<?

define("VIR_DIR","scripts/LeadSquare/");
include("../../core/app.php");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
$app = & app::get_instance();
$app->initialize();
echo mdrc_staging_disabled_message();
exit;
?>
