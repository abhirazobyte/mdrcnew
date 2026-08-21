<?php
	class model_item_lab{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_item_lab($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["city_id"]="int(11)";
			$this->nullable["city_id"]="NO";
			$this->default_value["city_id"]="";
			$this->fields["api_id"]="varchar(100)";
			$this->nullable["api_id"]="NO";
			$this->default_value["api_id"]="";
			$this->fields["code"]="varchar(255)";
			$this->nullable["code"]="NO";
			$this->default_value["code"]="";
			$this->fields["name"]="varchar(255)";
			$this->nullable["name"]="NO";
			$this->default_value["name"]="";
			$this->fields["slug"]="varchar(255)";
			$this->nullable["slug"]="NO";
			$this->default_value["slug"]="";
			$this->fields["image"]="varchar(255)";
			$this->nullable["image"]="NO";
			$this->default_value["image"]="";
			$this->fields["email"]="varchar(255)";
			$this->nullable["email"]="NO";
			$this->default_value["email"]="";
			$this->fields["phone"]="varchar(255)";
			$this->nullable["phone"]="NO";
			$this->default_value["phone"]="";
			$this->fields["address"]="text";
			$this->nullable["address"]="NO";
			$this->default_value["address"]="";
			$this->fields["department_names"]="text";
			$this->nullable["department_names"]="NO";
			$this->default_value["department_names"]="";

			$this->fields["excluding_department_names"]="text";
			$this->nullable["excluding_department_names"]="NO";
			$this->default_value["excluding_department_names"]="";

			$this->fields["lab_type"]="enum('Main Lab','Collection Point')";
			$this->nullable["lab_type"]="NO";
			$this->default_value["lab_type"]="Main Lab";
			$this->fields["panel_id"]="varchar(255)";
			$this->nullable["panel_id"]="NO";
			$this->default_value["panel_id"]="";

			$this->fields["rate_list_panel_id"]="varchar(255)";
			$this->nullable["rate_list_panel_id"]="NO";
			$this->default_value["rate_list_panel_id"]="";

			$this->fields["center_id"]="varchar(255)";
			$this->nullable["center_id"]="NO";
			$this->default_value["center_id"]="";
			$this->fields["status"]="enum('Active','Inactive','Trash')";
			$this->nullable["status"]="NO";
			$this->default_value["status"]="Active";
			$this->fields["sort_order"]="int(100)";
			$this->nullable["sort_order"]="NO";
			$this->default_value["sort_order"]="";
			$this->fields["entry_date_time"]="varchar(100)";
			$this->nullable["entry_date_time"]="NO";
			$this->default_value["entry_date_time"]="";
		}
	}
?>