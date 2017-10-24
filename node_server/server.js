var env = require('./env');
var constVar = require('./const');
var dateTime = require('./func/date_time');
var token = require('./func/token');
//
var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);
var db = require('./db');
// 
var userHandle = [];
var clients = [];
var notifyMessageHandle = [];

function userOnline(userId) {
  if(clients.indexOf(userId) !== -1){
    return true;
  }
  return false;
}

// Update read all message
function setAllMessageRead(userId) {
  // update notify = 1
  db.query("UPDATE `user_in_chat_room` SET `notify` = 0 WHERE `user_id` = "+userId);
}

// Update specifically message
// function updateUserReadMessage(roomId,userId) {
//   db.query("SELECT `id` FROM `chat_messages` WHERE `chat_room_id` = "+roomId+" ORDER BY created_at DESC LIMIT 1", function(err, messages){
//     if(messages.length === 1) {
//       db.query("UPDATE `user_in_chat_room` SET `notify` = 0, `message_read` = "+messages[0].id+", `message_read_date` = CURRENT_TIME() WHERE `chat_room_id`= "+roomId+" AND `user_id`= "+userId); 
//     }
//   });
// }

// Notify message to users
function notifyMessage(roomId,userId) {
  // GET Last Message
  db.query("SELECT `id`, `message` FROM `chat_messages` WHERE `chat_room_id` = "+roomId+" ORDER BY created_at DESC LIMIT 1", function(err, messages){
    if(messages.length === 1) {
      // Get Users in room
      db.query("SELECT `user_id` FROM `user_in_chat_room` WHERE `user_id` != "+userId+" AND `chat_room_id` = "+roomId+" AND `notify` = 0 AND `message_read` < "+messages[0].id, function(err, rows){
        //
        for (var i = 0; i < rows.length; i++) {
          if(rows[i].user_id != userId) {
            // Update notify = 1
            db.query("UPDATE `user_in_chat_room` SET `notify` = 1, `message_read_date` = CURRENT_TIME() WHERE `chat_room_id`= "+roomId+" AND `user_id`= "+rows[i].user_id);
            // Notify if user online
            if(userOnline(rows[i].user_id)) {
              countMessageNotication(rows[i].user_id);
              messageNotication(roomId, rows[i].user_id)
              displayNewMessage(roomId, rows[i].user_id, messages[0].message);
            }
          }
        }
      });
    }
  });
}
// display notification with snackbar
function displayNewMessage(roomId,userId,message) {
  io.in('u_'+userId).emit('display-new-message', {
    message: message,
    room: roomId,
    user: userId
  });
}
// update message notification total in header
function countMessageNotication(userId) {
  db.query("SELECT `chat_room_id` FROM `user_in_chat_room` WHERE `user_id` = "+userId+" AND `notify` = 1", function(err, rows){
    io.in('u_'+userId).emit('count-message-notification', {
      count: rows.length
    });
  });
}

function messageNotication(roomId,userId) {
  db.query("SELECT cm.message, cm.user_id, u.name, t.title, cm.created_at FROM `chat_messages` AS cm LEFT JOIN `users` as u ON cm.user_id = u.id LEFT JOIN `ticket_chat_rooms` AS tcr ON cm.chat_room_id = tcr.chat_room_id LEFT JOIN `tickets` AS t ON tcr.ticket_id = t.id WHERE cm.chat_room_id = "+roomId+" ORDER BY cm.created_at DESC LIMIT 1", function(err, messages){
    console.log(messages.length);
    if(messages.length == 1) {

      let isSender = false;
      if(messages[0].user_id == userId) {
        isSender = true;
      }

      console.log('ssss message-notification!!!');
      io.in('u_'+userId).emit('message-notification', {
        room: roomId,
        user: messages[0].user_id,
        message: messages[0].message,
        name: messages[0].name,
        ticket: messages[0].title,
        isSender: isSender,
        date: dateTime.passingDate(messages[0].created_at,dateTime.now())
      });
      
    }
  });

}

// update notification message to panel
function messageNoticationList(userId) {

  db.query("SELECT `chat_room_id` FROM `user_in_chat_room` WHERE `user_id` = "+userId+" ORDER BY message_read_date DESC LIMIT 15", function(err, rows){
    
    let data = [];
    let count = 0;
    let _now = dateTime.now();

    for (var i = 0; i < rows.length; i++) {

      let _roomId = rows[i].chat_room_id;
      // let _i = i+1;

      db.query("SELECT cm.message, cm.user_id, u.name, t.title, cm.created_at FROM `chat_messages` AS cm LEFT JOIN `users` as u ON cm.user_id = u.id LEFT JOIN `ticket_chat_rooms` AS tcr ON cm.chat_room_id = tcr.chat_room_id LEFT JOIN `tickets` AS t ON tcr.ticket_id = t.id WHERE cm.chat_room_id = "+rows[i].chat_room_id+" ORDER BY cm.created_at DESC LIMIT 1", function(err, messages){
        if(messages.length == 1) {

          let isSender = false;
          if(messages[0].user_id == userId) {
            isSender = true;
          }

          data.push({
            room: _roomId,
            user: messages[0].user_id,
            message: messages[0].message,
            name: messages[0].name,
            ticket: messages[0].title,
            isSender: isSender,
            date: dateTime.passingDate(messages[0].created_at,_now)
          });

          if(++count === rows.length) {
            console.log('message-notification-list!!!');
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
    console.log('user active');
    db.query("UPDATE `users` SET `last_active` = CURRENT_TIME() WHERE `users`.`id` = "+data.userId);

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
      // db.query("UPDATE `users` SET `online` = '1' WHERE `users`.`id` = "+data.userId+";");
    }else{
      io.in('check-online').emit('check-user-online', {
        user: data.userId,
        online: false
      });
      // db.query("UPDATE `users` SET `online` = '0' WHERE `users`.`id` = "+data.userId+";");
    }

  });

  // check user is online every 2 mins
  setInterval(function(){
    
    db.query("SELECT `id` FROM `users` WHERE `online` = 1 AND `last_active` <= '"+dateTime.now(true,1800000)+"' ORDER BY last_active ASC LIMIT 100", function(err, rows){
      // if(rows.length > 0) {
        for (var i = 0; i < rows.length; i++) {
          if(userOnline(rows[i].id)) {
            // Clear
            clients.splice(clients.indexOf(rows[i].id), 1);
            // Emit
            // io.in('u_'+rows[i].id).emit('offline', {});
          }

          io.in('check-online').emit('check-user-online', {
            user: rows[i].id,
            online: false
          });
          db.query("UPDATE `users` SET `online` = '0' WHERE `users`.`id` = "+rows[i].id);
        }
      // }
    });

  },120000);


  // ||||||||||||||||||||||| CHAT |||||||||||||||||||||||
  socket.on('chat-join', function(data){
  	socket.join('cr_'+data.room+'.'+data.key); 
  });

  socket.on('chat-leave', function(data){
  	socket.leave('cr_'+data.room+'.'+data.key); 
  });

  socket.on('typing', function(data){
    io.in('cr_'+data.room+'.'+data.key).emit('typing', {
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

    // chatMessageSave({
    //   message: data.message,
    //   room: data.room,
    //   user: data.user,
    //   key: data.key
    // });

  });

  socket.on('chat-load-more', function(data){
    let skip = (constVar.MESSAGE_TAKE * data.page) - constVar.MESSAGE_TAKE;

    db.query("SELECT message, user_id, created_at FROM `chat_messages` WHERE `chat_room_id` = "+data.room+" AND `created_at` < '"+data.time+"' ORDER BY `created_at` DESC LIMIT "+skip+","+constVar.MESSAGE_TAKE, function(err, rows){
      
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

  socket.on('ticket-chat-room-message-send', function(data){

    db.query('SELECT `id`,`title`,`created_by` FROM `tickets` WHERE `id` = "'+data.ticket+'" AND `closing_option` = 0 LIMIT 1', function(err, rows){

      if((rows.length === 1) && (data.user != rows[0].created_at)) {
        
        db.query('SELECT ticket_chat_rooms.chat_room_id FROM `ticket_chat_rooms` LEFT JOIN user_in_chat_room ON user_in_chat_room.chat_room_id = ticket_chat_rooms.chat_room_id WHERE ticket_chat_rooms.ticket_id = '+data.ticket+' AND user_in_chat_room.user_id = '+data.user+' AND user_in_chat_room.role = "b" LIMIT 1',function(err, rooms){

          if(rooms.length == 1) {
            // send
            ticketChatRoomSend({
              message: data.message,
              room: rooms[0].chat_room_id,
              user: data.user,
              chanel: data.chanel
            });

          }else {
            // create room and send
            createRoom(rows[0].created_by,data);
          }

        });

      }else {
        io.in(data.chanel).emit('ticket-chat-room-after-sending', {
          error: true,
          errorMessage: 'ไม่พบรายการนี้'
        });
      }

    })

  })

  socket.on('count-message-notification', function(data){
    countMessageNotication(data.user);
  })

  socket.on('message-notification-list', function(data){
    messageNoticationList(data.user);
  })

  socket.on('set-all-message-read', function(data){
    setAllMessageRead(data.user);
  })  

});

function createRoom(onwer,data) {
  // create new room
  db.query('INSERT INTO `chat_rooms` (`id`, `room_key`, `created_at`, `updated_at`) VALUES (NULL, "'+token.generateToken(16)+'", CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)', function(err, res){
    
    if(!err) {
      db.query('INSERT INTO `ticket_chat_rooms` (`id`, `chat_room_id`, `ticket_id`, `created_at`) VALUES (NULL, '+res.insertId+', '+data.ticket+', CURRENT_TIMESTAMP)');
      db.query('INSERT INTO `user_in_chat_room` (`chat_room_id`, `user_id`, `role`, `notify`, `message_read`, `message_read_date`) VALUES ('+res.insertId+', '+onwer+', "s", 0, 0, NULL)');
      db.query('INSERT INTO `user_in_chat_room` (`chat_room_id`, `user_id`, `role`, `notify`, `message_read`, `message_read_date`) VALUES ('+res.insertId+', '+data.user+', "b", 0, 0, NULL)');
      // send message
      ticketChatRoomSend({
        message: data.message,
        room: res.insertId,
        user: data.user,
        chanel: data.chanel
      });

      return res.insertId;
    }else {
      return 0;
    }

  });
  
}

function ticketChatRoomSend(data) {

  if(data.room === 0) {
    io.in(data.chanel).emit('ticket-chat-room-after-sending', {
      error: true,
      errorMessage: 'ไม่สามารถส่งข้อความได้'
    });
  }else {
    db.query('SELECT `room_key` FROM `chat_rooms` WHERE `id` = '+data.room, function(err, rows){

      if(rows.length !== 1) {
        // send error message
        io.in(data.chanel).emit('ticket-chat-room-after-sending', {
          error: true,
          errorMessage: 'ไม่สามารถส่งข้อความได้'
        });
      }

      db.query("INSERT INTO `chat_messages` (`id`, `chat_room_id`, `user_id`, `message`, `created_at`) VALUES (NULL, '"+data.room+"', '"+data.user+"', '"+data.message.trim()+"', CURRENT_TIMESTAMP)", function(err, res){
        

        if(!err) {

          clearTimeout(notifyMessageHandle[data.room]);

          io.in('cr_'+data.room+'.'+data.key).emit('chat-message', {
            user: data.user,
            message: data.message
          });

          notifyMessageHandle[data.room] = setTimeout(function(){
            notifyMessage(data.room,data.user);
          },3500);

          io.in(data.chanel).emit('ticket-chat-room-after-sending', {
            error: false,
            room: data.room
          });

        }else{
          io.in(data.chanel).emit('ticket-chat-room-after-sending', {
            error: true,
            errorMessage: 'ไม่สามารถส่งข้อความได้'
          });
        }

      });

    });
  }

}

// function chatMessageSave(data) {
//   if((!data.room) || (!data.user) || (!data.key)) {
//     return false;
//   }
  
//   clearTimeout(notifyMessageHandle[data.room]);

//   // save message
//   db.query("INSERT INTO `chat_messages` (`id`, `chat_room_id`, `user_id`, `message`, `created_at`) VALUES (NULL, '"+data.room+"', '"+data.user+"', '"+data.message.trim()+"', CURRENT_TIMESTAMP)");

//   io.in('cr_'+data.room+'.'+data.key).emit('chat-message', {
//     user: data.user,
//     message: data.message
//   });

//   notifyMessageHandle[data.room] = setTimeout(function(){
//     notifyMessage(data.room,data.user);
//   },3500);

//   return true;
// }

server.listen(env.SOCKET_PORT, env.SOCKET_HOST, () => {
  console.log('App listening on port -> '+env.SOCKET_PORT)
});