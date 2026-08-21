<?php
$ids=$app->getGetVar('ids');

$obj_model_delivery_vans= $app->load_model("delivery_vans");
$rs_dv = $obj_model_delivery_vans->execute("SELECT",false,"","");
$records_dv = array();
$records_dv[""] = "Select Delivery Boy";
for($i=0;$i<count($rs_dv);$i++)
{
	$records_dv[$rs_dv[$i]['id']] = $rs_dv[$i]['person_name'];
}
			
?>

<div class="modal fade" id="modal_order_dispatch" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">Order Dispatch</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <form method="post" name="order_dispatch_form" id="order_dispatch_form"  data-parsley-validate>
        <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","class"=>"form-control","value"=>$ids), "ids") ?>
        <div class="modal-body">
        
          
           <div class="form-row">
            <div class="form-group col-md-12">
                <label for="inputEmail4">Delivery Vans </label>
                <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control select2","required"=>"","values"=>$records_dv), "van_id") ?>
            </div>
            </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary tx-13 submit_btn order_dispatch_modal_submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
