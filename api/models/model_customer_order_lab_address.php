<?php
	class model_customer_order_lab_address{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_customer_order_lab_address($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["customer_id"]="int(11)";
			$this->nullable["customer_id"]="NO";
			$this->default_value["customer_id"]="";
			$this->fields["order_master_id"]="int(11)";
			$this->nullable["order_master_id"]="NO";
			$this->default_value["order_master_id"]="";
			$this->fields["lab_id"]="int(11)";
			$this->nullable["lab_id"]="NO";
			$this->default_value["lab_id"]="";
			$this->fields["api_id"]="varchar(100)";
			$this->nullable["api_id"]="NO";
			$this->default_value["api_id"]="";
			$this->fields["code"]="varchar(255)";
			$this->nullable["code"]="NO";
			$this->default_value["code"]="";
			$this->fields["lab_name"]="varchar(255)";
			$this->nullable["lab_name"]="NO";
			$this->default_value["lab_name"]="";
			$this->fields["lab_email"]="varchar(100)";
			$this->nullable["lab_email"]="NO";
			$this->default_value["lab_email"]="";
			$this->fields["lab_phone"]="varchar(100)";
			$this->nullable["lab_phone"]="NO";
			$this->default_value["lab_phone"]="";
			$this->fields["lab_address"]="text";
			$this->nullable["lab_address"]="NO";
			$this->default_value["lab_address"]="";
			$this->fields["entry_date_time"]="varchar(100)";
			$this->nullable["entry_date_time"]="NO";
			$this->default_value["entry_date_time"]="";
		}
	}
?>