<!-- Login Modal Start -->
<div class="action action-confirmation offcanvas offcanvas-bottom common-popup" tabindex="-1" id="login" aria-labelledby="login">
    <div class="offcanvas-header">
        <div class="d-flex align-items-center justify-content-end w-100">
            <div class="btnclose"> 
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
        </div>
    </div>
    <div class="offcanvas-body small">
        <div class="confirmation-box">
            <!-- Main Start -->
            <div class="main-wrap login-page bg-white">
                <div class="logo mb-5 mt-0 m-auto"><img src="assets/images/mdrc/logo/logo.png" /></div>
                <h2 class="fw-700 font-lg">Login/Sign Up 👋</h2>
                <p class="content-color font-sm">Please Enter Your Phone Number to Proceed</p>
                <!-- Login Section Start -->
                <section class="login-section p-0 mt-4">
                    <!-- Login Form Start -->
                    <form id="signin_popup_form" name="signin_popup_form" method="post" class="sidebarForm custom-form" autocomplete="off">
                        <input type="hidden" class="" id="action_type" name="action_type" value="login">
                        <!-- Email Input start -->
                        <div class="input-box">
                            <label for="phone" class="mb-1 d-block text-start font-md title-color fw-600">Phone Number</label>
                            <input type="text" placeholder="Enter Phone Number" id="phone" name="phone" class="login_f_data form-control required number numbers" maxlength="10" minlength="10" required />
                        </div>
                        <button type="submit" id="loginpopup_submit" class="btn-solid">Continue</button>
                        <div id="invalid_login" class="mt-3"></div>
                    </form>
                    <!-- Login Form End -->
                </section>
                <div class="mt-5">
                    <p class="text-center font-sm">If You Have Any Issue! <a href=""><b> Contact Us</b></a></p>
                </div>
                <!-- Login Section End -->
            </div>
            <!-- Main End -->
        </div>
    </div>
</div>
<!-- Login Modal End -->


<!-- otp Modal Start -->
<div class="action action-confirmation offcanvas offcanvas-bottom common-popup" tabindex="-1" id="otpverify" aria-labelledby="otpverify">
    <div class="offcanvas-body small">
        <div class="confirmation-box">
            <!-- Main Start -->
            <div class="main-wrap login-page bg-white">
                <div class="logo mb-5 mt-0 m-auto"><img src="assets/images/mdrc/logo/logo.png" /></div>
                <!-- Verify OTP Start -->
                <div class="otp-main">
                    <h2 class="fw-700 font-lg">Verify OTP </h2>
                    <p class="content-color font-sm">Please Enter 4-Digit OTP Sent to</p>
                    <span class="font-md signup_login_phone"> +91*******123</span>
                    <!-- Verify OTP Section Start -->
                    <section class="login-section p-0">
                        <!-- Verify OTP Form Start -->
                        <form id="otp_popup_form" name="otp_popup_form" method="post" class="custom-form">
                            <input type="hidden" class="" id="action_type" name="action_type" value="otp">
                            <h1 class="font-md title-color text-center fw-600">Verification Code</h1>
                            <div class="countdown mb-md">
                                <input type="text" id="otpch1" name="otpch1" maxlength="4" minlength="4" class="required number numbers" placeholder="" data-error="">
                            </div>
                            <button type="submit" class="btn-solid" id="otppopup_submit">Verify OTP</button>
                            <div id="invalid_otp" class="mt-3"></div>
                            <!-- Count Down Start -->
                            <div class="otp-countdown text-center">
                                <div class="content-color">
                                    <p>If you didn’t receive code! </p>
                                    <a href="javascript:void(0)" class="resend-otp" id="resend_otp_p">Resend OTP </a> 
                                    <a class="text-blue timi" id="claim_counter"></a>
                                </div>
                            </div>
                            <!-- Count Down End -->
                        </form>
                        <!-- Verify OTP Form End -->
                    </section>
                    <!-- Verify OTP Section End -->
                </div>
                <!-- Verify OTP End -->
            </div>
            <!-- Main End -->
        </div>
    </div>
</div>
<!-- otp Modal End -->


<!-- otp Modal Start -->
<div class="action action-confirmation offcanvas offcanvas-bottom" tabindex="-1" id="signup" aria-labelledby="signup">
    <div class="offcanvas-body small">
        <div class="confirmation-box">
            <!-- Main Start -->
            <div class="main-wrap login-page bg-white">
                <div class="logo mb-5 mt-0 m-auto"><img src="assets/images/mdrc/logo/logo.png" /></div>
                <!-- Verify OTP Start -->
                <div class="otp-main">
                    <h2 class="fw-700 font-lg">Profile </h2>
                    <p class="content-color font-sm">Please Enter Your details</p>
                    <!-- Verify OTP Section Start -->
                    <section class="login-section p-0">
                        <!-- Verify OTP Form Start -->
                        <form id="profile_popup_form" name="profile_popup_form" method="post" class="custom-form">
                            <div class="input-box">
                                <label for="phone" class="mb-1 d-block text-start font-md title-color fw-600">First Name*</label>
                                <input type="text" id="name" name="name" value="<?= $this->rs_customer['name'] ?>" class="form-control required" required />
                            </div>
                            <div class="input-box">
                                <label for="phone" class="mb-1 d-block text-start font-md title-color fw-600">Last Name*</label>
                                <input type="text" id="last_name" value="<?= $this->rs_customer['last_name'] ?>" name="last_name" class="form-control required" required />
                            </div>
                            <div class="input-box">
                                <label for="phone" class="mb-1 d-block text-start font-md title-color fw-600">Email</label>
                                <input type="text" id="email" name="email" value="<?= $this->rs_customer['email'] ?>" class="form-control" />
                            </div>
                            <div class="input-box">
                                <label for="phone" class="mb-1 d-block text-start font-md title-color fw-600">Mobile No.*</label>
                                <input type="text" id="showPhone" class="form-control" />
                            </div>
                            <button type="submit" class="btn-solid" id="profile_popup_btn">Save Details</button>
                        </form>
                        <!-- Verify OTP Form End -->
                    </section>
                    <!-- Verify OTP Section End -->
                </div>
                <!-- Verify OTP End -->
            </div>
            <!-- Main End -->
        </div>
    </div>
</div>
<!-- otp Modal End -->

<!-- City Modal Start -->
<div class="action action-confirmation offcanvas offcanvas-bottom" tabindex="-1" id="cityPopup" aria-labelledby="cityPopup">
    <div class="offcanvas-body small">
        <div class="confirmation-box">
            <!-- Main Start -->
            <div class="main-wrap login-page bg-white">
                <h4>Select Your City</h4>
                <!-- Location Button Start -->
                <div class="bg-white main-wrap py-3">
                    <a class="btn btn-solid w-100 font-sm" onclick="getLocation()"> <img src="assets/images/mdrc/icons/location.svg" alt="" class="img-fluid mb-1"> Use My Current Location</a>
                    <div id="googleMapApiResult" class="text-center mt-2"></div>
                </div>
                <!-- Location Button Start -->
                <!-- OR Line Start-->
                <div class="bg-white main-wrap pb-3">
                    <p class="orline px-3 text-center mb-0">OR</p>
                </div>
                <!-- OR Line End-->
                <!-- Search Box-->
                <div class="bg-white main-wrap">
                    <div class="search-box">
                        <img src="assets/images/mdrc/icons/search.svg" alt="" class="iconly-Search icli search inputsrcicon">
                        <input class="form-control" type="search" placeholder="Search Your City" onkeyup="m_show_suggestion(this.value)" />
                    </div>
                    <!-- Search Box End-->
                    <!-- Serch City Start -->
                    <section class="location-city-section">
                        <div class="row g-0">
                            
                            <?php 
                            for($i=0;$i<count($this->rs_gs_city);$i++){
                                if($this->rs_gs_city[$i]['image']!=''){
                                $cityName=$this->rs_gs_city[$i]['name'];
                                $cityId=$this->rs_gs_city[$i]['id'];
                                $cityimage=$this->rs_gs_city[$i]['image'];
                                $activeClass='';
                                if($cityId==$_SESSION['cityID'])
                                {
                                    $activeClass='active';
                                }
                                $cityimage = $this->utility->get_image_path($cityimage, 'city', 'large');
                            ?>
                            <div class="col-sm-3 col-4 sCity">
                                <a href="javascript:void(0)" class="<?=$activeClass?>" onclick="changeCity(<?=$cityId?>)">
                                    <div class="city-box">
                                        <figure class="mb-1">
                                            <img src="<?=$cityimage?>" alt="<?=$cityName?>" class="img-fluid">
                                        </figure>
                                        <p><?=$cityName?></p>
                                    </div>
                                </a>
                            </div>
                            <?php }}?>
                        </div>
                        <!-- Serach Name -->
                        <div class="mt-3 sCity">
                            <?php for($i=0;$i<count($this->rs_gs_city);$i++){
								if($this->rs_gs_city[$i]['image']==''){
								$cityName=$this->rs_gs_city[$i]['name'];
								$cityId=$this->rs_gs_city[$i]['id'];
								$cityimage=$this->rs_gs_city[$i]['image'];
								$activeClass='';
								if($cityId==$_SESSION['cityID'])
								{
									$activeClass='active';
								}
								$cityimage = $this->utility->get_image_path($cityimage, 'city', 'large');
								?>
                            <p class="search-name font-md"><a href="javascript:void(0)" onclick="changeCity(<?=$cityId?>)" class="<?=$activeClass?>"><?=$cityName?></a></p>
                            <?php }}?>
                            
                        </div>

                        

                    </section>
                </div>
                <!-- Serch City End -->
            </div>
            <!-- Main End -->
        </div>
    </div>
</div>
<!-- City Modal End -->

<!-- Book a test Start -->
<div class="action action-confirmation offcanvas offcanvas-bottom common-popup" tabindex="-1" id="bookATestMdrc-offcanvas" aria-labelledby="bookATestMdrc-offcanvas">
    	<div class="offcanvas-header">
		<div class="d-flex align-items-center justify-content-between w-100">
			<h3 class="fw-600">Not able to find your test?</h3>
			<div class="btnclose">
				<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
			</div>
		</div>
	</div>
    <div class="offcanvas-body small pt-0">
        <div class="col-md-12 col-12">
            <div class="row justify-content-center">
                <div class="col-md-12 text-center">            
                <p>Blood tests can be done through home blood sample collection services that do away with the need to travel to the laboratory. Please fill up the following details for appointment. You will receive an confirmation call from centre regarding appointment details.</p>
                </div>
            </div>

            <div class="row justify-content-center mt30">
                <div class="col-md-12">
                <div class="form-block fdgn2 mt10 mb10">
                    <form method="post" id="collection_appointment" name="collection_appointment" class="custom-form">
                    <div class="fieldsets row">

                        <?php $name=''; if($this->rs_customer['name']!=''){
                        $name = $this->rs_customer['name']." ".$this->rs_customer['last_name']; }
                        ?>
                        <div class="col-md-6 input-box"><input required="required" type="text" class="form-control" placeholder="Full Name*" name="name" id="name" value="<?=$name?>"></div>
                        <div class="col-md-6 input-box"><input required="required" type="email" class="form-control" placeholder="Email*" name="email" id="email" value="<?=$this->rs_customer['email']?>"></div>
                    </div>
                    <div class="fieldsets row">
                        <div class="col-md-6 input-box"><input  required="required" type="phone" class="form-control" placeholder="Phone*" class="numbersOnly" value="<?=$this->rs_customer['phone']?>" name="phone" id="phone"></div>
                        <div class="col-md-6 input-box"><input type="text" placeholder="Age" class="form-control" class="numbersOnly" name="age" id="age"></div>
                    </div>
                    <div class="fieldsets row">
                        <div class="col-md-6 input-box">
                        <select  required="required" name="city" id="city" class="form-control">
                            <option value="">Select City</option>
                            <?php for ($i=0; $i < count($this->rs_gs_city) ; $i++) { ?>
                                                        <option value="<?=$this->rs_gs_city[$i]['name']?>"><?=$this->rs_gs_city[$i]['name']?></option>
                                                    <?php }?>	
                                                </select>
                                                </div>


                        <div class="col-md-6 form-group">
                        <div class="row align-items-center no-gutters">
                            <div class="col-lg-6 col-md-5 input-box">
                                <input type="date" class="form-control" placeholder="Date*" id="date" name="date">
                            </div>
                            <div class="col-lg-6 col-md-7 d-flex gap-3 input-box radio-booktest">
                            <label class="text-dark ms-0 me-2 font-sm d-flex align-items-center" for="gender_male" ><input type="radio" value="Male" id="gender_male" name="gender"/> Male</label>
                            <label class="text-dark font-sm d-flex align-items-center" for="gender_female" ><input type="radio" value="Female" id="gender_female" name="gender"/> Female</label>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="fieldsets row">
                        <div class="col-md-6 input-box"><textarea placeholder="Address" class="form-control" id="address" name="address"></textarea></div>
                        <div class="col-md-6 input-box"><textarea placeholder="Brief details of your illness" class="form-control" id="brief_details" name="brief_details"></textarea></div>
                    </div>
                    <div class="fieldsets row">
                        <div class="col-md-12 input-box">
                        <select  name="reference" id="reference" class="form-control">
                                                        <option selected="selected" value="">How did you hear about us</option>
                                                        <option value=""> - Select Reference - </option>
                                                        <option value="newspaper">From Newspaper</option>
                                                        <option value="facebook">From Facebook</option>
                                                        <option value="twitter">From Twitter</option>
                                                        <option value="youtube">From Youtube</option>
                                                        <option value="just_dial">From Just Dial</option>
                                                        <option value="friends">Friends Reference</option>
                                                        <option value="doctor_reference">Doctor Reference</option>
                                                        <option value="old_patients">Patient Reference</option>
                                                        <option value="none">Any Other</option>
                        </select>
                        </div>
                    </div>
                    <div class="fieldsets row mt30 pb20 justify-content-center">
                        <div class="col-md-8">
                        <button type="submit" class="lnk btn-main bg-btn collection_appointment_btn btn-solid">Submit</button>
                        </div>
                    </div>
                    <div class="fieldsets row">
                        <div class="col-md-12">
                        <div id="collection_appointment_error_msg">
                        </div>
                            </div>
                        </div>
                    </form>

                </div>
                </div>
            </div>
        </div>
    </div>
 </div>
<!-- Book a test End -->