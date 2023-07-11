<?php
	ob_start();
	require_once("../includes/initialize.php"); 
	

    foreach ($_POST as $key => $value) {
        if (preg_match('/[\'"\^%*()}!{><;`=+]/', $value)){
            $session->message("Found Malicious Code."); redirect_to("index.php");
        } 
    }
    foreach ($_GET as $key => $value) {
        if (preg_match('/[\'"\^%*()}!{><;`=+]/', $value)){
            $session->message("Found Malicious Code."); redirect_to("index.php");
        }
    }



	if(!isset($_SESSION['employee_id']) && isset($_GET['id']) && !empty($_GET['id'])){
		$found_user 			= EmployeeReg::find_by_id($_GET['id']);
		
		if($found_user->log_time == 0 || $found_user->log_time < time()){
			if($_COOKIE['PHPSESSID'] == $found_user->log_session){
				$session->employee_login($found_user);		
			
				$found_user->log 		 	= 1;
				$found_user->log_time 		= time() + (300);
				$found_user->log_session 	= $_COOKIE['PHPSESSID'];
				if($found_user->save()){
					
					$emp_loc_sql = "Select * from employee_location where emp_id = {$found_user->id} AND emp_sub_role != 'Employee' Limit 1";
					$employee_location = EmployeeLocation::find_by_sql($emp_loc_sql);
					
					if(!$employee_location){
						redirect_to("index.php?logout"); 
					} else {
						redirect_to("index.php");
					}

					
				} else {
					$session->message("Failed to Login, try again."); redirect_to("logout.php");
				}
			} else {
				$session->message("PHP Session You are Already Logged in, If not then wait 5 min to end Login Session"); 
				redirect_to("login.php");
			}
		} else {
			$session->message("You are Already Logged in, If not then wait 5 min to end Login Session"); 
			redirect_to("logout.php");
		}
	}

	if (!$session->is_employee_logged_in()) { redirect_to("logout.php"); }

	$employee_reg = EmployeeReg::find_by_id($session->employee_id);






/*

	$employee_reg = EmployeeReg::find_by_id($session->employee_id);
	if (!$session->is_employee_logged_in()) { redirect_to("logout.php"); }
	if ($session->is_employee_logged_in()){ 
		
		$emp_loc_sql = "Select * from employee_location where emp_id = {$employee_reg->id} AND emp_sub_role != 'Employee' Limit 1";
		
		$employee_location = EmployeeLocation::find_by_sql($emp_loc_sql);
		
		print_r($employee_location);
		
		//if(!$employee_location){
			//redirect_to("index.php?logout"); 
		//}
	}
*/
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8" />
<title>Mahindra Accelo CRM</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta content="" name="description" />
<meta content=" " name="author" />
</head>
<!-- sidebar-enable -->
<body class="larged" data-keep-enlarged="true">

<!-- Begin page -->
<div class="wrapper">

<!-- ========== LEFT HEADER Sidebar Start ========== -->
<?php include 'left-header.php'?>
<!-- ========== LEFT HEADER Sidebar Start ========== -->

<!-- ============================================================== --><!-- Start Page Content here --><!-- ============================================================== -->

<div class="content-page">
<div class="content">

<!-- ========== TOP Sidebar Start ========== -->
<?php include 'top-header.php'?>
<!-- ========== TOP Sidebar Start ========== -->



<!-- Start Content-->
<div class="container-fluid">

<div class="">
<div class="comp-box">
<ul>
	<h2>Approval Note</h2>
<li>
<div class="comp-left"><h2><?php

	$sql = "Select * from employee_location where emp_id = {$session->employee_id} AND emp_sub_role != 'Employee' AND emp_sub_role != 'Viewer' ";
	$employee_loc = EmployeeLocation::find_by_sql($sql);
	
	foreach ($employee_loc as $employee_loc) {
		if($employee_loc->emp_sub_role == "CRM - Head"){
			$sql = "Select * from complaint where create_approval_note = 'Yes' AND cna_crm_head = ''";
		} else if($employee_loc->emp_sub_role == "Commercial Head"){
			$sql = "Select * from complaint where create_approval_note = 'Yes' AND cna_commercial_head = ''";
		} else if($employee_loc->emp_sub_role == "Plant Chief - AN"){
			$sql = "Select * from complaint where create_approval_note = 'Yes' AND cna_plant_chief = ''";
		} else if($employee_loc->emp_sub_role == "Sales Head"){
			$sql = "Select * from complaint where create_approval_note = 'Yes' AND cna_sales_head = ''";
		} else if($employee_loc->emp_sub_role == "CFO"){
			$sql = "Select * from complaint where create_approval_note = 'Yes' AND cna_cfo = ''";
		} else if($employee_loc->emp_sub_role == "MD"){
			$sql = "Select * from complaint where create_approval_note = 'Yes' AND cna_md = ''";
		}
		
	}
	
	$num =0;
	$complaint = Complaint::find_by_sql($sql);
	$complaint_id = "";
	foreach($complaint as $complaint){
		$product_id = Product::find_product_id($complaint->business_vertical,$complaint->plant_location,$complaint->product);
		if($product_id){
			$emp_sql = "Select * from employee_location where emp_id = '{$employee_reg->id}' AND emp_sub_role != 'Employee' AND emp_sub_role != 'Viewer' ";
			$emp_location = EmployeeLocation::find_by_sql($emp_sql);
			foreach($emp_location as $emp_location){
				if($product_id->id == $emp_location->product_id){
					if($complaint_id != $complaint->id){
						$num++;
					}
					$complaint_id = $complaint->id;
				}
			}
		}
	} echo $complaints_open = $num;
?></h2><p>Open Approval</p></div>
<div class="comp-right"><img src="assets/images/complaints/1.png"></div>
<div class="clerfix"></div>
<div class="val"><a href="approval.php?status=Open" class="color-gr1">View all</a></div>
<!--<div class="val"><a href="approval.php" class="color-gr1">View all</a></div>-->
</li>

<li>
<div class="comp-left"><h2><?php 

	$sql = "Select * from employee_location where emp_id = {$session->employee_id} AND emp_sub_role != 'Employee' AND emp_sub_role != 'Viewer' ";
	$employee_loc = EmployeeLocation::find_by_sql($sql);
	
	foreach ($employee_loc as $employee_loc) {
		if($employee_loc->emp_sub_role == "CRM - Head"){
			$sql = "Select * from complaint where create_approval_note = 'Yes' AND cna_crm_head != ''";
		} else if($employee_loc->emp_sub_role == "Commercial Head"){
			$sql = "Select * from complaint where create_approval_note = 'Yes' AND cna_commercial_head != ''";
		} else if($employee_loc->emp_sub_role == "Plant Chief - AN"){
			$sql = "Select * from complaint where create_approval_note = 'Yes' AND cna_plant_chief != ''";
		} else if($employee_loc->emp_sub_role == "Sales Head"){
			$sql = "Select * from complaint where create_approval_note = 'Yes' AND cna_sales_head != ''";
		} else if($employee_loc->emp_sub_role == "CFO"){
			$sql = "Select * from complaint where create_approval_note = 'Yes' AND cna_cfo != ''";
		} else if($employee_loc->emp_sub_role == "MD"){
			$sql = "Select * from complaint where create_approval_note = 'Yes' AND cna_md != ''";
		}
	}
	
	$num =0;
	$complaint = Complaint::find_by_sql($sql);
	$complaint_id = "";
	foreach($complaint as $complaint){
		$product_id = Product::find_product_id($complaint->business_vertical,$complaint->plant_location,$complaint->product);
		if($product_id){
			$emp_sql = "Select * from employee_location where emp_id = '{$employee_reg->id}' AND emp_sub_role != 'Employee' AND emp_sub_role != 'Viewer' ";
			$emp_location = EmployeeLocation::find_by_sql($emp_sql);
			foreach($emp_location as $emp_location){
				if($product_id->id == $emp_location->product_id){
					if($complaint_id != $complaint->id){
						$num++;
					}
					$complaint_id = $complaint->id;
				}
			}
		}
	} echo $complaints_closed = $num;
?></h2><p>Closed Approval</p></div>
<div class="comp-right"><img src="assets/images/complaints/2.png"></div>
<div class="clerfix"></div>
<div class="val"><a href="approval.php?status=Closed" class="color-gr2">View all</a></div>
<!--<div class="val"><a href="approval.php" class="color-gr2">View all</a></div>-->
</li>

<li>
<div class="comp-left"><h2><?php
		
	$sql = "Select * from employee_location where emp_id = {$session->employee_id} AND emp_sub_role != 'Employee' AND emp_sub_role != 'Viewer' ";
	$employee_loc = EmployeeLocation::find_by_sql($sql);
	
	foreach ($employee_loc as $employee_loc) {
		if($employee_loc->emp_sub_role == "CRM - Head"){
			$sql = "Select * from complaint where create_approval_note = 'Yes'";
		} else if($employee_loc->emp_sub_role == "Commercial Head"){
			$sql = "Select * from complaint where create_approval_note = 'Yes'";
		} else if($employee_loc->emp_sub_role == "Plant Chief - AN"){
			$sql = "Select * from complaint where create_approval_note = 'Yes'";
		} else if($employee_loc->emp_sub_role == "Sales Head"){
			$sql = "Select * from complaint where create_approval_note = 'Yes'";
		} else if($employee_loc->emp_sub_role == "CFO"){
			$sql = "Select * from complaint where create_approval_note = 'Yes'";
		} else if($employee_loc->emp_sub_role == "MD"){
			$sql = "Select * from complaint where create_approval_note = 'Yes'";
		}
		
	}
	
	$num =0;
	$complaint = Complaint::find_by_sql($sql);
	$complaint_id = "";
	foreach($complaint as $complaint){
		$product_id = Product::find_product_id($complaint->business_vertical,$complaint->plant_location,$complaint->product);
		if($product_id){
			$emp_sql = "Select * from employee_location where emp_id = '{$employee_reg->id}' AND emp_sub_role != 'Employee' AND emp_sub_role != 'Viewer' ";
			$emp_location = EmployeeLocation::find_by_sql($emp_sql);
			foreach($emp_location as $emp_location){
				if($product_id->id == $emp_location->product_id){
					if($complaint_id != $complaint->id){
						$num++;
					}
					$complaint_id = $complaint->id;
				}
			}
		}
	} echo $complaints_all = $num;
?></h2><p>Total Approval</p></div>
<div class="comp-right"><img src="assets/images/complaints/3.png"></div>
<div class="clerfix"></div>
<div class="val"><a href="approval.php" class="color-gr3">View all</a></div>
</li>

<div class="clerfix"></div>
</ul>
</div>
</div>


<div class="">
<div class="comp-box">
<ul>
	<h2>CAPA Approval</h2>
<li>
<div class="comp-left"><h2><?php
		
	$sql = "Select * from employee_location where emp_id = {$session->employee_id} AND emp_sub_role != 'Employee' AND emp_sub_role != 'Viewer' ";
	$employee_loc = EmployeeLocation::find_by_sql($sql);
	
	foreach ($employee_loc as $employee_loc) {
		if($employee_loc->emp_sub_role == "Quality Assurance"){
			$capa_sql = "Select * from complaint where create_capa_doc = 'Yes' AND capa_qa = ''";
		} else if($employee_loc->emp_sub_role == "Plant Head"){
			$capa_sql = "Select * from complaint where create_capa_doc = 'Yes' AND capa_ph = ''";
		} else if($employee_loc->emp_sub_role == "Plant Chief - CN"){
			$capa_sql = "Select * from complaint where create_capa_doc = 'Yes' AND capa_pc = ''";
		} else if($employee_loc->emp_sub_role == "Management Representative"){
			$capa_sql = "Select * from complaint where create_capa_doc = 'Yes' AND capa_mr = ''";
		} else {
			$capa_sql = "";
		}
		$emp_sub_role = $employee_loc->emp_sub_role;
	}
	
	$num =0;
	if($capa_sql){
		$capa_complaint = Complaint::find_by_sql($capa_sql);
		$complaint_id = "";
		foreach($capa_complaint as $capa_complaint){
			$product_id = Product::find_product_id($capa_complaint->business_vertical,$capa_complaint->plant_location,$capa_complaint->product);
			if($product_id){
				$emp_sql = "Select * from employee_location where emp_id = '{$employee_reg->id}' AND emp_sub_role = '{$emp_sub_role}'";
				$emp_location = EmployeeLocation::find_by_sql($emp_sql);
				foreach($emp_location as $emp_location){
					if($product_id->id == $emp_location->product_id){
						if($complaint_id != $capa_complaint->id){
							$num++;
						}
						$complaint_id = $capa_complaint->id;
					}
				}
			}
		} 
	} echo $capa_closed = $num;
	
?></h2><p>Open Approval</p></div>
<div class="comp-right"><img src="assets/images/complaints/1.png"></div>
<div class="clerfix"></div>
<div class="val"><a href="capa-approval.php?status=Open" class="color-gr1">View all</a></div>
<!--<div class="val"><a href="capa-approval.php" class="color-gr1">View all</a></div>-->
</li>

<li>
<div class="comp-left"><h2><?php
		
	$sql = "Select * from employee_location where emp_id = {$session->employee_id} AND emp_sub_role != 'Employee' AND emp_sub_role != 'Viewer' ";
	$employee_loc = EmployeeLocation::find_by_sql($sql);
	
	foreach ($employee_loc as $employee_loc) {
		if($employee_loc->emp_sub_role == "Quality Assurance"){
			$capa_sql = "Select * from complaint where create_capa_doc = 'Yes' AND capa_qa != ''";
		} else if($employee_loc->emp_sub_role == "Plant Head"){
			$capa_sql = "Select * from complaint where create_capa_doc = 'Yes' AND capa_ph != ''";
		} else if($employee_loc->emp_sub_role == "Plant Chief - CN"){
			$capa_sql = "Select * from complaint where create_capa_doc = 'Yes' AND capa_pc != ''";
		} else if($employee_loc->emp_sub_role == "Management Representative"){
			$capa_sql = "Select * from complaint where create_capa_doc = 'Yes' AND capa_mr != ''";
		} else {
			$capa_sql = "";
		}
	}
	
	$num =0;
	if($capa_sql){
		$capa_complaint = Complaint::find_by_sql($capa_sql);
		$complaint_id = "";
		foreach($capa_complaint as $capa_complaint){
			$product_id = Product::find_product_id($capa_complaint->business_vertical,$capa_complaint->plant_location,$capa_complaint->product);
			if($product_id){
				$emp_sql = "Select * from employee_location where emp_id = '{$employee_reg->id}' AND emp_sub_role = '{$emp_sub_role}'";
				$emp_location = EmployeeLocation::find_by_sql($emp_sql);
				foreach($emp_location as $emp_location){
					if($product_id->id == $emp_location->product_id){
						if($complaint_id != $capa_complaint->id){
							$num++;
						}
						$complaint_id = $capa_complaint->id;
					}
				}
			}
		} 
	} echo $capa_closed = $num;
?></h2><p>Closed Approval</p></div>
<div class="comp-right"><img src="assets/images/complaints/2.png"></div>
<div class="clerfix"></div>
<div class="val"><a href="capa-approval.php?status=Closed" class="color-gr2">View all</a></div>
<!--<div class="val"><a href="capa-approval.php" class="color-gr2">View all</a></div>-->
</li>

<li>
<div class="comp-left"><h2><?php
		
	$sql = "Select * from employee_location where emp_id = {$session->employee_id} AND emp_sub_role != 'Employee' AND emp_sub_role != 'Viewer' ";
	$employee_loc = EmployeeLocation::find_by_sql($sql);
	
	foreach ($employee_loc as $employee_loc) {
		if($employee_loc->emp_sub_role == "Quality Assurance"){
			$capa_sql = "Select * from complaint where create_capa_doc = 'Yes'";
		} else if($employee_loc->emp_sub_role == "Plant Head"){
			$capa_sql = "Select * from complaint where create_capa_doc = 'Yes'";
		} else if($employee_loc->emp_sub_role == "Plant Chief - CN"){
			$capa_sql = "Select * from complaint where create_capa_doc = 'Yes'";
		} else if($employee_loc->emp_sub_role == "Management Representative"){
			$capa_sql = "Select * from complaint where create_capa_doc = 'Yes'";
		} else {
			$capa_sql = "";
		}
	}
	
	$num =0;
	if($capa_sql){
		$capa_complaint = Complaint::find_by_sql($capa_sql);
		$complaint_id = "";
		foreach($capa_complaint as $capa_complaint){
			
			$product_id = Product::find_product_id($capa_complaint->business_vertical,$capa_complaint->plant_location,$capa_complaint->product);
			if($product_id){
				$emp_sql = "Select * from employee_location where emp_id = '{$employee_reg->id}' AND emp_sub_role = '{$emp_sub_role}'";
				$emp_location = EmployeeLocation::find_by_sql($emp_sql);
				foreach($emp_location as $emp_location){
					if($product_id->id == $emp_location->product_id){
						if($complaint_id != $capa_complaint->id){
							$num++;
						}
						$complaint_id = $capa_complaint->id;
					}
				}
			}
		} 
	} echo $capa_all = $num;
?></h2><p>Total Approval</p></div>
<div class="comp-right"><img src="assets/images/complaints/3.png"></div>
<div class="clerfix"></div>
<div class="val"><a href="capa-approval.php" class="color-gr3">View all</a></div>
</li>

<div class="clerfix"></div>
</ul>
</div>
</div>



</div>
<!-- container -->


</div>
<!-- content -->

<!-- Footer Start -->
<?php include 'footer.php'?>
<!-- end Footer -->
</div>

<!-- ============================================================== -->
<!-- End Page content -->
<!-- ============================================================== -->
</div>
<!-- END wrapper -->


</body>
</html>


<!-- third party:js -->
<script src="assets/js/vendor/d3.min.js"></script>
<script src="assets/js/vendor/britecharts.min.js"></script>
<!-- third party end -->
<!-- demo:js 
<script src="assets/js/pages/demo.britechart.js"></script>
<!-- demo end -->

<!-- third party js -->
<script src="assets/js/vendor/Chart.bundle.min.js"></script>
<!-- third party js ends -->
<!-- demo app 
<script src="assets/js/pages/demo.chartjs.js"></script>
<!-- end demo js-->
<!-- third party:js -->
<script src="assets/js/vendor/apexcharts.min.js"></script>
<!-- third party end -->
<!-- demo:js 
<script src="assets/js/pages/demo.apex-radialbar.js"></script>
<!-- demo end -->
<!-- third party:js -->
<script src="assets/js/vendor/apexcharts.min.js"></script>
<!-- third party end -->
<!-- demo:js 
<script src="assets/js/pages/demo.apex-bar.js"></script>
<!-- demo end -->

<?php
	//$bv_auto 			= Complaint::count_business_vertical("Auto");
	//$bv_crno 			= Complaint::count_business_vertical("CRNO");
	//$bv_crgo 			= Complaint::count_business_vertical("CRGO");
	/*
	$emp_status_new 	= Complaint::count_emp_status("New");
	$emp_status_vc 		= Complaint::count_emp_status("Visit Confirmed");
	$emp_status_vnc 	= Complaint::count_emp_status("Visit Not Confirmed");
	$emp_status_vd 		= Complaint::count_emp_status("Visit Done");
	$emp_status_vnd 	= Complaint::count_emp_status("Visit Not Done");
	$emp_status_ca 		= Complaint::count_emp_status("Complaint Accepted");
	$emp_status_cr 		= Complaint::count_emp_status("Complaint Rejected");
	$emp_status_cp 		= Complaint::count_emp_status("Complaint Pending");
	$emp_status_cp 		= Complaint::count_emp_status("CAPA Shared");
	$emp_status_cns 	= Complaint::count_emp_status("Credit Note Shared");
	$emp_status_cc 		= Complaint::count_emp_status("Complaint Closed");
	*/
	//$source_mill 		= Complaint::count_identify_source("Mill");
	//$source_plant 		= Complaint::count_identify_source("Plant");
	
?>
<script>

var options = {
    chart: {
        height: 380,
        type: "bar",
        toolbar: {
            show: !1
        }
    },
    plotOptions: {
        bar: {
            horizontal: !0
        }
    },
    dataLabels: {
        enabled: !1
    },
    series: [{
		<?php echo "data: [{$source_plant}, {$source_mill}]"; ?>
    }],
    colors: ["#0acf97"],
    xaxis: {
		<?php echo "categories: ['Plant {$source_plant}', 'Mill {$source_mill}']"; ?>
    },
    states: {
        hover: {
            filter: "none"
        }
    },
    grid: {
        borderColor: "#f1f3fa"
    }
};
(chart = new ApexCharts(document.querySelector("#basic-bar"), options)).render();
	
	
	
var 
options = {
    chart: {
        height: 380,
        width: 380,
        type: "radialBar"
    },
    plotOptions: {
        radialBar: {
            offsetY: -30,
            startAngle: 0,
            endAngle: 270,
            hollow: {
                margin: 5,
                size: "30%",
                background: "transparent",
                image: void 0
            },
            dataLabels: {
                name: {
                    show: !1
                },
                value: {
                    show: !1
                }
            }
        }
    },
    colors: ["#0acf97", "#727cf5", "#fa5c7c", "#ffbc00"],
	<?php echo "series: [{$bv_auto}, {$bv_crno}, {$bv_crgo}]"?>,
    labels: ["Auto", "CRNO", "CRGO"],
    legend: {
        show: !0,
        floating: !0,
        fontSize: "12px",
        position: "left",
        verticalAlign: "top",
        textAnchor: "end",
        labels: {
            useSeriesColors: !0
        },
        markers: {
            size: 0
        },
        formatter: function(e, a) {
            return e + ":  " + a.globals.series[a.seriesIndex]
        },
        itemMargin: {
            vertical: 0
        },
        containerMargin: {
            left: 180,
            top: 8
        }
    },
    responsive: [{
        breakpoint: 380,
        options: {
            chart: {
                height: 240,
                width: 240
            },
            legend: {
                show: !1
            }
        }
    }]
};
(chart = new ApexCharts(document.querySelector("#circle-angle-radial"), options)).render();
	
	
!function(r) {
    "use strict";
    var a = function() {
        this.$body = r("body"), this.charts = []
    };
    a.prototype.respChart = function(a, t, e, o) {
        var s = Chart.controllers.doughnut.prototype.draw;
        Chart.controllers.doughnut = Chart.controllers.doughnut.extend({
            draw: function() {
                s.apply(this, arguments);
                var r = this.chart.chart.ctx,
                    a = r.fill;
                r.fill = function() {
                    r.save(), r.shadowColor = "rgba(0,0,0,0.03)", r.shadowBlur = 4, r.shadowOffsetX = 0, r.shadowOffsetY = 3, a.apply(this, arguments), r.restore()
                }
            }
        });
        var i = a.get(0).getContext("2d"),
            d = r(a).parent();
        return function() {
            var n;
            switch (a.attr("width", r(d).width()), t) {
                case "Doughnut":
				n = new Chart(i, {
					type: "doughnut",
					data: e,
					options: o
				});
				break;
            }
            return n
        }()
    }, a.prototype.initCharts = function() {
        var a = [];
        
		var complaints_open 	= "<?php echo $complaints_open; ?>";
		var complaints_closed 	= "<?php echo $complaints_closed; ?>";
		var complaints_all 		= "<?php echo $complaints_all; ?>";
        if (r("#donut-chart-example").length > 0) {
            a.push(this.respChart(r("#donut-chart-example"), "Doughnut", {
				labels: ["Open - "+complaints_open, "Closed - "+complaints_closed],
                datasets: [{
					<?php echo "data: [{$complaints_open}, {$complaints_closed}]"; ?>,
                    backgroundColor: ["#0fb3f0", "#71bf44"],
                    borderColor: "transparent",
                    borderWidth: "3"
                }]
            }, {
                maintainAspectRatio: !1,
                cutoutPercentage: 60,
                legend: {
                    display: !1
                }
            }))
        }
        
        return a
    }, a.prototype.init = function() {
        var a = this;
        Chart.defaults.global.defaultFontFamily = '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif', a.charts = this.initCharts(), r(window).on("resize", function(t) {
            r.each(a.charts, function(r, a) {
                try {
                    a.destroy()
                } catch (r) {}
            }), a.charts = a.initCharts()
        })
    }, r.ChartJs = new a, r.ChartJs.Constructor = a
}(window.jQuery),
function(r) {
    "use strict";
    r.ChartJs.init()
}(window.jQuery);
	
!function(r) {
    "use strict";
    var a = function() {
        this.$body = r("body"), this.charts = []
    };
    a.prototype.respChart = function(a, t, e, o) {
        var s = Chart.controllers.doughnut.prototype.draw;
        Chart.controllers.doughnut = Chart.controllers.doughnut.extend({
            draw: function() {
                s.apply(this, arguments);
                var r = this.chart.chart.ctx,
                    a = r.fill;
                r.fill = function() {
                    r.save(), r.shadowColor = "rgba(0,0,0,0.03)", r.shadowBlur = 4, r.shadowOffsetX = 0, r.shadowOffsetY = 3, a.apply(this, arguments), r.restore()
                }
            }
        });
        var i = a.get(0).getContext("2d"),
            d = r(a).parent();
        return function() {
            var n;
            switch (a.attr("width", r(d).width()), t) {
                case "Doughnut":
				n = new Chart(i, {
					type: "doughnut",
					data: e,
					options: o
				});
				break;
            }
            return n
        }()
    }, a.prototype.initCharts = function() {
        var a = [];
        
		var capa_open 	= "<?php echo $capa_open; ?>";
		var capa_closed 	= "<?php echo $capa_closed; ?>";
		var capa_all 		= "<?php echo $capa_all; ?>";
        if (r("#donut-total-capa").length > 0) {
            a.push(this.respChart(r("#donut-total-capa"), "Doughnut", {
				labels: ["Open - "+capa_open, "Closed - "+capa_closed],
                datasets: [{
					<?php echo "data: [{$capa_open}, {$capa_closed}]"; ?>,
                    backgroundColor: ["#6c757d", "#ffbc00"],
                    borderColor: "transparent",
                    borderWidth: "3"
                }]
            }, {
                maintainAspectRatio: !1,
                cutoutPercentage: 60,
                legend: {
                    display: !1
                }
            }))
        }
        
        return a
    }, a.prototype.init = function() {
        var a = this;
        Chart.defaults.global.defaultFontFamily = '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif', a.charts = this.initCharts(), r(window).on("resize", function(t) {
            r.each(a.charts, function(r, a) {
                try {
                    a.destroy()
                } catch (r) {}
            }), a.charts = a.initCharts()
        })
    }, r.ChartJs = new a, r.ChartJs.Constructor = a
}(window.jQuery),
function(r) {
    "use strict";
    r.ChartJs.init()
}(window.jQuery);	
</script>
