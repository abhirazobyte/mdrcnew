<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);
//get action
$get_actionType = $app->getGetVar("actionType");
$actionType = $app->getPostVar("actionType");
//Function for Admin Logins datatbale loading
if ($get_actionType == "gallery_images_list") {
	$table_name = 'gallery';
	$cat_id = $app->getGetVar("cat_id");
	$status_cond = " AND gallery.gallery_category_id='" . $cat_id . "'";
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
		" . $table_name . ".status like '%" . $searchValue . "%'
		)
		";
	}
	## Total number of records without filtering
	$obj_table = $app->load_model($table_name);
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount," . $table_name . ".* from " . $table_name . "  where id!=0 " . $status_cond . "");
	$totalRecords = $result[0]['allcount'];
	## Total number of records with filtering
	$obj_table = $app->load_model($table_name);
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount," . $table_name . ".* from " . $table_name . "  where  " . $table_name . ".status!='Trash' " . $status_cond . "  " . $searchQuery);
	$totalRecordwithFilter = $result[0]['allcount'];
	## Fetch records
	$obj_brand = $app->load_model($table_name);
	$result = $obj_brand->execute("SELECT", false, "", "" . $table_name . ".id!=0 " . $status_cond . " " . $searchQuery . "", " " . $columnName . " " . $columnSortOrder . " limit " . $row . "," . $rowperpage . " ");
	$folder = 'gallery';
	$data = array();
	for ($i = 0; $i < count($result); $i++) {
		//Mobile
		$image = $result[$i]["image"];
		$banner_img = $app->utility->get_image_path($image, $folder . '/', "");
		$delete_btn = '<button type="button" class="btn btn-xs btn-danger btn-icon gallery_delete_onclick" data-id="' . $result[$i]['id'] . '" ><i class="fas fa-trash"></i></button>';
		$option = '<div class="btn-toolbar"><div>' . $delete_btn . '</div></div>';
		$checkbox = '<div class="custom-control custom-checkbox"><input type="checkbox" name="del[]" id="del' . $result[$i]['id'] . '"  value="' . $result[$i]['id'] . '" class="custom-control-input delAll" ><label class="custom-control-label" for="del' . $result[$i]['id'] . '"></label></div>';
		$status = '<img src="assets/img/status/' . $result[$i]['status'] . '.png" onclick="javascript:change_status(\'' . $result[$i]['id'] . '\', \'gallery\', \'' . $result[$i]['status'] . '\')" border="0" id="status_' . $result[$i]['id'] . '" style="cursor:pointer" alt="' . $result[$i]['status'] . '" data-toggle="tooltip" data-placement="right" title="Tooltip on right" title="' . $result[$i]['status'] . '" />';
		$set_at_home = '<img src="assets/img/status/' . $result[$i]['set_at_home'] . '.png" onclick="javascript:change_set_as_home(\'' . $result[$i]['id'] . '\', \'gallery\', \'' . $result[$i]['set_at_home'] . '\')" border="0" id="set_as_home_' . $result[$i]['id'] . '" style="cursor:pointer" alt="' . $result[$i]['set_at_home'] . '" data-toggle="tooltip" data-placement="right" title="Tooltip on right" title="' . $result[$i]['set_at_home'] . '" />';
		//data
		$data[] = array(
			"checkbox" => $checkbox,
			"id" => $result[$i]['id'],
			"image" => '<a href="' . $banner_img['large_image'] . '" class="image-popup table-gallery-image-list"><img src="' . $banner_img['large_image'] . '" class="up_img"></a>',
			"set_at_home" => $set_at_home,
			"status" => $status,
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
//Function for single Admin Logins delete
if ($actionType == "galleryDelete") {
	$getid = $app->getPostVar('getid');
	if ($getid != NULL && $getid > 0) {
		$obj_model_record = $app->load_model("gallery");
		$result = $obj_model_record->execute("SELECT", false, "", "id='" . $getid . "'");
		if ($result[0]["image"] != NULL) {
			$upload_dir = 'gallery';
			@unlink('../../../uploads/' . $upload_dir . '/' . $result[0]["image"]);
			@unlink('../../../uploads/' . $upload_dir . '/' . 'mediumthumb' . $result[0]["image"]);
			@unlink('../../../uploads/' . $upload_dir . '/' . 'thumb' . $result[0]["image"]);
		}
		$obj_change_table = $app->load_model('gallery');
		$update_id = $obj_change_table->execute("DELETE", false, "", "id='" . $getid . "'");
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
//Function for multiple Admin Logins delete
if ($actionType == "galleryMultiDelete") {
	$ids = $app->getPostVar('ids');
	if ($ids != NULL && $ids != '') {
		$getids = explode(",", $ids);
		for ($i = 0; $i < count($getids); $i++) {
			$obj_model_record = $app->load_model("gallery");
			$result = $obj_model_record->execute("SELECT", false, "", "id='" . $getids[$i] . "'");
			if ($result[0]["image"] != NULL) {
				$upload_dir = 'gallery';
				@unlink('../../../uploads/' . $upload_dir . '/' . $result[0]["image"]);
				@unlink('../../../uploads/' . $upload_dir . '/' . 'mediumthumb' . $result[0]["image"]);
				@unlink('../../../uploads/' . $upload_dir . '/' . 'thumb' . $result[0]["image"]);
			}
			$obj_change_table = $app->load_model('gallery');
			$update_id = $obj_change_table->execute("DELETE", false, "", "id='" . $getids[$i] . "'");
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
