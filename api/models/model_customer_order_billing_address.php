<?php
	class model_customer_order_billing_address{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_customer_order_billing_address($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["order_master_id"]="int(11)";
			$this->nullable["order_master_id"]="NO";
			$this->default_value["order_master_id"]="";
			$this->fields["customer_id"]="int(11)";
			$this->nullable["customer_id"]="NO";
			$this->default_value["customer_id"]="";
			$this->fields["customer_address_id"]="int(11)";
			$this->nullable["customer_address_id"]="NO";
			$this->default_value["customer_address_id"]="";
			$this->fields["first_name"]="varchar(100)";
			$this->nullable["first_name"]="NO";
			$this->default_value["first_name"]="";
			$this->fields["last_name"]="varchar(100)";
			$this->nullable["last_name"]="NO";
			$this->default_value["last_name"]="";
			$this->fields["phone"]="varchar(100)";
			$this->nullable["phone"]="NO";
			$this->default_value["phone"]="";
			$this->fields["email"]="varchar(100)";
			$this->nullable["email"]="NO";
			$this->default_value["email"]="";
			$this->fields["line1"]="varchar(500)";
			$this->nullable["line1"]="NO";
			$this->default_value["line1"]="";
			$this->fields["line2"]="varchar(500)";
			$this->nullable["line2"]="NO";
			$this->default_value["line2"]="";
			$this->fields["google_address"]="varchar(500)";
			$this->nullable["google_address"]="NO";
			$this->default_value["google_address"]="";
			$this->fields["zipcode"]="varchar(20)";
			$this->nullable["zipcode"]="NO";
			$this->default_value["zipcode"]="";
			$this->fields["city"]="varchar(100)";
			$this->nullable["city"]="NO";
			$this->default_value["city"]="";
			$this->fields["state_id"]="int(11)";
			$this->nullable["state_id"]="NO";
			$this->default_value["state_id"]="";
			$this->fields["address_type"]="varchar(50)";
			$this->nullable["address_type"]="NO";
			$this->default_value["address_type"]="";
			$this->fields["lattitude"]="varchar(255)";
			$this->nullable["lattitude"]="NO";
			$this->default_value["lattitude"]="";
			$this->fields["longitude"]="varchar(255)";
			$this->nullable["longitude"]="NO";
			$this->default_value["longitude"]="";
		}
	}
?>