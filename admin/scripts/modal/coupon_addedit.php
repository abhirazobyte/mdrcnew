<?php
$id=$app->getGetVar('id');
if($id!='')
{
	//Edit coupon
	$obj_brand = $app->load_model("coupon");
	$result = $obj_brand->execute("SELECT", false, "", "id='".$id."'");			
	
	$coupon_code=$result[0]['coupon_code'];
	$discount_type=$result[0]['discount_type'];
	$In_percentage=$result[0]['In_percentage'];
	$coupon_for=$result[0]['coupon_for'];
	$min_order_amount=$result[0]['min_order_amount'];
	$discount=$result[0]['discount'];
	$msg=$result[0]['msg'];
	$used=$result[0]['used'];
	$display_coupon=$result[0]['display_coupon'];
	$exp_date=$result[0]['exp_date'];
	$status=$result[0]['status'];
	
	if($In_percentage=='Yes')
	{
		$discount_percentage='(%)';
	}
	else
	{
		$discount_percentage='(<i class="fa fa-rupee-sign"></i>)';
	}
}
else
{
	$discount_percentage='(<i class="fa fa-rupee-sign"></i>)';
}

?>

<div class="modal fade" id="modal_coupon_addedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">Coupon Form</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <form method="post" name="coupon_form" id="coupon_form"  data-parsley-validate>
        <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","class"=>"form-control","value"=>$id), "id") ?>
        <div class="modal-body">
          <div class="form-row">
          
            <div class="form-group col-md-6">
              <label for="inputEmail4">Code</label>
               <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control","value"=>$coupon_code,"required"=>""), "coupon_code") ?>
            </div>
            
            
            <div class="form-group col-md-6">
              <label for="inputEmail4">Discount Type</label>
             <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","selected"=>$discount_type, "values"=>array("Discount"=>"Discount","Cashback"=>"Cashback"),"required"=>""), "discount_type") ;?>
            </div>
            <div class="form-group col-md-6">
              <label for="inputEmail4">In Percentage?</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","onchange"=>"discount_percentage(this.value)","selected"=>$In_percentage, "values"=>array("No"=>"No","Yes"=>"Yes"),"required"=>""), "In_percentage") ;?>
            </div>
            
           <div class="form-group col-md-6">
              <label for="inputEmail4">Discount <span id="discount_percentage"><?=$discount_percentage?></span></label>
               <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control","value"=>$discount,"required"=>""), "discount") ?>
            </div>  
            
            <div class="form-group col-md-6">
              <label for="inputEmail4">Coupon used in</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","selected"=>$coupon_for, "values"=>array("All"=>"Both","App"=>"Application","Web"=>"Website"),"required"=>""), "coupon_for") ;?>
            </div>
            
              <div class="form-group col-md-6">
              <label for="inputEmail4">Minimum Order Amount</label>
               <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control","value"=>$min_order_amount,"required"=>""), "min_order_amount") ?>
            </div>
            
            
             <div class="form-group col-md-12">
              <label for="inputEmail4">Message</label>
               <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control","value"=>$msg), "msg") ?>
            </div>
             <div class="form-group col-md-6">
              <label for="inputEmail4">Coupon Type</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","selected"=>$used, "values"=>array("Single"=>"Once Per User","Multiple"=>"Multiple","Once"=>"Once (1 Time Use)"),"required"=>""), "used") ;?>
            </div>
             <div class="form-group col-md-6">
              <label for="inputEmail4">Display Coupon(App & Website)</label>
                <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","selected"=>$display_coupon, "values"=>array("No"=>"No","Yes"=>"Yes"),"required"=>""), "display_coupon") ;?>
            </div>
            
             <div class="form-group col-md-6">
              <label for="inputEmail4">Expiry Date</label>
              
  
                <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control","placeholder"=>"DD-MM-YYYY","data-date-format"=>"dd-mm-yyyy","value"=>$exp_date), "exp_date") ;?>
            </div>
            

            <div class="form-group col-md-6">
              <label for="inputEmail4">Status</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","selected"=>$status, "values"=>array("Active"=>"Active","Inactive"=>"Inactive"),"required"=>""), "status") ;?>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary tx-13 submit_btn coupon_modal_submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function discount_percentage(percentage)
{
	if(percentage=='No')
	{
		$('#discount_percentage').html('(<i class="fa fa-rupee-sign"></i>)');
	}
	else
	{
		$('#discount_percentage').html('(%)');
	}
}


$('#exp_date').datepicker({ 
	dateFormat: 'dd-mm-yy',
	})
	
</script>
