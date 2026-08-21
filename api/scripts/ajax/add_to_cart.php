<?php
mysqli_set_charset('utf8');
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);
$item_id = $app->getPostVar('item_id');
$item_price_id = $app->getPostVar('item_price_id');
$quantity = $app->getPostVar('quantity');
$qty_type=$app->getPostVar('add_type');
$other_action=$app->getPostVar('other_action');
$items_o_html='';

if(is_numeric($item_id) && is_numeric($quantity))
{
	if($other_action=='DELETE')
	{
		$obj_model_last_cart1= $app->load_model("customer_cart");
		$obj_model_last_cart1->execute("DELETE",false,"","customer_id='".$_SESSION['MDRCCustID']."'","");
	}
	$obj_model_item = $app->load_model("item");
	$obj_model_item->join_table("item_description", "left", array("prescription_required"), array("id"=>"item_id"));
	$obj_model_item->join_table("item_other_data", "left", array("item_department_ids"), array("id"=>"item_id"));
	$rs_item = $obj_model_item->execute("SELECT", false, "", "item.status='Active' and item.id=".$item_id);
	$obj_model_item_price = $app->load_model("item_price");
	$rs_item_price = $obj_model_item_price->execute("SELECT", false, "", "id=".$item_price_id);
	$city_id=$rs_item_price[0]['city_id'];
	$prescription_require=$rs_item[0]['item_description_prescription_required'];
	$cart_item_department_ids=$rs_item[0]['item_other_data_item_department_ids'];
	$price=$rs_item_price[0]['price'];
	$sch_price=$rs_item_price[0]['sch_price'];
	$sch_start_date=$rs_item_price[0]['sch_start_date'];
	$sch_end_date=$rs_item_price[0]['sch_end_date'];
	if($sch_price>0 && $sch_start_date!='' && $sch_end_date!='')
	{
		$today_date=date('d-m-Y');
		$todaySlot=strtotime($today_date);
		$startSlot=strtotime($sch_start_date);
		$endSlot=strtotime($sch_end_date);
		if($todaySlot>=$startSlot && $todaySlot<=$endSlot)
		{
			$price=$sch_price;
		}
	}
	if(count($rs_item)>0 && count($rs_item_price)>0 )
	{
		if($_SESSION['MDRCCustID']>0)
		{
			$customerCond="customer_cart.customer_id='".$_SESSION['MDRCCustID']."'";
		}
		else
		{
			$customerCond="customer_cart.session_id='".session_id()."'";
		}
		$obj_model_tmp_cart = $app->load_model("customer_cart");
		$rs_cart = $obj_model_tmp_cart->execute("SELECT",false,"","".$customerCond." and cart_item_id='".$item_id."' and cart_item_price_id='".$item_price_id."'");
		if(count($rs_cart)==0)
		{
			$data = array();
			if($_SESSION['MDRCCustID']>0)
			{
				$data["customer_id"] = $_SESSION['MDRCCustID'];
			}
			else
			{
				$data["session_id"] =session_id();
			}
			$data["city_id"]=$city_id;
			$data["prescription_require"]=$prescription_require;
			$data["cart_item_name"] = $rs_item[0]['name'];
			$data["cart_item_id"] = $item_id;
			$data["cart_item_price_id"] = $item_price_id;
			$data["cart_gst_per"] = $rs_item[0]['gst_per'];
			$data["cart_item_price"] = $price;
			$data["cart_item_mrp"] = $rs_item_price[0]['mrp'];
			$data["cart_qty"] = $quantity;
			$data["cart_line_total"] = ($quantity * $price);
			$data["entry_from"] = 'Web';
			$data["entry_date_time"] = date("d-m-Y H:i:s");
			$data["cart_item_department_ids"] = $cart_item_department_ids;
			$obj_model_tmp_cart = $app->load_model("customer_cart");
			$obj_model_tmp_cart->map_fields($data);
			$result = $obj_model_tmp_cart->execute("INSERT");
			$extra_no='';
			$items_o_html='<a href="cart"  class="btn-main bg-btn checkout-btn lnk w-100 mb-1 alreadyInCart" >Already In Cart <i class="fas fa-chevron-right fa-icon fa-ani"></i><span class="circle"></span></a>';
			$P_QTY=$quantity;
			$add_cart_msg='Item successfully added to cart.';
		}
		else
		{
			$total_qty=1;
			if($total_qty>0)
			{
				$add_cart_msg='Item successfully added to cart.';
				$data = array();
				if($_SESSION['MDRCCustID']>0)
				{
					$data["customer_id"] = $_SESSION['MDRCCustID'];
				}
				else
				{
					$data["session_id"] =session_id();
				}
				$data["city_id"]=$city_id;
				$data["prescription_require"]=$prescription_require;
				$data["cart_item_id"] = $item_id;
				$data["cart_item_price_id"] = $item_price_id;
				$data["cart_item_name"] = $rs_item[0]['name'];
				$data["cart_gst_per"] = $rs_item[0]['gst_per'];
				$data["cart_item_price"] = $price;
				$data["cart_item_mrp"] = $rs_item_price[0]['mrp'];
				$data["cart_qty"] = $total_qty;
				$data["cart_line_total"] = ($total_qty * $price);
				$data["entry_from"] = 'Web';
				$data["entry_date_time"] = date("d-m-Y H:i:s");
				$data["cart_item_department_ids"] = $cart_item_department_ids;
				$obj_model_tmp_cart = $app->load_model("customer_cart");
				$obj_model_tmp_cart->map_fields($data);
				$result = $obj_model_tmp_cart->execute("UPDATE", false, "", "id='".$rs_cart[0]['id']."'");
				$P_QTY=$total_qty;
				$items_o_html='<a href="cart"  class="btn-main bg-btn checkout-btn lnk w-100 mb-1 alreadyInCart" >Already In Cart <i class="fas fa-chevron-right fa-icon fa-ani"></i><span class="circle"></span></a>';
			}
			else
			{
				$add_cart_msg='Item removed from cart.';
				$obj_model_tmp_cart = $app->load_model("customer_cart");
				$result = $obj_model_tmp_cart->execute("DELETE", false, "",  "id='".$rs_cart[0]['id']."'");
				$items_o_html='';
				$P_QTY=$total_qty;
			}
		}
		if($result>0)
		{
			if($_SESSION['MDRCCustID']>0)
			{
				$customerCond="customer_cart.customer_id='".$_SESSION['MDRCCustID']."'";
			}
			else
			{
				$customerCond="customer_cart.session_id='".session_id()."'";
			}
			$obj_model_tmp_cart = $app->load_model("customer_cart");
			$rs_cart = $obj_model_tmp_cart->execute("SELECT",false,"","".$customerCond."");
			$cartCount=count($rs_cart);
			$cartLineTotal = count($rs_cart)>0?array_sum(array_column($rs_cart,'cart_line_total')):0;
			echo $obj_json->encode(array("RESULT"=>"1", "MSG"=>$add_cart_msg,"items_o_html"=>$items_o_html,"cartCount"=>$cartCount,"cartLineTotal"=>$cartLineTotal));
			exit;
		}
		else
		{
			echo $obj_json->encode(array("RESULT"=>"0", "MSG"=>"The system failed to process your request (ErrorCode 1001)"));
		}
	}
	else
	{
		echo $obj_json->encode(array("RESULT"=>"0", "MSG"=>"The system failed to process your request (ErrorCode 1002)"));
	}
}
else
{
	echo $obj_json->encode(array("RESULT"=>"0", "MSG"=>"The system failed to process your request (ErrorCode 1003)"));
}
?>