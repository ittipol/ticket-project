class TicketForm {

  constructor() {
    this.handle;
  }

  init() {
    this.dateInputField($('#date_type_select').val());
    this.bind();
  }

  bind() {

    let _this = this;

    $('#price_input').on('keyup',function(){
      _this.calDiscount();
    })

    $('#original_price_input').on('keyup',function(){
      _this.calDiscount();
    })

    $('#date_type_select').on('change',function(){

      $('#date_input_1').val('');
      $('#date_input_2').val('');

      $('.date-readable').text('');

      _this.dateInputField($(this).val());

    })

  }

  dateInputField(type) {
    switch(type) {

      case '1':
          $('#date_1').css('display','block');
          $('#date_2').removeClass('col-12').addClass('col-md-6');
          $('#date_2 > label').removeClass('col-12').text('ใช้ได้ถึง');
          break;
      case '2':
            $('#date_1').css('display','none');
            $('#date_2').addClass('col-12').removeClass('col-md-6');
            $('#date_2 > label').text('วันที่แสดง');
          break;
      case '3':
          $('#date_1').css('display','none');
          $('#date_2').addClass('col-12').removeClass('col-md-6');
          $('#date_2 > label').text('วันที่เดินทาง');
          break;

    }
  }

  calDiscount() {

    clearTimeout(this.handle);

    if(
        (typeof $('#price_input').val() == 'undefined') || ($('#price_input').val() < 1) 
        ||
        (typeof $('#original_price_input').val() == 'undefined') || ($('#original_price_input').val() < 1)
      ) {
      return false;
    }

    if($('#price_input').val() - $('#original_price_input').val() > 0) {
      $('#percent_input').val(0);
      return false;
    }

    this.handle = setTimeout(function(){
      let percent = 100 - (($('#price_input').val() * 100) / $('#original_price_input').val());
      $('#percent_input').val(Math.round(percent,2));
    },300);

  }

}