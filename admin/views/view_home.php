<style>
@media (min-width: 1200px) {
  .media-body {
    width: 210px
  }
}

@media (min-width: 992px) {
  .media-body {
    width: 150px
  }
}

.custom-height-screen {
  overflow-y: auto;
  max-height: 1918px;
}

@media (max-width: 700px) {
  .custom-height-screen {
    overflow-y: auto;
    max-height: 600px;
  }
}
</style>
<!-- vendor css -->
<link href="lib/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
<link href="lib/ionicons/css/ionicons.min.css" rel="stylesheet">
<link href="lib/jqvmap/jqvmap.min.css" rel="stylesheet">
<link href="lib/morris.js/morris.css" rel="stylesheet">
<link href="lib/datatables.net-dt/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css" rel="stylesheet">
<!-- DashForge CSS -->
<link rel="stylesheet" href="assets/css/dashforge.css">
<link rel="stylesheet" href="assets/css/dashforge.dashboard.css">
<!-- Skin CSS -->
<link rel="stylesheet" href="assets/css/skin.cool.css">
<!--<link rel="stylesheet" href="assets/css/skin.charcoal.css">-->
<!-- Custom CSS -->
<link rel="stylesheet" href="assets/css/custom.css">
<!--Sweet Alert CSS & JS -->
<link href="lib/alert/css/sweet-alert.css" rel="stylesheet" type="text/css" />
<?php include('includes/menu.php');?>
  <div class="content ht-100v pd-0">
    <?php  include('includes/header.php'); ?>
      <!-- content-header -->
      <div class="content-body">
        <div class="container pd-x-0">
          <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
            <div>
              <h4 class="mg-b-0 tx-spacing--1">Welcome to Dashboard</h4> </div>
            <div class="d-none d-md-block"> <a style="display:none" href="index.php?view=email_data_list" class="btn btn-sm pd-x-15 btn-white btn-uppercase"><i data-feather="mail" class="wd-10 mg-r-5"></i> Email Settings</a> <a style="display:none" class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5" href="index.php?view=general_settings"><i data-feather="settings" class="wd-10 mg-r-5"></i> Generate Settigs</a> </div>
          </div>
          <?=$this->utility->get_message();?>
            
            
            
            
            
            
            <!-- row -->
        </div>
        <!-- container -->
      </div>
  </div>
  <div class="custom_ajax_preloader" id="custom_ajax_preloader" style="display: none;"> <span> <img src="assets/img/loader/ajax-loader.gif"> </span> </div>
  <!-- Ajax modal container-->
  <div class="ajax_modal_container" id="ajax_modal_container"> </div>
  <!-- content-footer -->
  </div>
  <script src="lib/jquery/jquery.min.js"></script>
  <script src="lib/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="lib/feather-icons/feather.min.js"></script>
  <script src="lib/perfect-scrollbar/perfect-scrollbar.min.js"></script>
  <script src="lib/jquery.flot/jquery.flot.js"></script>
  <script src="lib/jquery.flot/jquery.flot.stack.js"></script>
  <script src="lib/jquery.flot/jquery.flot.resize.js"></script>
  <script src="lib/chart.js/Chart.bundle.min.js"></script>
  <script src="lib/jqvmap/jquery.vmap.min.js"></script>
  <script src="lib/jqvmap/maps/jquery.vmap.usa.js"></script>
  <script src="lib/parsleyjs/parsley.min.js"></script>
  <script src="lib/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="lib/datatables.net-dt/js/dataTables.dataTables.min.js"></script>
  <script src="lib/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
  <script src="lib/datatables.net-responsive-dt/js/responsive.dataTables.min.js"></script>
  <script src="assets/js/dashforge.js"></script>
  <script src="assets/js/dashforge.aside.js"></script>
  <script src="assets/js/dashforge.sampledata.js"></script>
  <!-- other include -->
  <script src="lib/alert/js/sweet-alert.min.js"></script>
  <script src="lib/alert/js/jquery.sweet-alert.init.js"></script>
  <script src="lib/validate/js/jquery.validate.min.js"></script>
  <!-- Custom -->
  <script src="scripts/js/grocery.js"></script>
  <script src="scripts/js/admin.js"></script>
  <script>
  $(document).on("click", ".member_addedit_onclick", function() {
    getId = $(this).data("id");
    $('#custom_ajax_preloader').show();
    $.ajax({
      type: 'POST',
      url: 'scripts/modal/index.php?method=send_message_addedit&id=' + getId,
      dataType: 'html',
      data: $(this).serialize()
    }).done(function(data) {
      // show the response
      $('#ajax_modal_container').html(data);
      $('#modal_brand_addedit').modal('show');
      $('#custom_ajax_preloader').hide();
      $('#other_form').parsley();
      $.getScript("scripts/js/ajax.js");
    }).fail(function() {
      // just in case posting your form failed
      alert("Try again.");
      $('#custom_ajax_preloader').hide();
    });
  });
  $(document).on("click", ".brand_modal_submit", function() {
    $('#other_form').validate({
      rules: {
        brand: {
          required: true,
          minlength: 5,
          maxlength: 5
        },
      },
      submitHandler: function(form) {
        $('.brand_modal_submit').html('<span class="spinner-border spinner-border-sm mg-r-5" role="status" aria-hidden="true"></span> Loading...');
        $(".brand_modal_submit").attr("disabled", true);
        form.submit();
        return false;
      }
    });
  });
  </script>
  <script src="lib/raphael/raphael.min.js"></script>
  <script src="lib/morris.js/morris.min.js"></script>
  <script src="lib/jqueryui/jquery-ui.min.js"></script>