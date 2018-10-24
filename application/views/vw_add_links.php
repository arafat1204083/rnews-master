<!DOCTYPE html>
<html lang="en">
<!-- Main content-->
<?php 
 	echo form_open('Admin/update_link');
 	foreach ($link as $value) {
?>
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

<?php
	echo'
				<div class="cat">
				<h3>Add links</h3>
			  <div class="row" style="margin-top:20px;">
			  <div class="col-sm-9">
			  <div class="row">
				<div class="col-sm-4 form-group">
				  <h4>Facebook:</h4>
				</div>
				<div class="col-sm-8 form-group">
				  <input type ="hidden" name="link_id" value="'.$value->link_id.'">
				  <input class="form-control" id="name" name="link_fb" placeholder="facebook link here" type="text" value="'.$value->link_fb.'">
				</div>
			  </div> 
			  
			  <div class="row">
				<div class="col-sm-4 form-group">
				  <h4>Twitter:</h4>
				</div>
				<div class="col-sm-8 form-group">
				  <input class="form-control" id="name" name="link_twt" placeholder="twitter link here" type="text" value="'.$value->link_twt.'">
				</div>
			  </div> 
			  
			  <div class="row">
				<div class="col-sm-4 form-group">
				  <h4>Google plus:</h4>
				</div>
				<div class="col-sm-8 form-group">
				  <input class="form-control" id="name" name="link_google" placeholder="google+ link here" type="text" value="'.$value->link_google.'">
				</div>
			  </div> 
			  
			  <div class="row">
				<div class="col-sm-4 form-group">
				  <h4>Linkedin:</h4>
				</div>
				<div class="col-sm-8 form-group">
				  <input class="form-control" id="name" name="link_linkedin" placeholder="linkedin link here" type="text" value="'.$value->link_linkedin.'">
				</div>
			  </div> 
			  
			  <div class="row">
				<div class="col-sm-4 form-group">
				  <h4>Youtube:</h4>
				</div>
				<div class="col-sm-8 form-group">
				  <input class="form-control" id="name" name="link_utube" placeholder="youtube link here" type="text" value="'.$value->link_utube.'">
				</div>
			  </div> 
			  
			  <div class="row">
			  <button class="btn btn-primary pull-right" type="submit" style="margin-right:15px;"> Submit </button>
			  </div>
			';  
		}
	echo form_close();
	?>		  
			  <p class="notice"> *These links will be added to the social icons at your page's footer.</p>
			 
		
			  </div>
			  <div class="col-sm-3 form-group">
				</div>
			  </div>
			  
				
				</div>
		</div>