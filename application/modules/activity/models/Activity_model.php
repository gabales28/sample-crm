<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Activity_Model extends CI_Model {

   function __construct() {

      parent::__construct();

   }
   
  
   public function tableactivities(){

      $this->db->select('act.*, lead.*')->from('tblactivity as act')->join('tblleads as lead', 'act.lead_id = lead.lead_id', 'inner');

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

     if ($this->db->insert("tblactivity", $data)) {

       return true;

    }
   
   }

   public function select_lead_activity($lead_id) {

      $this->db->select('act.*, lead.*')->from('tblactivity as act')->join('tblleads as lead', 'act.lead_id = lead.lead_id', 'inner')
      ->where(array('act.lead_id ' => $lead_id));
  
     
      $query=$this->db->get();
  
      if ($query->num_rows() > 0){
  
        return $query->result_array();
  
      }
  
      else{
  
          return false;
  
      }
  
      $this->db->close();
    }

    public function select_notes($lead_id) {

      $this->db->select('note.*, lead.*')->from('tblremarks as note')->join('tblleads as lead', 'note.lead_id = lead.lead_id', 'inner')
      ->where(array('note.lead_id ' => $lead_id));
  
     
      $query=$this->db->get();
  
      if ($query->num_rows() > 0){
  
        return $query->result_array();
  
      }
  
      else{
  
          return false;
  
      }
  
      $this->db->close();
    }
    public function select_leadgent_lead($lead_id) {

      $this->db->select('*')->from('tblassign_leadgent')->where(array('lead_id ' => $lead_id));
     
      $query=$this->db->get();
  
      if ($query->num_rows() == 1){
        return $query->row_array();

      }
      else{
  
          return false;
  
      }
      $this->db->close();
    }

    public function select_agent_lead($lead_id) {

      $this->db->select('*')->from('tblassign_agent')->where(array('lead_id ' => $lead_id));
     
      $query=$this->db->get();
  
      if ($query->num_rows() == 1){
        return $query->row_array();

      }
      else{
  
          return false;
  
      }
      $this->db->close();
    }
    public function get_all_notifications($user_id) {
      if($this->session->userdata['userlogin']['usertype'] == 'Admin'){   
        $this->db->where('admin_id', $user_id);
      }
     elseif($this->session->userdata['userlogin']['usertype'] == 'Lead Gen.'){   
       $this->db->where('leadgent_user_id', $user_id);
    }
     elseif($this->session->userdata['userlogin']['usertype'] == 'Sales Trainee' || $this->session->userdata['userlogin']['usertype'] == 'Sales Prospecting' 
     || $this->session->userdata['userlogin']['usertype'] == 'Sales Tier 1' || $this->session->userdata['userlogin']['usertype'] == 'Sales Tier 2'){   
        $this->db->where('user_id', $user_id);
    }
    
      $this->db->order_by('activity_id', 'DESC');
      return $this->db->get('tblactivity')->result_array();
  }

  public function get_notifications_of_payment($user_id) {
    // Select activity data and associated assigned amount
    $this->db->select('tblactivity.*, tblassign_agent.amount');
    $this->db->from('tblactivity');

    // Join with tblassign_agent on lead_id
    $this->db->join('tblassign_agent', 'tblassign_agent.lead_id = tblactivity.lead_id', 'left');

    // Apply condition for Admin user
    $user_data = $this->session->userdata('userlogin');
    if ($user_data['usertype'] == 'Admin') {
        $this->db->where('tblactivity.admin_id', $user_id);
        $this->db->where('tblactivity.requested_date_paid', 1);
    }

    // Order by latest activity and limit to 20 records
    $this->db->order_by('tblactivity.activity_id', 'DESC');
    // $this->db->limit(20);
    return $this->db->get()->result_array();
}

    public function get_notifications($user_id) {
      if($this->session->userdata['userlogin']['usertype'] == 'Admin'){   
        $this->db->where('admin_id', $user_id);
        $this->db->where_not_in('remarks', ['Updated Payment Date', 'Added Payment', 'Updated Payment']);
      }
     elseif($this->session->userdata['userlogin']['usertype'] == 'Lead Gen.'){   
       $this->db->where('leadgent_user_id', $user_id);
    }
     elseif($this->session->userdata['userlogin']['usertype'] == 'Sales Trainee' || $this->session->userdata['userlogin']['usertype'] == 'Sales Prospecting' 
     || $this->session->userdata['userlogin']['usertype'] == 'Sales Tier 1' || $this->session->userdata['userlogin']['usertype'] == 'Sales Tier 2'){   
        $this->db->where('user_id', $user_id);
    }
    
      $this->db->order_by('activity_id', 'DESC');
      // $this->db->limit(10);
      return $this->db->get('tblactivity')->result_array();
  }

     public function count_unread_notifications_of_payment($user_id) {
    if($this->session->userdata['userlogin']['usertype'] == 'Admin'){   
       $this->db->where('admin_id', $user_id);
       $this->db->where('requested_date_paid', 1); 
       $this->db->where('unread_admin', 1);
    }
   return $this->db->count_all_results('tblactivity');
  }

   public function count_unread_notifications($user_id) {
    if($this->session->userdata['userlogin']['usertype'] == 'Admin'){   
       $this->db->where('admin_id', $user_id); 
       $this->db->where('unread_admin', 1);
       $this->db->where('requested_date_paid !=', 1); 
    }
    elseif($this->session->userdata['userlogin']['usertype'] == 'Lead Gen.'){   
      $this->db->where('leadgent_user_id', $user_id);
      $this->db->where('unread_leadgent', 1);
   }
   elseif($this->session->userdata['userlogin']['usertype'] == 'Sales Trainee' || $this->session->userdata['userlogin']['usertype'] == 'Sales Prospecting' 
   || $this->session->userdata['userlogin']['usertype'] == 'Sales Tier 1' || $this->session->userdata['userlogin']['usertype'] == 'Sales Tier 2'){   
       $this->db->where('user_id', $user_id);
       $this->db->where('unread_agent', 1);
   }
   return $this->db->count_all_results('tblactivity');
  }  

  public function mark_as_read($user_id) {

    if($this->session->userdata['userlogin']['usertype'] == 'Admin'){  
      $this->db->where('admin_id', $user_id); 
      $this->db->update('tblactivity', ['unread_admin' => 0]);
   }
   elseif($this->session->userdata['userlogin']['usertype'] == 'Lead Gen.'){   
    $this->db->where('leadgent_user_id', $user_id);
     $this->db->update('tblactivity', ['unread_leadgent' => 0]);
  }
  elseif($this->session->userdata['userlogin']['usertype'] == 'Sales Trainee' || $this->session->userdata['userlogin']['usertype'] == 'Sales Prospecting' 
  || $this->session->userdata['userlogin']['usertype'] == 'Sales Tier 1' || $this->session->userdata['userlogin']['usertype'] == 'Sales Tier 2'){   
      $this->db->where('user_id', $user_id);
      $this->db->update('tblactivity', ['unread_agent' => 0]);

  }
    
}

 }

?>

