<?php
	class model_get_call_back{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_get_call_back($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["customer_id"]="int(11)";
			$this->nullable["customer_id"]="YES";
			$this->default_value["customer_id"]="";
			$this->fields["name"]="varchar(255)";
			$this->nullable["name"]="NO";
			$this->default_value["name"]="";
			$this->fields["phone"]="varchar(255)";
			$this->nullable["phone"]="NO";
			$this->default_value["phone"]="";
			$this->fields["city"]="varchar(255)";
			$this->nullable["city"]="YES";
			$this->default_value["city"]="";
			$this->fields["message"]="text";
			$this->nullable["message"]="NO";
			$this->default_value["message"]="";
			$this->fields["added"]="varchar(255)";
			$this->nullable["added"]="YES";
			$this->default_value["added"]="";
			$this->fields["ip"]="varchar(255)";
			$this->nullable["ip"]="YES";
			$this->default_value["ip"]="";
		}
	}
?>