<?php
	class model_landing_lead{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_landing_lead($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";

			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";

			$this->fields["lead_id"]="varchar(255)";
			$this->nullable["lead_id"]="NO";
			$this->default_value["lead_id"]="NULL";

			$this->fields["related_id"]="varchar(255)";
			$this->nullable["related_id"]="NO";
			$this->default_value["related_id"]="NULL";

			$this->fields["name"]="varchar(255)";
			$this->nullable["name"]="NO";
			$this->default_value["name"]="";

			$this->fields["mobile"]="varchar(255)";
			$this->nullable["mobile"]="NO";
			$this->default_value["mobile"]="";

			$this->fields["city"]="varchar(255)";
			$this->nullable["city"]="NO";
			$this->default_value["city"]="";

			$this->fields["url"]="varchar(255)";
			$this->nullable["url"]="NO";
			$this->default_value["url"]="";

			$this->fields["utm"]="varchar(255)";
			$this->nullable["utm"]="NO";
			$this->default_value["utm"]="";

			$this->fields["source"]="varchar(255)";
			$this->nullable["source"]="NO";
			$this->default_value["source"]="";

			$this->fields["mx_gclid"]="varchar(255)";
			$this->nullable["mx_gclid"]="NO";
			$this->default_value["mx_gclid"]="";

			$this->fields["mx_fbclid"]="varchar(255)";
			$this->nullable["mx_fbclid"]="NO";
			$this->default_value["mx_fbclid"]="";

			$this->fields["mx_ad_name"]="varchar(255)";
			$this->nullable["mx_ad_name"]="NO";
			$this->default_value["mx_ad_name"]="";

			$this->fields["mx_ad_set"]="varchar(255)";
			$this->nullable["mx_ad_set"]="NO";
			$this->default_value["mx_ad_set"]="";

			$this->fields["lead_convert"]="enum('Yes','No')";
			$this->nullable["lead_convert"]="NO";
			$this->default_value["lead_convert"]="No";

			$this->fields["lead_convert_at"]="datetime";
			$this->nullable["lead_convert_at"]="Yes";
			$this->default_value["lead_convert_at"]="NULL";

			$this->fields["mx_campaign_name"]="varchar(255)";
			$this->nullable["mx_campaign_name"]="NO";
			$this->default_value["mx_campaign_name"]="";

			$this->fields["promo_code"]="varchar(255)";
			$this->nullable["promo_code"]="NO";
			$this->default_value["promo_code"]="";
		}
	}
?>