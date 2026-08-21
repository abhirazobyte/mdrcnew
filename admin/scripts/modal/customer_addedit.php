<?php
$id=$app->getGetVar('id');

if($id!='')
{
	$obj_brand = $app->load_model("customer");
	$obj_brand->join_table("customer_info", "left", array(), array("id"=>"customer_id"));
	$result = $obj_brand->execute("SELECT", false, "", "customer.id='".$id."'");			
	
	$id=$result[0]['id'];
	$name=$result[0]['name'];
	$last_name=$result[0]['last_name'];
	$gender=$result[0]['gender'];
	$email=$result[0]['email'];
	$phone=$result[0]['phone'];
	$status=$result[0]['status'];
	
	$otp_verified=$result[0]['otp_verified'];
	
	$birth_date=$result[0]['customer_info_birth_date'];
	$anniversary_date=$result[0]['customer_info_anniversary_date'];
	$whatsapp_no=$result[0]['customer_info_whatsapp_no'];
	
	$folder='customer';
	$img_name=$result[0]["image"];
	$log_img=$app->utility->get_image_path($img_name,$folder,'thumb');
}
else
{
	$log_img='images/img_upl.gif';
}
?>


<div class="modal fade" id="modal_customer_addedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">Add Customer Form</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <form method="post" name="customer_form" id="customer_form"  data-parsley-validate>
        <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","class"=>"form-control","value"=>$id), "id") ?>
        <div class="modal-body">
        <div data-label="Customer Info" class="df-example demo-table search_box">
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputEmail4">First Name<span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control ","value"=>$name,"required"=>""), "name");?>
            </div>
            
            <div class="form-group col-md-6">
              <label for="inputEmail4">Last Name<span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control ","value"=>$last_name,"required"=>""), "last_name");?>
            </div>
            
            <div class="form-group col-md-6">
              <label for="inputEmail4">Email</label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control ","value"=>$email), "email");?>
            </div>
            
              <div class="form-group col-md-6">
              <label for="inputEmail4">Phone <span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control ","value"=>$phone,"required"=>""), "phone");?>
            </div>
            
            <div class="form-group col-md-6">
              <label for="inputEmail4">Profile</label>
              <div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="fileupload-new" > <img src="<?=$log_img;?>" class="up_img"> </div>
                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                <div> <span class="btn btn-file btn-default"> <span class="mg-t-5 fileupload-new btn btn-white btn-xs">Select image</span><span class="fileupload-exists btn btn-white btn-xs">Change</span>
                  <? $app->htmlBuilder->buildTag("input", array("type"=>"file","class"=>""), "customer_image") ?>
                  </span> <a href="#" class="btn btn-xs fileupload-exists btn-white" data-dismiss="fileupload">Remove</a> </div>
              </div>
            </div>
            
            <div class="form-group col-md-6">
              <label for="inputEmail4">Whatsapp No</label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control ","value"=>$whatsapp_no), "whatsapp_no");?>
           
             <?php if($id!='' && $otp_verified=='No'){?>
             <br/>
              <label for="inputEmail4">OTP Verify? <span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","selected"=>$otp_verified, "values"=>array("No"=>"No","Yes"=>"Yes")), "otp_verified") ;?>
			  <?php }?> 
              <br/>
              <label for="inputEmail4">Status</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","selected"=>$status, "values"=>array("Active"=>"Active","Inactive"=>"Inactive")), "status") ;?>
           
             </div>
             
               <div class="form-group col-md-6">
              <label for="inputEmail4">Birth Date</label>
                 <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control input-datepicker","placeholder"=>"DD-MM-YYYY","data-date-format"=>"dd-mm-yyyy","value"=>$birth_date), "birth_date") ;?>
            </div>
            
             <div class="form-group col-md-6">
              <label for="inputEmail4">Anniversary Date</label>
                 <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control input-datepicker","placeholder"=>"DD-MM-YYYY","data-date-format"=>"dd-mm-yyyy","value"=>$anniversary_date), "anniversary_date") ;?>
            </div>

            
                    
          </div>
        </div>
        
          
          
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary tx-13 submit_btn customer_modal_submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>