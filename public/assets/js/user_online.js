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

		// setInterval(function(){
		// 	_this.check();
		// },10000);

	}

	bind() {

		this.io.socket.on('check-user-online', function(res){

			// let el = $( "#myDiv" ).length
			let el = $("#online_status_indicator_"+res.user);

			if(el.length) {
				if(res.online) {
					el.removeClass('is-offline').addClass('is-online');
				}else{
					el.removeClass('is-online').addClass('is-offline');
				}				
			}

		});

	}

	join() {
		this.io.join('check-online');
	}

	check() {
		this.io.socket.emit('check-user-online', {userId: this.target});
	}

}