<?php
class _test extends controller
{
	function init()
	{
		if($this->app->getCurrentAction()=="")
		{
			$this->load_data();
		}
	}

	function onload()
	{
		echo 'Success';
		exit;
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'http://182.156.200.228/mdrcnew/api/HomeAPI/GetItemListPanel',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => 'PanelID=78',
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/x-www-form-urlencoded'
			),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		$responseData=json_decode($response,true);
				
		if($responseData['status']=='1')
		{
			foreach($responseData['data'] as $item)
			{
				$obj_model_user = $this->app->load_model("item");
				$itemCheck=$obj_model_user->execute("SELECT",false,"","itemid='".$item['itemid']."'");

				if(count($itemCheck)>0)
				{
					$update_field = array();
					$update_field['test_count']=$item['ParameterCount'];
					$obj_model_item = $this->app->load_model("item");
					$obj_model_item->map_fields($update_field);
					$obj_model_item->execute("UPDATE",false,"","id='".$itemCheck[0]['id']."'");
				}
			}
		}
		
	}	
		
	function load_data()
	{
	}	
	
}	
?>