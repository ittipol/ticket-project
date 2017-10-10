class Chat {

	constructor(socket,chat) {
		this.chat = chat;
		this.socket = socket;
		this.typingHandle = null;
	}

	init() {
		this.join();
		// this.layoutInit();
	  this.bind();
	}

	join() {
		this.socket.emit('chat join', {
	    key: this.chat.key
	  });
	}

	// layoutInit() {
	// 	$('.chat-section').css('height',window.innerHeight-56+'px');
	// }

	bind() {

		let _this = this;

		$('#message_input').on('keyup',function(event){

			if(event.keyCode === 13) {
				return false;
			}

			_this.typing();

		});

		this.socket.on('typing', function(res){

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

		this.socket.on('chat message', function(res){

			if(_this.chat.user == res.user) {
				return false;
			}

	    _this.patchMessage(res,false);
	    _this.toButtom();
	  });

	}

	toButtom() {
		if($('.chat-section').height() > window.innerHeight) {
			$(document).scrollTop(($('.chat-section').height() - window.innerHeight + 100))
		}
	}

	sending(msg) {

		$('#message_input').val('');

		this.patchMessage({
			user: this.chat.user,
			msg: msg
		});

		this.send(msg);
	}

	send(msg) {
		this.socket.emit('chat message', {
		  room: this.chat.room,
		  user: this.chat.user,
		  msg: msg,
		  key: this.chat.key
		})
	}

	typing() {
		this.socket.emit('typing', {
			room: this.chat.room,
			user: this.chat.user,
			key: this.chat.key
		});
	}

	patchMessage(data,me = true) {

		let html = '';

		if(me) {
			html = `
			<div class="message-section message-me">
			  <div class="avatar">
			    <img src="/avatar?d=1">
			  </div>
			  <div class="message-box">${data.msg}</div>
			</div>
			`;
		}else{
			html = `
			<div class="message-section">
			  <div class="avatar">
			    <img src="/avatar?d=1">
			  </div>
			  <div class="message-box">${data.msg}</div>
			</div>
			`;
		}

		$('#message_display').append(html);
	}

}