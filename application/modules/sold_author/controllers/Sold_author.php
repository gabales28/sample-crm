<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sold_author extends MY_Controller
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
		$records['closed_leads'] = $this->Leads_Model->get_closed_leads();
		$records['agent_users'] = $this->User_Model->select_agents_for_their_sold_author();

		// $records['get_recycle_data_lead'] = $this->Recycle_Model->get_recycle_data_lead();
		
		$this->load->view('layout/head');
		$this->load->view('layout/header');
		$this->load->view('layout/nav-leadgent');
		$this->load->view('sold_author', $records);
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

}
