<?php
$id=$app->getGetVar('id');

if($id!='')
{
	$obj_brand = $app->load_model("category");
	$result = $obj_brand->execute("SELECT", false, "", "id='".$id."'");			
	
	$id=$result[0]['id'];
	$offer_title=$result[0]['offer_title'];
	$offer_short_description=$result[0]['offer_short_description'];	
	$offer_image_app=$result[0]['offer_image_app'];
	$offer_image_website=$result[0]['offer_image_website'];

  $offer_color=$result[0]['offer_color'];

	
	$condition="and id!='".$id."'";
	
	$folder1='category_image';
	//Mobile
	$image=$result[0]["offer_image_website"];
	$offer_image_website=$app->utility->get_image_path($image,$folder1,'thumb');
	
	
	$folder='category_icon';
	$image1=$result[0]["offer_image_app"];
	$offer_image_app=$app->utility->get_image_path($image1,$folder,'thumb');
	
}
else
{

	$offer_image_website='images/img_upl.gif';	
	$category_offer='images/img_upl.gif';	
}

		
?>

<div class="modal fade" id="modal_category_offer_addedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">Category Offer Form</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <form method="post" name="category_offer_form" id="category_offer_form"  data-parsley-validate>
        <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","class"=>"form-control","value"=>$id), "id") ?>
        <div class="modal-body">
          <div class="form-row">
          
          <div class="form-group col-md-8">
              <label for="inputEmail4">Offer Title<span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control ","value"=>$offer_title,"required"=>""), "offer_title");?>
            </div>

              <div class="form-group col-md-4">
              <label for="inputEmail4">Offer Color<span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control ","value"=>$offer_color,"required"=>""), "offer_color");?>
            </div>



          </div>
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="inputEmail4">Offer Short Description</label>
              <? $app->htmlBuilder->buildTag("textarea", array("type"=>"text","class"=>"form-control","value"=>$offer_short_description), "offer_short_description");?>
            </div>
          </div>
          
          <div class="form-row">

            <div class="form-group col-md-6">
              <label for="inputEmail4">Offer Image for website (1000px X 1000px)</label>
              <div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="fileupload-new" > <img src="<?=$offer_image_website;?>" id="image_<?=$id?>_offer_image_website" class="up_img"> </div>
                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                <div> <span class="btn btn-file btn-default"> <span class="mg-t-5 fileupload-new btn btn-white btn-xs">Select image</span><span class="fileupload-exists btn btn-white btn-xs">Change</span>
                  <? $app->htmlBuilder->buildTag("input", array("type"=>"file","class"=>""), "offer_image_website") ?>
                  </span> <a href="#" class="btn btn-xs fileupload-exists btn-white" data-dismiss="fileupload">Remove</a>
                  
                   <?php if($id!='' && $image1!=''){ ?>
                       <button id="btn_<?=$id?>_offer_image_website" class="btn btn-xs btn-outline-danger" onclick="remove_image('<?=$id?>','category','offer_image_website','offer_image_website')" type="button">Remove</button>
                      <?php }?>
                      
                      
                   </div>
              </div>
            </div>

            <div class="form-group col-md-6">
              <label for="inputEmail4">Offer Image for App (1000px X 1000px)</label>
              <div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="fileupload-new" > <img id="image_<?=$id?>_offer_image_app" src="<?=$offer_image_app;?>" class="up_img"> </div>
                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                <div> <span class="btn btn-file btn-default"> <span class="mg-t-5 fileupload-new btn btn-white btn-xs">Select image</span><span class="fileupload-exists btn btn-white btn-xs">Change</span>
                  <? $app->htmlBuilder->buildTag("input", array("type"=>"file","class"=>""), "offer_image_app") ?>
                  </span> <a href="#" class="btn btn-xs fileupload-exists btn-white" data-dismiss="fileupload">Remove</a>
                  
                    <?php if($id!='' && $image!=''){ ?>
                       <button id="btn_<?=$id?>_offer_image_app" class="btn btn-xs btn-outline-danger" onclick="remove_image('<?=$id?>','category','offer_image_app','offer_image_app')" type="button">Remove</button>
                      <?php }?>
                      
                   </div>
              </div>
            </div>
            


          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary tx-13 submit_btn category_offer_modal_submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
