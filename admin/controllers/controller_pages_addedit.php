<?
	class _pages_addedit extends controller{
		
		function init(){
			//$this->app->enable_cache("home.html");
		}
		
		function onload(){
			
			$this->assign("manage_for", "List");
			$this->assign("to_do", "Pages");	
			

			
			$uid=$this->app->getGetVar('id');
			$this->assign("id",$uid);	
			
			if($uid!="")
			{
			$obj_model_pagess = $this->app->load_model("pages");
			$rs_pagess = $obj_model_pagess->execute("SELECT", false, "","id='".$uid."'");
			$this->assign("rs_pages",$rs_pagess[0]);
			if(count($rs_pagess)>0)
			{
				$this->app->assign_form_data("frm_pages_addedit", $rs_pagess[0]);
			}
			}
			
			$data = $this->app->compile();
			$this->load_parser($data);
			$this->parser->assign("MESSAGE", $this->app->utility->get_message());
			$this->parser->parse('main');			
			$this->update_ouput($this->parser->text('main'));
			$this->unload_parser();
		}
		
		function update_data(){			
			if($this->app->getPostVar('id')!=""){
				$obj_model_pages = $this->app->load_model("pages", $this->app->getPostVar('id'));
				$update_field = array();
				
				
				$update_field["added_on"] = date('d-m-y');
				
				//$update_field['slug']=$this->app->utility->seo_url($this->app->getPostVar('page_title'));
				
				$obj_model_pages->map_fields($update_field);
				
				if($obj_model_pages->execute("UPDATE")>0){
					$this->app->utility->set_message("pages records updated successfull", "SUCCESS");
					$this->app->redirect("index.php?view=pages");
				}else{
					$this->app->utility->set_message("Ooops... There was a problem in update user records", "ERROR");
						$this->app->redirect("index.php?view=pages_addedit");
				}
			
				
			}
			else
			{
			//INSERT RECORDS
			$update_field = array();
				
				$obj_model_pages = $this->app->load_model("pages");
				
				$update_field["added_on"] = date('d-m-y');
				$update_field["page_description"] = $this->app->getPostVar('page_description');
				$obj_model_pages= $this->app->load_model("pages");
			
				$update_field['slug']=$this->app->utility->seo_url($this->app->getPostVar('page_title'));
				
				$obj_model_pages->map_fields($update_field);
				if($obj_model_pages->execute("INSERT")>0){
					$this->app->utility->set_message("Page added successfully", "SUCCESS");
					$this->app->redirect("index.php?view=pages");
				}else{
					$this->app->utility->set_message("Ooops... There was a problem in inserting record.", "ERROR");
					$this->app->redirect("index.php?view=pages_addedit");
				}
			}
		}
			
		
	
	}	
?>