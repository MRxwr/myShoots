<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title>Admin Panel - <?php echo $lang['meta_title'] ?></title>
	<meta title="description" content="<?php echo $lang['meta_description'] ?>">
	<meta title="keywords" content="<?php echo $lang['meta_keywords'] ?>">
	<meta title="Author" content="<?php echo $lang['author'] ?>">
	<meta name="author" content=""/>
	
	<!-- Favicon -->
	<link rel="shortcut icon" href="favicon.ico">
	<link rel="icon" href="favicon.ico" type="image/x-icon">
	
	<!-- Bootstrap Wysihtml5 css -->
	<link rel="stylesheet" href="assets/vendors/bower_components/bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.css" />
		<!-- Data table CSS -->
	<link href="assets/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>	
	<!-- Custom CSS -->
	<link href="assets/style/dist/css/style.css" rel="stylesheet" type="text/css">
    <link href="assets/style/dist/css/mdtimepicker.css" rel="stylesheet" type="text/css">
    <!-- Calendar CSS -->
		<link href="assets/vendors/bower_components/fullcalendar/dist/fullcalendar.css" rel="stylesheet" type="text/css"/>
		
	<!-- Bootstrap Dropify CSS -->
		<link href="assets/vendors/bower_components/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css"/>
          <script type="text/javascript" src="https://code.jquery.com/jquery-1.10.1.js"></script>
        
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.25/angular.min.js"></script>
		<style>
		  #minusButton {
				margin-top: 32px;
				height: 41px;
			}
		</style>
		<?php  $events = array(); ?>
</head>

<body>
	<!--Preloader-->
	<div class="preloader-it">
		<div class="la-anim-1"></div>
	</div>
	<!--/Preloader-->
    <div class="wrapper  theme-6-active pimary-color-green">
	
		<!-- Top Menu Items -->
		<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="mobile-only-brand pull-left">
				<div class="nav-header pull-left">
					<div class="logo-wrap">
						<a href="#">
							<img class="brand-img" src="assets/img/logo.png" alt="brand"/>
							<span class="brand-text">MyShoot</span>
						</a>
					</div>
				</div>	
				<a id="toggle_nav_btn" class="toggle-left-nav-btn inline-block ml-20 pull-left" href="javascript:void(0);"><i class="zmdi zmdi-menu"></i></a>
				<form id="search_form" role="search" class="top-nav-search collapse pull-left">
					<div class="input-group">
						<input type="text" name="example-input1-group2" class="form-control" placeholder="Search">
						<span class="input-group-btn">
						<button type="button" class="btn  btn-default"  data-target="#search_form" data-toggle="collapse" aria-label="Close" aria-expanded="true"><i class="zmdi zmdi-search"></i></button>
						</span>
					</div>
				</form>
			</div>
			<div id="mobile_only_nav" class="mobile-only-nav pull-right">
				<ul class="nav navbar-right top-nav pull-right">
					<li class="dropdown auth-drp">
						<a href="#" class="dropdown-toggle pr-0" data-toggle="dropdown"><img src="assets/img/user1.png" alt="user_auth" class="user-auth-img img-circle"/><span class="user-online-status"></span></a>
						<ul class="dropdown-menu user-auth-dropdown" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
							<li>
								<a href="index.php?page=profile"><i class="zmdi zmdi-account"></i><span>Profile</span></a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="index.php?page=logout"><i class="zmdi zmdi-power"></i><span>Log Out</span></a>
							</li>
						</ul>
					</li>
				</ul>
			</div>	
		</nav>
		<!-- /Top Menu Items -->
		
		<!-- Left Sidebar Menu -->
		<?php include('left-sidebar.php');?>
		<!-- /Left Sidebar Menu -->
		
		<!-- Right Sidebar Menu -->
		<?php include('right-sidebar.php');?>
		<!-- /Right Sidebar Menu -->
		
		
		
		<!-- Right Sidebar Backdrop -->
		<div class="right-sidebar-backdrop"></div>
		<!-- /Right Sidebar Backdrop -->