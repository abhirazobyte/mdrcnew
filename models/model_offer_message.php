<?php
	class model_offer_message{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_offer_message($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["message_text"]="varchar(255)";
			$this->nullable["message_text"]="NO";
			$this->default_value["message_text"]="";
			$this->fields["popup_type"]="varchar(100)";
			$this->nullable["popup_type"]="NO";
			$this->default_value["popup_type"]="";
			$this->fields["image"]="varchar(255)";
			$this->nullable["image"]="NO";
			$this->default_value["image"]="";
			$this->fields["link"]="varchar(255)";
			$this->nullable["link"]="NO";
			$this->default_value["link"]="";
			$this->fields["description"]="text";
			$this->nullable["description"]="NO";
			$this->default_value["description"]="";
			$this->fields["status"]="varchar(100)";
			$this->nullable["status"]="NO";
			$this->default_value["status"]="";
			$this->fields["sort_order"]="int(11)";
			$this->nullable["sort_order"]="NO";
			$this->default_value["sort_order"]="";
			$this->fields["added_on"]="varchar(100)";
			$this->nullable["added_on"]="NO";
			$this->default_value["added_on"]="";
			$this->fields["page_types"]="varchar(100)";
			$this->nullable["page_types"]="NO";
			$this->default_value["page_types"]="";
			$this->fields["start_date"]="varchar(100)";
			$this->nullable["start_date"]="NO";
			$this->default_value["start_date"]="";
			$this->fields["end_date"]="varchar(100)";
			$this->nullable["end_date"]="NO";
			$this->default_value["end_date"]="";
			$this->fields["start_time"]="varchar(100)";
			$this->nullable["start_time"]="NO";
			$this->default_value["start_time"]="";
			$this->fields["end_time"]="varchar(100)";
			$this->nullable["end_time"]="NO";
			$this->default_value["end_time"]="";
		}
	}
?>