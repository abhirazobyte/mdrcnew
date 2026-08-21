<?php
$id=$app->getGetVar('id');

if($id!='')
{
	//Edit popup
	$obj_popup = $app->load_model("popup");
	$result = $obj_popup->execute("SELECT", false, "", "id='".$id."'");			
	
	$category_id=$result[0]['category_id'];
	$title=$result[0]['title'];
	$link=$result[0]['link'];
	$date=$result[0]['date'];

	$folder='popup_image';	
	//image
	$image=$result[0]["image"];
	$popup_img=$app->utility->get_image_path($image,$folder,'large');	
}
else
{
	//Add popup
	$log_img='images/img_upl.gif';
	$popup_img='images/img_upl.gif';	
}



$obj_model_brand = $app->load_model("category");
$rs = $obj_model_brand->execute("SELECT", false,"","status='Active'");
$records1 = array();
$records1[''] = " Select Category";
for($i=0;$i<count($rs);$i++){
$records1[$rs[$i]['id']] = $rs[$i]['category_name'];
}


?>

<div class="modal fade" id="modal_popup_addedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">Popup Image Form</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <form method="post" name="popup_form" id="popup_form"  data-parsley-validate>
        <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","class"=>"form-control","value"=>$id), "id") ?>
        <div class="modal-body">


	 	 
         
         <div class="form-row">
            <div class="form-group col-md-12">
              <label for="inputEmail4">Catgory</label>
              
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control select2","selected"=>$category_id, "values"=>$records1), "category_id") ;?>
            </div>
            
            
          </div>
          
          
         <div class="form-row">
            <div class="form-group col-md-12">
              <label for="inputEmail4">Link</label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control ","value"=>$link), "link") ;?>
            </div>
          </div>


	<div class="form-row">
      <div class="form-group col-md-6">
        <label for="inputEmail4">Image (Size : 1300 x 400 Px.)</label>
        <div class="fileupload fileupload-new" data-provides="fileupload">
            <div class="fileupload-new" >
            <img src="<?=$popup_img;?>" class="up_img">
            </div>
            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
            <div>
            <span class="btn btn-file btn-default">
            <span class="mg-t-5 fileupload-new btn btn-white btn-xs">Select image</span><span class="fileupload-exists btn btn-white btn-xs">Change</span><? $app->htmlBuilder->buildTag("input", array("type"=>"file","class"=>"","required"=>""), "image") ?></span>
            <a href="#" class="btn btn-xs fileupload-exists btn-white" data-dismiss="fileupload">Remove</a>
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
          <button type="submit" class="btn btn-primary tx-13 submit_btn popup_modal_submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
