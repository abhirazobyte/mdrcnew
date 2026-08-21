<?php include('includes/header.php'); ?>

<?php
$url=(isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI];
$query_str = parse_url($url, PHP_URL_QUERY);
parse_str($query_str, $query_params);
if($query_params['callfrom']=='app') { 
$hideClass='d-none';
} 
?>

<!-- Main Start -->
<main class="bg-white page-common">
	
	<!-- About banner start -->
	<div class="card bg-theme rounded-0 border-0 p-3 <?=$hideClass;?>">
		<h3 class="text-center text-white mb-3">Not able to find your test?</h3>
		<p class="text-white text-center">
			MDRC is one of the few Diagnostic Companies in India which offers more than 2500 tests, ranging from Molecular to Whole Body Imaging.
		</p>
		<p class="text-white text-center">
		MODERN is accredited with ilac-MRA, NABL & NABH which strengthens our commitment to Quality and Accuracy in our reports.
		</p>
		<p class="text-white text-center">
			Please fill up the following details to get a call back on your enquiry.
		</p>
		<div class=" mx-auto mb-3">
			<div class="form-block formcover">
				<form method="post" id="prescription_booking" name="prescription_booking" class="shake mt30 custom-form textbookingfrm">
					<div class="row">
						<div class="col-md-6 col-12 input-box">
							<input type="text" id="name" placeholder="Full Name*" class="form-control" name="name" required="" value="<?= $name ?>" data-error="Please fill Out">
							<div class="help-block with-errors"></div>
						</div>
						<div class="col-md-6 col-12 input-box">
							<input type="text" id="email" name="email" class="form-control" placeholder="Email*" value="<?= $this->rs_customer['email'] ?>" required="">
							<div class="help-block with-errors"></div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-12 input-box">
							<input type="text" id="phone" name="phone" class="form-control" value="<?= $this->rs_customer['phone'] ?>" placeholder="Phone*" class="numbersOnly" required="" data-error="Please fill Out">
							<div class="help-block with-errors"></div>
						</div>
						<div class="col-md-6 col-12 input-box">
							<input type="text" id="age" class="form-control" placeholder="Age" class="numbersOnly" name="age" required="">
							<div class="help-block with-errors"></div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6 col-12 input-box">
							<select name="city" id="city" required="" class="form-select">
								<option value="">Select City</option>
								<?php for ($i = 0; $i < count($this->rs_gs_city); $i++) { ?>
									<option value="<?= $this->rs_gs_city[$i]['name'] ?>"><?= $this->rs_gs_city[$i]['name'] ?></option>
								<?php } ?>
							</select>
							<div class="help-block with-errors"></div>
						</div>
						<div class="col-md-6 col-12 input-box">
							<input type="date" placeholder="Date*" class="form-control" id="date" name="date">
						</div>
						<div class="col-md-6 col-12 input-box">
							<div class="d-flex align-items-center gap-3">
								<label class="text-white d-flex align-items-center"><input type="radio" value="Male" id="gender_male" name="gender"> Male</label>
								<label class="text-white d-flex align-items-center"><input type="radio" value="Female" id="gender_female" name="gender"> Female</label>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 col-12 input-box">
							<textarea rows="5" placeholder="Address" class="form-control" id="address" name="address" required=""></textarea>
							<div class="help-block with-errors"></div>
						</div>
						<div class="col-md-12 col-12 input-box">
							<textarea rows="5" placeholder="Brief details of your illness" class="form-control" id="brief_details" name="brief_details" required=""></textarea>
							<div class="help-block with-errors"></div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12 col-12 input-box">
							<label for="file" class="form-label cust text-white">Upload Prescription</label>
							<input class="form-control" type="file" id="pre_file" name="pre_file">
						</div>
					</div>


					<button type="submit" class="btn-solid lnk btn-main bg-btn prescription_booking_btn">Submit</button>
					<div class="fieldsets row">
						<div class="col-md-12">
							<div id="prescription_booking_error_msg">
							</div>
						</div>
					</div>

					<div id="msgSubmit" class="h3 text-center hidden"></div>
					<div class="clearfix"></div>
				</form>
			</div>

		</div>
	</div>
	<!-- About banner end -->

	<!-- About years start -->
	<div class="d-flex gap-3 align-items-center justify-content-center p-3">
		<div class="text-center">
			<p class="mb-0 fw-600 theme-color font-md">38+</p>
			<p class="mb-0 font-xs">Years Of Experience</p>
		</div>
		<div class="text-center">
			<p class="mb-0 fw-600 theme-color font-md">5 Crore+</p>
			<p class="mb-0 font-xs">Tests Done So Far</p>
		</div>
		<div class="text-center">
			<p class="mb-0 fw-600 theme-color font-md">20</p>
			<p class="mb-0 font-xs">Labs in India</p>
		</div>
		<div class="text-center">
			<p class="mb-0 fw-600 theme-color font-md">70 lac+</p>
			<p class="mb-0 font-xs">Satisfied Customers</p>
		</div>
	</div>
	<!-- About years End -->
	<div class="about-vision about-tab p-3 bg-gradiend-1 mb-4">
		<ul class="nav nav-pills mb-3 justify-content-center gap-2" id="pills-tab" role="tablist">
			<li class="nav-item" role="presentation">
				<button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-vision" type="button" role="tab" aria-controls="pills-home" aria-selected="true">
					<p class="mb-0">Our Vision</p>
				</button>
			</li>
			<li class="nav-item" role="presentation">
				<button class="nav-link" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-mission" type="button" role="tab" aria-controls="pills-home" aria-selected="true">
					<p class="mb-0">Our Mission</p>
				</button>
			</li>
		</ul>
		<div class="tab-content px-3" id="pills-tabContent">
			<div class="tab-pane fade show active" id="pills-vision" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
				<div class="d-flex align-items-center">
					<div class="d-flex about-icon">
						<img src="assets/images/mdrc/about/vision.png" alt="" class="img-fluid w-100 h-100">
					</div>
					<p class="mb-0 w-100">To become a leading diagnostic services provider in the country with unhinged focus on providing accurate, efficient & Cutting edge diagnostic services to our patients.</p>
				</div>
			</div>
			<div class="tab-pane fade" id="pills-mission" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
				<div class="d-flex align-items-center">
					<div class="d-flex about-icon">
						<img src="assets/images/mdrc/about/mission.png" alt="" class="img-fluid w-100 h-100">
					</div>
					<p class="mb-0 w-100">To obtain & deploy the best and latest technologies in the world, to diagnose ailments of our patients in a accurate, timely and cost effective manner.</p>
				</div>
			</div>
		</div>
	</div>
	<!-- ---about tab end starttttt--- -->
	<!-- About vision End -->
	<!-- About tab start -->
	<div class="about-tab mb-3">
		<h2 class="font-lg text-center mb-3">Our Accreditations</h2>
		<ul class="nav nav-pills mb-3 justify-content-center gap-2" id="pills-tab" role="tablist">
			<li class="nav-item" role="presentation">
				<button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-nabl" type="button" role="tab" aria-controls="pills-home" aria-selected="true">
					<!-- <img src="assets/images/mdrc/home/nabl.png" alt="" class="img-fluid d-block mx-auto object-cover"> -->
					<p class="mb-0">NABL</p>
				</button>
			</li>
			<li class="nav-item" role="presentation">
				<button class="nav-link" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-nabh" type="button" role="tab" aria-controls="pills-home" aria-selected="true">
					
					<p class="mb-0">NABH</p>
				</button>
			</li>
			
		</ul>
		<div class="tab-content px-3" id="pills-tabContent">
			<div class="tab-pane fade show active" id="pills-nabl" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
				<div class="w-25 mt-2 mb-3">
					<img src="assets/images/mdrc/about/nabl-img.png" alt="" class="w-100 h-100 img-fluid">
				</div>
				<h3 class="font-md fw-600 mb-3">NABL Accredited Lab</h3>
				<p class="mb-2">
					MDRC has laid great emphasis on its Quality Control in all the labs across India. To reflect our commitment towards accurate reports, we have 6 NABL Labs across India following high standards of quality control to get accurate and consistent results.
				</p>
				<p class="mb-2">
					MDRC follows strict internal and external quality control programs. We run daily controls and regular calibrations and follow regular External Quality Assurance Programs with RANDOX Laboratories UK, AIIMS and CMC Vellor.
				</p>
				<p class="mb-2">
					Our labs have latest fully automatic equipments which gives consistent and correct results in all fields such as Haematology, Serology, Immunology, Electrophoresis, Clinical Pathology, Microbiology, Molecular and Cytogenetics, Real time PCR etc.
				</p>
			</div>
			<div class="tab-pane fade" id="pills-nabh" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
				<div class="w-25 mt-4 mb-3">
					<img src="assets/images/mdrc/about/nabh-img.png" alt="" class="w-100 h-100 img-fluid">
				</div>
				<h3 class="font-md fw-600 mb-3">NABH Accredited Imaging Centre</h3>
				<p class="mb-2">
					MDRC Diagnostic centre at Sector 44, Gurugram and our Reference Lab at New Railway Road, Gurugram are NABH accredited.
				</p>
				
				<p class="mb-2">
					Medical Imaging Services cover all investigations of patients which are helpful in diagnosis, prevention and treatment of diseases or ascertaining the health of patients. It includes wide variety of imaging techniques using latest technologies such as Ultrasound, MRI, CT scan etc. The clinical advantages of these services are enormous as quality imaging affects critical decision-making at every stage of patient management.
				</p>
				<p class="mb-2">
					<strong>Patient Safety:</strong> We give special attention to the safety of our patients by ensuring minimal contrast administration and ensuring that the radiation dose is kept to minimum level possible.
				</p>
				<ul style="list-style: circle;" class="px-3">
					<li>Maintain accuracy of test results and ensure accurate patient diagnosis</li>
					<li>Meet required standards from CLIA, FDA and OSHA. </li>
					<li>Manage rapidly evolving changes in laboratory medicine and technology</li>
					<li>Exchange ideas and best practices among pathology and laboratory medicine peers</li>
					<li>Offer professional development and learning opportunities for laboratory staff</li>
				</ul>
			</div>
			
		</div>
	</div>
	<!-- About tab end -->
	<!-- About lab start -->
	<div>
		<div class="card abtcard-1 rounded m-3 p-3">
			<div class="d-flex align-items-center">
				<div class="wd-40 ht-40">
					<img src="assets/images/mdrc/about/lab.png" alt="" class="img-fluid d-block">
				</div>
				<div class="w-100 ms-2">
					<h3 class="fw-600 font-md mb-2">16 Labs across 7 States</h3>
					<span class="font-xs">Uttar Pradesh, Haryana, Rajasthan, West Bengal, Assam, Jammu & Kashmir, Madhya Pradesh</span>
				</div>
			</div>
		</div>
		<div class="card abtcard-2 rounded m-3 p-3">
			<div class="d-flex align-items-center">
				<div class="wd-40 ht-40">
					<img src="assets/images/mdrc/about/globe.png" alt="" class="img-fluid d-block">
				</div>
				<div class="w-100 ms-2">
					<h3 class="fw-600 font-md mb-2">International Reach </h3>
					<span class="font-xs">MDRC has international reach and get samples from UAE, Kenya, Uganda, Nigeria & Nepal.</span>
				</div>
			</div>
		</div>
		<div class="card abtcard-3 rounded m-3 p-3">
			<div class="d-flex align-items-center">
				<div class="wd-40 ht-40">
					<img src="assets/images/mdrc/about/collection.png" alt="" class="img-fluid d-block">
				</div>
				<div class="w-100 ms-2">
					<h3 class="fw-600 font-md mb-2">1800+ Touch points across India</h3>
					<span class="font-xs">MDRC offers complete range of diagnostic facilities in Radiology & Pathology under one roof.</span>
				</div>
			</div>
		</div>
	</div>
	<!-- About lab end -->



	<!-- Our portfolio caters to start -->
	<div class="banner-section profolio-caters p-3">
		<h2 class="font-lg text-center mb-3">Our vast array of testing portfolio caters to</h2>
		<div class="about-porfolio-slider">
			<div>
				<a href="javascript:void(0)" class="banner-box">
					<div class="card bg-white">
						<div class="ht-200">
							<img src="assets/images/mdrc/about/sl-1.png" alt="" class="img-fluid w-100 h-100 d-block">
						</div>
						<span class="my-2 font-md fw-600 text-center">Laboratory</span>
					</div>
				</a>
			</div>
			<div>
				<a href="javascript:void(0)" class="banner-box">
					<div class="card bg-white">
						<div class="ht-200">
							<img src="assets/images/mdrc/about/sl-2.png" alt="" class="img-fluid w-100 h-100 d-block">
						</div>
						<span class="my-2 font-md fw-600 text-center">Pathology</span>
					</div>
				</a>
			</div>
			<div>
				<a href="javascript:void(0)" class="banner-box">
					<div class="card bg-white">
						<div class="ht-200">
							<img src="assets/images/mdrc/about/sl-3.png" alt="" class="img-fluid w-100 h-100 d-block">
						</div>
						<span class="my-2 font-md fw-600 text-center">High end Pathology</span>
					</div>
				</a>
			</div>
			<div>
				<a href="javascript:void(0)" class="banner-box">
					<div class="card bg-white">
						<div class="ht-200">
							<img src="assets/images/mdrc/about/sl-4.png" alt="" class="img-fluid w-100 h-100 d-block">
						</div>
						<span class="my-2 font-md fw-600 text-center">Radiology</span>
					</div>
				</a>
			</div>
			<div>
				<a href="javascript:void(0)" class="banner-box">
					<div class="card bg-white">
						<div class="ht-200">
							<img src="assets/images/mdrc/about/sl-5.png" alt="" class="img-fluid w-100 h-100 d-block">
						</div>
						<span class="my-2 font-md fw-600 text-center">Imaging</span>
					</div>
				</a>
			</div>
			<div>
				<a href="javascript:void(0)" class="banner-box">
					<div class="card bg-white">
						<div class="ht-200">
							<img src="assets/images/mdrc/about/sl-5.png" alt="" class="img-fluid w-100 h-100 d-block">
						</div>
						<span class="my-2 font-md fw-600 text-center">Imaging</span>
					</div>
				</a>
			</div>
		</div>
	</div>
	<!-- Our portfolio caters to end -->
	<!-- Network start -->
	<div class="banner-section our-network p-3">
		<h2 class="font-lg text-center mb-3">Our Network</h2>
		<div class="map-image">
			<img src="assets/images/mdrc/about/map-network.png" alt="" class="img-fluid">
		</div>
		<div class="about-network-slider">
			<div>
				<a href="javascript:void(0)" class="banner-box">
					<div>
						<img src="assets/images/mdrc/about/network-1.png" alt="" class="img-fluid">
					</div>
				</a>
			</div>
			<div>
				<a href="javascript:void(0)" class="banner-box">
					<div>
						<img src="assets/images/mdrc/about/network-1.png" alt="" class="img-fluid">
					</div>
				</a>
			</div>
		</div>
	</div>
	<!-- Network end -->
</main>
<!-- Main End -->
<!-- Footer Start -->
<?php include('includes/footer.php'); ?>
<!-- Footer End -->
<script>
	$(document).ready(function() {
		$('.moreless-button').click(function() {
			$('.moretext').slideToggle();
			if ($('.moreless-button').text() == "Read more") {
				$(this).text("Read less")
			} else {
				$(this).text("Read more")
			}
		});
	});
</script>