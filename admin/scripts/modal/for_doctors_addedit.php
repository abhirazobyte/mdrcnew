<?php
$id=$app->getGetVar('id');
if($id!='')
{
  //Edit for_doctors
  $obj_brand = $app->load_model("for_doctors");
  $result = $obj_brand->execute("SELECT", false, "", "id='".$id."'");
  $id=$result[0]['id'];
  $title=$result[0]['title'];
  $main_title=$result[0]['main_title'];
  $short_desc=$result[0]['short_desc'];
  $button_name=$result[0]['button_name'];
  $button_link=$result[0]['button_link'];
  $set_at_home=$result[0]['set_at_home'];
  $status=$result[0]['status'];
  $sort_order=$result[0]['sort_order'];

  $meta_title=$result[0]['meta_title'];
  $meta_keywords=$result[0]['meta_keywords'];
  $meta_description=$result[0]['meta_description'];
}


?>
<div class="modal fade" id="modal_for_doctors_addedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">For Doctors Form</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <form method="post" name="for_doctors_form" id="for_doctors_form"  data-parsley-validate>
        <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","class"=>"form-control","value"=>$id), "id") ?>
        <div class="modal-body">
          <div class="form-row">

             <div class="form-group col-md-12">
              <label for="inputEmail4">Title <span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control","value"=>$title,"required"=>""), "title") ?>
            </div>

            <div class="form-group col-md-12">
              <label for="inputEmail4">Main Title <span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control","value"=>$main_title,"required"=>""), "main_title") ?>
            </div>

            <div class="form-group col-md-6">
              <label for="inputEmail4">Button Title</label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control","value"=>$button_name), "button_name") ?>
            </div>
            <div class="form-group col-md-6">
              <label for="inputEmail4">Button Link</label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control","value"=>$button_link), "button_link") ?>
            </div>

            <div class="form-group col-md-12">
              <label for="inputEmail4">Short Description</label>
              <? $app->htmlBuilder->buildTag("textarea", array("type"=>"text","class"=>"form-control","value"=>$short_desc,"style"=>"height: 80px;"), "short_desc") ?>
            </div>
        
            <div class="form-group col-md-4">
              <label for="inputEmail4">Sort Orde</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control ","selected"=>$sort_order, "values"=>$app->utility->sort_order('for_doctors'),"required"=>""), "sort_order") ;?>
            </div>
            <div class="form-group col-md-4">
              <label for="inputEmail4">Status</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","selected"=>$status, "values"=>array("Active"=>"Active","Inactive"=>"Inactive"),"required"=>""), "status") ;?>
            </div>

            <div class="form-group col-md-4">
              <label for="inputEmail4">Set At Home</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","selected"=>$set_at_home, "values"=>array("No"=>"No","Yes"=>"Yes"),"required"=>""), "set_at_home") ;?>
            </div>

            <div class="form-group col-md-12">
              <label for="inputEmail4">Meta Title</label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control","value"=>$meta_title), "meta_title") ?>
            </div>

            <div class="form-group col-md-12">
              <label for="inputEmail4">Meta Keywords</label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control","value"=>$meta_keywords), "meta_keywords") ?>
            </div>

            <div class="form-group col-md-12">
              <label for="inputEmail4">Meta Description</label>
              <? $app->htmlBuilder->buildTag("textarea", array("type"=>"text","class"=>"form-control","value"=>$meta_description), "meta_description") ?>
            </div>

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary tx-13 submit_btn for_doctors_modal_submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
  $('.ckeditor').each( function () 

{

    CKEDITOR.replace( this.id );

});
</script>