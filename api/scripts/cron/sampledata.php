<?php
include("../../core/app.php");
$app = &app::get_instance();
$app->initialize();
exit;
$url='';
$request_parameter="StateID=11&CityID=9";
$data=$app->utility->dataFromApi($url,$request_parameter);
$result_data=json_decode($data, true);
$allData=$result_data['data'];



for($i=0;$i<count($allData);$i++)
{
	$itemid=$allData[$i]['itemid'];
	$name=$allData[$i]['itemname'];
	$itemcode=$allData[$i]['itemcode'];
	$Rate=$allData[$i]['Rate'];
	$ItemType=$allData[$i]['ItemType'];
	$TestCount=$allData[$i]['TestCount'];
	
	
	if($ItemType=='Test')
	{
		$item_type_id=2;
		
	}
	else
	{
		
		$item_type_id=1;
	}
	
	
	$url1='';
	$request_parameter1="Itemid=".$itemid;
	$data1=$app->utility->dataFromApi($url1,$request_parameter1);
	$result_data1=json_decode($data1, true);
	$detail_data=$result_data1['data'];
	
	
	
			$city_ids='1,2';
	
			$getDats=$app->utility->getApiCitStateRecord($city_ids);
			$city_ids=$getDats['city_ids'];
			$state_ids=$getDats['state_ids'];
			$api_city_ids=$getDats['api_city_ids'];
			$api_state_ids=$getDats['api_state_ids'];
	
	
	
			$slug=$app->utility->unique_slug('item','add','slug',$name);
			//$brand_name=$this->app->utility->get_brandName($this->app->getPostVar('brand_id'));
			$update_field = array();
					
			$update_field['name'] = $name;
			$update_field['itemid'] = $itemid;
			$update_field['itemcode'] = $itemcode;
			$update_field['test_count'] = $TestCount;			
			$update_field['city_ids'] = $city_ids;
			$update_field['state_ids'] = $state_ids;
			$update_field['api_city_ids'] = $api_city_ids;
			$update_field['api_state_ids'] = $api_state_ids;			
			$update_field['status'] = 'Active';
			$update_field['slug'] = $slug;
			$update_field['entry_date_time'] = date('d-m-Y H:i:s');
			$obj_model_item = $app->load_model("item");
			$obj_model_item->map_fields($update_field);
			$item_id=$obj_model_item->execute("INSERT");
			
			
				
			
					$data = array();
					$data['item_id'] = $item_id;
					$data['item_category_ids'] = rand(1,9);
					$data['item_department_ids'] = rand(1,2);
					$data['item_diseases_ids'] = rand(1,9);
					$data['item_type_id'] = $item_type_id;
					
					$data['description'] = '';
					$obj_model_item = $app->load_model("item_other_data");
					$obj_model_item->map_fields($data);
					$obj_model_item->execute("INSERT");
					
					
					
					if($ItemType=='Test')
					{
						
						
						$required_attachment=$detail_data[0]['RequiredAttachment'];
						
						if($required_attachment=='')
						{
							$prescription_required='No';
							
						}
						else
						{
							$prescription_required='Yes';	
						}
					
						$data = array();
						$data['item_id'] = $item_id;
						$data['item_name'] = $name;
						$data['sample_remark'] = $detail_data[0]['SampleRemarks'];
						$data['sample_type_name'] = $detail_data[0]['SampleTypeName'];
						$data['sample_remark1'] = $detail_data[0]['sampleremarks1'];
						$data['test_parameters'] = $detail_data[0]['TestParameters'];
						$data['prescription_required'] = $prescription_required;
						$data['required_attachment'] = $required_attachment;
						$data['from_age_days'] = 1;
						$data['to_age_days'] = 99;
						$obj_model_item = $app->load_model("item_description");
						$obj_model_item->map_fields($data);
						$obj_model_item->execute("INSERT");
					
					}
					else
					{
						$data = array();
						$data['item_id'] = $item_id;
						$data['from_age_days'] = 1;
						$data['to_age_days'] = 99;
						$obj_model_item = $app->load_model("item_description");
						$obj_model_item->map_fields($data);
						$obj_model_item->execute("INSERT");
						
						
						
						
						
					}
					
					
					
					
					
					$cityData=explode(',',$city_ids);
					for($j=0;$j<count($cityData);$j++)
					{
						
						
						
							$obj_model_city = $app->load_model('city');
							$rs_city=$obj_model_city->execute("SELECT",false,"","id='".$cityData[$j]."'");
							
														
							
							$city_id=$rs_city[0]['id'];
							$state_id=$rs_city[0]['state_id'];
							$api_city_id=$rs_city[0]['api_city_id'];
							$api_state_id=$rs_city[0]['api_state_id'];
							
							$data = array();
							$data['item_id'] = $item_id;
							$data['price'] = $Rate;
							$data['mrp'] = 0;
							$data['sch_price'] = 0;
							$data['sch_start_date'] = '';
							$data['sch_end_date'] = '';
							$data['city_id'] = $city_id;
							$data['state_id'] = $state_id;
							$data['api_city_id'] = $api_city_id;
							$data['api_state_id'] = $api_state_id;					
							$data['entry_date_time'] = date('d-m-Y H:i:s');
							$obj_model_item = $app->load_model("item_price");
							$obj_model_item->map_fields($data);
							$obj_model_item->execute("INSERT");
						
						
					
					}
	 
		 
		 
		
		
	
	
	
	
		
}

$app->unload();
?>