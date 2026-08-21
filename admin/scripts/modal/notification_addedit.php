<?php

$id=$app->getGetVar('id');


if($id!='')

{

	//Edit Banner

	$obj_brand = $app->load_model("push_notification");

	$result = $obj_brand->execute("SELECT", false, "", "id='".$id."'");			



	//$youtube_url=$result[0]['youtube_url'];

	$title=$result[0]['title'];

	$message=$result[0]['message'];
	
	$product_id=$result[0]['product_id'];

	

	$folder='push_image';

	




	//Mobile

	$image=$result[0]["image"];

	$notification_img=$app->utility->get_image_path($image,$folder,'thumb');

	

}

else

{

	$notification_img='images/img_upl.gif';	

}
?>



<div class="modal fade" id="modal_notification_addedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">

    <div class="modal-content tx-14">

      <div class="modal-header">

        <h6 class="modal-title" id="exampleModalLabel2">Notification Form</h6>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>

      </div>

      <form method="post" name="notification_form" id="notification_form"  data-parsley-validate>

        <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","class"=>"form-control","value"=>$id), "id") ?>
        
        <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","class"=>"form-control","value"=>$product_id), "product_id") ?>

        <div class="modal-body">

	
    <div class="form-row">

            <div class="form-group col-md-12">

              <label for="inputEmail4">Title</label>

              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control ","value"=>$title,"required"=>""), "title") ;?>

            </div>

            

            </div>


<div class="form-row">

            <div class="form-group col-md-12">

              <label for="inputEmail4">Massage</label>

              <? $app->htmlBuilder->buildTag("textarea", array("type"=>"text","class"=>"form-control ","value"=>$message,"required"=>""), "message") ;?>

            </div>

            

            </div>


	<div class="form-row">

        

      <div class="form-group col-md-6">

        <label for="inputEmail4">Image</label>

        <div class="fileupload fileupload-new" data-provides="fileupload">

            <div class="fileupload-new" >

            <img src="<?=$notification_img;?>" class="up_img">

            </div>

            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>

            <div>

            <span class="btn btn-file btn-default">

            <span class="mg-t-5 fileupload-new btn btn-white btn-xs">Select image</span><span class="fileupload-exists btn btn-white btn-xs">Change</span><? $app->htmlBuilder->buildTag("input", array("type"=>"file","class"=>""), "notification_image") ?></span>

            <a href="#" class="btn btn-xs fileupload-exists btn-white" data-dismiss="fileupload">Remove</a>

            </div>

        </div>

  		  </div>


		

            
        


          </div>

          

          


		 	<div class="form-group row"  style="display:none;">
              <div class="col-lg-12">
                <label for="inputEmail4">Product</label>
                <div class="input-group">
                  <input type="text" id="product" name="product" class="form-control" placeholder="Phone Number"  autocomplete="off">
              
                    <div class="input-group-append">
                    <button class="btn btn-outline-light" type="button" id="button-addon2" onclick="remove_data()"  title="Change Product"><i class="fa fa-trash"></i></button>
                  </div>
                  
                </div>
              </div>
            </div>
            
        

          <div class="form-row" style="display:none;">

            <div class="form-group col-md-12">

              <label for="inputEmail4">Link</label>

              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control ","value"=>$youtube_url), "youtube_url") ;?>

            </div>

            

            </div>

            

            

          

        </div>

        <div class="modal-footer">

          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>

          <button type="submit" class="btn btn-primary tx-13 submit_btn notification_modal_submit">Submit</button>

        </div>

      </form>

    </div>

  </div>

</div>

