<?php
wp_register_script( 'jquery.validate', plugins_url().'/responsive-contact-form/js/jquery.validate.js',array('jquery'));
wp_enqueue_script( 'jquery.validate' );
wp_enqueue_style('wp-contact',  plugins_url('/responsive-contact-form/css/contact.css'));
wp_head();
$thank_you_message = get_option('ai_thankyou_setting')?get_option('ai_thankyou_setting'):'Your details are submitted successfully!';
?>
<div class="responsive-contact-form">
  <div class="alert alert-success" id="smsg" style="display:none"></div>
  <form class="form-horizontal" name="formValidate" id="ResponsiveContactForm" method="post" >
    <fieldset>
      <!-- Text input-->
      <div class="control-group">
        <label class="control-label" for="textinput">
          <?php _e('Name','aicontactform');?>
          <span class="req">*</span></label>
        <div class="controls">
          <input id="ai_name" name="ai_name" type="text" placeholder="" class="input-xlarge required" value="<?php if(isset($_POST['ai_name'])){ echo $_POST['ai_name']; }?>">
        </div>
      </div>
      
      <!-- Text input-->
      <div class="control-group">
        <label class="control-label" for="textinput">
          <?php _e('Phone','aicontactform');?>
          <span class="req">*</span></label>
        <div class="controls">
          <input id="ai_phone" name="ai_phone" type="text" placeholder="" class="input-xlarge required number" value="<?php if(isset($_POST['ai_phone'])){ echo $_POST['ai_phone']; }?>">
        </div>
      </div>
      
      <!-- Text input-->
      <div class="control-group">
        <label class="control-label" for="textinput">
          <?php _e('Email','aicontactform');?>
          <span class="req">*</span></label>
        <div class="controls">
          <input id="ai_email" name="ai_email" type="text" placeholder="" class="input-xlarge required email" value="<?php if(isset($_POST['ai_email'])){ echo $_POST['ai_email']; }?>">
        </div>
      </div>
      
      <!-- Textarea -->
      <div class="control-group">
        <label class="control-label" for="textarea">
          <?php _e('Comment','aicontactform');?>
        </label>
        <div class="controls">
          <textarea id="ai_comment" name="ai_comment"><?php if(isset($_POST['ai_comment'])){ echo $_POST['ai_comment']; }?>
</textarea>
        </div>
      </div>
      <?php $captcha = get_option('ai_enable_captcha');
    if($captcha)
    {
    ?>
      <div class="control-group">
        <label class="control-label" for="textinput">
          <?php _e('Captcha','aicontactform');?>
          <span class="req">*</span></label>
        <div class="controls">
          <div class="captcha-div"> <img class="captcha" src="<?php echo plugins_url('/responsive-contact-form/templates'); ?>/captcha_code_file.php?rand=<?php echo rand();?>" id='captchaimg' onclick='javascript: refreshCaptcha();' alt="captcha"> <a href="javascript: refreshCaptcha();" data-toggle="tooltip" class="ttip" data-placement="right" data-original-title="Refresh Captcha Code"><img style="border:0px" src="<?php echo plugins_url('/responsive-contact-form/templates/images/'); ?>refresh.png" alt="Refresh Code"></a>
            <input type="text" id="captcha" class="input-txt required" name="ai_captcha" maxlength="4" size="4" style="width:50px;">
          </div>
          <small>
          <?php _e('Captcha is not case sensitive.','aicontactform');?>
          </small>
          <div class="alert alert-error" id="fmsg" style="display:none"></div>
          <div class="clear"></div>
        </div>
      </div>
      <?php
    }
    ?>
      <!-- Button -->
      <div class="control-group">
        <label class="control-label" for="singlebutton"></label>
        <div class="controls">            
          <button id="singlebutton" name="singlebutton" class="btn-submit" >          
          <?php _e('Submit','aicontactform');?>
          <?php
            if(get_option('ai_email_address_setting')==''){
                $ai_emailadmin = get_option('admin_email');	
            }else{
                $ai_emailadmin = get_option('ai_email_address_setting');
            }
            
            if(get_option('ai_subject_text')==''){
            	$ai_subtext = 'August Infotech';
            }else{
            	$ai_subtext = get_option('ai_subject_text');
            }
          ?>   
          <input type="hidden"  name="ai_email_address_setting" value="<?php echo $ai_emailadmin; ?>">
          <input type="hidden"  name="ai_subject_text" value="<?php echo $ai_subtext; ?>">
          <input type="hidden"  name="ai_enable_captcha" value="<?php echo get_option('ai_enable_captcha'); ?>">
          <input type="hidden"  name="blog_name" value="<?php echo get_bloginfo('name');?>">
          </button>
        </div>
      </div>
    </fieldset>
  </form>
</div>
<script>
function refreshCaptcha()
{
	var img = document.images['captchaimg'];
	img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
}
</script> 
<script type="text/javascript">
jQuery(document).ready(function(){
jQuery("#ResponsiveContactForm").validate({
		submitHandler: function(form) 
		{			
			var myAjax =jQuery.ajax({
								  url:"<?php echo plugins_url('/responsive-contact-form/templates/ai-sendmail.php')?>" ,
								  global: false,
								  type: "POST",
								  data: jQuery(document.formValidate).serializeArray(),
								  dataType: "json",
								  success: function(result){
										if(result == 1)
						 				{
												jQuery("#smsg").slideDown(function(){
												jQuery('html, body').animate({scrollTop: jQuery("#smsg").offset().top},'fast');
									 			jQuery(this).html('<strong>Succeed :</strong> <?php echo $thank_you_message; ?>').delay(8000).slideUp("fast")});									
												document.getElementById('ResponsiveContactForm').reset();
												refreshCaptcha();								
												jQuery(".input-xlarge").removeClass("valid");
												jQuery(".input-xlarge").next('label.valid').remove();											
										}else{											
											jQuery("#fmsg").slideDown(function(){
											jQuery(this).html('<strong>Alert :</strong> Invalid captcha code!').delay(8000).slideUp("fast")});
											jQuery("#captcha").removeClass("valid").addClass("error");
											jQuery("#captcha").next('label.valid').removeClass("valid").addClass("error");									  
											jQuery('#captcha').val('');
											refreshCaptcha();											
										}
									  }
							});
				}			
});
});
</script>