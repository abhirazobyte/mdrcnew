<?php
	class model_item_for_doctors_services_data{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_item_for_doctors_services_data($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["item_id"]="int(11)";
			$this->nullable["item_id"]="NO";
			$this->default_value["item_id"]="";
			$this->fields["for_doctors_services_id"]="int(11)";
			$this->nullable["for_doctors_services_id"]="NO";
			$this->default_value["for_doctors_services_id"]="";
			$this->fields["sort_order"]="int(11)";
			$this->nullable["sort_order"]="NO";
			$this->default_value["sort_order"]="";
			$this->fields["entry_date_time"]="varchar(100)";
			$this->nullable["entry_date_time"]="NO";
			$this->default_value["entry_date_time"]="";
		}
	}
?>