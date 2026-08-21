<?php
include("../../core/app.php");
$app = &app::get_instance();
$app->initialize();


exit;



$obj_model_item = $app->load_model("item");
$allData=$obj_model_item->execute("SELECT",false,"","test_count=0");

for($i=0;$i<count($allData);$i++)
{
	$item_id=$allData[$i]['id'];
	$itemid=$allData[$i]['itemid'];
	
	
	
	$url1='api/HomeAPI/GetItemInClusion';
	$request_parameter1="Itemid=".$itemid;
	$data1=$app->utility->dataFromApi($url1,$request_parameter1);
	$result_data1=json_decode($data1, true);
	$detail_data=$result_data1['data'];
	
	
	
	
	
				for($j=0;$j<count($detail_data);$j++)
				{
					
					
						$checckitemid=$detail_data[$j]['itemid'];
						
						
						$obj_model_check = $app->load_model("item");
						$rs_check=$obj_model_check->execute("SELECT",false,"","itemid='".$checckitemid."'");
						
						
						if(count($rs_check)>0)
						{
						
	
						$data = array();
						$data['item_id'] = $item_id;
						$data['data_id'] = $rs_check[0]['id'];
						$data['itemid'] = $rs_check[0]['itemid'];
						$data['sort_order'] = $j;
						$data['entry_date_time'] = date('d-m-Y H:i:s');
						$obj_model_item = $app->load_model("item_package_data");
						$obj_model_item->map_fields($data);
						$obj_model_item->execute("INSERT");
						
						}
						
				}
						
						
						
				
				
				
						
					
					
	 
		 
		 
		
		
	
	
	
	
		
}

$app->unload();
?>