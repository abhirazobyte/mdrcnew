<?php
$id = $app->getGetVar('id');
$for_doctors_id = $app->getGetVar('for_doctors_id');
if ($id != '') {
  //Edit for_doctors_services
  $obj_brand = $app->load_model("for_doctors_services");
  $result = $obj_brand->execute("SELECT", false, "", "id='" . $id . "'");
  $id = $result[0]['id'];
  $title = $result[0]['title'];
  $description = $result[0]['description'];
  $short_desc = $result[0]['short_desc'];
  $button_name = $result[0]['button_name'];
  $button_link = $result[0]['button_link'];
  $status = $result[0]['status'];
  $sort_order = $result[0]['sort_order'];
  $for_doctors_id = $result[0]['for_doctors_id'];
  $decsription = $result[0]['decsription'];

  $meta_title = $result[0]['meta_title'];
  $meta_keywords = $result[0]['meta_keywords'];
  $meta_description = $result[0]['meta_description'];

  //image   

  $folder = 'for_doctors_services';
  $img_name = $result[0]["image"];
  $log_img = $app->utility->get_image_path($img_name, $folder, 'thumb');
} else {
  $log_img = 'images/img_upl.gif';
}

?>
<div class="modal fade" id="modal_for_doctors_services_addedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">For Doctors Form</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <form method="post" name="for_doctors_services_form" id="for_doctors_services_form" data-parsley-validate>
        <? $app->htmlBuilder->buildTag("input", array("type" => "hidden", "class" => "form-control", "value" => $for_doctors_id), "for_doctors_id") ?>
        <? $app->htmlBuilder->buildTag("input", array("type" => "hidden", "class" => "form-control", "value" => $id), "id") ?>
        <div class="modal-body">
          <div class="form-row">

            <div class="form-group col-md-12">
              <label for="inputEmail4">Title <span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type" => "text", "class" => "form-control", "value" => $title, "required" => ""), "title") ?>
            </div>


            <div class="form-group col-md-6">
              <label for="inputEmail4">Button Name</label>
              <? $app->htmlBuilder->buildTag("input", array("type" => "text", "class" => "form-control", "value" => $button_name), "button_name") ?>
            </div>

            <div class="form-group col-md-6">
              <label for="inputEmail4">Button Link </label>
              <? $app->htmlBuilder->buildTag("input", array("type" => "text", "class" => "form-control", "value" => $button_link), "button_link") ?>
            </div>


            <div class="form-group col-md-6">
              <label for="inputEmail4">Short Description</label>
              <? $app->htmlBuilder->buildTag("textarea", array("type" => "text", "class" => "form-control", "value" => $short_desc, "style" => "height: 120px;"), "short_desc") ?>
            </div>

            <div class="form-group col-md-6">
              <label for="inputEmail4">Image</label>
              <div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="fileupload-new"> <img src="<?= $log_img; ?>" class="up_img"> </div>
                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                <div> <span class="btn btn-file btn-default"> <span class="mg-t-5 fileupload-new btn btn-white btn-xs">Select image</span><span class="fileupload-exists btn btn-white btn-xs">Change</span>
                    <? $app->htmlBuilder->buildTag("input", array("type" => "file", "class" => ""), "image1") ?>
                  </span> <a href="#" class="btn btn-xs fileupload-exists btn-white" data-dismiss="fileupload">Remove</a> </div>
              </div>
            </div>

            <div class="form-group col-md-12">
              <label for="inputEmail4">Description</label>
              <? $app->htmlBuilder->buildTag("textarea", array("type" => "text", "class" => "form-control ckeditor", "value" => $decsription, "style" => "height: 140px;"), "decsription") ?>
            </div>


            <div class="form-group col-md-6">
              <label for="inputEmail4">Sort Orde</label>
              <? $app->htmlBuilder->buildTag("select", array("class" => "form-control ", "selected" => $sort_order, "values" => $app->utility->sort_order('for_doctors_services'), "required" => ""), "sort_order"); ?>
            </div>
            <div class="form-group col-md-6">
              <label for="inputEmail4">Status</label>
              <? $app->htmlBuilder->buildTag("select", array("class" => "form-control", "selected" => $status, "values" => array("Active" => "Active", "Inactive" => "Inactive"), "required" => ""), "status"); ?>
            </div>

            <div class="form-group col-md-12">
              <label for="inputEmail4">Meta Title</label>
              <? $app->htmlBuilder->buildTag("input", array("type" => "text", "class" => "form-control", "value" => $meta_title), "meta_title") ?>
            </div>

            <div class="form-group col-md-12">
              <label for="inputEmail4">Meta Keywords</label>
              <? $app->htmlBuilder->buildTag("input", array("type" => "text", "class" => "form-control", "value" => $meta_keywords), "meta_keywords") ?>
            </div>

            <div class="form-group col-md-12">
              <label for="inputEmail4">Meta Description</label>
              <? $app->htmlBuilder->buildTag("textarea", array("type" => "text", "class" => "form-control", "value" => $meta_description), "meta_description") ?>
            </div>

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary tx-13 submit_btn for_doctors_services_modal_submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
  $('.ckeditor').each(function() {
    CKEDITOR.replace(this.id);
  });
</script>
<script>
  // Disable Bootstrap's focus enforcement to allow CKEditor dialogs
  $.fn.modal.Constructor.prototype._enforceFocus = function() {};
</script>