<?php
	class model_admin{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_admin($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["login_username"]="varchar(25)";
			$this->nullable["login_username"]="NO";
			$this->default_value["login_username"]="";
			$this->fields["login_password"]="varchar(25)";
			$this->nullable["login_password"]="NO";
			$this->default_value["login_password"]="";
			$this->fields["email"]="varchar(150)";
			$this->nullable["email"]="NO";
			$this->default_value["email"]="";
			$this->fields["phone"]="varchar(100)";
			$this->nullable["phone"]="NO";
			$this->default_value["phone"]="";
			$this->fields["status"]="enum('Active','Inactive','Trash')";
			$this->nullable["status"]="NO";
			$this->default_value["status"]="Active";
			$this->fields["date"]="varchar(255)";
			$this->nullable["date"]="NO";
			$this->default_value["date"]="";
		}
	}
?>