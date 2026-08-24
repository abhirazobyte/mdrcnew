<?php
class _download_report extends controller
{
    function init() {}

    function onload()
    {
        $conn = $this->app->set_db_conn();

        $message = [
            "message" => "Visitor ID and Password are required",
            "msgCode" => "0",
            "data"    => []
        ];

        $visitor_id   = mysqli_real_escape_string($conn, $this->app->getPostVar('visitor_id'));
        $lab_password = mysqli_real_escape_string($conn, $this->app->getPostVar('lab_password'));

        if (!empty($visitor_id) && !empty($lab_password)) {
            $message = [
                "message" => mdrc_staging_disabled_message(),
                "msgCode" => "0",
                "data"    => []
            ];
        }

        echo $this->app->utility->indent(
            json_encode($message, JSON_UNESCAPED_UNICODE)
        );
        exit;
    }
}
