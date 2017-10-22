class TicketClose {

  constructor() {
    this.ticket;
  }

  init() {
    this.bind();
  }

  bind() {

    let _this = this;

    $('[data-t-closing-modal="1"]').on('click',function(){

      $('body').css('overflow-y','hidden');

      $('.ticket-title').text($(this).data('t-title'));

      _this.ticket = $(this).data('t-id');

      $('#closing_option_1').trigger('click');
      $('#closing_ticket_modal').addClass('show');
    });

    $('#closing_ticket_modal > .close').on('click',function(){
      $('body').css('overflow-y','auto');
      $('#closing_ticket_modal').removeClass('show');
      _this.clear();
    });

    $('#target-inner > .modal-close').on('click',function(){
      $('body').css('overflow-y','auto');
      $('#closing_ticket_modal').removeClass('show');
      _this.clear();
    });

    $('.close-option').on('click',function(){

      switch($(this).val()) {

        case '3':
          $('#closing_reason').addClass('show').focus();
        break;

        default:
          $('#closing_reason').removeClass('show').removeClass('error');
        break;

      }

    });

    $('#closing_ticket_form').on('submit',function(){

      switch($('.close-option:checked').val()) {
        case '3':

          if($('#closing_reason').val().trim() === '') {
            $('#closing_reason').addClass('error');
            return false;
          }

        break;
      }

      let hidden = document.createElement('input');
      hidden.setAttribute('type','hidden');
      hidden.setAttribute('name','ticketId');
      hidden.setAttribute('value',_this.ticket);
      $(this).append(hidden);

    });

  }

  clear() {
    $('.ticket-title').text('');
    $('#closing_reason').removeClass('show').removeClass('error').val('');
  }

}