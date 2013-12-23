<?php
function contactFormShortcode(){ 
wp_register_script( 'jquery.validate', plugins_url().'/responsive-contact-form/js/jquery.validate.js',array('jquery'));

wp_enqueue_script( 'jquery.validate' );

wp_enqueue_style('wp-contact',  plugins_url('/responsive-contact-form/css/contact.css'));

wp_head();

?>

<script type="text/javascript">

	var MyAjax = "<?php echo home_url(); ?>/wp-admin/admin-ajax.php";

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
<?php 
$data = '
	<div class="responsive-contact-form">
	<div class="alert alert-success" id="smsg" style="display:none">'.__("<strong>Succeed :</strong>Your details are submitted successfully!","aicontactform").'</div>
	<form class="form-horizontal" name="formValidate" id="ResponsiveContactForm" method="post" >
    <fieldset>';
	if(esc_attr(get_option("ai_visible_name"))=="on") {
    	$data .= '<div class="control-group"><label class="control-label" for="ai_name">'.__('Name','aicontactform');
		if(esc_attr(get_option('ai_enable_require_name'))=="on"){ 
			$data .= '<span class="req">*</span>'; 
		}
		$data .= '</label>
	      <div class="controls">
		      <input id="ai_name" name="ai_name" maxlength="50" title="'.__('Name','aicontactform').'" type="text" class="input-xlarge text ';		  
			  if(esc_attr(get_option('ai_enable_require_name'))=="on") { $data .= 'required '; }  $data .= '"onblur="replaceName();">
	      </div>
    </div>';
	}      
	$data .= '
	<div class="control-group">
	<label class="control-label" for="ai_email">'.__('Email ID','aicontactform').'<span class="req">*</span></label>
	    <div class="controls">
	    	<input id="ai_email" maxlength="255" name="ai_email" title="'.__('Email ID','aicontactform').'" type="text"class="input-xlarge email required">
	    </div>
    </div>'; 
	if(esc_attr(get_option('ai_visible_phone'))=="on") { 	
	$data .= '	
    <div class="control-group">
	<label class="control-label" for="ai_phone">'.__('Phone','aicontactform');
	if(esc_attr(get_option('ai_enable_require_phone'))=="on"){ $data .= '<span class="req">*</span>'; } $data .= '</label>
	    <div class="controls">
		    <input id="ai_phone" maxlength="15" name="ai_phone" title="'.__('Phone','aicontactform').'" type="text" class="input-xlarge number '; 
			if(esc_attr(get_option('ai_enable_require_phone'))=="on") {$data .= 'required';} $data .= '">
	    </div>
    </div>';
    }	  

    if(esc_attr(get_option('ai_visible_website'))=="on") {       
	$data .= '
	<div class="control-group">
	<label class="control-label" for="ai_website">'.__('Website Url','aicontactform');
	if(esc_attr(get_option("ai_enable_require_website"))=="on"){ $data .= '<span class="req">*</span>'; } $data .= '</label>
	    <div class="controls">
		    <input id="ai_website" name="ai_website" title="'.__('Website Url','aicontactform').'" type="text" class="input-xlarge ';
			if(esc_attr(get_option('ai_enable_require_website'))=="on") { $data .= 'required';} $data .= '"onblur="replaceWeburl();">
	    </div>
    </div>';
    }

    if(esc_attr(get_option('ai_visible_subject'))=="on") { 
    $data .= '<div class="control-group">
	<label class="control-label" for="ai_subject">'.__('Subject','aicontactform');
	if(esc_attr(get_option('ai_enable_require_subject'))=="on"){ $data .= '<span class="req">*</span>'; } $data .= '</label>
	    <div class="controls">
	    	<input id="ai_subject" name="ai_subject" title="'.__('Subject','aicontactform').'" type="text" class="input-xlarge '; 
			if(esc_attr(get_option('ai_enable_require_subject'))=="on") {$data .= 'required';} $data .= '"onblur="replaceSubject();">
	    </div>
    </div>';
    }      

    if(esc_attr(get_option('ai_visible_comment'))=="on") { 
    $data .= '<div class="control-group">
	<label class="control-label" for="ai_comment">'.__('Comment','aicontactform');
	if(esc_attr(get_option('ai_enable_require_comment'))=="on"){ $data .= '<span class="req">*</span>'; } $data .= '</label>
      	<div class="controls">
          <textarea id="ai_comment" name="ai_comment" title="'.__('Comment','aicontactform').'" rows="4" class="';if(esc_attr(get_option('ai_enable_require_comment'))=="on"){$data .= 'required';} $data .= '" onblur="replaceComment();"></textarea>
        </div>
    </div>';
	} 

    $captcha = get_option('ai_enable_captcha');
    if($captcha)
    {
	$data .= '
    <div class="control-group">
    	<label class="control-label" for="captcha">'.__('Captcha','aicontactform').'<span class="req">*</span></label>
    <div class="controls">
    <div class="captcha-div"> 
    	<img class="captcha" src="'.plugins_url("/responsive-contact-form/include").'/captcha_code_file.php?rand='.rand().'" id="captchaimg" onclick="javascript: refreshCaptcha();" alt="'.__('Captcha','aicontactform').'">
        <a href="javascript: refreshCaptcha();" data-toggle="tooltip" class="ttip" data-placement="right" data-original-title="'.__('Refresh Captcha Code','aicontactform').'">
        <img id="refresh" src="'.plugins_url("/responsive-contact-form/images/refresh.png").'" alt="Refresh Code">
        </a>
        <input type="text" id="captcha" title="'.__('Captcha Code','aicontactform').'" class="input-txt required" name="ai_captcha" maxlength="4" style="width:60px;">  
    </div>
    <span id="note"><small>'.__("Captcha is not case sensitive.","aicontactform").'</small></span> 
    <div class="alert alert-error" id="fmsg" style="display:none">'.__("<strong>Alert :</strong> Invalid captcha code!","aicontactform").'</div>
    <div class="clear"></div>
    </div>
    </div>';
    }
	
	if(esc_attr(get_option('ai_visible_sendcopy'))=="on") { 
    $data .= '<div class="control-group">
	  	<div class="controls">
		<input type="checkbox" name="ai_sendcopy" id="ai_sendcopy" value="1">'.__('Send me a copy','aicontactform').'           
        </div>
    </div>';
	} 
    $data .= '<div class="control-group">
		<div class="controls">
			<button id="submit" name="submit" title="'.__('Click to submit the form','aicontactform').'" class="btn-submit" >
			'.__('Submit','aicontactform').'
		    </button>
		</div>
	</div>
	</fieldset>
  </form>
</div>';
return $data;
}
?>