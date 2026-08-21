<?php



$json_class = $app->load_module("JSON");



$obj_json = new $json_class(JSON_LOOSE_TYPE);







//get action



$get_actionType=$app->getGetVar("actionType");



$actionType=$app->getPostVar("actionType");







//Function for Admin Logins datatbale loading



if($get_actionType=="help_list")



{



	$table_name='help';

	$current_status=$app->getGetVar("current_status");



	if($current_status!='')

	{

		$status_cond=" AND help.status='".$current_status."'";

	}

	else

	{

		$status_cond="";

	}

	

	
	
	

	
	







	## Read value



	$draw = $app->getPostVar('draw');



	$row = $app->getPostVar('start');



	$rowperpage = $app->getPostVar('length'); // Rows display per page



	$orderArray = $app->getPostVar('order');



	$columnIndex = $orderArray[0]['column']; // Column index



	



	$columnArray = $app->getPostVar('columns');



	$columnName = $columnArray[$columnIndex]['data']; // Column name



	



	if($columnName=='checkbox' || $columnName=='btn' || $columnName=='image')



	{



		$columnName='id';



	}



	



	$columnSortOrder = $orderArray[0]['dir']; // asc or desc



	



	$searchArray=$app->getPostVar('search');



	$searchValue = $searchArray['value']; // Search value



	



	## Search 



	$searchQuery = " ";



	if($searchValue != '')



	{



		$searchQuery = " and (	



		".$table_name.".id like '%".$searchValue."%' or 



		help.name like '%".$searchValue."%' or



		help.email like '%".$searchValue."%' or



		help.phone like '%".$searchValue."%' or

		

		help.message like '%".$searchValue."%' or
		


		help.status like '%".$searchValue."%'



		) 



		";



	}



	



	## Total number of records without filtering



	$obj_table = $app->load_model($table_name);

	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."  where id!=0");

	$totalRecords = $result[0]['allcount'];



	



	



	## Total number of records with filtering



	$obj_table = $app->load_model($table_name);
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."  where id!=0 ".$status_cond." ".$category_cond." ".$brand_cond." ".$searchQuery);	







	$totalRecordwithFilter = $result[0]['allcount'];



	



	## Fetch records



	$obj_brand = $app->load_model($table_name);
	$result = $obj_brand->execute("SELECT", false, "", "".$table_name.".id!=0 ".$status_cond." ".$brand_cond." ".$category_cond." ".$searchQuery.""," ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage." ");



	



	



	$folder='help_image';



	



	$data = array();



	for($i=0;$i<count($result);$i++)



	{



		



			//Mobile



			$status=$result[$i]["status"];
			
			$Pending='';
			$Solved='';
			$Canceled='';
			
			
			if($status=='Pending')
			{
				$Pending='selected="selected"';
				
			}
			else if($status=='Solved')
			{
				$Solved='selected="selected"';
				
			}
			else if($status=='Canceled')
			{
				$Canceled='selected="selected"';
			}
			else
			{
				
				$Pending='selected="selected"';
				
			}
			





			$status_soldout="<select onchange=\"change_help_status(this.id, this.value)\" id='".$result[$i]['id']."'\" class=\"form-control\">

			<option value=\"Pending\" ".$Pending.">Pending</option>
			<option value=\"Solved\" ".$Solved.">Solved</option>

			<option value=\"Canceled\" ".$Canceled.">Canceled</option>

			</select>";

			

			
			
		



		//data



		$data[] = array



		(



			"checkbox"=>$checkbox,



			"id"=>$result[$i]['id'].'<br/><b>'.$result[$i]['entry_from'].'</b>',


			"name"=>$result[$i]['name'].'<br/>'.$result[$i]['phone']."<br/>".$result[$i]['email'],



			"subject"=>$result[$i]['subject'],




			

			"message"=>$result[$i]['message'],

			

			"date"=>$result[$i]['date'],

			

			
			



			"status"=>$status_soldout,	



			"btn"=>$option



		);



	}



	



	## Response



	$response = array(



		"draw" => $draw,



		"iTotalRecords" => $totalRecords,



		"iTotalDisplayRecords" => $totalRecordwithFilter,



		"aaData" => $data



	);



		



	echo json_encode($response);



	exit;



}















//Function for single Admin Logins delete







//Function for single Admin Logins delete



if($actionType=="help_status_update")



{



	$getid=$app->getPostVar('getid');



	$value=$app->getPostVar('value');



	



	if($getid!= NULL && $getid>0 && $value!='')



	{



		$obj_change_table = $app->load_model('help');

		$update_id = $obj_change_table->execute("UPDATE",false,"UPDATE help SET status='".$value."' WHERE id='".$getid."'");



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



		$msg='Please Try Again .';



		$msgcode=1;	



	}



}







		



echo $obj_json->encode(array("RESULT"=>$msgcode,"url"=>"","msg"=>$msg));



?>