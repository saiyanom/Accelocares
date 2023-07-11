<?php 
	ob_start();
	require_once("../includes/initialize.php"); 

	$message = "";
	if ($session->is_employee_logged_in()) { 
		if($employee_reg->emp_role == "Approver"){
			$employee_reg = EmployeeReg::find_by_id($session->employee_id);
			redirect_to("index.php"); 
		}
	}
	
	// Remember to give your form's submit tag a name="submit" attribute!
	if (isset($_POST['employee_login'])) { // Form has been submitted.

		$user_name 		= trim($_POST['user_name']);
		$user_password 	= trim($_POST['user_password']);

		// Check database to see if username/password exist.
		$found_user = EmployeeReg::authenticate($user_name, $user_password);

		if ($found_user) {
			
			$employee_reg = EmployeeReg::find_by_id($found_user->id);

			if($employee_reg->emp_role == "Approver"){
				$session->employee_login($found_user);
				redirect_to("index.php"); 
			} else {
				$message = "Login with Approver ID";
			}
		} else {
			// username/password combo was not found in the database
			$message = "Username/Password combination incorrect.";
		}

	} else { // Form has not been submitted.
		$user_name = "";
		$user_password = "";
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8" />
<title>Mahindraaccelo</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta content=" " name="description" />
<meta content=" " name="author" />
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
<form action="login.php" method="post" class="login-lt-form" enctype="multipart/form-data">
    <div class="form-group">
        <input class="form-control form-my" type="text" id="validationCustom01" required="" name="user_name" placeholder="username">
    </div>
    <div class="form-group">
        <input class="form-control form-my" type="password" required="" id="password" name="user_password" placeholder="password">
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




<!-- Form pop up -->
<div class="modal fade" id="help" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">

<div class="modal-header pr-4 pl-4 border-bottom-0 d-block">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
<h4 class="modal-title">Help</h4>
</div>
<div class="help-pop">
<ul>
<li class="st-mo1">Step 1:</li>
<li class="st-mo2">Lorem Ipsum is simply dummy text of the printing</li>
<div class="clerfix"></div></ul>

<ul>
<li class="st-mo1">Step 2:</li>
<li class="st-mo2">Lorem Ipsum is simply dummy text of the printing</li>
<div class="clerfix"></div></ul>

<ul>
<li class="st-mo1">Step 3:</li>
<li class="st-mo2">Lorem Ipsum is simply dummy text of the printing</li>
<div class="clerfix"></div></ul>


</div>
    
    
</div> <!-- end modal-content-->
</div> <!-- end modal dialog-->
</div>
<!-- Form pop up -->





<!-- App js -->
<script src="assets/js/app.min.js"></script>
</body>
</html>