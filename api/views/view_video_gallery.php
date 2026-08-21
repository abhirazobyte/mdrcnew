

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



<!--Breadcrumb Area-->

<section class="breadcrumb-area banner-6">

  <div class="text-block">

	<div class="container">

	  <div class="row">

		<div class="col-lg-12 text-start v-center">

		  <div class="bread-inner">

			<div class="bread-menu wow fadeInUp" data-wow-delay=".2s">

			  <ul>

				<li><a href="index.html">Home</a></li>

				<li><a href="video">Video Gallery</a></li>

			  </ul>

			</div>

			<div class="bread-title wow fadeInUp" data-wow-delay=".5s">

			  <h2>Video Gallery</h2>

			</div>

		  </div>

		</div>

	  </div>

	</div>

  </div>

</section>

<!--End Breadcrumb Area-->







<!--Start Portfolio-->

<section class="portfolio-page pad-tb">

    <div class="container">

        <div class="row mb40 justify-content-left">

            <div class="col-lg-12 slinlk v-center">

				<a class="" href="gallery">Photo Gallery</a>

				<a class="lts active" href="video">Video Gallery</a>

            </div>

            <!-- <div class="col-lg-9 v-center"> -->

            <!-- </div> -->

        </div>

        <div class="row ">
        
        <?php for($i=0;$i<count($this->rs_gallery);$i++){?>

            <div class="col-lg-4 mb-3 col-md-6">

				<iframe width="100%" height="280" src="<?=$this->rs_gallery[$i]['video_link']?>" frameborder="0" class="GlryVdo" allowfullscreen=""></iframe>

			</div>
            <?php }?>

            
            
        </div>

    </div>

</section>

<!--End Portfolio-->



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