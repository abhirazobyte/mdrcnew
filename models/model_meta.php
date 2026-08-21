<?php
	class model_meta{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_meta($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["title"]="varchar(500)";
			$this->nullable["title"]="NO";
			$this->default_value["title"]="";
			$this->fields["keyword"]="text";
			$this->nullable["keyword"]="NO";
			$this->default_value["keyword"]="";
			$this->fields["description"]="text";
			$this->nullable["description"]="NO";
			$this->default_value["description"]="";
		}
	}
?>