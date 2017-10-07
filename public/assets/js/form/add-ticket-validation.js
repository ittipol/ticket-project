var Validation = function () {

    return {
        
        //Validation
        initValidation: function () {

          $.validator.addMethod("regx", function(value, element, regexpr) {          
              return regexpr.test(value);
          }, "");

	        $("#add_ticket_form").validate({  

            // ignore: '.ignore-field, :hidden, :disabled',
            ignore: ':hidden, :disabled',

	            // Rules for form validation
            rules:
            {
              title:
              {
                required: true
              },
              description:
              {
                required: true
              },
              place_location:
              {
              	required: true
              },
              expiration_date:
              {
                required: true,
                date: true
              },
              price:
              {
                required: true,
                regx: /^[0-9]{1,3}(?:,?[0-9]{3})*(?:\.[0-9]{2})?$/
              },
              // original_price:
              // {
              // }
            },
                                
            // Messages for form validation
            messages:
            {
              title:
              {
                required: 'ยังไม่ได้ป้อนหัวข้อ'
              },
              description:
              {
                required: 'ยังไม่ได้ป้อนรายละเอียด'
              },
              place_location:
              {
                required: 'ยังไม่ได้ป้อนสถานที่หรือตำแหน่งที่สามารถนำไปใช้ได้',
              },
              expiration_date:
              {
                required: 'ยังไม่ได้ป้อนวันสิ้นสุดการใช้งาน',
                date: 'วันสิ้นสุดการใช้งานไม่ถูกต้อง',
              },
              price:
              {
                required: 'ยังไม่ได้ป้อนราคาที่ต้องการขาย',
                regx: 'ราคาที่ต้องการขายไม่ถูกต้อง'
              },
              // original_price:
              // {
              //   regx: 'ราคาเดิมของบัตรไม่ถูกต้อง'
              // },
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