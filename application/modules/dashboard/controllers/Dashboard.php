<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

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

	
		$records['total_leads'] = $this->Leads_Model->count_all_leads($this->session->userdata['userlogin']['user_id'] );
		$records['total_sales'] = $this->Agents_Model->agent_total_sales(0);
		$records['agent_qouta'] = $this->Agents_Model->agent_qouta();
		$records['all_sales'] = $this->User_Model->count_all_agents();
		$records['online_users'] = $this->User_Model->get_all_users();
		$records['active_sales'] = $this->User_Model->view_account_sales();
		$records['total_deals_month'] = $this->Leads_Model->count_all_deal_month($this->session->userdata['userlogin']['user_id'], date('m'));
		$records['total_deals_year'] = $this->Leads_Model->count_all_deal_year($this->session->userdata['userlogin']['user_id'], date('Y'));
		$records['lead_id'] = 0; 	
		// $records['get_authors_closed_leads'] = $this->Leads_Model->get_authors_closed_leads($this->session->userdata['userlogin']['user_id'], date('m'));

		$this->load->view('layout/head');
		$this->load->view('layout/header_dashboard', $records);
		$this->load->view('layout/nav');
		$this->load->view('dashboard', $records);

		$this->load->view('layout/footer_dashboard');
   }
	public function leadgent(){
		$records['total_leads_assigned_to_agents'] = $this->Leads_Model->count_all_leads_of_the_agents($this->session->userdata['userlogin']['user_id'] );
		$records['total_leads'] = $this->Leads_Model->count_all_leads($this->session->userdata['userlogin']['user_id']);
		$records['all_sales'] = $this->Leads_Model->count_all_agents($this->session->userdata['userlogin']['user_id']);
		$records['active_sales'] = $this->User_Model->view_account_leadgent_sales_active($this->session->userdata['userlogin']['user_id']);
		$records['total_deals_month'] = $this->Leads_Model->count_all_deal_month($this->session->userdata['userlogin']['user_id'], date('m'));
		$records['total_deals_year'] = $this->Leads_Model->count_all_deal_year($this->session->userdata['userlogin']['user_id'], date('Y'));
		$records['lead_id'] = 0; 
		// $records['get_authors_closed_leads'] = $this->Leads_Model->get_authors_closed_leads($this->session->userdata['userlogin']['user_id'], date('m'));
	
		$this->load->view('layout/head');
		$this->load->view('layout/header_dashboard', $records);
		$this->load->view('layout/nav-leadgent');
		$this->load->view('dashboard-leadgent', $records);
		$this->load->view('layout/footer_dashboard');
	}
	public function agent(){
		$paymentData = $this->Agents_Model->agent_breakout_payment($this->session->userdata['userlogin']['user_id']);

		$payment = array_fill(0, 12, 0); // Default to 0 for all months

		if (!empty($paymentData)) {
			foreach ($paymentData as $data) {
				// echo "<br>";
			    // echo $data['date_paid'];
			    // echo "<br>";
				$monthIndex = (int)date('n', strtotime($data['date_paid'])) - 1; // Convert month to index (0-11)
				$payment[$monthIndex] += $data['amount'];
			}
		}
						// exit();

		$records['total_leads'] = $this->Leads_Model->count_all_leads($this->session->userdata['userlogin']['user_id'] );
		$records['total_sales'] = $this->Agents_Model->agent_total_sales($this->session->userdata['userlogin']['user_id'] );
		$records['total_deals_month'] = $this->Leads_Model->count_all_deal_month($this->session->userdata['userlogin']['user_id'], date('m'));
		$records['total_deals_year'] = $this->Leads_Model->count_all_deal_year($this->session->userdata['userlogin']['user_id'], date('Y'));
		$records['sales_qouta'] = $this->User_Model->view_single_user($this->session->userdata['userlogin']['user_id']);
		$records['payments'] = $payment; 
		$records['lead_id'] = 0; 	
		// $records['get_authors_closed_leads'] = $this->Leads_Model->get_authors_closed_leads($this->session->userdata['userlogin']['user_id'], date('m'));


		$this->load->view('layout/head');
		$this->load->view('layout/header');
		$this->load->view('layout/nav-agent');
		$this->load->view('dashboard-agent', $records);
		$this->load->view('layout/footer_dashboard_agent');
	}

	public function view_dashboard_details(){
		$total_leads = $this->Leads_Model->count_all_leads_sales($this->input->post("user_id"));
		$total_sales = $this->Agents_Model->agent_total_sales($this->input->post("user_id"));
		$total_deals_month = $this->Leads_Model->count_all_deal_month_sales($this->input->post("user_id"), date('m'));
		$total_deals_year = $this->Leads_Model->count_all_deal_year_sales($this->input->post("user_id"), date('Y'));
		$sales_qouta = $this->User_Model->view_single_user($this->input->post("user_id"));
		$paymentData = $this->Agents_Model->agent_breakout_payment($this->input->post("user_id"));


		$payment = array_fill(0, 12, 0); // Default to 0 for all months

		if (!empty($paymentData)) {
			foreach ($paymentData as $data) {

				$monthIndex = (int)date('n', strtotime($data['date_paid'])) - 1; // Convert month to index (0-11)
				$payment[$monthIndex] += $data['amount'];
			}
		}
		echo json_encode(['payments' => $payment, 'total_leads' => $total_leads,'total_sales' => $total_sales, 'total_deals_month' => $total_deals_month, 'total_deals_year' => $total_deals_year,'sales_qouta' => $sales_qouta]);


   }
   function formatNumber($num) {
    // Convert the number to a float
		$num = floatval($num);
		
		// Check if the number is valid
		if (is_nan($num)) {
			return "Invalid number";
		}

		// Format the number to two decimal places
		$num = number_format($num, 2, '.', '');

		// Split the number into integer and decimal parts
		$parts = explode('.', $num);
		$integerPart = $parts[0];
		$decimalPart = $parts[1];

		// Use a regular expression to add commas
		$integerPart = preg_replace('/\B(?=(\d{3})+(?!\d))/', ',', $integerPart);

		// Combine the integer and decimal parts
		return $integerPart . '.' . $decimalPart;
}


	
}
