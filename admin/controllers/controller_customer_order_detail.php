<?php


	class _customer_order_detail extends controller{

		

		function init(){

				$this->assign("manage_for", "");
				$this->assign("to_do", "Order Detail");
				
				
				$orderID=$this->app->getGetVar('id');
				$this->app->assign("orderID", $orderID);
				
				
				
				
				if($orderID=='')
				{
					$this->app->redirect("index.php?view=customer_order_list");
					exit;
					
				}
				
				
				
				
				
				
				if($this->app->getCurrentAction()==""){
					$this->load_data();
				}

			}

		

			function onload()
			{
			
			}	
			
			function load_data()
			{
				
			}	
			
			
		
		
		
		function save_add()
	{
		$fname=$this->app->getPostVar("fname");
		$lname=$this->app->getPostVar("lname");
		$phone=$this->app->getPostVar("phone");
		$ext=$this->app->getPostVar("ext");
		$address1=$this->app->getPostVar("address1");
		$unit=$this->app->getPostVar("unit");
		$entry_code=$this->app->getPostVar("entry_code");
		
		$city=$this->app->getPostVar("city");
		$province=$this->app->getPostVar("province");
		$zipcode=$this->app->getPostVar("zipcode");
		$address_instruction=$this->app->getPostVar("address_instruction");
		
		$o_id=$this->app->getPostVar("o_id");
		$address_id=$this->app->getPostVar("address_id");
		
		
		
		
		
		
		
		if($o_id!='' && $address_id!='' && $fname!='' && $address1!='')
		{
			
			
				$obj_model_check= $this->app->load_model("order_master");
				$rs_check=$obj_model_check->execute("SELECT",false,"","id='".$o_id."'");
								
				$order_city_id=$rs_check[0]['city_id'];
				
				
				$obj_model_zip= $this->app->load_model("zipcode");
				$rs_zip=$obj_model_zip->execute("SELECT",false,"","zipcode='".$zipcode."'");
								
				$city_id=$rs_zip[0]['city_id'];
				
				
				if($order_city_id!=$city_id)
				{
					$this->app->utility->set_message("Zipcode(".$zipcode.") not changable. Please try with same city zipcode.", "ERROR");
					$this->app->redirect("index.php?view=order_detail&orderID=".$o_id."");
					exit;
					
				}
			
			
			
			
			
				$update_field=array();				
				$update_field['fname'] = $fname;
				$update_field['lname'] = $lname;
				$update_field['ext'] = $ext;
				$update_field['phone'] = $phone;
				$update_field['address'] = $address1;	
				$update_field['unit'] = $unit;
				$update_field['province'] = $province;
				$update_field['city'] = $city;
				$update_field['entry_code'] = $entry_code;
				$update_field['zipcode'] = $zipcode;
				$update_field['address_instruction'] = $address_instruction;
									
				$obj_model_up = $this->app->load_model("order_shipping_address");
				$obj_model_up->map_fields($update_field);
				$up_id=$obj_model_up->execute("UPDATE",false,"","order_master_id='".$o_id."' and id='".$address_id."'");
				
				
			
			
			$this->app->utility->set_message("Successfully Updated..", "SUCCESS");
			$this->app->redirect("index.php?view=order_detail&orderID=".$o_id."");	
			
		}
		else
		{
			
			
			
			$this->app->utility->set_message("Please Fill Require Data.", "ERROR");
			$this->app->redirect("index.php?view=order_detail&orderID=".$o_id."");	
			
			
			
		}	
	}

	
	

	}	

?>