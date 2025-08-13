<?php if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Agents_Model extends CI_Model
{

  function __construct()
  {

    parent::__construct();
    $this->load->database();

  }

  // start save multipletaskform
public function save_agent_tasks($data) {
  return $this->db->insert_batch('tblassign_agent', $data);
}

public function get_leads() {
  return $this->db->get('tblleads')->result_array();
}
// end save multipletaskform
  public function tableagents()
  {
    $this->db->select('tblassign_agent.*, leadgent_user.*, tblleads.*, tbluser.*, COUNT(tblassign_agent.agent_task_id) AS tasks_total, 
    IF(tblassign_leadgent.leadgent_user_id IS NULL, "", leadgent_user.fname) AS leadgent_fname, 
    IF(tblassign_leadgent.leadgent_user_id IS NULL, "", leadgent_user.lname) AS leadgent_lname');
    $this->db->from('tblassign_agent');
    $this->db->join('tblleads', 'tblassign_agent.lead_id = tblleads.lead_id', 'inner');
    $this->db->join('tbluser', 'tblassign_agent.user_id = tbluser.user_id', 'inner');
    $this->db->join('tblassign_leadgent', 'tblleads.lead_id = tblassign_leadgent.lead_id', 'inner');
    $this->db->join('tbluser as leadgent_user ', 'tblassign_leadgent.leadgent_user_id = leadgent_user.user_id', 'inner');
    $this->db->group_by('tblassign_agent.user_id, DATE(tblassign_agent.agent_date_assigned)');
    $this->db->order_by('tasks_total', 'DESC');
    $this->db->where(array('tblassign_leadgent.lead_status_leadgent !=' => 2));
    // $this->db->where(array('tblassign_agent.user_id ' => $user_id));
    $this->db->where("lead_status_assign", 1); 
    $this->db->where("tblleads.trash !=", 1); 
        $this->db->where('tblassign_agent.lead_assign !=',  2);
        $this->db->where("tblassign_agent.agent_trash_lead !=", 2); 

    // $this->db->where(array('tblassign_leadgent.lead_status_leadgent !=' => 2));
    // $this->db->where('tblleads.lead_status_assign !=', 0);
    // $this->db->where('tblassign_leadgent.lead_status_leadgent !=', 2);

    // $this->db->group_by('tblleads.lead_id');



    // Grouping by user_id and date_assigned without time
    $this->db->group_by(['tblassign_agent.user_id', 'DATE(tblassign_agent.agent_date_assigned)']);
    $this->db->order_by('tasks_total', 'DESC');
  
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


  public function select_agent_user_task($agent_task_id) {

    $this->db->select('*')->from('tblassign_agent')->where(array('agent_task_id ' => $agent_task_id));

   
    $query=$this->db->get();

    if ($query->num_rows() > 0){

      return $query->result_array();

    }

    else{

        return false;

    }

    $this->$db->close();
  }


  public function select_agent_user_recycle_task($agent_task_id) {
    // Start building the query
    $this->db->select('tblassign_agent.*, tbluser.*')
             ->from('tblassign_agent')
             ->join('tbluser', 'tblassign_agent.user_id = tbluser.user_id', 'inner')
             ->where(array('tblassign_agent.agent_task_id' => $agent_task_id));

    // Execute the query
    $query = $this->db->get();

    // Check if any results were returned
    if ($query->num_rows() > 0) {
        return $query->result_array(); // Return results as an array
    } else {
        return false; // Return false if no results found
    }

    // Attempt to close the database connection (this line contains an error)
    $this->$db->close(); // Incorrect syntax, should be $this->db->close();
}


  public function insert_data($data) {
    return $this->db->insert('tblrecycle_history', $data);
  }

  public function select_agent_user_tasks($agent_task_id) {

    $this->db->select('*')->from('tblassign_agent')->where(array('agent_task_id ' => $agent_task_id));

   
    $query=$this->db->get();

    if ($query->num_rows() > 0){

      return $query->result_array();

    }

    else{

        return false;

    }

    $this->$db->close();
  }

  public function select_agent_task($user_id, $date_assigned) {
    $this->db->select('tblassign_agent.*, leadgent_user.*, tblleads.*, tbluser.*, remarks.remark_tasks, 
    IF(tblassign_leadgent.leadgent_user_id IS NULL, "", leadgent_user.fname) AS leadgent_fname, 
    IF(tblassign_leadgent.leadgent_user_id IS NULL, "", leadgent_user.lname) AS leadgent_lname, ');
    $this->db->from('tblassign_agent');
    $this->db->join('tblleads', 'tblassign_agent.lead_id = tblleads.lead_id', 'inner');
    $this->db->join('tbluser', 'tblassign_agent.user_id = tbluser.user_id', 'inner');
    $this->db->join('tblassign_leadgent', 'tblleads.lead_id = tblassign_leadgent.lead_id', 'inner');
    $this->db->join('tbluser as leadgent_user ', 'tblassign_leadgent.leadgent_user_id = leadgent_user.user_id', 'inner');
    $this->db->join('(SELECT *  FROM tblremarks WHERE (lead_id, date_remark) IN (SELECT lead_id, MAX(date_remark) FROM tblremarks GROUP BY lead_id)) remarks', 'tblassign_agent.lead_id = remarks.lead_id', 'left');
    $this->db->where(array('tblassign_leadgent.lead_status_leadgent !=' => 2));
    $this->db->where(array('tblassign_agent.user_id ' => $user_id));
    $this->db->where('DATE(tblassign_agent.agent_date_assigned)', $date_assigned);
    $this->db->where(array('tblassign_leadgent.lead_status_leadgent !=' => 2));
    // $this->db->where(array('tblassign_agent.user_id ' => $user_id));
    $this->db->where("tblleads.lead_status_assign", 1); 
    $this->db->where("tblleads.trash !=", 1); 
    $this->db->where('tblassign_agent.lead_assign !=',  2);
    $this->db->where('tblassign_agent.agent_trash_lead !=',  2);

   
    $query=$this->db->get();

    if ($query->num_rows() > 0){

      return $query->result_array();

    }

    else{

        return false;

    }

    $this->db->close();
  }


  public function select_agent_recycle_task($user_id, $date_assigned) {
    $this->db->select('tblassign_agent.*, leadgent_user.*, tblleads.*, tbluser.*, remarks.remark_tasks, 
    IF(tblassign_leadgent.leadgent_user_id IS NULL, "", leadgent_user.fname) AS leadgent_fname, 
    IF(tblassign_leadgent.leadgent_user_id IS NULL, "", leadgent_user.lname) AS leadgent_lname, ');
    $this->db->from('tblassign_agent');
    $this->db->join('tblleads', 'tblassign_agent.lead_id = tblleads.lead_id', 'inner');
    $this->db->join('tbluser', 'tblassign_agent.user_id = tbluser.user_id', 'inner');
    $this->db->join('tblassign_leadgent', 'tblleads.lead_id = tblassign_leadgent.lead_id', 'inner');
    $this->db->join('tbluser as leadgent_user ', 'tblassign_leadgent.leadgent_user_id = leadgent_user.user_id', 'inner');
    $this->db->join('(SELECT *  FROM tblremarks WHERE (lead_id, date_remark) IN (SELECT lead_id, MAX(date_remark) FROM tblremarks GROUP BY lead_id)) remarks', 'tblassign_agent.lead_id = remarks.lead_id', 'left');

    $this->db->where(array('tblassign_agent.user_id ' => $user_id));
    $this->db->where("tblleads.lead_status_assign", 1); 
    $this->db->where("tblleads.trash !=", 1);
    $this->db->where("tblassign_agent.lead_assign !=", 2); 
    $this->db->where("tblassign_agent.agent_trash_lead !=", 2); 
    $this->db->where('DATE(tblassign_agent.agent_date_assigned)', $date_assigned);
    $this->db->group_by('tblleads.lead_id');
    $this->db->order_by('tblassign_agent.agent_date_assigned ', 'DESC');




   
    $query=$this->db->get();

    if ($query->num_rows() > 0){

      return $query->result_array();

    }

    else{

        return false;

    }

    $this->db->close();
  }
  public function select_recycle_agent_task($user_id, $date_assigned) {
    $this->db->select('tblassign_agent.*, leadgent_user.*, tblleads.*, tbluser.*, remarks.remark_tasks, 
    IF(tblassign_leadgent.leadgent_user_id IS NULL, "", leadgent_user.fname) AS leadgent_fname, 
    IF(tblassign_leadgent.leadgent_user_id IS NULL, "", leadgent_user.lname) AS leadgent_lname, ');
    $this->db->from('tblassign_agent');
    $this->db->join('tblleads', 'tblassign_agent.lead_id = tblleads.lead_id', 'inner');
    $this->db->join('tbluser', 'tblassign_agent.user_id = tbluser.user_id', 'inner');
    $this->db->join('tblassign_leadgent', 'tblleads.lead_id = tblassign_leadgent.lead_id', 'inner');
    $this->db->join('tbluser as leadgent_user ', 'tblassign_leadgent.leadgent_user_id = leadgent_user.user_id', 'inner');
    $this->db->join('(SELECT *  FROM tblremarks WHERE (lead_id, date_remark) IN (SELECT lead_id, MAX(date_remark) FROM tblremarks GROUP BY lead_id)) remarks', 'tblassign_agent.lead_id = remarks.lead_id', 'left');

    $this->db->where(array('tblassign_agent.user_id ' => $user_id));
    $this->db->where('DATE(tblassign_agent.agent_date_assigned)', $date_assigned);


   
    $query=$this->db->get();

    if ($query->num_rows() > 0){

      return $query->result_array();

    }

    else{

        return false;

    }

    $this->db->close();
  }
  public function select_view_agent_task($user_id, $date_assigned) {
    $this->db->select('tblassign_agent.*, leadgent_user.*, tblleads.*, tbluser.*, remarks.remark_tasks, 
    IF(tblassign_leadgent.leadgent_user_id IS NULL, "", leadgent_user.fname) AS leadgent_fname, 
    IF(tblassign_leadgent.leadgent_user_id IS NULL, "", leadgent_user.lname) AS leadgent_lname');
    $this->db->from('tblassign_agent');
    $this->db->join('tblleads', 'tblassign_agent.lead_id = tblleads.lead_id', 'inner');
    $this->db->join('tbluser', 'tblassign_agent.user_id = tbluser.user_id', 'inner');
    $this->db->join('tblassign_leadgent', 'tblleads.lead_id = tblassign_leadgent.lead_id', 'inner');
    $this->db->join('tbluser as leadgent_user ', 'tblassign_leadgent.leadgent_user_id = leadgent_user.user_id', 'inner');
    $this->db->join('(SELECT *  FROM tblremarks WHERE (lead_id, date_remark) IN (SELECT lead_id, MAX(date_remark) FROM tblremarks GROUP BY lead_id)) remarks', 'tblassign_agent.lead_id = remarks.lead_id', 'left');

    $this->db->where(array('tblassign_agent.user_id ' => $user_id));
    $this->db->where('DATE(tblassign_agent.agent_date_assigned)', $date_assigned);


   
    $query=$this->db->get();

    if ($query->num_rows() > 0){

      return $query->result_array();

    }

    else{

        return false;

    }

    $this->db->close();
  }
  public function select_agent_task_lead($agent_task_id) {

    $this->db->select('tblassign_agent.*, leadgent_user.*, tblleads.*, 
    IF(tblassign_leadgent.leadgent_user_id IS NULL, "", leadgent_user.fname) AS leadgent_fname, 
    IF(tblassign_leadgent.leadgent_user_id IS NULL, "", leadgent_user.lname) AS leadgent_lname');
    $this->db->from('tblassign_agent');
    $this->db->join('tblleads', 'tblassign_agent.lead_id = tblleads.lead_id', 'inner');
    $this->db->join('tbluser', 'tblassign_agent.user_id = tbluser.user_id', 'inner');
    $this->db->join('tblassign_leadgent', 'tblleads.lead_id = tblassign_leadgent.lead_id', 'inner');
    $this->db->join('tbluser as leadgent_user ', 'tblassign_leadgent.leadgent_user_id = leadgent_user.user_id', 'inner');


    $this->db->where(array('tblassign_agent.agent_task_id ' => $agent_task_id));
    // $this->db->where('DATE(agents.agent_date_assigned)', );


   
    $query=$this->db->get();

    if ($query->num_rows() > 0){

      return $query->result_array();

    }

    else{

        return false;

    }

    $this->db->close();
  }
// 
 


    public function agent_tasks($user_id = 0)
    {
        $user_id = (int) $user_id;
        $this->db->select('tblassign_agent.*,  tbluser.*, tblleads.trash, COUNT(tblassign_agent.agent_task_id) as tasks_total');
        $this->db->from('tblassign_agent');
        $this->db->join('tbluser', 'tblassign_agent.user_id = tbluser.user_id', 'inner');
        // $this->db->join('tblleads', 'tblleads.lead_id = tblleads.lead_id', 'inner');
        $this->db->join('tblleads', 'tblassign_agent.lead_id = tblleads.lead_id', 'inner');
        $this->db->where("lead_assign !=", 2); 
        $this->db->where("tblassign_agent.agent_trash_lead !=", 2); 
        $this->db->where("tblleads.trash !=", 1); 
        $this->db->where("tblleads.lead_status_assign", 1); 
        $this->db->where("tblassign_agent.leadgent_user_id", $user_id);

    
        // Grouping by user_id and date_assigned without time
        $this->db->group_by(['tblassign_agent.user_id', 'DATE(tblassign_agent.agent_date_assigned)']);
        // $this->db->order_by('tasks_total', 'DESC');
        $this->db->order_by('agent_date_assigned', 'DESC');

    
        $query = $this->db->get();
    
        // Check if there are results and return them
        return ($query->num_rows() > 0) ? $query->result_array() : false;
        $this->db->close();

    }


   public function update_lead_status_assign($data, $lead_id) { 
    if (is_array($lead_id)) {

        $this->db->set($data); 

        $this->db->where_in("lead_id", $lead_id); 

        $this->db->update("tblassign_agent"); 
    }
    return false;

 } 
    // group by agent_id
    public function agent_group_task($user_id = 0)
    {
        $user_id = (int) $user_id;
        $this->db->select('tblassign_agent.*, tbluser.*, tblleads.trash, COUNT(tblassign_agent.agent_task_id) as tasks_total');
        $this->db->from('tblassign_agent');
        $this->db->join('tbluser', 'tblassign_agent.user_id = tbluser.user_id', 'inner');
        $this->db->join('tblleads', 'tblassign_agent.lead_id = tblleads.lead_id', 'inner');
        $this->db->where('tblassign_agent.lead_assign !=', 2);
        $this->db->where('tblassign_agent.agent_trash_lead !=', 2);
        $this->db->where('tblleads.trash !=', 1);
        $this->db->where("tblleads.lead_status_assign", 1); 
        $this->db->where("tblassign_agent.leadgent_user_id", $user_id);

    
        // Grouping by user_id and date_assigned without time
        $this->db->group_by(['tblassign_agent.user_id']);
        $this->db->order_by('tasks_total', 'DESC');
    
        $query = $this->db->get();
    
        // Check if there are results and return them
        return ($query->num_rows() > 0) ? $query->result_array() : false;
        $this->db->close();

    }



  //view agent\
  public function view_agent_tasks($user_id)
  {
    $this->db->select('tblassign_agent.*, leadgent_user.*, tblleads.*, tbluser.*, COUNT(tblassign_agent.agent_task_id) AS tasks_total, 
    IF(tblassign_leadgent.leadgent_user_id IS NULL, "", leadgent_user.fname) AS leadgent_fname, 
    IF(tblassign_leadgent.leadgent_user_id IS NULL, "", leadgent_user.lname) AS leadgent_lname');
    $this->db->from('tblassign_agent');
    $this->db->join('tblleads', 'tblassign_agent.lead_id = tblleads.lead_id', 'inner');
    $this->db->join('tbluser', 'tblassign_agent.user_id = tbluser.user_id', 'inner');
    $this->db->join('tblassign_leadgent', 'tblleads.lead_id = tblassign_leadgent.lead_id', 'inner');
    $this->db->join('tbluser as leadgent_user ', 'tblassign_leadgent.leadgent_user_id = leadgent_user.user_id', 'inner');
    $this->db->group_by('tblassign_agent.user_id, DATE(tblassign_agent.agent_date_assigned)');
    $this->db->order_by('tasks_total', 'DESC');
    $this->db->where('tblassign_agent.lead_assign !=',  2);
    $this->db->where('tblassign_agent.agent_trash_lead !=',  2);
    $this->db->where("tblleads.lead_status_assign", 1); 
    $this->db->where("tblassign_leadgent.lead_status_leadgent !=", 2); 
    $this->db->where('tblleads.trash !=',  1);



    $this->db->where("tblassign_agent.user_id", $user_id);


    // Grouping by user_id and date_assigned without time
 
  
      $query = $this->db->get();
  
      // Check if there are results and return them
      return ($query->num_rows() > 0) ? $query->result_array() : false;
      
  }

//   public function view_agent_tasks($user_id)
// {
//     $this->db->select('tblassign_agent.*, tbluser.*, COUNT(tblassign_agent.agent_task_id) as tasks_total');
//     $this->db->from('tblassign_agent');
//     $this->db->join('tbluser', 'tblassign_agent.user_id = tbluser.user_id', 'inner');
    
//     // Specify the table for user_id to avoid ambiguity
//     $this->db->where("tblassign_agent.user_id", $user_id);

//     // Grouping by user_id and date_assigned without time
//     $this->db->group_by(['tblassign_agent.user_id', 'DATE(tblassign_agent.agent_date_assigned)']);
//     $this->db->order_by('tasks_total', 'DESC');

//     $query = $this->db->get();

//     // Check if there are results and return them
//     return ($query->num_rows() > 0) ? $query->result_array() : false;
// }


  
public function update_agent_tasks($agent_task_id, $data) {
  // Example: Update tasks, e.g., mark as active
  $this->db->where('agent_task_id', $agent_task_id);
  return $this->db->update('tblassign_agent',$data); // Adjust as needed
  // return $this->db->update('tbltasks', $data);
}
public function delete_agent_tasks($ids) {
  // Ensure $ids is an array
  if (is_array($ids)) {
      $this->db->where_in('agent_task_id', $ids);
      return $this->db->delete('tblassign_agent');
  }
  return false;
}

public function update_agent_recycle_tasks($agent_task_id, $data) {
  // Example: Update tasks, e.g., mark as active
  $this->db->where('agent_task_id', $agent_task_id);
  return $this->db->update('tblassign_agent',$data); // Adjust as needed
  // return $this->db->update('tbltasks', $data);
}
// public function update_agent_date($data) {
//   if (!empty($data['agent_task_id'])) {
//       // Select necessary fields from tblassign_agent and tblleads
//       $this->db->select('tblassign_agent.*, tblleads.*'); // Ensure to select the required fields
//       $this->db->from('tblassign_agent');
//       $this->db->join('tblleads', 'tblleads.lead_id = tblassign_agent.lead_id', 'left'); // Join on lead_id
//       $this->db->where('tblassign_agent.agent_task_id', $data['lead_id']);
      
//       // Update the tblassign_agent table with the provided data
//       if ($this->db->update('tblassign_agent', $data)) {
//           return true; // Return true on successful update
//       }
//   }
//   return false; // Return false if lead_id is not set or update fails
// }

// public function update_agent($data) {
//   $this->db->where('agent_task_id', $data['agent_task_id']);
//   return $this->db->update('tblassign_agent', $data); // Update the 'agents' table
// }
// public function update_agent($data){
//   return $this->db->insert('tblassign_agent', $data);
// }


public function get_agent_task_details($agent_task_id, $lead_id, $transaction_id = 0, $services_status = "") {
  $this->db->select('agents.*, (agents.pitched_price + agents.pitched_price_marketing + agents.pitched_price_packages) as p_price, transactions.payment_status, transactions.services_status as trans_services_status,  transactions.lead_id AS trans_lead_id, transactions.transaction_id, transactions.date_paid, SUM(transactions.amount) as total_amount')
           ->from('tblassign_agent agents')
           ->join('(SELECT *  FROM tbltransaction_history WHERE (lead_id, date_paid) IN (SELECT lead_id, MAX(date_paid) FROM tbltransaction_history GROUP BY lead_id)) transactions', 'agents.agent_task_id = transactions.agent_task_id', 'left')
           ->where([
               'agents.agent_task_id' => $agent_task_id,
               'agents.lead_id' => $lead_id,
               'agents.services_status' => $services_status
           ]);
  $query = $this->db->get();
  return $query->result();
}

public function update_agent($data, $agent_task_id) {
  $this->db->where('agent_task_id', $agent_task_id);
  return $this->db->update('tblassign_agent', $data);
}
public function insertPitchedprice($data) {
  return $this->db->insert('tblpitched_price', $data);
}

public function agent_total_sales($agentuser_id = 0) {
  $this->db->select('SUM(amount) as total_sales')->from('tblpayment_transaction_history')
  ->where("DATE_FORMAT(expiration_date, '%Y-%m-%d') >  DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 1 DAY), '%Y-%m-%d')");

  if ($agentuser_id > 0) {
      $this->db->where('agent_user_id', $agentuser_id);
  }

  $query = $this->db->get();
  

  if ($query->num_rows() > 0){

    return $query->row_array();

  }
  else{
      return '0.00';
  }
}

public function agent_qouta() {
  $this->db->select('SUM(quota) as total_qouta')->from('tbluser');
  $query = $this->db->get();
  
  return $query->row_array() ?: '0.00';
}
public function agent_breakout_payment($agentuser_id = 0) {
  $this->db->select('*')->from('tblpayment_transaction_history')
  ->where("expiration_date IS NOT NULL ")
  ->where("date_paid IS NOT NULL");
  if ($agentuser_id > 0) {
      $this->db->where('agent_user_id', $agentuser_id);
  }

  $query = $this->db->get();
  
  return $query->result_array() ?: false;
}

public function select_single_row_agent_lead($lead_id) {

  $this->db->select('*')->from('tblassign_agent')->where(array('lead_id ' => $lead_id));

  $this->db->order_by('agent_date_assigned', 'DESC');
  $this->db->limit(1);


  $query=$this->db->get();

  if ($query->num_rows() > 0){

    return $query->row_array();

  }
  else{
      return false;
  }

  $this->db->close();
}
public function transaction_amount($lead_id = 0, $services_status) {
  $this->db->select('SUM(amount) as total_payment')->from('tbltransaction_history');
   $this->db->where('lead_id', $lead_id);
   $this->db->where('services_status', $services_status);
  

  $query = $this->db->get();
  

  if ($query->num_rows() > 0){

    return $query->row_array();

  }
  else{
      return false;
  }
}

}
?>

