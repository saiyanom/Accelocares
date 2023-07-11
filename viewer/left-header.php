
<?php
	$sql = "Select * from employee_location where emp_id = {$session->employee_id}";

	$emp_location = EmployeeLocation::find_by_sql($sql);
	
	$emp_sub_role_approval 	= "No";
	$emp_sub_role_capa 		= "No";

	foreach ($emp_location as $emp_location) {
		$emp_sub_role_header = $emp_location->emp_sub_role;
		
		if($emp_sub_role_header == "Viewer"){
			$emp_sub_role_approval = "Yes";
		} 
		
		if($emp_sub_role_header == "Viewer"){
			$emp_sub_role_capa = "Yes";
		} 
	}
?>

<!-- Start LOADER -->


<style type="text/css">
	
#loader {display: block;position: relative;left: 50%;top: 50%;width: 150px;height: 150px;margin: -75px 0 0 -75px;border-radius: 50%;border: 7px solid transparent;border-top-color: #71bf44;-webkit-animation: spin 1.7s linear infinite;animation: spin 1.7s linear infinite;z-index: 11;}
#loader:before {content: "";position: absolute;top: 5px;left: 5px;right: 5px;bottom: 5px;border-radius: 50%;border: 7px solid transparent;border-top-color: #e74c3c;-webkit-animation: spin-reverse .6s linear infinite;animation: spin-reverse .6s linear infinite;}
#loader:after {content: "";position: absolute;top: 15px;left: 15px;right: 15px;bottom: 15px;border-radius: 50%;border: 7px solid transparent;border-top-color: #f9c922;-webkit-animation: spin 1s linear infinite;animation: spin 1s linear infinite;}
#loader {height:150px;width:150px;	position:absolute;}
.mask {background-color:#fff;width:100%;height:100%; top:0;position:fixed;z-index:100000;}

@-webkit-keyframes spin {0% {-webkit-transform: rotate(0deg);}100% {-webkit-transform: rotate(360deg);}}@keyframes spin {0% {-webkit-transform: rotate(0deg);transform: rotate(0deg);}100% {-webkit-transform: rotate(360deg);transform: rotate(360deg);}}@-webkit-keyframes spin-reverse {0% {-webkit-transform: rotate(0deg);}100% {-webkit-transform: rotate(-360deg);}}@keyframes spin-reverse {0% {-webkit-transform: rotate(0deg);transform: rotate(0deg);}100% {-webkit-transform: rotate(-360deg);transform: rotate(-360deg);}}


</style>

<div class="mask"><div id="loader"> </div></div>


<!--END -->
<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">

<div class="slimscroll-menu">
<div class="btnmo"><button class="button-menu-mobile open-left disable-btn">
<i class="mdi mdi-menu"></i>                        </button></div>
<!-- LOGO -->
<a href="#" class="logo text-center">
<span class="logo-lg">
<img src="assets/images/logo.png" alt="" >                    </span>
<span class="logo-sm">
<img src="assets/images/logo_sm.png" alt="">                    </span>                </a>

<!--- Sidemenu -->
<ul class="metismenu side-nav">

<li class="side-nav-item">
<a href="index.php" class="side-nav-link">
<i class="dripicons-meter"></i>
<span> Dashboard </span></a>
</li>

<li class="side-nav-item">
<a href="javascript: void(0);" class="side-nav-link">
<i class="mdi mdi-clipboard-check"></i>
<span> Approval </span>
<span class="menu-arrow"></span>
</a>
<ul class="side-nav-second-level" aria-expanded="false">
	<?php 
		if($emp_sub_role_capa == "Yes" ){
	?>
		<li><a href="capa-approval.php">CAPA Approval </a></li>
	<?php } if($emp_sub_role_approval == "Yes") {?>
		<li><a href="approval.php">Credit Note Approval</a></li>
	<?php } ?>
</ul>
</li>


<li class="side-nav-item">
<a href="all-complaints.php" class="side-nav-link">
<i class="mdi mdi-file-document"></i>
<span> All Complaints  </span></a>
</li>

<li class="side-nav-item">
<?php
	if(strtolower($employee_reg->emp_email) == "mehernosh.percy@mahindra.com" || strtolower($employee_reg->emp_email) == "salvi.suvarna@mahindra.com" || strtolower($employee_reg->emp_email) == "issar.sumit@mahindra.com" || strtolower($employee_reg->emp_email) == "arora.vijay@mahindra.com"){
		echo "<a href='customer-cvc.php' class='side-nav-link'>";
	} else {
		echo "<a href='my-cvc.php' class='side-nav-link'>";
	}
?>

<i class="dripicons-browser"></i>
<span>CVC </span></a>
</li>

<li class="side-nav-item">
<a href="analytics.php" class="side-nav-link">
<i class="mdi mdi-chart-areaspline"></i>
<span> Analytics </span></a>
</li>

<li class="side-nav-item">
<a href="../employee/" class="side-nav-link">
<i class="dripicons-swap"></i>
<span> Employee </span></a>
</li>
<?php
	if($session->super_admin_id){
		$found_user = SuperAdmin::find_by_id($session->super_admin_id);
		if ($found_user){ 
			echo "
				<li class='side-nav-item'>
					<a href='../super-admin/' class='side-nav-link'>
					<i class='dripicons-swap'></i>
					<span> Super Admin </span></a>
				</li>
			";
		}
	}
?>		
<li class="side-nav-item">
<a href="mailto:CRM.ACCELO@MAHINDRA.COM?Subject=Feedback%20for%20CRM%20Portal" target="_blank" class="side-nav-link">
<i class="mdi mdi-email "></i>
<span> Feedback </span></a>
</li>
</ul>

<!-- End Sidebar -->

<div class="clearfix"></div>
</div>
<!-- Sidebar -left -->
</div>
<!-- ========== Left Sidebar Start ========== -->

            