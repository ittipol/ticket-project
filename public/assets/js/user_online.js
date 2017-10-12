class UserOnline {

	constructor(target){
		this.target = target;
		this.io;
	}

	init() {

		let _this = this;
		this.io = new IO();
		
		this.join();
		this.bind();

		this.check();

		setInterval(function(){
			_this.check();
		},10000);

	}

	bind() {

		this.io.socket.on('check-user-online', function(res){

			if(res.online) {
				$('#online_status_indicator').removeClass('is-offline').addClass('is-online');
			}else{
				$('#online_status_indicator').removeClass('is-online').addClass('is-offline');
			}

		});

	}

	join() {
		this.io.join('check_'+this.target);
	}

	check() {
		this.io.socket.emit('check-user-online', {userId: this.target});
	}

}