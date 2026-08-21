<?php
$id=$app->getGetVar('id');

if($id!='')
{
	$obj_brand = $app->load_model("admin");
	$result = $obj_brand->execute("SELECT", false, "", "id='".$id."'");			
	
	$login_username=$result[0]['login_username'];
	$phone=$result[0]['phone'];
	$email=$result[0]['email'];
	$login_password=$result[0]['login_password'];
	$status=$result[0]['status'];
}

?>

<div class="modal fade" id="modal_account_addedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">Admin User Form</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <form method="post" name="account_form" id="account_form"  data-parsley-validate>
        <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","class"=>"form-control","value"=>$id), "id") ?>
        <div class="modal-body">
        
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="inputEmail4">Name <span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control ","value"=>$login_username,"required"=>""), "login_username");?>
            </div>
          </div>
          
          
           <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputEmail4">Phone <span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control numbersOnly number","value"=>$phone,"required"=>""), "phone");?>
            </div>
            
            <div class="form-group col-md-6">
              <label for="inputEmail4">Email <span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control ","value"=>$email,"required"=>""), "email");?>
            </div>
            
          </div>
          
           
           <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputEmail4">Password <span class="tx-danger">*</span></label>
              
         
            <div class="input-group">
             <? $app->htmlBuilder->buildTag("input", array("type"=>"password","class"=>"form-control ","value"=>$login_password,"required"=>""), "login_password");?>
              <div class="input-group-prepend">
                  <div class="input-group-text"> <i toggle="#password-field" class="fa fa-fw fa-eye field_icon toggle-password"></i> </div>
                </div>
            </div>
            
          </div>
 
     
            <div class="form-group col-md-6">
              <label for="inputEmail4">Status</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","selected"=>$status, "values"=>array("Active"=>"Active","Inactive"=>"Inactive"),"required"=>""), "status") ;?>
            </div>
          </div>
          
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary tx-13 submit_btn account_modal_submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>



<script>
  $(document).on("click", ".toggle-password", function () {

    $(this).toggleClass("fa-eye fa-eye-slash");

    var input = $("#login_password");

    input.attr("type") === "password"

      ? input.attr("type", "text")

      : input.attr("type", "password");

  });
</script>
