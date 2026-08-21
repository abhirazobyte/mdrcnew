<?php
$cartID=$app->getGetVar('id');


$obj_model_tmp_cartmini = $app->load_model("customer_cart");
$rs_data = $obj_model_tmp_cartmini->execute("SELECT", false,"", "customer_cart.id='".$cartID."'");
$image=$rs_data[0]['prescription_data'];




	if($image!='' &&  file_exists(ABS_PATH."/".$app->get_user_config("prescription").'/'.$image))
	 {
		$img='uploads/prescription/'.$image;		
		
				
		
	 }
	 else
	 {
		 $img='uploads/default.png';
	 }
	
	




?>


<div class="popup-modals modal-ad-style">

  <div class="modal infosmal" id="modal-UploadPrescription-details" tabindex="-1" >

    <div class="modal-dialog">

      <div class="modal-content">

        <div class="modal-header">

          <div class="common-heading">

            <h4 class="mt0 mb0">Prescription</h4>

          </div>

          <button type="button" class="closes" data-bs-dismiss="modal">&times;</button>

        </div>

        <div class="modal-body">

        	<div class="col-lg-12 text-center col-12">

        			<img class="w-100" src="<?=$img?>" alt="">

        	</div>

        </div>

      </div>

    </div>

  </div>

</div>













