class User {

	constructor(user){
		this.user = user;
		this.io;
	}

	init() {

		let _this = this;
		this.io = new IO();

		this.online();
		this.offline();

		this.join();
	}

	join() {
		this.io.join('u_'+this.user);
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

}