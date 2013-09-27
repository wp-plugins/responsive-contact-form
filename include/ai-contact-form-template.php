<?php
wp_register_script( 'jquery.validate', plugins_url().'/responsive-contact-form/js/jquery.validate.js',array('jquery'));
wp_enqueue_script( 'jquery.validate' );
wp_enqueue_style('wp-contact',  plugins_url('/responsive-contact-form/css/contact.css'));
wp_head();
?>
<script type="text/javascript">
/* <![CDATA[ */
var MyAjax = "<?php echo home_url(); ?>/wp-admin/admin-ajax.php";
/* ]]> */
</script>
<script type="text/javascript">
function refreshCaptcha(){
	var img = document.images['captchaimg'];		
	img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
}
function replaceName() 
{
   var pattern = /\bscript\b/ig;
   var mystring = document.getElementById('ai_name').value;
   var newString = mystring.replace(pattern, " script ");
   document.getElementById('ai_name').value = newString;
}
function replaceWeburl() 
{
   var pattern = /\bscript\b/ig;
   var mystring = document.getElementById('ai_website').value;
   var newString = mystring.replace(pattern, " script ");
   document.getElementById('ai_website').value = newString;
}
function replaceSubject() 
{
   var pattern = /\bscript\b/ig;
   var mystring = document.getElementById('ai_subject').value;
   var newString = mystring.replace(pattern, " script ");
   document.getElementById('ai_subject').value = newString;
}
function replaceComment() 
{
   var pattern = /\bscript\b/ig;
   var mystring = document.getElementById('ai_comment').value;
   var newString = mystring.replace(pattern, " script ");
   document.getElementById('ai_comment').value = newString;
}
</script>
<div class="responsive-contact-form">
  <div class="alert alert-success" id="smsg" style="display:none"></div>
  <form class="form-horizontal" name="formValidate" id="ResponsiveContactForm" method="post" >
    <fieldset>
	  
	  <?php if(esc_attr(get_option('ai_visible_name'))=="on") { ?>	
      <div class="control-group">
	  	<label class="control-label" for="ai_name">Name<?php if(esc_attr(get_option('ai_enable_require_name'))=="on"){ ?><span class="req">*</span><?php } ?></label>
        <div class="controls">
          <input id="ai_name" name="ai_name" maxlength="50" title="Name" type="text" class="input-xlarge text <?php if(esc_attr(get_option('ai_enable_require_name'))=="on") {echo "required";} ?>" onblur="replaceName();">
        </div>
      </div>
	  <?php } ?>      
      
      <div class="control-group">
        <label class="control-label" for="ai_email">Email ID<span class="req">*</span></label>
        <div class="controls">
          <input id="ai_email" maxlength="255" name="ai_email" title="Email ID" type="text"class="input-xlarge email required">
        </div>
      </div>
      
	  <?php if(esc_attr(get_option('ai_visible_phone'))=="on") { ?>	
      <div class="control-group">
	  	<label class="control-label" for="ai_phone">Phone<?php if(esc_attr(get_option('ai_enable_require_phone'))=="on"){ ?><span class="req">*</span><?php } ?></label>
        <div class="controls">
          <input id="ai_phone" maxlength="15" name="ai_phone" title="Phone" type="text" class="input-xlarge number <?php if(esc_attr(get_option('ai_enable_require_phone'))=="on") {echo "required";} ?>">
        </div>
      </div>
      <?php } ?>
	  
      <?php if(esc_attr(get_option('ai_visible_website'))=="on") { ?>      
      <div class="control-group">
	  	<label class="control-label" for="ai_website">Website Url<?php if(esc_attr(get_option('ai_enable_require_website'))=="on"){ ?><span class="req">*</span><?php } ?></label>
        <div class="controls">
          <input id="ai_website" name="ai_website" title="Website Url" type="text" class="input-xlarge <?php if(esc_attr(get_option('ai_enable_require_website'))=="on") {echo "required";} ?>" onblur="replaceWeburl();">
        </div>
      </div>
      <?php } ?>
      
      <?php if(esc_attr(get_option('ai_visible_subject'))=="on") { ?>      
      <div class="control-group">
	  	<label class="control-label" for="ai_subject">Subject<?php if(esc_attr(get_option('ai_enable_require_subject'))=="on"){ ?><span class="req">*</span><?php } ?></label>   
        <div class="controls">
          <input id="ai_subject" name="ai_subject" title="Subject" type="text" class="input-xlarge <?php if(esc_attr(get_option('ai_enable_require_subject'))=="on") {echo "required";} ?>" onblur="replaceSubject();">
        </div>
      </div>
      <?php } ?>
      
      <?php if(esc_attr(get_option('ai_visible_comment'))=="on") { ?>
      <div class="control-group">
	  	<label class="control-label" for="ai_comment">Comment<?php if(esc_attr(get_option('ai_enable_require_comment'))=="on"){ ?><span class="req">*</span><?php } ?></label>
        <div class="controls">
          <textarea id="ai_comment" name="ai_comment" title="Message" rows="4" class="<?php if(esc_attr(get_option('ai_enable_require_comment'))=="on") {echo "required";} ?>" onblur="replaceComment();"></textarea>
        </div>
      </div>
      <?php } ?>

      <?php $captcha = get_option('ai_enable_captcha');
      if($captcha)
      {
      ?>
      <div class="control-group">
        <label class="control-label" for="captcha">Captcha<span class="req">*</span></label>
        <div class="controls">
          <div class="captcha-div"> 
          	
            <img class="captcha" src="<?php echo plugins_url('/responsive-contact-form/include'); ?>/captcha_code_file.php?rand=<?php echo rand();?>" id='captchaimg' onclick='javascript: refreshCaptcha();' alt="captcha"> 
            <a href="javascript: refreshCaptcha();" data-toggle="tooltip" class="ttip" data-placement="right" data-original-title="Refresh Captcha Code">
            <img id="refresh" src="<?php echo plugins_url('/responsive-contact-form/images/'); ?>refresh.png" alt="Refresh Code">
            </a>
            <input type="text" id="captcha" title="Captcha Code" class="input-txt required" name="ai_captcha" maxlength="4" style="width:60px;">
          
          </div>
          <span id="note"><small><?php _e('Captcha is not case sensitive.','aicontactform');?></small></span> 
          
          <div class="alert alert-error" id="fmsg" style="display:none"></div>
          
          <div class="clear"></div>
        </div>
      </div>
      <?php
      }
      ?>
      <div class="control-group">
        <div class="controls">            
          <button id="submit" name="submit" title="Click to submit the form" class="btn-submit" >          
          		<?php _e('Submit','aicontactform');?>                      
          </button>
        </div>
      </div>
    </fieldset>
  </form>
</div>