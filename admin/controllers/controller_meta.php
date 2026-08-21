<?

	class _meta extends controller{

		

		function init(){

			//$this->app->enable_cache("home.html");

		}

		

		function onload(){

			$this->assign("manage_for", "Meta Setting");

			$this->assign("to_do", "");

			$obj_model_admin = $this->app->load_model("meta",1);

			$rs = $obj_model_admin->execute("SELECT");
			
			
			$this->app->assign_form_data("frm_profile",$rs[0]);

			$this->app->assign("rscat",$rs[0]);

			

			$data = $this->app->compile();

			$this->load_parser($data);

			$this->parser->assign("MESSAGE", $this->app->utility->get_message());

			$this->parser->parse('main');			

			$this->update_ouput($this->parser->text('main'));

			$this->unload_parser();

			

		}

		

		function update_data(){
			
			
			
			
				$name=$this->app->getPostVar("name");
			

				$update_field = array();
	

				$update_field["login_username"] = $name;

				
		
			

			$obj_model_admin = $this->app->load_model("meta");
			$obj_model_admin->map_fields($update_field);

			$update_id = $obj_model_admin->execute("UPDATE", false, "", "id=1");		

			if($update_id!=NULL){

				$this->app->utility->set_message("Meta record updated successfull...", "SUCCESS");

				$this->app->redirect("index.php?view=meta");

			}else{

				$this->app->utility->set_message("Record not updated...", "ERROR");

				$this->app->redirect("index.php?view=meta");

			}

		}	

		

	}	

?>