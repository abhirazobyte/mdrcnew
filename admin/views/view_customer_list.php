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
              <li class="breadcrumb-item"><a href="javascript:void(0)">Customers</a></li>
              
              <li class="breadcrumb-item active" aria-current="page">Customer List</li>
            </ol>
          </nav>
          <h3 class="mg-b-0 tx-spacing--1">Customer List</h3>
        </div>
        <div class="d-none d-md-block">
          <button class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5 customer_addedit_onclick" data-id=""><i data-feather="plus" class="wd-10 mg-r-5" ></i> Add New</button>
           
          
            </div>
      </div>
      <!--<p class="mg-b-30">Sytem accept only order of below Zones.</p>-->
      
      <div data-label="Search" class="df-example demo-table search_box">
      
          <? $this->htmlBuilder->buildTag("form", array("action"=>"","method"=>"post","autocomplete"=>"off","class"=>"form-validate","data-parsley-validate"=>""), "frm_search");?>
          <? $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>"search"), "act") ?>
          
            <div class="form-row">
            
            
            <div class="form-group col-md-4">
                <label for="inputEmail4">Start Date </label>
                <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control required input-datepicker","placeholder"=>"DD-MM-YYYY","data-date-format"=>"dd-mm-yyyy","value"=>$_SESSION['search_start_date']), "search_start_date") ;?>
              </div>
              <div class="form-group col-md-4">
                <label for="inputEmail4">End Date</label>
                <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control required input-datepicker","placeholder"=>"DD-MM-YYYY","data-date-format"=>"dd-mm-yyyy","value"=>$_SESSION['search_end_date']), "search_end_date") ;?>
              </div>

              <div class="form-group col-md-3 mg-t-30">
                <button type="button" class="btn btn-success search_button" id="search_order">Search</button>
                <a  class="btn btn-danger" href="javascript:void(0)" onclick="reset_data()">Reset</a> 
              </div>
            </div>
          <?=$this->htmlBuilder->closeForm()?>
        </div>
        
       <?php if($_SESSION['search_status']=='Active')
	  {
	  	$Active='active';
	  }
	  else if($_SESSION['search_status']=='Inactive')
	  {
	  		$Inactive='active';
	  }
	   else
	  {
	  		$All='active';
	  }
	  ?>
        
        
      <div class="df-example datatable-menu-tab">
        <ul class="nav justify-content-left">
          <li class="nav-item"> <a class="nav-link navtab All <?=$All?>" onclick="show_status_data('All')" href="javascript:void(0)">All(<span id="All_count"></span>)</a> </li>
          <li class="nav-item"> <a class="nav-link navtab Active <?=$Active?>" onclick="show_status_data('Active')" href="javascript:void(0)">Active(<span id="Active_count"></span>)</a> </li>
          <li class="nav-item"> <a class="nav-link navtab Inactive <?=$Inactive?>" onclick="show_status_data('Inactive')" href="javascript:void(0)">Inactive(<span id="Inactive_count"></span>)</a> </li>
        </ul>
      </div>
      <div data-label="" class="df-example demo-table">
        <table id="table_customer" class="table">
          <thead>
            <tr>

              <th class="wd-5p">ID.</th>
              <th class="wd-15p">Name</th>
              <th class="wd-15p">Phone & Email</th>
              <th class="wd-10p">wallet</th>
               
              <th class="wd-10p">Date</th>
              <th class="wd-10p">OTP Verified</th>
              <th class="wd-5p">Status</th>
              <th class="wd-15p">Action</th>
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
<script src="lib/jqueryui/jquery-ui.min.js"></script> 
<!-- Custom -->
<link rel="stylesheet" href="lib/selectdropdown/jquery-ui.min.css">

<!-- Custom --> 
<script src="scripts/js/grocery.js"></script> 
<script src="scripts/js/customer.js"></script>
<link href='lib/selectdropdown/jquery-ui.min.css' rel='stylesheet' type='text/css'>
<script src='lib/selectdropdown/jquery-ui.min.js' type='text/javascript'></script> 


<script>
$('.input-datepicker, .input-daterange').datepicker({ 
	dateFormat: 'dd-mm-yy',
	})
	</script>