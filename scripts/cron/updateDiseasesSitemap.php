<?php
include("../../core/app.php");
$app = &app::get_instance();
$app->initialize();

$day_pre=0;
$today=date('d-m-Y');
$start_date1 = strtotime($today);
$date=date("d-m-Y", strtotime("- ".$day_pre." day",$start_date1));

$url='https://www.mdrcindia.com/';

$obj_model_tabel=$app->load_model("city");
$city=$obj_model_tabel->execute("SELECT",false,"","status='Active'","sort_order ASC");

$obj_model_category=$app->load_model("item_diseases");
$item_diseases=$obj_model_category->execute("SELECT",false,"","status='Active'","sort_order ASC");
	
$today_date=date('Y-m-d');

$xmlString = '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

for($i=0;$i<count($city);$i++)
{
	$citySlug=$city[$i]['slug'];
	for($j=0;$j<count($item_diseases);$j++)
	{
		$ItemDiseasesSlug=$item_diseases[$j]['slug'];
		$xmlString.='
<url><loc>'.$url.'diseases/'.$citySlug.'/'.$ItemDiseasesSlug.'</loc><priority>0.9</priority><changefreq>weekly</changefreq></url>
		';
	}
}

$xmlString.='
</urlset>';
$dom = new DOMDocument;
$dom->preserveWhiteSpace = true;
$dom->loadXML($xmlString);

//Save XML as a file
$dom->save('../../sitemap/diseases-sitemap.xml');
?>