<!DOCTYPE html>
<html lang="en">
<?php
	foreach ($settings as $key => $value_settings) {
		if($value_settings->settings_color=='-red')	
		{
			$btn_value = 'danger';
		}	
		if($value_settings->settings_color=='-blue')	
		{
			$btn_value = 'info';
		}
		if($value_settings->settings_color=='-green')	
		{
			$btn_value = 'success';
		}
		if($value_settings->settings_color=='-orange')	
		{
			$btn_value = 'warning';
		}
?>
		<?php
		foreach ($post as $key => $value) {
			// j=01(date),l=(day),g=(hour),i=(minute) a=(am/pm)
			
			$date = strtotime($value->news_date);
			$formated_date = date('j M, Y',$date) ;
			
			$total_comment = count($comment);
		$news_category = $value->news_category_fkey;	
		$CI =& get_instance();
		$CI->load->model('Mdl_admin');
		$category_name = $CI->Mdl_admin->show_parent($news_category);
		?>
		<!--main contents starts-->
		<div class="row cont-full container" style="margin-top: 30px; color: #000">
			<div class="col-sm-9">
			
			<!--cont 1-->
			<div class="row" style="margin-top: 25px">
			
			<div>
			<div class="container-fluid">
					<img src="<?php echo base_url()?><?php echo $value->news_photo?>" alt="resoft" class="img-responsive">
				  
				</div>
		<h2><a href="" class="heading<?php echo $value_settings->settings_color;?> "><?php echo $value->news_headline?></a></h2>
		<?php
			foreach ($category_name as $key => $category) {
		?>
			<p class="com<?php echo $value_settings->settings_color;?> "><b><a href=""> <?php echo $formated_date?></a> | <a href="<?php echo base_url();?>news/category/<?php echo $value->news_category_fkey;?>"><?php echo $category->category_name?></a> | <a><?php echo $total_comment;?> Comments </a></b></p>
		<?php
		}
		?>
			
			<p class="text-justify" style="margin:30px 20px;"> <?php echo $value->news_content?></p>
			</p>
			</div>
			
			</div>
			<div>
		<?php
		echo form_open('rnews/comments');
		?>
			<h3>Leave a comment</h3>
			<div class="row">
			<div class="col-sm-6 form-group">
				<input type ="hidden" name="comment_news_fkey" value="<?php echo $value->news_id?>">
			  <input class="form-control" id="name" name="comment_name" placeholder="Name" type="text" required>
			</div>
			<div class="col-sm-6 form-group">
			  <input class="form-control" id="email" name="comment_email" placeholder="Email" type="email" required>
			</div>
		  </div>
		  <textarea class="form-control" id="comments" name="comment_content" placeholder="Leave a comment" rows="4"></textarea><br>
		  <div class="row">
			<div class="col-sm-12 form-group">
			  <button class="btn<?php echo $value_settings->settings_color;?> btn btn-<?php echo $btn_value;?> pull-right" type="submit">Comment</button>
			</div>
		  </div> 
		<?php
		echo form_close();
		$count = count($comment);
		?>
			</div>
			<div>
			
		<?php
		if($count!= 0){
			echo'<h2 style="color: #cc312c;">Comments</h2>';
		}
		
		foreach ($comment as $value_comment) {
	// j=01(date),l=(day),g=(hour),i=(minute) a=(am/pm)
			
			$date = strtotime($value_comment->comment_time);
			$formated_date = date('j M, Y, g:i A',$date) ;
		echo'
			<div class="row">
			<div class="col-xs-2">';
		?>
			<img src="<?php echo base_url();?>assets/img/user1.png" style="margin-top:20px;" class="img-responsive pull-right">
		<?php
		echo'	</div>
			<div class="col-xs-10">
			<h3 style="color: #cc312c;">'.$value_comment->comment_name.'</h3>';
		?>
			<p class="com<?php echo $value_settings->settings_color;?> "><b><?php echo $formated_date;?></b></p>
		<?php
		echo'<p style="padding:5px; border-bottom: 1px dashed #ccc;">'.$value_comment->comment_content.'</p>
			</div>
			</div>';
		}
		?>
			
		<!--<a href="" class="heading<?php echo $value_settings->settings_color;?>  pull-right"><b>View more comments... </b></a>-->
			</div>
			
			<?php
			}
			?>
		
			
			</div>
<?php
	}
?>						
</body>
</html>