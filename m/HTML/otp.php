<!DOCTYPE html>
<!-- Html Start -->
<html lang="en">
  <!-- Head Start -->
  

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="MDRC" />
    <meta name="keywords" content="MDRC" />
    <meta name="author" content="MDRC" />
    <link rel="manifest" href="manifest.json" />
    <title>MDRC</title>
    <link rel="icon" href="assets/images/favicon.png" type="image/x-icon" />
    <link rel="apple-touch-icon" href="assets/images/favicon.png" />
    <meta name="theme-color" content="#0baf9a" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="apple-mobile-web-app-title" content="MDRC" />
    <meta name="msapplication-TileImage" content="assets/images/favicon.png" />
    <meta name="msapplication-TileColor" content="#FFFFFF" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- Bootstrap 5 -->
    <link rel="stylesheet" id="rtl-link" type="text/css" href="assets/css/vendors/bootstrap.css" />

    <!-- Style css -->
    <link rel="stylesheet" id="change-link" type="text/css" href="assets/css/style.css" />

     <!-- Custom Css -->
     <link rel="stylesheet" type="text/css" href="assets/css/custom.css" />
  </head>
  <!-- Head End -->

  <!-- Body Start -->
  <body>  

    <!-- Main Start -->
    <main class="main-wrap login-page bg-white">
      <div class="logo mb-5 mt-5"><img src="assets/images/mdrc/logo/logo.png" /></div>
      <h2 class="fw-700 font-lg">Verify OTP </h2>  
      <p class="content-color font-sm">Please Enter 4-Digit OTP Sent to</p>
      <span class="font-md">
        +91*******123 
        <!-- <a href="forgot-password.html"> <i data-feather="edit-3"></i></a> -->
      </span>

      <!-- Login Section Start -->
      <section class="login-section p-0">
        <!-- Login Form Start -->
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
        <!-- Login Form End -->
      </section>
      <!-- Login Section End -->
    </main>
    <!-- Main End -->

    <!-- jquery 3.6.0 -->
    <script src="assets/js/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap Js -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <!-- OTP Js -->
    <script src="assets/js/otp.js"></script>

    <!-- Feather Icon -->
    <script src="assets/js/feather.min.js"></script>

    <!-- Theme Setting js -->
    <script src="assets/js/theme-setting.js"></script>

    <!-- Script js -->
    <script src="assets/js/script.js"></script>
  </body>
  <!-- Body End -->


</html>
<!-- Html End -->
