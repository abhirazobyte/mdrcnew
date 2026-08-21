<?php
$id=$app->getGetVar('id');

if($id!='')
{
		$obj_category = $app->load_model("order_detail");
		$obj_category->join_table("order_master", "left", array("return_desc","return_amount","order_reff_data"), array("order_master_id"=>"id"));
		$rs_data = $obj_category->execute("SELECT", false, "", "order_master_id='".$id."'");
		$html='';
		$calculate_amount=0;
		for($i=0;$i<count($rs_data);$i++)
		{
			$line_total=(int)$rs_data[$i]['line_total'];
			$item_id=$rs_data[$i]['id'];
			$item_name=$rs_data[$i]['item_name'];
			$pro_unit=$rs_data[$i]['item_unit'];
			$product_weight=$rs_data[$i]['product_weight'];
			if($pro_unit=='in_gm')
			{
				$weight=$app->utility->change_weight_display_other_2018($product_weight,$pro_unit);
			}
			else if($pro_unit=='in_ltr')
			{
				$weight=$app->utility->change_weight_display_other_2018($product_weight,$pro_unit);
			}
			else
			{
				$weight=(int)$product_weight." Pcs";
			}
			if($rs_data[$i]['return_product']=='Yes')
			{
				$check='checked="checked"';
				$calculate_amount=$calculate_amount+$line_total;
			}
			else
			{
				$check='';
			}
			$finction='onclick="calculate_data('.$item_id.','.$line_total.')"';
			if($line_total>0)
			{
			$html.='<div class="form-group col-md-6"><div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" name="checks[]" id="checks_'.$item_id.'"  value="'.$item_id.'" '.$check.' '.$finction.'> <label class="custom-control-label" for="checks_'.$item_id.'">'.$item_name.' ('.$weight.') - Rs.'.$line_total.'</label></div></div>';
			}
		}
		if($rs_data[0]['order_master_return_desc']>0)
		{
			$amount=$rs_data[0]['order_master_return_desc'];
		}
		else
		{
			$amount=$calculate_amount;
		}
		if($amount<=0)
		{
			$amount='';
		}
		$remark=$rs_data[0]['order_master_return_desc'];
		$order_reff_data=$rs_data[0]['order_master_order_reff_data'];
}


?>

<div class="modal fade" id="modal_order_return" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">Order Return Remark</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <form method="post" name="order_return_form" id="order_return_form"  data-parsley-validate>
        <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","class"=>"form-control","value"=>$id), "returnID") ?>
        <div class="modal-body">
           <div class="form-row">
            <div class="form-group col-md-12">
                <label for="inputEmail4">Products <span class="tx-danger">*</span></label>
                 <div class="form-row">
				 <?=$html?>
                 </div>
            </div>
            
            <div class="form-group col-md-12">
                <label for="inputEmail4">Amount <span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control  required","value"=>$amount,"required"=>""), "return_value") ;?>
            </div>

            <div class="form-group col-md-12">
                <label for="inputEmail4">Remark <span class="tx-danger">*</span></label>
             <? $app->htmlBuilder->buildTag("textarea", array("type"=>"text","class"=>"form-control  required","value"=>$return_remark,"required"=>""), "return_remark") ;?>
            </div>
            
             <div class="form-group col-md-12">
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" value="Yes" id="return_option"  name="return_option" <?=$check?>>
              <label class="custom-control-label" for="return_option">Amount Refunded to User Wallet.</label>
            </div>
            </div>
            
            
            </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary tx-13 submit_btn order_return_modal_submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function calculate_data(id,amt)
{
	if($("#return_value").val()=='')
	{
		var at=0;
	}
	else
	{
		var at=parseInt($("#return_value").val());
	}
	var check_amt=$("input[id='checks_"+id+"']:checked").val();
	if(parseInt(check_amt)>0)
	{
		var new_amt=parseInt(at)+parseInt(amt);
	}
	else
	{
		var new_amt=parseInt(at)-parseInt(amt);
	}
	if(parseInt(new_amt)>0)
	{
		$("#return_value").val(new_amt);
	}
	else
	{
		$("#return_value").val('');
	}
}
</script>
