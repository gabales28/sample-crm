<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/ test
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

		$records['notifications'] = $this->Activity_Model->get_notifications($this->session->userdata['userlogin']['user_id']);
		$records['view_all_notifications'] = $this->Activity_Model->get_all_notifications($this->session->userdata['userlogin']['user_id']);

		$this->load->view('layout/head');
		$this->load->view('layout/header');
		if ($this->session->userdata['userlogin']['usertype'] == "Admin"){
		     $this->load->view('layout/nav');
		}
		elseif ($this->session->userdata['userlogin']['usertype'] == "Lead Gen."){
			$this->load->view('layout/nav-leadgent');
	   }
	   elseif($this->session->userdata['userlogin']['usertype'] == 'Sales Trainee' || $this->session->userdata['userlogin']['usertype'] == 'Sales Prospecting' 
	   || $this->session->userdata['userlogin']['usertype'] == 'Sales Tier 2' || $this->session->userdata['userlogin']['usertype'] == 'Sales Tier 1'){   
		$this->load->view('layout/nav-agent');
       }
		 $this->load->view('notification', $records);
		 $this->load->view('layout/footer');
	   }
		  
}