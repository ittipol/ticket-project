var env = require('./env');

var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);
var db = require('./db');

// var handle = [];
var clients = [];

const MESSAGE_TAKE = 20;

io.on('connection', function(socket){

  socket.on('join', function(chanel,type){
    socket.join(chanel);
    console.log('chanel joined: '+chanel);
  });

  socket.on('leave', function(chanel,type){
    socket.leave(chanel); 
  });
  
  socket.on('online', function(data){

    // if(handle[data.userId] !== undefined) {
    //   clearTimeout(handle[data.userId]);
    // }

    socket.userId = data.userId;

    if(clients.indexOf(data.userId) === -1){
      clients.push(data.userId);
      io.in('check-online').emit('check-user-online', {
        user: data.userId,
        online: true
      });
    }

    // -------------------------------------------------------
    // console.log('user: ' + data.userId + ' has come online');   

    // db.query("SELECT `online` FROM `users` WHERE `id` = "+data.userId, function(err, rows){
    //   if(!rows[0].online) {
    //     db.query("UPDATE `users` SET `online` = '1' WHERE `users`.`id` = "+data.userId);
    //   }
    // });
    
  });

  socket.on('disconnect', function() {

    if(socket.userId === undefined) {
      return false;
    }

    let index = clients.indexOf(socket.userId);

    if(index !== -1){
      clients.splice(index, 1);
      io.in('u_'+socket.userId).emit('offline', {});
      io.in('check-online').emit('check-user-online', {
        user: socket.userId,
        online: false
      });
    }

    // -------------------------------------------------------
    // console.log('User: ' + socket.userId + ' disconnected.');

    // handle[socket.userId] = setTimeout(function(){
    //   db.query("UPDATE `users` SET `online` = '0' WHERE `users`.`id` = "+socket.userId+";");
    //   console.log('clear!!! ' + socket.userId);
    // },5000);

  });

  socket.on('check-user-online', function(data) {

    let index = clients.indexOf(data.userId);

    if(index !== -1){
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
  socket.on('chat-join', function(room){
  	socket.join('chat_'+room.key); 
  	// io.in(key).emit('user joined', [username]);
  });

  socket.on('chat-leave', function(room){
  	socket.leave('chat_'+room.key); 
  });

  socket.on('typing', function(data){

    let res = {
      user: data.user
    }

    io.in('chat_'+data.key).emit('typing', res);
  });

  socket.on('chat-message', function(data){

    if((!data.room) || (!data.user) || (!data.key)) {
      return false;
    }

  	// save message
  	db.query("INSERT INTO `chat_messages` (`id`, `chat_room_id`, `user_id`, `message`, `created_at`) VALUES (NULL, '"+data.room+"', '"+data.user+"', '"+data.message.trim()+"', CURRENT_TIMESTAMP);");

  	// SAVE To Notification table
  	// AND Fetch
  	// fetch every 30 sec by fetct in chuck (50 record per 10 sec)

  	console.log('message saved');

  	let res = {
  		user: data.user,
  		message: data.message
  	}

    io.in('chat_'+data.key).emit('chat-message', res);
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

});

server.listen(env.SOCKET_PORT, env.SOCKET_HOST, () => {
  console.log('App listening on port -> '+env.SOCKET_PORT)
});