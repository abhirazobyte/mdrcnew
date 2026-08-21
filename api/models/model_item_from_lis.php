<?php
	class model_item_from_lis{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_item_from_lis($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";

			$this->fields["center_id"]="int(11)";
			$this->nullable["center_id"]="NO";
			$this->default_value["center_id"]="";

			$this->fields["itemid"]="varchar(255)";
			$this->nullable["itemid"]="NO";
			$this->default_value["itemid"]="";

			$this->fields["itemname"]="varchar(255)";
			$this->nullable["itemname"]="NO";
			$this->default_value["itemname"]="";

			$this->fields["itemcode"]="varchar(255)";
			$this->nullable["itemcode"]="NO";
			$this->default_value["itemcode"]="";

			$this->fields["FromAgeInDays"]="varchar(255)";
			$this->nullable["FromAgeInDays"]="NO";
			$this->default_value["FromAgeInDays"]="";

			$this->fields["ToAgeInDays"]="varchar(100)";
			$this->nullable["ToAgeInDays"]="NO";
			$this->default_value["ToAgeInDays"]="";

			$this->fields["Gender"]="varchar(100)";
			$this->nullable["Gender"]="NO";
			$this->default_value["Gender"]="";

			$this->fields["LabName"]="varchar(50)";
			$this->nullable["LabName"]="NO";
			$this->default_value["LabName"]="";

			$this->fields["LabCode"]="varchar(255)";
			$this->nullable["LabCode"]="NO";
			$this->default_value["LabCode"]="";

			$this->fields["LabID"]="varchar(255)";
			$this->nullable["LabID"]="NO";
			$this->default_value["LabID"]="";

			$this->fields["Rate"]="varchar(100)";
			$this->nullable["Rate"]="NO";
			$this->default_value["Rate"]="";

			$this->fields["subcategoryid"]="varchar(50)";
			$this->nullable["subcategoryid"]="NO";
			$this->default_value["subcategoryid"]="";

			$this->fields["DepartmentName"]="varchar(100)";
			$this->nullable["DepartmentName"]="NO";
			$this->default_value["DepartmentName"]="";
			
			$this->fields["ItemType"]="varchar(100)";
			$this->nullable["ItemType"]="NO";
			$this->default_value["ItemType"]="";

			$this->fields["TestCount"]="int(11)";
			$this->nullable["TestCount"]="NO";
			$this->default_value["TestCount"]="";

			$this->fields["ParameterCount"]="int(11)";
			$this->nullable["ParameterCount"]="NO";
			$this->default_value["ParameterCount"]="";

			$this->fields["ScheduleRate"]="varchar(100)";
			$this->nullable["ScheduleRate"]="NO";
			$this->default_value["ScheduleRate"]="No";

			$this->fields["fromDate"]="varchar(100)";
			$this->nullable["fromDate"]="NO";
			$this->default_value["fromDate"]="No";

			$this->fields["toDate"]="varchar(100)";
			$this->nullable["toDate"]="NO";
			$this->default_value["toDate"]="No";

			$this->fields["DiscountApplicable"]="varchar(100)";
			$this->nullable["DiscountApplicable"]="NO";
			$this->default_value["DiscountApplicable"]="";

			$this->fields["status"]="enum('Active','Inactive')";
			$this->nullable["DiscountApplicable"]="NO";
			$this->default_value["DiscountApplicable"]="";
		}
	}
?>