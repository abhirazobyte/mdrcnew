<?
class _logout extends controller
{
	function init()
	{
	}

	function onload()
	{
		
		$_SESSION['MDRCCustID']='';
		$_SESSION['MDRCCustFirstName']='';
		$_SESSION['MDRCCustLastName']='';
		$_SESSION['MDRCCustEmail']='';
		$_SESSION['MDRCCustPhone']='';
		$_SESSION['MDRCCustImage']='';
		$_SESSION['MDRCCustWallet']='';
		setcookie('MDRCToken', '', -1, "/");
		
		$this->app->redirect(M_SERVER_ROOT);	
		exit;
		
	}
}
?>