<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recycle_Model extends CI_Model {

   function __construct() {

      parent::__construct();
   }

   public function get_recycled_view_agenttask_data_lead($limit, $start, $search = null, $lead_id = 0, $lead_status = null)  {
    $this->db->select('
        user.*, 
        leadgen.*, 
        lead.*, 
        recycle.*, 
        agents.*, 
        agents.payment_status, 
        agents.agent_priority,  
      agents.services_status as agent_services_status, 
      SUM(transactions.pitched_price) as p_price,  
      COALESCE(SUM(transactions.total_payment), 0) as total_payment, 
      COALESCE(SUM(transactions.balance), 0) as balance, 
        transactions.transaction_id, 
        remarks.remark_tasks,
        transactions.services_status, 
        transactions.agent_remarks, 
    ');
    
    $this->db->from('tblrecycle_history as recycle');
    $this->db->join('tblassign_agent as agents', 'recycle.agent_task_id = agents.agent_task_id', 'inner');
    $this->db->join('tbltransaction_history as transactions', 'agents.agent_task_id = transactions.agent_task_id', 'left');

    $this->db->join('tblleads as lead', 'recycle.lead_id = lead.lead_id', 'inner');
    $this->db->join('tblassign_leadgent as leadgen', 'agents.leadgent_task_id  = leadgen.leadgent_task_id', 'inner');
    $this->db->join('tbluser as user', 'leadgen.leadgent_user_id = user.user_id', 'inner');

    // Joining latest remark per lead
    $this->db->join('(SELECT * FROM tblremarks WHERE (lead_id, date_remark) IN 
                    (SELECT lead_id, MAX(date_remark) FROM tblremarks GROUP BY lead_id)) remarks',
      'agents.lead_id = remarks.lead_id', 'left');
    // $this->db->join('( SELECT lead_id, remark_tasks, MAX(date_remark) AS latest_remark FROM tblremarks GROUP BY lead_id
    // ) as remarks', 'recycle.lead_id = remarks.lead_id', 'left');

    $this->db->group_by('agents.lead_id');

    $this->db->where('agents.agent_trash_lead !=', 2);  


    $this->db->where('lead.trash !=', 1);  
    $this->db->order_by('recycle.date_recycle', 'DESC');
    
   
     if (!empty($lead_status) && empty($search)) {
       $this->db->group_start(); // Start grouping for search conditions
       $this->db->where('lead.lead_status', $lead_status);
       $this->db->group_end(); // End grouping for search conditions
   
     } 
     else if ($lead_id > 0) {
       $this->db->group_start(); // Start grouping for search conditions
       $this->db->where('lead.lead_id', $lead_id);
       $this->db->group_end(); // End grouping for search conditions
   
     } 
     
     else if (!empty($search) && empty($lead_status)) {
       $this->db->group_start(); // Start grouping for search conditions
       $this->db->like('lead.title', $search);
       $this->db->or_like('lead.customer_name', $search);
       $this->db->or_like('CONCAT(user.fname, " ", user.lname)', $search);
       $this->db->or_like('CONCAT(agentuser.fname, " ",  agentuser.lname)', $search);
       $this->db->or_like('lead.customer_contact', $search);
       $this->db->group_end(); // End grouping for search conditions
   
     } else if (!empty($lead_status) && !empty($search)) {
       $this->db->group_start(); // Start grouping for search conditions
       $this->db->where('lead.lead_status', $lead_status);
       $this->db->like('lead.title', $search);
       $this->db->or_like('lead.customer_name', $search);
       $this->db->or_like('lead.customer_contact', $search);
       $this->db->or_like('CONCAT(user.fname, " ", user.lname)', $search);
       $this->db->or_like('CONCAT(agentuser.fname, " ",  agentuser.lname)', $search);
       $this->db->group_end(); // End grouping for search conditions
     }
   
     $this->db->limit($limit, $start);
     $query = $this->db->get();
     return $query->result();
   }
   public function count_recycle_filtered_view_agent_task($search = null, $lead_id = 0, $lead_status = null)
   {
    $this->db->select('
    lead.customer_name, lead.customer_contact, lead.customer_email, lead.customer_address, lead.brand_name, lead.title, lead.book_link, lead.source, lead.lead_status, 
     recycle.*');

      $this->db->from('tblrecycle_history as recycle');
      
      
      $this->db->join('tblleads as lead', 'recycle.lead_id = lead.lead_id', 'inner');
      
      $this->db->where('lead.trash !=', 1);  
      $this->db->group_by('recycle.lead_id');

   
       if (!empty($lead_status) && empty($search)) {
           $this->db->group_start();
           $this->db->where('lead.lead_status', $lead_status);
           $this->db->group_end();
       } else if ($lead_id > 0) {
           $this->db->group_start();
           $this->db->where('lead.lead_id', $lead_id);
           $this->db->group_end();
       } else if (!empty($search) && empty($lead_status)) {
           $this->db->group_start();
           $this->db->like('lead.title', $search);
           $this->db->or_like('lead.customer_name', $search);
           $this->db->or_like('CONCAT(user.fname, " ", user.lname)', $search);
           $this->db->or_like('lead.customer_contact', $search);
           $this->db->group_end();
       } else if (!empty($lead_status) && !empty($search)) {
           $this->db->group_start();
           $this->db->where('lead.lead_status', $lead_status);
           $this->db->like('lead.title', $search);
           $this->db->or_like('lead.customer_name', $search);
           $this->db->or_like('lead.customer_contact', $search);
           $this->db->or_like('CONCAT(user.fname, " ", user.lname)', $search);
           $this->db->group_end();
       }
   
       // Prevent duplicate counting
       $this->db->group_by('recycle.lead_id');
   
       $query = $this->db->get();
       return $query->num_rows(); // More reliable than count_all_results in this setup
   }
   
   
   public function count_recycle_all_view_agenttask()
   {
     return $this->db->count_all('tblrecycle_history');
   }

   public function update($data, $lead_id) { 

    $this->db->set($data); 

    $this->db->where("lead_id", $lead_id); 

    $this->db->update("tblrecycle_history"); 

 } 
 public function update_recycle_status($data, $recycle_id) { 

  $this->db->set($data); 

  $this->db->where("recycle_id", $recycle_id); 

  $this->db->update("tblrecycle_history"); 

} 
 public function select_recycle_agent_task_lead($lead_id) {
  $this->db->select('user.*, leadgen.*, agents.*, lead.*, recycle.*, remarks.remark_tasks');
   $this->db->from('tblrecycle_history as recycle');
   $this->db->join('tblassign_agent as agents', 'recycle.agent_task_id = agents.agent_task_id', 'inner');
   $this->db->join('tblleads as lead', 'recycle.lead_id = lead.lead_id ', 'inner');
   $this->db->join('tblassign_leadgent as leadgen', 'recycle.lead_id = leadgen.lead_id', 'inner');
   $this->db->join('tbluser as user', 'leadgen.leadgent_user_id = user.user_id', 'inner');
   $this->db->join('(SELECT *  FROM tblremarks WHERE (lead_id, date_remark) IN (SELECT lead_id, MAX(date_remark) FROM tblremarks GROUP BY lead_id)) remarks', 'recycle.lead_id = remarks.lead_id', 'left');
  //  $this->db->join('tbltransaction_history as transactions', 'recycle.lead_id = transactions.lead_id', 'left');
   $this->db->where(array('lead.lead_id ' => $lead_id));

   $this->db->order_by('lead.lead_id', 'DESC');

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
public function select_view_agent_recycled_task($lead_id) {

  // Select relevant fields
  $this->db->select('
      user.*, 
      leadgen.*, 
      agents.*, 
      lead.*, 
      recycle.*, 
      remarks.remark_tasks, 
      transactions.agent_priority,  
      transactions.services_status, 
      transactions.agent_remarks, 
      transactions.payment_status
  ');

  // Set the main table for the query
  $this->db->from('tblrecycle_history as recycle');
  $this->db->join('tblassign_agent as agents', 'recycle.agent_task_id = agents.agent_task_id', 'inner');
  $this->db->join('tblleads as lead', 'recycle.lead_id = lead.lead_id', 'inner');
  $this->db->join('tblassign_leadgent as leadgen', 'agents.leadgent_task_id = leadgen.leadgent_task_id', 'inner');
  $this->db->join('tbluser as user', 'leadgen.leadgent_user_id = user.user_id', 'inner');

  // Subquery to get the latest remark for each lead
  $this->db->join('(SELECT * FROM tblremarks WHERE (lead_id, date_remark) IN 
                    (SELECT lead_id, MAX(date_remark) FROM tblremarks GROUP BY lead_id)) remarks',
      'agents.lead_id = remarks.lead_id', 'left');
  // $this->db->join('(
  //     SELECT lead_id, remark_tasks, MAX(date_remark) AS latest_remark
  //     FROM tblremarks 
  //     GROUP BY lead_id
  // ) as remarks', 'recycle.lead_id = remarks.lead_id', 'left');

  // Subquery to get the most recent transaction details related to the recycled lead
  $this->db->join('(
      SELECT 
          lead_id, 
          MAX(pitched_price) as agent_pitched_price,  
          SUM(amount) as total_payment,
          MAX(agent_priority) as agent_priority,
          MAX(services_status) as services_status,
          MAX(agent_remarks) as agent_remarks,
          MAX(payment_status) as payment_status
      FROM tbltransaction_history
      GROUP BY lead_id
  ) as transactions', 'recycle.lead_id = transactions.lead_id', 'left');

  // Where clause to filter by the lead ID
  $this->db->where(array('recycle.lead_id' => $lead_id));

  // Order by the recycle date to ensure the most recent recycled lead is shown first
  $this->db->order_by('recycle.date_recycle', 'DESC');

  // Execute the query
  $query = $this->db->get();

  // Check if query returned results
  if ($query->num_rows() > 0) {
      return $query->result_array(); // Return the result as an array
  } else {
      return false; // Return false if no data was found
  }

  // Close the database connection (though this is not necessary as CodeIgniter handles it)
  $this->db->close();
}

public function update_last_row_recycle($data, $lead_id = 0) {
  // Fetch the last row with the specified ID
  $this->db->where('lead_id', $lead_id);
  $this->db->order_by('date_recycle', 'DESC'); // Assuming 'created_at' is the timestamp column
  $this->db->limit(1);
  $query = $this->db->get('tblrecycle_history');

  // Check if a row was found
  if ($query->num_rows() > 0) {
      $last_row = $query->row();
      
      // Now update the last row
      $this->db->where('lead_id', $last_row->lead_id);
      $this->db->update('tblrecycle_history', $data);
      
      return $this->db->affected_rows(); // Returns the number of affected rows
  } else {
      return false; // No row found
  }
}


public function update_return_lead_control($data, $lead_id) { 
  if (is_array($lead_id)) {

      $this->db->set($data); 

      $this->db->where_in("lead_id", $lead_id); 

      $this->db->update("tblleads"); 
  }
  return false;

} 

public function insert_return_to_lead_control_data($data) {
  return $this->db->insert('tblreturn_to_lead_control', $data);
}

public function view_return_to_lead_control_data($user_id = 0)
{
    $user_id = (int) $user_id;
    $this->db->select('tblreturn_to_lead_control.*,  tblleads.*, tbluser.*, COUNT(tblreturn_to_lead_control.agent_id) as tasks_total');
    $this->db->from('tblreturn_to_lead_control');
    $this->db->join('tblleads', 'tblreturn_to_lead_control.lead_id = tblleads.lead_id', 'left');
    $this->db->join('tbluser', 'tblreturn_to_lead_control.agent_id = tbluser.user_id', 'inner');
    $this->db->where('tblleads.return_to_lead_control', 1);
    $this->db->where('tblreturn_to_lead_control.return_status', 'Park');


    // $this->db->join('tblleads', 'tblleads.lead_id = tblleads.lead_id', 'inner');
    


    // Grouping by user_id and date_assigned without time
    $this->db->group_by(['tblreturn_to_lead_control.agent_id', 'DATE(tblreturn_to_lead_control.date_return_to_lead_control)']);
    $this->db->order_by('tasks_total', 'DESC');

    $query = $this->db->get();

    // Check if there are results and return them
    return ($query->num_rows() > 0) ? $query->result_array() : false;
    $this->db->close();

}

public function select_recycled_leads_data($user_id, $date_assigned, $search) {
  $this->db->select('tblreturn_to_lead_control.*,  tblleads.*, tbluser.*');
  $this->db->from('tblreturn_to_lead_control');
  $this->db->join('tblleads', 'tblreturn_to_lead_control.lead_id = tblleads.lead_id', 'left');
  $this->db->join('tbluser', 'tblreturn_to_lead_control.agent_id = tbluser.user_id', 'inner');
  $this->db->where('tblleads.return_to_lead_control', 1);
  $this->db->where('tblreturn_to_lead_control.return_status', 'Park');
  // Grouping by user_id and date_assigned without time

  $this->db->where(array('tblreturn_to_lead_control.agent_id ' => $user_id));
  $this->db->where("tblleads.return_to_lead_control", 1); 
  // $this->db->where("tblassign_agent.lead_assign !=", 2); 
  $this->db->where('DATE(tblreturn_to_lead_control.date_return_to_lead_control)', $date_assigned);
 
  if (!empty($search)) {
       $this->db->group_start(); // Start grouping for search conditions
       $this->db->like('lead.title', $search);
       $this->db->or_like('tblleads.customer_name', $search);
       $this->db->or_like('tblleads.customer_contact', $search);
        $this->db->or_like('tblleads.customer_email', $search);
       $this->db->group_end(); // End grouping for search conditions
   
     }
   $query = $this->db->get();
   if ($query->num_rows() > 0) {
      return $query->result_array(); // Return results as an array
  } else {
      return false; // Return false if no results found
  }
  $this->db->close();

}


public function select_recycled_leads_task($agent_task_id) {
  // Start building the query
  $this->db->select('tblreturn_to_lead_control.*, tbluser.*')
           ->from('tblreturn_to_lead_control')
           ->join('tbluser', 'tblreturn_to_lead_control.agent_id = tbluser.user_id', 'inner')
           ->where(array('tblreturn_to_lead_control.return_to_lead_control_id' => $agent_task_id));

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



public function update_return_lead_backet_data_status($data, $return_to_lead_control_id) { 
  if (is_array($return_to_lead_control_id)) {

      $this->db->set($data); 

      $this->db->where_in("return_to_lead_control_id", $return_to_lead_control_id); 

      $this->db->update("tblreturn_to_lead_control"); 
  }
  return false;

} 
 
}
