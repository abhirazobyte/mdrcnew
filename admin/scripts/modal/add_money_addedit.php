<?php
$getid=$app->getGetVar('id');

$obj_brand = $app->load_model("customer");
$result = $obj_brand->execute("SELECT", false, "", "id='".$getid."'");	

$phone=$result[0]['phone'];
$name=$result[0]['name'].' '.$result[0]['last_name'];
		
?>

<div class="modal fade" id="modal_add_money_addedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">Money to Wallet Form</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <form method="post" name="add_money_form" id="add_money_form"  data-parsley-validate>
       <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","class"=>"form-control"), "id") ?> 
                                              
        <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>$getid), "customer_id");?>   

        <div class="modal-body">
        
        
        <?php if($getid==''){?>
       	<div class="form-group row">
              <div class="col-lg-12">
                <label for="inputEmail4">Customer <span class="tx-danger">*</span></label>
                <div class="input-group">
                  <input type="text" id="phone" name="phone1" class="form-control" placeholder="Phone Number"  autocomplete="off" required="">
              
                    <div class="input-group-append">
                    <button class="btn btn-outline-light" type="button" id="button-addon2" onclick="remove_data()"  title="Change Customer"><i class="fa fa-trash"></i></button>
                  </div>
                </div>
                 <span >Customer Current Wallet Bal: <strong id="bal"><i class="fa fa-rupee-sign"></i> 0.00</strong></span>
              </div>
            </div>
         <?php }else{?>
         
         <div class="form-group row">
              <div class="col-lg-12">
                <label for="inputEmail4">Customer <span class="tx-danger">*</span></label>
                <div class="input-group">
                  <input type="text" id="phone" name="phone1" class="form-control" placeholder="Phone Number"  autocomplete="off" required="" readonly="readonly" disabled="disabled" value="<?=$phone.' ('.$name.')'?>">
              


                </div>
                 <span >Customer Current Wallet Bal: <strong id="bal"><i class="fa fa-rupee-sign"></i> <?=$result[0]['wallet']?></strong></span>
              </div>
            </div>
         
         
         <?php }?>
      

         <div class="form-row">
         	<div class="form-group col-md-4">
              <label for="inputEmail4">Amount<span class="tx-danger">*</span></label>
              <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-rupee-sign"></i> </span>
              </div>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control  numbersOnly number ","required"=>""), "amount") ;?>
              </div>
            </div>
            
            
            <div class="form-group col-md-4">
              <label for="inputEmail4">Credit / Debit <span class="tx-danger">*</span></label>
		         <? $app->htmlBuilder->buildTag("select", array("values"=>array("+"=>"Credit (+)","-"=>"Debit (-)"),"class"=>"form-control","required"=>""), "amount_type") ;?>
                 
              
            </div>
            
            <div class="form-group col-md-4">
              <label for="inputEmail4">Transaction ID<span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control","required"=>""), "transaction_id") ;?>
            </div>
            
            
            
          </div>
          

 			

		 <div class="form-row">
            <div class="form-group col-md-12">
              <label for="inputEmail4">Remark<span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control"), "remark") ;?>
            </div>
            </div>
            
               
              
          </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary tx-13 submit_btn add_money_modal_submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>


<script>
 function remove_data()
 {
	$('#customer_id').val('');
	$('#phone').val('');
	//$('#phone').removeAttr("readonly","readonly");
	$('#phone').attr("disabled",false);
	$('#phone').removeAttr("readonly","readonly");
	$("#bal").html('<i class="fa fa-rupee-sign"></i> 0.00');
 }
</script>
