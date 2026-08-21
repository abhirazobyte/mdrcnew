<?php
$id=$app->getGetVar('id');
if($id!='')
{
	//Edit item_lab
	$obj_item_lab = $app->load_model("item_lab");
	$result = $obj_item_lab->execute("SELECT", false, "", "id='".$id."'");			
	
	$city_id=$result[0]['city_id'];
	$api_id=$result[0]['api_id'];
	$code=$result[0]['code'];
	$name=$result[0]['name'];
	$slug=$result[0]['slug'];
	$image=$result[0]['image'];
	$email=$result[0]['email'];
  $selected_department = explode(',', $result[0]['department_names']);
  $selected_excluding_department_names = explode(',', $result[0]['excluding_department_names']);
	$phone=$result[0]['phone'];
	$address=$result[0]['address'];
	$status=$result[0]['status'];
	$sort_order=$result[0]['sort_order'];
	
	$rate_list_panel_id=$result[0]['rate_list_panel_id'];
  $lab_type=$result[0]['lab_type'];
  $panel_id=$result[0]['panel_id'];
 
  $center_id=$result[0]['center_id'];
	
	
	//image
	$image=$result[0]["image"];


}
else
{
	//Add item_lab
	
		
}


$lab_type_array=array("Main Lab"=>"Main Lab","Collection Point"=>"Collection Point");



$obj_model_state = $app->load_model("city");
$rs = $obj_model_state->execute("SELECT", false,"","status='Active'");
$records1 = array();
$records1[''] = " Select City";
for($i=0;$i<count($rs);$i++)
{
  $records1[$rs[$i]['id']] = $rs[$i]['name'];
}

$obj_model_lis_department = $app->load_model("lis_item_department");
$rs_department = $obj_model_lis_department->execute("SELECT", false,"","status='Active'");
$department = array();
for($i=0;$i<count($rs_department);$i++)
{
  $department[$rs_department[$i]['id']] = $rs_department[$i]['name'];
}



$file_class="fileupload-new";				  
if($id!='')
{
	 if($image!='' &&  file_exists(ABS_PATH."/".$app->get_user_config("item_lab").'/'.$image))
	 {
		$img='../uploads/item_lab/thumb'.$image;		
		$file_class="fileupload-exists";		
		
	 }
	 else
	 {
		 $img='images/img_upl.gif';
	 }
 }
 else
 {
	 $img='images/img_upl.gif';
 }


?>

<div class="modal fade" id="modal_item_lab_addedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">Lab Form</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <form method="post" name="item_lab_form" id="item_lab_form"  data-parsley-validate>
        <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","class"=>"form-control","value"=>$id), "id") ?>
        <div class="modal-body">




	 	 <div class="form-row">
         
          <div class="form-group col-md-6">
              <label for="inputEmail4">City<span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control select2","selected"=>$city_id, "values"=>$records1,"required"=>""), "city_id") ;?>
            </div>
            <div class="form-group col-md-6">
              <label for="inputEmail4">Lab Name<span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control ","value"=>$name,"required"=>""), "name") ;?>
            </div>
            
          </div>
          
          
          
          <div class="form-row">
         
           <div class="form-group col-md-6">
              <label for="inputEmail4">Lab ID<span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control ","value"=>$api_id,"required"=>""), "api_id") ;?>
            </div>
          
          
            <div class="form-group col-md-6">
              <label for="inputEmail4">Lab Code<span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control ","value"=>$code,"required"=>""), "code") ;?>
            </div>
            
          </div>

          <div class="form-row">

          <div class="form-group col-md-6">
              <label for="inputEmail4">Panel ID<span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control","value"=>$panel_id,"required"=>""), "panel_id") ;?>
            </div>
            <div class="form-group col-md-6">
              <label for="inputEmail4">Rate list panel ID<span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control","value"=>$rate_list_panel_id,"required"=>""), "rate_list_panel_id") ;?>
            </div>
           <div class="form-group col-md-6">
              <label for="inputEmail4">Centre ID<span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control","value"=>$center_id,"required"=>""), "center_id") ;?>
            </div>
          
          
            <div class="form-group col-md-6">
              <label for="inputEmail4">Lab Type<span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control select2","values"=>$lab_type_array,"selected"=>$lab_type,"required"=>""), "lab_type") ;?>
            </div>
            
          </div>

          
          
          
          <div class="form-row">
         
          
          
            <div class="form-group col-md-6">
              <label for="inputEmail4">Phone Number</label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control numbers numbersOnly","value"=>$phone), "phone") ;?>
            </div>
            
            <div class="form-group col-md-6">
              <label for="inputEmail4">Email</label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"email","class"=>"form-control","value"=>$email), "email") ;?>
            </div>
            
          </div>
          
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="inputEmail4">Including Department</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control select2","selected"=>$selected_department, "multiple"=>"multiple","values"=>$department), "lis_item_department_id[]") ;?>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="inputEmail4">Excluding Department</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control select2","selected"=>$selected_excluding_department_names, "multiple"=>"multiple","values"=>$department), "excluding_department_id[]") ;?>
            </div>
          </div>
          
          
          <div class="form-row">
         
          
          
            <div class="form-group col-md-12">
              <label for="inputEmail4">Address<span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("textarea", array("rows"=>"3","class"=>"form-control","value"=>$address,"required"=>""), "address") ;?>
            </div>
            
            
            
            
          </div>
          
          
          
          
          

	<div class="form-row">
      <div class="form-group col-md-6">
        <label for="inputEmail4">Image (Size : 1000 x 1000 Px.)</label>
        <div class="fileupload <?=$file_class;?>" data-provides="fileupload">
                <div class="fileupload-new" > <img src="images/img_upl.gif" class="up_img"> </div>
                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 150px; line-height: 20px;"> <img src="<?=$img;?>" />  </div>
                <div>
                	<span class="btn btn-file btn-default"> 
                    	<span class="fileupload-new btn btn-white btn-xs">Select image</span>
                    	<span class="fileupload-exists btn btn-white btn-xs">Change</span>
                    	<? $app->htmlBuilder->buildTag("input", array("type"=>"file","class"=>""), "item_lab_image") ?>
                    </span> 
                    <a href="#" class="btn btn-xs fileupload-exists btn-white" data-dismiss="fileupload">Remove</a> 
                </div>
              </div>
        
  		  </div>
        
			
            
            <div class="form-group col-md-6">
              <label for="inputEmail4">Sort Order</label>
           		<? $app->htmlBuilder->buildTag("select", array("class"=>"form-control ","selected"=>$sort_order, "values"=>$app->utility->sort_order('item_lab'),"required"=>""), "sort_order") ;?>
            <br />
              <label for="inputEmail4">Status</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","selected"=>$status, "values"=>array("Active"=>"Active","Inactive"=>"Inactive"),"required"=>""), "status") ;?>
            </div>
          </div>
          
          

        
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary tx-13 submit_btn item_lab_modal_submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
