<?php
$id=$app->getGetVar('id');
if($id!='')
{
	//Edit doctor
	$obj_doctor = $app->load_model("doctor");
	$result = $obj_doctor->execute("SELECT", false, "", "id='".$id."'");			
	
	$name=$result[0]['name'];
	$sort_order=$result[0]['sort_order'];
	$status=$result[0]['status'];
	$slug=$result[0]['slug'];
	
	$category_id=$result[0]['category_id'];
	$about_info=$result[0]['about_info'];
	$designation=$result[0]['designation'];
	$display_about=$result[0]['display_about'];
	
	$folder='doctor';
	//image
	$image=$result[0]["image"];

	$doctor_img1=$app->utility->get_image_path($image,$folder,"");
	$doctor_img=$doctor_img1['large_image'];
}
else
{
	//Add doctor
	$doctor_img='images/img_upl.gif';	
}

		$obj_table =$app->load_model("doctor_category");
		$result = $obj_table->execute("SELECT", false,"", "status!='Trash'");
		
		
		$records = array();
		$records[''] = 'Select';
		for($i=0;$i<count($result);$i++)
		{
			$records[$result[$i]['id']] = $result[$i]['name'];
		}
?>

<div class="modal fade" id="modal_doctor_addedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">Doctor Form</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <form method="post" name="doctor_form" id="doctor_form"  data-parsley-validate>
        <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","class"=>"form-control","value"=>$id), "id") ?>
        <div class="modal-body">


	 	 <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputEmail4">Category<span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control ","selected"=>$category_id, "values"=>$records,"required"=>""), "category_id") ;?>
            </div>
            
            
            <div class="form-group col-md-6">
              <label for="inputEmail4">Name<span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control ","value"=>$name,"required"=>""), "name") ;?>
            </div>
          </div>
          
          
          <div class="form-row">
           
           
            
            <div class="form-group col-md-12">
              <label for="inputEmail4">Designation<span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control ","value"=>$designation,"required"=>""), "designation") ;?>
            </div>
            
            
            <div class="form-group col-md-12">
              <label for="inputEmail4">About </label>
              <? $app->htmlBuilder->buildTag("textarea", array("rows"=>"3","class"=>"form-control ckeditor","value"=>$about_info), "about_info") ;?>
            </div>
          </div>
          
          
          

	<div class="form-row">
      <div class="form-group col-md-6">
        <label for="inputEmail4">Image (Size : 1300 x 400 Px.)</label>
        <div class="fileupload fileupload-new" data-provides="fileupload">
            <div class="fileupload-new" >
            <img src="<?=$doctor_img;?>" id="image_<?=$id?>_image" class="up_img">
            </div>
            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
            <div>
            <span class="btn btn-file btn-default">
            <span class="mg-t-5 fileupload-new btn btn-white btn-xs">Select image</span><span class="fileupload-exists btn btn-white btn-xs">Change</span><? $app->htmlBuilder->buildTag("input", array("type"=>"file","class"=>""), "doctor_image") ?></span>
            <a href="#" class="btn btn-xs fileupload-exists btn-white" data-dismiss="fileupload">Remove</a>
            
             <?php if($id!='' && $image!=''){ ?>
               <button id="btn_<?=$id?>_image" class="btn btn-xs btn-outline-danger" onclick="remove_image('<?=$id?>','doctor','image','doctor')" type="button">Remove</button>
              <?php }?>
            
            </div>
        </div>
  		  </div>
        
			
            
            <div class="form-group col-md-6">
              <label for="inputEmail4">Sort Order</label>
           		<? $app->htmlBuilder->buildTag("select", array("class"=>"form-control ","selected"=>$sort_order, "values"=>$app->utility->sort_order('doctor'),"required"=>""), "sort_order") ;?>
            <br />
            
             <label for="inputEmail4">Display About Page?</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","selected"=>$display_about, "values"=>array("Active"=>"Yes","Inactive"=>"No"),"required"=>""), "display_about") ;?>
            <br />
              <label for="inputEmail4">Status</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","selected"=>$status, "values"=>array("Active"=>"Active","Inactive"=>"Inactive"),"required"=>""), "status") ;?>
            </div>
          </div>
          

        
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary tx-13 submit_btn doctor_modal_submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
