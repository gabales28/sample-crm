<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sold_author_model extends CI_Model {

   function __construct() {

      parent::__construct();

   }

   public function get_recycled_view_agenttask_data_lead($limit, $start, $search = null, $lead_id = 0, $lead_status = null)  {
    $this->db->select('user.*, leadgen.*, agents.*, lead.*, recycle.*, SUM(transactions.amount) as total_payment, remarks.remark_tasks');
     $this->db->from('tblrecycle_history as recycle');
     $this->db->join('tblassign_agent as agents', 'recycle.agent_task_id = agents.agent_task_id', 'inner');
     $this->db->join('tblleads as lead', 'recycle.lead_id = lead.lead_id ', 'inner');
     $this->db->join('tblassign_leadgent as leadgen', 'recycle.lead_id = leadgen.lead_id', 'inner');
     $this->db->join('tbluser as user', 'leadgen.leadgent_user_id = user.user_id', 'inner');
     $this->db->join('(SELECT *  FROM tblremarks WHERE (lead_id, date_remark) IN (SELECT lead_id, MAX(date_remark) FROM tblremarks GROUP BY lead_id)) remarks', 'recycle.lead_id = remarks.lead_id', 'left');
     $this->db->join('tbltransaction_history as transactions', 'recycle.lead_id = transactions.lead_id', 'left');
     $this->db->group_by('recycle.lead_id');
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
    
    $this->db->select('user.*, leadgen.*, agents.*, lead.*, recycle.*, SUM(transactions.amount) as total_payment, remarks.remark_tasks');
    $this->db->from('tblrecycle_history as recycle');
    $this->db->join('tblassign_agent as agents', 'recycle.agent_task_id = agents.agent_task_id', 'inner');
    $this->db->join('tblleads as lead', 'recycle.lead_id = lead.lead_id ', 'inner');
    $this->db->join('tblassign_leadgent as leadgen', 'recycle.lead_id = leadgen.lead_id', 'inner');
    $this->db->join('tbluser as user', 'leadgen.leadgent_user_id = user.user_id', 'inner');
    $this->db->join('(SELECT *  FROM tblremarks WHERE (lead_id, date_remark) IN (SELECT lead_id, MAX(date_remark) FROM tblremarks GROUP BY lead_id)) remarks', 'recycle.lead_id = remarks.lead_id', 'left');
    $this->db->join('tbltransaction_history as transactions', 'recycle.lead_id = transactions.lead_id', 'left');
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
   
     return $this->db->count_all_results();

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


public function get_lead_authors_agent($agent_user_id) {
  // Select required fields including lead_id for use in view
  $this->db->select('tblleads.lead_id, tblleads.customer_email, tblleads.customer_name, tblleads.customer_contact,
   latest_recycle.status');

  $this->db->where('sold_author_status', 1);
  $this->db->where('recycle_status  !=', 1);
 
  $this->db->where('tblassign_agent.user_id', $agent_user_id);

  $this->db->from('tblleads');

  // Join assign_agent to filter by agent
  $this->db->join('tblassign_agent', 'tblleads.lead_id = tblassign_agent.lead_id', 'left');
  $this->db->join(
    '(SELECT lead_id, status, MAX(date_recycle) as date_recycle
      FROM tblrecycle_history
      WHERE status = "Reassign"
      GROUP BY lead_id) as latest_recycle',
    'tblleads.lead_id = latest_recycle.lead_id',
    'left'
);
  // Filter where sold_author_status is 1 (assumed to be in tblleads or tblassign_agent, update if needed)
  $this->db->where('tblleads.sold_author_status', 1);

  // Match the agent user ID
  $this->db->where('tblassign_agent.user_id', $agent_user_id);

  // Execute and return result
  return $this->db->get()->result();
}

public function get_data_sold_leads($limit, $start, $search, $lead_id = 0, $user_id = "")
  {
    $this->db->select('tblassign_agent.*, tblleads.*');
    $this->db->from('tblleads');
    $this->db->join('tblassign_agent', 'tblleads.lead_id = tblassign_agent.lead_id', 'inner');
    // $this->db->join('tbluser as users', 'leadgents.leadgent_user_id  = users.user_id', 'inner'); 
    // $this->db->where_not_in('leads.lead_status', ['inactive Leads', 'Wrong Email and Phone']);
    $this->db->where('tblleads.lead_status !=', '1');
    $this->db->where('tblassign_agent.sold_author_update_by_admin ', '1');
    // $this->db->where('tblleads.trash !=', 1);
    // $this->db->where('tblleads.lead_status_assign', 0);
    // $this->db->where('sold_author_status', 1);

    if ($lead_id > 0) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->where('tblleads.lead_id', $lead_id);
      $this->db->group_end(); // End grouping for search conditionsddddd

    } else if (!empty($search)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->like('title', $search)
        ->or_like('customer_email', $search)
        ->or_like('customer_contact', $search)
        ->or_like('customer_name', $search);
      $this->db->group_end(); // End grouping for search conditions
    } else if (!empty($user_id) && empty($search)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->where('tblassign_agent.user_id', $user_id);
      $this->db->group_end(); // End grouping for search conditions


    } else if (!empty($search) && empty($user_id)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->like('title', $search);
      $this->db->or_like('customer_name', $search);
      $this->db->group_end(); // End grouping for search conditions

    } else if (!empty($search) && !empty($user_id)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->or_like('customer_email', $search);
      $this->db->or_like('customer_contact', $search);
      $this->db->or_like('customer_name', $search);
      $this->db->where('tblassign_agent.user_id', $user_id);
      $this->db->group_end(); // End grouping for search conditions
    }

    $this->db->limit($limit, $start);
    $query = $this->db->get();
    return $query->result();
  }


 public function count_filtered_sold_leads($search, $lead_id = 0, $user_id = "")
  {
      $this->db->select('tblassign_agent.*, tblleads.*');
    $this->db->from('tblleads');
    $this->db->join('tblassign_agent', 'tblleads.lead_id = tblassign_agent.lead_id', 'inner');
    // $this->db->join('tbluser as users', 'leadgents.leadgent_user_id  = users.user_id', 'inner'); 
    // $this->db->where_not_in('leads.lead_status', ['inactive Leads', 'Wrong Email and Phone']);
    $this->db->where('tblleads.lead_status !=', '1');
    $this->db->where('tblassign_agent.sold_author_update_by_admin ', '1');




    if ($lead_id > 0) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->where('tblleads.lead_id', $lead_id);
      $this->db->group_end(); // End grouping for search conditionsddddd

    } else if (!empty($search)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->like('title', $search)
        ->or_like('customer_email', $search)
        ->or_like('customer_contact', $search)
        ->or_like('customer_name', $search);
      $this->db->group_end(); // End grouping for search conditions
    } else if (!empty($user_id) && empty($search)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->where('tblassign_agent.user_id', $user_id);
      $this->db->group_end(); // End grouping for search conditions


    } else if (!empty($search) && empty($user_id)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->like('title', $search);
      $this->db->or_like('customer_name', $search);
      $this->db->group_end(); // End grouping for search conditions

    } else if (!empty($search) && !empty($user_id)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->or_like('customer_email', $search);
      $this->db->or_like('customer_contact', $search);
      $this->db->or_like('customer_name', $search);
      $this->db->where('tblassign_agent.user_id', $user_id);
      $this->db->group_end(); // End grouping for search conditions
    }

    return $this->db->count_all_results();
  }

  public function count_all_sold_leads()
  {
    $this->db->select('tblassign_agent.*, tblleads.*');
    $this->db->from('tblleads');
    $this->db->join('tblassign_agent', 'tblleads.lead_id = tblassign_agent.lead_id', 'inner');
    // $this->db->join('tbluser as users', 'leadgents.leadgent_user_id  = users.user_id', 'inner'); 
    // $this->db->where_not_in('leads.lead_status', ['inactive Leads', 'Wrong Email and Phone']);
    $this->db->where('tblleads.lead_status !=', '1');
    $this->db->where('tblassign_agent.sold_author_update_by_admin ', '1');

    return $this->db->count_all_results();
  }




public function get_data_sold_leads_dropdown($limit, $start, $search, $lead_id = 0, $user_id = 0)
{
    $this->db->select('tblassign_agent.*, tblleads.*');
    $this->db->from('tblassign_agent');
    $this->db->join('tblleads', 'tblassign_agent.lead_id = tblleads.lead_id', 'inner');

    $this->db->where('tblleads.lead_status !=', '1');
    $this->db->where('tblassign_agent.sold_author_update_by_admin', '1');

    if (!empty($user_id)) {
        $this->db->where('tblassign_agent.user_id', $user_id);
    }

    if (!empty($lead_id)) {
        $this->db->where('tblleads.lead_id', $lead_id);
    }

    if (!empty($search)) {
        $this->db->group_start();
        $this->db->like('title', $search);
        $this->db->or_like('customer_email', $search);
        $this->db->or_like('customer_contact', $search);
        $this->db->or_like('customer_name', $search);
        $this->db->group_end();
    }

    $this->db->limit($limit, $start);
    return $this->db->get()->result();
}



public function count_filtered_sold_leads_dropdown($search, $lead_id = 0, $user_id = 0)
{
    $this->db->select('tblassign_agent.*, tblleads.*');
    $this->db->from('tblassign_agent');
    $this->db->join('tblleads', 'tblassign_agent.lead_id = tblleads.lead_id', 'inner');

    $this->db->where('tblleads.lead_status !=', '1');
    $this->db->where('tblassign_agent.sold_author_update_by_admin', '1');

    if (!empty($user_id)) {
        $this->db->where('tblassign_agent.user_id', $user_id);
    }

    if (!empty($lead_id)) {
        $this->db->where('tblleads.lead_id', $lead_id);
    }

    if (!empty($search)) {
        $this->db->group_start();
        $this->db->like('title', $search);
        $this->db->or_like('customer_email', $search);
        $this->db->or_like('customer_contact', $search);
        $this->db->or_like('customer_name', $search);
        $this->db->group_end();
    }

    return $this->db->count_all_results();
}


 public function count_all_sold_leads_dropdown($user_id = 0)
{
    $this->db->select('tblassign_agent.*, tblleads.*');
    $this->db->from('tblassign_agent');
    $this->db->join('tblleads', 'tblassign_agent.lead_id = tblleads.lead_id', 'inner');

    $this->db->where('tblleads.lead_status !=', '1');
    $this->db->where('tblassign_agent.sold_author_update_by_admin', '1');

    if (!empty($user_id)) {
        $this->db->where('tblassign_agent.user_id', $user_id);
    }

    return $this->db->count_all_results();
}



}