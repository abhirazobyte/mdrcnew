<?php
	class model_zipcode{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_zipcode($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["state_id"]="int(11)";
			$this->nullable["state_id"]="NO";
			$this->default_value["state_id"]="";
			$this->fields["name"]="varchar(50)";
			$this->nullable["name"]="NO";
			$this->default_value["name"]="";
			$this->fields["ship_charge_per_kg"]="float(9,2)";
			$this->nullable["ship_charge_per_kg"]="NO";
			$this->default_value["ship_charge_per_kg"]="";
			$this->fields["status"]="enum('Active','Inactive','Trash')";
			$this->nullable["status"]="NO";
			$this->default_value["status"]="Active";
			$this->fields["cod_availabel"]="enum('Yes','No')";
			$this->nullable["cod_availabel"]="NO";
			$this->default_value["cod_availabel"]="Yes";
		}
	}
?>