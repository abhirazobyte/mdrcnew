<?
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Credentials: true");

define("VIR_DIR", "webApi/");
include("../core/app.php");
$app = &app::get_instance();
$app->objDB->setPagingStyle("paging_link", "paging_nolink", "paging_selected");
$app->execute();
$app->unload();
?>