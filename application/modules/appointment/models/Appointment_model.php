<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Appointment_Model extends CI_Model {

   function __construct() {

      parent::__construct();

   }

     public function tableApp(){

      $this->db->select('appointment.*,leads.*, users.*')->from('tblappointment as appointment')
      ->join('tblleads as leads', 'appointment.lead_id = leads.lead_id', 'inner')
      ->join('tbluser as users', 'appointment.user_id = users.user_id', 'inner');

      $query=$this->db->get();
 
 
      if ($query->num_rows() > 0){
 
        return $query->result_array();
 
      }
 
      else{
 
          return false;
 
      }
 
      $this->db->close();
 
    }
   public function insert($data){

     if ($this->db->insert("tblappointment", $data)) {

       return true;

    }
   
   }

   public function insert_userlog($data) {

     if ($this->db->insert("tbluserlog", $data)) {

        return true;

     }

  }
  

  

 // GET APPOINTMENT DATA
   public function select_appointment_id($appointment_id){ // select_appointment_id FROM APPOINTMENT CONTROLLER

    $this->db->select('*')->from('tblappointment')->where(array('appointment_id' => $appointment_id));

    $query=$this->db->get();

    if ($query->num_rows() > 0){
      return $query->result_array();
    }
    else{
        return false;
    }
    $this->db->close();
  }
// UPDATE APPOINTMENT DATA

// public function update_details($data, $appointment_id) { 

//   $this->db->set($data); 

//   $this->db->where("appointment_id", $appointment_id); 

//   $this->db->update("tblappointment"); 
// } 
public function update_details($data, $appointment_id) {
  $this->db->where("appointment_id", $appointment_id);
  $this->db->update("tblappointment", $data);  // Directly pass the data array here for clarity
}

public function checkAvailability($date, $start_time, $end_time) {
    $start_time_obj = new DateTime($start_time);
    $end_time_obj = new DateTime($end_time);
    
    $start_time_minus_one_hour = (clone $start_time_obj)->modify('-1 hour')->format('H:i:s');
    $end_time_plus_one_hour = (clone $end_time_obj)->modify('+1 hour')->format('H:i:s');

    $this->db->where('appointment_schedule', $date);
    $this->db->where('appointment_status', 'Open');
    $this->db->group_start();
    $this->db->where("start_time BETWEEN '$start_time_minus_one_hour' AND '$end_time_plus_one_hour'");
    $this->db->or_where("end_time BETWEEN '$start_time_minus_one_hour' AND '$end_time_plus_one_hour'");
    $this->db->or_where("'$start_time' BETWEEN start_time AND end_time");
    $this->db->or_where("'$end_time' BETWEEN start_time AND end_time");
    $this->db->group_end();

    $query = $this->db->get('tblappointment');
    return $query->row();
}




// ==============================================================

// public function getUnavailableTimes($date) {
//   $this->db->select('start_time, end_time');
//   $this->db->where('appointment_schedule', $date);
//   $this->db->where('appointment_status', 'Open');
//   $query = $this->db->get('tblappointment'); // Replace 'tblappointment' with your actual table name
  
//   $unavailable_times = array();
//   foreach ($query->result() as $row) {
//       $start_time = $row->start_time;
//       $end_time = $row->end_time;

//       // Add both start and end times to the unavailable times array
//       $unavailable_times[] = date('H:i', strtotime($start_time));
//       $unavailable_times[] = date('H:i', strtotime($end_time));
//   }

//   return $unavailable_times;
// }

public function getUnavailableTimes($date) {
  $this->db->select('start_time, end_time');
  $this->db->where('appointment_schedule', $date);
  $this->db->where('appointment_status', 'Open');
  $query = $this->db->get('tblappointment'); // Replace 'tblappointment' with your actual table name
  
  $unavailable_times = array();
  foreach ($query->result() as $row) {
      $start_time = $row->start_time;
      $end_time = $row->end_time;

      // Add both start and end times to the unavailable times array
      $unavailable_times[] = date('H:i', strtotime($start_time));
      $unavailable_times[] = date('H:i', strtotime($end_time));
  }

  return $unavailable_times;
}


}
?>

