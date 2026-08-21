<?php
class _item_list extends controller
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
		$ExeclHeads=array("ID","Item","Item ID","Item Code","Item Type","Department","Diseases","Category","City","Price","MRP","Certificate");

		$obj_model_item = $this->app->load_model("item_price");
		$obj_model_item->join_table("item", "left", array("name","itemid","itemcode","status"), array("item_id"=>"id"));
		$obj_model_item->join_table("item_other_data", "left", array("item_department_ids","item_category_ids","item_diseases_ids","item_type_id"), array("item_id"=>"item_id"));
		$obj_model_item->join_table("city", "left", array("name"), array("city_id"=>"id"));
		$rs_item=$obj_model_item->execute("SELECT", false, "","item.status='Active'","item_price.item_id ASC",'item_price.id');
		//echo $obj_model_item->sql;exit;
		$ucount=1;
		$group_string='';
		foreach($rs_item as $item)
		{
			$certificate=$this->app->utility->get_certificate_name($item['item_certificate_ids']);
			$price=$item['price'];
			$mrp=$item['mrp'];
			$city_name=$item['city_name'];


			if($group_string!=$item['item_id'])
			{
				$departments=$this->app->utility->get_departments_name($item['item_other_data_item_department_ids']);
				$categorys=$this->app->utility->get_category_name($item['item_other_data_item_category_ids']);
				$diseases=$this->app->utility->get_diseases_name($item['item_other_data_item_diseases_ids']);
				$item_type_name=$this->app->utility->get_item_name($item['item_other_data_item_type_id']);
				$id=$item['item_id'];
				$item_name=$item['item_name'];
				$itemid=$item['item_itemid'];
				$itemcode=$item['item_itemcode'];
				$group_string=$item['item_id'];
			}
			else
			{
				$departments='-';
				$categorys='-';
				$diseases='-';
				$item_type_name='-';
				$id='-';
				$item_name='-';
				$itemid='-';
				$itemcode='-';
			}
			
			$user_array[]=array(
				"ID"=>$id,
				"Item"=>$item_name,
				"Item ID"=>$itemid,
				"Item Code"=>$itemcode,
				"Item Type"=>$item_type_name,
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
		$fields=array("ID","Item","Item ID","Item Code","Item Type","Department","Diseases","Category","City","Price","MRP","Certificate");
		$filename="Iteam - ".date('d-m-Y');
		$this->app->utility->export_excel($ExeclHeads,$data_array,$fields,$filename,$array_field);			
	}
}	
?>