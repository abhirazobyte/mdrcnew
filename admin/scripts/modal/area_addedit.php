<?php
$id=$app->getGetVar('id');
if($id!='')
{
  $obj_brand = $app->load_model("area");
  $result = $obj_brand->execute("SELECT", false, "", "id='".$id."'");
  $id=$result[0]['id'];
  $city_id=$result[0]['city_id'];
  $name=$result[0]['name'];
  $state_id=$result[0]['state_id'];
  $sort_order=$result[0]['sort_order'];
  $api_area_id=$result[0]['api_area_id'];
  $status=$result[0]['status'];

  $obj_model_brand11 = $app->load_model("city");
  $rs3 = $obj_model_brand11->execute("SELECT", false,"","status='Active' and state_id='".$state_id."'");
  $records2 = array();
  $records2[''] = " Select City";
  for($i=0;$i<count($rs3);$i++)
  {
    $records2[$rs3[$i]['id']] = $rs3[$i]['name'];
  }

}

$obj_model_brand = $app->load_model("state");
$rs = $obj_model_brand->execute("SELECT", false,"","status='Active'");
$records1 = array();
$records1[''] = " Select State";
for($i=0;$i<count($rs);$i++){
  $records1[$rs[$i]['id']] = $rs[$i]['name'];
}
?>
<div class="modal fade" id="modal_area_addedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">Area Form</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <form method="post" name="area_form" id="area_form"  data-parsley-validate>
        <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","class"=>"form-control","value"=>$id), "id") ?>
        <div class="modal-body">
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputEmail4">State <span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control select2","onchange"=>"getCity(this)","selected"=>$state_id, "values"=>$records1,"required"=>""), "state_id") ;?>
            </div>

            <div class="form-group col-md-6">
              <label for="inputEmail4">City <span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control select2","selected"=>$city_id, "values"=>$records2,"required"=>""), "city_id") ;?>
            </div>
            <div class="form-group col-md-6">
              <label for="inputEmail4">Area<span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control ","value"=>$name,"required"=>""), "name");?>
            </div>
            <div class="form-group col-md-6">
              <label for="inputEmail4">Area API Id<span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control numbersOnly","value"=>$api_area_id,"required"=>""), "api_area_id");?>
            </div>
   
             <div class="form-group col-md-6">
              <label for="inputEmail4">Sort Order</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control ","selected"=>$sort_order, "values"=>$app->utility->sort_order('area'),"required"=>""), "sort_order") ;?>
            </div>

          <div class="form-group col-md-6">
              <label for="inputEmail4">Status</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","selected"=>$status, "values"=>array("Active"=>"Active","Inactive"=>"Inactive"),"required"=>""), "status") ;?>
            </div>
          </div>
          <div class="form-row">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary tx-13 submit_btn area_modal_submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
