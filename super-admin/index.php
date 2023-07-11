<?php 
    ob_start();
	require_once("../includes/initialize.php"); 

	if(!isset($_SESSION['super_admin_login']) && isset($_GET['id']) && !empty($_GET['id'])){
		$found_user 			= EmployeeReg::find_by_id($_GET['id']);
		
		$found_admin = SuperAdmin::find_by_id($_GET['id']);

		$found_user = EmployeeReg::find_by_id($_GET['id']);
		
		
		
		if($found_admin->log_time == 0 || $found_admin->log_time < time()){
			if($_COOKIE['PHPSESSID'] == $found_admin->log_session){
				$session->super_admin_login($found_admin);
			
				$found_admin->log 		 	= 1;
				$found_admin->log_time 		= time() + (300);
				$found_admin->log_session 	= $_COOKIE['PHPSESSID'];
				if($found_admin->save()){
					if($_COOKIE['PHPSESSID'] == $found_user->log_session){
						$session->employee_login($found_user);		

						$found_user->log 		 	= 1;
						$found_user->log_time 		= time() + (300);
						$found_user->log_session 	= $_COOKIE['PHPSESSID'];
						if($found_user->save()){
							redirect_to("index.php");
						} else {
							$session->message("Failed to Login, try again."); redirect_to("logout.php");
						}
					} else {
						$session->message("PHP Session You are Already Logged in, If not then wait 5 min to end Login Session"); 
						redirect_to("login.php");
					}

					//redirect_to("index.php");
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


	if (!$session->is_super_admin_logged_in()) { redirect_to("logout.php"); }

    foreach ($_POST as $key => $value) {
        if (preg_match('/[\'"\^%*()}!{><;`=+]/', $value)){
            $session->message("Found Malicious Code."); redirect_to("index.php");
        } 
    }
    foreach ($_GET as $key => $value) {
        if (preg_match('/[\'"\^*()}!{><;`=]/', $value)){
            $session->message("Found Malicious Code."); redirect_to("index.php");
        }
    }
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

<li>
<div class="comp-left"><h2><?php
	$complaints_open = Complaint::count_status('Open'); if($complaints_open){echo $complaints_open;}else {echo $complaints_open = 0;}
?></h2><p>Open complaints</p></div>
<div class="comp-right"><img src="assets/images/complaints/1.png"></div>
<div class="clerfix"></div>
<div class="val"><a href="all-complaints.php?status=Open" class="color-gr1">View all</a></div>
</li>

<li>
<div class="comp-left"><h2><?php
	$complaints_closed = Complaint::count_status('Closed'); if($complaints_closed){echo $complaints_closed;}else {echo $complaints_closed = 0;}
?></h2><p>Closed complaints</p></div>
<div class="comp-right"><img src="assets/images/complaints/2.png"></div>
<div class="clerfix"></div>
<div class="val"><a href="all-complaints.php?status=Closed" class="color-gr2">View all</a></div>
</li>

<li>
<div class="comp-left"><h2><?php
	$complaints_all = Complaint::count_all(); if($complaints_all){echo $complaints_all;}else {echo $complaints_all = 0;}
?></h2><p>Total complaints</p></div>
<div class="comp-right"><img src="assets/images/complaints/3.png"></div>
<div class="clerfix"></div>
<div class="val"><a href="all-complaints.php" class="color-gr3">View all</a></div>
</li>

<div class="clerfix"></div>
</ul>
</div>
</div>


<div class="row">
<div class="col-xl-6">
<div class="card">
<div class="card-body">
<h4 class="header-title mb-4">Total ComplaInts</h4>

<div class="mt-3 chartjs-chart" style="height: 320px;">
<canvas id="donut-chart-example"></canvas>
</div>

</div> <!-- end card body-->
</div>
<!-- end card -->
</div>
<!-- end col-->

<div class="col-xl-6">
<div class="card">
<div class="card-body">
<h4 class="header-title mb-4">Complaint Type</h4>
<div id="bar-complaint-type" style="width: 100%;height: 320px;"></div>
</div>
<!-- end card body-->
</div>
<!-- end card -->
</div>
<!-- end col-->
</div>
<!-- end row-->

<div class="row">
<div class="col-xl-6">
<div class="card">
<div class="card-body">
<h4 class="header-title mb-4">BusIness vertIcal</h4>
<div class="text-center">
<div id="circle-angle-radial" class="apex-charts"></div>
</div>
</div>
<!-- end card body-->
</div>
<!-- end card -->
</div>
<!-- end col-->

<div class="col-xl-6">
<div class="card">
<div class="card-body">
<h4 class="header-title">Complaint Source</h4>
<div id="basic-bar" class="apex-charts"></div>
</div>
<!-- end card body-->
</div>
<!-- end card -->
</div>
<!-- end col-->
</div>
<!-- end row-->

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
	$bv_auto 		= Complaint::count_business_vertical("Auto");
	$bv_crno 		= Complaint::count_business_vertical("CRNO");
	$bv_crgo 		= Complaint::count_business_vertical("CRGO");
	
	/*$emp_status_new 	= Complaint::count_emp_status("New");
	$emp_status_vc 		= Complaint::count_emp_status("Visit Confirmed");
	$emp_status_vnc 	= Complaint::count_emp_status("Visit Not Confirmed");
	$emp_status_vd 		= Complaint::count_emp_status("Visit Done");
	$emp_status_vnd 	= Complaint::count_emp_status("Visit Not Done");
	$emp_status_ca 		= Complaint::count_emp_status("Complaint Accepted");
	$emp_status_cr 		= Complaint::count_emp_status("Complaint Rejected");
	$emp_status_cp 		= Complaint::count_emp_status("Complaint Pending");
	$emp_status_cp 		= Complaint::count_emp_status("CAPA Shared");
	$emp_status_cns 	= Complaint::count_emp_status("Credit Note Shared");
	$emp_status_cc 		= Complaint::count_emp_status("Complaint Closed");*/

	$source_mill 		= Complaint::count_identify_source("Mill");
	$source_plant 		= Complaint::count_identify_source("Plant");
	
	
	$complaint_type_cracking 	= Complaint::count_complaint_type("Cracking");
	$complaint_type_surface 	= Complaint::count_complaint_type("Surface Defect");
	$complaint_type_transit 	= Complaint::count_complaint_type("Transit Damage");
	$complaint_type_processing 	= Complaint::count_complaint_type("Processing");
	$complaint_type_packing 	= Complaint::count_complaint_type("Packing");
	
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
    series: [{name: "Complaint",
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
            horizontal: !1
        }
    },
    dataLabels: {
        enabled: !0
    },
    series: [{
        name: "Complaint",
		<?php echo "data: [{$complaint_type_cracking}, {$complaint_type_surface}, {$complaint_type_transit}, {$complaint_type_processing}, {$complaint_type_packing}]"; ?>
    }],
    colors: ["#727cf5"],
    xaxis: {
        categories: ["Cracking", "Surface Defect", "Transit Damage", "Processing", "Packing"]
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
(chart = new ApexCharts(document.querySelector("#bar-complaint-type"), options)).render();
	
	
	
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
        fontSize: "16px",
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
            top: 20
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
	
	
! function(r) {
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
                    backgroundColor: [ "#71bf44","#0fb3f0"],
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
