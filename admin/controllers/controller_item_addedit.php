<?
class _item_addedit extends controller
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
			if (!file_exists(ABS_PATH.'/uploads/item/'.$folder.'')) {
				mkdir(ABS_PATH.'/uploads/item/'.$folder.'', 0777, true);
			}
			$obj_model_blog = $this->app->load_model("blog");
			$rscat = $obj_model_blog->execute("SELECT",false,"SELECT count(id) AS Total_Data FROM  item","");
			$this->app->assign("folder",$folder);
			$this->app->assign("sort_order",$rscat[0]['Total_Data']+1);
		}

		//START : for getting lab list
		$obj_model_item_lab = $this->app->load_model("item_lab");
		$obj_model_item_lab->join_table("city", "left", array("name"), array("city_id"=>"id"));
		$rs_item_lab = $obj_model_item_lab->execute("SELECT", false,"","item_lab.status='Active'","item_lab.sort_order ASC");
		$this->assign("rs_item_lab",$rs_item_lab);
		$labsList = array();
		for($i=0;$i<count($rs_item_lab);$i++)
		{
			$labsList[$rs_item_lab[$i]['id']] = $rs_item_lab[$i]['name'];
		}
		$this->assign("labsList",$labsList);
		//END : for getting lab list

		$obj_model_brand = $this->app->load_model("item_type");
		$rs = $obj_model_brand->execute("SELECT", false,"","status='Active'");
		$records1 = array();
		$records1[''] = "Select";
		for($i=0;$i<count($rs);$i++)
		{
			$records1[$rs[$i]['id']] = $rs[$i]['name'];
		}
		$this->assign("item_type",$records1);
		$obj_model_brand = $this->app->load_model("city");
		$rs = $obj_model_brand->execute("SELECT", false,"","status='Active'");
		$records1 = array();
		$records1[0] = "Select";
		for($i=0;$i<count($rs);$i++)
		{
			$records1[$rs[$i]['id']] = $rs[$i]['name'];
		}
		$this->assign("citys",$records1);

		$obj_model_item_certificate = $this->app->load_model("item_certificate");
		$rs_item_certificate = $obj_model_item_certificate->execute("SELECT", false,"","item_certificate.status='Active'","sort_order ASC");
		$this->assign("rs_item_certificate",$rs_item_certificate);
		$recordsss = array();
		for($i=0;$i<count($rs_item_certificate);$i++)
		{
			$recordsss[$rs_item_certificate[$i]['id']] = $rs_item_certificate[$i]['name'];
		}
		$this->assign("certies",$recordsss);

		//Department
		$obj_model_brand = $this->app->load_model("item_department");
		$rs = $obj_model_brand->execute("SELECT", false,"","status='Active'");
		$this->assign("item_department",$rs);

		$obj_model_key_fetures = $this->app->load_model("item_key_fetures");
		$rs_key_fetures = $obj_model_key_fetures->execute("SELECT", false,"","status='Active'");
		$this->assign("item_key_fetures",$rs_key_fetures);
		//Diseases
		$obj_model_brand = $this->app->load_model("item_diseases");
		$rs = $obj_model_brand->execute("SELECT", false,"","status='Active'");
		$this->assign("item_diseases",$rs);
		//Category
		$obj_model_brand = $this->app->load_model("item_category");
		$rs = $obj_model_brand->execute("SELECT", false,"","status='Active'");
		$this->assign("item_category",$rs);

		# GET ITEM
		$obj_model_item = $this->app->load_model("item");
		$rs = $obj_model_item->execute("SELECT", false,"","status='Active'");
		$this->assign("all_items",$rs);
		//Citys
		/*$obj_model_brand = $this->app->load_model("city");
		$rs = $obj_model_brand->execute("SELECT", false,"","status='Active'");
		$this->assign("city",$rs);*/
		if($id!="")
		{
			$this->assign("to_do", "Edit");
			$this->assign("item_action_name", "Edit");
			$this->load_data();
		}
		else
		{
			$this->assign("to_do", "Add");
			$this->assign("item_action_name", "Add");
		}
		$this->assign("manage_for", "Item");
	}
	function load_data()
	{
		$id=$this->app->getGetVar('id');
		$obj_model_item = $this->app->load_model("item");
		$obj_model_item->join_table("item_other_data", "left", array(), array("id"=>"item_id"));
		$obj_model_item->join_table("item_description", "left", array(), array("id"=>"item_id"));
		$rscat = $obj_model_item->execute("SELECT",false,"","item.id='".$id."'");
		if(count($rscat)>0)
		{
			$obj_model_datas = $this->app->load_model("item_price");
			$rs_tab_data= $obj_model_datas->execute("SELECT",false,"","item_id='".$id."'");
			$this->app->assign("rs_tab_data", $rs_tab_data);
			$this->app->assign("rsitem", $rscat[0]);
			$this->app->assign("folder",$rscat[0]['folder']);
			$this->app->assign("sort_order",$rscat[0]['sort_order']);
			$this->app->assign_form_data("frm_item_addedit", $rscat[0]);
			$this->app->assign("rscat", $rscat[0]);
		}
		else
		{
			$this->app->redirect("index.php?view=item_list");
		}
	}
	function update_data()
	{
		$save_btn=$this->app->getPostVar('save_btn');
		$id=$this->app->getGetVar('id');
		$folder=$this->app->getPostVar('folder');
		$name=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('name1'));
		$description=$this->app->getPostVar('description');
		$meta_title=$this->app->getPostVar('meta_title');
		$meta_keywords=$this->app->getPostVar('meta_keywords');
		$meta_desc=$this->app->getPostVar('meta_desc');
		$showIn=$this->app->getPostVar('show_in');
		$work_item1=$this->app->getPostVar('work_item1');
		$item_department_ids=implode(',',$work_item1);

		# GET RECOMMENDATION DATA
		$work_item10=$this->app->getPostVar('work_item10');
		$item_rec_dept_ids=implode(',',$work_item10);
		$work_item11=$this->app->getPostVar('work_item11');
		$item_rec_disease_ids=implode(',',$work_item11);
		$work_item12=$this->app->getPostVar('work_item12');
		$item_rec_cat_ids=implode(',',$work_item12);
		$work_item13=$this->app->getPostVar('work_item13');
		$other_item_ids=implode(',',$work_item13);
		
		$work_item_key_fetures=$this->app->getPostVar('work_item_key_fetures');
		$item_key_fetures_ids=implode(',',$work_item_key_fetures);
		
		$work_item2=$this->app->getPostVar('work_item2');
		$item_diseases_ids=implode(',',$work_item2);
		$work_item3=$this->app->getPostVar('work_item3');
		$item_category_ids=implode(',',$work_item3);
		$work_item4=$this->app->getPostVar('attr1');
		$city_ids=implode(',',$work_item4);
		$getDats=$this->app->utility->getApiCitStateRecord($city_ids);
		$city_ids=$getDats['city_ids'];
		$state_ids=$getDats['state_ids'];
		$api_city_ids=$getDats['api_city_ids'];
		$api_state_ids=$getDats['api_state_ids'];
		$item_type_id=$this->app->getPostVar('item_type_id');
		$set_at_popular_package='No';
		$set_at_popular_test='No';
		$set_at_popular_package1=$this->app->getPostVar('set_at_popular_package1');
		$set_at_popular_test1=$this->app->getPostVar('set_at_popular_test1');
		if($item_type_id==1)
		{
			if($set_at_popular_package1=='Yes')
			{
				$set_at_popular_package='Yes';
			}
		}
		else
		{
			if($set_at_popular_test1=='Yes')
			{
				$set_at_popular_test='Yes';
			}
		}
		if($id!="")
		{
			$slug=$this->app->utility->unique_slug('item','edit','slug',$name,$id);
			$obj_model_item = $this->app->load_model("item", $id);
			$result = $obj_model_item->execute("SELECT");
			$update_field = array();
			if($result[0]["image"]!=NULL && $_FILES['image']['error'] == 0)
			{
				if($result[0]["image"]!=NULL)
				{
					@unlink('../'.$this->app->get_user_config("item").'/'.$folder.'/'.$result[0]["image"]);
					//@unlink('../'.$this->app->get_user_config("item").'/'.$folder.'/'.'/mediumthumb'.$result[0]["image"]);
					//@unlink('../'.$this->app->get_user_config("item").'/'.$folder.'/'.'/thumb'.$result[0]["image"]);
				}
			}
			if(!empty($_FILES['image']['name']))
			{
				//function call for image resizing
				$fileExt = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
				$item_image = uniqid('img_', true) . '.' . $fileExt;
				$destination = '..'.$this->app->get_user_config("item").'/'.$folder.'/' . $item_image;

				move_uploaded_file($_FILES['image']['tmp_name'], $destination);

				//$item_image=$this->app->utility->resize_image($_FILES['image']['name'],$_FILES['image']['tmp_name'],$this->app->get_user_config("item").'/'.$folder.'/','2000','480','250');
				$update_field["image"] = $item_image;
			}
			//For page Slug
			$update_field['name'] = $name;
			$update_field['set_at_popular_package'] = $set_at_popular_package;
			$update_field['set_at_popular_test'] = $set_at_popular_test;
			$update_field['city_ids'] = $city_ids;
			$update_field['state_ids'] = $state_ids;
			$update_field['api_city_ids'] = $api_city_ids;
			$update_field['api_state_ids'] = $api_state_ids;
			$update_field['status'] = 'Active';
			$update_field['slug'] = $slug;
			$update_field['entry_date_time'] = date('d-m-Y H:i:s');
			$this->app->utility->remove_uploaded_file();
			$obj_model_item->map_fields($update_field);
			if($obj_model_item->execute("UPDATE")>0)
			{
				$item_id=$id;
				$data = array();
				$data['item_id'] = $item_id;
				$data['pagewise_test'] = implode(',',$showIn);
				$data['item_category_ids'] = $item_category_ids;
				$data['item_rec_cat_ids'] = $item_rec_cat_ids;
				$data['item_department_ids'] = $item_department_ids;
				$data['item_rec_dept_ids'] = $item_rec_dept_ids;
				$data['item_key_fetures_ids'] = $item_key_fetures_ids;
				$data['item_diseases_ids'] = $item_diseases_ids;
				$data['item_rec_disease_ids'] = $item_rec_disease_ids;
				$data['other_item_ids'] = $other_item_ids;
				$data['description'] = $description;
				$data['meta_title'] = $meta_title;
				$data['meta_keywords'] = $meta_keywords;
				$data['meta_desc'] = $meta_desc;
				$obj_model_item = $this->app->load_model("item_other_data");
				$obj_model_item->map_fields($data);
				$obj_model_item->execute("UPDATE",false,"","item_id='".$item_id."'");
				
				$data = array();
				$data['item_id'] = $item_id;
				$data['item_name'] = $name;
				$obj_model_item = $this->app->load_model("item_description");
				$obj_model_item->map_fields($data);
				$obj_model_item->execute("UPDATE",false,"","item_id='".$item_id."'");
				$cityData=$this->app->getPostVar('attr1');
				$prices=$this->app->getPostVar('prices');
				$mrps=$this->app->getPostVar('mrps');
				$sch_prices=$this->app->getPostVar('sch_prices');
				$starts=$this->app->getPostVar('starts');
				$ends=$this->app->getPostVar('ends');
				$meeting_task_id=$this->app->getPostVar('meeting_task_id');
				$master_data_id=$this->app->getPostVar('master_data_id');
				for($i=0;$i<count($cityData);$i++)
				{
					if($cityData[$i]>0 && $prices[$i]>0)
					{
						$work_certi_item=$this->app->getPostVar('work_certi_item_'.$master_data_id[$i]);
						$item_certificate_ids=implode(',',$work_certi_item);

						$work_lab_item=$this->app->getPostVar('work_lab_item_'.$master_data_id[$i]);
						$item_lab_ids=implode(',',$work_lab_item);

						$obj_model_city = $this->app->load_model('city');
						$rs_city=$obj_model_city->execute("SELECT",false,"","id='".$cityData[$i]."'");
						$city_id=$rs_city[0]['id'];
						$state_id=$rs_city[0]['state_id'];
						$api_city_id=$rs_city[0]['api_city_id'];
						$api_state_id=$rs_city[0]['api_state_id'];
						$data = array();
						$data['item_id'] = $item_id;
						$data['price'] = $prices[$i];
						$data['mrp'] = $mrps[$i];
						$data['sch_price'] = $sch_prices[$i];
						$data['sch_start_date'] = $starts[$i];
						$data['sch_end_date'] = $ends[$i];
						$data['city_id'] = $city_id;
						$data['state_id'] = $state_id;
						$data['api_city_id'] = $api_city_id;
						$data['api_state_id'] = $api_state_id;
						$data['entry_date_time'] = date('d-m-Y H:i:s');
						$data['item_certificate_ids'] = $item_certificate_ids;
						$data['item_lab_ids'] = $item_lab_ids;
						if($meeting_task_id[$i]>0)
						{
							$obj_model_item = $this->app->load_model("item_price");
							$obj_model_item->map_fields($data);
							$obj_model_item->execute("UPDATE",false,"","id='".$meeting_task_id[$i]."'");
						}
						else
						{
							$obj_model_item = $this->app->load_model("item_price");
							$obj_model_item->map_fields($data);
							$obj_model_item->execute("INSERT");
						}
					}
				}
				$this->app->utility->set_message("Records updated successfully", "SUCCESS");
				if($save_btn=='Save_Stay')
				{
					$this->app->redirect("index.php?view=item_addedit&id=".$item_id."");
				}
				else
				{
					$this->app->redirect("index.php?view=item_list");
				}
			}
			else
			{
				$this->app->utility->set_message("Ooops... There was a problem in update item records", "ERROR");
				$this->app->redirect("index.php?view=item_list");
			}
		}
		else
		{
			//INSERT RECORDS
			$slug=$this->app->utility->unique_slug('item','add','slug',$name);
			//$brand_name=$this->app->utility->get_brandName($this->app->getPostVar('brand_id'));
			$update_field = array();
			if(!empty($_FILES['image']['name']))
			{
				$fileExt = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
				$item_image = uniqid('img_', true) . '.' . $fileExt;
				$destination = '..'.$this->app->get_user_config("item").'/'.$folder.'/' . $item_image;

				move_uploaded_file($_FILES['image']['tmp_name'], $destination);

				//$item_image=$this->app->utility->resize_image($_FILES['image']['name'],$_FILES['image']['tmp_name'],$this->app->get_user_config("item").'/'.$folder.'/','2000','480','250');
				$update_field["image"] = $item_image;
			}
			$update_field['name'] = $name;
			$update_field['set_at_popular_package'] = $set_at_popular_package;
			$update_field['set_at_popular_test'] = $set_at_popular_test;
			$update_field['city_ids'] = $city_ids;
			$update_field['state_ids'] = $state_ids;
			$update_field['api_city_ids'] = $api_city_ids;
			$update_field['api_state_ids'] = $api_state_ids;
			$update_field['status'] = 'Active';
			$update_field['slug'] = $slug;
			$update_field['entry_date_time'] = date('d-m-Y H:i:s');
			$obj_model_item = $this->app->load_model("item");
			$obj_model_item->map_fields($update_field);
			$item_id=$obj_model_item->execute("INSERT");
			if($item_id>0)
			{
				$data = array();
				$data['item_id'] = $item_id;
				$data['item_category_ids'] = $item_category_ids;
				$data['item_rec_cat_ids'] = $item_rec_cat_ids;
				$data['item_department_ids'] = $item_department_ids;
				$data['item_rec_dept_ids'] = $item_rec_dept_ids;
				$data['item_diseases_ids'] = $item_diseases_ids;
				$data['item_rec_disease_ids'] = $item_rec_disease_ids;
				$data['other_item_ids'] = $other_item_ids;
				$data['description'] = $description;
				$obj_model_item = $this->app->load_model("item_other_data");
				$obj_model_item->map_fields($data);
				$obj_model_item->execute("INSERT");
				
					$data = array();
					$data['item_id'] = $item_id;
					$data['item_name'] = $name;
					$obj_model_item = $this->app->load_model("item_description");
					$obj_model_item->map_fields($data);
					$obj_model_item->execute("INSERT");
					$cityData=$this->app->getPostVar('attr1');
					$prices=$this->app->getPostVar('prices');
					$mrps=$this->app->getPostVar('mrps');
					$sch_prices=$this->app->getPostVar('sch_prices');
					$starts=$this->app->getPostVar('starts');
					$ends=$this->app->getPostVar('ends');
					$master_data_id=$this->app->getPostVar('master_data_id');
					for($i=0;$i<count($cityData);$i++)
					{
						if($cityData[$i]>0 && $prices[$i]>0)
						{
							$work_certi_item=$this->app->getPostVar('work_certi_item_'.$master_data_id[$i]);
							$item_certificate_ids=implode(',',$work_certi_item);
							$obj_model_city = $this->app->load_model('city');
							$rs_city=$obj_model_city->execute("SELECT",false,"","id='".$cityData[$i]."'");
							$city_id=$rs_city[0]['id'];
							$state_id=$rs_city[0]['state_id'];
							$api_city_id=$rs_city[0]['api_city_id'];
							$api_state_id=$rs_city[0]['api_state_id'];
							$data = array();
							$data['item_id'] = $item_id;
							$data['price'] = $prices[$i];
							$data['mrp'] = $mrps[$i];
							$data['sch_price'] = $sch_prices[$i];
							$data['sch_start_date'] = $starts[$i];
							$data['sch_end_date'] = $ends[$i];
							$data['city_id'] = $city_id;
							$data['state_id'] = $state_id;
							$data['api_city_id'] = $api_city_id;
							$data['api_state_id'] = $api_state_id;
							$data['entry_date_time'] = date('d-m-Y H:i:s');
							$data['item_certificate_ids'] = $item_certificate_ids;
							$obj_model_item = $this->app->load_model("item_price");
							$obj_model_item->map_fields($data);
							$obj_model_item->execute("INSERT");
						}
					}
					$this->app->utility->set_message("Records added successfull", "SUCCESS");
					if($save_btn=='Save_Stay')
					{
						$this->app->redirect("index.php?view=item_addedit&id=".$item_id."");
					}
					else
					{
						$this->app->redirect("index.php?view=item_list");
					}
			}
			else
			{
				$this->app->utility->set_message("Try Again.", "ERROR");
				$this->app->redirect("index.php?view=item_list");
			}
		}
	}
}
?>