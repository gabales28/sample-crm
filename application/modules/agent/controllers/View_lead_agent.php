<?php
defined('BASEPATH') or exit('No direct script access allowed');

class View_lead_agent extends MY_Controller
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

	}
	public function index()
	{

		$records['tabletasks'] = $this->Tasks_Model->tabletasks();
		$records['agent_users'] = $this->User_Model->view_account_leadgent_sales($this->session->userdata['userlogin']['user_id']);
		$records['agent_tasks'] = $this->Agents_Model->view_agent_tasks($this->session->userdata['userlogin']['user_id']);
		$records['leads'] = $this->Leads_Model->tableleads();
		
		$this->load->view('layout/head');
		$this->load->view('layout/header');
		$this->load->view('layout/nav-agent');
		$this->load->view('view_lead_agent', $records);
		$this->load->view('layout/footer');
	}

	public function fetch_agent_view_data($user_id = 0, $date_assigned = "") {
		$data = $this->Agents_Model->select_agent_task($user_id, $date_assigned);

		$json_data = array("data" => $data);

		echo json_encode($json_data);
	}

// end list of task


		  
}


