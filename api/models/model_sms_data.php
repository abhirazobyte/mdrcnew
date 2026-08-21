<?php
	class model_sms_data{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_sms_data($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["name"]="varchar(255)";
			$this->nullable["name"]="NO";
			$this->default_value["name"]="";
			$this->fields["sms_text"]="text";
			$this->nullable["sms_text"]="NO";
			$this->default_value["sms_text"]="";
			$this->fields["sms_text_system"]="text";
			$this->nullable["sms_text_system"]="NO";
			$this->default_value["sms_text_system"]="";
			$this->fields["status"]="enum('Active','Inactive')";
			$this->nullable["status"]="NO";
			$this->default_value["status"]="Active";
			$this->fields["entry_date"]="varchar(100)";
			$this->nullable["entry_date"]="NO";
			$this->default_value["entry_date"]="";
			$this->fields["entry_date_time"]="varchar(100)";
			$this->nullable["entry_date_time"]="NO";
			$this->default_value["entry_date_time"]="";
			$this->fields["ip"]="varchar(100)";
			$this->nullable["ip"]="NO";
			$this->default_value["ip"]="";
			$this->fields["template_id"]="varchar(255)";
			$this->nullable["template_id"]="NO";
			$this->default_value["template_id"]="";
		}
	}
?>