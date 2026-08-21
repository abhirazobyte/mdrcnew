
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
   <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css'>
   <link href="css/custom.css" rel="stylesheet">
<!--Start Header -->
<?php include 'includes/header.php';?>
<!--End Header -->
<!--Start Hero-->
<section class="hero-card-web h-auto bannir" data-background="images/bg_banner.png" style="background-size: cover;">
 <div class="hero-main-rp container-fluid">
    <div class="row align-items-center">
       <div class="col-lg-5">
          <div class="hero-heading-sec">
             <h1 class="wow fadeIn text-white f-bold" data-wow-delay="0.3s"><?=$this->records_doctors['title']?></h1>
             <p class="wow fadeIn mt30" data-wow-delay="0.6s"><?=$this->records_doctors['short_desc']?></p>
             <?php if($this->records_doctors['button_name']!=''){?>
             <a href="<?=$this->records_doctors['button_link']?>" class="scrollTo niwax-btn2 wow fadeIn"  data-wow-delay="0.8s"><?=$this->records_doctors['button_name']?> <i class="fas fa-chevron-right fa-ani"></i></a>
            <?php }?>
             <div class="col-12 mt-4 p-0">
               <h6 class="text-white mb-3">Accreditations</h6>
             </div>
             <div class="col-12 cl-logo d-flex p-0">
                <div class="clients-logo">
                  <div>
                     <img src="images/nabh-logo.png" alt="text" class="img-fluid">
                     <span>MIS- 2017-0045</span>
                     <!-- <img src="images/accred-1.png" alt="text" class="img-fluid"> -->
                  </div>
               </div>
                <!-- <div class="clients-logo">
                  <div>
                     <img src="images/cap-logo.png" alt="text" class="img-fluid">
                     <img src="images/accred-2.png" alt="text" class="img-fluid"> 
                     <span>CAP No. 8498566</span>
                  </div>
                 </div> -->
                <div class="clients-logo">
                  <div>
                     <img src="images/nabl-new-logo.png" alt="text" class="img-fluid">
                     <!-- <img src="images/accred-3.png" alt="text" class="img-fluid"> -->
                     <span>MC-2334</span>
                  </div>
               </div>
            </div>
          </div>
       </div>
       <div class="col-lg-7">
          <div class="hero-right-scmm">
             <div class="hero-service-cards wow fadeInRight" data-wow-duration="2s">
                <div class="owl-carousel service-card-prb">
                  <?php for ($i=0; $i < count($this->records_services); $i++) {
                  $image = $this->utility->get_image_path($this->records_services[$i]['image'], 'for_doctors_services', 'large'); ?>
                   <div class="service-slide card-bg-a" data-tilt data-tilt-max="10" data-tilt-speed="1000">
                      <a class="scrollTo" href="service/<?=$this->category.'/'.$this->records_services[$i]['slug']?>">
                         <div class="service-card-hh">
                            <div class="image-sr-mm">
                               <img alt="custom-sport" src="<?=$image?>">
                            </div>
                            <div class="title-serv-c"><?=$this->records_services[$i]['title']?></div>
                         </div>
                      </a>
                   </div>
                  <?php }?>
                </div>
             </div>
          </div>
       </div>
    </div>
 </div>
</section>
<section class="badges-section  special-sec pad-tb about-sec-app">
 <div class="container">
    <div class="row mb40 justify-content-center">
       <div class="col-lg-8">
          <div class="common-heading-2 w-tdxt">
             <h2 class="mb-1">Our Specialities</h2>
             <p class="text-202024 text-center">All Diagnostic Services Under One Roof</p>
          </div>
       </div>
    </div>
    <div class="row">
       <div class="col-lg-3 col-md-6 col-6 wow fadeIn" data-wow-delay=".2s">
         <div class="s-block wide-sblock h-100">
            <div class="s-card-icon"><img src="images/a.png" alt="service" class="img-fluid"></div>
            <div class="s-block-content">
               <h4>Routine Testing</h4>
               <p>Routine investigations coverage from wellness to illness</p>
            </div>
         </div>
       </div>
       <div class="col-lg-3 col-md-6 col-6 wow fadeIn" data-wow-delay=".4s">
         <div class="s-block wide-sblock h-100">
            <div class="s-card-icon"><img src="images/b.png" alt="service" class="img-fluid"></div>
            <div class="s-block-content">
               <h4>Pathology Services</h4>
               <p>Super specialized department to diagnose auto immune disorders</p>
            </div>
         </div>
       </div>
       <div class="col-lg-3 col-md-6 col-6 wow fadeIn" data-wow-delay=".6s">
         <div class="s-block wide-sblock h-100">
            <div class="s-card-icon"><img src="images/c.png" alt="service" class="img-fluid"></div>
            <div class="s-block-content">
               <h4>Genomic Testing</h4>
               <p>Advanced genetic testing to know your health risks</p>
            </div>
         </div>
       </div>
       <div class="col-lg-3 col-md-6 col-6 wow fadeIn" data-wow-delay=".8s">
         <div class="s-block wide-sblock h-100">
            <div class="s-card-icon"><img src="images/d.png" alt="service" class="img-fluid"></div>
            <div class="s-block-content">
               <h4>Radiology</h4>
               <p>Advanced Medical Imaging procedures for your health diagnosis</p>
            </div>
         </div>
       </div>
    </div>
    <div class="-cta-btn mt70">
       <div class="free-cta-title v-center wow fadeInUp" data-wow-delay="1s">
          <p>We <span>Promise.</span> We <span>Deliver.</span></p>
       </div>
    </div>
 </div>
</section>
<section class="pb40 pt40 healthSection d-none">
    <div class="container">
        <div class="row section-title">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="common-heading-2 text-start">
                    <h2 class="mb30 text-white">Best Health Packages in India</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
            <hr class="line"/>
         </div>
        </div>
        <div class="row">
            <div class="col-sm-12 position-relative mt30">
            <div class="package-slider owl-carousel">
               <div class="items">
                  <div class="pricing-table ">
                     <div class="inner-table">
                        <span class="title">Swasthya Panel Details</span>
                        <ul class="list-style-  disc-list mt-3 mb30 pb5">
                           <li><span>25 Hydroxy Vitamin D</span></li>
                           <li><span>Urine Routine Examination</span></li>
                           <li><span>Kidney Function Test 4</span></li>
                           <li><span>Lipid Profile</span></li>
                           <li><span>Liver Function Test</span></li>
                           <li><span>Plasma Glucose - Fasting</span></li>
                        </ul>
                        <div class="d-info d-inline-block w-100">
                           <h4>Offer Price: <span class="float-end"><i class="fas fa-rupee-sign"></i>399 <del><i class="fas fa-rupee-sign"></i>580</del></span></h4>
                           <a href="#" class="btn-main bg-btn1 btn-blue lnk wow fadeInUp text-uppercase">Book Now<span class="circle"></span></a>
                           <a href="#" class="btncart float-end"><img src="images/icon-cart.png" alt="" /><span class="circle"></span></a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="items">
                  <div class="pricing-table ">
                     <div class="inner-table">
                        <span class="title">Swasthya Panel Details</span>
                        <ul class="list-style-  disc-list mt-3 mb30 pb5">
                           <li><span>25 Hydroxy Vitamin D</span></li>
                           <li><span>Urine Routine Examination</span></li>
                           <li><span>Kidney Function Test 4</span></li>
                           <li><span>Lipid Profile</span></li>
                           <li><span>Liver Function Test</span></li>
                           <li><span>Plasma Glucose - Fasting</span></li>
                        </ul>
                        <div class="d-info d-inline-block w-100">
                           <h4>Offer Price: <span class="float-end"><i class="fas fa-rupee-sign"></i>399 <del><i class="fas fa-rupee-sign"></i>580</del></span></h4>
                           <a href="#" class="btn-main bg-btn1 btn-blue lnk wow fadeInUp text-uppercase">Book Now<span class="circle"></span></a>
                           <a href="#" class="btncart float-end"><img src="images/icon-cart.png" alt="" /><span class="circle"></span></a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="items">
                  <div class="pricing-table ">
                     <div class="inner-table">
                        <span class="title">Swasthya Panel Details</span>
                        <ul class="list-style-  disc-list mt-3 mb30 pb5">
                           <li><span>25 Hydroxy Vitamin D</span></li>
                           <li><span>Urine Routine Examination</span></li>
                           <li><span>Kidney Function Test 4</span></li>
                           <li><span>Lipid Profile</span></li>
                           <li><span>Liver Function Test</span></li>
                           <li><span>Plasma Glucose - Fasting</span></li>
                        </ul>
                        <div class="d-info d-inline-block w-100">
                           <h4>Offer Price: <span class="float-end"><i class="fas fa-rupee-sign"></i>399 <del><i class="fas fa-rupee-sign"></i>580</del></span></h4>
                           <a href="#" class="btn-main bg-btn1 btn-blue lnk wow fadeInUp text-uppercase">Book Now<span class="circle"></span></a>
                           <a href="#" class="btncart float-end"><img src="images/icon-cart.png" alt="" /><span class="circle"></span></a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="items">
                  <div class="pricing-table ">
                     <div class="inner-table">
                        <span class="title">Swasthya Panel Details</span>
                        <ul class="list-style-  disc-list mt-3 mb30 pb5">
                           <li><span>25 Hydroxy Vitamin D</span></li>
                           <li><span>Urine Routine Examination</span></li>
                           <li><span>Kidney Function Test 4</span></li>
                           <li><span>Lipid Profile</span></li>
                           <li><span>Liver Function Test</span></li>
                           <li><span>Plasma Glucose - Fasting</span></li>
                        </ul>
                        <div class="d-info d-inline-block w-100">
                           <h4>Offer Price: <span class="float-end"><i class="fas fa-rupee-sign"></i>399 <del><i class="fas fa-rupee-sign"></i>580</del></span></h4>
                           <a href="#" class="btn-main bg-btn1 btn-blue lnk wow fadeInUp text-uppercase">Book Now<span class="circle"></span></a>
                           <a href="#" class="btncart float-end"><img src="images/icon-cart.png" alt="" /><span class="circle"></span></a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="owl-theme">
               <div class="owl-controls">
                  <div class="custom-nav owl-nav"></div>
               </div>
            </div>
         </div>
            <div class="col-sm-12 col-12 mt-2 text-center">
            <a href="#" class="btn-main bdrbtn bg-btn4 lnk">View All <img src="images/right-arrow-white.png" alt="" /><span class="circle"></span></a>
            </div>
        </div>
    </div>
</section>
<!--Start-->
<section id="servicesGrids" class="element-page pt50 pb50 healthSection">
   <div class="container">
      <div class="row">

         <?php for ($i=0; $i < count($this->records_services); $i++) {
          $image = $this->utility->get_image_path($this->records_services[$i]['image'], 'for_doctors_services', 'large'); ?>
          <div class="col-lg-4 col-sm-4 mt40 wow fadeIn" data-wow-delay="0.2s">
              <div class="isotope_item up-hor">
                  <div class="item-image">
                      <a href="service/<?=$this->category.'/'.$this->records_services[$i]['slug']?>"><img src="<?=$image?>" alt="image" class="img-fluid" /> </a>
                  </div>
                  <div class="item-info-div shdo">
                      <h4><a href="service/<?=$this->category.'/'.$this->records_services[$i]['slug']?>"><?=$this->records_services[$i]['title']?></a></h4>
                  </div>
              </div>
          </div>
         <?php }?>

      </div>
   </div>
</section>
<!--End -->
<section class="service why-service-sec  pad-tb pt140">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="image-block upset bg-shape">
                    <img src="images/img-why.png" alt="image" class="img-fluid"/>
                </div>
            </div>
            <div class="col-lg-8 block-1">
                <div class="common-heading text-l pl25">
                    <h2>Why Us?</h2>
                    <p>We are India’s fastest-growing diagnostic service provider, with a presence in more than 120 cities. We offer a holistic in-house end-to-end solution - Right from the time of receiving a call, to the home collection, testing of the sample, generating report and mailing it further to the patient, every step is carefully and professionally executed by the experienced in-house team. Our expertise lies in on-demand 1-hour home collection and same-day reports within 24 hours<sup>*</sup> (T&C apply). All our owned pathology labs and diagnostic centres are equipped with state-of-the-art infrastructure and staffed with a highly trained medical team to meet the testing requirements of the patients. Our automated processes ensure minimal human interference, which helps maintain a high degree of accuracy that leads to better patient diagnosis.</p>
                </div>
           <div class="row small glassmorphism  m-auto pt40">
               <div class="col-lg-4 col-sm-4">
                   <div class="statistics">
                       <div data-tilt data-tilt-max="20" data-tilt-speed="1000" class="statistics-img">
                           <img src="images/icons/deal.svg" alt="happy" class="img-fluid" />
                       </div>
                       <div class="statnumb">
                           <span class="counter">38</span><span>+</span>
                           <p>Years Of Experience</p>
                       </div>
                   </div>
               </div>
               <div class="col-lg-4 col-sm-4">
                   <div class="statistics">
                       <div data-tilt data-tilt-max="20" data-tilt-speed="1000" class="statistics-img">
                           <img src="images/icons/computers.svg" alt="project" class="img-fluid" />
                       </div>
                       <div class="statnumb counter-number">
                           <span class="counter">5</span> <span class=""> Crore+</span>
                           <p>Tests Done So Far</p>
                       </div>
                   </div>
               </div>
               <div class="col-lg-4 col-sm-4">
                   <div class="statistics">
                       <div data-tilt data-tilt-max="20" data-tilt-speed="1000" class="statistics-img">
                           <img src="images/icons/worker.svg" alt="work" class="img-fluid" />
                       </div>
                       <div class="statnumb">
                           <span class="counter">20</span>
                           <p>Labs in India</p>
                       </div>
                   </div>
               </div>
               <!-- <div class="col-lg-4 col-sm-6">
                   <div class="statistics mb0">
                       <div data-tilt data-tilt-max="20" data-tilt-speed="1000" class="statistics-img">
                           <img src="images/icons/customer-service.svg" alt="support" class="img-fluid" />
                       </div>
                       <div class="statnumb">
                           <span>Health Packages</span>
                           <p>Preventive Health Check Packages</p>
                       </div>
                   </div>
               </div> -->
           </div>
            </div>
        </div>
    </div>
</section>
<section id="how-work" class="pt50 middi pb80 ste4 bg-gradient15 modersec">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
            <div class="row section-title">
               <div class="col-sm-12 text-center col-12">
                  <div class="common-heading-2 text-center">
                     <h2 class="mb30">Get safe testing with MODERN labs</h2>
                  </div>
               </div>
            </div>
         </div>
        </div>
        <div class="row section-title">
            <div class="col-sm-3 text-start text-lg-center text-md-center position-relative">
                <div class="how-works-block text-start">
                    <!-- <img class="harrow" src="images/harrow.png" alt=""> -->
                    <div class="img"><img src="images/searchtest.png" alt=""></div>
                    <h5>
                        <span>Call and schedule an appointment with our Health Expert</span><br>
                    </h5>
                </div>
            </div>
            <div class="col-sm-3 text-start text-lg-center text-md-center position-relative">
                <div class="how-works-block text-start">
                    <!-- <img class="harrow mid" src="images/harrow.png" alt=""> -->
                    <div class="img" style="
    padding: 11px;
"><img src="images/secudletest.png" alt=""></div>
                    <h5 class="midd">
                        <span>We will Schedule appointment as per your availability and pick sample from your home</span><br>
                    </h5>
                </div>
            </div>
            <div class="col-sm-3 text-start text-lg-center text-md-center position-relative">
                <div class="how-works-block text-start">
                    <!-- <img class="harrow mid" src="images/harrow.png" alt=""> -->
                    <div class="img" style="
    padding: 26px 19px;
"><img src="images/sampletest.png" alt="" style="
    max-width: 81px;
"></div>
                    <h5 class="midd">
                        <span>High Quality Lab testing done in our Accredited Labs</span><br>
                    </h5>
                </div>
            </div>
            <div class="col-sm-3 text-start text-lg-center text-md-center position-relative">
                <div class="how-works-block text-start">
                    <div class="img" style="
    padding: 19px 19px;
    min-width: 119px;
    text-align: center;
"><img src="images/dwnload_report.png" alt=""></div>
                    <h5>
                        <span>Get your test reports over whatsapp or Download from your web account.</span><br>
                    </h5>
                </div>
            </div>
        </div>
    </div>
</section>
         <!--Start Testinomial-->
         <section class="bg-art-pic " style="display:block">
	<section class=" pt30 testimonials">
		<div class="container">
			<div class="row pt-5">
				<div class="col-lg-4  col-md-7">
					<div class="common-heading-2 text-start">
						<h2 class="mb0 lh-16">What Customer say</h2>
						<!--<p class="text-101010">Lorem ipsum is a placeholder text commonly </p>-->
					</div>
				</div>
				<div class="col-lg-8  col-md-5 mt-3 mt-lg-0 mt-md-0 border-start ps-lg-5 m-minus reviewimgs">
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
											<h4>
												<?= $this->rs_testimonial[$i]['name'] ?>
											</h4>
											<p>
												<?= $this->rs_testimonial[$i]['city'] ?><br />Service Rated <a href="javascript:void(0)" class="chked"><i class="fa fa-star"></i></a>
												<?= $this->rs_testimonial[$i]['ratting'] ?>
											</p>
										</div>
									</div>
									<div class="review-text text-start">
										<div class="col"> <span class="revbx-lr"><img src="images/img-quote.png" alt="quote" /></span> </div>
										<p>
											<?= $this->rs_testimonial[$i]['content'] ?>
										</p>
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
</section>
         <!--End Testinomial-->
<!--Start Footer -->
<?php include 'includes/footer.php';?>
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
<?php include 'includes/general_data.php';?>