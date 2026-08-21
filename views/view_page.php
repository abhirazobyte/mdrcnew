
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
<?php include 'includes/header.php';?>
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
                <li><a href="index.html">Home</a></li>
                <li><a href="javascript:void();"><?=$this->page['page_title']?></a></li>
              </ul>
            </div>
            <div class="bread-title wow fadeInUp" data-wow-delay=".5s">
              <h2><?=$this->page['page_title']?></h2>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--End Breadcrumb Area-->
<section class="teb-section  pb50 pt40 ">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12 col-md-12 col-12">
                <div>
                     <?=$this->page['page_description']?>
                </div>
            </div>
            
        </div>
    </div>
</section>


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