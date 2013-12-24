<?php

/*

Plugin Name: Responsive Contact Form

Plugin URI: http://www.augustinfotech.com

Description: Add Contact Form to your WordPress website.You can add [ai_contact_form] shortcode where you want to display contact form.OR You can add  do_shortcode("[ai_contact_form]"); shortcode in any template.

Version: 1.5

Text Domain: aicontactform

Author: August Infotech

Author URI: http://www.augustinfotech.com

*/

define('AI_PDIR_PATH',plugin_dir_path(__FILE__ ));

add_action('plugins_loaded', 'ai_contact_init');

/** Start Upgrade Notice **/
global $pagenow;
if ( 'plugins.php' === $pagenow )
{
    // Better update message
    $file   = basename( __FILE__ );
    $folder = basename( dirname( __FILE__ ) );
    $hook = "in_plugin_update_message-{$folder}/{$file}";
    add_action( $hook, 'update_notification_message', 20, 2 );
}
function update_notification_message( $plugin_data, $r )
{
    $data = file_get_contents( 'http://plugins.trac.wordpress.org/browser/responsive-contact-form/trunk/readme.txt?format=txt' );
	$upgradetext = stristr( $data, '== Upgrade Notice ==' );	
	$upgradenotice = stristr( $upgradetext, '*' );	
	$output = "<div style='color:#EEC2C1;font-weight: normal;background: #C92727;padding: 10px;border: 1px solid #eed3d7;border-radius: 4px;'><strong style='color:rgb(253, 230, 61)'>Update Notice : </strong> ".$upgradenotice."</div>";

    return print $output;
}
/** End Upgrade Notice **/


/* Activate Hook Plugin */

register_activation_hook(__FILE__,'ai_add_contact_table');

# Load the language files

function ai_contact_init(){

	load_plugin_textdomain( 'aicontactform', false, plugin_basename( dirname( __FILE__ )  . '/languages/' ));
}



add_action('admin_init', 'ai_register_fields' );

function ai_register_fields(){
	
	//wp_register_style( 'jquery-ui',  plugins_url('/responsive-contact-form/css/jquery-ui.css') );	
	//wp_register_style( 'jquery-ui',  '//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css' );	

	register_setting( 'ai-fields', 'ai_email_address_setting' );

	register_setting( 'ai-fields', 'ai_subject_text' );

	register_setting( 'ai-fields', 'ai_reply_user_message' );

	register_setting( 'ai-fields', 'ai_enable_captcha' );

	register_setting( 'ai-fields', 'ai_error_setting' );	

	register_setting( 'ai-fields', 'ai_visible_name' ); 

	register_setting( 'ai-fields', 'ai_enable_require_name' );

	register_setting( 'ai-fields', 'ai_visible_phone' ); 

	register_setting( 'ai-fields', 'ai_enable_require_phone' );

	register_setting( 'ai-fields', 'ai_visible_email' );

	register_setting( 'ai-fields', 'ai_visible_subject' );

	register_setting( 'ai-fields', 'ai_enable_require_subject' );

	register_setting( 'ai-fields', 'ai_visible_website' );

	register_setting( 'ai-fields', 'ai_enable_require_website' );

	register_setting( 'ai-fields', 'ai_visible_comment' );

	register_setting( 'ai-fields', 'ai_enable_require_comment' );
	
	register_setting( 'ai-fields', 'ai_visible_sendcopy' );

}

/*Uninstall Hook Plugin */

if( function_exists('register_uninstall_hook') ){

	register_uninstall_hook(__FILE__,'ai_contact_form_uninstall');			
}

function ai_contact_form_uninstall(){ 

	delete_option('ai_email_address_setting');

	delete_option('ai_enable_captcha');

	delete_option('ai_error_setting');

	delete_option('ai_subject_text');

	delete_option('ai_reply_user_message');

	delete_option('ai_visible_name');

	delete_option('ai_enable_require_name');

	delete_option('ai_visible_phone');

	delete_option('ai_enable_require_phone');

	delete_option('ai_visible_email');

	delete_option('ai_visible_subject');

	delete_option('ai_enable_require_subject');

	delete_option('ai_visible_website');

	delete_option('ai_enable_require_website');

	delete_option('ai_visible_comment');

	delete_option('ai_enable_require_comment');
		 
	delete_option('ai_visible_sendcopy');	 

	global $wpdb;	

	$ai_table_contact_drop = $wpdb->prefix . "ai_contact";  

	$wpdb->query("DROP TABLE IF EXISTS ".$ai_table_contact_drop);
}



add_shortcode('ai_contact_form', 'ai_shortcode');

function ai_shortcode(){

	include_once('include/ai-contact-form-template.php');
	return contactFormShortcode();
}



/* Make AI Contact Settings in Admin Menu Item*/

add_action('admin_menu','ai_contact_setting');



/*

* Setup Admin menu item

*/

function ai_contact_setting(){

	add_menu_page(__('AI Contact Form','aicontactform'),__('AI Contact Form','aicontactform'),'manage_options','ai_contact','ai_contact_settings','');
	global $page_options;
	$page_options = add_submenu_page('ai_contact', __('User List','aicontactform'), __('User List','aicontactform'),'manage_options', 'ai_user_lists', 'ai_user_list');
}

add_action('admin_enqueue_scripts', 'load_admin_scripts');
function load_admin_scripts($hook) {
	global $page_options;
	if( $hook != $page_options )
	return;
	wp_register_style( 'jquery-ui',  '//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css' );	
	wp_enqueue_style('jquery-ui');
}

function ai_add_contact_table(){	

	global $wpdb;

	$ai_table_contact = $wpdb->prefix . "ai_contact";			

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');	  

	$wpdb->query("DROP TABLE IF EXISTS ".$ai_table_contact);

	$ai_sql_contact = "CREATE TABLE IF NOT EXISTS $ai_table_contact (

	user_id int(10) NOT NULL AUTO_INCREMENT,

	username varchar(50) NULL,

	email_id varchar(255) NULL,
	
	message varchar(1000) NULL,

	contact_date date NULL,					  					  

	PRIMARY KEY (`user_id`)

	) ";

	dbDelta($ai_sql_contact);

}

function ai_contact_settings(){

	include AI_PDIR_PATH."/include/ai_settings.php";

}

function ai_user_list(){

	include AI_PDIR_PATH."/include/ai_user_list.php";

}

function ai_scripts(){

	wp_enqueue_script( 'ai_script', plugins_url( '/js/ai_script.js' , __FILE__ ) );		

	wp_enqueue_script( 'ai_script_table', plugins_url('/js/jquery.dataTables.js' , __FILE__), array( 'jquery' ) );

	wp_enqueue_script( 'jquery-ui', plugins_url('/js/jquery-ui.js' , __FILE__), array( 'jquery' ) );

	wp_enqueue_style('wp-datatable',  plugins_url('/responsive-contact-form/css/data_table.css'));

	//wp_enqueue_style('jquery-ui',  plugins_url('/responsive-contact-form/css/jquery-ui.css'));
	wp_enqueue_style('jquery-ui');

}  

add_action( 'admin_enqueue_scripts', 'ai_scripts' );

if(!is_admin()){

	wp_localize_script( 'my-ajax-request', 'MyAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );	

	wp_enqueue_script( 'my-ajax-request', plugins_url('/js/ajax.js' , __FILE__), array( 'jquery' ), '', true );

}



add_action('wp_ajax_ai_action', 'ai_action_call');

add_action('wp_ajax_nopriv_ai_action', 'ai_action_call');

function ai_action_call(){	

	global $wpdb;

	$data = $_POST['fdata'];
	$returndata = array();

	$strArray = explode("&", $data);

	$i = 0;

	foreach($strArray as $item){

		$array = explode("=", $item);

		$returndata[$array[0]] = $array[1];

	}

	foreach($returndata as $key => $val){

		if($key == 'ai_name'){

			$ai_name = urldecode($val);

		}elseif($key == 'ai_phone'){

			$ai_phone = urldecode($val);

		}elseif($key == 'ai_email'){

			$ai_email = urldecode($val);

		}elseif($key == 'ai_website'){

			$ai_website = urldecode($val);

		}elseif($key == 'ai_subject'){

			$ai_subject = urldecode($val);

		}elseif($key == 'ai_comment'){

			$ai_comment = urldecode($val);

		}elseif($key == 'ai_captcha'){

			$ai_captcha = urldecode($val);

		}elseif($key == 'ai_sendcopy'){

			$sendcopy = $val;

		}		
	}

	if(get_option('ai_email_address_setting')==''){

		$ai_emailadmin = get_option('admin_email');	

	}else{

		$ai_emailadmin = get_option('ai_email_address_setting');

	}

            

	if(get_option('ai_subject_text')==''){

		$ai_subtext = __('August Infotech','aicontactform');

	}else{

		$ai_subtext = get_option('ai_subject_text');

	}

	

	if(get_option('ai_reply_user_message')==''){

		$ai_reply_msg = __('Thank you for contacting us...We will get back to you soon...','aicontactform');

	}else{

		$ai_reply_msg = get_option('ai_reply_user_message');

	}	

	$arr = 1;

	$enable = get_option('ai_enable_captcha');	

	if($enable == 'on'){

		session_start();

		if(empty($_SESSION['captcha']) || (strcasecmp($_SESSION['captcha'], $ai_captcha) != 0) || trim($ai_captcha) == ''){ 	 

			$arr=2;

		}

	}

	

	// settings for mail received by user

	$ai_subject_mail = __('Reply : ','aicontactform').$ai_subtext;			

	$ai_headers = "MIME-Version: 1.0\n";

	$ai_headers .= "Content-type: text/html; charset=iso-8859-1\n";

	$ai_headers .= "From:".get_bloginfo('name')." ".$ai_emailadmin."\n";

	$ai_headers .= "Message-Id: <".time()."@".$_SERVER['SERVER_NAME'].">\n";

	$ai_headers .= "X-Mailer: php-mail-function-0.2\n";

	

	// settings for mail received by admin			

	

	$ai_admin_usermsg = "<table><tr><td colspan='2'><b>".__('User Details','aicontactform')."</b></td><tr/><tr><td colspan='2' height='40%'></td></tr>";

	

	if(esc_attr(get_option('ai_visible_name'))=="on" && $ai_name != ''){

		$ai_admin_usermsg .= "<tr><td align='left' width='80px'>".__('Name :','aicontactform')."</td><td>".$ai_name."</td></tr>";

	} 

						

	$ai_admin_usermsg .= "<tr><td align='left' width='80px'>".__('Email ID :','aicontactform')." </td><td>".$ai_email."</td></tr>";

						

	if(esc_attr(get_option('ai_visible_phone'))=="on" && $ai_phone != ''){

		$ai_admin_usermsg .= "<tr><td align='left' width='70px'>".__('Phone :','aicontactform')."</td><td>".$ai_phone."</td></tr>";

	}

						

	if(esc_attr(get_option('ai_visible_website'))=="on" && $ai_website != ''){

		$ai_admin_usermsg .= "<tr><td align='left' width='80px'>".__('Website Url :','aicontactform')."</td><td>".$ai_website."</td></tr>";

	}

						

	if(esc_attr(get_option('ai_visible_subject'))=="on" && $ai_subject != ''){ 

		$ai_admin_usermsg .= "<tr><td align='left' width='80px'>".__('Subject :','aicontactform')." </td><td>".$ai_subject."</td></tr>";

	}

						

	if(esc_attr(get_option('ai_visible_comment'))=="on" && $ai_comment != ''){ 

		$ai_admin_usermsg .= "<tr><td align='left' valign='top' width='70px'>".__('Comment : ','aicontactform')."</td><td>".$ai_comment."</td></tr></table>";		

	}

	

	if($ai_name == ''){	$ai_name = 'User';}

	$ai_admin_subject = $ai_name.__(' has contact us','aicontactform');		

						

	$ai_admin_headers = "MIME-Version: 1.0\n";

	$ai_admin_headers .= "Content-type: text/html; charset=iso-8859-1\n";	

	//$ai_admin_headers .= "From: ".str_replace(' ', '-', $ai_name)."\n";
	$ai_admin_headers .= "From: ".str_replace(' ', '-', $ai_name)." ".$ai_email."\n";

	$ai_admin_headers .= "Message-Id: <".time()."@".$_SERVER['SERVER_NAME'].">\n";

	$ai_admin_headers .= "X-Mailer: php-mail-function-0.2\n";

	$ai_usercopy_subject = __('Copy of form submitted','aicontactform');

	if($arr == 1){		

		mail($ai_email, $ai_subject_mail, $ai_reply_msg, $ai_headers);
		if($sendcopy == 1){
			mail($ai_email, $ai_usercopy_subject, $ai_admin_usermsg, $ai_admin_headers);
		}

		mail($ai_emailadmin, $ai_admin_subject, $ai_admin_usermsg, $ai_admin_headers);

		$date = date("Y-m-d");

		$table_name = $wpdb->prefix."ai_contact";

		$date = current_time( 'mysql' );

		if($ai_name != 'User' && $ai_name != ''){

			$wpdb->insert( $table_name, array("username" => urlencode($ai_name), "email_id" => $ai_email, "message" => $ai_comment, "contact_date" => $date ));

		}else{

			$wpdb->insert( $table_name, array("email_id" => $ai_email, "message" => $ai_comment, "contact_date" => $date ));

		}	

	}

	echo json_encode($arr);	

	die(); 	

}
?>