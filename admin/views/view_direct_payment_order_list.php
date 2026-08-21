<!-- vendor css -->
<link href="lib/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
<link href="lib/ionicons/css/ionicons.min.css" rel="stylesheet">
<link href="lib/typicons.font/typicons.css" rel="stylesheet">
<link href="lib/prismjs/themes/prism-vs.css" rel="stylesheet">
<link href="lib/datatables.net-dt/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css" rel="stylesheet">
<link href="lib/select2/css/select2.min.css" rel="stylesheet">
<!-- DashForge CSS -->
<link rel="stylesheet" href="assets/css/dashforge.css">
<link rel="stylesheet" href="assets/css/dashforge.demo.css">
<!-- Skin CSS -->
<link rel="stylesheet" href="assets/css/skin.cool.css">
<!--<link rel="stylesheet" href="assets/css/skin.charcoal.css">-->
<!-- Custom CSS -->
<link rel="stylesheet" href="assets/css/custom.css">
<!--Sweet Alert CSS & JS -->
<link href="lib/alert/css/sweet-alert.css" rel="stylesheet" type="text/css" />
<!-- file upload  -->
<link href="lib/bootstrap-file/css/fileupload.css" rel="stylesheet" type="text/css" />
<!--image popup -->
<link href="lib/magnific-popup/css/magnific-popup.css" rel="stylesheet" type="text/css" />
<?php include('includes/menu.php');?>
<div class="content ht-100v pd-0">
  <?php include('includes/header.php');?>
  <!-- sidebar -->
  <div class="section-nav" style="display:none;">
    <label class="nav-label">On This Page</label>
    <nav id="navSection" class="nav flex-column"> <a href="#section1" class="nav-link">Basic DataTable</a> <a href="#section2" class="nav-link">Responsive DataTable</a> <a href="#section3" class="nav-link">Data Source (Array)</a> <a href="#section4" class="nav-link">Data Source (Object)</a> </nav>
  </div>
  <!-- df-section-nav -->
  <div class="content-body">
    <div class="container">
      <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb df-breadcrumbs mg-b-10">
              <li class="breadcrumb-item"><a href="javascript:void(0)">Pay Now Order</a></li>
              <li class="breadcrumb-item active" aria-current="page">List</li>
            </ol>
          </nav>
          <h3 class="mg-b-0 tx-spacing--1">Pay Now Order List</h3>
        </div>
        <div class="d-none d-md-block">
 
        </div>
      </div>
      <div class="df-example datatable-menu-tab">
        <ul class="nav justify-content-left">
          <?php
       $Cancel='';
       $Confirm='';
      if($this->getGetVar('pay_status')=='Cancel')
      {
         $Cancel='active';
      }
      else
      {
        $Confirm='active';
      }
      ?>
          <input type="hidden" name="current_status" id="current_status" value="<?=$this->getGetVar('pay_status')?>">
          <li class="nav-item" > <a class="nav-link <?=$Confirm?>"  href="index.php?view=direct_payment_order_list&pay_status=Confirm">Confirm (<?=$this->ConfirmCount?>)</a> </li>
          <li class="nav-item"> <a class="nav-link <?=$Cancel?>" href="index.php?view=direct_payment_order_list&pay_status=Cancel">Cancel (<?=$this->CancelCount?>)</a> </li>
        </ul>
      </div>

      <div data-label="" class="df-example demo-table">
        <table id="table_direct_payment_order" class="table">
          <thead>
            <tr>
              <th class="wd-5p">ID.</th>
              <th class="wd-10p">Name</th>
              <th class="wd-15p">Mobile & Email</th>
              <th class="wd-10p">Amount</th>
              <th class="wd-10p">Pay Status</th>
              <th class="wd-10p">Date</th>
              <th class="wd-5p">Action</th>
            </tr>
          </thead>
        </table>
      </div>
      <!-- df-example -->
      <?php include('includes/footer.php');?>
      <!-- content-footer -->
    </div>
    <!-- container -->
  </div>
</div>
<!-- content -->
<script src="lib/jquery/jquery.min.js"></script>
<script src="lib/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="lib/feather-icons/feather.min.js"></script>
<script src="lib/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="lib/prismjs/prism.js"></script>
<script src="lib/parsleyjs/parsley.min.js"></script>
<script src="lib/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="lib/datatables.net-dt/js/dataTables.dataTables.min.js"></script>
<script src="lib/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="lib/datatables.net-responsive-dt/js/responsive.dataTables.min.js"></script>
<script src="lib/select2/js/select2.min.js"></script>
<script src="assets/js/dashforge.aside.js"></script>
<script src="assets/js/dashforge.js"></script>
<!-- other include -->
<script src="lib/alert/js/sweet-alert.min.js"></script>
<script src="lib/alert/js/jquery.sweet-alert.init.js"></script>
<!-- file upload  -->
<script src="lib/bootstrap-file/js/fileupload.js"></script>
<!-- image popup -->
<script src="lib/magnific-popup/js/jquery.magnific-popup.js"></script>
<script src="lib/validate/js/jquery.validate.min.js"></script>
<!-- Custom -->
<script src="scripts/js/grocery.js"></script>
<script src="scripts/js/direct_payment_order.js"></script>
