<?php include 'includes/header.php'; ?>

<main class="main-btm-pd bg-white page-common">
   <!-- About banner start -->
   <div class="card bg-theme rounded-0 border-0 pt-3">
      <h2 class="font-lg text-center text-white mb-3 px-3"><?= $this->records_doctors['title'] ?></h2>
      <p class="text-white text-center px-3">
         <?= $this->records_doctors['short_desc'] ?>
      </p>
     <!--  <//?php if ($this->records_doctors['button_name'] != '') { ?>
         <a href="<//?= $this->records_doctors['button_link'] ?>" class="btn btn-solid btn-sm bg-white text-dark shadow1 wd-150 d-inline-block"><//?= $this->records_doctors['button_name'] ?></a>
      <//?php } ?> -->

        <div class="offer-wrap modern-lab-slider">
         <?php for ($i = 0; $i < count($this->records_services); $i++) {
            $image = $this->utility->get_image_path($this->records_services[$i]['image'], 'for_doctors_services', 'large'); ?>
            <div class="product-list media bg-transparent">
               <div class="bg-white rounded">
               <a href="<?=SERVER_ROOT;?>/service/<?= $this->category . '/' . $this->records_services[$i]['slug'] ?>"><img src="<?= $image ?>" class="img-fluid rounded" alt="offer"></a>
               <div class="media-body py-2 px-3">
                  <a href="<?=SERVER_ROOT;?>/service/<?= $this->category . '/' . $this->records_services[$i]['slug'] ?>" class="font-md w-100 d-flex align-items-center justify-content-between"><span><?= $this->records_services[$i]['title'] ?></span></a>
               </div>
            </div>
            </div>
         <?php } ?>
      </div>
      <h5 class="text-white text-left font-md fw-600 px-3">Accreditations</h5>
      <div class="d-flex p-3">
         
         <div class="clients-logo">
            <div>
               <img src="assets/images/mdrc/modern-lab/cap-logo.png" alt="text" class="img-fluid">
               <span>Ilac-MRA</span>
            </div>
         </div>
         <div class="clients-logo">
            <div>
               <img src="assets/images/mdrc/modern-lab/nabl-new-logo.png" alt="text" class="img-fluid">
               <span>MC-2334</span>
            </div>
         </div>
         <div class="clients-logo">
            <div>
               <img src="assets/images/mdrc/modern-lab/nabh-logo.png" alt="text" class="img-fluid">
               <span>MIS- 2017-0045</span>
            </div>
         </div>
      </div>
   </div>
   <!-- About banner end -->

   <!-- Our Specialities start -->
   <div class="about-tab mt-3 mb-3">
      <h2 class="font-lg text-center mb-2">Our Specialities</h2>
      <p class="text-center mb-3">All Diagnostic Services Under One Roof</p>
   </div>
   <div class="row px-3 pb-3 g-3 align-items-stretch">
      <div class="col-6">
         <div class="card h-100 rounded p-3">
            <div class="d-flex align-items-center">
               <div class="wd-50 ht-50">
                  <img src="assets/images/mdrc/modern-lab/a.png" alt="" class="img-fluid d-block">
               </div>
               <div class="w-100 ms-3">
                  <h3 class="fw-600 font-md mb-2">Routine Testing</h3>
                  <span class="font-xs">Routine investigations coverage from wellness to illness</span>
               </div>
            </div>
         </div>
      </div>
      <div class="col-6">
         <div class="card h-100 rounded p-3">
            <div class="d-flex align-items-center">
               <div class="wd-50 ht-50">
                  <img src="assets/images/mdrc/modern-lab/b.png" alt="" class="img-fluid d-block">
               </div>
               <div class="w-100 ms-3">
                  <h3 class="fw-600 font-md mb-2">Pathology Services</h3>
                  <span class="font-xs">Super specialized department to diagnose auto immune disorders</span>
               </div>
            </div>
         </div>
      </div>
      <div class="col-6">
         <div class="card h-100 rounded p-3">
            <div class="d-flex align-items-center">
               <div class="wd-50 ht-50">
                  <img src="assets/images/mdrc/modern-lab/c.png" alt="" class="img-fluid d-block">
               </div>
               <div class="w-100 ms-3">
                  <h3 class="fw-600 font-md mb-2">Genomic Testing</h3>
                  <span class="font-xs">Advanced genetic testing to know your health risks</span>
               </div>
            </div>
         </div>
      </div>
      <div class="col-6">
         <div class="card h-100 rounded p-3">
            <div class="d-flex align-items-center">
               <div class="wd-50 ht-50">
                  <img src="assets/images/mdrc/modern-lab/d.png" alt="" class="img-fluid d-block">
               </div>
               <div class="w-100 ms-3">
                  <h3 class="fw-600 font-md mb-2">Radiology</h3>
                  <span class="font-xs">Advanced Medical Imaging procedures for your health diagnosis</span>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- Our Specialities end -->

  <!--  <div class="card bg-theme rounded-0 border-0 p-3 mb-3">
      <h2 class="font-lg text-center text-white mb-3">We Promise. We Deliver.</h2>
      <div class="offer-wrap modern-lab-slider">
         <?php for ($i = 0; $i < count($this->records_services); $i++) {
            $image = $this->utility->get_image_path($this->records_services[$i]['image'], 'for_doctors_services', 'large'); ?>
            <div class="product-list media bg-transparent">
               <div class="bg-white rounded p-3">
               <a href="<?=SERVER_ROOT;?>/service/<?= $this->category . '/' . $this->records_services[$i]['slug'] ?>"><img src="<?= $image ?>" class="img-fluid" alt="offer"></a>
               <div class="media-body">
                  <a href="<?=SERVER_ROOT;?>/service/<?= $this->category . '/' . $this->records_services[$i]['slug'] ?>" class="font-md w-100 d-flex align-items-center justify-content-between"><span><?= $this->records_services[$i]['title'] ?></span></a>
               </div>
            </div>
            </div>
         <?php } ?>
      </div>
   </div> -->
   <!-- Why Us start -->

   <div class="about-tab why-us px-3 mt-3 mb-3">
      <div class="why-img">
         <img src="assets/images/mdrc/modern-lab/img-why.png" class="img-fluid w-100 mb-3" alt="Why Us">
      </div>
      <h2 class="font-lg text-left mb-2">Why Us?</h2>
      <p class="text-left mb-3">We are India’s fastest-growing diagnostic service provider, with a presence in more than 120 cities. We offer a holistic in-house end-to-end solution - Right from the time of receiving a call, to the home collection, testing of the sample, generating report and mailing it further to the patient, every step is carefully and professionally executed by the experienced in-house team. Our expertise lies in on-demand 1-hour home collection and same-day reports within 24 hours* (T&C apply). All our owned pathology labs and diagnostic centres are equipped with state-of-the-art infrastructure and staffed with a highly trained medical team to meet the testing requirements of the patients. Our automated processes ensure minimal human interference, which helps maintain a high degree of accuracy that leads to better patient diagnosis.</p>
      <div class="d-flex gap-3 bg-grey align-items-center justify-content-between p-3">
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
      </div>
   </div>

   <!-- Get safe testing start -->
   <div class="about-tab mt-3 mb-3">
      <h2 class="font-lg text-center mb-3">Get safe testing with MODERN labs</h2>

   </div>
   <div class="row px-3 pb-3 g-3 align-items-stretch">
      <div class="col-12">
         <div class="card h-100 rounded p-3">
            <div class="d-flex align-items-center">
               <div class="wd-50 ht-50">
                  <img src="assets/images/mdrc/modern-lab/searchtest.png" alt="" class="img-fluid d-block">
               </div>
               <div class="w-100 ms-3">
                  <h3 class="fw-600 font-md mb-2">Call and schedule an appointment with our Health Expert</h3>

               </div>
            </div>
         </div>
      </div>
      <div class="col-12">
         <div class="card h-100 rounded p-3">
            <div class="d-flex align-items-center">
               <div class="wd-50 ht-50">
                  <img src="assets/images/mdrc/modern-lab/secudletest.png" alt="" class="img-fluid d-block">
               </div>
               <div class="w-100 ms-3">
                  <h3 class="fw-600 font-md mb-2">We will Schedule appointment as per your availability and pick sample from your home</h3>

               </div>
            </div>
         </div>
      </div>
      <div class="col-12">
         <div class="card h-100 rounded p-3">
            <div class="d-flex align-items-center">
               <div class="wd-50 ht-50">
                  <img src="assets/images/mdrc/modern-lab/sampletest.png" alt="" class="img-fluid d-block">
               </div>
               <div class="w-100 ms-3">
                  <h3 class="fw-600 font-md mb-2">High Quality Lab testing done in our Accredited Labs</h3>
                  <!-- <span class="font-xs">Advanced genetic testing to know your health risks</span> -->
               </div>
            </div>
         </div>
      </div>
      <div class="col-12">
         <div class="card h-100 rounded p-3">
            <div class="d-flex align-items-center">
               <div class="wd-50 ht-50">
                  <img src="assets/images/mdrc/modern-lab/dwnload_report.png" alt="" class="img-fluid d-block">
               </div>
               <div class="w-100 ms-3">
                  <h3 class="fw-600 font-md mb-2">Get your test reports over whatsapp or Download from your web account.</h3>
                  <!-- <span class="font-xs">Advanced Medical Imaging procedures for your health diagnosis</span> -->
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- Our Specialities end -->
</main>

<!--Start Footer -->
<?php include 'includes/footer.php'; ?>
<!--End Footer -->