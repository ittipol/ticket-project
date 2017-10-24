class TicketChatRoom {

  constructor(user,ticket) {
    this.user = user;
    this.ticket = ticket;
    this.io = null;
  }

  init() {
    this.io = new IO();
    this.bind();
    this.socketEvent();
  }

  bind() {

    let _this = this;

    $('[data-chat-modal="1"]').on('click',function(){
      $('body').css('overflow-y','hidden');
      $('#chat_message').val($(this).data('chat-message'));
      $('#chat_modal').addClass('show');
    });

    $('#chat_modal > .close').on('click',function(){
      $('body').css('overflow-y','auto');
      $('#chat_modal').removeClass('show');
      $('#chat_message').removeClass('error');
    });

    $('#chat_modal .modal-close').on('click',function(){
      $('body').css('overflow-y','auto');
      $('#chat_modal').removeClass('show');
      $('#chat_message').removeClass('error');
    });

    $('#chat_submit_message_btn').on('click',function(){

      let message = $('#chat_message').val().trim();

      if(message === '') {
        $('#chat_message').addClass('error');
        return false;
      }

      $(this).attr('disabled',true);
      // hide c-modal-inner
      $('.c-modal .c-modal-inner').addClass('hide');
      // show loading indicator
      $('.c-modal .sending-indicator').addClass('sending-animation');

      setTimeout(function(){
        _this.io.socket.emit('ticket-chat-room-message-send', {
          chanel: _this.user+'.'+_this.io.token,
          message: message,
          user: _this.user,
          ticket: _this.ticket,
        });
      },500);

    });

  }

  socketEvent() {

    let _this = this;

    this.io.socket.on('ticket-chat-room-after-sending', function(res){

      if(res.error) {

        const snackbar = new Snackbar();
        snackbar.setTitle(res.errorMessage);
        snackbar.display();

        $('#chat_submit_message_btn').attr('disabled',false);
        $('.c-modal .c-modal-inner').removeClass('hide');
        $('.c-modal .sending-indicator').removeClass('sending-animation');

      }else{
        setTimeout(function(){
          location.href = '/chat/r/'+res.room;
        },2500); 
      }

    });

  }

}