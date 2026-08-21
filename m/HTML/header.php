<input type="hidden" name="cityUrl" id="cityUrl" value="<?=$_SESSION['citySlug']?>">
<header class="nav-bg-b main-header navfix menu-dark"> <!-- fixed-top class removed -->
	<div class="container-fluid">
		<div class="row">
			<div class="menu-header">
				<div class="dsk-logo">
					<a class="nav-brand" href="<?=SERVER_ROOT;?>">
						<img src="images/logo.svg" alt="MDRC" class="mega-white-logo"/>
						<img src="images/logo.svg" alt="MDRC" class="mega-darks-logo"/>
					</a>
					<a class="cities-anchor" data-bs-toggle="modal" data-bs-target="#modal-cities">
							<div class="">
								<img src="images/icon-location.png" alt="" />
								<span><?=$_SESSION['cityName']?></span>
								<img src="images/icon-red-arrow.png" alt="" />
							</div>
					</a>
					<form class="d-inline-block position-relative serchFormi" name="searchForm" id="searchForm" method="post" action="">
						<input class="searchInput required searchKeyword" type="text" id="searchInput" autocomplete="off" placeholder="Search for a Test, Nearest Centres" />
						<button class="searSubmit" type="submit"><img src="images/icon-red-search.png" alt="" /></button>
					</form>
				</div>
				<div class="custom-nav" role="navigation">
					<ul class="nav-list onepge">
						<li class="contact-show second"><a   href="cart" class=""><img src="images/icon-cart.png" alt="cart" /> Cart <span class="cartCount"><?=count($this->rs_cartmini)?></span></a></li>
                        <?php if($_SESSION['MDRCCustID']<=0){?>
						 <li class="contact-show">
							<a data-bs-toggle="offcanvas" href="#offcanvasExample-login" class=""><img src="images/icon-profile.png" alt="profile" /> Login / Register</a>
						</li>
                        <?php }else{?>
						<li>
							<div class="dropdown prof-drop">
							  <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
							    <img src="images/icon-profile.png" alt="profile" /> <span class="PFName">Hi, <?=$_SESSION['MDRCCustFirstName']?></span> <i class="fas fa-chevron-down ms-2"></i>
							  </button>
							  <ul class="dropdown-menu">
							    <li><a class="dropdown-item" href="my-profile">Personal Information <i class="fas fa-chevron-right"></i></a></li>
							    <li><a class="dropdown-item" href="my-orders">My Orders <i class="fas fa-chevron-right"></i></a></li>
							    <li><a class="dropdown-item" href="my-family-friends">My Family & Friends <i class="fas fa-chevron-right"></i></a></li>
							    <li style="display:none"><a class="dropdown-item" href="my-addresses">My Addresses <i class="fas fa-chevron-right"></i></a></li>
							    <li><a class="dropdown-item" href="mdrc-test-booking-enquiry">Upload Prescription <i class="fas fa-chevron-right"></i></a></li>
							    <li><a class="dropdown-item" href="my-wallet">My Wallet <i class="fas fa-chevron-right"></i></a></li>
							    <li><a class="dropdown-item" href="help-support">Help & Support <i class="fas fa-chevron-right"></i></a></li>
							    <li><a class="dropdown-item" href="logout">Logout <i class="fas fa-chevron-right"></i></a></li>
							  </ul>
							</div>
						</li>
                        <?php }?>
                        
                        <li class="hidemobile"><a href="tel:+91-124-6712000"><img src="images/call-mobile-header.png" alt="Call" style="width:33px" /></a></li>
                        
						<li class="call-text" style="margin-left:10px">
							<a href="tel:+91-124-6712000" class="">CALL US <br/><span>+91-124-6712000</span></a>
						</li>
					</ul>
				</div>
			</div>
			<div class="menu-header cusnav">
				<nav class="navbar navbar-expand-md ">
				  <div class="container-fluid p-0">
					<button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
					  <span class="navbar-toggler-icon"></span>
					</button>
					<a class="navbar-brand d-block d-lg-none d-md-none me-auto" href="<?=SERVER_ROOT;?>"><img src="images/logo.svg" alt="MDRC" class=""></a>
					<ul class="nav-list d-block d-lg-none d-md-none onepge">
						<li class="contact-show second"><a   href="cart" class=""><img src="images/icon-cart.png" alt="cart" /> <span class="cartCount"><?=count($this->rs_cartmini)?></span></a>
						</li>
                        <?php if($_SESSION['MDRCCustID']<=0){?>
						 <li class="contact-show">
							<a data-bs-toggle="offcanvas" href="#offcanvasExample-login" class=""><img src="images/icon-profile.png" alt="profile" /></a>
						</li>
                        <?php }else{?>
						<li>
							<div class="dropdown prof-drop">
							  <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
							    <img src="images/icon-profile.png" alt="profile" /> <i class="fas fa-chevron-down ms-1"></i>
							  </button>
							  <ul class="dropdown-menu">
							    <li><span class="uname text-blue">Hi, <?=$_SESSION['MDRCCustFirstName']?></span></li>
							    <li><a class="dropdown-item" href="my-profile">Personal Information <i class="fas fa-chevron-right"></i></a></li>
							    <li><a class="dropdown-item" href="my-orders">My Orders <i class="fas fa-chevron-right"></i></a></li>
							    <li><a class="dropdown-item" href="my-family-friends">My Family & Friends <i class="fas fa-chevron-right"></i></a></li>
							    <li style="display:none"><a class="dropdown-item" href="my-addresses">My Addresses <i class="fas fa-chevron-right"></i></a></li>
							    <li><a class="dropdown-item" href="my-prescription">My Priscription <i class="fas fa-chevron-right"></i></a></li>
							    <li><a class="dropdown-item" href="my-wallet">My Wallet <i class="fas fa-chevron-right"></i></a></li>
							    <li><a class="dropdown-item" href="help-support">Help & Support <i class="fas fa-chevron-right"></i></a></li>
							    <li><a class="dropdown-item" href="logout">Logout <i class="fas fa-chevron-right"></i></a></li>
							  </ul>
							</div>
						</li>
                        <?php }?>
					
                     	
                        
                        <li class="contact-show">
							<a href="tel:+91-124-6712000" class=""><img src="images/call-mobile-header.png" alt="Call" /></a>
						</li>
                    </ul>
					<div class="d-flex mobsearchbar d-lg-none d-md-none">
							<a class="cities-anchor" data-bs-toggle="modal" data-bs-target="#modal-cities">
									<div class="">
										<img src="images/icon-location.png" alt="" />
										<span><?=$_SESSION['cityName']?></span>
										<img src="images/icon-red-arrow.png" alt="" />
									</div>
							</a>
							<form class="d-inline-block position-relative serchFormi" name="searchMobileForm" id="searchMobileForm" method="post" action="">
								<input class="searchInput required searchMobileKeyword" id="searchMobileInput" autocomplete="off" type="text" placeholder="Search for a Test, Nearest Centres" />
						<button class="searSubmit" type="submit"><img src="images/icon-red-search.png" alt="" /></button>
							</form>
					<!-- <form class="d-inline-block position-relative serchFormi" name="searchForm" id="searchForm" method="post" action="">
						<input class="searchInput required searchKeyword" type="text" id="searchInput" autocomplete="off" placeholder="Search for a Test, Nearest Centres" />
						<button class="searSubmit" type="submit"><img src="images/icon-red-search.png" alt="" /></button>
					</form> -->
					</div>
					<div class="collapse navbar-collapse" id="mynavbar">
					  <ul class="navbar-nav ml-auto">
						<li class="nav-item"><a href="about-us" class="nav-link">About Us</a></li>
						<li class="nav-item dropdown">
						  <a class="nav-link dropdown-toggle" href="for-doctors" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							For Doctors
						  </a>
						 <?php if(count($this->rs_for_doctors)>0){?>
						  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
						  <?php for ($i=0; $i < count($this->rs_for_doctors) ; $i++) { ?>
							<li><a class="dropdown-item" href="<?=$this->rs_for_doctors[$i]['slug']?>"> <?=$this->rs_for_doctors[$i]['title']?> </a></li>
							<?php }?>
						  </ul>
						<?php }?>
						</li>
						<li class="nav-item dropdown">
						  <a class="nav-link dropdown-toggle" href="for-patients" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							For Patients
						  </a>
						  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
							<li><a class="dropdown-item"  href="our-doctors"> Our Doctors </a> </li>
							<li><a class="dropdown-item"  href="covid-19"> Covid-19 </a> </li>
							<!-- <li><a class="dropdown-item"  href="health-packages.html"> Modern Health Packages</a> </li> -->
							<li><a class="dropdown-item"  href="imaging-test-information"> Imaging Test Information </a> </li>
							<li><a class="dropdown-item"  href="pathology-lab-information"> Pathology Lab Test Information </a> </li>
							<li><a class="dropdown-item"  data-bs-toggle="modal" data-bs-target="#modalform-full"> Home Sample Collection </a> </li>
						  </ul>
						</li>
                        <li class="nav-item dropdown">
						  <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							Lab Tests/Packages
						  </a>
						  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
							<li><a class="dropdown-item"  href="radiology/imaging-lab-tests-near/<?=$_SESSION['citySlug'];?>"> Radiology Imaging</a> </li>
                            <li><a class="dropdown-item"  href="pathology/lab-blood-test-near/<?=$_SESSION['citySlug'];?>"> Pathology Blood Test</a></li>
						  </ul>
						</li>
						<li class="nav-item"><a href="premium-health-checkup/<?=$_SESSION['citySlug'];?>" class="nav-link">Premium HealthCheckup</a></li>
						<li class="nav-item dropdown">
						  <a class="nav-link dropdown-toggle" href="reach-us" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							Contact Us
						  </a>
						  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
							<li> <a class="dropdown-item"  href="reach-us">Reach us</a> </li>
							<li> <a class="dropdown-item"  data-bs-toggle="modal" data-bs-target="#modalform-full">Book a test</a> </li>
							<li> <a class="dropdown-item"  href="news-and-events">News and Events</a> </li>
							<li> <a class="dropdown-item"  href="gallery">Gallery</a> </li>
							<li> <a class="dropdown-item"  href="career">Career</a> </li>
                            <li> <a class="dropdown-item"  href="blog">Blogs</a> </li>
						  </ul>
						</li>
					  </ul>
					</div>
				  </div>
				</nav>
			</div>
		</div>
	</div>
</header>
<!--Start sidebar -->
<div class="niwaxofcanvas offcanvas offcanvas-end otverify" tabindex="-1" id="offcanvasExample-otpverify">
  <div class="offcanvas-body">
    <div class="cbtn animation">
      <div class="btnclose"> <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button></div>
    </div>
    <div class="form-block sidebarform ">
      <h5 class="pt-3 pb-0">Verify OTP</h5>
      <p class="subhead">Please enter 4-digit OTP Sent to <br/><strong class="text-dark signup_login_phone">+91 99245 23136</strong></p>
      <form id="otp_popup_form" name="otp_popup_form" method="post" data-bs-toggle="validator" class="sidebarForm shake mt40">
      <input type="hidden" class="" id="action_type" name="action_type" value="otp">
        <div class="row">
          <div class="form-group col-sm-12 mb-2">
          	<label>Enter OTP</label>
            <input type="text"  id="otpch1" name="otpch1" maxlength="4" minlength="4" class="required number numbers" placeholder=""  data-error="">
            <div class="help-block with-errors"></div>
	       		<!-- <div class="col-12 p-0  mb-2 pb-1 text-end">
        	  	<a class="text-blue cotp " href="#">Clear OTP</a>
		    		</div> -->
		        <div class="col-12 p-0 text-end mb-2 pb-1">
		        	<span class="drecive d-inline-block">
                        <button type="button"  class="" id="resend_otp_p" style="border:none;background:none">Resend OTP</button></span>
		        	 <a class="text-blue timi" id="claim_counter"></a>
			   		</div>
          </div>
        </div>
        <button type="submit" id="otppopup_submit" class="btn lnk btn-main bg-btn">Verify OTP <span class="circle"></span></button>
        <div id="invalid_otp" class="mt-3"></div>
        <div class="clearfix"></div>
        <!-- <div class="col-12 p-0 mt-4">
        	<span class="drecive float-start">Did not receive the code?</span>
        	 <a class="text-blue float-start timi">00:25</a>
	        <a class="text-blue float-end reotop" href="#">Re-Send OTP</a>
	   		</div> -->
      </form>
    </div>
  </div>
</div>
<div class="niwaxofcanvas offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample-login">
  <div class="offcanvas-body">
    <div class="cbtn animation">
      <div class="btnclose"> <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button></div>
    </div>
    <div class="form-block sidebarform ">
      <h5 class="pt-3 pb-0">Login/Sign Up</h5>
      <p class="subhead">Please Enter Your Phone Number to Proceed</p>
      <form id="signin_popup_form" name="signin_popup_form" method="post" data-bs-toggle="validator" class="sidebarForm shake mt40" autocomplete="off">
      <input type="hidden" class="" id="action_type" name="action_type" value="login">
        <div class="row">
          <div class="form-group col-sm-12">
          	<label>Phone Number</label>
            <input type="text"  id="phone" name="phone" placeholder="Enter Phone Number" class="login_f_data required number numbers" maxlength="10" minlength="10" required data-error="Please fill Out" autocomplete="off">
            <div class="help-block with-errors"></div>
          </div>
        </div>
       <!-- <a class="btn lnk btn-main bg-btn w-100" data-bs-toggle="offcanvas" href="#offcanvasExample-otpverify">Login <span class="circle"></span></a>-->
       <button type="submit" id="loginpopup_submit" class="btn lnk btn-main bg-btn w-100 login-btn">Login <span class="circle"></span></button>
        <div id="invalid_login" class="mt-3"></div>
        <div class="clearfix"></div>
        <div class="col-12 p-0 mt-3 text-center" style="display:none">
        	<span class="almember">Don't have an account? <a class="text-blue"  data-bs-toggle="offcanvas" href="#offcanvasExample-signup">Sign Up</a></span>
	    </div>
        <div class="col-12 p-0 mt-3 text-center slidi">
			<div class="owl-carousel testimonial-card-a pl25">
				<div class="testimonial-card">
				  <div class="t-text">
	        		<img src="images/slide-3.png" />
		        		<h4>Digital Report Bank</h4>
		        		<p>Access speedy reports from everywhere and anywhere.</p>
				  </div>
				</div>
				<!--<div class="testimonial-card">
				  <div class="t-text">
	        		<img src="images/slide-2.png" />
	        		<h4>Free Call Consultationg</h4>
	        		<p>Have a doubt? Clear it out.</p>
				  </div>
				</div>-->
				<div class="testimonial-card">
				  <div class="t-text">
		        		<img src="images/slide-1.png" />
	        		<h4>Free Home Sample Pick-up</h4>
	        		<p>Care at your Convenience. Get tested from the comfort of your home.</p>
				  </div>
				</div>
			</div>
	    </div>
      </form>
    </div>
  </div>
</div>


<div class="niwaxofcanvas offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample-signup">
  <div class="offcanvas-body">
    <div class="cbtn animation">
      <div class="btnclose"> <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button></div>
    </div>
    <div class="form-block sidebarform ">
      <h5 class="pt-3 pb-0">Profile</h5>
      <p class="subhead">Please Enter Your details</p>
      <form id="profile_popup_form" name="profile_popup_form" method="post" data-bs-toggle="validator" class="shake mt40" autocomplete="off">
		     <div class=" step-info p-3">
		        <div class="row">
		          <div class="form-group col-sm-12">
		          	<label>First Name*</label>
		          </div>
		          <div class="form-group col-sm-12">
		            <input type="text" name="name" id="name" value="<?=$this->rs_customer['name']?>" placeholder="" required data-error="Please fill Out">
		            <div class="help-block with-errors"></div>
		          </div>
		        </div>
		        <div class="row">
		          <div class="form-group col-sm-12">
		          	<label>Last Name*</label>
		          </div>
		          <div class="form-group col-sm-12">
		            <input type="text" name="last_name" value="<?=$this->rs_customer['last_name']?>" id="last_name" placeholder="" required data-error="Please fill Out">
		            <div class="help-block with-errors"></div>
		          </div>
		        </div>
		        <div class="row">
		          <div class="form-group col-sm-12">
		          	<label>Email</label>
		          </div>
		          <div class="form-group col-sm-12">
		            <input type="text" name="email" id="email" value="<?=$this->rs_customer['email']?>" placeholder="" data-error="Please fill Out">
		            <div class="help-block with-errors"></div>
		          </div>
		        </div>

		        <div class="row">
		          <div class="form-group col-sm-12">
		          	<label>Mobile No.*</label>
		          </div>
		          <div class="form-group col-sm-12">
		            <input type="text" disabled value="<?=$this->rs_customer['phone']?>" placeholder="" data-error="Please fill Out">
		            <div class="help-block with-errors"></div>
		          </div>
		        </div>
		        <button type="submit" id="profile_popup_btn" class="btn lnk btn-main bg-btn mt-2">Save Details <span class="circle"></span></button>
		        <div id="msgSubmit" class="h3 text-center hidden"></div>
		        <div class="clearfix"></div>
	  	  </div>

		 
      </form>
    </div>
  </div>
</div>

<!--end sidebar -->
<div class="niwaxofcanvas offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample-download">
  <div class="offcanvas-body">
    <div class="cbtn animation">
      <div class="btnclose"> <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button></div>
    </div>
    <div class="form-block sidebarform ">
      <h5 class="pt-3 pb-0">Download Reports</h5>
      <p class="subhead">View your test reports</p>
      <form id="download_test_report" name="download_test_report" method="post" data-bs-toggle="validator" class="sidebarForm shake mt40" autocomplete="off">
        <div class="row">
          <div class="form-group col-sm-12">
          	<label>Lab/Visit ID</label>
            <input type="text" placeholder="" class="required" name="visitor_id" id="visitor_id" required data-error="Please fill Out" autocomplete="off">
            <div class="help-block with-errors"></div>
          </div>
          <div class="form-group col-sm-12">
          	<label>Password</label>
            <input type="text" placeholder="" class="required" name="lab_password" id="lab_password" required data-error="Please fill Out" autocomplete="off">
            <div class="help-block with-errors"></div>
          </div>
        </div>
       <button type="submit" id="download_report_submit" class="btn lnk btn-main bg-btn w-100 login-btn">Check Report <span class="circle"></span></button>
	  </form>
        <div id="no_report_found" class="mt-3"></div>
        <div class="clearfix"></div>
        <div class="col-12 p-0 mt-4 text-center slidi">
						<div class="col-12 ">
							  <div class="t-text">
				        		<img src="images/slide-3.png" />
					        		<h4>Digital Report Bank</h4>
					        		<p>Access speedy reports from everywhere and anywhere.</p>
							  </div>
						</div>
	    	</div>
        <div class="col-12 p-0 mt-5 pt-3 text-center">
					  <a class="text-blue text-bold" href="http://182.72.101.236/mdrcnew/design/onlinelab/" target="_blank">Download Report Client</a>
	    </div>
      
    </div>
  </div>
</div>
<!--End Header -->


