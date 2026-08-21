<?php

$id=$app->getGetVar('id');

if($id!='')

{

	//Edit item_diseases

	$obj_item_diseases = $app->load_model("item_diseases");

	$result = $obj_item_diseases->execute("SELECT", false, "", "id='".$id."'");			

	$meta_title=$result[0]['meta_title'];
  $meta_keywords=$result[0]['meta_keywords'];
  $meta_description=$result[0]['meta_description'];
  $meta_schema=$result[0]['meta_schema'];
  
  $description=$result[0]['description'];
  $starting_price=$result[0]['starting_price'];
	$name=$result[0]['name'];

	$sort_order=$result[0]['sort_order'];

	$status=$result[0]['status'];

	$slug=$result[0]['slug'];

	$item_department_ids=$result[0]['item_department_ids'];
	$set_at_home=$result[0]['set_at_home'];

	

	

	

	//image

	$image=$result[0]["image"];





}

else

{

	//Add item_diseases

	

		

}



$obj_model_tble = $app->load_model("item_department");

$rs_work = $obj_model_tble->execute("SELECT",false,"","status='Active'","sort_order ASC");







$file_class="fileupload-new";				  

if($id!='')

{

	 if($image!='' &&  file_exists(ABS_PATH."/".$app->get_user_config("item_diseases").'/'.$image))

	 {

		$img='../uploads/item_diseases/thumb'.$image;		

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



<div class="modal fade" id="modal_item_diseases_addedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">

    <div class="modal-content tx-14">

      <div class="modal-header">

        <h6 class="modal-title" id="exampleModalLabel2">Diseases Form</h6>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>

      </div>

      <form method="post" name="item_diseases_form" id="item_diseases_form"  data-parsley-validate>

        <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","class"=>"form-control","value"=>$id), "id") ?>

        <div class="modal-body">





	 	 <div class="form-row">

            <div class="form-group col-md-12">

              <label for="inputEmail4">Name<span class="tx-danger">*</span></label>

              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control ","value"=>$name,"required"=>""), "name") ;?>

            </div>

            

          </div>

          

          

          

          <div class="form-row">

            <div class="form-group col-md-12">

             <label for="inputEmail4">Department <span class="tx-danger">*</span></label>

       

       	 <select class="form-control select2" multiple="multiple" name="work_item[]" required="">

        	 <? for($i=0;$i<count($rs_work);$i++)

                {

                $micro_items=explode(',',$item_department_ids);

                ?>

                <option  value="<?=$rs_work[$i]['id']; ?>" <?  for($j=0;$j<count($micro_items);$j++)

					{if($rs_work[$i]['id']==trim($micro_items[$j])){echo 'selected';}} ?>>

					<?=$rs_work[$i]['name']; ?>

                </option>

                <?php } ?>

         </select>

   

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

                    	<? $app->htmlBuilder->buildTag("input", array("type"=>"file","class"=>""), "item_diseases_image") ?>

                    </span> 

                    <a href="#" class="btn btn-xs fileupload-exists btn-white" data-dismiss="fileupload">Remove</a> 

                </div>

              </div>

        

  		  </div>

        

			

            

            <div class="form-group col-md-6">

              <label for="inputEmail4">Sort Order</label>
           		<? $app->htmlBuilder->buildTag("select", array("class"=>"form-control ","selected"=>$sort_order, "values"=>$app->utility->sort_order('item_diseases'),"required"=>""), "sort_order") ;?>
                
              <br/>
              <label for="inputEmail4">Show Home?</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","selected"=>$set_at_home, "values"=>array("No"=>"No","Yes"=>"Yes"),"required"=>""), "set_at_home") ;?>

              <br/>
              <label for="inputEmail4">Status</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","selected"=>$status, "values"=>array("Active"=>"Active","Inactive"=>"Inactive"),"required"=>""), "status") ;?>

              <br/>
              <label for="inputEmail4">Starting Price</label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control","value"=>$starting_price), "starting_price") ?>

            </div>


             <div class="form-group col-md-12">
              <label for="inputEmail4">Description</label>
              <? $app->htmlBuilder->buildTag("textarea", array("type"=>"text","class"=>"form-control ckeditor","value"=>$description,"style"=>"height: 140px;"), "description") ?>
            </div>


            <div class="form-group col-md-12">
              <label for="inputEmail4">Meta Title</label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control","value"=>$meta_title), "meta_title") ?>
            </div>

            <div class="form-group col-md-12">
              <label for="inputEmail4">Meta Keywords</label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control","value"=>$meta_keywords), "meta_keywords") ?>
            </div>

            <div class="form-group col-md-12">
              <label for="inputEmail4">Meta Description</label>
              <? $app->htmlBuilder->buildTag("textarea", array("type"=>"text","class"=>"form-control","value"=>$meta_description), "meta_description") ?>
            </div>
            <div class="form-group col-md-12">
              <label for="inputEmail4">Meta Schema</label>
              <? $app->htmlBuilder->buildTag("textarea", array("type" => "text", "class" => "form-control", "value" => $meta_schema, "style" => "height: 100px;"), "meta_schema") ?>
            </div>

          </div>

          

          

        </div>

        <div class="modal-footer">

          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>

          <button type="submit" class="btn btn-primary tx-13 submit_btn item_diseases_modal_submit">Submit</button>

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
    // Disable Bootstrap's focus enforcement to allow CKEditor dialogs
    $.fn.modal.Constructor.prototype._enforceFocus = function() {};
</script>