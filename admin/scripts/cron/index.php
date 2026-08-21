<?
	set_time_limit(0);
	define("VIR_DIR","scripts/cron/");
	if($argc>1){
		$URL = SERVER_ROOT."/admin/scripts/cron/?method=".$argv[1];
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $URL);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 300);
		curl_setopt($ch, CURLOPT_POST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
		$content = curl_exec($ch);
		curl_close($ch);
	}else{
		include("../../../core/app.php");
		$app = new app();
		if($app->domSecure->isReferrerSecured){
			$method = $app->getPostVar("method");
			if($method!=""){
				if(file_exists($method.".php")){
					include($method.".php");
				}
			}
		}
		$app->unload();
	}	
?>