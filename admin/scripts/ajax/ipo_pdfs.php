<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);
//get action
$get_actionType = $app->getGetVar("actionType");
$actionType = $app->getPostVar("actionType");

//Function for active ipo_pdfs datatbale loading
if ($get_actionType == "ipo_pdfs_list") {
	$table_name = 'ipo_pdfs';

	## Read value
	$draw = $app->getPostVar('draw');
	$row = $app->getPostVar('start');
	$rowperpage = $app->getPostVar('length'); // Rows display per page
	$orderArray = $app->getPostVar('order');
	$columnIndex = $orderArray[0]['column']; // Column index

	$columnArray = $app->getPostVar('columns');
	$columnName = $columnArray[$columnIndex]['data']; // Column name

	if ($columnName == 'checkbox' || $columnName == 'btn' || $columnName == 'image') {
		$columnName = 'id';
	}

	$columnSortOrder = $orderArray[0]['dir']; // asc or desc

	$searchArray = $app->getPostVar('search');
	$searchValue = $searchArray['value']; // Search value

	## Search 
	$searchQuery = " ";
	if ($searchValue != '') {
		$searchQuery = " and (	
		" . $table_name . ".id like '%" . $searchValue . "%' or
		" . $table_name . ".title like '%" . $searchValue . "%' or
		" . $table_name . ".sort_order like '%" . $searchValue . "%' or
		" . $table_name . ".status like '%" . $searchValue . "%'
		) 
		";
	}

	## Total number of records without filtering
	$obj_table = $app->load_model($table_name);
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount," . $table_name . ".* from " . $table_name . "  where " . $table_name . ".status!='Trash'");
	$totalRecords = $result[0]['allcount'];


	## Total number of records with filtering
	$obj_table = $app->load_model($table_name);
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount," . $table_name . ".* from " . $table_name . "  where " . $table_name . ".status!='Trash' " . $searchQuery);
	$totalRecordwithFilter = $result[0]['allcount'];

	## Fetch records
	$obj_brand = $app->load_model($table_name);
	$result = $obj_brand->execute("SELECT", false, "", "" . $table_name . ".status!='Trash'  " . $searchQuery . "", " " . $columnName . " " . $columnSortOrder . " limit " . $row . "," . $rowperpage . " ");

	$folder = 'main_ipo_pdfs_images';

	$data = array();
	for ($i = 0; $i < count($result); $i++) {


		//Mobile
		$image = $result[$i]["ipo_pdfs_image"];
		$ipo_pdfs_img = $app->utility->get_image_path($image, $folder, "");



		$status = '<img src="assets/img/status/' . $result[$i]['status'] . '.png" onclick="javascript:change_status(\'' . $result[$i]['id'] . '\', \'ipo_pdfs\', \'' . $result[$i]['status'] . '\')" border="0" id="status_' . $result[$i]['id'] . '" style="cursor:pointer" alt="' . $result[$i]['status'] . '" data-toggle="tooltip" data-placement="right" title="Tooltip on right" title="' . $result[$i]['status'] . '" />';

		$edit_btn = '<button type="button" class="btn btn-xs btn-primary btn-icon ipo_pdfs_addedit_onclick" data-id="' . $result[$i]['id'] . '"><i class="fas fa-edit"></i></button>';

		$delete_btn = '<button type="button" class="btn btn-xs btn-danger btn-icon ipo_pdfs_delete_onclick" data-id="' . $result[$i]['id'] . '" ><i class="fas fa-trash"></i></button>';

		$option = '<div class="btn-toolbar"><div>' . $edit_btn . ' ' . $delete_btn . '</div></div>';

		$checkbox = '<div class="custom-control custom-checkbox"><input type="checkbox" name="del[]" id="del' . $result[$i]['id'] . '"  value="' . $result[$i]['id'] . '" class="custom-control-input delAll" ><label class="custom-control-label" for="del' . $result[$i]['id'] . '"></label></div>';
		if($result[$i]['file_name'] != ''){
			$pdf_file = '<a href="../../uploads/ipo_pdfs/'.$result[$i]['file_name'].'" target="_blank">'.$result[$i]['file_name'].'</a>';
		} else {
			$pdf_file = '';
		}
		if($result[$i]['page_type'] == 'IPO'){
			$page_type = 'IPO / Offer Documents';
		} else {
			$page_type = 'Policies';
		}

		//data
		$data[] = array(
			"checkbox" => $checkbox,
			"id" => $result[$i]['id'],
			"title" => $result[$i]['title'],
			"image" => $pdf_file,
			"page_type" => $page_type,
			"qr_code" => $result[$i]['qr_code'],
			"sort_order" => $result[$i]['sort_order'],
			"status" => $status.'<br/>'.date('d-m-Y h:i A',strtotime($result[$i]['created_at'])),
			"btn" => $option
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


//Function for ipo_pdfs addedit
if($actionType == "ipo_pdfsAddEdit")
{
	$status = $app->getPostVar('status');
	$id = $app->getPostVar('id');

	if ($id == '' && $_FILES['file_2']['name'] == ''){
		$msg = 'Please Select File First.';
		$msgcode = 1;
		echo $obj_json->encode(array("RESULT" => $msgcode, "url" => "", "msg" => $msg)); exit;
	}

	if ($status != '') {
		$update_field = array();
		if(!empty($_FILES['file_2']['name']))
		{
			$ipo_pdfs_img11 = $app->utility->upload_file_2025(['name' => $_FILES['file_2']['name'],'tmp_name' => $_FILES['file_2']['tmp_name']]);
			$update_field['file_name'] = $ipo_pdfs_img11;
		}

		$obj_model_user = $app->load_model("ipo_pdfs");
		$obj_model_user->map_fields($update_field);

		if ($id != '') {
			$rs = $obj_model_user->execute("UPDATE", false, "", "id='" . $id . "'");
		} else {
			$rs = $obj_model_user->execute("INSERT", false, "", "");
		}
		if ($rs > 0) {
			$msg = "Record " . $update_title . " Successfully.";
			$msgcode = 0;
		} else {
			$msg = 'Please Try Again.';
			$msgcode = 1;
		}
	} else {
		$msg = 'Please Fill Require Data';
		$msgcode = 1;
	}
}



# --------------- START : FUNCTION FOR SINGLE DELETE ---------------
if($actionType == "ipo_pdfsDelete")
{
	$getid = $app->getPostVar('getid');

	if($getid != NULL && $getid > 0)
	{

		$update_field = array();
		$update_field['status'] = 'Trash';
				
		$obj_change_table = $app->load_model('ipo_pdfs');
		$obj_change_table->map_fields($update_field);
		$update_id = $obj_change_table->execute("UPDATE", false, "", "id='" . $getid . "'");

		if($update_id > 0)
		{
			$msg = 'Sucess';
			$msgcode = 0;
		}
		else
		{
			$msg = 'Please Try Again.';
			$msgcode = 1;
		}
	}
	else
	{
		$msg = 'Please Try Again.';
		$msgcode = 1;
	}
}
# --------------- END : FUNCTION FOR SINGLE DELETE ---------------




//Function for multiple ipo_pdfs delete

if ($actionType == "ipo_pdfsMultiDelete") {

	$ids = $app->getPostVar('ids');

	$temp_ids = explode(',', $ids);

	if ($ids != NULL && $ids != '') {

		for ($i = 0; $i < count($temp_ids); $i++) {


			$update_field = array();
			$update_field['status'] = 'Trash';
					
			$obj_change_table = $app->load_model('ipo_pdfs');
			$obj_change_table->map_fields($update_field);
			$update_id = $obj_change_table->execute("UPDATE", false, "", "id='" . $temp_ids[$i] . "'");
		}



		if ($update_id > 0) {

			$msg = 'Sucess';

			$msgcode = 0;
		} else {

			$msg = 'Please Try Again.';

			$msgcode = 1;
		}
	} else {

		$msg = 'Please Try Again.';

		$msgcode = 1;
	}
}









echo $obj_json->encode(array("RESULT" => $msgcode, "url" => "", "msg" => $msg));
