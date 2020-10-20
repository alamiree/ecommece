$(document).ready(function(){
	var placeHolder = '';
	$('input').focus(function(){
		placeHolder = $(this).attr('placeholder');
		$(this).attr('placeholder', '');
	}).blur(function(){
		$(this).attr('placeholder', placeHolder);
	})
	$('.confirm').click(function(){
		console.log("Hi")
	})
	
})
