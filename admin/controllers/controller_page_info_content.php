<?
	class _page_info_content extends controller {
		function init() {
		}
		
		function onload() {
			
			$page_id=$this->app->getGetVar("page_id");
			if($page_id=='' && $page_id!=20)
			{
				$this->app->redirect("index.php");
			}
			
			
			$obj_model_generel_settings = $this->app->load_model("page_info");
			$rs = $obj_model_generel_settings->execute("SELECT",false,'',"id=".$page_id);
			
			$this->app->assign("rs_data",$rs[0]);
			$this->app->assign_form_data("frm_generel_settings",$rs[0]);

			$this->assign("manage_for", $rs[0]['page_name']);
			$this->assign("to_do", "");

			//$this->assign("MESSAGE", $this->app->utility->get_message());

			
			// $data = $this->app->compile();
			// $this->load_parser($data);
			// $this->parser->assign("MESSAGE", $this->app->utility->get_message());
			// $this->parser->parse('main');			
			// $this->update_ouput($this->parser->text('main'));
			// $this->unload_parser();

			
		}
		
		
		function update_data() {
			$page_id=$this->app->getPostVar("page_id");
			if($page_id=='')
			{
				$this->app->redirect("index.php");
			}
			$update_field = array();
			$obj_model_generel_settings = $this->app->load_model("page_info");
			$obj_model_generel_settings->map_fields($update_field);
			$update_id = $obj_model_generel_settings->execute("UPDATE", false, "", "id=".$page_id);		
			if($update_id!=NULL){
				$this->app->utility->set_message("Records updated successfull...", "SUCCESS");
				$this->app->redirect("index.php?view=page_info_content&page_id=".$page_id);
			}else{
				$this->app->utility->set_message("Record not updated...", "ERROR");
				$this->app->redirect("index.php?view=page_info_content&page_id=".$page_id);
			}
		}	
		
	}	
?>