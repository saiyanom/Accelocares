<!-- Footer Start -->
<footer class="footer">
<div class="container-fluid">
<div class="row">
<div class="col-md-6">Copyright &copy; 2019 Mahindra Accelo | All Rights Reserved. </div>
<!--<div class="col-md-6">
<div class="text-md-right footer-links d-none d-md-block">
<a href="javascript: void(0);">About</a>
<a href="javascript: void(0);">Support</a>
<a href="javascript: void(0);">Contact Us</a>                            </div>
</div>-->
</div>
</div>
</footer>
<!-- end Footer -->


<script src="assets/js/app.min.js"></script>
<script src="assets/js/custom.js?v=1"></script>

<script type="text/javascript">
	$(window).on('load', function() {
	    $("#loader").delay(500).fadeOut();
	    $(".mask").delay(1000).fadeOut("slow");
	});
	$(document).on('ready', function() {

	    $("#loader").fadeIn("slow");
	    setTimeout(function(){ 
	     	$("#loader").delay(500).fadeOut();
	    	$(".mask").delay(1000).fadeOut("slow"); },
	     3000);

	});

</script>
