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
  

  <!-- df-section-nav -->
  
  <div class="content-body">
    <div class="container">
      <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb df-breadcrumbs mg-b-10">
              <li class="breadcrumb-item"><a href="javascript:void(0)">Manage For Doctors</a></li>
              <li class="breadcrumb-item active" aria-current="page"><?=$this->rs_data['title']?></li>
            </ol>
          </nav>
          <h3 class="mg-b-0 tx-spacing--1">For Doctors - <?=$this->rs_data['title']?></h3>
        </div>
        <div class="">
       
       
       <?php if($this->getGetVar('tab_type')=='All')
		  {?>
          <button class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5" onclick="mulitple_item_select1();"><i data-feather="check" class="wd-10 mg-r-5"></i> Select Data</button>
          <?php }else{?>
       
          <button class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5" onclick="mulitple_item_select();"><i data-feather="trash" class="wd-10 mg-r-5"></i> Remove Data</button>
          <?php }?>
          
          
        </div>
      </div>
<!--      <p class="mg-b-30">Sytem accept only order of below Manufacturer.</p>
-->     





<div class="df-example datatable-menu-tab">
          <ul class="nav justify-content-left">
          
          
          <?php
		  
		   $all='';
		   $Selected='';
		 
		 
		  
		  if($this->getGetVar('tab_type')=='All')
		  {
			
			
			  
			   $all='active';
			   $tab_type='All';
			  
		  }
		  else  if($this->getGetVar('tab_type')=='Selected')
		  {
			   $Selected='active';
			   $tab_type='Selected';
		  }
		  
		  
		  else
		  {
			  $all='active'; 
			  $tab_type='All';
			  
			  
			  
		 }
		  ?>
         
         
          
            <li class="nav-item" >
              <a class="nav-link   <?=$all?> "  href="index.php?view=item_data_for_doctors_services_list&service_id=<?=$this->rs_data['id']?>&tab_type=All" >All</a>
            </li>
            <li class="nav-item">
              <a class="nav-link   <?=$Selected?>" href="index.php?view=item_data_for_doctors_services_list&service_id=<?=$this->rs_data['id']?>&tab_type=Selected" >Selected Test</a>
            </li>
           
           
          </ul>
      </div>


 <div data-label="" class="df-example demo-table">
 <input type="hidden" name="service_id" id="service_id" value="<?=$this->rs_data['id']?>">
 <input type="hidden" name="tab_type" id="tab_type" value="<?=$tab_type?>">
 
        <table id="table_item" class="table">
          <thead>
            <tr>
              <th class="wd-5p"><div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input checkAll" id="customCheck0" name="select_multiple" value="Yes">
                  <label class="custom-control-label" for="customCheck0"></label>
                </div></th>
              <th class="wd-5p">ID.</th>
              <th class="wd-10p">Image</th>
              <th class="wd-15p">Name</th>
             
             
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
<script src="scripts/js/item_data_for_doctors_services.js"></script> 

<script src="lib/editor/ckeditor/ckeditor.js"></script> 
