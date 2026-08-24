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
				<div class="col-lg-4">
					<h1 class="wow fadeInUp h3 f-bold text-white" data-wow-delay=".2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">Pay Now</h1>
					<p class="text-white f-normal fs-4"> </p>
				</div>
				<div class="col-lg-8">
					<div class="form-block formcover shadow">
                	<h4>Pay Now</h4>
						<form id="direct_order_pay" name="direct_order_pay" method="post" data-bs-toggle="validator" class="sidebarForm shake mt40" autocomplete="off" >
							<div class="row">
								<div class="form-group col-sm-6">
									<label>Name</label>
									<input type="text" placeholder="" class="required" name="pay_name" id="pay_name" required="" data-error="Please fill Out" autocomplete="off">
									<div class="help-block with-errors"></div>
								</div>
								<div class="form-group col-sm-6">
									<label>Email</label>
									<input type="text" placeholder="" class="required email" name="pay_email" id="pay_email" required="" data-error="Please fill Out" autocomplete="off">
									<div class="help-block with-errors"></div>
								</div>
							</div>
							<div class="row">
								<div class="form-group col-sm-6">
									<label>Phone</label>
									<input type="text" placeholder="" class="required number" name="pay_phone" id="pay_phone" required="" data-error="Please fill Out" autocomplete="off">
									<div class="help-block with-errors"></div>
								</div>
								<div class="form-group col-sm-6">
									<label>Amount</label>
									<input type="text" placeholder="" class="required number" name="pay_amount" id="pay_amount" required="" data-error="Please fill Out" autocomplete="off">
									<div class="help-block with-errors"></div>
								</div>
							</div>
							<div class="row">
								<div class="form-group col-sm-12">
									<label>Message</label>
									<input type="text" placeholder="" class="required" name="pay_message" id="pay_message" required="" data-error="Please fill Out" autocomplete="off">
									<div class="help-block with-errors"></div>
								</div>
							</div>
							<button type="submit" id="direct_pay_order_btn" class="btn lnk btn-main bg-btn w-100 login-btn">Pay Now<span class="circle"></span></button>
						</form>
						<div id="error_pay"></div>
              		</div>
				</div>
		   </div>
		</div>
	 </div>
</section>
<!--End Breadcrumb Area-->

<div class="d-none">
	<!-- <form method="post" name="redirect" id="redirect" action="<?=CCA_URL?>">
		<input type="hidden" name="encRequest" id="encRequest" />
		<input type="hidden" name="access_code" id="access_code" />
	</form> -->
	<form name='razorpayform' action="paynow-payment-process" id="redirect" method="POST">
		<input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
		<input type="hidden" name="razorpay_signature" id="razorpay_signature">
		<input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
	</form>
</div>

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
<!-- EXTERNAL API REMOVED: Razorpay -->
<?php include 'includes/general_data.php'; ?>