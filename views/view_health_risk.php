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
<section class="about-lead-gen abpage pb-0" data-background="" style="background-image: url(&quot;&quot;);">
	<div class="home-collection-bg">
		<img src="images/health-risk/main-banner.png" alt="home-collection-banner">
	</div>
</section>
<!--Start Mission Vision-->
<section class="teb-section  pb50 pt40 health-risk-main">
	<div class="container">
		<div class="row justify-content-start">
			<div class="col-lg-12">
				<div class="common-heading-2 text-start">
					<h1 class="mb10">Health Risk</h1>
				</div>
			</div>
		</div>
		<div class="row upset link-hover shape-num justify-content-start">
			<?php
			$j = 0;
			foreach ($item_diseases as $item) {
				$Cats = explode(',', $item['item_department_ids']);
				if (count($Cats) > 0 && in_array('2', $Cats)) {
					if ($j > 30) {
						break;
					}
					$image = $this->utility->get_image_path($item['image'], 'item_diseases', 'large');
			?>
					<div class="col-lg-3 col-md-4 col-6  mt30 shape-loc  wow fadeIn" data-wow-delay=".2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeIn;">
						<div class="s-block" data-tilt="" data-tilt-max="5" data-tilt-speed="1000" style="will-change: transform; transform: perspective(1000px) rotateX(0deg) rotateY(0deg) scale3d(1, 1, 1);">
							<div class="s-card-icon"><img data-src="<?=$image?>"alt="<?=$item['name'];?>" class="owl-lazy" src="<?=$image?>" style="opacity: 1;"></div>
							<h4><?=$item['name'];?></h4>
							<a href="diseases/<?= $_SESSION['citySlug']; ?>/<?= $item['slug']; ?>">BOOK NOW<i class="fas fa-chevron-right fa-icon"></i></a>
						</div>
					</div>
			<?php $j++;
				}
			} ?>
		</div>
	</div>
</section>
<!--End Mission Vision-->
<section id="how-work" class="pt40 middi schedule pb50 ste4">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-12">
				<div class="row section-title text-center">
					<div class="col-sm-12 col-12">
						<div class="common-heading-2 ">
							<h3 class="fs-3 text-202024">Schedule your Health Test with MDRC</h3>
							<h5 class="mb20">Take control of your health journey
								book your comprehensive health test with MDRC India now</h5>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row section-title mt10 justify-content-center align-items-center">
			<div class="col-sm-3 col-lg-3 col-md-4 col-8 text-start text-lg-center text-md-center position-relative">
				<div class="how-works-block text-start">
					<div class="d-flex align-items-center">
						<img alt="" class="lazy" src="images/search-res.png" style="">
						<div class=" ms-3">
							<h5>
								Search &amp; Add<br>
								Your Test
							</h5>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-3 col-lg-3 col-md-4 col-8 text-start text-lg-center text-md-center position-relative">
				<div class="how-works-block text-start">
					<div class="d-flex align-items-center">
						<img alt="" class="lazy" src="images/book-ser.png" style="">
						<div class=" ms-3">
							<h5>
								Book Appointment<br>For Your Tests
							</h5>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-3 col-lg-3 col-md-4 col-8 text-start text-lg-center text-md-center position-relative">
				<div class="how-works-block text-start">
					<div class="d-flex align-items-center">
						<img alt="" class="lazy" src="images/report-ser.png" style="">
						<div class=" ms-3">
							<h5>
								Get Reports<br>
								Online
							</h5>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-12 col-12 mt30 text-center">
				<a data-bs-toggle="modal" data-bs-target="#modalform-full" href="#" class="btn-main bg-btn1 btn-blue lnk wow fadeInUp text-uppercase" style="visibility: visible; animation-name: fadeInUp;">Book Now <span class="circle"></span></a>
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
<script id="rendered-js">
	$(document).ready(function() {
		// $('.my-select').selectpicker();
		// $(function () {
		// $('select').selectpicker();
		// });
	});
	//# sourceURL=pen.js
</script>
<script>
	//Owl-Carousel - awards card
	var owl = $('.niwax-review-slider');
	owl.owlCarousel({
		items: 3,
		loop: false,
		center: false,
		autoplay: true,
		margin: 10,
		nav: true,
		navText: [
			'<img src="images/black-arrow-left.png" />',
			'<img src="images/black-arrow-right.png" />'
		],
		navContainer: '.testimonials .custom-nav',
		dots: false,
		autoplayTimeout: 3500,
		autoplayHoverPause: true,
		smartSpeed: 2000,
		responsive: {
			0: {
				items: 1,
			},
			520: {
				items: 1
			},
			768: {
				items: 2
			},
			1200: {
				items: 2
			},
			1400: {
				items: 3
			},
			1600: {
				items: 3
			},
		}
	});
</script>
<?php include 'includes/general_data.php'; ?>