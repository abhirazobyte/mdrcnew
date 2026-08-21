
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
					<div class="col-lg-12  bg-white col-12 mb20">
						<div class="row border-bottom align-items-center">
				            <div class="col-lg-12 col-12 p-0">
				           		<h5 class="m-0 head">My Addresses</h5>
				            </div>
			            </div>
                        
                        <?php if(count($this->rs_customer_address)>0){?>

			           	<div class="row m-auto pt-3 ">
                        <?php for($i=0;$i<count($this->rs_customer_address);$i++){?>
		      				<div class="col-lg-5 AddressCard mb-2 row_data_<?=$this->rs_customer_address[$i]['id']?>">
				      			<label class="bg-white rounded p-3 w-100">
									<div class="float-end text-end mt-1">
										<a class=" edit text-blue f-semibold cust_address_addedit_onclick" href="javascript:void(0)" data-id="<?=$this->rs_customer_address[$i]['id']?>">Edit</a><br/>
										<a class="fas fa-trash-alt mt-3 text-danger address_delete" data-id="<?=$this->rs_customer_address[$i]['id']?>" href="javascript:void(0)"></a>
									</div>
									<span class="ml-3"><strong class="fwsb"><?=$this->rs_customer_address[$i]['first_name']?> <?=$this->rs_customer_address[$i]['last_name']?> : </strong><br><?=$this->rs_customer_address[$i]['line1']?>, <?=$this->rs_customer_address[$i]['line2']?>, <?=$this->rs_customer_address[$i]['city']?> - <?=$this->rs_customer_address[$i]['zipcode']?> </span>
								</label>
							</div>
                            
                            <?php }?>
		      				
		      			</div>

		      			<div class="row m-auto pt-3 pb-5">
		      				<div class="col-lg-12">
			      				<a  href="javascript:void(0)" data-id="" class="btn-main bg-btn1 btn-blue lnk text-uppercase cust_address_addedit_onclick">Add New Address<span class="circle"></span></a>
		      				</div>
		      			</div>
                        
                        <?php }else{?>
                        <div class="row m-auto pt-3 pb-5">
                        <div class="col-lg-12 text-center">
									<img class="max-width__81px" src="images/img-address.png" alt="" />
									<h4 class="mt__15">No Address found in your account!</h4>
									
                                    
                                    <a  href="javascript:void(0)" class="btn-main bg-btn1 btn-blue lnk text-uppercase cust_address_addedit_onclick" data-id="">Add Address<span class="circle"></span></a>


									
                                    

								</div>
                                
                                </div>
                        <?php }?>
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