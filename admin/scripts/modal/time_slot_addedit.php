<?php
$id=$app->getGetVar('id');

if($id!='')
{
	$obj_brand = $app->load_model("time_slot");
	$result = $obj_brand->execute("SELECT", false, "", "id='".$id."'");			
	
	$id=$result[0]['id'];
	$start_time=$result[0]['start_time'];
	$end_time=$result[0]['end_time'];
	$day=$result[0]['day'];
	
}

	$rs_work=array();
	$rs_work[0]['name']='Monday';
	$rs_work[1]['name']='Tuesday';
	$rs_work[2]['name']='Wednesday';
	$rs_work[3]['name']='Thursday';
	$rs_work[4]['name']='Friday';
	$rs_work[5]['name']='Saturday';
	$rs_work[6]['name']='Sunday';
	
?>

<div class="modal fade" id="modal_time_slot_addedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">Time Slot Form</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <form method="post" name="time_slot_form" id="time_slot_form"  data-parsley-validate>
        <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","class"=>"form-control","value"=>$id), "id") ?>
        <div class="modal-body">
        
          <div class="form-row">
          
          
            <div class="form-group col-md-6">
              <label for="inputEmail4">Start Time<span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control ","value"=>$start_time,"required"=>""), "start_time");?>
            </div>
            
            
            <div class="form-group col-md-6">
              <label for="inputEmail4">End Time<span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control ","value"=>$end_time,"required"=>""), "end_time");?>
            </div>
          </div>
          
         
          
          <div class="form-row">
            <div class="form-group col-md-12">
             <label for="inputEmail4">Days</label>
       	 <select class="form-control select2" multiple="multiple" name="days[]" required="">
        	 <option label="Choose one"></option>
        	 <? for($i=0;$i<count($rs_work);$i++)
                {
                $micro_items=explode(',',$day);
                ?>
                <option  value="<?=$rs_work[$i]['name']; ?>" <?  for($j=0;$j<count($micro_items);$j++)
					{if($rs_work[$i]['name']==trim($micro_items[$j])){echo 'selected';}} ?>>
					<?=$rs_work[$i]['name']; ?>
                </option>
                <?php } ?>
         </select>
        </div>
       </div>
          
          
          
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary tx-13 submit_btn time_slot_modal_submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
