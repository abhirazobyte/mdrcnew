<?php
	class model_event_gallery{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_event_gallery($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["event_id"]="int(11)";
			$this->nullable["event_id"]="NO";
			$this->default_value["event_id"]="";
			$this->fields["folder"]="varchar(255)";
			$this->nullable["folder"]="NO";
			$this->default_value["folder"]="";
			$this->fields["image"]="varchar(255)";
			$this->nullable["image"]="NO";
			$this->default_value["image"]="";
			$this->fields["status"]="enum('Active','Inactive')";
			$this->nullable["status"]="NO";
			$this->default_value["status"]="Active";
		}
	}
?>