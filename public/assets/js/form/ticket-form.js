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
          $('#date_1').removeClass('col-12').addClass('col-md-6');
          $('#date_1 > label').text('วันที่เริ่มใช้').removeClass('required');
          $('#date_2 > label').text('ใช้ได้ถึง').addClass('required');
          $('#date_input_1').removeClass('date-required');
          $('#date_input_2').addClass('date-required');
          $('#date_2').css('display','block')
          break;
      case '2':
            $('#date_2').css('display','none');
            $('#date_1').addClass('col-12').removeClass('col-md-6');
            $('#date_1 > label').text('วันที่แสดง').addClass('required');
            $('#date_input_1').addClass('date-required');
            $('#date_input_2').removeClass('date-required');
          break;
      case '3':
          $('#date_1').removeClass('col-12').addClass('col-md-6');
          $('#date_1 > label').text('วันที่เดินทาง').addClass('required');
          $('#date_2 > label').text('วันที่กลับ').removeClass('required');
          $('#date_input_1').addClass('date-required');
          $('#date_input_2').removeClass('date-required');
          $('#date_2').css('display','block');
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

    let price = $('#price_input').val().replace(/,/g,'');
    let originalPrice = $('#original_price_input').val().replace(/,/g,'');

    if(price - originalPrice > 0) {
      $('#percent_input').val(0);
      return false;
    }

    this.handle = setTimeout(function(){
      let percent = 100 - ((price * 100) / originalPrice);
      $('#percent_input').val(Math.round(percent,2));
    },300);

  }

}