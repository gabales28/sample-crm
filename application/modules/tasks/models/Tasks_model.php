<?php if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Tasks_Model extends CI_Model
{

  function __construct()
  {

    parent::__construct();
    $this->load->database();

  }

  // start save multipletaskform
  public function save_tasks($data)
  {
    return $this->db->insert_batch('tblassign_leadgent', $data);
  }
  public function insert_remark($data){
    return $this->db->insert('tblremarks', $data);
  }

  public function get_leads()
  {
    return $this->db->get('tblleads')->result_array();
  }
  // end save multipletaskform
  public function tabletasks()
  {
    // $this->db->select(' tbluser.*, tblleads.*, tblassign_leadgent.*, tblassign_agent.*,');
    // $this->db->from('tblassign_agent');
    // $this->db->join('tbluser', 'tblassign_agent.user_id = tbluser.user_id', 'left');
    // $this->db->join('tblleads', 'tblassign_agent.lead_id = tblleads.lead_id', 'left');
    // $this->db->join('tblassign_leadgent', 'tblassign_agent.leadgent_user_id = tblassign_leadgent.leadgent_task_id', 'left');


    $this->db->select('user.*, leadgent.*, agent.*, lead.*, 
                       IF(agent.user_id IS NULL, "", agentuser.fname) AS agent_fname, 
                       IF(agent.user_id IS NULL, "", agentuser.lname) AS agent_lname');
    $this->db->from('tblleads as lead');
    $this->db->join('tblassign_leadgent as leadgent', 'lead.lead_id = leadgent.lead_id', 'join');
    $this->db->join('tbluser as user', 'leadgent.leadgent_user_id = user.user_id', 'join');
    $this->db->join('tblassign_agent as agent', 'lead.lead_id = agent.lead_id', 'LEFT');
    $this->db->join('tbluser as agentuser', 'agent.user_id = agentuser.user_id', 'left');


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


  public function select_tasks($agent_task_id)
  {

    $this->db->select('*')->from('tblassign_agent')->where(array('agent_task_id ' => $agent_task_id));


    $query = $this->db->get();

    if ($query->num_rows() > 0) {

      return $query->result_array();

    } else {

      return false;

    }

    $this->$db->close();
  }


  public function select_task($user_id, $date_assigned)
  {

    $this->db->select('leads.*, leadgents.*, users.*')->from('tblassign_agent as agents');
    $this->db->join('tblleads as leads', 'agents.lead_id = leads.lead_id', 'left');
    $this->db->join('tblassign_leadgent as leadgents', 'agents.leadgent_task_id = leadgents.leadgent_task_id', 'left');
    $this->db->join('tbluser as users', 'agents.user_id = users.user_id', 'left');

    $this->db->where(array('agents.user_id ' => $user_id));
    $this->db->where('DATE(agents.date_assigned)', $date_assigned);

    $query = $this->db->get();

    if ($query->num_rows() > 0) {

      return $query->result_array();

    } else {

      return false;

    }

    $this->db->close();
  }

  

  public function get_data_lead($limit, $start, $search = null, $lead_id = 0,  $lead_status = null)
  {
    $this->db->select('user.*, leadgent.*, agent.*, lead.*, remarks.remark_tasks,
    IF(agent.user_id IS NULL, "", agentuser.fname) AS agent_fname, 
    IF(agent.user_id IS NULL, "", agentuser.lname) AS agent_lname');
    $this->db->from('tblleads as lead');
    $this->db->join('tblassign_leadgent as leadgent', 'lead.lead_id = leadgent.lead_id', 'join');
    $this->db->join('tbluser as user', 'leadgent.leadgent_user_id = user.user_id', 'join');
    $this->db->join('tblassign_agent as agent', 'lead.lead_id = agent.lead_id AND agent.lead_assign != 2 AND agent.agent_trash_lead != 2', 'LEFT');
    $this->db->join('tbluser as agentuser', 'agent.user_id = agentuser.user_id', 'left');
    $this->db->join('(SELECT *  FROM tblremarks WHERE (lead_id, date_remark) IN (SELECT lead_id, MAX(date_remark) FROM tblremarks GROUP BY lead_id)) remarks', 'leadgent.lead_id = remarks.lead_id', 'left');
    // $this->db->group_by('lead.lead_id'); // Ensure only one record per lead_id
    $this->db->where('lead.lead_status_assign_leadgent ', 1);
    $this->db->where('lead.trash !=', 1);
    $this->db->where('leadgent.lead_status_leadgent !=', 2);
    // $this->db->where('agent.lead_assign !=', 2);
    // $this->db->where('agent.lead_assign ',  2);
    // $this->db->where('leadgent.lead_status_leadgent !=', 2);
    // $this->db->group_by('lead.lead_id'); // Ensure only one record per lead_id
    $this->db->order_by('leadgent.date_assigned', 'DESC');




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

    } else if (!empty($search) && !empty($lead_status)) {
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

  // public function count_all()
  // {
  //   $this->db->where('tblassign_leadgent.lead_status_leadgent !=', 2);
  //   return $this->db->count_all('tblassign_leadgent');
  // }

  public function count_all()
{
    // Join tblassign_leadgent with tblleads on the common field (e.g., lead_id)
    $this->db->join('tblleads', 'tblassign_leadgent.lead_id = tblleads.lead_id', 'inner'); 

    // Apply the condition to the query
    $this->db->where('tblassign_leadgent.lead_status_leadgent !=', 2);
    $this->db->where('tblleads.trash !=', 1);
    
    // Return the count of results from the joined tables
    return $this->db->count_all_results('tblassign_leadgent');
}

  public function count_filtered($search = null, $lead_id = 0, $lead_status = null)
  {
    $this->db->select('user.*, leadgent.*, agent.*, lead.*, remarks.remark_tasks,
    IF(agent.user_id IS NULL, "", agentuser.fname) AS agent_fname, 
    IF(agent.user_id IS NULL, "", agentuser.lname) AS agent_lname');
    $this->db->from('tblleads as lead');
    $this->db->join('tblassign_leadgent as leadgent', 'lead.lead_id = leadgent.lead_id', 'join');
    $this->db->join('tbluser as user', 'leadgent.leadgent_user_id = user.user_id', 'join');
    $this->db->join('tblassign_agent as agent', 'lead.lead_id = agent.lead_id AND agent.lead_assign != 2 AND agent.agent_trash_lead != 2', 'LEFT');
    $this->db->join('tbluser as agentuser', 'agent.user_id = agentuser.user_id', 'left');
    $this->db->join('(SELECT *  FROM tblremarks WHERE (lead_id, date_remark) IN (SELECT lead_id, MAX(date_remark) FROM tblremarks GROUP BY lead_id)) remarks', 'leadgent.lead_id = remarks.lead_id', 'left');
    // $this->db->order_by('lead.lead_id', 'DESC');
    $this->db->where('lead.lead_status_assign_leadgent ', 1);
    $this->db->where('lead.trash !=', 1);
    $this->db->where('leadgent.lead_status_leadgent ', 0);




    // $this->db->where('lead.lead_status_assign_leadgent ', 1);
    // $this->db->where('agent.lead_assign ',  2);
    // $this->db->where('leadgent.lead_status_leadgent !=', 2);
    


    // $this->db->where('leadgent.lead_status_leadgent !=', 2);
    // $this->db->where('lead.lead_status_assign_leadgent =', 1);
    // $this->db->where('agent.lead_assign ',  2);
    // $this->db->where(array('lead.lead_status_assign_leadgent ', 1));

    // $this->db->where("lead_status_assign", 1); 
    // $this->db->group_by('lead.lead_id'); 

    if (!empty($lead_status) && empty($search)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->like('lead.title', $search);
      $this->db->where('lead.lead_status', $lead_status);
      $this->db->group_end(); // End grouping for search condition

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
      $this->db->group_end(); // End grouping for search conditions

    } else if (!empty($search) && !empty($lead_status)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->like('lead.title', $search);
      $this->db->or_like('lead.customer_name', $search);
      $this->db->where('lead.lead_status', $lead_status);
      $this->db->group_end(); // End grouping for search conditions


    }
    return $this->db->count_all_results();
  }


  public function get_agenttask_data_lead($limit, $start, $search = null, $lead_id = 0, $lead_status = null, $leadgent_user_id=0)
  {
    $this->db->select('user.*, leadgent.*, agent.*, lead.*, remarks.remark_tasks,
    IF(agent.user_id IS NULL, "", agentuser.fname) AS agent_fname, 
    IF(agent.user_id IS NULL, "", agentuser.lname) AS agent_lname');
    $this->db->from('tblleads as lead');
    $this->db->join('tblassign_leadgent as leadgent', 'lead.lead_id = leadgent.lead_id', 'join');
    $this->db->join('tbluser as user', 'leadgent.leadgent_user_id = user.user_id', 'join');
    $this->db->join('tblassign_agent as agent', 'lead.lead_id = agent.lead_id', 'LEFT');
    $this->db->join('tbluser as agentuser', 'agent.user_id = agentuser.user_id', 'left');
    $this->db->join('(SELECT *  FROM tblremarks WHERE (lead_id, date_remark) IN (SELECT lead_id, MAX(date_remark) FROM tblremarks GROUP BY lead_id)) remarks', 'leadgent.lead_id = remarks.lead_id', 'left');
    $this->db->where('leadgent.leadgent_user_id', $leadgent_user_id);
    $this->db->order_by('lead.lead_id', 'DESC');


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

  public function count_all_agenttask($leadgent_user_id)
  {
    $this->db->where('leadgent_user_id', $leadgent_user_id);  
    return $this->db->count_all('tblassign_agent');
  }


  public function count_filtered_agent_task($search = null, $lead_id =0, $lead_status = null,  $leadgent_user_id=0)
  {
    $this->db->select('user.*, leadgent.*, agent.*, lead.*, remarks.remark_tasks,
    IF(agent.user_id IS NULL, "", agentuser.fname) AS agent_fname, 
    IF(agent.user_id IS NULL, "", agentuser.lname) AS agent_lname');
    $this->db->from('tblleads as lead');
    $this->db->join('tblassign_leadgent as leadgent', 'lead.lead_id = leadgent.lead_id', 'join');
    $this->db->join('tbluser as user', 'leadgent.leadgent_user_id = user.user_id', 'join');
    $this->db->join('tblassign_agent as agent', 'lead.lead_id = agent.lead_id', 'LEFT');
    $this->db->join('tbluser as agentuser', 'agent.user_id = agentuser.user_id', 'left');
    $this->db->join('(SELECT *  FROM tblremarks WHERE (lead_id, date_remark) IN (SELECT lead_id, MAX(date_remark) FROM tblremarks GROUP BY lead_id)) remarks', 'leadgent.lead_id = remarks.lead_id', 'left');
    $this->db->where('leadgent.leadgent_user_id', $leadgent_user_id);
    $this->db->order_by('lead.lead_id', 'DESC');

    

    if (!empty($lead_status) && empty($search)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->like('lead.title', $search);
      $this->db->where('lead.lead_status', $lead_status);
      $this->db->group_end(); // End grouping for search condition

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
      $this->db->group_end(); // End grouping for search conditions

    } else if (!empty($search) && !empty($lead_status)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->like('lead.title', $search);
      $this->db->or_like('lead.customer_name', $search);
      $this->db->where('lead.lead_status', $lead_status);
      $this->db->group_end(); // End grouping for search conditions


    }
    return $this->db->count_all_results();
  }


// LEADGENT TASK view
public function get_view_agenttask_data_lead($limit, $start, $search = null, $lead_id = 0, $lead_status = null, $agent_user_id=0)
{
  $this->db->select('user.*, leadgent.*, agent.*, lead.*, remarks.remark_tasks,
  IF(agent.user_id IS NULL, "", agentuser.fname) AS agent_fname, 
  IF(agent.user_id IS NULL, "", agentuser.lname) AS agent_lname');
  $this->db->from('tblleads as lead');
  $this->db->join('tblassign_leadgent as leadgent', 'lead.lead_id = leadgent.lead_id', 'join');
  $this->db->join('tbluser as user', 'leadgent.leadgent_user_id = user.user_id', 'join');
  $this->db->join('tblassign_agent as agent', 'lead.lead_id = agent.lead_id', 'Inner');
  $this->db->join('tbluser as agentuser', 'agent.user_id = agentuser.user_id', 'Inner');
  $this->db->join('(SELECT *  FROM tblremarks WHERE (lead_id, date_remark) IN (SELECT lead_id, MAX(date_remark) FROM tblremarks GROUP BY lead_id)) remarks', 'leadgent.lead_id = remarks.lead_id', 'left');
  $this->db->where('agent.lead_assign !=', 2);
  $this->db->where("agent.agent_trash_lead !=", 2); 
  $this->db->where('lead.trash !=', 1);
  $this->db->where("lead.lead_status_assign", 1); 
  $this->db->where('agent.user_id', $agent_user_id);
  $this->db->group_by('lead.lead_id');
  $this->db->order_by('lead.lead_id', 'DESC');


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

// public function count_all_view_agenttask($user_id)
// {
//   $this->db->where('user_id', $user_id);  
//   return $this->db->count_all('tblassign_agent');
// }
public function count_all_view_agenttask($user_id)
{
    // Start by selecting the necessary columns, and join the tblleads table
    $this->db->select('tblassign_agent.*, tblleads.trash');
    $this->db->from('tblassign_agent');
    $this->db->join('tblleads', 'tblassign_agent.lead_id = tblleads.lead_id', 'inner');  // Adjust the join condition as per your schema
    $this->db->where('tblassign_agent.user_id', $user_id);
    $this->db->where('tblleads.trash !=', 1);
    $this->db->where('tblassign_agent.lead_assign !=', 2);
    $this->db->where('tblassign_agent.agent_trash_lead !=', 2);
    $this->db->where("tblleads.lead_status_assign", 1); 

    // Count the number of results
    return $this->db->count_all_results();
}



public function count_filtered_view_agent_task($search = null, $lead_id =0, $lead_status = null,  $agent_user_id=0)
{
  $this->db->select('user.*, leadgent.*, agent.*, lead.*, remarks.remark_tasks,
  IF(agent.user_id IS NULL, "", agentuser.fname) AS agent_fname, 
  IF(agent.user_id IS NULL, "", agentuser.lname) AS agent_lname');
  $this->db->from('tblleads as lead');
  $this->db->join('tblassign_leadgent as leadgent', 'lead.lead_id = leadgent.lead_id', 'join');
  $this->db->join('tbluser as user', 'leadgent.leadgent_user_id = user.user_id', 'join');
  $this->db->join('tblassign_agent as agent', 'lead.lead_id = agent.lead_id', 'Inner');
  $this->db->join('tbluser as agentuser', 'agent.user_id = agentuser.user_id', 'Inner');
  $this->db->join('(SELECT *  FROM tblremarks WHERE (lead_id, date_remark) IN (SELECT lead_id, MAX(date_remark) FROM tblremarks GROUP BY lead_id)) remarks', 'leadgent.lead_id = remarks.lead_id', 'left');
  $this->db->where('agent.user_id', $agent_user_id);
  $this->db->where('agent.user_id', $agent_user_id);
  $this->db->where('agent.lead_assign !=', 2); 
  $this->db->where('lead.trash !=', 1);
  $this->db->where("lead.lead_status_assign", 1); 
  $this->db->where('leadgent.lead_status_leadgent  !=', 2);
  $this->db->order_by('lead.lead_id', 'DESC');

  

  if (!empty($lead_status) && empty($search)) {
    $this->db->group_start(); // Start grouping for search conditions
    $this->db->like('lead.title', $search);
    $this->db->where('lead.lead_status', $lead_status);
    $this->db->group_end(); // End grouping for search condition

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
    $this->db->group_end(); // End grouping for search conditions

  } else if (!empty($search) && !empty($lead_status)) {
    $this->db->group_start(); // Start grouping for search conditions
    $this->db->like('lead.title', $search);
    $this->db->or_like('lead.customer_name', $search);
    $this->db->where('lead.lead_status', $lead_status);
    $this->db->group_end(); // End grouping for search conditions


  }
  return $this->db->count_all_results();
}

// ====================================================
// recycle


}
?>