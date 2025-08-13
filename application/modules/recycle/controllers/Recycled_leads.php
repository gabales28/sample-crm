<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Recycled_leads extends MY_Controller
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
		$records['return_to_lead_control_data'] = $this->Recycle_Model->view_return_to_lead_control_data();
		
		// $records['get_recycle_data_lead'] = $this->Recycle_Model->get_recycle_data_lead();
		
		$this->load->view('layout/head');
		$this->load->view('layout/header');
		$this->load->view('layout/nav');
		$this->load->view('recycled_leads', $records);
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


public function save_return_lead_control_form() {
	$checked_tasks = $this->input->post('checked_tasks') == "" ? array() : $this->input->post('checked_tasks');
	// $unchecked_agent_tasks = $this->input->post('unchecked_tasks') == "" ? 0 : $this->input->post('unchecked_tasks');
	// $unchecked_Lead = $this->input->post('unchecked_Lead') == "" ? 0 : $this->input->post('unchecked_Lead');
	$checked_Lead = $this->input->post('checked_Lead') == "" ? 0 : $this->input->post('checked_Lead');
	// $agent_task_id = $this->input->post('get_agent_task_id');
	// $lead_id = $this->input->post('lead_id');
	$leadgent_user_id = $this->input->post('leadgent_user_id');
	// $recycle_id = $this->input->post('recycle_id');


	// $user = $this->User_Model->view_single_user($this->input->post('assign_to'));
	// echo "<pre>";
	// print_r($checked_tasks);
	// echo "</pre>";
	// exit();

	$valuesArray1 = explode(",", $checked_Lead);
	$valuesArray2 = explode(",", $checked_tasks);


	$combinedArray = [];
	foreach ($valuesArray1 as $index => $lead) {
		$combinedArray[] = [
			'lead_id' => (int)trim($lead),
			'agent_task_id' => (int)trim($valuesArray2[$index])
		];
	}
	

	foreach ($combinedArray  as $key => $lead_agent) {
		// $this->Agents_Model->update_agent_tasks($id, $data);
			$data =  array(
				'lead_id' =>  $lead_agent['lead_id']	,
				'leadgent_user_id' =>  $leadgent_user_id,
				'previous_agent'  => $this->input->post('previous_agent'),
				'agent_id'  => $this->input->post('existing_user_id'),
				'agent_task_id'  => $lead_agent['agent_task_id'],
				'return_status'  => 'Park',
				'lead_gen_name'  =>  $this->session->userdata['userlogin']['full_name'],
				'date_return_to_lead_control' =>  date("Y-m-d H:i:s"),					
			);
			$this->Recycle_Model->insert_return_to_lead_control_data($data);

			$data_activities = array(
				'lead_id' =>  $lead_agent['lead_id'],
				'remarks' => "Recycled Lead",
				'admin_id' => 1,
				'unread_admin' => 1,
				'status_activity' => 5,
				'user_charge' => $this->session->userdata['userlogin']['full_name'],
				'date_added' => date("Y-m-d H:i:s"),
			);
			$this->Activity_Model->insert($data_activities);

	}
	// echo "<pre>";
	// print_r($data);
	// echo "</pre>";
	// exit();

	$this->Recycle_Model->update_return_lead_control(array('return_to_lead_control' => 1), explode(",", $checked_Lead));
	$this->Leads_Model->update_lead_status_assign(array('lead_status_assign' => 0, 'lead_status_assign_leadgent' => 0), explode(",", $checked_Lead));
	$this->Agents_Model->update_lead_status_assign(array('lead_assign' => 2), explode(",", $checked_Lead));
	$this->Leadgents_Model->update_lead_status_assign(array('lead_status_leadgent' => 2), explode(",", $checked_Lead));


	echo json_encode(array("response" =>   "success", "message" => "", "redirect" => base_url('tasks')));
}




public function fetch_recycled_leads_data($user_id = 0, $date_assigned = "") {
	$search = $this->input->get("search")['value'] ?? "";
	$data = $this->Recycle_Model->select_recycled_leads_data($user_id, $date_assigned, $search);

	$json_data = array("data" => $data);

	echo json_encode($json_data);
}


public function view_recycled_lead_details() { 
	$data=array();
	$task_data =$this->Recycle_Model->select_recycled_leads_task($this->input->get('agent_task_id')); 
	$data = $task_data;
	echo json_encode($data);             
}




// public function update_recycle_status()
// 	{

// 		// Prepare data to update
// 		$data = array(
// 			'recycle_status' => 0,
// 			'lead_id' => $this->input->post('lead_id')
// 		);

// 		// Update the recycle status

// 		// Update the recycle status
// 		if ($this->Leads_Model->update_lead_recycle_status($data)) {
// 			$this->Recycle_Model->update_recycle_status(array('status' => "Returned"),  $this->input->post('recycle_id'));

// 			echo json_encode(array("response" => "success", "message" => "", "redirect" => base_url('dashboard')));
// 		} else {
// 			echo json_encode(array("response" => "error", "message" => "", "redirect" => base_url('dashboard')));
// 		}
// 	}


public function update_return_lead_backet_data() {
	$checked_tasks = $this->input->post('checked_tasks') == "" ? array() : $this->input->post('checked_tasks');
	// $unchecked_agent_tasks = $this->input->post('unchecked_tasks') == "" ? 0 : $this->input->post('unchecked_tasks');
	// $unchecked_Lead = $this->input->post('unchecked_Lead') == "" ? 0 : $this->input->post('unchecked_Lead');
	$checked_Lead = $this->input->post('checked_Lead') == "" ? 0 : $this->input->post('checked_Lead');
	// $agent_task_id = $this->input->post('get_agent_task_id');
	// $lead_id = $this->input->post('lead_id');
	$leadgent_user_id = $this->input->post('leadgent_user_id');
	// $recycle_id = $this->input->post('recycle_id');


	// $this->Recycle_Model->update_return_lead_control(array('return_to_lead_control' => 1), explode(",", $checked_Lead));
	$this->Recycle_Model->update_return_lead_backet_data_status(array('return_status' => 'Returned'), explode(",", $checked_tasks));
	$this->Leads_Model->update_return_lead_backet_data_detail(array('return_to_lead_control' => 0), explode(",", $checked_Lead));

	echo json_encode(array("response" =>   "success", "message" => "", "redirect" => base_url('tasks')));
}


}
