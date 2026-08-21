<?php
$url=(isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI];
$query_str = parse_url($url, PHP_URL_QUERY);
parse_str($query_str, $query_params);
 ?>
<?php include('includes/header.php'); ?>
<!-- Main Start -->
<main class="pb-5 bg-white page-common">
	<!-- About banner start -->
	<div class="card bg-theme rounded-0 border-0 p-3">
		<h2 class="font-lg text-center text-white mb-3">Career</h2>
		<p class="text-white text-center">
			Everyone seeks a rewarding career. Modern Diagnostic & Research Centre welcomes every such individual with ignited minds and a will to work for an industry that helps you grow. Modern Diagnostic & Research Centre strongly believes in commitments and compassion, so working with us requires a certain set of qualities.
		</p>
		<div class="w-50 mx-auto">
			<img src="assets/images/mdrc/career/banner-img-career.png" alt="" class="w-100 h-100 img-fluid">
		</div>
	</div>
	<!-- About banner end -->
	<div class="about-tab why-us px-3 mt-3 mb-3">
		<div class="why-img">
			<img src="assets/images/mdrc/career/clinic-patient.png" class="img-fluid w-100 mb-3" alt="Why Us">
		</div>
		<h2 class="font-lg text-left mb-2">Perspective of clinic to patient</h2>
		<p class="text-left mb-3">Our success is based on teamwork, working together to have an environment based on dignity and respect across the wide variety of job roles that exist within our company. Since the inception of Modern in 1985, it is our mission to bring the best and latest technology available anywhere in the world so as to diagnose diseases at an early stage and thus help the patient and the clinician in better management of illness.</p>
	</div>
	<?php if (count($this->rs_job) > 0) { ?>
		<!-- Accordion Start -->
		<div class="packaee-perameters main-wrap jobs-main pb-3 pt-3 bg-white mb-3">
			<h4 class="font-md text-center fw-bold mb-2">JOBS</h4>
			<h2 class="font-lg text-center mb-3">Current Openings</h2>
			<div class="accordion" id="accordionExample">

				<?php for ($i = 0; $i < count($this->rs_job); $i++) { ?>
					<!-- Accordion item -->
					<div class="accordion-item">
						<h2 class="accordion-header fw-bold" id="headingOne">
							<button class="accordion-button bg-theme title-color collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseTwo">
								<?= $this->rs_job[$i]['title'] ?> - <?= $this->rs_job[$i]['no_of_opening'] ?> Post
							</button>
						</h2>
						<div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
							<div class="accordion-body py-3 data-reqs">
								<div>
									<?= $this->rs_job[$i]['description'] ?>
								</div>
								<?php if($query_params['callfrom']!='app') {?>
								<a href="javascript:void(0);" data-id="<?= $this->rs_job[$i]['id'] ?>" class="btn btn-solid rounded-pill w-100 mt-3 job_opning_modal">Apply Now</a>
								<?php }else{?>
									<a href="<?=SERVER_ROOT;?>?view=career&action=careerForm&job_id=<?=$this->rs_job[$i]['id']?>&job_heading=<?=$this->rs_job[$i]['title']?>" class="btn btn-solid rounded-pill w-100 mt-3">Apply Now</a>
									<?php } ?>
							</div>
						</div>
					</div>
					<!-- Accordion item -->
				<?php } ?>
			</div>
		</div>
		<!-- Accordion End -->
	<?php } ?>
</main>

<div class="action action-confirmation common-popup offcanvas offcanvas-bottom" tabindex="-1" id="job-opning-form-modal" aria-labelledby="job-opning-form-modal">
	<div class="offcanvas-header">
		<div class="d-flex align-items-center justify-content-between w-100">
			<h3 class="fw-600">Work with us</h3>
			<div class="btnclose">
				<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
			</div>
		</div>
	</div>
	<div class="offcanvas-body small pt-0">
		<div class="form-block fdgn2">
			<form id="job_opning_form" name="job_opning_form" method="post" class="custom-form">
				<input type="hidden" name="job_opening_id" id="job_opening_id">
				<div class="fieldsets row">
				
						<div class="col-md-6 input-box">
						<label class="cust">Your Full Name*</label>
						<input id="form_name" class="form-control" type="text" name="name" placeholder="" required="required">
						</div>

						<div class="col-md-6 input-box">
						<label class="cust">Your Email Address*</label>
						<input id="form_email" type="text" class="form-control" name="email" placeholder="" required="required">
						</div>
                         
						<div class="col-md-6 input-box">
						<label class="cust">Current Designation*</label>
						<input id="form_name" class="form-control" type="text" name="designation" placeholder="" required="required">
						</div>
                        
						<div class="col-md-6 input-box">
						<label class="cust">Total Experience (in Years)*</label>
						<input id="form_name" class="form-control" type="text" name="experience" placeholder="" required="required">
						</div>
				
						<div class="col-md-6 input-box">
						<label class="cust">Phone Number*</label>
						<input id="form_name" class="form-control" type="text" name="phone" class="numbersOnly" placeholder="" required="required">
						</div>

						<div class="col-md-6 input-box">
						<label class="cust">Notice Period (in Months)*</label>
						<input id="form_name" class="form-control" type="text" name="notice_period" placeholder="" required="required">
						</div>

						<div class="col-md-6 input-box">
						<label class="cust">Current Organization*</label>
						<input id="form_name" class="form-control" type="text" name="current_organization" placeholder="" required="required">
						</div>

						<div class="col-md-6 input-box">
						<label class="cust">Upload CV</label>
						<div class="custom-file">
							<input type="file" class="custom-file-input mb0 form-control" id="customFile" name="cv_file1">
							<label class="custom-file-label" for="customFile">(Doc, Docx and PDF format only)</label>
						</div>						
					</div>
						 
						<div  class="col-md-12 input-box">
						<label class="cust">Address</label>
						<textarea id="form_message" class="form-control" name="address" placeholder="Address *" rows="4" required="required"></textarea>
						</div>											
				</div>				
				<div class="fieldsets mt40">
					<button type="submit" class="btn-solid lnk btn-main bg-btn job_opning_submit">Submit<span class="circle"></span></button>
				</div>
				<div class="fieldsets- row">
					<div class="col-md-12 form-group" id="job_opning_error_msg">
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Main End -->


<!-- Footer Start -->
<?php include('includes/footer.php'); ?>
<!-- Footer End -->