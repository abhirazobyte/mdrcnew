<?php
	class model_area{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_area($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["api_state_id"]="int(11)";
			$this->nullable["api_state_id"]="NO";
			$this->default_value["api_state_id"]="";
			$this->fields["api_city_id"]="int(11)";
			$this->nullable["api_city_id"]="NO";
			$this->default_value["api_city_id"]="";
			$this->fields["api_area_id"]="int(11)";
			$this->nullable["api_area_id"]="NO";
			$this->default_value["api_area_id"]="";
			$this->fields["state_id"]="int(11)";
			$this->nullable["state_id"]="NO";
			$this->default_value["state_id"]="";
			$this->fields["city_id"]="int(11)";
			$this->nullable["city_id"]="NO";
			$this->default_value["city_id"]="";
			$this->fields["name"]="varchar(100)";
			$this->nullable["name"]="NO";
			$this->default_value["name"]="";
			$this->fields["slug"]="varchar(255)";
			$this->nullable["slug"]="NO";
			$this->default_value["slug"]="";
			$this->fields["sort_order"]="int(11)";
			$this->nullable["sort_order"]="NO";
			$this->default_value["sort_order"]="";
			$this->fields["status"]="enum('Active','Inactive','Trash')";
			$this->nullable["status"]="NO";
			$this->default_value["status"]="Active";
			$this->fields["entry_date_time"]="varchar(50)";
			$this->nullable["entry_date_time"]="NO";
			$this->default_value["entry_date_time"]="";
		}
	}
?>