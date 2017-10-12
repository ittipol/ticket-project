class User {

	constructor(user){
		this.user = user;
		this.io;
	}

	init() {

		let _this = this;
		this.io = new IO();

		this.online();

		setInterval(function(){
			_this.online();
		},10000);
	}

	online() {
		this.io.socket.emit('online', {userId: this.user});
	}

}