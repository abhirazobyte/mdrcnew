<?php
include("core/app.php");
$app = &app::get_instance();
$app->objDB->setPagingStyle("paging_link", "paging_nolink", "paging_selected");
$app->execute();
$app->unload();
?>