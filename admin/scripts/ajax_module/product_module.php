<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);


$action=$app->getPostVar('action');

if($action=='product_option_delete')
{
	
		$id=$app->getPostVar('getid');	
		$tablename=$app->getPostVar('tablename');
				
		if($id!='' && $tablename!='')
		{
			
						$obj_model_tbl = $app->load_model($tablename);
						$rs=$obj_model_tbl->execute("DELETE",false,"","id='".$id."'");
			
					
						$message="Record Deleted Successfully.";
						$res=0;													
						
					 
						
				
		}
		else
		{
						
					$message='Try Again.';
					$res=1;
					
								
		}
			


	
echo $obj_json->encode(array("RESULT"=>$res,"MESSAGE"=>$message));	
	


		
}





?>