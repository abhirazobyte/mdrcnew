

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





<!--Start Hero-->



<section class="shop-products-bhv booking-info pt60 pb60">

   <div class="container">

		<div class="row">

			<div class="col-lg-12 mb-4">

				<h4 class="succsesDiv rounded"><img src="images/icon-check.png" alt="" /> Your Booking is Confirmed!<!-- <br/><span class="font-weight-normal fs-14">We'll send you a shipping confirmation email as soon as your order ships.</span> --></h4>

			</div>

		</div>

		<div class="row">

			<div class="col-lg-12 mb-2 text-center">

				<h4>Booking Summary</h4>

			</div>

		</div>

		<div class="row m-auto">

			<div class="col-lg-12 bg-white pt-2 pb-2 mb-3 border rounded text-center">

				<div class="row">

					<div class="col-lg-4 text-center pt-2 pb-2 col-md-4 col-4">

						<span class="d-inline-block fs-14 w-100">Booking ID</span>

						<span class="d-inline-block text-dark mt-2 w-100"><?=$this->rs_data[0]['display_order_no']?></span>

					</div>

					<div class="col-lg-4 text-center pt-2 pb-2 col-md-4 col-4">

						<span class="d-inline-block fs-14 w-100">Booking Date</span>

						<span class="d-inline-block text-dark mt-2 w-100"><?=$this->rs_data[0]['order_date']?></span>

					</div>

					<div class="col-lg-4 text-center pt-2 pb-2 col-md-4 col-4">

						<span class="d-inline-block fs-14 w-100">Grand Total</span>

						<span class="d-inline-block text-dark mt-2 w-100"><i class="fas fa-rupee-sign"></i> <?=$this->rs_data[0]['net_order_value']?></span>

					</div>

				</div>

			</div>

		</div>

      <div class="row mt-2">

         <div class="col-lg-6">

            <div class="row mb50">

	            <div class="col-lg-12 mb-1">

                  <h5>Package Summary</h5>

    	        </div>

               	<div class="col-lg-12">
                
                <?php for($i=0;$i<count($this->rs_order_detail);$i++){?>

	               	
                    <div class="col-lg-12 bg-white shadow-normal mb-3">

	      				<div class="col-lg-12 bg-white  d-flex p-3">

      						<div class="packname">

      							<h4><?=$this->rs_order_detail[$i]['order_item_name']?> <a class="ms-2 itemsDetails" data-id="<?=$this->rs_order_detail[$i]['item_id']?>"><i class="fas fa-chevron-down text-black"></i></a><br><span>Includes <?=$this->rs_order_detail[$i]['order_item_test_count']?> Tests</span></h4>

      						</div>

      						<div class="pricdiv ms-auto">

								<h5><span class="float-end"><i class="fas fa-rupee-sign"></i><?=$this->rs_order_detail[$i]['price']?></span></h5>

							</div>

							
                            

						</div>

	      				<div class="col-lg-12 ps-3 pe-3">


							<?php
							$line1=$this->rs_order_detail[$i]['customer_members_line1'];
							$area=$this->rs_order_detail[$i]['customer_members_area'];				
							$pincode=$this->rs_order_detail[$i]['customer_members_pincode'];
							
							$obj_model_tble = $this->load_model("pincode");
							$obj_model_tble->join_table("state", "left", array("name"), array("state_id"=>"id"));
							$obj_model_tble->join_table("city", "left", array("name"), array("city_id"=>"id"));	
									
							$rs_pincode_data= $obj_model_tble->execute("SELECT", false, "", "pincode.name='".$pincode."'","pincode.id DESC");
							
							$city=$rs_pincode_data[0]['city_name'];
							$state=$rs_pincode_data[0]['state_name'];
							
			
							
			
							$member_html='<a class="vtest-btn text-dark d-inline-block w-100 mb-2 cartMemberRemove" data-id="'.$cartID.'" href="javascript:void(0)">'.$this->rs_order_detail[$i]['customer_members_prefix'].' '.$this->rs_order_detail[$i]['customer_members_first_name'].' '.$this->rs_order_detail[$i]['customer_members_last_name'].' | '.$this->rs_order_detail[$i]['customer_members_relation'].'<br/><span class=" ">'.$line1.', '.$area.','.$city.' - '.$pincode.', '.$state.'</span>  </a>';
							
							?>
                            
                            
							<?=$member_html?>
                            
                            <?php if($this->rs_order_detail[$i]['prescription_data']!=''){?>
                            
                            
                            <div class="vtest-btn text-dark d-inline-block w-100 mb-2" href="#">Prescription Info <a class="float-end vdet text-blue prescriptionOrderView" data-id="<?=$this->rs_order_detail[$i]['id']?>">View Details</a> 
                            </div>

							<?php }?>
							
						</div>

					</div>
                    
                    <?php }?>

               	</div>

            </div>
            
            <?php if(count($this->rs_lab_data)>0){?>

            <div class="row mb50">

	            <div class="col-lg-12 mb-1">

                  <h5>Lab Address Information</h5>

    	        </div>

               	<div class="col-lg-12">

	               	<div class="col-lg-12 bg-white border rounded p-3">

	                  <div class="row m-auto">

		                  <div class="col-lg-6 p-0">

			                  <h5><?=$this->rs_lab_data[0]['lab_name']?></h5>

			                  <p class="mt0 mb40"><?=$this->rs_lab_data[0]['lab_address']?></p>

			                  <a href="javascript:void(0)" class="btn-main bg-btn1 btn-blue lnk text-uppercase">Get Direction <span class="circle"></span></a>

		                  </div>

		                  <div class="col-lg-4 ms-auto text-end prdiv p-0">

		                  		
                                
		                  </div>

	                  </div>

	               	</div>

               	</div>

            </div>
            
            <?php }?>

         </div>

         <div class="col-lg-6 right-cart">

           	<div class="col-lg-12 mb-2" style="display:none">

              	<h5 class="d-inline-block">Booking & Payment Information</h5>

              	<span class="float-end">

	              	<a class="small-btns"  data-bs-toggle="modal" data-bs-target="#modalform-Reschedule-Booking"><i class="fas me-1 fa-calendar-alt"></i> Reschedule</a>

	              	<a class="small-btns text-danger border-danger" href="#"><i class="fas me-1 fa-times"></i> Cancel</a>

	            </span>

	        </div>

	        <div class="cart-extra-sevc div-for-data" style="display:none">

	             <div class="col-lg-12 p-0">

             		<span class="d-flex fs-14 align-items-center text-dark h6 w-100">Sample Collection Date <span class="ms-auto">15 Sep, 2022</span></span>

             		<span class="d-flex fs-14 align-items-center text-dark h6 mb-0 w-100">Sample Collection Time <span class="ms-auto">06:00 am - 07:00 am</span></span>

	             </div>

	         </div>

             <div class="cart-extra-sevc div-for-data">

                 <!-- <h4 class="mb30">Cart Totals</h4> -->

                 <!-- <h5 class="prc-info mb-3 border-bottom pb-3"><span class=""><i class="fas fa-rupee-sign"></i>399 <del><i class="fas fa-rupee-sign"></i>580</del></span> <span class="percnt float-end">Get 20 % OFF</span></h5> -->

                 <h6 class="fs__14 mb-2 pb-1">Order Details</h6>

                 <table class="table">

                     <tbody>

                         <tr>

                             <th>Payment By</th>

                             <td><span class="prc me-1"><?=$this->rs_data[0]['payment_type']?></span></td>

                         </tr>

                         
                         

                         <tr>

                             <th>Sub Total</th>

                             <td><span class="prc"><i class="fas fa-rupee-sign"></i><?=$this->rs_data[0]['subtotal']?></span></td>

                         </tr>
                         
                         <tr>

                             <th>Collection Charge</th>

                             <td><span class="prc"><i class="fas fa-rupee-sign"></i><?=$this->rs_data[0]['collection_charge']?></span></td>

                         </tr>
                         
                         <?php if($this->rs_data[0]['discount']>0){?>
                         
                         <tr>

                             <th>Discount</th>

                             <td><span class="prc">-<i class="fas fa-rupee-sign"></i><?=$this->rs_data[0]['discount']?></span></td>

                         </tr>
                         <?php }?>
                         <?php if($this->rs_data[0]['wallet_amount']>0){?>
                         
                         <tr>

                             <th>Wallet</th>

                             <td><span class="prc">-<i class="fas fa-rupee-sign"></i><?=$this->rs_data[0]['wallet_amount']?></span></td>

                         </tr>
                          <?php }?>

                        
                        

                         <tr class="tpayable">

                             <th>Total</th>

                             <td><span class="prc"><i class="fas fa-rupee-sign"></i><?=$this->rs_data[0]['net_order_value']?></span></td>

                         </tr>

                     </tbody>

                 </table>

                 <a href="my-orders.html" class="btn-main bg-btn checkout-btn lnk w-100 mb-1">My Orders <i class="fas fa-chevron-right fa-icon fa-ani"></i><span class="circle"></span></a>

               
               

            </div>

            <div class="col-lg-12 need-help">

               <h5>Need help with booking your test? <img src="images/call_to_order.svg" class="float-end cto"></h5>

               <span class="subtext d-inline-block w-100">Our experts are here to help you</span>

               <a href="tel:911246712000" class="call-icon"><i class="fas fa-phone-alt"></i> +91-124-6712000</a>

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