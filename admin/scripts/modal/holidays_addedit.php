<?php
$id=$app->getGetVar('id');
if($id!='')
{
	$obj_brand = $app->load_model("holidays");
	$result = $obj_brand->execute("SELECT", false, "", "id='".$id."'");
	$id=$result[0]['id'];
	$name=$result[0]['name'];
	$status=$result[0]['status'];
  $remark=$result[0]['remark'];
  $city_ids=$result[0]['city_ids'];
}
$obj_model_tble = $app->load_model("city");
$rs_work = $obj_model_tble->execute("SELECT",false,"","city.status='Active'","city.sort_order ASC");

?>
<div class="modal fade" id="modal_holidays_addedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">Holiday Form</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <form method="post" name="holidays_form" id="holidays_form"  data-parsley-validate>
        <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","class"=>"form-control","value"=>$id), "id") ?>
        <div class="modal-body">
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="inputEmail4">Holiday Date<span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control input-datepicker","data-date-format"=>"dd/mm/yy","value"=>$name,"required"=>""), "name");?>
            </div>

            <div class="form-group col-md-12">
              <label for="inputEmail4">Remark<span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control","value"=>$remark,"required"=>""), "remark");?>
            </div>

            <div class="form-group col-md-6">
              <label for="inputEmail4">City</label>
                <select class="form-control select2" multiple="multiple" name="work_item[]" >
                  <? for($i=0;$i<count($rs_work);$i++)
                  {
                  $micro_items=explode(',',$city_ids);
                  ?>
                <option  value="<?=$rs_work[$i]['id']; ?>" <?  for($j=0;$j<count($micro_items);$j++)
					      {if($rs_work[$i]['id']==trim($micro_items[$j])){echo 'selected';}} ?>>
					      <?=$rs_work[$i]['name']; ?>
                </option>
                <?php } ?>
               </select>
               <span style="font-size: 12px;">Make Blank for All city.</span>
            </div>

            <div class="form-group col-md-6">
              <label for="inputEmail4">Status</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","selected"=>$status, "values"=>array("Active"=>"Active","Inactive"=>"Inactive"),"required"=>""), "status") ;?>
            </div>

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary tx-13 submit_btn holidays_modal_submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
