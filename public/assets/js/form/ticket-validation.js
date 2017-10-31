var Validation = function () {

    return {
        
        //Validation
        initValidation: function () {

          $.validator.addMethod("regx", function(value, element, regexpr) {          
              return regexpr.test(value);
          }, '');

          $.validator.addMethod("greaterThan", function(value, element, params) {
            
            if(($(params).val() === '') || ($(element).val() === '')) {
              return true;
            }

            if(DateTime.dateToTimestamp($(params).val()) > DateTime.dateToTimestamp(value)) {
              return true;
            }

            return false;

          }, '');

	        $("#add_ticket_form").validate({  

            // ignore: '.ignore-field, :hidden, :disabled',
            ignore: ':hidden, :disabled',

	          // Rules for form validation
            rules:
            {
              title:
              {
                required: true,
                maxlength: 255
              },
              description:
              {
                required: true
              },
              place_location:
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
                required: true,
                date: true
              },
              price:
              {
                required: true,
                regx: /^[0-9]{1,3}(?:,?[0-9]{3})*(?:\.[0-9]{2})?$/
              },
              contact:
              {
                required: true
              }
            },
                                
            // Messages for form validation
            messages:
            {
              title:
              {
                required: 'ยังไม่ได้ป้อนหัวข้อ',
                maxlength: 'จำนวนตัวอักษรเกินกว่าที่กำหนด'
              },
              description:
              {
                required: 'ยังไม่ได้ป้อนรายละเอียด'
              },
              place_location:
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
                required: 'ยังไม่ได้ป้อนวันที่',
                date: 'วันที่ไม่ถูกต้อง'
              },
              price:
              {
                required: 'ยังไม่ได้ป้อนราคาที่ต้องการขาย',
                regx: 'ราคาที่ต้องการขายไม่ถูกต้อง'
              },
              contact:
              {
                required: 'ยังไม่ได้ป้อนช่องทางการติดต่อ'
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