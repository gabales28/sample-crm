<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sales_Leadgent extends MY_Controller
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
		$records['agent_users'] = $this->User_Model->view_account_sales();
		$records['leads'] = $this->Leads_Model->tableleads();
		$records['table_agent_leadgents'] = $this->Salesleadgent_Model->table_agent_leadgents();

		
		$this->load->view('layout/head');
		$this->load->view('layout/header');
		$this->load->view('layout/nav');
		$this->load->view('sales_leadgent', $records);
		$this->load->view('layout/footer');
	}

	public function fetch_legent_task_limit_data() {
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$search = $this->input->get("search")['value'];

		$data = $this->Salesleadgent_Model->get_data_leadgent_task($length, $start, $search);
		$totalData = $this->Salesleadgent_Model->count_all();	
		$totalFiltered = $this->Salesleadgent_Model->count_filtered($search);

		$json_data = array(
			"draw" => $draw,
			"recordsTotal" => $totalData,
			"recordsFiltered" => $totalFiltered,
			"data" => $data,
			
		);

		echo json_encode($json_data);
	}
   public function fetch_leadgent_task_data(){
		$data=array();
		$leadgent_task_data =$this->Salesleadgent_Model->fech_leadgent_task_category(); 
		$data = $leadgent_task_data;
		echo json_encode($data);      
	}

// end save multipletaskform

public function assign_agent_to_leadgent() {
    $users = $this->input->post('user_id'); 
    $assign_to = $this->input->post('assign_to');
    $leadgent_user = $this->User_Model->view_single_user($assign_to);

    if (is_array($users) && !empty($users)) {
        $agent_leadgent_data = [];
        $data_activities = [];

        foreach ($users as $user_id) {
            $agent_leadgent_data[] = [
                'agent_user_id' => $user_id,
                'leadgent_user_id' => $assign_to,
                'date_assigned' => date('Y-m-d H:i:s'),
            ];
        }   

        if ($this->Salesleadgent_Model->assign_agent_to_leadgent($agent_leadgent_data)) {
		   foreach ($agent_leadgent_data as $agent_leadgent) {

			  $agent_user = $this->User_Model->view_single_user($agent_leadgent['agent_user_id']);
				$data_assign_agent_activities =  array(
					'remarks' =>   "Assign Leadgent :  ".$leadgent_user['fname']." ".$leadgent_user['lname']." of you ",
					'unread_agent' =>   1,
					'status_activity' =>   1,
					'user_id'  => $agent_leadgent['agent_user_id'],
					'user_charge'  =>  $this->session->userdata['userlogin']['full_name'],
					'date_added' =>  date("Y-m-d H:i:s"),
				);
				$this->Activity_Model->insert($data_assign_agent_activities);

				$data_assign_leadgent_activities =  array(
					'remarks' =>   "Assign Agent :  ".$agent_user['fname']." ".$agent_user['lname']." of you ",
					'unread_leadgent' =>   1,
					'status_activity' =>   1,
					'leadgent_user_id'  => $this->input->post('assign_to'),
					'user_charge'  =>  $this->session->userdata['userlogin']['full_name'],
					'date_added' =>  date("Y-m-d H:i:s"),
				);

			$this->Activity_Model->insert($data_assign_leadgent_activities);
		    }


            echo json_encode([
                "response" => "success", 
                "message" => "", 
                "redirect" => base_url('dashboard')
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to save leadgent tasks.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No user selected.']);
    }
}


// GET DATA OR VIEW
public function view_agent_leadgent() {
    $agent_leadgent_id = $this->input->get('agent_leadgent_id');
    // Validate input
    if (empty($agent_leadgent_id)) {
        echo json_encode(['error' => 'User ID is required']);
        return;
    }
    // Fetch data from the model
    $data = $this->Salesleadgent_Model->select_agentleadgent_user_id($agent_leadgent_id);
    // Check if data exists
    if ($data !== false) {
        echo json_encode($data);
    } else {
        echo json_encode([]);
    }
}
// UPDATE DATA

public function update_agent_leadgent(){
			
	$data =  array(
					'leadgent_user_id' => $this->input->post('assign_leadgent') ,
					'agent_user_id' => $this->input->post('assign_agent') ,
					'agent_leadgent_id' => $this->input->post('agent_leadgent_id') ,
	  );
	  $agent_user = $this->User_Model->view_single_user($this->input->post('assign_agent'));
	  $leadgent_user = $this->User_Model->view_single_user($this->input->post('assign_leadgent'));
	  $this->Salesleadgent_Model->update_agentleadgent($data, $this->input->post('agent_leadgent_id'));

			$data_assign_agent_activities =  array(
				'remarks' =>   "Update Assign Leadgent :  ".$leadgent_user['fname']." ".$leadgent_user['lname']." of you ",
				'unread_agent' =>   1,
				'status_activity' =>   1,
				'user_id'  =>  $this->input->post('assign_agent'),
				'user_charge'  =>  $this->session->userdata['userlogin']['full_name'],
				'date_added' =>  date("Y-m-d H:i:s"),
			);
			$this->Activity_Model->insert($data_assign_agent_activities);

			$data_assign_leadgent_activities =  array(
				'remarks' =>   "Update Assign Agent :  ".$agent_user['fname']." ".$agent_user['lname']." of you ",
				'unread_leadgent' =>   1,
				'status_activity' =>   1,
				'leadgent_user_id'  =>  $this->input->post('agent_leadgent_id'),
				'user_charge'  =>  $this->session->userdata['userlogin']['full_name'],
				'date_added' =>  date("Y-m-d H:i:s"),
			);
			$this->Activity_Model->insert($data_assign_leadgent_activities);

			$agent_user_exist = $this->User_Model->view_single_user($this->input->post('existing_agent_user_id'));
			$leadgent_user_exist = $this->User_Model->view_single_user($this->input->post('existing_leadgent_user_id'));
			if($this->input->post('assign_agent') != $this->input->post('existing_agent_user_id') && $this->input->post('agent_leadgent_id') != $this->input->post('existing_leadgent_user_id')){
				$data_unassign_agent_activities =  array(
					'remarks' =>   "Removed Assign Leadgent :  ".$leadgent_user_exist['fname']." ".$leadgent_user_exist['lname']." of you ",
					'unread_agent' =>   1,
					'status_activity' =>   1,
					'user_id'  =>  $this->input->post('existing_agent_user_id'),
					'user_charge'  =>  $this->session->userdata['userlogin']['full_name'],
					'date_added' =>  date("Y-m-d H:i:s"),
				);
				$this->Activity_Model->insert($data_unassign_agent_activities);
				$data_unassign_leadgent_activities =  array(
					'remarks' =>   "Removed Assign Agent :  ".$agent_user_exist['fname']." ".$agent_user_exist['lname']." of you ",
					'unread_leadgent' =>   1,
					'status_activity' =>   1,
					'leadgent_user_id'  =>  $this->input->post('existing_leadgent_user_id'),
					'user_charge'  =>  $this->session->userdata['userlogin']['full_name'],
					'date_added' =>  date("Y-m-d H:i:s"),
				);
				$this->Activity_Model->insert($data_unassign_leadgent_activities);


			}
			// if($this->input->post('agent_leadgent_id') != $this->input->post('existing_leadgent_user_id')){
			// 	$data_unassign_leadgent_activities =  array(
			// 		'remarks' =>   "Removed Assign Agent :  ".$agent_user_exist['fname']." ".$agent_user_exist['lname']." of you ",
			// 		'unread_leadgent' =>   1,
			// 		'status_activitiy' =>   1,
			// 		'leadgent_user_id'  =>  $this->input->post('existing_leadgent_user_id'),
			// 		'user_charge'  =>  $this->session->userdata['userlogin']['full_name'],
			// 		'date_added' =>  date("Y-m-d H:i:s"),
			// 	);
			// 	$this->Activity_Model->insert($data_unassign_leadgent_activities);
			// }

					  
		  echo json_encode(array("response" =>   "success", "message" => "", "redirect" => base_url('tasks/sales_leadgent')));
}	

}