<?
class _event_addedit extends controller
{

	function init()
	{
	}

	function onload()
	{
		
		
		
		
		
		
		$id=$this->app->getGetVar('id');
		
		
		if($id=='')
		{
		
		
			$folder=date('mY');
		
		
			if (!file_exists(ABS_PATH.'/uploads/event/'.$folder.'')) {
				mkdir(ABS_PATH.'/uploads/event/'.$folder.'', 0777, true);
			}
			
			
			$obj_model_event = $this->app->load_model("event");
			$rscat = $obj_model_event->execute("SELECT",false,"SELECT count(id) AS Total_Data FROM  event","");
			
			$this->app->assign("folder",$folder);
			$this->app->assign("sort_order",$rscat[0]['Total_Data']+1);
			
		
		
		}
		
		
		
		
		
		
		
		
		$obj_model_brand = $this->app->load_model("event_category");
		$rs = $obj_model_brand->execute("SELECT", false,"","status='Active'");
		$records1 = array();
		$records1[''] = " Select";
		for($i=0;$i<count($rs);$i++)
		{
			$records1[$rs[$i]['id']] = $rs[$i]['name'];
		}
		$this->assign("records1",$records1);
		
		
		
		
		
		
		

		if($id!="")
		{
			$this->assign("to_do", "Edit");
			$this->assign("event_action_name", "Edit");
			$this->load_data();
		}
		else
		{
			$this->assign("to_do", "Add");
			$this->assign("event_action_name", "Add");
		}
		$this->assign("manage_for", "Event");
	}
	
	function load_data()
	{
		$id=$this->app->getGetVar('id');
		$obj_model_event = $this->app->load_model("event", $id);
		$rscat = $obj_model_event->execute("SELECT");
		
		if(count($rscat)>0)
		{
			
			
			$this->app->assign("rsevent", $rscat[0]);
			
			$this->app->assign("folder",$rscat[0]['folder']);
			$this->app->assign("sort_order",$rscat[0]['sort_order']);
			
			
			
			
		

			$this->app->assign_form_data("frm_event_addedit", $rscat[0]);
			$this->app->assign("rscat", $rscat[0]);
		}
		else
		{
			$this->app->redirect("index.php?view=event_list");
		}
	}

	
	function update_data()
	{
		
		
		
			
		$save_btn=$this->app->getPostVar('save_btn');		
	
	
				
				
		
		
		$id=$this->app->getGetVar('id');
		
		
		$folder=$this->app->getPostVar('folder');
		
		
		$name=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('name1'));
		
		$tags=$this->app->getPostVar('tags');
		$tag_ids=$this->app->utility->getTagsIds($tags);
		
		
		
		
		
		if($id!="")
		{
			$slug=$this->app->utility->unique_slug('event','edit','slug',$name,$id);
			$obj_model_event = $this->app->load_model("event", $id);
			$result = $obj_model_event->execute("SELECT");
			$update_field = array();
			if($result[0]["image"]!=NULL && $_FILES['image']['error'] == 0)
			{			
				
				
					if(file_exists('../'.$this->app->get_user_config("event").'/'.$folder.'/'.$result[0]["image"]))
					{
						if($result[0]["image"]!=NULL)
						{
							@unlink('../'.$this->app->get_user_config("event").'/'.$folder.'/'.$result[0]["image"]);
						}
					}				
				
				//function call for image resizing
								
			}
			//For page Slug
			
			if(!empty($_FILES['image']['name']))
			{
			
				$event_image=$this->app->utility->resize_single_image($_FILES['image']['name'],$_FILES['image']['tmp_name'],$this->app->get_user_config("event").'/'.$folder.'/','1000');
				$update_field["image"] = $event_image;
			
			}
			
			
			$update_field['slug'] = $slug;
			
			
			
			$update_field['name'] = $name;
			$update_field['tag_ids'] = $tag_ids;
			
			
			$this->app->utility->remove_uploaded_file();
			$obj_model_event->map_fields($update_field);
			if($obj_model_event->execute("UPDATE")>0)
			{	
			
			
				
				
				
						
						
			
			
			
					$this->app->utility->set_message("Records updated successfully", "SUCCESS");
					
					
					if($save_btn=='Save_Stay')
					{
						$this->app->redirect("index.php?view=event_addedit&id=".$event_id."");
						
					}
					else
					{
						$this->app->redirect("index.php?view=event_list");
						
					}
			}
			else
			{
				$this->app->utility->set_message("Ooops... There was a problem in update event records", "ERROR");
				$this->app->redirect("index.php?view=event_list");
			}
		}
		else
		{
			//INSERT RECORDS
			$slug=$this->app->utility->unique_slug('event','add','slug',$name);
			//$brand_name=$this->app->utility->get_brandName($this->app->getPostVar('brand_id'));
			$update_field = array();
			if(!empty($_FILES['image']['name']))
			{
				$event_image=$this->app->utility->resize_single_image($_FILES['image']['name'],$_FILES['image']['tmp_name'],$this->app->get_user_config("event").'/'.$folder.'/','1000');
				$update_field["image"] = $event_image;
			}
			
			
			
			$update_field['name'] = $name;
			$update_field['tag_ids'] = $tag_ids;
			
			
			$update_field['status'] = 'Active';
			$update_field['slug'] = $slug;
			$update_field['entry_date_time'] = date('d-m-Y H:i:s');
			$obj_model_event = $this->app->load_model("event");
			$obj_model_event->map_fields($update_field);
			$ins=$obj_model_event->execute("INSERT");
			if($ins>0)
			{
				
				
				
						
						
					
				$this->app->utility->set_message("Records added successfull", "SUCCESS");
					if($save_btn=='Save_Stay')
					{
						$this->app->redirect("index.php?view=event_addedit&id=".$event_id."");
						
					}
					else
					{
						$this->app->redirect("index.php?view=event_list");
						
					}
			}
			else
			{
				$this->app->utility->set_message("Try Again.", "ERROR");
				$this->app->redirect("index.php?view=event_list");
			}
		}
	}
}
?>