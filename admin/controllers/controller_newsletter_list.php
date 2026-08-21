<?php
class _newsletter_list extends controller
{
	function init()
	{
		if($this->app->getCurrentAction()=="")
		{
			$this->load_data();
		}
	}

	function onload()
	{
	}	
		
	function load_data()
	{
	}	
	
	function export_data()

		{

			

		 

		

		

		$this->app->no_html=true;

		$obj_excel = $this->app->load_module("PHPExcel");

		$ExeclHeads=array("Sr","Email","Date");

		

		$obj_model_society_user = $this->app->load_model("newsletter_receiver");
		//$obj_model_society_user->join_table("zone", "left", array("name"), array("zone_id"=>"id"));
		//$obj_model_society_user->join_table("city", "left", array("name"), array("city_id"=>"id"));
		$rs_user=$obj_model_society_user->execute("SELECT", false, "","","newsletter_receiver.id ASC");

		

		$ucount=1;

		foreach($rs_user as $user)

		{

			

			

			

			

			

			$user_array[]=array("Sr"=>$ucount,"Email"=>$user['email'],"Date"=>$user['registration_date']);

			$ucount++;

		}



		$ftype_prompt_title="";

		$ftype_prompt="";

		

		$array_field=array(

		"block_name"=>array("options"=>$block_options,"prompt_title"=>$block_prompt_title,"prompt"=>$block_prompt),

		

		"flat_type"=>array("options"=>"","prompt_title"=>"","prompt"=>""),

		

		"resident_type"=>array("options"=>'',"prompt_title"=>"","prompt"=>"")

		);

		

		$data_array=$user_array;

		

		

		$fields=array("Sr","Email","Date");

		$filename="Subscriber - ".date('d-m-Y H:i:s');

		

		$this->app->utility->export_excel($ExeclHeads,$data_array,$fields,$filename,$array_field);

		

		

		//$this->app->redirect("index.php?pg_no=".$this->app->getPostVar('page_no')."&view=general_data_list");



		

		}
}	
?>