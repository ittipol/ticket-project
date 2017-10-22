class Datepicker {

	constructor(input = '#date',readable = true, dateFormat = 'yy-mm-dd') {
		this.input = input;
		this.dateFormat = dateFormat;
		this.readable = readable;
		this.el = null;
	}

	init() {

		// let _this = this;

		$(this.input).datepicker({
      dateFormat: this.dateFormat,
      prevText: '<i class="fa fa-angle-left"></i>',
      nextText: '<i class="fa fa-angle-right"></i>'
	  });

		if(this.readable) {
	  	this.setReadable();
		}

	  // this.bind();
	}

	// bind() {
	// 	let _this = this;
	// }

	setReadable() {

		let _this = this;

		this.el = document.createElement('div');
	  this.el.setAttribute('class','date-readable');
	  // bind
	  $(this.el).on('click',function(){
	  	$(_this.input).datepicker('show');
	  });

	  $(this.input).parent().append(this.el);

	  $(this.input).css('color','#fff');
	  // check if has value
	  this.covertToReadable();
	  // bind
	  $(this.input).on('change',function(){
	    _this.covertToReadable();
	  });
	}

	covertToReadable() {
		if($(this.input).val() !== '') {
		  let date = $(this.input).val().split('-');
		  $(this.el).text(parseInt(date[2])+' '+DateTime.getMonthName(parseInt(date[1]))+' '+(parseInt(date[0])));
		}
	}

}