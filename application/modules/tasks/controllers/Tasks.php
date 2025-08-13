<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tasks extends MY_Controller
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
	public function index($lead_id = 0)
	{

		$records['tabletasks'] = $this->Tasks_Model->tabletasks();
		$records['leadgent_users'] = $this->User_Model->view_account_leadgent();
		$records['leads'] = $this->Leads_Model->tableleads();
		$records['tableleadgents'] = $this->Leadgents_Model->tableleadgents();
		$records['lead_id']=  $this->uri->segment(2) == "" ? 0 : $this->uri->segment(2) ;
		$records['lead_status'] =  '';




		$this->load->view('layout/head');
		$this->load->view('layout/header');
		$this->load->view('layout/nav');
		$this->load->view('tasks', $records);
		$this->load->view('layout/footer');
	}
	
	
    private function loadViews($data)
    {
        $this->load->view('layout/head');
        $this->load->view('layout/header');
        $this->load->view('layout/nav');
        $this->load->view('tasks', $data);
        $this->load->view('layout/footer');
    }

	public function sales_agents()
	{

		$records['tabletasks'] = $this->Tasks_Model->tabletasks();
		$records['lead_id']=  $this->uri->segment(3) == "" ? 0 : $this->uri->segment(3) ;
		$records['lead_status']= "";




		$this->load->view('layout/head');
		$this->load->view('layout/header');
		$this->load->view('layout/nav-leadgent');
		$this->load->view('task_agents', $records);
		$this->load->view('layout/footer');
	}


	public function view_task_detail() { 
		$data=array();
		$task_data =$this->Tasks_Model->select_tasks($this->input->get('agent_task_id')); 
		$data = $task_data;
		echo json_encode($data);             
}


	public function fetch_task_limit_data() {
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

	public function fetch_tasks_view_data($agent_task_id = 0, $date_assigned = "") {
		// $task_id = $this->input->get();
		$data = $this->Agents_Model->select_task($agent_task_id, $date_assigned);
		

		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		// exit();


		$json_data = array("data" => $data);

		echo json_encode($json_data);
	}

	



   public function fetch_task_data(){
		$data=array();
		$task_data =$this->Task_Model->fech_task_category(); 
		$data = $task_data;
		echo json_encode($data);      
	}

// end list of tasks

public function fetch_lead_limit_data()
	{
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$search = $this->input->get("search")['value'];
		$lead_status = $this->input->get("lead_status");
		$lead_id = $this->input->get("lead_id");

		


		$data = $this->Tasks_Model->get_data_lead($length, $start, $search, $lead_id, $lead_status);
		$totalData = $this->Tasks_Model->count_all();
		$totalFiltered = $this->Tasks_Model->count_filtered($search, $lead_id, $lead_status);

		$json_data = array(
			"draw" => $draw,
			"recordsTotal" => $totalData,
			"recordsFiltered" => $totalFiltered,
			"data" => $data,

		);
		// echo "<pre>";
		// print_r($json_data);
		// echo "</pre>";
		// exit();

		echo json_encode($json_data);
	}

	public function fetch_lead_agent_task_limit_data()
	{
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$search = $this->input->get("search")['value'];
		$lead_status = $this->input->get("lead_status");
		$lead_id = $this->input->get("lead_id");

		


		$data = $this->Tasks_Model->get_agenttask_data_lead($length, $start, $search, $lead_id, $lead_status, $this->session->userdata['userlogin']['user_id']);
		$totalData = $this->Tasks_Model->count_all_agenttask($this->session->userdata['userlogin']['user_id']);
		$totalFiltered = $this->Tasks_Model->count_filtered_agent_task($search, $lead_id, $lead_status, $this->session->userdata['userlogin']['user_id']);

		$json_data = array(
			"draw" => $draw,
			"recordsTotal" => $totalData,
			"recordsFiltered" => $totalFiltered,
			"data" => $data,

		);
		// echo "<pre>";
		// print_r($json_data);
		// echo "</pre>";
		// exit();

		echo json_encode($json_data);
	}

	public function add_remark() {
        // Update data in the database
		$leadgent_user = $this->Activity_Model->select_leadgent_lead($this->input->post('lead_id'));
        $agent_user = $this->Activity_Model->select_agent_lead($this->input->post('lead_id'));

		$data =  array(
			'lead_id' => $this->input->post('lead_id') ,
			'remark_tasks' => $this->input->post('remark'),
			'user_charge' => $this->session->userdata['userlogin']['full_name'],
			'date_remark' => date('Y-m-d H:i:s'),
			);
		// 	echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		if (!empty($this->input->post('remark'))){
            $this->Tasks_Model->insert_remark($data);
			if($this->session->userdata['userlogin']['usertype'] == 'Admin'){   
				$data_activities =  array(
					'lead_id' =>  $this->input->post('lead_id'),
					'remarks' =>   "Added Remark",
					'unread_leadgent' =>  $leadgent_user == false ? 0 : 1,
					'unread_agent' =>  $agent_user == false ? 0 : 1,
					'user_id'  => $agent_user == false ? 0 :  $agent_user['user_id'],
					'leadgent_user_id'  =>   $leadgent_user == false ? 0 : $leadgent_user['leadgent_user_id'],
					'user_charge'  =>  $this->session->userdata['userlogin']['full_name'],
					'date_added' =>  date("Y-m-d H:i:s"),
			);
		}
		elseif($this->session->userdata['userlogin']['usertype'] == 'Lead Gen.'){   
			$data_activities =  array(
					'lead_id' =>  $this->input->post('lead_id'),
					'remarks' =>   "Added Remark",
					'admin_id' =>   1,
					'unread_admin' =>  1,
					'unread_agent' =>  $agent_user == false ? 0 : 1,
					'user_id'  => $agent_user == false ? 0 :  $agent_user['user_id'],
					'user_charge'  =>  $this->session->userdata['userlogin']['full_name'],
					'date_added' =>  date("Y-m-d H:i:s"),
				);
			}

			elseif($this->session->userdata['userlogin']['usertype'] == 'Sales Trainee' || $this->session->userdata['userlogin']['usertype'] == 'Sales Prospecting' 
			|| $this->session->userdata['userlogin']['usertype'] == 'Sales Tier 1' || $this->session->userdata['userlogin']['usertype'] == 'Sales Tier 2'){   
					    $data_activities =  array(
						'lead_id' =>  $this->input->post('lead_id'),
						'remarks' =>   "Added Remark",
						'admin_id' =>   1,
						'unread_admin' =>  1,
						'unread_leadgent' =>  $leadgent_user == false ? 0 : 1,
						'leadgent_user_id'  =>   $leadgent_user == false ? 0 : $leadgent_user['leadgent_user_id'],
						'user_charge'  =>  $this->session->userdata['userlogin']['full_name'],
						'date_added' =>  date("Y-m-d H:i:s"),
					);
				}
			 $this->Activity_Model->insert($data_activities);
	    	 echo json_encode(array("response" =>   "success", "message" => "Successfully Added Remark", "redirect" => base_url('dashboard')));
        }
		 else{
			 echo json_encode(array("response" =>   "error", "message" => "Error Save", "redirect" => base_url('dashboard')));

		}
		  
	}


	public function update_sales_agent_remarks() {
		$data =  array(
			'sales_remarks' => $this->input->post('remark')
			);
		
			$this->Leads_Model->Agents_update_lead_status($data, $this->input->post('lead_id'));

		 
			 echo json_encode(array("response" =>   "error", "message" => "Error Save", "redirect" => base_url('dashboard')));
		  
	}




// Leadgent Task View
public function fetch_lead_agent_task_view_task()
{
	$draw = intval($this->input->get("draw"));
	$start = intval($this->input->get("start"));
	$length = intval($this->input->get("length"));
	$search = $this->input->get("search")['value'];
	$lead_status = $this->input->get("lead_status");
	$lead_id = $this->input->get("lead_id");
	$user_id = $this->input->get("user_id");



	$data = $this->Tasks_Model->get_view_agenttask_data_lead($length, $start, $search, $lead_id, $lead_status, $user_id);
	$totalData = $this->Tasks_Model->count_all_view_agenttask($user_id);
	$totalFiltered = $this->Tasks_Model->count_filtered_view_agent_task($search, $lead_id, $lead_status, $user_id);

	$json_data = array(
		"draw" => $draw,
		"recordsTotal" => $totalData,
		"recordsFiltered" => $totalFiltered,
		"data" => $data,

	);
	// echo "<pre>";
	// print_r($json_data);
	// echo "</pre>";
	// exit();

	echo json_encode($json_data);
}	
// ===============================================

}


