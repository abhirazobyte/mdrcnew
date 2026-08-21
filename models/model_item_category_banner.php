<?php
	class model_item_category_banner{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_item_category_banner($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["item_category_ids"]="varchar(255)";
			$this->nullable["item_category_ids"]="NO";
			$this->default_value["item_category_ids"]="";
			$this->fields["item_department_ids"]="varchar(255)";
			$this->nullable["item_department_ids"]="NO";
			$this->default_value["item_department_ids"]="";
			$this->fields["city_ids"]="varchar(255)";
			$this->nullable["city_ids"]="NO";
			$this->default_value["city_ids"]="";
			$this->fields["name"]="varchar(50)";
			$this->nullable["name"]="NO";
			$this->default_value["name"]="";
			$this->fields["banner_image"]="varchar(255)";
			$this->nullable["banner_image"]="NO";
			$this->default_value["banner_image"]="";
			$this->fields["mobile_image"]="varchar(255)";
			$this->nullable["mobile_image"]="NO";
			$this->default_value["mobile_image"]="";
			$this->fields["banner_text"]="varchar(255)";
			$this->nullable["banner_text"]="NO";
			$this->default_value["banner_text"]="";
			$this->fields["banner_link"]="varchar(255)";
			$this->nullable["banner_link"]="NO";
			$this->default_value["banner_link"]="";
			$this->fields["sort_id"]="int(11)";
			$this->nullable["sort_id"]="NO";
			$this->default_value["sort_id"]="";
			$this->fields["status"]="enum('Active','Inactive')";
			$this->nullable["status"]="NO";
			$this->default_value["status"]="Active";
		}
	}
?>