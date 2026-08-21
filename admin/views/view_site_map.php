<link href="lib/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
<link href="lib/ionicons/css/ionicons.min.css" rel="stylesheet">
<link href="lib/typicons.font/typicons.css" rel="stylesheet">
<link href="lib/prismjs/themes/prism-vs.css" rel="stylesheet">
<link rel="stylesheet" href="assets/css/dashforge.auth.css">
<link href="lib/select2/css/select2.min.css" rel="stylesheet">
<!-- DashForge CSS -->
<link rel="stylesheet" href="assets/css/dashforge.css">
<link rel="stylesheet" href="assets/css/dashforge.demo.css">
<!-- Skin CSS -->
<link rel="stylesheet" href="assets/css/skin.cool.css">
<!--<link rel="stylesheet" href="assets/css/skin.charcoal.css">-->
<!--Sweet Alert CSS & JS -->
<link href="lib/alert/css/sweet-alert.css" rel="stylesheet" type="text/css" />
<!-- file upload  -->
<link href="lib/bootstrap-file/css/fileupload.css" rel="stylesheet" type="text/css" />
<!--image popup -->
<link href="lib/magnific-popup/css/magnific-popup.css" rel="stylesheet" type="text/css" />
<!-- new added by developer -->
<link rel="stylesheet" href="assets/css/custom.css">
<style>
  .scrollbox {
    overflow-y: scroll;
    max-height: 220px;
    border: 1px solid #dae0e8;
  }

  .even {
    margin-left: 20px;
  }

  .price_varient {
    padding: 0;
    margin: 0;
  }
</style>
<?php include('includes/menu.php'); ?>
<div class="content ht-100v pd-0">
  <?php include('includes/header.php'); ?>
  <div class="content-body">
    <div class="container pd-x-0">
      <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
          <h4 class="mg-b-0 tx-spacing--1">Site Map</h4>
        </div>
      </div>
      <?= $this->utility->get_message() ?>
      <? $this->htmlBuilder->buildTag("form", array("action" => "", "data-parsley-validate" => "", "class" => "form-horizontal form-bordered form-validate"), "frm_site_map"); ?>
      <? $this->htmlBuilder->buildTag("input", array("type" => "hidden", "value" => "update_data"), "act"); ?>
      <div class="row">
        <div class="col-lg-12">
          <div data-label="" class="df-example demo-forms">
            <div class="row">
              <div class="col-lg-12">
                <div class="form-group">
                  <label class="" for="example-email">Select File</label>
                  <? $this->htmlBuilder->buildTag("input", array("type" => "file", "class" => "form-control"), "file_1") ?>
                </div>
                <span><b>Note : </b>This file will be uploaded in sitemap folder.</span>
              </div>
            </div>
          </div>
          <div data-label="" class="df-example demo-forms">
            <div class="row">
              <div class="col-lg-12">
                <div class="form-group">
                  <label class="" for="example-email">Select File</label>
                  <? $this->htmlBuilder->buildTag("input", array("type" => "file", "class" => "form-control"), "file_2") ?>
                </div>
                <span><b>Note : </b>This file will be uploaded in Root directory.</span>
              </div>
            </div>
        </div>
      </div>
      <div class="row mg-t-15">
        <div class="col-lg-12">
          <button class="btn btn-primary" type="submit">Submit</button>
          <button class="btn btn-secondary" type="reset">Cancel</button>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>
<script src="lib/jquery/jquery.min.js"></script>
<script src="lib/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="lib/feather-icons/feather.min.js"></script>
<script src="lib/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="lib/prismjs/prism.js"></script>
<script src="lib/parsleyjs/parsley.min.js"></script>
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
<script src="scripts/js/subziwalla.js"></script>
<link href='lib/selectdropdown/jquery-ui.min.css' rel='stylesheet' type='text/css'>
<script src='lib/selectdropdown/jquery-ui.min.js' type='text/javascript'></script>