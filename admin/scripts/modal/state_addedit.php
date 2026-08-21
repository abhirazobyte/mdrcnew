<?php
$id=$app->getGetVar('id');
if($id!='')
{
	$obj_brand = $app->load_model("state");
	$result = $obj_brand->execute("SELECT", false, "", "id='".$id."'");
	$id=$result[0]['id'];
	$name=$result[0]['name'];
	$status=$result[0]['status'];
  $api_state_id=$result[0]['api_state_id'];
  $sort_order=$result[0]['sort_order'];
}
?>
<div class="modal fade" id="modal_state_addedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">State Form</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <form method="post" name="state_form" id="state_form"  data-parsley-validate>
        <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","class"=>"form-control","value"=>$id), "id") ?>
        <div class="modal-body">
          <div class="form-row">
            <div class="form-group col-md-8">
              <label for="inputEmail4">State Name<span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control ","value"=>$name,"required"=>""), "name");?>
            </div>

            <div class="form-group col-md-4">
              <label for="inputEmail4">State Api Id<span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control numbersOnly","value"=>$api_state_id,"required"=>""), "api_state_id");?>
            </div>

            <div class="form-group col-md-6">
              <label for="inputEmail4">Sort Order</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control ","selected"=>$sort_order, "values"=>$app->utility->sort_order('state'),"required"=>""), "sort_order") ;?>
            </div>

            <div class="form-group col-md-6">
              <label for="inputEmail4">Status</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","selected"=>$status, "values"=>array("Active"=>"Active","Inactive"=>"Inactive"),"required"=>""), "status") ;?>
            </div>

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary tx-13 submit_btn state_modal_submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
