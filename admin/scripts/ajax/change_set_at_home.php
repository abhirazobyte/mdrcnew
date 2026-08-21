<?php 	
	$id = $app->getPostVar('id');
	
	$table_name = $app->getPostVar('table_name');
	$status = ($app->getPostVar('current_status')=="Active")?"Inactive":"Active";	
	$fields_map = array();	
	if($app->getPostVar('id') != NULL){
		$obj_change_status = $app->load_model($table_name, $id);
		$fields_map['set_at_home'] = $status;
		$obj_change_status->map_fields($fields_map);
		$update_id = $obj_change_status->execute("UPDATE");
		if($update_id>0){
			echo "OK";
		}else{
			echo "CANCEL";
		}
	}else{
		echo "Oops... Problem in change status. Please try again."; 
	}		
?>
