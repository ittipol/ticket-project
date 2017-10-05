var Validation = function () {

    return {
        
        //Validation
        initValidation: function () {

	        $("#login_form").validate({  

            // ignore: '.ignore-field, :hidden, :disabled',
            ignore: ':hidden, :disabled',

	            // Rules for form validation
            rules:
            {
              email:
              {
                required: true,
                email: true
              },
              password:
              {
              	required: true
              }
            },
                                
            // Messages for form validation
            messages:
            {
              email:
              {
                required: 'โปรดป้อนอีเมล',
                email: 'อีเมลไม่ถูกต้อง'
              },
              password:
              {
                required: 'โปรดป้อนรหัสผ่าน'
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