<?
	if(isset($_REQUEST["img"])){
		require_once("../../core/app.php");
		require_once("../../core/image_sizer.php");
		
		$image_path = $_REQUEST["img"];
		
		if($image_path!=""){
			$imgprocessor = new ImageSizer(dirname($image_path)."/");
			$imgprocessor->loadImage(basename($image_path));
			if($app->getGetVar("enlarge")!=""){
				$imgprocessor->dontMakeBigger=true;
			}else{
				$imgprocessor->dontMakeBigger=false;
			}
			$imgprocessor->keepAspectRatio=true;
			$imgprocessor->resizeImage($app->getGetVar("w"), $app->getGetVar("h"));
			$imgprocessor->showImage();
		}
	}
?>