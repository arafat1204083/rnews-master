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
				<h3>Publish a News</h3>
			  <div class="row">
			  <div class="col-sm-8" style="padding-right:25px;">
			  <div class="row">
				<div class="col-sm-3 form-group">
				  <h4>Headline</h4>
				</div>
			<?php
				 echo form_open_multipart('Admin/news_publish');
			?>
				<div class="col-sm-9 form-group">
				  <input class="form-control" id="name" name="news_headline" placeholder="Headline" type="text" required>
				</div>
			  </div> 
			  
			  <div class="row">
				<div class="col-sm-3 form-group">
				  <h4>Content</h4>
				</div>
				<div class="col-sm-9 form-group">
				  <textarea  class="form-control" id="name" name="news_content" placeholder="content" type="text"  rows="6"> </textarea><br>
				</div>
			  </div> 
			  
			<!--  <div class="row">
				<div class="col-sm-3 form-group">
				  <h4>Tags</h4>
				</div>
				<div class="col-sm-9 form-group">
				  <input class="form-control" id="tags" name="news_tags" placeholder="tags" type="text" required>
				</div>
			  </div> 
			 --> 
			  <div class="row">
				<div class="col-sm-3 form-group">
				  <h4>Select category</h4>
				</div>
				<div class="col-sm-9 form-group">
				    <select name="news_category_fkey" style="width:100%;margin-top:10px; padding:3px 10px;">
				    <option value="" style="display:none">Select Category</option>
			<?php
			foreach ($category as $value) {
				echo '<option value="'.$value->category_id.'" >'.$value->category_name.'</option>';
			}
					  
			?>		  
					</select>
				</div>
			  </div> 
			  
			  
			  <div class="row">
				<div class="col-sm-3 form-group">
				  <h4>Add a photo</h4>
				</div>
				<div class="col-sm-9 form-group">
					<input id="a" name="news_photo" placeholder="Add a photo" type="file">
			    </div>
			  </div>
			  
			   <p class="notice"> *Give proper title, tags and add a relevant photo to your post. All these will help you to get more traffic to your web site.</p>
			<div class="row">
			  <button class="btn btn-primary pull-right" type="submit" style=" margin-top:15px;"> Publish </button>
			  </div>
			 <?php
		echo form_close();
		?>
			  </div>
			  
			   <!-- Showing all news titles-->
			  <div class="col-sm-4 form-group" style="padding-left:15px; border-left:1px dotted #ccc;">
			  <h3 style="margin-top:-25px; margin-bottom:15px; margin-left:10px;"class="col-sm-11">All news</h3>
		<?php
		foreach ($news as $value1) {
			if($value1->news_visitor>=100)
			{
				$color = 'danger';
			}
			else if($value1->news_visitor>=50)
			{
				$color = 'warning';
			}
			else if($value1->news_visitor>=20)
			{
				$color = 'success';
			}
			else
			{
				$color = 'info';
			}
			$id=$value1->news_id;
				echo'<div class="row" style="padding:20px 0px 0px ">
					<div class="col-xs-11">
					<a href="#news_'.$id.'" data-toggle="modal" data-target="#news_'.$id.'"><h4 class="cont-head">'.$value1->news_headline.'<span class="label label-'.$color.'">'.$value1->news_visitor.'</span></h4></a>
					</div>
					<div class="col-xs-1">';
					?>
					 <a id="<?php echo $id;?>" style="color:red;"title="delete" onclick="return confirm('Are you sure want to delete this news?');" href="<?php echo base_url()?>Admin/news_delete/<?php echo $id;?>">  x </a>
					
					</div>
					</div>
		<?php
		}
					
		?>					
						<?php echo $this->pagination->create_links(); ?>
								
							
									
				</div>
			  </div>
			  
			  
			  <!--MODAL-->
						<?php
		foreach ($news as $value2)
		 {
		 	$id = $value2->news_id;
		 	$news_category = $value2->news_category_fkey;
			
			$CI =& get_instance();
			$CI->load->model('Mdl_admin');
			$category_name = $CI->Mdl_admin->show_parent($news_category);
		 	echo form_open_multipart('Admin/update_news');
		 	echo'
		 	<input type ="hidden" value = "'.$value2->news_id.'" name="news_id">
			<div id="news_'.$value2->news_id.'" class="modal fade " role="dialog">
							  <div class="modal-dialog">

								<!-- Modal content-->
								<div class="modal-content">
								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									
									<h4 class="modal-title black1">'.$value2->news_headline.'</h4>
								  </div>
								  <div class="modal-body">
								    
									<div class="row">
				<div class="col-sm-3 form-group">
				  <h4>Headline</h4>
				</div>';
			
				 
			
				echo'<div class="col-sm-9 form-group">
				  <input class="form-control" id="name" name="news_headline" placeholder="Name" type="text" required value="'.$value2->news_headline.'">
				</div>
			  </div> 
			  
			  <div class="row">
				<div class="col-sm-3 form-group">
				  <h4>Content</h4>
				</div>
				<div class="col-sm-9 form-group">
				  <textarea  class="form-control" id="name" name="news_content" placeholder="content" type="text"  rows="5"> '.$value2->news_content.'</textarea><br>
				</div>
			  </div> ';
			  
			 /* <div class="row">
				<div class="col-sm-3 form-group">
				  <h4>Tags</h4>
				</div>
				<div class="col-sm-9 form-group">
				  <input class="form-control" id="tags" name="news_tags" placeholder="tags" type="text" required>
				</div>
			  </div> */
			  
			echo'  <div class="row">
				<div class="col-sm-3 form-group">
				  <h4>Select category</h4>
				</div>
				<div class="col-sm-9 form-group">
				    <select name="news_category_fkey" style="width:100%;margin-top:10px; padding:3px 10px;">';
	foreach ($category_name as $value_cat)
										{
										echo'  <option value="'.$value_cat->category_id.'" style="display:none">'.$value_cat->category_name.'</option>';
										}		
	foreach ($category as $value) {
				echo '<option value="'.$value->category_id.'" >'.$value->category_name.'</option>';
			}
					  
			echo'
					  
					</select>
				</div>
			  </div> 
			  <div class="row">
				<div class="col-sm-5 form-group">';
				?>
			  <img src="<?php echo base_url()?><?php echo $value2->news_photo?>" class="img-responsive">
				 
				</div>
			    </div>
			  
			  <div class="row">
				<div class="col-sm-3 form-group">
				  <h4>Change photo</h4>
				</div>
				<div class="col-sm-9 form-group">
					<input id="a" name="news_photo"  type="file">
			    </div>
			  </div>
			  <button type="submit" class="btn btn-success category-h" title="add category">Update</button>
			 
								 
			
								  </div>
								  <div class="modal-footer">
									<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
								  </div>
								</div>

							  </div>
							</div>
				
				</div>
				<?php
				echo form_close();
					}
				
				?>	
		</div>
</body>
</html>