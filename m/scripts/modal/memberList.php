<?php
$id = $app->getGetVar('id');
$city_id = $_SESSION['cityID'];
$city_cond = " and FIND_IN_SET ('" . $city_id . "',item.city_ids) and item_price.city_id='" . $city_id . "'";
$master_con = $city_cond;

$obj_model_all = $app->load_model("customer_members");
//$obj_model_all->join_table("item_other_data", "left", array(), array("id"=>"item_id"));
//$obj_model_all->join_table("item_price", "left", array(), array("id"=>"item_id"));
//$obj_model_all->join_table("item_description", "left", array(), array("id"=>"item_id"));		
$obj_model_all->join_table("city", "left", array("name"), array("city_id" => "id"));
$obj_model_all->join_table("state", "left", array("name"), array("state_id" => "id"));
$rs_data = $obj_model_all->execute("SELECT", false, "", "customer_members.id!=0 and customer_members.customer_id='" . $_SESSION['MDRCCustID'] . "' and customer_members.status!='Trash'", "customer_members.id DESC", "");
?>
<div class="action action-confirmation offcanvas offcanvas-bottom common-popup" tabindex="-1" id="Modalselect-add-patients" aria-labelledby="Modalselect-add-patients">
        <div class="offcanvas-header">

        <div class="d-flex align-items-center justify-content-between w-100">
			<h3 class="fw-600">SELECT / ADD PATIENTS</h3>
			<div class="btnclose">
				<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
			</div>
		</div>
          <!-- <div class="common-heading">
            <h4 class="mt0 mb0">SELECT / ADD PATIENTS</h4>
          </div>
          <button type="button" class="closes" data-bs-dismiss="modal">&times;</button> -->
          
        </div>
        <div class="offcanvas-body small pe-0">
          <div class="form-block fdgn2 add-patient mt10">
            <form action="#" method="post" name="feedback-form">
              <input type="hidden" name="cartID" id="cartID" value="<?= $id ?>">


              <?php if (count($rs_data) > 0) { ?>
                <div class="fieldsets row m-auto bdr border-top-0">
                  <div class="col-md-12 text-end">
                    <button type="button" name="submit" class="btn-solid btn-main fw-bold font-sm bg-btn1 btn-blue lnk text-uppercase w-auto AddMemberData ms-2 text-center" data-id="<?= $id ?>">Add New Member<span class="circle"></span></button>
                  </div>

                  <?php for ($i = 0; $i < count($rs_data); $i++) { ?>
                    <div class="col-md-12 pt-3 pb-3 ps-4">
                      <div class="custom-control custom-radio">
                        <label class="custom-control-label">
                          <input type="radio" value="<?= $rs_data[$i]['id'] ?>" name="members">
                          <svg class="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M9 20l-7-7 3-3 4 4L19 4l3 3z"></path>
                          </svg>
                          <span class="ms-2 adri"><span class="fw-bold font-sm"><?= ($i + 1) ?>. <?= $rs_data[$i]['prefix'] ?> <?= $rs_data[$i]['first_name'] ?> <?= $rs_data[$i]['last_name'] ?></span><br><?= $rs_data[$i]['gender'] ?> , <?= $rs_data[$i]['age'] ?> yrs.
                            <br>
                            <span class="font-sm">
                              <?= $rs_data[$i]['line1'] ?><?php if ($rs_data[$i]['area'] != '') { ?>,<?php } ?> <?= $rs_data[$i]['area'] ?><?php if ($rs_data[$i]['city_name'] != '') { ?>,<?php } ?> <?= $rs_data[$i]['city_name'] ?> - <?= $rs_data[$i]['pincode'] ?><?php if ($rs_data[$i]['state_name'] != '') { ?>,<?php } ?> <?= $rs_data[$i]['state_name'] ?>
                            </span>
                          </span>
                        </label>

                      </div>
                    </div>

                  <?php } ?>


                </div>


                <div class="fieldsets row m-auto pt-0 pb-0">
                  <div class="col-lg-12 pt-0 pb-0 col-12 error_div" id="ListCouponDiv">
                  </div>
                </div>

                <div class="fieldsets row m-auto pt-3 pb-3">
                  <div class="col-md-6 ms-auto">
                    <button type="button" name="submit" class="btn-solid-green btn-main bg-btn1 btn-blue lnk bg-success add-totest text-uppercase w-100 selectMemberData">Add to Test <span class="circle"></span></button>
                  </div>
                </div>
              <?php } else { ?>

                <div class="fieldsets row m-auto pt-3 pb-3" style="text-align:center">
                  <div class="col-md-12">
                    <p class="mb-3">No Members Added.</p>
                    <button type="button" name="submit" class="btn-main bg-btn1 btn-blue lnk text-uppercase w-auto AddMemberData" data-id="<?= $id ?>">Add Member <span class="circle"></span></button>
                  </div>
                </div>
              <?php } ?>
            </form>
          </div>
        </div>
</div>