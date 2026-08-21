<?php 
//$_SESSION['track_orders']=[];
//array_push($_SESSION['track_orders'],'as');
//array_push($_SESSION['track_orders'],'asss');
//unset($_SESSION['track_orders']);
?>
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

<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css'>

<link href="css/custom.css" rel="stylesheet">

<!--Start Header -->



<?php include 'includes/header.php'; ?>



<!--End Header -->







<!--Info Personal-->

<section class="info-personal pt60 pb60 odetails">

	<div class="container">

		<div class="row">

			<div class="col-lg-3">


				<?php include 'includes/myaccount.php'; ?>



			</div>

			<div class="col-lg-9">

				<div class="row">

					<div class="col-lg-8 p-0 col-12 mb20" style="display:none">

						<div class="col-lg-12 bg-white border rounded p-3 mb-3">

							<h5 class="border-bottom  pb-2 mb-2"><a class="text-blue fs-14 t-underline f-semibold d-inline-block float-end" data-bs-toggle="offcanvas" href="#offcanvasExample-tracking-details">View tracking details</a> Patient Name <span class="font-weight-normal h6">(M / 25 Yrs.)</span></h5>

							<h5>RA Test Rheumatoid Arthritis Factor, Quantitative (1 parameters)</h5>

							<p class="text-blue inp">Reporting Time : <strong>24 hrs</strong></p>

							<p class="mt0 mb40 inp">RA Test Rheumatoid Arthritis Factor, Quantitative,</p>

							<div class="row m-auto">

								<div class="col-lg-5 p-0">

									<span class="badge badgenormal">Fasting not required</span>

								</div>

								<div class="col-lg-7 text-end prdiv p-0">

									<h5><span><i class="fas fa-rupee-sign"></i>399 <del><i class="fas fa-rupee-sign"></i>580</del></span> <span class="percnt">Get 20 % OFF</span></h5>

								</div>

							</div>

						</div>

						<div class="col-lg-12 bg-white border rounded p-3 mb-3">

							<h5 class="border-bottom  pb-2 mb-2"><a class="text-blue fs-14 t-underline f-semibold d-inline-block float-end" data-bs-toggle="offcanvas" href="#offcanvasExample-tracking-details">View tracking details</a> Patient Name <span class="font-weight-normal h6">(M / 25 Yrs.)</span></h5>

							<h5>RA Test Rheumatoid Arthritis Factor, Quantitative (1 parameters)</h5>

							<p class="text-blue inp">Reporting Time : <strong>24 hrs</strong></p>

							<p class="mt0 mb40 inp">RA Test Rheumatoid Arthritis Factor, Quantitative,</p>

							<div class="row m-auto">

								<div class="col-lg-5 p-0">

									<span class="badge badgenormal">Fasting not required</span>

								</div>

								<div class="col-lg-7 text-end prdiv p-0">

									<h5><span><i class="fas fa-rupee-sign"></i>399 <del><i class="fas fa-rupee-sign"></i>580</del></span> <span class="percnt">Get 20 % OFF</span></h5>

								</div>

							</div>

						</div>

						<div class="col-lg-12 bg-white border rounded p-3 mb-3">

							<h5 class="border-bottom  pb-2 mb-2"><a class="text-blue fs-14 t-underline f-semibold d-inline-block float-end" data-bs-toggle="offcanvas" href="#offcanvasExample-tracking-details">View tracking details</a> Patient Name <span class="font-weight-normal h6">(M / 25 Yrs.)</span></h5>

							<h5>RA Test Rheumatoid Arthritis Factor, Quantitative (1 parameters)</h5>

							<p class="text-blue inp">Reporting Time : <strong>24 hrs</strong></p>

							<p class="mt0 mb40 inp">RA Test Rheumatoid Arthritis Factor, Quantitative,</p>

							<div class="row m-auto">
								<div class="col-lg-5 p-0">
									<span class="badge badgenormal">Fasting not required</span>
								</div>
								<div class="col-lg-7 text-end prdiv p-0">
									<h5><span><i class="fas fa-rupee-sign"></i>399 <del><i class="fas fa-rupee-sign"></i>580</del></span> <span class="percnt">Get 20 % OFF</span></h5>
								</div>
							</div>
						</div>
					</div>
					<?php if($this->rs_data[0]['order_status']=='Pending') { ?>
					<div class="col-lg-12 pb-2 ml-auto text-end col-12">
					<a class="btn-main bg-btn1 btn-blue lnk text-uppercase" href="#" data-bs-toggle="modal" data-bs-target="#order-cancel-modal" data-order-id="{{ $id }}">Cancel</a>
					</div>
					<?php } ?>
					<div class="col-lg-8  col-12 mb20">
						<?php for ($i = 0; $i < count($this->rs_order_detail); $i++) {
							$age = $this->utility->getAge($this->rs_order_detail[$i]['customer_members_dob']) . " Year";
						?>
							<div class="col-lg-12 bg-white shadow-normal mb-3">
								<div class="row m-auto border-bottom">
									<div class="col-lg-12 p-0 col-12">
										<h5 class="m-0 head  ps-3">
											<?= $this->rs_order_detail[$i]['customer_members_prefix'] . ' ' . $this->rs_order_detail[$i]['customer_members_first_name'] . ' ' . $this->rs_order_detail[$i]['customer_members_last_name']; ?>
											<!-- <a style="margin-left:20px" class="text-blue fs-14 t-underline f-semibold d-inline-block float-lg-end float-md-end float-end" data-bs-toggle="offcanvas" href="#offcanvasExample-tracking-details">View tracking details</a> -->
											<?php if($this->rs_order_detail[$i]['lis_visitor_id']!='') { ?>
											
											<a style="margin-left:20px" class="text-blue fs-14 t-underline f-semibold d-inline-block float-lg-end float-md-end float-end" onclick="callOrderCustomerStatus('<?= $this->rs_order_detail[$i]['order_master_id']; ?>','<?= $this->rs_order_detail[$i]['customer_members_id']; ?>');">View tracking details</a>

											<a style="margin-left:20px" class="text-blue fs-14 t-underline f-semibold d-inline-block float-lg-end float-md-end float-end">Visitor ID  : <?=$this->rs_order_detail[$i]['lis_visitor_id'];?></a>

											<?php } ?>
										</h5>
									</div>

									<div class="col-lg-12 ps-3 pe-3">
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
										<?= $member_html ?>
									</div>
								</div>

								<?php for ($j = 0; $j < count($this->rs_order_detail_cust); $j++) {
									if ($this->rs_order_detail_cust[$j]['customer_members_id'] == $this->rs_order_detail[$i]['customer_members_id']) {
								?>
										<div class="col-lg-12 bg-white odetailpackage d-flex p-3">
											<div class="packname">
												<h4><?= $this->rs_order_detail_cust[$j]['order_item_name'] ?> <a class="ms-2 itemsDetails" data-id="<?= $this->rs_order_detail_cust[$j]['item_id'] ?>"><i class="fas fa-chevron-down text-black"></i></a><br><span>Includes <?= $this->rs_order_detail_cust[$j]['order_item_test_count'] ?> Tests</span></h4>
											</div>
											<div class="pricdiv ms-lg-auto ms-md-auto">
												<h5><span class="float-lg-end float-md-end float-start"><i class="fas fa-rupee-sign"></i><?= $this->rs_order_detail_cust[$j]['price'] ?></span></h5>
											</div>
										</div>

										<div class="col-lg-12 ps-3 pe-3">
											<?php if ($this->rs_order_detail_cust[$j]['prescription_data'] != '') { ?>
												<div class="vtest-btn text-dark d-inline-block w-100 mb-2" href="#">Prescription Info <a class="float-end vdet text-blue prescriptionOrderView" data-id="<?= $this->rs_order_detail_cust[$j]['id'] ?>">View Details</a>
												</div>
											<?php } ?>
										</div>
								<?php }
								} ?>

							</div>
						<?php } ?>

					</div>

					<div class="col-lg-4 col-12 mb20">

						<div class="col-lg-12 bg-white col-12 mb20">

							<div class="row m-auto">

								<div class="col-lg-12 p-0 col-12">

									<h5 class="m-0 head border-bottom ps-3">Order Summary</h5>

								</div>

							</div>

							<div class="row m-auto pt20 pb20">

								<div class="col-lg-12 col-12">

									<div class="d-inline-block mb-2 fs-14 w-100"><span>Order No:</span> <span class="float-end"><?= $this->rs_data[0]['display_order_no'] ?></span></div>

									<div class="d-inline-block mb-2 fs-14 w-100"><span>Order Date:</span> <span class="float-end"><?= $this->rs_data[0]['order_date'] ?></span></div>

									<div class="d-inline-block mb-2 fs-14 w-100"><span>Order Status:</span> <span class="float-end"><?= $this->rs_data[0]['order_status'] ?></span></div>

									<div class="d-inline-block mb-2 fs-14 w-100"><span>Payment Type:</span> <strong class="float-end text-black"><?= $this->rs_data[0]['payment_type'] ?></strong></div>

								</div>

							</div>

						</div>

						<?php if (count($this->rs_lab_data) > 0) { ?>

							<div class="col-lg-12 bg-white col-12 mb20">

								<div class="row m-auto">

									<div class="col-lg-12 p-0 col-12">

										<h5 class="m-0 head border-bottom ps-3">Lab Address</h5>

									</div>

								</div>

								<div class="row m-auto pt20 pb20">

									<div class="col-lg-12">

										<div class="d-inline-block mb-2 fs-14 lh-1-3 w-100"><strong class="fwsb"><?= $this->rs_lab_data[0]['lab_name'] ?>: </strong><br><?= $this->rs_lab_data[0]['lab_address'] ?></div>




									</div>

								</div>

							</div>

						<?php } ?>


						<?php if (count($this->rs_collection_address) > 0) { ?>

							<div class="col-lg-12 bg-white col-12 mb20">

								<div class="row m-auto">

									<div class="col-lg-12 p-0 col-12">

										<h5 class="m-0 head border-bottom ps-3">Sample Collection Address</h5>

									</div>

								</div>

								<div class="row m-auto pt20 pb20">

									<div class="col-lg-12">

										<div class="d-inline-block mb-2 fs-14 lh-1-3 w-100">
											<strong class="fwsb"><?= $this->rs_collection_address[0]['prefix'] ?> <?= $this->rs_collection_address[0]['first_name'] ?> <?= $this->rs_collection_address[0]['last_name'] ?>: </strong>
											<br>
											<?=$this->rs_collection_address[0]['line1']?>, <?=$this->rs_collection_address[0]['area']?>, <?=$this->rs_collection_address[0]['pincode']?>, <?=$this->rs_collection_address[0]['city_name']?> , <?=$this->rs_collection_address[0]['state_name']?>
											<br>

											Date : <?=$this->rs_data[0]['home_collection_date']?> <br/>
											Time : <?=$this->rs_data[0]['home_collection_slot']?>

										</div>




									</div>

								</div>

							</div>

						<?php } ?>

						<div class="col-lg-12 right-cart">

							<div class="cart-extra-sevc div-for-data p-0 border-0">

								<div class="row m-auto">

									<div class="col-lg-12 p-0 col-12">

										<h5 class="m-0 head border-bottom ps-3">Order Details</h5>

									</div>

								</div>

								<div class="col-lg-12 ps-3 pe-3 col-12">

									<table class="table border-0">

										<tbody>

											<tr>

												<th>Subtotal</th>

												<td><span class="prc"><i class="fas fa-rupee-sign"></i><?= $this->rs_data[0]['subtotal'] ?></span></td>

											</tr>

											<tr>

												<th>Collection Charges</th>

												<td><span class="prc text-blue"><i class="fas fa-rupee-sign"></i><?= $this->rs_data[0]['collection_charge'] ?></span></td>

											</tr>

											<?php if ($this->rs_data[0]['discount'] > 0) { ?>
												<tr>

													<th>Discount</th>

													<td><span class="prc text-blue">-<i class="fas fa-rupee-sign"></i><?= $this->rs_data[0]['discount'] ?></span></td>

												</tr>

											<?php } ?>
											<?php if ($this->rs_data[0]['wallet_amount'] > 0) { ?>
												<tr>

													<th>Wallet</th>

													<td><span class="prc text-blue">-<i class="fas fa-rupee-sign"></i><?= $this->rs_data[0]['wallet_amount'] ?></span></td>

												</tr>

											<?php } ?>

											<tr class="tpayable">

												<th>Total</th>

												<td><span class="prc"><i class="fas fa-rupee-sign"></i><?= $this->rs_data[0]['net_order_value'] ?></span></td>

											</tr>



										</tbody>

									</table>

								</div>

							</div>

						</div>

					</div>

				</div>

			</div>



		</div>

</section>

<!--End Info Personal-->
<div class="niwaxofcanvas offcanvas offcanvas-end otverify" tabindex="-1" id="offcanvasExample-tracking-details">
	<div class="offcanvas-body">
		<div class="cbtn animation">
			<div class="btnclose"> <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button></div>
		</div>
		<div class="form-block sidebarform order-track-detail-html">
		</div>
	</div>
</div>

<div class="niwaxofcanvas offcanvas offcanvas-end otverify" tabindex="-1" id="offcanvasExample-tracking-details-verify">
	<div class="offcanvas-body">
		<div class="cbtn animation">
			<div class="btnclose"> <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button></div>
		</div>
		<div class="form-block sidebarform ">
			<h5 class="pt-3 pb-0">Veify</h5>
			<p class="subhead">Please Enter Report password to Proceed</p>
			<form id="tracking-details-verify-form" name="tracking-details-verify-form" method="post" data-bs-toggle="validator" class="sidebarForm shake mt40" autocomplete="off">
				<div class="row">
				<div class="form-group col-sm-12">
					<label>Enter Password</label>
					<input type="password"  id="tracking-password" name="tracking-password" placeholder="Enter Password" class="login_f_data required" required data-error="Please fill Out" autocomplete="off">
					<div class="help-block with-errors"></div>
				</div>
				</div>
			
				<button type="submit" id="tracking-details-submit" class="btn lnk btn-main bg-btn w-100 tracking-details-btn">Proceed <span class="circle"></span></button>
				<input type="hidden" name="track-orderID" id="track-orderID"/>
				<input type="hidden" name="track-orderCustomerMemeberID" id="track-orderCustomerMemeberID"/>
				<div id="tracking-details-invalid" class="mt-3"></div>
			</form>
		</div>
	</div>
</div>
<!-- cancel modal -->
<div class="popup-modals modal-ad-style">
  <div class="modal" id="order-cancel-modal" tabindex="-1" >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <div class="common-heading">
            <h4 class="mt0 mb0">Order Cancel</h4>
          </div>
          <button type="button" class="closes" data-bs-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body ">
          <div class="form-block fdgn2 mt10 mb10">
            <form method="post" id="order_cancel" name="order_cancel">
             	<? $this->htmlBuilder->buildTag("input", array("type"=>"hidden","value"=>$this->rs_data[0]['id']), "id") ?>
            	<? $this->htmlBuilder->buildTag("input", array("type"=>"hidden","value"=>'Canceled'), "status") ?>
				<? $this->htmlBuilder->buildTag("input", array("type"=>"hidden","value"=>$this->rs_data[0]['customer_id']), "customer_id") ?>
				<? $this->htmlBuilder->buildTag("input", array("type"=>"hidden","value"=>'statusChange'), "act") ?>
              	<div class="fieldsets row">
					<div class="col-md-12">
						<label>Remark</label>
						<? $this->htmlBuilder->buildTag("textarea", array("class"=>"required"), "remark_other") ?>
					</div>
              	</div>
				<div class="fieldsets mt20 pb20 d-flex justify-content-center">
					<button type="submit" name="submit" class="lnk btn-main bg-btn w-auto me-2 ajax_modal_submit" >Save<span class="circle"></span></button>
					<a href="javascript:void(0)" class="btn-outline lnk ms-2" data-bs-dismiss="modal">Cancel<span class="circle"></span></a>
				</div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
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
<?php include 'includes/general_data.php'; ?>