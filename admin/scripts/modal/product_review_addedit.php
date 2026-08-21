<?php

$id=$app->getGetVar('id');


if($id!='')

{

	//Edit Banner

	$obj_brand = $app->load_model("product_review");

	$result = $obj_brand->execute("SELECT", false, "", "id='".$id."'");			



	$product_star=$result[0]['product_star'];

	$product_desc=$result[0]['product_desc'];

	$banner_link=$result[0]['banner_link'];
	$status=$result[0]['status'];
	$name=$result[0]['name'];

	

	$folder='main_banner_images';

	




	//Mobile

	$image=$result[0]["banner_image"];

	$banner_img=$app->utility->get_image_path($image,$folder,'thumb');

	

	

	//image		

	$img_name=$result[0]["mobile_image"];

	$log_img=$app->utility->get_image_path($img_name,$folder,'thumb');

}

else

{

	//Add Banner

	$log_img='images/img_upl.gif';

	$banner_img='images/img_upl.gif';	

}




$obj_model_brand = $app->load_model("category");

$rs = $obj_model_brand->execute("SELECT", false,"","status='Active'");

$records1 = array();

$records1[''] = " Select Category";

for($i=0;$i<count($rs);$i++){

$records1[$rs[$i]['id']] = $rs[$i]['category_name'];

}



?>

<div class="modal fade" id="modal_banner_addedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">Review Form</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <form method="post" name="banner_form" id="banner_form"  data-parsley-validate>
        <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","class"=>"form-control","value"=>$id), "id") ?>
        <div class="modal-body">
          <div class="form-row">
          
            
            
          
            
            
            
            
         
            <div class="form-group col-md-4">
              <label for="inputEmail4">Ratting</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control ","selected"=>$product_star, "values"=>array("1"=>"1","2"=>"2","3"=>"3","4"=>"4","5"=>"5"),"required"=>""), "product_star") ;?>
            </div>
            
               <div class="form-group col-md-8">
              <label for="inputEmail4">Review</label>
              <? $app->htmlBuilder->buildTag("textarea", array("rows"=>"5","class"=>"form-control","value"=>$product_desc), "product_desc") ?>
            </div>
            
            
          </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary tx-13 submit_btn banner_modal_submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
