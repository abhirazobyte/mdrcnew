<?php include('includes/header.php'); ?>
<!-- Main Start -->
<main class="main-btm-pd bg-white page-common">
	<!-- About banner start -->
	<div class="card bg-theme rounded-0 border-0 p-3">
		<h2 class="font-lg text-center text-white mb-3">Download Report</h2>
		<p class="text-white text-center">
			You can download your reports through the Visit ID and Password mentioned on your Booking Slip.
		</p>
		<a href="http://182.72.101.236/mdrcnew/design/onlinelab/" target="_new" class="text-white" style="text-decoration:underline">Click Here : Download Reports (For Client Only)</a>
	</div>
	<!-- About banner end -->
	<div class="about-tab why-us px-3 mt-3 mb-3">
		<div class="form-block formcover">
			<h4 class="mb-3">Enter Login Details</h4>
			<form id="download_test_report_page" name="download_test_report_page" method="post" data-bs-toggle="validator" class="sidebarForm shake mt40 custom-form" autocomplete="off">
				<div class="row">
					<div class="col-md-6 col-12 input-box">
						<label class="cust">Lab/Visit ID</label>
						<input type="text" placeholder="" class="required form-control" name="visitor_id_page" id="visitor_id_page" required="" data-error="Please fill Out" autocomplete="off">
						<div class="help-block with-errors"></div>
					</div>
					<div class="col-md-6 col-12 input-box">
						<label  class="cust">Password</label>
						<input type="password" placeholder="" class="required form-control" name="lab_password_page" id="lab_password_page" required="" data-error="Please fill Out" autocomplete="off">
						<div class="help-block with-errors"></div>
					</div>
				</div>
				<button type="submit" id="download_report_submit_page" class="btn btn-solid lnk btn-main bg-btn w-100 login-btn">Check Report <span class="circle"></span></button>
			</form>
			<div id="no_report_found_page" class="mt-3"></div>
		</div>
	</div>

	<section class="pt40 result_html" id="result_html" style="display:none;">
		<div class="container">
			<div class="row section-title ">
				<div class="col-lg-7 col-md-12 col-12">

					<div class="cart-extra-sevc div-for-data">
						<h4 class="mb30">Test Information</h4>

						<div class="table_html">
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
						</div>

					</div>


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
									
									<a href="#" class="btn-main bg-btn3 lnk w-100 mt10">Download Report<span class="circle"></span> </a>
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

</main>
<!-- Main End -->


<!-- Footer Start -->
<?php include('includes/footer.php'); ?>
<!-- Footer End -->