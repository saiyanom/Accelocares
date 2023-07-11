<?php ob_start();
	require_once("../includes/initialize.php"); 
	if (!$session->is_super_admin_logged_in()) { redirect_to("logout.php"); }
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8" />
<title>Analytics | Mahindraaccelo</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta content="" name="description" />
<meta content=" " name="author" />
</head>
<!-- sidebar-enable -->
<body class="enlarged" data-keep-enlarged="true">

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
&nbsp;
</div>	

<?php
	$complaints_open = Complaint::count_status('Open');
	$complaints_closed = Complaint::count_status('Closed'); 	
	$complaints_all = Complaint::count_all(); 
?>	


<div class="row">

	<div class="col-xl-6">
		<div class="card">
			<div class="card-body" id="plant_vs_mill">
				
			</div>
			<!-- end card body-->
		</div>
		<!-- end card -->
	</div>
	
	<div class="col-xl-6">
		<div class="card">
		<div class="card-body" id="mill_data">

		</div>
		<!-- end card body-->
		</div>
		<!-- end card -->
	</div>
	<!-- end col-->
	
	<div class="col-xl-6">
		<div class="card">
		<div class="card-body" id="business_verticle">

		</div>
		<!-- end card body-->
		</div>
		<!-- end card -->
	</div>
	<!-- end col-->
	
	<div class="col-xl-6">
		<div class="card">
		<div class="card-body" id="plant_data">

		</div>
		<!-- end card body-->
		</div>
		<!-- end card -->
	</div>
	<!-- end col-->
	
	<div class="col-xl-6">
		<div class="card">
		<div class="card-body" id="complaint_type">

		</div>
		<!-- end card body-->
		</div>
		<!-- end card -->
	</div>
	<!-- end col-->
	
	<div class="col-xl-6">
		<div class="card">
		<div class="card-body" id="company_wise">

		</div>
		<!-- end card body-->
		</div>
		<!-- end card -->
	</div>
	<!-- end col-->
	
	
	<div class="col-xl-6">
		<div class="card">
		<div class="card-body" id="complaint_analysis">

		</div>
		<!-- end card body-->
		</div>
		<!-- end card -->
	</div>
	<!-- end col-->
	
	<div class="col-xl-6">
		<div class="card">
		<div class="card-body" id="employee_performance">

		</div>
		<!-- end card body-->
		</div>
		<!-- end card -->
	</div>
	<!-- end col-->

</div>
<!-- end row-->

<div class="">
<div class="comp-box" style="padding-top: 0;">
<ul>

<li style="width: 24%; margin: 1% 1% 1% 0;">
<div class="comp-left"><h2><?php
	echo "7 / 9";
?></h2><p>Plant TAT</p></div>
<div class="comp-right"><img src="assets/images/complaints/1.png"></div>
<div class="clerfix"></div>
<div class="val"><a href="analytics-plant-data-table.php" class="color-gr1">View all</a></div>
</li>

<li style="width: 23%; margin: 1% 1%;">
<div class="comp-left"><h2><?php
	echo "15 / 20";
?></h2><p>Mill TAT</p></div>
<div class="comp-right"><img src="assets/images/complaints/2.png"></div>
<div class="clerfix"></div>
<div class="val"><a href="analytics-mill-data-table.php" class="color-gr2">View all</a></div>
</li>
	
<li style="width: 23%; margin: 1% 1%;">
<div class="comp-left"><h2><?php
	$sql = "Select * from site_location order by site_location ASC";
	$site_location = SiteLocation::find_by_sql($sql);
	$repeat = "";
	
	
	$total_credit_note_iss_cust = 0;
	$total_debit_note_iss_supplier = 0;
	$total_loss_per_approval_note = 0;

	foreach($site_location as $site_location){
		if($repeat != $site_location->site_location){
		
			$total_qty_rejc = 0;
			$credit_note_iss_cust = 0;
			$debit_note_iss_supplier = 0;
			$loss_per_approval_note = 0;

			$approval_note = ApprovalNote::find_all();
			foreach($approval_note as $approval_note){   

				$complaint = Complaint::find_by_id($approval_note->complaint_id);
				if($complaint){
					if($complaint->plant_location == $site_location->site_location){
						$credit_note_iss_cust 		+= $approval_note->credit_note_iss_cust;
						$debit_note_iss_supplier 	+= $approval_note->debit_note_iss_supplier;
						$loss_per_approval_note 	= $credit_note_iss_cust - $debit_note_iss_supplier;
					}
				}
			}
			$total_credit_note_iss_cust 	+= $credit_note_iss_cust;
			$total_debit_note_iss_supplier 	+= $debit_note_iss_supplier;
			$total_loss_per_approval_note 	+= $loss_per_approval_note;

	} $repeat = $site_location->site_location; }
	
	echo "<span class='app_note_plant'>{$total_loss_per_approval_note}</span>";
 
?></h2><p>Approval Note - Plant</p></div>
<div class="comp-right"><i class="fa fa-inr" style="color: #e31837;"></i></div>
<div class="clerfix"></div>
<div class="val"><a href="analytics-approval-note-location-table.php" class="color-gr3">View all</a></div>
</li>

<li style="width: 23%; margin: 1% 0 1% 1%;">
<div class="comp-left"><h2><?php
	$mill_reg = MillReg::find_all();

	$total_credit_note_iss_cust = 0;
	$total_debit_note_iss_supplier = 0;
	$total_loss_per_approval_note = 0;

	foreach($mill_reg as $mill_reg){
		
	$total_qty_rejc = 0;
	$credit_note_iss_cust = 0;
	$debit_note_iss_supplier = 0;
	$loss_per_approval_note = 0;

	$approval_note = ApprovalNote::find_all();
	foreach($approval_note as $approval_note){   

		$complaint = Complaint::find_by_id($approval_note->complaint_id);
		if($complaint){
			if($complaint->identify_source == 'Mill'){
				if($complaint->mill == $mill_reg->mill_name){
					$credit_note_iss_cust 		+= $approval_note->credit_note_iss_cust;
					$debit_note_iss_supplier 	+= $approval_note->debit_note_iss_supplier;
					$loss_per_approval_note 	= $credit_note_iss_cust - $debit_note_iss_supplier;
				}
			}
		}
	}
	$total_loss_per_approval_note 	+= $loss_per_approval_note;
}	echo "<span class='app_note_mill'>{$total_loss_per_approval_note}</span>";
?></h2><p>Approval Note - Mill</p></div>
	<div class="comp-right"><i class="fa fa-inr" style="color: #ffbc00;"></i></div>
<div class="clerfix"></div>
<div class="val"><a href="analytics-approval-note-mill-table.php" class="color-gr4">View all</a></div>
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
<script src="https://use.fontawesome.com/6e88edd09d.js"></script>
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
	
	$(document).ready(function() {
		$("#plant_vs_mill").load("analytics-plant-vs-mill.php");
		$("#mill_data").load("analytics-mill-data.php");
		$("#business_verticle").load("analytics-business-verticle.php");
		$("#plant_data").load("analytics-plant-data.php");
		$("#complaint_type").load("analytics-complaint-type.php");
		$("#company_wise").load("analytics-company-wise.php");
		$("#complaint_analysis").load("analytics-complaint-analysis.php");
		$("#employee_performance").load("analytics-employee-performance.php");
		
		var total = $('.app_note_mill').html();
		total = Math.round(total);
		var x=total;
		x=x.toString();
		var lastThree = x.substring(x.length-3);
		var otherNumbers = x.substring(0,x.length-3);
		if(otherNumbers != '')
			lastThree = ',' + lastThree;
		var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree;
		$('.app_note_mill').html(res);
		
		var total = $('.app_note_plant').html();
		total = Math.round(total);
		var x=total;
		x=x.toString();
		var lastThree = x.substring(x.length-3);
		var otherNumbers = x.substring(0,x.length-3);
		if(otherNumbers != '')
			lastThree = ',' + lastThree;
		var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree;
		$('.app_note_plant').html(res);
		
	});
	
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
		<?php echo "data: [{$source_mill},{$source_plant}]"; ?>
    }],
    colors: ["#39afd1"],
    xaxis: {
		<?php echo "categories: ['Plant {$source_mill}', 'Mill {$source_plant}']"; ?>
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
</script>
<style>
	.fa-inr {
		font-size: 49px;
	}
	span.clear_img{
		cursor: pointer;
		color: #fff;
		background-color: #0acf97;
		border: 1px solid #0acf97;
	}
</style>
