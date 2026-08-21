<?php include('includes/header.php'); ?>
<!-- Main Start -->
<main class="pb-2 bg-white page-common">
	<section class=" ">
		<div id="carouselExampleInterval" class="carousel slide carousel-btn" data-bs-ride="carousel">
			<div class="carousel-inner">
				<div class="carousel-item active" data-bs-interval="2000">
					<img src="../images/radiology-mammography.jpg" class="d-block w-100" alt="">
				</div>
				<div class="carousel-item" data-bs-interval="2000">
					<img src="../images/maternal1.jpg" class="d-block w-100" alt="">
				</div>
			</div>
			<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="visually-hidden">Previous</span>
			</button>
			<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="visually-hidden">Next</span>
			</button>
		</div>
	</section>

	<!-- About banner start -->
	<div class="card  rounded-0 border-0 mt-2 p-3">
		<div class="w-100 mx-auto">
			<img src="../images/pregnancy-care.jpg" alt="" class="w-100 h-100 img-fluid">
		</div>
		<div class="w-100 mx-auto pt-2">
			<h2 class="mb-3">Maternal care</h2>
			<p>Maternal care is a critical aspect of ensuring the health and well-being of both the mother and her unborn child. At our healthcare and diagnostic lab, we understand the importance of providing comprehensive and compassionate care to expecting mothers throughout their pregnancy.</p>

			<p>During pregnancy, a woman's body undergoes significant changes, and it's important to monitor her health closely. That's why we offer a range of tests and services specifically designed for each trimester of pregnancy.</p>
		</div>
	</div>
	<!-- About banner end -->

	<style>
		.about-tab .nav-link {
			padding: 5px 25px !important;
		}
	</style>

	<!-- About tab start -->
	<div class="about-tab mb-3 pt-4 pb-4" style="background: url(../images/baby-stape.png) 0% 0% no-repeat, url(../images/baby-stape.png) 100% 100% no-repeat;">
		<ul class="nav nav-pills mb-3 justify-content-center gap-2" id="pills-tab" role="tablist">
			<li class="nav-item" role="presentation">
				<button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-nabl" type="button" role="tab" aria-controls="pills-home" aria-selected="true">
					<p class="mb-0">I-Trimester</p>
				</button>
			</li>
			<li class="nav-item" role="presentation">
				<button class="nav-link" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-nabh" type="button" role="tab" aria-controls="pills-home" aria-selected="true">
					<p class="mb-0">II-Trimester</p>
				</button>
			</li>
			<li class="nav-item" role="presentation">
				<button class="nav-link" id="pills-home-tab2" data-bs-toggle="pill" data-bs-target="#pills-nabh2" type="button" role="tab" aria-controls="pills-home2" aria-selected="true">
					<p class="mb-0">III-Trimester</p>
				</button>
			</li>
		</ul>
		<div class="tab-content px-3" id="pills-tabContent">
			<div class="tab-pane fade show active" id="pills-nabl" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
				<p class="mb-2">
					In the first trimester, it's important to confirm the pregnancy and assess the health of the fetus. Our Tests can help detect any potential complications and ensure the health of the baby.
				</p>
			</div>
			<div class="tab-pane fade" id="pills-nabh" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
				<p class="mb-2">
					In the second trimester, a range of tests are performed to monitor the growth and development of the fetus, including mid-pregnancy ultrasound, alpha-fetoprotein (AFP) screening, and glucose tolerance test. These tests help identify any potential problems and allow for early intervention, if necessary.
				</p>
			</div>
			<div class="tab-pane fade" id="pills-nabh2" role="tabpanel" aria-labelledby="pills-profile-tab2" tabindex="0">
				<p class="mb-2">
					In the second trimester, a range of tests are performed to monitor the growth and development of the fetus, including mid-pregnancy ultrasound, alpha-fetoprotein (AFP) screening, and glucose tolerance test. These tests help identify any potential problems and allow for early intervention, if necessary.
				</p>
			</div>
		</div>
	</div>
	<!-- About tab end -->

	<?php if (count($this->homeItems) > 0) { ?>
		<!-- Our Our Maternal Packages Start -->
		<section class="banner-section materanl-package banner-section ratio2_1 ps-3 bg-theme py-3 mb-3">
			<div class="d-flex align-items-center mb-3 justify-content-between pe-3">
				<h2 class="font-lg text-white">Tests and Packages </h2>
				<!-- <a href="<?= M_SERVER_ROOT . '/premium-health-checkup/' . $_SESSION['citySlug'] ?>" class="text-white d-flex align-items-center">View All
					<img src="assets/images/mdrc/icons/double-chevron.svg" alt="" class="ms-2">
				</a> -->
			</div>
			<div class="maternal-package-slider">
				<?php
				foreach ($this->homeItems as $item) {
					$id = $item['id'];
					$item_price_id = $item['item_price_id'];
					$slug = $item['slug'];
					$name = $item['name'];
					$test_count = $item['test_count'];
					$image = $item['image'];
					$folder = $item['folder'];
					$price = $item['item_price_price'];
					$mrp = $item['item_price_mrp'];
					$url = 'tests/' . $item['slug'] . '/' . $_SESSION['citySlug'];
					$sch_price = $item['item_price_sch_price'];
					$sch_start_date = $item['item_price_sch_start_date'];
					$sch_end_date = $item['item_price_sch_end_date'];
					if ($sch_price > 0 && $sch_start_date != '' && $sch_end_date != '') {
						$today_date = date('d-m-Y');
						$todaySlot = strtotime($today_date);
						$startSlot = strtotime($sch_start_date);
						$endSlot = strtotime($sch_end_date);
						if ($todaySlot >= $startSlot && $todaySlot <= $endSlot) {
							$price = $sch_price;
						}
					}
					$price_html = $this->utility->mpackagePrice($id, $price, $mrp);
					$description1 = strip_tags($item['item_other_data_description']);
					$description_li = '';
					if ($description1 != '') {
						$description = $this->utility->string_truncate($description1, 100);
						$description_li = '<li><span>' . $description . '</span></li>';
					}
					$test_parameters_html = strip_tags($item['item_description_test_parameters']);
					if ($test_parameters_html != '') {
						$test_parameters_html = '<li><span>' . $this->utility->string_truncate($test_parameters_html, 100) . '</span></li>';
					}

					if (in_array($id, $_SESSION['cartitemIds'])) {
						$Book_Now = '<a href="' . $url . '" class="btn-main bg-btn1 btn-green lnk wow fadeInUp text-uppercase book-now">Added <span class="circle"></span></a>';
						$cartbtn = '<a class="add_to_cart btncart btn th-btn-green text-white btn-md font-sm d-flex align-items-center"> <img src="assets/images/mdrc/icons/shopping-cart-white.svg" alt="" class="me-1">Added</a>
          ';
					} else {
						$Book_Now = '<a href="' . $url . '" class="btn-main bg-btn1 btn-blue lnk wow fadeInUp text-uppercase book-now">Book Now <span class="circle"></span></a>';
						$cartbtn = '<a href="javascript:void(0)" data-item_price_id="' . $item_price_id . '" data-item_id="' . $id . '" class="add_to_cart btncart btn th-btn-solid-sm text-white btn-md font-sm d-flex align-items-center"> <img src="assets/images/mdrc/icons/shopping-cart-white.svg" alt="" class="me-1">Add</a>';
					}
				?>
					<div class="banner-box MDRC-TEST">
						<div class="border p-3 bg-white rounded">
							<a href="<?= $url; ?>" class="filter font-md theme-color fw-bold mb-2"><?= $name ?></a>
							<ul class="packageul">
								<li><span>Total no. of Tests : <?= $test_count ?></span></li>
								<?= $description_li ?>
								<?= $test_parameters_html; ?>
							</ul>
							<div class="d-flex align-items-center justify-content-between">
								<?= $price_html ?>
								<div>
									<?= $cartbtn; ?>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</section>
		<!-- Our Our Maternal Packages ENd -->
	<?php } ?>

	<!-- About banner start -->
	<div class="card  rounded-0 border-0 mt-2 p-3">
		<div class="w-100 mx-auto">
			<img src="../uploads/gallery/16678004441104.png" alt="" class="w-100 h-100 img-fluid">
		</div>
		<div class="w-100 mx-auto pt-3">
			<h2 class="mb-2">At MDRC India</h2>
			<p> We believe that providing expectant mothers with the best possible care is essential. Our team of experienced medical professionals is dedicated to ensuring that you receive the highest quality care, and our commitment to quality is reflected in every test we perform.</p>
			<p>In conclusion, if you're expecting a child and looking for comprehensive maternal care and testing services, look no further. Contact us today to learn more about how we can support you and your growing family.</p>
		</div>
	</div>
	<!-- About banner end -->

</main>
<!-- Main End -->

<!-- Footer Start -->
<?php include('includes/footer.php'); ?>
<!-- Footer End -->