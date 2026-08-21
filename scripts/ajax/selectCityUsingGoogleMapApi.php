<?php
ini_set("display_errors", "off");
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);
$cityName=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("cityName"));

if($cityName!='')
{
	$lastCityID=$_SESSION['cityID'];

	$obj_model_tble=$app->load_model("city");
	$rs_city = $obj_model_tble->execute("SELECT",false,"","status='Active'","");
	
	foreach($rs_city as $item)
	{
		$cityName=trim(strtolower($cityName));
		if ($cityName == trim(strtolower($item['name'])) || $cityName == trim(strtolower($item['slug']))) 
		//if (strpos($cityName, strtolower($item['name'])) !== false) 
		{
			$api_state_id=$item['api_state_id'];
			$api_city_id=$item['api_city_id'];
			$state_id=$item['state_id'];
			$cityName=$item['name'];
			$cityImage=$item['image'];
			$cityID=$item['id'];
			$citySlug=$item['slug'];
			$_SESSION['cityID']=$cityID;
			$_SESSION['cityName']=$cityName;
			$_SESSION['cityImage']=$cityImage;
			$_SESSION['cityApiStateId']=$api_state_id;
			$_SESSION['cityApiCityId']=$api_city_id;
			$_SESSION['cityStateID']=$state_id;
			$_SESSION['citySlug']=$citySlug;
			$_SESSION['cityPhone']=$item['phone'];
			if($lastCityID!=$_SESSION['cityID'])
			{
				//City Change Clear Cart
				if($_SESSION['MDRCCustID']>0)
				{
					$customerCond="customer_cart.customer_id='".$_SESSION['MDRCCustID']."'";
				}
				else
				{
					$customerCond="customer_cart.session_id='".session_id()."'";
				}
				$obj_model_tmp_cart_delete = $app->load_model("customer_cart");
				$obj_model_tmp_cart_delete->execute("DELETE",false,"","".$customerCond."");
			}
			$RESULT='OK';
			$MSG='Success';

			if($page=='premium-health-checkup') {
				$URL=SERVER_ROOT.'/'.$page.'/'.$_SESSION['citySlug'];
			} else {
				$URL=SERVER_ROOT;
			}

			if($lastCityID==$_SESSION['cityID'])
			{
				$RESULT='SAME';
				$MSG='Success';
			}
			
			echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG,"URL"=>$URL));
			exit;
		}
	}

	if($RESULT!='OK')
	{
		$RESULT='NOT OK';
		$MSG='Please Try Again.'.strtolower($cityName);
		echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG,"URL"=>$URL));
		exit;
	}
}
else
{
	$RESULT='NOT OK';
	$MSG='Please Try Again.';
}
echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG));
?>