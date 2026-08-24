<?php 
if(VIR_DIR=='m/') { 
	include('includes/m/footer.php');
} else {
?>
<?php 
$currentPage=$this->getCurrentView();
$pages=['cart','checkout'];
if(!in_array($currentPage,$pages)){
?>
	<section class="contact-page pad-tb faq-sec comman-faq" id="health-test">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="career-card-div">
                        <div class="accordion" id="accordionExampleFooter">

							<?php if (count($this->rs_gs_city) > 0) { ?>
								<div class="accordion-item">
									<h2 class="accordion-header" id="headingCity">
										<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCity" aria-expanded="true" aria-controls="collapseCity">
											Our Presence
										</button>
									</h2>
									<div id="collapseCity" class="accordion-collapse collapse show" aria-labelledby="headingCity" data-bs-parent="#accordionExampleFooter">
										<div class="accordion-body">
											<div class="data-reqs homelinks">
												<?php for ($i = 0; $i < count($this->rs_gs_city); $i++) { ?>
													<a class="tags footer_changecity_<?= $this->rs_gs_city[$i]['id'] ?>" onclick="changeCity(<?= $this->rs_gs_city[$i]['id'] ?>,'premium-health-checkup')" data-page='premium-health-checkup'><?= $this->rs_gs_city[$i]['name'] ?></a>
												<?php } ?>
											</div>
										</div>
									</div>
								</div>
							<?php } ?>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTests">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTests" aria-expanded="false" aria-controls="collapseTests">
                                        Popular Health Tests & Packages
                                    </button>
                                </h2>
                                <div id="collapseTests" class="accordion-collapse collapse" aria-labelledby="headingTests" data-bs-parent="#accordionExampleFooter">
                                    <div class="accordion-body">
                                        <div class="data-reqs homelinks">
											<?php $j = 0;
											foreach($items as $test)
											{
												$testCats = explode(',', $test['item_other_data_item_department_ids']);
												if(count($testCats) > 0 && in_array('2', $testCats) && $test['set_at_popular_test'] == 'Yes')
												{
													if($j > 30){
														break;
													} ?>
                                            		<a class="tags" href="tests/<?= $test['slug']; ?>/<?= $_SESSION['citySlug']; ?>"><?= $test['name'].' In '.$_SESSION['cityName']; ?></a>
													<?php $j++;
												}
											} ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingRadiology">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRadiology" aria-expanded="false" aria-controls="collapseRadiology">
                                        Popular Radiology Tests & Packages
                                    </button>
                                </h2>
                                <div id="collapseRadiology" class="accordion-collapse collapse" aria-labelledby="headingRadiology" data-bs-parent="#accordionExampleFooter">
                                    <div class="accordion-body">
                                        <div class="data-reqs homelinks">
											<?php $j = 0;
											foreach($items as $test)
											{
												$testCats = explode(',', $test['item_other_data_item_department_ids']);
												if(count($testCats) > 0 && in_array('1', $testCats) && $test['set_at_popular_test'] == 'Yes')
												{
													if($j > 30)
													{
														break;
													} ?>
                                            		<a class="tags" href="tests/<?= $test['slug']; ?>/<?= $_SESSION['citySlug']; ?>"><?= $test['name'].' In '.$_SESSION['cityName']; ?></a>
													<?php $j++;
												}
											} ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingCategories">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCategories" aria-expanded="false" aria-controls="collapseCategories">
                                        Popular Categories
                                    </button>
                                </h2>
                                <div id="collapseCategories" class="accordion-collapse collapse" aria-labelledby="headingCategories" data-bs-parent="#accordionExampleFooter">
                                    <div class="accordion-body">
                                        <div class="data-reqs homelinks">
											<?php $j = 0;
											foreach($item_category as $item)
											{
												$Cats = explode(',', $item['item_department_ids']);
												if(count($Cats) > 0 && in_array('2', $Cats))
												{
													if($j > 30)
													{
														break;
													} ?>
                                            		<a class="tags" href="category/<?= $_SESSION['citySlug']; ?>/<?= $item['slug']; ?>"><?= $item['name']; ?></a>
													<?php $j++;
												}
											} ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingRisk">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRisk" aria-expanded="false" aria-controls="collapseRisk">
                                        Test by Risk
                                    </button>
                                </h2>
                                <div id="collapseRisk" class="accordion-collapse collapse" aria-labelledby="headingRisk" data-bs-parent="#accordionExampleFooter">
                                    <div class="accordion-body">
                                        <div class="data-reqs homelinks">
                                            <?php $j = 0;
											foreach($item_diseases as $item)
											{
												$Cats = explode(',', $item['item_department_ids']);
												if(count($Cats) > 0 && in_array('1', $Cats))
												{
													if($j > 30)
													{
														break;
													} ?>
													<a class="tags" href="diseases/<?= $_SESSION['citySlug']; ?>/<?= $item['slug']; ?>"><?= $item['name']; ?></a>
													<?php $j++;
												}
											} ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

							<?php if (count($this->rs_gs_city) > 0) { ?>
								<div class="accordion-item">
									<h2 class="accordion-header" id="headingCheckup">
										<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCheckup" aria-expanded="false" aria-controls="collapseCheckup">
											Full Body Checkup
										</button>
									</h2>
									<div id="collapseCheckup" class="accordion-collapse collapse" aria-labelledby="headingCheckup" data-bs-parent="#accordionExampleFooter">
										<div class="accordion-body">
											<div class="data-reqs homelinks">
												<?php for($i = 0; $i < count($this->rs_gs_city); $i++) { ?>
													<a class="tags footer_changecity_<?= $this->rs_gs_city[$i]['id'] ?>" onclick="changeCity(<?= $this->rs_gs_city[$i]['id'] ?>,'premium-health-checkup')" data-page='premium-health-checkup'>Full body Checkup Test in <?= $this->rs_gs_city[$i]['name'] ?></a>
												<?php } ?>
											</div>
										</div>
									</div>
								</div>
							<?php } ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>

<!--Start Preloader -->
<div class="onloadpage" id="page_loader">
	<div class="pre-content">
	   <div class="logo-pre d-flex justify-content-center"><img src="images/favicon.png" alt="Logo" class="img-fluid" /></div>
	   <!-- <div class="pre-text- text-radius text-light text-animation bg-b">MDRC</div> -->
	   <!-- <div class="pre-text- color-red fw-bold">MDRC</div> -->
	</div>
 </div>
<!--End Preloader -->
<!-- <div class="RprtBtn-Wppr"> -->
	<!-- <a href="#" target="_blank">Download Report </a> -->
<!-- </div> -->
<!-- 
<div class="watsap_links">
	<a class="wtsapp-desktop" href="https://wa.me/918586988847?text=Hello :) Thank you for contacting Modern Diagnostic and Research Centre. How can we help you please?" target="_blank"><img src="images/whatsapp_i.png" alt="best diagnostic centre" /></a>
</div> -->
<div class="whatsapp-footer">
		<a class="whatsapp-button" target="_blank" href="https://wa.me/918586988847?text=Hello :) Thank you for contacting Modern Diagnostic and Research Centre. How can we help you please?">
			<i class="fab fa-whatsapp" aria-hidden="true"></i><span>Talk with Health Advisor</span>
		</a>

	</div>
<div class="stickyBarBottom">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-9 custim col-12 ft text-center">
				<div class="row">
					<div class="col-lg-4 col-4 ft text-center">
					   <a  href="" data-bs-toggle="modal" data-bs-target="#modalform-full"><em class="FxdBtn-Icn"><i class="fas fa-pencil-alt"></i></em><strong>Book a Lab Test</strong> </a>
					</div>
					<div class="col-lg-4 col-4 sd">
					   <a href="/download-reports" class="report-top"> <em class="FxdBtn-Icn"><i class="far fa-file-alt"></i></em><strong>Download reports</strong>  </a>
					</div>
					<div class="col-lg-4 col-4 td">
					   <a href="https://wa.me/918586988847?text=Hello :) Thank you for contacting Modern Diagnostic and Research Centre. How can we help you please?" target="_blank"> <em class="FxdBtn-Icn"><i class="fab fa-whatsapp"></i></em><strong>Chat with our health Agent</strong>  </a>
					</div>
				</div>
			</div>
		</div>
		<!-- <div class="row"> -->
			<!-- <div class="col-lg-4 col-4 ft text-center"> -->
			   <!-- <a href="#" target="_blank"><em class="FxdBtn-Icn"><img src="images/blood-test.png" alt="blood-test"></em>Book a Lab Test </a> -->
			<!-- </div> -->
			<!-- <div class="col-lg-4 col-4 sd"> -->
			   <!-- <a href="javascript:void(0)" class="report-top"> <em class="FxdBtn-Icn"><img src="images/file.png" alt="file"></em>Download reports  </a> -->
			<!-- </div> -->
			<!-- <div class="col-lg-4 col-4 td"> -->
			   <!-- <a href="contact-us.html"> <em class="FxdBtn-Icn"><img class=" lazyloaded" src="images/phonew.png" alt="ct scan in gurgaon"></em>Contact Us  </a> -->
			<!-- </div> -->
		<!-- </div> -->
	</div>
</div>
<!--Start Footer-->
<footer>
	<div class="footer-row1">
		<div class="container">
			<div class="row">
				<div class="col-lg-2 col-md-3 col-5">
					<div class="email-subs">
						<h5 class="text-white">Follow us on</h5>
						<div class="footer-social-media-icons">
							<a href="https://m.facebook.com/MdrcIndia/" target="blank"><i class="fab fa-facebook-f"></i></a>
							<a href="https://youtube.com/channel/UCwZECfhGeCu8o6CvAST95CQ" target="blank"><i class="fab fa-youtube"></i></a>
							<a href="https://www.linkedin.com/company/modern-diagnostic-research-centre/" target="blank"><i class="fab fa-linkedin-in"></i></a>
							<a href="https://mobile.twitter.com/mdrcindia" target="blank"><i class="fab fa-twitter"></i></a>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-7">
					<div class="email-subs">
						<a class="tel" href="https://wa.me/918586988847?text=Hello :) Thank you for contacting Modern Diagnostic and Research Centre. How can we help you please?" target="_blank"><h5 class="text-white">Chat with MDRC Expert</h5></a><br />

						<a class="tel" href="https://wa.me/918586988847?text=Hello :) Thank you for contacting Modern Diagnostic and Research Centre. How can we help you please?" target="_blank"><i class="fab fa-whatsapp"></i> Whatsapp</a>
					</div>
				</div>
				<div class="col-lg-6 col-md-5 mt-3 mt-lg-0 mt-md-0 ms-auto">
					<h5 class="text-white">Subscribe To Our Newsletter</h5>
					<div class="email-subs-form">
						<form class="row getTouch" name="subscribe_form" id="subscribe_form" method="post">
							<div class="col-lg-10 col-8">
								<input type="email" placeholder="Enter Email ID" name="email" id="email">
							</div>
							<div class="col-lg-2 ps-0 col-4">
								<button type="submit" id="subscribe_submit" class="lnk bg-btn1">Submit <span class="circle"></span></button>
							</div>
						</form>
						<div id="error_msg" class="text-center">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="footer-row2">
		<div class="container">
			<div class="row justify-content-between">
				<div class="col-lg-4 col-sm-6  ftr-brand-pp">
					<a class="navbar-brand  mb25 f-dark-logo" href="#"> <img src="images/logo.webp" alt="MDRC"/></a>
					<a class="navbar-brand mt30 mb25 f-white-logo" href="#"> <img src="images/logo.webp" alt="MDRC" /></a>
					<p>Modern Diagnostic & Research Centre Limited. Is one of India’s Fastest growing Diagnostic chain having more than 1800+ collection point across India and a network of 20+ Labs across 7 states.</p>
				</div>
				<div class="col-lg-2 col-sm-6">
					<h5>Quick Link</h5>
					<ul class="footer-address-list link-hover">
						<li><a href="about-us">About Us</a></li>
                        <li><a href="our-doctors">Our Doctors</a></li>
                        <li><a href="modern-lab">Modern Lab</a></li>
                        <li><a href="modern-imaging">Modern Imaging</a></li>
                        <li><a href="super-specialised-services">Super Specialised Services</a></li>
                        <li><a href="imaging-test-information">Imagine test Information</a></li>
                        <li><a href="pathology-lab-information">Pathology Lab Test Information</a></li>
                        <li><a href="home-sample-collection/<?=$_SESSION['citySlug'];?>">Home Sample Collection</a></li>
                        <li><a href="paynow">Pay Now</a></li>
                        
						
						
					</ul>
				</div>
				<div class="col-lg-2 col-sm-6">
					<h5>Info</h5>
					<ul class="footer-address-list link-hover">
                    <li><a href="blog">Blogs</a></li>
                    <li><a href="gallery">Gallery</a></li>
                    <li><a href="career">Career</a></li>
                    <li><a href="reach-us">Reach Us</a></li>
						<?php for ($i = 0; $i < count($this->rs_pages); $i++) {?>
              <li>
                  <a href="page/<?=$this->rs_pages[$i]['slug'];?>"><?=$this->rs_pages[$i]['page_title'];?></a>
              </li>
            <?php }?>
					</ul>
				</div>
				<div class="col-lg-3 col-sm-6 footer-blog-">
					<h5>Premium HealthCheckup</h5>
					<ul class="footer-address-list link-hover">
						<?php for($i=0;$i<count($this->rs_footer_popular_item);$i++){?>
						<li><a href="tests/<?=$this->rs_footer_popular_item[$i]['slug']?>/<?=$_SESSION['citySlug'];?>"><?=$this->rs_footer_popular_item[$i]['name']?></a></li>
                        <?php }?>
					</ul>
				</div>
			</div>
			

		

		</div>
	</div>
	<div class="footer-brands">
		<div class="container">
			<div class="row align-items-center">
				<!-- <div class="col-lg-6 col-md-6">
					<h6 class="mt10 mb10">Download The App <br class="d-block d-lg-none d-md-block"/>
						<a class="imggoogle ms-3 me-3" href="#"><img src="images/img-gplay.png" alt="Google Play"></a>
						<a class="imgstore" href="#"><img src="images/img-appstore.png" alt="App Store"></a>
					</h6>
				</div> -->
				<div class="col-lg-12 col-md-6 payment text-center text-lg-center text-md-end">
					<h6 class="mt10 mb10">Payment Option <br class="d-block d-lg-none d-md-block"/>
						<a class="ms-0 ms-lg-3 ms-md-3" href="#"><img src="images/img-cards.png" alt="Payment method"></a>
					</h6>
				</div>
			</div>
		</div>
	</div>
	<div class="footer-row3">
		<div class="copyright">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="footer-">
							<p>©2024 All right reserved. Modern Diagnostic & Research Centre Limited.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>
<!--End Footer-->
<div id="ajax_modal_container" class="ajax_modal_container"></div>
<!--start Modal html -->
<div class="popup-modals big-modal">
  <div class="modal" id="modalform-full">
    <div class="modal-dialog">
      <div class="modal-content">
        <button type="button" class="closes abt" data-bs-dismiss="modal">&times;</button>
        <div class="modal-body">
          <div class="col-md-12 col-12">
            <div class="row justify-content-center">
              <div class="col-md-12 text-center">
                <h3 class="mb10">Not able to find your test?</h3>
                <p>Blood tests can be done through home blood sample collection services that do away with the need to travel to the laboratory. Please fill up the following details for appointment. You will receive an confirmation call from centre regarding appointment details.</p>
              </div>
            </div>

            <div class="row justify-content-center mt30">
              <div class="col-md-12">
                <div class="form-block fdgn2 mt10 mb10">
                  <form method="post" id="collection_appointment" name="collection_appointment">
                    <div class="fieldsets row">

                    	<?php $name=''; if($this->rs_customer['name']!=''){
                    	$name = $this->rs_customer['name']." ".$this->rs_customer['last_name']; }
                    	?>
                      <div class="col-md-6"><input required="required" type="text" placeholder="Full Name*" name="name" id="name" value="<?=$name?>"></div>
                      <div class="col-md-6"><input required="required" type="email" placeholder="Email*" name="email" id="email" value="<?=$this->rs_customer['email']?>"></div>
                    </div>
                    <div class="fieldsets row">
                      <div class="col-md-6"><input  required="required" type="phone" placeholder="Phone*" class="numbersOnly" value="<?=$this->rs_customer['phone']?>" name="phone" id="phone"></div>
                      <div class="col-md-6"><input type="text" placeholder="Age" class="numbersOnly" name="age" id="age"></div>
                    </div>
                    <div class="fieldsets row">
                      <div class="col-md-6">
                      	<select  required="required" name="city" id="city">
                      		<option value="">Select City</option>
                      		<?php for ($i=0; $i < count($this->rs_gs_city) ; $i++) { ?>
														<option value="<?=$this->rs_gs_city[$i]['name']?>"><?=$this->rs_gs_city[$i]['name']?></option>
													<?php }?>	
												</select>
												</div>


                      <div class="col-md-6 form-group">
                        <div class="row align-items-center no-gutters">
                          <div class="col-lg-6 col-md-5">
		                       <input type="date" placeholder="Date*" id="date" name="date">
                          </div>
                          <div class="col-lg-6 col-md-7 mt-2 mt-lg-0 mt-md-0 mb-2 mb-lg-0 mb-md-0">
                      		<label class="text-dark ms-0 me-2"><input type="radio" value="Male" id="customRadio" name="example"/> Male</label>
                      		<label class="text-dark"><input type="radio" value="Female" id="customRadio2" name="example"/> Female</label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="fieldsets row">
                      <div class="col-md-6"><textarea placeholder="Address" id="address" name="address"></textarea></div>
                      <div class="col-md-6"><textarea placeholder="Brief details of your illness" id="brief_details" name="brief_details"></textarea></div>
                    </div>
                    <div class="fieldsets row">
                      <div class="col-md-12">
                        <select  name="reference" id="reference">
														<option selected="selected" value="">How did you hear about us</option>
														<option value=""> - Select Reference - </option>
														<option value="newspaper">From Newspaper</option>
														<option value="facebook">From Facebook</option>
														<option value="twitter">From Twitter</option>
														<option value="youtube">From Youtube</option>
														<option value="just_dial">From Just Dial</option>
														<option value="friends">Friends Reference</option>
														<option value="doctor_reference">Doctor Reference</option>
														<option value="old_patients">Patient Reference</option>
														<option value="none">Any Other</option>
                        </select>
                   		</div>
                    </div>
                    <div class="fieldsets row mt30 pb20 justify-content-center">
                      <div class="col-md-8">
                        <button type="submit" class="lnk btn-main bg-btn collection_appointment_btn">Submit <i class="fas fa-chevron-right fa-icon"></i><span class="circle"></span></button>
                      </div>
                    </div>
                    <div class="fieldsets row">
                      <div class="col-md-12">
                      	<div id="collection_appointment_error_msg">
                      	</div>
		                  </div>
		                </div>
                  </form>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
 </div>

<div class="popup-modals modal-ad-style coup-modal cities-modal">
  <div class="modal" id="modal-cities" tabindex="-1" >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
	        <div class="col-md-12 text-center w-100 pb-2">
					    <div class="float-end pt-2">
			  	        <button type="button" class="closes" data-bs-dismiss="modal">×</button>
				      </div>
	          	<h5 class="pt-3">Select Your City</h5>
	        </div>
         	<div class="form-block fdgn2 mt0 mb0">
	              <div class="fieldsets row justify-content-center m-auto">
	                	<div class="col-md-6 ps-2 pe-2 mt-1 mb-0 space_coupon position-relative">
							<form action="" method="post" name="feedback-form">
								<input type="text" placeholder="Search for your city" name="" class="m-0" onkeyup="show_suggestion(this.value)">
								<button type="button" class="check-coupon" id=""><i class="fas fa-search"></i></button>
							</form>
						</div>
						<div class="col-md-3 ps-2 pe-2 mt-1 mb-0 space_coupon position-relative">
							<div class="getCurrentLocation" onclick="getLocation()">
								<img src="images/icon-location.png" alt="">
								<span>Use Current Location</span>
							</div>
						</div>
				 </div>	
			</div>
	        <div class="row m-auto">
	          	<div class="col-md-12 cities-ul text-center ">
	          			<ul class="sCity">
                        	<?php for($i=0;$i<count($this->rs_gs_city);$i++){
								if($this->rs_gs_city[$i]['image']!=''){
								$cityName=$this->rs_gs_city[$i]['name'];
								$cityId=$this->rs_gs_city[$i]['id'];
								$cityimage=$this->rs_gs_city[$i]['image'];
								$activeClass='';
								if($cityId==$_SESSION['cityID'])
								{
									$activeClass='active';
								}
								$cityimage = $this->utility->get_image_path($cityimage, 'city', 'large');
								?>
	          					<li><a class="<?=$activeClass?>" href="javascript:void(0)" onclick="changeCity(<?=$cityId?>)"><img src="<?=$cityimage?>" alt="" /><br/><span><?=$cityName?></span></a></li>
                                <?php }}?>
	          			</ul>
						
						  </div>

						  <div class="col-md-12 cities-ul text-center pt-2 pb-2 cityListWithoutImageDiv">
						  <h5 class="pt-1">Other Cities</h5>
						  <ul class="cityListWithoutImage">
                        	<?php for($i=0;$i<count($this->rs_gs_city);$i++){
								if($this->rs_gs_city[$i]['image']==''){
								$cityName=$this->rs_gs_city[$i]['name'];
								$cityId=$this->rs_gs_city[$i]['id'];
								$cityimage=$this->rs_gs_city[$i]['image'];
								$activeClass='';
								if($cityId==$_SESSION['cityID'])
								{
									$activeClass='active';
								}
								$cityimage = $this->utility->get_image_path($cityimage, 'city', 'large');
								?>
	          					<li><a style="color:#3a3a3a;" class="<?=$activeClass?>" href="javascript:void(0)" onclick="changeCity(<?=$cityId?>)"><span><?=$cityName?></span></a></li>
                                <?php }}?>
	          			</ul>
	          	</div>

				<div id="googleMapApiResult" class="text-center col-md-12 pt-2 pb-3">
				</div>
	        </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- <div class="popup-modals modal-ad-style coup-modal">
  <div class="modal" id="coupon-modal" tabindex="-1" >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <div class="common-heading">
            <h4 class="mt0 mb0">APPLY COUPONS</h4>
          </div>
          <button type="button" class="closes" data-bs-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body p-0">
         	 <div class="form-block fdgn2 mt10 mb10">
	            <form action="#" method="post" name="feedback-form">
	              <div class="fieldsets row m-auto">
	                	<div class="col-md-12 ps-4 pe-4 mt-3 mb-3 space_coupon position-relative">
		                	<input type="text" placeholder="Enter coupon code" name="coupon_code" class="m-0">
		                	<button type="submit" class="check-coupon" id="appyCouponBtn">CHECK</button>
										</div>
								</div>
						</form>
					</div>
          <div class="form-block fdgn2 mt10 ">
            <form action="#" method="post" name="feedback-form">
              <div class="fieldsets row m-auto bdr">
                <div class="col-md-12 pt-3 pb-3 ps-4 pe-4">
                		<div class="custom-control custom-radio">
												<label class="custom-control-label">
														<input type="radio" name="coupon-check">
														<svg class="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
															<path d="M9 20l-7-7 3-3 4 4L19 4l3 3z"></path>
														</svg>
														<span class="d-inline-block c-bdr text-dark rounded fwseb">SWSKAPCK</span> <span class="d-block mt-2 text-dark fs__13">Special Offers</span>
												</label>
										</div>
                </div>
                <div class="col-md-12 pt-3 pb-3 ps-4 pe-4">
                		<div class="custom-control custom-radio">
												<label class="custom-control-label">
														<input type="radio" name="coupon-check">
														<svg class="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
															<path d="M9 20l-7-7 3-3 4 4L19 4l3 3z"></path>
														</svg>
														<span class="d-inline-block c-bdr text-dark rounded fwseb">TEST2021</span> <span class="d-block mt-2 text-dark fs__13">Minimum Order Amount Rs.100/- Require. Once Per User.</span>
												</label>
										</div>
                </div>
              </div>
              <div class="fieldsets row m-auto pt-3 pb-3">
                	<div class="col-md-6">
                	</div>
                	<div class="col-md-6">
           				 		<button type="submit" name="submit" class="btn-main bg-btn1 btn-blue lnk text-uppercase  appyCouponBtn w-100" data-bs-dismiss="modal">Apply<span class="circle"></span></button>
           				</div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> -->
<div class="popup-modals modal-ad-style coup-modal">
  <div class="modal" id="Modalselect-add-patients" tabindex="-1" >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <div class="common-heading">
            <h4 class="mt0 mb0">SELECT / ADD PATIENTS</h4>
          </div>
          <button type="button" class="closes" data-bs-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body p-0">
          <div class="form-block fdgn2 add-patient mt10">
            <form action="#" method="post" name="feedback-form">
              <div class="fieldsets row m-auto bdr border-top-0">
                <div class="col-md-12 pt-3 pb-3 ps-4 pe-4">
                		<div class="custom-control custom-radio">
												<label class="custom-control-label">
													<input type="radio" value="1" name="address1">
													<svg class="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
														<path d="M9 20l-7-7 3-3 4 4L19 4l3 3z"></path>
													</svg>
													<span class="ml-3 adri"><span class="fw-semibold">1. Mr Tester</span><br>Male , 30 yrs.</span></label>
										</div>
                </div>
                <div class="col-md-12 pt-3 pb-3 ps-4 pe-4">
                		<div class="custom-control custom-radio">
												<label class="custom-control-label">
													<input type="radio" value="1" name="address1">
													<svg class="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
														<path d="M9 20l-7-7 3-3 4 4L19 4l3 3z"></path>
													</svg>
													<span class="ml-3 adri"><span class="fw-semibold">2. Mr John</span><br>Male , 30 yrs.</span></label>
										</div>
                </div>
              </div>
              <div class="fieldsets row m-auto pt-3 pb-3">
                	<div class="col-md-6">
                	</div>
                	<div class="col-md-6">
           				 		<button type="submit" name="submit" class="btn-main bg-btn1 btn-blue lnk text-uppercase  appyCouponBtn w-100" data-bs-dismiss="modal">Apply<span class="circle"></span></button>
           				</div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="popup-modals modal-ad-style coup-modal">
  <div class="modal" id="modal-cancelorder" tabindex="-1" >
    <div class="modal-dialog mwidth">
      <div class="modal-content">
        <div class="modal-header">
          <div class="common-heading">
            <h4 class="mt0 mb0">CANCEL ORDER #MF61</h4>
          </div>
          <button type="button" class="closes" data-bs-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-block fdgn2 mt10">
	            <form action="#" method="post" name="feedback-form">
	              <div class="fieldsets row">
	                <div class="col-md-12">
	                	<label>Cancel Remark</label>
	                	<textarea class="h-100px" placeholder="Address" name="message"></textarea>
	                </div>
	              </div>
	              <div class="row">
		              <div class="fieldsets mt10 pb20">
		                <button type="submit" name="submit" class="lnk btn-main bg-btn w-auto me-2" data-bs-dismiss="modal">Submit<span class="circle"></span></button>
		              </div>
	              </div>
	            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="popup-modals modal-ad-style coup-modal">
  <div class="modal" id="myModal-add-money" tabindex="-1" >
    <div class="modal-dialog mwidth">
      <div class="modal-content">
        <div class="modal-header border-0 align-items-end d-block">
          <button type="button" class="closes float-end" data-bs-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          	<div class="form-block fdgn2 mt10">
	            <form action="#" method="post" name="feedback-form">
	                <div class="row justify-content-center">
	                    <div class="col-lg-11 col-12">
	                        <div class="col-lg-12 mt__30 text-center mb-3 mt-2 col-12">
	                            <img src="images/add-money-wallet.png" alt="">
	                            <h5 class="mt-3">Add Money to your Wallet</h5>
	                        </div>
		              				<div class="fieldsets row">
		                        <div class="col-lg-12 col-12">
		                            <input type="text" placeholder="Enter Amount to be Added in Wallet" name="search_keyword" class="h-45">
		                        </div>
	                        </div>
	                        <div class="col-lg-12 mb-3 text-center radi-btn col-12">
	                            <label><input type="radio" name="deliver" checked="true"><span>+<i class="fas fa-rupee-sign"></i>50</span></label>
	                            <label><input type="radio" name="deliver"><span>+<i class="fas fa-rupee-sign"></i>100</span></label>
	                            <label><input type="radio" name="deliver"><span>+<i class="fas fa-rupee-sign"></i>500</span></label>
	                            <label><input type="radio" name="deliver"><span>+<i class="fas fa-rupee-sign"></i>1000</span></label>
	                        </div>
	                        <div class="col-lg-12 mb-3 mt-3 text-center col-12">
			               					<button type="submit" name="submit" class="lnk btn-main bg-btn w-auto" data-bs-dismiss="modal">Continue<span class="circle"></span></button>
	                        </div>
	                    </div>
	                </div>
	            </form>
         		</div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="popup-modals modal-ad-style">
  <div class="modal" id="modalform-Reschedule-Booking" tabindex="-1" >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <div class="common-heading">
            <h4 class="mt0 mb0">Reschedule Booking</h4>
          </div>
          <button type="button" class="closes" data-bs-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body ">
          <div class="form-block fdgn2 mt10 mb10">
            <form action="#" method="post" name="feedback-form">
              <div class="fieldsets row">
                <div class="col-md-12 mb-4">
                	<label class="f-semibold">Current Sample Collection Date & Time :</label>
                	<span class="text-blue d-block w-100 fs-14">15 Sep, 2022 (06:00 am - 07:00 am)</span>
                </div>
                <div class="col-md-12">
                	<label>Select New Reschedule Sample Collection Date</label>
                	<input type="date" placeholder="Date" name="date">
                </div>
                <div class="col-md-12">
                	<label>Select New Reschedule Sample Collection Time</label>
                	<select>
                			<option>Select Collection Time</option>
                			<option>Select Collection Time</option>
                			<option>Select Collection Time</option>
                	</select>
                </div>
                <div class="col-md-12">
                	<label>Select Reschedule Reason</label>
                	<select>
                			<option>Select Reason</option>
                			<option>Select Reason</option>
                			<option>Select Reason</option>
                	</select>
                </div>
              </div>
              <div class="fieldsets mt20 pb20 d-flex justify-content-center">
                <button type="submit" name="submit" class="lnk btn-main bg-btn w-auto" data-bs-dismiss="modal">Submit<span class="circle"></span></button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="popup-modals modal-ad-style coup-modal collectionmodal">
  <div class="modal" id="modal-homeCollection" tabindex="-1" >
    <div class="modal-dialog">
      <div class="modal-content">
      	<button type="button" class="closes abt" data-bs-dismiss="modal">×</button>
<div class="modal-body">
          <div class="col-md-12 mt-5 mb-4 col-12">
            <div class="row justify-content-center">
              <div class="col-md-12 text-center">
              	<img class="img_del_boy_modal" src="images/Dlrvry_Boy.png" alt="">
                <h3 class="mb10 mt20">Home Sample Collection Service.</h3>
                <p>Blood tests can be done through home blood sample collection services.</p>
                <p>Click "Yes" if you want to avail Home Collection Service or Click "No" to give your same at your nearest Collection Point</p>
              </div>
            </div>
            <div class="row justify-content-center mt40">
              <div class="col-md-12 colecbtns text-center">
              		<button type="button" onclick="changeHomeCollectionStatus('Yes')" class="btn lnk btn-main bg-btn bg-success">Yes <span class="circle"></span></button>
              		<button type="button" onclick="changeHomeCollectionStatus('No')" class="btn lnk btn-main bg-btn bg-danger">No <span class="circle"></span></button>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--<script type="text/javascript">
var LHCChatOptions = {};
LHCChatOptions.opt = {widget_height:340,widget_width:300,popup_height:520,popup_width:500};
(function() {
var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
var referrer = (document.referrer) ? encodeURIComponent(document.referrer.substr(document.referrer.indexOf('://')+1)) : '';
var location = (document.location) ? encodeURIComponent(window.location.href.substring(window.location.protocol.length)) : '';
po.src = 'https://chatserver.mdrcindia.com/index.php/chat/getstatus/(click)/internal/(position)/bottom_right/(ma)/br/(top)/350/(units)/pixels/(disable_pro_active)/true?r='+referrer+'&l='+location;
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
})();
</script>
end Modal html  -->


<!-- Google tag (gtag.js) -->

 

<?php } ?>