<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css'>
<?php include 'includes/header.php'; ?>



<main class="page-common">
	<div class="row py-3 cart-steps-row m-0">
		<div class="col-12 stepsinfo text-center">
			<ul>
				<li class="active">
					<a href="cart"><span>1</span><br>Cart</a>
				</li>
				<li class="active">
					<a href="javascript:void(0);"><span>2</span><br>Schedule &amp; Book</a>
				</li>
				<li>
					<a href="javascript:void(0);"><span>3</span><br>Booked</a>
				</li>
			</ul>
		</div>
	</div>

	<?= $this->utility->get_message() ?>

</main>

<!--Shop Products-->
<section class="shop-products-bhv checkout-section pt-0 pb60" style="">
	<div class="container">
		<div class="row">

			<div class="col-12">
				<div class="accordion" id="accordionExample">
					<?php
					$no = 0;
					?>

					<?php
					if ($_SESSION['homeCollection'] == 'Yes') {
						$secondTabId = 'show';
						$thirdTabId = '';
						$thirdTabClass = 'collapsed';
					} else {
						$thirdTabId = 'show';
						$thirdTabClass = '';
					}
					?>
					<?php if ($_SESSION['homeCollection'] == 'Yes') {
						$no = $no + 1;
					?>
						<div class="accordion-item">
							<h2 class="accordion-header" id="headingNEw">
								<button class="accordion-button tab-heading  collapseNEw" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNEw" aria-expanded="false" aria-controls="collapseThree">
									<span class="nav_link_icon ml__5 me-2"><?= $no ?></span> Choose Home Sample Collection address, date & Time
								</button>
							</h2>
							<div id="collapseNEw" class="accordion-collapse collapse <?= $secondTabId ?>" aria-labelledby="headingNEw" data-bs-parent="#accordionExample">
								<div class="accordion-body">
									<div class="col-lg-12 acSps">
										<form name="homeAddressSelectForm" id="homeAddressSelectForm" method="post" action="">
											<div class="row align-item-center">
												<div class="col-sm-12 homeAddressError">
												</div>
											</div>
											<div class="row">
												<?php for ($i = 0; $i < count($this->rs_add); $i++) {
													if ($_SESSION['checkoutAddressID'] == $this->rs_add[$i]['id']) {
														$addCheck = 'checked="checked"';
													} else {
														$addCheck = '';
													}
												?>
													<div class="col-lg-4 AddressCard mb-3">
														<label class="bg-white rounded w-100 shadow2 p-3">
															<input class="float-end" type="radio" value="<?= $this->rs_add[$i]['id'] ?>" name="addID" <?= $addCheck ?>>
															<span class="ml-3"><strong class="fwsb"><?= ($i + 1) ?>. <?= $this->rs_add[$i]['prefix'] ?> <?= $this->rs_add[$i]['first_name'] ?> <?= $this->rs_add[$i]['last_name'] ?> </strong><br /><?= $this->rs_add[$i]['gender'] ?> , <?= $this->rs_add[$i]['age'] ?> yrs.<br /> <?= $this->rs_add[$i]['line1'] ?>,<?= $this->rs_add[$i]['area'] ?>, <?= $this->rs_add[$i]['city_name'] ?> - <?= $this->rs_add[$i]['pincode'] ?>, <?= $this->rs_add[$i]['state_name'] ?></span>
														</label>
													</div>
												<?php } ?>
												<div class="col-lg-12 cdate">
													<div class="form-block">
														<div class="row ">
															<div class="form-group col-sm-12">
																<label class="text-blue fwsb mb-2">CHOOSE DATE & TIME FOR HOME SAMPLE COLLECTION *</label>
															</div>
															<div class="form-group col-sm-5 has-error ">
																<!-- <input class="ps-0" type="date" id="" placeholder="Select sample collection date" data-error="Please fill Out"> -->
																<div class="col-12 p-0">
																	<div class="input-group date" id="datepicker">
																		<input type="text" class="form-control required" name="collectionDate" id="date" value="<?= $_SESSION['checkoutCollectionDate'] ?>" />
																		<span class="input-group-append">
																			<span class="input-group-text d-block">
																				<i class="fa fa-calendar"></i>
																			</span>
																		</span>
																	</div>
																</div>
																<div class="help-block with-errors"></div>
															</div>
															<div class="form-group col-sm-5 has-error ">
																<div class="fieldsets row">
																	<div class="col-md-12">
																		<select class="required form-select mt-sm-0 mt-3" name="collectionTime" id="collectionTime">
																			<option value="">Select collection Time</option>
																			<?php
																			$datastartTime = $this->home_collection_data[0]['start_time'];
																			$dataendTime = $this->home_collection_data[0]['end_time'];
																			$dataslot = $this->home_collection_data[0]['slot'];
																			for ($i = 0; $i < 9; $i++) {
																				$m = $i + 1;
																				$start = $i * $dataslot;
																				$end = $m * $dataslot;
																				$strartTime = date('h:i A', strtotime('+' . $start . ' minutes', strtotime($datastartTime)));
																				$endTime = date('h:i A', strtotime('+' . $end . ' minutes', strtotime($datastartTime)));
																				$homeSlot = $strartTime . ' - ' . $endTime;
																				if ($_SESSION['checkoutCollectionTime'] == $homeSlot) {
																					$selected = 'selected="selected"';
																				} else {
																					$selected = '';
																				}
																			?>
																				<option value="<?= $homeSlot ?>" <?= $selected ?>><?= $homeSlot ?></option>
																			<?php } ?>
																		</select>
																		<div class="help-block with-errors"></div>
																	</div>
																</div>
															</div>
														</div>
														<div class="row align-item-center mt-3">
															<div class="col-sm-9 ">
																<span class="text-dark Ctext">* Choose sample collection date & time to proceed further</span>
															</div>
															<div class="col-sm-3 mt-3">
																<button type="submit" class="btn-solid btn-main bg-btn1 btn-blue lnk  text-uppercase homeAddressBtn w-100">Next <span class="circle"></span></button>
															</div>
														</div>
													</div>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
					<?php if ($_SESSION['labSelection'] == 'Yes') {
						$no = $no + 1;
					?>
						<div class="accordion-item">
							<h2 class="accordion-header" id="headingThree">
								<button class="accordion-button tab-heading <?= $thirdTabClass ?> collapseThree" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
									<span class="nav_link_icon ml__5 me-2"><?= $no ?></span>
									<div id="step3_heading"> Nearby Diagnostic Centre for Radiology Imaging Test </div>
								</button>
							</h2>
							<div id="collapseThree" class="accordion-collapse collapse <?= $thirdTabId ?>" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
								<div class="accordion-body">
									<div class="col-lg-12 acSps">
										<div class="row align-item-center">
											<div class="col-sm-12 labSelectionError">
											</div>
										</div>
										<form name="labSelectForm" id="labSelectForm" method="post" action="">
											<div class="row">
												<?php for ($i = 0; $i < count($this->rs_lab); $i++) {
													if ($_SESSION['checkoutLabID'] == $this->rs_lab[$i]['id']) {
														$labCheck = 'checked="checked"';
													} else {
														$labCheck = '';
													}
												?>
													<div class="col-12 AddressCard mb-3">
														<label class="bg-white rounded p-3 w-100 shadow2" for="labID">
															<input class="float-end" type="radio" value="<?= $this->rs_lab[$i]['id'] ?>" name="labID" id="labID" <?= $labCheck ?>>
															<span class="ml-3"><strong class="fwsb"><?= $this->rs_lab[$i]['name'] ?>: </strong><br /><?= $this->rs_lab[$i]['address'] ?></span>
														</label>
													</div>
												<?php } ?>
												<div class="col-lg-12 cdate">
													<div class="form-block">
														<div class="row ">
															<div class="form-group col-sm-12">
																<label class="text-blue fwsb mb-2">Choose Date & Preferred Time Slot for Radiology Imaging test *</label>
															</div>
															<div class="form-group col-sm-5 has-error ">
																<!-- <input class="ps-0" type="date" id="" placeholder="Select sample collection date" data-error="Please fill Out"> -->
																<div class="col-12 p-0">
																	<div class="input-group date" id="datepicker2">
																		<input type="text" class="form-control required" name="labDate" value="<?= $_SESSION['labDate'] ?>" id="date" />
																		<span class="input-group-append">
																			<span class="input-group-text d-block">
																				<i class="fa fa-calendar"></i>
																			</span>
																		</span>
																	</div>
																</div>
																<div class="help-block with-errors"></div>
															</div>
															<div class="form-group col-sm-5 has-error ">
																<div class="fieldsets row">
																	<div class="col-md-12">
																		<select class="required form-select mt-sm-0 mt-3" name="labTime" id="labTime">
																			<option value="">Select Time</option>
																			<?php
																			$datastartTime = $this->lab_timiming_data[0]['start_time'];
																			$dataendTime = $this->lab_timiming_data[0]['end_time'];
																			$dataslot = $this->lab_timiming_data[0]['slot'];
																			for ($i = 0; $i < 3; $i++) {
																				$m = $i + 1;
																				$start = $i * $dataslot;
																				$end = $m * $dataslot;
																				$strartTime = date('h:i A', strtotime('+' . $start . ' minutes', strtotime($datastartTime)));
																				$endTime = date('h:i A', strtotime('+' . $end . ' minutes', strtotime($datastartTime)));
																				$homeSlot = $strartTime . ' - ' . $endTime;
																				if ($_SESSION['labTime'] == $homeSlot) {
																					$selected = 'selected="selected"';
																				} else {
																					$selected = '';
																				}
																			?>
																				<option value="<?= $homeSlot ?>" <?= $selected ?>><?= $homeSlot ?></option>
																			<?php } ?>
																		</select>
																		<div class="help-block with-errors"></div>
																	</div>
																</div>
															</div>
														</div>
														<div class="row align-item-center mt-3">
															<div class="col-sm-9">
																<span class="text-dark Ctext">* Appointment time is not investigation time, sometimes previously allotted appointment takes longer to complete. </span>
															</div>
															<div class="col-sm-3 mt-3">
																<button type="submit" class="btn-solid btn-main bg-btn1 btn-blue lnk  w-100 text-uppercase labSelectionBtn">Next <span class="circle"></span></button>
															</div>
														</div>
													</div>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
					<?php
					$no = $no + 1;
					?>
					<div class="accordion-item">
						<h2 class="accordion-header" id="headingFour">
							<button class="accordion-button tab-heading collapsed collapseFour" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseThree">
								<span class="nav_link_icon ml__5 me-2"><?= $no ?></span> Payment Option
							</button>
						</h2>
						<div id="collapseFour" class="accordion-collapse collapse paymentoption" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
							<div class="accordion-body">
								<div class="col-lg-12 acSps">
									<?php
									$cod = '';
									$online = '';
									if ($_SESSION['payment_type'] == 'ONLINE') {
										$online = 'checked="checked"';
									} else if ($_SESSION['payment_type'] == 'COD') {
										$cod = 'checked="checked"';
									}
									?>
									<div class="row">
										<div class="col-lg-12">
											<?php
											/*Rahul 01-12-2022 Payment Getway hide */
											if ($_SESSION['checkoutOnline'] == 'Yes') { ?>
												<!--ONLINE-->
												<div class="col-lg-12 AddressCard mb-2">
													<label class="bg-white rounded w-100 d-flex gap-3 pt-2">
														<input class="" type="radio" name="paymnetOption" value="ONLINE" onclick="SelectPayMethod('ONLINE')" <?= $online ?>>
														<span class="ml-3 text-dark">Pay Online / UPI / Cards / QR Code</span>
													</label>
												</div>
											<?php } ?>
											<?php /*Rahul 01-12-2022 COD Only Show*/
											if ($_SESSION['checkoutCod'] == 'Yes') { ?>
												<!--COD-->
												<div class="col-lg-12 AddressCard mb-2">
													<label class="bg-white rounded w-100 d-flex gap-3 pt-2">
														<input class="" type="radio" name="paymnetOption" value="COD" onclick="SelectPayMethod('COD')" <?= $cod ?>>
														<span class="ml-3 text-dark">Cash on Sample Collection / Bill at MDRC Centre</span>
													</label>
												</div>
											<?php } ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-12 right-cart">
				<div class="cart-extra-sevc div-for-data walletinfo mt-3 bg-white p-3">
					<h6 class="font-md fw-bold">Reward Point</h6>
					<?php
					$wallet = $this->utility->moneyFormatIndia($this->rs_customer['wallet']);
					$promoWallet = $this->utility->moneyFormatIndia($this->rs_customer['promoWallet']);
					if ($_SESSION['wallet_check'] == 'Yes') {
						$mdrcwallet = 'checked="checked"';
					} else {
						$mdrcwallet = '';
					}
					?>
					<div class="custom-control custom-checkbox text-dark d-flex justify-content-between align-items-center mt-3">
						<div class="d-flex align-items-center gap-2">
							<img src="assets/images/mdrc/my-cart/wallet.svg" alt="" class="img-fluid me-1">
							<label class="custom-control-label" for="MDRCwallet"><strong>MDRC Wallet</strong><br><span class="balsize d-inline-block">Balance : <span class="fwb  text-success"><?= $wallet ?></span></label>
						</div>
						<input type="checkbox" class="custom-control-input" id="MDRCwallet" name="MDRCwallet" value="Yes" onclick="WalletSelection()" <?= $mdrcwallet ?>>
					</div>
					<div class="custom-control custom-checkbox text-dark" style="display:none">
						<input type="checkbox" class="custom-control-input" id="MDRCwalletPromo" name="MDRCwalletPromo" value="Yes" onclick="WalletSelection()" <?= $mdrcwallet ?>>
						<label class="custom-control-label" for="MDRCwalletPromo"><strong>MDRC Promo Wallet</strong><br><span class="balsize d-inline-block">Balance : <span class="fwb  text-success"><i class="fas fa-rupee-sign ms-1"></i> <?= $promoWallet ?></span></label>
					</div>
				</div>

				<!-- coupon card -->
				<div class="cart-extra-sevc div-for-data mt-3 bg-white p-3">
					<h6 class="fw-bold font-md mb-2">Coupons</h6>
					<div class="promo_apply w-100" style="">
						<div class="col-12 w-100 p-0">
							<p class="text-dark coup-p ft w-100 mb-0 d-flex justify-content-between align-items-center">
								<i class="fas fa-tag fs__22 position-absolute al-pos mr-2 text-dark"></i>
								Apply Coupons<a href="javascript:void(0)" class="float-end couponModal btn btn-outline-danger" data-id="">Apply</a> 
							</p>
						</div>
					</div>

					<div class="promo_success"></div>
				</div>
				<!-- coupon card -->
				

				
				<div class="cart-extra-sevc div-for-data bg-white p-3 mt-3">
					<h6 class="font-md fw-bold mb-2">Order Summary <span class="fs__12">(<?= count($this->rs_cartmini) ?> Items)</span></h6>
					<div class="order_total_calculation">
					</div>
					<span class="d-block fs-14">*inclusive of all the taxes, fees and subject to availability</span>
					<div class="col-12 p-0 mt-2 col-md-12" id="CheckoutDiv"></div>
				</div>
			</div>
		</div>
	</div>
</section>
<!--End Shop Products-->

<div class="checkout-bottom">
	<div class=" price-list w-100">
		<form method="post" action="" name="CheckoutForm" id="CheckoutForm">
			<input type="hidden" name="act" id="act" value="place_order">
			<button type="submit" class="btn btn-solid-green checkout-btn lnk w-100 PlaceOrderBtn">PAY NOW</button>
		</form>
	</div>
</div>

<!--Start Footer -->
<?php include 'includes/footer.php'; ?>
<!--End Footer -->
<script src='https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js'></script>
<script src="scripts/js/load_checkout.js?v=1.2"></script>
<script id="rendered-js">
	var holiDays = [<?php echo sprintf("'%s'", implode("','", $this->holidaysDate)); ?>];
	$(function() {
		$('#datepicker').datepicker({
			format: 'dd-mm-yyyy',
			startDate: '+1d',
			datesDisabled: holiDays
		});
		$('#datepicker2').datepicker({
			format: 'dd-mm-yyyy',
			startDate: '+1d',
			datesDisabled: holiDays
		});
		$('#datepicker23').datepicker({
			beforeShowDay: setHoliDays
		});
		$('#datepicker24').datepicker({
			beforeShowDay: setHoliDays
		});
	});

	function setHoliDays(date) {
		for (i = 0; i < holiDays.length; i++) {
			if (date.getFullYear() == holiDays[i][0] &&
				date.getMonth() == holiDays[i][1] - 1 &&
				date.getDate() == holiDays[i][2]) {
				return [true, 'holiday', holiDays[i][3]];
			}
		}
		return [true, ''];
	}
</script>
<script>
	show_order_total_calculation('<?= $_SESSION['wallet_check'] ?>');
</script>