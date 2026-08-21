<?php
$id=$app->getGetVar('id');
$faq_type=$app->getGetVar('faq_type');
$faq_type_id=$app->getGetVar('faq_type_id');
if($id!='')
{
	//Edit faq
	$obj_brand = $app->load_model("faq");
	$result = $obj_brand->execute("SELECT",false, "", "id='".$id."'");			
  $faq_category_id=$result[0]['faq_category_id'];
  $question=$result[0]['question'];
  $answer=$result[0]['answer'];
	$sort_id=$result[0]['sort_id'];
	$status=$result[0]['status'];
}
?>
<div class="modal fade" id="modal_faq_addedit" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">FAQ Form</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <form method="post" name="faq_form" id="faq_form"  data-parsley-validate>
        <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","class"=>"form-control","value"=>$id), "id") ?>
        <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","class"=>"form-control","value"=>$faq_type),"type") ?>
        <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","class"=>"form-control","value"=>$faq_type_id),"faq_type_id") ?>
        <div class="modal-body">
          <div class="form-row">
            <?php if($faq_type==''){ ?>
            <div class="form-group col-md-12">
              <label for="inputEmail4">Category</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","selected"=>$faq_category_id, "values"=>array("1"=>"Radiology FAQ Page","2"=>"Pathology FAQ Page","3"=>"Home Page","4"=>"Full Body Checkup"),"required"=>""), "faq_category_id") ;?>
            </div>
            <?php }; ?>
            <div class="col-lg-12">
              <div class="form-group">
                <label class="" for="example-email">Question *</label>
                <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control","required"=>"","value"=>$question), "question") ?>
                <div>Note : Write city name like {CITY} in meta details. It will change with current city. * </div>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="form-group">
                <label class="" for="example-email">Answer *</label>
                <? $app->htmlBuilder->buildTag("textarea", array("class"=>"form-control ckeditor","required"=>"","value"=>$answer), "answer") ?>
                <div>Note : Write city name like {CITY} in meta details. It will change with current city. * </div>
              </div>
            </div>
            <div class="form-group col-md-6">
              <label for="inputEmail4">Sort Id *</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control ","selected"=>$sort_id, "values"=>$app->utility->sort_order('faq'),"required"=>""), "sort_id") ;?>
            </div>
            <div class="form-group col-md-6">
              <label for="inputEmail4">Status</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","selected"=>$status, "values"=>array("Active"=>"Active","Inactive"=>"Inactive"),"required"=>""), "status") ;?>
            </div>
            
          </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary tx-13 submit_btn faq_modal_submit">Submit</button>
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
