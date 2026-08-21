<?php
	class model_fellowship_leaderboards{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_fellowship_leaderboards($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="bigint(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["fellowship_master_id"]="int(11)";
			$this->nullable["fellowship_master_id"]="NO";
			$this->default_value["fellowship_master_id"]="";
			$this->fields["user_id"]="bigint(11)";
			$this->nullable["user_id"]="NO";
			$this->default_value["user_id"]="";
			$this->fields["category"]="enum('Platinum','Gold','Silver')";
			$this->nullable["category"]="YES";
			$this->default_value["category"]="Platinum";
			$this->fields["profile_url"]="varchar(255)";
			$this->nullable["profile_url"]="NO";
			$this->default_value["profile_url"]="";
			$this->fields["name"]="varchar(255)";
			$this->nullable["name"]="NO";
			$this->default_value["name"]="";
			$this->fields["college_name"]="varchar(255)";
			$this->nullable["college_name"]="NO";
			$this->default_value["college_name"]="";
			$this->fields["location"]="varchar(255)";
			$this->nullable["location"]="NO";
			$this->default_value["location"]="";
			$this->fields["sort_order"]="int(11)";
			$this->nullable["sort_order"]="NO";
			$this->default_value["sort_order"]="";
			$this->fields["created_at"]="varchar(100)";
			$this->nullable["created_at"]="YES";
			$this->default_value["created_at"]="";
			$this->fields["updated_at"]="varchar(100)";
			$this->nullable["updated_at"]="YES";
			$this->default_value["updated_at"]="";
		}
	}
?>