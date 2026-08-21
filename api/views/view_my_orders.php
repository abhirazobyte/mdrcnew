

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







<!--Info Personal-->

<section class="info-personal pt60 pb60">

	<div class="container">

		<div class="row">

			<div class="col-lg-4">

            

				<?php include 'includes/myaccount.php';?>

				

			</div>

			<div class="col-lg-8">

				<div class="row m-auto" style="display: none;">

					<div class="col-lg-12 orderlinks p-0 col-12 mb20">

						<a class="active" href="javascript:void(0)">Upcoming</a>

						<a href="javascript:void(0)">Completed</a>

						<a href="javascript:void(0)">Cancelled</a>

<!-- 						<ul class="nav nav-tabs" id="myTab4" role="tablist">
						  <li class="nav-item">
							<a class="nav-link active" id="tabHealth1a" data-bs-toggle="tab" href="#tabHealth1" role="tab" aria-controls="tabHealth1" aria-selected="true">Upcoming</a>
						  </li>
						  <li class="nav-item">
							<a class="nav-link" id="tabHealth2b" data-bs-toggle="tab" href="#tabHealth2" role="tab" aria-controls="tabHealth2" aria-selected="false">Completed</a>
						  </li>
						  <li class="nav-item">
							<a class="nav-link" id="tabHealth3c" data-bs-toggle="tab" href="#tabHealth3" role="tab" aria-controls="tabHealth3" aria-selected="false">Cancelled</a>
						  </li>
						</ul>

						<div class="tab-content" id="myTabContent4">
							<div class="tab-pane tabi1 fade active show" id="tabHealth1" role="tabpanel" aria-labelledby="tabHealth1a">
									<p>sdf</p>
							</div>
						</div>

						<div class="tab-pane tabi2 fade" id="tabHealth2" role="tabpanel" aria-labelledby="tabHealth2b">
									<p>sdf</p>
						</div>

						<div class="tab-pane tabi2 fade" id="tabHealth3" role="tabpanel" aria-labelledby="tabHealth3c">
									<p>sdf</p>
						</div> -->


					</div>
				</div>
                    
                    <div class="" id="results">
					
                    

					
                    
                    
                    
                    </div>

					<div class="nonvalued">

						              <input type="hidden" name="total_products" id="total_products" value="">

						               <input type="hidden" name="p_core_collection_v" id="p_core_collection_v" value="no">

						                <input type="hidden" name="p_new_arrivals_v" id="p_new_arrivals_v" value="no">



						                 <input type="hidden" name="serach_keyword" id="serach_keyword" value="">

						             

						            </div>
                                    
					<div class="row" style="margin-bottom:50px;text-align:center;">

						              <div class="col-lg-12">

						                <button class="btn btn-primary animation_image" id="l_more" align="center">Load More </button>

						              </div>

						            </div>
                    

				</div>

			</div>



		</div>

</section>

<!--End Info Personal-->



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
<script src="js/load_my_orders.js"></script>