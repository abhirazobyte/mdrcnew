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

    <!-- Custom Css -->
    <link rel="stylesheet" type="text/css" href="assets/css/custom.css" />
</head>
<!-- Head End -->

<!-- Body Start -->

<body>
    <!-- Header Start -->
    <header class="header">
        <div class="logo-wrap">
            <a href="index.php"><i data-feather="chevron-left"></i></a>
            <h2 class="fw-bold font-md">My Family & Friends</h2>
        </div>
    </header>
    <!-- Header End -->
    <!-- Main Start -->
    <main class="main-wrap bg-white mt-3 page-common pt-3">
   <a href="add-member.php" class="btn btn-solid rounded-pill w-100 font-md mb-3 d-block">
    <img src="assets/images/mdrc/icons/plus-fill-white.svg" alt="" class="img-fluid me-1 mb-1">
    Add More Member 
</a>
   <div class="card p-3 mb-3">
      <div class="d-flex justify-content-between">
        <div>
            <h3 class="font-md fw-600 mb-2">1. Mr. Virag Gandhi</h3>
            <p class="mb-0 text-secondary">Self</p>
            <p class="mb-0 text-secondary"><span>Male </span><span class="bdot ms-3"></span>40 yrs.</p>
        </div>
        <div class="d-flex flex-column gap-3 align-items-end">
            <a href="#">
            <img src="assets/images/mdrc/icons/edit.svg" alt="" class="img-fluid">
            <span class="font-md fw-600 theme-color">Edit</span>
        </a>
        <a href="#" type="button" data-bs-toggle="offcanvas" data-bs-target="#cardDelete" aria-controls="cardDelete">
            <img src="assets/images/mdrc/icons/trash.svg" alt="" class="img-fluid">
        </a>

        </div>
      </div>
   </div>
   <div class="card p-3 mb-3">
    <div class="d-flex justify-content-between">
      <div>
          <h3 class="font-md fw-600 mb-2">1. Mr. Virag Gandhi</h3>
          <p class="mb-0 text-secondary">Self</p>
          <p class="mb-0 text-secondary"><span>Male </span><span class="bdot ms-3"></span>40 yrs.</p>
      </div>
      <div class="d-flex flex-column gap-3 align-items-end">
          <a href="#">
          <img src="assets/images/mdrc/icons/edit.svg" alt="" class="img-fluid">
          <span class="font-md fw-600 theme-color">Edit</span>
      </a>
      <a href="#" type="button" data-bs-toggle="offcanvas" data-bs-target="#cardDelete" aria-controls="cardDelete">
          <img src="assets/images/mdrc/icons/trash.svg" alt="" class="img-fluid">
      </a>

      </div>
    </div>
 </div>
 <div class="card p-3 mb-3">
    <div class="d-flex justify-content-between">
      <div>
          <h3 class="font-md fw-600 mb-2">1. Mr. Virag Gandhi</h3>
          <p class="mb-0 text-secondary">Self</p>
          <p class="mb-0 text-secondary"><span>Male </span><span class="bdot ms-3"></span>40 yrs.</p>
      </div>
      <div class="d-flex flex-column gap-3 align-items-end">
          <a href="#">
          <img src="assets/images/mdrc/icons/edit.svg" alt="" class="img-fluid">
          <span class="font-md fw-600 theme-color">Edit</span>
      </a>
      <a href="#" type="button" data-bs-toggle="offcanvas" data-bs-target="#cardDelete" aria-controls="cardDelete">
          <img src="assets/images/mdrc/icons/trash.svg" alt="" class="img-fluid">
      </a>
      </div>
    </div>
 </div>
    </main>
    <!-- Main End -->

      <!--  Delete Card Offcanvas Start -->
      <div class="h-auto offcanvas offcanvas-bottom" tabindex="-1" id="cardDelete" aria-labelledby="cardDelete">        
        <div class="offcanvas-body small py-3">
            <div class="icon-warning-popup pb-3">
                <i data-feather="alert-circle" class="text-warning"></i>
            </div>    
            <div class="mb-2">
                <h2 class="fw-bold font-lg text-center mb-2">Are you sure?</h2>
                <p class="mb-0 text-center">You will not be able to undo after this action!</p>
            </div>                
            <div class="offcanvas-footer py-3">
                <div class="btn-box d-flex align-items-center justify-content-center">
                    <a href="#" class="btn btn-solid d-block w-100" data-bs-dismiss="offcanvas">
                       Cancel
                    </a>
                    <a href="#" class="btn th-btn-red d-block w-100 ms-3">
                        Yes, delete it!
                     </a>
                </div>
            </div>
    </div>
    </div>
    <!--  Delete Card Offcanvas End -->
    

     <!-- Footer Start -->
     <?php include('includes/footer.php'); ?>
    <!-- Footer End -->


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

    <!-- Custom js -->
    <script src="assets/js/custom.js"></script>
</body>
<!-- Body End -->



</html>