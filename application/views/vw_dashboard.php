 <!DOCTYPE html>
<html lang="en">
<body>
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
				<h3> Dashboard</h3>
					<div class="row">
						<div class="col-xs-3 text-center">
							<div class="stat-a" style=" background:#00c0ef">
									<h2><?php echo $total_post?></h2>	
								<h4>Total posts</h4>
							</div>
						</div>
						<div class="col-xs-3 text-center">
							<div class="stat-a" style=" background:#00a65a">
					<?php
					foreach ($daily_visit as $key => $daily) {
						echo'<h2>'.$daily->visitor_total.'</h2>';
					}					
					?>
								<h4>Daily Visit</h4>
							</div>
						</div>
						<div class="col-xs-3 text-center">
							<div class="stat-a" style=" background:#f39c12">
					<?php
					
						echo'<h2>'.$weekly_visit.'</h2>';
										
					?>
								<h4>Weekly Visit</h4>
							</div>
						</div>
						<div class="col-xs-3 text-center">
							<div class="stat-a" style=" background:#de4b39">
					<?php
					
						echo'<h2>'.$monthly_visit.'</h2>';
										
					?>
								<h4>Monthly Visit</h4>
							</div>
						</div>
					</div>
					
					<div class="row" style="margin-top:40px;">
					<div class="col-xs-6">
					<h3>News Headlines at a glance</h3>
			<?php
			foreach ($news as $news_value) {
			if($news_value->news_visitor>=100)
			{
				$color = 'danger';
			}
			else if($news_value->news_visitor>=50)
			{
				$color = 'warning';
			}
			else if($news_value->news_visitor>=20)
			{
				$color = 'success';
			}
			else
			{
				$color = 'info';
			}
			?>
				<a href="<?php echo base_url();?>news/<?php echo $news_value->news_id?>"><?php echo'<h4 class="cont-head">'.$news_value->news_headline.'<span class="label label-'.$color.'">'.$news_value->news_visitor.'</span></h4></a>';
			}
			?>
			<?php echo $this->pagination->create_links(); ?>
					
					
					</div>
					<div class="col-xs-6">
					<h3 style="margin-left:0px;">Monthly Visits</h3>
			<?php

			foreach ($monthly_progress as $progress) {
			
					$month_count = $progress['visitor_month'];
					$total = $progress['visitor_total'];
				if($total>=1000)
				{
					$width = 100;
				}
				else
				{
					$width = ($total*100)/1000;
				}
				switch ($month_count)
						{
						case 1:
						  $month_name = 'January';
						  break;
						case 2:
						  $month_name = 'February';
						  break;
						case 3:
						 $month_name = 'March';
						 break;
						 case 4:
						  $month = 'April';
						  break;
						case 5:
						  $month_name = 'May';
						  break;
						case 6:
						 $month_name = 'June';
						  break;
						 case 7:
						  $month_name = 'July';
						  break;
						case 8:
						  $month_name = 'August';
						  break;
						case 9:
						 $month_name = 'September';
						 break;
						 case 10:
						  $month_name = 'October';
						  break;
						case 11:
						  $month_name = 'November';
						  break;
						case 12:
						 $month_name = 'December';
						  break;
						default:
						  echo "null";
						}
				if($total>=900)
				{
					$color ='danger';
				}
				else if($total>=500)
				{
					$color ='warning';
				}
				else if($total>=250)
				{
					$color ='success';
				}
				else
				{
					$color = 'info';
				}
			echo'
				'.$month_name.': 
				<div class="progress">
					<div class="progress-bar progress-bar-striped  progress-bar-'.$color.' active" role="progressbar" style="width:'.$width.'%">'.$total.' VIsits</div>
				</div>
			';

			}
			?>
						
						<p style="margin-top:75px; float:right; color:#aaa">Developed by <a href="http://facebook.com/resoftbd">Resoft</a>.</p>
					</div>
				</div>
		</div>
	</body>
</html>