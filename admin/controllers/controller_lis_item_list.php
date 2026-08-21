<?php
class _lis_item_list extends controller
{
	function init()
	{
		if($this->app->getCurrentAction()=="")
		{
			$this->load_data();
		}
	}

	function onload()
	{
	}	
		
	function load_data()
	{
	}

	function export_data()
	{
		
		$this->app->no_html=true;
		$obj_excel = $this->app->load_module("PHPExcel");
		$ExeclHeads=array("ID","lis_item","lis_item ID","lis_item Code","lis_item Type","Department","Diseases","Category","City","Price","MRP","Certificate");

		$obj_model_lis_item = $this->app->load_model("lis_item_price");
		$obj_model_lis_item->join_table("lis_item", "left", array("name","lis_itemid","lis_itemcode","status"), array("lis_item_id"=>"id"));
		$obj_model_lis_item->join_table("lis_item_other_data", "left", array("lis_item_department_ids","lis_item_category_ids","lis_item_diseases_ids","lis_item_type_id"), array("lis_item_id"=>"lis_item_id"));
		$obj_model_lis_item->join_table("city", "left", array("name"), array("city_id"=>"id"));
		$rs_lis_item=$obj_model_lis_item->execute("SELECT", false, "","lis_item.status='Active'","lis_item_price.lis_item_id ASC",'lis_item_price.id');
		//echo $obj_model_lis_item->sql;exit;
		$ucount=1;
		$group_string='';
		foreach($rs_lis_item as $lis_item)
		{
			$certificate=$this->app->utility->get_certificate_name($lis_item['lis_item_certificate_ids']);
			$price=$lis_item['price'];
			$mrp=$lis_item['mrp'];
			$city_name=$lis_item['city_name'];


			if($group_string!=$lis_item['lis_item_id'])
			{
				$departments=$this->app->utility->get_departments_name($lis_item['lis_item_other_data_lis_item_department_ids']);
				$categorys=$this->app->utility->get_category_name($lis_item['lis_item_other_data_lis_item_category_ids']);
				$diseases=$this->app->utility->get_diseases_name($lis_item['lis_item_other_data_lis_item_diseases_ids']);
				$lis_item_type_name=$this->app->utility->get_lis_item_name($lis_item['lis_item_other_data_lis_item_type_id']);
				$id=$lis_item['lis_item_id'];
				$lis_item_name=$lis_item['lis_item_name'];
				$lis_itemid=$lis_item['lis_item_lis_itemid'];
				$lis_itemcode=$lis_item['lis_item_lis_itemcode'];
				$group_string=$lis_item['lis_item_id'];
			}
			else
			{
				$departments='-';
				$categorys='-';
				$diseases='-';
				$lis_item_type_name='-';
				$id='-';
				$lis_item_name='-';
				$lis_itemid='-';
				$lis_itemcode='-';
			}
			
			$user_array[]=array(
				"ID"=>$id,
				"lis_item"=>$lis_item_name,
				"lis_item ID"=>$lis_itemid,
				"lis_item Code"=>$lis_itemcode,
				"lis_item Type"=>$lis_item_type_name,
				"Department"=>$departments,
				"Diseases"=>$diseases,
				"Category"=>$categorys,
				"City"=>$city_name,
				"Price"=>$price,
				"MRP"=>$mrp,
				"Certificate"=>$certificate
			);	
		}

		$array_field=array(
		"block_name"=>array("options"=>"","prompt_title"=>"","prompt"=>""),
		"flat_type"=>array("options"=>"","prompt_title"=>"","prompt"=>""),
		"resident_type"=>array("options"=>"","prompt_title"=>"","prompt"=>"")
		);
		$data_array=$user_array;
		$fields=array("ID","lis_item","lis_item ID","lis_item Code","lis_item Type","Department","Diseases","Category","City","Price","MRP","Certificate");
		$filename="Iteam - ".date('d-m-Y');
		$this->app->utility->export_excel($ExeclHeads,$data_array,$fields,$filename,$array_field);			
	}
}	
?>