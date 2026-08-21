<?php
$id=$app->getGetVar('id');
if($id!='')
{
	//Edit brand
	$obj_brand = $app->load_model("user");
	$result = $obj_brand->execute("SELECT", false, "", "id='".$id."'");			
	
	$name=$result[0]['name'];
	$mobile=$result[0]['mobilephone'];
	$email=$result[0]['email'];
	$id=$result[0]['id'];
	
	
}
else
{
	//Add brand
	$brand_img='images/img_upl.gif';	
}
?>

<div class="modal fade" id="modal_brand_addedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">Send Message</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <form method="post" name="other_form" id="other_form"  data-parsley-validate>
        <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","class"=>"form-control","value"=>$name), "name") ?>
         <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","class"=>"form-control","value"=>$mobile), "mobile") ?>
         <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","class"=>"form-control","value"=>"send_mail"), "act") ?>
        <div class="modal-body">


	 	 <div class="form-row">
            <div class="form-group col-md-12">
              <label for="inputEmail4">Email<span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control required","value"=>$email,"required"=>""), "email") ;?>
            </div>
            
          </div>
          
          
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="inputEmail4">Message<span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("textarea", array("rows"=>"5","class"=>"form-control required","value"=>"","required"=>""), "msg") ;?>
            </div>
            
          </div>
          
          
          

	
          

        
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary tx-13 submit_btn brand_modal_submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
