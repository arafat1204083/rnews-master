<!DOCTYPE html>
<html lang="en">

				 <!-- Main COntents-->

			<?php
				echo form_open_multipart('Admin/add_profile');
			?>
				<div class="cat">
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
				<h3>Add an admin</h3>
			  <div class="row">
			  <div class="col-sm-9">
			  <div class="row">
				<div class="col-sm-4 form-group">
				  <h4>Name:</h4>
				</div>
				<div class="col-sm-8 form-group">
				  <input class="form-control" id="name" name="admin_name" placeholder="Name" type="text" required>
				</div>
			  </div> 
			  <div class="row">
				<div class="col-sm-4 form-group">
				  <h4>Username:</h4>
				</div>
				<div class="col-sm-8 form-group">
				<div class="alert-danger ">
				<?php
				 echo form_error('admin_username'); 
				?>
				</div>
				  <input class="form-control" id="name" name="admin_username" placeholder="Username" type="text" required>
				</div>
			  </div> 
			  
			  <div class="row">
				<div class="col-sm-4 form-group">
				  <h4>Password:</h4>
				</div>
				<div class="col-sm-8 form-group">
				<div class="alert-danger ">
				<?php
				 echo form_error('admin_password'); 
				?>
				</div>
				  <input class="form-control" id="password" name="admin_password" placeholder="Password" type="password" required>
				</div>
			  </div> 
			  <div class="row">
				<div class="col-sm-4 form-group">
				  <h4>Re-enter Password:</h4>
				</div>
				<div class="col-sm-8 form-group">
				<div class="alert-danger ">
				<?php
				 echo form_error('admin_passconf'); 
				?>
				</div>
				  <input class="form-control" id="re-pass" name="admin_passconf" placeholder="Password" type="password" required>
				</div>
			  </div> 
			 <div class="row">
				<div class="col-sm-4 form-group">
				  <h4>Email:</h4>
				</div>
				<div class="col-sm-8 form-group">
				<div class="alert-danger ">
				<?php
				 echo form_error('admin_email'); 
				?>
			    </div>
				  <input class="form-control" id="mail" name="admin_email" placeholder="Email" type="email" required>
				</div>
			  </div> 
			 <div class="row">
				<div class="col-sm-4 form-group">
				  <h4>Designation:</h4>
				</div>
				<div class="col-sm-8 form-group">
				    <select name="admin_designation" style="width:100%; padding:6px 10px;">
						<option value="" style="display:none">Select Designation</option>
						<option value="Editor">Editor</option>
						<option value="Admin">Admin</option>';
				    </select><br>
				</div>
			  </div> 
			  
			   <!-- Right side photo showing portion -->
			  <div class="row">
				<div class="col-sm-4 form-group">
				  <h4>Add a photo</h4>
				</div>
				<div class="col-sm-8 form-group">
					<input id="a" name="admin_photo" placeholder="Add a photo" type="file">
			    </div>
			  </div> 
			 <p class="notice"> *Be sure before adding one more admin to your page. Because, (s)he will get the full power to change page layout, contents and everything else. It is for your page's safety.</p>
			  </div>
			  
			  <!-- Right side photo showing portion -->
			  <div class="col-sm-3 form-group">
				 
				
				<!--remove admin-->
				<div class="row">
				<ul class="cat" style="margin-top:-40px; margin-bottom:40px;">
				<h3>Remove an admin</h3>
				<?php
				foreach ($all_profile as $key => $value_all) {
					$id = $value_all->admin_id;
					$count = count($all_profile);
					$online = $this->session->userdata('admin_id');
					if($id != $online )
					{
				?>
				<li style="margin:15px; list-style:none;"><div class="col-sm-12"><img src="<?php echo base_url()?><?php echo $value_all->admin_photo?>" style="height:40px;" class="img-thumbnail img-responsive"><b style="font-size:16px"><?php echo $value_all->admin_name?> </b></div>
					<div class="col-sm-6 pull-left">
						<a id="<?php echo $id;?>" title="delete" onclick="return confirm('Are you sure want to delete the Profile?');" href="<?php echo base_url()?>Admin/admin_delete/<?php echo $id;?>" style="color:#a00; margin-left:15px;"> 
							remove 
						</a>
					</div>
				</li>
				<?php
					}
					if($count == 1 )
					{
				?>
						<li style="margin:15px; list-style:none;">
							<h4>No Admin to remove</h4>
						</li>
				<?php
					}		
				}
				?>
				</ul>
				</div>
				
				 <button class="btn btn-success" type="submit" style="width:100%;">Submit</button>
		<?php
			echo form_close();
		?> 
				</div>
			  </div>
			  
				
				</div>
		</div>
</body>
</html>