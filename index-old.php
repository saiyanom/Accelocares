<?php 
	ob_start();
	require_once("includes/initialize.php"); 
	
	if($_SERVER['SERVER_NAME'] == 'localhost'){

		echo "Login";
	}
	else{


		if(isset($_GET['login'])){

			$input = base64_decode($_GET['login']);

			//echo "<hr />";

			foreach (explode('|', $input) as $id){
				$user_email = $id;
				break;
			}
			
			
			$user_email = $user_email."@mahindra.com";
			
	    	$message = "";
			
			$str = 'abcdefghijklmnopqrstuvwxyz1234567890';
			$shuffled = str_shuffle($str);
			$gen_cookie = substr($shuffled, 0, 32);
			
			// Remember to give your form's submit tag a name="submit" attribute!
			if (isset($user_email)) { // Form has been submitted.
				
				

				// Check database to see if username/password exist.

				$found_admin = SuperAdmin::authenticate($user_email);

				$found_user = EmployeeReg::authenticate($user_email);
				
				

				if ($found_admin) {
					$found_admin->log 			= 0;
					$found_admin->log_session 	= time();
					$found_admin->log_time 		= 0;
					$found_admin->save();
					
					setcookie("PHPSESSID","",time()-3600,"/");
					setcookie("PHPSESSID",$gen_cookie,time()+3600,"/crm/administrator","",true,true);

					if($found_admin->log_time > time()){
						$message = "You are Already Logged in, If not then wait 5 min to end Login Session";
					} else {
						$found_admin->log_session = $gen_cookie;
						$found_admin->save();
						
						if ($found_user) {
							$found_user->log 			= 0;
							$found_user->log_session 	= time();
							$found_user->log_time 		= 0;
							$found_user->save();

							$session->employee_login($found_user);

							$employee_reg = EmployeeReg::find_by_id($found_user->id);
							//$employee_reg = EmployeeReg::find_by_id($session->employee_id);
							$emp_loc_sql = "Select * from employee_location where emp_id = {$employee_reg->id} AND emp_role = 'Approver'";

							$employee_location = EmployeeLocation::find_by_sql($emp_loc_sql);

							if($employee_location){
								//redirect_to("approver/index.php"); 
								setcookie("PHPSESSID","",time()-3600,"/");
								setcookie("PHPSESSID",$gen_cookie,time()+3600,"/crm/administrator","",true,true);

								if($found_user->log_time > time()){
									$message = "You are Already Logged in, If not then wait 5 min to end Login Session";
								} else {
									$found_user->log_session = $gen_cookie;
									$found_user->save();
									//redirect_to("approver/index.php?id=".$found_user->id);			
								}
							} else {
								setcookie("PHPSESSID","",time()-3600,"/");
								setcookie("PHPSESSID",$gen_cookie,time()+3600,"/crm/administrator","",true,true);

								if($found_user->log_time > time()){
									$message = "You are Already Logged in, If not then wait 5 min to end Login Session";
								} else {
									$found_user->log_session = $gen_cookie;
									$found_user->save();
									//redirect_to("employee/index.php?id=".$found_user->id);			
								}
							}

						}

						redirect_to("super-admin/index.php?id=".$found_admin->id);			
					}
				}
				
				

				if ($found_user) {
					$found_user->log 			= 0;
					$found_user->log_session 	= time();
					$found_user->log_time 		= 0;
					$found_user->save();

					

					$session->employee_login($found_user);

					$employee_reg = EmployeeReg::find_by_id($found_user->id);
					//$employee_reg = EmployeeReg::find_by_id($session->employee_id);
					$emp_loc_sql = "Select * from employee_location where emp_id = {$employee_reg->id} AND emp_role = 'Approver'";

					$employee_location = EmployeeLocation::find_by_sql($emp_loc_sql);

					if($employee_location){
						//redirect_to("approver/index.php"); 
						setcookie("PHPSESSID","",time()-3600,"/");
						setcookie("PHPSESSID",$gen_cookie,time()+3600,"/crm/administrator","",true,true);

						if($found_user->log_time > time()){
							$message = "You are Already Logged in, If not then wait 5 min to end Login Session";
						} else {
							$found_user->log_session = $gen_cookie;
							$found_user->save();
							redirect_to("approver/index.php?id=".$found_user->id);			
						}
					} else {
						setcookie("PHPSESSID","",time()-3600,"/");
						setcookie("PHPSESSID",$gen_cookie,time()+3600,"/crm/administrator","",true,true);

						if($found_user->log_time > time()){
							$message = "You are Already Logged in, If not then wait 5 min to end Login Session";
						} else {
							$found_user->log_session = $gen_cookie;
							$found_user->save();
							redirect_to("employee/index.php?id=".$found_user->id);			
						}
					}

				} else {
					// username/password combo was not found in the database
					$message = "{$user_email} not found";
				}

			} else { // Form has not been submitted.
				$user_name = "";
				$user_password = "";
				redirect_to("https://www.mahindrarise.com/get_auth_asp_new.php ");
			}

		} else {
			redirect_to("https://www.mahindrarise.com/get_auth_asp_new.php");
		}
	}


	
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8" />
<title>Mahindraaccelo | Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta content=" " name="description" />
<meta content=" " name="author" />
<!-- App favicon -->
<link rel="shortcut icon" href="assets/images/favicon.ico">

<!-- App css -->
<link href="employee/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
<link href="employee/assets/css/app.min.css" rel="stylesheet" type="text/css" />
<link href="employee/assets/css/custom.css" rel="stylesheet" type="text/css" />
<script src="employee/assets/js/app.min.js"></script>	
</head>
<body>
	<div align="center" class="login-box alert fade show text-white <?php if($message == "Message"){echo "bg-success";} else {echo "bg-danger";}?>" 
		<?php if(empty($message)){echo "style='display:none;'";}else {echo "style='width:400px; margin: 10% auto 0 auto;'";}?>>
		<strong><?php echo $message; ?></strong>
	</div>
	<div style='width:400px; margin: 10px auto 0 auto;'><a href="logout.php" class="btn btn-success btn-block">Try Again</a></div>
</body>