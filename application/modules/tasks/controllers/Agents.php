<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Agents extends MY_Controller
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

		$records['tableagents'] = $this->Agents_Model->tableagents();
		$records['leadgent_users'] = $this->User_Model->view_account_leadgent();
		$records['leads'] = $this->Leads_Model->tableleads();


		$this->load->view('layout/head');
		$this->load->view('layout/header');
		$this->load->view('layout/nav');
		$this->load->view('agents', $records);
		$this->load->view('layout/footer');
	}

	public function view_agent_task_detail() { 
		$data=array();
		$task_data =$this->Agents_Model->select_agent_task_lead($this->input->get('agent_task_id')); 
		$data = $task_data;
		echo json_encode($data);             
}


	public function fetch_legent_agent_limit_data() {
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$search = $this->input->get("search")['value'];



		$data = $this->Agents_Model->get_data_agent_task($length, $start, $search);
		$totalData = $this->Agents_Model->count_all();	
		$totalFiltered = $this->Agents_Model->count_filtered($search);

		$json_data = array(
			"draw" => $draw,
			"recordsTotal" => $totalData,
			"recordsFiltered" => $totalFiltered,
			"data" => $data,
			
		);

		echo json_encode($json_data);
	}

	public function fetch_agent_view_data($agent_task_id = 0, $date_assigned = "") {
		// $task_id = $this->input->get();
		$data = $this->Agents_Model->select_agent_task($agent_task_id, $date_assigned);
		

		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		// exit();


		$json_data = array("data" => $data);

		echo json_encode($json_data);
	}
	
	
	public function fetch_agent_view_data_lead($agent_task_id = 0, $date_assigned = "") {
		// $task_id = $this->input->get();
		$data = $this->Agents_Model->select_agent_task($agent_task_id, $date_assigned);
		

		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		// exit();


		$json_data = array("data" => $data);

		echo json_encode($json_data);
	}
   public function fetch_agent_task_data(){
		$data=array();
		$agent_task_data =$this->Agents_Model->fech_agent_task_category(); 
		$data = $agent_task_data;
		echo json_encode($data);      
	}

// end list of tasks

		  
	}


