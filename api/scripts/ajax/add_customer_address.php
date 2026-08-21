<?php 
$jsonclass = $app->load_module("Services_JSON");
$obj_JSON = new $jsonclass(SERVICES_JSON_LOOSE_TYPE);
$id=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("id"));
$customer_id=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("customer_id"));

$first_name=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("first_name"));
$last_name=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("last_name"));
$phone=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("phone"));

$line1=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("line1"));
$line2=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("line2"));
$zipcode=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("zipcode"));
$city=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("city"));
$address_type=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("address_type"));
$state_id=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("state_id"));
$app_type='Web';

if($line1!=''  && $customer_id!='')
{
	$update_field = array();
	$update_field['customer_id']=$customer_id;
	
	
	$update_field['first_name']=$first_name;
	$update_field['last_name']=$last_name;
	$update_field['phone']=$phone;
	$update_field['line1']=$line1;
	$update_field['line2']=$line2;	
	$update_field['city']=$city;
	$update_field['state_id']=$state_id;
	$update_field['address_type']=$address_type;
	$update_field['updated_from']=$app_type;
	$update_field['zipcode']=$zipcode;
	$update_field['ip_address']=$_SERVER['REMOTE_ADDR'];
	$update_field['customer_address_register_date']=date('d-m-Y H:i:s');
	$update_field['customer_address_update_date']=date('d-m-Y H:i:s');
	$obj_model_user = $app->load_model("customer_address");
	$obj_model_user->map_fields($update_field);

	if($id>0)
	{
		$obj_model_user->execute("UPDATE",false,"","id='".$id."'");
		$msg="Address Updated Successfully.";
	}
	else
	{
		$insid=$obj_model_user->execute("INSERT",false,"","");
		$msg='Address Added Successfully.';
	}
	if($insid>0)
	{
		$obj_model_update = $app->load_model("customer_address");
		$obj_model_update->execute("UPDATE",false,"UPDATE customer_address SET default_address=0 WHERE customer_id='".$user_id."'");

		$obj_model_update1 = $app->load_model("customer_address");
		$obj_model_update1->execute("UPDATE",false,"UPDATE customer_address SET default_address=1 WHERE customer_id='".$user_id."' and id='".$insid."'");
					
		echo $obj_JSON->encode(array("RESULT"=>"0","MSG"=>$msg));	
		exit;
	}
	echo $obj_JSON->encode(array("RESULT"=>"0","MSG"=>$msg));	
	exit;
}
else
{
	if($name=='')
	{
		echo $obj_JSON->encode(array("RESULT"=>"1","MSG"=>"Please Enter Name."));	
	}
	else if($phone=='')
	{
		echo $obj_JSON->encode(array("RESULT"=>"1","MSG"=>"Please Enter Phone No."));	
	}
	else
	{
		echo $obj_JSON->encode(array("RESULT"=>"1","MSG"=>"Please Fill Require Data."));
	}	
}
?>