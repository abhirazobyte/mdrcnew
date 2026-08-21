<?php
	class model_timing_settings{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_timing_settings($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["start_time"]="varchar(50)";
			$this->nullable["start_time"]="NO";
			$this->default_value["start_time"]="";
			$this->fields["end_time"]="varchar(50)";
			$this->nullable["end_time"]="NO";
			$this->default_value["end_time"]="";
			$this->fields["slot"]="int(11)";
			$this->nullable["slot"]="NO";
			$this->default_value["slot"]="";
			$this->fields["type"]="varchar(100)";
			$this->nullable["type"]="NO";
			$this->default_value["type"]="";
		}
	}
?>