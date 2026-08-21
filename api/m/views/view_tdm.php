<?php include('includes/header.php'); ?>
<!-- Main Start -->
<main class="pb-4 bg-white page-common">
	<!-- About banner start -->
	<div class="card bg-theme rounded-0 border-0 ">
		<div class="w-100 mx-auto">
			<img src="../images/tdm-banner.png" alt="" class="w-100 h-100 img-fluid">
		</div>
	</div>
	<!-- About banner end -->

	<!-- About banner start -->
	<div class="card  rounded-0 border-0 mt-2 p-3">
		<div class="w-100 mx-auto">
			<img src="../images/tdm.jpg" alt="" class="w-100 h-100 img-fluid">
		</div>
		<div class="w-100 mx-auto pt-2">
			<h2 class="mb-3">Therapeutic Drug Monitoring</h2>
			<p>Therapeutic Drug Monitoring (TDM) is a critical tool in the effective management of various Psyciatric medical conditions. The purpose of TDM is to monitor the concentration of drugs in a patient's bloodstream to ensure that the right amount is being taken and to prevent toxicity or inadequate treatment.</p>
			<p>At MDRC India, we understand the importance of accurate and reliable TDM results.</p>
			<p>LC-MS/MS is a highly advanced method of TDM that offers several advantages over traditional methods. It provides a more accurate and reliable measurement of drug levels, which allows for more precise dosing and better patient outcomes.</p>
		</div>
	</div>
	<!-- About banner end -->

	<!-- About banner start -->
	<div class="card  rounded-0 border-0 mt-2 p-3">
		<div class="w-100 mx-auto">
			<img src="../images/tdm2.jpg" alt="" class="w-100 h-100 img-fluid">
		</div>
		<div class="w-100 mx-auto pt-3">
			<p>Whether you're a patient or a healthcare provider, you can trust that our lab will provide you with the information you need to make informed decisions about Our Tests.</p>
			<p>At our MDRC, we believe in making healthcare accessible to everyone. That's why we offer convenient scheduling, affordable pricing, and easy access to test results. Our goal is to make the process of getting tested as stress-free and straightforward as possible.</p>
			<p>In conclusion, if you're looking for a healthcare Lab that offers high-quality TDM services using the latest technology and methods, look no further. Contact us today to learn more about how we can help you stay healthy and informed.</p>
		</div>
	</div>
	<!-- About banner end -->

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