<?php
	class model_push_notification{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_push_notification($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["title"]="varchar(255)";
			$this->nullable["title"]="NO";
			$this->default_value["title"]="";
			$this->fields["message"]="text";
			$this->nullable["message"]="NO";
			$this->default_value["message"]="";
			$this->fields["image"]="varchar(255)";
			$this->nullable["image"]="NO";
			$this->default_value["image"]="";
			$this->fields["item_id"]="int(11)";
			$this->nullable["item_id"]="NO";
			$this->default_value["item_id"]="";
			$this->fields["type"]="varchar(255)";
			$this->nullable["type"]="NO";
			$this->default_value["type"]="";
			$this->fields["search_id"]="int(11)";
			$this->nullable["search_id"]="NO";
			$this->default_value["search_id"]="";
			$this->fields["added_on"]="datetime";
			$this->nullable["added_on"]="NO";
			$this->default_value["added_on"]="";
		}
	}
?>