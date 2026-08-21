<?php
$id=$app->getGetVar('id');

if($id!='')
{
	$obj_brand = $app->load_model("page_info");
	$result = $obj_brand->execute("SELECT", false, "", "id='".$id."'");			
  $page_name=$result[0]['page_name'];
	$page_title=$result[0]['page_title'];
	$meta_keywords=$result[0]['meta_keywords'];
	$meta_description=$result[0]['meta_description'];
  $meta_schema=$result[0]['meta_schema'];
  $decsription=$result[0]['description'];
}

?>

<div class="modal fade" id="modal_page_info_addedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">Page Info Form</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <form method="post" name="page_info_form" id="page_info_form"  data-parsley-validate>
        <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","class"=>"form-control","value"=>$id), "id") ?>
        <div class="modal-body">
          <div class="form-row">

            <div class="form-group col-md-12">
              <label for="inputEmail4">Page Name *</label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control", "value"=>$page_name,"required"=>""), "page_name") ;?>
            </div>
   
            <div class="form-group col-md-12">
              <label for="inputEmail4">Title</label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control","value"=>$page_title,"required"=>""), "page_title") ?>
            </div>
            <div class="form-group col-md-12">
              <label for="inputEmail4">Meta Keywords</label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control ","value"=>$meta_keywords,"required"=>""), "meta_keywords") ;?>
            </div>
            <div class="form-group col-md-12">
              <label for="inputEmail4">Meta Description</label>
              <? $app->htmlBuilder->buildTag("textarea", array("class"=>"form-control","value"=>$meta_description,"required"=>""), "meta_description") ;?>
            </div>
            <div class="form-group col-md-12">
              <label for="inputEmail4">Page Description</label>
              <? $app->htmlBuilder->buildTag("textarea", array("type" => "text", "class" => "form-control ckeditor", "value" => $decsription, "style" => "height: 140px;"), "description") ?>
            </div>
            <div class="form-group col-md-12">
              <label for="inputEmail4">Meta Schema</label>
              <? $app->htmlBuilder->buildTag("textarea", array("type" => "text", "class" => "form-control", "value" => $meta_schema, "style" => "height: 100px;"), "meta_schema") ?>
            </div>
            <div class="form-group col-md-12">
            Note : Write city name like {CITY} in meta details. It will change with current city. *
            </div>
          </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary tx-13 submit_btn page_info_modal_submit">Submit</button>
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