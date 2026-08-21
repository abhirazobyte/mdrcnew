<?php
ini_set("display_errors", "off");
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);
## GET ACTION
$get_actionType=$app->getGetVar("actionType");
$actionType=$app->getPostVar("actionType");

// -------------------- LOAD DATATABLE --------------------
if($get_actionType=="lis_item_list")
{
	$table_name='item_from_lis';
	## READ VALUE
	$draw = $app->getPostVar('draw');
	$row = $app->getPostVar('start');
	$rowperpage = $app->getPostVar('length'); // ROWS DISPLAY PER PAGE
	$orderArray = $app->getPostVar('order');
	$columnIndex = $orderArray[0]['column']; // COLUMN INDEX
	$columnArray = $app->getPostVar('columns');
	$columnName = $columnArray[$columnIndex]['data']; // COLUMN NAME
	if($columnName=='checkbox' || $columnName=='btn' || $columnName=='image')
	{
		$columnName='id';
	}
	$columnSortOrder = $orderArray[0]['dir']; // ASC OR DESC
	$searchArray=$app->getPostVar('search');
	$searchValue = $searchArray['value']; // SEARCH VALUE
	## SEARCH
	$searchQuery = " ";
	if($searchValue != '')
	{
		$searchQuery = " and (
		".$table_name.".id like '%".$searchValue."%' or
		itemname like '%".$searchValue."%' or
		".$table_name.".itemcode like '%".$searchValue."%'
		)
		";
	}
	## TOTAL NUMBER OF RECORDS WITHOUT FILTERING
	$obj_table = $app->load_model($table_name);
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."  where ".$table_name.".id!=''");
	$totalRecords = $result[0]['allcount'];
	## TOTAL NUMBER OF RECORDS WITH FILTERING
	$obj_table = $app->load_model($table_name);
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."  where ".$table_name.".id!='' ".$searchQuery);
	$totalRecordwithFilter = $result[0]['allcount'];
	## FETCH RECORDS
	$obj_item = $app->load_model($table_name);
	$obj_item->join_table("item_other_data", "left", array(), array("id"=>"item_id"));
	$result = $obj_item->execute("SELECT", false, "", "".$table_name.".id!=''  ".$searchQuery.""," ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage." ");
	$folder='lis_item';
	$data = array();
	for($i=0;$i<count($result);$i++)
	{
		$obj_model_user=$app->load_model("item_price_from_lis");
		$item_price=$obj_model_user->execute("SELECT",false,"","item_id='".$result[$i]['itemid']."'");

		$image=$result[$i]["image"];
		$lis_item_img=$app->utility->get_image_path($image,$folder.'/'.$result[$i]['folder'].'/',"");
		$item_department_ids=$result[$i]["item_other_data_item_department_ids"]!=''?$app->utility->getDepartmentData($result[$i]["item_other_data_item_department_ids"]):'';
		$typeID=$result[$i]["ItemType"];
		if($typeID!='Test')
		{
			$packageTestHtml='<br/><span class="badge badge-success">Package</span>';
		}
		else
		{
			$packageTestHtml='<br/><span class="badge badge-info">Test</span>';
		}
		$status='<img src="assets/img/status/'.$result[$i]['status'].'.png" onclick="javascript:change_status(\''.$result[$i]['id'].'\', \'item_from_lis\', \''.$result[$i]['status'].'\')" border="0" id="status_'.$result[$i]['id'].'" style="cursor:pointer" alt="'.$result[$i]['status'].'" data-toggle="tooltip" data-placement="right" title="Tooltip on right" title="'.$result[$i]['status'].'" />';
		$edit_btn='<a href="javascript:void(0)" class="btn btn-xs btn-primary btn-icon mg-r-5 lis_item_addedit_onclick_r" ><i class="fas fa-edit"></i></a>';
		$delete_btn='<button type="button" class="btn btn-xs btn-danger btn-icon lis_item_delete_onclick" data-id="'.$result[$i]['id'].'" ><i class="fas fa-trash"></i></button>';
		$option='<div class="btn-toolbar"><div>-</div></div>';
		$checkbox='<div class="custom-control custom-checkbox"><input type="checkbox" name="del[]" id="del'.$result[$i]['id'].'"  value="'.$result[$i]['id'].'" class="custom-control-input delAll" ><label class="custom-control-label" for="del'.$result[$i]['id'].'"></label></div>';
		
		## DATA
		$data[] = array
		(
			"checkbox"=>$checkbox,
			"id"=>$result[$i]['id'],
			"name"=>$result[$i]['itemname'].$packageTestHtml,
			"center_id"=>$result[$i]["center_id"],
			"price"=>number_format($result[$i]['Rate']??0,2),
			"city"=>count($item_price),
			"code"=>$result[$i]['itemcode'],
			"btn"=>$status
		);
	}
	## RESPONSE
	$response = array(
		"draw" => $draw,
		"iTotalRecords" => $totalRecords,
		"iTotalDisplayRecords" => $totalRecordwithFilter,
		"aaData" => $data
	);
	echo json_encode($response);
	exit;
}
// ----------------------------------------

// -------------------- SYNC LIS WEB SUBMIT --------------------
// if($actionType=="sync_web_lis_itemAddEdit-1")
// {
	
// 	$obj_model_user = $app->load_model("item_lab");
// 	$labs=$obj_model_user->execute("SELECT",false,"SELECT DISTINCT center_id,city_id,id FROM item_lab WHERE status='Active'");
// 	foreach($labs as $lab)
// 	{
// 		$obj_model_user = $app->load_model("item_price_from_lis");
// 		$obj_model_user->join_table("item_from_lis", "left", array(), array("item_id"=>"itemid"));
// 		$lisItems=$obj_model_user->execute("SELECT",false,"","item_price_from_lis.api_center_id='".$lab['center_id']."' and item_price_from_lis.api_city_id='".$lab['city_id']."' and item_from_lis.status='Active'","item_price_from_lis.id desc");

// 		foreach($lisItems as $lisItem)
// 		{
// 			$obj_model_user=$app->load_model("item");
// 			$item=$obj_model_user->execute("SELECT",false,"","itemid='".$lisItem['item_id']."' and status!='Trash'");

// 			if(count($item)>0)
// 			{
// 				$obj_model_city =$app->load_model('city');
// 				$rs_city=$obj_model_city->execute("SELECT",false,"","id='".$lab['city_id']."'");
// 				$city_id=$rs_city[0]['id'];
// 				$state_id=$rs_city[0]['state_id'];
// 				$api_city_id=$rs_city[0]['api_city_id'];
// 				$api_state_id=$rs_city[0]['api_state_id'];
// 				$item_api_city_id=explode(',',$item[0]['api_city_id']);
// 				$item_city_id=explode(',',$item[0]['city_id']);
// 				$item_state_id=explode(',',$item[0]['state_id']);
// 				$item_api_state_id=explode(',',$item[0]['api_state_id']);
				
// 				if(in_array($lab['city_id'],$item_city_id)){

// 					$slug=$app->utility->unique_slug('item','edit','slug',$lisItem['item_from_lis_itemname'],$item[0]['id']);
// 					$update_field = array();
// 					$update_field['name'] = $lisItem['item_from_lis_itemname'];
// 					$update_field['slug'] = $slug;
// 					if($lisItem['item_from_lis_status']=='Inactive'){
// 						$update_field['status'] ='Inactive';
// 					}
// 					$update_field['test_count']=$lisItem['item_from_lis_ParameterCount'];
// 					$obj_model_item = $app->load_model("item");
// 					$obj_model_item->map_fields($update_field);
// 					$item_id=$obj_model_item->execute("UPDATE",false,"","id='".$item[0]['id']."'");

// 				}
// 				else
// 				{
// 					array_push($item_city_id,$city_id);
// 					array_push($item_state_id,$state_id);
// 					array_push($item_api_city_id,$api_city_id);
// 					array_push($item_api_state_id,$api_state_id);

// 					$slug=$app->utility->unique_slug('item','edit','slug',$lisItem['item_from_lis_itemname'],$item[0]['id']);
// 					$update_field = array();
// 					$update_field['name'] = $lisItem['item_from_lis_itemname'];
// 					$update_field['city_ids']=implode(',',$item_city_id);
// 					$update_field['state_ids']=implode(',',$item_state_id);
// 					$update_field['api_city_ids']=implode(',',$item_api_city_id);
// 					$update_field['api_state_ids']=implode(',',$item_api_state_id);
// 					$update_field['slug'] = $slug;
// 					if($lisItem['item_from_lis_status']=='Inactive'){
// 						$update_field['status'] ='Inactive';
// 					}
// 					$obj_model_item = $app->load_model("item");
// 					$obj_model_item->map_fields($update_field);
// 					$item_id=$obj_model_item->execute("UPDATE",false,"","id='".$item[0]['id']."'");

// 				}

// 				$obj_model_user = $app->load_model("item_price");
// 				$item_price=$obj_model_user->execute("SELECT",false,"","item_id='".$item[0]['id']."' and city_id='".$lab['city_id']."'");

// 				if(count($item_price)>0)
// 				{
// 					$single_item_labs=explode(',',$item_price[0]['item_lab_ids']);
// 					if(in_array($lab['id'],$single_item_labs)){
// 						$item_lab_ids=$item_price[0]['item_lab_ids'];
// 					}else{
// 						array_push($single_item_labs,$lab['id']);
// 						$item_lab_ids=implode(',',$single_item_labs);
// 					}
// 					$data = array();
// 					$data['price']=$lisItem['item_from_lis_Rate'];
// 					$data['mrp']='';
// 					$data['sch_price']=$lisItem['item_from_lis_ScheduleRate'];
// 					$data['sch_start_date']=!empty($lisItem['item_from_lis_toDate'])?date('d-m-Y',strtotime($lisItem['item_from_lis_fromDate'])):'';
// 					$data['sch_end_date']=!empty($lisItem['item_from_lis_toDate'])?date('d-m-Y',strtotime($lisItem['item_from_lis_toDate'])):'';
// 					$data['item_lab_ids']=$item_lab_ids;
// 					$obj_model_item=$app->load_model("item_price");
// 					$obj_model_item->map_fields($data);
// 					$obj_model_item->execute("UPDATE",false,"","id='".$item_price[0]['id']."'");
// 				}
// 				else
// 				{
// 					$data = array();
// 					$data['item_id']=$item_id;
// 					$data['price']=$lisItem['item_from_lis_Rate'];
// 					$data['mrp']='';
// 					$data['sch_price']=$lisItem['item_from_lis_ScheduleRate'];
// 					$data['sch_start_date']=!empty($lisItem['item_from_lis_toDate'])?date('d-m-Y',strtotime($lisItem['item_from_lis_fromDate'])):'';
// 					$data['sch_end_date']=!empty($lisItem['item_from_lis_toDate'])?date('d-m-Y',strtotime($lisItem['item_from_lis_toDate'])):'';
// 					$data['city_id']=$city_id;
// 					$data['state_id']=$state_id;
// 					$data['api_city_id']=$api_city_id;
// 					$data['api_state_id']=$api_state_id;
// 					$data['item_lab_ids']=$lab['id'];
// 					$data['entry_date_time']=date('d-m-Y H:i:s');
// 					$data['item_certificate_ids']='';
// 					$obj_model_item=$app->load_model("item_price");
// 					$obj_model_item->map_fields($data);
// 					$obj_model_item->execute("INSERT");
// 				}
// 			}
// 			else
// 			{
// 				if($lisItem['item_from_lis_status']=='Active')
// 				{
					
// 					$obj_model_city =$app->load_model('city');
// 					$rs_city=$obj_model_city->execute("SELECT",false,"","id='".$lab['city_id']."'");
// 					$city_id=$rs_city[0]['id'];
// 					$state_id=$rs_city[0]['state_id'];
// 					$api_city_id=$rs_city[0]['api_city_id'];
// 					$api_state_id=$rs_city[0]['api_state_id'];
				
// 					$slug=$app->utility->unique_slug('item','add','slug',$lisItem['item_from_lis_itemname']);
// 					$update_field = array();
// 					$update_field['name'] = $lisItem['item_from_lis_itemname'];
// 					$update_field['set_at_popular_package'] ='No';
// 					$update_field['set_at_popular_test'] ='No';
// 					$update_field['city_ids']=$city_id;
// 					$update_field['itemid'] = $lisItem['item_id'];
// 					$update_field['itemcode'] =$lisItem['item_from_lis_itemcode'];
// 					$update_field['test_count']=$lisItem['item_from_lis_ParameterCount'];
// 					$update_field['state_ids']=$state_id;
// 					$update_field['api_city_ids']=$api_city_id;
// 					$update_field['api_state_ids']=$api_state_id;
// 					$update_field['status'] = 'Inactive';
// 					$update_field['slug'] = $slug;
// 					$update_field['entry_date_time']=date('d-m-Y H:i:s');
// 					$obj_model_item = $app->load_model("item");
// 					$obj_model_item->map_fields($update_field);
// 					$item_id=$obj_model_item->execute("INSERT");
				
// 					if($item_id>0)
// 					{
// 						$data = array();
// 						$data['item_id']=$item_id;
// 						$data['item_category_ids']='';
// 						$data['item_department_ids']=$item_department_ids;
// 						$data['item_diseases_ids'] ='';
// 						$data['description'] ='';
// 						$data['item_type_id']=$lisItem['item_from_lis_ItemType']=='Test'?'2':'1';
// 						$obj_model_item = $app->load_model("item_other_data");
// 						$obj_model_item->map_fields($data);
// 						$obj_model_item->execute("INSERT");

// 						$data = array();
// 						$data['item_id'] = $item_id;
// 						$data['item_name']=$lisItem['item_from_lis_itemname'];
// 						$obj_model_item = $app->load_model("item_description");
// 						$obj_model_item->map_fields($data);
// 						$obj_model_item->execute("INSERT");
						
					
// 						if($lisItem['Rate']>0)
// 						{
// 							$data = array();
// 							$data['item_id']=$item_id;
// 							$data['price']=$lisItem['item_from_lis_Rate'];
// 							$data['mrp']='';
// 							$data['sch_price']=$lisItem['item_from_lis_ScheduleRate'];
// 							$data['sch_start_date']=!empty($lisItem['item_from_lis_toDate'])?date('d-m-Y',strtotime($lisItem['item_from_lis_fromDate'])):'';
// 							$data['sch_end_date']=!empty($lisItem['item_from_lis_toDate'])?date('d-m-Y',strtotime($lisItem['item_from_lis_toDate'])):'';
// 							$data['city_id']=$city_id;
// 							$data['state_id']=$state_id;
// 							$data['api_city_id']=$api_city_id;
// 							$data['api_state_id']=$api_state_id;
// 							$data['item_lab_ids']=$lab['id'];
// 							$data['entry_date_time']=date('d-m-Y H:i:s');
// 							$data['item_certificate_ids']='';
// 							$obj_model_item =$app->load_model("item_price");
// 							$obj_model_item->map_fields($data);
// 							$obj_model_item->execute("INSERT");
// 						}
// 					}
// 				}
// 			}
// 		}
// 	}
// 	echo $obj_json->encode(array("RESULT"=>0,"url"=>"","msg"=>'Sync LIS Web Insert'));
// 	exit;
// }

if($actionType=="sync_web_lis_itemAddEdit")
{
	$city_id=[];
	$state_id=[];
	$api_city_id=[];
	$api_state_id=[];
	
	
		$pathologyArray = ["BIOCHEMISTRY","CLINICAL PATHOLOGY","CYTOPATHOLOGY","FLOW CYTOMETRY", "HAEMATOLOGY","HISTOPATHOLOGY","IHC-HISTOPATHOLOGY", "HORMONE ASSAYS", "IMMUNOLOGY - SEROLOGY (A)","MICROBIOLOGY","MOLECULAR PATHOLOGY","MOLECULAR MICROBIOLOGY"];

		$radiologyArray=["MASS SPECTROMETRY","NEW BORN SCREENING","MOLECULAR","HIGH END TEST","PET SCAN","X-RAY","ULTRASOUND","NEUROLOGY","MRI","DENTAL","CARDIOLOGY", "CT SCAN"];

		$obj_model_user = $app->load_model("item_from_lis");
		$lisItems=$obj_model_user->execute("SELECT",false,"","item_from_lis.status='Active'","item_from_lis.id desc");
		
		foreach($lisItems as $lisItem)
		{
			$city_id=[];
			$state_id=[];
			$api_city_id=[];
			$api_state_id=[];
			$item_department_ids=NULL;
			
			if(in_array($lisItem['DepartmentName'], $pathologyArray))
			{
				$item_department_ids=2;
			}
			elseif(in_array($lisItem['DepartmentName'], $radiologyArray))
			{
				$item_department_ids=1;
			}
			elseif($lisItem['DepartmentName']=='LAB PACKAGE')
			{
				$item_department_ids=2;
			}
		
			$obj_model_user=$app->load_model("item");
			$item=$obj_model_user->execute("SELECT",false,"","itemid='".$lisItem['itemid']."'");
			
			if(count($item)>0)
			{
				$slug=$app->utility->unique_slug('item','edit','slug',$lisItem['itemname'],$item[0]['id']);
				$update_field = array();
				$update_field['name'] = $lisItem['itemname'];
				$update_field['slug'] = $slug;
				if($lisItem['status']=='Inactive' && $item[0]['status']=='Active'){
					$update_field['status'] ='Inactive';
				}
				$update_field['test_count']=$lisItem['ParameterCount'];
				$obj_model_item = $app->load_model("item");
				$obj_model_item->map_fields($update_field);
				$item_id=$obj_model_item->execute("UPDATE",false,"","id='".$item[0]['id']."'");

				
				$obj_model_user = $app->load_model("item_price_from_lis");
				$obj_model_user->join_table("city", "left", array(), array("api_city_id"=>"id"));
				$obj_model_user->join_table("item_lab", "left", array(), array("api_center_id"=>"center_id"));
				$lisItemPrice=$obj_model_user->execute("SELECT",false,"","item_id='".$lisItem['itemid']."'");
				
				$lisCityIds=array_column($lisItemPrice,'api_city_id');
				
				$obj_model_user = $app->load_model("item_price");
				$item_price=$obj_model_user->execute("SELECT",false,"","item_id='".$item[0]['id']."'");
				
					foreach($item_price as $price)
					{ 
						foreach($lisItemPrice as $price_lis)
						{ 
							if($price['city_id']==$price_lis['api_city_id'])
							{
								$city_id[]=$price['city_id'];
								$state_id[]=$price['city_state_id'];
								$api_city_id[]=$price['city_api_city_id'];
								$api_state_id[]=$price['city_api_state_id'];

								$data = array();
								$data['price']=$price_lis['Rate'];
								$data['mrp']='';
								$data['sch_price']=$price_lis['ScheduleRate'];
								$data['sch_start_date']=!empty($price_lis['toDate'])?date('d-m-Y',strtotime($price_lis['fromDate'])):'';
								$data['sch_end_date']=!empty($price_lis['toDate'])?date('d-m-Y',strtotime($price_lis['toDate'])):'';
								$data['item_lab_ids']=$price_lis['item_lab_id'];
								$obj_model_item=$app->load_model("item_price");
								$obj_model_item->map_fields($data);
								$obj_model_item->execute("UPDATE",false,"","id='".$price['id']."'");
							}
						}
					}

					if(!empty(implode(',',$lisCityIds)))
					{
						$obj_model_item=$app->load_model("item_price");
						$obj_model_item->execute("DELETE",false,"","city_id NOT IN (".implode(',',$lisCityIds).") and item_id='".$item[0]['id']."'");
					}
			
					foreach($lisItemPrice as $price_lis)
					{
						if(!in_array($price_lis['api_city_id'],$city_id))
						{
							//echo $price_lis['api_city_id'];exit;
							$city_id[]=$price_lis['city_id'];
							$state_id[]=$price_lis['city_state_id'];
							$api_city_id[]=$price_lis['city_api_city_id'];
							$api_state_id[]=$price_lis['city_api_state_id'];

							$data = array();
							$data['price']=$price_lis['Rate'];
							$data['mrp']='';
							$data['item_id']=$item[0]['id'];
							$data['city_id'] =$price_lis['api_city_id'];
							$data['state_id'] =$price_lis['city_state_id'];
							$data['api_city_id']=$price_lis['city_api_city_id'];
							$data['api_state_id']=$price_lis['city_api_state_id'];
							$data['sch_price']=$price_lis['ScheduleRate'];
							$data['sch_start_date']=!empty($price_lis['toDate'])?date('d-m-Y',strtotime($price_lis['fromDate'])):'';
							$data['sch_end_date']=!empty($price_lis['toDate'])?date('d-m-Y',strtotime($price_lis['toDate'])):'';
							$data['item_lab_ids']=$price_lis['item_lab_id'];
							$data['entry_date_time']=date('d-m-Y H:i:s');
							$obj_model_item=$app->load_model("item_price");
							$obj_model_item->map_fields($data);
							$obj_model_item->execute("INSERT",false,"","");

						}
						
					}
					
					$update_field = array();
					$update_field['city_ids']=implode(',',array_unique($city_id));
					$update_field['state_ids']=implode(',',array_unique($state_id));
					$update_field['api_city_ids']=implode(',',array_unique($api_city_id));
					$update_field['api_state_ids']=implode(',',array_unique($api_state_id));
					$obj_model_item = $app->load_model("item");
					$obj_model_item->map_fields($update_field);
					$item_id=$obj_model_item->execute("UPDATE",false,"","id='".$item[0]['id']."'");
			}
			else
			{
				
				if($lisItem['status']=='Active')
				{
					
					$slug=$app->utility->unique_slug('item','add','slug',$lisItem['itemname']);
					$update_field = array();
					$update_field['name'] = $lisItem['itemname'];
					$update_field['set_at_popular_package'] ='No';
					$update_field['set_at_popular_test'] ='No';
					$update_field['itemid'] = $lisItem['itemid'];
					$update_field['itemcode'] =$lisItem['itemcode'];
					$update_field['test_count']=$lisItem['ParameterCount'];
					$update_field['status'] = 'Inactive';
					$update_field['slug'] = $slug;
					$update_field['entry_date_time']=date('d-m-Y H:i:s');
					$obj_model_item = $app->load_model("item");
					$obj_model_item->map_fields($update_field);
					$item_id=$obj_model_item->execute("INSERT");
				
					if($item_id>0)
					{
						$data = array();
						$data['item_id']=$item_id;
						$data['item_category_ids']='';
						$data['item_department_ids']=$item_department_ids;
						$data['item_diseases_ids'] ='';
						$data['description'] ='';
						$data['item_type_id']=$lisItem['ItemType']=='Test'?'2':'1';
						$obj_model_item = $app->load_model("item_other_data");
						$obj_model_item->map_fields($data);
						$obj_model_item->execute("INSERT");

						$data = array();
						$data['item_id'] = $item_id;
						$data['item_name']=$lisItem['itemname'];
						$obj_model_item = $app->load_model("item_description");
						$obj_model_item->map_fields($data);
						$obj_model_item->execute("INSERT");
						
						$obj_model_user = $app->load_model("item_price_from_lis");
						$obj_model_user->join_table("city", "left", array(), array("api_city_id"=>"id"));
						$obj_model_user->join_table("item_lab", "left", array(), array("api_center_id"=>"center_id"));
						$lisItemPrice=$obj_model_user->execute("SELECT",false,"","item_id='".$lisItem['itemid']."'");
						
						foreach($lisItemPrice as $price)
						{
							$city_id[]=$price['city_id'];
							$state_id[]=$price['city_state_id'];
							$api_city_id[]=$price['city_api_city_id'];
							$api_state_id[]=$price['city_api_state_id'];

							$data = array();
							$data['item_id']=$item_id;
							$data['price']=$price['Rate'];
							$data['mrp']='';
							$data['sch_price']=$price['ScheduleRate'];
							$data['sch_start_date']=!empty($price['toDate'])?date('d-m-Y',strtotime($price['fromDate'])):'';
							$data['sch_end_date']=!empty($price['toDate'])?date('d-m-Y',strtotime($price['toDate'])):'';
							$data['city_id']=$price['city_id'];
							$data['state_id']=$price['city_state_id'];
							$data['api_city_id']=$price['city_api_city_id'];
							$data['api_state_id']=$price['city_api_state_id'];
							$data['item_lab_ids']=$price['item_lab_id'];
							$data['entry_date_time']=date('d-m-Y H:i:s');
							$data['item_certificate_ids']='';
							$obj_model_item =$app->load_model("item_price");
							$obj_model_item->map_fields($data);
							$obj_model_item->execute("INSERT");
						}
						
						$update_field = array();
						$update_field['city_ids']=implode(',',array_unique($city_id));
						$update_field['state_ids']=implode(',',array_unique($state_id));
						$update_field['api_city_ids']=implode(',',array_unique($api_city_id));
						$update_field['api_state_ids']=implode(',',array_unique($api_state_id));
						$obj_model_item = $app->load_model("item");
						$obj_model_item->map_fields($update_field);
						$obj_model_item->execute("UPDATE",false,"","id='".$item_id."'");
					}
				}
			}
		
		}
	echo $obj_json->encode(array("RESULT"=>0,"url"=>"","msg"=>'Sync LIS Web Insert'));
	exit;
}
// ----------------------------------------



// -------------------- SYNC RECORD & MAP --------------------
if($actionType=="sync_lis_test_item")
{
	$obj_model_user = $app->load_model("item_lab");
	$labs=$obj_model_user->execute("SELECT",false,"SELECT city_id,center_id,rate_list_panel_id,department_names,excluding_department_names FROM item_lab WHERE status='Active' and rate_list_panel_id!='1'");

	$obj_model_lis_item_department = $app->load_model("lis_item_department");
	$lis_item_department=$obj_model_lis_item_department->execute("SELECT",false,"","");
	
	
	$_SESSION['temp_check']=[];
	if(count($labs)>0){
		$existsLabId=[];
		foreach($labs as $lab)
		{
			foreach($lis_item_department as $item_d)
			{
				
				if(in_array($item_d['id'],explode(',',$lab['department_names'])) && $lab['department_names']!='')
				{
					$department_names[]=$item_d['name'];
				}
				if(in_array($item_d['id'],explode(',',$lab['excluding_department_names'])) && $lab['excluding_department_names']!='')
				{
					$excluding_department_names[]=$item_d['name'];
				}
			}
			$string=$lab['city_id'].$lab['rate_list_panel_id'];
			if(!in_array($string,$_SESSION['temp_check']))
			{
				$_SESSION['temp_check'][]=$string;

				$curl = curl_init();

				curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://lis6.mdrcindia.com/mdrcnew/api/HomeAPI/GetItemListPanel',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => 'PanelID='.$lab['rate_list_panel_id'],
				CURLOPT_HTTPHEADER => array(
					'Content-Type: application/x-www-form-urlencoded'
				),
				));
				$response = curl_exec($curl);
				curl_close($curl);
				$responseData=json_decode($response,true);
				
				$city_id=[];
				$existsId=[];
				if($responseData['status']=='1')
				{
					foreach($responseData['data'] as $item)
					{
						if((!in_array(trim($item['DepartmentName']),$excluding_department_names)) && (in_array(trim($item['DepartmentName']),$department_names) || count($department_names)==0))
						{
							$existsLabId[]=$item['itemid'];
							$existsId[]=$item['itemid'];
							$obj_model_user = $app->load_model("item_from_lis");
							$lisItem=$obj_model_user->execute("SELECT",false,"","itemid='".$item['itemid']."'");
	
							$item['center_id']=$lab['center_id'];
							
							if(empty($lisItem))
							{
								$item['status']='Active';
								$obj_model_user = $app->load_model("item_from_lis");
								$obj_model_user->map_fields($item);
								$obj_model_user->execute("INSERT",false,"","");
							}
							else
							{
								$obj_model_user = $app->load_model("item_from_lis");
								$obj_model_user->map_fields($item);
								$obj_model_user->execute("UPDATE",false,"","id='".$lisItem[0]['id']."'");
							}
	
							$obj_model_user = $app->load_model("item_price_from_lis");
							$lisItemPrice=$obj_model_user->execute("SELECT",false,"","item_id='".$item['itemid']."' and api_city_id='".$lab['city_id']."'");

							

							$data=array();
							$data['api_city_id']=$lab['city_id'];
							$data['api_center_id']=$lab['center_id'];
							$data['item_id']=$item['itemid'];
							$data['Rate']=$item['Rate'];
							$data['ScheduleRate']=$item['ScheduleRate'];
							$data['fromDate']=$item['fromDate'];
							$data['toDate']=$item['toDate'];
							$obj_model_user = $app->load_model("item_price_from_lis");
							$obj_model_user->map_fields($data);
							if(empty($lisItemPrice))
							{
								$obj_model_user->execute("INSERT",false,"","");
							}
							else
							{
								$obj_model_user->execute("UPDATE",false,"","id='".$lisItemPrice[0]['id']."'");
							}
							
							$city_id[]=$lab['city_id'];
							
						}
					}
					if(count($existsId)>0)
					{
						$obj_model_user=$app->load_model("item_price_from_lis");
						$obj_model_user->execute("DELETE",false,"","api_center_id='".$lab['center_id']."' and item_id NOT IN (".implode(',',array_unique(array_filter($existsId))).")");
					}
				}
			}
		}
		if(count($existsLabId)>0)
		{
			unset($item);
			$item=array();
			$item['status']='Inactive';
			$obj_model_user = $app->load_model("item_from_lis");
			$obj_model_user->map_fields($item);
			$obj_model_user->execute("UPDATE",false,"","itemid NOT IN (".implode(',',array_unique(array_filter($existsLabId))).")");
		}
		$msg='Success';
		$msgcode=0;
	}else{
		$msg='Please Try Again.';
		$msgcode=1;
	}
}
if($actionType=="sync_lis_item_empty")
{
	$obj_model_user = $app->load_model("item_from_lis");
	$obj_model_user->execute("DELETE",false,"TRUNCATE TABLE item_from_lis");

	$obj_model_user = $app->load_model("item_price_from_lis");
	$obj_model_user->execute("DELETE",false,"TRUNCATE TABLE item_price_from_lis");
	
	$msg='Success';
	$msgcode=0;	
}
// ============================ save backup ====================
if($actionType=="sync_lis_item_save_backup")
{
	$table=['item', 'item_price', 'item_other_data'];
	$tableList = implode(' ', $table);
	// Backup file name with current timestamp
	$backupFile=ABS_PATH.'/uploads/db_backup/' . $table . '_backup_' . date('Y-m-d_H-i-s') . '.sql';
	// Command to execute mysqldump
	$command = "mysqldump --user={DB_USERNAME} --password={DB_PASSWORD} --host={DB_HOST} {DB_DATABASE} {$tableList} > {$backupFile}";
	// Execute the command
	exec($command, $output, $returnVar);
	
	$msg='Success';
	$msgcode=0;	
}
// ----------------------------------------



// -------------------- DELETE --------------------
if($actionType=="lis_itemDelete")
{
	$getid=$app->getPostVar('getid');
	if($getid!= NULL && $getid>0)
	{
		$obj_change_table = $app->load_model('item_from_lis');
		$update_id = $obj_change_table->execute("DELETE",false,"","id='".$getid."'");
		if($update_id>0)
		{
			$msg='Success';
			$msgcode=0;
		}
		else
		{
			$msg='Please Try Again.';
			$msgcode=1;
		}
	}
	else
	{
		$msg='Please Try Again.';
		$msgcode=1;
	}
}
// ----------------------------------------
if($actionType=="itemMultiInactive")
{
	$ids=$app->getPostVar('ids');
	$temp_ids=explode(',',$ids);
	if($ids != NULL && $ids!='')
	{
		for($i=0;$i<count($temp_ids);$i++)
		{
			$data=array();
			$data['status']='Inactive';
			$obj_change_table = $app->load_model('item_from_lis');
			$obj_change_table->map_fields($data);
			$update_id = $obj_change_table->execute("UPDATE",false,"","id=".$temp_ids[$i]."");
		}
		if($update_id>0)
		{
			$msg='Sucess';
			$msgcode=0;
		}
		else
		{
			$msg='Please Try Again.';
			$msgcode=1;
		}
	}
	else
	{
		$msg='Please Try Again.';
		$msgcode=1;
	}
}
echo $obj_json->encode(array("RESULT"=>$msgcode,"url"=>"","msg"=>$msg));
?>