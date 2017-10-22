var Validation = function () {

    return {
        
        //Validation
        initValidation: function () {

          $.validator.addMethod("greaterThan", function(value, element, params) {
            
            if($(params).val() === '') {
              return true;
            }

            if(DateTime.dateToTimestamp($(params).val()) > DateTime.dateToTimestamp(value)) {
              return true;
            }

            return false;

          }, '');

	        $("#ticket_filter_form").validate({  

            // ignore: '.ignore-field, :hidden, :disabled',
            ignore: ':hidden, :disabled',

	          // Rules for form validation
            rules:
            {
              q:
              {
                maxlength: 255
              },
              date_1:
              {
                date: true,
                greaterThan: '#date_input_2'
              },
              date_2:
              {
                date: true
              }
            },
                                
            // Messages for form validation
            messages:
            {
              q:
              {
                maxlength: 'จำนวนตัวอักษรเกินกว่าที่กำหนด'
              },
              date_1:
              {
                date: 'วันที่ไม่ถูกต้อง',
                greaterThan: 'ไม่อนุญาตให้กรอกวันที่เริ่มต้นมากกว่าหรือเท่ากับวันที่สิ้นสุด'
              },
              date_2:
              {
                date: 'วันที่ไม่ถูกต้อง'
              }
            },    

            // submitHandler: function(form) {},             
	            
	            // Do not change code below
            errorPlacement: function(error, element)
            {
              error.insertAfter(element.parent());
            }
	        });
        }

    };
}();