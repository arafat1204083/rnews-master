<!DOCTYPE html>
<html lang="en">
<body>
	<!-- Slider starts here-->
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
	
		
		<!--main contents starts-->

		<div class="row cont-full container" style="margin-top: 30px; color: #000">
			
			<div class="col-sm-9">
				<?php
				if($msg!='')
				{
				?><div>
				<div class="alert alert-<?php echo $msg_type;?> "> 
					<button type="button" class="close" data-dismiss="alert" 
                                aria-hidden="true">
                                &times;
                              </button>
					<h1><?php echo $msg;?></h1>

					</div>
					<a href="<?php echo base_url();?>"><button class="btn<?php echo $value_settings->settings_color;?> btn btn-<?php echo $btn_value;?>">Go Home</button></a>
				</div>
				<?php
				}
				?>
			<?php 
			foreach ($news as $key => $news_value) {
			// j=01(date),l=(day),g=(hour),i=(minute) a=(am/pm)
			
			$date = strtotime($news_value['news_date']);
			$formated_date = date('j M, Y',$date) ;
			$id = $news_value['news_id'];
			$news_category = $news_value['news_category_fkey'];
			$original_string = $news_value['news_content'];
			$CI =& get_instance();
			$CI->load->model('Mdl_admin');
			$category_name = $CI->Mdl_admin->show_parent($news_category);

			$CI =& get_instance();
			$CI->load->model('Mdl_rnews');
			$comment = $CI->Mdl_rnews->load_comment($id);
			$total_comment = count($comment);
			?>
			<!--Read more-->
			<?php
			$num_words = 100;
			$words = array();
			$words = explode(" ", $original_string, $num_words);
			$shown_string = "";

			if(count($words) == 100){
			   $words[99] = " ... ";
			}

			$shown_string = implode(" ", $words);	
			?>
			<!--News Content-->
			<div class="row" style="margin-top: 30px">
			<h2><a href="<?php echo base_url();?>news/<?php echo $news_value['news_id'];?>" class="heading<?php echo $value_settings->settings_color;?> "><?php echo $news_value['news_headline'];?></a></h2>
			<?php
			foreach ($category_name as $key => $category) {
			?>
			<p class="com<?php echo $value_settings->settings_color;?> "><b><a href=""> <?php echo $formated_date;?></a> | <a href="<?php echo base_url();?>news/category/<?php echo $news_value['news_category_fkey'];?>"><?php echo $category->category_name?> | <a href="<?php echo base_url();?>news/<?php echo $news_value['news_id']?>"><?php echo $total_comment;?> Comments</a></a></b></p>
			<?php	
			}
			?>
			
			<div class="col-sm-4 image">
			<a href="<?php echo base_url();?>news/<?php echo $news_value['news_id'];?>"><img src="<?php echo base_url();?><?php echo $news_value['news_photo'];?>" class="img-thumbnail img-responsive imag"></img></a>
			</div>
			<div class="col-sm-8">
			
			<p class="text-justify"><?php echo $shown_string?></p>
			<a href="<?php echo base_url();?>news/<?php echo $news_value['news_id'];?>"><button class="btn<?php echo $value_settings->settings_color;?> btn btn-<?php echo $btn_value;?>">Read More</button></a></div>
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