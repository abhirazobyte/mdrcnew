<?php
$id=$app->getGetVar('id');
if($id!='')
{
	//Edit Banner
	$obj_brand = $app->load_model("item_category_banner");
	$result = $obj_brand->execute("SELECT", false, "", "id='".$id."'");
	$link=$result[0]['link'];
	$sort_id=$result[0]['sort_id'];
	$city_ids=$result[0]['city_ids'];
  $item_category_ids=$result[0]['item_category_ids'];
  $item_department_ids=$result[0]['item_department_ids'];
	$banner_link=$result[0]['banner_link'];
	$status=$result[0]['status'];
	$name=$result[0]['name'];
	$folder='item_category_banner';
	//Mobile
	$image=$result[0]["banner_image"];
	//$banner_img=$app->utility->get_image_path($image,$folder,'large');
	//image
	$img_name=$result[0]["mobile_image"];
	//$log_img=$app->utility->get_image_path($img_name,$folder,'large');
}
else
{
	//Add Banner
	$log_img='images/img_upl.gif';
	$banner_img='images/img_upl.gif';
}
$obj_model_tble = $app->load_model("city");
$rs_work = $obj_model_tble->execute("SELECT",false,"","city.status='Active'","city.sort_order ASC");

$obj_model_item_category = $app->load_model("item_category");
$item_category = $obj_model_item_category->execute("SELECT",false,"","item_category.status='Active'","item_category.sort_order ASC");

$obj_model_item_department = $app->load_model("item_department");
$item_department = $obj_model_item_department->execute("SELECT",false,"","item_department.status='Active'","item_department.sort_order ASC");

$file_class = "fileupload-new";
$file_class2 = "fileupload-new";
if ($id != '') {
  if ($image != '') {
    $banner_img=$app->utility->get_image_path($image,$folder,'large');
    $file_class = "fileupload-exists";
  } else {
    $banner_img = 'images/img_upl.gif';
  }

  if ($img_name != '') {
    $log_img=$app->utility->get_image_path($img_name,$folder,'large');
    $file_class2 = "fileupload-exists";
  } else {
    $log_img = 'images/img_upl.gif';
  }
} else {
  $log_img='images/img_upl.gif';
	$banner_img='images/img_upl.gif';
}
?>
<div class="modal fade" id="modal_item_category_banner_addedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">Item Category Banner Form</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <form method="post" name="item_category_banner_form" id="item_category_banner_form"  data-parsley-validate>
        <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","class"=>"form-control","value"=>$id), "id") ?>
        <div class="modal-body">
          <div class="form-row">

            <div class="form-group col-md-12">
              <label for="inputEmail4">Department</label>
                <select class="form-control select2" multiple="multiple" name="department_item[]" >
                  <? for($i=0;$i<count($item_department);$i++)
                  {
                  $micro_items=explode(',',$item_department_ids);
                  ?>
                <option  value="<?=$item_department[$i]['id']; ?>" <?  for($j=0;$j<count($micro_items);$j++)
					      {if($item_department[$i]['id']==trim($micro_items[$j])){echo 'selected';}} ?>>
					      <?=$item_department[$i]['name']; ?>
                </option>
                <?php } ?>
               </select>
               <span style="font-size: 12px;">Blank for All Department.</span>
            </div>
            
            <div class="form-group col-md-12">
              <label for="inputEmail4">Item Category</label>
                <select class="form-control select2" multiple="multiple" name="category_item[]" >
                  <? for($i=0;$i<count($item_category);$i++)
                  {
                  $micro_items=explode(',',$item_category_ids);
                  ?>
                <option  value="<?=$item_category[$i]['id']; ?>" <?  for($j=0;$j<count($micro_items);$j++)
					      {if($item_category[$i]['id']==trim($micro_items[$j])){echo 'selected';}} ?>>
					      <?=$item_category[$i]['name']; ?>
                </option>
                <?php } ?>
               </select>
               <span style="font-size: 12px;">Make Blank for All Category.</span>
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
              <div class="fileupload <?= $file_class2; ?>" data-provides="fileupload">
                <div class="fileupload-new"> <img src="images/img_upl.gif" class="up_img"> </div>
                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 150px; line-height: 20px;"> <img src="<?= $banner_img; ?>" /> </div>
                <div>
                  <span class="btn btn-file btn-default">
                    <span class="fileupload-new btn btn-white btn-xs">Select image</span>
                    <span class="fileupload-exists btn btn-white btn-xs">Change</span>
                    <? $app->htmlBuilder->buildTag("input", array("type" => "file", "class" => ""), "banner_image") ?>
                  </span>
                  <a href="#" class="btn btn-xs fileupload-exists btn-white" data-dismiss="fileupload">Remove</a>
                </div>
              </div>
            </div>
            <div class="form-group col-md-6">
              <label for="inputEmail4">App Banner Image</label>
              <div class="fileupload <?= $file_class2; ?>" data-provides="fileupload">
                <div class="fileupload-new"> <img src="images/img_upl.gif" class="up_img"> </div>
                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 150px; line-height: 20px;"> <img src="<?= $log_img; ?>" /> </div>
                <div>
                  <span class="btn btn-file btn-default">
                    <span class="fileupload-new btn btn-white btn-xs">Select image</span>
                    <span class="fileupload-exists btn btn-white btn-xs">Change</span>
                    <? $app->htmlBuilder->buildTag("input", array("type" => "file", "class" => ""), "mobile_banner") ?>
                  </span>
                  <a href="#" class="btn btn-xs fileupload-exists btn-white" data-dismiss="fileupload">Remove</a>
                </div>
              </div>
              
            </div>
            <div class="form-group col-md-12">
              <label for="inputEmail4">Link</label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control","value"=>$banner_link), "banner_link") ?>
            </div>
            <div class="form-group col-md-6">
              <label for="inputEmail4">Sort Id</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control ","selected"=>$sort_id, "values"=>$app->utility->sort_order('item_category_banner'),"required"=>""), "sort_id") ;?>
            </div>
            <div class="form-group col-md-6">
              <label for="inputEmail4">Status</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","selected"=>$status, "values"=>array("Active"=>"Active","Inactive"=>"Inactive"),"required"=>""), "status") ;?>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary tx-13 submit_btn item_category_banner_modal_submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
