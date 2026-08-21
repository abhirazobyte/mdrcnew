

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

<section class="breadcrumb-area banner-6">

  <div class="text-block">

	<div class="container">

	  <div class="row">

		<div class="col-lg-12 text-start v-center">

		  <div class="bread-inner">

			<div class="bread-menu wow fadeInUp" data-wow-delay=".2s">

			  <ul>

				<li><a href="index.html">Home</a></li>

				<li><a href="our-doctors">Our Doctors</a></li>

			  </ul>

			</div>

			<div class="bread-title wow fadeInUp" data-wow-delay=".5s">

			  <h1 class="f-bold fs-2 text-white">Our Doctors</h1>

			</div>

		  </div>

		</div>

	  </div>

	</div>

  </div>

</section>

<!--End Breadcrumb Area-->



<!--End Hero-->

<!--Start Team Leaders-->

<section class="team pad-tb pad-bot-cust">

    <div class="container">

        <div class="row justify-content-center text-center">

        

        	<?php for($i=0;$i<count($this->rs_doctor);$i++){

				$image = $this->utility->get_image_path($this->rs_doctor[$i]['image'], 'doctor', 'large');

				?>

            <div class="col-lg-3 col-sm-6 mb30 ">

                <div class="full-image-card pb-4 borderhover up-hor">	

                    <div class="image-div shadow-none"><img src="<?=$image?>" alt="<?=$this->rs_doctor[$i]['name']?>" class="img-fluid"/></div>

                    <div class="info-text-block">

                        <h4><?=$this->rs_doctor[$i]['name']?></h4>

                        <span style="
    display: block;
    margin-top: 6px;
    font-family: 'Open Sans', sans-serif;
    font-size: 13px;
    font-weight: 600;
    color: #555;
    line-height: 1.5;
    letter-spacing: 0.2px;
">
    <?=$this->rs_doctor[$i]['designation']?>
</span>

                    </div>
                          
                           <a href="our-doctors/detail/<?=$this->rs_doctor[$i]['slug']?>" style="
       display:inline-block;
       margin-top:12px;
       padding:8px 20px;
       background:linear-gradient(135deg,#1b6ca8,#0d8b8b);
       color:#fff;
       font-size:14px;
       font-weight:600;
       font-family:'Poppins',sans-serif;
       text-decoration:none;
       border-radius:25px;
       letter-spacing:.2px;
       box-shadow:0 4px 12px rgba(0,0,0,.15);
       transition:all .3s ease;
   ">Know More<i class="fas fa-arrow-right" style="margin-left:6px;font-size:12px;"></i></a>

                </div>

            </div>

            <?php }?>

            

            

            

                    

            

            

            











        </div>

    </div>

</section>

<!--End Team Leaders-->





<?php include 'includes/get_in_touch_form.php';?>



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
