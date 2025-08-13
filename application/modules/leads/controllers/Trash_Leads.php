<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Trash_Leads extends MY_Controller
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
		$records['trashleadsview'] = $this->Leads_Model->trashleads();
		$records['activities'] = $this->Activity_Model->tableactivities();
		$records['leadgent_users'] = $this->User_Model->view_account_leadgent();

		$this->load->view('layout/head');
		$this->load->view('layout/header');
		$this->load->view('layout/nav');
		$this->load->view('Trash_Leads', $records);
		$this->load->view('layout/footer');
	}

	public function fetch_lead_limit_leadgent_data_modal()
	{
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$search = $this->input->get("search")['value'];

		$data = $this->Leads_Model->get_data_lead_leadgent_modal($length, $start, $search);
		$totalData = $this->Leads_Model->count_all_leadgent_modal();
		$totalFiltered = $this->Leads_Model->count_filtered_leadgent_modal($search);

		$json_data = array(
			"draw" => $draw,
			"recordsTotal" => $totalData,
			"recordsFiltered" => $totalFiltered,
			"data" => $data,

		);

		echo json_encode($json_data);
	}


	public function fetch_leads_restore_data($user_remove_leads_id = 0, $remove_date = "") {
		// $task_id = $this->input->get();
		$data = $this->Leads_Model->get_leads_restore_data($user_remove_leads_id, $remove_date);

		$json_data = array("data" => $data);

		echo json_encode($json_data);
	}
	public function view_restore_leads_detail() { 
		$data=array();
		$task_data =$this->Leads_Model->select_leads_restore_data($this->input->get('trash_id')); 
		$data = $task_data;
		echo json_encode($data);             
}


public function restore_leads_data() {
    // Check if 'checked_tasks' or 'checked_Lead' is set and sanitize input
    $checked_tasks = $this->input->post('checked_tasks');
    $checked_Lead = $this->input->post('checked_Lead');

    // If the input is empty, set default values (array for tasks, 0 for lead)
    $checked_tasks = empty($checked_tasks) ? array() : explode(",", $checked_tasks);
    $checked_Lead = empty($checked_Lead) ? 0 : explode(",", $checked_Lead);

    // Prepare data for updating trash status
    $data = array(
        'trash_status' => "Restored"
    );
	$this->Leads_Model->restore_lead_data_detail(array('trash' => 0, 'lead_status_assign' =>0), $checked_Lead);
    // Attempt to restore both lead data and trash status
    if ($this->Leads_Model->restore_trash_lead($data, $checked_tasks)){
        
   // Failure response
		echo json_encode(array(
            "response" => "error", 
            "message", 
            "redirect" => base_url('dashboard')
        ));
    } else {
        // Success response 

		echo json_encode(array(
            "response" => "success", 
            "message", 
            "redirect" => base_url('dashboard')
        ));
    }
}

}

