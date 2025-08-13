<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once FCPATH . 'vendor/autoload.php'; // Load Composer's autoloader

use RingCentral\SDK\SDK;

class Call_logs extends MY_Controller {

    private $clientId = '3Y0M0cCINCYbUyNz5AD0Oi';
    private $clientSecret = '6GGsEyX9xPJfYLiCSsaDrI8Bj5zZqi7KabwSDUkpUEpQ';
    private $serverUrl = 'https://platform.ringcentral.com';
    private $JWT_TOKEN = 'eyJraWQiOiI4NzYyZjU5OGQwNTk0NGRiODZiZjVjYTk3ODA0NzYwOCIsInR5cCI6IkpXVCIsImFsZyI6IlJTMjU2In0.eyJhdWQiOiJodHRwczovL3BsYXRmb3JtLnJpbmdjZW50cmFsLmNvbS9yZXN0YXBpL29hdXRoL3Rva2VuIiwic3ViIjoiNjMwMDM2NTgwMDgiLCJpc3MiOiJodHRwczovL3BsYXRmb3JtLnJpbmdjZW50cmFsLmNvbSIsImV4cCI6Mzg4MTU5MTI3NCwiaWF0IjoxNzM0MTA3NjI3LCJqdGkiOiJUSlJ2VkxfR1FpR0JiWjFObDVPT3d3In0.cthZiJwbodG33KoJcb5m2h4XN40ls1r__oBXahlQm_N5ky5vCIlwYeidsz6PC7PVsSM1ITY2W_urbQEppdAOPBYfY3_jHjWl5entOIQluesrs2PNk-uExoCU5cU_2vuZKsiRLb7fqju_t35GTMQptml3cTcRQCW-UPqiM3luBgA1-BvxPcFzG33zfLyBXHwM0UDjSjHH7U_gZu3yiQEoZcrJiJKnReh6QtemyB8sTLy1uXEQk4hg9Optt8Gsu4dADuoY-6cvbfB5kEEMLD5P-xgUjISeTMgl58jSxxRTR34tyO_NeQxt_rlUVuqTgUJ-MMmEl3Uejw49JMGT2YbzeA';

    private $platform;

    public function __construct() {
        parent::__construct();
        $sdk = new SDK($this->clientId, $this->clientSecret, $this->serverUrl);
        $this->platform = $sdk->platform();
        $this->platform->login(["jwt" => $this->JWT_TOKEN]);
    }
    public function index() {
        date_default_timezone_set('America/New_York');
        $records['agent_users'] = $this->User_Model->view_account_sales_and_leadgen();
        $this->load->view('layout/head');
		$this->load->view('layout/header');
		$this->load->view('layout/nav');
		$this->load->view('call_logs', $records);
		$this->load->view('layout/footer');
    
}
public function fetch_call_logs_data() {
    $fromDate = new DateTime($this->input->post('from_date'), new DateTimeZone('America/New_York'));
    $toDate = new DateTime($this->input->post('to_date'), new DateTimeZone('America/New_York'));

    // Set the time to the start and end of the day
    $fromDate->setTime(0, 0, 0);
    $toDate->setTime(23, 59, 59);

    $formattedFromDate = $fromDate->format(DateTime::RFC3339);
    $formattedToDate = $toDate->format(DateTime::RFC3339);
    $phonenumber = $this->input->post('phonenumber');
    $yesterdayStart = (new DateTime('yesterday'))->setTime(0, 0, 0)->format(DateTime::ATOM);
    $yesterdayEnd = (new DateTime('yesterday'))->setTime(23, 59, 59)->format(DateTime::ATOM);

    try {
        $response = $this->platform->get('/account/~/call-log', [
            'phoneNumber' => $phonenumber,
            'dateFrom' => $formattedFromDate,
            'dateTo' => $formattedToDate,
            'viewDetails' => true,
            'perPage' => 10000,
        ]);

        $call_logs = $response->json();
        $data = $this->processCallLogs($call_logs->records);
        echo json_encode(['data' => $data]);
    } catch (\RingCentral\SDK\Http\ApiException $e) {
        if ($e->getCode() === 4291) { // 4291 = Too Many Requests
            $retryAfter = $e->response()->getHeader('Retry-After')[0] ?? 60; // Default to 60 seconds if missing
            sleep((int)$retryAfter);
            $response = $this->platform->get('/account/~/call-log', [
                'phoneNumber' => $phonenumber,
                'dateFrom' => $formattedFromDate,
                'dateTo' => $formattedToDate,
                'viewDetails' => true,
                'perPage' => 10000,
            ]);
            $call_logs = $response->json();
            $data = $this->processCallLogs($call_logs->records);
            echo json_encode(['data' => $data]);
        } else {
            // Handle other exceptions
            log_message('error', 'API Exception: ' . $e->getMessage());
            echo json_encode(['error' => 'An error occurred while fetching call logs.']);
        }
    }
}

private function processCallLogs($records) {
    $data = [];
    foreach ($records as $log) {
        if (!in_array($log->result, ['Missed'])  && ($log->direction != 'Inbound' || $log->duration >=1800)) {
            $recording = isset($log->recording) ? $log->recording->id : null;
            $data[] = [
                'from_number' => $log->from->phoneNumber ?? "Unknown",
                'to_number' => $log->to->phoneNumber ?? "Unknown",
                'action' => $log->action,
                'result' => $log->result,
                'startime' => $log->startTime,
                'duration' => $log->duration,
                'recording' => $recording,
            ];
        }
    }
    return $data;
}

  

    public function fetch_audio($id) {

        try {
            $response = $this->platform->get("/account/~/recording/$id/content");
            header('Content-Type: ' . $response->response()->getHeaderLine('Content-Type'));
            echo $response->text();
    
        } catch (\RingCentral\SDK\Http\ApiException $e) {
            if ($e->getCode() == 4291) {

                $retryAfter = $e->response()->getHeader('Retry-After')[0] ?? 60; // Default to 60 seconds if missing
                sleep((int)$retryAfter);
         
                $response = $this->platform->get("/account/~/recording/$id/content");
                header('Content-Type: ' . $response->response()->getHeaderLine('Content-Type'));
                echo $response->text();
        

            }
        }
    }
}
