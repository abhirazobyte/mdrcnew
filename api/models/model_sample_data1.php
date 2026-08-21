<?php
	class model_sample_data1{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_sample_data1($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["user_id"]="int(11)";
			$this->nullable["user_id"]="NO";
			$this->default_value["user_id"]="";
			$this->fields["category"]="varchar(255)";
			$this->nullable["category"]="NO";
			$this->default_value["category"]="";
		}
	}
?>