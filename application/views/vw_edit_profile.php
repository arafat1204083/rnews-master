<!DOCTYPE html>
<html lang="en">

				
				 <!-- Main content-->

		
		<?php
		echo form_open_multipart('Admin/profile_update','class="form-horizontal"');
		foreach ($profile as  $value2) {
		
		  	
							  					
		echo'
			<input type="hidden" name="admin_id" value="'.$value2->admin_id.'">
				<div class="col-xs-10 content">
				<div class="cat">';
		?>
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
		echo'
				<h3>Edit Profile</h3>
				
				
			  <div class="row">
			  <div class="col-sm-9">
			  <div class="row">
				<div class="col-sm-4 form-group">
				  <h4>Name:</h4>
				</div>
				<div class="col-sm-8 form-group">
				  <input class="form-control"  name="admin_name" value="'.$value2->admin_name.'" placeholder="Name" type="text" required>
				</div>
			  </div> 
			    <div class="row">
				<div class="col-sm-4 form-group">
				  <h4>Username:</h4>
				</div>
				<div class="col-sm-8 form-group">
				<div class="alert-danger ">';

				 echo form_error('admin_username'); 
				 echo'
				  </div>
				  <input class="form-control"  name="admin_username" value="'.$value2->admin_username.'" placeholder="Name" type="text" required>
				</div>
			  </div>
			  
			  <div class="row">
				<div class="col-sm-4 form-group">
				  <h4>Old Password:</h4>
				</div>
				<div class="col-sm-8 form-group">
				  <input class="form-control" id="password" name="admin_old_password" placeholder="Password" type="password" required>
				</div>
			  </div> 
			  <div class="row">
				<div class="col-sm-4 form-group">
				  <h4>New Password:</h4>
				</div>
				<div class="col-sm-8 form-group">
				<div class="alert-danger ">';
				 echo form_error('admin_password'); 
				 echo'
				</div>
				  <input class="form-control" id="re-pass" name="admin_password" placeholder="Password" type="password" required>
				</div>
			  </div> 
			 <div class="row">
				<div class="col-sm-4 form-group">
				  <h4>Re-type New Password:</h4>
				</div>
				<div class="col-sm-8 form-group">
				<div class="alert-danger ">';
				echo form_error('admin_passconf'); 
				echo'
				</div>
				  <input class="form-control" id="pass-re" name="admin_passconf" placeholder="password" type="password" required>
				</div>
			  </div> 
			  <div class="row">
				<div class="col-sm-4 form-group">
				  <h4>Email:</h4>
				</div>
				<div class="col-sm-8 form-group">
				<div class="alert-danger ">';
				 echo form_error('admin_email'); 
				 echo'
				 </div>
				  <input class="form-control" id="mail" name="admin_email" value="'.$value2->admin_email.'"placeholder="email" type="email">
				</div>
			  </div> 
			  
			 <div class="row">
				<div class="col-sm-4 form-group">
				  <h4>Designation:</h4>
				</div>
				<div class="col-sm-8 form-group">
				  <p class="form-control" id="dsgntn">'.$value2->admin_designation.'</p>
				</div>
			  </div> 
			  
			   <!-- Right side image showing portion-->
			  <div class="row">
				<div class="col-sm-4 form-group">
				  <h4>Change photo</h4>
				</div>
				<div class="col-sm-8 form-group">
					<input id="a" name="admin_photo" placeholder="Add a photo" type="file">
			    </div>
			  </div>
			  
			   <p class="notice"> *Check twice before completing editing profile. Having trouble with editing profile? Forgot password? <a href="">click here</a></p>
			 
			  </div>
			  <div class="col-sm-3 form-group">';
			 ?>
			  <img src="<?php echo base_url()?><?php echo $value2->admin_photo?>" class="img-responsive">
				  <button class="btn btn-success" type="submit" style="width:100%; margin-top:15px;">Update</button>
				</div>
			  </div>
			  
				
				</div>
		</div>
</body>
<?php
}
echo form_close();
?>
</html>