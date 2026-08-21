<?
	class _general_settings extends controller{
		
		function init(){
			//$this->app->enable_cache("home.html");
		}
		
		function onload(){
			
			
			$this->assign("manage_for", "General Settings");
			$this->assign("to_do", "");
			
			$obj_model_generel_settings = $this->app->load_model("generel_settings");
			$rs = $obj_model_generel_settings->execute("SELECT", true);
			
			$this->app->assign("rs_data",$rs[0]);
			$this->app->assign_form_data("frm_generel_settings",$rs[0]);
			
			$p_type='';
			$this->app->assign("p_type",$p_type);
			
			$data = $this->app->compile();
			$this->load_parser($data);
			$this->parser->assign("MESSAGE", $this->app->utility->get_message());
			$this->parser->parse('main');			
			$this->update_ouput($this->parser->text('main'));
			$this->unload_parser();
			
		}
		
		
		function update_data(){
			
			
			$amount=$this->app->getPostVar("amount");
			
			$order_value=$this->app->getPostVar("order_value");
			$min_price=$this->app->getPostVar("min_price");
			$express_charge=$this->app->getPostVar("express_charge");
			$express_note=$this->app->getPostVar("express_note");
			$bag_charge=$this->app->getPostVar("bag_charge");
			$bag_charge_type=$this->app->getPostVar("bag_charge_type");
			$bag_charge_note=$this->app->getPostVar("bag_charge_note");
			$discount=$this->app->getPostVar("discount");
			$discount1=$this->app->getPostVar("discount1");

			
			
			$update_field = array();
			if(!empty($_FILES['logo1']['name']))
			{				
				$logo1=$this->app->utility->resize_image($_FILES['logo1']['name'],$_FILES['logo1']['tmp_name'],$this->app->get_user_config("project_image"),'800','251','148');	
				$update_field["logo"] = $logo1;
			}
			
			if(!empty($_FILES['app_static_image1']['name']))
			{				
				$app_static_image1=$this->app->utility->resize_image($_FILES['app_static_image1']['name'],$_FILES['app_static_image1']['tmp_name'],$this->app->get_user_config("project_image"),'800','251','148');	
				$update_field["app_static_image"] = $app_static_image1;
			}
			
			if(!empty($_FILES['refer_image1']['name']))
			{				
				$refer_image1=$this->app->utility->resize_image($_FILES['refer_image1']['name'],$_FILES['refer_image1']['tmp_name'],$this->app->get_user_config("project_image"),'800','251','148');	
				$update_field["refer_image"] = $refer_image1;
			}
			
			
			if(!empty($_FILES['refer_image_share']['name']))
			{				
				$refer_image_share1=$this->app->utility->resize_image($_FILES['refer_image_share']['name'],$_FILES['refer_image_share']['tmp_name'],$this->app->get_user_config("project_image"),'800','251','148');	
				$update_field["refer_image_share"] = $refer_image_share1;
			}

			if(!empty($_FILES['form_home_image']['name']))
			{
				$fileExt = strtolower(pathinfo($_FILES['form_home_image']['name'], PATHINFO_EXTENSION));
				$newFileName = uniqid('img_', true) . '.' . $fileExt;
				$destination = '../uploads/home/' . $newFileName;

				move_uploaded_file($_FILES['form_home_image']['tmp_name'], $destination);
				$update_field["home_image"] = $newFileName;
			}
			if(!empty($_FILES['form_home_image_2']['name']))
			{
				$fileExt = strtolower(pathinfo($_FILES['form_home_image_2']['name'], PATHINFO_EXTENSION));
				$newFileName = uniqid('img_', true) . '.' . $fileExt;
				$destination = '../uploads/home/' . $newFileName;

				move_uploaded_file($_FILES['form_home_image_2']['tmp_name'], $destination);
				$update_field["home_image_2"] = $newFileName;
			}

			$obj_model_generel_settings = $this->app->load_model("generel_settings");
			$obj_model_generel_settings->map_fields($update_field);
			$update_id = $obj_model_generel_settings->execute("UPDATE", false, "", "id=1");
			if($update_id!=NULL){
				$this->app->utility->set_message("Records updated successfull...", "SUCCESS");
				$this->app->redirect("index.php?view=general_settings");
			}else{
				$this->app->utility->set_message("Record not updated...", "ERROR");
				$this->app->redirect("index.php?view=general_settings");
			}
		}	
		
	}	
?>