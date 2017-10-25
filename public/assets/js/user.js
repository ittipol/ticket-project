class User {

	constructor(user){
		this.user = user;
		this.io;
		this.newMessage = false;
	}

	init() {

		this.io = new IO();

		this.join();

		this.online();
		this.countMessageNotication();
		this.messageNoticationList();

		this.bind();
		this.socketEvent();
	}

	bind() {

		let _this = this;

		$('#message_notification').on('click',function(){
			if(_this.newMessage) {
				_this.newMessage = false;

				$('#message_notification_count').text(0);
				$('#message_notification').removeClass('on');

				_this.setAllMessageRead();
			}
		});

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
				_this.newMessage = true;
				$('#message_notification').addClass('on');
			}
		});

		this.io.socket.on('display-new-message', function(res){
			const snackbar = new Snackbar();
			snackbar.setTitle('<span class="avatar"><img src="/avatar/'+res.user+'?d=1"></span><span class="w-50 ml-2"><div><small>ข้อความใหม่</small></div><div>'+res.message+'</div></span><a href="/chat/r/'+res.room+'" class="action">แชท</a>');
			snackbar.display();
		});

		this.io.socket.on('message-notification-list', function(res){
			for (var i = 0; i < res.length; i++) {
				if($('#message_'+res[i].room).length) {
					$('#message_'+res[i].room).remove();
				}

				$('#message_notification_list').append(_this.messageNotificationListHtml(res[i]));
			}
		})

		this.io.socket.on('message-notification', function(res){
			if($('#message_'+res.room).length) {
				$('#message_'+res.room).remove();
			}
			// create new and place to top of list
			$('#message_notification_list').prepend(_this.messageNotificationListHtml(res));
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

		if(data.isSender) {
			var senderLable = 'คุณได้ส่งข้อความถึง '+data.name+' ('+data.date+')';
		}else{
			var senderLable = data.name+' ได้ส่งข้อความถึงคุณ'+' ('+data.date+')';
		}
console.log(data.closing_option);
		let ticket = '';
		if(data.closing_option != 0) {
			ticket = '[ผู้ขายปิดประกาศนี้แล้ว] '+data.ticket;
		}else {
			ticket = data.ticket;
		}

		return `
			<a href="/chat/r/${data.room}" id="message_${data.room}" class="message-notification-list-item">
			  <div class="message-notification-icon">
			    <img class="avatar" src="/avatar/${data.user}?d=1">
			  </div>
			  <div class="message-notification-content">
			    <div><i class="fa fa-comment" aria-hidden="true"></i>&nbsp;${data.message}</div>
			    <div class="bb b--moon-gray pb-2"><small>${senderLable}</small></div>
			  	<div><small>${ticket}</small></div>
			  </div>
			</a>
    `;

    // return html;
	}

	setAllMessageRead() {
		this.io.socket.emit('set-all-message-read', {
			user: this.user
		});
	}

}