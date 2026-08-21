<!DOCTYPE html>
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

    <!-- Iconly Icon css -->
    <link rel="stylesheet" type="text/css" href="assets/css/iconly.css" />

    <!-- Slick css -->
    <link rel="stylesheet" type="text/css" href="assets/css/vendors/slick.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/vendors/slick-theme.css" />

    <!-- Style css -->
    <link rel="stylesheet" id="change-link" type="text/css" href="assets/css/style.css" />

    <!-- Jquery UI css -->
    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet">

    <!-- Custom Css -->
    <link rel="stylesheet" type="text/css" href="assets/css/custom.css" />
</head>
<!-- Head End -->

<!-- Body Start -->

<body>
    <!-- Header Start -->
    <header class="header">
        <div class="logo-wrap">
            <a href="family-friends.php"><i data-feather="chevron-left"></i></a>
            <h2 class="fw-bold font-md">Add Member</h2>
        </div>
    </header>
    <!-- Header End -->
    <!-- Main Start -->
    <main class="addmeber-page main-wrap bg-white pt-3 main-btm-pd">

        <!-- Add Member Form Start -->
        <form action="#" class="custom-form" id="addMember">
            <div class="input-box">
                <div class="row g-3">
                    <div class="col-3">
                        <select name="" id="" class="form-select">
                            <option value="" selected>Mr</option>
                            <option value="">Mrs</option>
                        </select>
                    </div>
                    <div class="col">
                        <input type="text" name="fname" placeholder="First Name" class="form-control" required>
                    </div>
                    <div class="col">
                        <input type="text" name="lname" placeholder="Last Name" class="form-control" required>
                    </div>
                </div>
            </div>
            <div class="input-box">
                <div class="row g-3 ">
                    <div class="col-6">
                        <select name="" id="" class="form-select">
                            <option value="" selected>Gender</option>
                            <option value="">Male</option>
                            <option value="">Female</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <select name="" id="" class="form-select">
                            <option value="" selected>Relaction</option>
                            <option value="">Father</option>
                            <option value="">Mother</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="input-box">
                <div class="row g-3">
                    <div class="col-12">
                        <input type="text" class="form-control" placeholder="Enter Mobile Number" name="phone" required>
                    </div>
                </div>
            </div>
            <div class="input-box">
                <div class="row g-3">
                    <div class="col-6 position-relative">
                        <input type="text" class="form-control" placeholder="Date Of Birth" id="Datepicker">                        
                        <img src="assets/images/mdrc/icons/calendar.svg" alt="" class="inputimgset">
                    </div>
                    <div class="col-6">
                        <input type="text" class="form-control" placeholder="Age" name="age" required>
                    </div>
                </div>
            </div>
            <div class="input-box">
                <div class="row g-3">
                    <div class="col-12">
                        <textarea name="" id="" class="w-100" rows="1" placeholder="Address"></textarea>
                    </div>
                </div>
            </div>
            <div class="input-box">
                <div class="row g-3">
                    <div class="col-6">
                        <input type="text" class="form-control" placeholder="State" name="state" required>
                    </div>
                    <div class="col-6">
                        <select name="" id="" class="form-select">
                            <Option selected>City</Option>
                            <Option>Jaipur</Option>
                            <Option>Udaipur</Option>
                            <Option>Jodphur</Option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="input-box">
                <div class="row g-3">
                    <div class="col-6">
                        <input type="text" class="form-control" placeholder="Area" name="area" required>
                    </div>
                    <div class="col-6">
                        <input type="text" class="form-control" placeholder="Pincode" name="pincode" required>
                    </div>
                </div>
            </div>

            <div class="save-btn mt-4">
                <button type="submit" class="btn-solid w-100 rounded-pill">Save</button>
            </div>
        </form>
        <!-- Add Member End -->
    </main>
    <!-- Main End -->

    <!-- Footer Start -->
    <?php include('includes/footer.php'); ?>
    <!-- Footer End -->


    <!-- ============================== Date Image Start =========================================================================== -->
    <!-- Header Start -->
   <header class="header">
    <div class="logo-wrap">
      <a href="#"><i data-feather="chevron-left"></i></a>
      <h2 class="fw-bold font-md">My Family & Friends</h2>   
    </div>     
  </header>
  <!-- Header End -->
    <!-- Main Start -->
    <main class="success-page bg-white main-wrap">

    <div class="d-flex align-item-center justify-content-center pt-5 pb-5">
        <img src="assets/images/mdrc/family/no-data.png" alt="img-fluid d-block">
    </div>
    <div>
        <h2 class="fw-bold text-center mb-3 font-lg theme-color">No Members found in your account!</h2>
        <p class="fw-600 text-center font-md text-secondary lh-sm">Kindly Add Member to Continue</p>
    </div>
    <div class="d-flex justify-content-center mt-5">
    <a href="add-member.html" class="btn btn-outline-solid btn-md d-flex align-items-center"><i data-feather="plus" class="icon-size-1 me-1"></i>Add Member</a>
</div>
    </main>
    <!-- Main End -->
    <!-- ============================== Date Image End=========================================================================== -->

    <!-- jquery 3.6.0 -->
    <script src="assets/js/jquery-3.6.0.min.js"></script>    
                
    <!-- Bootstrap Js -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <!-- Lord Icon -->
    <script src="assets/js/lord-icon-2.1.0.js"></script>

    <!-- Feather Icon -->
    <script src="assets/js/feather.min.js"></script>

    <!-- Slick Slider js -->
    <script src="assets/js/slick.js"></script>
    <script src="assets/js/slick.min.js"></script>
    <script src="assets/js/slick-custom.js"></script>

    <!-- Add To Home  js -->
    <script src="assets/js/homescreen-popup.js"></script>

    <!-- Theme Setting js -->
    <script src="assets/js/theme-setting.js"></script>

    <!-- Script js -->
    <script src="assets/js/script.js"></script>

    <!-- jquery UI -->
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <!-- Custom js -->
    <script src="assets/js/custom.js"></script>

    <script>
        $(function() {
          $('#Datepicker').datepicker();
        });
      </script>

</body>
<!-- Body End -->



</html>