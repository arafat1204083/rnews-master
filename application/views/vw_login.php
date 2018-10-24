<!DOCTYPE html>
<html lang="en">
<head>
  <title>RNews</title>
   <link rel="icon" href="<?php echo base_url(); ?>assets/img/resoft.jpg">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link href="http://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:700,500" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/admin/css/style.css">
</head>
<body>
	<div class="row">
		<div class="col-xs-4">
			
		</div>
			<div class="col-xs-4 content" style="margin-top:160px; height:250px; border-radius:7px; overflow:hidden;">
				<h3>Admin Login</h3>
					
					
					<?php
					$atr=array('class'=>"form-horizontal");
					echo form_open("admin_login/do_login",$atr);
					?>
						<div class="row" style="margin:18px;">
						<div class="col-xs-3">
						<h4>Username:</h4>
						</div>
						<div class="col-xs-9">
						<input class="form-control" id="username" name="username" placeholder="Type Username" type="text" required>
						</div>
						</div>
						<div class="row" style="margin:18px;">
						<div class="col-xs-3">
						<h4>Password:</h4>
						</div>
						<div class="col-xs-9">
						<input class="form-control" id="password" name="password" placeholder="Type Password" type="password" required>
						</div>
						</div>
						<button class="btn btn-primary pull-right" style="margin:18px;">Log in</button><br>
						<?php
						if(isset($msg)	)
						{
					?>
						<div class="alert-danger" style="padding:7px 15px; width:310px; margin-top:-2px; margin-left:20px"> <?php echo $msg ?></div>

					<?php	
						}
				    ?>
					<?php
						if(validation_errors())
						{
					?>
						<div class="alert-danger"> <?php echo validation_errors(); ?></div>

					<?php	
						}
				    ?>
					<?php
					echo form_close();
					?>
				<!--<p class="notice"> Forgot password? <a href="admin.html"> Click here. </a>-->
			</div>
		<div class="col-xs-4">
		
		</div>
	</div>
</body>
</html>