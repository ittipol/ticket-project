var Masking = function () {

    return {
        
        //Masking
        initMasking: function () {
	        $("#card_number").mask('9999 9999 9999 9999', {placeholder:'•'});
	        $("#cvc").mask('999', {placeholder:'•'});
	        $("#card_expire").mask('99/99', {placeholder:'•'});
        }

    };
    
}();