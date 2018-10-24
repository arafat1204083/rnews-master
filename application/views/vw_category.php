<!DOCTYPE html>
<html lang="en">

				 <!-- Main content -->

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
				<div class="col-sm-4">
				<h3> Category</h3>
				<div class="container-fluid">
					<?php
					echo form_open('Admin/insert_cat','class="form-horizontal"')
					?>
						<div class="form-group">
						  <h3 class="category-h">Category name:</h3>
							<input type="text" class="form-control" id="add-cat" name="category_name" placeholder="Add a category">
							<h3 class="category-h">Select parent</h3>
							
								<select name="category_parent" style="width:100%; padding:6px 10px;">
								  <option value="0">None</option>
							<?php
							foreach ($parent as  $value) {
							echo'
								  <option value="'.$value->category_id.'">'.$value->category_name.'</option>';
							}
								
							?>
								</select><br>
								
								<p class="notice category-h">* In order to add a category, select parent category- "none". In order to add a sub category, select the parent category that you want to make the parent of your sub category. </p> <br> 
							<button type="submit" class="btn btn-primary category-h" title="add category">Add category</button>
						</div>
					<?php
					echo form_close();
					?>
				</div>
				</div>
				<div class="col-sm-8" style="padding-left:100px; padding-right: 50px; margin-top:40px;">
				<h3 style="margin-top:30px;">Existing categories</h3>
							
				<?php
				foreach ($category as $value2) {
					$parent_id = $value2->category_parent;
					$id =$value2->category_id;
					$CI =& get_instance();
					$CI->load->model('Mdl_admin');
					$parent_name = $CI->Mdl_admin->show_parent($parent_id);
					
					echo'
						<div class="form-group row cat">
						<input type="hidden" name="category_id" value="'.$value2->category_id.'">
						  <div class="col-sm-4">

							<h4>'.$value2->category_name.'</h4>
						  </div>';
						  if($parent_id=='0'){
						  		echo'<div class="col-sm-3">
							<h4>None</h4>
						  </div>';
						  	}
						  foreach ($parent_name as $value5) {
						  	
						  	
						  		echo'<div class="col-sm-3">
							<h4>'.$value5->category_name.'</h4>
						  </div>';
						  	
						  	
						  }
						  							  
						
						  
						  
						  echo'
							<div class="col-sm-5 btn-group">';
					/*		<button type="submit" class="btn btn-info" title="move up"><i class="fa fa-level-up" aria-hidden="true"></i></button>
							<button type="submit" class="btn btn-success" title="move down"><i class="fa fa-level-down" aria-hidden="true"></i></button>
					*/
							 echo'<button type="submit" class="btn btn-warning" title="edit" data-toggle="modal" data-target="#category_'.$value2->category_id.'"><i class="fa fa-edit" aria-hidden="true"></i></button>
							<input type = "hidden" name ="category_id" value="'.$id.'">';
							?>
							<a id="<?php echo $id;?>" onclick="return confirm('Are you sure?');" href="<?php echo base_url()?>Admin/category_delete/<?php echo $id;?>"
								<button type="submit" class="btn btn-danger" title="remove" onclick="cat_delete('.$id.')"><i class="fa fa-times" aria-hidden="true"></i></button></a>
							</div>
							
						</div>
				<?php	
				}
				?>
						
					 
					  
					  <p class="notice category-h">* Hover over the buttons and hold for one or two seconds in order to know the functionalities of that button.</p>
				</div>
				</div>
				</div>
				</div>
				
				<!--MODAL-->
				<?php
				foreach ($category as $value3) 
				{
					$parent_id = $value3->category_parent;
					$CI =& get_instance();
					$CI->load->model('Mdl_admin');
					$parent_name = $CI->Mdl_admin->show_parent($parent_id);
					echo form_open('Admin/update_cat','class="form-horizontal"');
					echo'<input type="hidden" name="category_id" value="'.$value3->category_id.'">
							<div id="category_'.$value3->category_id.'" class="modal fade" role="dialog">
							  <div class="modal-dialog">

								<!-- Modal content-->
								<div class="modal-content cat">
								  <div class="modal-header" style="color:#111;">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									
									<h4 class="modal-title">Category name</h4>
								  </div>
								  <div class="modal-body" style="color:#111;">
								   <h3 class="category-h">Category name:</h3>
								   
									<input type="text" name="category_name" class="form-control" id="add-cat" placeholder="Add a category" value="'.$value3->category_name.'">
									<h3 class="category-h">Select parent</h3>
										<select name="category_parent" style="width:100%; padding:6px 10px;">';
				foreach ($parent_name as $value5)
										{
										echo'  <option value="'.$value5->category_id.'" style="display:none">'.$value5->category_name.'</option>';
										}
										echo'
								  		<option value="0">None</option>';
				  foreach ($parent as  $value4) {
				  		if($value3->category_id!=$value4->category_id)
				  				{
								echo'
								  		<option value="'.$value4->category_id.'">'.$value4->category_name.'</option>';
								}
											}
										echo'</select><br>
									<button type="submit" class="btn btn-primary category-h" title="add category">Update</button>
								
								   </div>
								  <div class="modal-footer">
									<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
								  </div>
								</div>

							  </div>
							</div>';
					echo form_close();
				}
				?>
		</div>
</body>
</html>