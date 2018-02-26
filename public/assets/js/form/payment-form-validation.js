var Validation = function () {

    return {
        
        //Validation
        initValidation: function () {

          $.validator.addMethod("regx", function(value, element, regexpr) {          
              return regexpr.test(value);
          }, "");

	        $("#payment_form").validate({  

            // ignore: '.ignore-field, :hidden, :disabled',
            ignore: ':hidden, :disabled',

	            // Rules for form validation
            rules:
            {
              amount:
              {
              	required: true,
                regx: /^[0-9]{1,3}(?:,?[0-9]{3})*(?:\.[0-9]{2})?$/,
              },
              holder_name:
              {
                required: true
              },
              // card_number:
              // {
              //   // required: true,
              //   digits: true
              // },
              cvc:
              {
                required: true,
                digits: true
              },
              card_expire:
              {
                required: true
              }
            },
                                
            // Messages for form validation
            messages:
            {
              amount:
              {
                required: 'จำนวนเงินห้ามว่าง',
                regx: 'จำนวนเงินไม่ถูกต้อง'
              },
              holder_name:
              {
                required: 'ชื่อเจ้าของบัตรห้ามว่าง'
              },
              // card_number:
              // {
              //   // required: 'หมายเลขบัตรห้ามว่าง',
              //   digits: 'หมายเลขบัตรไม่ถูกต้อง'
              // },
              cvc:
              {
                required: 'CVC ห้ามว่าง',
                digits: 'CVC ไม่ถูกต้อง',
                // regx: 'CVC ไม่ถูกต้อง'
              },
              card_expire:
              {
                required: 'วันหมดอายุห้ามว่าง'
              }
            },

            submitHandler: function(form) {
              $('.global-overlay').addClass('displayed');
              $('.global-loading-icon').addClass('displayed');
              $(form).get(0).submit();
            },

            // submitHandler: function(form) {

            //   let _form = $(form);

            //   // Disable the submit button to avoid repeated click.
            //   _form.find("input[type=submit]").prop("disabled", true);

            //   $('.global-overlay').addClass('displayed');
            //   $('.global-loading-icon').addClass('displayed');

            //   switch($('.method-rdo:checked').val()) {

            //     case 'method_1':

            //       let cardExpire = $('#card_expire').val().split(' / ');
            //       let card = {
            //         "name":  $('#holder_name').val(),
            //         "number": $('#card_number').val().replace(/\s/g,''),
            //         "expiration_month": cardExpire[0],
            //         "expiration_year": cardExpire[1],
            //         "security_code": $('#cvc').val()
            //       };
                
            //       Omise.createToken("card", card, function (statusCode, response) {
            //         if(response.object == "error") {

            //           $("#card_error").html('หมายเลขบัตรเครดิตไม่ถูกต้องหรือระบบไม่รองรับบัตรเครดิตนี้').css('display','block');
            //           $(document).scrollTop($("#card_error").position().top);

            //           // Re-enable the submit button.
            //           _form.find("input[type=submit]").prop("disabled", false);

            //           $('.global-overlay').removeClass('displayed');
            //           $('.global-loading-icon').removeClass('displayed');

            //         }else {
            //           // Then fill the omise_token.
            //           _form.find("[name=omise_token]").val(response.id);

            //           // Remove card number from form before submiting to server.
            //           $('#card_number').val('');
            //           $('#cvc').val('');

            //           // submit token to server.
            //           _form.get(0).submit();
            //         };
            //       });

            //     break;

            //     default:

            //       setTimeout(function(){
            //         _form.get(0).submit();
            //       },400);

            //   }

            //   return false;

            // },             
	            
	            // Do not change code below
            errorPlacement: function(error, element)
            {
              error.insertAfter(element.parent());
            }
	        });
        }

    };
}();