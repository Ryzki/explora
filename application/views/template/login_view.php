<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Explora | Digital Printing</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.6 -->
	<link rel="stylesheet" href="<?=base_url();?>assets/bootstrap/css/bootstrap.min.css">


	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?=base_url();?>assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?=base_url();?>assets/dist/css/AdminLTE.css">
	<!-- AdminLTE Skins. Choose a skin from the css/skins
	folder instead of downloading all of them to reduce the load. -->
	<link rel="stylesheet" href="<?=base_url();?>assets/dist/css/skins/_all-skins.css">
	<!-- iCheck -->
	<link rel="stylesheet" href="<?=base_url();?>assets/plugins/iCheck/flat/blue.css">
	<!-- Morris chart -->
	<link rel="stylesheet" href="<?=base_url();?>assets/plugins/morris/morris.css">
	<!-- jvectormap -->
	<link rel="stylesheet" href="<?=base_url();?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
	<!-- Date Picker -->
	<link rel="stylesheet" href="<?=base_url();?>assets/plugins/datepicker/datepicker3.css">
	<!-- Daterange picker -->
	<link rel="stylesheet" href="<?=base_url();?>assets/plugins/daterangepicker/daterangepicker.css">
	<!-- bootstrap wysihtml5 - text editor -->
	<link rel="stylesheet" href="<?=base_url();?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
	<link rel="stylesheet" href="<?=base_url();?>assets/css/module.css">


	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box" id="modalLogin">
 
  <!-- /.login-logo -->
  <div class="login-box-body">
	<center>
		<img src="<?=base_url();?>assets/img/logo_explorastore.png" width="200px" >
	</center>
	<hr>
    <p class="login-box-msg">Silahkan Login</p>

	<form method="post"  id="form_login">	
		<div class="form-group has-feedback">
			<input type="input" class="form-control" placeholder="Username" name="USERNAME_LOGIN">
			<span class="glyphicon glyphicon-user form-control-feedback"></span>
		</div>
		<div class="form-group has-feedback">
			<input type="password" class="form-control" placeholder="Password" id="PASSWORD_LOGIN" name="PASSWORD_LOGIN">
			<span class="glyphicon glyphicon-lock form-control-feedback"></span>
		</div>
		<div class="form-group">
			<div class="col-sm-12">
				<img src="<?php echo base_url();?>assets/img/loading.gif" id="loading_login" style="display:none">
				<p id="pesan_error_login" style="display:none" class="text-warning" style="display:none"></p>
			</div>
		</div>	
		<div class="row">
		
		<!-- /.col -->
		<div class="col-xs-4">
			<button type="submit" class="btn btn-primary btn-block btn-flat">Login</button>
		</div>
		<!-- /.col -->
		</div>
	</form>


    <!-- /.social-auth-links -->

 
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
		<script src="<?=base_url();?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
		<!-- jQuery UI 1.11.4 -->
		<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
		<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
		<script>	
			var base_url = "<?php echo base_url();?>";
			var uri_1 = "<?php echo $this->uri->segment(1); ?>";
			var uri_2 = "<?php echo $this->uri->segment(2); ?>";
			var uri_3 = "<?php echo $this->uri->segment(3); ?>";
			var uri_4 = "<?php echo $this->uri->segment(4); ?>";			
			$.widget.bridge('uibutton', $.ui.button);
		</script>
		<!-- Bootstrap 3.3.6 -->
		<script src="<?=base_url();?>assets/bootstrap/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/validate.js"></script>	
		<script src="<?=base_url();?>assets/js/module.js"></script>	
</body>
</html>
