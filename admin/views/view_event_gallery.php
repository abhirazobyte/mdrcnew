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
<link rel="stylesheet" href="lib/dropzone/dropzone.css" />
<?php include('includes/menu.php'); ?>
<div class="content ht-100v pd-0">
  <?php include('includes/header.php'); ?>
  <!-- sidebar -->
  <!-- df-section-nav -->
  <div class="content-body">
    <div class="container">
      <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb df-breadcrumbs mg-b-10">
              <li class="breadcrumb-item"><a href="javascript:void(0)">Event Gallery</a></li>
              <li class="breadcrumb-item active" aria-current="page">Images Upload</li>
            </ol>
          </nav>
          <h3 class="mg-b-0 tx-spacing--1">Images Upload - <span style="font-size:16px"><?= $this->event['name'] ?></span></h3>
        </div>
        <div class="">
          <a href="index.php?view=event_list" class="btn btn-sm pd-x-15 btn-warning btn-uppercase mg-l-5 " data-id=""><i data-feather="arrow-left" class="wd-10 mg-r-5" ></i> Back</a>
        </div>
      </div>
      <!--  <p class="mg-b-30">Sytem accept only order of below city.</p>-->
      <div data-label="Multi Images Upload" class="df-example demo-table">
        <div class="block">
          <form class="dropzone" id="my_awesome_dropzone" enctype="multipart/form-data">
            <input type="hidden" name="event_id" id="event_id" value="<?= $this->getGetVar("event_id") ?>" />
            <input type="hidden" name="folder" id="folder" value="<?= $this->folder;?>" />
          </form>
          <div class="form-bordered" style="clear:both;    margin-top: 20px;">
            <div class="form-group form-actions">
              <button type="button" id="newAlbum" class="btn btn-effect-ripple btn-primary">Upload Photos</button>
              <a href="index.php?view=event_gallery&event_id=<?= $this->getGetVar("event_id") ?>" class="btn btn-effect-ripple btn-danger">Reset</a>
            </div>
          </div>
        </div>
      </div>
      <!-- df-example -->
      <div data-label="Gallery Images" class="df-example demo-table">
        <div class="d-none d-md-block text-right pb-2">
          <button class="btn btn-sm pd-x-15 btn-danger btn-uppercase mg-l-5" onclick="mulitple_gallery_select();"><i data-feather="trash" class="wd-10 mg-r-5"></i> Delete</button>
        </div>
        <table id="table_event_gallery" class="table">
          <thead>
            <tr>
              <th class="">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input checkAll" id="customCheck0" name="select_multiple" value="Yes">
                  <label class="custom-control-label" for="customCheck0"></label>
                </div>
              </th>
              <th class="">ID.</th>
              <th class="">Image</th>
              <th class="">Status</th>
              <th class="">Action</th>
            </tr>
          </thead>
        </table>
      </div>
      <?php include('includes/footer.php'); ?>
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
<!-- image popup -->
<link href="lib/magnific-popup/css/magnific-popup.css" rel="stylesheet" type="text/css" />
<script src="lib/magnific-popup/js/jquery.magnific-popup.js"></script>
<script src="lib/validate/js/jquery.validate.min.js"></script>
<!-- Custom -->
<script src="scripts/js/grocery.js"></script>
<script src="scripts/js/event_gallery_images.js"></script>
<script src="lib/dropzone/dropzone.js"></script>
<script>
  Dropzone.autoDiscover = false;
  $(function() {
    var event_id = $("#event_id").val();
    var folder = $("#folder").val();
    var myDropzone = new Dropzone("#my_awesome_dropzone", {
      url: "scripts/ajax/index.php?method=event_gallery_upload&event_id=" + event_id + "&folder=" + folder + "",
      addRemoveLinks: true,
      acceptedFiles: ".jpeg,.jpg,.png,.gif",
      maxFiles: 30,
      uploadMultiple: true,
      parallelUploads: 100,
      createImageThumbnails: true,
      autoProcessQueue: false
    });
    $(document).on("click", "#newAlbum", function()
      {
        myDropzone.on("sending", function(file, xhr, formData) {
        });
        myDropzone.processQueue(); // Tell Dropzone to process all queued files.
        // alert('show this to have time to upload');
      });
  });
</script>
<!-- file upload  -->
<link href="lib/bootstrap-file/css/fileupload.css" rel="stylesheet" type="text/css" />
<!-- file upload  -->
<script src="lib/bootstrap-file/js/fileupload.js"></script>