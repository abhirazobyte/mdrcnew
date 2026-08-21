<?
class _coupon_list extends controller {
	function init(){
	}
	function onload()
	{
		$ip=$_SERVER['REMOTE_ADDR'];
		$userID=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('userID'));
		$userID=$this->app->utility->decrypt($userID);
		$cityID=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('cityID'));
		$cityID=$cityID!=''?$this->app->utility->decrypt($cityID):"";
		$userPhone=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('userPhone'));
		$deviceType=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("deviceType"));
		$action=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("action"));
		$couponCode=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("couponCode"));

		if($userID!='' && $userPhone!='' && $deviceType!='' && $action=='list')
		{
			$obj_model_coupon = $this->app->load_model("coupon");
			$obj_model_coupon->join_table("coupon_info", "left", array(), array("id"=>"coupon_id"));
			$rs_coupon = $obj_model_coupon->execute("SELECT", false, "", "status='Active' and display_list='Yes' and (category_ids='' or (cat_include='Yes' and FIND_IN_SET('".$cityID."',`category_ids`)) or (cat_include='No' and NOT FIND_IN_SET('".$cityID."',`category_ids`)))", "coupon.id DESC");
			if(count($rs_coupon)>0)
			{
				foreach($rs_coupon as $item) {
					$couponList[]=["code"=>$item['coupon_code'],"msg"=>nl2br($item['msg'])];
				}
				$result=["couponList"=>$couponList];
				$message=array("message"=>'success',"msgCode"=>"1","result"=>$result);
			}
			else
			{
				//2 means redirect to cart
				$message=array("message"=>"No Coupon Code Active.","msgCode"=>"0");
			}
		}
		else if($userID!='' && $userPhone!='' && $deviceType!='' && $action=='apply' && $couponCode!='')
		{
			$obj_model_coupon =$this->app->load_model("coupon");
			$rs_coupon = $obj_model_coupon->execute("SELECT",false,"","coupon_code='".$couponCode."' and status='Active'","");
			if(count($rs_coupon)==0)
			{
				$message=array("message"=>"No Coupon Code Active.","msgCode"=>"0");
				$opt=json_encode($message, JSON_UNESCAPED_UNICODE);
				echo $this->app->utility->indent($opt);
				exit;
			}
			$start_date=$rs_coupon[0]['start_date'];
			$exp_date=$rs_coupon[0]['exp_date'];
			if($exp_date!='')
			{
				$today=strtotime(date('m/d/Y'));
				$exdate=strtotime($exp_date);
				if($today>$exdate)
				{
					$message=array("message"=>"Promo Code Expired.","msgCode"=>"0");
					$opt=json_encode($message, JSON_UNESCAPED_UNICODE);
					echo $this->app->utility->indent($opt);
					exit;
				}
			}
			if($start_date!='')
			{
				$today=strtotime(date('m/d/Y'));
				$strdate=strtotime($start_date);
				if($today<$strdate)
				{
					$message=array("message"=>"Promo Code Expired.","msgCode"=>"0");
					$opt=json_encode($message, JSON_UNESCAPED_UNICODE);
					echo $this->app->utility->indent($opt);
					exit;
				}
			}

			$obj_model_tmp_cartmini = $this->app->load_model("customer_cart");
			$obj_model_tmp_cartmini->join_table("item_price", "left", array(), array("cart_item_price_id"=>"id"));
			$obj_model_tmp_cartmini->join_table("item", "left", array(), array("cart_item_id"=>"id"));
			$rs_cartmini = $obj_model_tmp_cartmini->execute("SELECT", false, "", "customer_cart.customer_id='".$userID."'");

			$cart_array=$rs_cartmini;
			$cart_products=count($cart_array);
			$obj_model_user = $this->app->load_model("customer");
			$rs_user = $obj_model_user->execute("SELECT",false,"","id='".$userID."'");
			$total=0;
			$app_price=0;
			$subtotal=0;
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

			// General Date Condition //
			$coupon_id=$rs_coupon[0]['id'];
			$type=$rs_coupon[0]['type'];
			$amount=$rs_coupon[0]['amount'];
			$max_amount=$rs_coupon[0]['max_amount'];
			$order_amount=$rs_coupon[0]['order_amount'];
			$msg=$rs_coupon[0]['msg'];
			$success_apply_msg=$rs_coupon[0]['success_apply_msg'];

			$obj_model_coupon_info =$this->app->load_model("coupon_info");
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
					$obj_model_cats =$this->app->load_model("city");
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
					if($order_amount>0 && $subtotal<$order_amount)
					{
						$message=array("message"=>"Minimum Order Amount  Rs.".$order_amount." is  required.","msgCode"=>"0");
						$opt=json_encode($message, JSON_UNESCAPED_UNICODE);
						echo $this->app->utility->indent($opt);
						exit;
					}
					// Specific Limit Order
					if($use_limit>0)
					{
						$cheeck_total_orders=$this->app->utility->check_coupon_order($coupon_id);
						if($use_limit<=$cheeck_total_orders)
						{
							$message=array("message"=>"Promo Code Expired.(Total Limit Used.)","msgCode"=>"0");
							$opt=json_encode($message, JSON_UNESCAPED_UNICODE);
							echo $this->app->utility->indent($opt);
							exit;
						}
					}
					// Specific Customer Use Once / Multiple
					if($once_per_customer=='Yes')
					{
						$cheeck_total_orders=$this->app->utility->check_coupon_order_customer($coupon_id,$userID);
						if($cheeck_total_orders>0)
						{
							$message=array("message"=>"This promo code can only be used once per account and has been used already.","msgCode"=>"0");
							$opt=json_encode($message, JSON_UNESCAPED_UNICODE);
							echo $this->app->utility->indent($opt);
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
					// 		$message=array("message"=>"This coupon is not valid for your city.","msgCode"=>"0");
					// 		$opt=json_encode($message, JSON_UNESCAPED_UNICODE);
					// 		echo $this->app->utility->indent($opt);
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
							$message=array("message"=>"Invalid Code. (Valid for Specific Test).","msgCode"=>"0");
							$opt=json_encode($message, JSON_UNESCAPED_UNICODE);
							echo $this->app->utility->indent($opt);
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
				if($dis>$max_amount){$discount=$max_amount;}else{$discount=$dis;}
	
				$result=["discount"=>$discount];
				$message=array("message"=>$success_apply_msg,"msgCode"=>"1","result"=>$result);
				$opt=json_encode($message, JSON_UNESCAPED_UNICODE);
				echo $this->app->utility->indent($opt);
				exit;
			}
			else if($type=='Fixed amount')
			{
					// Specific Purchase Amount
					if($order_amount>0 && $subtotal<$order_amount)
					{
							$message=array("message"=>"Minimum Order Amount  Rs.".$order_amount." is  required.","msgCode"=>"0");
							$opt=json_encode($message, JSON_UNESCAPED_UNICODE);
							echo $this->app->utility->indent($opt);
							exit;
					}
					// Specific Limit Order
					if($use_limit>0)
					{
						$cheeck_total_orders=$this->app->utility->check_coupon_order($coupon_id);
						if($use_limit<=$cheeck_total_orders)
						{
							$message=array("message"=>"Promo Code Expired.(Total Limit Used.)","msgCode"=>"0");
							$opt=json_encode($message, JSON_UNESCAPED_UNICODE);
							echo $this->app->utility->indent($opt);
							exit;
						}
					}
					// Specific Customer Use Once / Multiple
					if($once_per_customer=='Yes')
					{
						$cheeck_total_orders=$this->app->utility->check_coupon_order_customer($coupon_id,$userID);
						if($cheeck_total_orders>0)
						{
							$message=array("message"=>"This promo code can only be used once per account and has been used already.","msgCode"=>"0");
							$opt=json_encode($message, JSON_UNESCAPED_UNICODE);
							echo $this->app->utility->indent($opt);
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
							$message=array("message"=>"Invalid Code (Specific Category).","msgCode"=>"0");
							$opt=json_encode($message, JSON_UNESCAPED_UNICODE);
							echo $this->app->utility->indent($opt);
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
							$message=array("message"=>"Invalid Code (Specific Product).","msgCode"=>"0");
							$opt=json_encode($message, JSON_UNESCAPED_UNICODE);
							echo $this->app->utility->indent($opt);
							exit;
						}
					}
					else
					{
						// Everyone
						$total=$subtotal;
					}
				$discount=$amount;
				$result=["discount"=>$discount];
				$message=array("message"=>$success_apply_msg,"msgCode"=>"1","result"=>$result);
				$opt=json_encode($message, JSON_UNESCAPED_UNICODE);
				echo $this->app->utility->indent($opt);
				exit;
			}
			else 
			{
				$message=array("message"=>"Promo Code Expired.","msgCode"=>"0");
				$opt=json_encode($message, JSON_UNESCAPED_UNICODE);
				echo $this->app->utility->indent($opt);
				exit;
			}
		}
		else
		{
			$message=array("message"=>"Date missing.","msgCode"=>"0");
		}
		$opt=json_encode($message, JSON_UNESCAPED_UNICODE);
		echo $this->app->utility->indent($opt);
		exit;
	}
}
?>