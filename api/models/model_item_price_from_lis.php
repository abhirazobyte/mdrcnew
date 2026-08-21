<?php
	class model_item_price_from_lis{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_item_price_from_lis($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";

			$this->fields["api_center_id"]="int(11)";
			$this->nullable["api_center_id"]="NO";
			$this->default_value["api_center_id"]="";

			$this->fields["item_id"]="varchar(255)";
			$this->nullable["item_id"]="NO";
			$this->default_value["item_id"]="";

			$this->fields["api_city_id"]="varchar(255)";
			$this->nullable["api_city_id"]="NO";
			$this->default_value["api_city_id"]="";

			$this->fields["Rate"]="varchar(100)";
			$this->nullable["Rate"]="NO";
			$this->default_value["Rate"]="";

			$this->fields["ScheduleRate"]="varchar(100)";
			$this->nullable["ScheduleRate"]="NO";
			$this->default_value["ScheduleRate"]="No";

			$this->fields["fromDate"]="varchar(100)";
			$this->nullable["fromDate"]="NO";
			$this->default_value["fromDate"]="No";

			$this->fields["toDate"]="varchar(100)";
			$this->nullable["toDate"]="NO";
			$this->default_value["toDate"]="No";

		}
	}
?>