<!DOCTYPE html>
<html lang="en">
<head>
	<?php
		$tag_value ="online news,news,latest news";
		if($post!=0)
		{

			foreach ($post as $key => $tag) {
				
					$content = $tag->news_headline;
				
				$explode =explode(' ', $content);
			
				$tag_value = implode(',', $explode);
			}
		}
		

		foreach ($settings as $value_settings) {
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
  <title><?php echo $value_settings->settings_title;?></title>
  <link rel="icon" href="<?php echo base_url(); ?><?php echo $value_settings->settings_icon;?>">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="keywords" content="Resoft,Rnews,News,Online News,Latest News,News Now.<?php echo $tag_value;?>" />
 <!-- Online file-->
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link href="http://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
  <link href="http://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
	<!--Offline file-->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">
 



</head>
<body class="container-fluid">
<!--header starts-->

<div class="container main" id="top-head">
		<div class="row" style="margin-top:-6px;">
		  <div class="logo_head col-xs-9 container" >
			<h2><a href="<?php echo base_url(); ?>" class="heading<?php echo $value_settings->settings_color;?>"><img src="<?php echo base_url(); ?><?php echo $value_settings->settings_logo;?>" class="logo"> <?php echo $value_settings->settings_title;?></a></h2>
			</div>
			<?php
			echo form_open('Rnews/search')
			?>
		<div class="col-xs-3 container" role="search">
	        <div class="input-group sarch">
	            <input type="text" class="form-control" required = "required" placeholder="Search" name="search_value" id="srch-term">
	            <div class="input-group-btn">
	                <button class="btn<?php echo $value_settings->settings_color;?> btn btn-<?php echo $btn_value;?>" type="submit"><i class="glyphicon glyphicon-search"></i></button>
	            </div>
	        </div>
        </div>
        <?php
       echo form_close();
        ?>
		</div>	
		<!--header ends-->
		<!--navbar starts here-->
		<nav class="navbar navbar-inverse navbar-custom" data-spy="affix" data-offset-top="107">
			  <div class="container">
				<div class="navbar-header">
				  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span> 
				  </button>
				</div>
				<div class="collapse navbar-collapse navis" id="myNavbar">
				  <ul class="nav navbar-nav">
					<li class="color"><a href="<?php echo base_url(); ?>">Home</a></li>
		<?php
			foreach ($category as $category_value) 
			{
				$parent = $category_value->category_id;
				$CI =& get_instance();
				$CI->load->model('Mdl_rnews');
				$subcategory = $CI->Mdl_rnews->load_subcategory($parent);
				$count = count($subcategory);
			if($count!=0){
		?>
				<li class="dropdown color">
						<a class="dropdown-toggle" data-toggle="dropdown" href=""><?php echo $category_value->category_name;?>
						<span class="caret"></span></a>
					<ul class="dropdown-menu">
			<li><a href="<?php echo base_url();?>news/category/<?php echo $category_value->category_id;?>"><?php echo $category_value->category_name;?>
			</li>

		<?php
			foreach ($subcategory as $value)
			{
		?>
			<li><a href="<?php echo base_url();?>news/category/<?php echo $value->category_id;?>"><?php echo$value->category_name;?></a></li>
		<?php	
			}
		?>   
					</ul>
				</li>
		<?php
						}	
			
			else{		
		?>						 
			<li class="color"><a href="<?php echo base_url();?>news/category/<?php echo $category_value->category_id;?>"><?php echo $category_value->category_name;?></a></li>
			
		<?php	}
			}
		?>	
				</div>
			  </div>
		</nav>
		<!-- Navbar Ends here-->
		
		<?php
		
	
				if(isset($vw_index))
				{

				$this->load->view($vw_index);

				}
				else if(isset($vw_home))
				{

				$this->load->view($vw_home);

				}

				else if(isset($vw_post))
				{

				$this->load->view($vw_post);

				}
				else if(isset($vw_search))
				{

				$this->load->view($vw_search);

				}
				else
				{
				$this->load->view($vw_index);
				}
			?>
			<!--widget-->
			<div class="col-sm-3 widget-full container">
			
			
			<div class="widget">
			<h3>Recent Posts</h3>
			<ul>
			<?php
			foreach ($recent_news as $key => $recent) {
			// j=01(date),l=(day),g=(hour),i=(minute) a=(am/pm)
			
			$date = strtotime($recent->news_date);
			$formated_date = date('j M, Y',$date) ;
			$id = $recent->news_id;
			$news_category = $recent->news_category_fkey;	
			$CI =& get_instance();
			$CI->load->model('Mdl_admin');
			$category_name = $CI->Mdl_admin->show_parent($news_category);

			$CI =& get_instance();
			$CI->load->model('Mdl_rnews');
			$comment_news = $CI->Mdl_rnews->load_comment($id);
			$total_comment = count($comment_news);
			foreach ($category_name as $category) {
			?>
			<li><h4>
			<a href="<?php echo base_url();?>news/<?php echo $recent->news_id?>" class="heading<?php echo $value_settings->settings_color;?>"><?php echo $recent->news_headline?></a></h4>
			<p class="wizcom<?php echo $value_settings->settings_color;?> "><b><?php echo $formated_date?>| <?php echo $category->category_name?> | <?php echo $total_comment;?> Comments</b></p></li>
			<?php
				}
			}
			?>
			</ul>
			</div>
			<div class="widget">
			<h3>Recent Comments</h3>
			<ul>
			<?php
			
			foreach ($recent_comment as $key => $value_comment) {
				foreach ($value_comment as $key => $comment) {
			// j=01(date),l=(day),g=(hour),i=(minute) a=(am/pm)
				
			$date = strtotime($comment->news_date);
			$formated_date = date('j M, Y',$date) ;
			$id = $comment->news_id;
			$news_category = $comment->news_category_fkey;	
		
			$CI =& get_instance();
			$CI->load->model('Mdl_admin');
			$category_name = $CI->Mdl_admin->show_parent($news_category);

			$CI =& get_instance();
			$CI->load->model('Mdl_rnews');
			$comment_recent = $CI->Mdl_rnews->load_comment($id);
			$total_comment = count($comment_recent);
			foreach ($category_name as $category_comment) {
			?>
			<li><h4><a href="<?php echo base_url();?>news/<?php echo $comment->news_id?>" class="heading<?php echo $value_settings->settings_color;?>"><?php echo $comment->news_headline?></a></h4>
			<p class="wizcom<?php echo $value_settings->settings_color;?> "><b><?php echo $formated_date?>| <?php echo $category_comment->category_name?> | <?php echo $total_comment;?> Comments</b></p></li>
			<?php
				}
				}
			}
			?>
			</ul>
			</div>
			
			<div class="widget">
			<h3>Archieve</h3>			
			<ul>
				<?php		
				$time = date("Y-m-d");
				list($year, $m, $d) = explode('-', $time);
				$month_name = '';
				for ($month=1; $month <=12 ; $month++) { 
					if($month==1){$month_name = 'January';}
					if($month==2){$month_name = 'February';}
					if($month==3){$month_name = 'March';}
					if($month==4){$month_name = 'April';}
					if($month==5){$month_name = 'May';}
					if($month==6){$month_name = 'June';}
					if($month==7){$month_name = 'July';}
					if($month==8){$month_name = 'August';}
					if($month==9){$month_name = 'September';}
					if($month==10){$month_name = 'October';}
					if($month==11){$month_name = 'November';}
					if($month==12){$month_name = 'December';}
					?>
					<li><h4><a href="<?php echo base_url();?>news/archieve/<?php echo $month;?>/<?php echo $year;?>" class="heading<?php echo $value_settings->settings_color;?>"><?php echo $month_name;?>, <?php echo $year;?></a></h4></li>
				<?php
					if($month==$m){
						break;
					}
				}
				?>
			
			</ul>
			</div>
			
			<div class="widget" style="width:250px; margin-left:20px; border-radius:4px;">
				<?php
					foreach ($adsense as $key => $value_ad) {
						if($value_ad->adsense_status==1)
						{
							echo $value_ad->adsense_code;
						}
					}
				?>
							
			<!--<img src="<?php echo base_url();?>assets/img/resoft.jpg" class="img-responsive" alt="Add here" style="width:250px; margin-left:20px; border-radius:4px;"></img>-->
			
			</div>
			</div>
		
		</div>
		<!--footer-->
		<footer class="text-center container-fluid">
		<div class="row">
			
					<div class="col-sm-5 footer-sec">
					<h3 class="footh3<?php echo $value_settings->settings_color;?> ">Contact Information</h3>
					<p style="margin-bottom:70px;">Address: <?php echo $value_settings->settings_address;?>
					</br>
					Cell :<?php echo $value_settings->settings_phone;?>
					</br>
					Email: <?php echo $value_settings->settings_email;?>
					</br>
					</p>
			<?php
				foreach ($link as $value_link) {
			?>		
					<h3 class="footh3<?php echo $value_settings->settings_color;?> ">Around the web</h3>
					<a href="<?php echo $value_link->link_twt;?>"><i class="fa fa-twitter tw" aria-hidden="true"></i></a>
					<a href="<?php echo $value_link->link_google;?>"><i class="fa fa-google-plus gp" aria-hidden="true"></i></a>
					<a href="<?php echo $value_link->link_fb;?>"><i class="fa fa-facebook fb" aria-hidden="true"></i></a>
					<a href="<?php echo $value_link->link_linkedin;?>"><i class="fa fa-linkedin ld" aria-hidden="true"></i> </a>
					<a href="<?php echo $value_link->link_utube;?>"><i class="fa fa-youtube yt" aria-hidden="true"></i> </a>
			<?php
				}
			?>
			</div>
			
			
			<div class="col-sm-7 footer-first">
			<h3 class="footh3<?php echo $value_settings->settings_color;?> ">Send us a message</h3>
			<div class="row">
		<?php
			echo form_open('Rnews/send_message');
		?>
			<div class="col-sm-6 form-group">
			  <input class="form-control" id="name" name="inbox_name" placeholder="Name" type="text" required>
			</div>
			<div class="col-sm-6 form-group">
			  <input class="form-control" id="email" name="inbox_email" placeholder="Email" type="email" required>
			</div>
		  </div>
		  <textarea class="form-control" id="comments" name="inbox_message" placeholder="Send us a message" rows="3"></textarea><br>
		  <div class="row">
			<div class="col-sm-12 form-group">
			  <button class="btn<?php echo $value_settings->settings_color;?> btn btn-<?php echo $btn_value;?> pull-right" type="submit">Send</button>
			</div>
		<?php echo form_close();
		?>
		  </div> 
		  
		  <p style="margin-top:35px; float:right; color:#aaa;">© Copyright <strong><?php echo $value_settings->settings_title;?></strong> || Developed by <a href="http://facebook.com/resoftbd">Resoft</a>.</p>
			</div>
		</div>
		</footer>
		
</div>
<div class="top" style="position:fixed; bottom:5px; right:10px; padding:10px 5px;"><a href="#top-head"><button class="btn trans-top"><i class="fa fa-arrow-up" style="color:#000;" aria-hidden="true"></i></button></a></div>

<script>
$(document).ready(function(){
  // Add smooth scrolling to all links in navbar + footer link
  $(".top a[href='#top-head']").on('click', function(event) {

   // Make sure this.hash has a value before overriding default behavior
  if (this.hash !== "") {

    // Prevent default anchor click behavior
    event.preventDefault();

    // Store hash
    var hash = this.hash;

    // Using jQuery's animate() method to add smooth page scroll
    // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
    $('html, body').animate({
      scrollTop: $(hash).offset().top
    }, 850, function(){

      // Add hash (#) to URL when done scrolling (default click behavior)
      window.location.hash = hash;
      });
    } // End if
  });
})
</script>

<?php
}
?>
</body>
</html>