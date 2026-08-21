<?php
$id=$app->getGetVar('id');
if($id!='')
{
	//Edit Banner
	$obj_brand = $app->load_model("item_diseases_banner");
	$result = $obj_brand->execute("SELECT", false, "", "id='".$id."'");
	$link=$result[0]['link'];
	$sort_id=$result[0]['sort_id'];
	$city_ids=$result[0]['city_ids'];
  $item_diseases_ids=$result[0]['item_diseases_ids'];
	$banner_link=$result[0]['banner_link'];
	$status=$result[0]['status'];
	$name=$result[0]['name'];
	$folder='item_diseases_banner';
	//Mobile
	$image=$result[0]["banner_image"];
	$banner_img=$app->utility->get_image_path($image,$folder,'large');
	//image
	$img_name=$result[0]["mobile_image"];
	$log_img=$app->utility->get_image_path($img_name,$folder,'large');
}
else
{
	//Add Banner
	$log_img='images/img_upl.gif';
	$banner_img='images/img_upl.gif';
}
$obj_model_tble = $app->load_model("city");
$rs_work = $obj_model_tble->execute("SELECT",false,"","city.status='Active'","city.sort_order ASC");

$obj_model_item_category = $app->load_model("item_diseases");
$item_diseases = $obj_model_item_category->execute("SELECT",false,"","item_diseases.status='Active'","item_diseases.sort_order ASC");

?>
<div class="modal fade" id="modal_item_diseases_banner_addedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">Item Diseases Banner Form</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <form method="post" name="item_diseases_banner_form" id="item_diseases_banner_form"  data-parsley-validate>
        <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","class"=>"form-control","value"=>$id), "id") ?>
        <div class="modal-body">
          <div class="form-row">
            
            <div class="form-group col-md-12">
              <label for="inputEmail4">Item Diseases</label>
                <select class="form-control select2" multiple="multiple" name="item_diseases[]" >
                  <? for($i=0;$i<count($item_diseases);$i++)
                  {
                  $micro_items=explode(',',$item_diseases_ids);
                  ?>
                <option  value="<?=$item_diseases[$i]['id']; ?>" <?  for($j=0;$j<count($micro_items);$j++)
					      {if($item_diseases[$i]['id']==trim($micro_items[$j])){echo 'selected';}} ?>>
					      <?=$item_diseases[$i]['name']; ?>
                </option>
                <?php } ?>
               </select>
               <span style="font-size: 12px;">Make Blank for All Diseases.</span>
            </div>

            <div class="form-group col-md-12">
              <label for="inputEmail4">City</label>
                <select class="form-control select2" multiple="multiple" name="work_item[]" >
                  <? for($i=0;$i<count($rs_work);$i++)
                  {
                  $micro_items=explode(',',$city_ids);
                  ?>
                <option  value="<?=$rs_work[$i]['id']; ?>" <?  for($j=0;$j<count($micro_items);$j++)
					      {if($rs_work[$i]['id']==trim($micro_items[$j])){echo 'selected';}} ?>>
					      <?=$rs_work[$i]['name']; ?>
                </option>
                <?php } ?>
               </select>
               <span style="font-size: 12px;">Make Blank for All city.</span>
            </div>
            <div class="form-group col-md-6">
              <label for="inputEmail4">Web Banner Image</label>
              <div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="fileupload-new" > <img src="<?=$banner_img;?>" class="up_img"> </div>
                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                <div> <span class="btn btn-file btn-default"> <span class="mg-t-5 fileupload-new btn btn-white btn-xs">Select image</span><span class="fileupload-exists btn btn-white btn-xs">Change</span>
                  <? $app->htmlBuilder->buildTag("input", array("type"=>"file","class"=>""), "banner_image") ?>
                  </span> <a href="#" class="btn btn-xs fileupload-exists btn-white" data-dismiss="fileupload">Remove</a> </div>
              </div>
            </div>
            <div class="form-group col-md-6">
              <label for="inputEmail4">App Banner Image</label>
              <div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="fileupload-new" > <img src="<?=$log_img;?>" class="up_img"> </div>
                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                <div> <span class="btn btn-file btn-default"> <span class="mg-t-5 fileupload-new btn btn-white btn-xs">Select image</span><span class="fileupload-exists btn btn-white btn-xs">Change</span>
                  <? $app->htmlBuilder->buildTag("input", array("type"=>"file","class"=>""), "mobile_banner") ?>
                  </span> <a href="#" class="btn btn-xs fileupload-exists btn-white" data-dismiss="fileupload">Remove</a> </div>
              </div>
            </div>
            <div class="form-group col-md-12">
              <label for="inputEmail4">Link</label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control","value"=>$banner_link), "banner_link") ?>
            </div>
            <div class="form-group col-md-6">
              <label for="inputEmail4">Sort Id</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control ","selected"=>$sort_id, "values"=>$app->utility->sort_order('item_diseases_banner'),"required"=>""), "sort_id") ;?>
            </div>
            <div class="form-group col-md-6">
              <label for="inputEmail4">Status</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","selected"=>$status, "values"=>array("Active"=>"Active","Inactive"=>"Inactive"),"required"=>""), "status") ;?>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary tx-13 submit_btn item_diseases_banner_modal_submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
