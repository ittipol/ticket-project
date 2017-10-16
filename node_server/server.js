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

function updateMessageRead(roomId,userId) {
  db.query("SELECT `id` FROM `chat_messages` WHERE `chat_room_id` = "+roomId+" ORDER BY created_at DESC LIMIT 1", function(err, rows){
    if(rows.length === 1) {
      db.query("UPDATE `user_in_chat_room` SET `notify` = 0, `message_read` = "+rows[0].id+" WHERE `chat_room_id`= "+roomId+" AND `user_id`= "+userId);
      console.log('message read -> '+rows[0].id);
    }
  });
}

function notifyMessage(roomId,userId) {
  
  db.query("SELECT `id`, `message` FROM `chat_messages` WHERE `chat_room_id` = "+roomId+" ORDER BY created_at DESC LIMIT 1", function(err, rows){
    if(rows.length === 1) {
      db.query("SELECT `user_id` FROM `user_in_chat_room` WHERE `user_id` != "+userId+" AND `chat_room_id` = "+roomId+" AND `notify` = 0 AND `message_read` < "+rows[0].id, function(err, _rows){
        if(_rows.length > 0) {
          for (var i = 0; i < _rows.length; i++) {
            if(_rows[i].user_id != userId) {

              db.query("UPDATE `user_in_chat_room` SET `notify` = 1 WHERE `chat_room_id`= "+roomId+" AND `user_id`= "+_rows[i].user_id);

              io.in('u_'+_rows[i].user_id).emit('notify-message', {
                id: rows[0].id,
                message: rows[0].message,
                user: _rows[i].user_id
              });
            }
          }
        }

      });
    }
  });

  // db.query("SELECT `user_id` FROM `user_in_chat_room` WHERE `chat_room_id` = 1 AND `notify` = 0 AND `message_read` != 1");

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
    },6000);

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

  socket.on('message-received', function(data){
    updateMessageRead(data.room,data.user);
  })

  setInterval(function(){
    console.log('fetch');

    // FETCH Notifications

    if(true) {
      io.emit('send-notification', {});
      // io.in(data.chanel).emit('send-notification', res);
    }
  },30000);

});

server.listen(env.SOCKET_PORT, env.SOCKET_HOST, () => {
  console.log('App listening on port -> '+env.SOCKET_PORT)
});