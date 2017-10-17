var env = require('./env');

var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);
var db = require('./db');

var userHandle = [];
var clients = [];

var notifyMessageHandle = [];

const MESSAGE_TAKE = 20;

function userOnline(userId) {
  if(clients.indexOf(userId) !== -1){
    return true;
  }
  return false;
}

function updateUserReadMessage(roomId,userId) {
  db.query("SELECT `id` FROM `chat_messages` WHERE `chat_room_id` = "+roomId+" ORDER BY created_at DESC LIMIT 1", function(err, messages){
    if(messages.length === 1) {
      db.query("UPDATE `user_in_chat_room` SET `notify` = 0, `message_read` = "+messages[0].id+", `message_read_date` = CURRENT_TIME() WHERE `chat_room_id`= "+roomId+" AND `user_id`= "+userId); 
    }
  });
}

// Notify message to users
function notifyMessage(roomId,userId) {
  
  // GET Last Message
  db.query("SELECT `id`, `message` FROM `chat_messages` WHERE `chat_room_id` = "+roomId+" ORDER BY created_at DESC LIMIT 1", function(err, messages){
    if(messages.length === 1) {
      // Get Users in room
      db.query("SELECT `user_id` FROM `user_in_chat_room` WHERE `user_id` != "+userId+" AND `chat_room_id` = "+roomId+" AND `notify` = 0 AND `message_read` < "+messages[0].id, function(err, rows){
        for (var i = 0; i < rows.length; i++) {
          //
          if(rows[i].user_id != userId) {
            // Update notify = 1
            db.query("UPDATE `user_in_chat_room` SET `notify` = 1, `message_read_date` = CURRENT_TIME() WHERE `chat_room_id`= "+roomId+" AND `user_id`= "+rows[i].user_id);
           
            countMessageNotication(rows[i].user_id);
            displayNewMessage(roomId, rows[i].user_id, messages[0].message);
          }
        }
      });
    }
  });

}

function displayNewMessage(roomId,userId,message) {
  console.log('display notification');
  io.in('u_'+userId).emit('display-new-message', {
    message: message,
    room: roomId,
    user: userId
  });
}

function countMessageNotication(userId) {
  db.query("SELECT `chat_room_id` FROM `user_in_chat_room` WHERE `user_id` = "+userId+" AND `notify` = 1", function(err, rows){
    io.in('u_'+userId).emit('count-message-notification', {
      count: rows.length
    });
  });
}

function messageNoticationList(userId) {

  db.query("SELECT `chat_room_id` FROM `user_in_chat_room` WHERE `user_id` = "+userId+" ORDER BY message_read_date DESC LIMIT 15", function(err, rows){
    
    let data = [];
    let count = 0;

    for (var i = 0; i < rows.length; i++) {

      let _room = rows[i].chat_room_id;
      // let _i = i+1;

      db.query("SELECT cm.message, cm.user_id, u.name, t.title FROM `chat_messages` AS cm LEFT JOIN `users` as u ON cm.user_id = u.id LEFT JOIN `ticket_chat_rooms` AS tcr ON cm.chat_room_id = tcr.chat_room_id LEFT JOIN `tickets` AS t ON tcr.ticket_id = t.id WHERE cm.chat_room_id = "+rows[i].chat_room_id+" ORDER BY cm.created_at DESC LIMIT 1", function(err, messages){

        if(messages.length == 1) {

          let isSender = false;
          if(messages[0].user_id == userId) {
            isSender = true;
          }

          data.push({
            message: messages[0].message,
            name: messages[0].name,
            ticket: messages[0].title,
            room: _room,
            user: messages[0].user_id,
            isSender: isSender
          });

          if(++count === rows.length) {
            console.log('emit!!!');
            io.in('u_'+userId).emit('message-notification-list', data);
          }
        }

      })
    }
  });
}

io.on('connection', function(socket){

  socket.on('join', function(chanel,type){
    socket.join(chanel);
    console.log('chanel joined: '+chanel);
  });

  socket.on('leave', function(chanel,type){
    socket.leave(chanel); 
  });
  
  socket.on('online', function(data){

    if(userHandle[data.userId] !== undefined) {
      clearTimeout(userHandle[data.userId]);
    }

    socket.userId = data.userId;

    if(clients.indexOf(data.userId) === -1){
      // Push to clients
      clients.push(data.userId);
      // Emit to client
      io.in('check-online').emit('check-user-online', {
        user: data.userId,
        online: true
      });
      // Update user is online to database
      db.query("UPDATE `users` SET `online` = '1' WHERE `users`.`id` = "+data.userId);
    }
    
  });

  socket.on('disconnect', function() {

    if(socket.userId === undefined) {
      return false;
    }

    userHandle[socket.userId] = setTimeout(function(){

      if(userOnline(socket.userId)){
        // Clear
        clients.splice(clients.indexOf(socket.userId), 1);

        // Emit
        io.in('u_'+socket.userId).emit('offline', {});
        // Check if other page is open
        io.in('check-online').emit('check-user-online', {
          user: socket.userId,
          online: false
        });

        // Update
        db.query("UPDATE `users` SET `online` = '0' WHERE `users`.`id` = "+socket.userId+";");
      }
    },3000);

  });

  socket.on('check-user-online', function(data) {
    
    if(userOnline(data.userId)) {
      io.in('check-online').emit('check-user-online', {
        user: data.userId,
        online: true
      });
    }else{
      io.in('check-online').emit('check-user-online', {
        user: data.userId,
        online: false
      });
    }

  });



  // ||||||||||||||||||||||| CHAT |||||||||||||||||||||||
  socket.on('chat-join', function(data){
  	socket.join('cr_'+data.room+'.'+data.key); 
  });

  socket.on('chat-leave', function(data){
  	socket.leave('cr_'+data.room+'.'+data.key); 
  });

  socket.on('typing', function(data){
    io.in('chat_'+data.key).emit('typing', {
      user: data.user
    });
  });

  socket.on('send-message', function(data){

    if((!data.room) || (!data.user) || (!data.key)) {
      return false;
    }

    clearTimeout(notifyMessageHandle[data.room]);

  	// save message
  	db.query("INSERT INTO `chat_messages` (`id`, `chat_room_id`, `user_id`, `message`, `created_at`) VALUES (NULL, '"+data.room+"', '"+data.user+"', '"+data.message.trim()+"', CURRENT_TIMESTAMP);");

    io.in('cr_'+data.room+'.'+data.key).emit('chat-message', {
      user: data.user,
      message: data.message
    });

    notifyMessageHandle[data.room] = setTimeout(function(){
      notifyMessage(data.room,data.user);
    },3500);

  });

  socket.on('chat-load-more', function(data){
    let skip = (MESSAGE_TAKE * data.page) - MESSAGE_TAKE;

    db.query("SELECT message, user_id, created_at FROM `chat_messages` WHERE `chat_room_id` = "+data.room+" AND `created_at` < '"+data.time+"' ORDER BY `created_at` DESC LIMIT "+skip+","+MESSAGE_TAKE, function(err, rows){
      
      let res = {
        next: false
      };

      if(rows.length !== 0) {
        res = {
          data: rows,
          page: data.page + 1,
          next: true
        };
      }

      io.in(data.chanel).emit('chat-load-more', res);
    });

  });

  socket.on('message-read', function(data){
    updateUserReadMessage(data.room,data.user);
  })

  socket.on('count-message-notification', function(data){
    countMessageNotication(data.user);
  })

  socket.on('message-notification-list', function(data){
    messageNoticationList(data.user);
  })

  // setInterval(function(){
  //   console.log('fetch');

  //   // FETCH Notifications

  //   if(true) {
  //     io.emit('send-notification', {});
  //     // io.in(data.chanel).emit('send-notification', res);
  //   }
  // },30000);

});

server.listen(env.SOCKET_PORT, env.SOCKET_HOST, () => {
  console.log('App listening on port -> '+env.SOCKET_PORT)
});