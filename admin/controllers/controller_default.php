<?php
	class _default extends controller
	{
		function init()
		{
		}
		
		function onload()
		{
			
			//check if cookie is set or not
			if(isset($_COOKIE['Grocery']))
			{
				
				
				/*  $obj_model_admin = $this->app->load_model("admin");
				 $rsUser = $obj_model_admin->execute("SELECT",false,"","phone='".$_COOKIE['Grocery']."' or email='".$_COOKIE['Grocery']."' and status='Active'");
				
				 if(count($rsUser)==1)
				 {
					$_SESSION['admin'] = $rsUser[0]['id'];
					$_SESSION['adminName'] = $rsUser[0]['login_username'];
					$this->app->redirect("index.php?view=home");	
				 }
				 else
				 {
					unset($_SESSION['admin']);
					unset($_SESSION['adminName']);
					unset($_COOKIE['Grocery']);
					$this->app->utility->set_message("You have successfully logged out of the system", "SUCCESS");
					$this->app->redirect("index.php");
				 } */
			}
		}

	}	

?>