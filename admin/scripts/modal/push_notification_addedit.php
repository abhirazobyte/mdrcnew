<?php
$id=$app->getGetVar('id');
if($id!='')
{
	//Edit push_notification
	$obj_brand = $app->load_model("push_notification");
	$result = $obj_brand->execute("SELECT", false, "", "id='".$id."'");
  $title=$result[0]['title'];
	$massage=$result[0]['message'];
	
	$folder='push_notification';
	//image
	$image=$result[0]["image"];
	$push_notification_img=$app->utility->get_image_path($image,$folder,'large');
}
else
{
	//Add push_notification
	$log_img='images/img_upl.gif';
	$push_notification_img='images/img_upl.gif';
}
$class.=$result[0]['type']=='Radiology'?"d-none":"";
$class.=$result[0]['type']=='Pathology'?"d-none":"";
$obj_model_tble = $app->load_model("city");
$rs_work = $obj_model_tble->execute("SELECT",false,"","city.status='Active'","city.sort_order ASC");
?>
<div class="modal fade" id="modal_push_notification_addedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">Notification Form</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <form method="post" name="push_notification_form" id="push_notification_form"  data-parsley-validate>
        <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","class"=>"form-control","value"=>$id), "id") ?>
        <div class="modal-body">
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="inputEmail4">Title</label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control","value"=>$title,"required"=>""), "title") ;?>
            </div>
            <div class="form-group col-md-12 d-none">
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
            <div class="form-group col-md-12">
              <label for="inputEmail4">Description</label>
              <? $app->htmlBuilder->buildTag("textarea", array("class"=>"form-control","value"=>$massage,"required"=>""), "message") ;?>
            </div>
            <div class="form-group col-md-6">
              <label for="inputEmail4">Image</label>
              <div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="fileupload-new" > <img src="<?=$push_notification_img;?>" class="up_img"> </div>
                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                <div> <span class="btn btn-file btn-default"> <span class="mg-t-5 fileupload-new btn btn-white btn-xs">Select image</span><span class="fileupload-exists btn btn-white btn-xs">Change</span>
                  <? $app->htmlBuilder->buildTag("input", array("type"=>"file","class"=>""), "push_notification_image") ?>
                  </span> <a href="#" class="btn btn-xs fileupload-exists btn-white" data-dismiss="fileupload">Remove</a> </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-6">
              <label for="inputEmail4">Select Type</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","onchange"=>"getType();","selected"=>$result[0]['type'],"values"=>array(""=>"Select","Item"=>"Item","Category"=>"Category","Diseases"=>"Diseases","Radiology"=>"Radiology","Pathology"=>"Pathology"),"required"=>""), "type") ;?>
            </div>
            <div class="form-group col-md-6 Type <?=$class?>">
              <label for="inputEmail4">Search</label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control"), "search") ;?>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","class"=>"form-control","value"=>$result[0]['search_id']), "search_id") ;?>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary tx-13 submit_btn push_notification_modal_submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
