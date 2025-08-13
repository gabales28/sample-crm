<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Appointment extends MY_Controller {

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

		$records['tableApp'] = $this->Appointment_Model->tableApp();
		$records['leads'] = $this->Leads_Model->tableleads();
		$records['leadgent_users'] = $this->User_Model->view_account_leadgent();
		
		$this->load->view('layout/head');
		$this->load->view('layout/header');
		$this->load->view('layout/nav');
		$this->load->view('appointment', $records);
		$this->load->view('layout/footer');
		}

	   // add Appointment
	//    public function tableApp(){
	//   	$user_charge = $this->session->userdata['userlogin']['full_name'];
	
	// 	   $data =  array(
			
	// 						'lead_id' => $this->input->post('title') ,
	// 						'user_id' => $this->input->post('assign_to') ,
	// 						'appointment_status' => "Open",
	// 						'appointment_remarks' => $this->input->post('appointment_remarks'),
	// 						'appointment_schedule' => $this->input->post('appointment_schedule'),
	// 						'start_time' =>  $this->input->post('start_time'),
	// 						'end_time' =>  $this->input->post('end_time'),

	// 						);
	
	// 			$this->Appointment_Model->insert($data);
	// 			echo json_encode(array("response" =>   "success", "message" => "Successfully Added Appointment", "redirect" => base_url('dashboard')));
				
	// }
	public function tableApp() {
		$user_charge = $this->session->userdata['userlogin']['full_name'];
		$appointment_schedule = $this->input->post('appointment_schedule');
		$start_time = $this->input->post('start_time');
		$end_time = $this->input->post('end_time');
	
		$start_time = DateTime::createFromFormat('h:i A', $this->input->post('start_time'))->format('H:i:s');
		$end_time = DateTime::createFromFormat('h:i A', $this->input->post('end_time'))->format('H:i:s');
		// Check for existing open appointments
		$existingAppointment = $this->Appointment_Model->checkAvailability($appointment_schedule, $start_time, $end_time);
	
		if ($existingAppointment) {
			echo json_encode(array("response" => "error", "message" => "Appointment slot is already taken."));
			return;
		}
		$data = array(
			'lead_id' => $this->input->post('title'),
			'user_id' => $this->input->post('assign_to'),
			'appointment_status' => "Open",
			'appointment_remarks' => $this->input->post('appointment_remarks'),
			'appointment_schedule' => $appointment_schedule,
			'start_time' => $start_time,
			'end_time' => $end_time,
		);
		$this->Appointment_Model->insert($data);
		echo json_encode(array("response" => "success", "message" => "Successfully Added Appointment", "redirect" => base_url('dashboard')));
	}
		
		// get APPOINTMENT data
		public function view_appointment_details() { 
			$data=array();
			$appointmentid =$this->Appointment_Model->select_appointment_id($this->input->get('appointment_id')); 

			$data = $appointmentid;
			echo json_encode($data);             

		 }
	//   // update appointment
		  public function update_appointment_details(){
			
			$data =  array(

							'lead_id' => $this->input->post('title') ,
							'user_id' => $this->input->post('assign_to') ,
							'appointment_status' => $this->input->post('appointment_status'),
							'appointment_remarks' => $this->input->post('appointment_remarks'),
							'appointment_schedule' => $this->input->post('appointment_schedule'),
							'start_time' =>  $this->input->post('start_time'),
							'end_time' =>  $this->input->post('end_time'),
							  );
				  $this->Appointment_Model->update_details($data, $this->input->post('appointment_id'));
				  echo json_encode(array("response" =>   "success", "message" => "Successfully Updated Appointment", "redirect" => base_url('appointment')));
	  }	
	
// =============================================================

// public function checkAvailableTimes() {
//     $this->load->model('Appointment_model');
    
//     $date = $this->input->post('date');

//     // Fetch unavailable times from the model
//     $unavailable_times = $this->Appointment_model->getUnavailableTimes($date);

//     // Define the full range of available times for the day
//     $all_times = array("09:00", "10:00", "11:00", "12:00", "1:00", "2:00", "3:00","04:00", "5:00", "6:00", "7:00", "8:00", "9:00"); // Example times

//     // Determine available times by excluding unavailable times from all times
//     $available_times = array_diff($all_times, $unavailable_times);

//     // Return the available and unavailable times as a JSON response
//     echo json_encode(array('unavailable_times' => $unavailable_times, 'available_times' => $available_times));
// }

public function checkAvailableTimes() {
    $this->load->model('Appointment_model');
    
    $date = $this->input->post('date');

    // Fetch unavailable times from the model
    $unavailable_times = $this->Appointment_model->getUnavailableTimes($date);

    // Return the unavailable times as a JSON response
    echo json_encode(array('unavailable_times' => $unavailable_times));
}

	
}

