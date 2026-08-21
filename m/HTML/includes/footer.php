 <!-- Footer Start ---------------------->
 <footer class="footer-wrap">
        <ul class="footer">
            <li class="footer-item active">
                <a href="index.php" class="footer-link">
                    <i class="iconly-Home icli"></i>
                    <!-- <span>Home</span> -->
                </a>
            </li>
            <li class="footer-item">
                <a href="health-package.php" class="footer-link">
                    <!-- <i class="iconly-Category icli"></i> -->
                    <i data-feather="search" class="text-white"></i>
                    <!-- <span>Search</span> -->
                </a>
            </li>
            <li class="footer-item">
                <a href="index.php" class="footer-link">
                    <span class="bottom-bar-logo">
                        <figure class="mb-0">
                        <img src="assets/images/favicon.png" />
                        </figure>
                    </span>                    
                </a>
            </li>
            <li class="footer-item">
                <a href="support.php" class="footer-link">
                    <!-- <i class="iconly-Call icli"></i> -->
                    <i data-feather="headphones" class="text-white"></i>
                    <!-- <span class="offer">Support</span> -->
                </a>
            </li>
            <li class="footer-item">
                <a href="account.php" class="footer-link">
                    <!-- <i class="iconly-User2 icli"></i> -->
                    <img src="assets/images/mdrc/icons/profile.svg" alt="" >
                    <!-- <span>My Account</span> -->
                </a>
            </li>
        </ul>
    </footer>
    <!-- Footer End ------------------->

    <!-- Login Modal Start -->
<div class="action action-confirmation offcanvas offcanvas-bottom" tabindex="-1" id="login-popup" aria-labelledby="login-popup">
	<div class="offcanvas-body small">
	<div class="confirmation-box">
		<!-- Main Start -->
        <div class="main-wrap login-page bg-white">
            <div class="logo mb-5 mt-0 m-auto"><img src="assets/images/mdrc/logo/logo.png" /></div>
            <h2 class="fw-700 font-lg">Welcome Back  👋</h2>     
            <p class="content-color font-sm">Please Enter Your Phone Number to Proceed</p>

            <!-- Login Section Start -->
            <section class="login-section p-0 mt-4">
                <!-- Login Form Start -->
                <form action="" class="custom-form">        
                <!-- Email Input start -->
                <div class="input-box">     
                    <label for="phone" class="mb-1 d-block text-start font-md title-color fw-600">Phone Number</label>       
                    <input type="text" placeholder="Enter Phone Number" id="phone" required class="form-control" />       
                </div>                    
                <a href="otp.php" class="btn-solid">Continue</a>           
                <div class="d-flex align-items-center px-1">
                    <input type="checkbox" id="Terms" name="terms">
                    <label class="mb-0 ms-3 font-ms d-block text-start w-100" for="Terms">
                        By going forward, you agree to our <a href="#"><b>Terms & Conditions</b></a> and <a href="privacy-policy.php"><b>Privacy Policy</b></a>
                    </label>
                </div>     
                </form>
                <!-- Login Form End -->
        
            </section>
            <div class="mt-5"> <p class="text-center font-sm">If You Have Any Issue! <a href=""><b> Contact Us</b></a></p></div>
            <!-- Login Section End -->


            <!-- Verify OTP Start -->
            <div class="otp-main">
                <!-- <div class="logo mb-5 mt-5"><img src="assets/images/mdrc/logo/logo.png" /></div> -->
                <h2 class="fw-700 font-lg">Verify OTP </h2>  
                <p class="content-color font-sm">Please Enter 4-Digit OTP Sent to</p>
                <span class="font-md">
                    +91*******123 
                    <!-- <a href="forgot-password.html"> <i data-feather="edit-3"></i></a> -->
                </span>

                <!-- Verify OTP Section Start -->
                <section class="login-section p-0">
                    <!-- Verify OTP Form Start -->
                    <form action="" class="custom-form">
                    <h1 class="font-md title-color fw-600">Verification Code</h1>

                    <div class="countdown mb-md">
                        <div class="input-box otp-input">
                        <input class="otp form-controll" placeholder="0" type="text" required oninput="digitValidate(this)" onkeyup="tabChange(1)" maxlength="1" />
                        <input class="otp form-controll" placeholder="0" type="text" required oninput="digitValidate(this)" onkeyup="tabChange(2)" maxlength="1" />
                        <input class="otp form-controll" placeholder="0" type="text" required oninput="digitValidate(this)" onkeyup="tabChange(3)" maxlength="1" />
                        <input class="otp form-controll" placeholder="0" type="text" required oninput="digitValidate(this)" onkeyup="tabChange(4)" maxlength="1" />
                        </div>
                    </div>          
                    <a href="signup.php" class="btn-solid">Verify OTP</a>           
                    <!-- Count Down Start -->
                    <div class="otp-countdown text-center">
                        <div class="content-color">
                        <p>If you  didn’t receive code! </p>
                        <a href="javascript:void(0)" class="resend-otp">Resend OTP </a> <span class="time"> In <span id="timer"></span></span>
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
<!-- Login Modal End -->