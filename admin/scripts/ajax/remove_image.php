<?php 	
	$id = $app->getPostVar('id');
	$table = $app->getPostVar('table');
	$col = $app->getPostVar('col');
	$folder = $app->getPostVar('folder');

	if($id!= NULL)
	{
		$obj_model_record = $app->load_model($table);
		$result=$obj_model_record->execute("SELECT",false,"","id='".$id."'");
		if($result[0][$col]!=NULL)
		{
			@unlink('../../../uploads/'.$folder.'/'.$result[0][$col]);
			@unlink('../../../uploads/'.$folder.'/'.'mediumthumb'.$result[0][$col]);
			@unlink('../../../uploads/'.$folder.'/'.'thumb'.$result[0][$col]);									
		}	
	
		$fields_map = array();
		$fields_map[$col] ="";
		$obj_rmove_image = $app->load_model($table, $id);
		$obj_rmove_image->map_fields($fields_map);
		$update_id = $obj_rmove_image->execute("UPDATE");
		if($update_id>0)
		{
			echo "0";
		}
		else
		{
			echo "1";
		}
	}
	else
	{
		echo "1"; 
	}		
?>
