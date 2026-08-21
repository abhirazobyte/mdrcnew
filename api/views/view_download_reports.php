<!--plugin-css-->
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/plugin.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<!-- template-style-->
<link href="css/style.css" rel="stylesheet">
<link href="css/responsive.css" rel="stylesheet">
<!-- Bootstrap Select -->
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css'>
<link href="css/custom.css" rel="stylesheet">
<!--Start Header -->
<?php include 'includes/header.php'; ?>
<!--End Header -->
<!--Breadcrumb Area-->
<section class="hero-creative-agenc1 banner-twostyle pt40 pb30" data-background="images/bg-gradient.png" style="background-image: url(&quot;images/bg-gradient.png&quot;);">
	<div class="text-block">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-7">
					<h1 class="wow fadeInUp h3 f-bold text-white" data-wow-delay=".2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">Download Report</h1>
					<p class="text-white f-normal fs-4">You can download your reports through the Visit ID and Password mentioned on your Booking Slip. </p>
					<br /><br /><br />
					<!--<a href="http://182.72.101.236/mdrcnew/design/onlinelab/" target="_new" class="text-white" style="text-decoration:underline">Click Here : Download Reports (For Client Only)</a>-->
					<a href="https://lis6.mdrcindia.com/mdrcnew/design/OnlineLab/Default.aspx" target="_new" class="text-white" style="text-decoration:underline">Click Here : Download Reports (For Client Only)</a>

				</div>
				<div class="col-lg-5">
					<div class="form-block formcover shadow">
						<h4>Enter Login Details</h4>
						<form id="download_test_report_page" name="download_test_report_page" method="post" data-bs-toggle="validator" class="sidebarForm shake mt40" autocomplete="off">
							<div class="row">
								<div class="form-group col-sm-12">
									<label>Lab/Visit ID</label>
									<input type="text" placeholder="" class="required" name="visitor_id_page" id="visitor_id_page" required="" data-error="Please fill Out" autocomplete="off">
									<div class="help-block with-errors"></div>
								</div>
								<div class="form-group col-sm-12">
									<label>Password</label>
									<input type="password" placeholder="" class="required" name="lab_password_page" id="lab_password_page" required="" data-error="Please fill Out" autocomplete="off">
									<div class="help-block with-errors"></div>
								</div>
							</div>
							<button type="submit" id="download_report_submit_page" class="btn lnk btn-main bg-btn w-100 login-btn">Check Report <span class="circle"></span></button>
						</form>
						<div id="no_report_found_page" class="mt-3"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!--End Breadcrumb Area-->
<!--Start Team Leaders-->
<section class="pt40 result_html" id="result_html" style="display:none;">
	<div class="container">
		<div class="row section-title ">
			<div class="col-lg-7 col-md-12 col-12 table_html">
				<!-- <div class="cart-extra-sevc div-for-data">
					<h4 class="mb30">Test Information</h4>
					<div class="table_html"> -->
						<!-- <table class="table border">
								<tbody>
									<tr>
										<th><strong>Swasthya Panel</strong></th>
										<td><span class="text-primary">Booking Verified</span></td>
									</tr>
									<tr>
										<th><strong>Serum Creatinine</strong></th>
										<td><span class="text-primary">Sample Collected</span></td>
									</tr>
									<tr>
										<th><strong>SGOT (Serum Glutamic Oxaloacetic Transaminase)</strong></th>
										<td><span class="text-success">Report Ready</span></td>
									</tr>
									<tr>
										<th><strong>CRP (C-Reactive Protein )</strong></th>
										<td><span class="text-primary">Sample Receive At Lab</span></td>
									</tr>
								</tbody>
							</table> -->
					<!-- </div>
				</div> -->
			</div>
			<div class="col-lg-5 col-md-12 col-12">
				<div class="rpb-item-infodv">
					<ul class="button_html">
						<!-- <li>
									<strong>Patient</strong>
									<div class="nx-rt">Mr.DHRUV YADAV</div>
								</li>
								<li>
									<strong>Booking</strong>
									<div class="nx-rt">11-Sep-2021 11:58 AM</div>
								</li>
								<li>
									<strong>Mobile Number</strong>
									<div class="nx-rt">9999474297</div>
								</li>
								<li>
									<strong>Centre</strong>
									<div class="nx-rt">MDRC GURGAON</div>
								</li>
								<li>
									<a href="#" class="btn btn-solid w-100">Download Report<span class="circle"></span> </a>
								</li>
							<li>
									<a href="#" class="btn-main bg-btn5 lnk w-100 mt10">Report is not Ready<span class="circle"></span> </a>
								</li>-->
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>
<!--Start Footer -->
<?php include 'includes/footer.php'; ?>
<!--End Footer -->
<!-- js placed at the end of the document so the pages load faster -->
<script src="js/vendor/modernizr-3.5.0.min.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/plugin.min.js"></script>
<script src="js/preloader.js"></script>
<!--common script file-->
<script src="js/main.js"></script>
<script src='https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js'></script>
<?php include 'includes/general_data.php'; ?>