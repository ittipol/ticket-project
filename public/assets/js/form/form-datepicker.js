class Datepicker {

	constructor(selector = '#date',hiddenSelector = '#_date') {
		this.selector = selector;
		this.hiddenSelector = hiddenSelector;
	}

	init() {

		let _this = this;

		$(this.selector).datepicker({
      dateFormat: 'yy-mm-dd',
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

	findMonthName(month) {
	  let monthName = [
	    'มกราคม',
	    'กุมภาพันธ์',
	    'มีนาคม',
	    'เมษายน',
	    'พฤษภาคม',
	    'มิถุนายน',
	    'กรกฎาคม',
	    'สิงหาคม',
	    'กันยายน',
	    'ตุลาคม',
	    'พฤศจิกายน',
	    'ธันวาคม',
	  ];

	  return monthName[month-1];
	}

}