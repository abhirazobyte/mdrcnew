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

<!--Breadcrumb Area-->
<section class="breadcrumb-area banner-6 d-none">
  <div class="text-block">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-start v-center">
          <div class="bread-inner">
            <div class="bread-menu wow fadeInUp" data-wow-delay=".2s">
              <ul>
                <li><a href="index">Home</a></li>
                <li><a href="about-us">About Us</a></li>
              </ul>
            </div>
            <div class="bread-title wow fadeInUp" data-wow-delay=".5s">
              <h2>About Us</h2>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--End Breadcrumb Area-->

<section class="booking-inquiry bipage pt30 pb50" data-background="images/bg_banner.png" style="background-size: cover;">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-5 col-md-6 col-12">
        <div class="common-heading-1 text-l text-center text-lg-start text-md-start">
          <h1 class="mb20 text-center text-lg-start text-md-start text-white fs-1">Not able to find your test?</h1>


          <p class="text-white">MDRC is one of the few Diagnostic Companies in India which offers more than 2500 tests, ranging from Molecular to Whole Body Imaging. </p><br />

          <p class="text-white">MODERN is accredited with ilac-MRA, NABL & NABH which strengthens our commitment to Quality and Accuracy in our reports. </p><br />

          <p class="text-white">Please fill up the following details to get a call back on your enquiry.</p>
        </div>
      </div>

      <?php $name = '';
      if ($this->rs_customer['name'] != '') {
        $name = $this->rs_customer['name'] . " " . $this->rs_customer['last_name'];
      }
      ?>

      <div class="col-lg-7 col-md-6 lead-intro-  col-12">
        <div class="form-block formcover shadow">
          <form method="post" id="prescription_booking" name="prescription_booking" class="shake mt30">

            <div class="row">
              <div class="form-group">
                <label class="text-dark ms-0 me-2 mt-2"><input type="radio" value="New Booking" id="enquiry_new_booking" name="enquiry_type" checked> New Booking</label>
                <label class="text-dark"><input type="radio" value="Customer Support Query" id="enquiry_customer_support" name="enquiry_type"> Customer Support Query</label>
              </div>
            </div><br/>

            <div class="row">
              <div class="form-group col-sm-12">
                <input type="text" id="name" placeholder="Full Name*" name="name" required="" value="<?= $name ?>" data-error="Please fill Out">
                <div class="help-block with-errors"></div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6">
                <input type="text" id="phone" name="phone" value="<?= $this->rs_customer['phone'] ?>" placeholder="Phone*" class="numbersOnly" required="" data-error="Please fill Out">
                <div class="help-block with-errors"></div>
              </div>
              <div class="form-group col-sm-6">
                <select name="city" id="city" required="">
                  <option value="">Select City</option>
                  <?php for ($i = 0; $i < count($this->rs_gs_city); $i++) { ?>
                    <option value="<?= $this->rs_gs_city[$i]['name'] ?>"><?= $this->rs_gs_city[$i]['name'] ?></option>
                  <?php } ?>
                </select>
                <div class="help-block with-errors"></div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6">
                <label for="file" class="form-label">Upload Prescription</label>
                <input class="form-control" type="file" id="pre_file" name="pre_file">
              </div>
            </div>

            <div class="row">
              <div class="form-group">
                <label class="text-dark ms-0 me-2 mt-2"><input type="radio" value="Blood Test" id="test_blood_test" name="test_type"> Blood Test</label>
                <label class="text-dark"><input type="radio" value="MRI/CT Scan Etc" id="test_mri_ctscan" name="test_type" checked> MRI CT Scan Ultrasound X-ray etc</label>
              </div>
            </div><br/>

            <div class="cf-turnstile" data-sitekey="0x4AAAAAAAbKtvxHo9oxETke"></div>

            <button type="submit" class=" mt-2 lnk btn-main bg-btn prescription_booking_btn">Submit <i class="fas fa-chevron-right fa-icon"></i><span class="circle"></span></button>
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

  </div>

</section>



<section class="about-lead-gen pt40 pb40">

  <div class="container">

    <div class="row align-items-center">

      <div class="col-lg-12">

        <div class="row small text-center text-lg-start text-md-start t-ctr mt0">

          <div class="col-lg-3 col-3">

            <div class="statistics">

              <div class="statnumb text-center text-lg-start text-md-start">

                <span class="counter">38</span><span>+</span>

                <p>Years Of Experience</p>

              </div>

            </div>

          </div>

          <div class="col-lg-3 col-3">

            <div class="statistics">

              <div class="statnumb text-center text-lg-start text-md-start">

                <span class="counter">5</span><span>&nbsp;Crore+</span>

                <p>Tests Done So Far</p>

              </div>

            </div>

          </div>

          <div class="col-lg-3 col-3">

            <div class="statistics">

              <div class="statnumb text-center text-lg-start text-md-start">

                <span class="counter">20</span>

                <p>Labs in India</p>

              </div>

            </div>

          </div>

          <div class="col-lg-3 col-3">

            <div class="statistics">

              <div class="statnumb text-center text-lg-start text-md-start">

                <span class="counter">70</span><span>&nbsp;lac+</span>

                <p>Satisfied Customers</p>

              </div>

            </div>

          </div>

        </div>

      </div>

    </div>

  </div>

</section>





<!--Start Mission Vision-->

<section class="missionvision dark-bg4 pb40 pt40  bg-gradient9">

  <div class="container">

    <!-- <div class="row"> -->

    <!-- <div class="col-lg-6 col-sm-12"> -->

    <!-- <h2>A group of creative minds dedicated to creating the best apps and websites in the world.</h2> -->

    <!-- </div> -->

    <!-- <div class="col-lg-6 col-sm-12"> -->

    <!-- <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p> -->

    <!-- <p class="mt15">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p> -->

    <!-- </div> -->

    <!-- </div> -->

    <div class="row">

      <div class="col-lg-6  text-center text-lg-start text-md-start col-sm-12 mb0 mb-4 mb-lg-0 mb-md-0">

        <div class="s-block2">

          <div class="card-icon"><img src="images/icons/vision.png" alt="icon" class="w80 mb20"></div>

          <h3>Our Vision</h3>

          <p class="mt15">To become a leading diagnostic services provider in the country with unhinged focus on providing accurate, efficient & Cutting edge diagnostic services to our patients.</p>

        </div>

      </div>

      <div class="col-lg-6  text-center text-lg-start text-md-start col-sm-12 mb0">

        <div class="s-block2">

          <div class="card-icon"><img src="images/icons/mountain.png" alt="icon" class="w80 mb20"></div>

          <h3>Our Mission</h3>

          <p class="mt15">To obtain & deploy the best and latest technologies in the world, to diagnose ailments of our patients in a accurate, timely and cost effective manner. </p>

        </div>

      </div>

    </div>

  </div>

</section>

<!--End Mission Vision-->



<!--Start Mission Vision-->

<section class="teb-section  pb50 pt40 ">

  <div class="container">

    <div class="row justify-content-center">

      <div class="col-lg-8">

        <div class="common-heading-2">

          <h2 class="mb10">Our Accreditations</h2>

        </div>

      </div>

    </div>

    <div class="row">

      <div class="col-lg-12 col-xs-12 col-12">

        <div class="tabs-layout">

          <ul class="nav nav-tabs text-center" id="myTab1" role="tablist">


            <li class="nav-item">

              <a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false"><img src="images/nabl-logo.png" alt="" /> NABL Accredited Lab</a>

            </li>



            <li class="nav-item">

              <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"><img src="images/nabh-logo.png" alt="" /> NABH Accredited Imaging Centre</a>

            </li>

          </ul>

          <div class="tab-content" id="myTabContent1">


            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">

              <div class="row">

                <div class="col-lg-3 text-center imgg col-xs-12 col-12">

                  <img src="images/nabl-logo.png" alt="" />

                </div>

                <div class="col-lg-9 common-heading-2 text-start col-xs-12 col-12">

                  <h6 class="mt0 text-202024 mb10">NABL Accredited Lab</h6>

                  <p class="text-202024">MDRC has laid great emphasis on its Quality Control in all the labs across India. To reflect our commitment towards accurate reports, we have 6 NABL Labs across India following high standards of quality control to get accurate and consistent results.</p>

                  <p class="text-202024">MDRC follows strict internal and external quality control programs. We run daily controls and regular calibrations and follow regular External Quality Assurance Programs with RANDOX Laboratories UK, AIIMS and CMC Vellor.</p>

                  <p class="text-202024">Our labs have latest fully automatic equipments which gives consistent and correct results in all fields such as Haematology, Serology, Immunology, Electrophoresis, Clinical Pathology, Microbiology, Molecular and Cytogenetics, Real time PCR etc.</p>

                </div>

              </div>

            </div>



            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

              <div class="row">

                <div class="col-lg-3 text-center imgg col-xs-12 col-12">

                  <img src="images/nabh-logo.png" alt="" />

                </div>

                <div class="col-lg-9 common-heading-2 text-start col-xs-12 col-12">

                  <h6 class="mt0 text-202024 mb10">NABH Accredited Imaging Centre</h6>

                  <p class="text-202024">MDRC Diagnostic centre at Sector 44, Gurugram and our Reference Lab at New Railway Road, Gurugram are NABH accredited.</p>

                  

                  <p class="text-202024">Medical Imaging Services cover all investigations of patients which are helpful in diagnosis, prevention and treatment of diseases or ascertaining the health of patients. It includes wide variety of imaging techniques using latest technologies such as Ultrasound, MRI, CT scan etc. The clinical advantages of these services are enormous as quality imaging affects critical decision-making at every stage of patient management.</p>
                  <p class="text-202024"><strong>Patient Safety:</strong> We give special attention to the safety of our patients by ensuring minimal contrast administration and ensuring that the radiation dose is kept to minimum level possible.</p>

                  <ul class="list-style- text-202024">

                    <li>Maintain accuracy of test results and ensure accurate patient diagnosis</li>

                    <li>Meet required standards from CLIA, FDA and OSHA. </li>

                    <li>Manage rapidly evolving changes in laboratory medicine and technology</li>

                    <li>Exchange ideas and best practices among pathology and laboratory medicine peers</li>

                    <li>Offer professional development and learning opportunities for laboratory staff</li>

                  </ul>

                </div>

              </div>

            </div>



          </div>

        </div>

      </div>

    </div>

    <div class="row mt40 justify-content-center">

      <div class="col-lg-4 wow fadeInUp" data-wow-delay=".2s">

        <div class="col-lg-12 icr shadow s-block up-hor bd-hor-base srcl3 text-start">

          <img src="images/img-lab.png" />

          <h2 class="f_s">20+ Labs across 8 States</h2><span>Uttar Pradesh, Haryana, Rajasthan, West Bengal, Assam, Jammu & Kashmir, Madhya Pradesh</span>

        </div>

      </div>

      <div class="col-lg-4 wow fadeInUp" data-wow-delay=".4s">

        <div class="col-lg-12 icr shadow s-block up-hor bd-hor-base srcl4 text-start">

          <img src="images/img-globe.png" />

          <h3 class="f_s">International Reach</h3><span>MDRC has international reach and get samples from UAE, Kenya, Uganda, Nigeria & Nepal.</span>

        </div>

      </div>

      <div class="col-lg-4 wow fadeInUp" data-wow-delay=".6s">

        <div class="col-lg-12 icr shadow s-block up-hor bd-hor-base srcl5 text-start">

          <img src="images/img-collection.png" />

          <h4 class="f_s">1800+ Touch points across India</h4><span>MDRC offers complete range of diagnostic facilities in Radiology & Pathology under one roof.</span>

        </div>

      </div>

    </div>



    <div class="row upset ovr-bg2 bd-hor d-none">

      <div class="col-lg-4 col-sm-6 mt30 wow fadeInUp" data-wow-delay=".2s">

        <div class="s-block up-hor bd-hor-base">

          <div class="nn-card-set">

            <div class="s-card-icon"><img src="images/img-lab.png" /></div>

            <h4>15 Labs across 7 States<br /><span>Uttar Pradesh, Haryana, Rajasthan, West Bengal, Assam, Jammu & Kashmir, Madhya Pradesh</span>

          </div>

        </div>

      </div>

      <div class="col-lg-4 col-sm-6 mt30 wow fadeInUp" data-wow-delay=".4s">

        <div class="s-block up-hor bd-hor-base">

          <div class="nn-card-set">

            <div class="s-card-icon"><img src="images/img-globe.png" class="" /></div>

            <h4>International network <br /><span>UAE, Kenya, Uganda, Nigeria & Nepal.</span>

          </div>

        </div>

      </div>

      <div class="col-lg-4 col-sm-6 mt30 wow fadeInUp" data-wow-delay=".6s">

        <div class="s-block up-hor bd-hor-base">

          <div class="nn-card-set">

            <div class="s-card-icon"><img src="images/img-collection.png" /></div>

            <h4>1800+ Collection Points<br /><span>Lorem ipsum dolor sit amet, Discit amet lorem ipsum</span>

          </div>

        </div>

      </div>

    </div>



  </div>

</section>

<!--End Mission Vision-->



<!--Start Hero-->

<section class="sliders-section pb50 pt40 bg-gradient5">

  <div class=" container">

    <div class="row justify-content-center">

      <div class="col-lg-8">

        <div class="common-heading-2">

          <h2 class="mb20">Our vast array of testing portfolio caters to</h2>

        </div>

      </div>

    </div>

    <div class="row">

      <div class="col-lg-12">

        <div class="hero-right-scmm">

          <div class="hero-service-cards mt-0 wow fadeInRight" data-wow-duration="2s">

            <div class="owl-carousel service-card-prb1">

              <div class="service-slide card-bg-a" data-tilt data-tilt-max="10" data-tilt-speed="1000">

                <a href="#">

                  <div class="service-card-hh">

                    <div class="image-sr-mm">

                      <img alt="custom-sport" src="images/sl-1.png">

                    </div>

                    <div class="title-serv-c">Imaging</div>

                  </div>

                </a>

              </div>

              <div class="service-slide card-bg-b" data-tilt data-tilt-max="10" data-tilt-speed="1000">

                <a href="#">

                  <div class="service-card-hh">

                    <div class="image-sr-mm">

                      <img alt="custom-sport" src="images/sl-2.png">

                    </div>

                    <div class="title-serv-c">Pathology</div>

                  </div>

                </a>

              </div>

              <div class="service-slide card-bg-c" data-tilt data-tilt-max="10" data-tilt-speed="1000">

                <a href="#">

                  <div class="service-card-hh">

                    <div class="image-sr-mm">

                      <img alt="custom-sport" src="images/sl-3.png">

                    </div>

                    <div class="title-serv-c">High end Pathology</div>

                    <!-- <div class="title-serv-c">High end Pathology & Moledular Services</div> -->

                  </div>

                </a>

              </div>

              <div class="service-slide card-bg-d" data-tilt data-tilt-max="10" data-tilt-speed="1000">

                <a href="#">

                  <div class="service-card-hh">

                    <div class="image-sr-mm">

                      <img alt="custom-sport" src="images/sl-4.png">

                    </div>

                    <div class="title-serv-c">Radiology</div>

                  </div>

                </a>

              </div>

              <div class="service-slide card-bg-e" data-tilt data-tilt-max="10" data-tilt-speed="1000">

                <a href="#">

                  <div class="service-card-hh">

                    <div class="image-sr-mm">

                      <img alt="custom-sport" src="images/sl-5.png">

                    </div>

                    <div class="title-serv-c">Laboratory</div>

                  </div>

                </a>

              </div>

            </div>

          </div>

        </div>

      </div>

    </div>

  </div>

</section>

<!--End Hero-->



<section class="pb40 pt30 photoGallery" style="background:none;">

  <div class="container">

    <div class="row m-auto justify-content-center">

      <div class="col-lg-8">

        <div class="common-heading-2">

          <h2 class="mb40">Our Network</h2>

        </div>

      </div>

    </div>

    <div class="row align-items-center">

      <div class="col-lg-7 text-center">

        <img src="images/img-map2.png" alt="" class="">

      </div>

      <div class="col-lg-5">

        <div class="row ">

          <div class="col-lg-6 mb-3">

            <div class="full-image-card hover-scale m-0">

              <div class="image-div"><a href="#"><img src="images/network-5.png" alt="team" class="img-fluid"></a></div>

            </div>

          </div>

          <div class="col-lg-6 mb-3">

            <div class="full-image-card hover-scale m-0">

              <div class="image-div"><a href="#"><img src="images/network-6.png" alt="team" class="img-fluid"></a></div>

            </div>

          </div>

          <div class="col-lg-6 mb-3">

            <div class="full-image-card hover-scale m-0">

              <div class="image-div"><a href="#"><img src="images/network-7.png" alt="team" class="img-fluid"></a></div>

            </div>

          </div>

          <div class="col-lg-6 mb-3">

            <div class="full-image-card hover-scale m-0">

              <div class="image-div"><a href="#"><img src="images/netwrork-4.png" alt="team" class="img-fluid"></a></div>

            </div>

          </div>

        </div>

      </div>

    </div>

    <div class="row m-auto d-none">

      <div class="col-lg-12 ">

        <ul>

          <li><a href="#"><img src="images/look-1.png" alt="" class=""></a></li>

          <li><a href="#"><img src="images/look-2.png" alt="" class=""></a></li>

          <li><a href="#"><img src="images/look-3.png" alt="" class=""></a></li>

          <li class="multiImg">

            <a href="#"><img src="images/look-4.png" alt="" class=""></a>

            <a href="#"><img src="images/look-5.png" alt="" class=""></a>

          </li>

          <li><a href="#"><img src="images/look-6.png" alt="" class=""></a></li>

        </ul>

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
<script>
  function refreshTurnstile() {
    turnstile.reset('.cf-turnstile');
    console.log('captcha regenerate.');
  }

  // Refresh the Turnstile token every 2 minutes (120000 milliseconds)
  setInterval(refreshTurnstile, 120000);
</script>