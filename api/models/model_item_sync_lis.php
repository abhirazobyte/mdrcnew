<?php
	class model_item_sync_lis{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_item_sync_lis($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";

			$this->fields["column_names"]="text()";
			$this->nullable["column_names"]="NO";
			$this->default_value["column_names"]="";
		}
	}
?>