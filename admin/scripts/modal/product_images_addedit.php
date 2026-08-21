<?php
$id=$app->getGetVar('id');
if($id!='')
{
	//Edit brand
	$obj_brand = $app->load_model("product_images");
	$obj_brand->join_table("product", "left", array("folder"), array("product_id"=>"id"));
	$result = $obj_brand->execute("SELECT", false, "", "product_images.id='".$id."'");			
	
	$name=$result[0]['name'];
	$sort_order=$result[0]['sort_order'];
	$status=$result[0]['status'];
	$slug=$result[0]['slug'];
	
	$folder='product/'.$result[0]['product_folder'].'/';
	//image
	$image=$result[0]["image"];

	$brand_img1=$app->utility->get_image_path($image,$folder,"");
	$brand_img=$brand_img1['large_image'];
}
else
{
	//Add brand
	$brand_img='images/img_upl.gif';	
}
?>

<div class="modal fade" id="modal_product_images_addedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">Image Form</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <form method="post" name="product_images_form" id="product_images_form"  data-parsley-validate>
        <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","class"=>"form-control","value"=>$id), "id") ?>
        <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","class"=>"form-control","value"=>$result[0]['product_folder']), "folder_name") ?>
        <div class="modal-body">


	 	 
         
          
          
          

	<div class="form-row">
      <div class="form-group col-md-6">
        <label for="inputEmail4">Image </label>
        <div class="fileupload fileupload-new" data-provides="fileupload">
            <div class="fileupload-new" >
            <img src="<?=$brand_img;?>" id="image_<?=$id?>_image" class="up_img">
            </div>
            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
            <div>
            <span class="btn btn-file btn-default">
            <span class="mg-t-5 fileupload-new btn btn-white btn-xs">Select image</span><span class="fileupload-exists btn btn-white btn-xs">Change</span><? $app->htmlBuilder->buildTag("input", array("type"=>"file","class"=>""), "brand_image") ?></span>
            <a href="#" class="btn btn-xs fileupload-exists btn-white" data-dismiss="fileupload">Remove</a>
            
           
           
            
            </div>
        </div>
  		  </div>
        
			
            
            <div class="form-group col-md-6">
              <label for="inputEmail4">Sort Order</label>
           		<? $app->htmlBuilder->buildTag("input", array("class"=>"form-control ","value"=>$sort_order, "type"=>"text","required"=>""), "sort_order") ;?>
            <br />
              <label for="inputEmail4">Status</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","selected"=>$status, "values"=>array("Active"=>"Active","Inactive"=>"Inactive"),"required"=>""), "status") ;?>
            </div>
          </div>
          

        
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary tx-13 submit_btn product_images_modal_submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
