<?php
	class model_customer_logins{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_customer_logins($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["customer_id"]="int(11)";
			$this->nullable["customer_id"]="NO";
			$this->default_value["customer_id"]="";
			$this->fields["ip_address"]="varchar(100)";
			$this->nullable["ip_address"]="NO";
			$this->default_value["ip_address"]="";
			$this->fields["customer_logins_update_date"]="varchar(100)";
			$this->nullable["customer_logins_update_date"]="NO";
			$this->default_value["customer_logins_update_date"]="";
			$this->fields["created_from"]="varchar(100)";
			$this->nullable["created_from"]="NO";
			$this->default_value["created_from"]="";
		}
	}
?>