<?php

$id=$app->getGetVar('id');

if($id!='')

{

	//Edit item_certificate

	$obj_item_certificate = $app->load_model("item_certificate");

	$result = $obj_item_certificate->execute("SELECT", false, "", "id='".$id."'");			

	

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

	//Add item_certificate

	

		

}



$obj_model_tble = $app->load_model("item_department");

$rs_work = $obj_model_tble->execute("SELECT",false,"","status='Active'","sort_order ASC");








				  

if($id!='')

{

	 if($image!='' &&  file_exists(ABS_PATH."/".$app->get_user_config("item_certificate").'/'.$image))

	 {

		$img='../uploads/item_certificate/'.$image;		

		
			

		

	 }

	 else

	 {

		 $img='';

	 }

 }

 else

 {

	 $img='';

 }





?>



<div class="modal fade" id="modal_item_certificate_addedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">

    <div class="modal-content tx-14">

      <div class="modal-header">

        <h6 class="modal-title" id="exampleModalLabel2">Certificate Form</h6>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>

      </div>

      <form method="post" name="item_certificate_form" id="item_certificate_form"  data-parsley-validate>

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

        <label for="inputEmail4">Image File</label>

        
         <? $app->htmlBuilder->buildTag("input", array("type"=>"file","class"=>"form-control "), "file1") ;?>
         
         <?php if($img!=''){?>
         <span class=""><a href="<?=$img?>" target="_blank">View Uploaded File</a></span>
         
         <?php }?>




  		  </div>

        
        
        
                    

            <div class="form-group col-md-6">
              <label for="inputEmail4">Sort Order</label>
           	  <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control ","selected"=>$sort_order, "values"=>$app->utility->sort_order('item_certificate'),"required"=>""), "sort_order") ;?>
           </div>
            
            
             <div class="form-group col-md-6">
              <label for="inputEmail4">Status</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","selected"=>$status, "values"=>array("Active"=>"Active","Inactive"=>"Inactive"),"required"=>""), "status") ;?>
              
            </div>
            

          </div>

          



        

          

        </div>

        <div class="modal-footer">

          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>

          <button type="submit" class="btn btn-primary tx-13 submit_btn item_certificate_modal_submit">Submit</button>

        </div>

      </form>

    </div>

  </div>

</div>

