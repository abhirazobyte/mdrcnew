<?php
$id=$app->getGetVar('id');

if($id!='')
{
	$obj_brand = $app->load_model("delivery_vans");
	$result = $obj_brand->execute("SELECT", false, "", "id='".$id."'");			
	
	$van_no=$result[0]['van_no'];
	$person_name=$result[0]['person_name'];
	$mobile=$result[0]['mobile'];
	$password=$result[0]['password'];
}


?>

<div class="modal fade" id="modal_delivery_boy_addedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">Delivery Boy Form</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <form method="post" name="delivery_boy_form" id="delivery_boy_form"  data-parsley-validate>
        <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","class"=>"form-control","value"=>$id), "id") ?>
        <div class="modal-body">
        
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="inputEmail4">Vehicle No <span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control ","value"=>$van_no,"required"=>""), "van_no");?>
            </div>
          </div>
          
          
           <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputEmail4">Delivery Boy Name  <span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control","value"=>$person_name,"required"=>""), "person_name");?>
            </div>
            
            <div class="form-group col-md-6">
              <label for="inputEmail4">Phone <span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control numbersOnly number","value"=>$mobile,"required"=>""), "mobile");?>
            </div>
            
          </div>
          
           
           <div class="form-row">
            <div class="form-group col-md-12">
              <label for="inputEmail4">Password <span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"password","class"=>"form-control ","value"=>$password,"required"=>""), "password");?>
            </div>
          </div>
          
          
          
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary tx-13 submit_btn delivery_boy_modal_submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
