
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



<!--Shop Products-->
<section class="shop-products-bhv checkout-section pt60 pb60">
	<div class="container">
		<div class="row">
			<div class="col-lg-8">
				<div class="accordion" id="accordionExample">
				  <div class="accordion-item">
				    <h2 class="accordion-header" id="headingOne">
				      <button class="accordion-button tab-heading d-flex align-items-center fl_between" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
				        <span class="nav_link_icon ml__5 ">1</span> <span class="txt_h_tab  me-auto tu">Login/Register</span>
				      </button>
				    </h2>
				    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
				      	<div class="accordion-body">
				      		<div class="col-lg-12 acSps">
					      		<div class="row">
					      			<div class="col-lg-6">
				      					<div class="form-block">
				      						<div class="row ">
												<div class="form-group col-sm-12 has-error ">
					      							<input class="ps-0" type="text" id="name" placeholder="Enter Mobile Number" data-error="Please fill Out">
													<div class="help-block with-errors"></div>
												</div>
												<div class="col-sm-12 mt-1">
													<button type="submit" id="form-submit" class="btn lnk btn-main bg-btn conitnueBtn">Continue <span class="circle"></span></button>
												</div>
											</div>
										</div>
				      					<div class="form-block mt-1">
				      						<div class="row ">
												<div class="col-sm-12">
				      								<span class="verifyCode text-dark">Please enter verification code (OTP) sent to:<br/> <strong>+91 9510069163</strong></span>
				      							</div>
												<div class="form-group col-sm-12 has-error ">
					      							<input class="ps-0" type="text" id="name" placeholder="Enter OTP" data-error="Please fill Out">
													<div class="help-block with-errors"></div>
												</div>
												<div class="col-sm-12">
				      								<span class="getOTP">Get OTP in 30 seconds</span>
				      							</div>
												<div class="col-sm-12">
				      								<a class="reSendOTP text-blue" href="#">Resend OTP</a>
				      							</div>
											</div>
										</div>
					      			</div>
					      			<div class="col-lg-5 ms-auto advangtage">
					      				<h6>Advantage of our secure login</h6>
					      				<ul class="key-points">
											<li>Stay informed with latest offers & reminders</li>
											<li>Single login for App & Web, access to historic reports</li>
											<li>Control all notifications, zero spam</li>
										</ul>
					      			</div>
					      		</div>
				      		</div>
				      		<div class="row whatsappBar m-auto">
								<div class="col-sm-6 col-8">
				      				<span class="getAlert"><img src="images/Whats-App-icon.png" /> Get alerts on WhatsApp</span>
				      			</div>
								<div class="col-sm-6 d-flex text-right align-items-right col-4">
									<div class="custom-control custom-radio m-0 ms-auto">
										<input class="toggleInput" type="checkbox" id="TESTS" name="TESTS">
										<label class="ios-checkbox" for="TESTS"></label>
									</div>
				      			</div>
				      		</div>
				      	</div>
				    </div>
				  </div>
				  <div class="accordion-item">
				    <h2 class="accordion-header" id="headingTwo">
				      <button class="accordion-button tab-heading collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
				        <span class="nav_link_icon ml__5 ">2</span> Add member
				      </button>
				    </h2>
				    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
				     	<div class="accordion-body">
				      		<div class="col-lg-12 acSps">
					      		<div class="row">
				      				<div class="col-lg-4 AddressCard mb-2">
						      			<label class="bg-white rounded p-3 w-100">
											<input class="float-end" type="radio" name="addressi" checked="checked" onchange="showDeliBtn(8)">
											<span class="ml-3"><strong class="fwsb">Teser,</strong><br/>Self<br/>Male , 25 yrs.</span>
										</label>
									</div>
				      				<div class="col-lg-4 AddressCard mb-2">
						      			<label class="bg-white rounded p-3 w-100">
											<input class="float-end" type="radio" name="addressi" onchange="showDeliBtn(7)">
											<span class="ml-3"><strong class="fwsb">Tersit,</strong><br/>Self<br/>Male , 28 yrs.</span>
										</label>
				      				</div>
				      			</div>
					      		<div class="row mt-3">
				      				<div class="col-lg-12">
					      				<a data-bs-toggle="modal" data-bs-target="#modalform-add-member" href="#" class="btn-main bg-btn1 btn-blue lnk text-uppercase">Add More Member<span class="circle"></span></a>
				      				</div>
				      			</div>
				      		</div>
				      	</div>
				    </div>
				  </div>
				  <div class="accordion-item">
				    <h2 class="accordion-header" id="heading5">
				      <button class="accordion-button tab-heading collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapseTwo">
				        <span class="nav_link_icon ml__5 ">3</span> Package Summary
				      </button>
				    </h2>
				    <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#accordionExample">
				     	<div class="accordion-body">
				      		<div class="col-lg-12 acSps">
					      		<div class="row">
				      				<div class="col-lg-12 AddressCard">
					      				<div class="col-lg-12 bg-white shadow-normal mb-3">
						      				<div class="col-lg-12 bg-white  d-flex p-3">
					      						<div class="packname">
					      							<h4>Smart Full Body Checkup <a class="ms-2" data-bs-toggle="offcanvas" href="#offcanvasExample-package-details"><i class="fas fa-chevron-down text-black"></i></a><br/><span>Includes 85 Tests</span></h4>
					      						</div>
					      						<div class="pricdiv ms-auto">
													<h5><span class="float-end"><i class="fas fa-rupee-sign"></i>399 <del><i class="fas fa-rupee-sign"></i>580</del></span></h5>
												</div>
												<a class="delbtn float-end ms-3 mt-1" href="#"><i class="far fa-trash-alt"></i></a>
											</div>
						      				<div class="col-lg-12 ps-3 pe-3">
												<a class="vtest-btn text-dark d-inline-block w-100 mb-2" href="#">Virag Gandhi | Self  <i class="far float-end fa-times-circle"></i></a>
											</div>
										</div>
					      				<div class="col-lg-12 bg-white shadow-normal mb-3">
						      				<div class="col-lg-12 bg-white  d-flex p-3">
					      						<div class="packname">
					      							<h4>Summer Special Package <a class="ms-2" data-bs-toggle="offcanvas" href="#offcanvasExample-package-details"><i class="fas fa-chevron-down text-black"></i></a><br/><span>Includes 82 Tests</span></h4>
					      						</div>
					      						<div class="pricdiv ms-auto">
													<h5><span class="float-end"><i class="fas fa-rupee-sign"></i>699 <del><i class="fas fa-rupee-sign"></i>2710</del></span></h5>
												</div>
												<a class="delbtn float-end ms-3 mt-1" href="#"><i class="far fa-trash-alt"></i></a>
											</div>
						      				<div class="col-lg-12 p-0 border-top">
												<a class="adpatient d-inline-block border-end text-blue mt-2 mb-2" data-bs-toggle="modal" data-bs-target="#Modalselect-add-patients"><i class="fas fa-plus me-2"></i> Add patients for this item</a>
												<a class="adpatient d-inline-block text-blue mt-2 mb-2"><i class="fas fa-plus me-2"></i> Add Prescription</a>
											</div>
										</div>
									</div>
				      			</div>
				      		</div>
				      	</div>
				    </div>
				  </div>
				  <div class="accordion-item">
					    <h2 class="accordion-header" id="headingThree">
					      <button class="accordion-button tab-heading collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
					        <span class="nav_link_icon ml__5 ">4</span> Add sample collection address, date & time
					      </button>
					    </h2>
					    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
					    	 <div class="accordion-body">
					      		<div class="col-lg-12 acSps">
						      		<div class="row">
					      				<div class="col-lg-5 AddressCard mb-4">
							      			<label class="bg-white rounded p-3 w-100">
												<input class="float-end" type="radio" name="addressi2" checked="checked" onchange="showDeliBtn(8)">
												<span class="ml-3"><strong class="fwsb">Lab 1: </strong><br/>123, Sarkhej, Ahmedabad, Gujarat, India Ahmedabad Gujarat - 380001</span>
											</label>
										</div>
					      				<div class="col-lg-5 AddressCard mb-4">
							      			<label class="bg-white rounded p-3 w-100">
												<input class="float-end" type="radio" name="addressi2" checked="" onchange="showDeliBtn(8)">
												<span class="ml-3"><strong class="fwsb">Lab 2: </strong><br/>325, Paldi, Ahmedabad, Gujarat, India Ahmedabad Gujarat - 380001</span>
											</label>
										</div>
						      			<div class="col-lg-12 cdate">
					      					<div class="form-block">
					      						<div class="row ">
													<div class="form-group col-sm-12">
														<label class="text-blue fwsb mt-1 mb-2">CHOOSE DATE & TIME FOR HOME SAMPLE COLLECTION *</label>
													</div>
													<div class="form-group col-sm-5 has-error ">
						      							<input class="ps-0" type="date" id="" placeholder="Select sample collection date" data-error="Please fill Out">
														<div class="help-block with-errors"></div>
													</div>
													<div class="form-group col-sm-5 has-error ">
														<div class="fieldsets row">
									                     	<div class="col-md-12">
									                  	     	<select class="ps-0" required="required">
																	<option selected="selected" value="">Select collection Time</option>
																	<option value="">Select collection Time</option>
																	<option value="">Select collection Time</option>
																	<option value="">Select collection Time</option>
									                        	</select>
																<div class="help-block with-errors"></div>
									                   		</div>
									                    </div>
													</div>
													<div class="col-sm-12 mt-3">
														<span class="text-dark Ctext">* Choose sample collection date & time to proceed further</span>
													</div>
												</div>
											</div>
						      			</div>
						      		</div>
						      		<div class="col-lg-12 mt-3">
						      			<a data-bs-toggle="modal" data-bs-target="#modalform-add-new-address" href="#" class="btn-main bg-btn1 btn-blue lnk text-uppercase">Add New Address<span class="circle"></span></a>
							      	</div>
						      	</div>
					      	</div>
					 	</div>
					</div>
				  <div class="accordion-item">
				    <h2 class="accordion-header" id="headingFour">
				      <button class="accordion-button tab-heading collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseThree">
				        <span class="nav_link_icon ml__5 ">5</span> Payment Option
				      </button>
				    </h2>
				    <div id="collapseFour" class="accordion-collapse collapse paymentoption" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
				    	 <div class="accordion-body">
				      		<div class="col-lg-12 acSps">
					      		<div class="row">
				      				<div class="col-lg-12">
				      					<div class="col-lg-12 AddressCard mb-2">
							      			<label class="bg-white rounded p-3 w-100">
												<input class="" type="radio" name="payment1" checked="checked" onchange="">
												<span class="ml-3 text-dark">Pay Online</span>
											</label>
										</div>
				      					<div class="col-lg-12 AddressCard mb-2">
							      			<label class="bg-white rounded p-3 w-100">
												<input class="" type="radio" name="payment1" onchange="">
												<span class="ml-3 text-dark">Cash/Card on Sample Pickup</span>
											</label>
										</div>
				      				</div>
				      			</div>
				      		</div>
				      	</div>
				    </div>
				  </div>
				</div>
			</div>
			<div class="col-lg-4 right-cart">
	             <div class="cart-extra-sevc div-for-data">
	                 <div class="col-lg-12 prdiv p-0">
	                     <h5><span class=""><i class="fas fa-rupee-sign"></i>399 <del><i class="fas fa-rupee-sign"></i>580</del></span> <span class="percnt float-end">Get 20 % OFF</span></h5>
	                 </div>
	             </div>
	             <div class="cart-extra-sevc div-for-data walletinfo">
	               	<h6 class="fs__14 mb-2 pb-1">Wallet</h6>
	                 
					<div class="custom-control custom-checkbox text-dark">
						<input type="checkbox" class="custom-control-input" id="customCheckWallet" name="example1">
						<label class="custom-control-label" for="customCheckWallet"><strong>MDRC Wallet</strong><br><span class="mt-2 balsize d-inline-block">Balance : <span class="fwb  text-success"><i class="fas fa-rupee-sign ms-1"></i> 105</span></label>
					</div>
	             </div>
	             <div class="cart-extra-sevc div-for-data">
	                 <h6 class="mb-2 pb-1">COUPONS</h6>
	                 <div class="promo_apply">
	                     <div class="col-12 w-100 p-0">
	                         <p class="text-dark coup-p ft w-100 fs__14 ">
	                             <i class="fas fa-tag fs__22 position-absolute al-pos mr-2 text-dark"></i> <a data-bs-toggle="modal" data-bs-target="#coupon-modal" class="float-end couponModal">Apply</a> Apply Coupons
	                         </p>
	                     </div>
	                 </div>
	             </div>
				<div class="cart-extra-sevc div-for-data">
					<!-- <h4 class="mb30">Cart Totals</h4> -->
					<!-- <h5 class="prc-info mb-3 border-bottom pb-3"><span class=""><i class="fas fa-rupee-sign"></i>399 <del><i class="fas fa-rupee-sign"></i>580</del></span> <span class="percnt float-end">Get 20 % OFF</span></h5> -->

					<h6 class="fs__14 mb-2 pb-1">Order Summary <span class="fs__12">(2 Items)</span></h6>

					<table class="table">
						<tbody>
							<tr>
								<th>Subtotal</th>
								<td><span class="prc"><i class="fas fa-rupee-sign"></i>399</span></td>
							</tr>
							<tr>
								<th>Sample collection charges</th>
								<td><span class="prc text-blue">FREE</span></td>
							</tr>
							<tr class="tpayable">
								<th >Total Payable</th>
								<td><span class="prc"><i class="fas fa-rupee-sign"></i>399</span></td>
							</tr>

						</tbody>
					</table>

					<a href="#" class="btn-main bg-btn checkout-btn checkout-btn lnk w-100 mb-1">Pay Now <i class="fas fa-chevron-right fa-icon fa-ani"></i><span class="circle"></span></a>
					<span class="d-block fs-12">*inclusive of all the taxes, fees and subject to availability</span>
					</div>
				</div>
			</div>
		</div>
</section>
<!--End Shop Products-->

<section class="bggreylight pt60 pb60 d-none">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 text-center">
				<img class="carimg" src="images/epmty-cart.gif" />
				<h3 class="mt-0">Your Cart is Empty!</h3>
				<p>There are no items in your cart. Explore and add packages!</p>
				<a href="#" class="btn-main bg-btn1 btn-blue lnk wow fadeInUp text-uppercase mt-4">Explore Packages <span class="circle"></span></a>
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