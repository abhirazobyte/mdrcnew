<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);

$name = $app->getPostVar("name");
$phone = $app->getPostVar("phone");
$city = $app->getPostVar("city");
$fmessage = $app->getPostVar("fmessage");

if($name!='' && $phone!='')
{

   	$fields_map = array();	
	$fields_map['customer_id'] = $_SESSION['MDRCCustID'];
	$fields_map['name'] = $name;
	$fields_map['city'] = $city;
	$fields_map['phone'] = $phone;
	$fields_map['message'] = $fmessage;
	$fields_map['ip'] = $_SERVER['REMOTE_ADDR'];
	$fields_map['added'] =  date('Y-m-d');

	$obj_model_newsletter=$app->load_model('get_call_back');
	$obj_model_newsletter->map_fields($fields_map);
	$id=$obj_model_newsletter->execute("INSERT");

	if($id>0)
	{
		/*------------------Start for mail function------------------*/
		$template_name='get_in_touch_admin';
		$send_data_arary=['name'=>$name,'city'=>$city,'phone'=>$phone,'message'=>$fmessage];
		$subject='Get In Touch from '.$name.' on Website';
		$mail_for='Admin';
		$data=['template_name'=>$template_name,'send_data_arary'=>$send_data_arary,'subject'=>$subject,'mail_for'=>$mail_for];
		$app->utility->sendMial($data);
		/*------------------End for mail function------------------*/

		$RESULT='1';
		$MSG='Successfully';
	}
	else
	{
		$RESULT='0';
		$MSG='Something went wrong !';
	}
}
else
{
	$RESULT='0';
	$MSG='Something went wrong !';
}

//call api for add data in crm
if($RESULT=='1')
{
	$obj_model_phone=$app->load_model('get_call_back');
	$checkPhone=$obj_model_phone->execute("SELECT",false,"","phone='".$phone."'");
	if(count($checkPhone)<=0)
	{
		require_once('../ripcord-master/ripcord.php');
	
		$url = CRM_URL;
		$db = CRM_DB;
		$email = CRM_EMAIL;
		$password = CRM_PASSWORD;

		$common = ripcord::client("$url/xmlrpc/2/common");
		$uid = $common->authenticate($db, $email, $password, []);
		
		if(!empty($uid)) {
			$models = ripcord::client("$url/xmlrpc/2/object");
	
			// an example of how to call the create method in res.partner model
			$values = [
				'name' => $name,
				'city' => $city,
				'mobile' => $phone
			];
			$partners = $models->execute_kw($db, $uid, $password, 'res.partner', 'create', [$values]);
    	}
	}
}

echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG));	

?>