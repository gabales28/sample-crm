<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Leads extends MY_Controller
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
	}
	public function index()
	{

		$records['tableleads'] = $this->Leads_Model->tableleads();
		$records['activities'] = $this->Activity_Model->tableactivities();
		$records['leadgent_users'] = $this->User_Model->view_account_leadgent();

		$this->load->view('layout/head');
		$this->load->view('layout/header');
		$this->load->view('layout/nav');
		$this->load->view('leads', $records);
		$this->load->view('layout/footer');
	}

	//admin filtering
	// public function fetch_lead_limit_data()
	// {
	// 	$draw = intval($this->input->get("draw"));
	// 	$start = intval($this->input->get("start"));
	// 	$length = intval($this->input->get("length"));
	// 	$search = $this->input->get("search")['value'];
	// 	$lead_status = $this->input->get("lead_status");


	// 	// $data = $this->Leads_Model->get_data_lead_status_is_closed($length, $start, $search, $lead_status);

	// 	$data = $this->Leads_Model->get_data_lead($length, $start, $search, $lead_status);
	// 	$totalData = $this->Leads_Model->count_all();
	// 	$totalFiltered = $this->Leads_Model->count_filtered($search, $lead_status);

	// 	// Highlight duplicated customer names
	// 	foreach ($data as &$lead) {
	// 		// if ($this->is_customer_name_duplicated($lead->customer_name)) {
	// 		// 	$lead->customer_name = '<span style="color:red;">' . $lead->customer_name . '</span>';
	// 		// }

	// 		if ($lead->sold_author_status == 1 || $this->Leads_Model->is_customer_name_duplicated($lead->customer_name) && $this->Leads_Model->is_customer_name_in_leads_with_sold_status($lead->customer_name)) {
	// 			// Apply highlight to customer name if closed
	// 			$lead->customer_name = '<span style="color:teal; font-weight: bold;">' . $lead->customer_name . '</span>';
	// 		} elseif ($this->Leads_Model->is_customer_name_duplicated($lead->customer_name)) {
	// 			$lead->customer_name = '<span style="color:red;">' . $lead->customer_name . '</span>';
	// 		}




	// 		// Handle multiple emails
	// 		$emails = explode(',', $lead->customer_email);
	// 		$formatted_emails = [];
	// 		foreach ($emails as $email) {
	// 			$email = trim($email);
	// 			if ($lead->sold_author_status == 1 || $this->Leads_Model->is_customer_email_in_leads($email)) {
	// 				// Apply highlight to customer name if closed
	// 				$formatted_emails[] = '<a href="mailto:' . $email . '" style="color: teal !important; font-weight: bold;">' . $email . '</a>';
	// 			} elseif ($this->Leads_Model->is_customer_email_duplicated($email) && $this->Leads_Model->is_customer_email_in_leads_with_sold_status($email)) {
	// 				$formatted_emails[] = '<a href="mailto:' . $email . '" style="color: teal !important; font-weight: bold;">' . $email . '</a>';
	// 			} elseif ($this->Leads_Model->is_customer_email_duplicated($email)) {
	// 				// Apply highlight to email if sold
	// 				$formatted_emails[] = '<a href="mailto:' . $email . '" style="color:red;">' . $email . '</a>';
	// 			} else {
	// 				$formatted_emails[] = '<a href="mailto:' . $email . '" style="color:#0056b3;">' . $email . '</a>';
	// 			}
	// 		}

	// 		// Handle multiple contacts
	// 		$contacts = explode(',', $lead->customer_contact);
	// 		$formatted_contacts = [];
	// 		foreach ($contacts as $contact) {
	// 			$contact = trim($contact);

	// 			if ($lead->sold_author_status == 1 || $this->Leads_Model->is_customer_contact_in_leads($contact)) {
	// 				// Apply highlight to customer name if closed
	// 				$formatted_contacts[] = '<a href="tel:' . $contact . '" style="color: teal !important; font-weight: bold;">' . $contact . '</a>';
	// 			} elseif ($this->Leads_Model->is_customer_contact_duplicated($contact) && $this->Leads_Model->is_customer_contact_in_leads_with_sold_status($contact)) {
	// 				$formatted_contacts[] = '<a href="tel:' . $contact . '" style="color: teal !important; font-weight: bold;">' . $contact . '</a>';

	// 			} elseif ($this->Leads_Model->is_customer_contact_duplicated($contact)) {
	// 				// Apply highlight to email if sold
	// 				$formatted_contacts[] = '<a href="tel:' . $contact . '" style="color:red;">' . $contact . '</a>';
	// 			} else {
	// 				$formatted_contacts[] = '<a href="tel:' . $contact . '" style="color:#0056b3;">' . $contact . '</a>';
	// 			}
	// 		}

	// 		// Join the formatted contacts back into a string
	// 		$lead->customer_contact = implode(', ', $formatted_contacts);

	// 		$lead->customer_email = implode(', ', $formatted_emails);
	// 	}

	// 	$json_data = array(
	// 		"draw" => $draw,
	// 		"recordsTotal" => $totalData,
	// 		"recordsFiltered" => $totalFiltered,
	// 		"data" => $data,

	// 	);


	// 	echo json_encode($json_data);
	// }

	public function fetch_lead_limit_data()
	{
		$draw = (int) $this->input->get("draw");
		$start = (int) $this->input->get("start");
		$length = (int) $this->input->get("length");
		$search = $this->input->get("search")['value'];
		$lead_status = $this->input->get("lead_status");
	
		$data = $this->Leads_Model->get_data_lead($length, $start, $search, $lead_status);
		$totalData = $this->Leads_Model->count_all();
		$totalFiltered = $this->Leads_Model->count_filtered($search, $lead_status);
	
		foreach ($data as &$lead) {
			$customer_name = $lead->customer_name;
			$sold_status = $lead->sold_author_status;
	
			$is_name_duplicated = $this->Leads_Model->is_customer_name_duplicated($customer_name);
			$is_name_in_sold = $this->Leads_Model->is_customer_name_in_leads_with_sold_status($customer_name);
	
			// Highlight customer name
			if ($sold_status == 1 || ($is_name_duplicated && $is_name_in_sold)) {
				$lead->customer_name = '<span style="color:teal; font-weight: bold;">' . $customer_name . '</span>';
			} elseif ($is_name_duplicated) {
				$lead->customer_name = '<span style="color:red;">' . $customer_name . '</span>';
			}
	
			// Format emails
			$emails = array_map('trim', explode(',', $lead->customer_email));
			$lead->customer_email = implode(', ', array_map(function ($email) use ($sold_status) {
				$is_dup = $this->Leads_Model->is_customer_email_duplicated($email);
				$in_sold = $this->Leads_Model->is_customer_email_in_leads_with_sold_status($email);
				$in_leads = $this->Leads_Model->is_customer_email_in_leads($email);
	
				if ($sold_status == 1 || $in_leads || ($is_dup && $in_sold)) {
					return '<a href="mailto:' . $email . '" style="color: teal !important; font-weight: bold;">' . $email . '</a>';
				} elseif ($is_dup) {
					return '<a href="mailto:' . $email . '" style="color:red;">' . $email . '</a>';
				}
				return '<a href="mailto:' . $email . '" style="color:#0056b3;">' . $email . '</a>';
			}, $emails));
	
			// Format contacts
			$contacts = array_map('trim', explode(',', $lead->customer_contact));
			$lead->customer_contact = implode(', ', array_map(function ($contact) use ($sold_status) {
				$is_dup = $this->Leads_Model->is_customer_contact_duplicated($contact);
				$in_sold = $this->Leads_Model->is_customer_contact_in_leads_with_sold_status($contact);
				$in_leads = $this->Leads_Model->is_customer_contact_in_leads($contact);
	
				if ($sold_status == 1 || $in_leads || ($is_dup && $in_sold)) {
					return '<a href="tel:' . $contact . '" style="color: teal !important; font-weight: bold;">' . $contact . '</a>';
				} elseif ($is_dup) {
					return '<a href="tel:' . $contact . '" style="color:red;">' . $contact . '</a>';
				}
				return '<a href="tel:' . $contact . '" style="color:#0056b3;">' . $contact . '</a>';
			}, $contacts));
		}
	
		echo json_encode([
			"draw" => $draw,
			"recordsTotal" => $totalData,
			"recordsFiltered" => $totalFiltered,
			"data" => $data,
		]);
	}
	public function export_csv()
	{
		// Load the model
		// $this->load->model('leads_model');

		// Fetch data
		$data = $this->Leads_Model->get_lead_data();

		// Set headers for CSV download
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename="leads_data.csv"');
		header('Pragma: no-cache');
		header('Expires: 0');

		// Open output stream
		$output = fopen('php://output', 'w');

		// Add CSV column headers
		fputcsv($output, array('Lead ID', 'Customer Name', 'Customer Contact', 'Customer Email', 'Customer Address', 'Brand Name', 'Source', 'Lead Status', 'Date Created'));

		// Add data rows
		foreach ($data as $row) {
			fputcsv($output, array(
				'Lead' . str_pad($row->lead_id, 4, '0', STR_PAD_LEFT),
				$row->customer_name,
				implode(", ", array_map('trim', explode(',', $row->customer_contact))),
				implode(", ", array_map('trim', explode(',', $row->customer_email))),
				substr($row->customer_address, 0, 15),
				$row->brand_name,
				$row->source,
				$row->lead_status,
				date('Y-m-d', strtotime($row->date_created))
			));
		}

		// Close output stream
		fclose($output);
		exit();
	}
	public function export_csv_leadgent()
	{
		// Load the model
		// $this->load->model('leads_model');

		// Fetch data
		$data = $this->Leads_Model->get_lead_data_leadgent($this->session->userdata['userlogin']['user_id']);

		// Set headers for CSV download
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename="leads_data.csv"');
		header('Pragma: no-cache');
		header('Expires: 0');

		// Open output stream
		$output = fopen('php://output', 'w');

		// Add CSV column headers
		fputcsv($output, array('Lead ID', 'Customer Name', 'Customer Contact', 'Customer Email', 'Customer Address', 'Brand Name', 'Source', 'Lead Status', 'Date Created'));

		// Add data rows
		foreach ($data as $row) {
			fputcsv($output, array(
				'Lead' . str_pad($row->lead_id, 4, '0', STR_PAD_LEFT),
				$row->customer_name,
				implode(", ", array_map('trim', explode(',', $row->customer_contact))),
				implode(", ", array_map('trim', explode(',', $row->customer_email))),
				substr($row->customer_address, 0, 15),
				$row->brand_name,
				$row->source,
				$row->lead_status,
				date('Y-m-d', strtotime($row->date_created))
			));
		}

		// Close output stream
		fclose($output);
		exit();
	}
	// public function delete() {
	// 	$data=array{
	// 		'trash'=>1
	// 	}
	//     $lead_id = $this->input->post('lead_id'); 
	//     if ($this->Leads_Model->delete_lead($lead_id)) {
	//         echo json_encode(array('status' => 'success', 'message' => 'Lead deleted successfully.'));
	//     } else {
	//         echo json_encode(array('status' => 'error', 'message' => 'Failed to delete lead.'));
	//     }
	// }


	public function delete()
	{

		// Prepare data to update
		$data = array(
			'lead_id' => $this->input->post('lead_id'),
			'user_remove_leads_id' => $this->session->userdata['userlogin']['user_id'],
			'user_removed_leads' => $this->session->userdata['userlogin']['full_name'],
			'trash_status' => 'Deleted',
			'remove_date' => date("Y-m-d H:i:s"),

		);

		if ($this->Leads_Model->delete_lead(array('trash' => 1, 'lead_id' => $this->input->post('lead_id')))) {
			$this->Leads_Model->insert_trash_lead($data);
			$this->Leads_Model->update_agent_trash_lead(array('agent_trash_lead' => 2, 'agent_task_id' => $this->input->post('agent_task_id')));

			echo json_encode(array("response" => "success", "message" => 'Lead deleted successfully.', "redirect" => base_url('dashboard')));

		} else {
			echo json_encode(array("response" => "error", "message" => 'Failed to delete lead.', "redirect" => base_url('dashboard')));
		}
	}
	// for duplicate data the color is red

	// private function is_customer_contact_note_duplicated($customer_contact) {
	// 	$this->db->select('COUNT(*) as count');
	// 	$this->db->from('tblleads');
	// 	$this->db->where('customer_contact', $customer_contact);
	// 	$query = $this->db->get();
	// 	return $query->row()->count ==1;
	// }
	//leadgen filtering
	public function fetch_leadgen_limit_data()
	{
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$search = $this->input->get("search")['value'];
		$lead_status = $this->input->get("lead_status");



		$data = $this->Leads_Model->get_data_leadgen($length, $start, $search, $lead_status, $this->session->userdata['userlogin']['user_id']);
		$totalData = $this->Leads_Model->count_all_leadgen($this->session->userdata['userlogin']['user_id']);
		$totalFiltered = $this->Leads_Model->count_filtered_leadgen($search, $lead_status, $this->session->userdata['userlogin']['user_id']);

		$json_data = array(
			"draw" => $draw,
			"recordsTotal" => $totalData,
			"recordsFiltered" => $totalFiltered,
			"data" => $data,

		);
		// echo "<pre>";
		// print_r($json_data);
		// echo "</pre>";
		// exit();

		echo json_encode($json_data);
	}

	//agent filtering
	public function fetch_agent_lead_limit_data()
	{
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$search = $this->input->get("search")['value'];
		$lead_status = $this->input->get("lead_status");



		$data = $this->Leads_Model->get_data_agent_lead($length, $start, $search, $lead_status, $this->session->userdata['userlogin']['user_id']);
		$totalData = $this->Leads_Model->count_all_agent_lead($this->session->userdata['userlogin']['user_id']);
		$totalFiltered = $this->Leads_Model->count_filtered_agent_lead($search, $lead_status, $this->session->userdata['userlogin']['user_id']);

		$json_data = array(
			"draw" => $draw,
			"recordsTotal" => $totalData,
			"recordsFiltered" => $totalFiltered,
			"data" => $data,

		);
		// echo "<pre>";
		// print_r($json_data);
		// echo "</pre>";
		// exit();

		echo json_encode($json_data);
	}

	// public function fetch_lead_limit_leadgent_data()
	// {
	// 	$draw = intval($this->input->get("draw"));
	// 	$start = intval($this->input->get("start"));
	// 	$length = intval($this->input->get("length"));
	// 	$search = $this->input->get("search")['value'];
	// 	$lead_id = $this->input->get("lead_id");
	// 	$lead_status = $this->input->get("lead_status");


	// 	$data = $this->Leads_Model->get_data_lead_status_is_closed_leadgen($length, $start, $search, $lead_status);

	// 	$data = $this->Leads_Model->get_data_leadagent($length, $start, $search, $lead_id, $lead_status, $this->session->userdata['userlogin']['user_id']);
	// 	$totalData = $this->Leads_Model->count_filtered_leadgent($search, $lead_id, $this->session->userdata['userlogin']['user_id']);
	// 	$totalFiltered = $this->Leads_Model->count_all_leadgent($this->session->userdata['userlogin']['user_id']);

	// 	// Highlight duplicated customer names


	// 	foreach ($data as &$lead) {
	// 		// if ($this->is_customer_name_duplicated_leads_of_leadGen($lead->customer_name)) {
	// 		// 	$lead->customer_name = '<span style="color:red;">' . $lead->customer_name . '</span>';
	// 		// 	$this->session->userdata['userlogin']['user_id'];
	// 		// }
	// 		if ($lead->sold_author_status == 1 || $this->Leads_Model->is_customer_name_duplicated_leads_of_leadGen($lead->customer_name) && $this->Leads_Model->is_customer_name_in_leads_with_sold_status_leadgen($lead->customer_name)) {
	// 			// Apply highlight to customer name if closed
	// 			$lead->customer_name = '<span style="color:teal; font-weight: bold;">' . $lead->customer_name . '</span>';
	// 		} elseif ($this->Leads_Model->is_customer_name_duplicated($lead->customer_name)) {
	// 			$lead->customer_name = '<span style="color:red;">' . $lead->customer_name . '</span>';
	// 		}

	// 		$emails = explode(',', $lead->customer_email);
	// 		$formatted_emails = [];

	// 		foreach ($emails as $emails) {
	// 			$emails = trim($emails); // Trim whitespace
	// 			if ($lead->sold_author_status == 1 || $this->Leads_Model->is_customer_email_in_leads_leadgen($emails)) {
	// 				// Apply highlight to customer name if closed
	// 				$formatted_emails[] = '<a href="mailto:' . $emails . '" style="color: teal !important; font-weight: bold;">' . $emails . '</a>';
	// 			} elseif ($this->Leads_Model->is_customer_email_duplicated_leads_of_leadGen($emails) && $this->Leads_Model->is_customer_email_in_leads_with_sold_status_leadgen($emails)) {
	// 				$formatted_emails[] = '<a href="https://mail.google.com/mail/?view=cm&fs=1&to=' . $emails . '" style="color:teal; font-weight: bold;" target="_blank">' . $emails . '</a>';
	// 				$this->session->userdata['userlogin']['user_id'];
	// 			} elseif ($this->Leads_Model->is_customer_email_duplicated_leads_of_leadGen($emails)) {
	// 				$formatted_emails[] = '<a href="https://mail.google.com/mail/?view=cm&fs=1&to=' . $emails . '" style="color:red;" target="_blank">' . $emails . '</a>';
	// 				$this->session->userdata['userlogin']['user_id'];
	// 			} else {
	// 				$formatted_emails[] = '<a href="https://mail.google.com/mail/?view=cm&fs=1&to=' . $emails . '" style="color:#0056b3;" target="_blank">' . $emails . '</a>';
	// 				$this->session->userdata['userlogin']['user_id'];
	// 			}
	// 		}

	// 		$contacts = explode(',', $lead->customer_contact);
	// 		$formatted_contacts = [];
	// 		foreach ($contacts as $contact) {
	// 			$contact = trim($contact); // Trim whitespace
	// 			if ($lead->sold_author_status == 1 || $this->Leads_Model->is_customer_contact_in_leads_leadgen($contact)) {
	// 				// Apply highlight to customer name if closed
	// 				$formatted_contacts[] = '<a href="tel:' . $contact . '" style="color: teal !important; font-weight: bold;">' . $contact . '</a>';
	// 			} elseif ($this->Leads_Model->is_customer_contact_duplicated_leads_of_leadGen($contact) && $this->Leads_Model->is_customer_contact_in_leads_with_sold_status_leadgen($contact)) {
	// 				$formatted_contacts[] = '<a href="tel:' . $contact . '" style="color:teal; font-weight: bold;">' . $contact . '</a>';
	// 				$this->session->userdata['userlogin']['user_id'];
	// 			} elseif ($this->Leads_Model->is_customer_contact_duplicated_leads_of_leadGen($contact)) {
	// 				// Apply highlight to email if sold
	// 				$formatted_contacts[] = '<a href="tel:' . $contact . '" style="color:red;">' . $contact . '</a>';
	// 				$this->session->userdata['userlogin']['user_id'];
	// 			} else {
	// 				$formatted_contacts[] = '<a href="tel:' . $contact . '" style="color:#0056b3;">' . $contact . '</a>';
	// 				$this->session->userdata['userlogin']['user_id'];
	// 			}
	// 		}

	// 		// Join the formatted contacts back into a string
	// 		$lead->customer_contact = implode(', ', $formatted_contacts);

	// 		$lead->customer_email = implode(', ', $formatted_emails);
	// 	}

	// 	$json_data = array(
	// 		"draw" => $draw,
	// 		"recordsTotal" => $totalData,
	// 		"recordsFiltered" => $totalFiltered,
	// 		"data" => $data,

	// 	);


	// 	echo json_encode($json_data);
	// }
		public function fetch_lead_limit_leadgent_data_lead_status()
{
    $draw = intval($this->input->get("draw"));
    $start = intval($this->input->get("start"));
    $length = intval($this->input->get("length"));
    $search = $this->input->get("search")['value'];
    $lead_id = $this->input->get("lead_id");
    $lead_status = $this->input->get("lead_status");
    $user_id = $this->session->userdata['userlogin']['user_id'];

    // Fetch data
    $data = $this->Leads_Model->get_data_leadagent_lead_status($length, $start, $search, $lead_id, $lead_status, $user_id);
    $totalData = $this->Leads_Model->count_filtered_leadgent_lead_status($search, $lead_id, $user_id);
    $totalFiltered = $this->Leads_Model->count_all_leadgent_lead_status($user_id);

    echo json_encode([
        "draw" => $draw,
        "recordsTotal" => $totalData,
        "recordsFiltered" => $totalFiltered,
        "data" => $data,
    ]);
}

	public function fetch_lead_limit_leadgent_data()
{
    $draw = intval($this->input->get("draw"));
    $start = intval($this->input->get("start"));
    $length = intval($this->input->get("length"));
    $search = $this->input->get("search")['value'];
    $lead_id = $this->input->get("lead_id");
    $lead_status = $this->input->get("lead_status");
    $user_id = $this->session->userdata['userlogin']['user_id'];

    // Fetch data
    $data = $this->Leads_Model->get_data_leadagent($length, $start, $search, $lead_id, $lead_status, $user_id);
    $totalData = $this->Leads_Model->count_filtered_leadgent($search, $lead_id, $user_id);
    $totalFiltered = $this->Leads_Model->count_all_leadgent($user_id);

    foreach ($data as &$lead) {
        // Format customer name
        $isSold = $lead->sold_author_status == 1;
        $isDuplicateName = $this->Leads_Model->is_customer_name_duplicated($lead->customer_name);
        $isDuplicateLeadGen = $this->Leads_Model->is_customer_name_duplicated_leads_of_leadGen($lead->customer_name);
        $isSoldNameInLead = $this->Leads_Model->is_customer_name_in_leads_with_sold_status_leadgen($lead->customer_name);

        if ($isSold || ($isDuplicateLeadGen && $isSoldNameInLead)) {
            $lead->customer_name = '<span style="color:teal; font-weight: bold;">' . $lead->customer_name . '</span>';
        } elseif ($isDuplicateName) {
            $lead->customer_name = '<span style="color:red;">' . $lead->customer_name . '</span>';
        }

        // Format emails
        $emails = array_map('trim', explode(',', $lead->customer_email));
        $formatted_emails = array_map(function($email) use ($isSold) {
            $style = 'color:#0056b3;';
            if ($isSold || $this->Leads_Model->is_customer_email_in_leads_leadgen($email)) {
                $style = 'color: teal !important; font-weight: bold;';
            } elseif (
                $this->Leads_Model->is_customer_email_duplicated_leads_of_leadGen($email) &&
                $this->Leads_Model->is_customer_email_in_leads_with_sold_status_leadgen($email)
            ) {
                $style = 'color:teal; font-weight: bold;';
            } elseif ($this->Leads_Model->is_customer_email_duplicated_leads_of_leadGen($email)) {
                $style = 'color:red;';
            }
            return '<a href="https://mail.google.com/mail/?view=cm&fs=1&to=' . $email . '" style="' . $style . '" target="_blank">' . $email . '</a>';
        }, $emails);

        // Format contacts
        $contacts = array_map('trim', explode(',', $lead->customer_contact));
        $formatted_contacts = array_map(function($contact) use ($isSold) {
            $style = 'color:#0056b3;';
            if ($isSold || $this->Leads_Model->is_customer_contact_in_leads_leadgen($contact)) {
                $style = 'color: teal !important; font-weight: bold;';
            } elseif (
                $this->Leads_Model->is_customer_contact_duplicated_leads_of_leadGen($contact) &&
                $this->Leads_Model->is_customer_contact_in_leads_with_sold_status_leadgen($contact)
            ) {
                $style = 'color:teal; font-weight: bold;';
            } elseif ($this->Leads_Model->is_customer_contact_duplicated_leads_of_leadGen($contact)) {
                $style = 'color:red;';
            }
            return '<a href="tel:' . $contact . '" style="' . $style . '">' . $contact . '</a>';
        }, $contacts);

        $lead->customer_email = implode(', ', $formatted_emails);
        $lead->customer_contact = implode(', ', $formatted_contacts);
    }

    echo json_encode([
        "draw" => $draw,
        "recordsTotal" => $totalData,
        "recordsFiltered" => $totalFiltered,
        "data" => $data,
    ]);
}

	public function fetch_lead_limit_agent_data()
	{
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$search = $this->input->get("search")['value'];
		$lead_id = $this->input->get("lead_id");


		$data = $this->Leads_Model->get_data_agent($length, $start, $search, $lead_id, $this->session->userdata['userlogin']['user_id']);
		$totalData = $this->Leads_Model->count_filtered_agent($search, $lead_id, $this->session->userdata['userlogin']['user_id']);
		$totalFiltered = $this->Leads_Model->count_all_agent($this->session->userdata['userlogin']['user_id']);


		// foreach ($data as &$lead ) {
		// 	if ($this->is_customer_name_duplicated_leads_of_agent($lead->customer_name)) {
		// 		$lead->customer_name = '<span style="color:red;">' . $lead->customer_name . '</span>';
		// 		$this->session->userdata['userlogin']['user_id'];
		// 	}


		// 	$emails = explode(',', $lead->customer_email);
		// 	$formatted_emails = [];

		// 	foreach ($emails as $emails) {
		// 		$emails = trim($emails); // Trim whitespace
		// 		if ($this->is_customer_email_duplicated_leads_of_agent($emails)) {
		// 			$formatted_emails[] = '<a href="https://mail.google.com/mail/?view=cm&fs=1&to=' . $emails . '" style="color:red;" target="_blank">' . $emails . '</a>';
		// 			$this->session->userdata['userlogin']['user_id'];
		// 		} else {
		// 			$formatted_emails[] = '<a href="https://mail.google.com/mail/?view=cm&fs=1&to=' . $emails . '" style="color:#0056b3;" target="_blank">' . $emails . '</a>';
		// 				$this->session->userdata['userlogin']['user_id'];
		// 		}
		// 	}

		// 	$contacts = explode(',', $lead->customer_contact);
		// 	$formatted_contacts = [];
		// 	foreach ($contacts as $contact) {
		// 		$contact = trim($contact); // Trim whitespace
		// 		if ($this->is_customer_contact_duplicated_leads_of_agent($contact)) {
		// 			$formatted_contacts[] = '<a href="tel:' . $contact . '" style="color:red;">' . $contact . '</a>';
		// 			$this->session->userdata['userlogin']['user_id'];
		// 		} else {
		// 			$formatted_contacts[] = '<a href="tel:' . $contact . '" style="color:#0056b3;">' . $contact . '</a>';
		// 			$this->session->userdata['userlogin']['user_id'];
		// 		}
		// 	}

		// 	// Join the formatted contacts back into a string
		// 	$lead->customer_contact = implode(', ', $formatted_contacts);

		// 	$lead->customer_email = implode(', ', $formatted_emails);
		// }

		$json_data = array(
			"draw" => $draw,
			"recordsTotal" => $totalData,
			"recordsFiltered" => $totalFiltered,
			"data" => $data,

		);

		echo json_encode($json_data);
	}


	// private function is_customer_name_duplicated_leads_of_agent($customer_name)
	// {
	// 	$this->db->select('COUNT(*) as count', 'agents.*');
	// 	$this->db->from('tblleads');
	// 	$this->db->join('tblassign_agent as agents', 'tblleads.lead_id = agents.lead_id', 'inner');
	// 	$this->db->where('customer_name', $customer_name);
	// 	$query = $this->db->get();
	// 	return $query->row()->count > 1;
	// }

	// private function is_customer_email_duplicated_leads_of_agent($customer_email) {
	// 	$this->db->select('COUNT(*) as count', 'agents.*');
	// 	$this->db->from('tblleads');
	// 	$this->db->join('tblassign_agent as agents', 'tblleads.lead_id = agents.lead_id', 'inner');
	// 	$this->db->where('customer_email', $customer_email);
	// 	$query = $this->db->get();
	// 	return $query->row()->count > 1;
	// }

	// private function is_customer_contact_duplicated_leads_of_agent($customer_contact) {
	// 	$this->db->select('COUNT(*) as count', 'agents.*');
	// 	$this->db->from('tblleads');
	// 	$this->db->join('tblassign_agent as agents', 'tblleads.lead_id = agents.lead_id', 'inner');
	// 	$this->db->where('customer_contact', $customer_contact);
	// 	$query = $this->db->get();
	// 	return $query->row()->count > 1;
	// }


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

	public function fetch_lead_limit_leadgent_data_modal()
	{
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$search = $this->input->get("search")['value'];

		$data = $this->Leads_Model->get_data_lead_leadgent_modal($length, $start, $search);
		$totalData = $this->Leads_Model->count_all_leadgent_modal();
		$totalFiltered = $this->Leads_Model->count_filtered_leadgent_modal($search);

		$json_data = array(
			"draw" => $draw,
			"recordsTotal" => $totalData,
			"recordsFiltered" => $totalFiltered,
			"data" => $data,

		);

		echo json_encode($json_data);
	}

	public function fetch_lead_limit_agent_data_modal()
	{
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$search = $this->input->get("search")['value'];



		$data = $this->Leads_Model->get_data_lead_agent_modal($length, $start, $search, $this->session->userdata['userlogin']['user_id']);
		$totalData = $this->Leads_Model->count_all_agent_modal($this->session->userdata['userlogin']['user_id']);
		$totalFiltered = $this->Leads_Model->count_filtered_agent_modal($search, $this->session->userdata['userlogin']['user_id']);

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
		$title = $this->input->post('title') == "" ? array() : $this->input->post('title');
		$bookLink = $this->input->post('bookLink') == "" ? array() : $this->input->post('bookLink');
		$contact = $this->input->post('customer_contact') == "" ? array() : $this->input->post('customer_contact');
		$email = $this->input->post('customer_email') == "" ? array() : $this->input->post('customer_email');

		$titleString = implode(',', $title);
		$bookLinkString = implode(',', $bookLink);
		$contactsString = implode(',', $contact); // Convert Customer contact array to comma-separated string
		$emailsString = implode(',', $email); // Convert Customer Email  array to comma-separated string


		$data = array(
			'brand_name' => $this->input->post('brandName'),
			'title' => $titleString,
			// 'description' => $this->input->post('desc') ,
			// 'lead_value' => $this->input->post('value'),
			'book_link' => $bookLinkString,
			'source' => $this->input->post('source'),
			// 'user_id' => $this->input->post('assign_to'),
			// 'priority' => $this->input->post('priority'),
			'customer_name' => $this->input->post('customer_name'),
			'customer_address' => $this->input->post('customer_address'),
			// 'customer_address'  => $this->input->post('customer_address'),
			// 'customer_address'  => $this->input->post('customer_address'),
			'lead_status' => $this->input->post('statusData'),

			// 'lead_status' =>  "Active",
			// 'lead_status' =>  $this->session->userdata['userlogin']['usertype'] == 'Lead Gen.' ? "Active Leads" : "",
			'lead_status_assign_leadgent' => $this->session->userdata['userlogin']['usertype'] == 'Lead Gen.' ? 1 : 0,
			'customer_contact' => $contactsString,
			'customer_email' => $emailsString,
			'date_created' => date("Y-m-d H:i:s"),

		);



		$this->Leads_Model->insert($data);
		$lead_id = $this->db->insert_id();


		if ($this->session->userdata['userlogin']['usertype'] == 'Lead Gen.') {
			$leadgent_tasks_data = [
				'lead_id' => $lead_id,
				'leadgent_user_id' => $this->session->userdata['userlogin']['user_id'],
				// 'remarks' => $remarks,
				'status_assign' => "Not yet open",
				'date_assigned' => date('Y-m-d H:i:s'),

			];
			$data_activities = array(
				'lead_id' => $lead_id,
				'remarks' => "Added Lead",
				'unread_admin' => 1,
				'admin_id' => 1,
				'user_charge' => $this->session->userdata['userlogin']['full_name'],
				'date_added' => date("Y-m-d H:i:s"),
			);

			$this->Leadgents_Model->insert($leadgent_tasks_data);
			$this->Activity_Model->insert($data_activities);
		}

		echo json_encode(array("response" => "success", "message" => "", "redirect" => base_url('dashboard')));
	}

	private function isRowEmpty($row)
	{
		return count(array_filter($row)) === 0; // Check if all columns are empty
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
			$numberOfFields = 12;
			fgetcsv($handle);  //SKIP THE FIRST ROW
			$duplicates = 0;

			while (($filesop = fgetcsv($handle, 1000, ",")) !== false) {
				if ($this->isRowEmpty($filesop)) {
					continue; // Skip empty rows
				}
			
				$customer_name = trim($filesop[4]); // Adjust index if necessary
				$customer_contact = trim($filesop[6]);
				$customer_email = trim($filesop[7]);
			
				// Skip if customer name is empty or both contact and email are empty
				if (empty($customer_name) || (empty($customer_contact) && empty($customer_email))) {
					$duplicates++; // Consider incomplete rows as duplicates (or optionally skip without increment)
					continue;
				}
			
				// Check for uniqueness (we want to upload only if either contact or email is unique)
				$is_duplicate_name_contact = $this->Leads_Model->checkDuplicateNameContact($customer_name, $customer_contact);
				$is_duplicate_name_email = $this->Leads_Model->checkDuplicateNameEmail($customer_name, $customer_email);
				$is_duplicate_contact_email = $this->Leads_Model->checkDuplicateContactEmail($customer_contact, $customer_email);
			
				// Logic to handle duplicates
				if (empty($customer_contact) && !empty($customer_email)) {
					// Check if name and email combination exists (without checking contact)
					if ($is_duplicate_name_email) {
						$duplicates++;
						continue; // Skip duplicate with name and email
					}
				} elseif (empty($customer_email) && !empty($customer_contact)) {
					// Check if name and contact combination exists (without checking email)
					if ($is_duplicate_name_contact) {
						$duplicates++;
						continue; // Skip duplicate with name and contact
					}
				} elseif (!empty($customer_email) && !empty($customer_contact)) {
					// Skip if contact and email combination already exists (even with different name)

					if ($is_duplicate_contact_email) {
						$duplicates++;
						continue; // Skip duplicate with name and contact
					}
					if ($is_duplicate_name_email) {
						$duplicates++;
						continue; // Skip duplicate with name and email
					}
				}
				if ($is_duplicate_name_contact) {
					$duplicates++;
					continue; // Skip duplicate with name and contact
				}
				// elseif ($is_duplicate_name_contact && $is_duplicate_name_email && $is_duplicate_contact_email) {
				// 	// If both contact and email combinations are duplicated, skip
				// 	$duplicates++;
				// 	continue; // Skip duplicate
				// }

				$data = array(
					'brand_name' => $filesop[0],
					'title' => $filesop[1],
					'book_link' => $filesop[2],
					'source' => $filesop[3],
					'customer_name' => $customer_name,
					'customer_address' => $filesop[5],
					'customer_contact' => $customer_contact,
					'customer_email' => $customer_email,
					'lead_status' => $filesop[8],
					'sales_remarks' => $filesop[9],
					'date_created' => date("Y-m-d H:i:s"),
				);

				$this->Leads_Model->insert($data);
				// $this->Activity_Model->insert($data_activities);
				$c++;
			}
			fclose($handle);
			$this->session->set_flashdata('success', "Import completed. Imported: $c, Duplicates skipped: $duplicates.");
			redirect('leads');
		}
	}


	public function upload_lead_leadgen()
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
			$numberOfFields = 12;
			fgetcsv($handle);  //SKIP THE FIRST ROW


			while (($filesop = fgetcsv($handle, 1000, ",")) !== false) {
				if ($this->isRowEmpty($filesop)) {
					continue; // Skip empty rows
				}
			
				$customer_name = trim($filesop[4]); // Adjust index if necessary
				$customer_contact = trim($filesop[6]);
				$customer_email = trim($filesop[7]);
			
				// Skip if customer name is empty or both contact and email are empty
				if (empty($customer_name) || (empty($customer_contact) && empty($customer_email))) {
					$duplicates++; // Consider incomplete rows as duplicates (or optionally skip without increment)
					continue;
				}
			
				// Check for uniqueness (we want to upload only if either contact or email is unique)
				$is_duplicate_name_contact = $this->Leads_Model->checkDuplicateNameContact($customer_name, $customer_contact);
				$is_duplicate_name_email = $this->Leads_Model->checkDuplicateNameEmail($customer_name, $customer_email);
				$is_duplicate_contact_email = $this->Leads_Model->checkDuplicateContactEmail($customer_contact, $customer_email);
			
				// Logic to handle duplicates
				// Logic to handle duplicates
				if (empty($customer_contact) && !empty($customer_email)) {
					// Check if name and email combination exists (without checking contact)
					if ($is_duplicate_name_email) {
						$duplicates++;
						continue; // Skip duplicate with name and email
					}
				} elseif (empty($customer_email) && !empty($customer_contact)) {
					// Check if name and contact combination exists (without checking email)
					if ($is_duplicate_name_contact) {
						$duplicates++;
						continue; // Skip duplicate with name and contact
					}
				} elseif (!empty($customer_email) && !empty($customer_contact)) {
					// Skip if contact and email combination already exists (even with different name)

					if ($is_duplicate_contact_email) {
						$duplicates++;
						continue; // Skip duplicate with name and contact
					}
					if ($is_duplicate_name_email) {
						$duplicates++;
						continue; // Skip duplicate with name and email
					}
				}
				if ($is_duplicate_name_contact) {
					$duplicates++;
					continue; // Skip duplicate with name and contact
				}

				$data = array(
					// 'brand_name' => $filesop[0],
					// 'title' => $filesop[1],
					// 'source' => $this->session->userdata['userlogin']['full_name'],
					// 'book_link' => $filesop[2],
					// 'customer_name' => $customer_name,
					// 'customer_address' => $filesop[5],
					// 'customer_contact' => $customer_contact,
					// 'customer_email' => $customer_email,
					// 'lead_status' => $filesop[8],
					// 'sales_remarks' => $filesop[9],
					'brand_name' => $filesop[0],
					'title' => $filesop[1],
					'book_link' => $filesop[2],
					'source' => $filesop[3],
					'customer_name' => $customer_name,
					'customer_address' => $filesop[5],
					'customer_contact' => $customer_contact,
					'customer_email' => $customer_email,
					'lead_status' => $filesop[8],
					'sales_remarks' => $filesop[9],
					'lead_status_assign_leadgent' => 1,
					'date_created' => date("Y-m-d H:i:s"),
				);

				$this->Leads_Model->insert($data);
				// $this->Activity_Model->insert($data_activities);
				$lead_id = $this->db->insert_id();


				$leadgent_tasks_data = [
					'lead_id' => $lead_id,
					'leadgent_user_id' => $this->session->userdata['userlogin']['user_id'],
					// 'remarks' => $remarks,
					'status_assign' => "Not yet open",
					'date_assigned' => date('Y-m-d H:i:s'),

				];
				$this->Leadgents_Model->insert($leadgent_tasks_data);

				$c++;
			}
			fclose($handle);
			$data_activities = array(
				'remarks' => "Uploaded $c Total Leads",
				'admin_id' => 1,
				'unread_admin' => 1,
				'status_activity' => 6,
				'user_charge' => $this->session->userdata['userlogin']['full_name'],
				'date_added' => date("Y-m-d H:i:s"),
			);
			$this->Activity_Model->insert($data_activities);

			$this->session->set_flashdata('success', "Import completed. Imported: $c, Duplicates skipped: $duplicates.");
			redirect('leadgent');
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
		$this->Leads_Model->update(array('customer_contact' => $data_customer_contact), $this->input->get('lead_id'));

		echo json_encode(array("response" => "", "message" => "Successfully Deleted Customer Contact"));
	}
	// get LEAD customer email data
	public function delete_lead_email()
	{
		$lead_data = $this->Leads_Model->select_single_row_lead($this->input->get('lead_id'));
		$customer_email = $lead_data['customer_email'];

		$data_customer_email = preg_replace('/\b' . preg_quote($this->input->get('customer_email'), '/') . '\b(,)?/', '', $customer_email);
		$data_customer_email = trim($data_customer_email, ',');
		$this->Leads_Model->update(array('customer_email' => $data_customer_email), $this->input->get('lead_id'));

		echo json_encode(array("response" => "", "message" => "Successfully Deleted Customer Email"));
	}
	// get LEAD customer email data
	public function delete_lead_title()
	{
		$lead_data = $this->Leads_Model->select_single_row_lead($this->input->get('lead_id'));
		$book_title = $lead_data['title'];

		$data_book_title = preg_replace('/\b' . preg_quote($this->input->get('title'), '/') . '\b(,)?/', '', $book_title);
		$data_book_title = trim($data_book_title, ',');
		$this->Leads_Model->update(array('customer_email' => $data_book_title), $this->input->get('lead_id'));

		echo json_encode(array("response" => "", "message" => "Successfully Deleted Customer Email"));
	}
	// update LEADS
	public function update_lead()
	{
		$user_charge = $this->session->userdata['userlogin']['full_name'];

		$contact = $this->input->post('customer_contact') == "" ? array() : $this->input->post('customer_contact');
		$email = $this->input->post('customer_email') == "" ? array() : $this->input->post('customer_email');
		$booklink = $this->input->post('bookLink') == "" ? array() : $this->input->post('bookLink');
		$title = $this->input->post('title') == "" ? array() : $this->input->post('title');

		$contactsString = implode(',', $contact); // Convert Customer contact array to comma-separated string
		$emailsString = implode(',', $email); // Convert Customer Email  array to comma-separated string
		$titleString = implode(',', $title); // Convert Customer contact array to comma-separated string
		$booklinkString = implode(',', $booklink); // Convert Customer Email  array to comma-separated string
		$leadgent_user = $this->Activity_Model->select_leadgent_lead($this->input->post('lead_id'));
		$agent_user = $this->Activity_Model->select_agent_lead($this->input->post('lead_id'));


		$data = array(
			'brand_name' => $this->input->post('brandName'),
			'sales_remarks' => $this->input->post('sales_remarks'),
			'title' => $titleString,
			//   'description' => $this->input->post('desc') ,
			//   'lead_value' => $this->input->post('value'),
			'book_link' => $booklinkString,
			'source' => $this->input->post('source'),
			// 'priority' => $this->input->post('priority'),
			'customer_name' => $this->input->post('customer_name'),
			'customer_address' => $this->input->post('customer_address'),
			'lead_status' => $this->input->post('statusData'),
			'customer_contact' => $contactsString,
			'customer_email' => $emailsString,



		);
		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		// exit();
		if ($this->session->userdata['userlogin']['usertype'] == 'Admin') {
			$data_activities = array(
				'lead_id' => $this->input->post('lead_id'),
				'remarks' => "Updated Lead",
				'unread_leadgent' => $leadgent_user == false ? 0 : 1,
				'unread_agent' => $agent_user == false ? 0 : 1,
				'user_id' => $agent_user == false ? 0 : $agent_user['user_id'],
				'leadgent_user_id' => $leadgent_user == false ? 0 : $leadgent_user['leadgent_user_id'],
				'user_charge' => $this->session->userdata['userlogin']['full_name'],
				'date_added' => date("Y-m-d H:i:s"),
			);
		} else {
			$data_activities = array(
				'lead_id' => $this->input->post('lead_id'),
				'remarks' => "Updated Lead",
				'admin_id' => 1,
				'unread_admin' => 1,
				'unread_agent' => $agent_user == false ? 0 : 1,
				'user_id' => $agent_user == false ? 0 : $agent_user['user_id'],
				'user_charge' => $this->session->userdata['userlogin']['full_name'],
				'date_added' => date("Y-m-d H:i:s"),
			);
		}
		$this->Activity_Model->insert($data_activities);

		$this->Leads_Model->update($data, $this->input->post('lead_id'));
		echo json_encode(array("response" => "success", "message" => "", "redirect" => base_url('dashboard')));
	}


	// get recyle LEAD data
	public function view_lead_recycle_detail()
	{
		$data = array();
		$lead_data = $this->Leads_Model->select_lead($this->input->get('lead_id'));
		$data = $lead_data;
		echo json_encode($data);
	}



	public function update_recycle_status()
	{

		// Prepare data to update
		$data = array(
			'recycle_status' => 0,
			'lead_id' => $this->input->post('lead_id')
		);

		// Update the recycle status

		// Update the recycle status
		if ($this->Leads_Model->update_lead_recycle_status($data)) {
			$this->Recycle_Model->update_recycle_status(array('status' => "Returned"), $this->input->post('recycle_id'));

			echo json_encode(array("response" => "success", "message" => "", "redirect" => base_url('dashboard')));
		} else {
			echo json_encode(array("response" => "error", "message" => "", "redirect" => base_url('dashboard')));
		}
	}



}

