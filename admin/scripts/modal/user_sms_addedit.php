<?php
$id=$app->getGetVar('id');

if($id!='')
{
	$obj_model_user = $app->load_model("user", $id);
	$user = $obj_model_user->execute("SELECT");

}
?>

<div class="modal fade" id="modal_user_sms_addedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">Send Mail Form</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <form method="post" name="user_sms_form" id="user_sms_form"  data-parsley-validate>
        <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","class"=>"form-control","value"=>$id), "user_id") ?>
        <div class="modal-body">
        
          <div class="form-row">
          
          
            <div class="form-group col-md-6">
              <label for="inputEmail4">Name<span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control", "readonly"=>"readonly", "value"=>$user[0]['name']), "") ?>
             </div>
            
            <div class="form-group col-md-6">
              <label for="inputEmail4">Type<span class="tx-danger">*</span></label>
             <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","onchange"=>"show_data(this.value)","required"=>"","values"=>array("Both"=>"Email & SMS","Email"=>"Email","SMS"=>"SMS")), "type_data") ?>
             </div>
             
             
             <div class="form-group col-md-12" id="e_data">
              <label for="inputEmail4">Email Address <span class="tx-danger">*</span></label>
              <?php if($user[0]['email']==''){?>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"email","class"=>"form-control","value"=>$user[0]['email']), "email") ?>
              <?php }else{?>
               <? $app->htmlBuilder->buildTag("input", array("type"=>"email","class"=>"form-control","value"=>$user[0]['email'],"readonly"=>"readonly"), "email") ?>
              <?php }?> 
             </div>
            
            <div class="form-group col-md-12" id="e_data1">
              <label for="inputEmail4">Email Message<span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("textarea", array("type"=>"textarea","class"=>"form-control ckeditor"), "message") ?>
            </div>


              
            <div class="form-group col-md-12" id="s_data">
              <label for="inputEmail4">Phone No <span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control","readonly"=>"readonly","value"=>$user[0]['mobilephone']), "phone");?>
            </div>
            
              <div class="form-group col-md-12" id="s_data1">
              <label for="inputEmail4">SMS Message <span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("textarea", array("type"=>"textarea","class"=>"form-control"), "sms_message") ?>
            </div>
  
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary tx-13 submit_btn user_sms_modal_submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function show_data(a)
{
	if(a=='Email')
	{
		$("#s_data").hide();
		$("#s_data1").hide();		
		$("#e_data").show();
		$("#e_data1").show();		
	}
	else if(a=='SMS')
	{
		$("#s_data").show();
		$("#s_data1").show();		
		$("#e_data").hide();
		$("#e_data1").hide();		
	}
	else
	{
		$("#s_data").show();
		$("#s_data1").show();		
		$("#e_data").show();
		$("#e_data1").show();
	}
}
</script>
