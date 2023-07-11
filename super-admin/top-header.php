<?php 
	$super_admin = SuperAdmin::find_by_id($session->super_admin_id);

	if($super_admin->log_time <= time() || $super_admin->log_session != $_COOKIE['PHPSESSID']){
		//redirect_to("logout.php");
	} else {
		$super_admin->log 			= 1;
		$super_admin->log_session 	= $_COOKIE['PHPSESSID'];
		$super_admin->log_time 		= time() + 600;
		$super_admin->save();
	}
?>
<!-- App favicon -->
<link rel="shortcut icon" href="assets/images/favicon.ico">
<!-- third party css -->
<link href="assets/css/vendor/britecharts.min.css" rel="stylesheet" type="text/css" />
<!-- App css -->
<link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
<link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
<link href="assets/css/custom.css" rel="stylesheet" type="text/css" />
<link href="assets/css/custom-main.css" rel="stylesheet" type="text/css" />



<!-- ========== TOP Sidebar Start ========== -->
<div class="navbar-custom">
<ul class="list-unstyled topbar-right-menu float-right mb-0">



<li class="dropdown notification-list">
<a class="nav-link dropdown-toggle nav-user-ms arrow-none mr-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="false"
aria-expanded="false"><span class="account-user-avatar"> <img src="assets/images/users/avatar-1.jpg" alt="user-image" class="rounded-circle arosid2"> <i class="mdi arosid mdi-chevron-down"></i></span></a>
<div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown ">
<!-- item-->
<div class=" dropdown-header noti-title">
<h6 class="text-overflow m-0">Welcome !</h6>
</div>

<!-- item-->
<a href="my-account.php" class="dropdown-item notify-item">
<i class="mdi mdi-account-circle"></i>
<span>My Account</span>                                    </a>

<!-- item-->
<a href="logout.php" class="dropdown-item notify-item">
<i class="mdi mdi-logout"></i>
<span>Logout</span>                                    </a>                                </div>
</li>
</ul>
<button class="button-menu-mobile open-left disable-btn">
<i class="mdi mdi-menu"></i>                        </button>
<div class="app-search">
<h2 class="app-search-tex">Hi <i><?php echo $super_admin->admin_name?></i></h2>
</div>
</div>
<!-- ========== TOP Sidebar Start ========== -->


            