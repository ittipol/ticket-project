class Chat {

	constructor(chat) {
		this.chat = chat;
		this.typingHandle = null;
		this.loading = false;
		this.io = null;
		this.messagePlaced = false;
	}

	init() {

		this.io = new IO();

		this.join();
	  this.bind();
	  this.more();	  

	  let _this = this;

	  setTimeout(function(){
	  	_this.toButtom();
	  },800)
	}

	join() {
		this.io.socket.emit('chat join', {
	    key: this.chat.key
	  });
	}

	bind() {

		let _this = this;

		$('#message_input').on('keyup',function(event){

			if(event.keyCode === 13) {
				return false;
			}

			_this.typing();

		});

		this.io.socket.on('typing', function(res){

			if(_this.chat.user == res.user) {
				return false;
			}

			$('.typing-indicator').css('display','block');
			
			clearTimeout(_this.typingHandle);
			_this.typingHandle = setTimeout(function(){
				$('.typing-indicator').css('display','none');
			},400);

		});

		$('#send_btn').on('click',function(){

	    if($('#message_input').val() !== '') {
	      _this.sending($('#message_input').val());
	      _this.toButtom();
	    }

	  });

	  $('#message_input').on('keypress',function(event){

	  	if((event.keyCode == 13) && ($('#message_input').val() !== '')) {
	  	  _this.sending($('#message_input').val());
	  	  _this.toButtom();
	  	}

	  });

		this.io.socket.on('chat-message', function(res){

			if(_this.messagePlaced) {
				_this.messagePlaced = false;
				return false;
			}

			if(_this.chat.user == res.user) {
				return false;
			}

	    _this.placeMessage(res,false);
	    _this.toButtom();

	  });

	  $(document).on('scroll',function(){

	  	if($(this).scrollTop() < 120) {
	  		_this.more();
	  	}

	  });

	  this.io.socket.on('chat-load-more', function(res){

	  	let me;

	  	for (var i = 0; i < res.length; i++) {

	  		me = false;

	  		if(_this.chat.user == res[i].user_id) {
	  			me = true;
	  		}

	  		$('#message_display').prepend(_this.getHtml(res[i], me));

	  	};

	  	setTimeout(function(){
	  		_this.loading = false;
	  	},1000);

	  });

	}

	toButtom() {
		if($('.chat-section').height() > window.innerHeight) {
			$(document).scrollTop(($('.chat-section').height() - window.innerHeight + 100))
		}
	}

	more() {

		if(this.loading) {;
			return false;
		}

		this.loading = true;

		this.io.socket.emit('chat-load-more', {
			chanel: this.chat.user+'.'+this.io.token,
			room: this.chat.room,
			page: this.chat.page,
			time: this.chat.time
		});
	}

	sending(message) {

		$('#message_input').val('');

		this.placeMessage({
			user: this.chat.user,
			message: message
		});

		this.messagePlaced = true;

		this.send(message);
	}

	send(message) {

		this.io.socket.emit('chat-message', {
		  message: message,
		  room: this.chat.room,
		  user: this.chat.user,
		  key: this.chat.key
		})
	}

	typing() {
		this.io.socket.emit('typing', {
			room: this.chat.room,
			user: this.chat.user,
			key: this.chat.key
		});
	}

	getHtml(data,me = true) {

		let html = '';

		if(me) {
			html = `
			<div class="message-section message-me">
			  <div class="avatar">
			    <img src="/avatar?d=1">
			  </div>
			  <div class="message-box">${data.message}</div>
			</div>
			`;
		}else{
			html = `
			<div class="message-section">
			  <div class="avatar">
			    <img src="/avatar?d=1">
			  </div>
			  <div class="message-box">${data.message}</div>
			</div>
			`;
		}

		return html;

	}

	placeMessage(data,me = true) {
		$('#message_display').append(this.getHtml(data,me));
	}

}