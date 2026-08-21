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
<?php include('includes/menu.php');?>

<div class="content ht-100v pd-0">
  <?php include('includes/header.php');?>
  
  
  
  <div class="content-body">
    <div class="container">
      <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb df-breadcrumbs mg-b-10">
              <li class="breadcrumb-item"><a href="javascript:void(0)">Users & Wallet</a></li>
              <li class="breadcrumb-item active" aria-current="page">Abandoned Cart</li>
            </ol>
          </nav>
          <h3 class="mg-b-0 tx-spacing--1">Abandoned Cart</h3>
        </div>
      </div>
      <?=$this->utility->get_message()?>

       <div data-label="Search" class="df-example demo-table">
          <div class="form-row">
            <div class="form-group col-md-3">
              <label for="inputEmail4">Start Date </label>
              <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control required input-datepicker","placeholder"=>"DD-MM-YYYY","data-date-format"=>"dd-mm-yyyy"), "search_start_date") ;?>
            </div>
            <div class="form-group col-md-3">
              <label for="inputEmail4">End Date</label>
              <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control required input-datepicker","placeholder"=>"DD-MM-YYYY","data-date-format"=>"dd-mm-yyyy"), "search_end_date") ;?>
            </div>
            <div class="form-group col-md-3" >
              <label>City</label>
              <? $this->htmlBuilder->buildTag("select", array("class"=>"form-control","values"=>$this->records_city), "search_city_id") ?>
            </div>
            <div class="form-group col-md-3 mg-t-30">
              <button type="button" class="btn btn-success search_button" id="search_order">Search</button>
              <a  class="btn btn-danger" href="javascript:void(0)" onclick="reset_data()">Reset</a> </div>
          </div>
      </div>

      <div data-label="All Cart List" class="df-example demo-table">
        <table id="table_user_cart" class="table">
          <thead>
            <tr>
              <th class="wd-5p">ID.</th>
              <th class="wd-15p">Customer</th>
              <th class="wd-15p">Item Name</th>
              <th class="wd-15p">Amount</th>
              <th class="wd-15p">Added On</th>
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
<script src="lib/validate/js/jquery.validate.min.js"></script> 
<script src="lib/jqueryui/jquery-ui.min.js"></script> 

<!-- Custom --> 
<script src="scripts/js/grocery.js"></script> 
<script src="scripts/js/user_cart_list.js?v=1.4"></script> 

<script>
$('.input-datepicker, .input-daterange').datepicker({ 
	dateFormat: 'dd-mm-yy',
	})
</script> 