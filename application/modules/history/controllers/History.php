<?php
defined('BASEPATH') or exit('No direct script access allowed');

class History extends MY_Controller
{


	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct()
	{
		parent::__construct();
		modules::run("login/is_logged_in");
		require_once FCPATH . 'vendor/autoload.php'; // Load Composer's autoloader
	}
	public function index()
	{

		$records['tabledeals'] = $this->Activity_Model->tabledeals();
		$records['notifications'] = $this->Activity_Model->count_unread_notifications($this->session->userdata['userlogin']['user_id']);


		$this->load->view('layout/head');
		$this->load->view('layout/header');
		$this->load->view('layout/nav');
		$this->load->view('activity', $records);
		$this->load->view('layout/footer');
	}
	// add Deals

	// get LEAD data activities
	public function activity_leads()
	{

		$data = array();
		$lead_activity_data = $this->Activity_Model->select_lead_activity($this->input->get('lead_id'));
		$data = $lead_activity_data;
		echo json_encode($data);
	}

	public function count_unread_notifications()
	{
		$unread_count = $this->Activity_Model->count_unread_notifications($this->session->userdata['userlogin']['user_id']);
		$activities = $this->Activity_Model->get_notifications($this->session->userdata['userlogin']['user_id']);

		echo json_encode(['count' => $unread_count, 'activities' => $activities, 'usertype' => $this->session->userdata['userlogin']['usertype']]);
	}
	public function view_activity_notifications()
	{
		$notifications = $this->Activity_Model->get_notifications($this->session->userdata['userlogin']['user_id']);
		echo json_encode($notifications);
	}

	public function mark_read()
	{
		$this->Activity_Model->mark_as_read($this->session->userdata['userlogin']['user_id']);
		echo json_encode(['status' => 'success']);
	}


	public function view_agent_history()
	{
		$data = array();
		$task_data = $this->History_Model->select_agent_history($this->input->get('lead_id'));
		$data = $task_data;
		echo json_encode($data);
	}
	public function view_transaction_history()
	{
		$data = array();
		$task_data = $this->History_Model->select_transaction_history($this->input->get('lead_id'));
		$data = $task_data;
		echo json_encode($data);
	}
	
	public function view_agents_transaction_history()
	{
		$data = array();
		$task_data = $this->History_Model->select_agents_transaction_history($this->input->get('lead_id'));
		$data = $task_data;
		echo json_encode($data);
	}
	public function fetch_agent_payment_history($agent_task_id = 0, $lead_id = 0)
	{
		$data = $this->History_Model->select_agent_payment_history($agent_task_id, $lead_id);

		$json_data = array("data" => $data);

		echo json_encode($json_data);
	}

	public function edit_agent_history()
	{


		// Get the data from POST
		$data = array(
			'transaction_id' => $this->input->post('transaction_id'),
			'payment_status' => $this->input->post('payment_status'),
			'amount' => $this->input->post('amount'),
			'services_status' => $this->input->post('services_status'),
			'pitched_price' => $this->input->post('pitched_price'),
			'date_paid' => $this->input->post('date_paid'),

		);

		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		// exit();


		if ($this->History_Model->update_history($data, $this->input->post('transaction_id'))) {

			echo json_encode(array("response" => "success", "message" => "Lead Successfully Updated", "redirect" => base_url('dashboard')));
		} else {
			echo json_encode(array("response" => "error", "message" => "Lead Error", "redirect" => base_url('dashboard')));
		}
	}

	public function updatePaymentHistory()
	{
		$lead_id = $this->input->post('lead_id');
		$agent_user = $this->Activity_Model->select_agent_lead($lead_id);
		$transaction_id = $this->input->post('transaction_id');
		$payment_id = $this->input->post('payment_id');
		$pitched_price = $this->input->post('pitched_price');
		$amount = $this->input->post('amount');
		$payment_status = $this->input->post('payment_status');
		$services_status = $this->input->post('services_status');
		$service_purchased = $this->input->post('service_purchased');
		$agent_remarks = $this->input->post('agent_remarks');
		$agent_task_id = $this->input->post('agent_task_id');
		$date_paid =  DateTime::createFromFormat('Y-m-d', $this->input->post('date_paid'));
		$expiration_date =  DateTime::createFromFormat('Y-m-d', $this->input->post('expiration_date'));

		// echo $amount;

		$data = array(
			'pitched_price' => $pitched_price,
			'amount' => $amount,
			'payment_status' => $payment_status,
			'services_status' => $services_status,
			'date_paid' => $date_paid->format("Y-m-d H:i:s")
		);
		// $datapayment_history = $data; // reuse
		$data_agent = array(
			'pitched_price' => $pitched_price,
			'amount' => $amount,
			'payment_status' => $payment_status,
			'services_status' => $services_status,
			'sold_author_update_by_admin' => 1

		);
		$data_activities =  array(
			'lead_id' =>  $this->input->post('lead_id'),
			'remarks' =>   "Updated Payment Date",
			'unread_agent' =>  $agent_user == false ? 0 : 1,
			'user_id'  => $agent_user == false ? 0 :  $agent_user['user_id'],
			'user_charge'  =>  $this->session->userdata['userlogin']['full_name'],
			'date_added' =>  date("Y-m-d H:i:s"),
		);
		$this->Leads_Model->update_lead_sold_author_status_closed(array('sold_author_status' => 1), $lead_id);
		$this->Leads_Model->update_requested_date_paid(array('requested_date_paid' => 0), $lead_id);
		$result = $this->History_Model->updatePayment($transaction_id, $data);
		$agent_result = $this->Agents_Model->update_agent($data_agent, $agent_task_id);
		$payment_transaction = $this->History_Model->update_paymentTransaction($payment_id, $data, $date_paid->format("Y-m-d"));

		if ($result && $agent_result && $payment_transaction) {
			$this->Activity_Model->insert($data_activities);
			echo json_encode(['status' => 'success']);
		} else {
			echo json_encode(['status' => 'error']);
		}
	}


	public function resetPaymentHistory()
	{


		$agent_user = $this->Activity_Model->select_agent_lead($this->input->post('lead_id'));


		$transaction_id = $this->input->post('transaction_id');
		$agent_task_id = $this->input->post('agent_task_id');

		// echo $amount;

		$data_agent = array(
			'pitched_price' => "",
			'amount' => "",
			'payment_status' => "",
			'agent_remarks' => "",
			'services_status' => "",
			'agent_priority' => "",
			'service_purchased' => "",
		);
		$data_activities =  array(
			'lead_id' =>  $this->input->post('lead_id'),
			'remarks' =>   "Reseted Payment History",
			'unread_agent' =>  $agent_user == false ? 0 : 1,
			'user_id'  => $agent_user == false ? 0 :  $agent_user['user_id'],
			'user_charge'  =>  $this->session->userdata['userlogin']['full_name'],
			'date_added' =>  date("Y-m-d H:i:s"),
		);



		$this->Leads_Model->update_requested_date_paid(array('requested_date_paid' => 0), ($this->input->post('lead_id')));
		$result = $this->History_Model->resetPayment($transaction_id);
		$agent_result = $this->Agents_Model->update_agent($data_agent, $agent_task_id);

		if ($result && $agent_result) {
			$this->Activity_Model->insert($data_activities);
			echo json_encode(['status' => 'success']);
		} else {
			echo json_encode(['status' => 'error']);
		}
	}



	public function getData()
	{
		$client = new Google_Client();
		$client->setApplicationName('Crmdata');
		$client->setScopes(Google_Service_Sheets::SPREADSHEETS);
		$client->setAuthConfig(FCPATH . 'google/crmdata-442001-3bced0bb22c5.json'); // Path to your JSON file
		$client->setAccessType('offline');
		$service = new Google_Service_Sheets($client);

		$spreadsheetId = '1hbup5m0kCsgz1S6yN2FS9dJ4w2IyMrbssWlz9JAr6oU'; // Replace with your spreadsheet ID
		$range = 'Sheet1'; // Adjust the range as needed

		$users_data = $this->User_Model->all_users();
		$user_emails = array_column($users_data, 'email_add'); // Extract email addresses from users_data

		$response = $service->spreadsheets_values->get($spreadsheetId, $range);
		$values = $response->getValues();
		$formatted_values = [];

		try {
			$response = $service->spreadsheets_values->get($spreadsheetId, $range);
			$values = $response->getValues();

			if (empty($values)) {
				echo "No data found.";
			} else {

				if (!empty($values)) {
					foreach ($values as $row) {
						if (count($row) >= 2) { // Ensure there are at least two columns
							$formatted_values[] = [
								'email' => $row[0], // First column as email
								'password' => $row[1] // Second column as password
							];
						}
					}
				}
				foreach ($formatted_values as $row) {
					if (in_array($row[0], $user_emails)) { // Check if email matches
						echo implode(", ", $row) . "<br>";
					}
				}
			}
		} catch (Exception $e) {
			echo 'Error: ' . $e->getMessage();
		}
	}

	public function get_latest_transaction_history()
	{
		$data = array();
		$task_data = $this->History_Model->select_agent_payment_history($this->input->get('lead_id'));
		$data = $task_data;
		echo json_encode($data);
	}
	public function updateLatestPayment()
	{
    $lead_id = $this->input->post('lead_id');
    $agent_user = $this->Activity_Model->select_agent_lead($lead_id);
    $agent_task_id = $this->input->post('agent_task_id');
	$payment_id = $this->input->post('payment_id');
	$transaction_id = $this->input->post('transaction_id');
    $recording = $this->input->post('recording');
    $recording = $recording ? $recording : ''; // 🔵 No NULL recording

    // Minimal validation
    // if (empty($lead_id) || empty($this->input->post('amount'))) {
    //     echo json_encode(['status' => 'error', 'message' => 'Lead ID and Amount are required.']);
    //     return;
    // }

    $data = array(
        'lead_id' => $lead_id,
        'agent_task_id' => $agent_task_id,
        'payment_status' => $this->input->post('payment_status'),
        'services_status' => $this->input->post('services_status'),
        'service_purchased' => $this->input->post('service_purchased'),
		'additional_book' => $this->input->post('additional_book'),
        'agent_remarks' => $this->input->post('agent_remarks'),
        'agent_priority' => $this->input->post('agent_priority'),
        'amount' => $this->input->post('amount'),
		'total_payment' => $this->input->post('total_payment'),
        'balance' => $this->input->post('balance'),
        'recording' => $recording,
        'pitched_price' => $this->input->post('pitched_price'),
        'agent_user_id' => $this->session->userdata['userlogin']['user_id'],
    );

    $data_agent = array(
        'lead_id' => $lead_id,
        'agent_task_id' => $agent_task_id,
        'payment_status' => $this->input->post('payment_status'),
        'services_status' => $this->input->post('services_status'),
        'service_purchased' => $this->input->post('service_purchased'),
        'agent_remarks' => $this->input->post('agent_remarks'),
        'agent_priority' => $this->input->post('agent_priority'),
        'amount' => $this->input->post('amount'),
        'recording' => $recording,
        'pitched_price' => $this->input->post('pitched_price'),
    );
	$data_payment_trans_history = array(
        'lead_id' => $lead_id,
        'agent_task_id' => $agent_task_id,
        'payment_status' => $this->input->post('payment_status'),
        'services_status' => $this->input->post('services_status'),
        'service_purchased' => $this->input->post('service_purchased'),
		'additional_book' => $this->input->post('additional_book'),
        'agent_remarks' => $this->input->post('agent_remarks'),
        'agent_priority' => $this->input->post('agent_priority'),
        'amount' => $this->input->post('amount'),
		'total_payment' => $this->input->post('total_payment'),
        'balance' => $this->input->post('balance'),
        'recording' => $recording,
        'pitched_price' => $this->input->post('pitched_price'),
        'agent_user_id' => $this->session->userdata['userlogin']['user_id'],
    );
    $data_activities = array(
		'lead_id' => $this->input->post('lead_id'),
		'remarks' => "Updated Payment",
		'admin_id' => 1,
		'unread_admin' => 1,
		'requested_date_paid' => 1,
		'user_charge' => $this->session->userdata['userlogin']['full_name'],
		'date_added' => date("Y-m-d H:i:s"),
	);
	$insert_payment = $this->History_Model->InsertPaymentTransaction($payment_id, $data_payment_trans_history);
    $results = $this->History_Model->updateLatestsPayment($transaction_id, $data);
    $agent_result = $this->Agents_Model->update_agent($data_agent, $agent_task_id);

    // $this->Activity_Model->insert($data_activities);
	// $pitched = $this->History_Model->updatePitchedPrice($pitched_id, $data_pitched_price);
    // $this->db->trans_complete();

    if ($results && $agent_result && $insert_payment) {
		$this->Activity_Model->insert($data_activities);
		echo json_encode(['status' => 'success']);
	} else {
		echo json_encode(['status' => 'error']);
	}
}

}
