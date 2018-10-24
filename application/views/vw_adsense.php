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
				<h3>Google AdSense</h3>
			  <div class="row">
			  <div class="col-sm-8" style="padding-right:25px;">
			  <div class="row">
				
			<?php
				 echo form_open_multipart('Admin/adsense_code');
			foreach ($adsense as $key => $value) {
				$advert_st = "";
						if($value->adsense_status==1)
						{
							$advert_st = "checked";
						}
							
			?>
			<input type ="hidden" name ="adsense_id" value="<?php echo $value->adsense_id;?>">
				
			  
			  <div class="row">
				<div class="col-sm-3 form-group">
				  <h4>AdSense Code</h4>
				</div>
				<div class="col-sm-9 form-group">
				  <textarea  class="form-control" id="name" name="adsense_code" placeholder="AdSense Code" type="text"  rows="6"><?php echo $value->adsense_code;?> </textarea><br>
				</div>
			  </div> 
			  
			<h4><input type="checkbox" <?php echo $advert_st;?> data-toggle="toggle" name="adsense_status" style="margin:3px 5px;" value="1"> Enable Google AdSense</h4>
			  
			 <div class="row">
			  <button class="btn btn-primary pull-right" type="submit" style=" margin-top:15px;"> Submit </button>
			  </div> 
			   <p class="notice"> *Create your Google AdSense account.Copy your code and paste here.If you don't want to have advertisement than uncheck 'Enable Google AdSense' button</p>
			
			 <?php
		echo form_close();

				
			}
			?>
			  </div>
			  
			  
			  
			
</body>
</html>