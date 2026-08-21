<?php include('includes/header.php'); ?>
<!-- Main Start -->
<main class="main-btm-pd">
	<!-- Card -->
	<div class="card mb-3 pb-1 border-0">
		<div class="p-3 d-flex align-items-center justify-content-between">
			<h3 class="text-dark font-md fw-bold">#<?= $this->rs_data[0]['display_order_no'] ?></h3>
			<a href="#" class="th-color-green fw-600 font-sm"><?= $this->rs_data[0]['order_status'] ?></a>
		</div>
		<!-- Order Summary -->
		<div class="bg-white px-3">
			<div class="d-flex justify-content-between align-items-center pb-2 fw-600">
				<p class="mb-0">Order Date:</p>
				<p class="mb-0 fw-600"><?= $this->rs_data[0]['order_date'] ?></p>
			</div>
			<div class="d-flex justify-content-between align-items-center pb-2 fw-600">
				<p class="mb-0">Payment Type:</p>
				<p class="mb-0 fw-600"><?= $this->rs_data[0]['payment_type'] ?></p>
			</div>
		</div>
	</div>
	<!-- Order info tabs Start -->
	<div class="card orderinfotab mb-3 rounded-0">
		<ul class="nav nav-pills mb-3 border-bottom" id="pills-tab" role="tablist">
			<li class="nav-item" role="presentation">
				<button class="nav-link active font-md fw-600" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="true">
					Patient Info
				</button>
			</li>
			
			<?php if (count($this->rs_lab_data) > 0) { ?>
			<li class="nav-item" role="presentation">
				<button class="nav-link  font-md fw-600" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="false">
					Lab Info
				</button>
			</li>
			<?php } ?>

			<?php if (count($this->rs_collection_address) > 0) { ?>
			<li class="nav-item" role="presentation">
				<button class="nav-link  font-md fw-600" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#mdrc-collection" type="button" role="tab" aria-controls="mdrc-collection" aria-selected="false">
					Collection Address
				</button>
			</li>
			<?php } ?>

		</ul>
		<div class="tab-content" id="pills-tabContent">

			<div class="tab-pane fade show active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
				<div class="main-wrap">
					
					<?php 
					for ($i = 0; $i < count($this->rs_order_detail); $i++) {
						$age = $this->utility->getAge($this->rs_order_detail[$i]['customer_members_dob']) . " Year";
					?>
					<div>
						<h2 class="font-sm fw-bold mb-1"><?= $this->rs_order_detail[$i]['customer_members_prefix'] . ' ' . $this->rs_order_detail[$i]['customer_members_first_name'] . ' ' . $this->rs_order_detail[$i]['customer_members_last_name']; ?></h2>

						<?php
							$line1 = $this->rs_order_detail[$i]['customer_members_line1'];
							$area = $this->rs_order_detail[$i]['customer_members_area'];
							$pincode = $this->rs_order_detail[$i]['customer_members_pincode'];

							$obj_model_tble = $this->load_model("pincode");
							$obj_model_tble->join_table("state", "left", array("name"), array("state_id" => "id"));
							$obj_model_tble->join_table("city", "left", array("name"), array("city_id" => "id"));

							$rs_pincode_data = $obj_model_tble->execute("SELECT", false, "", "pincode.name='" . $pincode . "'", "pincode.id DESC");

							$city = $rs_pincode_data[0]['city_name'];
							$state = $rs_pincode_data[0]['state_name'];

							$member_html = '<a class="vtest-btn text-dark d-inline-block w-100 mb-2 cartMemberRemove" data-id="' . $cartID . '" href="javascript:void(0)">' . $age . ' | ' . $this->rs_order_detail[$i]['customer_members_relation'] . '<br/><span class=" ">' . $line1 . ', ' . $area . ',' . $city . ' - ' . $pincode . ', ' . $state . '</span>  </a>';
						?>

						<div class="card bg-light-blue p-2 border-0 mb-3">
							<h3 class="font-sm fw-bold mb-1"><?=$age.' | '.$this->rs_order_detail[$i]['customer_members_relation'];?></h3>
							<p class="text-secondary mb-0 font-xs"><?php echo $line1 . ', ' . $area . ',' . $city . ' - ' . $pincode . ', ' . $state;?></p>
						</div>

						<?php if($this->rs_order_detail[$i]['lis_visitor_id']!='') { ?>
						<div class="gap-3 justify-content-center align-items-start mb-3">
							<div class="card bg-light-blue p-2 border-0 mb-3">
								<h3 class="font-sm fw-bold mb-1">Visitor ID</h3>
								<p class="text-secondary mb-0 font-xs"><?=$this->rs_order_detail[$i]['lis_visitor_id'];?></p>
							</div>

							<a href="javascript:void(0)" type="button" class="w-100 theme-color btn-outline-solid btn w-50 font-sm text-nowrap text-decoration-underline" onclick="callOrderCustomerStatus('<?= $this->rs_order_detail[$i]['order_master_id']; ?>','<?= $this->rs_order_detail[$i]['customer_members_id']; ?>');">View Tracking Details</a>
						</div>
						<?php } ?>

						<?php 
						for ($j = 0; $j < count($this->rs_order_detail_cust); $j++) {
							if ($this->rs_order_detail_cust[$j]['customer_members_id'] == $this->rs_order_detail[$i]['customer_members_id']) {
						?>
						<!-- Card -->
						<div class="card p-3 rounded mb-3">
							<a href="javascript:void(0);" class="d-flex justify-content-between align-items-center itemsDetails" data-id="<?= $this->rs_order_detail_cust[$j]['item_id'] ?>" type="button">
								<h3 class="font-sm fw-bold lh-sm w-100"><?= $this->rs_order_detail_cust[$j]['order_item_name'] ?></h3>
								<i data-feather="chevron-down"></i>
							</a>
							<p class="font-xs mb-0 text-secondary">Includes <?= $this->rs_order_detail_cust[$j]['order_item_test_count'] ?> Tests</p>
							<div class="d-flex align-items-start">
								<p class="font-md fw-bold mb-0"><i class="fas fa-rupee-sign"></i> <span><?= $this->rs_order_detail_cust[$j]['price'] ?></span></p>
							</div>
							
							<?php if ($this->rs_order_detail_cust[$j]['prescription_data'] != '') { ?>
							<div class="card bg-light-blue p-2 border-0 mt-2">
								<p class="text-secondary mb-0 font-xs">Prescription Info 
									<a type="button" class="float-end vdet text-blue prescriptionOrderView" data-id="<?= $this->rs_order_detail_cust[$j]['id'] ?>">View Details</a>
								</p>
							</div>
							<?php } ?>

						</div>
						<!-- Card -->
						<?php }
						} ?>
						
					</div>
					<?php } ?>
				</div>
			</div>

			<?php if (count($this->rs_lab_data) > 0) { ?>
			<div class="tab-pane fade" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
				<div class="px-3">
					<h3 class="font-md fw-bold mb-3"><?= $this->rs_lab_data[0]['lab_name'] ?></h3>
					<div class="d-flex align-items-start mb-3">
						<div><img src="assets/images/mdrc/order/location-pin.svg" alt="" class="img-fluid"></div>
						<p class="text-dark d-block ms-2 w-100"><?= $this->rs_lab_data[0]['lab_address'] ?></p>
					</div>
				</div>
			</div>
			<?php } ?>
			
			<?php if (count($this->rs_collection_address) > 0) { ?>
			<div class="tab-pane fade" id="mdrc-collection" role="tabpanel" aria-labelledby="mdrc-collection-tab" tabindex="0">
				<div class="px-3">
					<h3 class="font-md fw-bold mb-3"><?= $this->rs_collection_address[0]['prefix'] ?> <?= $this->rs_collection_address[0]['first_name'] ?> <?= $this->rs_collection_address[0]['last_name'] ?></h3>
					<div class="d-flex align-items-start mb-3">
						<div><img src="assets/images/mdrc/order/location-pin.svg" alt="" class="img-fluid"></div>
						<p class="text-dark d-block ms-2 w-100"><?=$this->rs_collection_address[0]['line1']?>, <?=$this->rs_collection_address[0]['area']?>, <?=$this->rs_collection_address[0]['pincode']?>, <?=$this->rs_collection_address[0]['city_name']?> , <?=$this->rs_collection_address[0]['state_name']?></p>
					</div>
					<div class="d-flex align-items-center mb-3 gap-3">
						<div class="d-flex align-items-start">
							<div><img src="assets/images/mdrc/order/calendar.svg" alt="" class="mb-1"></div>
							<p class="text-dark d-block ms-2 w-100"><?=$this->rs_data[0]['home_collection_date']?></p>
						</div>
						<div class="d-flex align-items-start">
							<div><img src="assets/images/mdrc/order/clock.svg" alt="" class="mb-1"></div>
							<p class="text-dark d-block ms-2 w-100"><?=$this->rs_data[0]['home_collection_slot'];?></p>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
	<!-- Order info tabs End -->

	<!-- Booking Summary Start -->
	<div class="booking-summary bg-white px-3 pt-3 pb-1 mb-3">
		<h4 class="font-md fw-bold mb-2">Order Details</h4>
		<div class="d-flex justify-content-between align-items-center pb-2 fw-600">
			<p class="mb-0">Subtotal</p>
			<p class="mb-0"><span><i class="fas fa-rupee-sign"></i> <?= $this->rs_data[0]['subtotal'] ?></span></p>
		</div>
		<div class="d-flex justify-content-between align-items-center pb-2 fw-600">
			<p class="mb-0">Collection Charges</p>
			<p class="mb-0"><span><i class="fas fa-rupee-sign"></i> <?= $this->rs_data[0]['collection_charge'] ?></span></p>
		</div>

		<?php if ($this->rs_data[0]['discount'] > 0) { ?>
		<div class="d-flex justify-content-between align-items-center pb-2 fw-600">
			<p class="mb-0">Discount</p>
			<p class="mb-0"><span>- <i class="fas fa-rupee-sign"></i> <?= $this->rs_data[0]['discount'] ?></span></p>
		</div>
		<?php } ?>

		<?php if ($this->rs_data[0]['wallet_amount'] > 0) { ?>
		<div class="d-flex justify-content-between align-items-center pb-2 fw-600">
			<p class="mb-0">Discount</p>
			<p class="mb-0"><span>- <i class="fas fa-rupee-sign"></i> <?= $this->rs_data[0]['wallet_amount'] ?></span></p>
		</div>
		<?php } ?>

		<div class="d-flex justify-content-between align-items-center pb-2 border-top pt-2">
			<p class="mb-0 fw-bold">Total Amount</p>
			<p class="mb-0 fw-bold"><span><i class="fas fa-rupee-sign"></i> <?= $this->rs_data[0]['net_order_value'] ?></span></p>
		</div>
		<div class="d-flex justify-content-between align-items-center pb-2 border-top pt-2">
			<p class="mb-0 fw-bold">Total Paid</p>
			<p class="mb-0 fw-bold"><span><i class="fas fa-rupee-sign"></i> <?= array_sum(array_column($this->rs_payment, 'transaction_amount')) ?></span></p>
		</div>
		<div class="d-flex justify-content-between align-items-center pb-2 border-top pt-2">
			<p class="mb-0 fw-bold">Balance Due Before Test</p>
			<p class="mb-0 fw-bold"><span><i class="fas fa-rupee-sign"></i> <?= $this->rs_data[0]['net_order_value'] - array_sum(array_column($this->rs_payment, 'transaction_amount'))?></span></p>
		</div>
	</div>
	<!-- Booking Summary End -->

	<div class="p-3 cancle-btn-sticky d-none">
		<a href="" class="btn th-btn-red rounded-pill w-100" type="button">Cancle Order</a>
	</div>
</main>
<!-- Main End -->

<!-- Order lis Offcanvas Start -->
<div class="offcanvas offcanvas-bottom otverify common-popup" tabindex="-1" id="offcanvasExample-tracking-details">
	<div class="offcanvas-body small">
		<div class="form-block sidebarform order-track-detail-html">
		</div>
	</div>
</div>
<!-- Order lis Offcanvas End -->

<!-- Order lis verify Offcanvas Start -->
<div class="offcanvas offcanvas-bottom otverify common-popup" tabindex="-1" id="offcanvasExample-tracking-details-verify">
	<div class="offcanvas-body small">
		<div class="cbtn animation">
			<div class="btnclose d-flex justify-content-end"> <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button></div>
		</div>
		<div class="form-block sidebarform ">
			<h5 class="pt-3 pb-0 fw-700 font-lg text-center">Veify</h5>
			<p class="subhead content-color font-sm text-center">Please Enter Report password to Proceed</p>
			<form id="tracking-details-verify-form" name="tracking-details-verify-form" method="post" data-bs-toggle="validator" class="sidebarForm shake mt40 custom-form" autocomplete="off">
				<div class="row">
				<div class="input-box col-sm-12">
					<label class="mb-1 d-block text-start font-md title-color fw-600">Enter Password</label>
					<input type="password"  id="tracking-password" name="tracking-password" placeholder="Enter Password" class="w-100 login_f_data required" required data-error="Please fill Out" autocomplete="off">
					<div class="help-block with-errors"></div>
				</div>
				</div>
			
				<button type="submit" id="tracking-details-submit" class="btn-solid btn lnk btn-main bg-btn w-100 tracking-details-btn">Proceed</button>
				<input type="hidden" name="track-orderID" id="track-orderID"/>
				<input type="hidden" name="track-orderCustomerMemeberID" id="track-orderCustomerMemeberID"/>
				<div id="tracking-details-invalid" class="mt-3"></div>
			</form>
		</div>
	</div>
</div>
<!-- Order lis verify Offcanvas End -->

<!-- Footer Start -->
<?php include('includes/footer.php'); ?>
<!-- Footer End -->