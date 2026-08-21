
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
				<div class="row m-auto">
					<div class="col-lg-12  bg-white pt-4 pb-4 col-12 mb20">
						<div class="row align-items-center w-100 m-auto">
							<div class="col-lg-8 col-md-8 col-12">
                            <?php $wallet=$this->utility->moneyFormatIndia($this->rs_customer['wallet']);?>
								<div class="wallet-ad w-auto wal-border">
									<i class="fa fa-wallet text-success walicon"></i>
									<span class="d-block text-dark rupee-text"> <?=$wallet?></span>
									<span class="d-block stext pt-2"> Wallet Balance</span>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 text-left text-lg-end col-12 mt-3 mt-lg-0">
								<a style="display:none" data-bs-toggle="modal" data-bs-target="#myModal-add-money" href="#" class="btn-main bg-btn1 btn-blue lnk text-uppercase pe-3 ps-3"><i class="fas fa-plus me-2"></i> Add Money to Wallet<span class="circle"></span></a>
							</div>
						</div>

					</div>
				</div>

				<div class="row m-auto">
					<div class="col-lg-12  bg-white col-12 mb20">
						<div class="row border-bottom align-items-center">
				            <div class="col-lg-8 p-0 col-6">
				           		<h5 class="m-0 head">History</h5>
				            </div>
				            <div class="col-lg-4 ml-auto  col-6 " style="padding-top:0px;">
								<div class="form-block fdgn2 mt0 mb0">
					                
					                    <div class="fieldsets row">
					                      	<div class="col-md-12"><input type="text" name="search_keyword" id="search_keyword" placeholder="Search...."  class="mt-2 mb-2"></div>
					                    </div>
					                
					            </div>
							</div>
			            </div>
                        
                        <div id="results">
                        
                        
                        </div>
                        
                        <div class="nonvalued">
					              <input type="hidden" name="total_products" id="total_products" value="<?=count($this->rs_data)?>">
					             
					        	 <input type="hidden" name="serach_keyword" id="serach_keyword" value="">
					               <input type="hidden" name="p_core_collection_v" id="p_core_collection_v" value="no">
					                <input type="hidden" name="p_new_arrivals_v" id="p_new_arrivals_v" value="no">
					             
					            </div>
					            <div class="row" style="margin-bottom:30px;margin-top:30px;text-align:center">
					              <div class="col-lg-12">
					                <button class="lnk btn-main bg-btn w-auto me-2 customerFormSubmit animation_image" id="l_more" align="center">Load More </button>
					              </div>
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