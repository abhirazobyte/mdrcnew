<?php include('includes/header.php'); ?>
<!-- Main Start -->
<main class="pb-4 bg-white page-common">
	<!-- About banner start -->
	<div class="card bg-theme rounded-0 border-0 ">
		<div class="w-100 mx-auto">
			<img src="../images/oncology-banner.png" alt="" class="w-100 h-100 img-fluid">
		</div>
	</div>
	<!-- About banner end -->

	<!-- About banner start -->
	<div class="card  rounded-0 border-0 mt-2 p-3">
		<div class="w-100 mx-auto">
			<img src="../images/oncology.jpg" alt="" class="w-100 h-100 img-fluid">
		</div>
		<div class="w-100 mx-auto pt-2">
			<h2 class="mb-3">Oncology</h2>
			<p>Oncology is a branch of medicine that deals with the diagnosis, treatment, and management of cancer. Cancer is a complex and serious disease that affects millions of people worldwide, and early detection is critical to improving outcomes and increasing the chances of a successful treatment.</p>
			<p>At MDRC India, we understand the importance of providing comprehensive and compassionate care to those facing a cancer diagnosis. We offer a range of oncology tests and services to help diagnose, monitor, and treat cancer.</p>
			<p>Diagnostic tests for cancer include imaging studies such as X-rays, CT scans, and MRI, as well as biopsy procedures to obtain a tissue sample for examination. These tests are used to identify the presence and location of cancer in the body, as well as to determine the type and stage of the disease.</p>

		</div>
	</div>
	<!-- About banner end -->

	<!-- About banner start -->
	<div class="card  rounded-0 border-0 mt-2 p-3">
		<div class="w-100 mx-auto">
			<img src="../images/oncology-1.jpg" alt="" class="w-100 h-100 img-fluid">
		</div>
		<div class="w-100 mx-auto pt-3">
			<p>Once a cancer diagnosis has been made, monitoring tests such as blood tests, PET scans are used to track the progression of the disease and the effectiveness of treatment. These tests also help identify any changes in the cancer, allowing for prompt and appropriate intervention.</p>
			<p>Treatment for cancer often involves a combination of surgery, chemotherapy, and radiation therapy. Our lab offers a range of tests to monitor the effectiveness of treatment, including blood tests to track the level of cancer markers, and imaging studies to track the size and location of the cancer.</p>
			<p>At our healthcare and diagnostic lab, we believe in providing our patients with the highest quality care and support. Our team of experienced and highly trained medical professionals is dedicated to ensuring that you receive the best possible care, and our commitment to quality is reflected in every test we perform.</p>
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