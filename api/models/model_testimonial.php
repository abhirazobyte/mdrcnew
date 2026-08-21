<?php
	class model_testimonial{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_testimonial($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["name"]="varchar(255)";
			$this->nullable["name"]="NO";
			$this->default_value["name"]="";
			$this->fields["ratting"]="float(9,1)";
			$this->nullable["ratting"]="NO";
			$this->default_value["ratting"]="";
			$this->fields["city"]="varchar(100)";
			$this->nullable["city"]="NO";
			$this->default_value["city"]="";
			$this->fields["image"]="varchar(255)";
			$this->nullable["image"]="NO";
			$this->default_value["image"]="";
			$this->fields["content"]="text";
			$this->nullable["content"]="NO";
			$this->default_value["content"]="";
			$this->fields["sort_id"]="int(11)";
			$this->nullable["sort_id"]="NO";
			$this->default_value["sort_id"]="";
			$this->fields["status"]="varchar(100)";
			$this->nullable["status"]="NO";
			$this->default_value["status"]="";
			$this->fields["added_on"]="varchar(100)";
			$this->nullable["added_on"]="NO";
			$this->default_value["added_on"]="";
		}
	}
?>