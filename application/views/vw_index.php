<!DOCTYPE html>
<html lang="en">

<body class="container-fluid">
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
	
	<!-- slideshow-->
			<div class="container-fluid">
			  <div id="myCarousel" class="carousel slide jumborton" data-ride="carousel" data-interval="4500">
				<!-- Indicators -->
				<ol class="carousel-indicators">
				  <?php
				$count = count($slideshow);	
				 echo' <li data-target="#myCarousel" data-slide-to="0" class="active"></li>';
				for($i=1;$i<$count;$i++){
				echo '<li data-target="#myCarousel" data-slide-to="'.$i.'"></li>';
				}	
				?>
				</ol>
</ol>

			<!-- Wrapper for slides -->
			<div class="carousel-inner jumborton" role="listbox">
				<?php
				$active = 0;
				foreach ($slideshow as $slide_value) {
				
					if($active==0)
					{
				?>
				  <div class="item active">
					<img src="<?php echo base_url();?><?php echo $slide_value->slideshow_photo?>" alt="resoft" class="slider-image img-responsive">
				  </div>

				 <?php
					}
					else
					{
				 ?>
				 <div class="item">
					<img src="<?php echo base_url();?><?php echo $slide_value->slideshow_photo?>" alt="resoft" class="slider-image img-responsive">
				  </div>
				 <?php
				    }
				    $active++;
				  }

				?>

				</div>
					<!-- Left and right controls -->
					<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
					  <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
					  <span class="sr-only">Previous</span>
					</a>
					<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
					  <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
					  <span class="sr-only">Next</span>
					</a>
			    </div>
			</div>
		<!--Slider ends here-->
		
		<!--main contents starts-->
		<div class="row cont-full container" style="margin-top: 20px; color: #000">
			<div class="col-sm-9">
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
			foreach ($category as $category_value) 
			{
				$category = $category_value->category_id;
				$CI =& get_instance();
				$CI->load->model('Mdl_rnews');
				$news = $CI->Mdl_rnews->home_news($category);
				$count = count($news);
				if($count!=0){
			?>
			<div class="cat_artical" style="margin-top: 55px">
			<h1><a href="<?php echo base_url();?>news/category/<?php echo $category_value->category_id;?>" class="heading<?php echo $value_settings->settings_color;?> " <?php echo $category_value->category_name?></a></h1>
			<div class="row">
			<?php
			foreach ($news as $key => $value) {
			$id = $value->news_id;
			$original_string = $value->news_content;		
			
			$CI =& get_instance();
			$CI->load->model('Mdl_rnews');
			$comment = $CI->Mdl_rnews->load_comment($id);
			$total_comment = count($comment);
			?>
			<!--Read more-->
			<?php
			$num_words = 25;
			$words = array();
			$words = explode(" ", $original_string, $num_words);
			$shown_string = "";

			if(count($words) == 25){
			   $words[24] = " ... ";
			}
			$shown_string = implode(" ", $words);	
// j=01(date),l=(day),g=(hour),i=(minute) a=(am/pm)
			
			$date = strtotime($value->news_date);
			$formated_date = date('j M, Y',$date) ;
			?>

				<div class="col-xs-4 ">
				<h3><a href="<?php echo base_url();?>news/<?php echo $value->news_id?>" class="heading<?php echo $value_settings->settings_color;?> "><?php echo $value->news_headline?></a></h3>
				<p class="com<?php echo $value_settings->settings_color;?> "><b><a href=""> <?php echo $formated_date?></a> | <a href=""><?php echo $total_comment?> comments</a></b></p>
				<a href="<?php echo base_url();?>news/<?php echo $value->news_id?>"><img src="<?php echo base_url();?><?php echo $value->news_photo?>"  class="img-responsive home imag"></img></a>
				<p class="text-justify"><?php echo $shown_string?></p>
				</div>

			<?php
			}
			?>
			
			
	
			</div>
			</div>
			<?php
			}
		}
			?>

			</div>
			
			
<?php
	}
?>
	

</body>
</html>