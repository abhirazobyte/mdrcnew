<?php
	class model_customer_token{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_customer_token($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["customer_id"]="int(11)";
			$this->nullable["customer_id"]="NO";
			$this->default_value["customer_id"]="";
			$this->fields["android_version"]="varchar(20)";
			$this->nullable["android_version"]="NO";
			$this->default_value["android_version"]="";
			$this->fields["android_device"]="varchar(100)";
			$this->nullable["android_device"]="NO";
			$this->default_value["android_device"]="";
			$this->fields["fcm_token"]="varchar(255)";
			$this->nullable["fcm_token"]="NO";
			$this->default_value["fcm_token"]="";
			$this->fields["android_updated_at"]="varchar(100)";
			$this->nullable["android_updated_at"]="NO";
			$this->default_value["android_updated_at"]="";
			$this->fields["android_ip_address"]="varbinary(45)";
			$this->nullable["android_ip_address"]="NO";
			$this->default_value["android_ip_address"]="";
			$this->fields["iphone_version"]="varchar(20)";
			$this->nullable["iphone_version"]="NO";
			$this->default_value["iphone_version"]="";
			$this->fields["iphone_token"]="varchar(255)";
			$this->nullable["iphone_token"]="NO";
			$this->default_value["iphone_token"]="";
			$this->fields["iphone_updated_at"]="varchar(100)";
			$this->nullable["iphone_updated_at"]="NO";
			$this->default_value["iphone_updated_at"]="";
			$this->fields["iphone_ip_address"]="varbinary(45)";
			$this->nullable["iphone_ip_address"]="NO";
			$this->default_value["iphone_ip_address"]="";
		}
	}
?>