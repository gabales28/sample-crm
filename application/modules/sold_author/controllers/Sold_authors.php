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
		$records['get_lead_authors'] = $this->Leads_Model->get_lead_authors();
		// $records['get_authors_data'] = $this->Sold_author_Model->get_authors_data($this->session->userdata['userlogin']['user_id']);
		$records['tableleads'] = $this->Leads_Model->tableleads();
		$records['activities'] = $this->Activity_Model->tableactivities();
		$records['leadgent_users'] = $this->User_Model->view_account_leadgent();
		// $records['closed_leads'] = $this->Leads_Model->get_closed_leads();
        $records['sold_closed_leads'] = $this->Leads_Model->get_sold_closed_leads();
		$records['agent_users'] = $this->User_Model->select_agents_for_their_sold_author();

		// $records['get_recycle_data_lead'] = $this->Recycle_Model->get_recycle_data_lead();
		
		$this->load->view('layout/head');
		$this->load->view('layout/header');
		$this->load->view('layout/nav');
		$this->load->view('sold_authors', $records);
		$this->load->view('layout/footer');
	}
	
	public function fetch_lead_data()
	{
		$data = array();
		$lead_data = $this->Leads_Model->fech_lead_category();
		$data = $lead_data;
		echo json_encode($data);
	}
	public function fetch_lead_limit_recycle_data()
	{
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$search = $this->input->get("search")['value'];
		$lead_status = $this->input->get("lead_status");
		$lead_id = $this->input->get("lead_id");
		$user_id = $this->input->get("user_id");

		$data = $this->Recycle_Model->get_recycled_view_agenttask_data_lead($length, $start, $search, $lead_id, $lead_status);
		$totalData = $this->Recycle_Model->count_recycle_filtered_view_agent_task($search, $lead_id, $lead_status);
		$totalFiltered = $this->Recycle_Model->count_recycle_filtered_view_agent_task();
		
		$json_data = array(
			"draw" => $draw,
			"recordsTotal" => $totalData,
			"recordsFiltered" => $totalFiltered,
			"data" => $data,

		);

		echo json_encode($json_data);
	}
		public function fetch_lead_limit_agent_data_sold_leads()
{
    $draw = intval($this->input->get("draw"));
    $start = intval($this->input->get("start"));
    $length = intval($this->input->get("length"));
    $search = $this->input->get("search")['value'];
    $lead_id = $this->input->get("lead_id");

    // Fetch data
    $data = $this->Sold_author_model->get_data_sold_leads($length, $start, $search, $lead_id, );
    $totalData = $this->Sold_author_model->count_filtered_sold_leads($search, $lead_id);
    $totalFiltered = $this->Sold_author_model->count_all_sold_leads();

    echo json_encode([
        "draw" => $draw,
        "recordsTotal" => $totalData,
        "recordsFiltered" => $totalFiltered,
        "data" => $data,
    ]);
}

public function fetch_lead_limit_agent_data_sold_leads_drodown()
{
    $draw = intval($this->input->get("draw"));
    $start = intval($this->input->get("start"));
    $length = intval($this->input->get("length"));
    $search = $this->input->get("search")['value'];
    $user_id = $this->input->get("user_id");


    $data = $this->Sold_author_model->get_data_sold_leads_dropdown($length, $start, $search, 0, $user_id);
	$totalFiltered = $this->Sold_author_model->count_filtered_sold_leads_dropdown($search, 0, $user_id);
	$totalData = $this->Sold_author_model->count_all_sold_leads_dropdown($user_id);


    echo json_encode([
        "draw" => $draw,
        "recordsTotal" => $totalData,
        "recordsFiltered" => $totalFiltered,
        "data" => $data,
    ]);
}




	// public function add_sold_author()
	// {
		
	// 	$contact = $this->input->post('customer_contact') == "" ? array() : $this->input->post('customer_contact');
	// 	$email = $this->input->post('customer_email') == "" ? array() : $this->input->post('customer_email');

	// 	$contactsString = implode(',', $contact); // Convert Customer contact array to comma-separated string
	// 	$emailsString = implode(',', $email); // Convert Customer Email  array to comma-separated string


	// 	$data =  array(
		
	// 		'customer_name'  => $this->input->post('customer_name'),
	// 		// 'lead_status_assign_leadgent' => $this->session->userdata['userlogin']['usertype'] == 'Lead Gen.' ? 1 : 0,
	// 		'customer_contact'  => $contactsString,
	// 		'customer_email'  => $emailsString,
	// 		'date_created' =>  date("Y-m-d H:i:s"),

	// 	);
	// 	// echo "<pre>";
	// 	// print_r($data);
	// 	// echo "</pre>";
	// 	// exit();

	// 	$this->Sold_author_Model->insert_authors_data($data);


	// 	echo json_encode(array("response" =>   "success", "message" => "", "redirect" => base_url('dashboard')));
	// }

	// public function view_sold_author_detail()
	// {
	// 	$data = array();
	// 	$sold_author_data = $this->Sold_author_Model->select_sold_author($this->input->get('sold_author_id'));
	// 	$data = $sold_author_data;
	// 	echo json_encode($data);

	// 	// echo "<pre>";
	// 	// print_r($data);
	// 	// echo "</pre>";
	// 	// exit();
	// }




	// public function edit_sold_author()
	// {
		
	// 	$contact = $this->input->post('customer_contact') == "" ? array() : $this->input->post('customer_contact');
	// 	$email = $this->input->post('customer_email') == "" ? array() : $this->input->post('customer_email');

	// 	$contactsString = implode(',', $contact); // Convert Customer contact array to comma-separated string
	// 	$emailsString = implode(',', $email); // Convert Customer Email  array to comma-separated string


	// 	$data =  array(
	// 		'customer_name'  => $this->input->post('customer_name'),
	// 		// 'lead_status_assign_leadgent' => $this->session->userdata['userlogin']['usertype'] == 'Lead Gen.' ? 1 : 0,
	// 		'customer_contact'  => $contactsString,
	// 		'customer_email'  => $emailsString,
	// 		'date_created' =>  date("Y-m-d H:i:s"),

	// 	);
	// 	// echo "<pre>";
	// 	// print_r($data);
	// 	// echo "</pre>";
	// 	// exit();

	// 	$this->Sold_author_Model->update_authors_data($data, $this->input->post('sold_author_id'));


	// 	echo json_encode(array("response" =>   "success", "message" => "", "redirect" => base_url('dashboard')));
	// }
	


}
