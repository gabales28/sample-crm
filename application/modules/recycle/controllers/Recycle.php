<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Recycle extends MY_Controller
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
		
		// $records['get_recycle_data_lead'] = $this->Recycle_Model->get_recycle_data_lead();
		
		$this->load->view('layout/head');
		$this->load->view('layout/header');
		$this->load->view('layout/nav');
		$this->load->view('recycle', $records);
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

	// 
public function view_recycled_agent_task_detail() { 
	$data=array();
	$task_data =$this->Recycle_Model->select_recycle_agent_task_lead($this->input->get('lead_id')); 
	$data = $task_data;
	echo json_encode($data);             
}
public function fetch_agent_view_recycled_data($lead_id = 0) {
	$data = $this->Recycle_Model->select_view_agent_recycled_task($lead_id);
	$json_data = array("data" => $data);
	echo json_encode($json_data);
}
}
