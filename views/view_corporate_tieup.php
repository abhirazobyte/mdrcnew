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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
<link href="css/custom.css" rel="stylesheet">
<!--Start Header -->
<?php include 'includes/header.php'; ?>
<!--End Header -->
<style>
	:root {
		--color-sky: #eaf9ff;
		--color-white: #fff;
		--color-bluesky: #1160a5;
		--color-black: #000;
	}

	.bg-white {
		background-color: var(--color-white) !important;
	}

	.bg-sky {
		background-color: var(--color-sky) !important;
	}

	.healthcare-solutions .heading h2 {
		font-size: 25px;
		font-weight: 600;
		line-height: 1.4;
	}

	.healthcare-solutions .heading h3 {
		font-size: 18px;
		font-weight: 500;
		line-height: 1.4;
		margin-top: 10px;
	}

	.healthcare-solutions .heading p {
		font-size: 16px;
		font-weight: 400;
		line-height: 1.6;
		color: var(--color-black) !important;
		margin-top: 10px;
	}

	.healthcare-solutions .heading i {
		font-size: 24px;
		font-weight: 900;
	}

	.healthcare-solutions .heading ul {
		margin-top: 10px;
	}

	.healthcare-solutions .heading .list-text {
		font-size: 16px;
		font-weight: 400;
		margin-top: 10px;
	}

	@media (max-width: 767.98px) {
		.healthcare-solutions .heading h2 {
			font-size: 20px;
		}

		.healthcare-solutions .heading h3 {
			font-size: 16px;
		}

		.healthcare-solutions .heading p,
		.healthcare-solutions .list-text {
			font-size: 14px;
		}

		.healthcare-solutions img {
			width: 100%;
			height: auto;
			margin-bottom: 20px;
		}

		.healthcare-solutions .row {
			margin-bottom: 30px;
		}
	}

	.enquire-now-container .enquiry-form {
		background: linear-gradient(to bottom,
				#1160a5 0%,
				#1476b6 40%,
				#189ed3 100%);
	}

	.enquire-now-container .enquiry-form .enquiry-btn {
		border-radius: 4px !important;
		color: var(--color-bluesky);
		background: var(--color-white);
	}

	.prioritizing-img img {
		border-radius: 0 0 0 64px !important;
		box-shadow: none !important;
	}

	.prioritizing-container .row {
		position: relative;
		display: flex;
		flex-wrap: wrap;
		align-items: center;
	}

	.prioritizing-container .content {
		background-color: white !important;
		padding: 20px;
		border-radius: 8px;
		position: relative;
		right: 0;
		box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
		margin-top: 20px;
		flex: 1;
		border-bottom: 10px solid var(--color-bluesky);
		border-bottom-left-radius: 20px;
		border-bottom-right-radius: 40px;
	}

	@media (min-width: 992px) {
		.prioritizing-container .row {
			flex-direction: row;
			justify-content: space-between;
		}

		.prioritizing-container .content {
			max-width: 700px;
			margin-left: 0;
			margin-right: 0;
			position: relative;
			right: 100px;
		}

		.prioritizing-container .image-block img {
			width: 100%;
			border-radius: 0 0 0 64px !important;
		}
	}

	@media (max-width: 767px) {
		.prioritizing-container .row {
			flex-direction: column;
			align-items: center;
			justify-content: center;
		}

		.prioritizing-container .content {
			margin-top: 20px;
			width: 90%;
			max-width: 700px;
			text-align: center;
			margin-left: auto;
			margin-right: auto;
			margin-top: 30px;
		}

		.prioritizing-container .image-block img {
			width: 100%;
			border-radius: 0 0 0 64px !important;
		}
	}
</style>


<!-- hero-main-section - start -->
<section class="container-fluid">
	<div class="row">
		<div class="col-12 px-0 d-none d-md-block">
			<img data-src="images/corporate-tieus/banner.jpg" alt="Corporate health Tie-ups" class="img-fluid lazy w-100" />
		</div>
		<div class="col-12 px-0 d-block d-md-none">
			<img data-src="images/corporate-tieus/banner-2.jpg" alt="Corporate health Tie-ups" class="img-fluid lazy w-100" />
		</div>
	</div>
</section>
<!-- hero-main-section - end -->

<!-- prioritizing-employee - start  -->
<section class="about-agencys prioritizing-container pad-tb block-1 dark-bg3">
	<div class="container">
		<div class="row justify-content-between relative">
			<div class="col-lg-6">
				<div class="image-block prioritizing-img mb0 m-mt30">
					<img data-src="images/corporate-tieus/prioritizing-employee.png" alt="Prioritizing Employee"
						class="img-fluid lazy" />
				</div>
			</div>

			<div class="col-lg-6 v-center">
				<div class="common-heading text-l content bg-white">
					<h2 class="mb20">Prioritizing Employee Well-being</h2>
					<p>
						In today’s fast-paced corporate world, employee health plays a
						vital role in organizational success. A healthy workforce leads
						to enhanced productivity, reduced absenteeism, and a positive
						work environment. Our corporate healthcare tie-up services
						provide comprehensive health and wellness solutions tailored to
						meet the needs of your employees. We partner with businesses to
						create customized healthcare packages that focus on preventive
						care, early diagnosis, and overall well-being. Whether you’re a
						small enterprise or a large corporation, our flexible healthcare
						programs ensure easy access to quality medical care.
					</p>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- prioritizing-employee - end  -->

<!-- Our-Healthcare-Solutions-section - start -->
<section class="pt40 pb40 bg-sky">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-12">
				<div class="row section-title text-center">
					<div class="col-12">
						<div class="common-heading-5">
							<h1 class="fs-3 text-202024 fw-bold">
								Our Healthcare Solutions for Corporates
							</h1>
							<h2 class="mb20 head-2">
								We offer a diverse range of medical and wellness services
								designed to support employee health and improve workplace
								efficiency
							</h2>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="pt30 pb30 streamline healthcare-solutions">
		<div class="container">
			<!-- First  -->
			<div class="row align-items-center mb-5">
				<div class="col-lg-6 col-md-6 col-12 mb-4 mb-md-0">
					<img data-src="images/corporate-tieus/Pre-emp-health-checkups.png" alt="Pre-Employment Health Checkups"
						src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR4nGNgYAAAAAMAASsJTYQAAAAASUVORK5CYII="
						class="img-fluid lazy" />
				</div>
				<div class="col-lg-6 col-md-6 col-12">
					<div class="heading text-start">
						<h2>Pre-Employment Health Checkups</h2>
						<h3 class="mt10">
							Ensure a Healthy Workforce with Pre-Employment Medical
							Screenings
						</h3>
						<p>
							Hiring the right talent goes beyond skills it’s also about
							ensuring they are medically fit for the job. Our
							pre-employment medical screenings help you make informed
							hiring decisions by identifying any underlying health issues
							early on.
						</p>
						<ul class="list-unstyled">
							<li class="d-flex align-items-start mb-2">
								<i class="bi bi-check2-circle text-primary me-2 mt-1"></i>
								<span class="list-text">Confirms the medical fitness of potential employees</span>
							</li>
							<li class="d-flex align-items-start mb-2">
								<i class="bi bi-check2-circle text-primary me-2 mt-1"></i>
								<span class="list-text">Identifies existing or underlying health conditions</span>
							</li>
							<li class="d-flex align-items-start mb-2">
								<i class="bi bi-check2-circle text-primary me-2 mt-1"></i>
								<span class="list-text">Reduces future workplace health risks and
									absenteeism</span>
							</li>
							<li class="d-flex align-items-start mb-2">
								<i class="bi bi-check2-circle text-primary me-2 mt-1"></i>
								<span class="list-text">Enhances overall workplace safety and productivity</span>
							</li>
							<li class="d-flex align-items-start mb-2">
								<i class="bi bi-check2-circle text-primary me-2 mt-1"></i>
								<span class="list-text">Ensures compliance with company and industry health
									standards</span>
							</li>
						</ul>
					</div>
				</div>
			</div>

			<!-- second -->
			<div class="row align-items-center flex-column-reverse flex-md-row mb-5">
				<div class="col-lg-6 col-md-6 col-12">
					<div class="heading text-start">
						<h2>Annual Health Checkups</h2>
						<p class="mt10">
							Regular health monitoring is key to maintaining a healthy
							workforce. Our annual medical examinations include a complete
							assessment of vital health parameters such as
						</p>
						<ul class="list-unstyled">
							<li class="d-flex align-items-start mb-2">
								<i class="bi bi-check2-circle text-primary me-2 mt-1"></i>
								<span class="list-text">Blood tests</span>
							</li>
							<li class="d-flex align-items-start mb-2">
								<i class="bi bi-check2-circle text-primary me-2 mt-1"></i>
								<span class="list-text">Cardiac evaluations</span>
							</li>
							<li class="d-flex align-items-start mb-2">
								<i class="bi bi-check2-circle text-primary me-2 mt-1"></i>
								<span class="list-text">Diabetes screening</span>
							</li>
							<li class="d-flex align-items-start mb-2">
								<i class="bi bi-check2-circle text-primary me-2 mt-1"></i>
								<span class="list-text">Vision and hearing tests</span>
							</li>
							<li class="d-flex align-items-start mb-2">
								<i class="bi bi-check2-circle text-primary me-2 mt-1"></i>
								<span class="list-text">General physical examination</span>
							</li>
						</ul>

						<p class="mt10">
							These periodic assessments help in the early detection of
							illnesses and enable timely medical intervention.
						</p>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-12 mb-4 mb-md-0">
					<img data-src="images/corporate-tieus/annual-health checkups.png"
						src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR4nGNgYAAAAAMAASsJTYQAAAAASUVORK5CYII="
						alt="Pre-Employment Health Checkups" class="img-fluid lazy" />
				</div>
			</div>

			<!-- third  -->
			<div class="row align-items-center mb-5">
				<div class="col-lg-6 col-md-6 col-12 mb-4 mb-md-0">
					<img data-src="images/corporate-tieus/preventive-healthcare-packages.png"
						alt="Pre-Employment Health Checkups"
						src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR4nGNgYAAAAAMAASsJTYQAAAAASUVORK5CYII="
						class="img-fluid lazy" />
				</div>
				<div class="col-lg-6 col-md-6 col-12">
					<div class="heading text-start">
						<h2>Preventive Healthcare Packages</h2>
						<p class="mt10">
							Prevention is better than cure! Our preventive healthcare
							solutions focus on risk detection, lifestyle management, and
							wellness programs. These packages include
						</p>
						<ul class="list-unstyled">
							<li class="d-flex align-items-start mb-2">
								<i class="bi bi-check2-circle text-primary me-2 mt-1"></i>
								<span class="list-text">Health risk assessments</span>
							</li>
							<li class="d-flex align-items-start mb-2">
								<i class="bi bi-check2-circle text-primary me-2 mt-1"></i>
								<span class="list-text">Stress management sessions</span>
							</li>
							<li class="d-flex align-items-start mb-2">
								<i class="bi bi-check2-circle text-primary me-2 mt-1"></i>
								<span class="list-text">Nutritional counseling</span>
							</li>
							<li class="d-flex align-items-start mb-2">
								<i class="bi bi-check2-circle text-primary me-2 mt-1"></i>
								<span class="list-text">Vaccination programs</span>
							</li>
						</ul>
						<p class="mt10">
							By addressing potential health concerns before they become
							serious, we help businesses reduce medical expenses and
							increase employee efficiency.
						</p>
					</div>
				</div>
			</div>

			<!-- four -->
			<div class="row align-items-center flex-column-reverse flex-md-row mb-5">
				<div class="col-lg-6 col-md-6 col-12">
					<div class="heading text-start">
						<h2>On-Site & Off-Site Health Camps</h2>
						<p class="mt10">
							To make healthcare more accessible, we organize
						</p>
						<ul class="list-unstyled">
							<li class="d-flex align-items-start mb-2">
								<i class="bi bi-check2-circle text-primary me-2 mt-1"></i>
								<p class="list-text mt-1">
									<strong>On-Site Health Camps </strong> Medical checkups
									conducted at your office premises.
								</p>
							</li>
							<li class="d-flex align-items-start mb-2">
								<i class="bi bi-check2-circle text-primary me-2 mt-1"></i>
								<p class="list-text mt-1">
									<strong>Off-Site Checkups </strong> Employees can visit
									our healthcare centers for routine examinations.
								</p>
							</li>
						</ul>

						<p class="mt10">
							Our health camps cover general health screenings, eye tests,
							dental checkups, and fitness evaluations, ensuring that
							employees receive medical care without disrupting their work
							schedules.
						</p>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-12 mb-4 mb-md-0">
					<img data-src="images/corporate-tieus/site-health-camps.png" alt="Pre-Employment Health Checkups"
						src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR4nGNgYAAAAAMAASsJTYQAAAAASUVORK5CYII="
						class="img-fluid lazy" />
				</div>
			</div>

			<!-- five  -->
			<div class="row align-items-center mb-5">
				<div class="col-lg-6 col-md-6 col-12 mb-4 mb-md-0">
					<img data-src="images/corporate-tieus/customized-wellness-programs.png" alt="Pre-Employment Health Checkups"
						src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR4nGNgYAAAAAMAASsJTYQAAAAASUVORK5CYII="
						class="img-fluid lazy" />
				</div>
				<div class="col-lg-6 col-md-6 col-12">
					<div class="heading text-start">
						<h2>Customized Wellness Programs</h2>
						<p class="mt10">
							Each workplace is unique, and so are its healthcare
							requirements. We provide tailored wellness solutions based on
							employee needs, including
						</p>
						<ul class="list-unstyled">
							<li class="d-flex align-items-start mb-2">
								<i class="bi bi-check2-circle text-primary me-2 mt-1"></i>
								<span class="list-text">Ergonomic workplace consultations</span>
							</li>
							<li class="d-flex align-items-start mb-2">
								<i class="bi bi-check2-circle text-primary me-2 mt-1"></i>
								<span class="list-text">Mental health counseling</span>
							</li>
							<li class="d-flex align-items-start mb-2">
								<i class="bi bi-check2-circle text-primary me-2 mt-1"></i>
								<span class="list-text">Women’s health checkups</span>
							</li>
							<li class="d-flex align-items-start mb-2">
								<i class="bi bi-check2-circle text-primary me-2 mt-1"></i>
								<span class="list-text">Corporate yoga and meditation programs</span>
							</li>
						</ul>
						<p class="mt10">
							These programs help foster a culture of well-being, leading to
							a more engaged and productive workforce.
						</p>
					</div>
				</div>
			</div>

			<!-- last -->
			<div class="row align-items-center flex-column-reverse flex-md-row">
				<div class="col-lg-6 col-md-6 col-12">
					<div class="heading text-start">
						<h2>Home Sample Collection Services</h2>
						<p class="mt10">
							Busy schedules should not be a barrier to good health. We
							offer doorstep diagnostic sample collection services where
							employees can get their medical tests done without stepping
							out of their homes.
						</p>
						<ul class="list-unstyled">
							<li class="d-flex align-items-start mb-2">
								<i class="bi bi-check2-circle text-primary me-2 mt-1"></i>
								<span class="list-text">Hassle-free booking </span>
							</li>
							<li class="d-flex align-items-start mb-2">
								<i class="bi bi-check2-circle text-primary me-2 mt-1"></i>
								<span class="list-text">Timely sample collection</span>
							</li>
							<li class="d-flex align-items-start mb-2">
								<i class="bi bi-check2-circle text-primary me-2 mt-1"></i>
								<span class="list-text">Accurate test results delivered online</span>
							</li>
						</ul>
						<p class="mt10">
							These periodic assessments help in the early detection of
							illnesses and enable timely medical intervention.
						</p>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-12 mb-4 mb-md-0">
					<img data-src="images/corporate-tieus/home-sample-collection-services.png"
						alt="Pre-Employment Health Checkups" class="img-fluid lazy"
						src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR4nGNgYAAAAAMAASsJTYQAAAAASUVORK5CYII=" />
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Our-Healthcare-Solutions-section - end -->

<!-- Trusted-Diagnostic-Lab-section - start -->
<section class="pt40 pb-0 schedule bg-white">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-12">
				<div class="row section-title text-center">
					<div class="col-sm-12 col-12">
						<div class="common-heading-5">
							<h1 class="fs-3 text-202024 fw-bold">
								Trusted Diagnostic Lab Centre in India
							</h1>
							<h2 class="mb20 head-2">
								Top-Rated Lab Testing Facilities Near You
							</h2>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 px-0 d-none d-md-block">
				<img class="lazy w-100 img-fluid h-100" alt="Trusted Diagnostic Lab"
					src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR4nGNgYAAAAAMAASsJTYQAAAAASUVORK5CYII="
					data-src="https://www.mdrcindia.com/images/home/modren.png" />
			</div>

			<div class="col-12 px-0 d-block d-md-none">
				<img class="lazy w-100 img-fluid h-100" alt="Trusted Diagnostic Lab"
					src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR4nGNgYAAAAAMAASsJTYQAAAAASUVORK5CYII="
					data-src="images/corporate-tieus/modren-2.png" />
			</div>
		</div>
	</div>
</section>
<!-- Trusted-Diagnostic-Lab-section - end -->

<!-- How-to-Get-Started-section - start -->
<section class="pt40 pb40 schedule bg-white">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-12">
				<div class="row section-title text-center">
					<div class="col-sm-12 col-12">
						<div class="common-heading-5">
							<h1 class="fs-3 text-202024 fw-bold">How to Get Started?</h1>
							<h2 class="mb20 head-2">
								Partnering with us for your corporate healthcare needs is
								simple.
							</h2>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-12 px-0 d-none d-md-block">
				<img class="w-100 img-fluid h-100" alt="Healthcare Steps" src="images/corporate-tieus/healthcare-steps.svg" />
			</div>
			<div class="col-12 px-0 d-block d-md-none">
				<img class="w-100 img-fluid h-100 lazy" alt="Healthcare Steps" data-src="images/corporate-tieus/healthcare-steps-2.png" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR4nGNgYAAAAAMAASsJTYQAAAAASUVORK5CYII=" />
			</div>
		</div>
	</div>
</section>
<!-- How-to-Get-Started-section - end -->

<!-- form section - start -->
<section class="enquire-now-container pt30 pb50">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-6 col-md-6 col-12 mb-4 mb-md-0">
				<img data-src="images/corporate-tieus/person-2.png" alt="Pre-Employment Health Checkups" class="img-fluid lazy" src="" />
			</div>

			<div class="col-lg-6 col-md-6 lead-intro- col-12">
				<div class="form-block enquiry-form formcover shadow">
					<form method="post" id="corporate_tieup" name="corporate_tieup" class="shake">
						<h3 class="text-white text-center">Enquire Now</h3>
						<div class="row">
							<div class="form-group col-sm-12">
								<input type="text" id="name" placeholder="Full Name*" name="name" class="required" value="" maxlength="255"/>
							</div>
						</div>

						<div class="row">
							<div class="form-group col-sm-12">
								<input type="text" id="company" placeholder="Company Name*" name="company" maxlength="255" class="required" value="" />
							</div>
						</div>

						<div class="row">
							<div class="form-group col-sm-12">
								<input type="text" id="phone" name="phone" value="" placeholder="Phone Number *" maxlength="20" class="numbersOnly required" />
							</div>
						</div>

						<div class="row">
							<div class="form-group col-sm-12">
								<input type="text" id="email" name="email" value="" placeholder="Email *" maxlength="150" class="required" />
							</div>
						</div>

						<div class="row">
							<div class="form-group col-sm-12">
								<textarea id="message" name="message" placeholder="Message*" maxlength="255" rows="4" class="form-control required"></textarea>
							</div>
						</div>

						<button type="submit" class="mt-2 lnk btn-main bg-btn bg-white corporate_tieup_btn">Submit <i class="fas fa-chevron-right fa-icon"></i></button>
						<div class="fieldsets row">
							<div class="col-md-12">
								<div id="corporate_tieup_error_msg"></div>
								<div id="corporate_tieup_success_msg"></div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- form section - end -->

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
<script>
	document.addEventListener("DOMContentLoaded", function() {
		const lazyImages = document.querySelectorAll("img.lazy");

		if ("IntersectionObserver" in window) {
			let observer = new IntersectionObserver(function(entries, observer) {
				entries.forEach(function(entry) {
					if (entry.isIntersecting) {
						const img = entry.target;
						img.src = img.getAttribute("data-src");
						img.classList.remove("lazy");
						observer.unobserve(img);
					}
				});
			});

			lazyImages.forEach(function(img) {
				observer.observe(img);
			});
		} else {
			// Fallback for browsers that don't support IntersectionObserver
			lazyImages.forEach(function(img) {
				img.src = img.getAttribute("data-src");
				img.classList.remove("lazy");
			});
		}
	});
</script>
<?php include 'includes/general_data.php'; ?>