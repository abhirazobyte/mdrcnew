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
  <!-- content-header -->
  <div class="content-body">
    <div class="container pd-x-0">
      <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
              <li class="breadcrumb-item"><a href="#">Page</a></li>
              <li class="breadcrumb-item active" aria-current="page">
                <?= $this->to_do ?>
              </li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1">
            <?= $this->to_do ?>
            <?= $this->manage_for ?>
          </h4>
        </div>
        <div class="d-none d-md-block"> </div>
      </div>
      <?= $this->utility->get_message() ?>
      <? $this->htmlBuilder->buildTag("form", array("action" => "", "data-parsley-validate" => "", "class" => "form-horizontal form-bordered form-validate"), "frm_doctor_addedit"); ?>
      <? $this->htmlBuilder->buildTag("input", array("type" => "hidden", "value" => $this->id), "id"); ?>
      <? $this->htmlBuilder->buildTag("input", array("type" => "hidden", "value" => $this->getGetVar('pg_no')), "pg_no"); ?>
      <? $this->htmlBuilder->buildTag("input", array("type" => "hidden", "value" => "update_data"), "act"); ?>
      <? $this->htmlBuilder->buildTag("input", array("type" => "hidden", "value" => $this->rsdoctor['master_type']), "last_master_type"); ?>
      <? $this->htmlBuilder->buildTag("input", array("type" => "hidden", "value" => $this->folder), "folder"); ?>
      <input type="hidden" name="doctor_option" value="multiple">
      <div class="row">
        <div class="col-lg-8">
          <div data-label="doctor Basic Information" class="df-example demo-forms">
            <div class="form-group">
              <label class="d-block">Name <span class="tx-danger">*</span></label>
              <? $this->htmlBuilder->buildTag("input", array("type" => "text", "class" => "form-control ", "required" => "", "value" => $this->rsdoctor['name']), "name1") ?>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <div class="form-group">
                  <label class="d-block">Designation </label>
                  <? $this->htmlBuilder->buildTag("input", array("type" => "text", "class" => "form-control"), "designation") ?>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="d-block">Description</label>
              <? $this->htmlBuilder->buildTag("textarea", array("type" => "text", "class" => "form-control ckeditor", "style" => "height:150px"), "about_info") ?>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <?php 
          $file_class = "fileupload-new";
          if ($this->getGetVar('id')) {
            if ($this->rscat['image'] != '' &&  file_exists(ABS_PATH . "/" . $this->get_user_config("doctor") . '/' . $this->folder . '/' . $this->rscat['image'])) {
              $img = '../uploads/doctor/' . $this->folder . '/' . $this->rscat['image'];
              $file_class = "fileupload-exists";
            } else {
              $img = 'images/img_upl.gif';
            }
          } else {
            $img = 'images/img_upl.gif';
          } ?>
          <div data-label="doctor Image" class="df-example demo-forms">
            <label class="d-block">Image</label>
            <div class="fileupload <?= $file_class; ?>" data-provides="fileupload">
              <div class="fileupload-new"> <img src="images/img_upl.gif" class="up_img"> </div>
              <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 150px; line-height: 20px;"> <img src="<?= $img; ?>" class="up_img"/> </div>
              <div>
                <span class="btn btn-file btn-default">
                  <span class="fileupload-new btn btn-white btn-xs">Select image</span>
                  <span class="fileupload-exists btn btn-white btn-xs">Change</span>
                  <? $this->htmlBuilder->buildTag("input", array("type" => "file", "class" => ""), "image") ?>
                </span>
                <a href="#" class="btn btn-xs fileupload-exists btn-white" data-dismiss="fileupload">Remove</a>
              </div>
            </div>
          </div>
          <div data-label="Category" class="df-example demo-forms">
            <div class="row">
              <div class="col-lg-12">
                <div class="form-group">
                  <label class="d-block">Category </label>
                  <? $this->htmlBuilder->buildTag("select", array("class" => "form-control select2", "values" => $this->records1), "category_id") ?>
                </div>
              </div>
            </div>
          </div>
          <div data-label="doctor Other Data" class="df-example demo-forms">
            <div class="row">
              <div class="col-lg-12">
                <div class="form-group">
                  <label class="d-block">Sort Order</label>
                  <? $this->htmlBuilder->buildTag("select", array("class" => "form-control", "values" => $this->utility->sort_order('doctor')), "sort_order") ?>
                </div>
              </div>
              <div class="col-lg-12">
                <div class="form-group">
                  <label class="d-block">Display About Page?</label>
                  <? $this->htmlBuilder->buildTag("select", array("class" => "form-control", "values" => array("Inactive" => "No", "Active" => "Yes")), "display_about") ?>
                </div>
              </div>
              <div class="col-lg-12">
                <div class="form-group">
                  <label class="d-block">Status</label>
                  <? $this->htmlBuilder->buildTag("select", array("class" => "form-control", "values" => array("Active" => "Active", "Inactive" => "Inactive")), "status") ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row mg-t-15">
        <div class="col-lg-12">
          <input type="hidden" name="save_btn" id="save_btn" value="Save">
          <button class="btn btn-primary" id="doctor_btn" onclick="update_type('Save')" type="submit">Save</button>
          <a class="btn btn-secondary" href="index.php?view=doctor_list">Cancel</a>
        </div>
      </div>
      </form>
      <?php include('includes/footer.php'); ?>
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
<script src="lib/select2/js/select2.min.js"></script>
<script>
  // Adding placeholder for search input
  (function($) {
    'use strict'
    var Defaults = $.fn.select2.amd.require('select2/defaults');
    $.extend(Defaults.defaults, {
      searchInputPlaceholder: ''
    });
    var SearchDropdown = $.fn.select2.amd.require('select2/dropdown/search');
    var _renderSearchDropdown = SearchDropdown.prototype.render;
    SearchDropdown.prototype.render = function(decorated) {
      // invoke parent method
      var $rendered = _renderSearchDropdown.apply(this, Array.prototype.slice.apply(arguments));
      this.$search.attr('placeholder', this.options.get('searchInputPlaceholder'));
      return $rendered;
    };
  })(window.jQuery);
  $(function() {
    'use strict'
    // Basic with search
    $('.select2').select2({
      placeholder: 'Choose one',
      searchInputPlaceholder: 'Search options'
    });
  });
</script>
<script src="lib/typeahead.js/typeahead.bundle.min.js"></script>
<script src="lib/handlebars/handlebars.min.js"></script>
<script src="assets/js/dashforge.aside.js"></script>
<script src="assets/js/dashforge.js"></script>
<!-- other include -->
<script src="lib/alert/js/sweet-alert.min.js"></script>
<script src="lib/alert/js/jquery.sweet-alert.init.js"></script>
<script>
  function update_type(a) {
    $("#save_btn").val(a);
  }

  function change_dtypes(a) {
    if (a == 'in_pkt') {
      $(".dtype").html('Pkt');
    } else if (a == 'in_pcs') {
      $(".dtype").html('Pcs');
    } else if (a == 'in_ltr') {
      $(".dtype").html('Ml');
    } else if (a == 'in_gm') {
      $(".dtype").html('Gram');
    } else {
      $(".dtype").html('Pkt');
    }
  }

  function show_suggestion(s) {
    var value = s.toLowerCase();
    $(".scrollbox .even").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  }
</script>
<!-- file upload  -->
<script src="lib/bootstrap-file/js/fileupload.js"></script>
<!-- image popup -->
<script src="lib/magnific-popup/js/jquery.magnific-popup.js"></script>
<script src="lib/validate/js/jquery.validate.min.js"></script>
<!-- Custom -->
<script src="scripts/js/grocery.js"></script>
<!-- ckeditor -->
<script src="lib/editor/ckeditor/ckeditor.js"></script>