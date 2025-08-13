<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activity extends MY_Controller {

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
	function __construct() {
		parent::__construct();
		modules::run("login/is_logged_in");
	 }
	public function index(){

		$records['tabledeals'] = $this->Activity_Model->tabledeals();
		$records['notifications'] = $this->Activity_Model->count_unread_notifications($this->session->userdata['userlogin']['user_id'] );

		
		$this->load->view('layout/head');
		$this->load->view('layout/header');
		$this->load->view('layout/nav');
		$this->load->view('activity', $records);
		$this->load->view('layout/footer');
		}
	   // add Deals

	   	// get LEAD data activities
	public function activity_leads(){
		
		$data = array();
		$lead_activity_data = $this->Activity_Model->select_lead_activity($this->input->get('lead_id'));
		$notes_data = $this->Activity_Model->select_notes($this->input->get('lead_id'));
		echo json_encode(['activities' => $lead_activity_data, 'notes' => $notes_data]);

	}

	public function count_unread_notifications() {
        $unread_count = $this->Activity_Model->count_unread_notifications($this->session->userdata['userlogin']['user_id']);
		$activities = $this->Activity_Model->get_notifications($this->session->userdata['userlogin']['user_id']);

        echo json_encode(['count' => $unread_count, 'activities' => $activities, 'usertype' => $this->session->userdata['userlogin']['usertype']]);
    }
	public function count_unread_notifications_of_payment() {
        $unread_count = $this->Activity_Model->count_unread_notifications_of_payment($this->session->userdata['userlogin']['user_id']);
		$activities = $this->Activity_Model->get_notifications_of_payment($this->session->userdata['userlogin']['user_id']);

        echo json_encode(['count' => $unread_count, 'activities' => $activities, 'usertype' => $this->session->userdata['userlogin']['usertype']]);
    }
	public function view_activity_notifications() {
        $view_all_notifications = $this->Activity_Model->get_all_notifications($this->session->userdata['userlogin']['user_id']);
        echo json_encode($view_all_notifications);
    }

	public function mark_read() {
        $this->Activity_Model->mark_as_read($this->session->userdata['userlogin']['user_id']);
        echo json_encode(['status' => 'success']);
    }

	function timeAgo($date) {
		$now = new DateTime();
		$dateTime = new DateTime($date);
		$interval = $now->getTimestamp() - $dateTime->getTimestamp();
		
		$years = floor($interval / 31536000);
		if ($years > 1) return $years . " years ago";
		
		$months = floor($interval / 2592000);
		if ($months > 1) return $months . " months ago";
		
		$days = floor($interval / 86400);
		if ($days > 1) return $days . " days ago";
		
		$hours = floor($interval / 3600);
		if ($hours > 1) return $hours . " hours ago";
		
		$minutes = floor($interval / 60);
		if ($minutes > 1) return $minutes . " minutes ago";
		
		return $interval . " seconds ago";
	}

}
