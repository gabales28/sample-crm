<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends MY_Controller
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

	private $allowed_ips = ['49.145.129.134','49.145.133.82','49.145.133.72','180.190.195.181','180.190.195.130','127.0.0.1','180.190.197.58','180.190.180.45']; // Replace with your allowed IPs


	function __construct()
	{

		parent::__construct();


		$this->load->library('email');
		$this->load->library('user_agent');
		//  $this->load->library('phpmailer_lib');

		$this->email->initialize(
			array(
				'charset' => 'utf-8',
				'wordwrap'  => TRUE,
				'mailtype'  => 'html',
				'protocol'  => 'sendmail'
			)
		);

		$get_remark_project = false;
	}
	public function index()
	{
		// $this->load->view('layout/header');
		$this->load->view('login');
		// $this->load->view('layout/footer');
		// Retrieve the IP address from session data
		$data['ip_address'] = $this->session->userdata('ip_address');
	}

// ORIGINAL CODE
	// public function login_user()
	// {

	// 	$this->form_validation->set_rules('email_address', 'Email Address', 'trim|xss_clean|required');

	// 	$this->form_validation->set_rules('password', 'Password', 'trim|xss_clean|required');

	// 	if ($this->form_validation->run() == FALSE) {

	// 		echo json_encode(array("response" => "error", "message" => validation_errors()));
	// 	} else {

	// 		$emailaddress = strtolower($this->input->post('email_address'));

	// 		$password = $this->input->post('password');
	// 		$usertype = $this->input->post('usertype');
	// 		// Retrieve the user's IP address
	// 		$ip_address = $this->input->ip_address();
	// 		$user = $this->User_Model->login($emailaddress, $password);
	// 		// Store the IP address in session data
	// 		if ($user) {

				
	// 			foreach ($user as  $result) {

	// 				$sessiondata = array(
	// 					'username' => ucfirst($result->username),

	// 					'user_id' => $result->user_id,

	// 					'full_name' => ucwords($result->fname . ' ' . $result->lname),

	// 					'emailaddress' => $result->email_add,

	// 					'contact' => $result->contact,

	// 					'usertype' => $result->usertype,
	// 					'address' => $result->address,
	// 					'ip_address' => $ip_address,
	// 				);

	// 				$data = array(
	// 					'user_id' => $result->user_id,
	// 					'ip_address' => $ip_address,
	// 					'log_date' =>  date('Y-m-d H:i:s a'),
	// 					// 'attempt_activities' =>  1,

	// 				);

	// 				$this->session->set_userdata('userlogin', $sessiondata);

	// 				if ($result->status == 'Active') {

	// 					// $this->User_Model->update_userlog($emailaddress, $password);

	// 					$this->User_Model->insert_userlog($data);

	// 					if ($result->usertype == 'Admin') {
	// 						echo json_encode(array("response" => "success", "message" => "You have successfully logged in!", 'userlogin' => $this->session->userdata['userlogin']['usertype'], "redirect" => base_url("dashboard")));
	// 					} else if ($result->usertype == 'Leadgent') {
	// 						echo json_encode(array("response" => "success", "message" => "You have successfully logged in!", 'userlogin' => $this->session->userdata['userlogin']['usertype'], "redirect" => base_url("dashboard/leadgent")));
	// 					} else if ($result->usertype == 'Sales') {
	// 						echo json_encode(array("response" => "success", "message" => "You have successfully logged in!", 'userlogin' => $this->session->userdata['userlogin']['usertype'], "redirect" => base_url("dashboard/agent")));
	// 					}
	// 				} else if ($result->attempt <= 0) {
	// 					echo json_encode(array("response" => "error", "message" => "Account has been locked, please contact the Administrator."));
	// 				} else {
	// 					echo json_encode(array("response" => "error", "message" => "Account has been disabled, please contact the Administrator."));
	// 				}
	// 			}
	// 		} else {

	// 			$this->User_Model->update_attempt($this->input->post('email_address'));

	// 			echo json_encode(array("response" => "error", "message" => "Incorrect your Email Address or Password"));
	// 		}
	// 	}
	// }

// SAMPLE CODE

public function login_user()
    {
        $this->form_validation->set_rules('email_address', 'Email Address', 'trim|xss_clean|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|xss_clean|required');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array("response" => "error", "message" => validation_errors()));
        } else {
            $emailaddress = strtolower($this->input->post('email_address'));
            $password = $this->input->post('password');
            $ip_address = $this->input->ip_address();
            $user = $this->User_Model->login($emailaddress, $password);

            if ($user) {
                foreach ($user as $result) {
                    $sessiondata = array(
                        'username' => ucfirst($result->username),
                        'user_id' => $result->user_id,
                        'full_name' => ucwords($result->fname . ' ' . $result->lname),
                        'emailaddress' => $result->email_add,
                        'contact' => $result->contact,
                        'usertype' => $result->usertype,
                        'address' => $result->address,
                        'ip_address' => $ip_address,
						'phonenumber' => $result->phonenumber,
                    );

                    $data = array(
                        'user_id' => $result->user_id,
                        'ip_address' => $ip_address,
                        'log_date' =>  date('Y-m-d H:i:s a'),
                    );

                    $this->session->set_userdata('userlogin', $sessiondata);
                    $this->User_Model->insert_userlog($data);
       
					// Set user to online

                 if ($result->status == 'Active') {
                        if ($result->usertype == 'Admin') {
								if (in_array($ip_address, $this->allowed_ips)) {
									$this->User_Model->set_online_status($result->user_id, 1); 
									echo json_encode(array(
										"response" => "success",
										"message" => "You have successfully logged in!",
										"redirect" => base_url("dashboard")
									));
								} else{
									echo json_encode(array("response" => "error", "message" => "You don't have permission to log in at this time. You're in the wrong address."));

							    }
							}
                //  if ($result->status == 'Active') {
                //         if ($result->usertype == 'Admin') {
				// 			$this->User_Model->set_online_status($result->user_id, 1); 
                //             echo json_encode(array("response" => "success", "message" => "You have successfully logged in!", "redirect" => base_url("dashboard")));
                //         }
						 else if ($result->usertype == 'Lead Gen.') {
								if (in_array($ip_address, $this->allowed_ips)){
								$data_activities =  array(
									'remarks' =>  'was logged in on CRM.',
									'admin_id' =>   1,
									'unread_admin' =>  1,
									'status_activity' =>  3,
									'user_charge'  =>  ucwords($result->fname . ' ' . $result->lname),
									'date_added' =>  date("Y-m-d H:i:s"),
								);
								$this->User_Model->set_online_status($result->user_id, 1); 
								$this->Activity_Model->insert($data_activities);
								echo json_encode(array("response" => "success", "message" => "You have successfully logged in!", "redirect" => base_url("dashboard/leadgent")));
								}
							    else{
									echo json_encode(array("response" => "error", "message" => "You don't have a permission to login on this time, Please contact to the Admin."));

							    }
						} else if ($result->usertype == 'Sales Trainee' || 'Sales Prospecting' || 'Sales Tier 1' || 'Sales Tier 2') {
							if (in_array($ip_address, $this->allowed_ips)){
								$data_activities =  array(
									'remarks' =>  'was logged in on CRM.',
									'admin_id' =>   1,
									'unread_admin' =>  1,
									'status_activity' =>  3,
									'user_charge'  =>  ucwords($result->fname . ' ' . $result->lname),
									'date_added' =>  date("Y-m-d H:i:s"),
								);
								$this->User_Model->set_online_status($result->user_id, 1); 
								$this->Activity_Model->insert($data_activities);
                            echo json_encode(array("response" => "success", "message" => "You have successfully logged in!", "redirect" => base_url("dashboard/agent")));
							}
							else{
								echo json_encode(array("response" => "error", "message" => "You don't have a permission to login on this time, Please contact to the Admin."));
							}
						}
                    } else if ($result->attempt <= 0) {
                        echo json_encode(array("response" => "error", "message" => "Account locked, contact Admin."));
                    } else {
                        echo json_encode(array("response" => "error", "message" => "Account disabled, contact Admin."));
                    }
                }
            } else {
                $this->User_Model->update_attempt($this->input->post('email_address'));
                echo json_encode(array("response" => "error", "message" => "Incorrect Email or Password"));
            }
        }
    }
// ORIGINAL CODE
	function is_logged_in(){

		$is_logged_in = $this->session->userdata('userlogin');

		if (!isset($is_logged_in) || $is_logged_in != true) {

			redirect('login');

			exit();
		}
	}

	// public function logout(){

	// 	$this->session->userdata('userlogin');

	// 	$this->session->sess_destroy();

	// 	redirect('login');
	// }

	// SAMPLE
	public function logout()
    {
        $this->User_Model->set_offline_status($this->session->userdata('userlogin')['user_id'], 0); // Set user to offline

        $this->session->sess_destroy();
        redirect('login');
    }

}
