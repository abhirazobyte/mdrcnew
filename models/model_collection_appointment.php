<?php
	class model_collection_appointment{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_collection_appointment($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["name"]="varchar(255)";
			$this->nullable["name"]="NO";
			$this->default_value["name"]="";
			$this->fields["email"]="varchar(255)";
			$this->nullable["email"]="NO";
			$this->default_value["email"]="";
			$this->fields["phone"]="varchar(255)";
			$this->nullable["phone"]="NO";
			$this->default_value["phone"]="";
			$this->fields["age"]="varchar(255)";
			$this->nullable["age"]="YES";
			$this->default_value["age"]="";
			$this->fields["city"]="varchar(255)";
			$this->nullable["city"]="YES";
			$this->default_value["city"]="";
			$this->fields["date"]="varchar(255)";
			$this->nullable["date"]="YES";
			$this->default_value["date"]="";
			$this->fields["gender"]="varchar(255)";
			$this->nullable["gender"]="YES";
			$this->default_value["gender"]="";
			$this->fields["address"]="varchar(255)";
			$this->nullable["address"]="YES";
			$this->default_value["address"]="";
			$this->fields["brief_details"]="text";
			$this->nullable["brief_details"]="YES";
			$this->default_value["brief_details"]="";
			$this->fields["reference"]="varchar(255)";
			$this->nullable["reference"]="YES";
			$this->default_value["reference"]="";
			$this->fields["user_id"]="int(11)";
			$this->nullable["user_id"]="YES";
			$this->default_value["user_id"]="";
			$this->fields["added_date"]="varchar(255)";
			$this->nullable["added_date"]="YES";
			$this->default_value["added_date"]="";
			$this->fields["ip"]="varchar(255)";
			$this->nullable["ip"]="YES";
			$this->default_value["ip"]="";
		}
	}
?>