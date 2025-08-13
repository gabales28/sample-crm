<?php if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Leadgents_Model extends CI_Model
{

  function __construct()
  {

    parent::__construct();
    $this->load->database();

  }

  // start save multipletaskform
public function save_leadgent_tasks($data) {
  return $this->db->insert_batch('tblassign_leadgent', $data);
}

public function get_leads() {
  return $this->db->get('tblleads')->result_array();
}
// end save multipletaskform
  public function tableleadgents()
  {
      $this->db->select('tblassign_leadgent.*, tbluser.*, tblleads.trash,  COUNT(tblassign_leadgent.leadgent_task_id) as leadgent_tasks_total');
      $this->db->from('tblassign_leadgent');
      $this->db->join('tbluser', 'tblassign_leadgent.leadgent_user_id = tbluser.user_id', 'inner');
      $this->db->join('tblleads ', 'tblassign_leadgent.lead_id =  tblleads.lead_id', 'inner');  
      // $this->db->join('tblreturn_to_lead_control ', 'tblassign_leadgent.lead_id =  tblreturn_to_lead_control.lead_id', 'inner');  
      // $this->db->where("tblreturn_to_lead_control.return_status", 'Returned');  
      // $this->db->where("tblleads.recycle_status !=", 2);  
      $this->db->where("tblleads.trash !=", 1);  
      $this->db->where("tblassign_leadgent.lead_status_leadgent   !=", 2);  


      
  
      // Grouping by user_id and date_assigned without time
      $this->db->group_by(['tblassign_leadgent.leadgent_user_id', 'DATE(tblassign_leadgent.date_assigned)']);
      $this->db->order_by('leadgent_tasks_total', 'DESC');
  
      $query = $this->db->get();
  
      // Check if there are results and return them
      return ($query->num_rows() > 0) ? $query->result_array() : false;
  }



  public function insert($data)
  {

    if ($this->db->insert("tblassign_leadgent", $data)) {

      return true;

    }

  }



  public function insert_userlog($data)
  {

    if ($this->db->insert("tbluserlog", $data)) {

      return true;

    }

  }
  public function update_leadgent_task($data, $leadgent_task_id)
  {

    $this->db->set($data);

    $this->db->where("leadgent_task_id", $leadgent_task_id);

    $this->db->update("tblassign_leadgent");

  }

  
  public function update_details($data, $leadgent_task_id) {
    $this->db->where("leadgent_task_id", $leadgent_task_id);
    $this->db->update("tblassign_leadgent", $data);  // Directly pass the data array here for clarity
  }



  public function delete($id)
  {

    $this->db->delete('tblassign_leadgent', array('leadgent_task_id' => $id));  // Produces: // DELETE FROM mytable  // WHERE id = $id
  }

  public function update_attempt($emailaddress)
  {

    $this->db->set('attempt', 'attempt-1', FALSE);

    $this->db->where("email_add", $emailaddress);

    $this->db->update("tblassign_leadgent");

  }



  public function select_leadgent_task($leadgent_task_id) {

    $this->db->select('*')->from('tblassign_leadgent')->where(array('leadgent_task_id ' => $leadgent_task_id));

   
    $query=$this->db->get();

    if ($query->num_rows() > 0){

      return $query->result_array();

    }

    else{

        return false;

    }

    $this->$db->close();
  }

  public function update_lead_status_assign($data, $lead_id) { 
    if (is_array($lead_id)) {

        $this->db->set($data); 

        $this->db->where_in("lead_id", $lead_id); 

        $this->db->update("tblassign_leadgent"); 
    }
    return false;

 } 
  public function select_lead_task($user_id, $date_assigned) {

    $this->db->select('leads.*, leadgents.*')->from('tblassign_leadgent as leadgents');
    $this->db->join('tblleads as leads', 'leadgents.lead_id = leads.lead_id', 'inner');

    $this->db->where(array('leadgents.leadgent_user_id ' => $user_id));
    $this->db->where('DATE(leadgents.date_assigned)', $date_assigned);
    $this->db->where("leadgents.lead_status_leadgent   !=", 2);  
    $this->db->where("leads.trash   !=", 1);  



   
    $query=$this->db->get();

    if ($query->num_rows() > 0){

      return $query->result_array();

    }

    else{

        return false;

    }

    $this->db->close();
  }



// end list of tasks
  public function get_data_leadgent_task($limit, $start, $search)
  {
    $this->db->select('tblassign_leadgent.*, tbluser.*, tblleads.*, COUNT(tblassign_leadgent.task_id) as leadgent_tasks_total');
    $this->db->from('tblassign_leadgent');
    $this->db->join('tbluser', 'tblassign_leadgent.leadgent_user_id = tbluser.user_id', 'inner');
    $this->db->join('tblleads', 'tblassign_leadgent.lead_id = tblleads.lead_id', 'inner');

    if (!empty($search)) {
        $this->db->group_start();
        $this->db->like('tblleads.title', $search);
        $this->db->or_like('tblleads.customer_name', $search);
        $this->db->group_end();
    }
    
    // Grouping by user_id and date_assigned
    $this->db->group_by(['tblassign_leadgent.user_id', 'DATE(tblassign_leadgent.date_assigned)']);
    $this->db->order_by('leadgent_tasks_total', 'DESC');

    $this->db->limit($limit, $start);
    $query = $this->db->get();
    return $query->result();
}


  public function count_all()
  {
    return $this->db->count_all('tblassign_leadgent');
  }

  public function count_filtered($search)
  {
    $this->db->select('tblassign_leadgent.*, tbluser.*, tblleads.*, COUNT(tblassign_leadgent.leadgent_task_id) as leadgent_tasks_total');
    $this->db->from('tblassign_leadgent');
    $this->db->join('tbluser', 'tblassign_leadgent.leadgent_user_id = tbluser.user_id', 'inner');
    $this->db->join('tblleads', 'tblassign_leadgent.lead_id = tblleads.lead_id', 'inner');

    if (!empty($search)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->like('title', $search);
      $this->db->or_like('customer_name', $search);
      $this->db->group_end(); // End grouping for search conditions

      // Add more columns as needed
    }

    return $this->db->count_all_results();
  }

  public function fech_leadgent_task_category()
  {

    $this->db->select('leadgent_task_id, title as Lead Title, customer_name as Customer Name, lead_value as Lead Value')->from('tblassign_leadgent');



    $query = $this->db->get();


    if ($query->num_rows() > 0) {

      return $query->result_array();

    } else {

      return false;

    }

    $this->db->close();
  }
// end list of tasks




public function update_leadgent_tasks($leadgent_task_id, $data) {
  // Example: Update tasks, e.g., mark as active
  $this->db->where('leadgent_task_id', $leadgent_task_id);
  return $this->db->update('tblassign_leadgent',$data); // Adjust as needed
  // return $this->db->update('tbltasks', $data);
}
public function update_leadgent_tasks_user_assign($data, $leadgent_task_ids) {
  // Example: Update tasks, e.g., mark as active
  $this->db->where('leadgent_task_id', $leadgent_task_ids);
  return $this->db->update('tblassign_leadgent',$data); // Adjust as needed
  // return $this->db->update('tbltasks', $data);
}


public function delete_leadgent_tasks($ids) {
  // Ensure $ids is an array
  if (is_array($ids)) {
      $this->db->where_in('leadgent_task_id', $ids);
      return $this->db->delete('tblassign_leadgent');
  }
  return false;
}


// public function update_tasks($data, $task_id) {
//   $this->db->where('task_id', $task_id);
//   return $this->db->update('tbltasks', $data);
// }

// public function get_filtered_leads($lead_status, $user_id) {
//   $this->db->select('*')
//            ->from('tblleads')
//            ->where('lead_status', $lead_status)
//            ->where('user_id', $user_id);

//   $query = $this->db->get();
//   return ($query->num_rows() > 0) ? $query->result_array() : [];
// }



}
?>

