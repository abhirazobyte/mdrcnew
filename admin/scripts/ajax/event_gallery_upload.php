<?php
ini_set("display_errors",0);
ini_set("max_file_uploads",100);
$jsonclass = $app->load_module("Services_JSON");
$obj_JSON = new $jsonclass(SERVICES_JSON_LOOSE_TYPE);
$event_id=$app->getPostVar("event_id");
$folder=$app->getPostVar("folder");
$upload_dir='event/'.$folder.'/';
			$fileCount = count($_FILES["file"]['name']);
    		for($i=0; $i < $fileCount; $i++)
    		{
			    $product_image=$app->utility->resize_single_image($_FILES['file']['name'][$i],$_FILES['file']['tmp_name'][$i],'../../uploads/'.$upload_dir.'/','1000');
				$m=$i+1;
				$update_field = array();
				$update_field['event_id'] = $event_id;
				$update_field['folder'] = $folder;
				$update_field['image'] = $product_image;
				$update_field['status'] = 'Active';
				$obj_model_product_image = $app->load_model("event_gallery");
				$obj_model_product_image->map_fields($update_field);
				$ins_arr=$obj_model_product_image->execute("INSERT");
				$ins_arr[]=$ins;
    		}
	echo $obj_JSON->encode(array("RESULT"=>"OK","op"=>$op,"OPTION"=>array("id"=>$ins_arr,"product_images"=>$_FILES["file"]['name'])));
?>