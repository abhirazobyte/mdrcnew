<?php include('includes/header.php'); ?>

<main class="bg-white page-common">
<!--Breadcrumb Area-->

<div class="card rounded-0 border-0 p-3">
	<div class="form-block formcover">
		<h3 class="mb-3">Pay Now</h3>
		<form id="direct_order_pay" name="direct_order_pay" method="post" data-bs-toggle="validator" class="custom-form shake mt40" autocomplete="off" >
			<div class="row">
				<div class="input-box col-sm-12">
					<label>Name</label>
					<input type="text" placeholder="" class="required form-control" name="pay_name" id="pay_name" required="" data-error="Please fill Out" autocomplete="off">
					<div class="help-block with-errors"></div>
				</div>
				<div class="input-box col-sm-12">
					<label>Email</label>
					<input type="text" placeholder="" class="form-control required email" name="pay_email" id="pay_email" required="" data-error="Please fill Out" autocomplete="off">
					<div class="help-block with-errors"></div>
				</div>
			</div>
			<div class="row">
				<div class="input-box col-sm-12">
					<label>Phone</label>
					<input type="text" placeholder="" class="form-control required number" name="pay_phone" id="pay_phone" required="" data-error="Please fill Out" autocomplete="off">
					<div class="help-block with-errors"></div>
				</div>
				<div class="input-box col-sm-12">
					<label>Amount</label>
					<input type="text" placeholder="" class="form-control required number" name="pay_amount" id="pay_amount" required="" data-error="Please fill Out" autocomplete="off">
					<div class="help-block with-errors"></div>
				</div>
			</div>
			<div class="row">
				<div class="input-box col-sm-12">
					<label>Message</label>
					<input type="text" placeholder="" class="form-control required" name="pay_message" id="pay_message" required="" data-error="Please fill Out" autocomplete="off">
					<div class="help-block with-errors"></div>
				</div>
			</div>
			<button type="submit" id="direct_pay_order_btn" class="btn-solid btn lnk btn-main bg-btn w-100 login-btn">Pay Now</button>
		</form>
		<div id="error_pay"></div>
	</div>
</div>

<!--End Breadcrumb Area-->

<div class="d-none">
<form method="post" name="redirect" id="redirect" action="<?=CCA_URL?>">
<input type="hidden" name="encRequest" id="encRequest" />
<input type="hidden" name="access_code" id="access_code" />
</form>
</div>

</main>

<!--Start Footer -->
<?php include('includes/footer.php'); ?>
<!--End Footer -->