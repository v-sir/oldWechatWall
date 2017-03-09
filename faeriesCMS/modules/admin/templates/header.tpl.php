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
						<?php
						session_start();
						if(isset($_SESSION['loginstatus'])){
							 ?>
							<li class="light-blue">
								<a data-toggle="dropdown" href="#" class="dropdown-toggle">
									<img class="nav-user-photo" src="<?php echo adminSTATICS_PATH?>assets/avatars/user.jpg" alt="Jason's Photo" />
								<span class="user-info">
									<small><? echo L('welcome')?>,</small>
									<?echo$_SESSION['username'];?>
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
						<?php }?>



					</ul><!-- /.ace-nav -->
				</div><!-- /.navbar-header -->
			</div><!-- /.container -->
		</div>

		<div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>

			<div class="main-container-inner">
				<a class="menu-toggler" id="menu-toggler" href="#">
					<span class="menu-text"></span>
				</a>

				<div class="sidebar" id="sidebar">
					<script type="text/javascript">
						try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
					</script>

					<div class="sidebar-shortcuts" id="sidebar-shortcuts">

						<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
							<span class="btn btn-success"></span>

							<span class="btn btn-info"></span>

							<span class="btn btn-warning"></span>

							<span class="btn btn-danger"></span>
						</div>
					</div><!-- #sidebar-shortcuts -->

					<ul class="nav nav-list">
						<li class="active">
							<a href="#">
								<i class="icon-dashboard"></i>
								<span class="menu-text"> <? echo L('admin_console');?> </span>
							</a>
						</li>

						<li>
							<a href="#" class="dropdown-toggle">
								<i class="icon-desktop"></i>
								<span class="menu-text"> <? echo L('wechat_wall')?></span>

								<b class="arrow icon-angle-down"></b>
							</a>

							<ul class="submenu">
								<li>
									<a href="index.php?m=admin&c=index&tpl=user">
										<i class="icon-double-angle-right"></i>
										<?echo L('wechat_wall_user')?>
									</a>
								</li>

								<li>
									<a href="index.php?m=admin&c=index&tpl=wechat">
										<i class="icon-double-angle-right"></i>
										<?echo L('wechat_wall_wcmsg')?>
									</a>
								</li>

								<li>
									<a href="treeview.html">
										<i class="icon-double-angle-right"></i>
										<?echo L('wechat_wall_dxmsg')?>
									</a>
								</li>

								<li>
									<a href="index.php?m=admin&c=index&tpl=topic">
										<i class="icon-double-angle-right"></i>
										<?echo L('wechat_wall_topic')?>
									</a>
								</li>
								<li>
									<a href="index.php?m=admin&c=index&tpl=shake">
										<i class="icon-double-angle-right"></i>
										<?echo L('shake')?>
									</a>
								</li>



							</ul>
						</li>

						<li>
							<a href="#" class="dropdown-toggle">
								<i class="icon-list"></i>
								<span class="menu-text"> <? echo L('awards')?></span>

								<b class="arrow icon-angle-down"></b>
							</a>

							<ul class="submenu">
								<li>
									<a href="index.php?m=admin&c=index&tpl=award">
										<i class="icon-double-angle-right"></i>
										<?echo L('award_list') ?>
									</a>
								</li>


							</ul>
						</li>

						<li>
							<a href="#" class="dropdown-toggle">
								<i class="icon-edit"></i>
								<span class="menu-text"> <? echo L('sysConfig')?></span>

								<b class="arrow icon-angle-down"></b>
							</a>

							<ul class="submenu">
								<li>
									<a href="form-elements.html">
										<i class="icon-double-angle-right"></i>
										<?echo L('userlist')?>
									</a>
								</li>

								<li>
									<a href="form-wizard.html">
										<i class="icon-double-angle-right"></i>
										<? echo L('displayConfig')?>
									</a>
								</li>

							</ul>
						</li>

					</ul><!-- /.nav-list -->

					<div class="sidebar-collapse" id="sidebar-collapse">
						<i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
					</div>

					<script type="text/javascript">
						try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
					</script>
				</div>

				<div class="main-content">
					<div class="breadcrumbs" id="breadcrumbs">
						<script type="text/javascript">
							try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
						</script>

						<ul class="breadcrumb">
							<li>
								<i class="icon-home home-icon"></i>
								<a href="#">首页</a>
							</li>
							<li class="active"><? echo L('admin_console')?></li>
						</ul><!-- .breadcrumb -->
					</div>

					<div class="page-content">
						<div class="page-header">
							<h1>
								<? echo L('admin_console')?>
								<small>
									<i class="icon-double-angle-right"></i>
									 查看
								</small>
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<div id="OperationTips">

									<div class="alert alert-block alert-success">
										<button type="button" class="close" data-dismiss="alert">
											<i class="icon-remove"></i>
										</button>

										<i class="icon-ok green"></i>

											<? echo L('welcome')?>
										<strong class="green">
											<? echo L('title')?>
										<small><?echo L('admin_version')?></small>
										</strong>
											,<?echo L('miao')?>.
										
							  		</div>
								</div>