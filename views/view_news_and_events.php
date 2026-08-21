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
				<li><a href="news-and-events">News and Events</a></li>
				<?php if($this->array_bread!=''){?>
					<li><a href="javascript:void()"><?=$this->array_bread?></a></li>
				<?php }?>
			  </ul>
			</div>
			<div class="bread-title wow fadeInUp" data-wow-delay=".5s">
				<?php if($this->array_bread!=''){
					$title=$this->array_bread;
				}else{
					$title='News and Events';
				}
				?>
			  <h1 class="f-bold fs-2 text-white"><?=$title?></h1>
			</div>
		  </div>
		</div>
	  </div>
	</div>
  </div>
</section>
<!--End Breadcrumb Area-->
<!--Start Blog Grid-->
<section class="blog-page  pt00">
	<div class="container">
		<div class="row">
			<!-- <h2 class="fs-3 text-center mt-md-2 text-202024">News and Events</h2> -->
			<div class="col-lg-12 mt-3 col-12 text-center">
			     <input class="search-input" id="serach_keyword" name="serach_keyword" type="text" placeholder="Search">
			</div>
		</div>

		<div class="row" id="result_data">

		</div>

    <div class="nonvalued">
      <input type="hidden" name="catv" id="catv" value="<?=$this->CatId?>">
      <input type="hidden" name="tagv" id="tagv" value="<?=$this->TagId?>">
      <input type="hidden" name="total_events" id="total_events" value="<?=count($this->rs_data)?>">
    </div>

    <div class="row" style="margin-top:50px;text-align:center">
      <div class="col-lg-12">
        <button class="btn btn-primary animation_image" id="load_more_event" align="center">Load More </button>
      </div>
    </div>


	</div>
</section>
  <!--End Blog Grid-->
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