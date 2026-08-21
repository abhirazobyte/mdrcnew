<?php
	class model_customer_info{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_customer_info($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["phone_otp"]="varchar(20)";
			$this->nullable["phone_otp"]="NO";
			$this->default_value["phone_otp"]="";
			$this->fields["customer_id"]="int(11)";
			$this->nullable["customer_id"]="NO";
			$this->default_value["customer_id"]="";
			$this->fields["city"]="varchar(100)";
			$this->nullable["city"]="NO";
			$this->default_value["city"]="";
			$this->fields["state"]="varchar(100)";
			$this->nullable["state"]="NO";
			$this->default_value["state"]="";
			$this->fields["address"]="text";
			$this->nullable["address"]="NO";
			$this->default_value["address"]="";
			$this->fields["zipcode"]="varchar(100)";
			$this->nullable["zipcode"]="NO";
			$this->default_value["zipcode"]="";
			$this->fields["birth_date"]="varchar(100)";
			$this->nullable["birth_date"]="NO";
			$this->default_value["birth_date"]="";
			$this->fields["marital_status"]="enum('Single','Married','Divorced','Widowed')";
			$this->nullable["marital_status"]="NO";
			$this->default_value["marital_status"]="Single";
			$this->fields["anniversary_date"]="varchar(100)";
			$this->nullable["anniversary_date"]="NO";
			$this->default_value["anniversary_date"]="";
			$this->fields["whatsapp_no"]="varchar(100)";
			$this->nullable["whatsapp_no"]="NO";
			$this->default_value["whatsapp_no"]="";
			$this->fields["last_login"]="varchar(100)";
			$this->nullable["last_login"]="NO";
			$this->default_value["last_login"]="";
			$this->fields["last_ip_address"]="varchar(100)";
			$this->nullable["last_ip_address"]="NO";
			$this->default_value["last_ip_address"]="";
			$this->fields["entry_date_time"]="varchar(100)";
			$this->nullable["entry_date_time"]="NO";
			$this->default_value["entry_date_time"]="";
		}
	}
?>