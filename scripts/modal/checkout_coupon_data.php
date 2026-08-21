<?php
$id = $app->getGetVar('id');
$getType = $app->getGetVar('getType');

$obj_model_coupon = $app->load_model("coupon");
$obj_model_coupon->join_table("coupon_info", "left", array(), array("id"=>"coupon_id"));
$rs_coupon = $obj_model_coupon->execute("SELECT", false, "", "status='Active' and display_list='Yes' and (category_ids='' or (cat_include='Yes' and FIND_IN_SET('".$_SESSION['cityID']."',`category_ids`)) or (cat_include='No' and NOT FIND_IN_SET('".$_SESSION['cityID']."',`category_ids`)))", "coupon.id DESC");
// /SELECT * FROM `coupon` 
//LEFT JOIN coupon_info on coupon_info.coupon_id=coupon.id
//WHERE status='Active' and display_list='Yes' and (category_ids='' or (cat_include='Yes' and FIND_IN_SET(1,`category_ids`)) or (cat_include='No' and NOT FIND_IN_SET(1,`category_ids`)))
?>
<!-- The Modal -->
<div class="popup-modals modal-ad-style coup-modal">
	<div class="modal show" id="coupon-modal">
		<div class="modal-dialog ">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header">
					<div class="common-heading">
						<h4 class="mt0 mb0">APPLY COUPONS</h4>
					</div>
					<button type="button" class="closes" data-bs-dismiss="modal">&times;</button>
				</div>
				<!-- Modal body -->
				<div class="modal-body p-0">
					<div class="form-block fdgn2 mt10 mb10">
						<form class="" id="promo_code_form" name="promo_code_form" method="post" action="">
							<div class="fieldsets row m-auto">
								<div class="col-md-12 ps-4 pe-4 mt-3 mb-3 space_coupon position-relative">
									<input class="required m-0" type="text" id="coupon_code" name="coupon_code" placeholder="Enter coupon code">
									<button type="submit" class="check-coupon" id="appyCouponBtn">CHECK</button>
									<small class="text-danger error_div" id="CustomCouponDiv"></small>
								</div>
							</div>
						</form>
					</div>
					<div class="form-block fdgn2 mt10 " >
						<div class="fieldsets row m-auto bdr">
							<?php if (count($rs_coupon) > 0) { ?>
								<?php for ($i = 0; $i < count($rs_coupon); $i++) { ?>
									<div class="col-md-12 pt-3 pb-3 ps-4 pe-4">
										<div class="custom-control custom-radio">
										<label class=" wallet-check coupon-code position-relative custom-control-label">
											<input class="" type="radio" name="coupon-check" value="<?= $rs_coupon[$i]['coupon_code'] ?>">
											<svg class="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
												<path d="M9 20l-7-7 3-3 4 4L19 4l3 3z"></path>
											</svg>
											<span class="d-inline-block c-bdr text-dark rounded fwseb"><?= $rs_coupon[$i]['coupon_code'] ?></span>
											<span class="d-block mt-2 text-dark fs__13"><?= nl2br($rs_coupon[$i]['msg']) ?></span>
										</label>
										</div>
									</div>
								<?php } ?>
							<?php } else { ?>
								<div class="col-lg-12 p-0 text-center col-12">
									<p class="fs__12">No other coupons available</p>
								</div>
							<?php } ?>
						</div>
					</div>
					<?php if (count($rs_coupon) > 0) { ?>
						
						<div class="fieldsets row m-auto pt-3 pb-3">
							
						<div class="col-lg-12 pt-2 pb-2 col-12 error_div" id="ListCouponDiv">
							</div>
									<div class="col-lg-6 col-6 pl-4">
									</div>
									<div class="col-lg-6 col-6">
										<button type="button" class="btn-main bg-btn1 btn-blue lnk text-uppercase w-100 appyCouponBtn" id="appyCouponBtn">Apply</button>
									</div>
								
							
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>