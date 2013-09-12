<?php	
	$enable = $_POST['ai_enable_captcha'];	
	
	$arr = 1;
	if($enable == 'on'){
		session_start();
		if(empty($_SESSION['captcha']) || (strcasecmp($_SESSION['captcha'], $_POST['ai_captcha']) != 0) || trim($_POST['ai_captcha']) == '')
		{ 	 
			$arr=2;
		}
	}
	$subtext = $_POST['ai_subject_text'];
	$ai_emailadmin = $_POST['ai_email_address_setting'];
	$blogname = $_POST['blog_name'];			
	$ai_name = $_POST['ai_name'];			
	$ai_phone = $_POST['ai_phone'];
	$ai_email = $_POST['ai_email'];
	$ai_comment = $_POST['ai_comment'];			
	
	// settings for mail received by user
	$ai_subject = 'Reply : '.$subtext;			
	$ai_messagereply = 'Thank you for contacting us...We will get back to you soon...';					
	$ai_headers = "MIME-Version: 1.0\n";
	$ai_headers .= "Content-type: text/html; charset=iso-8859-1\n";
	$ai_headers .= "From:".$blogname." ".$ai_emailadmin."\n";
	$ai_headers .= "Message-Id: <".time()."@".$_SERVER['SERVER_NAME'].">\n";
	$ai_headers .= "X-Mailer: php-mail-function-0.2\n";
	
	// settings for mail received by admin
	$ai_admin_subject = $ai_name.' has contact us';					
	$ai_admin_usermsg = "<table><tr><td colspan='2'><b>User Details</b></td><tr/><tr><td colspan='2' height='40%'></td></tr>";
	$ai_admin_usermsg .= "<tr><td align='left' width='70px'>Name : </td><td>".$ai_name."</td></tr>";
	$ai_admin_usermsg .= "<tr><td align='left' width='70px'>Email id : </td><td>".$ai_email."</td></tr>";
	$ai_admin_usermsg .= "<tr><td align='left' width='70px'>Phone No : </td><td>".$ai_phone."</td></tr>";
	$ai_admin_usermsg .= "<tr><td align='left' valign='top' width='70px'>Message : </td><td>".$ai_comment."</td></tr></table>";		
	$ai_admin_headers = "MIME-Version: 1.0\n";
	$ai_admin_headers .= "Content-type: text/html; charset=iso-8859-1\n";
	$ai_admin_headers .= "From: ".$ai_name."\n";
	$ai_admin_headers .= "Message-Id: <".time()."@".$_SERVER['SERVER_NAME'].">\n";
	$ai_admin_headers .= "X-Mailer: php-mail-function-0.2\n";
	if($arr == 1){		
		mail($ai_email, $ai_subject, $ai_messagereply, $ai_headers);
		mail($ai_emailadmin, $ai_admin_subject, $ai_admin_usermsg, $ai_admin_headers);
	}
	echo json_encode($arr) ;
?>