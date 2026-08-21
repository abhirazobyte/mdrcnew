<?php
	class model_user_logins_admin{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_user_logins_admin($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["user_id"]="int(11)";
			$this->nullable["user_id"]="NO";
			$this->default_value["user_id"]="";
			$this->fields["date"]="varchar(255)";
			$this->nullable["date"]="NO";
			$this->default_value["date"]="";
			$this->fields["browser"]="varchar(255)";
			$this->nullable["browser"]="NO";
			$this->default_value["browser"]="";
			$this->fields["ip"]="varchar(255)";
			$this->nullable["ip"]="NO";
			$this->default_value["ip"]="";
		}
	}
?>