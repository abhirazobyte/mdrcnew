<?php
$id=$app->getGetVar('id');


if($id!='')
{
	$obj_brand = $app->load_model("sms_data");
	$result = $obj_brand->execute("SELECT", false, "", "id='".$id."'");			
	
	$id=$result[0]['id'];
	$name=$result[0]['name'];
	
	
	$sms_text_system=$result[0]['sms_text_system'];
	$sms_text=$result[0]['sms_text'];
	
	$status=$result[0]['status'];
	
	$template_id=$result[0]['template_id'];
	
	
}

	
	
	
?>

<div class="modal fade" id="modal_sms_data_addedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">SMS Template Form</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <form method="post" name="sms_data_form" id="sms_data_form"  data-parsley-validate>
        <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","class"=>"form-control","value"=>$id), "id") ?>
        <div class="modal-body">
        
          <div class="form-row">
          <div class="form-group col-md-12">
              <label for="inputEmail4">Template Id<span class="tx-danger">*</span></label>
              
     
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control ","value"=>$template_id,"required"=>""), "template_id");?>
            
            </div>
          
            <div class="form-group col-md-12">
              <label for="inputEmail4">Template Name<span class="tx-danger">*</span></label>
              
              <?php if($id!='')
{?>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control ","value"=>$name,"required"=>"","readonly"=>"readonly"), "name");?>
              <?php }else{?>
              
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control ","value"=>$name,"required"=>""), "name");?>
              <?php }?>
            </div>
          </div>
          
          <div class="form-row">
            <div class="form-group col-md-12">
              <label class="d-block">SMS Text *</label>
              
               <? $app->htmlBuilder->buildTag("textarea", array("rows"=>"4","class"=>"form-control ","value"=>$sms_text,"required"=>"","onkeyup"=>"count_ch(this.value)"), "sms_text");?>
              
              
              <p><span class="charcter">0</span> charcter</p>
              
            </div>
       </div>
       
       
       
       <div class="form-row">
            <div class="form-group col-md-12">
              <label class="d-block">SMS Text (Default)*</label>
              
              <?php if($id!='')
{?>
              
               <? $app->htmlBuilder->buildTag("textarea", array("rows"=>"4","class"=>"form-control ","value"=>$sms_text_system,"required"=>"","readonly"=>"readonly"), "sms_text_system");?>
               
              <?php }else{?>
              
               <? $app->htmlBuilder->buildTag("textarea", array("rows"=>"4","class"=>"form-control ","value"=>$sms_text_system,"required"=>""), "sms_text_system");?>
               
              
              
              <?php }?>
              
               
              
              
              
              
            </div>
       </div>
       
       
       
          
          
          <div class="form-row">
          
          <div class="form-group col-md-6">
              <label for="inputEmail4">Status</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","selected"=>$status, "values"=>array("Active"=>"Active","Inactive"=>"Inactive"),"required"=>""), "status") ;?>
            </div>
          </div>
          
          
          
          
          
          
          
          <div class="form-row">
          
          <div class="form-group col-md-12">
              <p style="margin-left:20px">Note : <strong>160</strong> charcter = <strong>1</strong> sms</p>
            
            
          </div>
          
          
          
        </div>
          
          
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary tx-13 submit_btn sms_data_modal_submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
