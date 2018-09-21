$(document).ready(function() {
	
	$('[placeholder]').focus(function() {
		$(this).attr('data-text', $(this).attr('placeholder'));

		$(this).attr('placeholder', '');
		
	}).blur(function() {
		$(this).attr('placeholder' , $(this).attr('data-text'));
	});

	$('input').each(function() {
		if ($(this).attr('required') === 'required') {
         $(this).after('<span class="ast"> * </span> ');

		}
	});


	$('.confirm').click(function() {
		return confirm('Are you sure');
	});
  


  /////////////////form active in front end 


  $('.logindiv h2 span').click(function() {
  	$(this).addClass('actv').siblings().removeClass('actv');
   $('.logindiv form').hide();	  	

  	$('.' + $(this).data('class')).fadeIn(1000);
  

  });


$('.live-name').keyup(function() {
	$('.live-preview h3').text($(this).val()) ;
});


$('.live-price').keyup(function() {
	$('.thumbnail span').text($(this).val()) ;
});
$('.live-desc').keyup(function() {
	$('.live-preview p').text($(this).val()) ;
});


});	