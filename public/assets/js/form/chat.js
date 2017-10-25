class Chat {

	constructor(chat) {
		this.chat = chat;
		this.io = null;
		this.loading = false;
		this.loadPostition = 0;
		this.messagePlaced = false;
		this.typingHandle = null;
		this.messageReceivedHandle = null;
	}

	init() {

		this.io = new IO();

		let _this = this;

		this.join();
	  this.bind(_this);
	  this.socketEvent(_this);

	  this.more();
	  this.layout();
	  this.calPosition(window.innerHeight);



	  setTimeout(function(){
	  	_this.toButtom();
	  },800)
	}

	join() {
		this.io.socket.emit('chat-join', {
			room: this.chat.room,
	    key: this.chat.key
	  });
	}

	bind(_this) {

		$('#message_input').on('keyup',function(event){

			if(event.keyCode === 13) {
				return false;
			}

			_this.typing();

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

	  $('.chat-section').on('scroll',function(){
	  	if($(this).scrollTop() < _this.loadPostition) {
	  		_this.more();
	  	}
	  });

	  $(window).resize(function(){
	  	_this.layout();
	  	_this.calPosition(window.innerHeight);
	  });

	}

	socketEvent(_this) {

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

		this.io.socket.on('chat-message', function(res){

			clearTimeout(this.messageReceivedHandle);

			if(_this.messagePlaced) {
				_this.messagePlaced = false;
				return false;
			}

	  	if(_this.chat.user != res.user) {
	  		setTimeout(function(){
					_this.io.socket.emit('message-read', {
						room: _this.chat.room,
						user: _this.chat.user
					});
				},2000);

	  		_this.placeMessage(res,false);
	  		_this.toButtom();
	  	}

	  });

	  this.io.socket.on('chat-load-more', function(res){

	  	if(!res.next) {
	  		return false;
	  	}

	  	let me;

	  	_this.chat.page = res.page;

	  	for (var i = 0; i < res.data.length; i++) {
	  		me = false;

	  		if(_this.chat.user == res.data[i].user_id) {
	  			me = true;
	  		}

				// moment(res.data[i].created_at, "YYYYMMDDThhmmss.SSS").format("YYYY-MM-DD hh:mm:ss")
	  		$('#message_display').prepend(_this.getHtml(res.data[i].user_id, res.data[i].message, res.data[i].created_at, me));
	  	};

	  	setTimeout(function(){
	  		_this.loading = false;
	  	},1000);

	  });

	}

	toButtom() {
		if($('.chat-thread').innerHeight() > $('.chat-section').innerHeight()) {
			$('.chat-section').scrollTop(($('.chat-thread').innerHeight() - $('.chat-section').innerHeight()))
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
			message: message.trim()
		});

		this.messagePlaced = true;

		this.send(message);
	}

	send(message) {
		this.io.socket.emit('send-message', {
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

	getHtml(user,message,date,me = true) {

		let html = '';

		if(me) {
			html = `
			<div class="message-section message-me">
			  <div class="avatar">
			    <img src="/avatar?d=1">
			  </div>
			  <div class="message-box">
				  ${message}
			  </div>
			  <small class="message-time">${DateTime.covertDateTimeToSting(date)}</small>
			</div>
			`;
		}else{
			html = `
			<div class="message-section">
			  <div class="avatar">
			    <img src="/avatar/${user}?d=1">
			  </div>
			  <div class="message-box">
			  	${message}
			  </div>
			  <small class="message-time">${DateTime.covertDateTimeToSting(date)}</small>
			</div>
			`;
		}

		return html;

	}

	placeMessage(data,me = true) {
		$('#message_display').append(this.getHtml(data.user,data.message, moment().format('YYYY-MM-DD h:mm:ss'), me));
	}

	calPosition(screenHeight) {
		this.loadPostition = screenHeight * 0.15;
	}

	layout() {

		let wH = window.innerHeight;
		let wW = window.innerWidth;
		let navbarH = 60;
		let sidebarW = $('.chat-left-sidenav').innerWidth();

		$('.chat-left-sidenav').css({
			'height': (wH-navbarH)+'px',
			'top': navbarH+'px'
		});

		$('.chat-section').css({
			'height': (wH-navbarH-50)+'px',
			'width': (wW-sidebarW)+'px'
		});

		$('.chat-footer-section').css('width',(wW-sidebarW)+'px');

	}

}