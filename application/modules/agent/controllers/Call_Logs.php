<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// use RingCentral\SDK\RCClient;
// use RingCentral\SDK\OAuth\OAuth;
require_once FCPATH . 'vendor/autoload.php'; // Load Composer's autoloader

use RingCentral\SDK\SDK;


class Ringcentral extends MY_Controller {

    private $clientId = '3Y0M0cCINCYbUyNz5AD0Oi';
    private $clientSecret = '6GGsEyX9xPJfYLiCSsaDrI8Bj5zZqi7KabwSDUkpUEpQ';
    private $serverUrl = 'https://platform.ringcentral.com';
    private $JWT_TOKEN = 'eyJraWQiOiI4NzYyZjU5OGQwNTk0NGRiODZiZjVjYTk3ODA0NzYwOCIsInR5cCI6IkpXVCIsImFsZyI6IlJTMjU2In0.eyJhdWQiOiJodHRwczovL3BsYXRmb3JtLnJpbmdjZW50cmFsLmNvbS9yZXN0YXBpL29hdXRoL3Rva2VuIiwic3ViIjoiNjMwMDM2NTgwMDgiLCJpc3MiOiJodHRwczovL3BsYXRmb3JtLnJpbmdjZW50cmFsLmNvbSIsImV4cCI6Mzg4MTU5MTI3NCwiaWF0IjoxNzM0MTA3NjI3LCJqdGkiOiJUSlJ2VkxfR1FpR0JiWjFObDVPT3d3In0.cthZiJwbodG33KoJcb5m2h4XN40ls1r__oBXahlQm_N5ky5vCIlwYeidsz6PC7PVsSM1ITY2W_urbQEppdAOPBYfY3_jHjWl5entOIQluesrs2PNk-uExoCU5cU_2vuZKsiRLb7fqju_t35GTMQptml3cTcRQCW-UPqiM3luBgA1-BvxPcFzG33zfLyBXHwM0UDjSjHH7U_gZu3yiQEoZcrJiJKnReh6QtemyB8sTLy1uXEQk4hg9Optt8Gsu4dADuoY-6cvbfB5kEEMLD5P-xgUjISeTMgl58jSxxRTR34tyO_NeQxt_rlUVuqTgUJ-MMmEl3Uejw49JMGT2YbzeA';




    public function __construct() {
        parent::__construct();
        modules::run("login/is_logged_in");

    }

    // AGENT CALL LOGS

public function getCallLogsdata() {
    date_default_timezone_set('America/New_York');

    $sdk = new SDK($this->clientId, $this->clientSecret, $this->serverUrl);
    $platform = $sdk->platform();
    
    $platform->login( [ "jwt" => $this->JWT_TOKEN ] );

    $fromDate = '2024-12-17T00:00:00Z'; // Start date in ISO 8601 format  // modify dynamic variable  EG .POST codeigniter
    $toDate = '2024-12-17T23:59:59Z'; // End date in ISO 8601 format  // modify dynamic variable egg POST CODEIGNITER

    $response = $platform->get('/account/~/call-log', [
        'dateFrom' => $fromDate,
        'dateTo' => $toDate,
        'viewDetails' => true, // Added parameter to view details
        'perPage' => 10000

    ]);
    $data = $response->json();
    // $records['agent_users'] = $this->User_Model->view_account_leadgent_sales($this->session->userdata['userlogin']['user_id']);

    $records['agent_users'] = $this->User_Model->view_account_sales();
    $records['callLogs'] = $data->records;

    $this->load->view('layout/head');
    $this->load->view('layout/header');
    $this->load->view('layout/nav-agent');
    $this->load->view('agent_call_logs', $records);
    $this->load->view('layout/footer');

}
public function fetch_call_logs_data() {
    date_default_timezone_set('America/New_York');

    $sdk = new SDK($this->clientId, $this->clientSecret, $this->serverUrl);
    $platform = $sdk->platform();
    $platform->login(["jwt" => $this->JWT_TOKEN]);
    
    $fromDate = new DateTime($this->input->post('from_date'), new DateTimeZone('UTC'));
    $toDate = new DateTime($this->input->post('to_date'), new DateTimeZone('UTC'));
    
    // Set the time to the start and end of the day
    $fromDate->setTime(0, 0, 0);
    $toDate->setTime(23, 59, 59);
    
    $formattedFromDate = $fromDate->format('Y-m-d\TH:i:s.v\Z');
    $formattedToDate = $toDate->format('Y-m-d\TH:i:s.v\Z');
    
    $phonenumber = $this->input->post('phonenumber');


    // $callDirection = $this->input->post('call_direction'); // New parameter for inbound/outbound
    
    $response = $platform->get('/account/~/call-log', [
        'phoneNumber' => $phonenumber,
        'dateFrom' => $formattedFromDate,
        'dateTo' => $formattedToDate,
        'viewDetails' => true,
        'perPage' => 10000,
    ]);
    
    $data = $response->json();

    echo json_encode($data);


}
}
