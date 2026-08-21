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
<!--image popup -->
<link href="lib/magnific-popup/css/magnific-popup.css" rel="stylesheet" type="text/css" />
<!-- Skin CSS -->
<link rel="stylesheet" href="assets/css/skin.cool.css">
<!--<link rel="stylesheet" href="assets/css/skin.charcoal.css">-->
<!-- Custom CSS -->
<link rel="stylesheet" href="assets/css/custom.css">
<style>
table td, table th {
  text-align:center;
}
.btn-toolbar {
  display: inline-flex;
}
.d_data {
  border: 1px dotted grey;
  padding: 5px;
}
.cd {
  cursor:pointer;
}
.collect_class {
  color:red;
}
.refund_class {
  color:green;
}
</style>
<!--Sweet Alert CSS & JS -->
<link href="lib/alert/css/sweet-alert.css" rel="stylesheet" type="text/css" />
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
              <li class="breadcrumb-item"><a href="javascript:void(0)">Orders</a></li>
              <li class="breadcrumb-item active" aria-current="page"><a href="javascript:void(0)">All Orders</a></li>
            </ol>
          </nav>
          <h3 class="mg-b-0 tx-spacing--1">Order</h3>
        </div>
        <div class="d-md-block">
          <a href="index.php?view=order_list&act=export_data&order_status=<?=$this->getGetVar('order_status')?>" class="btn btn-sm pd-x-15 btn-success btn-uppercase mg-l-5"><i data-feather="download" class="wd-10 mg-r-5" ></i> Export Data </a>
        </div>
      </div>
      <!-- <p class="mg-b-30">Sytem accept only order of below order.</p>-->
      <?=$this->utility->get_message();?>
      <div data-label="Search" class="df-example demo-table">
        <!-- General Elements Title -->
        <!-- END General Elements Title -->
        <!-- General Elements Content -->
        <? $this->htmlBuilder->buildTag("form", array("action"=>"","method"=>"post","autocomplete"=>"off","class"=>"form-validate","data-parsley-validate"=>""), "frm_search");?>
        <div class="row">
          <div class="form-group col-md-3 start_dates" >
            <label>Order Start Date</label>
            <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control order_date input-datepicker","placeholder"=>"Order Start Date ","data-date-format"=>"mm/dd/yyyy","value"=>$_SESSION['search_start_order_date']), "start_date") ?>
          </div>
          <div class="form-group col-md-3 start_dates" >
            <label>Order End Date</label>
            <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control order_date input-datepicker","placeholder"=>"Order End Date ","data-date-format"=>"mm/dd/yyyy","value"=>$_SESSION['search_end_order_date']), "end_date") ?>
          </div>
          <div class="form-group col-md-3" >
            <label>City</label>
            <? $this->htmlBuilder->buildTag("select", array("class"=>"form-control","values"=>$this->records_city,"selected"=>$_SESSION['search_city']), "city_id") ?>
          </div>
          <div class="form-group col-md-3" >
            <label>Test or Package</label>
            <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control","placeholder"=>"Test or Package Name","value"=>$_SESSION['search_test']), "test_name") ?>
          </div>
          <div class="form-group col-md-3" >
            <label>Order Status</label>
            <? $this->htmlBuilder->buildTag("select", array("class"=>"form-control","values"=>$this->records_status,"selected"=>$_SESSION['search_order_status']), "order_status") ?>
          </div>
          <div class="form-group col-md-3" >
            <label>Customer Phone</label>
            <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control number","placeholder"=>"Phone","value"=>$_SESSION['search_cust_phone']), "customer_phone") ?>
          </div>
          <div class="form-group col-md-3" >
            <label>Customer Name</label>
            <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control","placeholder"=>"Name","value"=>$_SESSION['search_cust_name']), "customer_name") ?>
          </div>
          <div class="form-group col-md-3" >
            <label>Customer Email</label>
            <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control","placeholder"=>"Email","value"=>$_SESSION['search_cust_email']), "customer_email") ?>
          </div>
          <div class="col-md-3" >
            <input type="hidden" name="method" value="set_order_session_data"/>
            <button type="button" class="btn btn-success search_button" onclick="search_data()">Search</button>
            <button type="button" class="btn btn-danger"  onclick="reset_data()">Reset</button>
          </div>
        </div>
        <?=$this->htmlBuilder->closeForm()?>
        <!-- END General Elements Content -->
      </div>
      <div class="df-example datatable-menu-tab">
        <ul class="nav justify-content-left">
          <?php
       $all='';
       $paid='';
       $Canceled='';
       $Completed='';
      if($this->getGetVar('order_status')=='')
      {
          $all='active';
      }
      else  if($this->getGetVar('order_status')=='Pending')
      {
         $Pending='active';
      }
      else  if($this->getGetVar('order_status')=='Confirmed')
      {
         $Confirmed='active';
      }
      else  if($this->getGetVar('order_status')=='Canceled')
      {
        $Canceled='active';
      }
      else  if($this->getGetVar('order_status')=='Completed')
      {
        $Completed='active';
      }
      else
      {
        $all='active';
     }
      ?>
          <input type="hidden" name="current_status" id="current_status" value="<?=$this->getGetVar('order_status')?>">
          <li class="nav-item" > <a class="nav-link <?=$all?>"  href="index.php?view=order_list&order_status=">All (<?=$this->AllCount?>)</a> </li>
          <li class="nav-item"> <a class="nav-link <?=$Pending?>" href="index.php?view=order_list&order_status=Pending">Pending (<?=$this->PendingCount?>)</a> </li>
          <li class="nav-item"> <a class="nav-link <?=$Confirmed?>" href="index.php?view=order_list&order_status=Confirmed">Confirmed (<?=$this->ConfirmedCount?>)</a> </li>
          <li class="nav-item"> <a class="nav-link <?=$Completed?>" href="index.php?view=order_list&order_status=Completed">Completed (<?=$this->CompletedCount?>)</a> </li>
          <li class="nav-item"> <a class="nav-link <?=$Canceled?>" href="index.php?view=order_list&order_status=Canceled">Canceled (<?=$this->CanceledCount?>)</a> </li>
        </ul>
      </div>
      <div data-label="" class="df-example demo-table">
      <div class="table-responsive">
        <table id="table_order" class="table">
          <thead>
            <tr>
              <th class="wd-10p">ID</th>
              <th class="">Order Date</th>
              <th class="">Customer</th>
              <th class="">City</th>
              <th class="">Total</th>
              <th class="">Status</th>
              <th class="">Action</th>
            </tr>
          </thead>
        </table>
        </div>
      </div>
      <!-- df-example -->
       <span style="font-style: italic;font-size: 12px;"><strong>Note:</strong> To change Order Status, Please click on Current Status Badge.</span>
      <?php include('includes/footer.php');?>
      <!-- content-footer -->
    </div>
    <!-- container -->
  </div>
</div>


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
<!-- Custom -->
<script src="scripts/js/grocery.js"></script>
<script src="scripts/js/order.js"></script>
<!-- image popup -->
<script src="lib/magnific-popup/js/jquery.magnific-popup.js"></script>
<script src="lib/jqueryui/jquery-ui.min.js"></script>
<script>
function printDiv()
{
  var divToPrint=document.getElementById('DivIdToPrint');
  var newWin=window.open('','Print-Window');
  newWin.document.open();
  newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
  newWin.document.close();
  setTimeout(function(){newWin.close();},10);
}
function change_delivery_date(id,o_del_date,customer_name)
{
  $('#voucher_name_d').html('#'+id);
  $('#d_order_id').val(id);
  $('#o_del_date').html(o_del_date);
  //$('#del_notes').val('Dear '+customer_name+', your delivery reschedule to '+o_del_date+'');
  $('#del_notes').val('<?=$this->delivery_sms_text?>');
}
function change_delivery_type_order(id,curren_delivery_name)
{
  $('#change_delivery_display_order_id').html('#'+id);
  $('#change_delivery_order_id').val(id);
  $('#change_delivery_name').html(curren_delivery_name);
  if(curren_delivery_name=='Fedex')
  {
    $('#fedex_note').html('Note : Please cancel Fedex shipment if created before change order delivery.');
  }
  else
  {
    $('#fedex_note').html('Note : if you assign fedex, then press create shipment buttton after update delivery.');
  }
}
function send_otp_exchange(cust_order_id)
{
     if(cust_order_id!='')
     {
      $.ajax
      ({
          type: "POST",
          dataType: 'json',
          url: "../scripts/ajax/index.php",
          data: "method=get_otp_exchange_msg&cust_order_id="+cust_order_id,
          success: function(data)
          {
            $("#otp_msg").html(data.msg);
            $("#cust_order_id").val(cust_order_id);
          }
      });
     }
     else
     {
      alert('Oops something gone wrong.');
      return false;
     }
}
</script>
<script>
      $(function(){
        'use strict'
    $('.input-datepicker').datepicker();
        var dateFormat = 'mm/dd/yy',
        from = $('#dateFrom')
        .datepicker({
          defaultDate: '+1w',
          numberOfMonths: 2
        })
        .on('change', function() {
          to.datepicker('option','minDate', getDate( this ) );
        }),
        to = $('#dateTo').datepicker({
          defaultDate: '+1w',
          numberOfMonths: 2
        })
        .on('change', function() {
          from.datepicker('option','maxDate', getDate( this ) );
        });
        function getDate( element ) {
          var date;
          try {
            date = $.datepicker.parseDate( dateFormat, element.value );
          } catch( error ) {
            date = null;
          }
          return date;
        }
      });
    </script>
<script>
  function export_data()
  {
    var order_date=$('.order_date').val();
    var city_id=$('#city_id').val();
    var order_status="<?=$this->getGetVar("order_status")?>";
    window.location.href = 'index.php?view=order_list&act=export_data&order_date='+order_date+'&city_id='+city_id+'&order_status='+order_status;
    return false;
  }
  function search_data()
  {   
    $.ajax
      ({
          type: "POST",
          dataType: 'json',
          url: "scripts/ajax/index.php",
         // data: "method=set_order_session_data&order_date="+order_date+"&city_id="+city_id,
          data: $('#frm_search').serialize(),
          success: function(data)
          {
            var oTable = $('#table_order').dataTable( );
            oTable.api().ajax.reload();
          }
      });
  }
  function reset_data()
  {
    $('#frm_search')[0].reset();
    $.ajax
    ({
        type: "POST",
        dataType: 'json',
        url: "scripts/ajax/index.php",
        //data: "method=set_order_session_data&order_date="+order_date+"&city_id="+city_id,
        data: $('#frm_search').serialize()+ "&reset=clear",
        success: function(data)
        {
          //var oTable = $('#table_order').dataTable( );
          //oTable.api().ajax.reload();
          location.reload(true);
        }
    });
  }
  function show_data(id)
  {
    if($(".class_"+id).hasClass("fa-arrow-right"))
    {
      $(".class_"+id).removeClass("fa-arrow-right");
      $(".class_"+id).addClass("fa-arrow-down");
      $("#class_"+id).show();
    }
    else
    {
      $(".class_"+id).addClass("fa-arrow-right");
      $(".class_"+id).removeClass("fa-arrow-down");
      $("#class_"+id).hide();
    }
  }
</script>
