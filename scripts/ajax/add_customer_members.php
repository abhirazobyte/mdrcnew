<?php 
$jsonclass = $app->load_module("Services_JSON");
$obj_JSON = new $jsonclass(SERVICES_JSON_LOOSE_TYPE);
$id=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("id"));
$customer_id=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("customer_id"));

$cartID=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("cartID"));

$first_name=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("first_name"));
$last_name=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("last_name"));
$phone1=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("phone1"));
$phone2=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("phone2"));
$relation=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("relation"));
$age=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("age"));
$dob=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("dob"));
$prefix=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("prefix"));
$relation=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("relation"));


$line1=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("line1"));
$area=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("area"));


$pincode=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("pincode"));
$city_id=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("city_id"));
$state_id=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("state_id"));

$app_type='Web';

if($first_name!=''  && $customer_id!='')
{
	
	//$obj_model_data = $app->load_model("pincode");
	//$rs_check=$obj_model_data->execute("SELECT",false,"","name='".$pincode."'");
	
	//$api_state_id=$rs_check[0]['api_state_id'];
	//$api_city_id=$rs_check[0]['api_city_id'];
	//$api_area_id=$rs_check[0]['api_area_id'];
	//$state_id=$rs_check[0]['state_id'];
	//$city_id=$rs_check[0]['city_id'];
	//$area_id=$rs_check[0]['area_id'];
	
	
	
	$update_field = array();
	$update_field['customer_id']=$customer_id;
	$update_field['line1']=$line1;
	$update_field['area']=$area;
	$update_field['pincode']=$pincode;
	
	$update_field['api_state_id']=$api_state_id;
	$update_field['api_city_id']=$api_city_id;
	$update_field['api_area_id']=$api_area_id;
	$update_field['state_id']=$state_id;
	$update_field['city_id']=$city_id;
	$update_field['area_id']=$area_id;
	
	$update_field['entry_date_time']=date('d-m-Y H:i:s');
	$update_field['status']='Active';
	$obj_model_user = $app->load_model("customer_members");
	$obj_model_user->map_fields($update_field);

	if($id>0)
	{
		$obj_model_user->execute("UPDATE",false,"","id='".$id."'");
		$msg="Member Updated Successfully.";
		$memberID=$id;
	}
	else
	{
		$insid=$obj_model_user->execute("INSERT",false,"","");
		$msg='Member Added Successfully.';
		
		$memberID=$insid;
	}
	
	
	echo $obj_JSON->encode(array("RESULT"=>"0","MSG"=>$msg,"cartID"=>$cartID,"memberID"=>$memberID));	
	exit;
}
else
{
	if($first_name=='')
	{
		echo $obj_JSON->encode(array("RESULT"=>"1","MSG"=>"Please Enter First Name."));	
	}
	
	
	else
	{
		echo $obj_JSON->encode(array("RESULT"=>"1","MSG"=>"Please Fill Require Data."));
	}	
}
?>