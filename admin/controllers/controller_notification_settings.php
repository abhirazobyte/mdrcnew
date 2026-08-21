<?
	class _notification_settings extends controller{
		
		function init(){
			//$this->app->enable_cache("home.html");
		}
		
		function onload(){
			
			
			$this->assign("manage_for", "Cart Notification Settings");
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
			
			$title=$this->app->getPostVar("cart_notification_title");
			$desc=$this->app->getPostVar("cart_notification_desc");
			$notification=$this->app->getPostVar("cart_notification");

			$update_field = array();
			$update_field['cart_notification_title'] = $title;
			$update_field['cart_notification_desc'] = $desc;
			$update_field['cart_notification'] = $notification;

			$obj_model_notification_settings = $this->app->load_model("generel_settings");
			$obj_model_notification_settings->map_fields($update_field);
			$update_id = $obj_model_notification_settings->execute("UPDATE", false, "", "id=1");
			if($update_id!=NULL){
				$this->app->utility->set_message("Records updated successfull...", "SUCCESS");
				$this->app->redirect("index.php?view=notification_settings");
			}else{
				$this->app->utility->set_message("Record not updated...", "ERROR");
				$this->app->redirect("index.php?view=notification_settings");
			}
		}	
		
	}	
?>