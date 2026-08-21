<?php
$id=$app->getGetVar('id');
if($id!='')
{
	$obj_brand = $app->load_model("city");
	$result = $obj_brand->execute("SELECT", false, "", "id='".$id."'");
	$id=$result[0]['id'];
	$name=$result[0]['name'];
	$status=$result[0]['status'];
  $api_city_id=$result[0]['api_city_id'];
  $sort_order=$result[0]['sort_order'];
  $state_id=$result[0]['state_id'];
  $image=$result[0]["image"];
  $certi_image=$result[0]["certi_image"];
  $phone=$result[0]["phone"];
}
$file_class="fileupload-new";
$certi_file_class="fileupload-new";
$img='images/img_upl.gif';
if($id!='')
{
	 if($image!='' &&  file_exists(ABS_PATH."/".$app->get_user_config("city").'/'.$image))
	 {
		$img='../uploads/city/thumb'.$image;
		$file_class="fileupload-exists";
	 }

   if($certi_image!='' &&  file_exists(ABS_PATH."/".$app->get_user_config("city").'/'.$certi_image))
	 {
		$certi_img='../uploads/city/thumb'.$certi_image;
		$certi_file_class="fileupload-exists";
	 }
}

$obj_model_state = $app->load_model("state");
$rs = $obj_model_state->execute("SELECT", false,"","status='Active'");
$records1 = array();
$records1[''] = " Select State";
for($i=0;$i<count($rs);$i++)
{
  $records1[$rs[$i]['id']] = $rs[$i]['name'];
}
?>
<div class="modal fade" id="modal_city_addedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">City Form</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <form method="post" name="city_form" id="city_form"  data-parsley-validate>
        <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","class"=>"form-control","value"=>$id), "id") ?>
        <div class="modal-body">
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputEmail4">State<span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control select2","selected"=>$state_id, "values"=>$records1,"required"=>""), "state_id") ;?>
            </div>
            <div class="form-group col-md-6">
              <label for="inputEmail4">City Name<span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control ","value"=>$name,"required"=>""), "name");?>
            </div>
            <div class="form-group col-md-4">
              <label for="inputEmail4">City Api Id<span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control numbersOnly","value"=>$api_city_id,"required"=>""), "api_city_id");?>
            </div>
            <div class="form-group col-md-4">
              <label for="inputEmail4">Sort Order</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control ","selected"=>$sort_order, "values"=>$app->utility->sort_order('city'),"required"=>""), "sort_order") ;?>
            </div>
            <div class="form-group col-md-4">
              <label for="inputEmail4">Status</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","selected"=>$status, "values"=>array("Active"=>"Active","Inactive"=>"Inactive"),"required"=>""), "status") ;?>
            </div>
            <div class="form-group col-md-6">
            <label for="inputEmail4">Image (Size : 500 x 500 Px.)</label>
              <div class="fileupload <?=$file_class;?>" data-provides="fileupload">
                <div class="fileupload-new" > <img src="images/img_upl.gif" class="up_img"> </div>
                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 150px; line-height: 20px;"> <img src="<?=$img;?>" />  </div>
                <div>
                	<span class="btn btn-file btn-default">
                    	<span class="fileupload-new btn btn-white btn-xs">Select image</span>
                    	<span class="fileupload-exists btn btn-white btn-xs">Change</span>
                    	<? $app->htmlBuilder->buildTag("input", array("type"=>"file","class"=>""), "item_city_image") ?>
                    </span>
                    <a href="#" class="btn btn-xs fileupload-exists btn-white" data-dismiss="fileupload">Remove</a>
                </div>
              </div>
  		      </div>
            <div class="form-group col-md-6">
            <label for="inputEmail4">Certificate Image </label>
              <div class="fileupload <?=$certi_file_class;?>" data-provides="fileupload">
                <div class="fileupload-new" > <img src="images/img_upl.gif" class="up_img"> </div>
                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 150px; line-height: 20px;"> <img src="<?=$certi_img;?>" />  </div>
                <div>
                	<span class="btn btn-file btn-default">
                    	<span class="fileupload-new btn btn-white btn-xs">Select image</span>
                    	<span class="fileupload-exists btn btn-white btn-xs">Change</span>
                    	<? $app->htmlBuilder->buildTag("input", array("type"=>"file","class"=>""), "item_city_certi_image") ?>
                    </span>
                    <a href="#" class="btn btn-xs fileupload-exists btn-white" data-dismiss="fileupload">Remove</a>
                </div>
              </div>
  		      </div>
            <div class="form-group col-md-6">
              <label for="inputEmail4">City Phone Number<span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control ","value"=>$phone,"required"=>""), "phone");?>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary tx-13 submit_btn city_modal_submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
