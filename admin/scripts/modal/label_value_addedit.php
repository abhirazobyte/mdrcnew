<?php
$id=$app->getGetVar('id');
if($id!='')
{
	//Edit label_value
	$obj_label_value = $app->load_model("label_value");
	$result = $obj_label_value->execute("SELECT", false, "", "id='".$id."'");			
	
	$name=$result[0]['name'];
	$sort_order=$result[0]['sort_order'];
	$status=$result[0]['status'];
	$slug=$result[0]['slug'];
	
	$folder='label_value';
	//image
	$image=$result[0]["image"];

	$label_value_img1=$app->utility->get_image_path($image,$folder,"");
	$label_value_img=$label_value_img1['large_image'];
}
else
{
	//Add label_value
	$label_value_img='images/img_upl.gif';	
}
?>

<div class="modal fade" id="modal_label_value_addedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">Label Value Form</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <form method="post" name="label_value_form" id="label_value_form"  data-parsley-validate>
        <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","class"=>"form-control","value"=>$id), "id") ?>
        <div class="modal-body">


	 	 <div class="form-row">
            <div class="form-group col-md-12">
              <label for="inputEmail4">Name<span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control ","value"=>$name,"required"=>""), "name") ;?>
            </div>
            
          </div>
          
          
          

	<div class="form-row">
      
      
        
			
            
            <div class="form-group col-md-6">
              <label for="inputEmail4">Sort Order</label>
           		<? $app->htmlBuilder->buildTag("select", array("class"=>"form-control ","selected"=>$sort_order, "values"=>$app->utility->sort_order('label_value'),"required"=>""), "sort_order") ;?>
            </div>
            <div class="form-group col-md-6">
              <label for="inputEmail4">Status</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","selected"=>$status, "values"=>array("Active"=>"Active","Inactive"=>"Inactive"),"required"=>""), "status") ;?>
            </div>
          </div>
          

        
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary tx-13 submit_btn label_value_modal_submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
