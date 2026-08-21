<?php
include("../../core/app.php");
$app = &app::get_instance();
$app->initialize();

$day_pre=0;
$today=date('d-m-Y');
$start_date1 = strtotime($today);
$date=date("d-m-Y", strtotime("- ".$day_pre." day",$start_date1));

$url='https://www.mdrcindia.com/';

$obj_model_tabel=$app->load_model("blog");
$blog=$obj_model_tabel->execute("SELECT",false,"","status='Active'","sort_order ASC");


$today_date=date('Y-m-d');

$xmlString = '<?xml version="1.0" encoding="UTF-8"?>
<urlset>';

$xmlString.='
<url><loc>https://www.mdrcindia.com/blog</loc><priority>0.9</priority><changefreq>weekly</changefreq></url>
';
for($i=0;$i<count($blog);$i++)
{
	$slug=$blog[$i]['slug'];
	$xmlString.='
<url><loc>'.$url.'blog/detail/'.$slug.'</loc><priority>0.9</priority><changefreq>weekly</changefreq></url>
	';
	
}

$xmlString.='
</urlset>';
$dom = new DOMDocument;
$dom->preserveWhiteSpace = true;
$dom->loadXML($xmlString);

//Save XML as a file
$dom->save('../../blogs-sitemap.xml');
?>