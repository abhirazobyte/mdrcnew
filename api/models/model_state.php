<?php
	class model_state{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_state($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["api_state_id"]="int(11)";
			$this->nullable["api_state_id"]="NO";
			$this->default_value["api_state_id"]="";
			$this->fields["name"]="varchar(100)";
			$this->nullable["name"]="NO";
			$this->default_value["name"]="";
			$this->fields["sort_order"]="int(11)";
			$this->nullable["sort_order"]="NO";
			$this->default_value["sort_order"]="";
			$this->fields["entry_date_time"]="varchar(50)";
			$this->nullable["entry_date_time"]="NO";
			$this->default_value["entry_date_time"]="";
			$this->fields["status"]="enum('Active','Inactive','Trash')";
			$this->nullable["status"]="NO";
			$this->default_value["status"]="Active";
		}
	}
?>