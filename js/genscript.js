
$(document).ready(function(e) {
	
	$.fn.extend({
		valida_numero: function(e) {
				
				if(e.keyCode>47 && e.keyCode<58){
					return true;
				}
				else{
					return false;
				}
			}
	});
	$("body").on("keypress","input[data-validar='numero']",function(e){
		return $(this).valida_numero(e);
    });
	
	
});
