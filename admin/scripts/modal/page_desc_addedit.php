<?php

$id = $app->getGetVar('id');
$pageInfoId = $app->getGetVar('page_info_id');

if ($id != '') {
  $obj_brand = $app->load_model("page_description");
  $result = $obj_brand->execute("SELECT", false, "", "id='" . $id . "' and page_info_id='" . $pageInfoId . "'");
  $city_id = $result[0]['city_id'];
  $description = $result[0]['description'];
  $status = $result[0]['status'];
}

// GET CITY OPTION IN ARRAY
$obj_model_state = $app->load_model("city");
$rs = $obj_model_state->execute("SELECT", false, "", "status='Active'");
$records1 = array();
$records1[''] = " Select City";
for ($i = 0; $i < count($rs); $i++) {
  $records1[$rs[$i]['id']] = $rs[$i]['name'];
}

?>

<div class="modal fade" id="modal_page_desc_addedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">Page Description Form</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <form method="post" name="page_desc_form" id="page_desc_form" data-parsley-validate>
        <? $app->htmlBuilder->buildTag("input", array("type" => "hidden", "value" => $id), "id") ?>
        <? $app->htmlBuilder->buildTag("input", array("type" => "hidden", "value" => $pageInfoId), "page_info_id") ?>
        <div class="modal-body">
          <div class="form-row">

            <div class="form-group col-md-12">
              <label for="inputEmail4">City <span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("select", array("class" => "form-control select2", "selected" => $city_id, "values" => $records1), "city_id"); ?>
            </div>

            <div class="form-group col-md-12">
              <label for="inputEmail4">Page Description <span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("textarea", array("type" => "text", "class" => "form-control ckeditor", "value" => $description, "style" => "height: 140px;"), "descriptions") ?>
            </div>

            <div class="form-group col-md-12">
              <label for="inputEmail4">Status <span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("select", array("class" => "form-control", "selected" => $status, "values" => array("Active" => "Active", "Inactive" => "Inactive"), "required" => ""), "status"); ?>
            </div>

          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary tx-13 submit_btn page_desc_modal_submit">Submit</button>
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