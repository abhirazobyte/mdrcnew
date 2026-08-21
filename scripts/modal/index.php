<?
	define("VIR_DIR","scripts/modal/");
	include("../../core/app.php");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	
	$app = & app::get_instance();
	$app->initialize();

	if($app->domSecure->isReferrerSecured){
		$method = $app->getPostVar("method");
			$method2 = $app->getGetVar("method");
		if($method!=""){
			if(file_exists($method.".php")){
				include($method.".php");
			}
		}
		if($method2!=""){
			if(file_exists($method2.".php")){
				include($method2.".php");
			}
		}
	}
	
	$app->unload();
?>