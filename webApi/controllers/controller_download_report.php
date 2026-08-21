<?php
class _download_report extends controller
{
    function init() {}

    function onload()
    {
        $conn = $this->app->set_db_conn();

        // Default response
        $message = [
            "message" => "Visitor ID and Password are required",
            "msgCode" => "0",
            "data"    => []
        ];

        // Get POST variables
        $visitor_id   = mysqli_real_escape_string($conn, $this->app->getPostVar('visitor_id'));
        $lab_password = mysqli_real_escape_string($conn, $this->app->getPostVar('lab_password'));

        if (!empty($visitor_id) && !empty($lab_password)) {

            /* ===== Call LIS API ===== */
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => LIS_API_URL . '/BookingAPI/TestStatusAPI',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => http_build_query([
                    "WorkOrderID" => $visitor_id
                ]),
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/x-www-form-urlencoded'
                ],
            ]);

            $response = curl_exec($curl);
            curl_close($curl);

            $api_response = $response ? json_decode($response, true) : [];

            /* ===== Validate Visitor ID ===== */
            if (empty($api_response) || empty($api_response[0]['Booking_Status'])) {

                $message = [
                    "message" => "Invalid visitor ID or no record found",
                    "msgCode" => "0",
                    "data"    => []
                ];

            } else {

                /* ===== Password Check (EXACT LOGIC) ===== */
                $PMPassword_webob = $api_response[0]['Password_web'];

                if ($lab_password != $PMPassword_webob) {

                    $message = [
                        "message" => "Please enter valid details.",
                        "msgCode" => "0",
                        "data"    => []
                    ];

                } else {

                    /* ===== Prepare Report Data ===== */
                    $report_ready = false;
                    $tests = [];

                    foreach ($api_response as $row) {

                        if (in_array($row['Booking_Status'], [
                            'Report Ready',
                            'Dispatched',
                            'Printed'
                        ])) {
                            $report_ready = true;
                            $status_name = 'Report Ready';

                        } elseif (in_array($row['Booking_Status'], [
                            'Sample Receive At Lab',
                            'Rejected Test',
                            'Sample Collected',
                            'Tested',
                            'Hold'
                        ])) {
                            $status_name = 'Received in lab';

                        } else {
                            $status_name = $row['Booking_Status'];
                        }

                        $tests[] = [
                            "item_name" => $row['ItemName'],
                            "status"    => $status_name
                        ];
                    }

                    $data = [
                        "patient" => [
                            "name"         => $api_response[0]['PName'],
                            "mobile"       => $api_response[0]['PMob'],
                            "booking_date" => $api_response[0]['EntryDate'],
                        ],
                        "report_ready" => $report_ready,
                        "tests"        => $tests
                    ];

                    if ($report_ready) {
                        $data["download_url"] =
                            "http://182.156.200.228/mdrcnew/Design/Lab/labreportnew.aspx?page=new&reportid="
                            . $visitor_id . "_" . $lab_password;
                    }

                    $message = [
                        "message" => $report_ready ? "Report ready" : "Report not ready",
                        "msgCode" => $report_ready ? "1" : "2",
                        "data"    => $data
                    ];
                }
            }
        }

        /* ===== Single Response Output ===== */
        echo $this->app->utility->indent(
            json_encode($message, JSON_UNESCAPED_UNICODE)
        );
        exit;
    }
}
