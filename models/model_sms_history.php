<?php
	class model_sms_history{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_sms_history($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["phones"]="varchar(255)";
			$this->nullable["phones"]="NO";
			$this->default_value["phones"]="";
			$this->fields["sms_text"]="text";
			$this->nullable["sms_text"]="NO";
			$this->default_value["sms_text"]="";
			$this->fields["sms_msg_id"]="varchar(500)";
			$this->nullable["sms_msg_id"]="NO";
			$this->default_value["sms_msg_id"]="";
			$this->fields["sms_status"]="varchar(100)";
			$this->nullable["sms_status"]="NO";
			$this->default_value["sms_status"]="";
			$this->fields["sms_count"]="int(11)";
			$this->nullable["sms_count"]="NO";
			$this->default_value["sms_count"]="";
			$this->fields["ip"]="varchar(100)";
			$this->nullable["ip"]="NO";
			$this->default_value["ip"]="";
			$this->fields["entry_date"]="varchar(100)";
			$this->nullable["entry_date"]="NO";
			$this->default_value["entry_date"]="";
			$this->fields["entry_date_time"]="varchar(100)";
			$this->nullable["entry_date_time"]="NO";
			$this->default_value["entry_date_time"]="";
		}
	}
?>