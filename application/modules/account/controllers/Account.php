<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Account extends MY_Controller
{



	function __construct()
	{

		parent::__construct();


		$this->load->library('email');
		$this->load->library('user_agent');
		$this->load->library('phpmailer_lib');

		$this->email->initialize(
			array(
				'charset' => 'utf-8',
				'wordwrap'  => TRUE,
				'mailtype'  => 'html',
				'protocol'  => 'sendmail'
			)
		);
	}
	
	
	public function index()
	{
		modules::run("login/is_logged_in");

		$records['all_users'] = $this->User_Model->all_users();


		$this->load->view('layout/head');
		$this->load->view('layout/header');
		$this->load->view('layout/nav');
		$this->load->view('user', $records);
		$this->load->view('layout/footer');
	}

	public function users()
	{
		modules::run("login/is_logged_in");

		$records['all_users'] = $this->User_Model->all_users();

		$this->load->view('layout/head');
		$this->load->view('layout/header');
		$this->load->view('layout/nav');
		$this->load->view('user', $records);
		$this->load->view('layout/footer');
	}
	// USERS ONLINE
	public function users_online(){
	
		modules::run("login/is_logged_in"); 
	
		$records['get_all_users'] = $this->User_Model->get_all_users();
		$this->load->view('dashboard', $records);
	}
	// USER LOGS
	public function user_logs()
	{
		modules::run("login/is_logged_in");

		// Pass $user_id as an argument
		$records['user_id'] = $this->User_Model->user_id();

		$this->load->view('layout/head');
		$this->load->view('layout/header');
		$this->load->view('layout/nav');
		$this->load->view('user_logs', $records);
		$this->load->view('layout/footer');
	}
	public function all_users() {
        $data['users'] = $this->User_Model->get_users();
        $this->load->view('dashboard', $data);
    }
	// add user
	public function add_user()
	{
		$user_charge = $this->session->userdata['userlogin']['full_name'];
		$rand_pass = substr(md5(rand()), 0, 10);
		$password = md5($rand_pass);

		// $this->form_validation->set_rules('email_address','Email Address','trim|xss_clean|required|valid_email');
		$this->form_validation->set_rules('email_address', 'Email Address', 'trim|required|valid_email|callback_email_exists');


		if ($this->form_validation->run() == FALSE) {

			echo json_encode(array("response" => "error", "message" => validation_errors()));
		} else {
			$data =  array(
				'fname' => $this->input->post('fname'),
				'lname' => $this->input->post('lname'),
				'contact'  => $this->input->post('contact'),
				'phonenumber' => $this->input->post('phonenumber'),
				'email_add' => $this->input->post('email_address'),
				'username'  => $this->input->post('username'),
				'password' =>  md5($this->input->post('lname')),
				'usertype'  => $this->input->post('usertype'),
				'quota'  => $this->input->post('UserQuota'),
				'address'  => $this->input->post('address'),
				'status'  => $this->input->post('status'),
				'date_created' =>  date("Y-m-d H:i:s"),
			);



			$this->User_Model->insert($data);

			echo json_encode(array("response" =>   "success", "message" => "", "redirect" => base_url('dashboard')));
		}
	}

	public function email_exists($email)
	{
		if ($this->User_Model->is_email_exists($email)) {
			$this->form_validation->set_message('email_exists', 'The email address already exists.');
			return false;
		}
		return true;
	}
	// get user data
	public function view_user_profile()
	{

		$data = array();

		$userid = $this->User_Model->select_user_id($this->input->get('user_id'));

		$data = $userid;

		echo json_encode($data);
	}


	// update_user
	public function update_user()
	{

		$this->form_validation->set_rules('email_address', 'Email Address', 'trim|xss_clean|required|valid_email');

		if ($this->form_validation->run() == FALSE) {
			echo json_encode(array("response" => "error", "message" => validation_errors()));
		} else {
			$data =  array(
				'fname' => $this->input->post('fname'),
				'lname' => $this->input->post('lname'),
				'contact'  => $this->input->post('contact'),
				'phonenumber' => $this->input->post('phonenumber'),
				'email_add' => $this->input->post('email_address'),
				'address'  => $this->input->post('address'),
				'username'  => $this->input->post('username'),
				'password' =>  md5($this->input->post('lname')),
				'usertype'  => $this->input->post('usertype'),
				'quota'  => $this->input->post('UserQuota'),
				'address'  => $this->input->post('address'),
				'status'  => $this->input->post('status'),
			);


			$this->User_Model->update_user($data, $this->input->post('user_id'));
			echo json_encode(array("response" =>   "success", "message" => "", "redirect" => base_url('dashboard')));
		}
	}

	public function update_profile()
	{

		$this->form_validation->set_rules('firstName', 'First Name', 'trim|xss_clean|required');
		$this->form_validation->set_rules('lastName', 'Last Name', 'trim|xss_clean|required');
		$this->form_validation->set_rules('contact', 'Contact', 'trim|xss_clean|required');
		$this->form_validation->set_rules('email', 'Email Address', 'trim|xss_clean|required|valid_email');
		$this->form_validation->set_rules('address', 'Address', 'trim|xss_clean|required');

		if ($this->form_validation->run() == FALSE) {
			echo json_encode(array("response" => "error", "message" => validation_errors()));
		} else {
			$data =  array(
				'fname' => $this->input->post('firstName'),
				'lname' => $this->input->post('lastName'),
				'contact'  => $this->input->post('contact'),
				'email_add' => $this->input->post('email'),
				'address'  => $this->input->post('address'),
			);


			$this->User_Model->update_user($data, $this->session->userdata['userlogin']['user_id']);
			echo json_encode(array("response" =>   "success", "message" => "Successfully Updated your Profile", "redirect" => base_url('dashboard')));
		}
	}

	public function send_reset_link()
	{
		$email = $this->input->post('email');
		$user = $this->User_Model->get_user_by_email($email);
		$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');


		if ($this->form_validation->run() == FALSE) {
			echo json_encode(array("response" => "error", "message" => validation_errors()));
		} else {
			if ($user) {
				$token = bin2hex(random_bytes(50));
				$this->User_Model->store_reset_token($user->user_id, $token);
				$this->send_email($email, $token);
				echo json_encode(array("response" =>   "success", "message" => "Reset link sent to your email", "redirect" => base_url('dashboard')));
			} else {
				echo json_encode(array("response" =>   "error", "message" => "Email not found", "redirect" => base_url('dashboard')));
			}
		}
	}

	private function send_email($email, $token)
	{
		$reset_link = base_url("account/reset_password/?token=$token");
		$mail = $this->phpmailer_lib->load();

		$mail->isSMTP();
		$mail->Host = 'smtp.gmail.com';
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = "ssl";
		$mail->Port = 465;

		$mail->Username = 'webmaster@thequippyquill.com'; // gmail email
		$mail->Password = 'xbvxdooclagnxtsv'; // gmail password

		// Sender and recipient settings
		$mail->SetFrom('webmaster@thequippyquill.com', 'Quippy Quill');

		$mail->addAddress($email);

		// // Add a recipient
		// $mail->addAddress('john.doe@gmail.com');
		// // Add cc or bcc 
		// $mail->addBCC('bcc@example.com');
		// Email subject
		$mail->Subject = 'Password Reset Request CRM';
		$mail->Body =  "Click this link to reset your password: $reset_link";


		// Set email format to HTML
		$mail->isHTML(true);
		$mail->send();
	}


	public function reset_password()
	{
		$token = $this->input->get('token');
		if ($this->User_Model->is_token_valid($token)) {
			$this->load->view('reset_password', ['token' => $token]);
		} else {
			echo "Invalid or expired token.";
		}
	}


	public function update_password()
	{
		$token = $this->input->post('token');
		$new_password = $this->input->post('password');
		if ($this->User_Model->update_password($token, $new_password)) {
			echo json_encode(array("response" =>   "success", "message" => "Password updated successfully", "redirect" => base_url('login')));
		} else {
			echo json_encode(array("response" =>   "error", "message" => "Failed to update password.", "redirect" => base_url('login')));
		}
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
	

// 	public function autologin_by_email() {
//     $email = $this->input->post('email_add');
    
//     if (!$email) {
//         echo json_encode([
//             'response' => 'error',
//             'message' => 'No email provided.'
//         ]);
//         return;
//     }

//     $this->load->User_Model('User_Model');
//     $user = $this->User_Model->get_user_by_email($email);

//     if ($user) {
//         $this->session->set_userdata([
//             'user_id' => $user->user_id,
//             'email_add' => $user->email,
//             'usertype' => $user->usertype,
//             'is_logged_in' => true,
//         ]);

//         echo json_encode([
//             'response' => 'success',
//             'redirect' => base_url('dashboard')
//         ]);
//     } else {
//         echo json_encode([
//             'response' => 'error',
//             'message' => 'User not found.'
//         ]);
//     }
// }

public function autologin_by_email()
{
    $emailaddress = strtolower($this->input->post('email_add'));
    $user = $this->User_Model->get_user_by_email($emailaddress);
	$ip_address = $this->input->ip_address();


    if ($user) {
        $result = $user; // Assuming get_user_by_email returns an array with one user

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
            'log_date' => date('Y-m-d H:i:s a'),
        );

        $this->session->set_userdata('userlogin', $sessiondata);
        $this->User_Model->insert_userlog($data);

        // Set user to online
        if ($result->status == 'Active') {
            $this->handleUserLogin($result, $ip_address);
        } else {
            echo json_encode(array("response" => "error", "message" => "Account disabled, contact Admin."));
        }
    }
}

private function handleUserLogin($result, $ip_address)
{
    if ($this->isAllowedUserType($result->usertype)) {
        $this->logUserActivity($result);

       // Custom redirect based on usertype
		$redirect_url = base_url("dashboard");

		if (in_array($result->usertype, ['Sales Trainee', 'Sales Prospecting', 'Sales Tier 1', 'Sales Tier 2'])) {
			$redirect_url = base_url("dashboard/agent");
		} elseif ($result->usertype === 'Lead Gen.') {
			$redirect_url = base_url("dashboard/leadgent"); // NOTE: is this a typo? Should it be 'leadgen'?
		}

        echo json_encode([
            "response" => "success",
            "message" => "You have successfully logged in!",
            "redirect" => $redirect_url
        ]);

    } elseif ($result->attempt <= 0) {
        echo json_encode([
            "response" => "error",
            "message" => "Account locked, contact Admin."
        ]);
    } else {
        echo json_encode([
            "response" => "error",
            "message" => "Account disabled, contact Admin."
        ]);
    }
}


private function isAllowedUserType($usertype)
{
    $allowedUserTypes = ['Lead Gen.', 'Sales Trainee', 'Sales Prospecting', 'Sales Tier 1', 'Sales Tier 2'];
    return in_array($usertype, $allowedUserTypes);
}

private function logUserActivity($result)
{
    $data_activities = array(
        'remarks' => 'was logged in on CRM.',
        'admin_id' => 1,
        'unread_admin' => 1,
        'status_activity' => 3,
        'user_charge' => ucwords($result->fname . ' ' . $result->lname),
        'date_added' => date("Y-m-d H:i:s"),
    );
    $this->User_Model->set_online_status($result->user_id, 1);
    $this->Activity_Model->insert($data_activities);
}
}
