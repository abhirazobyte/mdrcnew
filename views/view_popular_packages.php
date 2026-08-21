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
<link href="css/custom.css" rel="stylesheet">
<!--Start Header -->
<?php include 'includes/header.php'; ?>
<!--End Header -->
<!--Start Hero-->
<section class=" pt40 pb40" data-background="images/bg-gradient.png" style="display:none">
	<div class="text-block">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-6">
					<h1 class="wow fadeInUp f-bold text-white" data-wow-delay=".2s">MODERN Popular Package</h1>
					<p class="text-white mt-4 mb-3 d-inline-block f-normal"><span class="f-medium">
						Our Range of Premium HealthCheckup gives you a unique mix of both Radiology & Pathology test to give you a comphrensive body checkup. <br />
					Along with comphresive Pathology Blood Checkup Packages</span>
				</p>
				<div class="col-12 mt-4 p-0">
					<h6 class="text-white mb-3">Accreditations</h6>
				</div>
				<div class="col-12 cl-logo d-flex p-0">
					<div class="clients-logo">
						<div>
							<img src="images/nabh-logo.png" alt="nabh-logo" class="img-fluid">
							<span>MIS- 2017-0045</span>
							<!-- <img src="images/accred-1.png" alt="text" class="img-fluid"> -->
						</div>
					</div>
					<!-- <div class="clients-logo">
						<div>
							<img src="images/cap-logo.png" alt="cap-logo" class="img-fluid">
							<img src="images/accred-2.png" alt="text" class="img-fluid">
							<span>CAP No. 8498566</span>
						</div>
					</div> -->
					<div class="clients-logo">
						<div>
							<img src="images/nabl-new-logo.png" alt="nabl-new-logo" class="img-fluid">
							<!-- <img src="images/accred-3.png" alt="text" class="img-fluid"> -->
							<span>MC-2334</span>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-6 mt-3 mt-lg-0 mt-md-0">
				<div class="bannerSlide owl-carousel">
					<div class="items">
						<div class="col-12 p-0">
							<img src="images/MDRC-overview.jpg" alt="MDRC-overview" />
						</div>
					</div>
					<div class="items">
						<div class="col-12 p-0">
							<img src="images/allergy-inhalation.jpg" alt="allergy-inhalation" />
						</div>
					</div>
					<div class="items">
						<div class="col-12 p-0">
							<img src="images/pouplar-packages.png" alt="pouplar-packages" />
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</section>
<section class="hero-creative-agenc1 banner-twostyle pt10 pb10" data-background="images/radiology-bg.png">
<div class="text-block">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-6">
				<h1 class="wow fadeInUp fs-3 f-bold text-white" data-wow-delay=".2s">MODERN Popular Package</h1>
			</div>
		</div>
	</div>
</div>
</section>
<!--End Hero-->
<!--slider-->
<?php if (count($this->rs_banner) > 0) { ?>
<section class="moderSection">
<div class="container-fluid">
	<div class="row">
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
</div>
</section>
<?php } ?>
<!--End Hero-->
<!--Start-->
<!--End-->
<section class="pb30 pt40 healthSection packages">
<div class="container">
	<div class="row align-items-end section-title">
		
		<?php
			$default_string = array("{CITY}");
			$new_string = array($_SESSION['cityName']);
			$page_title=str_replace($default_string, $new_string,$this->page_info["content_title"]);
			$page_desc=str_replace($default_string, $new_string,$this->page_info["content_desc"]);
		?>
		
		<div class="col-lg-6 col-md-8 col-12">
			<div class="common-heading-2 text-start">
				<h2 class="mb20 "><?=$page_title;?></h2>
				<span>Home > Popular Packages</span>
			</div>
		</div>
		<div class="col-lg-6 col-md-4 col-12 text-end">
			<div class="sortby mb10">
				Sort By
				<select name="sort_order" id="sort_order" onchange="ChanegeSortOrder(this.value)">
					<option value="">Latest</option>
					<option value="name_a_z">Name (A - Z)</option>
					<option value="name_z_a">Name (Z - A)</option>
					<option value="price_l_h">Price (Low - High)</option>
					<option value="price_h_l">Price (High - Low)</option>
				</select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<hr class="line" />
		</div>
	</div>
	
	
	<div class="row mt20">
		<div class="col-lg-12 col-md-12 col-12">
			<div class="row">
				<div class="col-lg-12 mb-4 col-12 text-center">
					<input class="search-input" id="serach_keyword" name="serach_keyword" type="text" placeholder="Find your Test/Package/Scan" onkeyup="searchData(this.value)">
				</div>
			</div>
			<div class="row" id="results">
			</div>
			<div class="nonvalued">
				<input type="hidden" name="type_ids" id="type_ids" value="">
				<input type="hidden" name="dieses_ids" id="dieses_ids" value="">
				<input type="hidden" name="category_ids" id="category_ids" value="">
				<input type="hidden" name="sort_by" id="sort_by" value="">
				<input type="hidden" name="search_data" id="search_data" value="">
				<input type="hidden" name="city_id" id="city_id" value="<?= $this->city_id ?>">
				<input type="hidden" name="department_id" id="department_id" value="<?= $this->department_id ?>">
				<input type="hidden" name="total_data" id="total_data" value="0">
				<input type="hidden" name="pageType" id="pageType" value="<?= $this->pageType ?>">
			</div>
			<div class="row">
				<div class="col-lg-12 loaderDiv d-none" style="text-align:center">
					<img src="images/loader.gif">
				</div>
				<div class="col-lg-12 " style="text-align:center">
					<button class="btn-main bg-btn1 bg-grengradi text-white lnk wow fadeInUp animation_image" id="l_more" align="center" style="display:none">Load More <span class="circle"></span></button>
				</div>
			</div>

			<?php if($page_desc!='') { ?>
	<div class="row mt20">
		<div class="col-lg-12 col-md-12 col-12">
			<?=$page_desc;?>
		</div>
	</div>
	<?php } ?>
	
		</div>
	</div>
</div>
</section>
<!--End Faqs-->
<!-- Start Book Home Collection -->
<section id="how-work" class="pt40 middi pb80 ste4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
				<div class="row section-title">
					<div class="col-sm-6 col-8">
						<div class="common-heading-2 text-start">
							<h3 class="mb30 fs-3 text-202024">Schedule your Health Test with MDRC</h3>
						</div>
					</div>
					<div class="col-sm-6 col-4 text-end">
						<a data-bs-toggle="modal" data-bs-target="#modalform-full" href="#" class="btn-main bg-btn1 btn-blue lnk wow fadeInUp text-uppercase">Book Now <span class="circle"></span></a>
					</div>
				</div>
			</div>
        </div>
        <div class="row section-title">
            <div class="col-sm-4 text-start text-lg-center text-md-center position-relative">
                <div class="how-works-block text-start">
                    <!-- <img class="harrow" src="images/harrow.png" alt=""> -->
                    <div class="img"><img src="images/searchtest.png" alt=""></div>
                    <h5>
                        <span>Search &amp; Add <br> Your Test</span><br>
                    </h5>
                </div>
            </div>
            <div class="col-sm-4 text-start text-lg-center text-md-center position-relative">
                <div class="how-works-block text-start">
                    <!-- <img class="harrow mid" src="images/harrow.png" alt=""> -->
                    <div class="img" style="
    padding: 11px;
"><img src="images/secudletest.png" alt=""></div>
                    <h5 class="midd">
                        <span>Book Appointment<br>For Your Tests</span><br>
                    </h5>
                </div>
            </div>

			


            
            <div class="col-sm-4 text-start text-lg-center text-md-center position-relative">
                <div class="how-works-block text-start">
                    <div class="img" style="
    padding: 19px 19px;
    min-width: 119px;
    text-align: center;
"><img src="images/dwnload_report.png" alt=""></div>
                    <h5>
                        <span>Get Reports <br> Online</span><br>
                    </h5>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Book Home Collection -->
<section class="pb130 pt40 testimonials raiolog">
<div class="container">
	<div class="row">
		<div class="col-lg-4  col-md-7">
			<div class="common-heading-2 text-start">
				<h2 class="mb0 lh-16">What Customer say </h2>
				<!--<p class="text-101010">Lorem ipsum is a placeholder text commonly </p>-->
			</div>
		</div>
		<div class="col-lg-8  col-md-5 mt-3 mt-lg-0 mt-md-0 border-start ps-lg-5 m-minus reviewimgs">
			<a class="revi-text" href="#"><img src="images/review-google.png" alt="Review Google" />
				<div class="ps-3">4.8<br /><span>3000+ Reviews</span></div>
			</a>
		</div>
	</div>
	<?php if (count($this->rs_testimonial) > 0) { ?>
	<div class="row normal position-relative">
		<div class="col-md-12 p-0 mt20">
			<div class="niwax-review-slider owl-carousel center-dots">
				<?php for ($i = 0; $i < count($this->rs_testimonial); $i++) {
				$image = $this->utility->get_image_path($this->rs_testimonial[$i]['image'], 'testimonial', 'large'); ?>
				<div class="reviews-card pr-shadow">
					<div class="-client-details-">
						<div class="-reviewr">
							<img src="<?= $image ?>" alt="<?= $this->rs_testimonial[$i]['name'] ?>" class="img-fluid">
						</div>
						<div class="reviewer-text">
							<h4><?= $this->rs_testimonial[$i]['name'] ?></h4>
							<p><?= $this->rs_testimonial[$i]['city'] ?><br />Service Rated <a href="javascript:void(0)" class="chked"><i class="fa fa-star"></i></a> <?= $this->rs_testimonial[$i]['ratting'] ?></p>
						</div>
					</div>
					<div class="review-text text-start">
						<div class="col"> <span class="revbx-lr"><img src="images/img-quote.png" alt="quote" /></span> </div>
						<p><?= $this->rs_testimonial[$i]['content'] ?></p>
					</div>
				</div>
				<?php } ?>
			</div>
			<div class="owl-theme">
				<div class="owl-controls">
					<div class="custom-nav owl-nav"></div>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
</div>
</section>
<?php include 'includes/get_in_touch_form.php'; ?>
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