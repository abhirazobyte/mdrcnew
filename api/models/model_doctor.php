<?php
	class model_doctor{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_doctor($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["name"]="varchar(255)";
			$this->nullable["name"]="NO";
			$this->default_value["name"]="";
			$this->fields["slug"]="varchar(255)";
			$this->nullable["slug"]="NO";
			$this->default_value["slug"]="";
			$this->fields["category_id"]="int(11)";
			$this->nullable["category_id"]="NO";
			$this->default_value["category_id"]="";
			$this->fields["about_info"]="text";
			$this->nullable["about_info"]="NO";
			$this->default_value["about_info"]="";
			$this->fields["designation"]="varchar(255)";
			$this->nullable["designation"]="NO";
			$this->default_value["designation"]="";
			$this->fields["image"]="varchar(100)";
			$this->nullable["image"]="NO";
			$this->default_value["image"]="";
			$this->fields["display_about"]="enum('Active','Inactive')";
			$this->nullable["display_about"]="NO";
			$this->default_value["display_about"]="Active";
			$this->fields["sort_order"]="int(11)";
			$this->nullable["sort_order"]="NO";
			$this->default_value["sort_order"]="";
			$this->fields["status"]="enum('Active','Inactive','Trash')";
			$this->nullable["status"]="NO";
			$this->default_value["status"]="Active";
			$this->fields["entry_date_time"]="varchar(100)";
			$this->nullable["entry_date_time"]="NO";
			$this->default_value["entry_date_time"]="";
		}
	}
?>