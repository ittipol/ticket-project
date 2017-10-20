var Validation = function () {

    return {
        
        //Validation
        initValidation: function () {

	        $("#profile_edit_form").validate({  

            // ignore: '.ignore-field, :hidden, :disabled',
            ignore: ':hidden, :disabled',

	            // Rules for form validation
            rules:
            {
              name:
              {
                required: true,
                maxlength: 255
              }
            },
                                
            // Messages for form validation
            messages:
            {
              name:
              {
                required: 'ชื่อ นามสกุลห้ามว่าง',
                maxlength: 'จำนวนตัวอักษรเกินกว่าที่กำหนด'
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