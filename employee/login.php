<?php 


	ob_start();
	require_once("../includes/initialize.php"); 
	date_default_timezone_set('Asia/Calcutta');

	foreach ($_POST as $key => $value) {
		if (preg_match('/[\'"\^%*()}!{><;`=+]/', $value)){
			$session->message("Found Malicious Code."); redirect_to("login.php");
		} 
	}
	foreach ($_GET as $key => $value) {
		if (preg_match('/[\'"\^%*()}!{><;`=+]/', $value)){
			$session->message("Found Malicious Code."); redirect_to("login.php");
		} 
	}
	
	//$message = "";
	if ($session->is_employee_logged_in()) { 
		redirect_to("index.php"); 
	}
	
	// Remember to give your form's submit tag a name="submit" attribute!
	if (isset($_POST['employee_login'])) { // Form has been submitted.

		$user_name 		= trim($_POST['user_name']);
		$user_password 	= trim($_POST['user_password']);

		// Check database to see if username/password exist.
		$found_user = EmployeeReg::authenticate($user_name, $user_password);

		if ($found_user) {
			$session->employee_login($found_user);
			if($found_user->log_time > time()){
				$message = "You are Already Logged in, If not then wait 5 min to end Login Session";
			} else {
				$found_user->log 		 	= 1;
				$found_user->log_session 	= $_COOKIE['PHPSESSID'];
				$found_user->log_time 		= time() + (300000);
				if($found_user->save()){
					redirect_to("index.php");
				} else {
					$message = "Failed to Login, try again.";
				}
			}
		} else {
			// username/password combo was not found in the database
			$message = "Username/Password combination incorrect.";
		}

	} else { // Form has not been submitted.
		$message = output_message($message);
		$user_name = "";
		$user_password = "";			
		setcookie("PHPSESSID","",time()-3600,"/");
		$str = 'abcdefghijklmnopqrstuvwxyz1234567890';
		$shuffled = str_shuffle($str);
		$gen_cookie = substr($shuffled, 0, 32);
		setcookie("PHPSESSID",$gen_cookie,time()+3600 , "/");
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8" />
<title>Mahindra Accelo CRM</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta content=" " name="description" />
<meta content="Coderthemes" name="author" />
<!-- App favicon -->
<link rel="shortcut icon" href="assets/images/favicon.ico">

<!-- App css -->
<link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
<link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
<link href="assets/css/custom.css" rel="stylesheet" type="text/css" />
</head>

<body class="auth-fluid-pages pb-0">

<div class="auth-fluid">
<!--Auth fluid left content -->
<div class="auth-fluid-form-box login-boxleft">
<div class="login-box1">

<div class="logo-log">
<a href="#"> <img src="assets/images/accelo-logo.png"></a></div>

<div class="text-log">
<h2>LeadIng<br>steel<br>processor</h2>
<p>Across automotive, power and <br>home appliance verticals</p>
</div>

<div class="log-textfooter"><p>Copyright © 2019 | All rights reserved.</p></div>
</div>              
</div>
<!-- end auth-fluid-form-box-->

<!-- Auth fluid right content -->
<div class="auth-fluid-right text-center login-boxright">
<div class="align-items-center login-box2">

<div class="login-box alert fade show text-white <?php if($message == "Message"){echo "bg-success";} else {echo "bg-danger";}?>" 
	<?php if(empty($message)){echo "style='display:none;'";}?>>
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong><?php echo $message; ?></strong>
</div>	

<h2 class="log-v">Login</h2>  

<!-- form -->
<form action="login.php" method="post" class="login-lt-form" enctype="multipart/form-data" autocomplete="off">
    <div class="form-group">
        <input class="form-control form-my" type="text" id="validationCustom01" required="" name="user_name" placeholder="username">
    </div>
    <div class="form-group">
        <input class="form-control form-my" type="password" required="" id="password" placeholder="password">
        <input class="form-control form-my" type="hidden" required="" id="user_password" name="user_password" placeholder="password">
    </div>
    <div class="form-group">
		<!--<div class="float-left"><a href="#" class="text-muted "><small>Create an account</small></a></div>-->
		<div class=" float-right">   <a href="reset-password.php" class="text-muted"><small>Reset password </small></a> | <a href="#" data-toggle="modal" data-target="#help" class="text-muted"><small>Help</small></a></div>

		<div class="clerfix"></div>
	</div>
    
    <div class="form-group mb-0 text-center log-btn">
        <input type="submit" name="employee_login" class="btn btn-primary btn-block" value="Login" />
    </div>
    <!-- social-->
</form>
<!-- end form-->
</div> <!-- end .align-items-center.d-flex.h-100-->
</div>
<!-- end Auth fluid right content -->
</div>
<!-- end auth-fluid-->



<!-- App js -->
<script src="assets/js/app.min.js"></script>
<script src="assets/js/sha256.js"></script>

<script>
	function isValid(str) {
	    return !/[~`!#$%\^&*()+=\\[\]\\';/{}|\\":<>\?]/g.test(str);
	}

	$("input, textarea").keypress(function(event) {
	    var character = String.fromCharCode(event.keyCode);
	    return isValid(character);  
	});

	$("#password").keyup(function () {
	    var value = $(this).val();
	    $("#user_password").val(sha256_digest(value));
	}).keyup();
</script>
</body>
</html>