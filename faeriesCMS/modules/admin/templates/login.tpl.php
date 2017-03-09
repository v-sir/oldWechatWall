<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title><?php echo L('title')?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="shortcut icon" href="https://open.sky31.com/favicon.ico">
		<!-- basic styles -->
		<link href="<?php echo adminSTATICS_PATH?>assets/css/bootstrap.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="<?php echo adminSTATICS_PATH?>assets/css/font-awesome.min.css" />

		<!--[if IE 7]>
		  <link rel="stylesheet" href="./faeriesCMS/modules/admin/templates/assets/css/font-awesome-ie7.min.css" />
		<![endif]-->

		<!-- page specific plugin styles -->

		<!-- fonts -->

		<link rel="stylesheet" href="http://fonts.useso.com/css?family=Open+Sans:400,300" />

		<!-- ace styles -->

		<link rel="stylesheet" href="<?php echo adminSTATICS_PATH?>assets/css/ace.min.css" />
		<link rel="stylesheet" href="<?php echo adminSTATICS_PATH?>assets/css/ace-rtl.min.css" />
		<link rel="stylesheet" href="<?php echo adminSTATICS_PATH?>assets/css/ace-skins.min.css" />

		<!--[if lte IE 8]>
		  <link rel="stylesheet" href="./faeriesCMS/modules/admin/templates/assets/css/ace-ie.min.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- ace settings handler -->

		<script src="<?php echo adminSTATICS_PATH?>assets/js/ace-extra.min.js"></script>

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

		<!--[if lt IE 9]>
		<script src="./faeriesCMS/modules/admin/templates/assets/js/html5shiv.js"></script>
		<script src="./faeriesCMS/modules/admin/templates/assets/js/respond.min.js"></script>
		<![endif]-->
	</head>

	<body>
		<div class="navbar navbar-default" id="navbar">
			<script type="text/javascript">
				try{ace.settings.check('navbar' , 'fixed')}catch(e){}
			</script>

			<div class="navbar-container" id="navbar-container">
				<div class="navbar-header pull-left">
					<a href="#" class="navbar-brand">
						<small>
							<i class="icon-leaf"></i>
							<?php  echo L('title') ?>
						</small>
					</a><!-- /.brand -->
				</div><!-- /.navbar-header -->

				<div class="navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">
						<!--未登录显示-->
						<?
						session_start();
						if(isset($_SESSION['loginstatus'])){
							 ?>
							<li class="light-blue">
								<a data-toggle="dropdown" href="#" class="dropdown-toggle">
									<img class="nav-user-photo" src="<?php echo adminSTATICS_PATH?>assets/avatars/user.jpg" alt="Jason's Photo" />
								<span class="user-info">
									<small>欢迎光临,</small>
									ADMIN
								</span>

									<i class="icon-caret-down"></i>
								</a>

								<ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
									<li>
										<a href="#">
											<i class="icon-cog"></i>
											设置
										</a>
									</li>

									<li>
										<a href="#">
											<i class="icon-user"></i>
											个人资料
										</a>
									</li>

									<li class="divider"></li>

									<li>
										<a href="#">
											<i class="icon-off"></i>
											<a href="index.php?m=admin&c=index&a=logout"><? echo L('logout')?></a>
										</a>
									</li>
								</ul>
							</li>


						<?}
						else{
						?>
						<li class="light-blue">

							<a href='index.php?m=admin&c=index&a=login'><? echo L('no_login')?></a>


						</li>
						<?}?>



					</ul><!-- /.ace-nav -->
				</div><!-- /.navbar-header -->
			</div><!-- /.container -->
		</div>
		<div class="row clearfix show-it">
			<div class="col-md-12 column">
					<form action="index.php?m=admin&c=index&a=login" method='post'>
					<div class="login-form">
						<div class="form-group">
							<? echo L('username')?><input type="text" class="form-control login-field" name="UserName" id="UserName" placeholder="<? echo L('enter_username')?>" required/>
							<label class="login-field-icon fui-cmd" for="tid"></label>
						</div>
						<div class="form-group">
							<? echo L('password')?><input type="password" class="form-control login-field" name="PassWord" id="PassWord" placeholder="<? echo L('enter_password')?>" required/>
							<label class="login-field-icon fui-cmd" for="tid"></label>
						</div>
						<button class="btn btn-primary btn-lg btn-block"  type="submit" ><?echo L('login_button')?></button>
					</div>
					</form>

			</div>
		</div>




		<footer><? echo L('copyright')?></footer>
		</body>
	</html>
