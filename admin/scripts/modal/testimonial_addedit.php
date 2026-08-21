<?php
$id=$app->getGetVar('id');

if($id!='')
{
	$obj_brand = $app->load_model("testimonial");
	$result = $obj_brand->execute("SELECT", false, "", "id='".$id."'");			
	
	$name=$result[0]['name'];
	$content=$result[0]['content'];
	$sort_id=$result[0]['sort_id'];
	$city=$result[0]['city'];
	$ratting=$result[0]['ratting'];
	
	$status=$result[0]['status'];
	$view_date=$result[0]['view_date'];
	
	//Mobile
	$folder='testimonial';
	$image=$result[0]["image"];
	$banner_img=$app->utility->get_image_path($image,$folder,'thumb');
}
else
{
	$banner_img='images/img_upl.gif';		
}

?>

<div class="modal fade" id="modal_testimonial_addedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">Testimonial Form</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <form method="post" name="testimonial_form" id="testimonial_form"  data-parsley-validate>
        <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","class"=>"form-control","value"=>$id), "id") ?>
        <div class="modal-body">
        
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="inputEmail4">Name <span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control ","value"=>$name,"required"=>""), "name");?>
            </div>
          </div>
          
          
          
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputEmail4">City <span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control ","value"=>$city,"required"=>""), "city");?>
            </div>
            
            <div class="form-group col-md-6">
              <label for="inputEmail4">Ratting <span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control numbersOnly","value"=>$ratting,"required"=>""), "ratting");?>
            </div>
          </div>
          
          
           <div class="form-row">
            <div class="form-group col-md-12">
                <label for="inputEmail4">Content <span class="tx-danger">*</span></label>
             <? $app->htmlBuilder->buildTag("textarea", array("type"=>"text","class"=>"form-control  required","value"=>$content,"required"=>""), "content") ;?>
            </div>
            </div>
            

           <div class="form-row">
           
           
           
         <div class="form-group col-md-6">
        <label for="inputEmail4">Image (Size : 400 x 400 Px.)</label>
        <div class="fileupload fileupload-new" data-provides="fileupload">
            <div class="fileupload-new" >
            <img src="<?=$banner_img;?>" class="up_img">
            </div>
            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
            <div>
            <span class="btn btn-file btn-default">
            <span class="mg-t-5 fileupload-new btn btn-white btn-xs">Select image</span><span class="fileupload-exists btn btn-white btn-xs">Change</span><? $app->htmlBuilder->buildTag("input", array("type"=>"file","class"=>""), "banner_image") ?></span>
            <a href="#" class="btn btn-xs fileupload-exists btn-white" data-dismiss="fileupload">Remove</a>
            </div>
        </div>
  		  </div>
           
           
           
            <div class="form-group col-md-6">
              <label for="inputEmail4">Sort Id</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control ","selected"=>$sort_id, "values"=>$app->utility->sort_order('testimonial'),"required"=>""), "sort_id") ;?>

              <label for="inputEmail4" class="mt-3">Date</label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control ","value"=>$view_date), "view_date");?>
            </div>
              
            <div class="form-group col-md-6">
               <label for="inputEmail4">Status</label>
             <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","selected"=>$status, "values"=>array("Active"=>"Active","Inactive"=>"Inactive"),"required"=>""), "status") ;?>
           
            </div>

  
  
            
            
            
            
          </div>
          
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary tx-13 submit_btn testimonial_modal_submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
