<?php
include("../../core/app.php");
$app = &app::get_instance();
$app->initialize();

$day_pre=0;
$today=date('d-m-Y');
$start_date1 = strtotime($today);
$date=date("d-m-Y", strtotime("- ".$day_pre." day",$start_date1));

$url='https://www.mdrcindia.com/';

$obj_model_for_doctors=$app->load_model("for_doctors");
$for_doctors=$obj_model_for_doctors->execute("SELECT",false,"","status='Active'","sort_order ASC");
	
$today_date=date('Y-m-d');

$xmlString = '<?xml version="1.0" encoding="UTF-8"?>
<urlset>';

for($i=0;$i<count($for_doctors);$i++)
{
	$xmlString.='
<url><loc>'.$url.$for_doctors[$i]['slug'].'</loc><priority>0.9</priority><changefreq>weekly</changefreq></url>
';

	$obj_model_for_doctors_services=$app->load_model("for_doctors_services");
	$for_doctors_services=$obj_model_for_doctors_services->execute("SELECT",false,"","for_doctors_id='".$for_doctors[$i]['id']."' and status='Active'","sort_order ASC");

	for($j=0;$j<count($for_doctors_services);$j++)
	{
		$xmlString.='
<url><loc>'.$url.'service/'.$for_doctors[$i]['slug'].'/'.$for_doctors_services[$j]['slug'].'</loc><priority>0.9</priority><changefreq>weekly</changefreq></url>
		';
	}
}

$xmlString.='
</urlset>';
$dom = new DOMDocument;
$dom->preserveWhiteSpace = true;
$dom->loadXML($xmlString);

//Save XML as a file
$dom->save('../../for-doctors-sitemap.xml');
?>