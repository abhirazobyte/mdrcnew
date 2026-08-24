<?php
if (VIR_DIR == 'm/') {
	include('includes/m/header.php');
} else {

	if ($_SESSION['tempCityID'] == '') {
		$_SESSION['tempCityID'] = $_SESSION['cityID'];
	} else {
		if ($_SESSION['tempCityID'] != $_SESSION['cityID']) {
			$_SESSION['tempCityID'] = $_SESSION['cityID'];
			$_SESSION['items'] = '';
			$_SESSION['item_category'] = '';
			$_SESSION['item_diseases'] = '';
		}
	}
	//query for php
	if ($_SESSION['items'] == '') {

		$obj_model = $this->load_model('item');
		$obj_model->join_table("item_other_data", "left", array('item_id', 'item_category_ids', 'item_key_fetures_ids', 'item_department_ids', 'item_diseases_ids', 'item_type_id'), array("id" => "item_id"));
		$obj_model->join_table("item_price", "left", array(), array("id" => "item_id"));
		$city_cond = " and FIND_IN_SET ('" . $_SESSION['cityID'] . "',item.city_ids) and item_price.city_id='" . $_SESSION['tempCityID'] . "'";
		$items = $obj_model->execute("SELECT", false, "", "item.status='Active'" . $city_cond, "item.id desc");
		$_SESSION['items'] = $items;
	} else {
		$items = $_SESSION['items'];
	}

	if ($_SESSION['item_category'] == '') {
		$obj_model = $this->load_model('item_category');
		$item_category = $obj_model->execute("SELECT", false, "", "item_category.status='Active'", "sort_order asc");
		$_SESSION['item_category'] = $item_category;
	} else {
		$item_category = $_SESSION['item_category'];
	}

	if ($_SESSION['item_diseases'] == '') {
		$obj_model = $this->load_model('item_diseases');
		$item_diseases = $obj_model->execute("SELECT", false, "", "item_diseases.status='Active'", "sort_order asc");
		$_SESSION['item_diseases'] = $item_diseases;
	} else {
		$item_diseases = $_SESSION['item_diseases'];
	}
?>


	<input type="hidden" name="cityUrl" id="cityUrl" value="<?= $_SESSION['citySlug'] ?>">
	
	<header class="nav-bg-b main-header navfix menu-dark" style="top:0;display: block !important;"> <!-- fixed-top class removed -->
	<div class="container-fluid" style="padding-left: 0px !important;padding-right: 0px !important;">
	<div class="header-top">
		<div class="container-fluid">
			<div class="top-nav">
				<ul class="nav-left">

					<li>
						<p style="margin: 0;"><a href="#" class="text-white">Download App</a></p>
					</li>
					<li>
						<div class="d-flex align-items-center">
							<a href="https://play.google.com/store/apps/details?id=com.mdrcindia.booking" target="_blank">
								<img alt="" class="lazy" src="images/android.png" style="max-width:80px">
							</a>
							<a href="https://apps.apple.com/us/app/modern-diagnostic-health-app/id6504657715" target="_blank">
								<img alt="" class="ms-2 lazy" src="images/apple.png" style="max-width:80px">
							</a>
						</div>
					</li>
				</ul>
				<ul class=" nav-right">
					<li>
						<div id="google_translate_element"></div>
						<script type="text/javascript">
							function googleTranslateElementInit() {
								new google.translate.TranslateElement({
									pageLanguage: 'en',
									includedLanguages: 'hi,gu,bn,te,ta,ur,en,kn,mr,ml,as,pa',
								}, 'google_translate_element');
							}
						</script>
						<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
					</li>
				</ul>
			</div>

		</div>
	</div>
	</div>

		<div class="container-fluid">
			<div class="row">
				<div class="menu-header menu-header2">
					<div class="dsk-logo">
						<a class="nav-brand" href="<?= SERVER_ROOT; ?>">
							<img src="images/logo.webp" alt="MDRC" class="mega-white-logo" />
							<img src="images/logo.webp" alt="MDRC" class="mega-darks-logo" />
						</a>
						<a class="cities-anchor" data-bs-toggle="modal" data-bs-target="#modal-cities">
							<div class="">
								<img src="images/icon-location.png" alt="location" />
								<span>
									<?= $_SESSION['cityName'] ?>
								</span>
								<img src="images/icon-red-arrow.png" alt="select location" />
							</div>
						</a>
						<form class="d-inline-block position-relative serchFormi" name="searchForm" id="searchForm" method="post" action="">
							<input class="searchInput required searchKeyword" type="text" id="searchInput" autocomplete="off" placeholder="Search for a Test, Nearest Centres" />
							<button class="searSubmit" type="submit"><img src="images/icon-red-search.png" alt="search location" /></button>
						</form>

					</div>

					<div class="custom-nav" role="navigation">
						<?php if ($_SESSION['cityCertificateImage'] != '') { ?>
							<div class="head-certificates">
								<img src="<?= $_SESSION['SERVER_ROOT']; ?>/uploads/city/<?= $_SESSION['cityCertificateImage']; ?>" alt="Certificates">
							</div>
						<?php } ?>
						<ul class="nav-list onepge">
							<li class="contact-show second"><a href="cart" class=""><img src="images/icon-cart.png" alt="cart" /> Cart <span class="cartCount">
										<?= count($this->rs_cartmini) ?>
									</span></a>
							</li>
							<?php if ($_SESSION['MDRCCustID'] <= 0) { ?>
								<li class="contact-show">
									<a data-bs-toggle="offcanvas" href="#offcanvasExample-login" class=""><img src="images/icon-profile.png" alt="profile" /> Login / Register</a>
								</li>
							<?php } else { ?>
								<li>
									<div class="dropdown prof-drop">
										<button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
											<img src="images/icon-profile.png" alt="profile" /> <span class="PFName">Hi,
												<?= $_SESSION['MDRCCustFirstName'] ?>
											</span> <i class="fas fa-chevron-down ms-2"></i>
										</button>
										<ul class="dropdown-menu">
											<li><a class="dropdown-item" href="my-profile">Personal Information <i class="fas fa-chevron-right"></i></a></li>
											<li><a class="dropdown-item" href="my-orders">My Orders <i class="fas fa-chevron-right"></i></a></li>
											<li><a class="dropdown-item" href="my-family-friends">My Family & Friends <i class="fas fa-chevron-right"></i></a></li>
											<li style="display:none"><a class="dropdown-item" href="my-addresses">My Addresses
													<i class="fas fa-chevron-right"></i></a></li>
											<li><a class="dropdown-item" href="mdrc-test-booking-enquiry">Upload Prescription <i class="fas fa-chevron-right"></i></a></li>
											<li><a class="dropdown-item" href="my-wallet">My Wallet <i class="fas fa-chevron-right"></i></a></li>
											<li><a class="dropdown-item" href="help-support">Help & Support <i class="fas fa-chevron-right"></i></a></li>
											<li><a class="dropdown-item" href="logout">Logout <i class="fas fa-chevron-right"></i></a></li>
										</ul>
									</div>
								</li>
							<?php } ?>

							<li class="hidemobile"><a href="tel:<?php echo !empty($_SESSION['cityPhone']) ? $_SESSION['cityPhone'] : '+91-124-6712000'; ?>">
									<div class="call-new-icon"><i class="fas fa-phone-alt"></i></div>
									<!-- <img src="images/call-mobile-header.png" alt="Call" style="width:33px" /> -->
								</a></li>

							<li class="call-text" style="margin-left:10px">
								<a href="tel:<?php echo !empty($_SESSION['cityPhone']) ? $_SESSION['cityPhone'] : '+91-124-6712000'; ?>" class="">CALL US <br /><span>
										<?php echo !empty($_SESSION['cityPhone']) ? $_SESSION['cityPhone'] : '+91-124-6712000'; ?>
									</span></a>
							</li>
						</ul>
					</div>
				</div>
				<div class="menu-header cusnav">
					<nav class="navbar navbar-expand-md ">
						<div class="container-fluid p-0">
							<button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
								<span class="navbar-toggler-icon"></span>
							</button>
							<a class="navbar-brand d-block d-lg-none d-md-none me-auto" href="<?= SERVER_ROOT; ?>"><img src="images/logo.webp" alt="MDRC" class=""></a>
							<ul class="nav-list d-block d-lg-none d-md-none onepge">
								<li class="contact-show second"><a href="cart" class=""><img src="images/icon-cart.png" alt="cart" /> <span class="cartCount">
											<?= count($this->rs_cartmini) ?>
										</span></a>
								</li>
								<?php if ($_SESSION['MDRCCustID'] <= 0) { ?>
									<li class="contact-show">
										<a data-bs-toggle="offcanvas" href="#offcanvasExample-login" class=""><img src="images/icon-profile.png" alt="profile" /></a>
									</li>
								<?php } else { ?>
									<li>
										<div class="dropdown prof-drop">
											<button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
												<img src="images/icon-profile.png" alt="profile" /> <i class="fas fa-chevron-down ms-1"></i>
											</button>
											<ul class="dropdown-menu">
												<li><span class="uname text-blue">Hi,
														<?= $_SESSION['MDRCCustFirstName'] ?>
													</span></li>
												<li><a class="dropdown-item" href="my-profile">Personal Information <i class="fas fa-chevron-right"></i></a></li>
												<li><a class="dropdown-item" href="my-orders">My Orders <i class="fas fa-chevron-right"></i></a></li>
												<li><a class="dropdown-item" href="my-family-friends">My Family & Friends <i class="fas fa-chevron-right"></i></a></li>
												<li style="display:none"><a class="dropdown-item" href="my-addresses">My Addresses <i class="fas fa-chevron-right"></i></a></li>
												<li><a class="dropdown-item" href="my-prescription">My Priscription <i class="fas fa-chevron-right"></i></a></li>
												<li><a class="dropdown-item" href="my-wallet">My Wallet <i class="fas fa-chevron-right"></i></a></li>
												<li><a class="dropdown-item" href="help-support">Help & Support <i class="fas fa-chevron-right"></i></a></li>
												<li><a class="dropdown-item" href="logout">Logout <i class="fas fa-chevron-right"></i></a></li>
											</ul>
										</div>
									</li>
								<?php } ?>



								<li class="contact-show">
									<a href="tel:+91-124-6712000" class=""><img src="images/call-mobile-header.png" alt="Call" /></a>
								</li>
							</ul>
							<div class="d-flex mobsearchbar d-lg-none d-md-none">
								<a class="cities-anchor" data-bs-toggle="modal" data-bs-target="#modal-cities">
									<div class="">
										<img src="images/icon-location.png" alt="Location" />
										<span>
											<?= $_SESSION['cityName'] ?>
										</span>
										<img src="images/icon-red-arrow.png" alt="Select Location" />
									</div>
								</a>
								<form class="d-inline-block position-relative serchFormi " name="searchMobileForm" id="searchMobileForm" method="post" action="">
									<input class="searchInput required searchMobileKeyword" id="searchMobileInput" autocomplete="off" type="text" placeholder="Search for a Test, Nearest Centres" />
									<button class="searSubmit" type="submit"><img src="images/icon-red-search.png" alt="Select Location" /></button>
								</form>
								<!-- <form class="d-inline-block position-relative serchFormi" name="searchForm" id="searchForm" method="post" action="">
						<input class="searchInput required searchKeyword" type="text" id="searchInput" autocomplete="off" placeholder="Search for a Test, Nearest Centres" />
						<button class="searSubmit" type="submit"><img src="images/icon-red-search.png" alt="" /></button>
					</form> -->
							</div>
							<div class="collapse navbar-collapse" id="mynavbar">
								<ul class="navbar-nav ml-auto">
									<li class="nav-item"><a href="<?= SERVER_ROOT; ?>" class="nav-link">
											<i class="fas fa-home"></i>
										</a></li>
									<!-- new link -->
									<li class="nav-item dropdown">
										<a href="#" class="nav-link dropdown-toggle">About Us</a>
										<ul class="dropdown-menu main-menu" aria-labelledby="navbarDropdown">
											<li class="nav-item dropdown">
												<div class="d-flex">
													<a href="about-us" class="nav-link ps-3 pe-2">About Us</a>
												</div>
											</li>
											<li class="nav-item dropdown"><a class="nav-link dropdown-toggle">For Doctors </a>
												<ul class="dropdown-menu sub-menu" aria-labelledby="navbarDropdown">
													<li><a class="dropdown-item" href="modern-lab">Modern Lab</a> </li>
													<li><a class="dropdown-item" href="modern-imaging"> Modern Imaging</a></li>
													<li><a class="dropdown-item" href="super-specialised-services">Super Specialised Services</a> </li>
												</ul>
											</li>
											<li class="nav-item dropdown"><a class="nav-link dropdown-toggle">For Patients </a>
												<ul class="dropdown-menu sub-menu" aria-labelledby="navbarDropdown">
													<li><a class="dropdown-item" href="our-doctors"> Our Doctors </a> </li>
													<li><a class="dropdown-item" href="imaging-test-information">Imaging Test Information </a></li>
													<li><a class="dropdown-item" href="pathology-lab-information"> Pathology Lab Test Information </a> </li>
													<li><a class="dropdown-item" href="home-sample-collection/<?= $_SESSION['citySlug']; ?>"> Home Sample Collection </a></li>
												</ul>
											</li>
											<li class="nav-item dropdown">
												<div class="d-flex">
													<a class="dropdown-item" href="/our-milestones">Our Milestones</a> 
												</div>
											</li>
											
										</ul>
									</li>


									
									<!-- new link -->
									<li class="nav-item dropdown mob-viewmega">
										<a class="nav-link dropdown-toggle" href="radiology/imaging-lab-tests-near/<?= $_SESSION['citySlug']; ?>" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
											Book Your Blood Test
										</a>
										<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
											<li><a class="dropdown-item" href="pathology/lab-blood-test-near/<?= $_SESSION['citySlug']; ?>">Popular Packages </a> </li>
											<li><a class="dropdown-item" href="pathology/lab-blood-test-near/<?= $_SESSION['citySlug']; ?>">Popular Tests </a></li>
											<li><a class="dropdown-item" href="pathology/lab-blood-test-near/<?= $_SESSION['citySlug']; ?>">Health Risk</a></li>
											<li><a class="dropdown-item" href="pathology/lab-blood-test-near/<?= $_SESSION['citySlug']; ?>">Categories</a></li>
											<li><a class="dropdown-item" href="premium-health-checkup/<?= $_SESSION['citySlug']; ?>">Premium Test</a></li>
										</ul>
									</li>
									<li class="nav-item dropdown mob-viewmega">
										<a class="nav-link dropdown-toggle" href="for-patients" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
											Book Your Scan
										</a>
										<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
											<li><a class="dropdown-item" href="our-doctors">Popular Packages</a> </li>
										</ul>
									</li>
									<li class="nav-item dropdown  position-static des-viewmega">
										<a class="nav-link dropdown-toggle-cust" href="pathology/lab-blood-test-near/<?= $_SESSION['citySlug']; ?>" aria-expanded="false">Book Your Blood Test </a>
										<div class="dropdown-menu w-100 mt-0 p-0" aria-labelledby="navbarDropdown">
											<div style="height: 350px;" class="">
												<ul class="menu main-megadrop" aria-labelledby="navbarDropdownMenuLink" style="background: rgb(238, 238, 238);height: 350px;">
													<li class="menu-li">
														<!-- href="popular-packages/<?= $_SESSION['citySlug']; ?>" -->
														<a class="dropdown-itemnew w-100 d-flex justify-content-between align-items-center" href="javascript:void(0);">Popular Packages <i class="fas fa-chevron-right"></i></a>
														<div class="megadrop" style="background-color: #fff;">
															<div class="main-mega-menu">
																<ul>
																	<?php
																	$j = 0;
																	foreach ($items as $test) {
																		$testCats = explode(',', $test['item_other_data_item_department_ids']);
																		if (count($testCats) > 0 && in_array('2', $testCats) && $test['set_at_popular_package'] == 'Yes') {
																			if ($j > 30) {
																				break;
																			}
																	?>
																			<li class="ht-inner-sub">
																				<a href="tests/<?= $test['slug']; ?>/<?= $_SESSION['citySlug']; ?>"><?= $test['name']; ?></a>
																			</li>
																	<?php $j++;
																		}
																	} ?>
																</ul>

															</div>
														</div>
													</li>
													<li class="menu-li">
														<!-- href="popular-tests/<?= $_SESSION['citySlug']; ?>" -->
														<a class="dropdown-itemnew w-100 d-flex justify-content-between align-items-center" href="javascript:void(0);">Popular Tests <i class="fas fa-chevron-right"></i></a>
														<div class="megadrop">
															<div class="main-mega-menu">
																<ul>
																	<?php
																	$j = 0;
																	foreach ($items as $test) {
																		$testCats = explode(',', $test['item_other_data_item_department_ids']);
																		if (count($testCats) > 0 && in_array('2', $testCats) && $test['set_at_popular_test'] == 'Yes') {
																			if ($j > 30) {
																				break;
																			}
																	?>
																			<li class="ht-inner-sub">
																				<a href="tests/<?= $test['slug']; ?>/<?= $_SESSION['citySlug']; ?>"><?= $test['name']; ?></a>
																			</li>
																	<?php $j++;
																		}
																	} ?>
																</ul>
															</div>
														</div>
													</li>
													<li class="menu-li">
														<a class="dropdown-itemnew w-100 d-flex justify-content-between align-items-center" href="health-risk/<?= $_SESSION['citySlug']; ?>">Health Risk <i class="fas fa-chevron-right"></i></a>
														<div class="megadrop">
															<div class="main-mega-menu">
																<ul>
																	<?php
																	$j = 0;
																	foreach ($item_diseases as $item) {
																		$Cats = explode(',', $item['item_department_ids']);
																		if (count($Cats) > 0 && in_array('2', $Cats)) {
																			if ($j > 30) {
																				break;
																			}
																	?>
																			<li class="ht-inner-sub">
																				<a href="diseases/<?= $_SESSION['citySlug']; ?>/<?= $item['slug']; ?>"><?= $item['name']; ?></a>
																			</li>
																	<?php $j++;
																		}
																	} ?>
																</ul>
															</div>
														</div>
													</li>
													<li class="menu-li">
														<a class="dropdown-itemnew w-100 d-flex justify-content-between align-items-center" href="categories/<?= $_SESSION['citySlug']; ?>">Categories <i class="fas fa-chevron-right"></i></a>
														<div class="megadrop">
															<div class="main-mega-menu">
																<ul>
																	<?php
																	$j = 0;
																	foreach ($item_category as $item) {
																		$Cats = explode(',', $item['item_department_ids']);
																		if (count($Cats) > 0 && in_array('2', $Cats)) {
																			if ($j > 30) {
																				break;
																			}
																	?>
																			<li class="ht-inner-sub">
																				<a href="category/<?= $_SESSION['citySlug']; ?>/<?= $item['slug']; ?>"><?= $item['name']; ?></a>
																			</li>
																	<?php $j++;
																		}
																	} ?>
																</ul>
															</div>
														</div>
													</li>
													<li class="menu-li">
														<a class="dropdown-itemnew w-100 d-flex justify-content-between align-items-center" href="premium-health-checkup/<?= $_SESSION['citySlug']; ?>">Premium Test <i class="fas fa-chevron-right"></i></a>
														<div class="megadrop">
															<div class="main-mega-menu">
																<ul>
																	<?php
																	$j = 0;
																	foreach ($items as $test) {
																		$Cats = explode(',', $item['item_department_ids']);
																		if ($test['set_at_popular_package'] == 'Yes' && in_array('2', $Cats)) {
																			if ($j > 30) {
																				break;
																			}
																	?>
																			<li class="ht-inner-sub">
																				<a href="tests/<?= $test['slug']; ?>/<?= $_SESSION['citySlug']; ?>"><?= $test['name']; ?></a>
																			</li>
																	<?php $j++;
																		}
																	} ?>
																</ul>
															</div>
														</div>
													</li>
												</ul>
											</div>
										</div>
									</li>
									<li class="nav-item dropdown  position-static des-viewmega">
										<a class="nav-link dropdown-toggle-cust" href="radiology/imaging-lab-tests-near/<?= $_SESSION['citySlug']; ?>" id="navbarDropdown" aria-expanded="false">
											Book Your Scan
										</a>
										<div class="dropdown-menu w-100 mt-0 p-0" aria-labelledby="navbarDropdown">
											<div style="" class="">
												<div class="row megamenu-h">
													<div class="col-md-3 col-lg-3 main-megadrop">
														<ul class="menu " aria-labelledby="navbarDropdownMenuLink">
															<?php
															$i = 0;
															foreach ($item_category as $item) {
																$Cats = explode(',', $item['item_department_ids']);
																if (count($Cats) > 0 && in_array('1', $Cats)) {
																	if ($i > 10) {
																		break;
																	}
															?>
																	<li>
																		<a class="dropdown-itemnew w-100 d-flex justify-content-between align-items-center" href="category/<?= $_SESSION['citySlug']; ?>/<?= $item['slug']; ?>"><?= $item['name']; ?> <i class="fas fa-chevron-right"></i></a>
																		<div class="megadrop">
																			<div class="main-mega-menu">
																				<ul>
																					<?php
																					$j = 0;
																					foreach ($items as $test) {
																						$testCats = explode(',', $test['item_other_data_item_category_ids']);
																						if (count($testCats) > 0 && in_array($item['id'], $testCats)) {
																							if ($j > 30) {
																								break;
																							}
																					?>
																							<li class="ht-inner-sub">
																								<a href="tests/<?= $test['slug']; ?>/<?= $_SESSION['citySlug']; ?>"><?= $test['name']; ?></a>
																							</li>
																					<?php $j++;
																						}
																					} ?>
																				</ul>
																			</div>
																		</div>
																	</li>
															<?php
																	$i++;
																}
															}
															?>
														</ul>
													</div>
												</div>
											</div>
										</div>
									</li>

									<li class="nav-item"><a href="premium-health-checkup/<?= $_SESSION['citySlug']; ?>" class="nav-link">Full Body Checkup</a></li>

									<li class="nav-item dropdown">
										<a href="#" class="nav-link dropdown-toggle">Investor Relation</a>
										<ul class="dropdown-menu main-menu" aria-labelledby="navbarDropdown">
											<li class="nav-item dropdown">
												<div class="d-flex">
													<a href="ipo" class="nav-link ps-3 pe-2">IPO / Offer Documents</a>
												</div>
											</li>
											<li class="nav-item dropdown">
												<div class="d-flex">
													<a class="dropdown-item" href="policies">Policies</a> 
												</div>
											</li>
										</ul>
									</li>
									
									<li class="nav-item dropdown">
										<a class="nav-link dropdown-toggle" href="reach-us" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
											Contact Us
										</a>
										<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
											<li> <a class="dropdown-item" href="reach-us">Reach us</a> </li>
											<li> <a class="dropdown-item" href="mdrc-test-booking-enquiry">Book a test</a> </li>
											<li> <a class="dropdown-item" href="news-and-events">News and Events</a> </li>
											<li> <a class="dropdown-item" href="gallery">Gallery</a> </li>
											<li> <a class="dropdown-item" href="career">Career</a> </li>
											<li> <a class="dropdown-item" href="blog">Blogs</a> </li>
											<li> <a class="dropdown-item" href="/corporate-tieup">Corporate Tieup</a> </li>
										</ul>
									</li>
								</ul>
							</div>
						</div>
					</nav>
				</div>
			</div>
		</div>
	</header>
	<!--Start sidebar -->
	<div class="niwaxofcanvas offcanvas offcanvas-end otverify" tabindex="-1" id="offcanvasExample-otpverify">
		<div class="offcanvas-body">
			<div class="cbtn animation">
				<div class="btnclose"> <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button></div>
			</div>
			<div class="form-block sidebarform ">
				<h5 class="pt-3 pb-0">Verify OTP</h5>
				<p class="subhead">Please enter 4-digit OTP Sent to <br /><strong class="text-dark signup_login_phone"></strong></p>
				<form id="otp_popup_form" name="otp_popup_form" method="post" data-bs-toggle="validator" class="sidebarForm shake mt40">
					<input type="hidden" class="" id="action_type" name="action_type" value="otp">
					<div class="row">
						<div class="form-group col-sm-12 mb-2">
							<label>Enter OTP</label>
							<input type="text" id="otpch1" name="otpch1" maxlength="4" minlength="4" class="required number numbers" placeholder="" data-error="">
							<div class="help-block with-errors"></div>
							<!-- <div class="col-12 p-0  mb-2 pb-1 text-end">
				  <a class="text-blue cotp " href="#">Clear OTP</a>
					</div> -->
							<div class="col-12 p-0 text-end mb-2 pb-1">
								<span class="drecive d-inline-block">
									<button type="button" class="" id="resend_otp_p" style="border:none;background:none">Resend OTP</button></span>
								<a class="text-blue timi" id="claim_counter"></a>
							</div>
						</div>
					</div>
					<button type="submit" id="otppopup_submit" class="btn lnk btn-main bg-btn">Verify OTP <span class="circle"></span></button>
					<div id="invalid_otp" class="mt-3"></div>
					<div class="clearfix"></div>
					<!-- <div class="col-12 p-0 mt-4">
			<span class="drecive float-start">Did not receive the code?</span>
			 <a class="text-blue float-start timi">00:25</a>
			<a class="text-blue float-end reotop" href="#">Re-Send OTP</a>
			   </div> -->
				</form>
			</div>
		</div>
	</div>
	<div class="niwaxofcanvas offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample-login">
		<div class="offcanvas-body">
			<div class="cbtn animation">
				<div class="btnclose"> <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button></div>
			</div>
			<div class="form-block sidebarform ">
				<h5 class="pt-3 pb-0">Login/Sign Up</h5>
				<p class="subhead">Please Enter Your Phone Number to Proceed</p>
				<form id="signin_popup_form" name="signin_popup_form" method="post" data-bs-toggle="validator" class="sidebarForm shake mt40" autocomplete="off">
					<input type="hidden" class="" id="action_type" name="action_type" value="login">
					<div class="row">
						<div class="form-group col-sm-12">
							<label>Phone Number</label>
							<input type="text" id="phone" name="phone" placeholder="Enter Phone Number" class="login_f_data required number numbers" maxlength="10" minlength="10" required data-error="Please fill Out" autocomplete="off">
							<div class="help-block with-errors"></div>
						</div>
					</div>
					<!-- <a class="btn lnk btn-main bg-btn w-100" data-bs-toggle="offcanvas" href="#offcanvasExample-otpverify">Login <span class="circle"></span></a>-->
					<button type="submit" id="loginpopup_submit" class="btn lnk btn-main bg-btn w-100 login-btn">Login <span class="circle"></span></button>
					<div id="invalid_login" class="mt-3"></div>
					<div class="clearfix"></div>
					<div class="col-12 p-0 mt-3 text-center" style="display:none">
						<span class="almember">Don't have an account? <a class="text-blue" data-bs-toggle="offcanvas" href="#offcanvasExample-signup">Sign Up</a></span>
					</div>
					<div class="col-12 p-0 mt-3 text-center slidi">
						<div class="owl-carousel testimonial-card-a pl25">
							<div class="testimonial-card">
								<div class="t-text">
									<img src="images/slide-3.png" alt="Banner" />
									<h4>Digital Report Bank</h4>
									<p>Access speedy reports from everywhere and anywhere.</p>
								</div>
							</div>
							<!--<div class="testimonial-card">
				  <div class="t-text">
					<img src="images/slide-2.png" />
					<h4>Free Call Consultationg</h4>
					<p>Have a doubt? Clear it out.</p>
				  </div>
				</div>-->
							<div class="testimonial-card">
								<div class="t-text">
									<img src="images/slide-1.png" alt="Banner" />
									<h4>Free Home Sample Pick-up</h4>
									<p>Care at your Convenience. Get tested from the comfort of your home.</p>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>


	<div class="niwaxofcanvas offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample-signup">
		<div class="offcanvas-body">
			<div class="cbtn animation">
				<div class="btnclose"> <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button></div>
			</div>
			<div class="form-block sidebarform ">
				<h5 class="pt-3 pb-0">Profile</h5>
				<p class="subhead">Please Enter Your details</p>
				<form id="profile_popup_form" name="profile_popup_form" method="post" data-bs-toggle="validator" class="shake mt40" autocomplete="off">
					<div class=" step-info p-3">
						<div class="row">
							<div class="form-group col-sm-12">
								<label>First Name*</label>
							</div>
							<div class="form-group col-sm-12">
								<input type="text" name="name" id="name" value="<?= $this->rs_customer['name'] ?>" placeholder="" required data-error="Please fill Out">
								<div class="help-block with-errors"></div>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-sm-12">
								<label>Last Name*</label>
							</div>
							<div class="form-group col-sm-12">
								<input type="text" name="last_name" value="<?= $this->rs_customer['last_name'] ?>" id="last_name" placeholder="" required data-error="Please fill Out">
								<div class="help-block with-errors"></div>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-sm-12">
								<label>Email</label>
							</div>
							<div class="form-group col-sm-12">
								<input type="text" name="email" id="email" value="<?= $this->rs_customer['email'] ?>" placeholder="" data-error="Please fill Out">
								<div class="help-block with-errors"></div>
							</div>
						</div>

						<div class="row">
							<div class="form-group col-sm-12">
								<label>Mobile No.*</label>
							</div>
							<div class="form-group col-sm-12">
								<input type="text" disabled value="<?= $this->rs_customer['phone'] ?>" placeholder="" data-error="Please fill Out">
								<div class="help-block with-errors"></div>
							</div>
						</div>
						<button type="submit" id="profile_popup_btn" class="btn lnk btn-main bg-btn mt-2">Save Details <span class="circle"></span></button>
						<div id="msgSubmit" class="h3 text-center hidden"></div>
						<div class="clearfix"></div>
					</div>


				</form>
			</div>
		</div>
	</div>

	<!--end sidebar -->
	<div class="niwaxofcanvas offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample-download">
		<div class="offcanvas-body">
			<div class="cbtn animation">
				<div class="btnclose"> <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button></div>
			</div>
			<div class="form-block sidebarform ">
				<h5 class="pt-3 pb-0">Download Reports</h5>
				<p class="subhead">View your test reports</p>
				<form id="download_test_report" name="download_test_report" method="post" data-bs-toggle="validator" class="sidebarForm shake mt40" autocomplete="off">
					<div class="row">
						<div class="form-group col-sm-12">
							<label>Lab/Visit ID</label>
							<input type="text" placeholder="" class="required" name="visitor_id" id="visitor_id" required data-error="Please fill Out" autocomplete="off">
							<div class="help-block with-errors"></div>
						</div>
						<div class="form-group col-sm-12">
							<label>Password</label>
							<input type="text" placeholder="" class="required" name="lab_password" id="lab_password" required data-error="Please fill Out" autocomplete="off">
							<div class="help-block with-errors"></div>
						</div>
					</div>
					<button type="submit" id="download_report_submit" class="btn lnk btn-main bg-btn w-100 login-btn">Check
						Report <span class="circle"></span></button>
				</form>
				<div id="no_report_found" class="mt-3"></div>
				<div class="clearfix"></div>
				<div class="col-12 p-0 mt-4 text-center slidi">
					<div class="col-12 ">
						<div class="t-text">
							<img src="images/slide-3.png" alt="Banner" />
							<h4>Digital Report Bank</h4>
							<p>Access speedy reports from everywhere and anywhere.</p>
						</div>
					</div>
				</div>
				<div class="col-12 p-0 mt-5 pt-3 text-center">
					<a class="text-blue text-bold" href="http://182.72.101.236/mdrcnew/design/onlinelab/" target="_blank">Download Report Client</a>
				</div>

			</div>
		</div>
	</div>



	<!--End Header -->
<?php } ?>



<script>
	document.addEventListener("DOMContentLoaded", function() {
		var dropdowns = document.querySelectorAll(".dropdown-menu");

		dropdowns.forEach(function(dropdown) {
			var menuItems = dropdown.querySelectorAll(".menu > li");

			if (menuItems.length > 0) {
				menuItems[0].classList.add("active");
			}

			menuItems.forEach(function(item, index) {
				// Handle mouseenter event
				item.addEventListener("mouseenter", function() {
					menuItems.forEach(function(menuItem) {
						menuItem.classList.remove("active");
					});
					item.classList.add("active");
				});


				// Handle click event on other menu items
				item.addEventListener("click", function() {
					menuItems.forEach(function(menuItem) {
						menuItem.classList.remove("active");
					});
					item.classList.add("active");
				});
			});
		});
	});
</script>