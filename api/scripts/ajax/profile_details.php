<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);

$name=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("name"));
$last_name=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("last_name"));
$customer_email=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("email"));

if($_SESSION['MDRCCustID']!='')
{
	$obj_model_user =$app->load_model("customer");
	$obj_model_user->set_fields_to_get(array("phone","status","name"));
	$rs_user = $obj_model_user->execute("SELECT",false,"","id='".$_SESSION['MDRCCustID']."' and status!='Trash'","");

	if(count($rs_user)<=0)
	{
		$RESULT='NOT OK';
		$MSG='Your Account is Disabled By Admin. Contact Admin.';
		echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG));
		exit;
	}

	if($customer_email!='')
	{
		$obj_model_user1 =$app->load_model("customer");
		$obj_model_user1->set_fields_to_get(array("email","status"));
		$rs_user1 = $obj_model_user1->execute("SELECT",false,"","email='".$customer_email."' and id!='".$_SESSION['MDRCCustID']."' and status!='Trash'","");
		if(count($rs_user1)>0)
		{
			$RESULT='NOT OK';
			$MSG='Account with '.$customer_email.' email address is already exit.';
			echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG));
			exit;
		}
	}

	$data_t=array();
	$data_t['name']=$name;
	$data_t['last_name']=$last_name;
	$data_t['email']=$customer_email;
	$data['ip']=$_SERVER['REMOTE_ADDR'];
	$data['entry_date_time']=date('d-m-Y H:i:s');
	$obj_model_customer=$app->load_model("customer");
	$obj_model_customer->map_fields($data);
	$obj_model_customer->execute("UPDATE",false,"","id='".$_SESSION['MDRCCustID']."'");

	$RESULT='OK';
	$MSG='Successfully.';
	echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG));
	exit;
}
else
{
	$RESULT='NOT OK';
	$MSG='Please Fill Require Data.';
	echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG));
	exit;
}
echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG));
?>