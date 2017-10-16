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
		})
	}

	messageNoticationNotify() {
		
	}

}