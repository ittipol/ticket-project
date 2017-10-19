var dateTime = require('./date_time');
var db = require('../db');
var io = require('socket.io')(server);

module.exports = class Message {

  constructor(){}

  // Update read all message
  static readAllMessage(userId) {
    // GET All user in rooms with notify = 1
    db.query("SELECT `chat_room_id` FROM `user_in_chat_room` WHERE `user_id` = "+userId+" AND `notify` = 1", function(err, rows){
      console.log(rows);
    });
  }

  // Update specifically message
  static updateUserReadMessage(roomId,userId) {
    db.query("SELECT `id` FROM `chat_messages` WHERE `chat_room_id` = "+roomId+" ORDER BY created_at DESC LIMIT 1", function(err, messages){
      if(messages.length === 1) {
        db.query("UPDATE `user_in_chat_room` SET `notify` = 0, `message_read` = "+messages[0].id+", `message_read_date` = CURRENT_TIME() WHERE `chat_room_id`= "+roomId+" AND `user_id`= "+userId); 
      }
    });
  }

  // Notify message to users
  static notifyMessage(roomId,userId) {
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
             
              if(userOnline(rows[i].user_id)) {
                this.countMessageNotication(rows[i].user_id);
                this.displayNewMessage(roomId, rows[i].user_id, messages[0].message);
              }
              
            }
          }
        });
      }
    });
  }
  // display notification with snackbar
  static displayNewMessage(roomId,userId,message) {
    console.log('display notification');
    io.in('u_'+userId).emit('display-new-message', {
      message: message,
      room: roomId,
      user: userId
    });
  }
  // update message notification total in header
  static countMessageNotication(userId) {
    db.query("SELECT `chat_room_id` FROM `user_in_chat_room` WHERE `user_id` = "+userId+" AND `notify` = 1", function(err, rows){
      io.in('u_'+userId).emit('count-message-notification', {
        count: rows.length
      });
    });
  }
  // update notification message to panel
  static messageNoticationList(userId) {

    db.query("SELECT `chat_room_id` FROM `user_in_chat_room` WHERE `user_id` = "+userId+" ORDER BY message_read_date DESC LIMIT 15", function(err, rows){
      
      let data = [];
      let count = 0;
      let _now = dateTime.now();

      for (var i = 0; i < rows.length; i++) {

        let _room = rows[i].chat_room_id;
        // let _i = i+1;

        db.query("SELECT cm.message, cm.user_id, u.name, t.title, cm.created_at FROM `chat_messages` AS cm LEFT JOIN `users` as u ON cm.user_id = u.id LEFT JOIN `ticket_chat_rooms` AS tcr ON cm.chat_room_id = tcr.chat_room_id LEFT JOIN `tickets` AS t ON tcr.ticket_id = t.id WHERE cm.chat_room_id = "+rows[i].chat_room_id+" ORDER BY cm.created_at DESC LIMIT 1", function(err, messages){

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
              isSender: isSender,
              date: dateTime.passingDate(messages[0].created_at,_now)
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

}