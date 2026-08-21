<?php
$id=$this->orderID;
//Order Master
$obj_model_order_master = $this->load_model("customer_order_master");
$obj_model_order_master->join_table("customer_order_master_info", "left", array(), array("id"=>"order_master_id"));
$order = $obj_model_order_master->execute("SELECT", false, "","customer_order_master.id='".$id."'");	


$obj_model_last_order= $this->load_model("customer_order_edit_history");
$rs_last_order = $obj_model_last_order->execute("SELECT", false, "","order_master_id='".$order[0]["id"]."'");




/*$obj_model_order_rate = $this->load_model("order_rattings");
$obj_model_order_rate->join_table("webadmin", "left", array(), array("delivery_boy_id"=>"id"));
$order_rate = $obj_model_order_rate->execute("SELECT",false,"","order_master_id='".$order[0]['id']."'","order_rattings.id desc limit 0,1");
									*/


//Order Shipping Details
$obj_model_order_shipping_address = $this->load_model("customer_order_shipping_address");
$obj_model_order_shipping_address->join_table("state", "left", array("name"), array("state_id"=>"id"));
$shipping_info = $obj_model_order_shipping_address->execute("SELECT", false, "","customer_order_shipping_address.order_master_id=".$order[0]["id"]);




			
$city=$shipping_info[0]['city'];
$state=$shipping_info[0]['state_name'];

//Order Detail
$obj_model_order_detail = $this->load_model("customer_order_detail");
$order_detail = $obj_model_order_detail->execute("SELECT", false, "","order_master_id=".$order[0]["id"]);

//Order Status History
$obj_model_order_history = $this->load_model("customer_order_status_history");
$rs_data = $obj_model_order_history->execute("SELECT", false, "","order_master_id=".$order[0]["id"]."","id DESC");


$vendor_company_name=$rs_vendor[0]['company_name'];
$vendor_company_phone=$rs_vendor[0]['company_phone'];


$order_id=$order[0]['id'];


$order_date = $order[0]['order_date'];


$delivery_date = $order[0]['delivery_date'];
$delivery_time = $order[0]['delivery_time'];



$order_type=$order[0]['order_type'];
$transaction_id=$order[0]['transaction_id'];


$delivery_type=$order[0]['delivery_type'];


$o_status_20=$this->utility->o_status_html2020($order[0]['order_status']);





$coupon_code='';
$msg='';
$admin_note='';
if($discount_coupon_id>0)
{
$obj_model_dis = $this->load_model("coupon");
$rs_discount = $obj_model_dis->execute("SELECT", false, "","id='".$discount_coupon_id."'");
$coupon_code=$rs_discount[0]['coupon_code'];
$msg=$rs_discount[0]['msg'];
$admin_note=$rs_discount[0]['admin_note'];
}


$address_instruction=$billing_info[0]['address_instruction'];
$order_instruction=$billing_info[0]['order_instruction'];
$customer_id=$order[0]["customer_id"];

// Shipping Address Data
$s_name=ucfirst(strtolower($shipping_info[0]["first_name"])).' '.ucfirst(strtolower($shipping_info[0]["last_name"]));
$s_address=$shipping_info[0]["line1"].', '.$shipping_info[0]["line2"].'<br/>';
$s_address.=$city.', '.$state.' - '.$shipping_info[0]["zipcode"];


$s_phone=$shipping_info[0]["phone"];
$s_email=$shipping_info[0]["email"];

                     

?>



<link href="lib/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">

<link href="lib/ionicons/css/ionicons.min.css" rel="stylesheet">

<link href="lib/typicons.font/typicons.css" rel="stylesheet">

<link href="lib/prismjs/themes/prism-vs.css" rel="stylesheet">

<link href="lib/datatables.net-dt/css/jquery.dataTables.min.css" rel="stylesheet">

<link href="lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css" rel="stylesheet">

<link rel="stylesheet" href="assets/css/dashforge.auth.css">



<!-- DashForge CSS -->

<link rel="stylesheet" href="assets/css/dashforge.css">

<link rel="stylesheet" href="assets/css/dashforge.demo.css">



<!-- Skin CSS -->

<link rel="stylesheet" href="assets/css/skin.cool.css">

<!--<link rel="stylesheet" href="assets/css/skin.charcoal.css">-->



<!-- new added by developer -->

<link rel="stylesheet" href="assets/css/custom.css">



<!--Sweet Alert CSS & JS -->

<link href="lib/alert/css/sweet-alert.css" rel="stylesheet" type="text/css" />



<!-- file upload  --> 

<link href="lib/bootstrap-file/css/fileupload.css" rel="stylesheet" type="text/css" />



<!--image popup -->

<link href="lib/magnific-popup/css/magnific-popup.css" rel="stylesheet" type="text/css" />





<?php include('includes/menu.php');?>

<div class="content ht-100v pd-0">

  <?php include('includes/header.php');?>

  <!-- content-header -->

  

  <div class="content-body">

    <div class="container pd-x-0">

      

      <?=$this->utility->get_message()?>

      <div class="content tx-13">

      

      <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">

        <div>

          <nav aria-label="breadcrumb">

            <ol class="breadcrumb breadcrumb-style1 mg-b-10">

              <li class="breadcrumb-item"><a href="#">Page</a></li>

              <li class="breadcrumb-item active" aria-current="page">

                <?=$this->to_do?>

              </li>

            </ol>

          </nav>
          <h3 class="mg-b-0 tx-spacing--1">Order Detail #<?=$order[0]['display_order_no']?></h3>

        </div>

      </div>


		
		
      

        <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
           
          
          
          <div class="order-invoice mt-4">
            <div class="row">
              <div class="col-lg-8 col-md-12">
                  <div class="table-responsive df-example px-3 py-2 rounded">
                    <table class="table table-invoice mb-0">
                      <thead>
                        <tr>
                          <th class="wd-40p  d-sm-table-cell border-0 tx-left pl-0" colspan="2">Product</th>
                          
                          <th class="tx-center border-0">Price</th>
                          <th class="tx-center border-0">Qty</th>
                          
                          <th class="tx-right border-0">Total</th>
                          
                        </tr>
                      </thead>
                      <tbody>
                      
                       <?php for($i=0;$i<count($order_detail);$i++){
						   
						   $productimage=$order_detail[$i]['order_product_image'];
							$order_product_folder_name=$order_detail[$i]['order_product_folder_name'];
							if($productimage!="" && file_exists(ABS_PATH."/uploads/product/".$order_product_folder_name."/".$productimage))
							{
								 $product_image = "../uploads/product/".$order_product_folder_name."/".$productimage;
							}
							else
							{
								$product_image="../uploads/default.jpg";
							}
							
							
							
						$order_product_attribute_name=$order_detail[$i]['order_product_attribute_name'];
						$order_product_attribute_name2=$order_detail[$i]['order_product_attribute_name2'];
						$order_product_attribute_name3=$order_detail[$i]['order_product_attribute_name3'];
						
						
						
						$varient_name=array();

						if($order_product_attribute_name!=''){$varient_name[]=$order_product_attribute_name;}
						if($order_product_attribute_name2!=''){$varient_name[]=$order_product_attribute_name2;}
						if($order_product_attribute_name3!=''){$varient_name[]=$order_product_attribute_name3;}
						
						$display_name=implode(', ',$varient_name);

						   
						   
						   ?>
                        <tr>
                          <td class="pl-0">
                            <div class="item-img">
                              <img src="<?=$product_image?>" class="rounded wd-60">
                            </div>
                          </td>
                          <td class=" d-sm-table-cell tx-color-02 align-middle"><strong><?=$order_detail[$i]['order_product_name']; ?></strong><br/><span style="font-size:12px"><?=$display_name?></span></td>
                          
                          
                           <td class="tx-center align-middle"><div class="qty-inner"><i class="fas fa-rupee-sign"></i> <?=$order_detail[$i]['price']; ?></div></td>
                        <td class="tx-center align-middle"><div class="qty-inner"><?=$order_detail[$i]['quantity']; ?></div></td>
                          <td class="tx-right align-middle"><span class="price-in"><i class="fas fa-rupee-sign"></i> <?=$order_detail[$i]['total']; ?></span></td>
                          
                        </tr>
                        
                        
                        <?php }?>
                        
                       
                      </tbody>
                    </table>
                  </div>
                  
                  
                  
                  <div class="df-example rounded p-0  mt-3 ">
          
          
              <div class="card-header d-flex align-items-center justify-content-between">
                <h4 class="mg-b-0">Order Status History</h4>
                <div class="d-flex tx-18">
                  
                  
                </div>
              </div>
              <ul class="list-group list-group-flush tx-13">
                <?php if(count($rs_data)>0)
									{?>
                  <?php
									for($i=0;$i<count($rs_data);$i++){
										$status=$rs_data[$i]['o_status'];
										$date=$rs_data[$i]['entry_date_time'];
										$msg=$rs_data[$i]['remark'];
										$ostatus=$this->utility->o_status_html2020($status);
										
										if($rs_data[$i]['remark_other']!='')
										{
										
											$msg.='<br/><b>'.$rs_data[$i]['remark_other'].'</b>';
										
										}
										
										 
										 
										?>
                <li class="list-group-item d-flex pd-sm-x-20">
                  
                  <div class="pd-sm-l-10">
                    <p class="tx-medium mg-b-0"><?=$msg?></p>
                    
                    
                  </div>
                  <div class="mg-l-auto text-right">
                   <small class="tx-12  mg-b-0"><?=$ostatus?></small>
                    <p class="tx-medium mg-b-0"><?=$date?></p>
                   
                  </div>
                </li>
                
                 <?php } }?>
                
                
              </ul>
              
              
              
               </div>
                      <?php if(count($rs_last_order)>0){?>
               
               <div class="df-example rounded p-0  mt-3 ">
          
          
              <div class="card-header d-flex align-items-center justify-content-between">
                <h4 class="mg-b-0">Order Edit History</h4>
                
                
              </div>
              
              <div class="table-responsive df-example px-3 py-2 rounded">
                    <table class="table table-invoice mb-0">
                      <thead>
                        <tr>
                          <th>Sr.</th>
                    
                  	  <th>Last Order Amount</th>
                  	  <th>New Order Amount</th>                  	
                    
                   	 <th>From</th>
                          
                        </tr>
                      </thead>
                      <tbody>
                      
                       <tr>
                    <td>1</td>
                    <td>Sub Total : <i class="fas fa-rupee-sign"></i> <?=$rs_last_order[0]['subtotal']?><br/>Shipping : <i class="fas fa-rupee-sign"></i> <?=$rs_last_order[0]['ship_charge']?><br/>Discount : <i class="fas fa-rupee-sign"></i> <?=$rs_last_order[0]['discount']?><br/>Wallet : <i class="fas fa-rupee-sign"></i> <?=$rs_last_order[0]['wallet_amount']?><br/><hr/>Total : <i class="fas fa-rupee-sign"></i> <?=$rs_last_order[0]['net_order_value']?></td>
                    <td>Sub Total : <i class="fas fa-rupee-sign"></i> <?=$order[0]['subtotal']?><br/>Shipping : <i class="fas fa-rupee-sign"></i> <?=$order[0]['ship_charge']?><br/>Discount : <i class="fas fa-rupee-sign"></i> <?=$order[0]['discount']?><br/>Wallet : <i class="fas fa-rupee-sign"></i> <?=$order[0]['promo_wallet_amount']?><br/><hr/>Total : <i class="fas fa-rupee-sign"></i> <?=$order[0]['net_order_value']?></td>
                    
                    
                    <td><?=$rs_last_order[0]['order_from']?><br/>
                    <?=$rs_last_order[0]['order_date']?></td>
                  </tr>
                       
                      </tbody>
                    </table>
                  </div>
              
              
              
              
              
               </div>
               
               
               <?php }?>
                  
                  
                  <?php
				  				
								$order_delivery_date=$order[0]['order_delivery_date'];	
				  
				  				$subtotal=$order[0]['subtotal'];								
								$ship_charge=$order[0]['ship_charge'];	
								$bag_charge=$order[0]['bag_charge'];								
								$discount_value=$order[0]['discount'];
								$total=$order[0]['net_order_value'];
								$wallet_amount=$order[0]['wallet_amount'];
								
								
								
								
								$order_fix_charge=$order[0]['order_master_info_order_fix_charge'];
								$order_weight_charge=$order[0]['order_master_info_order_weight_charge'];
								$order_km_chrage=$order[0]['order_master_info_order_km_chrage'];
				  
				  
				  ?>
                  
                  
              </div>
              <div class="col-lg-4 col-md-12 mt-lg-0 mt-3">
                <div class="order-summary df-example px-3 py-2 rounded">
                   <h6 class="bd-b py-2">Order Summary</h6>
                   <table class="os-tabl wd-100p">
                      <tbody>
                         <tr>
                            <td class="pb-2">Order No :</td>
                            <td class="text-right pb-2"><?=$order[0]['display_order_no']?></td>
                         </tr>
                         <tr>
                            <td class="pb-2">Order Date :</td>
                            <td class="text-right pb-2"><?=$order_date?> </td>
                         </tr>
                         
                          <tr>
                            <td class="pb-2">Payment Type :</td>
                            <td class="text-right pb-2"><?=$order[0]['payment_type']?> </td>
                         </tr>
                         
                          <tr>
                            <td class="pb-2">Order Status:</td>
                            <td class="text-right pb-2"><?=$o_status_20?> </td>
                         </tr>
                         
                       
                       
                      </tbody>
                   </table>
                </div>
                <div class="deliverying df-example mt-3 px-3 py-2 rounded">
                   <h6 class="bd-b py-2">Delivering to</h6>
                    <p class="tx-color-02 mb-2 lh-10">
                      <b><?=$s_name?></b> <br>
                      <?=$s_phone?><br>
                      <?=$s_email?><br>
                      <?=$s_address?><br>
                    </p>
                </div>
                
                
                
                
                <div class="sub-totle-table mt-3 df-example px-3 py-2 rounded">
                    <ul class="list-unstyled lh-7 mb-0">
                      <li class="d-flex justify-content-between bd-b py-2">
                        <span>Sub-Total</span>
                        <span><i class="fas fa-rupee-sign"></i> <?=$subtotal?></span>
                      </li>
                      <li class="d-flex justify-content-between bd-b py-2">
                        <span>Shipping Charge</span>
                        <span><i class="fas fa-rupee-sign"></i> <?=$order[0]['ship_charge']?></span>
                      </li>
                      
                       
                       
                      <li class="d-flex justify-content-between bd-b py-2">
                        <span>Discount</span>
                        <span>- <i class="fas fa-rupee-sign"></i> <?=$discount_value?></span>
                      </li>
                      
                       <li class="d-flex justify-content-between bd-b py-2">
                        <span>Promo Wallet</span>
                        <span>- <i class="fas fa-rupee-sign"></i> <?=$order[0]['promo_wallet_amount']?></span>
                      </li>
                      
                       <li class="d-flex justify-content-between bd-b py-2">
                        <span>Wallet</span>
                        <span>- <i class="fas fa-rupee-sign"></i> <?=$order[0]['wallet_amount']?></span>
                      </li>
                      
                      <li class="d-flex justify-content-between py-2">
                        <strong>Total</strong>
                        <strong><i class="fas fa-rupee-sign"></i> <?=$total?></strong>
                      </li>
                    </ul>
                  </div>
              </div>
            </div>
          </div>
          
          
         
         
         
          
          
          
          
           
           
          
          

        </div>


        <!-- container --> 

      </div>

    </div>

    <?php include('includes/footer.php');?>

  </div>

  

  <!-- container --> 

</div>

</div>











<div class="modal fade" id="add-inq" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">

    <div class="modal-content tx-14">

      <div class="modal-header">

        <h6 class="modal-title" id="exampleModalLabel2">Shipping Address</h6>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>

      </div>

      <div class="modal-body">



      

        

         <form action="" method="post" class="form-horizontal form-bordered form-validate9" data-parsley-validate>

               

        <? $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>"save_add"), "act");?>

        

        <? $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>$shipping_info[0]["order_master_id"]), "o_id");?>



        

          <? $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>$shipping_info[0]["id"]), "address_id");?>

       



        

        



        



         

         

         

         

         <div class="row">



         



            

            

            <div class="form-group col-md-6">



              <label for="example-nf-email">First Name. *</label>



               <input type="text" class="form-control required" name="fname" id="fname" value="<?php echo $shipping_info[0]["fname"]?>"  autocomplete="off" required>



               



              



           



             



            </div>

            

            

            <div class="form-group col-md-6">



              <label for="example-nf-email">Last Name. *</label>



               <input type="text" class="form-control required" name="lname" id="lname" value="<?php echo $shipping_info[0]["lname"]?>"  autocomplete="off" required>



               



              



           



             



            </div>

            

            

            



          



        </div>

        

        

        

        



        





<div class="row">



            <div class="form-group col-md-12">



              <label for="example-nf-email">Address Line 1: Area, Locality, Flat, Building, Company, Apartment *</label>



               <textarea class="form-control required" name="address1" id="address1" autocomplete="off" required><?php echo $shipping_info[0]["address"]?></textarea>



               



              



           



             



            </div>

            

            <div class="form-group col-md-9">



              <label for="example-nf-email">Address Line 2: House/ Flat/ Office No. </label>



               <input type="text" class="form-control" name="unit" id="unit" value="<?php echo $shipping_info[0]["unit"]?>"  autocomplete="off">



               



              



           



             



            </div>

            

            <div class="form-group col-md-3">



              <label for="example-nf-email">Entry Code</label>



               <input type="text" class="form-control" name="entry_code" id="entry_code" value="<?php echo $shipping_info[0]["entry_code"]?>"  autocomplete="off">



               



              



           



             



            </div>

            

            

            





        </div>

        

        

        <div class="row">



          <div class="form-group col-md-4">



              <label for="example-nf-email">Ext.</label>



               <input type="text" class="form-control" name="ext" id="ext" value="<?php echo $shipping_info[0]["ext"]?>"  autocomplete="off">



               



              



           



             



            </div>



            <div class="form-group col-md-8">



              <label for="example-nf-email">Phone number *</label>



               <input type="text" class="form-control required number" name="phone" id="phone" value="<?php echo $shipping_info[0]["phone"]?>" placeholder="XXX-XXX-XXXX"  autocomplete="off" required>



               



              



           



             



            </div>

            

            

            

            

            



          



        </div>

        



        

        

        

        <div class="row">



          



            <div class="form-group col-md-4">



              <label for="example-nf-email">City *</label>



               <input type="text" class="form-control required" name="city" id="city" value="<?php echo $shipping_info[0]["city"]?>"  autocomplete="off" required>



               



              



           



             



            </div>

            

            <div class="form-group col-md-4">



              <label for="example-nf-email">State *</label>



               <input type="text" class="form-control required" name="province" id="province" value="<?php echo $shipping_info[0]["province"]?>"  autocomplete="off" required>



               



              



           



             



            </div>

            

            <div class="form-group col-md-4">



              <label for="example-nf-email">Zip code *</label>



               <input type="text" class="form-control" name="zipcode" id="zipcode" value="<?php echo $shipping_info[0]["zipcode"]?>" autocomplete="off" required>



               



              



           



             



            </div>

            

            

            



        



        </div>



        



        <div class="row">



         

          

          



            <div class="form-group col-md-12">



              <label for="example-nf-email">Address-specific instructions</label>



              <textarea class="form-control" name="address_instruction" id="address_instruction"  rows="4" autocomplete="off"><?php echo $shipping_info[0]["address_instruction"]?></textarea>

              



            </div>

            

            

          

         



            





          



        </div>



               

        



        



        



        <div class="row">

        

          <div class="form-group form-actions col-md-12">

            <button type="submit" class="btn btn-effect-ripple btn-success">Submit</button>

            <a href="javascript:void(0)" class="btn btn-effect-ripple btn-danger" data-dismiss="modal" aria-hidden="true"  >Cancel</a>



          </div>

          



        </div>



        <?=$this->htmlBuilder->closeForm()?>



        <!-- END General Elements Content --> 

        



        



      </div>

    </div>

  </div>

</div>









<div class="modal fade" id="refund-wallet" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">

    <div class="modal-content tx-14">

      <div class="modal-header">

        <h6 class="modal-title" id="exampleModalLabel2">Order <strong id="voucher_name_1"> --- </strong> - Refund In Wallet</h6>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>

      </div>

      <div class="modal-body">

        <form action="" method="post" class="form-horizontal form-bordered form-validate2" data-parsley-validate>

          <? $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>""), "r_order_id") ?>

          <? $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>"refund_amount_wallet"), "act") ?>

          <? $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>"0"), "r_check_amt") ?>

          <div class="form-group">

            <div class="col-xs-12">

              <label>Refund Amount</label>

              <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control numbersOnly required number","id"=>"r_amount","name"=>"r_amount","placeholder"=>"Refund Amount","value"=>"","required"=>""), "") ?>

            </div>

          </div>

          <div class="form-group">

            <div class="col-xs-12">

              <label>Remark</label>

              <? $this->htmlBuilder->buildTag("textarea", array("class"=>"form-control required","id"=>"r_text","name"=>"r_text","placeholder"=>"Remark","required"=>""), "") ?>

            </div>

          </div>

          

          

          <div class="form-group">

            <div class="col-xs-12">

              <label>SMS Text</label>

              <? $this->htmlBuilder->buildTag("textarea", array("class"=>"form-control required","id"=>"sms_text","name"=>"sms_text","placeholder"=>"SMS Text","value"=>$this->refund_sms_text), "") ?>

            </div>

          </div>

          

          

          

          <div class="form-group">

            <div class="col-xs-12">

              <div class="custom-control custom-checkbox">

                <input type="checkbox" name="send_sms" id="del122"  value="yes" class="custom-control-input" >

                <label class="custom-control-label" for="del122"> Send sms to customer?</label>

              </div>

            </div>

          </div>

          <div class="form-group form-actions">

            <div class="col-xs-12 text-right">

              <button type="submit" class="btn btn-effect-ripple btn-success">Submit</button>

            </div>

          </div>

        </form>

      </div>

    </div>

  </div>

</div>



<div class="modal fade" id="refund-wallet-stripe" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">

    <div class="modal-content tx-14">

      <div class="modal-header">

        <h6 class="modal-title" id="exampleModalLabel2">Order <strong id="voucher_name_rc"><?=$id?></strong> - Refund In Wallet</h6>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>

      </div>

      <div class="modal-body">

        <form action="" method="post" class="form-horizontal form-bordered form-validate2" data-parsley-validate>

          <? $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>$id), "r_orderID") ?>

          <? $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>"refund_amount_wallet_manually"), "act") ?>

          <? $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>$final_refund_amt), "Check_Amount") ?>

          <div class="form-group">

            <div class="col-xs-12">

              <label>Refund Amount *</label>

              <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control numbersOnly required number","id"=>"ramount","name"=>"ramount","placeholder"=>"Refund Amount","value"=>$final_refund_amt,"required"=>""), "") ?>

            </div>

          </div>

          

          

          

          <div class="form-group">

          

         

          

            <div class="col-xs-6" style="width:45%; float:left;    margin-right: 5%;">

              <label>Transction Date *</label>

             

              

              

               <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control end_date input-datepicker","id"=>"example-datepicker34","required"=>"","name"=>"trns_date","placeholder"=>"","data-date-format"=>"mm/dd/yyyy","value"=>""), "") ?>

            </div>

            

            <div class="col-xs-6" style="width:50%; float:left">

              <label>Transction ID *</label>

              <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control required","id"=>"trnsID","name"=>"trnsID","placeholder"=>"","value"=>'',"required"=>""), "") ?>

            </div>

            

           

          </div>

          

          

          

          

          

          

          

          <div class="form-group">

            <div class="col-xs-12">

              <label>Remark *</label>

              <? $this->htmlBuilder->buildTag("textarea", array("class"=>"form-control required","id"=>"remark_text","name"=>"remark_text","placeholder"=>"Remark","required"=>""), "") ?>

            </div>

          </div>

          

          

          

          <div class="form-group">

            <div class="col-xs-12">

              <label>SMS Text</label>

              <? $this->htmlBuilder->buildTag("textarea", array("class"=>"form-control required","id"=>"sms_text","name"=>"sms_text","placeholder"=>"SMS Text","value"=>$this->refund_sms_text_stripe), "") ?>

            </div>

          </div>

          

          

          <div class="form-group">

            <div class="col-xs-12">

              <div class="custom-control custom-checkbox">

                <input type="checkbox" name="send_sms" id="del134"  value="yes" class="custom-control-input" >

                <label class="custom-control-label" for="del134"> Send sms to customer?</label>

              </div>

            </div>

          </div>

          

          

          

          

          

          <div class="form-group form-actions">

            <div class="col-xs-12 text-right">

              <button type="submit" class="btn btn-effect-ripple btn-success">Submit</button>

            </div>

          </div>

        </form>

      </div>

    </div>

  </div>

</div>



<div class="modal fade" id="refund-customer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">

    <div class="modal-content tx-14">

      <div class="modal-header">

        <h6 class="modal-title" id="exampleModalLabel2">Order <strong id="voucher_name_2"> --- </strong> - Refund In Customer Account</h6>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>

      </div>

      <div class="modal-body">

        <form action="" method="post" class="form-horizontal form-bordered form-validate2" data-parsley-validate>

          <? $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>""), "rc_order_id") ?>

          <? $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>"refund_amount_customer"), "act") ?>

          <? $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>"0"), "rc_check_amt") ?>

          <div class="form-group">

            <div class="col-xs-12">

              <label>Refund Amount</label>

              <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control numbersOnly required number","id"=>"rc_amount","name"=>"rc_amount","placeholder"=>"Refund Amount","value"=>"","required"=>""), "") ?>

            </div>

          </div>

          <div class="form-group">

            <div class="col-xs-12">

              <label>Remark</label>

              <? $this->htmlBuilder->buildTag("textarea", array("class"=>"form-control required","id"=>"rc_text","name"=>"rc_text","placeholder"=>"Remark","required"=>""), "") ?>

            </div>

          </div>

          

          <div class="form-group">

            <div class="col-xs-12">

              <label>SMS Text</label>

              <? $this->htmlBuilder->buildTag("textarea", array("class"=>"form-control required","id"=>"sms_text","name"=>"sms_text","placeholder"=>"SMS Text","value"=>$this->refund_sms_text_stripe), "") ?>

            </div>

          </div>

          

          

          <div class="form-group">

            <div class="col-xs-12">

              <div class="custom-control custom-checkbox">

                <input type="checkbox" name="send_sms" id="del13"  value="yes" class="custom-control-input" >

                <label class="custom-control-label" for="del13"> Send sms to customer?</label>

              </div>

            </div>

          </div>

          

          

          

          <div class="form-group form-actions">

            <div class="col-xs-12 text-right">

              <button type="submit" class="btn btn-effect-ripple btn-success">Submit</button>

            </div>

          </div>

        </form>

      </div>

      

    </div>

  </div>

</div>





<div class="modal fade" id="order-collect" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">

    <div class="modal-content tx-14">

      <div class="modal-header">

        <h6 class="modal-title" id="exampleModalLabel2">Order <strong><?=$id?></strong> - Payment </h6>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>

      </div>

      <div class="modal-body">
      

        <form action="" method="post" class="form-horizontal form-bordered form-validate2" data-parsley-validate>

          <? $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>$id), "collect_order_id") ?>

           <? $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>$customer_id), "customer_id") ?>

          

          <? $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>"collected_order_payment"), "act") ?>

          

		  

          <div class="form-group">

            <div class="col-xs-12">

              <label>Amount *</label>

              <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control numbersOnly required number","id"=>"collect_amount","name"=>"collect_amount","placeholder"=>"","value"=>$pay_Final,"required"=>"","readonly"=>"readonly"), "") ?>

            </div>

          </div>

          

          

          <div class="form-group">

            <div class="col-xs-12">

              <label>TransctionID *</label>

              <? $this->htmlBuilder->buildTag("input", array("class"=>"form-control required","id"=>"c_transctionid","name"=>"c_transctionid","placeholder"=>"TransctionID","required"=>""), "") ?>

            </div>

          </div>

          

           <div class="form-group">

            <div class="col-xs-12">

              <label>Transction Date *</label>

            

            

              

               <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control start_date input-datepicker required","id"=>"example-datepicker3","name"=>"trans_date","placeholder"=>"Transction Date","data-date-format"=>"mm/dd/yyyy","required"=>""), "") ?>

            </div>

          </div>

          

          

          <div class="form-group">

            <div class="col-xs-12">

              <label>Remark</label>

              <? $this->htmlBuilder->buildTag("input", array("class"=>"form-control","id"=>"remark","name"=>"remark"), "") ?>

            </div>

          </div>

          

          <div class="form-group">

            <div class="col-xs-12">

              <div class="custom-control custom-checkbox">

                <input type="checkbox" name="sms_flag" id="del199"  value="yes" class="custom-control-input" >

                <label class="custom-control-label" for="del199"> Send sms to customer?</label>

              </div>

            </div>

          </div>

          

          

          <div class="form-group form-actions">

            <div class="col-xs-12 text-right">

              <button type="submit" class="btn btn-effect-ripple btn-success">Submit</button>

            </div>

          </div>

        </form>

      </div>

    </div>

  </div>

</div>



<script src="lib/jquery/jquery.min.js"></script> 

<script src="lib/bootstrap/js/bootstrap.bundle.min.js"></script> 

<script src="lib/feather-icons/feather.min.js"></script> 

<script src="lib/perfect-scrollbar/perfect-scrollbar.min.js"></script> 

<script src="lib/prismjs/prism.js"></script> 

<script src="lib/parsleyjs/parsley.min.js"></script> 

<script src="lib/datatables.net/js/jquery.dataTables.min.js"></script> 

<script src="lib/datatables.net-dt/js/dataTables.dataTables.min.js"></script> 

<script src="lib/datatables.net-responsive/js/dataTables.responsive.min.js"></script> 

<script src="lib/datatables.net-responsive-dt/js/responsive.dataTables.min.js"></script> 

<script src="assets/js/dashforge.aside.js"></script> 

<script src="assets/js/dashforge.js"></script>



<!-- other include --> 

<script src="lib/alert/js/sweet-alert.min.js"></script> 

<script src="lib/alert/js/jquery.sweet-alert.init.js"></script> 



<!-- file upload  --> 

<script src="lib/bootstrap-file/js/fileupload.js"></script> 



<!-- image popup --> 

<script src="lib/magnific-popup/js/jquery.magnific-popup.js"></script> 



<script src="lib/validate/js/jquery.validate.min.js"></script> 



<!-- Custom --> 

<script src="scripts/js/subziwalla.js"></script>

<script src="scripts/js/order.js"></script> 







<script>



function changemsg(a,f_name)

{

	

	var id=$('#order_id').val();

	

	

	

	if(a=='Paid')

	{

		$('#message').val('Hi '+f_name+', your Subziwalla order (#'+id+') is confirmed! You\'\ll receive an email shortly with your order details');

			

	}

	else if(a=='Processing')

	{

		//$('#message').val('Great news '+f_name+'!  Your Subziwalla order (#'+id+') is on its way! It\'\ll be delivered to your door before 8pm today. Stayed tuned for an update when it\'\s delivered.');

		

		

		$('#message').val('Great news '+f_name+'! Your Subziwalla order (#'+id+') is getting prepped. We look forward to shipping it on {delivery_date}');

		

		

		

		

	}

	else if(a=='Dispatched')

	{

		$('#message').val('Great news '+f_name+'!  Your Subziwalla order (#'+id+') is on its way! It\'\ll be delivered to your door before 8pm today. Stayed tuned for an update when it\'\s delivered.');

	}

	else if(a=='Out for Delivery')

	{

		$('#message').val("<?=$this->sms_delivery_data?>");

	}

	else if(a=='Arrived')

	{

		$('#message').val('Your Pakage with order id (#'+id+') will be delivered today by Subziwalla agent (1234567890) on or before 5.00 PM.');

	}

	else if(a=='Delivered')

	{

		$('#message').val('Your Subziwalla order (#'+id+') is waiting at your door! No need to rush - your groceries are safe from the elements and will remain fresh until you get home. Happy cooking! ');

	}

	else if(a=='Canceled')

	{

		$('#message').val('');

	}

}

function get_refund_amount_wallet(id,amount)

{

	

	$("#voucher_name_1").html('#'+id);

	

	$("#r_order_id").val(id);

	$("#r_amount").val(amount);

	$("#r_check_amt").val(amount);

	

	$("#r_text").val('');

	

}

function get_refund_amount_customer(id,amount)

{

	

	$("#voucher_name_2").html('#'+id);

	$("#rc_order_id").val(id);

	$("#rc_amount").val(amount);

		$("#rc_check_amt").val(amount);

	$("#rc_text").val('');

	

}



function cancel_shipment(optns)

{

	 swal({

                title: "Are you sure?",

                text: "Cancel Shipment!",

                type: "warning",

                showCancelButton: true,

                confirmButtonClass: 'btn-warning',

                confirmButtonText: "Yes, Cancel it!",

				confirmButtonClass: "confirm btn btn-lg btn-warning xyz",

                closeOnConfirm: false

            }, function (r) 

			{

				if(r == true)

				{

					var frm = $("<form>", {'method':'post'});

					for(key in optns)

					{

						$("<input>", {'type':'hidden', 'name':key, 'value':optns[key]}).appendTo(frm);

					}

					frm.appendTo("body");

					frm.submit();

					

					

					$(".cancel").hide();

					$(".confirm").hide();

					

					

					$(".text-muted").html("Please Wait...");

					

					

					

					



				}

				else

				{

					return false;

				}

            });

}



</script> 



<script>



// customer Form Validation

$(document).on("click",".note_modal_submit", function () 

{



    $('#customer_notes_form').validate({

		

		



		errorClass: 'help-block animation-slideUp', // You can change the animation class for a different entrance animation - check animations page

		errorElement: 'div',

		errorPlacement: function(error, e) {

			e.parents('.form-group > div').append(error);

		},

		highlight: function(e) {

			$(e).closest('.form-group').removeClass('has-success has-error').addClass('has-error');

			$(e).closest('.help-block').remove();

		},

		success: function(e) {

			

			e.closest('.form-group').removeClass('has-success has-error');

			e.closest('.help-block').remove();

		},		

	



		 



		rules: 



		{



        subject: {



            required: true, 



            



        },

		

		phone: {



           		required: true, 



				minlength:10,



				maxlength:10  



            



        },

		zipcode: {



           		required: true, 



				minlength:5,



				maxlength:5  



            



        },





		



		},



		submitHandler: function (form)



		{

			

						

			//var dataString ='method=table_customer_addedit&'+$('#customer_form').serialize();

					

			$('button[type="submit"]').attr("disabled","disabled");

		

		

			var dataString = new FormData(form);

			dataString.append('method', 'customer_module');

			dataString.append('action', 'customer_notes_addedit');

						

			

			$.ajax({



                dataType: 'json',

                type: "POST",

				url: "scripts/ajax_module/index.php",

				data: dataString,

				cache:false,

          	  	contentType: false,

           	 	processData: false,

	 			success: function (responseData) 



				{



				  if(responseData.RESULT==1)



						{





							$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.MESSAGE+'</p>', {type:'danger',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20}

                });

				

							$('button[type="submit"]').removeAttr("disabled","disabled");



						



						}

				

						else  if(responseData.RESULT==0)



						{





							$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.MESSAGE+'</p>', {type:'success',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20}

                });

							

							

							

							$('button[type="submit"]').removeAttr("disabled","disabled");

							

							

							

							

							

							

							

							

							

						}



                                    



                },



                error: function (responseData) {



                    console.log('Ajax request not recieved!');



                }



            });



           

            return false; 



        }

    });

});

</script>

<script src="lib/jqueryui/jquery-ui.min.js"></script> 

<script>

      $(function(){

        'use strict'

		

		$('.input-datepicker').datepicker();

		

		

        var dateFormat = 'mm/dd/yy',

        from = $('#dateFrom')

        .datepicker({

          defaultDate: '+1w',

          numberOfMonths: 2

        })

        .on('change', function() {

          to.datepicker('option','minDate', getDate( this ) );

        }),

        to = $('#dateTo').datepicker({

          defaultDate: '+1w',

          numberOfMonths: 2

        })

        .on('change', function() {

          from.datepicker('option','maxDate', getDate( this ) );

        });

        function getDate( element ) {

          var date;

          try {

            date = $.datepicker.parseDate( dateFormat, element.value );

          } catch( error ) {

            date = null;

          }

          return date;

        }

      });

    </script> 