<?php

session_start();

if ($_SESSION['user_key'] == ''):
    header('location: login.php?err=2');
endif;

include 'config/common.php';

$_SESSION['last_page'] = $_SERVER["PHP_SELF"];

if (isset($_SESSION['is_locked']) && $_SESSION['is_locked'] == 'Y'):
    header('location: lock-screen.php');
endif;

$get_user_info = 'SELECT um.id, um.fname, um.gender, um.avatar, um.lname, um.email, um.mobile, um.dob, um.country, urm.role_name, um.role_id FROM user_master um INNER JOIN user_role_master urm ON urm.id = um.role_id WHERE user_key = "' . $_SESSION['user_key'] . '"';
$user_info_res = $mysqli->query($get_user_info);
$user_info_row = mysqli_fetch_object($user_info_res);


/* set avatar */
$small_avatar = '';
if ($user_info_row->avatar == ''):
    if ($user_info_row->gender == 'm'):
        $small_avatar = 'business_user.png';
    else:
        $small_avatar = 'female_business_user.png';
    endif;
else:
    $small_avatar = $user_info_row->avatar;
endif;
/* set avatar */


/* get menu */
$set_meun = 'select amm.menu_name, amm.page_name, amm.menu_icon, um.*, urm.id as role_id from admin_menu_assign ama
inner join admin_menu_master amm on amm.id = ama.menu_id
inner join user_master um on um.id = ama.user_id
inner join user_role_master urm on um.role_id = urm.id
where amm.`status` = "A" and um.`status`="A" and um.role_id = "' . $user_info_row->role_id . '" ORDER BY amm.menu_order';
$menu_res = $mysqli->query($set_meun);

$menu = '';
if ($menu_res->num_rows > 0):
    while ($menu_row = mysqli_fetch_object($menu_res)):
        if (strpos($_SERVER['SCRIPT_NAME'], $menu_row->page_name . '.php')):
            $menu .= '<li>
					<a href="' . $menu_row->page_name . '.php" class="active">
						<i class="fa ' . $menu_row->menu_icon . '"></i>
						<span>' . ucfirst($menu_row->menu_name) . '</span>
					</a>
				</li>';
        else:
            $menu .= '<li>
					<a href="' . $menu_row->page_name . '.php">
						<i class="fa ' . $menu_row->menu_icon . '"></i>
						<span>' . ucfirst($menu_row->menu_name) . '</span>
					</a>
				</li>';
        endif;

    endwhile;
else:
    $menu = '<li>
					<a href="index.php">
						<i class="fa fa-dashboard"></i>
						<span>No menu is assigned to you.</span>
					</a>
				</li>';
endif;
/* get menu */


$header = '<!DOCTYPE html>
<html lang="en">
    <head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="shortcut icon" href="img/favicon.png" />

		<title>Admin Panel</title>

		<!-- Bootstrap core CSS -->
		<link href="css/bootstrap.min.css" rel="stylesheet" />
		<link href="css/bootstrap-reset.css" rel="stylesheet" />
		
		<!--external css-->
		<link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
		
		<!-- Custom styles for this template -->
		<link href="css/style.css" rel="stylesheet">
		<link href="css/style-responsive.css" rel="stylesheet" />
		
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
		<!--[if lt IE 9]>
		  <script src="js/html5shiv.js"></script>
		<![endif]-->
                
		<script src="js/jquery.js"></script>
		<script src="js/jquery-ui-1.9.2.custom.min.js"></script>
		<script src="js/idle.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
		<script src="js/jquery.scrollTo.min.js"></script>
		<script src="js/jquery.nicescroll.js" type="text/javascript"></script>
		<script src="js/respond.min.js" ></script>
		
		<script>
		jQuery.curCSS = jQuery.css;
			var awayCallback = function () {
				top.location.href="lock-screen.php";
			};

			var awayBackCallback = function () {
			};
			var onVisibleCallback = function () {
			};

			var onHiddenCallback = function () {
			};
			
			//this is one way of using it.
			/*
			 var idle = new Idle();
			 idle.onAway = awayCallback;
			 idle.onAwayBack = awayBackCallback;
			 idle.setAwayTimeout(2000);
			 idle.start();
			 */
			//this is another way of using it
			var idle = new Idle({
			onHidden: onHiddenCallback,
			onVisible: onVisibleCallback,
			onAway: awayCallback,
			onAwayBack: awayBackCallback,
			awayTimeout: 900000 //away with 15 minutes of inactivity
			}).start();
		</script>
                <style type="text/css">
                    label.error {
                        color: #b94a48;
                        font-weight: normal;
                        font-size: 12px;
                    }
                </style>
        </head>
	<body>
		<section id="container" >
			<!--header start-->
			<header class="header white-bg">
				<div class="sidebar-toggle-box">
					<div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
				</div>
				
				<!--logo start-->
				<a href="index.php" class="logo">Mumbai Artroom</a>
				<!--logo end-->
				
				<div class="top-nav">
					<!--user info start-->
					<ul class="nav pull-right top-menu">
						<!-- user login dropdown start-->
						<li class="dropdown">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<img alt="" src="img/avatar/' . $small_avatar . '" style="width:29px; height:29px;">
								<span class="username">' . ucfirst($user_info_row->fname) . ' ' . ucfirst($user_info_row->lname) . '</span>
								<b class="caret"></b>
							</a>
							<ul class="dropdown-menu logout">
								<li><a href="logout.php"><i class="fa fa-key"></i> Log Out</a></li>
							</ul>
						</li>
						<!-- user login dropdown end -->
					</ul>
					<!--search & user info end-->
				</div>
			</header>
			<!--header end-->
			<!--sidebar start-->
			<aside>
				<div id="sidebar"  class="nav-collapse ">
					<!-- sidebar menu start-->
					<ul class="sidebar-menu" id="nav-accordion">
						' . $menu . '
					</ul>
					<!-- sidebar menu end-->
				</div>
			</aside>
			<!--sidebar end-->';
?>