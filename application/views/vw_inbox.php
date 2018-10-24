<!DOCTYPE html>
<html lang="en">

				 <!-- Main content-->
				<div class="col-xs-10 content">
					<?php
				if($msg!='')
				{
				?>
				<div class="alert alert-<?php echo $msg_type;?> alert-dismissable"> 
					<button type="button" class="close" data-dismiss="alert" 
                                aria-hidden="true">
                                &times;
                              </button>
					<?php echo $msg;?>
					</div>
				<?php
				}
				?>
				<div class="cat">
				<div class="row">
				<div class="col-sm-9">
					<h3>Inbox</h3>
				<?php
			
				$read = count($inbox_count);
				$unread = $inbox_total-$read;
				if($inbox_total==0)
					{
						echo'<p class="notice">There is no message to show!!</p>';
					}
					echo form_open('Admin/remove_checked');
				?>
						<ul class="inbox">
						<?php
						foreach ($inbox as $key => $value) {
							
							if($value->inbox_seen == 0)
							{
								$status = "unread";
							}
							else{
								$status = "read";
							}?>
							<?php
							$original_string = $value->inbox_message;
							$num_words = 13;
							$words = array();
							$words = explode(" ", $original_string, $num_words);
							$shown_string = "";

							if(count($words) == 13){
							   $words[12] = " ... ";
							}

							$shown_string = implode(" ", $words);	
							
							?>

							<li class="<?php echo $status;?>"><input type="checkbox" name="msg[]" value="<?php echo $value->inbox_id; ?>" data-toggle="toggle" style="margin:3px 5px;"><a href="#msg_<?php echo $value->inbox_id;?>" data-toggle="modal" data-target="#msg_<?php echo $value->inbox_id;?>" onclick="">Message from <?php echo $value->inbox_email;?> - <?php echo $shown_string;?></a></li>
						<?php
						}
						?>
											
						</ul>
						<?php echo $this->pagination->create_links(); ?>
				<?php
				foreach ($inbox as $key => $value1) {
			// j=01(date),l=(day),g=(hour),i=(minute) a=(am/pm)
			
			$date = strtotime($value1->inbox_date);
			$formated_date = date('j M, Y, g:i A',$date) ;
			
					echo'	<!--MODAL-->
							<div id="msg_'.$value1->inbox_id.'" class="modal fade " role="dialog">
							  <div class="modal-dialog">

								<!-- Modal content-->
								<div class="modal-content">
								  <div class="modal-header">';?>
									<button type="button" class="close" data-dismiss="modal" onclick="window.location='<?php echo base_url();?>Admin/seen/<?php echo $value1->inbox_id;?>'" >&times;</button>
							<?php echo'	
									<h4 class="modal-title black1">From: '.$value1->inbox_email.'</h4>
									<h5 class="modal-title black1"> '.$formated_date.'</h5>
								  </div>
								  <div class="modal-body">
								    <b>Name: '.$value1->inbox_name.'</b><br><br>
									<p>'.$value1->inbox_message.'</p>
								  </div>
								  <div class="modal-footer">';
								  ?>
								<button onclick ="window.location='<?php echo base_url();?>Admin/seen/<?php echo $value1->inbox_id;?>'"  type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
								  </div>
								</div>

							  </div>
							</div>
				<?php
					}
				?>

				</div>
				<?php
					if($inbox_total!=0){
				?>
				
				 <!-- Right side message info showing and delete option providing portion-->
						<div class="col-sm-3" style="margin-top:40px; padding-left:40px;">
							<ul class="list-group inbox-del">
								  <li class="list-group-item list-group-item-success">Inbox: <?php echo $inbox_total;?></li>
								  <li class="list-group-item list-group-item-info">Read: <?php echo $read;?></li>
								  <li class="list-group-item list-group-item-danger">Unread: <?php echo $unread;?></li>
								</ul>
						
							<div class="btn-group inbox-del">
								
								<?php echo form_submit('delete', 'Delete',array('class' => 'btn btn-danger del-half')); ?>
								<button type="button" class="btn btn-danger del-half"> <a  style="text-decoration:none!important;color:white;" href="<?php echo base_url();?>Admin/delete_all" onclick="return confirm('Are you sure?');">Delete all </a></button>
							</div>
							
							<p class="notice">* Check all the messages you want to delete and then press delete button. In order to delete all the messages, click the delete all button.</p>
						</div>
				<?php
					}
				?>
						</div>
				</div>
		</div>
</body>
</html>