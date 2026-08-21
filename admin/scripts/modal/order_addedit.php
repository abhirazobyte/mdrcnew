<?php
$id=$app->getGetVar('id');

if($id!='')
{
		$obj_s= $app->load_model("customer_order_master");
		$rs_data = $obj_s->execute("SELECT", false, "", "id=".$id."");
		
		
		$last_status=$rs_data[0]['order_status'];
		$delivery_boy_id1=$rs_data[0]['delivery_boy_id'];
		
		if($last_status=='Pending')
		{
			$new_status="Confirmed";
			$display_label="Confirmed";
			
		}
		else if($last_status=='Confirmed')
		{
			$new_status="Packed";
			$display_label="Packed";
			
		}
		else if($last_status=='Packed')
		{
			$new_status="Dispatched";
			$display_label="Dispatched";
			
		}
		else if($last_status=='Dispatched')
		{
			$new_status="On Delivery";
			$display_label="On Delivery";
			
		}
		
		
		else if($last_status=='On Delivery')
		{
			$new_status="Delivered";
			$display_label="Delivered";
			
		}
		else if($last_status=='Delivered')
		{
			$new_status="Return";
			$display_label="Return";
			
		}
		
		
		
		
		
		
			
			
		
		
		
		
		
	
}






?>

<div class="modal fade" id="modal_proposal_addedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">Order Status : <?=$rs_data[0]['display_order_no']?></h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <form method="post" name="proposal_form" id="proposal_form"  data-parsley-validate>
        <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","class"=>"form-control","value"=>$id), "id") ?>
        <div class="modal-body">
        
        
        
        <div class="form-row">
            <div class="form-group col-md-6">
            <label class="d-block">Status <span class="tx-danger">*</span></label>
            
            
            
            
            
            
             
            <?php if($last_status=='Delivered'){?>
            
            <div class="custom-control custom-radio">
              <input type="radio" id="status2" value="Return" name="status_order" class="custom-control-input" checked>
              <label class="custom-control-label" for="status2" >Return</label>
            </div>
            <?php }else{?>
            
            
            
            
            
            
            <div class="custom-control custom-radio">
              <input type="radio" id="status1" value="<?=$new_status?>" name="status_order" class="custom-control-input"  checked>
              <label class="custom-control-label" for="status1" ><?=$display_label?></label>
            </div>
            
            <?php }?>
            
            
            
            
            
            
            
            
            <?php if($last_status=='Delivered' || $last_status=='Return' || $last_status=='Canceled'){}else{?>
            
            <div class="custom-control custom-radio">
              <input type="radio" id="status2" value="Canceled" name="status_order" class="custom-control-input" >
              <label class="custom-control-label" for="status2" >Canceled</label>
            </div>
            <?php }?>
            
            
            
            
            
            
            
            
            <?php if($last_status=='Packed11'){?>
           
            <div class="mg-t-10">
              <label for="inputEmail4">Delivery Boy </label>
             <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","selected"=>$delivery_boy_id1,"values"=>$records1), "delivery_boy_id1") ;?>
            </div>
            
            <?php }?>
            
            
            
            
            
		</div>
           
           
           
           
             
            
        
        
        
            <div class="form-group col-md-6">
              <label for="inputEmail4">Remark </label>
             <? $app->htmlBuilder->buildTag("textarea", array("rows"=>"5","class"=>"form-control","value"=>$name), "remark_data") ;?>
            </div>
            
         
          
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary tx-13 submit_btn proposal_modal_submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
