class User {

	constructor(user){
		this.user = user;
		this.io;
	}

	init() {

		this.io = new IO();

		this.join();

		this.online();
		this.countMessageNotication();
		this.messageNoticationList();

		this.socketEvent();
	}

	socketEvent() {

		let _this = this;
		
		this.io.socket.on('offline', function(res){
			_this.online();
		});
		
		this.io.socket.on('count-message-notification', function(res){
			$('#message_notification_count').text(res.count);
			$('#message_notification').removeClass('on');
			if(res.count > 0) {
				$('#message_notification').addClass('on');
			}
		});

		this.io.socket.on('display-new-message', function(res){
			const snackbar = new Snackbar();
			snackbar.setTitle('<span class="avatar"><img src="/avatar/'+res.user+'?d=1"></span><span class="w-50 ml-2"><div><small>ข้อความใหม่</small></div><div>'+res.message+'</div></span><a href="/chat/r/'+res.room+'" class="action">แชท</a>');
			snackbar.display();
		});

		this.io.socket.on('message-notification-list', function(res){
			
			// loop data and patch message notification
			// patchMessageNotification
console.log('message notification list update');
			for (var i = 0; i < res.length; i++) {
				console.log(res[i])
				$('#message_notification_list').append(_this.messageNotificationListHtml(res[i]));
			}

		})

	}

	join() {
		this.io.join('u_'+this.user);
	}

	online() {
		this.io.socket.emit('online', {userId: this.user});
	}

	countMessageNotication() {
		this.io.socket.emit('count-message-notification', {
			user: this.user
		});
	}

	messageNoticationList() {
		this.io.socket.emit('message-notification-list', {
			user: this.user
		});
	}

	messageNotificationListHtml(data) {

		// return `
		// 	<a href="/chat/r/${data.room}" id="" class="message-notification-list-item clearfix">
		// 	  <div class="message-notification-icon fl">
		// 	    <img class="avatar" src="/avatar/${data.user}?d=1">
		// 	  </div>
		// 	  <div class="message-notification-content fl">
		// 	    <div><small><strong>${data.name}</strong></small></div>
		// 	    <div>${data.message}</div>
		// 	  </div>
		// 	</a>
  //   `;

  			if(data.isSender) {
  				var senderLable = 'คุณได้ส่งข้อความถึง '+data.name;
  			}else{
  				var senderLable = data.name+' ได้ส่งข้อความถึงคุณ';
  			}

  			return `
  				<a href="/chat/r/${data.room}" id="" class="message-notification-list-item">
  				  <div class="message-notification-icon">
  				    <img class="avatar" src="/avatar/${data.user}?d=1">
  				  </div>
  				  <div class="message-notification-content">
  				    <div><i class="fa fa-comment" aria-hidden="true"></i>&nbsp;${data.message}</div>
  				    <div class="bb b--moon-gray pb-2"><small>${senderLable}</small></div>
  				  	<div><small>${data.ticket}</small></div>
  				  </div>
  				</a>
  	    `;

    // return html;
	}

}