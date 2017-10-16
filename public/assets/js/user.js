class User {

	constructor(user){
		this.user = user;
		this.io;
	}

	init() {

		let _this = this;
		this.io = new IO();

		this.join();

		this.bindEvent();
	}

	join() {
		this.io.join('u_'+this.user);
	}

	bindEvent() {
		this.online();
		this.offline();
		this.notifyMessage();
	}

	online() {
		this.io.socket.emit('online', {userId: this.user});
	}

	offline() {
		let _this = this;

		this.io.socket.on('offline', function(res){
			_this.online();
		});
	}

	notifyMessage() {
		this.io.socket.on('notify-message', function(res){

			const snackbar = new Snackbar();
			snackbar.setTitle('ข้อความใหม่ "'+res.message+'"');
			snackbar.display();

		});
	}

}