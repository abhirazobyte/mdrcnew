<?php 

	$jsonclass = $app->load_module("Services_JSON");

	$obj_JSON = new $jsonclass(SERVICES_JSON_LOOSE_TYPE);

	

	$area=$app->getPostVar("area");

	
	
	//for find min order value for not shipping charge added
	$obj_model_shipping_charge=$app->load_model("shipping_charge");
	$final_shipping_charge=$obj_model_shipping_charge->execute("SELECT",false,"","");

	
	
		

	$obj_model_area=$app->load_model("area");

	$rs_area=$obj_model_area->execute("SELECT",false,"","id='".$area."'");

	
	
	

	$ship_charge=$rs_area[0]['ship_charge'];

	$min_order=$rs_area[0]['min_order'];

	

	if($_SESSION['subtotal']<$rs_area[0]['min_order'])

	{
		$_SESSION['total_min_charge']=0;
		$_SESSION['area_ship_charge']=$rs_area[0]['ship_charge'];

		

	}else

	{

		$_SESSION['total_min_charge']=0;
		$_SESSION['area_ship_charge']=0;
		

	}

	

	

	

	$ship_charge=$_SESSION['area_ship_charge'];	

	

	if(count($rs_area)>0)

	{

		

		echo $obj_JSON->encode(array("RESULT"=>"1","ship_charge"=>$rs_area[0]['ship_charge'],"min_order"=>$rs_area[0]['min_order']));		

	}

	else

	{

		echo $obj_JSON->encode(array("RESULT"=>"0","ship_charge"=>$ship_charge,"min_order"=>0));

	}

		

		 	

?>