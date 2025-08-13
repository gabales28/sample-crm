<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lead_Agent extends MY_Controller
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
	 * map to /index.php/welcome/<method_name> changedddd lead
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct()
	{
		parent::__construct();
		modules::run("login/is_logged_in");
		$this->load->library('upload');
	}
	public function index($lead_id = 0)
	{

		$records['tableleads'] = $this->Leads_Model->tableleads();
		$records['activities'] = $this->Activity_Model->tableactivities();
		$records['leadgent_users'] = $this->User_Model->view_account_leadgent();
		$records['lead_id'] =  $this->uri->segment(3) == "" ? 0 : $this->uri->segment(3);
		$records['lead_status'] =  "";


		$this->load->view('layout/head');
		$this->load->view('layout/header');
		$this->load->view('layout/nav-agent');
		$this->load->view('lead_agent', $records);
		$this->load->view('layout/footer');
	}

	public function fetch_lead_limit_data()
	{
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$search = $this->input->get("search")['value'];
		$lead_status = $this->input->get("lead_status");



		$data = $this->Leads_Model->get_data_lead($length, $start, $search, $lead_status);
		$totalData = $this->Leads_Model->count_all();
		$totalFiltered = $this->Leads_Model->count_filtered($search, $lead_status);

		$json_data = array(
			"draw" => $draw,
			"recordsTotal" => $totalData,
			"recordsFiltered" => $totalFiltered,
			"data" => $data,

		);

		echo json_encode($json_data);
	}

	public function fetch_lead_data()
	{
		$data = array();
		$lead_data = $this->Leads_Model->fech_lead_category();
		$data = $lead_data;
		echo json_encode($data);
	}


	//for Assign mutiple task
	public function fetch_lead_limit_data_modal()
	{
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$search = $this->input->get("search")['value'];



		$data = $this->Leads_Model->get_data_lead_modal($length, $start, $search);
		$totalData = $this->Leads_Model->count_all_modal();
		$totalFiltered = $this->Leads_Model->count_filtered_modal($search);

		$json_data = array(
			"draw" => $draw,
			"recordsTotal" => $totalData,
			"recordsFiltered" => $totalFiltered,
			"data" => $data,

		);

		echo json_encode($json_data);
	}
	// add LEADS
	public function add_lead()
	{
		$user_charge = $this->session->userdata['userlogin']['full_name'];

		$contact = $this->input->post('customer_contact') == "" ? array() : $this->input->post('customer_contact');
		$email = $this->input->post('customer_email') == "" ? array() : $this->input->post('customer_email');

		$contactsString = implode(',', $contact); // Convert Customer contact array to comma-separated string
		$emailsString = implode(',', $email); // Convert Customer Email  array to comma-separated string


		$data =  array(
			'brand_name' => $this->input->post('brandName'),
			'title' => $this->input->post('title'),
			// 'description' => $this->input->post('desc') ,
			// 'lead_value' => $this->input->post('value'),
			'book_link' => $this->input->post('bookLink'),
			'source' => $this->input->post('source'),
			// 'user_id' => $this->input->post('assign_to'),
			// 'priority' => $this->input->post('priority'),
			'customer_name'  => $this->input->post('customer_name'),
			'customer_address'  => $this->input->post('customer_address'),
			// 'customer_address'  => $this->input->post('customer_address'),
			// 'customer_address'  => $this->input->post('customer_address'),
			'lead_status' => "Active Leads",
			'customer_contact'  => $contactsString,
			'customer_email'  => $emailsString,
			'date_created' =>  date("Y-m-d H:i:s"),

		);
		$data_activities =  array(
			'lead_id' =>   $this->db->insert_id(),
			'remarks' =>   "Added Lead",
			'user_id'  =>  $this->session->userdata['userlogin']['user_id'],
			'user_charge'  =>  $this->session->userdata['userlogin']['full_name'],
			'date_added' =>  date("Y-m-d H:i:s"),
		);

		$this->Leads_Model->insert($data);
		$this->Activity_Model->insert($data_activities);
		echo json_encode(array("response" =>   "success", "message" => "Successfully Added Lead", "redirect" => base_url('dashboard')));
	}

	// Upload Leads
	public function upload_lead()
	{
		$user_charge = $this->session->userdata['userlogin']['full_name'];

		$usertype = $this->session->userdata['userlogin']['usertype'];

		$configUpload['upload_path'] = FCPATH . 'lead_files/';

		$configUpload['allowed_types'] = 'csv';

		$configUpload['file_name'] = 'Leads' . uniqid() . '_' . date('Y-m-d');

		$this->load->library('upload', $configUpload);

		if (!$this->upload->do_upload('upload_lead')) {
			$this->session->set_flashdata('error', $this->upload->display_errors('', ''));
			redirect('leads');
		} else {


			$media = $this->upload->data();

			$inputFileName = './lead_files/' . $media['file_name'];

			$handle = fopen($inputFileName, "r");

			$c = 0;
			$numberOfFields = 7;
			fgetcsv($handle);  //SKIP THE FIRST ROW


			while (($filesop = fgetcsv($handle, 1000, ",")) !== false) {
				$num = count($filesop);

				$data =  array(
					'brand_name' => $filesop[0],
					'title' => $filesop[1],
					// 'description' =>$filesop[1],
					// 'lead_value' =>$filesop[2],
					'book_link' =>   $filesop[2],
					'source' => $filesop[3],
					'customer_name' =>   $filesop[4],
					// 'customer_address' =>   $filesop[5],
					'customer_contact' =>   $filesop[5],
					// 'lead_status' =>   $filesop[6],
					'customer_email' =>   $filesop[6],
					// 'remark_lead' =>   $filesop[7],
					'date_created' => date("Y-m-d H:i:s"),

				);
				// $data_activities =  array(
				// 	'lead_id' =>   $this->db->insert_id(),
				// 	'remarks' =>   "Addes Lead",
				// 	'user_id'  =>  $this->session->userdata['userlogin']['user_id'],
				// 	'user_charge'  =>  $this->session->userdata['userlogin']['full_name'],
				// 	'date_added' =>  date("Y-m-d H:i:s"),
				// );

				if ($num == $numberOfFields) {

					$this->Leads_Model->insert($data);
					// $this->Activity_Model->insert($data_activities);


					$c++;
				}
			}
			fclose($handle);
			$this->session->set_flashdata('success', "Successfully to Import Lead");
			redirect('leads');
		}
	}
	// get LEAD data
	public function view_lead_detail()
	{
		$data = array();
		$lead_data = $this->Leads_Model->select_lead($this->input->get('lead_id'));
		$data = $lead_data;
		echo json_encode($data);
	}
	// get LEAD customer contact data
	public function delete_lead_contact()
	{
		$lead_data = $this->Leads_Model->select_single_row_lead($this->input->get('lead_id'));
		$customer_contact = $lead_data['customer_contact'];

		$data_customer_contact = preg_replace('/\b' . preg_quote($this->input->get('customer_contact'), '/') . '\b(,)?/', '', $customer_contact);
		$data_customer_contact = trim($data_customer_contact, ',');
		$this->Leads_Model->update(array('customer_contact' => 	$data_customer_contact), $this->input->get('lead_id'));

		echo json_encode(array("response" =>   "success", "message" => "Successfully Deleted Customer Contact"));
	}
	// get LEAD customer email data
	public function delete_lead_email()
	{
		$lead_data = $this->Leads_Model->select_single_row_lead($this->input->get('lead_id'));
		$customer_email = $lead_data['customer_email'];

		$data_customer_email = preg_replace('/\b' . preg_quote($this->input->get('customer_email'), '/') . '\b(,)?/', '', $customer_email);
		$data_customer_email = trim($data_customer_email, ',');
		$this->Leads_Model->update(array('customer_email' => 	$data_customer_email), $this->input->get('lead_id'));

		echo json_encode(array("response" =>   "success", "message" => "Successfully Deleted Customer Email"));
	}

	// update LEADS
	public function update_lead()
	{
		$user_charge = $this->session->userdata['userlogin']['full_name'];

		$contact = $this->input->post('customer_contact') == "" ? array() : $this->input->post('customer_contact');
		$email = $this->input->post('customer_email') == "" ? array() : $this->input->post('customer_email');

		$contactsString = implode(',', $contact); // Convert Customer contact array to comma-separated string
		$emailsString = implode(',', $email); // Convert Customer Email  array to comma-separated string


		$data =  array(
			'brand_name' => $this->input->post('brandName'),
			'title' => $this->input->post('title'),
			//   'description' => $this->input->post('desc') ,
			//   'lead_value' => $this->input->post('value'),
			'book_link' => $this->input->post('bookLink'),
			'source' => $this->input->post('source'),
			'lead_id' => $this->input->post('lead_id'),
			// 'priority' => $this->input->post('priority'),
			'customer_name'  => $this->input->post('customer_name'),
			'customer_address'  => $this->input->post('customer_address'),
			'lead_status' => $this->input->post('statusData'),
			'customer_contact'  => $contactsString,
			'customer_email'  => $emailsString,



		);

		$this->Leads_Model->update($data, $this->input->post('lead_id'));
		echo json_encode(array("response" =>   "success", "message" => "Successfully Updated Lead", "redirect" => base_url('dashboard')));
	}



	public function view_agent_Task_detail()
	{
		$agent_task_id = $this->input->get('agent_task_id');
		$lead_id = $this->input->get('lead_id');
		$transaction_id = $this->input->get('transaction_id');
		$services_status = $this->input->get('service_status');


		$data = $this->Agents_Model->get_agent_task_details($agent_task_id, $lead_id, $transaction_id, $services_status);
		echo json_encode($data);
		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		// exit();

	}

	public function update_agent()
{
    $agent_priority = $this->input->post('agent_priority');
    $recording = $this->input->post('recording');

    // Validate required fields
    if (empty($agent_priority)) {
        echo json_encode([
            "response" => "error",
            "message" => "Agent Priority is required.",
            "redirect" => base_url('dashboard')
        ]);
        return;
    }

    // Recording is required unless agent_priority is Pipe or Prospect
    if (!in_array($agent_priority, ['Pipe', 'Prospect']) && empty($recording)) {
        echo json_encode([
            "response" => "error",
            "message" => "Recording URL is required unless the priority is Pipe or Prospect.",
            "redirect" => base_url('dashboard')
        ]);
        return;
    }

    // Additional required field validations when NOT Pipe or Prospect
    if (!in_array($agent_priority, ['Pipe', 'Prospect'])) {
        $required_fields = ['pitched_price', 'agent_remarks', 'amount', 'services_status', 'service_purchased', 'payment_status'];
        foreach ($required_fields as $field) {
            if (empty($this->input->post($field))) {
                echo json_encode([
                    "response" => "error",
                    "message" => ucfirst(str_replace('_', ' ', $field)) . " is required when priority is not Pipe or Prospect.",
                    "redirect" => base_url('dashboard')
                ]);
                return;
            }
        }
    }

    // Prepare data for update
    $data = array(
        'agent_priority' => $agent_priority,
        'pitched_price' => $this->input->post('pitched_price'),
        'agent_remarks' => $this->input->post('agent_remarks'),
        'amount' => $this->input->post('amount'),
        'recording' => $recording,
        'services_status' => $this->input->post('services_status'),
        'service_purchased' => $this->input->post('service_purchased'),
        'payment_status' => $this->input->post('payment_status'),
    );

    // Proceed with update
    if ($this->Agents_Model->update_agent($data, $this->input->post('agent_task_id'))) {

        // Insert activity log
        $data_activities = array(
            'lead_id' => $this->input->post('lead_id'),
            'remarks' => "Added Payment",
            'admin_id' => 1,
            'unread_admin' => 1,
			'requested_date_paid' => 1,
            'user_charge' => $this->session->userdata['userlogin']['full_name'],
            'date_added' => date("Y-m-d H:i:s"),
        );
        $this->Activity_Model->insert($data_activities);

        // Skip history if Pipe or Prospect
        if (!in_array($agent_priority, ['Pipe', 'Prospect'])) {
            $data_history = array(
                'lead_id' => $this->input->post('lead_id'),
                'agent_task_id' => $this->input->post('agent_task_id'),
                'payment_status' => $this->input->post('payment_status'),
                'services_status' => $this->input->post('services_status'),
                'service_purchased' => $this->input->post('service_purchased'),
                'additional_book' => $this->input->post('additional_book'),
                'agent_remarks' => $this->input->post('agent_remarks'),
                'agent_priority' => $agent_priority,
                'amount' => $this->input->post('amount'),
                'total_payment' => $this->input->post('total_payment'),
                'balance' => $this->input->post('balance'),
                'recording' => $recording,
                'pitched_price' => $this->input->post('pitched_price'),
                'agent_user_id' => $this->session->userdata['userlogin']['user_id'],
                'date' => date("Y-m-d H:i:s"),
            );

            $this->History_Model->insertPaymentTransactionHistory($data_history);

            if ($agent_priority === "Closed") {
                if (empty($this->input->post('payment_status')) || empty($recording)) {
                    echo json_encode([
                        "response" => "error",
                        "message" => "Payment status or Recording URL cannot be empty when lead is Closed.",
                        "redirect" => base_url('dashboard')
                    ]);
                    return;
                }
                $this->History_Model->insert($data_history);
            }
        }

        echo json_encode(["response" => "success", "message" => "", "redirect" => base_url('dashboard')]);
        return;
    }

    // Fallback error
    echo json_encode(["response" => "error", "message" => "Lead update failed", "redirect" => base_url('dashboard')]);
}




	// ========================================

	// public function update_agent() {
	// 		$leadgent_user = $this->Activity_Model->select_leadgent_lead($this->input->post('lead_id'));
	// 		// $this->form_validation->set_rules('date_paid', 'Date Paid', 'trim|xss_clean|required');


	// 		// Get the data from POST
	// 		$data_history = array(
	// 			'lead_id' => $this->input->post('lead_id'),
	// 			'agent_task_id' => $this->input->post('agent_task_id'),
	// 			'payment_status' => $this->input->post('payment_status'),
	// 			'services_status' => $this->input->post('services_status'),
	// 			'agent_remarks' => $this->input->post('agent_remarks'),
	// 			'amount' => $this->input->post('amount'),
	// 			'balance' => $this->input->post('balance'), // Adding the balance field
	// 			'recording' => $this->input->post('recording'),
	// 			'pitched_price' => $this->input->post('pitched_price'),
	// 			'agent_user_id' => $this->session->userdata['userlogin']['user_id'],
	// 			// 'date_paid' => null,
	// 			'date' =>  date("Y-m-d H:i:s"),
	// 		);
	// 		if ($this->History_Model->insert($data_history)) {
	// 			$data_activities = array(
	// 				'lead_id' => $this->input->post('lead_id'),
	// 				'remarks' => "Updated Lead Task",
	// 				'admin_id' => 1,
	// 				'unread_admin' => 1,
	// 				'user_charge' => $this->session->userdata['userlogin']['full_name'],
	// 				'date_added' => date("Y-m-d H:i:s"),
	// 			);
	// 			$this->Activity_Model->insert($data_activities);
	// 			   $payment_status = $this->input->post('payment_status');
	// 			   $recording = $this->input->post('recording');
	// 			if ($this->input->post('agent_priority') == "Closed" && $this->input->post('current_status_payment') != 'Full payment' && $this->input->post('recording') !=' ')  {
	// 				if (empty($payment_status && $recording) ) {
	// 					echo json_encode(array("response" => "error", "message" => "Payment status Or Recording URL cannot be empty.", "redirect" => base_url('dashboard')));
	// 					return; // Exit if payment status is empty
	// 				}
	// 			}
	// 			echo json_encode(array("response" => "success", "message" => "", "redirect" => base_url('dashboard')));
	// 		} else {
	// 			echo json_encode(array("response" => "error", "message" => "Lead Error", "redirect" => base_url('dashboard')));
	// 		}
	// 	}


	// ========================================

	public function view_agent_Task_detaildddd()
	{
		$agent_task_id = $this->input->get('agent_task_id');
		$lead_id = $this->input->get('lead_id');
		$transaction_id = $this->input->get('transaction_id');





		$data = $this->Agents_Model->get_agent_task_details($agent_task_id, $lead_id, $transaction_id);
		echo json_encode($data);
		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		// exit();

	}
	public function recording()
	{
		$this->load->view('upload_form');
	}



	public function do_upload()
	{
		$agent_user = $this->Activity_Model->select_agent_lead($this->input->post('lead_id'));
		$agent_task_id = $this->input->post('agent_task_id');
		$config['upload_path']   = FCPATH . 'ringcentral_recording';
		$config['allowed_types'] = 'mp3';
		$config['file_name'] = 'Audio' . uniqid() . '_' . date('Y-m-d');
		$config['max_size'] = 25000; // 25MB

		$this->upload->initialize($config);


		$data_activities =  array(
			'lead_id' =>  $this->input->post('lead_id'),
			'remarks' =>   "Uploaded Audio",
			'admin_id' => 1,
			'unread_admin' => 1,
			'user_charge'  =>  $this->session->userdata['userlogin']['full_name'],
			'date_added' =>  date("Y-m-d H:i:s"),
		);

		if (!$this->upload->do_upload('userfile')) {
			echo json_encode('Audio Uploading Error');
		} else {
			$media = $this->upload->data();
			if ($this->Agents_Model->update_agent(array('file_name ' => $media['file_name']), $this->input->post('agent_task_id'))) {
				$this->Activity_Model->insert($data_activities);
				echo json_encode('Audio Successfully Uploaded');
			}
		}
	}

	public function get_latest_balance_history()
	{
		$lead_id = $this->input->post('lead_id');
		$service_status = $this->input->post('service_status');

		$this->db->select('*');
		$this->db->from('tbltransaction_history');
		$this->db->where('lead_id', $lead_id);
		$this->db->where('services_status', $service_status);
		$this->db->order_by('date', 'DESC');
		$this->db->limit(1);

		$query = $this->db->get();

		$data2 = $this->Agents_Model->select_single_row_agent_lead($lead_id);
		$total_payment = $this->Agents_Model->transaction_amount($lead_id, $service_status);

		if ($query->num_rows() > 0) {
			$transaction_data = $query->row_array();
			$transaction_data['formatted_date'] = date('Y-m-d H:i:s', strtotime($transaction_data['date']));

			echo json_encode([
				'response' => 'success',
				'data' => $transaction_data,
				'data2' => $data2,
				'total_payment' => $total_payment['total_payment'] ?? 0, // Added safety
			]);
		} else {
			echo json_encode([
				'response' => 'error',
				'message' => 'No data found for the selected service status.',
				'services_status' => $service_status,
			]);
		}
	}
}
