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
<style>
.green {
	color:green !important;
	font-weight:600;
}
.red {
	color:red !important;
	font-weight:600;
}
.ui-widget-content {
	z-index:99999 !important;
}
</style>
<?php include('includes/menu.php');?>

<div class="content ht-100v pd-0">
  <?php include('includes/header.php');?>
  <div class="content-body">
    <div class="container">
      <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb df-breadcrumbs mg-b-10">
              <li class="breadcrumb-item"><a href="javascript:void(0)">Customers</a></li>
              <li class="breadcrumb-item active" aria-current="page">Added Money</li>
            </ol>
          </nav>
          <h3 class="mg-b-0 tx-spacing--1">Added Money</h3>
        </div>
        <input type="hidden" id="customer_id1" value="<?=$this->getGetVar('customer_id')?>">
        <input type="hidden" id="reward_type" value="<?=$this->getGetVar('reward_type')?>">
        <div class="d-none d-md-block">
          <?php if($this->getGetVar('customer_id')==''){?>
          <button class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5 add_money_addedit_onclick" data-id=""><i data-feather="plus" class="wd-10 mg-r-5" ></i> Add Money</button>
          <?php }?>
        </div>
      </div>
      <?php if($this->getGetVar('customer_id')==''){?>
       <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="row  row-xs">
        
        <div class="col-sm-6 col-lg-4 mg-t-10 mg-sm-t-0">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total Credit</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
               <?php
              $wallet_total=$this->Total_Credit;
			  $wallet_total=$this->utility->numerdisplayformate($wallet_total);
			  ?>
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1 green"><i class="fa fa-rupee-sign"></i> <?=$wallet_total?></h3>
              </div>
              <!-- chart-three -->
            </div>
          </div><!-- col -->
          
         <div class="col-sm-6 col-lg-4 mg-t-10 mg-sm-t-0">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total Debit</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <?php
			$Total_data=$this->Total_Debit;
			$Total_data=$this->utility->numerdisplayformate($Total_data);
			?>
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1 red"><i class="fa fa-rupee-sign"></i> <?=$Total_data?></h3>
              </div>
              <!-- chart-three -->
            </div>
          </div><!-- col -->
</div>
        </div>
   
      <?php }?>
      <div data-label="Search" class="df-example demo-table">
        <? $this->htmlBuilder->buildTag("form", array("action"=>"","method"=>"post","autocomplete"=>"off","class"=>"form-validate","data-parsley-validate"=>""), "frm_search");?>
        <? $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>"search"), "act") ?>
        <div class="form-row">
          <div class="form-group col-md-3">
            <label for="inputEmail4">Type</label>
            <? $this->htmlBuilder->buildTag("select", array("class"=>"form-control select2","selected"=>$_SESSION['search_type'], "values"=>array(""=>"All","App"=>"App","Web"=>"Web","Admin"=>"Admin")), "search_type") ;?>
          </div>
          <div class="form-group col-md-3">
            <label for="inputEmail4">Start Date </label>
            <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control required input-datepicker","placeholder"=>"DD-MM-YYYY","data-date-format"=>"dd-mm-yyyy","value"=>$_SESSION['search_start_date']), "search_start_date") ;?>
          </div>
          <div class="form-group col-md-3">
            <label for="inputEmail4">End Date</label>
            <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control required input-datepicker","placeholder"=>"DD-MM-YYYY","data-date-format"=>"dd-mm-yyyy","value"=>$_SESSION['search_end_date']), "search_end_date") ;?>
          </div>
          <div class="form-group col-md-3 mg-t-30">
            <button type="button" class="btn btn-success search_button" id="search_order">Search</button>
            <a  class="btn btn-danger" href="javascript:void(0)" onclick="reset_data()">Reset</a> </div>
        </div>
        <?=$this->htmlBuilder->closeForm()?>
      </div>
      
      <!--<p class="mg-b-30">Sytem accept only order of below Added Money.</p>-->
      <div data-label="" class="df-example demo-table">
        <table id="table_add_money" class="table">
          <thead>
            <tr>
              <th class="wd-5p">ID.</th>
              <th class="wd-15p">Customer</th>
              <th class="wd-10p">Amount</th>
              <th class="wd-10p">Remark</th>
              <th class="wd-10p">Pay With</th>
               <th class="wd-10p">Status</th>
              <th class="wd-15p">Date</th>
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
<script src="scripts/js/add_money.js?v=1.1"></script>
<link rel="stylesheet" href="lib/selectdropdown/jquery-ui.min.css">


<script>
$('.input-datepicker, .input-daterange').datepicker({ 
	dateFormat: 'dd-mm-yy',
	})


</script> 
