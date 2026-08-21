<?php

$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);
	
$id=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("id"));
$page=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("page"));




if($id>0)
{
	
	
			
			
				$lastCityID=$_SESSION['cityID'];
	
	
	
		
				$obj_model_tble=$app->load_model("city");
				$rs_city = $obj_model_tble->execute("SELECT",false,"","id='".$id."' and status='Active'","");
								

				if(count($rs_city)>0)
				{
					
						// Login 
						
						
				
						$api_state_id=$rs_city[0]['api_state_id'];						
						$api_city_id=$rs_city[0]['api_city_id'];	
						$state_id=$rs_city[0]['state_id'];
						$cityName=$rs_city[0]['name'];
						$cityImage=$rs_city[0]['image'];
						$cityCertificateImage=$rs_city[0]['certi_image'];
						$cityID=$rs_city[0]['id'];
						$citySlug=$rs_city[0]['slug'];
						
						
						$_SESSION['cityID']=$cityID;
						$_SESSION['cityName']=$cityName;
						$_SESSION['cityCertificateImage']=$cityCertificateImage;
						$_SESSION['cityImage']=$cityImage;
						$_SESSION['cityApiStateId']=$api_state_id;
						$_SESSION['cityApiCityId']=$api_city_id;
						$_SESSION['cityStateID']=$state_id;
						$_SESSION['citySlug']=$citySlug;
						$_SESSION['cityPhone']=$rs_city[0]['phone'];
						
						
						
						if($lastCityID!=$_SESSION['cityID'])
						{
							//City Change Clear Cart
							
							if($_SESSION['MDRCCustID']>0)
							{
								$customerCond="customer_cart.customer_id='".$_SESSION['MDRCCustID']."'";								

							}
							else
							{
								$customerCond="customer_cart.session_id='".session_id()."'";						

							}
														
							
							$obj_model_tmp_cart_delete = $app->load_model("customer_cart");
							$obj_model_tmp_cart_delete->execute("DELETE",false,"","".$customerCond."");
							
								
						}
							
						
						
						
						
						$RESULT='OK';
						$MSG='Success';

						if($page=='premium-health-checkup') {
							$URL=SERVER_ROOT.'/'.$page.'/'.$_SESSION['citySlug'];
						} else {
							$URL=SERVER_ROOT.'/labs';
						}
						
						//$URL='';
						echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG,"URL"=>$URL));	
						exit;
						
						
						
						
						
				}
				else
				{
					$RESULT='NOT OK';
					$MSG='Please Try Again.';
					
				}
		
		
		
		
		
	

}


else
{
	$RESULT='NOT OK';
	$MSG='Please Try Again.';
	
}
	
	
				
echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG));	
?>