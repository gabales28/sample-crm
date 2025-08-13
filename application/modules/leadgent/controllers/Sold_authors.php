<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sold_authors extends MY_Controller
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
		$records['lead_id']=  $this->uri->segment(2) == "" ? 0 : $this->uri->segment(2) ;
		$records['lead_status']=  "";


		$this->load->view('layout/head');
		$this->load->view('layout/header');
		$this->load->view('layout/nav-leadgent');
		$this->load->view('sold_author', $records);
		$this->load->view('layout/footer');
	}

	public function fetch_lead_limit_data()
	{
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$search = $this->input->get("search")['value'];
		$lead_status = $this->input->get("lead_status");
		$lead_id = $this->input->get("lead_id");



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
	public function leads($status_lead = ""){


		$records['lead_id'] = 0;
		$status_lead = $this->input->get('status_lead');
	
		$records['lead_status'] = $status_lead;

		$this->load->view('layout/head');
		$this->load->view('layout/header');
		$this->load->view('layout/nav-leadgent');
		$this->load->view('my_leads', $records);
		$this->load->view('layout/footer');

	}
	

}
