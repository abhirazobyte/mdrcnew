<?php
$id=$app->getGetVar('id');
//Order Master
$obj_model_coupon = $app->load_model("coupon");
$rs_coupon = $obj_model_coupon->execute("SELECT", false, "","id='".$id."'");	

$obj_model_order_master = $app->load_model("order_master");
$obj_model_order_master->join_table("customer", "left", array( "name","phone","last_name","email"), array("customer_id"=>"id"));
		//	$obj_model_order_master->set_paging_settings($_SESSION['records'],5);	
$rs = $obj_model_order_master->execute("SELECT", false, "", "order_status!='Canceled' and discount_coupon_id='".$rs_coupon[0]['id']."'", "order_master.id DESC");


                              

?>



<div class="modal fade" id="modal_coupon_order_detail_module" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-body pd-20 pd-sm-30">
            <h4 class="tx-18 tx-sm-20 mg-b-3">Coupon Code: <b><?=$rs_coupon[0]['coupon_code']?></b></h4>
            <p class="mg-b-20 tx-color-03">Total Orders : <b style="font-size: 18px;"><?=count($rs)?></b></p>
            <a href="" role="button" class="close pos-absolute t-15 r-15" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </a>

            <div class="bd">
              

              <ul class="list-unstyled media-list tx-12 tx-sm-13 mg-b-0" style="height: 400px;overflow-y: scroll;">
              
              <?php for($i=0;$i<count($rs);$i++){
				  
				 	$fname=ucfirst($rs[$i]['customer_name']);
					$last_name=' '.ucfirst($rs[$i]['customer_last_name']);					
					$name=$fname.$last_name;										
					$fCharacter = $fname[0];					
					$id=$fname=$rs[$i]['id'];
					$old_date_timestamp = strtotime($rs[$i]['order_date_time']);
					$new_date = date('m/d/Y', $old_date_timestamp);
					$TOTAL = $rs[$i]['net_order_value']+$rs[$i]['wallet_value'];
					
				  ?>
                <li class="media bg-ui-01 pd-y-10 pd-x-15">
                  <div class="avatar"><span class="avatar-initial rounded-circle bg-gray-600"><?=$fCharacter?></span></div>
                  <div class="media-body mg-l-15">
                    <h6 class="tx-13 mg-b-2"><?=$name?></h6>
                    <span class="d-block tx-color-03"><strong>#<?=$id?></strong> - <?=$new_date?> - $<?=$TOTAL?> </span>
                  </div><!-- media-body -->
                  <a  href="javascript:void(0)"  data-id="<?=$id?>" class="btn btn-white rounded-circle btn-icon mg-l-15 order_detail"><i class="fa fa-arrow-right"></i></a>
                </li>
                
                <?php }?>
              
              </ul>
            </div>

            <div class="d-flex justify-content-end mg-t-30">
              <button type="button" class="btn btn-white" data-dismiss="modal">Cancel</button>
              
            </div>
          </div><!-- modal-body -->
        </div><!-- modal-content -->
      </div><!-- modal-dialog -->
    </div>



