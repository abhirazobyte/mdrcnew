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
<link href="css/custom.css?v=1.3" rel="stylesheet">
<!--Start Header -->
<?php include 'includes/header.php'; ?>
<!--End Header -->

<section class="hero-creative-agenc1 banner-twostyle pt10 pb10" data-background="images/radiology-bg.png">
	<div class="text-block">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-12">
					<h1 class="wow fadeInUp h3 f-bold text-white" data-wow-delay=".2s"><?= $this->data_name ?> Test Price Near you in <?= $this->areaName; ?> <?= $this->city_name ?></h1>

				</div>

			</div>
		</div>
	</div>
</section>
<!--End Hero-->
<!--slider-->
<?php if (count($this->rs_banner) > 0 || count($this->item_category_banner) > 0) { ?>
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
								<a href="<?= $url ?>"><img src="<?= $image ?>" alt="Banner" /></a>
							</div>
						</div>
					<?php } ?>

					<?php for ($i = 0; $i < count($this->item_category_banner); $i++) {
						$folder = 'item_category_banner';
						$image = $this->utility->get_image_path($this->item_category_banner[$i]['banner_image'], $folder, "large");
						$url = 'javascript:void(0)';
						if ($this->item_category_banner[$i]['banner_link'] != '') {
							$url = $this->item_category_banner[$i]['banner_link'];
						}
					?>
						<div class="items">
							<div class="col-12 p-0">
								<a href="<?= $url ?>"><img src="<?= $image ?>" alt="Banner" /></a>
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

		<div class="row">
			<div class="col-sm-12">
				<div class="common-heading-2 text-start ">
					<h2 class="mb20 "><?= $this->data_name ?> Tests/Packages</h2>
				</div>
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
					<input type="hidden" name="category_ids" id="category_ids" value="<?= $this->data_id ?>">
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

			</div>
		</div>

		<div class="row align-items-end section-title">
			<div class="col-lg-12 col-md-12 col-12">
				<div class="text-start ">


					<?php if ($this->rs_cat[0]['decsription'] != '') {
						$default_string = array("{CITY}");
						$new_string   = array($_SESSION['cityName']);
						$desc = str_replace($default_string, $new_string, $this->rs_cat[0]['decsription']);
					?>
						<div class="com-tag"><?= $desc; ?></div>
					<?php } ?>

				</div>
			</div>
		</div>


	</div>
</section>
<!-- start faq -->
<?php if (count($this->rs_faq_data) > 0) { ?>
	<section class="pt40 pb50 faqSection">
		<div class="container">
			<div class="row ">
				<!-- <div class="col-lg-6 col-md-6 mt15">
					<img src="images/img-faq.png" alt="image" class="img-fluid rounded-cust">
				</div> -->
				<div class="col-md-12 col-md-12 mt-3 mt-lg-0 mt-md-0">
					<div class="common-heading-2 text-start">
						<h2 class="mb20">Frequently Asked Questions for <?= $this->data_name ?> in <?= $this->areaName; ?> <?= $this->city_name ?></h2>
					</div>
					<div class="accordion" id="accordionExample">
						<?php for ($i = 0; $i < count($this->rs_faq_data); $i++) { ?>
							<div class="accordion-item">
								<h2 class="accordion-header" id="heading-1">
									<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?= $i ?>" aria-expanded="true" aria-controls="collapseOne">
										<?= $this->rs_faq_data[$i]['question'] ?>
									</button>
								</h2>
								<div id="collapse-<?= $i ?>" class="accordion-collapse collapse" aria-labelledby="heading-1" data-bs-parent="#accordionExample">
									<div class="accordion-body">
										<div class="data-reqs">
											<p><?= $this->rs_faq_data[$i]['answer'] ?></p>
										</div>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php } ?>
<!--End Faqs-->

<section class="pb60 pt40 testsbyCondition">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-8">
				<div class="common-heading-2">
					<h2 class="mb30">Our Imaging Services</h2>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 imgs text-center">
				<div class="logo-weworkfor owl-carousel">
					<?php for ($i = 0; $i < count($this->rs_category); $i++) {
						$name = $this->rs_category[$i]['name'];
						$image = $this->rs_category[$i]['image'];
						$slug = $this->rs_category[$i]['slug'];
						$folder = 'item_category';
						$item_diseases_img = $this->utility->get_image_path($image, $folder, "large");
						$url = SERVER_ROOT . '/category/' . $_SESSION['citySlug'] . '/' . $slug . '';
					?>
						<div class="items"><a href="<?= $url ?>">
								<div class="imgDiv"><img src="<?= $item_diseases_img ?>" alt="<?= $name ?>" class=""></div><br /><span><?= $name ?></span>
							</a></div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</section>

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

<section class="bg-art-pic">
	<section class="pb60 pt30 testimonials">
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
			<?php if (count($this->rs_testimonial) > 0) {
			?>
				<div class="row normal position-relative">
					<div class="col-md-12 p-0 mt20">
						<div class="niwax-review-slider owl-carousel center-dots">
							<?php for ($i = 0; $i < count($this->rs_testimonial); $i++) {
								$image = $this->utility->get_image_path($this->rs_testimonial[$i]['image'], 'testimonial', 'large');
							?>
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
	<section class="homelinks">
		<div class="container-fluid">
			<div class="row">
				<?php if (count($this->rs_area) > 0) { ?>
					<div class="col-lg-12 col-sm-12 pb50 pt50 bg-light text-center">
						<h6 class="fw-semibold mb20">Lab Tests Near You</h6>
						<?php for ($i = 0; $i < count($this->rs_area); $i++) { ?>
							<a href="category/<?= $_SESSION['citySlug'] ?>/<?= $this->slug ?>/<?= $this->rs_area[$i]['slug'] ?>" class="tags">Lab Test In <?= $this->rs_area[$i]['name'] ?></a>
						<?php } ?>
					</div>
				<?php } ?>
			</div>
		</div>
	</section>
	<section class="downloadSection pt0 pb50 d-none">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-6 col-md-5 lead-intro-">
					<img src="images/app-mobile.png" alt="image" class="img-fluid">
				</div>
				<div class="col-lg-4 col-md-7">
					<div class="common-heading-2 text-l">
						<h2 class="mb0">Download Our App Now</h2>
						<p class="mb25">Keeping a check on your health made easy with the app. Available on both Google Play Store and App Store. Get easy access to health check ups with quick turnaround time.</p>
						<a class="imggoogle me-3" href="#"><img src="images/img-gplay.png" alt="Google Play"></a>
						<a class="imgstore" href="#"><img src="images/img-appstore.png" alt="App Store"></a>
					</div>
				</div>
			</div>
		</div>
	</section>
</section>
<section class="getTouch ">
	<div class="container">
		<div class="row align-items-center ">
			<div class="col-lg-5 col-md-6">
				<div class="common-heading-2 mt20 text-l">
					<h2 class="mb0 text-white">Get In Touch With Us</h2>
					<p class="text-white">Feel Free to Connect With Us For Any Queries</p>
					<div class="form-block">
						<form id="contactForm" data-bs-toggle="validator" class="shake">
							<div class="row">
								<div class="form-group col-sm-4">
									<input type="text" id="name" placeholder="Name" required="" data-error="Please fill Out">
									<div class="help-block with-errors"></div>
								</div>
								<div class="form-group col-sm-4">
									<input type="tel" id="phone" placeholder="Mobile No." required="">
									<div class="help-block with-errors"></div>
								</div>
								<div class="form-group col-sm-4">
									<input type="text" id="mobile" placeholder="City" required="" data-error="Please fill Out">
									<div class="help-block with-errors"></div>
									<button type="submit" id="form-submit" class="btn1 bg-btn1">Submit <span class="circle"></span></button>
									<div id="msgSubmit" class="h3 text-center hidden"></div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- <div class="col-lg-6 col-md-6 ms-auto text-end mtopminus">
				<img src="images/doctors.png" class="img-fluid">
			</div> -->
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