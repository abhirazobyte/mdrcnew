<?php
$id=$app->getGetVar('id');
if($id!='')
{
	$obj_model_order_master = $app->load_model("order_master");
	$obj_model_order_master->join_table("user", "left", array("name", "mobilephone"), array("user_id"=>"id"));
	$order = $obj_model_order_master->execute("SELECT", false, "","order_master.id='".$id."'");	

	if($rs[0]['edit_id']>0)
	{
		$obj_model_order_reff_data11 = $app->load_model("order_reff_data");
		$last_order = $obj_model_order_reff_data11->execute("SELECT", false, "","order_master_id='".$order[0]['id']."' and id='".$order[0]['edit_id']."'");	
	}
	
	$obj_model_order_billing_address = $app->load_model("order_billing_address");
	$billing_info = $obj_model_order_billing_address->execute("SELECT", false, "","order_master_id=".$order[0]["id"]);	
	
	/* == GET SHIPPING DETAILS INFORMAION ==== */
	$obj_model_order_shipping_address = $app->load_model("order_shipping_address");
	$shipping_info = $obj_model_order_shipping_address->execute("SELECT", false, "","order_master_id=".$order[0]["id"]);	
		
	
	/* == GET ORDER DETAILS INFORMAION ==== */
	$obj_model_order_detail = $app->load_model("order_detail");
	$obj_model_order_detail->join_table("product", "left", array("id", "product_name","caption","product_image","product_model","product_price","product_unit"), array("product_id"=>"id"));
	$order_detail = $obj_model_order_detail->execute("SELECT", false, "","order_master_id=".$order[0]["id"]);	
	
	$obj_model_order_payment_data = $app->load_model("order_payment_data");
	$order_payment = $obj_model_order_payment_data->execute("SELECT", false, "","order_master_id=".$order[0]["id"],"id DESC");	
}
?>

<div class="modal fade" id="modal_order_detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">Order Detail</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <div class="modal-body">
        <div class="form-row">
          <div class="form-group col-md-6">
            <div data-label="Billing Information" class="df-example demo-table">
              <div class="form-row">
                <div class="form-group col-md-12">
                  <p><strong>OrderID : </strong>
                    <?=$order[0]['order_reff_data'];?>
                    <?php echo $app->getGetVar('id');?></p>
                  <p><strong>Delivery Date : </strong><?php echo $order[0]["del_date"].' '.$order[0]["del_time"]?></p>
                  <p><strong>Payment Type : </strong><?php echo $order[0]["payment_type"]?></p>
                  <p><strong>Order Date :
                    <?=date('d-m-Y H:i:s',strtotime($order[0]['order_date_time']))?>
                    </strong></p>
                  <p><strong>User :
                    <?=$order[0]["user_name"]?>
                    (<?php echo $order[0]["user_mobilephone"]?>)</strong></p>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group col-md-6">
            <div data-label="Shipping Information" class="df-example demo-table">
              <div class="form-row">
                <div class="form-group col-md-12">
                  <p><?php echo $shipping_info[0]["first_name"]." ".$shipping_info[0]["last_name"]; ?></p>
                  <p><?php echo $shipping_info[0]["address_line1"]." ".$shipping_info[0]["address_line2"]; ?></p>
                  <p>
                    <?=$shipping_info[0]["city"]." - ".$shipping_info[0]["zipcode"]; ?>
                  </p>
                  <p>
                    <?=$shipping_info[0]["country"]; ?>
                  </p>
                  <p><?php echo $shipping_info[0]["contact_number"]." - ".$shipping_info[0]["email"]; ?></p>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group col-md-12">
            <div data-label="Order Information" class="df-example demo-table">
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Image</th>
                    <th scope="col">Name (code)</th>
                    <th scope="col">Weight/Pcs</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Price</th>
                    <th scope="col">Mrp</th>
                    <th scope="col">Total Price</th>
                  </tr>
                </thead>
                <tbody>
                <?php 
			    $you_save=0;
				for($i=0;$i<count($order_detail);$i++)
				{
					$product_id= $order_detail[$i]["product_id"];
					$pro_unit= $order_detail[$i]["item_unit"];
					$purchase=$order_detail[$i];
					$default_weight=$purchase["default_product_weight"];
					$final_weight=$purchase["product_weight"];
					$product_id=$purchase["product_id"];
					$default_qty=$purchase["default_quantity"];
					$final_qty=$purchase["quantity"];
					$weight_html=$app->utility->order_print_weight_detail_data($pro_unit,$default_weight,$final_weight,$default_qty,$final_qty);
					$o_weight=$weight_html['o_weight'];
					$o_qty=$weight_html['o_qty'];
					$weight=$o_weight;
					$qty=$o_qty;
					
					if($order_detail[$i]['product_mrp']>$order_detail[$i]['product_price'])
					{
						$save_total=$order_detail[$i]['product_mrp']-$order_detail[$i]['product_price'];
					}
					else
					{
						$save_total=0;
					}
							
					$you_save+=$save_total*$qty;
				?>
                  <tr>
                    <th><img style="width: 60px;" src="<?=SERVER_ROOT."/uploads/product_image/".'thumb'.$order_detail[$i]['product_product_image'];?>" /></th>
                    <td><?=$order_detail[$i]['item_name']; ?>
                      (
                      <?=$order_detail[$i]['product_caption']; ?>
                      ) (
                      <?=$order_detail[$i]['product_product_model']; ?>
                      )
                      <?php if($order_detail[$i]['return_product']=='Yes'){?>
                      <br/>
                      <span class="badge badge-primary">Return</span>
                      <?php }?>
                      <?php if($order_detail[$i]['line_total']<=0){?>
                      <br/>
                      <span class="badge badge-warning">Cancel</span>
                      <?php }?></td>
                    <td><?=$weight; ?></td>
                    <td><?=$qty; ?></td>
                    <td><i class="fa fa-rupee-sign"></i>
                      <?=$order_detail[$i]['product_price']; ?></td>
                      <td><i class="fa fa-rupee-sign"></i>
                      <?=$order_detail[$i]['product_mrp']; ?></td>
                    <td><i class="fa fa-rupee-sign"></i>
                      <?=$order_detail[$i]['line_total']; ?></td>
                  </tr>
                  <?php }?>
                  <tr>
                    <td colspan="1" rowspan="2"><p>
                        <label>Special Instruction For This Order:</label>
                        <br />
                        <?=$order[0]['instruction']?>
                      </p>
                      <?php if($order[0]['return_desc']!=''){?>
                      <br/>
                      <p>
                        <label>Return Note:</label>
                        <br />
                        <?=$order[0]['return_desc']?>
                      </p>
                      <?php }?></td>
                    <td align="right" colspan="6"><strong>Sub Total</strong>: <i class="fa fa-rupee-sign"></i> <?php echo $order[0]['total_product_sell_value']; ?></td>
                  </tr>
                 
                  <?php if($you_save>0){?>
                  <tr>
                    <td  align="right" colspan="6"><strong>Save</strong>: <i class="fa fa-rupee-sign"></i> <?php echo $you_save; ?></td>
                  </tr>
                  <?php }?> 
                 
                  <?php if($order[0]['area_charge']>0){?>
                  <tr>
                    <td  align="right" colspan="6"><strong>Delivery Charge</strong>: <i class="fa fa-rupee-sign"></i> <?php echo $order[0]['area_charge']; ?></td>
                  </tr>
                  <?php }?>
                  <?php if($order[0]['express_charge']>0){?>
                  <tr>
                    <td  align="right" colspan="6"><strong>Express Charge</strong>: <i class="fa fa-rupee-sign"></i> <?php echo $order[0]['express_charge']; ?></td>
                  </tr>
                  <?php }?>
                  <?php if($order[0]['bag_charge']>0){?>
                  <tr>
                    <td  align="right" colspan="6"><strong>Bag Charge</strong>: <i class="fa fa-rupee-sign"></i> <?php echo $order[0]['bag_charge']; ?></td>
                  </tr>
                  <?php }?>
                  <?php if($order[0]['discount_value']>0){ $dis_info=$app->utility->dis_html_detail($order[0]['discount_coupon_id'],$order[0]['discount_coupon']);?>
                  <tr>
                    <td  align="right" colspan="6"><strong>Discount</strong>
                      <?=$dis_info?>
                      : <i class="fa fa-rupee-sign"></i> <?php echo $order[0]['discount_value']; ?></td>
                  </tr>
                  <?php }?>
                  <tr>
                    <td  align="right" colspan="6"><strong>Total</strong>: <i class="fa fa-rupee-sign"></i> <?php echo $order[0]['net_order_value']; ?></td>
                  </tr>
                  <?php if($order[0]['wallet_value']>0){?>
                  <tr>
                    <td  align="right" colspan="6"><strong>Paid From Wallet</strong>: <i class="fa fa-rupee-sign"></i> <?php echo $order[0]['wallet_value']; ?></td>
                  </tr>
                  <?php }?>
                  <tr>
                    <td  align="right" colspan="6"><strong>Total Pay Amount</strong>: <i class="fa fa-rupee-sign"></i> <?php echo $order[0]['pay_value']; ?></td>
                  </tr>
                  <?php if($order[0]['return_amount']>0){?>
                  <tr>
                    <td  align="right" colspan="6"></td>
                  </tr>
                  <tr>
                    <td  align="right" colspan="6"><strong>Return Amount</strong>: <i class="fa fa-rupee-sign"></i> <?php echo $order[0]['return_amount']; ?></td>
                  </tr>
                  <?php }?>
                </tbody>
              </table>
            </div>
          </div>
          <?php if(count($order_payment)>0){?>
          <div class="form-group col-md-12">
            <div data-label="Order Payment Information - Order Id (#<?=$id;?>)" class="df-example demo-table">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Pay Type</th>
                    <th scope="col">Payment Detail</th>
                    <th scope="col">Remark</th>
                  </tr>
                </thead>
                <tbody>
         <?php for($i=0;$i<count($order_payment);$i++){
		  $entry_from=$order_payment[$i]['entry_from'];
		  $date=$order_payment[$i]['transction_date_time'];
		  $transction_type=$order_payment[$i]['transction_type'];
		  $remark=$order_payment[$i]['gateway_remark'];
		  $payment_data=$order_payment[$i]['payment_data'];
		  $payment_mode=$order_payment[$i]['payment_mode'];
		  $payment_status=$order_payment[$i]['payment_status'];
		  $transction_id=$order_payment[$i]['transction_id'];
		  $transaction_amount=$order_payment[$i]['transaction_amount'];
		  $payment_type=$order_payment[$i]['payment_type'];
		  if($payment_status=='Success')
		  {
			  $payment_status='<span class="badge badge-success">Success</span>';
		  }
		  else
		  {
			   $payment_status='<span class="badge badge-warning">Failed</span>';
		  }
		  if($transction_id!='')
		  {
			  $transction_html='<strong>Txn ID : </strong>'.$transction_id.'<br/>';
		  }
		  else
		  {
			  $transction_html='';
		  }
		  if($payment_mode!='')
		  {
			  $payment_mode_html='<strong>Payment Mode : </strong>'.$payment_mode.'<br/>';
		  }
		  else
		  {
			  $payment_mode_html='';
		  }
		   if($payment_data!='')
		  {
			  $payment_data_html='<strong>Payment Detail : </strong>'.$payment_data.'<br/>';
		  }
		  else
		  {
			  $payment_data_html='';
		  }
		  if($transction_type=='Order')
		  {
			  $transction_type_html='';
		  }
		  else
		  {
			  $transction_type_html='<br/><span class="badge badge-warning">Refund</span>';
		  }
	?>
                  <tr>
                    <th><?=$entry_from?>
                        </strong><br/>
                        <?=$date?>
                        <br/>
                        <?=$transction_type_html?></th>
                    <td><i class="fa fa-rupee-sign"></i><?=$transaction_amount?><br/>
                        <?=$payment_status?></td>
                    <td><?=$payment_type?></td>
                    <td><?=$transction_html?>
                        <?=$payment_mode_html?>
                        <?=$payment_data_html?></td>
                    <td><?=$remark?></td>
                  </tr>
            <?php }?> 
                </tbody>
              </table>
            </div>
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
