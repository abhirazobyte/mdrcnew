<?php include('includes/header.php'); ?>

<!-- Main Start -->
<main class="index-page  bg-white page-common">
  <!-- Search Box Start -->
 
    <div class="search-box search-box2 mx-3 pt-3 mt-3">
      <form name="searchMobileForm" id="searchMobileForm" method="post" action="">
      <input class="form-control required searchMobileKeyword searchInput" type="text" id="searchMobileInput" autocomplete="off" placeholder="Search for a Test, Nearest Centres" />
      <button class="searSubmit" type="submit">
        <i class="iconly-Search icli search text-danger"></i>
      </button>
      </form>
    </div>
  <!-- Search Box End -->

  <?php if(count($this->rs_banner)>0){?>
  <!-- Banner Section Start -->
  <section class="banner-section ratio2_1 bg-white pb-1 pt-0">
    <div class="h-banner-slider">
      <?php 
      for($i=0;$i<count($this->rs_banner);$i++) {
        $folder='main_banner_images';
        $image=$this->utility->get_image_path($this->rs_banner[$i]['mobile_image'],$folder,"large");
        $url='javascript:void(0)';
        if($this->rs_banner[$i]['banner_link']!='')
        {
          $url=$this->rs_banner[$i]['banner_link'];
        }
        if($this->rs_banner[$i]['mobile_image']!=''){
      ?>
      <div>
        <a href="<?=$url?>" class="banner-box rounded-0">
          <img src="<?=$image?>" alt="banner" class="bg-img" />
        </a>
      </div>
      <?php } } ?>
    </div>
  </section>
  <!-- Banner Section End -->
  <?php } ?>
  <?php if($_SESSION['cityID']==11) { ?>
  <section class="pt-0 pb-0">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 text-center">
				<marquee direction="left" style="color : #1160a5;font-style: italic;padding:5px;"> Home collection will be done for disabled and aged patients. </marquee>
			</div>
		</div>
	</div>
</section>
<?php } ?>
  <!-- Book Box Start -->
  <section class="bookbox pt-0 bg-white pb-3 main-wrap">
    <div class="row g-3 align-items-stretch">
      <div class="col-6">
        <a href="<?=M_SERVER_ROOT;?>/pathology/lab-blood-test-near/<?=$_SESSION['citySlug'];?>" class="d-flex align-items-center justify-content-center bg-img-blue p-3" style="background-image: url('assets/images/mdrc/home/bg-blue.png');">
          <div>
            <p class="text-white mb-0 text-center">Book your Test</p>
          </div>
        </a>
      </div>
      <div class="col-6">
        <a href="<?=M_SERVER_ROOT;?>/download-reports" class="d-flex align-items-center justify-content-center bg-img-blue p-3" style="background-image: url('assets/images/mdrc/home/bg-blue.png');">
          <div>
            <p class="text-white mb-0 text-center">Download Report</p>
          </div>
        </a>
      </div>
    </div>
  </section>
  <!-- Book Box End -->

  <?php if(count($this->rs_item_diseases)>0){?>
  <!-- Diseases Start -->
  <section class="pt-0 px-3 diseases-section pb-3">
    <h2 class="font-lg text-center mb-3">Tests by Condition</h2>
    <div class="desease-slider">
      <?php for($i=0;$i<count($this->rs_item_diseases);$i++){
        $name=$this->rs_item_diseases[$i]['name'];
        $image=$this->rs_item_diseases[$i]['image'];
        $slug=$this->rs_item_diseases[$i]['slug'];
        $folder='item_diseases';
        $item_diseases_img=$this->utility->get_image_path($image,$folder,"large");
        $url=M_SERVER_ROOT.'/diseases/'.$_SESSION['citySlug'].'/'.$slug.'';
      ?>
      <a href="<?=$url?>" class="desease-item">
        <div class="desease-img">
          <figure class="item-img">
            <img src="<?=$item_diseases_img?>" alt="<?=$name?>" class="">
          </figure>
        </div>
        <span><?=$name?></span>
      </a> 
    <?php }?>    
    </div>
  </section>
  <!-- Diseases End -->
  <?php }?>

  <!-- Accreditation Section Start -->
  <section class="accreditation-sec pt-0 pb-3 d-none">
    <div class="accreditation p-3">
      <h2 class="mb-3 font-lg text-center">Accreditation</h2>
      <div class="row g-3">
        <div class="col-4">
          <a href="javascript:void(0)">
            <div class="mb-1">
              <img src="assets/images/mdrc/home/nabl.png" alt="" class="img-fluid d-block mx-auto object-cover">
            </div>
            <p class="text-center title-color mb-0">NABL Lab</p>
          </a>
        </div>
        <div class="col-4">
          <a href="javascript:void(0)">
            <div class="mb-1">
              <img src="assets/images/mdrc/home/nabh.png" alt="" class="img-fluid d-block mx-auto object-cover">
            </div>
            <p class="text-center title-color mb-0">NABH Center</p>
          </a>
        </div>
        <div class="col-4">
          <a href="javascript:void(0)">
            <div class="mb-1">
              <img src="assets/images/mdrc/home/cap.png" alt="" class="img-fluid d-block mx-auto object-cover">
            </div>
            <p class="text-center title-color mb-0">
            ILAC MRA 
            </p>
          </a>
        </div>
      </div>
  </section>
  <!-- Accreditation Section End -->

  <!-- Accreditation Section 2 Start -->
  <section class="accreditation2 pt-0 pb-3 main-wrap bg-white">
    <div class="row g-3">
      <div class="col-4">
        <a href="<?=M_SERVER_ROOT;?>/pregnancy-care">
          <div class="accreditation2box mb-2">
            <img src="assets/images/mdrc/home/pregnancy-care.png" alt="" class="img-fluid d-block mx-auto">
          </div>
          <p class="text-center title-color mb-0">Pregnancy Care</p>
        </a>
      </div>
      <div class="col-4">
        <a href="<?=M_SERVER_ROOT;?>/therapeutic-drug-monitoring">
          <div class="accreditation2box mb-2">
            <img src="assets/images/mdrc/home/tdm.png" alt="" class="img-fluid d-block mx-auto">
          </div>
          <p class="text-center title-color mb-0">TDM</p>
        </a>
      </div>
      <div class="col-4">
        <a href="<?=M_SERVER_ROOT;?>/oncology">
          <div class="accreditation2box mb-2">
            <img src="assets/images/mdrc/home/oncology.png" alt="" class="img-fluid d-block mx-auto">
          </div>
          <p class="text-center title-color mb-0">Oncology</p>
        </a>
      </div>
  </section>
  <!-- Accreditation Section 2 End -->

  <!-- Accreditation Section 3 Start -->
  <section class="accreditation3 pt-0 pb-3 bg-white main-wrap">
    <a href="mdrc-test-booking-enquiry" class="d-flex align-items-center justify-content-between rounded-10 bg-theme p-3">
      <p class="text-white font-md mb-0 w-75">Upload Prescription & Chat With Us</p>
      <div class="wd-40 ht-40">
        <img src="assets/images/mdrc/home/customer-service.png" alt="" class="img-fluid">
      </div>
    </a>
  </section>
  <!-- Accreditation Section 3 End -->

  <?php if(count($this->rs_item_home_category)>0){ ?>
  <!-- Our Health Packages Section Start -->
  <section class="banner-section health-pac1-section pt-0 main-wrap pb-3 bg-white">
    <h2 class="mb-3 font-lg">Our Health Packages</h2>
    <div class="row g-0 health-pac1-slider">
      <?php
      for($i=0;$i<count($this->rs_item_home_category);$i++){
        $image=$this->rs_item_home_category[$i]['image'];
        $folder='item_category';
        $img=$this->utility->get_image_path($image,$folder,"large");
        $caturl=M_SERVER_ROOT.'/category/'.$_SESSION['citySlug'].'/'.$this->rs_item_home_category[$i]['slug'];
      ?>
      <div class="col-6">
        <a href="<?=$caturl;?>" class="d-flex align-items-center justify-content-between p-3 bg-blue-gradient rounded-10">
          <div class="w-25">
            <img src="<?=$img;?>" alt="" class="img-fluid d-block mx-auto object-cover w-100">
          </div>
          <div class="w-75 ms-3">
            <p class="text-white mb-0 slider-h-fix"><?=$this->rs_item_home_category[$i]['name']?></p>
          </div>
        </a>
      </div>
      <?php } ?>
    </div>
  </section>
  <!-- Our Health Packages Section End -->
  <?php } ?>

  <?php if(count($this->homeItems)>0){ ?>
  <!-- Our Our Maternal Packages Start -->
  <section class="banner-section materanl-package banner-section ratio2_1 ps-3 bg-theme py-3 mb-3">
    <div class="d-flex align-items-center mb-3 justify-content-between pe-3">
      <h2 class="font-lg text-white">Popular Tests</h2>
      <a href="<?=M_SERVER_ROOT.'/premium-health-checkup/'.$_SESSION['citySlug']?>" class="text-white d-flex align-items-center">View All
        <img src="assets/images/mdrc/icons/double-chevron.svg" alt="" class="ms-2">
      </a>
    </div>
    <div class="maternal-package-slider">
      <?php 
      foreach($this->homeItems as $item) { 
        $id=$item['id'];
        $item_price_id=$item['item_price_id'];
        $slug=$item['slug'];
        $name=$item['name'];
        $test_count=$item['test_count'];
        $image=$item['image'];
        $folder=$item['folder'];
        $price=$item['item_price_price'];
        $mrp=$item['item_price_mrp'];
        $url='tests/'.$item['slug'].'/'.$_SESSION['citySlug'];
        $sch_price=$item['item_price_sch_price'];
        $sch_start_date=$item['item_price_sch_start_date'];
        $sch_end_date=$item['item_price_sch_end_date'];
        if($sch_price>0 && $sch_start_date!='' && $sch_end_date!='')
        {
          $today_date=date('d-m-Y');
          $todaySlot=strtotime($today_date);
          $startSlot=strtotime($sch_start_date);
          $endSlot=strtotime($sch_end_date);
          if($todaySlot>=$startSlot && $todaySlot<=$endSlot)
          {
            $price=$sch_price;
          }
        }
        $price_html=$this->utility->mpackagePrice($id,$price,$mrp);
        $description1=strip_tags($item['item_other_data_description']);
        $description_li='';
        if($description1!='')
        {
          $description=$this->utility->string_truncate($description1,100);
          $description_li='<li><span>'.$description.'</span></li>';
        }
        $test_parameters_html=strip_tags($item['item_description_test_parameters']);
        if($test_parameters_html!='')
        {
          $test_parameters_html='<li><span>'.$this->utility->string_truncate($test_parameters_html,100).'</span></li>';
        }

        if (in_array($id, $_SESSION['cartitemIds']))
        {
          $Book_Now='<a href="'.$url.'" class="btn-main bg-btn1 btn-green lnk wow fadeInUp text-uppercase book-now">Added <span class="circle"></span></a>';
          $cartbtn='<a class="add_to_cart btncart btn th-btn-green text-white btn-md font-sm d-flex align-items-center"> <img src="assets/images/mdrc/icons/shopping-cart-white.svg" alt="" class="me-1">Added</a>
          ';
        }
        else
        {
          $Book_Now='<a href="'.$url.'" class="btn-main bg-btn1 btn-blue lnk wow fadeInUp text-uppercase book-now">Book Now <span class="circle"></span></a>';
          $cartbtn='<a href="javascript:void(0)" data-item_price_id="'.$item_price_id.'" data-item_id="'.$id.'" class="add_to_cart btncart btn th-btn-solid-sm text-white btn-md font-sm d-flex align-items-center"> <img src="assets/images/mdrc/icons/shopping-cart-white.svg" alt="" class="me-1">Add</a>';
        }
      ?>
      <div class="banner-box MDRC-TEST">
          <div class="border p-3 bg-white rounded">
            <a href="<?=$url;?>" class="filter font-md theme-color fw-bold mb-2"><?=$name?></a>
            <ul class="packageul">
              <li><span>Total no. of Tests : <?=$test_count?></span></li>
              <?=$description_li?>
              <?=$test_parameters_html;?>
            </ul>
            <div class="d-flex align-items-center justify-content-between">
              <?=$price_html?>
              <div>
                <?=$cartbtn;?>
              </div>
            </div>
          </div>
      </div>
      <?php } ?>
    </div>
  </section>
  <!-- Our Our Maternal Packages ENd -->
  <?php } ?>

  <!-- MDRC HealthCare Section Start -->
  <section class="mdrc-healthcare pt-0 main-wrap pb-3 bg-white">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2 class="font-lg">MDRC HealthCare</h2>
      <a href="#" class="theme-color font-md fw-bolder">#HealthyIndia</a>
    </div>
    <div class="row g-3 align-items-stretch">
      <div class="col-6">
        <a href="javascript:void(0)" class="mdrc-healthcare-box">
          <div class="w-25">
            <img src="assets/images/mdrc/home/svg/healthcare-icon1.svg" alt="" class="img-fluid d-block mx-auto object-cover w-100">
          </div>
          <div class="w-75 ms-3">
            <p class="mb-0">Features - 20 Labs <br> Across 8 State</p>
          </div>
        </a>
      </div>
      <div class="col-6">
        <a href="javascript:void(0)" class="mdrc-healthcare-box">
          <div class="w-25">
            <img src="assets/images/mdrc/home/svg/healthcare-icon2.svg" alt="" class="img-fluid d-block mx-auto object-cover w-100">
          </div>
          <div class="w-75 ms-3">
            <p class="mb-0">1800+ Touch <br> Points Across India</p>
          </div>
        </a>
      </div>
      <div class="col-6">
        <a href="javascript:void(0)" class="mdrc-healthcare-box">
          <div class="w-25">
            <img src="assets/images/mdrc/home/svg/healthcare-icon3.svg" alt="" class="img-fluid d-block mx-auto object-cover w-100">
          </div>
          <div class="w-75 ms-3">
            <p class="mb-0">International <br> Reach</p>
          </div>
        </a>
      </div>
      <div class="col-6">
        <a href="javascript:void(0)" class="mdrc-healthcare-box">
          <div class="w-25">
            <img src="assets/images/mdrc/home/svg/healthcare-icon4.svg" alt="" class="img-fluid d-block mx-auto object-cover w-100">
          </div>
          <div class="w-75 ms-3">
            <p class="mb-0">40+ Year of <br> Experience</p>
          </div>
        </a>
      </div>
    </div>
  </section>
  <!-- MDRC HealthCare Section End -->
  <!-- How it Works Section Start -->
  <section class="how-it-works pt-0 pb-3 bg-white">
    <img src="assets/images/mdrc/home/how-it-works.png" alt="" class="object-cover img-fluid w-100">
  </section>
  <!-- How it Works Section End -->
  <!-- Book Collection Start -->
  <section class="bookcollection pt-0 main-wrap pb-3 bg-white">
    <div class="row g-3 ">
      <div class="col-12">
        <div class="d-flex align-items-center justify-content-between">
          <h2 class="font-lg">Book Home Collection</h2>
          <div>
            <a href="<?=M_SERVER_ROOT;?>/pathology/lab-blood-test-near/<?=$_SESSION['citySlug'];?>" class="btn btn-solid">Book Now</a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Book Collection End -->
  <!-- Book Collection 2 Start -->
  <section class="how-it-works pt-0 pb-3 bg-white d-none">
    <img src="assets/images/mdrc/home/section-banner.png" alt="" class="object-cover img-fluid w-100">
  </section>
  <!--Book Collection 2 End -->
  <!-- Book Collection 2 Start -->
  <section class="book-collection2 pt-0 main-wrap pb-3 bg-white">
    <div class="row g-3 align-items: stretch">
      <div class="col-6">
        <a href="<?=M_SERVER_ROOT;?>/pathology/lab-blood-test-near/<?=$_SESSION['citySlug'];?>" class="d-flex flex-column align-items-center shadow1 p-3 rounded-10 bg-white h-100">
          <div class="mb-1">
            <img src="assets/images/mdrc/home/booklab-test.svg" alt="" class="img-fluid d-block mx-auto object-cover">
          </div>
          <p class="mb-0 text-center">Book a Lab Test</p>
        </a>
      </div>
      <div class="col-6">
        <a href="<?=M_SERVER_ROOT;?>/download-reports" class="d-flex flex-column align-items-center shadow1 p-3 rounded-10 bg-white h-100">
          <div class="mb-1">
            <img src="assets/images/mdrc/home/download-report.svg" alt="" class="img-fluid d-block mx-auto object-cover">
          </div>
          <div>
            <p class="mb-0 text-center">Download reports</p>
          </div>
        </a>
      </div>

    </div>
  </section>
  <!-- Book Collection 2 End -->
</main>
<!-- Main End -->

<!-- Footer Start -->
<?php include('includes/footer.php'); ?>
<!-- Footer End -->