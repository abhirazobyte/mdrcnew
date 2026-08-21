<link href="lib/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
<link href="lib/ionicons/css/ionicons.min.css" rel="stylesheet">
<link href="lib/typicons.font/typicons.css" rel="stylesheet">
<link href="lib/prismjs/themes/prism-vs.css" rel="stylesheet">
<link href="lib/datatables.net-dt/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css" rel="stylesheet">
<link rel="stylesheet" href="assets/css/dashforge.auth.css">
<link href="lib/select2/css/select2.min.css" rel="stylesheet">
<!-- DashForge CSS -->
<link rel="stylesheet" href="assets/css/dashforge.css">
<link rel="stylesheet" href="assets/css/dashforge.demo.css">




<!-- Custom CSS -->
<link rel="stylesheet" href="assets/css/custom.css">

<!--Sweet Alert CSS & JS -->
<link href="lib/alert/css/sweet-alert.css" rel="stylesheet" type="text/css" />

<!-- file upload  --> 
<link href="lib/bootstrap-file/css/fileupload.css" rel="stylesheet" type="text/css" />

<!--image popup -->
<link href="lib/magnific-popup/css/magnific-popup.css" rel="stylesheet" type="text/css" />

<style>
#cat_include
{
	width: 40%;
    margin-top: 10px;
	
}
.form-group {
	margin-bottom: 0px;
}
.scrollbox {
	overflow-y: scroll;
	max-height: 220px;
	border: 1px solid #dae0e8;
}
.even {
	margin-left: 20px;
}
.d_none {
	display:none !important;
}
label.error {
	display:none !important;
}
input.error {
	border:1px solid red !important;
}
.demo-forms {
	margin-bottom:20px;
}
</style>
<?php include('includes/menu.php');?>
<div class="content ht-100v pd-0">
  <?php include('includes/header.php');?>
  <!-- content-header -->
  <div class="content-body">
    <div class="container pd-x-0">
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
          <h4 class="mg-b-0 tx-spacing--1">
            <?=$this->to_do?>
            <?=$this->manage_for?>
          </h4>
        </div>
      </div>
      <p class="mg-b-30"></p>
      <div class="row">
        <div class="col-md-8">
          <?=$this->utility->get_message();?>
          <div class="alert alert-danger alert-dismissable" id="eroormessage_o" style="display:none">
            <p id="error_msg"></p>
          </div>
          <!-- General Elements Block -->
          <? $this->htmlBuilder->buildTag("form", array("action"=>"","class"=>"form-validate_bb"), "frm_user_addedit");?>
          <? $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>$this->id), "id");?>
          <? $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>$this->getGetVar('pg_no')), "pg_no");?>
          <? $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>"update_data"), "act");?>
          <div data-label="Example" class="df-example demo-forms">
            <div class="block pb-20"> 
              <!-- General Elements Title -->
              
              <div class="row">
                <div class="col-md-12">
                  <label class="fs-16 mb-10 example-nf-email box_title" for="example-email">Discount code <span class="tx-danger">*</span></label>
                </div>
                <div class="col-md-8">
                  <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control  required"), "coupon_code") ?>
                  <?php if($this->id==''){?>
                </div>
                <div class="col-md-4"> <a onclick="generate_code()" class="btn  btn-primary" style="color:#fff">Generate Code</a>
                  <?php }?>
                </div>
              </div>
              
              
              
              
              <div class="row mt-10">
                <div class="col-md-4">
                  <label class="fs-16 mb-10 example-nf-email box_title" for="example-email">Display Code (Website & App)</label>
                  <? $this->htmlBuilder->buildTag("select", array("values"=>array("No"=>"No","Yes"=>"Yes"),"class"=>"form-control  required"), "display_list") ?>
                </div>
                
                
              </div>
              
              
              
              
              
            </div>
          </div>
          <div data-label="Example" class="df-example demo-forms">
            <div class="block">
              <div class="form-bordered">
                <?php
				
				  $ship_discount_new_box='';
			  if($this->id=='')
			  {
				  $Percentage='checked="checked"';
				  $fixed_amount='';
				  $free_shipping='';
				  $buy_x_Y='';
				   $shipping_value_entire_box='style="display:none"';
				   $buy_x_y_value_box='style="display:none"';
				   $minimum_req_box='';
				   $customer_elig_box='';
				   $shipping_value_box='style="display:none"';
				   $symbol='%';
				   $max_discount_box='';
				   
				 
			  }
			  else
			  {
				  $types=$this->rs_coupons['type'];
				  if($types=='Percentage')
				  {
					   	$Percentage='checked="checked"';
					  	$fixed_amount='';
					  	$free_shipping='';
					  	$buy_x_Y='';
					   $shipping_value_entire_box='style="display:none"';
					   $buy_x_y_value_box='style="display:none"';
					   $minimum_req_box='';
					   $customer_elig_box='';
					   $discoun_value_box='';
					   $shipping_value_box='style="display:none"';
					   $symbol='%';
					   $max_discount_box='';
				  }
				  else  if($types=='Fixed amount')
				  {
					   	$Percentage='';
					  	$fixed_amount='checked="checked"';
					  	$free_shipping='';
					  	$buy_x_Y='';
					   $shipping_value_entire_box='style="display:none"';
					   $buy_x_y_value_box='style="display:none"';
					   $minimum_req_box='';
					   $customer_elig_box='';
					   $discoun_value_box='';
					   $shipping_value_box='style="display:none"';
					   $symbol='<i class="fas fa-rupee-sign"></i>';
					   $max_discount_box='style="display:none"';
				  }
				  else  if($types=='Free shipping')
				  {
					   	$Percentage='';
					  	$fixed_amount='';
					  	$free_shipping='checked="checked"';
					  	$buy_x_Y='';
					   $shipping_value_box='';
					   //Cond
					   $shipping_value_entire_box='';
					   //$discoun_value_box='style="display:none"';
					   
					   $discoun_value_box='';
					   $buy_x_y_value_box='style="display:none"';
					   $minimum_req_box='';
					   $customer_elig_box='';
					   $symbol='<i class="fas fa-rupee-sign"></i>';
					   $max_discount_box='style="display:none"';
					   
					    $ship_discount_new_box='style="display:none"';
				  }
				   else  if($types=='Buy X get Y')
				  {
					   	$Percentage='';
					  	$fixed_amount='';
					  	$free_shipping='';
					  	$buy_x_Y='checked="checked"';
					   $shipping_value_entire_box='style="display:none"';
					   $buy_x_y_value_box='';
					   $discoun_value_box='style="display:none"';
					   $shipping_value_box='style="display:none"';
					   $minimum_req_box='style="display:none"';
					   $customer_elig_box='style="display:none"';
					   $symbol='<i class="fas fa-rupee-sign"></i>';
					   $max_discount_box='style="display:none"';
				  }
			  }
			  ?>
                <div class="form-group">
                  <label class="fs-16 example-nf-email box_title" for="example-email">Types <span class="tx-danger">*</span></label>
                  <div class="radio">
                    <label for="example-radio1">
                      <input type="radio" id="example-radio1" name="types" value="Percentage" <?=$Percentage?> onchange="show_discount_type_data('Percentage')">
                      Percentage </label>
                  </div>
                  <div class="radio">
                    <label for="example-radio2">
                      <input type="radio" id="example-radio2" name="types" value="Fixed_Amount" <?=$fixed_amount?> onchange="show_discount_type_data('Fixed_Amount')">
                      Fixed amount </label>
                  </div>
                  <div class="radio" style="display:none">
                    <label for="example-radio3">
                      <input type="radio" id="example-radio3" name="types" value="Free_Shipping" <?=$free_shipping?> onchange="show_discount_type_data('Free_Shipping')">
                      Free shipping </label>
                  </div>
                  <div class="radio" style="display:none">
                    <label for="example-radio34">
                      <input type="radio" id="example-radio34" name="types" value="Buy_X_Y" <?=$buy_x_Y?> onchange="show_discount_type_data('Buy_X_Y')">
                      Buy X get Y </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div data-label="Example" class="df-example demo-forms" id="discoun_value_box" <?=$discoun_value_box?>>
            <div class="form-bordered ship_discount_new_box" <?=$ship_discount_new_box?>>
              <div class="form-group" >
                <div class="row">
                  <div class="col-md-12">
                    <label class="fs-16 example-nf-email box_title" for="example-email">Discount value <span class="dis_symbol">(
                      <?=$symbol?>
                      )</span> <span class="tx-danger">*</span> </label>
                  </div>
                  <div class="col-md-3">
                    <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control numbersOnly  required number"), "amount") ?>
                  </div>
                </div>
              </div>
              <div class="form-group" id="max_discount_box" <?=$max_discount_box?>>
                <div class="row">
                  <div class="col-md-12">
                    <label class="fs-16 example-nf-email box_title" for="example-email">Maximum Discount <span class="dis_symbol1">(<i class="fas fa-rupee-sign"></i>)</span> <span class="tx-danger">*</span></label>
                  </div>
                  <div class="col-md-3">
                    <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control numbersOnly  required number"), "max_amount") ?>
                  </div>
                </div>
              </div>
            </div>
            
            
            <div class="form-bordered">
              	<div class="form-group">
                	<label class="pt-20 fs-16 example-nf-email" for="example-email">APPLIES TO</label>
                	<?php
					  	if($this->id=='')
					  	{
							$entire_order='checked="checked"';
							$specific_category='';
							$all_item='checked="checked"';
							$hideBoxOnChange='d-none';
							$specific_item='';
							$specific_product='';
							$ap_category_box='style="display:none"';
							$ap_product_box='style="display:none"';
						}
						else
						{
							$category_ids=$this->coupon_info['category_ids'];
							$item_ids=$this->coupon_info['item_ids'];
							$product_ids=$this->coupon_info['product_ids'];
							if($item_ids!=''){
								$all_item='';
								$hideBoxOnChange='';
								$specific_item='checked="checked"';
							} else {
								$all_item='checked="checked"';
								$hideBoxOnChange='d-none';
								$specific_item='';
							}
							if($category_ids!='')
							{
								$specific_category='checked="checked"';
								$entire_order='';
								$specific_product='';
								$ap_category_box='';
								$ap_product_box='style="display:none"';
							}
							elseif($product_ids!='')
							{
								$specific_product='checked="checked"';
								$specific_category='';
								$entire_order='';
								$ap_category_box='style="display:none"';
								$ap_product_box='';
								
								$obj_model_product_n = $this->load_model("product_option");
								$obj_model_product_n->join_table("product", "left", array(), array("product_id"=>"id"));
								$rs_product_n = $obj_model_product_n->execute("SELECT", false, "", "product_option.id IN (".$product_ids.")");
							}
							else
							{
								$entire_order='checked="checked"';
								$specific_category='';
								$specific_product='';
								$ap_category_box='style="display:none"';
								$ap_product_box='style="display:none"';
						  	}
					  	}
					?>

					<!-- ------------------------------------------------------------ -->
					<!-- -------------------- START : APPLY TYPE -------------------- -->
					<!-- ------------------------------------------------------------ -->
					<div class="radio ship_discount_new_box" <?=$ship_discount_new_box?>>
						<label for="example-radio4">
							<input type="radio" id="example-radio4" name="applies_type" value="Entire_Order" <?=$entire_order?> onchange="show_applies_type_box('Entire_Order')">
						All City </label>
					</div>

					<div class="radio">
						<label for="example-radio5">
							<input type="radio" id="example-radio5" name="applies_type" value="Specific_Category" <?=$specific_category?> onchange="show_applies_type_box('Specific_Category')">
						Specific City </label>
					</div>
					
            
					<div class="form-group" id="category_box" <?=$ap_category_box?>>
						<?php if($this->id==NULL){?>
							<select id="example-chosen-multiple" name="work_item[]" class="select-chosen select2" data-placeholder="Select category.." multiple>
								<? for($i=0;$i<count($this->work);$i++){?>
									<option value="<?=$this->work[$i]['id']?>" >
										<?=$this->work[$i]['name']?>
									</option>
								<?php }?>
							</select>
							<div class="h10"></div>
						<?php }else{?>
							<select id="example-chosen-multiple" name="work_item[]" class="select-chosen select2" data-placeholder="Select category.." multiple>
								<? for($i=0;$i<count($this->work);$i++) {
									$micro_items=explode(',',$this->coupon_info['category_ids']); ?>
									<option  value="<?=$this->work[$i]['id']; ?>"
										<? for($j=0;$j<count($micro_items);$j++) {
											if($this->work[$i]['id']==trim($micro_items[$j])){echo 'selected="selected"';}} ?>>
										<?=$this->work[$i]['name']; ?>
									</option>
								<?php } ?>
							</select>
						<?php }?>
						
						<?php if($this->id==NULL){
							$include_cat='checked="checked"' ;
							$not_include_cat='';
						}else{
							$include_cat='' ;
							$not_include_cat='';
							if($this->coupon_info['cat_include']=='Yes')
							{
								$include_cat='checked="checked"' ;
							}
							else
							{
								$not_include_cat='checked="checked"' ;
							}
						}?>
						<div class="form-group">
							<div class="radio">
							<label for="example-radio19999">
								<input type="radio" id="example-radio19999" name="cat_include" value="Yes" <?=$include_cat?>  >
								Include City </label>
							</div>
							<div class="radio">
							<label for="example-radio14999">
								<input type="radio" id="example-radio14999" name="cat_include" value="No" <?=$not_include_cat?>>
								Not Include City</label>
							</div>
						</div>
					</div>
					<!-- ------------------------------------------------------------ -->
					<!-- --------------------- END : APPLY TYPE --------------------- -->
					<!-- ------------------------------------------------------------ -->



					<!-- ------------------------------------------------------------ -->
					<!-- -------------------- START : APPLY ITEM -------------------- -->
					<!-- ------------------------------------------------------------ -->
					<div class="radio ship_discount_new_box mt-3" <?=$ship_discount_new_box?>>
						<label for="all_item_radio">
							<input type="radio" id="all_item_radio" name="applies_item" value="All Items" class="onChangeItemSelection" <?=$all_item?>>
						All Items </label>
					</div>

					<div class="radio">
						<label for="all_item_radio2">
							<input type="radio" id="all_item_radio2" name="applies_item" value="Specific Items" class="onChangeItemSelection" <?=$specific_item?>>
						Specific Items </label>
					</div>

					<div class="form-group hideBoxOnChange <?=$hideBoxOnChange?>" id="item_box">
						<?php if($this->id==NULL){?>
							<select id="example-chosen-multiple2" name="item_item[]" class="select-chosen select2 w-100" data-placeholder="Select item.." multiple>
								<? for($i=0;$i<count($this->item);$i++){?>
									<option value="<?=$this->item[$i]['id']?>" >
										<?=$this->item[$i]['name']?>
									</option>
								<?php }?>
							</select>
							<div class="h10"></div>
						<?php }else{?>
							<select id="example-chosen-multiple2" name="item_item[]" class="select-chosen select2 w-100" data-placeholder="Select item.." multiple>
								<? for($i=0;$i<count($this->item);$i++) {
									$micro_items=explode(',',$this->coupon_info['item_ids']); ?>
									<option  value="<?=$this->item[$i]['id']; ?>"
										<? for($j=0;$j<count($micro_items);$j++) {
											if($this->item[$i]['id']==trim($micro_items[$j])){echo 'selected="selected"';}} ?>>
										<?=$this->item[$i]['name']; ?>
									</option>
								<?php } ?>
							</select>
						<?php }?>
						
						<?php if($this->id==NULL){
							$include_cat='checked="checked"' ;
							$not_include_cat='';
						}else{
							$include_cat='' ;
							$not_include_cat='';
							if($this->coupon_info['item_include']=='Yes')
							{
								$include_cat='checked="checked"' ;
							}
							else
							{
								$not_include_cat='checked="checked"' ;
							}
						}?>
						<div class="form-group">
							<div class="radio">
							<label for="example-radio-item">
								<input type="radio" id="example-radio-item" name="item_include" value="Yes" <?=$include_cat?>  >
								Include Items </label>
							</div>
							<div class="radio">
							<label for="example-radio-item2">
								<input type="radio" id="example-radio-item2" name="item_include" value="No" <?=$not_include_cat?>>
								Not Include Items</label>
							</div>
						</div>
					</div>
					<!-- ------------------------------------------------------------ -->
					<!-- --------------------- END : APPLY ITEM --------------------- -->
					<!-- ------------------------------------------------------------ -->



				</div>

              <div class="form-group" id="product_box" <?=$ap_product_box?>>
                <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control","value"=>"","placeholder"=>"Search Products","autocomplete"=>"off"), "p_type") ?>
                <div class="products">
                  <ul id="products_data">
                    <?php for($i=0;$i<count($rs_product_n);$i++){?>
                    <li id="products_data_<?=$rs_product_n[$i]['id']?>">
                      <div class="row">
                        <input type="hidden" name="products_ids_data[]" value="<?=$rs_product_n[$i]['id']?>">
                        <div class="col-md-9">
                          <?=$rs_product_n[$i]['product_name']?>
                          -
                          <?=$rs_product_n[$i]['weight']?>
                        </div>
                        <div class="col-md-2">$
                          <?=$rs_product_n[$i]['price']?>
                        </div>
                        <div class="col-md-1"><a class="remove_products" href="javascript:void(0)" onclick="remove_products(<?=$rs_product_n[$i]['id']?>)">X</a></div>
                      </div>
                    </li>
                    <?php }?>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div data-label="Example" class="df-example demo-forms" id="shipping_value_box" <?=$shipping_value_box?>>
            <?php
			if($this->id=='')
			{
				$shipping_value_entire_box='style="display:none"';
				$exclude_shiping_type_ch='';
			}
			else
			{
				$exclude_shipping_rate=$this->coupon_info['exclude_shipping_rate'];
				if($exclude_shipping_rate>0)
				{
					$shipping_value_entire_box='';
					$exclude_shiping_type_ch='checked="checked"';
				}
				else
				{
					$shipping_value_entire_box='style="display:none"';
					$exclude_shiping_type_ch='';
				}
			}
			?>
            <div class="form-bordered">
              <div class="form-group" >
                <label class="example-nf-email box_title" for="example-email">SHIPPING RATES</label>
                <br/>
                <label class="checkbox-inline" for="example-inline-checkbox1">
                  <input type="checkbox" id="example-inline-checkbox1" name="exclude_shiping_type" value="Exclude Shipping" onchange="show_shipping_box();" <?=$exclude_shiping_type_ch?>>
                  Exclude shipping rates over a certain amount </label>
                <div class="row">
                  <div class="col-md-3">
                    <div id="shipping_value_entire_box" <?=$shipping_value_entire_box?>>
                      <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control mt-10 numbersOnly  required number","value"=>$exclude_shipping_rate), "exclude_shipping_rate_value") ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div data-label="Example" class="df-example demo-forms" id="buy_x_y_value_box" <?=$buy_x_y_value_box?>>
            <?php
				$buy_quantity=$this->coupon_info['buy_quantity'];
				$get_quantity=$this->coupon_info['get_quantity'];
				$buy_product_ids=$this->coupon_info['product_ids'];
				$get_product_ids=$this->coupon_info['get_product_ids'];
				if($buy_product_ids!='')
				{
					$obj_model_product_n = $this->load_model("product_option");
					$obj_model_product_n->join_table("product", "left", array(), array("product_id"=>"id"));
					$rs_product_buy = $obj_model_product_n->execute("SELECT", false, "", "product_option.id IN (".$buy_product_ids.")");
				}
				if($get_product_ids!='')
				{
					$obj_model_product_n = $this->load_model("product_option");
					$obj_model_product_n->join_table("product", "left", array(), array("product_id"=>"id"));
					$rs_product_get = $obj_model_product_n->execute("SELECT", false, "", "product_option.id IN (".$get_product_ids.")");
				}
			?>
            <div class="form-bordered">
              <div class="form-group" id="product_box" >
                <div class="row">
                  <div class="col-md-12">
                    <label class="fs-16 example-nf-email box_title" for="example-email">Customer buys</label>
                    <br/>
                  </div>
                  <div class="col-md-12">
                    <label class="example-nf-email" for="example-email">Quantity</label>
                  </div>
                  <div class="col-md-3">
                    <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control numbersOnly  required number","value"=>$buy_quantity), "buy_quantity") ?>
                  </div>
                  <div class="col-md-9">
                    <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control","value"=>"","placeholder"=>"Search Products"), "p_type_b") ?>
                  </div>
                  <div class="products col-md-12">
                    <ul id="products_data_b">
                      <?php for($i=0;$i<count($rs_product_buy);$i++){?>
                      <li id="products_data_b_<?=$rs_product_buy[$i]['id']?>">
                        <div class="row">
                          <input type="hidden" name="products_buy_ids_data[]" value="<?=$rs_product_buy[$i]['id']?>">
                          <div class="col-md-9"><?=$rs_product_buy[$i]['product_name']?> - <?=$rs_product_buy[$i]['weight']?></div>
                          <div class="col-md-2">$ <?=$rs_product_buy[$i]['price']?></div>
                          <div class="col-md-1"><a class="remove_products" href="javascript:void(0)" onclick="remove_products_b(<?=$rs_product_buy[$i]['id']?>)">X</a></div>
                        </div>
                      </li>
                      <?php }?>
                    </ul>
                    
                    
                    
                    <div class="notes"><strong>Note :</strong> Customer buy above selected products then discount will apply.</div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-bordered">
              <div class="form-group" id="product_box" >
                <div class="row">
                  <div class="col-md-12">
                    <label class="pt-20 example-nf-email box_title" for="example-email">Customer gets</label>
                    <br/>
                  </div>
                  <div class="col-md-12">
                    <label class="example-nf-email" for="example-email">Quantity</label>
                  </div>
                  <div class="col-md-3">
                    <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control numbersOnly  required number","value"=>$get_quantity), "get_quantity") ?>
                  </div>
                  <div class="col-md-9">
                    <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control","value"=>"","placeholder"=>"Search Products","autocomplete"=>"off"), "p_type_g") ?>
                  </div>
                  <div class="products col-md-12">
                    <ul id="products_data_g">
                      <?php for($i=0;$i<count($rs_product_get);$i++){?>
                      <li id="products_data_g_<?=$rs_product_get[$i]['id']?>">
                        <div class="row">
                          <input type="hidden" name="products_get_ids_data[]" value="<?=$rs_product_get[$i]['id']?>">
                          <div class="col-md-9"><?=$rs_product_get[$i]['product_name']?> - <?=$rs_product_get[$i]['weight']?></div>
                          <div class="col-md-2">$ <?=$rs_product_get[$i]['price']?></div>
                          <div class="col-md-1"><a class="remove_products" href="javascript:void(0)" onclick="remove_products_g(<?=$rs_product_get[$i]['id']?>)">X</a></div>
                        </div>
                      </li>
                      <?php }?>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-bordered">
              <?php
			  if($this->id=='')
			  {
				  $Free='checked="checked"';
				  $Percentage='';
				  $get_discount_value_box='style="display:none"';
			  }
			  else
			  {
				  $get_discount_value=$this->coupon_info['get_discount_value'];
				  if($get_discount_value>0)
				  {
					  $Free='';
					  $Percentage='checked="checked"';
				  	  $get_discount_value_box='';
				  }
				  else
				  {
					  $Free='checked="checked"';
				 	  $Percentage='';
				  	  $get_discount_value_box='style="display:none"';
				  }
			  }
			  ?>
              <div class="form-group">
                <label class="example-nf-email mt-10" for="example-email">AT A VALUE</label>
                <div class="radio">
                  <label for="example-radio88">
                    <input type="radio" id="example-radio88" name="discount_value_types" value="Free" <?=$Free?> onchange="show_get_discount_value_box('Free')">
                    Free </label>
                </div>
                <div class="radio" style="display:none">
                  <div class="row">
                    <div class="col-md-12">
                      <label for="example-radio99">
                        <input type="radio" id="example-radio99" name="discount_value_types" value="Percentage" <?=$Percentage?> onchange="show_get_discount_value_box('Percentage')">
                        Percentage</label>
                    </div>
                    <div class="col-md-3">
                      <div id="get_discount_value_box" <?=$get_discount_value_box?>>
                        <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control mt-10 numbersOnly required number","value"=>$get_discount_value), "get_discount_value") ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div data-label="Example" class="df-example demo-forms" id="minimum_req_box" <?=$minimum_req_box?>>
            <div class="form-bordered">
              <?php
			  if($this->id=='')
			  {
				  $None='checked="checked"';
				  $Minimum_Purchase_Amount='';
				  $min_purchase_amount_box='style="display:none"';
			  }
			  else
			  {
				 $order_amount=$this->rs_coupons['order_amount'];
				 if($order_amount>0)
				 {
					 $None='';
					 $Minimum_Purchase_Amount='checked="checked"';
				 	 $min_purchase_amount_box='';
			     }
				 else
				 {
					 $None='checked="checked"';
				 	 $Minimum_Purchase_Amount='';
				  	 $min_purchase_amount_box='style="display:none"';
			     }
			  }
			  ?>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-12">
                    <label class="fs-16 example-nf-email box_title" for="example-email">Minimum Requirements</label>
                  </div>
                  <div class="col-md-4">
                    <div class="radio">
                      <label for="example-radio11">
                        <input type="radio" id="example-radio11" name="requirement_types" value="None" <?=$None?> onchange="show_min_require_box('None')">
                        None </label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="radio mt-0">
                    <div class="col-md-12">
                      <label for="example-radio12">
                        <input type="radio" id="example-radio12" name="requirement_types" value="Minimum_Purchase_Amount" <?=$Minimum_Purchase_Amount?> onchange="show_min_require_box('Minimum_Purchase_Amount')">
                        Minimum purchase amount (<i class="fas fa-rupee-sign"></i>) <span class="tx-danger">*</span></label>
                    </div>
                    <div class="col-md-3">
                      <div id="min_purchase_amount_box" <?=$min_purchase_amount_box?>>
                        <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control mt-10 numbersOnly required number"), "order_amount") ?>
                        <span class="help-block">Applies to entire order.</span> </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div data-label="Example" class="df-example demo-forms" id="customer_elig_box" 
           <?=$customer_elig_box?> style="opacity: 0;position: fixed;">
            <div class="form-bordered">
              <?php
			  if($this->id=='')
			  {
				  $Everyone='checked="checked"';
				  $Specific_Customers='';
				  $customer_data_box='style="display:none"';
			  }
			  else
			  {
				 $customer_ids=$this->coupon_info['customer_ids'];
				 if($customer_ids!='')
				 {
					 $Everyone='';
					 $Specific_Customers='checked="checked"';
					 $customer_data_box='';
					    $obj_model_cust = $this->load_model("customer");
						$rs_cust = $obj_model_cust->execute("SELECT", false, "", "customer.id IN (".$customer_ids.")");
			     }
				 else
				 {
					 $Everyone='checked="checked"';
				 	 $Minimum_Purchase_Amount='';
					 $customer_data_box='style="display:none"';
			     }
			  }
			  ?>
              <div class="form-group" >
                <label class="fs-16 example-nf-email box_title" for="example-email">Customer Eligibility</label>
                <div class="radio">
                  <label for="example-radio13">
                    <input type="radio" id="example-radio13" name="customer_types" value="Everyone" <?=$Everyone?> onchange="show_customers_box('Everyone')">
                    Everyone </label>
                </div>
                <div class="radio">
                  <label for="example-radio14">
                    <input type="radio" id="example-radio14" name="customer_types" value="Specific_Customers" <?=$Specific_Customers?> onchange="show_customers_box('Specific_Customers')">
                    Specific Customers</label>
                </div>
              </div>
              <div class="form-group" id="customers_box" <?=$customer_data_box?>>
                <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control","value"=>"","placeholder"=>"Search Customers","autocomplete"=>"off"), "phone") ?>
                <div class="customers">
                  <ul id="customers_data">
                    <?php for($i=0;$i<count($rs_cust);$i++){?>
                    <li id="c_data_<?=$rs_cust[$i]['id']?>">
                      <div class="row">
                        <input type="hidden" name="customer_ids_data[]" value="<?=$rs_cust[$i]['id']?>">
                        <div class="col-md-4">
                          <?=$rs_cust[$i]['name']?>
                          <?=$rs_cust[$i]['last_name']?>
                        </div>
                        <div class="col-md-4">
                          <?=$rs_cust[$i]['phone']?>
                        </div>
                        <div class="col-md-4 text-right"><a class="remove_products" href="javascript:void(0)" onclick="remove_customers(<?=$rs_cust[$i]['id']?>)">X</a></div>
                      </div>
                    </li>
                    <?php }?>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <?php
if($this->id=='')
{
	$use_limit_entire_box='style="display:none"';
}
else
{
				$use_limit=$this->coupon_info['use_limit'];
				 if($use_limit>0)
				 {
					 $use_limit_ch='checked="checked"';
			 		 $use_limit_entire_box='';
			     }
				 else
				 {
					 $use_limit_ch='';
					 $use_limit_entire_box='style="display:none"';
			     }
				 $once_per_customer_type=$this->coupon_info['once_per_customer'];
				 if($once_per_customer_type=='Yes')
				 {
					  $once_per_customer_type_ch='checked="checked"';
			     }
				 else
				 {
					 $once_per_customer_type_ch='';
			     }
}
?>
          <div data-label="Example" class="df-example demo-forms" >
            <div class="form-bordered">
              <div class="form-group" >
                <div class="row">
                  <div class="col-md-12">
                    <label class="fs-16 example-nf-email box_title" for="example-email">Usage Limits</label>
                    <br/>
                  </div>
                  <div class="col-md-12">
                    <label class="checkbox-inline" for="example-inline-checkbox3">
                      <input type="checkbox" id="example-inline-checkbox3" name="use_limit_type" value="use_limit" onclick="show_limit_entire_box()" <?=$use_limit_ch?>>
                      Limit number of times this discount can be used in total </label>
                  </div>
                  <div class="col-md-3">
                    <div id="use_limit_entire_box" <?=$use_limit_entire_box?>>
                      <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"mt-10 mb-10 form-control numbersOnly  required number","value"=>$use_limit), "use_limit_value") ?>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <label class="checkbox-inline" for="example-inline-checkbox4">
                      <input type="checkbox" id="example-inline-checkbox4" name="once_per_customer_type" value="once_per_customer" <?=$once_per_customer_type_ch?>>
                      Limit to one use per customer </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div data-label="Example" class="df-example demo-forms" style="opacity: 0; position: fixed;"> 
            <!-- General Elements Title --> 
            <!-- END General Elements Title --> 
            <!-- General Elements Content -->
            <div class="form-bordered">
              <div class="form-group">
                <div class="row">
                  <div class="col-md-12">
                    <label class="fs-16 example-nf-email box_title" for="example-email">Active Dates</label>
                    <br/>
                  </div>
                  <div class="col-md-12">
                    <?php if($this->id==''){$start_date=date('d-m-Y');}else{$start_date=$this->rs_coupons['start_date'];}?>
                  </div>
                  <div class="col-md-12">
                    <div class="col-md-3 row">
                      <label class="example-nf-email" for="example-email">Start Date</label>
                      <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control start_date input-datepicker","id"=>"example-datepicker3","name"=>"start_date","placeholder"=>"Start Date","data-date-format"=>"dd-mm-yyyy","autocomplete"=>"off","value"=>$start_date), "") ?>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="col-md-3 row">
                      <?php
				if($this->id=='')
				{
					$show_enddate_box_id='style="display:none"';
					$end_ch='';
				}
				else
				{
					$exp_date=$this->rs_coupons['exp_date'];
					if($exp_date!='')
					{
						$show_enddate_box_id='';
						$end_ch='checked="checked"';
					}
					else
					{
						$show_enddate_box_id='style="display:none"';
						$end_ch='';
					}
				}
				?>
                      <!-- <label class="example-nf-email" for="example-email"></label> -->
                      <label class="checkbox-inline mt-10" for="example-inline-checkbox525">
                        <input type="checkbox" id="example-inline-checkbox525" name="use_end_date_type" value="Yes" onclick="show_enddate_box()" <?=$end_ch?>>
                        End Date </label>
                      <div id="show_enddate_box_id" <?=$show_enddate_box_id?>>
                        <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"mt-10 form-control end_date input-datepicker","id"=>"example-datepicker345","name"=>"exp_date","placeholder"=>"End Date","data-date-format"=>"dd-mm-yyyy","autocomplete"=>"off","value"=>$this->rs_coupons['exp_date']), "") ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div data-label="Example" class="df-example demo-forms"> 
            <!-- General Elements Title --> 
            <!-- END General Elements Title --> 
            <!-- General Elements Content -->
            <div class="form-bordered">
              <div class="form-group">
              
                <label class="fs-16 example-nf-email" for="example-email">Coupon Description (Display Web & App) <span class="tx-danger">*</span></label>
                <? $this->htmlBuilder->buildTag("textarea", array("rows"=>"4","class"=>"form-control required mb-10","value"=>$this->rs_coupons['msg']), "msg") ?>
                
                
                  <label class="fs-16 example-nf-email" for="example-email">Coupon Success Msg (Display Web & App) <span class="tx-danger">*</span></label>
                <? $this->htmlBuilder->buildTag("textarea", array("rows"=>"2","class"=>"form-control required mb-10","value"=>$this->rs_coupons['success_apply_msg']), "success_apply_msg") ?>
                
                
                
                <label class="fs-16 example-nf-email" for="example-email">Admin Note</label>
                <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control","value"=>htmlentities($this->rs_coupons['admin_note'])), "admin_note") ?>
              </div>
            </div>
          </div>
          <div class="form-group form-actions">
            <div class="row">
              <div class="col-md-12 ">
                <button type="submit" class="mr-10 btn btn-effect-ripple btn-primary submit_btn" >Submit</button>
                <a href="index.php?view=coupon_list&pg_no=<?=$this->getGetVar('pg_no')?>" class="btn btn-effect-ripple btn-danger" style="overflow: hidden; position: relative;">Cancel</a> </div>
            </div>
          </div>
          <?=$this->htmlBuilder->closeForm()?>
          <!-- END General Elements Content --> 
        </div>
      </div>
       <?php include('includes/footer.php');?>
    </div>
    <!-- container --> 
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
<script src="lib/select2/js/select2.min.js"></script> 
<script>
      // Adding placeholder for search input
      (function($) {

        'use strict'

        var Defaults = $.fn.select2.amd.require('select2/defaults');

        $.extend(Defaults.defaults, {
          searchInputPlaceholder: ''
        });

        var SearchDropdown = $.fn.select2.amd.require('select2/dropdown/search');

        var _renderSearchDropdown = SearchDropdown.prototype.render;

        SearchDropdown.prototype.render = function(decorated) {

          // invoke parent method
          var $rendered = _renderSearchDropdown.apply(this, Array.prototype.slice.apply(arguments));

          this.$search.attr('placeholder', this.options.get('searchInputPlaceholder'));

          return $rendered;
        };

      })(window.jQuery);


      $(function(){
        'use strict'

        // Basic with search
        $('.select2').select2({
          placeholder: 'Choose one',
          searchInputPlaceholder: 'Search options'
        });

        

      });
    </script> 
<script src="assets/js/dashforge.aside.js"></script> 
<script src="assets/js/dashforge.js"></script> 

<script src="lib/validate/js/jquery.validate.min.js"></script> 
<script>
function getprice(value)
{
	if(value=='single')
	{
		$('.dataPrice').show();
		$('.dataMrp').show();
		$('.dataWeight').show();
		$('.dataship').show();
	}
	else
	{
		$('.dataPrice').hide();
		$('.dataMrp').hide();
		$('.dataWeight').hide();
		$('.dataship').hide();
	}
}
function generate_code()
{
	$('#coupon_code').val('');
	$.ajax(
		{
			type: "POST",
			dataType: 'json',
			url: "scripts/ajax/index.php",
			data: "method=generate_coupon_code",
			success: function(data){
				$('#coupon_code').val(data.CODE);
			}
		}
	);
}
</script> 
<script>
function show_discount_type_data(a)
{
	if(a=='Percentage')
	{
		$('#discoun_value_box').show();
		$('#shipping_value_box').hide();
		$('#buy_x_y_value_box').hide();
		$('#minimum_req_box').show();
		$('#customer_elig_box').show();
		$('#max_discount_box').show();
		//$('#amount').val();
		//$('#max_amount').val();
		$('.dis_symbol').html('(%)');
		
		$('.ship_discount_new_box').show();
	}
	else if(a=='Fixed_Amount')
	{
		$('#discoun_value_box').show();
		$('#shipping_value_box').hide();
		$('#buy_x_y_value_box').hide();
		$('#minimum_req_box').show();
		$('#customer_elig_box').show();
		$('#max_discount_box').hide();
		//$('#amount').val();
		$('#max_amount').val('');
		$('.dis_symbol').html('(<i class="fas fa-rupee-sign"></i>)');
		$('.ship_discount_new_box').show();
	}
	else if(a=='Free_Shipping')
	{
		$('#discoun_value_box').show();
		$('#shipping_value_box').show();
		$('#buy_x_y_value_box').hide();
		$('#minimum_req_box').show();
		$('#customer_elig_box').show();
		$('#max_discount_box').hide();
		$('#amount').val('');
		$('#max_amount').val('');
		$('.dis_symbol').html('');
		
		$('.ship_discount_new_box').hide();
		$("#example-radio5").prop("checked", true);
		show_applies_type_box('Specific_Category');
		
	}
	else if(a=='Buy_X_Y')
	{
		$('#discoun_value_box').hide();
		$('#shipping_value_box').hide();
		$('#buy_x_y_value_box').show();
		$('#minimum_req_box').hide();
		$('#customer_elig_box').hide();
		$('#amount').val('');
		$('#max_amount').val('');
		$('#max_discount_box').hide();
		$('.dis_symbol').html('');
		$('.ship_discount_new_box').show();
	}
	else
	{
		alert("Try Again");
		location.reload();
	}
}
function show_shipping_box()
{
	var check=$("input[name='exclude_shiping_type']:checked").val();
	if(check=='Exclude Shipping')
	{
		$('#shipping_value_entire_box').show();
	}
	else
	{
		$('#shipping_value_entire_box').hide();
	}
}
function show_min_require_box(a)
{
	if(a=='Minimum_Purchase_Amount')
	{
		$('#min_purchase_amount_box').show();
	}
	else
	{
		$('#min_purchase_amount_box').hide();
		$('#order_amount').val('');
	}
}
function show_limit_entire_box()
{
	var check=$("input[name='use_limit_type']:checked").val();
	if(check=='use_limit')
	{
		$('#use_limit_entire_box').show();
	}
	else
	{
		$('#use_limit_entire_box').hide();
	}
}
// -------------------------
function show_enddate_box()
{
	var check=$("input[name='use_end_date_type']:checked").val();
	if(check=='Yes')
	{
		$('#show_enddate_box_id').show();
	}
	else
	{
		$('#show_enddate_box_id').hide();
	}
}
// ---------------------------
function show_applies_type_box(a)
{
	if(a=='Entire_Order')
	{
		$('#category_box').hide();
		$('#product_box').hide();
	}
	else if(a=='Specific_Category')
	{
		$('#category_box').show();
		$('#product_box').hide();
	}
	else if(a=='Specific_Products')
	{
		$('#category_box').hide();
		$('#product_box').show();
	}
	else
	{
		$('#category_box').hide();
		$('#product_box').hide();
		alert("Try Again");
		location.reload();
	}
}

function show_customers_box(a)
{
	if(a=='Everyone')
	{
		$('#customers_box').hide();
	}
	else if(a=='Specific_Customers')
	{
		$('#customers_box').show();
	}
	else
	{
		$('#customers_box').hide();
		alert("Try Again");
		location.reload();
	}
}
function show_get_discount_value_box(a)
{
	if(a=='Free')
	{
		$('#get_discount_value_box').hide();
		$('#get_discount_value').val('');
	}
	else if(a=='Percentage')
	{
		$('#get_discount_value_box').show();
	}
	else
	{
		$('#get_discount_value_box').hide();
		$('#get_discount_value').val('');
		alert("Try Again");
		location.reload();
	}
}
$('.chosen-toggle').each(function(index) {
//console.log(index);
    $(this).on('click', function(){
    console.log($(this).parent().find('option').text());
         $(this).parent().find('option').prop('selected', $(this).hasClass('select')).parent().trigger('chosen:updated');
    });
});
</script>
<link href='lib/selectdropdown/jquery-ui.min.css' rel='stylesheet' type='text/css'>
<script src='lib/selectdropdown/jquery-ui.min.js' type='text/javascript'></script> 
<!--<script src="lib/jqueryui/jquery-ui.min.js"></script>--> 
<script>
 $( function() {
        $( "#p_type" ).autocomplete({
            source: function( request, response ) {
                $.ajax({
                   	url: "..//scripts/ajax/index.php",
                    type: 'post',
                    dataType: "json",
                    data:'method=sales_product_suggession&queryString='+request.term,
                    success: function( data ) {
                        response( data );
                    }
                });
            },
			minLength: 0,
            select: function (event, ui) {
                $('#p_type').val(''); // display the selected text
				 addproduct_to_table_n(ui.item.value,1);
				//  fill_data(ui.item.value);
				  // save selected id to input
                return false;
            }
        }).focus(function () {
			  $(this).autocomplete("search");
		});
    });
		function addproduct_to_table_n(product_id,cust_id)
	{
		$.ajax(
		{
			type: "POST",
			dataType: 'json',
			url: "../scripts/ajax/index.php",
			data: "method=get_product_detail_order_new&product_id="+product_id+'&cust_id='+cust_id,
			success: function(data){
					if(data.RESULT=='OK')
					{
				//$('#free_product_id').val(product_id);
				var c='<li id="products_data_'+product_id+'"><div class="row"><input type="hidden" name="products_ids_data[]" value="'+product_id+'"><div class="col-md-10">'+data.product_name+' - '+data.p_type+'</div><div class="col-md-1">$'+data.product_unit_cost+'</div><div class="col-md-1"><a class="remove_products" href="javascript:void(0)" onclick="remove_products('+product_id+')">X</a></div></div></li>';
				$('#products_data').append(c);
					}
			}
		}
	);
	}
</script> 
<script>
 $( function() {
        $( "#p_type_b" ).autocomplete({
            source: function( request, response ) {
                $.ajax({
                   	url: "..//scripts/ajax/index.php",
                    type: 'post',
                    dataType: "json",
                    data:'method=sales_product_suggession&queryString='+request.term,
                    success: function( data ) {
                        response( data );
                    }
                });
            },
			minLength: 0,
            select: function (event, ui) {
                $('#p_type_b').val(''); 
				
				var buy_qty=$("#buy_quantity").val();
				if(buy_qty==0 || buy_qty=='')
				{
					buy_qty=1;
					
				}
				
				 addproduct_to_table_b(ui.item.value,buy_qty);
				//  fill_data(ui.item.value);
				  // save selected id to input
                return false;
            }
        }).focus(function () {
			  $(this).autocomplete("search");
		});
    });
		function addproduct_to_table_b(product_id,buy_qty)
	{
		
		var cust_id=1;
		$.ajax(
		{
			type: "POST",
			dataType: 'json',
			url: "../scripts/ajax/index.php",
			data: "method=get_product_detail_order_new&product_id="+product_id+'&cust_id='+cust_id,
			success: function(data){
					if(data.RESULT=='OK')
					{
				//$('#free_product_id').val(product_id);
				var c='<li id="products_data_b_'+product_id+'"><div class="row"><input type="hidden" name="products_buy_ids_data[]" value="'+product_id+'"><input type="hidden" name="products_buy_qtys[]" value="'+buy_qty+'"><div class="col-md-9">'+data.product_name+' - '+data.p_type+'</div><div class="col-md-2">$'+data.product_unit_cost+'</div><div class="col-md-1"><a class="remove_products" href="javascript:void(0)" onclick="remove_products_b('+product_id+')">X</a></div></div></li>';
				$('#products_data_b').append(c);
					}
			}
		}
	);
	}
</script> 
<script>
 $( function() {
        $( "#p_type_g" ).autocomplete({
            source: function( request, response ) {
                $.ajax({
                   	url: "..//scripts/ajax/index.php",
                    type: 'post',
                    dataType: "json",
                    data:'method=sales_product_suggession&queryString='+request.term,
                    success: function( data ) {
                        response( data );
                    }
                });
            },
			minLength: 0,
            select: function (event, ui) {
                $('#p_type_g').val(''); // display the selected text
				
				var get_quantity=$("#get_quantity").val();
				if(get_quantity==0 || get_quantity=='')
				{
					get_quantity=1;
					
				}
				
				 addproduct_to_table_g(ui.item.value,get_quantity);
				//  fill_data(ui.item.value);
				  // save selected id to input
                return false;
            }
        }).focus(function () {
			  $(this).autocomplete("search");
		});
    });
		function addproduct_to_table_g(product_id,get_quantity)
	{
		
		var cust_id=1;
		
		$.ajax(
		{
			type: "POST",
			dataType: 'json',
			url: "../scripts/ajax/index.php",
			data: "method=get_product_detail_order_new&product_id="+product_id+'&cust_id='+cust_id,
			success: function(data){
					if(data.RESULT=='OK')
					{
				//$('#free_product_id').val(product_id);
				var c='<li id="products_data_g_'+product_id+'"><div class="row"><input type="hidden" name="products_get_ids_data[]" value="'+product_id+'"><input type="hidden" name="products_get_qtys[]" value="'+get_quantity+'"><div class="col-md-9">'+data.product_name+' - '+data.p_type+'</div><div class="col-md-2">$'+data.product_unit_cost+'</div><div class="col-md-1"><a class="remove_products" href="javascript:void(0)" onclick="remove_products_g('+product_id+')">X</a></div></div></li>';
				$('#products_data_g').append(c);
					}
			}
		}
	);
	}
</script> 
<script>
  $( function() {
        $( "#phone" ).autocomplete({
            source: function( request, response ) {
                $.ajax({
                   	url: "scripts/ajax/index.php",
                    type: 'post',
                    dataType: "json",
                    data:'method=show_suggessions_customer&queryString='+request.term,
                    success: function( data ) {
                        response( data );
                    }
                });
            },
			minLength: 0,
            select: function (event, ui) {
                 //$('#phone').val(ui.item.label); // display the selected text
				 //$('#brand_id').val(ui.item.value);
				 fill_data_user(ui.item.value);
				 // save selected id to input
                return false;
            }
        }).focus(function () {
			  $(this).autocomplete("search");
		});
    });
function fill_data_user(id)
{
	$.ajax({
		type: "POST",
		url: "scripts/ajax/index.php",
		data:'method=customer_detail_data&id='+id,
		dataType:'json',
			success: function(data){
				if(data.RESULT=='OK')
				{
					// $("#phone").val(data.phone);
			 	  	// $("#name").val(data.name);
					// $("#name").focus();
			   	   //  $("#customer_id").val(data.user_id);
					 var c='<li id="c_data_'+data.id+'"><div class="row"><input type="hidden" name="customer_ids_data[]" value="'+data.id+'"><div class="col-md-4">'+data.first_name+'</div><div class="col-md-4">'+data.phone+'</div><div class="col-md-4 text-right"><a class="remove_products" href="javascript:void(0)" onclick="remove_customers('+data.id+')">X</a></div></div></li>';
				$('#customers_data').append(c);
				$("#phone").val('');
				}
				else
				{}
			}
		});
}
function remove_products(id)
{
	$('#products_data_'+id).remove();
}
function remove_products_b(id)
{
	$('#products_data_b_'+id).remove();
}
function remove_products_g(id)
{
	$('#products_data_g_'+id).remove();
}
function remove_customers(id)
{
	$('#c_data_'+id).remove();
}
$(document).ready(function ()
{
    $('#frm_user_addedit').validate({
		rules: {
        otp: {
            required: true,
			minlength:4,
			maxlength:4
        },
		},
		submitHandler: function (form)
		{
			$('#eroormessage_o').hide();
			//$('#suc_message_o').hide();
			$('.submit_btn').html('Wait...');
			var dataString ='method=check_coupon_validation&'+$('#frm_user_addedit').serialize();
			$.ajax({
			    dataType: 'json',
                type: "POST",
				url: "scripts/ajax/index.php",
				data: dataString,
				success: function (responseData)
				{
				  if(responseData.RESULT==1)
						{
							$('.submit_btn').html('Submit');
							$('#error_msg').html(responseData.MSG);
							$('#eroormessage_o').fadeIn(700).show();
							//$('#suc_message_o').fadeOut(700).hide();
							$('html, body').animate({scrollTop: '0px'}, 800);
						}
						else  if(responseData.RESULT==0)
						{
							form.submit();
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

<style>
#min_purchase_amount_box
{
	width:150px;
}
</style>

 <script src="lib/jqueryui/jquery-ui.min.js"></script>
<script>
      $(function(){
        'use strict'
		
		$('.input-datepicker').datepicker();
		
		
        var dateFormat = 'dd-mm-yy',
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

<script>
	$(document).on('change', '.onChangeItemSelection', function () {
		const selectedValue = $(this).val();
		if(selectedValue === 'All Items'){
			$('.hideBoxOnChange').addClass('d-none');
		} else {
			$('.hideBoxOnChange').removeClass('d-none');
		}
	});

	$(document).ready(function () {
		$('#example-chosen-multiple2').select2({
			width: '100%'
		});
		$('#example-chosen-multiple').select2({
			width: '100%'
		});
	});
</script>

<script src="scripts/js/grocery.js"></script> 