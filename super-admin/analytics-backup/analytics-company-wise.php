<?php ob_start();
	require_once("../includes/initialize.php"); 
	if (!$session->is_super_admin_logged_in()) { redirect_to("logout.php"); }
?>
<h4 class="header-title">
	<a href="#"><i class="mdi mdi-table"></i> Company Wise</a>
	<div class="input-group" style="float: right; width: 200px;">
		<div class="custom-file">
			<input readonly type="text" id="date_range" name="date_range" placeholder="Select Date Range" class="form-control date-picker company_wise_date_picker" data-provide="datepicker" data-toggle="date-picker" data-single-date-picker="false">
		</div>
	</div>
</h4>	
<div id="company_wise_graph" style="width: 100%;height: 320px;"></div>


<script>
	$('.date-picker').daterangepicker({
		singleDatePicker: false,
		locale: {
		  format: 'DD/MM/YYYY',
		}
	});
	
	$('.company_wise_date_picker').click(function(){
		$(this).on('apply.daterangepicker', function(ev, picker) {
			var startDate 	= picker.startDate;
			var endDate 	= picker.endDate;

			var startDate 	= startDate.format('YYYY-MM-DD');
			var endDate 	= endDate.format('YYYY-MM-DD')

			//alert("analytics-company-wise.php?from_date="+startDate+"&to_date="+endDate);
			$("#company_wise").load("analytics-company-wise.php?from_date="+startDate+"&to_date="+endDate);
		});
	});
	
var options = {
    chart: {
        height: 335,
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
		<?php 
			$sql = "Select * from company_reg order by company_name ASC";
			$company_reg = CompanyReg::find_by_sql($sql);
			$company_reg_count=1;
			echo "data: [";
				foreach($company_reg as $company_reg){
					if($company_reg_count <= 10){
						if(isset($_GET['from_date']) && !empty($_GET['from_date']) && isset($_GET['to_date']) && !empty($_GET['to_date'])){
							$company_reg_ = Complaint::count_by_company_reg_date($_GET['from_date'], $_GET['to_date'], $company_reg->company_name);
						} else { $company_reg_ = Complaint::count_by_company_reg($company_reg->company_name); }
						echo "{$company_reg_},";
						$company_reg_count++;
					}
				}
			echo "]";
		?>
    }],
    colors: ["#fa5c7c"],
    xaxis: {
		<?php 
			$sql = "Select * from company_reg order by company_name ASC";
			$company_reg = CompanyReg::find_by_sql($sql);
			$company_reg_count=1;
			echo "categories: [";
				foreach($company_reg as $company_reg){	
					if($company_reg_count <= 10){
						echo "'{$company_reg->company_name}',";
						$company_reg_count++;
					}
				}
			echo "]";
		?>
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
(chart = new ApexCharts(document.querySelector("#company_wise_graph"), options)).render();
</script>