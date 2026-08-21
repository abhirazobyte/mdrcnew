<?php
	class model_help{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_help($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["user_id"]="int(11)";
			$this->nullable["user_id"]="NO";
			$this->default_value["user_id"]="";
			$this->fields["name"]="varchar(255)";
			$this->nullable["name"]="NO";
			$this->default_value["name"]="";
			$this->fields["email"]="varchar(100)";
			$this->nullable["email"]="NO";
			$this->default_value["email"]="";
			$this->fields["phone"]="varchar(50)";
			$this->nullable["phone"]="NO";
			$this->default_value["phone"]="";
			$this->fields["message"]="varchar(500)";
			$this->nullable["message"]="NO";
			$this->default_value["message"]="";
			$this->fields["date"]="varchar(100)";
			$this->nullable["date"]="NO";
			$this->default_value["date"]="";
			$this->fields["type"]="varchar(100)";
			$this->nullable["type"]="NO";
			$this->default_value["type"]="";
			$this->fields["status"]="enum('Pending','Solved','Canceled')";
			$this->nullable["status"]="NO";
			$this->default_value["status"]="Pending";
			$this->fields["ip"]="varchar(255)";
			$this->nullable["ip"]="NO";
			$this->default_value["ip"]="";
			$this->fields["entry_from"]="varchar(255)";
			$this->nullable["entry_from"]="NO";
			$this->default_value["entry_from"]="";
			$this->fields["order_id"]="int(11)";
			$this->nullable["order_id"]="NO";
			$this->default_value["order_id"]="";
			$this->fields["city"]="varchar(255)";
			$this->nullable["city"]="NO";
			$this->default_value["city"]="";
		}
	}
?>