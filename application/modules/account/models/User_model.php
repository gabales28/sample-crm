  <?php if (! defined('BASEPATH')) exit('No direct script access allowed');

  class User_Model extends CI_Model
  {

    function __construct()
    {

      parent::__construct();
    }

    public function login($emailaddress, $password)
    {


      $this->db->select('*')->from('tbluser')->where(array('email_add' => $emailaddress, 'password' => md5($password)));

      $query = $this->db->get();


      if ($query->num_rows() == 1) {

        return $query->result();
      } else {

        return false;
      }

      $this->db->close();
    }


    public function all_users()
    {

      $this->db->select('*')->from('tbluser');

      $query = $this->db->get();


      if ($query->num_rows() > 0) {

        return $query->result_array();
      } else {

        return false;
      }

      $this->db->close();
    }

// for user logs
    public function user_id(){
    $this->db->select('user.*, leadgent_agents.*, user.fname as fname, user.lname as lname');
    $this->db->from('tbluserlog as leadgent_agents');
    $this->db->join('tbluser as user', 'leadgent_agents.user_id = user.user_id', 'inner');
    $this->db->order_by('log_id', 'DESC');
    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        return $query->result_array();
    } else {
        return false;
    }
}


    public function is_email_exists($email)
    {
      $query = $this->db->get_where('tbluser', array('email_add' => $email));
      return $query->num_rows() > 0;
    }

    public function view_account_leadgent()
    {

      $this->db->select('*')->from('tbluser')->where(array('usertype ' => 'Lead Gen.', 'status' => 'Active'));

      $query = $this->db->get();

      if ($query->num_rows() > 0) {

        return $query->result_array();
      } else {

        return false;
      }

      $this->db->close();
    }

    public function view_single_user($user_id)
    {

      $this->db->select('*')->from('tbluser')->where(array('user_id ' => $user_id));

      $query = $this->db->get();

      if ($query->num_rows() > 0) {

        return $query->row_array();
      } else {

        return false;
      }

      $this->db->close();
    }


    // public function view_account_sales(){
    //   $this->db->select('*')->from('tbluser')->where(array('usertype ' => 'Sales', 'status' => 'Active'));

    //   $query = $this->db->get();

    //   if ($query->num_rows() > 0) {

    //     return $query->result_array();
    //   } else {

    //     return false;
    //    }
    // }
    public function view_account_sales() {
      $this->db->select('*')
               ->from('tbluser')
               ->where_in('usertype', ['Sales Trainee','Sales Prospecting','Sales Tier 1', 'Sales Tier 2' ])
               ->where('status', 'Active');
      
      $query = $this->db->get();
      
      if ($query->num_rows() > 0) {
          return $query->result_array();
      } else {
          return false;
      }
  }

//   public function view_account_sales_() {
//     $this->db->select('*')
//              ->from('tbluser')
//              ->where_in('usertype', ['Sales Trainee','Sales Prospecting','Sales Tier 1', 'Sales Tier 2', 'Lead Gen.' ])
//              ->where('status', 'Active');
    
//     $query = $this->db->get();
    
//     if ($query->num_rows() > 0) {
//         return $query->result_array();
//     } else {
//         return false;
//     }
// }


  public function view_account_sales_and_leadgen() {
    $this->db->select('*')
             ->from('tbluser')
             ->where_in('usertype', ['Sales Trainee','Sales Prospecting','Sales Tier 1', 'Sales Tier 2', 'Lead Gen.' ])
             ->where('status', 'Active');
    
    $query = $this->db->get();
    
    if ($query->num_rows() > 0) {
        return $query->result_array();
    } else {
        return false;
    }
}
  
  
    public function view_account_leadgent_sales_active($user_id){
      $this->db->select('*')->from('tbluser')->join('tblassign_agent_leadgent', 'tbluser.user_id = tblassign_agent_leadgent.agent_user_id', 'inner')
      ->where('tbluser.status','Active')->where('tblassign_agent_leadgent.leadgent_user_id', $user_id);

      $query = $this->db->get();
    
      if ($query->num_rows() > 0) {
    
        return $query->result_array();
      } else {
    
        return false;
       }
    }

    //   public function count_all_agents() {
    //     $this->db->where(array('usertype ' => 'Sales', 'status' => 'Active'));
    //     return $this->db->count_all_results('tbluser');
    //  }  
    public function count_all_agents() {
      $this->db->where_in('usertype', ['Sales Trainee', 'Sales Prospecting', 'Sales Tier 1','Sales Tier 2']);
      $this->db->where('status', 'Active');
      return $this->db->count_all_results('tbluser');
  }
      

    // public function view_account_leadgent_sales($leadgent_user_id){
    //   $this->db->select('users.*, leadgents.*');
    //   $this->db->from('tbluser as users');
    //   $this->db->join('tblassign_agent_leadgent as leadgents', 'users.user_id = leadgents.agent_user_id', 'inner');
    //   // $this->db->join('tbluser as users', 'leadgents.leadgent_user_id  = users.user_id', 'inner');
    //   $this->db->where('leadgents.leadgent_user_id =', $leadgent_user_id);
    //   $this->db->where(array('users.usertype ' => 'Sales', 'users.status' => 'Active'));

    //   $query = $this->db->get();

    //   if ($query->num_rows() > 0) {

    //     return $query->result_array();
    //   } else {

    //     return false;
    //   }

    //   $this->db->close();
    // }
    public function view_account_leadgent_sales($leadgent_user_id){
      $this->db->select('users.*, leadgents.*');
      $this->db->from('tbluser as users');
      $this->db->join('tblassign_agent_leadgent as leadgents', 'users.user_id = leadgents.agent_user_id', 'inner');
      $this->db->where('leadgents.leadgent_user_id', $leadgent_user_id);
      $this->db->where_in('users.usertype', ['Sales Trainee', 'Sales Prospecting', 'Sales Tier 1','Sales Tier 2']);
      $this->db->where('users.status', 'Active');
  
      $query = $this->db->get();
  
      if ($query->num_rows() > 0) {
          return $query->result_array();
      } else {
          return false;
      }
  
      $this->db->close();
  }



    public function insert($data)
    {

      if ($this->db->insert("tbluser", $data)) {

        return true;
      }
    }

    public function insert_userlog($data)
    {

      if ($this->db->insert("tbluserlog", $data)) {

        return true;
      }
    }
    public function update_user($data, $user_id)
    {

      $this->db->set($data);

      $this->db->where("user_id", $user_id);

      $this->db->update("tbluser");
    }
    public function delete($id)
    {

      $this->db->delete('tbluser', array('user_id' => $id));  // Produces: // DELETE FROM mytable  // WHERE id = $id
    }

    public function update_attempt($emailaddress)
    {

      $this->db->set('attempt', 'attempt-1', FALSE);

      $this->db->where("email_add", $emailaddress);

      $this->db->update("tbluser");
    }

    public function select_user_id($user_id)
    {

      $this->db->select('*')->from('tbluser')->where(array('user_id ' => $user_id));

      $query = $this->db->get();

      if ($query->num_rows() > 0) {

        return $query->result_array();
      } else {

        return false;
      }

      $this->db->close();
    }
    public function get_user_by_email($email)
    {
      return $this->db->get_where('tbluser', ['email_add' => $email])->row();
    }

    public function store_reset_token($user_id, $token)
    {
      $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
      $this->db->where('user_id', $user_id);
      $this->db->update('tbluser', ['password_reset_token' => $token, 'token_expiry' => $expiry]);
    }

    public function is_token_valid($token)
    {
      $this->db->where('password_reset_token', $token);
      $this->db->where('token_expiry >', date('Y-m-d H:i:s'));
      $query = $this->db->get('tbluser');
      return $query->num_rows() > 0;
    }

    public function update_password($token, $new_password)
    {
      $this->db->where('password_reset_token', $token);
      $this->db->where('token_expiry >', date('Y-m-d H:i:s'));
      $this->db->update('tbluser', ['password' => md5($new_password), 'password_reset_token' => null, 'token_expiry' => null]);
      return $this->db->affected_rows() > 0;
    }
     // Log the user in by setting online status to 1
     public function set_online_status($user_id, $status = 1)
     {
         $this->db->set('is_online', $status);
         $this->db->set('date_login', date('Y-m-d H:i:s'));
         $this->db->where('user_id', $user_id);
         $this->db->update('tbluser');
     }
     public function set_offline_status($user_id, $status = 0)
     {
         $this->db->set('is_online', $status);
         $this->db->where('user_id', $user_id);
         $this->db->update('tbluser');
     }
    
    
     public function get_all_users() {
      $this->db->select('*');
      $this->db->from('tbluser'); // Adjusted to use userOn as the main table
      $this->db->where('is_online', 1);

      $query = $this->db->get();
  
      if ($query->num_rows() > 0) {
          return $query->result_array();
      } else {
          return false;
      }
  }
//   public function get_all_users($is_online){
//     $this->db->select('*')->from('tbluser')->where(array('is_online' => $is_online));
//     $query = $this->db->get();

//     if ($query->num_rows() > 0) {
//         return $query->result_array();
//     } else {
//         return false;
//     }
// }


public function select_agents_for_their_sold_author() {
    $this->db->select('*')
             ->from('tbluser')
             ->where_in('usertype', ['Sales Trainee','Sales Prospecting','Sales Tier 1', 'Sales Tier 2' ])
             ->where('status', 'Active');
    
    $query = $this->db->get();
    
    if ($query->num_rows() > 0) {
        return $query->result_array();
    } else {
        return false;
    }
  }
 public function get_agents_by_email($email) {
    return $this->db->get_where('tbluser', ['email_add' => $email])->row();

}
  }

  
  ?>

