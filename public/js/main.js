$(function(){
	
	$('div.question .answer input, div.question .answer label').click(function()
	{
		if($(this).parent().find('input').is(':checked'))
		{
			$(this).parent().parent().find('.radio').removeClass('has-answer');
			// console.log($(this).parent().parent().find('input[type="radio"]'));
			$(this).parent().addClass('has-answer');
		}
		else
		{
			$(this).parent().removeClass('has-answer');
		}
		
	});
	
	$('div.question .row.has-success input, div.question .row.has-error input').keypress(function()
	{
		$(this).parent().parent().removeClass('has-success has-error');
	});
	
	$('a.spoiler-warning').click(function()
	{
		$('.correct-answers').addClass('spoiled');
		$('#top-spoiler-warning').slideUp(400);
	});
	
	var getAuthenticationTypeByActiveTab = function()
	{
		if($('#tab-register').hasClass('active'))
		{
			return 0;
		}
		else if($('#tab-login').hasClass('active'))
		{
			return 1;
		}
		
		$('#tab-register').addClass('active');
		return 0;
	}
	
	var authentication_type = getAuthenticationTypeByActiveTab();
	
	$('#tab-register a').click(function(e)
	{
		$('form').removeClass('form-login').addClass('form-register');
		
		authentication_type = 0;
		$('#authentication_type').val(authentication_type);
		
		$('div.tabs .tab.active').removeClass('active');
		$(this).parent().addClass('active');
		
		e.preventDefault();
	});
	
	$('#tab-login a').click(function(e)
	{
		$('form').removeClass('form-register').addClass('form-login');
		
		authentication_type = 1;
		$('#authentication_type').val(authentication_type);
		
		$('div.tabs .tab.active').removeClass('active');
		$(this).parent().addClass('active');
		
		e.preventDefault();
	});
	
	////////////////////////////////////
	
	var updateScroll = function()
	{
		if($(document).scrollTop() >= 110)
		{
			$('header').addClass('fixed');
		}
		else
		{
			$('header').removeClass('fixed');
		}
	}
	
	$(document).scroll(function()
	{
		updateScroll();
	});
	
	updateScroll();
	
});
