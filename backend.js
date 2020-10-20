$(document).ready(function(){
	var placeHolder = '';
	$('input').focus(function(){
		placeHolder = $(this).attr('placeholder');
		$(this).attr('placeholder', '');
	}).blur(function(){
		$(this).attr('placeholder', placeHolder);
	})
	$('.confirm').click(function(){
		return confirm("Are you sure");
	})
	
})
