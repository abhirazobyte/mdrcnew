<?php
	class model_item_price{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_item_price($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["item_id"]="int(11)";
			$this->nullable["item_id"]="NO";
			$this->default_value["item_id"]="";
			$this->fields["city_id"]="int(11)";
			$this->nullable["city_id"]="NO";
			$this->default_value["city_id"]="";
			$this->fields["state_id"]="int(11)";
			$this->nullable["state_id"]="NO";
			$this->default_value["state_id"]="";
			$this->fields["api_city_id"]="int(11)";
			$this->nullable["api_city_id"]="NO";
			$this->default_value["api_city_id"]="";
			$this->fields["api_state_id"]="int(11)";
			$this->nullable["api_state_id"]="NO";
			$this->default_value["api_state_id"]="";
			$this->fields["price"]="float(9,2)";
			$this->nullable["price"]="NO";
			$this->default_value["price"]="";
			$this->fields["mrp"]="float(9,2)";
			$this->nullable["mrp"]="NO";
			$this->default_value["mrp"]="";
			$this->fields["sch_price"]="float(9,2)";
			$this->nullable["sch_price"]="NO";
			$this->default_value["sch_price"]="";
			$this->fields["sch_start_date"]="varchar(50)";
			$this->nullable["sch_start_date"]="NO";
			$this->default_value["sch_start_date"]="";
			$this->fields["sch_end_date"]="varchar(50)";
			$this->nullable["sch_end_date"]="NO";
			$this->default_value["sch_end_date"]="";
			$this->fields["item_certificate_ids"]="varchar(255)";
			$this->nullable["item_certificate_ids"]="NO";
			$this->default_value["item_certificate_ids"]="";
			$this->fields["item_lab_ids"]="varchar(255)";
			$this->nullable["item_lab_ids"]="NO";
			$this->default_value["item_lab_ids"]="";
			$this->fields["entry_date_time"]="varchar(100)";
			$this->nullable["entry_date_time"]="NO";
			$this->default_value["entry_date_time"]="";
		}
	}
?>