<?php
	class model_lis_api_call{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_lis_api_call($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["call_for"]="enum('Order')";
			$this->nullable["call_for"]="NO";
			$this->default_value["call_for"]="Order";
			$this->fields["send_json"]="longtext";
			$this->nullable["send_json"]="NO";
			$this->default_value["send_json"]="";
			$this->fields["response_json"]="longtext";
			$this->nullable["response_json"]="NO";
			$this->default_value["response_json"]="";
			$this->fields["send_on_time"]="varchar(255)";
			$this->nullable["send_on_time"]="NO";
			$this->default_value["send_on_time"]="";
			$this->fields["response_on_time"]="varchar(255)";
			$this->nullable["response_on_time"]="NO";
			$this->default_value["response_on_time"]="";
		}
	}
?>