<?php
	class model_pincode{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_pincode($ID=0){
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
			$this->fields["area_id"]="int(11)";
			$this->nullable["area_id"]="NO";
			$this->default_value["area_id"]="";
			$this->fields["name"]="varchar(100)";
			$this->nullable["name"]="NO";
			$this->default_value["name"]="";
			$this->fields["appointment_start_time"]="varchar(100)";
			$this->nullable["appointment_start_time"]="NO";
			$this->default_value["appointment_start_time"]="";
			$this->fields["appointment_end_time"]="varchar(100)";
			$this->nullable["appointment_end_time"]="NO";
			$this->default_value["appointment_end_time"]="";
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