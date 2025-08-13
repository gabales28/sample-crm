<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LeadGen_Trash_Leads extends MY_Controller
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
		$records['lead_id']=  $this->uri->segment(2) == "" ? 0 : $this->uri->segment(2) ;
		$records['lead_status']=  "";
		$records['trashleadsview'] = $this->Leads_Model->trashleads();



		$this->load->view('layout/head');
		$this->load->view('layout/header');
		$this->load->view('layout/nav-leadgent');
		$this->load->view('LeadGen_Trash_Leads', $records);
		$this->load->view('layout/footer');
	}



}
