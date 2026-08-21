<?php
$id=$app->getGetVar('id');
if($id!='')
{

	$obj_model_user = $app->load_model("user", $id);
	$user= $obj_model_user->execute("SELECT", false);		
	
	if($user[0]['group_id']!='')
	{
		$groups=$app->utility->user_group($user[0]['group_id']);
	}
	else
	{
				$groups='';
	}

}

?>

<div class="modal fade" id="modal_user_detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lx" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">User Detail</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <div class="modal-body">
        <div class="form-row">
          <div class="form-group col-md-6">
            <div data-label="" class="df-example demo-table">
              <div class="form-row">
                <div class="form-group col-md-12">
                  <p><strong>Name : </strong><?=$user[0]['name'];?></p>
                  <p><strong>Email : </strong><?=$user[0]['email'];?></p>
                  <p><strong>Phone : </strong><?=$user[0]['mobilephone'];?></p>
                  <p><strong>Group :</strong><?=$groups;?></p>
                  <p><strong>Address :</strong><?=$user[0]['billing_address_line1'];?></p>
                  <p><strong>Area :</strong><?=$user[0]['area_name'];?></p>
                  <p><strong>Wallet :</strong><?=$user[0]['wallet'];?></p>
                  <p><strong>OTP Code :</strong><?=$user[0]['otp_code'];?></p>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group col-md-6">
            <div data-label="Billing Information" class="df-example demo-table">
              <div class="form-row">
                <div class="form-group col-md-12">
                  <p><strong>Pincode : </strong><?=$user[0]['billing_zip_code'];?></p>
                  <p><strong>City : </strong><?=$user[0]['billing_city'];?></p>
                  <p><strong>State : </strong><?=$user[0]['billing_state'];?></p>
                  <p><strong>Country : </strong><?=$user[0]['billing_country'];?></p>
                  <p><strong>Birthdate : </strong><?=$user[0]['date_of_birth'];?></p>
                  <p><strong>Anniversary :</strong><?=$user[0]['mrg_anniversary'];?></p>
                  <p><strong>Refferal Code : </strong><?=$user[0]['ref_key'];?></p>
                  <p><strong>Refferal From : </strong><?=$user[0]['referral_from'];?></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
