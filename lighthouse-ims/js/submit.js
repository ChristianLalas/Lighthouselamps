$(document).ready(function(){
	$('form .submit').click(function(){
		var form = $(this).closest('form');

		if(form[0].checkValidity())
		{
			$(this).attr('disabled', true);
			form.submit();
		}
		
	});
});