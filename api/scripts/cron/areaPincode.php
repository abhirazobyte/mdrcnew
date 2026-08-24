<?php
include("../../core/app.php");
$app = &app::get_instance();
$app->initialize();
echo mdrc_staging_disabled_message();
exit;
$data=$app->utility->dataFromApi($url,$request_parameter);
$result_data=json_decode($data, true);
$allData=$result_data['data'];
for($i=0;$i<count($allData);$i++)
{
	$StateID=$allData[$i]['StateID'];
	$State=$allData[$i]['State'];
	$CityID=$allData[$i]['CityID'];
	$City=$allData[$i]['City'];
	$AreaID=$allData[$i]['AreaID'];
	$Area=$allData[$i]['Area'];
	$PinCode=$allData[$i]['PinCode'];
	$AppointmentStartTime=$allData[$i]['AppointmentStartTime'];
	$EndStartTime=$allData[$i]['EndStartTime'];
	
	$obj_model_table=$app->load_model("state");
	$rs_state=$obj_model_table->execute("SELECT",false,"","name='".$State."'","");
	$state_id=$rs_state[0]['id'];
	  
	  $data=array();
	  $data['api_state_id']=$StateID;
	  $data['name']=$State;	  
	  $data['entry_date_time']=date("d-m-Y H:i:s");	  
	  if($state_id<=0)
	  {
		  $data['sort_order']=1;
	  	  $data['status']='Active';
		  $obj_table = $app->load_model("state");
		  $obj_table->map_fields($data);
		  $state_id=$obj_table->execute("INSERT");
		  
	  }
	  else
	  {
		  
		  $obj_table = $app->load_model("state");
		  $obj_table->map_fields($data);
		  $obj_table->execute("UPDATE",false,"","id='".$state_id."'");
	  }
	  
	  
 	$obj_model_table=$app->load_model("city");
	$rs_city=$obj_model_table->execute("SELECT",false,"","name='".$City."' and state_id='".$state_id."'","");
	$city_id=$rs_city[0]['id'];
	  
	  $data=array();
	  $data['api_state_id']=$StateID;
	  $data['api_city_id']=$CityID;
	  $data['state_id']=$state_id;
	  $data['name']=$City;	  
	  $data['entry_date_time']=date("d-m-Y H:i:s");	  
	  if($city_id<=0)
	  {
		  $data['sort_order']=1;
	  	  $data['status']='Active';
		  $obj_table = $app->load_model("city");
		  $obj_table->map_fields($data);
		  $city_id=$obj_table->execute("INSERT");
		  
	  }
	  else
	  {
		  
		  $obj_table = $app->load_model("city");
		  $obj_table->map_fields($data);
		  $obj_table->execute("UPDATE",false,"","id='".$city_id."'");
	  }
	  
	  
	  
	$obj_model_table=$app->load_model("area");
	$rs_area=$obj_model_table->execute("SELECT",false,"","name='".$Area."' and state_id='".$state_id."'  and city_id='".$city_id."'","");
	$area_id=$rs_area[0]['id'];
	  
	  $data=array();
	  $data['api_state_id']=$StateID;
	  $data['api_city_id']=$CityID;
	  $data['api_area_id']=$AreaID;
	  $data['state_id']=$state_id;
	  $data['city_id']=$city_id;
	  $data['name']=$Area;	  
	  $data['entry_date_time']=date("d-m-Y H:i:s");	  
	  if($area_id<=0)
	  {
		  $data['sort_order']=1;
	  	  $data['status']='Active';
		  $obj_table = $app->load_model("area");
		  $obj_table->map_fields($data);
		  $area_id=$obj_table->execute("INSERT");
		  
	  }
	  else
	  {
		  
		  $obj_table = $app->load_model("area");
		  $obj_table->map_fields($data);
		  $obj_table->execute("UPDATE",false,"","id='".$area_id."'");
	  }
	  
	  
	  
	  
	  
	  
	 $obj_model_table=$app->load_model("pincode");
	 $rs_pincode=$obj_model_table->execute("SELECT",false,"","name='".$PinCode."' and state_id='".$state_id."'  and city_id='".$city_id."' and area_id='".$area_id."'","");
	 
	
	
	 $pincode_id=$rs_pincode[0]['id'];
	  
	  $data=array();
	  $data['api_state_id']=$StateID;
	  $data['api_city_id']=$CityID;
	  $data['api_area_id']=$AreaID;
	  $data['state_id']=$state_id;
	  $data['city_id']=$city_id;
	  $data['area_id']=$area_id;
	  $data['name']=$PinCode;	  
	  $data['appointment_start_time']=$AppointmentStartTime;
	  $data['appointment_end_time']=$EndStartTime;	  	  
	  $data['entry_date_time']=date("d-m-Y H:i:s");	  
	  if($pincode_id<=0)
	  {
		  $data['sort_order']=1;
	  	  $data['status']='Active';
		  $obj_table = $app->load_model("pincode");
		  $obj_table->map_fields($data);
		  $city_id=$obj_table->execute("INSERT");
		 
		 
		  
	  }
	  else
	  {
		  
		  $obj_table = $app->load_model("pincode");
		  $obj_table->map_fields($data);
		  $obj_table->execute("UPDATE",false,"","id='".$pincode_id."'");
	  }
	
	
	
	
		
}

$app->unload();
?>