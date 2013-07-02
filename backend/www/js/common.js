$(document).ready(function(){
     
	$(function() {
		jQuery('a[rel="tooltip"]').tooltip();
		jQuery('input[type="text"]').tooltip();
	});
    /* display jGrowl message based on json response
		expected format:
		data.status = "error","success","info","warning"
		data.message = message to be displayed
	*/
	jQuery.lmNotify = function(data) {
		
		var _sticky  = false;
		if (data.status =='error' || data.status =='warning')
			_sticky = true;
		$.jGrowl(data.message,
		{
			theme : 'lm-'+ data.status,
			life  : 5000,
			sticky : _sticky
		
		});
		
		
	};
});