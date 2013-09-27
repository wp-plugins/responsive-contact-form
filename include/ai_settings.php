<style>

	#form-settings { width: 50%; }

	#form-settings .field-name{ font-weight: bold; width: 60px; text-align: right; }

	#form-settings .field-status{ width: 60px; text-align: center; }		

	#email-settings { border-top: 5px solid #dfdfdf; }

	#email-settings th { width: 140px; }	

</style>

<div class="wrap">

	<img src="<?php echo plugins_url();?>/responsive-contact-form/images/augustinfotech.jpg" class="icon32" />

	<h2><?php _e('Responsive Contact Form Settings','aicontactform');?></h2>

	<div class="postbox" id="poststuff">

		<h3 class="title"><?php _e('Settings','aicontactform');?></h3>

		<form method="post" action="options.php" name="AIGolbalSiteOptions">

			<?php settings_fields( 'ai-fields' ); ?>

			<table class="form-table" id="form-settings">

				<tbody>

					<tr>

						<td colspan="3"></td>                        

					</tr> 

					<tr>

						<th class="field-name"><?php _e('<strong>Field Name</strong>','aicontactform');?></th>

						<th class="field-status"><?php _e('<strong>Select to Show / Hide Fields on form</strong>','aicontactform');?></th>

						<th><?php _e('<strong>Required / Not Required Fields</strong>','aicontactform');?></th> 

					</tr>        

					<tr>

						<th class="field-name"><?php _e('Name:','aicontactform');?></th>

						<td class="field-status">

							<input type="checkbox" name="ai_visible_name" onclick="validate_name()" id="ai_visible_name" <?php if(esc_attr(get_option('ai_visible_name'))=="on"){echo "checked";} ?>  />              				

						</td>

						<td>

							<input type="checkbox" name="ai_enable_require_name" <?php if(esc_attr(get_option('ai_visible_name'))==""){ echo 'disabled="disabled"';} ?> id="ai_enable_require_name" <?php if(esc_attr(get_option('ai_enable_require_name'))=="on"){echo "checked";} ?>  />              				

						</td>

					</tr>

					<tr>

						<th class="field-name"><?php _e('Phone:','aicontactform');?></th>

						<td class="field-status">

							<input type="checkbox" name="ai_visible_phone" onclick="validate_phone()" id="ai_visible_phone" <?php if(esc_attr(get_option('ai_visible_phone'))=="on"){echo "checked";} ?>  />              				

						</td>

						<td>

							<input type="checkbox" name="ai_enable_require_phone" <?php if(esc_attr(get_option('ai_visible_phone'))==""){ echo 'disabled="disabled"';} ?> id="ai_enable_require_phone" <?php if(esc_attr(get_option('ai_enable_require_phone'))=="on"){echo "checked";} ?>  />              				

						</td>

					</tr>            

					<tr>

						<th class="field-name"><?php _e('Website:','aicontactform');?></th>

						<td class="field-status">

							<input type="checkbox" name="ai_visible_website" onclick="validate_website()" id="ai_visible_website" <?php if(esc_attr(get_option('ai_visible_website'))=="on"){echo "checked";} ?>  />          				

						</td>

						<td>

							<input type="checkbox" name="ai_enable_require_website" <?php if(esc_attr(get_option('ai_visible_website'))==""){ echo 'disabled="disabled"';} ?> id="ai_enable_require_website" <?php if(esc_attr(get_option('ai_enable_require_website'))=="on"){echo "checked";} ?>  />              				

						</td>

					</tr>

					<tr>

						<th class="field-name"><?php _e('Subject:','aicontactform');?></th>

						<td class="field-status">

							<input type="checkbox" name="ai_visible_subject" onclick="validate_subject()" id="ai_visible_subject" <?php if(esc_attr(get_option('ai_visible_subject'))=="on"){echo "checked";} ?>  />         				

						</td>

						<td>

							<input type="checkbox" name="ai_enable_require_subject" <?php if(esc_attr(get_option('ai_visible_subject'))==""){ echo 'disabled="disabled"';} ?> id="ai_enable_require_subject" <?php if(esc_attr(get_option('ai_enable_require_subject'))=="on"){echo "checked";} ?>  />              				

						</td>

					</tr>

					<tr>

						<th class="field-name"><?php _e('Comment:','aicontactform');?></th>

						<td class="field-status">

							<input type="checkbox" name="ai_visible_comment" onclick="validate_comment()" id="ai_visible_comment" <?php if(esc_attr(get_option('ai_visible_comment'))=="on"){echo "checked";} ?>  />              				

						</td>

						<td>

							<input type="checkbox" name="ai_enable_require_comment" <?php if(esc_attr(get_option('ai_visible_comment'))==""){ echo 'disabled="disabled"';} ?> id="ai_enable_require_comment" <?php if(esc_attr(get_option('ai_enable_require_comment'))=="on"){echo "checked";} ?>  />              				

						</td>

					</tr>

					<tr>

						<th class="field-name"><?php _e('Captcha:','aicontactform');?></th>

						<td class="field-status">

							<input type="checkbox" name="ai_enable_captcha" id="ai_enable_captcha" <?php if(esc_attr(get_option('ai_enable_captcha'))=="on"){echo "checked";} ?>  />                                

						</td>

						<td><?php _e('<strong>Note: </strong>Enable captcha sets by default it to required field.','aicontactform');?>							

						</td>

					</tr>

					<tr>

						<th class="field-name"><?php _e('Email:','aicontactform');?></th>

						<td class="field-status">

							<input type="checkbox" name="ai_visible_email" onclick="validate_email()" id="ai_visible_email" checked="checked" disabled="disabled" />                             				

						</td>

						<td><?php _e('<strong>Note: </strong>Email field is mandatory.','aicontactform');?></td>

					</tr>
					<tr>

						<th class="field-name"><?php _e('Send me a copy:','aicontactform');?></th>

						<td class="field-status">

							<input type="checkbox" align="left" name="ai_visible_sendcopy" id="ai_visible_sendcopy" <?php if(esc_attr(get_option('ai_visible_sendcopy'))=="on"){echo "checked";} ?>  />              				

						</td>
						<td><?php _e('<strong>Note: </strong>Select to show checkbox on form.','aicontactform');?></td>					       				

					</tr>

					<tr>

						<td colspan="3"></td>                        

					</tr>            

				</tbody>

			</table>            

			<table class="form-table" id="email-settings">

				<tbody>

					<tr>

						<td colspan="3"></td>                        

					</tr> 

					<tr>

						<th><label for="ai_email_address_setting"><?php _e('Email Address:','aicontactform');?></label></th>

						<td>

							<input type="text" name="ai_email_address_setting" class="regular-text" value="<?php echo esc_attr(get_option('ai_email_address_setting'));?>">							

						</td>

						<td>

							<?php _e('<strong>Note:</strong> You can add multiple email addresses seperated by comma, to send email to multiple users.','aicontactform');?>

						</td>

					</tr>

					<tr>

						<th><label for="ai_subject_text"><?php _e('Subject Text:','aicontactform');?></label></th>

						<td>

							<input type="text" name="ai_subject_text" class="regular-text" value="<?php echo esc_attr(get_option('ai_subject_text'));?>">      				

						</td>

						<td>

							<?php _e('<strong>Note:</strong> Default subject text " August Infotech " will be used.','aicontactform');?>

						</td>

					</tr>

					<tr>

						<th><label for="ai_reply_user_message"><?php _e('Reply Message for User:','aicontactform');?></label></th>

						<td>

							<?php /* <input type="text" name="ai_reply_user_message" class="regular-text" value="<?php echo esc_attr(get_option('ai_reply_user_message'));?>"> */?>

							<textarea name="ai_reply_user_message" rows="5" cols="49" class="regular-text"><?php echo esc_attr(get_option('ai_reply_user_message'));?></textarea>              				           				

						</td>

						<td>

							<?php _e('<strong>Note:</strong> Default Reply Message " Thank you for contacting us...We will get back to you soon... " will be used.','aicontactform');?> 

						</td>

					</tr> 

					<tr>

						<td colspan="3"></td>                        

					</tr>  

					<tr>

						<td colspan="3">

							<input class="button-primary" type="submit" value="<?php _e('Save All Changes','aicontactform');?>">

						</td>

					</tr>

					<tr>

						<td colspan="3" align="center">

							<?php _e('<strong>Note:</strong> You can add <strong> [ai_contact_form] </strong> shortcode where you want to display contact form in pages.','aicontactform');?>              				

							<?php  _e(' <br/> OR  You can add <strong> &lt;&#63;php do_shortcode("[ai_contact_form]"); &#63;&gt;</strong> shortcode in any template.','aicontactform');?>

							<?php  _e(' <br/> OR  You can add <strong> &lt;&#63;php echo do_shortcode("[ai_contact_form]"); &#63;&gt;</strong> shortcode in any template.','aicontactform');?>

						</td>

					</tr> 

					<tr>

						<td colspan="3"></td>                        

					</tr>

				</tbody>

			</table>		

		</form>

	</div>

</div>