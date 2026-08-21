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
<link href="css/custom.css?v=1.5" rel="stylesheet">
<!--Start Header -->
<?php include 'includes/header.php'; ?>
<!--End Header -->
<section class="hero-creative-agenc1 banner-twostyle pt10 pb10" data-background="images/radiology-bg.png">
   <div class="text-block">
      <div class="container">
         <div class="row align-items-center">
            <div class="col-lg-3">
               <h2 class="wow fadeInUp h3 f-bold text-white" data-wow-delay=".2s">Our Accreditations</h2>
            </div>
            <div class="col-lg-9">
               <?php if (count($this->rs_certi_data) > 0) { ?>
                  <ul class="w-100 mt15 mb15 labsimg">
                     <?php for ($i = 0; $i < count($this->rs_certi_data); $i++) {
                        $folder = 'item_certificate';
                        $item_certificate_img = $this->utility->get_image_path($this->rs_certi_data[$i]['image'], $folder, "large");
                     ?>
                        <li class="text-center pe-3">
                           <img src="<?= $item_certificate_img ?>" alt="">
                           <span><?= $this->rs_certi_data[$i]['name'] ?></span>
                        </li>
                     <?php } ?>
                  </ul>
               <?php } ?>
            </div>
         </div>
      </div>
   </div>
</section>
<!--Start Hero-->
<section class="shop-products-bhv package-details  pt60 pb60 bg-white">
   <div class="container">
      <div class="row">
         <div class="col-lg-8">
            <div class="row">
               <div class="col-lg-12">
                  <h1 class="fs-2"><?= $this->rs_data['name'] ?> in <?= $this->city_name ?></h1>
                  <p class="subhead"><span>Includes: <strong><?= $this->rs_data['test_count'] ?> Parameters</strong></span></p>
                  <?php if (count($this->rs_package_data) > 0) {
                     $pName = array();
                     for ($i = 0; $i < count($this->rs_package_data); $i++) {
                        $pName[] = $this->rs_package_data[$i]['item_description_item_name'];
                     }
                  ?>
                     <p class="mt20 mb40" style="display:none"><?= implode(', ', $pName) ?></p>
                  <?php } ?>
                  <?php if (count($this->rs_key_fetures_data) > 0) { ?>
                     <div class="col-lg-12 item-key-features mb-2 mt-4">
                        <div class="row">
                           <?php for ($i = 0; $i < count($this->rs_key_fetures_data); $i++) {
                              $folder = 'item_key_fetures';
                              $item_key_fetures_img = $this->utility->get_image_path($this->rs_key_fetures_data[$i]['image'], $folder, "large");
                           ?>
                              <div class="col-lg-4 col-sm-12 wow fadeIn item-key-features-item" data-wow-delay="0.3s">
                                 <div class="industry-workfor hoshd">
                                    <img src="<?= $item_key_fetures_img ?>" alt="img">
                                    <div class="item-key-features-item-desc">
                                       <h6><?= $this->rs_key_fetures_data[$i]['name']; ?></h6>
                                       <p><?= $this->rs_key_fetures_data[$i]['subtext']; ?></p>
                                    </div>
                                 </div>
                              </div>
                           <?php } ?>
                        </div>
                     </div>
                  <?php } ?>
                  
               </div>
            </div>
            <div class="row mb10">
               <div class="col-lg-12">
                  <hr />
               </div>
            </div>
            <div class="row mt10 ">
               <div class="col-lg-12">
                  <div class="accordion" id="package-details-accordion">
                     <?php if ($this->rs_data['item_other_data_description'] != '') { ?>
                        <h2 class="mb-2 mt-4 fs-5">Description</h2>
                        <p class="text-202024 font-weight-normal tx-14"><?= $this->rs_data['item_other_data_description'] ?>
                        <p>
                        <?php } ?>
                        <?php if ($this->rs_data['item_other_data_item_department_ids'] == 1) {
                           $test_parameter_heading = 'Test Remark';
                        } else {
                           $test_parameter_heading = 'Test Parameters';
                        } ?>
                        <h3 class="mb-2 mt-4 fs-5"> <?= $test_parameter_heading; ?></h3>
                        <?php if ($this->rs_data['item_other_data_item_type_id'] == 1) { ?>
                           <?php for ($i = 0; $i < count($this->rs_package_data); $i++) { ?>
                              <div class="accordion-item">
                                 <h2 class="accordion-header" id="package-details-<?= $i ?>">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-detail-<?= $i ?>" aria-expanded="false" aria-controls="collapseOne">
                                       <?= $this->rs_package_data[$i]['item_description_item_name'] ?>
                                    </button>
                                 </h2>
                                 <div id="collapse-detail-<?= $i ?>" class="accordion-collapse collapse" aria-labelledby="heading-detail-<?= $i ?>" data-bs-parent="#package-details-accordion" style="">
                                    <div class="accordion-body">
                                       <div class="data-reqs">
                                          <?php if ($this->rs_package_data[$i]['item_description_sample_remark'] != '') { ?>
                                             <p> <strong>Sample Remark</strong> : <?= $this->rs_package_data[$i]['item_description_sample_remark'] ?></p>
                                          <?php } ?>
                                          <?php if ($this->rs_package_data[$i]['item_description_sample_type_name'] != '') { ?>
                                             <p> <strong>Sample Type</strong> : <?= $this->rs_package_data[$i]['item_description_sample_type_name'] ?></p>
                                          <?php } ?>
                                          <?php if ($this->rs_package_data[$i]['item_description_sample_remark1'] != '') { ?>
                                             <p> <strong>Sample Remark1</strong> : <?= $this->rs_package_data[$i]['item_description_sample_remark1'] ?></p>
                                          <?php } ?>
                                          <?php if ($this->rs_package_data[$i]['item_description_test_parameters'] != '') { ?>
                                             <div> <strong>Test Parameters</strong> : <?= $this->rs_package_data[$i]['item_description_test_parameters'] ?></div>
                                          <?php } ?>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           <?php } ?>
                        <?php } else { ?>
                           <div class="accordion-item">
                              <h2 class="accordion-header" id="package-details-1">
                                 <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-detail-1" aria-expanded="false" aria-controls="collapseOne">
                                    <?= $this->rs_data['item_description_item_name'] ?>
                                 </button>
                              </h2>
                              <div id="collapse-detail-1" class="accordion-collapse collapse" aria-labelledby="heading-detail-1" data-bs-parent="#package-details-accordion" style="">
                                 <div class="accordion-body">
                                    <div class="data-reqs">
                                       <?php if ($this->rs_data['item_description_sample_remark'] != '') { ?>
                                          <p> <strong>Sample Remark</strong> : <?= $this->rs_data['item_description_sample_remark'] ?></p>
                                       <?php } ?>
                                       <?php if ($this->rs_data['item_description_sample_type_name'] != '') { ?>
                                          <p> <strong>Sample Type</strong> : <?= $this->rs_data['item_description_sample_type_name'] ?></p>
                                       <?php } ?>
                                       <?php if ($this->rs_data['item_description_sample_remark1'] != '') { ?>
                                          <p> <strong>Sample Remark1</strong> : <?= $this->rs_data['item_description_sample_remark1'] ?></p>
                                       <?php } ?>
                                       <?php if ($this->rs_data['item_description_test_parameters'] != '') { ?>
                                          <div> <strong>Test Parameters</strong> : <?= $this->rs_data['item_description_test_parameters'] ?></div>
                                       <?php } ?>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        <?php } ?>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-4 right-cart">
            <div class="cart-extra-sevc div-for-data-removed">
               <div class="cart-extra-sevc div-for-data border-0 ps-0">
                  <div class="col-lg-12 prdiv p-0">
                     <?php
                     $priceDetail = $this->rs_data['item_price_price'];
                     $mrpDetail = $this->rs_data['item_price_mrp'];
                     $sch_price = $this->rs_data['item_price_sch_price'];
                     $sch_start_date = $this->rs_data['item_price_sch_start_date'];
                     $sch_end_date = $this->rs_data['item_price_sch_end_date'];
                     if ($sch_price > 0 && $sch_start_date != '' && $sch_end_date != '') {
                        $today_date = date('d-m-Y');
                        $todaySlot = strtotime($today_date);
                        $startSlot = strtotime($sch_start_date);
                        $endSlot = strtotime($sch_end_date);
                        if ($todaySlot >= $startSlot && $todaySlot <= $endSlot) {
                           $priceDetail = $sch_price;
                        }
                     }
                     $price_html = $this->utility->detailpackagePrice($this->rs_data['id'], $priceDetail, $mrpDetail);
                     echo $price_html;
                     ?>
                  </div>
               </div>
               <div class="pr_<?= $this->rs_data['id'] ?>">
                  <?php if (in_array($this->rs_data['id'], $_SESSION['cartitemIds'])) { ?>
                     <a href="cart" class="btn-main bg-btn checkout-btn lnk w-100 mb-1 alreadyInCart">Schedule and Book <i class="fas fa-chevron-right fa-icon fa-ani"></i><span class="circle"></span></a>
                  <?php } else { ?>
                     <button type="button" class="btn-main bg-btn checkout-btn lnk w-100 mb-1 addToClass" onclick="addtocart('<?= $this->rs_data['id'] ?>','<?= $this->rs_data['item_price_id'] ?>')">Add to Cart <i class="fas fa-chevron-right fa-icon fa-ani"></i><span class="circle"></span></button>
                  <?php } ?>
               </div>
               <span class="d-block fs-14">*inclusive of all the taxes, fees and subject to availability</span>
            </div>
            <div class="col-lg-12 need-help">
               <h4 class="fs-5">Need help with booking your test? <img src="images/call_to_order.svg" class="float-end cto"></h>
                  <span class="subtext d-inline-block w-100">Our experts are here to help you</span>
                  <a href="tel:911246712000" class="call-icon"><i class="fas fa-phone-alt"></i> +91-124-6712000</a>
                  <span class="subtext d-inline-block w-100 mt-2">Whatsapp Chat with MDRC Expert</span>
                  <a href="https://wa.me/918586988847?text=Hello :) Thank you for contacting Modern Diagnostic and Research Centre. How can we help you please?" target="_blank" class="whatsapp-icon"><i class="fab fa-whatsapp"></i> +91-8586988847</a>
            </div>
            <div class="cart-extra-sevc div-for-data-removed mt-4">
					<h6 class="fs__14 mb-2 pb-1">Add Our Other Tests</h6>
					<span class="d-block fs-14 mb20">*inclusive of all the taxes, fees and subject to availability</span>
					<hr />
					<div class="row text-center cart-quick-links">
						<div class="col-lg-6"><b><a href="pathology/lab-blood-test-near/<?=$_SESSION['citySlug'];?>" class="text-202024">+ Pathology tests</a></b></div>
						<div class="col-lg-6"><b><a href="radiology/imaging-lab-tests-near/<?=$_SESSION['citySlug'];?>" class="text-202024">+ Radiology tests</a></b></div>
					</div>
				</div>
            <?php if (count($this->rs_faq_data)>0) { ?>
            <div class="col-lg-12 test-detail-faq bg-white mt20 shop-products-bhv cart-extra-sevc ">
               <h4 class="fs-5 mb10">Frequently Asked Questions about <?= $this->rs_data['name'] ?></h4>
               <div class="accordion" id="accordionExample">
                  <?php foreach ($this->rs_faq_data as $faq) { 
                     
                     $default_string = array("{CITY}");
							$new_string = array($_SESSION['cityName']);
							$question=str_replace($default_string, $new_string,$faq['question']);
							$answer=str_replace($default_string, $new_string,$faq['answer']);

                     ?>
                     <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-<?= $faq['id'] ?>">
                           <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?= $faq['id'] ?>" aria-expanded="false" aria-controls="collapseOne"><?= $question?></button>
                        </h2>
                        <div id="collapse-<?= $faq['id'] ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?= $faq['id'] ?>" data-bs-parent="#accordionExample" style="">
                           <div class="accordion-body">
                              <div class="data-reqs">
                                 <p><?= $answer?></p>
                              </div>
                           </div>
                        </div>
                     </div>
                  <?php }; ?>
               </div>
            </div>
            <?php } ?>

            <?php if (count($this->rs_banner) > 0) { ?>
               <div class="col-lg-12 mt-2">
                  <div class="bannerSlide owl-carousel" style="padding:0px; margin:0px">
                     <?php for ($i = 0; $i < count($this->rs_banner); $i++) {
                        $folder = 'main_banner_images';
                        $image = $this->utility->get_image_path($this->rs_banner[$i]['banner_image'], $folder, "large");
                        $url = 'javascript:void(0)';
                        if ($this->rs_banner[$i]['banner_link'] != '') {
                           $url = $this->rs_banner[$i]['banner_link'];
                        }
                     ?>
                        <div class="items">
                           <div class="col-12 p-0">
                              <a href="<?= $url ?>"><img src="<?= $image ?>" alt="banner" /></a>
                           </div>
                        </div>
                     <?php } ?>
                  </div>
               </div>
            <?php } ?>
         </div>
      </div>
   </div>
</section>
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
