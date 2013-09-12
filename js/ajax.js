jQuery(document).ready(function(){
jQuery("#ResponsiveContactForm").validate({						
	submitHandler: function(form) 
	{
	jQuery.ajax({
		type: "POST",			
		dataType: "json",	
		url:MyAjax, 
		data:{
			action: 'ai_action', 
			fdata : jQuery(document.formValidate).serialize()
		}, 
		success:function(response) {
			if(response == 1){
				jQuery("#smsg").slideDown(function(){
				jQuery('html, body').animate({scrollTop: jQuery("#smsg").offset().top},'fast');
				jQuery(this).html('<strong>Succeed :</strong>Your details are submitted successfully!').delay(8000).slideUp("fast")});
				document.getElementById('ResponsiveContactForm').reset();
				refreshCaptcha();								
				jQuery(".input-xlarge").removeClass("valid");
				jQuery(".input-xlarge").next('label.valid').remove();											
			}else if(response == 2){											
				jQuery("#fmsg").slideDown(function(){
				jQuery(this).html('<strong>Alert :</strong> Invalid captcha code!').delay(8000).slideUp("fast")});
				jQuery("#captcha").removeClass("valid").addClass("error");
				jQuery("#captcha").next('label.valid').removeClass("valid").addClass("error");									  
				jQuery('#captcha').val('');
				refreshCaptcha();											
			}else{
				alert(response);
			}		
		}
		});	
	}			
});
});