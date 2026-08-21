<?php
$id=$app->getGetVar('id');

if($id!='')
{

	$obj_category = $app->load_model("order_master");
	$obj_category->set_fields_to_get(array("wallet_value","id","order_reff_data"));
	$rs_data = $obj_category->execute("SELECT", false, "", "id='".$id."'");

	if($rs_data[0]['wallet_value']>0)
	{
		$advance_amount=$rs_data[0]['wallet_value'];
		$advance='Yes';
	}
	else
	{
		$advance_amount=0;
		$advance='No';
	}
	$order_remark=$rs_data[0]['order_remark'];
	$order_reff_data=$rs_data[0]['order_reff_data'];
}


?>

<div class="modal fade" id="modal_order_cancel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">Order Cancel Remark</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <form method="post" name="order_cancel_form" id="order_cancel_form"  data-parsley-validate>
        <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","class"=>"form-control","value"=>$id), "id") ?>
        <div class="modal-body">
        
          
           <div class="form-row">
            <div class="form-group col-md-12" style="display:none">
                <label for="inputEmail4">Advance Amount</label>
               <input type="text" name="refund_value" id="refund_value" class="span4 required number" value="<?=$advance_amount?>" >
            </div>
           
            <div class="form-group col-md-12">
                <label for="inputEmail4">Remark <span class="tx-danger">*</span></label>
             <? $app->htmlBuilder->buildTag("textarea", array("type"=>"text","class"=>"form-control  required","value"=>$$order_remark,"required"=>""), "cancel_remark") ;?>
            </div>
            
             <div class="form-group col-md-12" style="display:none">
             	<input type="checkbox" name="refund_option" id="refund_option" value="Yes" checked="checked">
                 <label for="inputEmail4">Advance Amount Refunded to User Wallet.</label>
            </div>
            </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary tx-13 submit_btn order_cancel_modal_submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
