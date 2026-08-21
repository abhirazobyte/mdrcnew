<?php
	class model_newsletter_receiver{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_newsletter_receiver($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["email"]="varchar(250)";
			$this->nullable["email"]="NO";
			$this->default_value["email"]="";
			$this->fields["registration_date"]="date";
			$this->nullable["registration_date"]="NO";
			$this->default_value["registration_date"]="";
		}
	}
?>