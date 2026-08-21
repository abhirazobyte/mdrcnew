<?php
$id=$app->getGetVar('id');

if($id!='')
{
	$obj_brand = $app->load_model("user");
	$result = $obj_brand->execute("SELECT", false, "", "id='".$id."'");			
	
	$id=$result[0]['id'];
	$name=$result[0]['name'];
	$email=$result[0]['email'];
	
	$city_id=$result[0]['city_id'];
	
	
	$mobilephone=$result[0]['mobilephone'];
	$group_id=$result[0]['group_id'];
	$billing_address_line1=$result[0]['billing_address_line1'];
	$billing_city=$result[0]['billing_city'];
	$area_id=$result[0]['area_id'];
	$otp_verified=$result[0]['otp_verified'];
	$billing_zip_code=$result[0]['billing_zip_code'];
	$billing_state=$result[0]['billing_state'];
	$billing_country=$result[0]['billing_country'];
	$date_of_birth=$result[0]['date_of_birth'];
	$mrg_anniversary=$result[0]['mrg_anniversary'];
}

$obj_model_brand = $app->load_model("user_group");
$rs = $obj_model_brand->execute("SELECT", false,"","status='Active'");

$obj_model_brand = $app->load_model("area");
$rs = $obj_model_brand->execute("SELECT", false,"","status='Active'");
$records1 = array();
$records1[''] = " Select Area";
for($i=0;$i<count($rs);$i++)
{
	$records1[$rs[$i]['id']] = $rs[$i]['name'];
}

$obj_model_city= $app->load_model("city");
$rs_city= $obj_model_city->execute("SELECT", false,"","status='Active'");
$records_city= array();
$records_city[''] = " Select City";
for($i=0;$i<count($rs_city);$i++)
{
	$records_city[$rs_city[$i]['id']] = $rs_city[$i]['name'];
}

$obj_model_zipcode= $app->load_model("zipcode");
$rs_zipcode= $obj_model_zipcode->execute("SELECT", false,"","status='Active'");
$records2= array();
$records2[''] = " Select Zipcode";
for($i=0;$i<count($rs_zipcode);$i++)
{
	$records2[$rs_zipcode[$i]['name']] = $rs_zipcode[$i]['name'];
}
?>

<div class="modal fade" id="modal_user_addedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">Add User Form</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <form method="post" name="user_form" id="user_form"  data-parsley-validate>
        <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","class"=>"form-control","value"=>$id), "id") ?>
        <div class="modal-body">
        
          <div class="form-row">
          
          
            <div class="form-group col-md-12">
              <label for="inputEmail4">Name<span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control ","value"=>$name,"required"=>""), "name");?>
            </div>
            
            
            <div class="form-group col-md-6">
              <label for="inputEmail4">Email</label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control ","value"=>$email), "email");?>
            </div>
            
              <div class="form-group col-md-6">
              <label for="inputEmail4">Phone <span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control ","value"=>$mobilephone,"required"=>""), "mobilephone");?>
            </div>
            
             <div class="form-group col-md-6">
              <label for="inputEmail4">Date of Birth</label>

                <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control","placeholder"=>"DD-MM-YYYY","data-date-format"=>"dd-mm-yyyy","value"=>$date_of_birth), "date_of_birth") ;?>
            </div>
            
             <div class="form-group col-md-6">
              <label for="inputEmail4">Marriage Anniversary</label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control","placeholder"=>"DD-MM-YYYY","data-date-format"=>"dd-mm-yyyy","value"=>$mrg_anniversary), "mrg_anniversary") ;?>
              


            </div>
            
            <?php if($id!='' && $otp_verified=='No'){?>
             <div class="form-group col-md-6">
              <label for="inputEmail4">OTP Verify? <span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","selected"=>$otp_verified, "values"=>array("No"=>"No","Yes"=>"Yes")), "otp_verified1") ;?>
            </div>
			  <?php }?>          
          </div>
          
         
          
          <div class="form-row">
            <div class="form-group col-md-12">
             <label for="inputEmail4">Group </label>
       	 <select class="form-control select2" multiple="multiple" name="group_ids[]">
        	 <? for($i=0;$i<count($rs);$i++)
                {
                $micro_items=explode(',',$group_id);
                ?>
                <option  value="<?=$rs[$i]['id']; ?>" <?  for($j=0;$j<count($micro_items);$j++)
					{if($rs[$i]['id']==trim($micro_items[$j])){echo 'selected';}} ?>>
					<?=$rs[$i]['name']; ?>
                </option>
                <?php } ?>
         </select>
        </div>
       </div>
          
          
          
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="inputEmail4">Address</label>
               <? $app->htmlBuilder->buildTag("textarea", array("type"=>"text","class"=>"form-control","value"=>$billing_address_line1), "billing_address_line1") ?>
            </div>   
            
            <div class="form-group col-md-12">
              <label for="inputEmail4">Area</label>
               <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control select2","selected"=>$area_id, "values"=>$records1,"required"=>""), "area_id") ;?>
            </div>
            
              <div class="form-group col-md-6">
              <label for="inputEmail4">City</label>
               <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control select2","onchange"=>"GetCityDetail(this.value)","selected"=>$city_id, "values"=>$records_city,"required"=>""), "city_id") ;?>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","id"=>"billing_city","value"=>$billing_city), "billing_city");?>
            </div>
            
             <div class="form-group col-md-6">
              <label for="inputEmail4">Pincode</label>
                <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control select2","selected"=>$billing_zip_code, "values"=>$records2), "billing_zip_code") ;?>
            </div>
            
             <div class="form-group col-md-6">
              <label for="inputEmail4">State </label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control","id"=>"billing_state","readonly"=>"readonly","value"=>$billing_state), "billing_state");?>
            </div>
            
             <div class="form-group col-md-6">
              <label for="inputEmail4">Country </label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control","value"=>"India"), "billing_country");?>
            </div>
          </div>
          
          
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary tx-13 submit_btn user_modal_submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>

$('#date_of_birth').datepicker({ 
	dateFormat: 'dd-mm-yy',
	})
	
$('#mrg_anniversary').datepicker({ 
	dateFormat: 'dd-mm-yy',
	})
	
function GetCityDetail(city_id)
{
	$.ajax({
	  type: "POST",
	  dataType: 'json',
	  url: "scripts/ajax/index.php",
	  data: "method=user&actionType=GetCityDetail&getid="+city_id,
	  success: function(responseData)
	  {
	  	$("#billing_state").val(responseData.state_name);
		$("#billing_city").val(responseData.city_name);
	  }							  
	});
		
}	
</script>