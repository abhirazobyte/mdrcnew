<?php
$id=$app->getGetVar('id');
if($id!='')
{
  $obj_brand = $app->load_model("pincode");
  $result = $obj_brand->execute("SELECT", false, "", "id='".$id."'");
  $name=$result[0]['name'];
  $state_id=$result[0]['state_id'];
  $city_id=$result[0]['city_id'];
  $area_id=$result[0]['area_id'];
  $api_state_id=$result[0]['api_state_id'];
  $api_city_id=$result[0]['api_city_id'];
  $api_area_id=$result[0]['api_area_id'];
  $sort_order=$result[0]['sort_order'];
  $status=$result[0]['status'];
  $appointment_start_time=$result[0]['appointment_start_time'];
  $appointment_end_time=$result[0]['appointment_end_time'];

  $obj_model_brand11 = $app->load_model("city");
  $rs3 = $obj_model_brand11->execute("SELECT", false,"","status='Active' and state_id='".$state_id."'");
  $records2 = array();
  $records2[''] = " Select City";
  for($i=0;$i<count($rs3);$i++)
  {
    $records2[$rs3[$i]['id']] = $rs3[$i]['name'];
  }

  $obj_model_area = $app->load_model("area");
  $rs4 = $obj_model_area->execute("SELECT", false,"","status='Active' and city_id='".$city_id."'");
  $records3 = array();
  $records3[''] = " Select Area";
  for($i=0;$i<count($rs4);$i++)
  {
    $records3[$rs4[$i]['id']] = $rs4[$i]['name'];
  }

}
else
{
  $records2 = array();
  $records2[''] = " Select City";
  $records3 = array();
  $records3[''] = " Select Area";
}

$obj_model_state= $app->load_model("state");
$rs = $obj_model_state->execute("SELECT", false,"","status='Active'");
$records1 = array();
$records1[''] = " Select State";
for($i=0;$i<count($rs);$i++){
  $records1[$rs[$i]['id']] = $rs[$i]['name'];
}
?>
<div class="modal fade" id="modal_pincode_addedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">Pincode Form</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <form method="post" name="pincode_form" id="pincode_form"  data-parsley-validate>
        <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","class"=>"form-control","value"=>$id), "id") ?>
        <div class="modal-body">
          <div class="form-row">

            <div class="form-group col-md-6">
              <label for="inputEmail4">State <span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control select2","onchange"=>"getCity(this)","selected"=>$state_id, "values"=>$records1,"required"=>""), "state_id") ;?>
            </div>

            <div class="form-group col-md-6">
              <label for="inputEmail4">City <span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control select2","onchange"=>"getArea(this)","selected"=>$city_id, "values"=>$records2,"required"=>""), "city_id") ;?>
            </div>
            <div class="form-group col-md-6">
              <label for="inputEmail4">Area<span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control select2","selected"=>$area_id, "values"=>$records3,"required"=>""), "area_id") ;?>
            </div>

            <div class="form-group col-md-6">
              <label for="inputEmail4">Pincode<span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control numbersOnly","value"=>$name,"required"=>""), "name");?>
            </div>

            <div class="form-group col-md-6">
              <label for="inputEmail4">Appointment Start Time<span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control numbersOnly","value"=>$appointment_start_time,"required"=>""), "appointment_start_time");?>
            </div>

            <div class="form-group col-md-6">
              <label for="inputEmail4">Appointment End Time<span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control numbersOnly","value"=>$appointment_end_time,"required"=>""), "appointment_end_time");?>
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
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary tx-13 submit_btn pincode_modal_submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
