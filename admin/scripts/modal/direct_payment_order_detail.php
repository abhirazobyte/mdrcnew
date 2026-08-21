<?php
$id=$app->getGetVar('id');
if($id!='')
{
  $obj_brand = $app->load_model("direct_payment_order");
  $result = $obj_brand->execute("SELECT", false, "", "id='".$id."'");

  $name=$result[0]['name'];
  $email=$result[0]['email'];
  $mobile=$result[0]['mobile'];
  $amount=$result[0]['amount'];
  $message=$result[0]['message'];
  $order_pay_status=$result[0]['order_pay_status'];
  $payment_id=$result[0]['payment_id'];
  $transction_date_time=$result[0]['transction_date_time'];

  if($result[0]['order_pay_status']=='Confirm')
  {
    $order_pay_status='<span style=" font-size: 16px;"  class="badge badge-success">'.$result[0]['order_pay_status'].'</span>';
  }
  else
  {
    $order_pay_status='<span style=" font-size: 16px;"  class="badge badge-danger">'.$result[0]['order_pay_status'].'</span>';
  }


  $gateway_remark=$result[0]['gateway_remark'];
  
}
?>
<div class="modal fade" id="modal_direct_payment_order_detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">Pay Now Order Details  <b style=" font-size: 18px;">#<?=$id?> - <?=$order_pay_status?></b></h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
        <div class="modal-body">
          <div class="form-row">
            <?php if($name!=''){?>
            <div class="form-group col-md-6">
             <label for="inputEmail4">Name</label>
             <p class="details"><?=$name?></p>
            </div>
            <?php }?>
            <?php if($email!=''){?>
            <div class="form-group col-md-6">
             <label for="inputEmail4">Email</label>
             <p class="details"><?=$email?></p>
            </div>
          <?php }?>
          <?php if($mobile!=''){?>
            <div class="form-group col-md-6">
             <label for="inputEmail4">Mobile</label>
             <p class="details"><?=$mobile?></p>
            </div>
          <?php }?>
          <?php if($amount!=''){?>
            <div class="form-group col-md-6">
             <label for="inputEmail4">Amount</label>
             <p class="details"><?=$amount?></p>
            </div>
        <?php }?>
          <?php if($payment_id!=''){?>
            <div class="form-group col-md-6">
             <label for="inputEmail4">Payment ID</label>
             <p class="details"><?=$payment_id?></p>
            </div>
          <?php }?>
          <?php if($transction_date_time!=''){?>
            <div class="form-group col-md-6">
             <label for="inputEmail4">Transction Date Time</label>
             <p class="details"><?=$transction_date_time?></p>
            </div>
          <?php }?>
          <?php if($message!=''){?>
             <div class="form-group col-md-12">
             <label for="inputEmail4">Message</label>
             <p class="details"><?=$message?></p>
            </div>
          <?php }?>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
        </div>
    </div>
  </div>
</div>

<style type="text/css">
 p.details {
    border: 1px solid #c0ccda;
    padding: 9px;
    border-radius: 0.25rem;
}
</style>