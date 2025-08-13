<?php
defined('BASEPATH') or exit('No direct script access allowed');

class View_Sales_Tasks extends MY_Controller
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
		$records['agent_tasks'] = $this->Agents_Model->agent_group_task($this->session->userdata['userlogin']['user_id']);
		$records['leads'] = $this->Leads_Model->tableleads();
		$records['lead_id']=  $this->uri->segment(2) == "" ? 0 : $this->uri->segment(2) ;
		$records['lead_status']=  "";



		$this->load->view('layout/head');
		$this->load->view('layout/header');
		$this->load->view('layout/nav-leadgent');
		$this->load->view('view_sales_tasks', $records);
		$this->load->view('layout/footer');
	}

	// get Tasks data
	public function view_Task_detail()
	{
		$data = array();
		$task_data = $this->Tasks_Model->select_task($this->input->get('task_id'));
		$data = $task_data;
		echo json_encode($data);
	}


	public function fetch_task_limit_data()
	{
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$search = $this->input->get("search")['value'];



		$data = $this->Tasks_Model->get_data_task($length, $start, $search);
		$totalData = $this->Tasks_Model->count_all();
		$totalFiltered = $this->Tasks_Model->count_filtered($search);

		$json_data = array(
			"draw" => $draw,
			"recordsTotal" => $totalData,
			"recordsFiltered" => $totalFiltered,
			"data" => $data,

		);

		echo json_encode($json_data);
	}

	public function fetch_edit_data($task_id = 0, $date_assigned = "")
	{
		// $task_id = $this->input->get();
		$data = $this->Tasks_Model->select_lead_task($task_id, $date_assigned);


		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		// exit();


		$json_data = array("data" => $data);

		echo json_encode($json_data);
	}

	public function fetch_task_data()
	{
		$data = array();
		$task_data = $this->Tasks_Model->fech_task_category();
		$data = $task_data;
		echo json_encode($data);
	}

	///Assign Leadgent to agent

	public function save_agent_tasks()
	{
		$leads = $this->input->post('lead_ids');
		$assign_to = $this->input->post('assign_to');
		// $priority = $this->input->post('priority');
		$remarks = $this->input->post('remarks');
		$lead_status = $this->input->post('lead_status');
		$user = $this->User_Model->view_single_user($this->input->post('assign_to'));



		$leadgent_tasks_data = [];
		$data_activities = [];

		foreach ($leads as $lead_id) {
			$agent_tasks_data[] = [
				'lead_id' => $lead_id,
				'user_id' => $assign_to,
				'leadgent_user_id' => $this->session->userdata['userlogin']['user_id'],
				// 'remarks' => $remarks,
				'Priority' => "Pending",
				'status_assign' => "Not yet open",
				'agent_date_assigned' => date('Y-m-d H:i:s'),


			];

			$this->Leads_Model->update(array('lead_status_assign' => 1), $lead_id);
		}

		if ($this->Agents_Model->save_agent_tasks($agent_tasks_data)) {
			$data_activities =  array(
				'unread_agent' =>   1,
				'admin_id' =>   1,
				'unread_admin' =>   1,
				'user_id'  => $assign_to,
				'status_activity' =>  2,
				'remarks' =>   "Agent have been given the task of " . $this->input->post('total_leads') . " leads.",
				'user_charge'  =>  $this->session->userdata['userlogin']['full_name'],
				'date_added' =>  date("Y-m-d H:i:s"),
			);

			$this->Activity_Model->insert($data_activities);

			echo json_encode(array("response" => "success", "message" => "Successfully Assign to Agent!", "redirect" => base_url('dashboard')));
		} else {
			echo json_encode(array("response" => "erroe", "message" => "Failed to Assign", "redirect" => base_url('dashboard')));
		}
	}

	// public function fetch_agent_view_data($user_id = 0, $date_assigned = "")
	// {
	// 	$data = $this->Agents_Model->select_agent_task($user_id, $date_assigned);

	// 	$json_data = array("data" => $data);

	// 	echo json_encode($json_data);
	// }
	public function fetch_agent_view_data_task($user_id = 0, $date_assigned = "")
	{
		// $task_id = $this->input->get();
		$data = $this->Agents_Model->select_view_agent_task($user_id, $date_assigned);


		$json_data = array("data" => $data);

		echo json_encode($json_data);
	}

	public function view_agent_tasks_detail()
	{
		$data = array();
		$task_data = $this->Agents_Model->select_agent_user_tasks($this->input->get('agent_task_id'));
		$data = $task_data;
		echo json_encode($data);
	}
	
	// delete module
	// public function update_agent_tasks()
	// {
	// 	$checked_tasks = $this->input->post('checked_tasks') == "" ? array() : $this->input->post('checked_tasks');
	// 	$unchecked_agent_tasks = $this->input->post('unchecked_tasks') == "" ? 0 : $this->input->post('unchecked_tasks');
	// 	$unchecked_Lead = $this->input->post('unchecked_Lead') == "" ? 0 : $this->input->post('unchecked_Lead');
	// 	$agent_task_id = $this->input->post('get_agent_task_id');
	// 	$lead_id = $this->input->post('lead_id');

	// 	$user = $this->User_Model->view_single_user($this->input->post('assign_to'));


	// 	foreach ($agent_task_id as $key => $id) {
	// 		$data = array(
	// 			'user_id' => $this->input->post('assign_to'),
	// 			'lead_id' => $this->input->post('lead_id')[$key],
	// 		);
	// 		$this->Agents_Model->update_agent_tasks($id, $data);

	// 		$agent_user_first = $this->Activity_Model->select_agent_lead($data['lead_id']);
	// 		$leadgent_user_first = $this->Activity_Model->select_leadgent_lead($data['lead_id']);

	// 		if ($this->input->post('assign_to') != $this->input->post('existing_user_id')) {

	// 			$this->Activity_Model->insert($data_change_assign_activities);
	// 			$data_remove_activities =  array(
	// 				'lead_id' =>  $data['lead_id'],
	// 				'remarks' =>   "Removed " . sprintf("Lead%04d", $data['lead_id']) . " from your Task",
	// 				'unread_admin' =>  1,
	// 				'admin_id' =>  1,
	// 				'unread_agent' =>  1,
	// 				'user_id'  => $this->input->post('existing_user_id'),
	// 				'user_charge'  =>  $this->session->userdata['userlogin']['full_name'],
	// 				'date_added' =>  date("Y-m-d H:i:s"),
	// 			);
	// 			$this->Activity_Model->insert($data_remove_activities);
	// 		}
	// 	}

	// 	$this->Agents_Model->delete_agent_tasks(explode(",", $unchecked_agent_tasks));
	// 	$this->Leads_Model->update_lead_status_assign(array('lead_status_assign' => 0), explode(",", $unchecked_Lead));
	// 	if ($this->input->post('assign_to') == $this->input->post('existing_user_id')) {
	// 		if ($unchecked_Lead != 0) {
	// 			foreach (explode(",", $unchecked_Lead) as $key => $task_lead_id) {
	// 				$data_activities =  array(
	// 					'lead_id' =>  $task_lead_id,
	// 					'remarks' =>   "Removed " . sprintf("Lead%04d", $task_lead_id) . " from your Task",
	// 					'unread_admin' =>  1,
	// 					'unread_agent' =>  1,
	// 					'admin_id' =>  1,
	// 					'user_id'  => $this->input->post('assign_to'),
	// 					'user_charge'  =>  $this->session->userdata['userlogin']['full_name'],
	// 					'date_added' =>  date("Y-m-d H:i:s"),
	// 				);
	// 				$this->Activity_Model->insert($data_activities);
	// 			}
	// 		}
	// 	}
	// 	if ($this->input->post('assign_to') != $this->input->post('existing_user_id')) {
	// 		$data_change_assign_activities =  array(
	// 			'remarks' =>   "Agent have been given the task of " . count(explode(",", $checked_tasks)) . " leads.",
	// 			'unread_agent' =>  1,
	// 			'unread_admin' =>  1,
	// 			'status_activity' =>  2,
	// 			'user_id'  => $this->input->post('assign_to'),
	// 			'admin_id'  => 1,
	// 			'user_charge'  =>  $this->session->userdata['userlogin']['full_name'],
	// 			'date_added' =>  date("Y-m-d H:i:s"),
	// 		);
	// 	}

	// 	echo json_encode(array("response" =>   "success", "message" => "Successfully Updated Assign Agent Tasks", "redirect" => base_url('tasks')));
	// }

}
