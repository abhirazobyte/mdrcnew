<?php
	class model_job_opning_inq{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_job_opning_inq($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["name"]="varchar(255)";
			$this->nullable["name"]="NO";
			$this->default_value["name"]="";
			$this->fields["phone"]="varchar(255)";
			$this->nullable["phone"]="NO";
			$this->default_value["phone"]="";
			$this->fields["email"]="varchar(255)";
			$this->nullable["email"]="NO";
			$this->default_value["email"]="";
			$this->fields["notice_period"]="varchar(255)";
			$this->nullable["notice_period"]="YES";
			$this->default_value["notice_period"]="";
			$this->fields["designation"]="varchar(255)";
			$this->nullable["designation"]="YES";
			$this->default_value["designation"]="";
			$this->fields["current_organization"]="varchar(255)";
			$this->nullable["current_organization"]="YES";
			$this->default_value["current_organization"]="";
			$this->fields["experience"]="varchar(255)";
			$this->nullable["experience"]="YES";
			$this->default_value["experience"]="";
			$this->fields["address"]="text";
			$this->nullable["address"]="YES";
			$this->default_value["address"]="";
			$this->fields["cv_file"]="varchar(255)";
			$this->nullable["cv_file"]="YES";
			$this->default_value["cv_file"]="";
			$this->fields["added_date"]="varchar(255)";
			$this->nullable["added_date"]="YES";
			$this->default_value["added_date"]="";
			$this->fields["ip"]="varchar(255)";
			$this->nullable["ip"]="YES";
			$this->default_value["ip"]="";
			$this->fields["user_id"]="int(11)";
			$this->nullable["user_id"]="YES";
			$this->default_value["user_id"]="";
			$this->fields["job_opening_id"]="int(11)";
			$this->nullable["job_opening_id"]="NO";
			$this->default_value["job_opening_id"]="";
		}
	}
?>