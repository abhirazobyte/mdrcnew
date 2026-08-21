
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
<?php include 'includes/header.php'; ?>
<!--End Header -->
<!--Start Hero-->
<section class="shop-products-bhv booking-info pt40 pb60">
 <div class="container">

 <div class="row">
 <div class="col-lg-12 mb-4">
 <h4 class="succsesDiv rounded"><img src="images/icon-check.png" alt="" /> Your payment is Confirmed!</h4>
 </div>
 </div>

<?php if(!empty($this->tracking_id)) { ?>
    <div class="row mb-2">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-12 mb-2 ">
                <h4>Online Payment Summary</h4>
                </div>
            </div>
            <div class="row m-auto">
                <div class="col-lg-12 bg-white pt-2 pb-2 mb-3 border rounded text-center">
                    <div class="row">
                        <div class="col-lg-4 text-center pt-2 pb-2 col-md-4 col-4">
                            <span class="d-inline-block fs-14 w-100">Tracking ID</span>
                            <span class="d-inline-block text-dark mt-2 w-100"><?=$this->tracking_id;?></span>
                        </div>
                        <div class="col-lg-4 text-center pt-2 pb-2 col-md-4 col-4">
                            <span class="d-inline-block fs-14 w-100">Transaction Status</span>
                            <span class="d-inline-block text-dark mt-2 w-100"><?=$this->pay_status;?></span>
                        </div>
                        <div class="col-lg-4 text-center pt-2 pb-2 col-md-4 col-4">
                            <span class="d-inline-block fs-14 w-100">Transaction  Amount</span>
                            <span class="d-inline-block text-dark mt-2 w-100"><i class="fas fa-rupee-sign"></i> <?=$this->pay_amount;?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>



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