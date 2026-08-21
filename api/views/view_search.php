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
<section class=" pt40 pb40" data-background="images/bg-gradient.png">
	<div class="text-block">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-6">
					<p class="text-white mt-0 mb-0 d-inline-block f-normal">Showing results for</p>
					<h1 class="wow fadeInUp mt-0 f-bold text-white" data-wow-delay=".2s">"<?= $this->searchKeword ?>"</h1>
					<div class="col-12 mt-4 p-0">
						<h6 class="text-white mb-3">Accreditations</h6>
					</div>
					<div class="col-12 cl-logo smallii d-flex p-0">
						<div class="clients-logo">
							<img src="images/accred-1.png" alt="text" class="img-fluid">
						</div>
						<!--
			             <div class="clients-logo">
							<img src="images/accred-2.png" alt="text" class="img-fluid">
						</div> -->
						<div class="clients-logo">
							<img src="images/accred-3.png" alt="text" class="img-fluid">
						</div>
					</div>
				</div>
				<div class="col-lg-6 mt-3 mt-lg-0 mt-md-0">
					<a href="premium-health-checkup/<?= $_SESSION['citySlug']; ?>">
						<img class="w-100 rounded" src="images/pouplar-packages.png" alt="" />
					</a>
				</div>
			</div>
		</div>
	</div>
</section>
<!--End Hero-->
<!--Start-->
<section class="pb30 moderSection pt40 d-none">
	<div class="container">
		<div class="row normal position-relative">
			<div class="col-lg-12 text-center col-md-12 col-12">
				<div class="modernSlide owl-carousel">
					<div class="items">
						<a href="#" class="col-12 p-0 position-relative radi">
							<img src="images/system-1.jpg" alt="" />
							<span class="align">MRI Scan</span>
						</a>
					</div>
					<div class="items">
						<a href="#" class="col-12 p-0 position-relative radi">
							<img src="images/system-2.jpg" alt="" />
							<span class="align">CT Scan</span>
						</a>
					</div>
					<div class="items">
						<a href="#" class="col-12 p-0 position-relative radi">
							<img src="images/system-3.jpg" alt="" />
							<span class="align">CBCT</span>
						</a>
					</div>
					<div class="items">
						<a href="#" class="col-12 p-0 position-relative radi">
							<img src="images/system-4.jpg" alt="" />
							<span class="align">Ultrasound</span>
						</a>
					</div>
					<div class="items">
						<a href="#" class="col-12 p-0 position-relative radi">
							<img src="images/system-5.jpg" alt="" />
							<span class="align">Colour Doppler Ultrasound</span>
						</a>
					</div>
					<div class="items">
						<a href="#" class="col-12 p-0 position-relative radi">
							<img src="images/system-6.jpg" alt="" />
							<span class="align">Digital X Ray</span>
						</a>
					</div>
					<div class="items">
						<a href="#" class="col-12 p-0 position-relative radi">
							<img src="images/system-7.jpg" alt="" />
							<span class="align">Mammography</span>
						</a>
					</div>
					<div class="items">
						<a href="#" class="col-12 p-0 position-relative radi">
							<img src="images/system-8.jpg" alt="" />
							<span class="align">Bone Densitometry (Dexa)</span>
						</a>
					</div>
					<div class="items">
						<a href="#" class="col-12 p-0 position-relative radi">
							<img src="images/system-9.jpg" alt="" />
							<span class="align">Neurology Lab</span>
						</a>
					</div>
					<div class="items">
						<a href="#" class="col-12 p-0 position-relative radi">
							<img src="images/system-10.jpg" alt="" />
							<span class="align">Complete Heart Lab</span>
						</a>
					</div>
					<div class="items">
						<a href="#" class="col-12 p-0 position-relative radi">
							<img src="images/system-11.jpg" alt="" />
							<span class="align">Pulmonary Function Test</span>
						</a>
					</div>
				</div>
				<div class="owl-theme">
					<div class="owl-controls">
						<div class="custom-nav owl-nav"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!--End-->
<section class="pb30 pt40 healthSection packages">
	<div class="container">
		<div class="row align-items-end section-title">
			<div class="col-lg-6 col-md-8 col-12">
				<div class="common-heading-2 text-start">
					<h2 class="mb20 ">Popular Packages in <?= $this->city_name ?></h2>
				</div>
			</div>
			<div class="col-lg-6 col-md-4 col-12 text-end">
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<hr class="line" />
			</div>
		</div>
		<div class="row mt20">
			<div class="col-lg-12 col-md-12 col-12">
				<div class="row" id="results">
				</div>
				<div class="nonvalued">
					<input type="hidden" name="type_ids" id="type_ids" value="">
					<input type="hidden" name="dieses_ids" id="dieses_ids" value="">
					<input type="hidden" name="category_ids" id="category_ids" value="">
					<input type="hidden" name="sort_by" id="sort_by" value="">
					<input type="hidden" name="search_data" id="search_data" value="<?= $this->searchKeword ?>">
					<input type="hidden" name="city_id" id="city_id" value="<?= $this->city_id ?>">
					<input type="hidden" name="department_id" id="department_id" value="<?= $this->department_id ?>">
					<input type="hidden" name="pageType" id="pageType" value="<?= $this->pageType ?>">
					<input type="hidden" name="total_data" id="total_data" value="0">
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
	</div>
</section>
<!--End Faqs-->
<section class="pb50 bg-art-pic pt50 testimonials raiolog">
	<div class="container">
		<div class="row">
			<div class="col-lg-4  col-md-7">
				<div class="common-heading-2 text-start">
					<h2 class="mb0 lh-16">What Customer say </h2>
					<!-- <p class="text-101010">Lorem ipsum is a placeholder text commonly </p> -->
				</div>
			</div>
			<div class="col-lg-8  col-md-5 mt-3 mt-lg-0 mt-md-0 border-start ps-lg-5 m-minus reviewimgs">
				<!-- <a class="me-3 me-lg-5 me-md-3" href="#"><img src="images/review-google.png" alt="Review Google" /></a> -->
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
					$image = $this->utility->get_image_path($this->rs_testimonial[$i]['image'], 'testimonial', 'large');
				?>
					<div class="reviews-card pr-shadow">
						<div class="-client-details-">
							<div class="-reviewr">
								<img src="<?= $image ?>" alt="<?= $this->rs_testimonial[$i]['name'] ?>" class="img-fluid">
							</div>
							<div class="reviewer-text">
								<?= $this->rs_testimonial[$i]['city'] ?><br />Service Rated <a href="javascript:void(0)" class="chked"><i class="fa fa-star"></i></a>
								<?= $this->rs_testimonial[$i]['ratting'] ?>
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
<section class="getTouch d-none">
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
			<div class="col-lg-6 col-md-6 ms-auto text-end mtopminus">
				<img src="images/doctors.png" class="img-fluid">
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