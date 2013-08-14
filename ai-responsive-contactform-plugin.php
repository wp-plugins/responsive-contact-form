<?php
/*
Plugin Name: Responsive ContactForm
Plugin URI: http://www.augustinfotech.com
Description: Add Contact Form to your WordPress website.You can add [ai_contact_form] shortcode where you want to display contact form.OR You can add  do_shortcode("[ai_contact_form]"); shortcode in any template.
Version: 1.0
Text Domain: aicontactform
Author: August Infotech
Author URI: http://www.augustinfotech.com
*/
add_action('plugins_loaded', 'ai_contactform_init');

function ai_contactform_init() {
		load_plugin_textdomain( 'aicontactform', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

add_action('admin_menu', 'ai_global_menu');

function ai_global_menu() {
		add_options_page('AI Simple Ajax Contact Form Settings','AI Simple Ajax Contact Form Settings','manage_options', 'aiglobalsitesettings', 'ai_global_settings_page');
}

add_action('admin_init', 'ai_register_globalsettings' );

function ai_register_globalsettings() { 
  register_setting( 'ai-global-group', 'ai_thankyou_setting' );
  register_setting( 'ai-global-group', 'ai_email_address_setting' );
  register_setting( 'ai-global-group', 'ai_enable_captcha' );
  register_setting( 'ai-global-group', 'ai_error_setting' );
  register_setting( 'ai-global-group', 'ai_subject_text' );
}

if ( function_exists('register_uninstall_hook') )
        register_uninstall_hook(__FILE__,'ai_contact_form_uninstall');   
		
function ai_contact_form_uninstall()
{
	 delete_option('ai_thankyou_setting'); 
	 delete_option('ai_email_address_setting');
	 delete_option('ai_enable_captcha');
	 delete_option('ai_error_setting');
	 delete_option('ai_subject_text');
}		

add_shortcode('ai_contact_form',  'ai_shortcode');

function ai_shortcode() {
	 include_once('templates/ai-template-contact-form.php');
}

function ai_global_settings_page()
{
?>
<style>
textarea, input[type="text"], input[type="password"], input[type="file"], input[type="email"], input[type="number"], input[type="search"], input[type="tel"], input[type="url"], select { width: 250px !important; }
</style>
<div class="wrap">
   <img src="<?php echo plugin_dir_url(__FILE__ ) ;?>/css/augustinfotech.jpg" class="icon32" />
  <h2><?php _e('AI Simple Ajax Contact Form Settings','aicontactform');?></h2>
  <div class="postbox" id="poststuff">
    <div class="handlediv" title="Click to toggle"><br>
    </div>
    <h3 class="hndle"><?php _e('Settings','aicontactform');?></h3>
    <form method="post" action="options.php" name="AIGolbalSiteOptions">
      <?php settings_fields( 'ai-global-group' ); ?>
      <table class="form-table">
        <tbody>
          <tr>
            <th><label for="ai_email_address_setting">
                <?php _e('Email Address:','aicontactform');?>
              </label></th>
            <td><input type="text" name="ai_email_address_setting" class="regular-text" value="<?php echo esc_attr(get_option('ai_email_address_setting'));?>">
              <br />
             <?php _e('<strong>Note:</strong> You can add multiple email addresses seperated by comma, to send email to multiple users.','aicontactform');?></td>
          </tr>
          <tr>
            <th><label for="ai_thankyou_setting">
                <?php _e('Thank You Message:','aicontactform');?>
              </label></th>
            <td><textarea  name="ai_thankyou_setting" class="regular-text" ><?php echo esc_attr(get_option('ai_thankyou_setting'));?></textarea>
    	        <br /><?php _e('<strong>Note:</strong> If not provided default message " Your details are submitted successfully! " will be used.','aicontactform');?>
            </td>
          </tr>          
          <tr>
            <th><label for="ai_subject_text">
                <?php _e('Subject Text:','aicontactform');?>
              </label></th>
            <td><input type="text" name="ai_subject_text" class="regular-text" value="<?php echo esc_attr(get_option('ai_subject_text'));?>">
	            <br /><?php _e('<strong>Note:</strong> If not provided default subject text " August Infotech " will be used.','aicontactform');?>
            </td>
          </tr>
          <tr>
            <th><label for="ai_enable_captcha">
                <?php _e('Enable Captcha:','aicontactform');?>
              </label></th>
            <td><input type="checkbox" name="ai_enable_captcha" id="ai_enable_captcha" <?php if(esc_attr(get_option('ai_enable_captcha'))=="on") {echo "checked";} ?>  />	<br /><?php _e('<strong>Note:</strong> You can add <strong> [ai_contact_form] </strong> shortcode where you want to display contact form.','aicontactform');?> <?php  _e(' <br/> OR  You can add <strong> < ? php do_shortcode("[ai_contact_form]"); ? ></strong> shortcode in any template.','aicontactform');?> </td>
          </tr>
          <tr>
            <td colspan="2"><br />
              <input class="button-primary" type="submit" value="<?php _e('Save Changes','aicontactform');?>" onclick="return validate(this.form);"></td>
          </tr>
        </tbody>
      </table>
    </form>
  </div>
</div>
<script>
function validate(frm)
{ 
	with(frm)
	{
		var result = email_address_setting.value.split(","); 
		for(var i = 0;i < result.length;i++) 
		{
			var regex = /^[\w]+(\.[\w]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/ ;
			if(!regex.test(result[i]))
			{
				alert('Please enter valid email address separated by comma(,) and without whitespace in it.');
				email_address_setting.focus(); 
				return false;  
			}
		}
		return true;
	}
}
</script>
<?php } ?>