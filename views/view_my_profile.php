
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
					<div class="col-lg-12 bg-white col-12 mb20">
						<div class="row">
				            <div class="col-lg-12 p-0 col-12">
				           		<h5 class="m-0 head border-bottom">My Profile</h5>
				            </div>
			            </div>
						<div class="row m-auto pt20 pb20">
				            <div class="col-lg-12 col-12">
				           		<div class="form-block fdgn2 ">
						            <form action="" method="post" name="customerForm" id="customerForm">
						            	<div class="fieldsets row">
                                        
                                       
                                       
							                <div class="col-md-6">
							                	<label>First Name</label>
							                	  <input name="first_name" id="first_name" type="text" class="required" value="<?=$this->rs_customer['name']?>">
							                </div>
                                            
                                            <div class="col-md-6">
							                	<label>Last Name</label>
							                	 <input name="last_name" id="last_name" type="text" class="required" value="<?=$this->rs_customer['last_name']?>">
							                </div>
							                
                                            
							                <div class="col-md-6">
							                	<label>Mobile No.</label>
							                	  <input name="phone1" id="phone1" type="text" class="numbersOnly numbers required" readonly="readonly" disabled="disabled" value="<?=$this->rs_customer['phone']?>">
							                </div>
                                            
                                            <div class="col-md-6">
							                	<label>Email</label>
							                	 <input name="email" id="email" type="text" class="" value="<?=$this->rs_customer['email']?>">
							                </div>
                                            
                                             <div class="col-md-6">
							                	<label>Profile Photo</label>
							                	 <input name="profile_image" id="profile_image" type="file" class="" value="">
							                </div>
							                
							                
                                            
						              	</div>
						              	
                                        
							            <div class="fieldsets mt20 pb20">
							            	<button type="submit" name="submit" class="lnk btn-main bg-btn w-auto me-2 customerFormSubmit" >Save<span class="circle"></span></button>
							            </div>
						            </form>
						        </div>
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