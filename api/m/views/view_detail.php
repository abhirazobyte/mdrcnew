<?php include('includes/header.php'); ?>
<!-- Main Start -->
<main class="health-package-details-page page-common">
   <!-- Packgae Banner Start -->
   <div class="package-banner pb-3 bg-white">
      <img src="assets/images/mdrc/health-package/banner1.png" alt="" class="img-fluid w-100 object-cover">
   </div>
   <!-- Package Banner End -->
   <!-- Health Package Details Start -->
   <div class="offcanvas-body small">
      <div class="bg-white main-wrap">
         <h3 class="fw-bold font-lg"><?=$this->rs_data['name']?> in <?=$this->city_name?></h3>
         <p class="btn-outline-label font-base">Includes: <span><?=$this->rs_data['test_count']?> tests</span></p>
      </div>
      <?php if(count($this->rs_key_fetures_data)>0) { ?>
      <div class="bg-white main-wrap pb-3 mb-3">
         <div class="package-benifit ">
            <?php for($i=0;$i<count($this->rs_key_fetures_data);$i++) {
               $folder='item_key_fetures';
               $item_key_fetures_img=$this->utility->get_image_path($this->rs_key_fetures_data[$i]['image'],$folder,"large");
            ?>
            <div class="benifits-box">
               <img src="<?=$item_key_fetures_img?>" alt="" style="width: 24px;">
               <p class="mb-0"><?=$this->rs_key_fetures_data[$i]['name'];?></p>
            </div>
            <?php } ?>
         </div>
      </div>
      <?php } ?>
      <div class="package-dec bg-white main-wrap pb-3 pt-3 mb-3">
         <?php if($this->rs_data['item_other_data_description']!=''){?> 
         <h4 class="font-md fw-bold">Description</h4>
         <p class="font-sm mb-1"><?=$this->rs_data['item_other_data_description']?></p>
         <?php }?>
         <!-- <a href="" class="font-sm theme-color">View More</a> -->
      </div>
      <!-- Accordion Start -->
      <div class="packaee-perameters main-wrap pt-3 bg-white mb-3">
         <?php if($this->rs_data['item_other_data_item_department_ids']==1) { $test_parameter_heading='Test Remark';}else { $test_parameter_heading='Test Parameters';} ?>
         <h4 class="font-md fw-bold mb-2"><?=$test_parameter_heading;?></h4>
         
         <div class="accordion" id="accordionExample">
         <?php if($this->rs_data['item_other_data_item_type_id']==1){?>
            <?php for($i=0;$i<count($this->rs_package_data);$i++){ ?>
            <!-- Accordion item -->
            <div class="accordion-item">
               <h2 class="accordion-header fw-bold" id="package-details-<?=$i?>">
                  <button class="accordion-button title-color collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-detail-<?=$i?>" aria-expanded="false" aria-controls="collapseTwo">
                     <?=$this->rs_package_data[$i]['item_description_item_name']?>
                  </button>
               </h2>
               <div id="collapse-detail-<?=$i?>" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                     <?php if($this->rs_package_data[$i]['item_description_sample_remark']!=''){?>
                     <p>Sample Remark</p>
                     <?=$this->rs_package_data[$i]['item_description_sample_remark']?>
                     <?php } ?>

                     <?php if($this->rs_package_data[$i]['item_description_sample_type_name']!=''){?>
                     <p>Sample Type</p>
                     <?=$this->rs_package_data[$i]['item_description_sample_type_name']?>
                     <?php } ?>

                     <?php if($this->rs_package_data[$i]['item_description_sample_remark1']!=''){?>
                     <p>Sample Remark1</p>
                     <?=$this->rs_package_data[$i]['item_description_sample_remark1']?>
                     <?php } ?>

                     <?php if($this->rs_package_data[$i]['item_description_test_parameters']!=''){?>
                     <p>Test Parameters</p>
                     <?=$this->rs_package_data[$i]['item_description_test_parameters']?>
                     <?php } ?>

                  </div>
               </div>
            </div>
            <!-- Accordion item end -->
            <?php } ?>
            <?php }else{?>
            
            <!-- Accordion item -->
            <div class="accordion-item">
               <h2 class="accordion-header fw-bold" id="package-details-one">
                  <button class="accordion-button title-color collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-detail-one" aria-expanded="false" aria-controls="collapseTwo">
                     <?=$this->rs_data['item_description_item_name']?>
                  </button>
               </h2>
               <div id="collapse-detail-one" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                     <?php if($this->rs_data['item_description_sample_remark']!=''){?>
                     <p>Sample Remark</p>
                     <?=$this->rs_data['item_description_sample_remark']?>
                     <?php } ?>

                     <?php if($this->rs_data['item_description_sample_type_name']!=''){?>
                     <p>Sample Type</p>
                     <?=$this->rs_data['item_description_sample_type_name']?>
                     <?php } ?>

                     <?php if($this->rs_data['item_description_sample_remark1']!=''){?>
                     <p>Sample Remark1</p>
                     <?=$this->rs_data['item_description_sample_remark1']?>
                     <?php } ?>

                     <?php if($this->rs_data['item_description_test_parameters']!=''){?>
                     <p>Test Parameters</p>
                     <?=$this->rs_data['item_description_test_parameters']?>
                     <?php } ?>

                  </div>
               </div>
            </div>
            <!-- Accordion item end -->

            <?php }?>

         </div>
      </div>
      <!-- Accordion End -->
      <div class="text-section main-wrap bg-white pb-3 pt-3">
         <h3 class="fw-bold mb-3 font-md">Need help with booking your test?</h3>
         <a href="tel:911246712000" class="d-flex align-items-center shadow1 px-3 py-2 rounded-3 mb-3">
            <img src="assets/images/mdrc/health-package/phone-cell.svg" alt="">
            <p class="mb-0 theme-color font-sm ms-3">Our Experts are Here to Help You</p>
         </a>
         <a href="https://wa.me/918586988847?text=Hello :) Thank you for contacting Modern Diagnostic and Research Centre. How can we help you please?" class="d-flex align-items-center th-bg-green px-3 py-2 rounded-3">
            <img src="assets/images/mdrc/health-package/whatsapp.svg" alt="">
            <p class="mb-0 theme-color font-sm ms-3 text-white">Whatsapp Chat with MDRC Expert</p>
         </a>
      </div>
   </div>
   <!-- Health Package  Details Start End -->
</main>
<!-- Main End -->


<?php
$priceDetail=$this->rs_data['item_price_price'];
$mrpDetail=$this->rs_data['item_price_mrp'];
$sch_price=$this->rs_data['item_price_sch_price'];
$sch_start_date=$this->rs_data['item_price_sch_start_date'];
$sch_end_date=$this->rs_data['item_price_sch_end_date'];
if($sch_price>0 && $sch_start_date!='' && $sch_end_date!=''){
   $today_date=date('d-m-Y');
   $todaySlot=strtotime($today_date);
   $startSlot=strtotime($sch_start_date);
   $endSlot=strtotime($sch_end_date);
   if($todaySlot>=$startSlot && $todaySlot<=$endSlot)
   {
   $priceDetail=$sch_price;
   }
}
$price_html=$this->utility->mpackagePrice($this->rs_data['id'],$priceDetail,$mrpDetail);

if (in_array($this->rs_data['id'], $_SESSION['cartitemIds']))
{
   $cartbtn='<a class="add_to_cart btncart btn th-btn-green text-white btn-md font-sm d-flex align-items-center"> <img src="assets/images/mdrc/icons/shopping-cart-white.svg" alt="" class="me-1">Added</a>';
} else {
   $cartbtn='<a href="javascript:void(0)" data-item_price_id="'.$this->rs_data['item_price_id'].'" data-item_id="'.$this->rs_data['id'].'" class="add_to_cart btncart btn th-btn-solid-sm text-white btn-md font-sm d-flex align-items-center"> <img src="assets/images/mdrc/icons/shopping-cart-white.svg" alt="" class="me-1">Add</a>';
}
?>

<!-- Footer Price-bottom Start -->
<div class="price-bottom MDRC-TEST">
   <div class="d-flex align-items-center justify-content-between py-3 price-list w-100">
      <div class="d-flex align-items-center">
         <?=$price_html;?>
      </div>
      <?=$cartbtn;?>
   </div>
</div>
<!-- Footer Price-bottom End -->

<?php include('includes/footer.php'); ?>