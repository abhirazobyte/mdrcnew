<?php
$id=$app->getGetVar('id');

$getType=$app->getGetVar('getType');

if($id=='')
{
	$id=0;
}

$obj_model_user = $app->load_model("customer_address");
$rs_adderess = $obj_model_user->execute("SELECT",false,"","customer_id=".$_SESSION['MDRCCustID']." and id='".$id."'","id DESC limit 0,1");

$first_name=$rs_adderess[0]['first_name'];
$last_name=$rs_adderess[0]['last_name'];
$phone=$rs_adderess[0]['phone'];
$email=$rs_adderess[0]['email'];
$line1=$rs_adderess[0]['line1'];
$line2=$rs_adderess[0]['line2'];
$zipcode=$rs_adderess[0]['zipcode'];
$city=$rs_adderess[0]['city'];
$state_id=$rs_adderess[0]['state_id'];
$address_type=$rs_adderess[0]['address_type'];
$note=$rs_adderess[0]['note'];
$latitude=$rs_adderess[0]['latitude'];
$longitude=$rs_adderess[0]['longitude'];
$google_address=$rs_adderess[0]['google_address'];
$customer_address_register_date=$rs_adderess[0]['default_address'];
$id=$rs_adderess[0]['id'];

if($id>0)
{
	$add_title='Edit';
}
else
{
	$add_title='Add New';
}


$obj_model_state= $app->load_model("state");
$rs = $obj_model_state->execute("SELECT", false,"","status='Active'");
$records1 = array();
$records1[''] = " Select State";
for($i=0;$i<count($rs);$i++){
$records1[$rs[$i]['id']] = $rs[$i]['name'];
}


?>


<div class="popup-modals modal-ad-style">
  <div class="modal" id="address-modal" tabindex="-1" >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <div class="common-heading">
            <h4 class="mt0 mb0">Add New Address</h4>
          </div>
          <button type="button" class="closes" data-bs-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body ">
          <div class="form-block fdgn2 mt10 mb10">
             <form method="post" id="add_customer_address" name="add_customer_address">
             <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","value"=>$id), "id") ?>
            <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","value"=>$_SESSION['MDRCCustID']), "customer_id") ?>
              <div class="fieldsets row">
              <div class="col-md-6">
                	<label>First Name *</label>
                	<? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"required","value"=>$first_name), "first_name") ?>
                </div>
                
                <div class="col-md-6">
                	<label>Last Name *</label>
                	 <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"required","value"=>$last_name), "last_name") ?>
                </div>
              
                <div class="col-md-6">
                	<label>Mobile Number *</label>
                	<? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"numbersOnly numbers rounded required","value"=>$phone), "phone") ?>
                </div>
                
                <div class="col-md-12">
                	<label>Address (Area and Street) *</label>
                	
                    
               <? $app->htmlBuilder->buildTag("textarea", array("type"=>"text","class"=>"required","rows"=>"1","cols"=>"5","value"=>$line1), "line1") ?>
                </div>
                
                
                 <div class="col-md-6">
                <label for="" id="">State *</label>
                  <? $app->htmlBuilder->buildTag("select", array("class"=>"required","selected"=>$state_id, "values"=>$records1,"required"=>""), "state_id") ;?>
                  </div>
                
                <div class="col-md-6">
                  <label for="">City/District/Town *</label>
                  <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"required","value"=>$city), "city") ?>
                	
                    
                </div>
                
                
                <div class="col-md-6">
                	<label>Locality *</label>
                	<? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"required","value"=>$line2), "line2") ?>
                </div>
                <div class="col-md-6">
                 <label for="">Pincode</label>
                <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"required numbersOnly numbers","value"=>$zipcode), "zipcode") ?>
                	
                    
                </div>
                
                
                
              </div>
              <div class="fieldsets mt20 pb20 d-flex justify-content-center">
                <button type="submit" name="submit" class="lnk btn-main bg-btn w-auto me-2 ajax_modal_submit" >Save<span class="circle"></span></button>
                <a href="javascript:void(0)" class="btn-outline lnk ms-2" data-bs-dismiss="modal">Cancel<span class="circle"></span></a>
              </div>
              
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- The Modal -->


<script type="text/javascript">
   $('.numbersOnly').keyup(function () {
    if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
       this.value = this.value.replace(/[^0-9\.]/g, '');
    }
});

$("input.numbers").keypress(function(event) {

   return /\d/.test(String.fromCharCode(event.keyCode));

});
</script>