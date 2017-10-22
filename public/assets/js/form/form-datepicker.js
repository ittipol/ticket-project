class Datepicker {

	constructor(selector = '#date',dateFormat = 'yy-mm-dd') {
		this.selector = selector;
		// this.hiddenSelector = hiddenSelector;
		this.dateFormat = dateFormat;
	}

	init() {

		// let _this = this;

		$(this.selector).datepicker({
      dateFormat: this.dateFormat,
      prevText: '<i class="fa fa-angle-left"></i>',
      nextText: '<i class="fa fa-angle-right"></i>'
	  });

	  // $(this.selector).on('change',function(){
	  //   if($(this).val() != '') {

	  //   	$(_this.hiddenSelector).val($(this).val());

	  //     let date = $(this).val().split('-');
	  //     $(this).val(parseInt(date[2])+' '+_this.findMonthName(parseInt(date[1]))+' '+(parseInt(date[0])+543));
	  //   }
	  // });
	}

}