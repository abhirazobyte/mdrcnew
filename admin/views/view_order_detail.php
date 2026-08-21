<style>
@media (min-width: 1200px) {
  .media-body {
    width: 210px
  }
}
@media (min-width: 992px) {
  .media-body {
    width: 150px
  }
}
.custom-height-screen {
  overflow-y: auto;
  max-height: 1918px;
}
@media (max-width: 700px) {
  .custom-height-screen {
    overflow-y: auto;
    max-height: 600px;
  }
}
  .coupon-code-text {
    font-weight: bold;
    color: #28a745; /* Green color for the coupon code */
    font-size: 1rem;
  }
  .discount-amount {
    font-size: 1rem;
    color: #6c757d; /* Gray color for the discount amount */
  }
</style>
<!-- vendor css -->
<link href="lib/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
<link href="lib/ionicons/css/ionicons.min.css" rel="stylesheet">
<link href="lib/jqvmap/jqvmap.min.css" rel="stylesheet">
<link href="lib/morris.js/morris.css" rel="stylesheet">
<link href="lib/datatables.net-dt/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css" rel="stylesheet">
<!-- DashForge CSS -->
<link rel="stylesheet" href="assets/css/dashforge.css">
<link rel="stylesheet" href="assets/css/dashforge.dashboard.css">
<link rel="stylesheet" href="assets/css/dashforge.demo.css">
    <link rel="stylesheet" href="assets/css/dashforge.profile.css">
<!-- Skin CSS -->
<link rel="stylesheet" href="assets/css/skin.cool.css">
<!--<link rel="stylesheet" href="assets/css/skin.charcoal.css">-->
<!-- Custom CSS -->
<link rel="stylesheet" href="assets/css/custom.css">
<!--Sweet Alert CSS & JS -->
<link href="lib/alert/css/sweet-alert.css" rel="stylesheet" type="text/css" />

<link href="lib/magnific-popup/css/magnific-popup.css" rel="stylesheet" type="text/css" />

<?php include('includes/menu.php');?>
  <div class="content ht-100v pd-0 custorder_detail">
    <?php  include('includes/header.php'); ?>
      <!-- content-header -->
      <div class="content-body">
          <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
          <div class="row">
            <div class="col-lg-7 col-md-12">
                  <div class="d-sm-flex align-items-center justify-content-between mb-1">
                      <div>
                        <nav aria-label="breadcrumb">
                          <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                            <li class="breadcrumb-item"><a href="#">Order</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                              Order Detail
                            </li>
                          </ol>
                        </nav>
                        <h3 class="mg-b-0 tx-spacing--1">Order ID #<?=$this->rs_order['display_order_no']?></h3>
                      </div>
                  </div>
            </div>
            <div class="col-lg-5 text-right col-md-12">
                  
            </div>
          </div>
              <div class="order-invoice mt-1">
                <div class="row">
                  <div class="col-lg-12 col-md-12 mb-4">
                      <div class="df-example rounded p-0 ">
                          <div class="card-header ">
                            <div class="row align-items-center">
                              <div class="col-lg-12 col-md-12">
                                  <h4 class="mg-b-0">Booking Details</h4>
                              </div>
                            </div>
                          </div>

                          <div class="row mt-3 mb-3">
                            <div class="col-lg-3 col-md-6 pl-5">
                                <h6 class="py-2">City : <strong><?=$this->rs_order['city_name']?></strong></h6>
                            </div>
                             <!-- <div class="col-lg-3 col-md-6">
                                <h6 class="py-2">Visitor ID: <strong><?=$this->rs_order['city_name']?></strong></h6>
                            </div>
                             <div class="col-lg-3 col-md-6">
                                <h6 class="py-2">Visitor ID: <strong><?=$this->rs_order['city_name']?></strong></h6>
                            </div>
                             <div class="col-lg-3 col-md-6">
                                <h6 class="py-2">Visitor ID: <strong><?=$this->rs_order['city_name']?></strong></h6>
                            </div> -->

                          </div>
                      </div>
                  </div>


                  <div class="col-lg-8 col-md-12">
                    <?php for($i=0;$i<count($this->rs_detail_array);$i++){

                     $age=$this->utility->getAge($this->rs_detail_array[$i]['cust_detail']['customer_members_dob'])." Year";
                     
                      $class="mt-3";
                      if($i==0)
                      {
                        $class="";
                      }
                      ?>
                      <div class="df-example rounded p-0 <?=$class?>">
                          <div class="card-header ">
                            <div class="row align-items-center">
                              <div class="col-lg-6 col-md-12">
                                  <h5 class="mg-b-0"><?=$this->rs_detail_array[$i]['cust_detail']['customer_members_prefix']?> <?=$this->rs_detail_array[$i]['cust_detail']['customer_members_first_name']?> <?=$this->rs_detail_array[$i]['cust_detail']['customer_members_last_name']?></h5>
                                  <span class="tx-12"><?=$this->rs_detail_array[$i]['cust_detail']['customer_members_gender']?> , <?=$age?>.</span>
                              </div>
                              <div class="col-lg-3 col-md-12">
                                  <span class="tx-12">Visitor ID:</span>
                                  <?php if($this->rs_detail_array[$i]['cust_detail']['lis_visitor_id']==''){ ?>
                                  <a href="javascript:void(0)" class="update_lis_visitor_id" data-id="<?=$this->rs_detail_array[$i]['cust_detail']['id']?>"> Add Visitor ID </h5></a>
                                  <?php } else {  ?>
                                  <h5 class="mg-b-0"><?=$this->rs_detail_array[$i]['cust_detail']['lis_visitor_id']?></h5>
                                  <?php } ?>
                              </div>
                              <!-- <div class="col-lg-3 text-right col-md-12">
                               <a href="#offCanvas-new" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5 off-canvas-menu">View Report</a>
                              </div> -->
                            </div>
                          </div>
                          <div class="table-responsive df-example px-3 py-2 border-0">
                            <table class="table table-invoice mb-0">
                              <thead>
                                <tr>
                                  <th class="wd-30p  d-sm-table-cell border-0 tx-left pl-0" colspan="2">Test & Packages</th>
                                  <th class="tx-center border-0">Price</th>
                                  <th class="wd-15p tx-center border-0">Discount</th>
                                  <th class="tx-center border-0">Report Status</th>
                                  <th class="tx-right border-0">Total</th>
                                  <th class="tx-right border-0">Prescription</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php for ($j=0; $j < count($this->rs_detail_array[$i]['order_detail']) ; $j++) {
                                  $items=$this->rs_detail_array[$i]['order_detail'][$j];
                                  $department_ids=$items['item_other_data_item_department_ids'];
                                  $department_id_array=explode(',',$department_ids);
                                  $department='';
                                  for($p=0;$p<count($department_id_array);$p++)
                                  {
                                      $department.='<span class="badge badge-secondary">'.$this->item_department[$department_id_array[$p]].'</span>';
                                  }
                                 
                                  ?>
                                <tr>
                                  <td colspan="2" class=" d-sm-table-cell tx-color-02 align-middle"><span style="font-size:12px"><?=$items['order_item_name']?></span><br><?=$department?></td>
                                  <td class="tx-center align-middle">
                                    <div class="qty-inner">
                                      <?php if($items['mrp']>$items['price']) {?> <span class="mrp" style="font-size:12px"><del><i class="fas fa-rupee-sign"></i> <?=$items['mrp']?> </del></span> <?php } ?><br />
                                      <i class="fas fa-rupee-sign"></i> <?=$items['price']?>
                                    </div>
                                  </td>
                                  <td class="tx-center align-middle"><div class="qty-inner"> - <i class="fas fa-rupee-sign"></i> <?php echo $items['mrp']>$items['price']?($items['mrp']-$items['price']):0; ?></div></td>
                                  <td class="tx-center align-middle"><small class="tx-12  mg-b-0"><span class="badge badge-secondary">Pending</span></small></td>
                                  <td class="tx-right align-middle"><span class="price-in"><i class="fas fa-rupee-sign"></i> <?=$items['total']?></span><br/><!-- <span class="tx-11 text-success tx-medium">Discount Applied</span --></td>
                                  <?php
                                  $image=$this->utility->get_image_path($this->rs_detail_array[$i]['cust_detail']['prescription_data'],'prescription',"")
                                  ?>
                                  <td><a href="<?=$image['medium_image'];?>" class="image-popup"><img src="<?=$image['thumb_image'];?>" class="up_img"></a></td>
                                </tr>
                                <?php }?>
                                
                            
                              </tbody>
                            </table>
                          </div>
                      </div>
                    <?php }?>

                    <?php if($this->rs_order['order_status']!='Canceled'){?>
                      <div data-label="Order Status" class="df-example demo-forms mt-3">
                        <form method="post" name="order_status_form" id="order_status_form"  data-parsley-validate>
                        <? $this->htmlBuilder->buildTag("input", array("type"=>"hidden","value"=>$this->rs_order['id']), "order_master_id") ;?>
                        <? $this->htmlBuilder->buildTag("input", array("type"=>"hidden","value"=>$this->rs_order['customer_id']), "customer_id") ;?>
                        <div class="row">
                          <div class="col-lg-4">
                            <div class="form-group">
                              <label class="" for="example-email">Status Update </label>
                              <? $this->htmlBuilder->buildTag("select", array("class"=>"form-control","onchange"=>"smsDataGet(this.value)","selected"=>$this->rs_order['order_status'], "values"=>$this->order_status_array,"required"=>""), "order_status") ;?>
                            </div>
                            <div class="form-group">
                              <label for="inputEmail4">SMS </label>
                              <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" checked id="sms_send" name="sms_send" value="Yes">
                                <label class="custom-control-label" for="sms_send">Send sms to customer ?</label>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-8">
                            <div class="form-group">
                              <label class="" for="example-email">Message </label>
                              <textarea name="remark" id="remark" class="form-control" readonly style="height: 106px;"></textarea>
                            </div>
                          </div>
                          <div class="col-lg-12">
                            <div class="form-group">
                              <label class="" for="example-email">Remark </label>
                              <textarea name="remark_other" id="remark_other" class="form-control"></textarea>
                            </div>
                          </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-12 text-right">
                          <button type="submit" class="btn btn-primary tx-13 submit_btn order_status_submit">Save</button>
                        </div>
                      </div>
                    </form>
                    </div>
                  <?php }?>

                      <div class="df-example rounded p-0 mt-3">
                        <div class="card-header d-flex align-items-center justify-content-between">
                          <h4 class="mg-b-0">Booking Status History</h4>
                          <div class="d-flex tx-18">
                          </div>
                        </div>
                      <ul class="list-group list-group-flush tx-13">
                        <?php for ($i=0; $i < count($this->rs_status); $i++) {?>
                          <li class="list-group-item d-flex pd-sm-x-20">
                            <div class="pd-sm-l-10">
                              <?php if(!empty($this->rs_status[$i]['remark'])) {?>
                              <p class="tx-medium mg-b-0"><b>Message : </b><br><?=$this->rs_status[$i]['remark']?></p>
                              <?php }?>
                              <br>
                              <?php if(!empty($this->rs_status[$i]['remark_other'])) {?>
                              <p class="tx-medium mg-b-0"><b>Admin Remark : </b><?=$this->rs_status[$i]['remark_other']?></p>
                              <?php }?>
                              <br>
                              <?php if(!empty($this->rs_status[$i]['remark_customer'])) {?>
                              <p class="tx-medium mg-b-0"><b>Customer Remark : </b><?=$this->rs_status[$i]['remark_customer']?></p>
                              <?php }?>
                            </div>
                            <div class="mg-l-auto text-right">
                            <small class="tx-12  mg-b-0"><?=$this->utility->o_status_html2020($this->rs_status[$i]['o_status'])?></small>
                              <p class="tx-medium mg-b-0"><?=$this->rs_status[$i]['entry_date_time']?></p>
                            </div>
                          </li>
                        <?php }?>
                                       
                      </ul>
                  </div>

                  <?php if(count($this->rs_payment_data)>0){?>
                   <div class="df-example rounded p-0 mt-3">
                        <div class="card-header d-flex align-items-center justify-content-between">
                          <h4 class="mg-b-0">Payment Transaction History</h4>
                          <div class="d-flex tx-18">
                          </div>
                        </div>
                      <ul class="list-group list-group-flush tx-13">

                        <?php for ($i=0; $i < count($this->rs_payment_data); $i++) {?>
                          <li class="list-group-item d-flex pd-sm-x-20">
                            <div class="pd-sm-l-10">
                              <p class="tx-medium mg-b-0">Payment Type : <span class="badge badge-warning"><?=$this->rs_payment_data[$i]['payment_type']?></span><br/>Transaction ID :<b> <?=$this->rs_payment_data[$i]['transction_id']?></b><br/>Amount : <b><i class="fas fa-rupee-sign"></i> <?=$this->rs_payment_data[$i]['transaction_amount']?></b></p>
                            </div>
                            <div class="mg-l-auto text-right">  
                            <small class="tx-12  mg-b-0"><?=$this->utility->o_status_html2020($this->rs_payment_data[$i]['payment_status'])?></small>
                              <p class="tx-medium mg-b-0"><?=$this->rs_payment_data[$i]['payment_date']?></p>
                            </div>
                          </li>
                        <?php }?>
                                       
                      </ul>
                  </div>
                  <?php }?>

                  
                  </div>
                  <div class="col-lg-4 col-md-12 mt-lg-0 mt-3">
                    <div class="order-summary df-example px-3 py-2 rounded">
                      <h6 class="bd-b py-2">Booking Summary</h6>
                      <table class="os-tabl wd-100p">
                          <tbody>
                            <tr>
                                <td class="pb-2">Booking No :</td>
                                <td class="text-right pb-2"><?=$this->rs_order['display_order_no']?></td>
                            </tr>
                            <tr>
                                <td class="pb-2">Booking Date :</td>
                                <td class="text-right pb-2"><?=$this->rs_order['order_date']?></td>
                            </tr>

                            

                            <tr>
                                <td class="pb-2">Booking Type :</td>
                                <td class="text-right pb-2"><?=$this->rs_order['payment_type']?> </td>
                            </tr>
                              <tr>
                                <td class="pb-2">Booking Status:</td>
                                <td class="text-right pb-2"><?=$this->utility->o_status_html2020($this->rs_order['order_status'])?></td>
                            </tr>
                          </tbody>
                      </table>
                    </div>
                   <?php if($this->rs_order['home_address_id']>0) { ?>
                    <div class="deliverying df-example mt-3 px-3 py-2 rounded">
                      <h6 class="bd-b py-2">Sample Collection Address</h6>
                      <table class="os-tabl wd-100p">
                          <tbody>
                            <tr>
                                <td class="pb-2">Date :</td>
                                <td class="text-right pb-2"><?=$this->rs_order['home_collection_date']?></td>
                            </tr>
                            <tr>
                                <td class="pb-2">Time :</td>
                                <td class="text-right pb-2"><?=$this->rs_order['home_collection_slot']?></td>
                            </tr>
                            <tr>
                                <td class="pb-2">Phone :</td>
                                <td class="text-right pb-2"><?=$this->rs_home_collection_address['phone1']?></td>
                            </tr>
                              <tr>
                                <td class="pb-2" colspan="2"><b>Address:</b>
                                  <br/>
                                  <?=$this->rs_home_collection_address['line1']?>, <?=$this->rs_home_collection_address['area']?>, <?=$this->rs_home_collection_address['pincode']?>, <?=$this->rs_home_collection_address['city_name']?> , <?=$this->rs_home_collection_address['state_name']?> 
                                </td>
                            </tr>
                           
                          </tbody>
                      </table>
                    </div>
                  <?php } ?>


                  <?php if($this->rs_order['lab_id']>0) { ?>
                    <div class="deliverying df-example mt-3 px-3 py-2 rounded">
                      <h6 class="bd-b py-2">Selected Lab</h6>
                      <table class="os-tabl wd-100p">
                          <tbody>
                            <tr>
                                <td class="pb-2">Date Selected :</td>
                                <td class="text-right pb-2"><?=$this->rs_order['lab_prefer_date']?></td>
                            </tr>
                            <tr>
                                <td class="pb-2">TimeSlot :</td>
                                <td class="text-right pb-2"><?=$this->rs_order['lab_prefer_slot']?></td>
                            </tr>
                            <tr>
                                <td class="pb-2">Lab Type :</td>
                                <td class="text-right pb-2"><?=$this->rs_selected_lab['item_lab_lab_type']?></td>
                            </tr>
                            <tr>
                                <td class="pb-2">Lab Name :</td>
                                <td class="text-right pb-2"><?=$this->rs_selected_lab['lab_name']?></td>
                            </tr>
                            <tr>
                                <td class="pb-2">Center ID :</td>
                                <td class="text-right pb-2"><?=$this->rs_selected_lab['item_lab_center_id']?></td>
                            </tr>
                            <tr>
                                <td class="pb-2">panel ID :</td>
                                <td class="text-right pb-2"><?=$this->rs_selected_lab['item_lab_panel_id']?></td>
                            </tr>
                            
                              <tr>
                                <td class="pb-2" colspan="2"><b>Address:</b>
                                  <br/>
                                  <?=$this->rs_selected_lab['lab_address']?> 
                                </td>
                            </tr>
                           
                          </tbody>
                      </table>
                    </div>
                  <?php } ?>

                    <div class="sub-totle-table mt-3 df-example px-3 py-2 rounded">
                        <ul class="list-unstyled lh-7 mb-0">
                          <li class="d-flex justify-content-between bd-b py-2">
                            <span>Sub-Total</span>
                            <span><i class="fas fa-rupee-sign"></i> <?=$this->rs_order['subtotal']?></span>
                          </li>
                         
                          <!-- <li class="d-flex justify-content-between bd-b py-2">
                            <span>Discount</span><span><?=$this->rs_order['coupon_coupon_code']?></span>
                            <span>- <i class="fas fa-rupee-sign"></i> <?=$this->rs_order['discount']?></span>
                          </li> -->
                          <li class="d-flex justify-content-between bd-b py-2">
                            <span>Discount</span>
                            <div class="d-flex flex-column align-items-end">
                              <span class="coupon-code-text"><?=$this->rs_order['coupon_coupon_code']?></span>
                              <span class="discount-amount">- <i class="fas fa-rupee-sign"></i> <?=$this->rs_order['discount']?></span>
                            </div>
                          </li>
                          <li class="d-flex justify-content-between bd-b py-2">
                            <span>Promo Wallet</span>
                            <span>- <i class="fas fa-rupee-sign"></i> <?=$this->rs_order['promo_wallet_amount']?></span>
                          </li>
                          <li class="d-flex justify-content-between bd-b py-2">
                            <span>Wallet</span>
                            <span>- <i class="fas fa-rupee-sign"></i> <?=$this->rs_order['wallet_amount']?></span>
                          </li>
                          <li class="d-flex justify-content-between py-2">
                            <strong>Total</strong>
                            <strong><i class="fas fa-rupee-sign"></i> <?=$this->rs_order['net_order_value']?></strong>
                          </li>
                          <li class="d-flex justify-content-between py-2">
                            <strong>Total Paid</strong>
                            <strong><i class="fas fa-rupee-sign"></i> <?=array_sum(array_column($this->rs_payment, 'transaction_amount'))?></strong>
                          </li>
                          <li class="d-flex justify-content-between py-2">
                            <strong>Balance Due Before Test</strong>
                            <strong><i class="fas fa-rupee-sign"></i> <?=$this->rs_order['net_order_value'] - array_sum(array_column($this->rs_payment, 'transaction_amount'))?></strong>
                          </li>
                        </ul>
                      </div>
                  </div>
                </div>
              </div>
            </div>
          <!-- container -->
        </div>
      </div>
  </div>

  <!-- Ajax modal container-->
  <div class="ajax_modal_container" id="ajax_modal_container"> </div>
  <!-- content-footer -->
  </div>
  
  <script src="lib/jquery/jquery.min.js"></script>
  <script src="lib/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="lib/feather-icons/feather.min.js"></script>
  <script src="lib/perfect-scrollbar/perfect-scrollbar.min.js"></script>
  <script src="lib/jquery.flot/jquery.flot.js"></script>
  <script src="lib/jquery.flot/jquery.flot.stack.js"></script>
  <script src="lib/jquery.flot/jquery.flot.resize.js"></script>
  <script src="lib/chart.js/Chart.bundle.min.js"></script>
  <script src="lib/jqvmap/jquery.vmap.min.js"></script>
  <script src="lib/jqvmap/maps/jquery.vmap.usa.js"></script>
  <script src="lib/parsleyjs/parsley.min.js"></script>
  <script src="lib/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="lib/datatables.net-dt/js/dataTables.dataTables.min.js"></script>
  <script src="lib/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
  <script src="lib/datatables.net-responsive-dt/js/responsive.dataTables.min.js"></script>
  <script src="assets/js/dashforge.js"></script>
  <script src="assets/js/dashforge.aside.js"></script>
  <script src="assets/js/dashforge.sampledata.js"></script>
  <!-- other include -->
  <script src="lib/alert/js/sweet-alert.min.js"></script>
  <script src="lib/alert/js/jquery.sweet-alert.init.js"></script>
  <script src="lib/magnific-popup/js/jquery.magnific-popup.js"></script>
  <script src="lib/validate/js/jquery.validate.min.js"></script>
  <!-- Custom -->
  <script src="scripts/js/grocery.js"></script>
  <script src="scripts/js/admin.js"></script>
  <script src="scripts/js/order.js"></script>
  <script src="lib/raphael/raphael.min.js"></script>
  <script src="lib/morris.js/morris.min.js"></script>
  <script src="lib/jqueryui/jquery-ui.min.js"></script>
