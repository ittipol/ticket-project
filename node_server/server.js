console.log('##########################################');
var env = require('./env');
var _const = require('./const');
var stringHelper = require('./func/string_helper');
var dateTime = require('./func/date_time');
var token = require('./func/token');
var striptags = require('striptags');
//
var db = require('./db');
var fs = require('fs');
var app = require('express')();
// Server
if(env.SSL) {
  var server = require('https').Server({
    key: fs.readFileSync(env.SSL_KEY),
    cert: fs.readFileSync(env.SSL_CERT),
  },app);
  console.log('SSL -> true');
}else{
  var server = require('http').Server(app);
  console.log('SSL -> false');
}
// socket.io
var io = require('socket.io')(server);
// redis
var redis = require('redis');
var redisClient = redis.createClient();

var Promise = require('bluebird');
Promise.promisifyAll(redis);

// Var
var userHandle = [];
var notifyMessageHandle = [];

function addUserOnline(userId) {
  redisClient.set('user-online:'+userId, 1);
  // expire at 1 hrs = 3600 secs
  // redisClient.expireat('user-online:'+userId, 3600);
}

function clearUserOnline(userId) {
  redisClient.del('user-online:'+userId);
}

// Update read all message
function setAllMessageRead(userId) {
  // update notify = 1
  db.query("UPDATE `user_in_chat_room` SET `notify` = 0 WHERE `user_id` = "+userId);
}

// Update specifically message
function updateUserReadMessage(roomId,userId) {
  db.query("SELECT `id` FROM `chat_messages` WHERE `chat_room_id` = "+roomId+" ORDER BY created_at DESC LIMIT 1", function(err, messages){
    if(messages.length === 1) {
      db.query("UPDATE `user_in_chat_room` SET `notify` = 0, `message_read_date` = '"+dateTime.now(true)+"' WHERE `chat_room_id`= "+roomId+" AND `user_id`= "+userId); 
    }
  });
}

// Notify message to users
function notifyMessage(roomId,userId) {
  // GET Last Message
  db.query("SELECT `message`, `created_at` FROM `chat_messages` WHERE `chat_room_id` = "+roomId+" ORDER BY created_at DESC LIMIT 1", function(err, messages){
    
    if(messages.length === 1) {

      // Get Users in room
      // db.query("SELECT `user_id` FROM `user_in_chat_room` WHERE `user_id` != "+userId+" AND `chat_room_id` = "+roomId+" AND `notify` = 0 AND `message_read` < "+messages[0].id, function(err, rows){
        db.query("SELECT `user_id` FROM `user_in_chat_room` WHERE `user_id` != "+userId+" AND `chat_room_id` = "+roomId+" AND `notify` = 0 AND `message_read_date` <= '"+messages[0].created_at+"'", function(err, rows){
        //

        for (var i = 0; i < rows.length; i++) {

          console.log('message notofy '+rows[i].user_id);

          if(rows[i].user_id != userId) {

            let _userid = rows[i].user_id;

            // Update notify = 1
            db.query("UPDATE `user_in_chat_room` SET `notify` = 1, `message_read_date` = '"+messages[0].created_at+"' WHERE `chat_room_id`= "+roomId+" AND `user_id`= "+_userid);

            // if(checkUserOnline(_userid)) {
            //   countMessageNotication(_userid);
            //   messageNotication(roomId, _userid);
            //   displayNewMessage(roomId, _userid, messages[0].message);
            // }

            // Notify to online user
            redisClient.getAsync('user-online:'+_userid).then(function(res){

              if(res === null) {
                return false;
              }

              countMessageNotication(_userid);
              messageNotication(roomId, _userid);
              displayNewMessage(roomId, _userid, messages[0].message);

            });

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
  db.query("SELECT cm.message, cm.user_id, u.name, t.title, t.closing_option, cm.created_at FROM `chat_messages` AS cm LEFT JOIN `users` as u ON cm.user_id = u.id LEFT JOIN `ticket_chat_rooms` AS tcr ON cm.chat_room_id = tcr.chat_room_id LEFT JOIN `tickets` AS t ON tcr.ticket_id = t.id WHERE cm.chat_room_id = "+roomId+" ORDER BY cm.created_at DESC LIMIT 1", function(err, messages){
  
    if(messages.length == 1) {

      let isSender = false;
      if(messages[0].user_id == userId) {
        isSender = true;
      }

      io.in('u_'+userId).emit('message-notification', {
        room: roomId,
        user: messages[0].user_id,
        message: messages[0].message,
        name: messages[0].name,
        ticket: messages[0].title,
        closing_option: messages[0].closing_option,
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

      db.query("SELECT cm.message, cm.user_id, u.name, t.title, t.closing_option, cm.created_at FROM `chat_messages` AS cm LEFT JOIN `users` as u ON cm.user_id = u.id LEFT JOIN `ticket_chat_rooms` AS tcr ON cm.chat_room_id = tcr.chat_room_id LEFT JOIN `tickets` AS t ON tcr.ticket_id = t.id WHERE cm.chat_room_id = "+rows[i].chat_room_id+" ORDER BY cm.created_at DESC LIMIT 1", function(err, messages){
        
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
            ticket: stringHelper.truncString(messages[0].title,50),
            closing_option: messages[0].closing_option,
            isSender: isSender,
            date: dateTime.passingDate(messages[0].created_at,_now)
          });

        }

        if((++count === rows.length) && (data.length > 0)) {
          io.in('u_'+userId).emit('message-notification-list', data);
        }

      });
    }
  });
}

io.on('connection', function(socket){

  socket.on('join', function(chanel,type){
    socket.join(chanel);
    // console.log('chanel joined: '+chanel);
  });

  socket.on('leave', function(chanel,type){
    socket.leave(chanel); 
  });
  
  socket.on('online', function(data){

    db.query("UPDATE `users` SET `last_active` = '"+dateTime.now(true)+"' WHERE `id` = "+data.userId);

    if(userHandle[data.userId] !== undefined) {
      clearTimeout(userHandle[data.userId]);
    }
    //
    socket.userId = data.userId;

    redisClient.getAsync('user-online:'+data.userId).then(function(res){

      if(res !== null) {
        return false;
      }

      console.log('Online user# '+data.userId);
      addUserOnline(data.userId);
      
      io.in('check-online').emit('check-user-online', {
        user: data.userId,
        online: true
      });

    });

    // if(!checkUserOnline(data.userId)) {
    //   // set user online
    //   console.log('add user...');
    //   addUserOnline(data.userId);
    //   // Emit to client
    //   io.in('check-online').emit('check-user-online', {
    //     user: data.userId,
    //     online: true
    //   });
    //   // Update online = 1
    //   // db.query("UPDATE `users` SET `online` = '1' WHERE `id` = "+data.userId);
    // }
    
  });

  socket.on('disconnect', function() {

    if(socket.userId === undefined) {
      return false;
    }

    userHandle[socket.userId] = setTimeout(function(){

      redisClient.getAsync('user-online:'+socket.userId).then(function(res){

        if(res === null) {
          return false;
        }
        console.log('Disconnect user# '+socket.userId);
        // Clear
        clearUserOnline(socket.userId);
        // 
        io.in('u_'+socket.userId).emit('offline', {});
        // Check if other page is opening
        io.in('check-online').emit('check-user-online', {
          user: socket.userId,
          online: false
        });

      });

      // if(checkUserOnline(socket.userId)){
      //   // Clear user online 
      //   clearUserOnline(socket.userId);
      //   // Emit
      //   io.in('u_'+socket.userId).emit('offline', {});
      //   // Check if other page is open
      //   io.in('check-online').emit('check-user-online', {
      //     user: socket.userId,
      //     online: false
      //   });
      //   // Update online = 0
      //   // db.query("UPDATE `users` SET `online` = '0' WHERE `id` = "+socket.userId);
      // }
    },3000);

  });

  socket.on('check-user-online', function(data) {

    redisClient.getAsync('user-online:'+data.userId).then(function(res){

      if(res === null) {
        io.in('check-online').emit('check-user-online', {
          user: data.userId,
          online: false
        });
      }else {
        io.in('check-online').emit('check-user-online', {
          user: data.userId,
          online: true
        });
      }

    });
    
    // if(checkUserOnline(data.userId)) {
    //   io.in('check-online').emit('check-user-online', {
    //     user: data.userId,
    //     online: true
    //   });
    // }else{
    //   io.in('check-online').emit('check-user-online', {
    //     user: data.userId,
    //     online: false
    //   });
    // }

  });

  // check user is online every 5 mins
  setInterval(function(){
    db.query("SELECT `id` FROM `users` WHERE (`last_active` >= '"+dateTime.now(true,2760000)+"' AND `last_active` <= '"+dateTime.now(true,1800000)+"') ORDER BY last_active ASC LIMIT 100", function(err, rows){
      for (var i = 0; i < rows.length; i++) {
        // temp
        let _userid = rows[i].id;

        redisClient.getAsync('user-online:'+_userid).then(function(_res){

          if(_res === null) {
            return false;
          }

          console.log('clear user...');
          console.log(_userid);
          // Clear
          clearUserOnline(_userid);
          // Emit
          // io.in('u_'+_userid).emit('offline', {});

          io.in('check-online').emit('check-user-online', {
            user: _userid,
            online: false
          });

          // db.query("UPDATE `users` SET `online` = '0' WHERE `id` = "+_userid);
        });
      }
    });
  },300000);


  socket.on('get-location', function(data){
    
    let _this = this;

    let sql = '';
    if(data['parentId'] === null) {
      sql = 'SELECT * FROM `locations` WHERE `parent_id` IS NULL';
    }else if(data['parentId']) {
      sql = 'SELECT * FROM `locations` WHERE `parent_id` = '+data['parentId'];
    }else {
      return false;    
    }

    let count = 0;
    let locations = [];

    db.query(sql, function(err, rows){

      for (var i = 0; i < rows.length; i++) {

        let _rows = rows[i];
      
        db.query('SELECT COUNT(id) AS total FROM `locations` WHERE `parent_id` = '+rows[i]['id'], function(err, row){
          
          let next = true;
          if(row[0]['total'] === 0) {
            next = false;
          }

          locations.push({
            id: _rows['id'],
            name: _rows['name'],
            hasChild: next,
          });

          if(++count === rows.length) {
            io.in(data.chanel).emit('get-location', {
              data: locations
            });
          }

        })

      }
      
    })

  })



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

    if(!data.room || !data.user || !data.key) {
      io.in(data.chanel).emit('chat-error', {
        error: true,
        message: 'มีบางอย่างผิดพลาด ไม่สามารถแชทได้'
      });
      return false;
    }

    redisClient.getAsync('user-online:'+data.user).then(function(res){

      if(res === null) {
        io.in(data.chanel).emit('chat-error', {
          error: true,
          message: 'มีบางอย่างผิดพลาด ไม่สามารถแชทได้'
        });
        return false;
      }

      clearTimeout(notifyMessageHandle[data.room]);

      let message = striptags(data.message.trim());
      //
      db.query("INSERT INTO `chat_messages` (`id`, `chat_room_id`, `user_id`, `message`, `created_at`) VALUES (NULL, '"+data.room+"', '"+data.user+"', "+db.escape(message)+", '"+dateTime.now(true)+"');");

      io.in('cr_'+data.room+'.'+data.key).emit('chat-message', {
        user: data.user,
        message: message
      });

      notifyMessageHandle[data.room] = setTimeout(function(){
        notifyMessage(data.room,data.user);
      },3500);

    });

  });

  socket.on('chat-load-more', function(data){
    let skip = (_const.MESSAGE_TAKE * data.page) - _const.MESSAGE_TAKE;

    db.query("SELECT message, user_id, created_at FROM `chat_messages` WHERE `chat_room_id` = "+data.room+" AND `created_at` < '"+data.time+"' ORDER BY `created_at` DESC LIMIT "+skip+","+_const.MESSAGE_TAKE, function(err, rows){
      
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
            chatRoomSend({
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

  socket.on('message-read', function(data){
    updateUserReadMessage(data.room,data.user);
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

  let _now = dateTime.now(true);

  db.query('INSERT INTO `chat_rooms` (`id`, `room_key`, `created_at`, `updated_at`) VALUES (NULL, "'+token.generateToken(16)+'", "'+_now+'", "'+_now+'")', function(err, res){
    
    if(!err) {

      let readDate = dateTime.now(true);

      db.query('INSERT INTO `ticket_chat_rooms` (`id`, `chat_room_id`, `ticket_id`, `created_at`) VALUES (NULL, '+res.insertId+', '+data.ticket+', "'+_now+'")');
      db.query('INSERT INTO `user_in_chat_room` (`chat_room_id`, `user_id`, `role`, `notify`, `message_read_date`) VALUES ('+res.insertId+', '+onwer+', "s", 0, "'+readDate+'")');
      db.query('INSERT INTO `user_in_chat_room` (`chat_room_id`, `user_id`, `role`, `notify`, `message_read_date`) VALUES ('+res.insertId+', '+data.user+', "b", 0, "'+readDate+'")');
      // send message
      chatRoomSend({
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

function chatRoomSend(data) {

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

      db.query("INSERT INTO `chat_messages` (`id`, `chat_room_id`, `user_id`, `message`, `created_at`) VALUES (NULL, '"+data.room+"', '"+data.user+"', '"+data.message.trim()+"', '"+dateTime.now(true)+"')", function(err, res){
        
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

server.listen(env.SOCKET_PORT, () => {
  console.log('App listening on port -> '+env.SOCKET_PORT)
});