<?php
$id=$app->getGetVar('id');

if($id!='')
{
	//Edit Banner
	$obj_brand = $app->load_model("category_banner");
	$result = $obj_brand->execute("SELECT", false, "", "id='".$id."'");			

	$link=$result[0]['link'];
	$sort_order=$result[0]['sort_order'];
	$display=$result[0]['display'];
	$status=$result[0]['status'];
	$title=$result[0]['title'];
	$category_id=$result[0]['category_id'];

	$folder='category_banner';
	$image=$result[0]["image"];
	$offer_banner_img=$app->utility->get_image_path($image,$folder,'thumb');

  $app_image=$result[0]["app_image"];
  $app_image=$app->utility->get_image_path($app_image,$folder,'thumb');

}
else
{
	//Add Banner
	$offer_banner_img='images/img_upl.gif';	
  $app_image='images/img_upl.gif'; 

  $sort_order=$app->utility->sort_order_count('category_banner');
}


$obj_model_brand = $app->load_model("category");
$rs = $obj_model_brand->execute("SELECT", false,"","status='Active'");
$records1 = array();
$records1[''] = " Select Category";
for($i=0;$i<count($rs);$i++){
$records1[$rs[$i]['id']] = $rs[$i]['category_name'];
}

?>

<div class="modal fade" id="modal_offer_banner_addedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">Offer Banner Form</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <form method="post" name="offer_banner_form" id="offer_banner_form"  data-parsley-validate>
        <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","value"=>$id), "id") ?>
        <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","value"=>$sort_order), "sort_order") ?>
        <div class="modal-body">
          <div class="form-row">
          
            <div class="form-group col-md-12">
              <label for="inputEmail4">Category</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control select2","selected"=>$category_id, "values"=>$records1), "category_id") ;?>
            </div>
          
            

            <div class="form-group col-md-12">
              <label for="inputEmail4">Title</label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control","value"=>$title), "title") ?>
            </div>

          
            <div class="form-group col-md-6">
              <label for="inputEmail4">Image for website (1000x1000)</label>
              <div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="fileupload-new" > <img src="<?=$offer_banner_img;?>" class="up_img"> </div>
                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                <div> <span class="btn btn-file btn-default"> <span class="mg-t-5 fileupload-new btn btn-white btn-xs">Select image</span><span class="fileupload-exists btn btn-white btn-xs">Change</span>
                  <? $app->htmlBuilder->buildTag("input", array("type"=>"file","class"=>""), "category_banner1") ?>
                  </span> <a href="#" class="btn btn-xs fileupload-exists btn-white" data-dismiss="fileupload">Remove</a> </div>
              </div>
            </div> 

            <div class="form-group col-md-6">
              <label for="inputEmail4">Image for App (1000x1000)</label>
              <div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="fileupload-new" > <img src="<?=$app_image;?>" class="up_img"> </div>
                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                <div> <span class="btn btn-file btn-default"> <span class="mg-t-5 fileupload-new btn btn-white btn-xs">Select image</span><span class="fileupload-exists btn btn-white btn-xs">Change</span>
                  <? $app->htmlBuilder->buildTag("input", array("type"=>"file","class"=>""), "app_image") ?>
                  </span> <a href="#" class="btn btn-xs fileupload-exists btn-white" data-dismiss="fileupload">Remove</a> </div>
              </div>
            </div> 

            
             <div class="form-group col-md-6">
              <label for="inputEmail4">Display</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","selected"=>$display, "values"=>array("All"=>"All","Website"=>"Website","App"=>"App"),"required"=>""), "display") ;?>
            </div>
              <div class="form-group col-md-6">
              <label for="inputEmail4">Status</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","selected"=>$status, "values"=>array("Active"=>"Active","Inactive"=>"Inactive"),"required"=>""), "status") ;?>
            </div>
            
          
          </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary tx-13 submit_btn offer_banner_modal_submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
