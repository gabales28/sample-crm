<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sold_authoragent extends MY_Controller
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
		$records['get_lead_authors_agent'] = $this->Sold_author_model->get_lead_authors_agent( $this->session->userdata['userlogin']['user_id']);
		$records['tableleads'] = $this->Leads_Model->tableleads();
		$records['activities'] = $this->Activity_Model->tableactivities();
		$records['leadgent_users'] = $this->User_Model->view_account_leadgent();
		$records['closed_leads'] = $this->Leads_Model->get_closed_leads();

		// $records['get_recycle_data_lead'] = $this->Recycle_Model->get_recycle_data_lead();
		
		$this->load->view('layout/head');
		$this->load->view('layout/header');
		$this->load->view('layout/nav-agent');
		$this->load->view('sold_author_agent', $records);
		$this->load->view('layout/footer');
	}

}
