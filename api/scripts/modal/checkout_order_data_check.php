<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);
$RESULT=0;
$error_msg='';
if($_SESSION['homeCollection']=='Yes')
{
	
	if($_SESSION['checkoutAddressID']<=0)
	{
		echo $obj_json->encode(array("RESULT"=>"1","error_msg"=>"Please Select Sample Collection Address"));	
		exit;
		
	}
	if($_SESSION['checkoutCollectionDate']=='')
	{
		echo $obj_json->encode(array("RESULT"=>"1","error_msg"=>"Please Select Collection Date"));	
		exit;
		
	}
	if($_SESSION['checkoutCollectionTime']=='')
	{
		echo $obj_json->encode(array("RESULT"=>"1","error_msg"=>"Please Select Collection Time"));	
		exit;
		
	}
	
	
}
if($_SESSION['labSelection']=='Yes')
{

	if($_SESSION['checkoutLabID']<=0)
	{
		echo $obj_json->encode(array("RESULT"=>"2","error_msg"=>"Please Select Lab Address"));	
		exit;
		
	}
	if($_SESSION['labDate']=='')
	{
		echo $obj_json->encode(array("RESULT"=>"2","error_msg"=>"Please Select Date"));	
		exit;
		
	}
	if($_SESSION['labTime']=='')
	{
		echo $obj_json->encode(array("RESULT"=>"2","error_msg"=>"Please Select Time"));	
		exit;
		
	}

}

if($_SESSION['payment_type']=='')
{
	
	
	$error_msg='Please Select Payment Method.';
	echo $obj_json->encode(array("RESULT"=>"3","error_msg"=>"Please Select Payment Method."));	
	exit;
		
}

// item price check
$customerCond="customer_cart.customer_id='".$_SESSION['MDRCCustID']."'";

$obj_model_tmp_cartmini = $app->load_model("customer_cart");
$obj_model_tmp_cartmini->join_table("item_price", "left", array(), array("cart_item_price_id"=>"id"));
$obj_model_tmp_cartmini->join_table("item", "left", array(), array("cart_item_id"=>"id"));
$rs_cartmini = $obj_model_tmp_cartmini->execute("SELECT", false, "", "".$customerCond."","customer_cart.id DESC");

if(count($rs_cartmini)>0)
{
	for($i=0;$i<count($rs_cartmini);$i++)
	{
		$sch_price=$rs_cartmini[$i]['item_price_sch_price'];
		$sch_start_date=$rs_cartmini[$i]['item_price_sch_start_date'];
		$sch_end_date=$rs_cartmini[$i]['item_price_sch_end_date'];
		if($sch_price>0 && $sch_start_date!='' && $sch_end_date!='')
		{
			$price=$rs_cartmini[$i]['cart_item_price'];

			$today_date=date('d-m-Y');
			$todaySlot=strtotime($today_date);
			$startSlot=strtotime($sch_start_date);
			$endSlot=strtotime($sch_end_date);
			$dbPrice=$rs_cartmini[$i]['item_price_price'];
			if($todaySlot>=$startSlot && $todaySlot<=$endSlot)
			{
				$dbPrice=$sch_price;
			}
			if($rs_cartmini[$i]['item_status']!='Active'){
				$error_msg=$rs_cartmini[$i]['item_name'].' Not Available. Please remove form cart.';
				echo $obj_json->encode(array("RESULT"=>"3","error_msg"=>$error_msg));
				exit;
			}
			if($rs_cartmini[$i]['cart_item_price']!=$dbPrice && $rs_cartmini[$i]['item_status']=='Active'){
				$error_msg=$rs_cartmini[$i]['item_name'].' price has changed! Remove this product from your cart and add it again to see the updated price.';
				echo $obj_json->encode(array("RESULT"=>"3","error_msg"=>$error_msg));
				exit;
			}
		}
	}
}
echo $obj_json->encode(array("RESULT"=>$RESULT,"error_msg"=>$error_msg));
?>