<?php
	global $wpdb;
	$table_name = $wpdb->prefix . "ai_contact";
	$info=$_GET["info"];
	if($info=="del")
	{
		$delid=$_GET["did"];
		
		$wpdb->query("delete from ".$table_name." where `user_id`=".$delid);
		echo "<div style='clear:both;'></div><div class='updated' id='message'><p><strong>User Record Deleted.</strong>.</p></div>";
	}
?>
<div class="wrap"> 
	<img src="<?php echo plugins_url();?>/responsive-contact-form/images/augustinfotech.jpg" class="icon32" />
	<h2><?php _e('List of User Records','aicontactform');?>
		<a class="button add-new-h2 dateshow" href="#">Export User Records</a>
	</h2>
	<form method="post" name="exportdate" id="exportdateform" action="<?php echo plugins_url();?>/responsive-contact-form/include/userlist_export.php" >	
         <div id="dateexport" style="display:none;width:100%;margin-bottom:10px;">
             <div class="form-wrap">
             <div style="float:left;">
           		  <label>From Date</label><input type="text" name="start_date" id="startdate" class="input-txt" value=""/><br/>(Format: MM-DD-YYYY)
             </div>
			 <div style="float:left;margin-left:50px;">
	             <label>To Date</label><input type="text" name="end_date" id="enddate" class="input-txt" value=""/><br/>(Format: MM-DD-YYYY)
             </div>
             <div style="float:left;margin-left:50px;margin-top:22px;">
	             <input type="submit" value="Go" class="button add-new-h2 checkdate" id="submit" name="submit"/>
	             <a class="button add-new-h2 checkcancel" href="#">Cancel</a>
           	 </div>             
             </div>
         </div>
  	</form>
			<?php settings_fields( 'ai-fields' ); ?>	
			<table class="wp-list-table widefat fixed display" id="userlist">
			<caption style="color:#9CC;">Please click on column's title to sort the data according to specific column !!! </caption>
				<thead style="cursor: pointer;">
					<tr>
						<th style="width:50px;text-align:left;"><u>Sr. No</u></th>
						<th style="text-align:left;"><u>Username</u></th> 
						<th><u>Email Address</u></th>                                  
						<th style="width:95px;text-align:left;"><u>Contact Date</u></th>                              
						<th style="width:50px;text-align:center;">Action</th>
					</tr>
				</thead>
				<tbody>				     
					<?php
					$sql = $wpdb->get_results( "select * from ".$table_name." order by user_id DESC" );								
					$no = 1;
					if ( ! empty( $sql ) ) { ?>
						<script type="text/javascript">
							/* <![CDATA[ */
							jQuery(document).ready(function(){
								jQuery('#userlist').dataTable({ "aaSorting": [[ 0, "desc" ]]	});
								jQuery( "#startdate").datepicker();
								jQuery( "#enddate").datepicker();
							});
							jQuery('.dateshow').click(function(){
								jQuery('#dateexport').show();
							});
							jQuery('.checkdate').click(function(){
								if(jQuery('#startdate').val() == '' || jQuery('#enddate').val() == '')
								{
									alert("please select the date");
									return false;
								}
							});
							jQuery('.checkcancel').click(function(){
								var str='';
								jQuery('#dateexport').hide();
								jQuery('#startdate').val(str);
								jQuery('#enddate').val(str);
							});
							/* ]]> */						
						</script><?php
						foreach ( $sql as $user ) {
							$id        = $user->user_id;
							$username  = $user->username;
							$email     = $user->email_id;
							$date   = $user->contact_date; ?>
							<tr>
								<td style="width:40px;text-align:center;"><?php echo $no; ?></td>
								<td nowrap><?php echo urldecode($username); ?></td>
								<td nowrap><?php echo $email; ?></td> 
								<td style="text-align:center;"><?php echo $date; ?></td>                
								<td style="width:40px;text-align:center;">								
									<a onclick="javascript:return confirm('Are you sure, want to delete record of <?php echo $username; ?>?')" href="admin.php?page=ai_user_list&info=del&did=<?php echo $id;?>">
									<img src="<?php echo plugins_url(); ?>/responsive-contact-form/images/delete.png" title="Delete" alt="Delete" style="height:18px;" />
									</a>
								</td>                
							</tr>
						<?php $no += 1;							
						}
					} else {
						echo 'No User Records Found !!! ';
					} ?>					
				</tbody>
			</table>
</div>			