<!--Start Header -->
<?php include 'includes/header.php'; ?>
<!--End Header -->
<main class="h-100vh overflow-auto">
    <!-- Cart Steps Start -->
    <div class="row py-3 cart-steps-row m-0 bg-white">
        <div class="col-12 stepsinfo text-center">
            <ul>
                <li class="active">
                    <a href="javascript:void(0);"><span>1</span><br>Cart</a>
                </li>
                <li class="active">
                    <a href="avascript:void(0);"><span>2</span><br>Schedule &amp; Book</a>
                </li>
                <li class="active">
                    <a href="avascript:void(0);"><span>3</span><br>Booked</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- Cart Steps End -->

    <div class="d-flex align-items-center bg-theme p-3">
        <img src="assets/images/mdrc/img/suceess.png" alt="" class="img-fluid wd-50 ht-50">
        <p class="mb-0 font-md text-white fw-bold ms-3">Your Booking is Confirmed!</p>
    </div>

    <!-- Booking Summary Start -->
    <div class="booking-summary bg-white px-3 pt-3 pb-1 mb-3">
        <h4 class="font-md fw-bold pb-2">Booking Summary</h4>
        <div class="d-flex justify-content-between align-items-center pb-2 fw-600">
            <p class="mb-0">Booking ID</p>
            <p class="mb-0"><?= $this->rs_data[0]['display_order_no'] ?></p>
        </div>
        <div class="d-flex justify-content-between align-items-center pb-2 fw-600">
            <p class="mb-0">Booking Date</p>
            <p class="mb-0"><?= $this->rs_data[0]['order_date'] ?></p>
        </div>
        <div class="d-flex justify-content-between align-items-center pb-2 border-top pt-2">
            <p class="mb-0 font-md fw-bold">Grand Total</p>
            <p class="mb-0 font-md fw-bold"><i class="fas fa-rupee-sign"></i> <?= $this->rs_data[0]['net_order_value'] ?></p>
        </div>
    </div>
    <!-- Booking Summary End -->

    <?php if (!empty($this->tracking_id)) { ?>
    <!-- Booking Summary Start -->
    <div class="booking-summary bg-white px-3 pt-3 pb-1 mb-3">
        <h4 class="font-md fw-bold pb-2">Online Payment Summary</h4>
        <div class="d-flex justify-content-between align-items-center pb-2 fw-600">
            <p class="mb-0">Tracking ID</p>
            <p class="mb-0"><?= $this->tracking_id; ?></p>
        </div>
        <div class="d-flex justify-content-between align-items-center pb-2 fw-600">
            <p class="mb-0">Transaction Status</p>
            <p class="mb-0"><?= $this->pay_status; ?></p>
        </div>
        <div class="d-flex justify-content-between align-items-center pb-2 border-top pt-2">
            <p class="mb-0 font-md fw-bold">Transaction Amount</p>
            <p class="mb-0 font-md fw-bold"><i class="fas fa-rupee-sign"></i> <?= $this->pay_amount; ?></p>
        </div>
    </div>
    <!-- Booking Summary End -->
    <?php } ?>

     <!-- Order details Start -->
     <div class="booking-summary bg-white px-3 pt-3 pb-1">
        <h4 class="font-md fw-bold pb-2">Order Details</h4>
        <div class="d-flex justify-content-between align-items-center pb-2 fw-600">
            <p class="mb-0">Payment By</p>
            <p class="mb-0"><?= $this->rs_data[0]['payment_type'] ?></p>
        </div>
        <div class="d-flex justify-content-between align-items-center pb-2 fw-600">
            <p class="mb-0">Sub Total</p>
            <p class="mb-0"><i class="fas fa-rupee-sign"></i><span><?= $this->rs_data[0]['subtotal'] ?></span></p>
        </div>
        <div class="d-flex justify-content-between align-items-center pb-2 fw-600">
            <p class="mb-0">Collection Charge</p>
            <p class="mb-0"><i class="fas fa-rupee-sign"></i><span><?= $this->rs_data[0]['collection_charge'] ?></span></p>
        </div>
        <?php if ($this->rs_data[0]['discount'] > 0) { ?>
        <div class="d-flex justify-content-between align-items-center pb-2 fw-600">
            <p class="mb-0">Discount</p>
            <p class="mb-0">- <i class="fas fa-rupee-sign"></i><span><?= $this->rs_data[0]['discount'] ?></span></p>
        </div>
        <?php } ?>
        <?php if ($this->rs_data[0]['wallet_amount'] > 0) { ?>
        <div class="d-flex justify-content-between align-items-center pb-2 fw-600">
            <p class="mb-0">Wallet</p>
            <p class="mb-0">- <i class="fas fa-rupee-sign"></i><span><?= $this->rs_data[0]['wallet_amount'] ?></span></p>
        </div>
        <?php } ?>
        <div class="d-flex justify-content-between align-items-center pb-2 border-top pt-2">
            <p class="mb-0 font-md fw-bold">Total</p>
            <p class="mb-0 font-md fw-bold"><i class="fas fa-rupee-sign"></i><span><?= $this->rs_data[0]['net_order_value'] ?></span></p>
        </div>
    </div>
    <!-- Order details End -->
        
    <div class="my-5 mx-3">
            <a href="<?=SERVER_ROOT;?>/my-orders" class="btn btn-solid w-100 rounded-pill">My Orders</a>
    </div>

</main>

<!--Start Hero-->
<section class="shop-products-bhv booking-info pt40 pb60" style="display: none !important;">
    <div class="container">
        
           <div class="row mb-2">
            
            <div class="col-lg-6 ">
                <?php if (count($this->rs_lab_data) > 0) { ?>
                    <div class="row mb-3">
                        <div class="col-lg-12 mb-2">
                            <h5>Lab Address Information</h5>
                        </div>
                        <div class="col-lg-12">
                            <div class="col-lg-12 labInfo bg-white border rounded ">
                                <div class="row m-auto">
                                    <div class="col-lg-12 sppr">
                                        <img src="images/labinformationnew.svg" alt="" />
                                        <h5><?= $this->rs_lab_data[0]['lab_name'] ?></h5>
                                        <p class="mt0 mb10"><?= $this->rs_lab_data[0]['lab_address'] ?>
                                            <!-- <a href="javascript:void(0)" class="btn-main bg-btn1 btn-blue lnk text-uppercase">Get Direction <span class="circle"></span></a> -->
                                            <a href="javascript:void(0)" class="vdet text-blue prescriptionOrderView" data-id="33">Get Direction</a>
                                    </div>
                                    <div class="col-lg-4 ms-auto text-end prdiv p-0">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-lg-6">
                <div class="row mb50">
                    <div class="col-lg-12 mb-1">
                        <h5>Package Summary</h5>
                    </div>
                    <div class="col-lg-12">
                        <?php for ($i = 0; $i < count($this->rs_order_detail); $i++) { ?>

                            <div class="col-lg-12 bg-white shadow-normal mb-3">
                                <div class="col-lg-12 bg-white d-flex p-3">
                                    <div class="packname">
                                        <h4><?= $this->rs_order_detail[$i]['order_item_name'] ?> <a class="ms-2 itemsDetails" data-id="<?= $this->rs_order_detail[$i]['item_id'] ?>"><i class="fas fa-chevron-down text-black"></i></a><span>Includes <?= $this->rs_order_detail[$i]['order_item_test_count'] ?> Tests</span></h4>
                                    </div>
                                    <div class="pricdiv ms-auto">
                                        <h5><span class="float-end"><i class="fas fa-rupee-sign"></i><?= $this->rs_order_detail[$i]['price'] ?></span></h5>
                                    </div>


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
                                    $member_html = '<a class="vtest-btn text-dark d-inline-block w-100 mb-2 cartMemberRemove" data-id="' . $cartID . '" href="javascript:void(0)">' . $this->rs_order_detail[$i]['customer_members_prefix'] . ' ' . $this->rs_order_detail[$i]['customer_members_first_name'] . ' ' . $this->rs_order_detail[$i]['customer_members_last_name'] . ' | ' . $this->rs_order_detail[$i]['customer_members_relation'] . '<br/><span class=" ">' . $line1 . ', ' . $area . ',' . $city . ' - ' . $pincode . ', ' . $state . '</span> </a>';
                                    ?>
                                    <?= $member_html ?>
                                    <?php if ($this->rs_order_detail[$i]['prescription_data'] != '') { ?>
                                        <div class="vtest-btn text-dark d-inline-block w-100 mb-2" href="#">Prescription Info <a class="float-end vdet text-blue prescriptionOrderView" data-id="<?= $this->rs_order_detail[$i]['id'] ?>">View Details</a>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>

            </div>
            <div class="col-lg-6 right-cart">
                <div class="col-lg-12 mb-2" style="display:none">
                    <h5 class="d-inline-block">Booking & Payment Information</h5>
                    <span class="float-end">
                        <a class="small-btns" data-bs-toggle="modal" data-bs-target="#modalform-Reschedule-Booking"><i class="fas me-1 fa-calendar-alt"></i> Reschedule</a>
                        <a class="small-btns text-danger border-danger" href="#"><i class="fas me-1 fa-times"></i> Cancel</a>
                    </span>
                </div>
                <div class="cart-extra-sevc div-for-data" style="display:none">
                    <div class="col-lg-12 p-0">
                        <span class="d-flex fs-14 align-items-center text-dark h6 w-100">Sample Collection Date <span class="ms-auto">15 Sep, 2022</span></span>
                        <span class="d-flex fs-14 align-items-center text-dark h6 mb-0 w-100">Sample Collection Time <span class="ms-auto">06:00 am - 07:00 am</span></span>
                    </div>
                </div>
                <div class="cart-extra-sevc div-for-data">
                    <!-- <h4 class="mb30">Cart Totals</h4> -->
                    <!-- <h5 class="prc-info mb-3 border-bottom pb-3"><span class=""><i class="fas fa-rupee-sign"></i>399 <del><i class="fas fa-rupee-sign"></i>580</del></span> <span class="percnt float-end">Get 20 % OFF</span></h5> -->
                    <h6 class="fs__14 mb-2 pb-1">Order Details</h6>
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>Payment By</th>
                                <td><span class="prc me-1"><?= $this->rs_data[0]['payment_type'] ?></span></td>
                            </tr>


                            <tr>
                                <th>Sub Total</th>
                                <td><span class="prc"><i class="fas fa-rupee-sign"></i><?= $this->rs_data[0]['subtotal'] ?></span></td>
                            </tr>
                            <tr>
                                <th>Collection Charge</th>
                                <td><span class="prc"><i class="fas fa-rupee-sign"></i><?= $this->rs_data[0]['collection_charge'] ?></span></td>
                            </tr>
                            <?php if ($this->rs_data[0]['discount'] > 0) { ?>
                                <tr>
                                    <th>Discount</th>
                                    <td><span class="prc">-<i class="fas fa-rupee-sign"></i><?= $this->rs_data[0]['discount'] ?></span></td>
                                </tr>
                            <?php } ?>
                            <?php if ($this->rs_data[0]['wallet_amount'] > 0) { ?>
                                <tr>
                                    <th>Wallet</th>
                                    <td><span class="prc">-<i class="fas fa-rupee-sign"></i><?= $this->rs_data[0]['wallet_amount'] ?></span></td>
                                </tr>
                            <?php } ?>


                            <tr class="tpayable">
                                <th>Total</th>
                                <td><span class="prc"><i class="fas fa-rupee-sign"></i><?= $this->rs_data[0]['net_order_value'] ?></span></td>
                            </tr>
                        </tbody>
                    </table>
                    <a href="my-orders" class="btn-main bg-btn checkout-btn lnk w-100 mb-1">My Orders <i class="fas fa-chevron-right fa-icon fa-ani"></i><span class="circle"></span></a>


                </div>
                <div class="col-lg-12 need-help">
                    <h5>Need help with booking your test? <img src="images/call_to_order.svg" class="float-end cto"></h5>
                    <span class="subtext d-inline-block w-100">Our experts are here to help you</span>
                    <a href="tel:911246712000" class="call-icon"><i class="fas fa-phone-alt"></i> +91-124-6712000</a>
                </div>
            </div>

        </div>
    </div>
</section>

<!--Start Footer -->
<?php include 'includes/footer.php'; ?>
<!--End Footer -->