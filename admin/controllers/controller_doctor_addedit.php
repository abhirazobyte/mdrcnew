<?
class _doctor_addedit extends controller
{

	function init()
	{
	}

	function onload()
	{
		
		
		
		
		
		
		$id=$this->app->getGetVar('id');
		
		
		
		
		
		
		
		
		$obj_model_brand = $this->app->load_model("doctor_category");
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
			$this->assign("doctor_action_name", "Edit");
			$this->load_data();
		}
		else
		{
			$this->assign("to_do", "Add");
			$this->assign("doctor_action_name", "Add");
		}
		$this->assign("manage_for", "doctor");
	}
	
	function load_data()
	{
		$id=$this->app->getGetVar('id');
		$obj_model_doctor = $this->app->load_model("doctor", $id);
		$rscat = $obj_model_doctor->execute("SELECT");
		
		if(count($rscat)>0)
		{
			
			
			$this->app->assign("rsdoctor", $rscat[0]);
			
			$this->app->assign("folder",$rscat[0]['folder']);
			
			
			
		

			$this->app->assign_form_data("frm_doctor_addedit", $rscat[0]);
			$this->app->assign("rscat", $rscat[0]);
		}
		else
		{
			$this->app->redirect("index.php?view=doctor_list");
		}
	}

	
	function update_data()
	{
		
		
		
			
		$save_btn=$this->app->getPostVar('save_btn');		
	
	
				
				
		
		
		$id=$this->app->getGetVar('id');
		
		
		$folder=$this->app->getPostVar('folder');
		
		
		$name=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('name1'));
		
		
		
		
		
		if($id!="")
		{
			$slug=$this->app->utility->unique_slug('doctor','edit','slug',$name,$id);
			$obj_model_doctor = $this->app->load_model("doctor", $id);
			$update_field = array();
			if(!empty($_FILES['image']['name']))
			{
				$result = $obj_model_doctor->execute("SELECT");
				if(count($result)>0)
				{
					if(file_exists('../'.$this->app->get_user_config("doctor").'/'.$folder.'/'.$result[0]["image"]))
					{
						if($result[0]["image"]!=NULL)
						{
							@unlink('../'.$this->app->get_user_config("doctor").'/'.$folder.'/'.$result[0]["image"]);
							//@unlink('../'.$this->app->get_user_config("doctor").'/'.$folder.'/'.'/mediumthumb'.$result[0]["image"]);
							//@unlink('../'.$this->app->get_user_config("doctor").'/'.$folder.'/'.'/thumb'.$result[0]["image"]);
						}
					}
				}
				//function call for image resizing
				$fileExt = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
				$item_image = uniqid('img_', true) . '.' . $fileExt;
				$destination = '../'.$this->app->get_user_config("doctor").'/'.$folder.'/' . $item_image;

				move_uploaded_file($_FILES['image']['tmp_name'], $destination);
				//$doctor_image=$this->app->utility->resize_image($_FILES['image']['name'],$_FILES['image']['tmp_name'],$this->app->get_user_config("doctor").'/'.$folder.'/','2000','480','250');
				$update_field["image"] = $item_image;
			}
			//For page Slug
			$update_field['slug'] = $slug;
			
			
			
			$update_field['name'] = $name;
			
			$this->app->utility->remove_uploaded_file();
			$obj_model_doctor->map_fields($update_field);
			if($obj_model_doctor->execute("UPDATE")>0)
			{	
			
			
				
				
				
						
						
			
			
			
					$this->app->utility->set_message("Records updated successfully", "SUCCESS");
					
					
					if($save_btn=='Save_Stay')
					{
						$this->app->redirect("index.php?view=doctor_addedit&id=".$doctor_id."");
						
					}
					else
					{
						$this->app->redirect("index.php?view=doctor_list");
						
					}
			}
			else
			{
				$this->app->utility->set_message("Ooops... There was a problem in update doctor records", "ERROR");
				$this->app->redirect("index.php?view=doctor_list");
			}
		}
		else
		{
			//INSERT RECORDS
			$slug=$this->app->utility->unique_slug('doctor','add','slug',$name);
			//$brand_name=$this->app->utility->get_brandName($this->app->getPostVar('brand_id'));
			$update_field = array();
			if(!empty($_FILES['image']['name']))
			{
				$doctor_image=$this->app->utility->resize_image($_FILES['image']['name'],$_FILES['image']['tmp_name'],$this->app->get_user_config("doctor").'/'.$folder.'/','2000','480','250');
				$update_field["image"] = $doctor_image;
			}
			
			
			
			$update_field['name'] = $name;
			
			
			$update_field['status'] = 'Active';
			$update_field['slug'] = $slug;
			$update_field['entry_date_time'] = date('d-m-Y H:i:s');
			$obj_model_doctor = $this->app->load_model("doctor");
			$obj_model_doctor->map_fields($update_field);
			$ins=$obj_model_doctor->execute("INSERT");
			if($ins>0)
			{
				
				
				
						
						
					
				$this->app->utility->set_message("Records added successfull", "SUCCESS");
					if($save_btn=='Save_Stay')
					{
						$this->app->redirect("index.php?view=doctor_addedit&id=".$doctor_id."");
						
					}
					else
					{
						$this->app->redirect("index.php?view=doctor_list");
						
					}
			}
			else
			{
				$this->app->utility->set_message("Try Again.", "ERROR");
				$this->app->redirect("index.php?view=doctor_list");
			}
		}
	}
}
?>