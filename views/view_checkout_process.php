<?php
require('razorpay-php/Razorpay.php');
$name = $this->orderData['customer_name'];
$phone = $this->orderData['customer_phone'];
$email = $this->orderData['customer_email'];
$razorpayOrderId = $this->paymentData['payment_data'];
$amount = $this->paymentData['transaction_amount'];
$address = '';
?>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/plugin.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<!-- template-style-->
<link href="css/style.css" rel="stylesheet">
<link href="css/responsive.css" rel="stylesheet">

<!-- Bootstrap Select -->
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css'>
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css'>
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css'>
<link href="css/custom.css" rel="stylesheet">
<style>
	a {
		color: #666;
	}

	a {
		text-decoration: none;
		outline: none !important;
	}

	.confirm {
		width: 100% !important;
		;
	}

	.cart_update {
		background: #ac0d0d;
		color: #fff;
		border: 1px solid #ac0d0d;
		cursor: pointer;
	}

	.remove_product {
		background: #ac0d0d;
		color: #fff;
		border: 1px solid #ac0d0d;
		cursor: pointer;
	}

	.remove_product span:hover {
		color: #fff !important;
	}

	.btn-border {
		line-height: 39px;
  padding: 1px 29px;
  transition: all 1.5s;
  display: inline-block;
font-weight: 500;
  font-size: 13px;
  border-radius: 4px;
    border:1px solid gray;
	}

	.btn-border:hover {
		color: #fff;
  background-image: linear-gradient(90deg, #0f5ba1 0%, #1d7fbb 100%);
  line-height: 39px;
  padding: 1px 29px;
  transition: all 1.5s;
	}
</style>
<?php include 'includes/header.php'; ?>
<div class="columns-container">
		<section class="breadcrumb-area banner-6">
  <div class="text-block">
	<div class="container">
	  <div class="row">
		<div class="col-lg-12 text-start v-center">
		  <div class="bread-inner">
			<div class="bread-menu wow fadeInUp" data-wow-delay=".2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
			  <ul>
				<li><a href="index.html">Home</a></li>
				<li><a href="contact-us">Payment Summery</a></li>
			  </ul>
			</div>
			<div class="bread-title wow fadeInUp" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInUp;">
			  <h1 class="f-bold fs-2 text-white">Payment Summery</h1>
			</div>
		  </div>
		</div>
	  </div>
	</div>
  </div>
</section>
	<div class="container" id="columns">

		<div class="page-content page-order py-5">
			<?= $this->utility->get_message(); ?>
			<div class="order-detail-content">
				<table class="table table-bordered table-responsive cart_summary">
					<thead>
						<tr>
							<th>Order ID</th>
							<th>Total Amount</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class=""># <?= $this->orderData['id'] ?></td>
							<td class=""><span><i class="fa fa-inr"></i>
									<?= $amount ?>
								</span>
							</td>
						</tr>
					</tbody>
					
				</table>
				<div class="cart_navigation d-flex justify-content-between align-items-center"> 
					<a class="next-btn btn-main bg-btn1 btn-blue lnk wow fadeInUp text-uppercase" href="javascript:void(0)" id="rzp-button1">Pay Now</a> 
					<a class="btn-border" href="order-details/<?= $this->orderData['id'] ?>">View Bookings</a> 
			</div>
			</div>
		</div>
	</div>
</div>
<!-- Footer -->
<?php include 'includes/footer.php'; ?>
<!-- Script-->
<script src="js/vendor/modernizr-3.5.0.min.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/plugin.min.js"></script>
<script src="js/preloader.js"></script>
<!--common script file-->
<script src="js/main.js"></script>
<script src='https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js'></script>
<script id="rendered-js" >
	<?php include 'includes/general_data.php';?>
</script>
<?php

use Razorpay\Api\Api;
$keyId = RAZOR_PAY_KEY;
$keySecret = RAZOR_PAY_SECRET;
$api = new Api($keyId, $keySecret);
//
// We create an razorpay order using orders api
// Docs: https://docs.razorpay.com/docs/orders
//

$data = [
	"key"               => $keyId,
	"amount"            => $amount,
	"name"              => "Modern Diagnostic & Research Centre",
	"description"       => "Online Shopping Site",
	"image"             => "https://www.mdrcindia.com/images/logo.webp",
	"prefill"           => [
		"name"              => $name,
		"email"             => $email,
		"contact"           => $phone,
	],
	"notes"             => [
		"address"           => $address,
	],
	"theme"             => [
		"color"             => "#F37254"
	],
	"order_id"          => $razorpayOrderId,
];
//print_r($data); exit;
$json = json_encode($data);
?>
<!-- EXTERNAL API REMOVED: Razorpay -->
<form name='razorpayform' action="payment-process" method="POST">
	<input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
	<input type="hidden" name="razorpay_signature" id="razorpay_signature">
	<input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
</form>
<script>
	var options = <?php echo $json ?>;
	/**
	 * The entire list of Checkout fields is available at
	 * https://docs.razorpay.com/docs/checkout-form#checkout-fields
	 */
	options.handler = function(response) {
		document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
		document.getElementById('razorpay_signature').value = response.razorpay_signature;
		document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
		document.razorpayform.submit();
	};
	options.theme.image_padding = false;
	options.modal = {
		ondismiss: function() {
			console.log("This code runs when the popup is closed");
		},
		escape: true,
		backdropclose: false
	};
	var rzp = new Razorpay(options);
	rzp.open();
	document.getElementById('rzp-button1').onclick = function(e) {
		rzp.open();
		e.preventDefault();
	}
</script>