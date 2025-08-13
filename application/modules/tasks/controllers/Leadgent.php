<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Leadgent extends MY_Controller
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
		
		$records['tableleadgents'] = $this->Leadgents_Model->tableleadgents();
		$records['leadgent_users'] = $this->User_Model->view_account_leadgent();
		$records['leads'] = $this->Leads_Model->tableleads();


		$this->load->view('layout/head');
		$this->load->view('layout/header');
		$this->load->view('layout/nav');
		$this->load->view('assign_leadgent', $records);
		$this->load->view('layout/footer');
	}

	// add Tasks
	// public function add_leadgent()
	// {
	// 	$user_charge = $this->session->userdata['userlogin']['full_name'];

	// 	// $contact = $this->input->post('customer_contact') == "" ? array() : $this->input->post('customer_contact');
	// 	// $email = $this->input->post('customer_email') == "" ? array() : $this->input->post('customer_email');

	// 	// $contactsString = implode(',', $contact); // Convert Customer contact array to comma-separated string
	// 	// $emailsString = implode(',', $email); // Convert Customer Email  array to comma-separated string
		
	// 	$data = array(
	// 		'lead_id' => $this->input->post('title'),
	// 		'user_id' => $this->input->post('assign_to'),
	// 		// 'priority' => $this->input->post('priority'),
	// 		'lead_status' => "Not Yet Open",
	// 		'remarks' => $this->input->post('remarks'),
	// 		'date_assigned' => date('Y-m-d H:i:s'),
			

	// 	);



	// 	$this->Leadgents_Model->insert($data);

	// 	echo json_encode(array("response" => "success", "message" => "Successfully Added Task", "redirect" => base_url('dashboard')));



	// }
	// get Tasks data
	public function view_leadgent_Task_detail() { 
		$data=array();
		$task_data =$this->Leadgents_Model->select_leadgent_task($this->input->get('task_id')); 
		$data = $task_data;
		echo json_encode($data);             
}

	// update Tasks
// 	public function update_task_details(){
			
// 		$data =  array(

// 						'lead_id' => $this->input->post('title') ,
// 						'user_id' => $this->input->post('assign_to') ,
// 						'task_id' => $this->input->post('task_id'),
// 						'remarks' => $this->input->post('remarks'),
// 						'priority' => $this->input->post('priority'),
// 						  );

// 			  $this->Tasks_Model->update_details($data, $this->input->post('appointment_id'));
// 			  echo json_encode(array("response" =>   "success", "message" => "Successfully Updated Appointment", "redirect" => base_url('tasks')));
//   }	
// start list of tasks
	public function fetch_legent_task_limit_data() {
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$search = $this->input->get("search")['value'];



		$data = $this->Leadgents_Model->get_data_leadgent_task($length, $start, $search);
		$totalData = $this->Leadgents_Model->count_all();	
		$totalFiltered = $this->Leadgents_Model->count_filtered($search);

		$json_data = array(
			"draw" => $draw,
			"recordsTotal" => $totalData,
			"recordsFiltered" => $totalFiltered,
			"data" => $data,
			
		);

		echo json_encode($json_data);
	}

	public function fetch_leadgent_edit_data($user_id = 0, $date_assigned = "") {
		// $task_id = $this->input->get();
		$data = $this->Leadgents_Model->select_lead_task($user_id, $date_assigned);

		$json_data = array("data" => $data);

		echo json_encode($json_data);
	}

   public function fetch_leadgent_task_data(){
		$data=array();
		$leadgent_task_data =$this->Leadgents_Model->fech_leadgent_task_category(); 
		$data = $leadgent_task_data;
		echo json_encode($data);      
	}

// end list of tasks


// end save multipletaskform
	public function save_leadgent_tasks() {
        $leads = $this->input->post('lead_ids');
        $assign_to = $this->input->post('assign_to');
		// $priority = $this->input->post('priority');
		$remarks = $this->input->post('remarks');
		$lead_status = $this->input->post('lead_status');
		$user = $this->User_Model->view_single_user($this->input->post('assign_to'));



        $leadgent_tasks_data = [];
        $data_activities = [];

        foreach ($leads as $lead_id) {
            $leadgent_tasks_data[] = [
                'lead_id' => $lead_id,
                'leadgent_user_id' => $assign_to,
                // 'remarks' => $remarks,
				'status_assign' => "Not yet open",
				'date_assigned' => date('Y-m-d H:i:s'),


            ];

		
			$this->Leads_Model->update(array('lead_status_assign_leadgent' => 1), $lead_id);

        }

        if ($this->Leadgents_Model->save_leadgent_tasks($leadgent_tasks_data)) {
			$data_activities =  array(
				'leadgent_user_id' => $assign_to  ,
				'remarks' =>   "You have been given the task of " .$this->input->post('total_leads'). " leads.",
				'unread_leadgent' =>  1,
				'status_activity' =>  2,
				'user_charge'  =>  $this->session->userdata['userlogin']['full_name'],
				'date_added' =>  date("Y-m-d H:i:s"),
			);
			
			$this->Activity_Model->insert($data_activities);

			echo json_encode(array("response" => "success", "message" => "", "redirect" => base_url('dashboard')));

        } else {
            echo json_encode(['status' => 'error']);
        }
    }


	// delete module
	public function save_leagent_taskss() {
		$checked_tasks = $this->input->post('checked_tasks') == "" ? 0 : $this->input->post('checked_tasks');
		$checked_leadgent_tasks = $this->input->post('checked_leadgent_tasks') == "" ? array() : $this->input->post('checked_leadgent_tasks');
		$unchecked_leadgent_tasks = $this->input->post('unchecked_tasks') == "" ? 0 : $this->input->post('unchecked_tasks');
		$unchecked_Lead = $this->input->post('unchecked_Lead') == "" ? 0 : $this->input->post('unchecked_Lead');
		$leadgent_task_id = $this->input->post('get_leadgent_task_id');
		$lead_id = $this->input->post('lead_id');

		$user = $this->User_Model->view_single_user($this->input->post('assign_to'));

		// echo "<pre>";
		// print_r(count(explode(",", $checked_tasks)));
		// echo "<pre>";	
		// exit();
		
        foreach ($leadgent_task_id as $key => $id) {
            $data = array(
				'leadgent_user_id' => $this->input->post('assign_to'),
				// 'priority' => $this->input->post('priority')[$key],
				'lead_id' => $this->input->post('lead_id')[$key],
				// 'remarks' => $this->input->post('remarks')[$key],
            );
			$this->Leadgents_Model->update_leadgent_tasks($id, $data);
			$agent_user_first = $this->Activity_Model->select_agent_lead($data['lead_id']);
			$leadgent_user_first = $this->Activity_Model->select_leadgent_lead($data['lead_id']);

			if ($this->input->post('assign_to') != $this->input->post('existing_user_id')){
				$data_remove_activities =  array(
					'lead_id' =>  $data['lead_id'],
					'remarks' =>   "Removed ".sprintf("Lead%04d", $data['lead_id'])." from your Task",
					'unread_leadgent' =>  1,
					'leadgent_user_id'  => $this->input->post('existing_user_id'),
					'user_charge'  =>  $this->session->userdata['userlogin']['full_name'],
					'date_added' =>  date("Y-m-d H:i:s"),
				);
				$this->Activity_Model->insert($data_remove_activities);
			 }

        }

			$this->Leadgents_Model->delete_leadgent_tasks(explode(",", $unchecked_leadgent_tasks));
			$this->Leads_Model->update_lead_status_assign(array('lead_status_assign_leadgent' => 0), explode(",", $unchecked_Lead));
			if ($this->input->post('assign_to') == $this->input->post('existing_user_id')){
				if ($unchecked_Lead != 0 ){
					foreach (explode(",", $unchecked_Lead) as $key => $task_lead_id) {
						$agent_user = $this->Activity_Model->select_agent_lead($task_lead_id);

						$data_activities =  array(
							'lead_id' =>  $task_lead_id,
							'remarks' =>   "Removed ".sprintf("Lead%04d", $task_lead_id)." from your Task",
							'unread_leadgent' =>  1,
							'leadgent_user_id'  => $this->input->post('assign_to'),
							'user_charge'  =>  $this->session->userdata['userlogin']['full_name'],
							'date_added' =>  date("Y-m-d H:i:s"),
						);
						$this->Activity_Model->insert($data_activities);
					}
				}
	     }

		   if ($this->input->post('assign_to') != $this->input->post('existing_user_id')){
				$data_change_assign_activities =  array(
				    'remarks' =>   "You have been given the task of " .count(explode(",", $checked_tasks)). " leads.",
					'unread_leadgent' =>  1,
					'leadgent_user_id'  => $this->input->post('assign_to'),
					'status_activity' =>  2,
					'user_charge'  =>  $this->session->userdata['userlogin']['full_name'],
					'date_added' =>  date("Y-m-d H:i:s"),
				);
			    $this->Activity_Model->insert($data_change_assign_activities);

			}

		echo json_encode(array("response" =>   "success", "message" => "", "redirect" => base_url('tasks')));
	}


	

	// public function updates() {
    //     $task_id = $this->input->post('task_id');
    //     $data = array(
    //         'user_id' => $this->input->post('assign_to'),
    //         // 'priority' => $this->input->post('priority'),
    //         'remarks' => $this->input->post('remarks')
    //     );

    //     if ($this->Tasks_Model->update_tasks($data, $task_id)) {
    //         echo json_encode(array('status' => 'success', 'message' => 'Task updated successfully.'));
    //     } else {
    //         echo json_encode(array('status' => 'error', 'message' => 'Failed to update task.'));
    //     }
    // }
	  
	}


