<?php 
    ob_start();
	require_once("../includes/initialize.php"); 

	if(!isset($_SESSION['employee_id']) && isset($_GET['id']) && !empty($_GET['id'])){
		$found_user 			= EmployeeReg::find_by_id($_GET['id']);
		
		if($found_user->log_time == 0 || $found_user->log_time < time()){
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
		} else {
			$session->message("You are Already Logged in, If not then wait 5 min to end Login Session"); 
			redirect_to("logout.php");
		}
	}

	if (!$session->is_employee_logged_in()) { redirect_to("logout.php"); }

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
	$complaints_open = Complaint::count_status_emp('Open',$session->employee_id); if($complaints_open){echo $complaints_open;}else {echo $complaints_open = 0;}
?></h2><p>Open complaints</p></div>
<div class="comp-right"><img src="assets/images/complaints/1.png"></div>
<div class="clerfix"></div>
<div class="val"><a href="my-complaints.php?status=Open" class="color-gr1">View all</a></div>
</li>

<li>
<div class="comp-left"><h2><?php
	$complaints_closed = Complaint::count_status_emp('Closed',$session->employee_id); if($complaints_closed){echo $complaints_closed;}else {echo $complaints_closed = 0;}
?></h2><p>Closed complaints</p></div>
<div class="comp-right"><img src="assets/images/complaints/2.png"></div>
<div class="clerfix"></div>
<div class="val"><a href="my-complaints.php?status=Closed" class="color-gr2">View all</a></div>
</li>

<li>
<div class="comp-left"><h2><?php
	$complaints_all = Complaint::count_all_emp($session->employee_id); if($complaints_all){echo $complaints_all;}else {echo $complaints_all = 0;}
?></h2><p>Total complaints</p></div>
<div class="comp-right"><img src="assets/images/complaints/3.png"></div>
<div class="clerfix"></div>
<div class="val"><a href="my-complaints.php" class="color-gr3">View all</a></div>
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
<h4 class="header-title">Complaint Source</h4>
<div id="basic-bar" class="apex-charts" style="width: 100%;height: 350px;"></div>
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
<h4 class="header-title mb-4">Complaint Type</h4>
<div id="bar-complaint-type" style="width: 100%;height: 320px;"></div>
</div>
<!-- end card body-->
</div>
<!-- end card -->
</div>
<!-- end col-->



<div class="col-xl-6">
<div class="card">
<div class="card-body">
<h4 class="header-title mb-4">Total Complaint status</h4>
<div id="bar-container-horizontal" style="width: 100%;height: 320px;"></div>
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
	$bv_auto 		= Complaint::count_business_vertical_emp("Auto",$session->employee_id);
	$bv_crno 		= Complaint::count_business_vertical_emp("CRNO",$session->employee_id);
	$bv_crgo 		= Complaint::count_business_vertical_emp("CRGO",$session->employee_id);
	
	
	$emp_status_comp_reg 	= Complaint::count_emp_status_emp("Complaint Received",$session->employee_id);
	$emp_status_comp_att 	= Complaint::count_emp_status_emp("Complaint Attented",$session->employee_id);
	$emp_status_visit_con 	= Complaint::count_emp_status_emp("Visit Confirmed",$session->employee_id);
	$emp_status_mom_upld 	= Complaint::count_emp_status_emp("MOM Created",$session->employee_id);
	$emp_status_comp_acc 	= Complaint::count_emp_status_emp("Complaint Accepted",$session->employee_id);
	$emp_status_comp_rej 	= Complaint::count_emp_status_emp("Complaint Rejected",$session->employee_id);
	$emp_status_dec_pend 	= Complaint::count_emp_status_emp("Decision Pending",$session->employee_id);
	
	$emp_status_closed 		= Complaint::count_status_emp("Closed",$session->employee_id);
	$emp_status_invalid 	= Complaint::count_status_emp("Invalid",$session->employee_id);

	$source_mill 			= Complaint::count_identify_source_emp("Mill",$session->employee_id);
	$source_plant 			= Complaint::count_identify_source_emp("Plant",$session->employee_id);
	
	$complaint_type_cracking 	= Complaint::count_emp_complaint_type("Cracking",$session->employee_id);
	$complaint_type_surface 	= Complaint::count_emp_complaint_type("Surface Defect",$session->employee_id);
	$complaint_type_transit 	= Complaint::count_emp_complaint_type("Transit Damage",$session->employee_id);
	$complaint_type_processing 	= Complaint::count_emp_complaint_type("Processing",$session->employee_id);
	$complaint_type_packing 	= Complaint::count_emp_complaint_type("Packing",$session->employee_id);
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
        enabled: !0
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
            horizontal: !0
        }
    },
    dataLabels: {
        enabled: !0
    },
    series: [{
        name: "Complaint",
		<?php echo "data: [{$emp_status_comp_reg}, {$emp_status_comp_att}, {$emp_status_visit_con}, {$emp_status_mom_upld}, {$emp_status_comp_acc}, {$emp_status_comp_rej}, {$emp_status_dec_pend}, {$emp_status_closed}, {$emp_status_invalid}]"; ?>
    }],
    colors: ["#39afd1"],
    xaxis: {
        categories: ["Complaint Received", "Complaint Attented", "Visit Confirmed", "MOM Uploaded", "Comp. Accepted", "Comp. Rejected", "Decision Pending", "Closed Comp.", "Invalid Complaint"]
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
(chart = new ApexCharts(document.querySelector("#bar-container-horizontal"), options)).render();
	
	
	
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
        <?php //echo "data: [{$complaint_type_cracking}, {$complaint_type_surface}, {$complaint_type_transit}, {$complaint_type_processing}, {$complaint_type_packing}]"; ?>
        <?php 
            $sql = "Select * from complaint_type order by complaint_type ASC";
            $complaint_type = ComplaintType::find_by_sql($sql);
            //$sql = "Select * from complaint_type where department = 'Auto' order by complaint_type ASC";
            //$complaint_type = ComplaintType::find_by_sql($sql);
            $ct_store = "";
            $complaint_type_all = "";
            $max=0;
            echo "data: [";
                foreach($complaint_type as $complaint_type){
                    if($ct_store != $complaint_type->complaint_type){
                        if(isset($_GET['from_date']) && !empty($_GET['from_date']) && isset($_GET['to_date']) && !empty($_GET['to_date'])){
                            $complaint_type_ = Complaint::count_by_complaint_type_emp_date($_GET['from_date'], $_GET['to_date'], $complaint_type->complaint_type,$session->employee_id);
                        } else { $complaint_type_ = Complaint::count_by_complaint_type_emp($complaint_type->complaint_type,$session->employee_id); }
                        echo "{$complaint_type_},";
                        $complaint_type_all .= "'{$complaint_type->complaint_type}',";
                    }$ct_store = $complaint_type->complaint_type;
                }
                $complaint_type_all = substr($complaint_type_all, 0, -1);
                if(isset($_GET['from_date']) && !empty($_GET['from_date']) && isset($_GET['to_date']) && !empty($_GET['to_date'])){
                    $complaint_type_ = Complaint::count_by_complaint_type_emp_date($_GET['from_date'], $_GET['to_date'], 'Other',$session->employee_id);
                } else { $complaint_type_ = Complaint::count_by_not_complaint_type_emp($complaint_type_all,$session->employee_id); }
                echo "{$complaint_type_},";
                if($max < $complaint_type_){ $max = $complaint_type_;}
            echo "]";
        ?>
    }],
    colors: ["#727cf5"],
    xaxis: {
        //categories: ["Cracking", "Surface Defect", "Transit Damage", "Processing", "Packing"]
        categories: [<?php
            $sql_cat = "Select * from complaint_type order by complaint_type ASC";
            $complaint_type = ComplaintType::find_by_sql($sql_cat);
            $old_complaint_type = "";
            foreach ($complaint_type as $complaint_type) {
                if($complaint_type->complaint_type != $old_complaint_type){
                    echo "'{$complaint_type->complaint_type}',";
                }
                $old_complaint_type = $complaint_type->complaint_type;
            } echo "'Other'";
        ?>]
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
