<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);

	$_SESSION["DIS_ID"]='';
	$_SESSION["discount"]=0;
	$_SESSION["discount_msg"]='';
	$code=mysqli_real_escape_string($app->set_db_conn(),$app->getGetVar("code"));
	$custID=$_SESSION['MDRCCustID'];
	$osType='Web';

		$obj_model_tmp_cartmini = $app->load_model("customer_cart");
		$obj_model_tmp_cartmini->join_table("item_price", "left", array(), array("cart_item_price_id"=>"id"));
		$obj_model_tmp_cartmini->join_table("item", "left", array(), array("cart_item_id"=>"id"));
		$rs_cartmini = $obj_model_tmp_cartmini->execute("SELECT", false, "", "customer_cart.customer_id='".$_SESSION['MDRCCustID']."'");
		$cart_array=$rs_cartmini;
		$cart_products=count($cart_array);
		$obj_model_user = $app->load_model("customer");
		$rs_user = $obj_model_user->execute("SELECT",false,"","id='".$custID."'");
			$total=0;
			$p_error='';
			$p_error=array();
			foreach($cart_array as $item)
			{
				$product_id=$item["cart_item_id"];
				$product_price_id=$item["cart_item_price_id"];
				$product_quantity=$item["cart_qty"];
				$app_price+=($item["cart_item_price"]*$product_quantity);
				$price=$item['cart_item_price']*$product_quantity;
				$subtotal+= $price;
			}
			$obj_model_coupon =$app->load_model("coupon");
			$rs_coupon = $obj_model_coupon->execute("SELECT",false,"","coupon_code='".$code."' and status='Active'","");
			if(count($rs_coupon)==0)
			{
					echo $obj_json->encode(array("RESULT"=>"1","error_msg"=>"Invalid promo code"));
					exit;
			}
			// General Date Condition //
			$start_date=$rs_coupon[0]['start_date'];
			$exp_date=$rs_coupon[0]['exp_date'];
			if($exp_date!='')
			{
				$today=strtotime(date('m/d/Y'));
				$exdate=strtotime($exp_date);
				if($today>$exdate)
				{
					echo $obj_json->encode(array("RESULT"=>"1","error_msg"=>"Promo Code Expired."));
					exit;
				}
			}
			if($start_date!='')
			{
				$today=strtotime(date('m/d/Y'));
				$strdate=strtotime($start_date);
				if($today<$strdate)
				{
					echo $obj_json->encode(array("RESULT"=>"1","error_msg"=>"Promo Code Expired."));
					exit;
				}
			}
			// General Date Condition //
			$coupon_id=$rs_coupon[0]['id'];
			$type=$rs_coupon[0]['type'];
			$amount=$rs_coupon[0]['amount'];
			$max_amount=$rs_coupon[0]['max_amount'];
			$order_amount=$rs_coupon[0]['order_amount'];
			$msg=$rs_coupon[0]['msg'];
			$success_apply_msg=$rs_coupon[0]['success_apply_msg'];

			$obj_model_coupon_info =$app->load_model("coupon_info");
			$rs_coupon_info = $obj_model_coupon_info->execute("SELECT",false,"","coupon_id='".$rs_coupon[0]['id']."'","");
			$cat_include=$rs_coupon_info[0]['cat_include'];

			if($rs_coupon_info[0]['category_ids']!='')
			{
				if($cat_include=='Yes')
				{
					$category_ids=$rs_coupon_info[0]['category_ids'];
				}
				else
				{
					$obj_model_cats =$app->load_model("city");
					$rs_cats = $obj_model_cats->execute("SELECT",false,"","id NOT IN (".$rs_coupon_info[0]['category_ids'].")","");
					$cat_d=array();
					for($c=0;$c<count($rs_cats);$c++)
					{
						$cat_d[]=$rs_cats[$c]['id'];
					}
					$category_ids=implode(',',$cat_d);
				}
			}

			$product_ids=$rs_coupon_info[0]['item_ids'];
			$get_product_ids=$rs_coupon_info[0]['get_product_ids'];
			$buy_quantity=$rs_coupon_info[0]['buy_quantity'];
			$get_quantity=$rs_coupon_info[0]['get_quantity'];
			$get_discount_value=$rs_coupon_info[0]['get_discount_value'];
			$customer_ids=$rs_coupon_info[0]['customer_ids'];
			$once_per_customer=$rs_coupon_info[0]['once_per_customer'];
			$use_limit=$rs_coupon_info[0]['use_limit'];
			$exclude_shipping_rate=$rs_coupon_info[0]['exclude_shipping_rate'];

			if($type=='Percentage')
			{
					// Specific Purchase Amount
					if($order_amount>0)
					{
						if($subtotal<$order_amount)
						{
							echo $obj_json->encode(array("RESULT"=>"1","error_msg"=>"Minimum Order Amount  Rs.".$order_amount." is  required."));
							exit;
						}
					}
					// Specific Limit Order
					if($use_limit>0)
					{
						$cheeck_total_orders=$app->utility->check_coupon_order($coupon_id);
						if($use_limit<=$cheeck_total_orders)
						{
							echo $obj_json->encode(array("RESULT"=>"1","error_msg"=>"Promo Code Expired.(Total Limit Used.)"));
							exit;
						}
					}
					// Specific Customer Use Once / Multiple
					if($once_per_customer=='Yes')
					{
						$cheeck_total_orders=$app->utility->check_coupon_order_customer($coupon_id,$custID);
						if($cheeck_total_orders>0)
						{
							echo $obj_json->encode(array("RESULT"=>"1","error_msg"=>"This promo code can only be used once per account and has been used already."));
							exit;
						}
					}
					
					// if($category_ids!='')
					// {
					// 	// Specific Category
					// 	$c_data=explode(',',$category_ids);
					// 	$total_cart_p=0;
					// 	for($i=0;$i<count($cart_array);$i++)
					// 	{
					// 		$total_price=$cart_array[$i]['cart_item_price']*$cart_array[$i]['cart_qty'];
					// 		$total_cart_p=$total_cart_p+$total_price;
					// 	}

					// 	if(!in_array($cart_array[0]['city_id'],$c_data)){
					// 		$total_cart_p=0;
					// 	}

					// 	$total=$total_cart_p;
					// 	if($total==0)
					// 	{
					// 		echo $obj_json->encode(array("RESULT"=>"1","error_msg"=>"This coupon is not valid for your city."));
					// 		exit;
					// 	}
					// }
					
					if($product_ids!='')
					{
						// Specific Products
						$c_data=explode(',',$product_ids);
						$total_cart_p=0;
						for($i=0;$i<count($cart_array);$i++)
						{
							$p_id=$cart_array[$i]['cart_item_id'];
							$total_price=$cart_array[$i]['cart_item_price']*$cart_array[$i]['cart_qty'];
							$p_cat_array='';
							$p_cat_array=array();
							$p_cat_array[]=$p_id;
							$cat_status='';
							for($k=0;$k<count($c_data);$k++)
							{
								if($cat_status=='')
								{
										  if(in_array($c_data[$k], $p_cat_array))
										  {
											 $cat_status='Yes';
										  }
								}
								
								
							}
							
							if($cat_status=='Yes')
							{
								$total_cart_p=$total_cart_p+$total_price;
							}
						}
						
						$total=$total_cart_p;
						if($total==0)
						{
							echo $obj_json->encode(array("RESULT"=>"1","error_msg"=>"Applicable to specific items only."));
							exit;
						}
					}
					else
					{
						// Everyone
						$total=$subtotal;
					}
				$dis=($total*$amount)/100;
				$dis=number_format($dis,'2','.','');
				if($dis>$max_amount)
				{
					$discount=$max_amount;
				}
				else
				{
					$discount=$dis;
				}
				$promo_success='<div class="col-12 w-100 p-0">
				<p class="text-dark coup-p ft w-100 fs__14 ">
				<i class="fas fa-tag fs__22 position-absolute al-pos mr-2 text-dark"></i> <a class="float-end" onclick="remove_coupon_code()" href="javascript:void(0)">Remove</a> Coupon Applied Successfully. <br/>
					<span class="text-success">'.$success_apply_msg.'</span>
				</p>
			</div>';
				$_SESSION["discount_msg"]=$promo_success;
				$_SESSION["DIS_ID"]=$coupon_id;
				$_SESSION["discount"]=$discount;
				echo $obj_json->encode(array("RESULT"=>"0","error_msg"=>"","promo_success"=>$promo_success));
				exit;
			}
			else if($type=='Fixed amount')
			{
					// Specific Purchase Amount
					if($order_amount>0)
					{
						if($subtotal<$order_amount)
						{
							echo $obj_json->encode(array("RESULT"=>"1","error_msg"=>"Minimum Order Amount  Rs.".$order_amount." is  required."));
							exit;
						}
					}
					// Specific Limit Order
					if($use_limit>0)
					{
						$cheeck_total_orders=$app->utility->check_coupon_order($coupon_id);
						if($use_limit<=$cheeck_total_orders)
						{
							echo $obj_json->encode(array("RESULT"=>"1","error_msg"=>"Promo Code Expired.(Total Limit Used.)"));
							exit;
						}
					}
					// Specific Customer Use Once / Multiple
					if($once_per_customer=='Yes')
					{
						$cheeck_total_orders=$app->utility->check_coupon_order_customer($coupon_id,$custID);
						if($cheeck_total_orders>0)
						{
							echo $obj_json->encode(array("RESULT"=>"1","error_msg"=>"This promo code can only be used once per account and has been used already."));
							exit;
						}
					}
					if($category_ids!='')
					{
						// Specific Category
						$c_data=explode(',',$category_ids);
						$total_cart_p=0;
						for($i=0;$i<count($cart_array);$i++)
						{
							$total_price=$cart_array[$i]['cart_item_price']*$cart_array[$i]['cart_qty'];
							$total_cart_p=$total_cart_p+$total_price;
						}

						if(!in_array($cart_array[0]['city_id'],$c_data)){
							$total_cart_p=0;
						}
						$total=$total_cart_p;
						if($total==0)
						{
							echo $obj_json->encode(array("RESULT"=>"1","error_msg"=>"Invalid Code (Specific Category)."));
							exit;
						}
					}
					else if($product_ids!='')
					{
						// Specific Products
						$c_data=explode(',',$product_ids);
						$total_cart_p=0;
						for($i=0;$i<count($cart_array);$i++)
						{
							$p_id=$cart_array[$i]['cart_product_price_id'];
							$total_price=$cart_array[$i]['cart_product_price']*$cart_array[$i]['cart_qty'];
							$p_cat_array='';
							$p_cat_array=array();
							$p_cat_array[]=$p_id;
							$cat_status='';
							for($k=0;$k<count($c_data);$k++)
							{
								if($cat_status=='')
								{
										  if(in_array($c_data[$k], $p_cat_array))
										  {
											 $cat_status='Yes';
										  }
								}
							}
							if($cat_status=='Yes')
							{
								$total_cart_p=$total_cart_p+$total_price;
							}
						}
						$total=$total_cart_p;
						if($total==0)
						{
							echo $obj_json->encode(array("RESULT"=>"1","error_msg"=>"Invalid Code (Specific Product)."));
							exit;
						}
					}
					else
					{
						// Everyone
						$total=$subtotal;
					}
				$discount=$amount;
						
								
				$promo_success='<div class="col-12 w-100 p-0">
	                         <p class="text-dark coup-p ft w-100 fs__14 ">
							 <i class="fas fa-tag fs__22 position-absolute al-pos mr-2 text-dark"></i> <a class="float-end" onclick="remove_coupon_code()" href="javascript:void(0)">Remove</a> Coupon Applied Successfully. <br/>
								 <span class="text-success">'.$success_apply_msg.'</span>
	                         </p>
	                     </div>';

								
				$_SESSION["DIS_ID"]=$coupon_id;
				$_SESSION["discount"]=$discount;
				$_SESSION["discount_msg"]=$promo_success;
				echo $obj_json->encode(array("RESULT"=>"0","error_msg"=>"","promo_success"=>$promo_success));
				exit;
			}
echo $obj_json->encode(array("RESULT"=>$RESULT,"error_msg"=>$distance_error_msg));
?>