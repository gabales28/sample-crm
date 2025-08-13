<?php if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Salesleadgent_Model extends CI_Model
{

  function __construct()
  {

    parent::__construct();
    $this->load->database();

  }


// public function table_agent_leadgents() {
//   $this->db->select('tbluser.user_id, tbluser.fname, tbluser.lname,  tbluser.contact, tbluser.email_add, tbluser.address, tbluser.usertype, tbluser.status');
//   $this->db->from('tbluser');
//   $this->db->join('tblassign_agent_leadgent', 'tblassign_agent_leadgent.agent_leadgent_id  = tbluser.user_id', 'left');  // Left join
// }

// function get_datatables() {
//   $this->table_agent_leadgents();
//   if ($_POST['length'] != -1) {
//       $this->db->limit($_POST['length'], $_POST['start']);
//   }
//   $query = $this->db->get();
//   return $query->result();
// }

// function count_filtered() {
//   $this->table_agent_leadgents();
//   $query = $this->db->get();
//   return $query->num_rows();
// }
public function get_users_by_type() {
  $this->db->select('userType');
  $query = $this->db->get('tbluser');
  return $query->result();
}
function count_all() {
  $this->db->from('tbluser');  // Counting all rows in the base table
  return $this->db->count_all_results();
}
public function table_agent_leadgents()
{

    $this->db->select('leagent_agents.*, agent.*, leadgent.fname as leadgent_fname, leadgent.lname as leadgent_lname');
    $this->db->from('tblassign_agent_leadgent as leagent_agents');
    $this->db->join('tbluser as agent', 'leagent_agents.agent_user_id = agent.user_id', 'inner');
    $this->db->join('tbluser as leadgent', 'leagent_agents.leadgent_user_id = leadgent.user_id', 'inner');

    $query = $this->db->get();

    // Check if there are results and return them
    return ($query->num_rows() > 0) ? $query->result_array() : false;
}

// add multiple agent function

public function assign_agent_to_leadgent($data) {
  return $this->db->insert_batch('tblassign_agent_leadgent', $data);
}
public function get_user() {
  return $this->db->get('tbluser')->result_array();
}
public function insert_userlog($data) {

  if ($this->db->insert("tbluserlog", $data)) {

     return true;

  }

}

// GET
public function select_agentleadgent_user_id($agent_leadgent_id) {
  $this->db->select('*');
  $this->db->from('tblassign_agent_leadgent');
  $this->db->where('agent_leadgent_id', $agent_leadgent_id);

  $query = $this->db->get();

  if ($query->num_rows() > 0) {
      return $query->result_array();
  } else {
      return false;
  }
}
// UPDATE 
public function update_agentleadgent($data, $agent_leadgent_id) { 

  $this->db->set($data); 

  $this->db->where("agent_leadgent_id", $agent_leadgent_id); 

  $this->db->update("tblassign_agent_leadgent"); 

} 
}
