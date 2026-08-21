<?php

$id=$app->getGetVar('id');

if($id!='')

{

	//Edit item_department

	$obj_item_department = $app->load_model("item_department");

	$result = $obj_item_department->execute("SELECT", false, "", "id='".$id."'");			

	
    $description=$result[0]['description'];

	$name=$result[0]['name'];

	$sort_order=$result[0]['sort_order'];

	$status=$result[0]['status'];

	$slug=$result[0]['slug'];
	
	
	$home_collection=$result[0]['home_collection'];
	
	

	

	

	

	//image

	$image=$result[0]["image"];





}

else

{

	//Add item_department

	

		

}







$file_class="fileupload-new";				  

if($id!='')

{

	 if($image!='' &&  file_exists(ABS_PATH."/".$app->get_user_config("item_department").'/'.$image))

	 {

		$img='../uploads/item_department/thumb'.$image;		

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



<div class="modal fade" id="modal_item_department_addedit" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">

    <div class="modal-content tx-14">

      <div class="modal-header">

        <h6 class="modal-title" id="exampleModalLabel2">Department Form</h6>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>

      </div>

      <form method="post" name="item_department_form" id="item_department_form"  data-parsley-validate>

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

        <label for="inputEmail4">Image (Size : 1000 x 1000 Px.)</label>

        <div class="fileupload <?=$file_class;?>" data-provides="fileupload">

                <div class="fileupload-new" > <img src="images/img_upl.gif" class="up_img"> </div>

                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 150px; line-height: 20px;"> <img src="<?=$img;?>" />  </div>

                <div>

                	<span class="btn btn-file btn-default"> 

                    	<span class="fileupload-new btn btn-white btn-xs">Select image</span>

                    	<span class="fileupload-exists btn btn-white btn-xs">Change</span>

                    	<? $app->htmlBuilder->buildTag("input", array("type"=>"file","class"=>""), "item_department_image") ?>

                    </span> 

                    <a href="#" class="btn btn-xs fileupload-exists btn-white" data-dismiss="fileupload">Remove</a> 

                </div>

              </div>

        

  		  </div>

        

			
            
             <div class="form-group col-md-6">
              <label for="inputEmail4">Home Collection  Option?</label>

              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","selected"=>$home_collection, "values"=>array("Yes"=>"Yes","No"=>"No"),"required"=>""), "home_collection") ;?>
             
            
            

            <br />

          
          

              <label for="inputEmail4">Sort Order</label>

           		<? $app->htmlBuilder->buildTag("select", array("class"=>"form-control ","selected"=>$sort_order, "values"=>$app->utility->sort_order('item_department'),"required"=>""), "sort_order") ;?>

            <br />

              <label for="inputEmail4">Status</label>

              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","selected"=>$status, "values"=>array("Active"=>"Active","Inactive"=>"Inactive"),"required"=>""), "status") ;?>

            </div>

            
          <div class="form-group col-md-12">
              <label for="inputEmail4">Description</label>
              <? $app->htmlBuilder->buildTag("textarea", array("class"=>"form-control ckeditor","value"=>$description), "description") ?>
            </div>

          </div>

          



        

          

        </div>

        <div class="modal-footer">

          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>

          <button type="submit" class="btn btn-primary tx-13 submit_btn item_department_modal_submit">Submit</button>

        </div>

      </form>

    </div>

  </div>

</div>

<script type="text/javascript">
$('.ckeditor').each( function () 
{
    CKEDITOR.replace( this.id );
});
</script>
<script>
    $.fn.modal.Constructor.prototype._enforceFocus = function() {};
</script>