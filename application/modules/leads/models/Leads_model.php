<?php if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Leads_Model extends CI_Model
{

  function __construct()
  {

    parent::__construct();

  }
  public function get_lead_data()
  {
    $this->db->select('*');
    $this->db->from('tblleads');
    $this->db->where("tblleads.trash !=", 1);
    $query = $this->db->get();
    return $query->result();
  }

  public function get_lead_data_leadgent($leadgentuser_id)
  {
    $this->db->select('leads.*, leadgents.*, agents.agent_task_id,');
    $this->db->from('tblleads as leads');
    $this->db->join('tblassign_leadgent as leadgents', 'leads.lead_id = leadgents.lead_id AND leadgents.lead_status_leadgent !=2', 'left');
    $this->db->join('tblassign_agent as agents', 'leads.lead_id = agents.lead_id AND agents.agent_trash_lead !=2 AND agents.lead_assign !=2', 'left');
    $this->db->where('leads.lead_status_assign_leadgent ', 1);
    // $this->db->or_where('leads.recycle_status ',  1);
    $this->db->where('leads.trash !=', 1);
    $this->db->where('leadgents.leadgent_user_id =', $leadgentuser_id);

    // $this->db->order_by('agents.agent_date_assigned', 'DESC');
    $query = $this->db->get();
    return $query->result();
  }

  public function tableleads()
  {

    $this->db->select('*')->from('tblleads');


    $query = $this->db->get();


    if ($query->num_rows() > 0) {

      return $query->result_array();

    } else {

      return false;

    }

    $this->db->close();
  }
  //  get leads or filtered data
  public function get_data_lead($limit, $start, $search = null, $lead_status = null)
  {
    $this->db->select('tblleads.*, agents.agent_task_id');
    $this->db->from('tblleads');
    $this->db->join('tblassign_agent as agents', 'tblleads.lead_id = agents.lead_id AND agents.agent_trash_lead != 2 AND agents.lead_assign !=2', 'left');

    $this->db->order_by('lead_id', 'DESC');
    $this->db->where('return_to_lead_control !=', 1);
    $this->db->where('recycle_status !=', 1);
    $this->db->where('trash !=', 1);


    if (!empty($lead_status) && empty($search)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->like('title', $search);
      $this->db->where('lead_status', $lead_status);
      $this->db->group_end(); // End grouping for search conditions


    } else if (!empty($search) && empty($lead_status)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->like('title', $search);
      $this->db->or_like('customer_name', $search);
      $this->db->or_like('customer_contact', $search);
      $this->db->or_like('customer_email', $search);

      $this->db->group_end(); // End grouping for search conditions

    } else if (!empty($search) && !empty($lead_status)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->where('lead_status', $lead_status);
      $this->db->like('title', $search);
      $this->db->or_like('customer_name', $search);
      $this->db->or_like('customer_email', $search);
      $this->db->group_end(); // End grouping for search conditions
    }

    $this->db->limit($limit, $start);
    $query = $this->db->get();
    return $query->result();
  }
  //  get leads or filtered data
  public function get_recycle_data_lead($limit, $start, $search = null, $lead_status = null)
  {
    $this->db->select('*');
    $this->db->from('tblleads');
    $this->db->order_by('lead_id', 'DESC');

    if (!empty($lead_status) && empty($search)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->like('title', $search);
      $this->db->where('lead_status', $lead_status);
      $this->db->group_end(); // End grouping for search conditions


    } else if (!empty($search) && empty($lead_status)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->like('title', $search);
      $this->db->or_like('customer_name', $search);
      $this->db->group_end(); // End grouping for search conditions

    } else if (!empty($search) && !empty($lead_status)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->where('lead_status', $lead_status);
      $this->db->like('title', $search);
      $this->db->or_like('customer_name', $search);
      $this->db->group_end(); // End grouping for search conditions
    }

    $this->db->limit($limit, $start);
    $query = $this->db->get();
    return $query->result();
  }
  // public function count_all() {
  //     return $this->db->count_all('tblleads');
  // }
  public function count_all()
  {
    $this->db->where('trash !=', 1); // Apply condition on 'trash' column
    $this->db->where('return_to_lead_control !=', 1);
    $this->db->where('recycle_status !=', 1);
    return $this->db->count_all_results('tblleads'); // Correct method for counting rows
  }

  //for Assign mutiple task
  public function count_all_modal()
  {
    $this->db->where('lead_status_assign=', 0);
    return $this->db->count_all('tblleads');

  }

  // public function count_filtered($search) {
  //     $this->db->like('title', $search);
  //     // $this->db->or_like('customer_name', $search);
  //     $this->db->from('tblleads');
  //     return $this->db->count_all_results();
  // }
  public function count_filtered($search = null, $lead_status = null)
  {
    $this->db->select('tblleads.*, agents.agent_task_id');
    $this->db->from('tblleads');
    $this->db->join('tblassign_agent as agents', 'tblleads.lead_id = agents.lead_id AND agents.agent_trash_lead != 2 AND agents.lead_assign !=2', 'left');
    $this->db->where('return_to_lead_control !=', 1);
    $this->db->where('recycle_status !=', 1);
    $this->db->where('trash !=', 1);

    if (!empty($lead_status) && empty($search)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->like('title', $search);
      $this->db->where('lead_status', $lead_status);
      $this->db->group_end(); // End grouping for search condition

    } else if (!empty($search) && empty($lead_status)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->like('title', $search);
      $this->db->or_like('customer_name', $search);
      $this->db->group_end(); // End grouping for search conditions

    } else if (!empty($search) && !empty($lead_status)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->like('title', $search);
      $this->db->or_like('customer_name', $search);
      $this->db->where('lead_status', $lead_status);
      $this->db->group_end(); // End grouping for search conditions


    }
    return $this->db->count_all_results();
  }


  //  get leads or filtered data
  public function get_data_leadgen($limit, $start, $search = null, $lead_status = "")
  {
    $this->db->select('leads.*, leadgents.*');
    $this->db->from('tblleads as leads');
    $this->db->join('tblassign_leadgent as leadgents', 'leads.lead_id = leadgents.lead_id', 'inner');
    $this->db->order_by('leads.lead_id', 'DESC');


    if (!empty($lead_status) && empty($search)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->like('leads.title', $search);
      $this->db->where('leads.lead_status', $lead_status);
      $this->db->group_end(); // End grouping for search conditions


    } else if (!empty($lead_status) && !empty($search)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->where('leads.lead_status', $lead_status);
      $this->db->like('leads.title', $search);
      $this->db->or_like('leads.customer_name', $search);
      $this->db->group_end(); // End grouping for search conditions
    } else if (!empty($search) && empty($lead_status)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->like('leads.title', $search);
      $this->db->or_like('leads.customer_name', $search);
      $this->db->group_end(); // End grouping for search conditions

    }


    $this->db->limit($limit, $start);
    $query = $this->db->get();
    return $query->result();
  }

  public function count_all_leadgen()
  {
    return $this->db->count_all('tblleads');
  }

  public function count_filtered_leadgen($search = null, $lead_status = null)
  {
    $this->db->select('leads.*, leadgents.*');
    $this->db->from('tblleads as leads');
    $this->db->join('tblassign_leadgent as leadgents', 'leads.lead_id = leadgents.lead_id', 'inner');

    if (!empty($lead_status) && empty($search)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->like('title', $search);
      $this->db->where('lead_status', $lead_status);
      $this->db->group_end(); // End grouping for search condition

    } else if (!empty($search) && empty($lead_status)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->like('title', $search);
      $this->db->or_like('customer_name', $search);
      $this->db->group_end(); // End grouping for search conditions

    } else if (!empty($search) && !empty($lead_status)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->like('title', $search);
      $this->db->or_like('customer_name', $search);
      $this->db->where('lead_status', $lead_status);
      $this->db->group_end(); // End grouping for search conditions


    }
    return $this->db->count_all_results();
  }

  //agent filtering

  //  get leads or filtered data
  public function get_data_agent_lead($limit, $start, $search = null, $lead_status = null, $agent_user_id  )
  {
    $this->db->select('leads.*, agents.*, agents.payment_status,
      agents.agent_priority,
      agents.services_status as agent_services_status,
      SUM(transactions.pitched_price) as p_price,
      COALESCE(SUM(transactions.total_payment), 0) as total_payment,
      COALESCE(SUM(transactions.balance), 0) as balance,
      transactions.transaction_id,
      remarks.remark_tasks,
      transactions.services_status,
      transactions.agent_remarks');
    $this->db->from('tblleads as leads');
    $this->db->join('tblassign_agent as agents', 'leads.lead_id = agents.lead_id AND agents.lead_assign !=2  AND agents.agent_trash_lead !=2', 'inner');
    $this->db->join('(SELECT * FROM tblremarks WHERE (lead_id, date_remark) IN (SELECT lead_id, MAX(date_remark) FROM tblremarks GROUP BY lead_id)) remarks', 'agents.lead_id = remarks.lead_id', 'left');
    $this->db->join('tbltransaction_history as transactions', 'agents.lead_id = transactions.lead_id', 'left');
    $this->db->where('leads.trash !=', 1);
    $this->db->where("leads.lead_status_assign", 1);
    $this->db->where('agents.user_id', $agent_user_id);
    $this->db->group_by('leads.lead_id');
    $this->db->order_by('transactions.date', 'DESC');
    if (!empty($lead_status) && empty($search)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->like('leads.title', $search);
      $this->db->where('agents.agent_priority', $lead_status);
      $this->db->group_end(); // End grouping for search conditions


    } else if (!empty($search) && empty($lead_status)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->like('leads.title', $search);
      $this->db->or_like('leads.customer_name', $search);
      $this->db->or_like('agents.agent_priority', $lead_status);
      $this->db->group_end(); // End grouping for search conditions

    } else if (!empty($search) && !empty($lead_status)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->like('leads.title', $search);
      $this->db->or_like('leads.customer_name', $search);
      $this->db->or_like('agents.agent_priority', $lead_status);
      $this->db->where('leads.lead_status', $lead_status);
      $this->db->group_end(); // End grouping for search conditions
    }

    $this->db->limit($limit, $start);
    $query = $this->db->get();
    return $query->result();
  }

  public function count_all_agent_lead($agent_user_id)
  {
    $this->db->from('tblleads as leads');
    $this->db->join('tblassign_agent as agents', 'leads.lead_id = agents.lead_id AND agents.lead_assign !=2  AND agents.agent_trash_lead !=2', 'inner');
    $this->db->where('leads.trash !=', 1);
    $this->db->where("leads.lead_status_assign", 1);
    $this->db->where('agents.user_id', $agent_user_id);
    return $this->db->count_all_results();
  }

  public function count_filtered_agent_lead($search = null, $lead_status = null, $agent_user_id)
  {
    $this->db->select('leads.*, agents.*, remarks.remark_tasks');
    $this->db->from('tblleads as leads');
    $this->db->join('tblassign_agent as agents', 'leads.lead_id = agents.lead_id AND agents.lead_assign !=2  AND agents.agent_trash_lead !=2', 'inner');
    $this->db->join('(SELECT * FROM tblremarks WHERE (lead_id, date_remark) IN (SELECT lead_id, MAX(date_remark) FROM tblremarks GROUP BY lead_id)) remarks', 'agents.lead_id = remarks.lead_id', 'left');
    $this->db->where('leads.trash !=', 1);
    $this->db->where("leads.lead_status_assign", 1);
    $this->db->where('agents.user_id', $agent_user_id);
    if (!empty($lead_status) && empty($search)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->like('title', $search);
      $this->db->where('agents.agent_priority', $lead_status);
      $this->db->group_end(); // End grouping for search condition

    } else if (!empty($search) && empty($lead_status)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->like('leads.title', $search);
      $this->db->or_like('leads.customer_name', $search);
      $this->db->or_like('agents.agent_priority', $lead_status);
      $this->db->group_end(); // End grouping for search conditions

    } else if (!empty($search) && !empty($lead_status)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->like('leads.title', $search);
      $this->db->or_like('customer_name', $search);
      $this->db->or_like('agents.agent_priority', $lead_status);
      $this->db->where('leads.lead_status', $lead_status);
      $this->db->group_end(); // End grouping for search conditions


    }
    return $this->db->count_all_results();
  }


  //for Assign mutiple task
  public function get_data_lead_modal($limit, $start, $search)
  {
    $this->db->select('*');
    $this->db->from('tblleads');
    $this->db->where('lead_status_assign=', 0);



    if (!empty($search)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->like('title', $search);
      $this->db->or_like('customer_name', $search);
      $this->db->group_end(); // End grouping for search conditions


    }

    $this->db->limit($limit, $start);
    $query = $this->db->get();
    return $query->result();
  }

  //for Assign mutiple task
  public function count_filtered_modal($search)
  {
    $this->db->select('*')->from('tblleads');
    $this->db->where('lead_status_assign=', 0);


    if (!empty($search)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->like('title', $search);
      $this->db->or_like('customer_name', $search);
      $this->db->group_end(); // End grouping for search conditions

      // Add more columns as needed
    }

    return $this->db->count_all_results();
  }


  //for Assign mutiple task leadgent
  public function get_data_lead_leadgent_modal($limit, $start, $search)
  {
    $this->db->select('*');
    $this->db->from('tblleads');
    $this->db->where('lead_status_assign_leadgent=', 0);
    $this->db->where('recycle_status=', 0);
    $this->db->where('return_to_lead_control=', 0);
    $this->db->where("tblleads.trash !=", 1);
    if (!empty($search)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->like('title', $search);
      $this->db->or_like('customer_name', $search);
      $this->db->group_end(); // End grouping for search conditions


    }

    $this->db->limit($limit, $start);
    $query = $this->db->get();
    return $query->result();
  }

  //for Assign mutiple task
  public function count_filtered_leadgent_modal($search)
  {
    $this->db->select('*')->from('tblleads');
    $this->db->where('lead_status_assign_leadgent=', 0);
    $this->db->where('recycle_status=', 0);
    $this->db->where('return_to_lead_control=', 0);
    $this->db->where("tblleads.trash !=", 1);


    if (!empty($search)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->like('title', $search);
      $this->db->or_like('customer_name', $search);
      $this->db->group_end(); // End grouping for search conditions

      // Add more columns as needed
    }

    return $this->db->count_all_results();
  }

  public function count_all_leadgent_modal()
  {
    $this->db->where('lead_status_assign_leadgent=', 0);
    $this->db->where('recycle_status=', 0);
    $this->db->where('return_to_lead_control=', 0);
    $this->db->where("tblleads.trash !=", 1);
    return $this->db->count_all_results('tblleads');
  }



  //leadgent lead data
  public function get_data_leadagent($limit, $start, $search, $lead_id = 0, $lead_status = "", $leadgentuser_id)
  {
    $this->db->select('leads.*, leadgents.*, agents.agent_task_id,');
    $this->db->from('tblleads as leads');
    $this->db->join('tblassign_leadgent as leadgents', 'leads.lead_id = leadgents.lead_id AND leadgents.lead_status_leadgent !=2', 'left');
    $this->db->join('tblassign_agent as agents', 'leads.lead_id = agents.lead_id AND agents.agent_trash_lead !=2 AND agents.lead_assign !=2', 'left');
    $this->db->where('leads.lead_status_assign_leadgent ', 1);
    // $this->db->or_where('leads.recycle_status ',  1);
    $this->db->where('leads.trash !=', 1);
    // $this->db->order_by('agents.agent_date_assigned', 'DESC');
    $this->db->order_by('leads.lead_id', 'DESC');

    // $this->db->join('tbluser as users', 'leadgents.leadgent_user_id  = users.user_id', 'inner');
    $this->db->where('leadgents.leadgent_user_id =', $leadgentuser_id);

    if ($lead_id > 0) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->where('leads.lead_id', $lead_id);
      $this->db->group_end(); // End grouping for search conditionsddddd

    } else if (!empty($search)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->like('title', $search)
        ->or_like('customer_email', $search)
        ->or_like('customer_contact', $search)
        ->or_like('customer_name', $search);
      $this->db->group_end(); // End grouping for search conditions
    } else if (!empty($lead_status) && empty($search)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->where('lead_status', $lead_status);
      $this->db->group_end(); // End grouping for search conditions


    } else if (!empty($search) && empty($lead_status)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->like('title', $search);
      $this->db->or_like('customer_name', $search);
      $this->db->group_end(); // End grouping for search conditions

    } else if (!empty($search) && !empty($lead_status)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->or_like('customer_email', $search);
      $this->db->or_like('customer_contact', $search);
      $this->db->or_like('customer_name', $search);
      $this->db->where('lead_status', $lead_status);
      $this->db->group_end(); // End grouping for search conditions
    }

    $this->db->limit($limit, $start);
    $query = $this->db->get();
    return $query->result();
  }

  //for Assign mutiple task
  public function count_filtered_leadgent($search, $lead_id = 0, $lead_status = "", $leadgentuser_id = 0)
  {
    $this->db->select('leads.*, leadgents.*');
    $this->db->from('tblleads as leads');
    $this->db->join('tblassign_leadgent as leadgents', 'leads.lead_id = leadgents.lead_id', 'inner');
    $this->db->where('leads.lead_status_assign_leadgent !=', 0);
    $this->db->where('leads.trash !=', 1);


    // $this->db->join('tbluser as users', 'leadgents.leadgent_user_id  = users.user_id', 'inner');
    $this->db->where('leadgents.leadgent_user_id =', $leadgentuser_id);




    if ($lead_id > 0) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->where('leads.lead_id', $lead_id);
      $this->db->group_end(); // End grouping for search conditionsddddd

    } else if (!empty($search)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->like('title', $search)
        ->or_like('customer_email', $search)
        ->or_like('customer_contact', $search)
        ->or_like('customer_name', $search);
      $this->db->group_end(); // End grouping for search conditions
    } else if (!empty($lead_status) && empty($search)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->where('lead_status', $lead_status);
      $this->db->group_end(); // End grouping for search conditions


    } else if (!empty($search) && empty($lead_status)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->like('title', $search);
      $this->db->or_like('customer_name', $search);
      $this->db->group_end(); // End grouping for search conditions

    } else if (!empty($search) && !empty($lead_status)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->or_like('customer_email', $search);
      $this->db->or_like('customer_contact', $search);
      $this->db->or_like('customer_name', $search);
      $this->db->where('lead_status', $lead_status);
      $this->db->group_end(); // End grouping for search conditions
    }

    return $this->db->count_all_results();
  }

  // public function count_all_leadgent() {
//   return $this->db->where('lead_status_leadgent !=', 2)
//                   ->count_all_results('tblassign_leadgent');
// }
  public function count_all_leadgent( $leadgentuser_id = 0)
  {
    $this->db->where('tblleads.trash !=', 1);
    $this->db->where('lead_status_leadgent !=', 2);
    $this->db->where('tblassign_leadgent.leadgent_user_id =', $leadgentuser_id);

    // Add the join statement
    $this->db->join('tblleads', 'tblassign_leadgent.lead_id = tblleads.lead_id', 'inner'); // Adjust the join condition as per your schema

    return $this->db->count_all_results('tblassign_leadgent');
  }



  // start agent
// public function get_data_agent($limit, $start, $search, $lead_id = 0, $agentuser_id) {
//   $this->db->select('leads.*, agents.*,   transactions.agent_pitched_price,  transactions.total_payment, remarks.remark_tasks');
//   $this->db->from('tblleads as leads');
//   $this->db->join('tblassign_agent as agents', 'leads.lead_id = agents.lead_id', 'inner');
//   $this->db->join('(SELECT * FROM tblremarks WHERE (lead_id, date_remark) IN (SELECT lead_id, MAX(date_remark) FROM tblremarks GROUP BY lead_id)) remarks', 'agents.lead_id = remarks.lead_id', 'left');
//   $this->db->join('(SELECT pitched_price as  agent_pitched_price, SUM(amount) as total_payment, lead_id FROM tbltransaction_history WHERE (lead_id, date) IN (SELECT lead_id, date FROM tbltransaction_history)) transactions', 'agents.lead_id = transactions.lead_id', 'left');

  //   $this->db->where('agents.lead_assign !=', 2);
//   $this->db->where('agents.user_id =', $agentuser_id);
//   $this->db->group_by('agents.lead_id');
//     // $this->db->order_by('leadgent_agent_total', 'DESC');

  //    if ($lead_id > 0) {
//     $this->db->group_start(); // Start grouping for search conditions
//     $this->db->where('leads.lead_id', $lead_id);
//     $this->db->group_end(); // End grouping for search conditions

  //   } 


  //   if (!empty($search)) {
//     $this->db->group_start(); // Start grouping for search conditions
//     $this->db->like('title', $search)
//              ->or_like('customer_email', $search)
//              ->or_like('customer_contact', $search)
//              ->or_like('customer_name', $search);
//     $this->db->group_end(); // End grouping for search conditions

  //     // Add more columns as needed
// }

  //   $this->db->limit($limit, $start);
//   $query = $this->db->get();
//   return $query->result();
// }


  // public function get_data_agent($limit, $start, $search, $lead_id = 0, $agentuser_id) {
//   $this->db->select('leads.*, agents.*, transactions.agent_pitched_price, transactions.total_payment, remarks.remark_tasks');
//   $this->db->from('tblleads as leads');
//   $this->db->join('tblassign_agent as agents', 'leads.lead_id = agents.lead_id', 'inner');

  //   // Fix the transactions subquery to correctly group payments by lead_id
//   $this->db->join('(SELECT lead_id, pitched_price as agent_pitched_price,  SUM(amount) as total_payment FROM tbltransaction_history GROUP BY lead_id, pitched_price) transactions', 'agents.lead_id = transactions.lead_id', 'left');

  //   $this->db->join('(SELECT * FROM tblremarks WHERE (lead_id, date_remark) IN ( SELECT lead_id, MAX(date_remark) FROM tblremarks GROUP BY lead_id)) remarks', 'agents.lead_id = remarks.lead_id', 'left');

  //   $this->db->where('agents.lead_assign !=', 2);
//   $this->db->where('agents.user_id', $agentuser_id);
//   $this->db->group_by('agents.lead_id');

  //   if ($lead_id > 0) {
//       $this->db->where('leads.lead_id', $lead_id);
//   }

  //   if (!empty($search)) {
//       $this->db->group_start();
//       $this->db->like('title', $search)
//                ->or_like('customer_email', $search)
//                ->or_like('customer_contact', $search)
//                ->or_like('customer_name', $search);
//       $this->db->group_end();
//   }

  //   $this->db->limit($limit, $start);
//   $query = $this->db->get();
//   return $query->result();
// }
// ====================================

  public function get_data_agent($limit, $start, $search, $lead_id = 0,  $agentuser_id)
  {
    $this->db->select('
      leads.*, 
      agents.*, 
      agents.payment_status,
      agents.agent_priority,
      agents.services_status,
      SUM(transactions.pitched_price) as p_price,
      COALESCE(SUM(transactions.total_payment), 0) as total_payment,
      COALESCE(SUM(transactions.balance), 0) as balance,
      transactions.transaction_id,
      remarks.remark_tasks,
      agents.agent_remarks
  ');
    $this->db->from('tblleads as leads');
    $this->db->join('tblassign_agent as agents', 'leads.lead_id = agents.lead_id', 'inner');
    $this->db->join('tbltransaction_history as transactions', 'agents.lead_id = transactions.lead_id', 'left');
    $this->db->join('(SELECT * FROM tblremarks WHERE (lead_id, date_remark) IN 
                    (SELECT lead_id, MAX(date_remark) FROM tblremarks GROUP BY lead_id)) remarks',
      'agents.lead_id = remarks.lead_id',
      'left'
    );

    $this->db->where('agents.lead_assign !=', 2);
    $this->db->where('agents.agent_trash_lead !=', 2);
    $this->db->where('leads.trash !=', 1);
    $this->db->where("leads.lead_status_assign", 1);
    $this->db->group_by('leads.lead_id');
    $this->db->where('agents.user_id =', $agentuser_id);
    $this->db->order_by('transactions.date', 'DESC');


    if ($lead_id > 0) {
      $this->db->where('leads.lead_id', $lead_id);
    }

    if (!empty($search)) {
      $this->db->group_start();
      $this->db->like('title', $search)
        ->or_like('customer_email', $search)
        ->or_like('customer_contact', $search)
        ->or_like('customer_name', $search);
      $this->db->group_end();
    }

    $this->db->limit($limit, $start);

    // Debugging: Check the generated SQL query
    // echo $this->db->last_query(); exit;

    $query = $this->db->get();
    return $query->result();
  }


  //for Assign mutiple task
  public function count_filtered_agent($search, $lead_id = 0, $agentuser_id)
  {

    $this->db->select('leads.title, agents.agent_task_id,  transactions.lead_id,  SUM(transactions.amount) as total_payment');

    $this->db->from('tblleads as leads');
    $this->db->join('tblassign_agent as agents', 'leads.lead_id = agents.lead_id AND agents.lead_assign !=2 AND agents.agent_trash_lead !=2 ', 'inner');

    // Subquery for transactions
    $this->db->join('tbltransaction_history as transactions', 'agents.lead_id = transactions.lead_id', 'left');
    // $this->db->where('agents.lead_assign !=', 2);
    $this->db->where('leads.trash !=', 1);
    $this->db->where("leads.lead_status_assign", 1);
    $this->db->where('agents.user_id =', $agentuser_id);
    $this->db->group_by('leads.lead_id'); // Changed to avoid duplicate column name

    if ($lead_id > 0) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->where('leads.lead_id', $lead_id);
      $this->db->group_end(); // End grouping for search conditions

    }

    if (!empty($search)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->like('title', $search)
        ->or_like('customer_email', $search)
        ->or_like('customer_contact', $search)
        ->or_like('customer_name', $search);
      $this->db->group_end(); // End grouping for search conditions

      // Add more columns as needed
    }

    return $this->db->count_all_results();
  }

  public function count_all_agent($agentuser_id)
  {
    $this->db->select('leads.title, agents.agent_task_id,  transactions.lead_id,  SUM(transactions.amount) as total_payment');

    $this->db->from('tblleads as leads');
    $this->db->join('tblassign_agent as agents', 'leads.lead_id = agents.lead_id AND agents.lead_assign !=2 AND agents.agent_trash_lead !=2', 'inner');

    // Subquery for transactions
    $this->db->join('tbltransaction_history as transactions', 'agents.lead_id = transactions.lead_id', 'left');
    $this->db->where('leads.trash !=', 1);
    $this->db->where("leads.lead_status_assign", 1);
    $this->db->where('agents.user_id =', $agentuser_id);

    $this->db->group_by('leads.lead_id'); // Changed to avoid duplicate column name
    

    return $this->db->count_all_results();
  }
  // end agent





  //for Assign mutiple lead agennt
  public function get_data_lead_agent_modal($limit, $start, $search, $leadgentuser_id)
  {
    $this->db->select('leads.*, leadgents.*');
    $this->db->from('tblleads as leads');
    $this->db->join('tblassign_leadgent as leadgents', 'leads.lead_id = leadgents.lead_id', 'inner');
    // $this->db->join('tbluser as users', 'leadgents.leadgent_user_id  = users.user_id', 'inner'); try daw
    $this->db->where('leadgents.leadgent_user_id =', $leadgentuser_id);
    $this->db->where_not_in('leads.lead_status', ['inactive Leads', 'Wrong Email and Phone']);
    $this->db->where('leads.lead_status IS NOT NULL');
    $this->db->where('leads.lead_status !=', '');
    $this->db->where('leads.trash !=', 1);
    $this->db->where('leads.lead_status_assign', 0);
    $this->db->where('leadgents.lead_status_leadgent !=', 2);




    if (!empty($search)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->like('title', $search);
      $this->db->or_like('customer_name', $search);
      $this->db->group_end(); // End grouping for search conditions

    }

    $this->db->limit($limit, $start);
    $query = $this->db->get();
    return $query->result();
  }

  //for Assign mutiple task
  public function count_filtered_agent_modal($search, $leadgentuser_id)
  {
    $this->db->select('leads.*, leadgents.*');
    $this->db->from('tblleads as leads');
    $this->db->join('tblassign_leadgent as leadgents', 'leads.lead_id = leadgents.lead_id', 'inner');
    // $this->db->join('tbluser as users', 'leadgents.leadgent_user_id  = users.user_id', 'inner');
    $this->db->where('leadgents.leadgent_user_id =', $leadgentuser_id);
    $this->db->where_not_in('leads.lead_status', ['inactive Leads']);
    $this->db->where('leads.lead_status IS NOT NULL');
    $this->db->where('leads.lead_status !=', '');
    $this->db->where('leads.lead_status_assign', 0);
    $this->db->where('leadgents.lead_status_leadgent !=', 2);



    if (!empty($search)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->like('title', $search);
      $this->db->or_like('customer_name', $search);
      $this->db->group_end(); // End grouping for search conditions

      // Add more columns as needed
    }

    return $this->db->count_all_results();
  }

  public function count_all_agent_modal($leadgentuser_id)
  {
    $this->db->select('leads.*, leadgents.*');
    $this->db->from('tblleads as leads');
    $this->db->join('tblassign_leadgent as leadgents', 'leads.lead_id = leadgents.lead_id', 'inner');
    // $this->db->join('tbluser as users', 'leadgents.leadgent_user_id  = users.user_id', 'inner'); padayun
    $this->db->where('leadgents.leadgent_user_id =', $leadgentuser_id);
    $this->db->where_not_in('leads.lead_status', ['inactive Leads']);
    $this->db->where('leads.lead_status IS NOT NULL');
    $this->db->where('leads.lead_status !=', '');
    $this->db->where('leads.lead_status_assign', 0);
    $this->db->where('leads.trash !=', 1);
    $this->db->where('leadgents.lead_status_leadgent !=', 2);


    return $this->db->count_all_results();

  }


  public function fech_lead_category()
  {

    $this->db->select('lead_id, title as Lead Title, description as Description,  customer_name as Customer Name, lead_value as Lead Value')->from('tblleads');


    $query = $this->db->get();


    if ($query->num_rows() > 0) {

      return $query->result_array();

    } else {

      return false;

    }

    $this->db->close();
  }
  //    public function tableleads(){

  //     $this->db->select('leads.*, users.*')->from('tblleads as leads')->join('tbluser as users', 'leads.user_id = users.user_id', 'inner');


  //     $query=$this->db->get();


  //     if ($query->num_rows() > 0){

  //       return $query->result_array();

  //     }

  //     else{

  //         return false;

  //     }

  //     $this->db->close();

  //   }
  //  }
  public function insert($data)
  {

    if ($this->db->insert("tblleads", $data)) {

      return true;

    }

  }

  public function insert_userlog($data)
  {

    if ($this->db->insert("tbluserlog", $data)) {

      return true;

    }

  }
  public function Agents_update_lead_status($data, $lead_id)
  {

    $this->db->set($data);

    $this->db->where("lead_id", $lead_id);

    $this->db->update("tblleads");

  }
  public function update($data, $lead_id)
  {

    $this->db->set($data);

    $this->db->where("lead_id", $lead_id);

    $this->db->update("tblleads");

  }

  public function update_lead_status_assign($data, $lead_id)
  {
    if (is_array($lead_id)) {

      $this->db->set($data);

      $this->db->where_in("lead_id", $lead_id);

      $this->db->update("tblleads");
    }
    return false;

  }

  //  public function update_recycle_status($data, $lead_id) { 
//   if (is_array($lead_id)) {

  //       $this->db->set($data); 

  //       $this->db->where_in("lead_id", $lead_id); 

  //       $this->db->update("tblleads"); 
//   }
//   return false;

  // } 
  public function delete($lead_id)
  {

    $this->db->delete('tblleads', array('lead_id' => $lead_id));  // Produces: // DELETE FROM mytable  // WHERE id = $id
  }

  public function select_lead($lead_id)
  {

    $this->db->select('*')->from('tblleads')->where(array('lead_id ' => $lead_id));


    $query = $this->db->get();

    if ($query->num_rows() > 0) {

      return $query->result_array();

    } else {

      return false;

    }

    $this->db->close();
  }

  public function select_single_row_lead($lead_id)
  {

    $this->db->select('*')->from('tblleads')->where(array('lead_id ' => $lead_id));


    $query = $this->db->get();

    if ($query->num_rows() > 0) {

      return $query->row_array();

    } else {

      return false;

    }

    $this->db->close();
  }

  // public function get_authors_closed_leads($user_id,$month) {

  //   if($this->session->userdata['userlogin']['usertype'] == 'Admin'){   
  //       $this->db->where('sold_author_status', 1);

  //     return $this->db->count_all_results('tblleads');
  //   }

  //   elseif($this->session->userdata['userlogin']['usertype'] == 'Lead Gen.'){   
  //     // $this->db->where('leadgent_user_id', $user_id);
  //     $this->db->where('sold_author_status', 1);

  //     return $this->db->count_all_results('tblleads');
  //  }
  //  elseif($this->session->userdata['userlogin']['usertype'] == 'Sales Trainee' || $this->session->userdata['userlogin']['usertype'] == 'Sales Prospecting' 
  //  || $this->session->userdata['userlogin']['usertype'] == 'Sales Tier 1' || $this->session->userdata['userlogin']['usertype'] == 'Sales Tier 2'){   
  //      $this->db->where('user_id', $user_id);
  //     //  $this->db->where('MONTH(date_closed)', $month);
  //      $this->db->where('sold_author_status', 1);

  //     return $this->db->count_all_results('tblleads');
  //     }
  // } 

  public function count_all_deal_month($user_id, $month)
  {

    if ($this->session->userdata['userlogin']['usertype'] == 'Admin') {

      // $this->db->where_in('agent_remarks', ['Completed', 'On Process']);
      // $this->db->where('lead_assign !=', 2);
      // return $this->db->count_all_results('tblassign_agent');
      $this->db->select('tblassign_agent*, tblleads.sold_author_status');
      $this->db->from('tblassign_agent');
      $this->db->join('tblleads', 'tblassign_agent.lead_id = tblleads.lead_id AND tblleads.return_to_lead_control !=1 AND tblleads.trash !=1 AND tblleads.recycle_status !=1', 'inner');
      // $this->db->where('MONTH(date_closed)', $month);
      $this->db->where('lead_assign !=', 2);
      $this->db->where('agent_trash_lead !=', 2);
      $this->db->where('tblleads.sold_author_status', 1);
      // $this->db->where_in('agent_remarks', ['Completed', 'On Process']);

      return $this->db->count_all_results();
    
    } elseif ($this->session->userdata['userlogin']['usertype'] == 'Lead Gen.') {
      $this->db->where('leadgent_user_id', $user_id);
      $this->db->where_in('agent_remarks', ['Completed', 'On Process']);

      return $this->db->count_all_results('tblassign_agent');
    } elseif (
      $this->session->userdata['userlogin']['usertype'] == 'Sales Trainee' || $this->session->userdata['userlogin']['usertype'] == 'Sales Prospecting'
      || $this->session->userdata['userlogin']['usertype'] == 'Sales Tier 1' || $this->session->userdata['userlogin']['usertype'] == 'Sales Tier 2'
    ) {
      $this->db->select('tblassign_agent*, tblleads.sold_author_status');
      $this->db->from('tblassign_agent');
      $this->db->join('tblleads', 'tblassign_agent.lead_id = tblleads.lead_id AND tblleads.return_to_lead_control !=1 AND tblleads.trash !=1 AND tblleads.recycle_status !=1', 'inner');
      $this->db->where('tblassign_agent.user_id', $user_id);
      // $this->db->where('MONTH(date_closed)', $month);
      $this->db->where('lead_assign !=', 2);
      $this->db->where('agent_trash_lead !=', 2);
      $this->db->where('tblleads.sold_author_status', 1);
      // $this->db->where_in('agent_remarks', ['Completed', 'On Process']);

      return $this->db->count_all_results();
    }
  }

  public function count_all_deal_month_sales($user_id, $month)
  {
    // $this->db->where('user_id', $user_id);
    // $this->db->where_in('agent_remarks', ['Completed', 'On Process']);

    // return $this->db->count_all_results('tblassign_agent');
      $this->db->select('tblassign_agent*, tblleads.sold_author_status');
      $this->db->from('tblassign_agent');
      $this->db->join('tblleads', 'tblassign_agent.lead_id = tblleads.lead_id AND tblleads.return_to_lead_control !=1 AND tblleads.trash !=1 AND tblleads.recycle_status !=1', 'inner');
      $this->db->where('tblassign_agent.user_id', $user_id);
     
      $this->db->where('lead_assign !=', 2);
      $this->db->where('agent_trash_lead !=', 2);
      $this->db->where('tblleads.sold_author_status', 1);

      return $this->db->count_all_results();
  }

  public function count_all_deal_year_sales($user_id, $month)
  {
    $this->db->where('user_id', $user_id);
    $this->db->where_in('agent_remarks', ['Completed', 'On Process']);

    return $this->db->count_all_results('tblassign_agent');

  }


  public function count_all_deal_year($user_id, $year)
  {

    if ($this->session->userdata['userlogin']['usertype'] == 'Admin') {
      $this->db->where_in('agent_remarks', ['Completed', 'On Process']);
      return $this->db->count_all_results('tblassign_agent');
    } elseif ($this->session->userdata['userlogin']['usertype'] == 'Lead Gen.') {
      $this->db->where('leadgent_user_id', $user_id);
      $this->db->where_in('agent_remarks', ['Completed', 'On Process']);
      return $this->db->count_all_results('tblassign_agent');
    } elseif (
      $this->session->userdata['userlogin']['usertype'] == 'Sales Trainee' || $this->session->userdata['userlogin']['usertype'] == 'Sales Prospecting'
      || $this->session->userdata['userlogin']['usertype'] == 'Sales Tier 1' || $this->session->userdata['userlogin']['usertype'] == 'Sales Tier 2'
    ) {
      $this->db->where('user_id', $user_id);
      $this->db->where_in('agent_remarks', ['Completed', 'On Process']);

      return $this->db->count_all_results('tblassign_agent');
    }
  }

  public function count_all_leads($user_id)
  {

    if ($this->session->userdata['userlogin']['usertype'] == 'Admin') {
      $this->db->where_not_in('lead_status', ['inactive Leads']);
      $this->db->where('tblleads.trash !=', 1);
      return $this->db->count_all_results('tblleads');
    } elseif ($this->session->userdata['userlogin']['usertype'] == 'Lead Gen.') {
      $this->db->from('tblassign_leadgent');
      $this->db->join('tblleads', 'tblassign_leadgent.lead_id = tblleads.lead_id', 'inner');
      $this->db->where_not_in('tblleads.lead_status', ['inactive Leads']);
      $this->db->where('tblassign_leadgent.leadgent_user_id', $user_id);
      $this->db->where('lead_status_leadgent !=', 2);
      $this->db->where('tblleads.trash !=', 1);
      return $this->db->count_all_results();
    } elseif (
      $this->session->userdata['userlogin']['usertype'] == 'Sales Trainee' || $this->session->userdata['userlogin']['usertype'] == 'Sales Prospecting'
      || $this->session->userdata['userlogin']['usertype'] == 'Sales Tier 1' || $this->session->userdata['userlogin']['usertype'] == 'Sales Tier 2'
    ) {
      //  $this->db->where('user_id', $user_id);
      //  $this->db->where('lead_assign !=', 2);
      //  return $this->db->count_all_results('tblassign_agent');
      $this->db->select('tblassign_agent.*, tblleads.trash');
      $this->db->from('tblassign_agent');
      $this->db->join('tblleads', 'tblassign_agent.lead_id = tblleads.lead_id', 'inner');
      $this->db->where('tblassign_agent.user_id', $user_id);
      $this->db->where('lead_assign !=', 2);
      $this->db->where('agent_trash_lead !=', 2);
      $this->db->where('tblleads.trash !=', 1);
      $this->db->where("tblleads.lead_status_assign", 1);
      return $this->db->count_all_results();
    }
  }

  public function count_all_leads_of_the_agents($leadgentuser_id = 0)
  {
    $this->db->select('tblassign_agent.*, tblleads.trash');
    $this->db->from('tblassign_agent');
    $this->db->join('tblleads', 'tblassign_agent.lead_id = tblleads.lead_id', 'inner');
    $this->db->where('lead_assign !=', 2);
    $this->db->where('agent_trash_lead !=', 2);
    $this->db->where('tblleads.trash !=', 1);
    $this->db->where("tblleads.lead_status_assign", 1);
    $this->db->where('tblassign_agent.leadgent_user_id =', $leadgentuser_id);

    return $this->db->count_all_results();

  }
  public function count_all_leads_sales($user_id)
  {
    $this->db->where('user_id', $user_id);
     $this->db->where('lead_assign !=', 2);
    return $this->db->count_all_results('tblassign_agent');
  }
  public function count_all_agents($user_id)
  {
    $this->db->from('tblassign_agent_leadgent');
    $this->db->join('tbluser', 'tblassign_agent_leadgent.agent_user_id = tbluser.user_id', 'inner');
    $this->db->where('tblassign_agent_leadgent.leadgent_user_id', $user_id);
    $this->db->where('tbluser.status', 'Active');
    return $this->db->count_all_results();
  }

  public function get_lead_authors()
  {
    $this->db->select('*')->from('tblleads');
    // $this->db->from('tblsold_author')->where('sold_author_id', $sold_author_id);

    $query = $this->db->get();

    if ($query->num_rows() > 0) {
      return $query->result_array(); //  Returns multiple rows as an array of arrays
    } else {
      return []; //  Return an empty array instead of false
    }
  }


  public function update_lead_recycle_status($data)
  {
    // Ensure the lead_id is provided
    if (empty($data['lead_id'])) {
      return false; // or handle the error as needed
    }

    // Update the recycle status in the database
    $this->db->where('lead_id', $data['lead_id']);
    return $this->db->update('tblleads', ['recycle_status' => $data['recycle_status']]);

  }
  // public function get_authors_closed_leads() {
//   // Select only the columns: email, name, and number
//   $this->db->select('customer_email, customer_name, customer_contact');

  //   // Add condition where lead_status is 1 (closed)
//   $this->db->where('sold_author_status', 1);

  //   // Fetch data from the 'leads' table
//   $query = $this->db->get('tblleads');

  //   // Return the result as an array of objects
//   return $query->result();
// }
  public function get_closed_leads()
  {
    // Select only the columns: email, name, and number
    $this->db->select('customer_email, customer_name, customer_contact');

    // Add condition where lead_status is 1 (closed)
    $this->db->where('sold_author_status', 1);

    // Fetch data from the 'leads' table
    $query = $this->db->get('tblleads');

    // Return the result as an array of objects
    return $query->result();
  }
  public function get_sold_closed_leads()
  {
    // Select only the columns: email, name, and number
    $this->db->select('tblleads.lead_id, customer_email, customer_name, customer_contact');

    // Add condition where lead_status is 1 (closed)
    $this->db->where('sold_author_status', 1);

    // Fetch data from the 'leads' table
    $query = $this->db->get('tblleads');

    // Return the result as an array of objects
    return $query->result();
  }
  public function get_data_lead_status_is_closed($length, $start, $search, $lead_status)
  {
    $this->db->select('customer_name, customer_email, customer_contact, sold_author_status'); // Include sold_author_status in the select statement
    $this->db->from('tblleads');

    if ($lead_status != '') {
      $this->db->where('lead_status', $lead_status);
    }

    if (!empty($search)) {
      $this->db->like('customer_name', $search);
    }

    $this->db->limit($length, $start);
    $query = $this->db->get();
    return $query->result();
  }
  public function get_data_lead_status_is_closed_leadgen($length, $start, $search, $lead_status)
  {
    $this->db->select('customer_name, customer_email, customer_contact, sold_author_status'); // Include sold_author_status in the select statement
    $this->db->from('tblleads');

    if ($lead_status != '') {
      $this->db->where('lead_status', $lead_status);
    }
    if (!empty($search)) {
      $this->db->like('customer_name', $search);
    }

    $this->db->limit($length, $start);
    $query = $this->db->get();
    return $query->result();
  }

  public function update_lead_sold_author_status_closed($data, $lead_id)
  {
    $this->db->set($data);
    $this->db->where("lead_id", $lead_id);

    // Perform the update and return the success status (TRUE or FALSE)
    $query = $this->db->update("tblleads");

    // Return TRUE if update was successful, else FALSE
    return $query;
  }

  public function update_requested_date_paid($data, $lead_id)
  {
    $this->db->set($data);
    $this->db->where("lead_id", $lead_id);

    // Perform the update and return the success status (TRUE or FALSE)
    $query = $this->db->update("tblactivity");
       
    // Return TRUE if update was successful, else FALSE
    return $query;
  }

  public function update_return_lead_backet_data_detail($data, $lead_id)
  {
    if (is_array($lead_id)) {

      $this->db->set($data);

      $this->db->where_in("lead_id", $lead_id);

      $this->db->update("tblleads");
    }
    return false;

  }



  public function restore_trash_lead($data, $trash_id)
  {
    if (is_array($trash_id)) {

      $this->db->set($data);

      $this->db->where_in("trash_id", $trash_id);

      $this->db->update("tbltrash_leads");
    }
    return false;

  }


  public function trashleads()
  {
    $this->db->select('tbltrash_leads.*, tbluser.*, tblleads.*,  COUNT(tbltrash_leads.user_remove_leads_id )  as total_trash_leads');
    $this->db->from('tbltrash_leads');
    $this->db->join('tblleads', 'tbltrash_leads.lead_id = tblleads.lead_id', 'left');
    $this->db->join('tbluser', 'tbltrash_leads.user_remove_leads_id = tbluser.user_id', 'left');

    // $this->db->join('tblleads ', 'tblassign_leadgent.lead_id =  tblleads.lead_id', 'inner');  
    // $this->db->join('tblreturn_to_lead_control ', 'tblassign_leadgent.lead_id =  tblreturn_to_lead_control.lead_id', 'inner');  
    // $this->db->where("tblreturn_to_lead_control.return_status", 'Returned');  
    // $this->db->where("tblleads.recycle_status !=", 2);  
    $this->db->where("tblleads.trash !=", 0);
    $this->db->where("tbltrash_leads.trash_status !=", 'Restored');




    // Grouping by user_id and date_assigned without time
    $this->db->group_by(['tbltrash_leads.user_remove_leads_id', 'DATE(tbltrash_leads.remove_date)']);
    $this->db->order_by('total_trash_leads', 'DESC');

    $query = $this->db->get();

    // Check if there are results and return them
    return ($query->num_rows() > 0) ? $query->result_array() : false;
  }


  public function delete_lead($data)
  {
    // Ensure the lead_id is provided
    if (empty($data['lead_id'])) {
      return false; // or handle the error as needed
    }

    // Update the recycle status in the database
    $this->db->where('lead_id', $data['lead_id']);
    return $this->db->update('tblleads', ['trash' => $data['trash']]);

  }


  public function update_agent_trash_lead($data)
  {
    // Ensure the lead_id is provided
    if (empty($data['agent_task_id'])) {
      return false; // or handle the error as needed
    }

    // Update the recycle status in the database
    $this->db->where('agent_task_id', $data['agent_task_id']);
    return $this->db->update('tblassign_agent', ['agent_trash_lead' => $data['agent_trash_lead']]);

  }



  public function insert_trash_lead($data)
  {

    if ($this->db->insert("tbltrash_leads", $data)) {

      return true;

    }

  }


  public function get_leads_restore_data($user_remove_leads_id, $remove_date)
  {

    $this->db->select('tblleads.*, tbltrash_leads.*')->from('tbltrash_leads');
    $this->db->join('tblleads', 'tbltrash_leads.lead_id = tblleads.lead_id', 'left');

    $this->db->where(array('tbltrash_leads.user_remove_leads_id ' => $user_remove_leads_id));
    $this->db->where('DATE(tbltrash_leads.remove_date)', $remove_date);
    $this->db->where("tblleads.trash !=", 0);
    $this->db->where("tbltrash_leads.trash_status !=", 'Restored');





    $query = $this->db->get();

    if ($query->num_rows() > 0) {
      return $query->result_array();

    } else {

      return false;

    }

    $this->db->close();
  }


  public function select_leads_restore_data($trash_id)
  {

    $this->db->select('tbltrash_leads.*')->from('tbltrash_leads')->where(array('trash_id ' => $trash_id));


    $query = $this->db->get();

    if ($query->num_rows() > 0) {

      return $query->result_array();

    } else {

      return false;

    }

    $this->$db->close();
  }


  public function restore_lead_data_detail($data, $lead_id)
  {
    if (is_array($lead_id)) {

      $this->db->set($data);

      $this->db->where_in("lead_id", $lead_id);

      $this->db->update("tblleads");
    }
    return false;

  }

  public function is_customer_name_duplicated($customer_name)
  {
    $this->db->select('COUNT(*) as count');
    $this->db->from('tblleads');
    $this->db->where('customer_name', $customer_name);
    $this->db->where('trash !=', 1);
    $query = $this->db->get();
    return $query->row()->count > 1;
  }

  public function is_customer_email_duplicated($customer_email)
  {
    $this->db->select('COUNT(*) as count');
    $this->db->from('tblleads');
    $this->db->where('customer_email', $customer_email);
    $this->db->where('trash !=', 1);
    $query = $this->db->get();
    return $query->row()->count > 1;
  }

  public function is_customer_contact_duplicated($customer_contact)
  {
    $this->db->select('COUNT(*) as count');
    $this->db->from('tblleads');
    $this->db->where('customer_contact', $customer_contact);
    $this->db->where('trash !=', 1);
    $query = $this->db->get();
    return $query->row()->count > 1;
  }

  // if data is sold author the color is teal
  public function is_customer_email_in_leads($customer_email)
  {
    $this->db->select('1');
    $this->db->from('tblleads');
    $this->db->where('customer_email', $customer_email);
    $this->db->where('sold_author_status', 1);  // Check if sold_author_status is 1
     $this->db->where('trash !=', 1);
    $query = $this->db->get();
    return $query->num_rows() > 0;
  }

  public function is_customer_contact_in_leads($customer_contact)
  {
    $this->db->select('1');
    $this->db->from('tblleads');
    $this->db->where('customer_contact', $customer_contact);
    $this->db->where('sold_author_status', 1);  // Check if sold_author_status is 1
    $this->db->where('trash !=', 1);
    $query = $this->db->get();
    return $query->num_rows() > 0;
  }

  // if data SOLD AUTHORS and has duplication data the color is teal
  public function is_customer_name_in_leads_with_sold_status($customer_name)
  {
    $this->db->select('1');
    $this->db->from('tblleads');
    $this->db->where('customer_name', $customer_name);
    $this->db->where('trash !=', 1);
    $this->db->where('sold_author_status', 1);  // Check if sold_author_status is 1
    $query = $this->db->get();
    return $query->num_rows() > 0;
  }

  public function is_customer_email_in_leads_with_sold_status($customer_email)
  {
    $this->db->select('1');
    $this->db->from('tblleads');

    $this->db->where('customer_email', $customer_email);
    $this->db->where('sold_author_status', 1);  // Check if sold_author_status is 1
    $this->db->where('trash !=', 1);
    $query = $this->db->get();
    return $query->num_rows() > 0;
  }

  public function is_customer_contact_in_leads_with_sold_status($customer_contact)
  {
    $this->db->select('1');
    $this->db->from('tblleads');
    $this->db->where('customer_contact', $customer_contact);
    $this->db->where('sold_author_status', 1);  // Check if sold_author_status is 1
    $this->db->where('trash !=', 1);
    $query = $this->db->get();
    return $query->num_rows() > 0;
  }

  // for LEADGEN if data is duplicate the font color is RED
  public function is_customer_name_duplicated_leads_of_leadGen($customer_name)
  {
    $this->db->select('COUNT(*) as count', 'leadgents.*');
    $this->db->from('tblleads');
    $this->db->join('tblassign_leadgent as leadgents', 'tblleads.lead_id = leadgents.lead_id', 'inner');
    $this->db->where('customer_name', $customer_name);
    $this->db->where('lead_status_leadgent !=', 2);
    $this->db->where('trash !=', 1);
    $query = $this->db->get();
    return $query->row()->count > 1;
  }

  public function is_customer_email_duplicated_leads_of_leadGen($customer_email)
  {
    $this->db->select('COUNT(*) as count', 'leadgents.*');
    $this->db->from('tblleads');
    $this->db->join('tblassign_leadgent as leadgents', 'tblleads.lead_id = leadgents.lead_id', 'inner');
    $this->db->where('customer_email', $customer_email);
    $this->db->where('lead_status_leadgent !=', 2);
    $this->db->where('trash !=', 1);
    $query = $this->db->get();
    return $query->row()->count > 1;
  }

  public function is_customer_contact_duplicated_leads_of_leadGen($customer_contact)
  {
    $this->db->select('COUNT(*) as count', 'leadgents.*');
    $this->db->from('tblleads');
    $this->db->join('tblassign_leadgent as leadgents', 'tblleads.lead_id = leadgents.lead_id', 'inner');
    $this->db->where('customer_contact', $customer_contact);
    $this->db->where('lead_status_leadgent !=', 2);
    $this->db->where('trash !=', 1);
    $query = $this->db->get();
    return $query->row()->count > 1;
  }
  //  if SOLD AUTHOR the color is TEAL



  public function is_customer_email_in_leads_leadgen($customer_email)
  {
    $this->db->select('1');
    $this->db->from('tblleads');
    $this->db->where('customer_email', $customer_email);
    $this->db->where('sold_author_status', 1);  // Check if sold_author_status is 1
    $this->db->where('trash !=', 1);
    $query = $this->db->get();
    return $query->num_rows() > 0;
  }

  public function is_customer_contact_in_leads_leadgen($customer_contact)
  {
    $this->db->select('1');
    $this->db->from('tblleads');
    $this->db->where('customer_contact', $customer_contact);
    $this->db->where('sold_author_status', 1);  // Check if sold_author_status is 1
    $this->db->where('trash !=', 1);
    $query = $this->db->get();
    return $query->num_rows() > 0;
  }

  // if data is SOLD AUTHOR and has DUPLICATE DATA the color is TEAL
  public function is_customer_name_in_leads_with_sold_status_leadgen($customer_name)
  {
    $this->db->select('1');
    $this->db->from('tblleads');
    $this->db->where('customer_name', $customer_name);
    $this->db->where('sold_author_status', 1);  // Check if sold_author_status is 1
    $this->db->where('trash !=', 1);
    $query = $this->db->get();
    return $query->num_rows() > 0;
  }
  public function is_customer_email_in_leads_with_sold_status_leadgen($customer_email)
  {
    $this->db->select('1');
    $this->db->from('tblleads');

    $this->db->where('customer_email', $customer_email);
    $this->db->where('sold_author_status', 1);  // Check if sold_author_status is 1
    $this->db->where('trash !=', 1);
    $query = $this->db->get();
    return $query->num_rows() > 0;
  }
  public function is_customer_contact_in_leads_with_sold_status_leadgen($customer_contact)
  {
    $this->db->select('1');
    $this->db->from('tblleads');
    $this->db->where('customer_contact', $customer_contact);
    $this->db->where('sold_author_status', 1);  // Check if sold_author_status is 1
    $this->db->where('trash !=', 1);
    $query = $this->db->get();
    return $query->num_rows() > 0;
  }
  // =========================================================================


  public function checkDuplicate($email, $contact)
  {
    $this->db->where('customer_email', $email);
    $this->db->where('customer_contact', $contact);
    $this->db->where('trash !=', 1);
    $query = $this->db->get('tblleads'); // Replace 'leads' with your actual table name

    return $query->num_rows() > 0;
  }

  public function checkDuplicateNameContact($name, $contact) {
    $this->db->where('customer_name', $name);
    $this->db->where('customer_contact', $contact);
    $this->db->where('trash !=', 1);
    $query = $this->db->get('tblleads'); // Replace with actual table name
    return $query->num_rows() > 0;
}

public function checkDuplicateNameEmail($name, $email) {
    $this->db->where('customer_name', $name);
    $this->db->where('trash !=', 1);
    $this->db->where('customer_email', $email);
    $query = $this->db->get('tblleads');
    return $query->num_rows() > 0;
}

public function checkDuplicateContactEmail($contact, $email) {
    $this->db->where('customer_contact', $contact);
    $this->db->where('customer_email', $email);
    $query = $this->db->get('tblleads');
    return $query->num_rows() > 0;
}
public function get_data_leadagent_lead_status($limit, $start, $search, $lead_id = 0, $lead_status = "", $leadgentuser_id)
  {
    $this->db->select('leads.*, leadgents.*');
    $this->db->from('tblleads as leads');
    $this->db->join('tblassign_leadgent as leadgents', 'leads.lead_id = leadgents.lead_id', 'inner');
    // $this->db->join('tbluser as users', 'leadgents.leadgent_user_id  = users.user_id', 'inner'); try daw
    $this->db->where('leadgents.leadgent_user_id =', $leadgentuser_id);
    // $this->db->where_not_in('leads.lead_status', ['inactive Leads', 'Wrong Email and Phone']);
    $this->db->where('leads.lead_status IS NOT NULL');
    $this->db->where('leads.lead_status !=', '');
    $this->db->where('leads.trash !=', 1);
    $this->db->where('leads.lead_status_assign', 0);
    $this->db->where('leadgents.lead_status_leadgent !=', 2);

    if ($lead_id > 0) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->where('leads.lead_id', $lead_id);
      $this->db->group_end(); // End grouping for search conditionsddddd

    } else if (!empty($search)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->like('title', $search)
        ->or_like('customer_email', $search)
        ->or_like('customer_contact', $search)
        ->or_like('customer_name', $search);
      $this->db->group_end(); // End grouping for search conditions
    } else if (!empty($lead_status) && empty($search)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->where('lead_status', $lead_status);
      $this->db->group_end(); // End grouping for search conditions


    } else if (!empty($search) && empty($lead_status)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->like('title', $search);
      $this->db->or_like('customer_name', $search);
      $this->db->group_end(); // End grouping for search conditions

    } else if (!empty($search) && !empty($lead_status)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->or_like('customer_email', $search);
      $this->db->or_like('customer_contact', $search);
      $this->db->or_like('customer_name', $search);
      $this->db->where('lead_status', $lead_status);
      $this->db->group_end(); // End grouping for search conditions
    }

    $this->db->limit($limit, $start);
    $query = $this->db->get();
    return $query->result();
  }


 public function count_filtered_leadgent_lead_status($search, $lead_id = 0, $lead_status = "", $leadgentuser_id = 0)
  {
     $this->db->select('leads.*, leadgents.*');
    $this->db->from('tblleads as leads');
    $this->db->join('tblassign_leadgent as leadgents', 'leads.lead_id = leadgents.lead_id', 'inner');
    // $this->db->join('tbluser as users', 'leadgents.leadgent_user_id  = users.user_id', 'inner');
    $this->db->where('leadgents.leadgent_user_id =', $leadgentuser_id);
    // $this->db->where_not_in('leads.lead_status', ['inactive Leads']);
    $this->db->where('leads.lead_status IS NOT NULL');
    $this->db->where('leads.lead_status !=', '');
    $this->db->where('leads.lead_status_assign', 0);
    $this->db->where('leadgents.lead_status_leadgent !=', 2);




    if ($lead_id > 0) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->where('leads.lead_id', $lead_id);
      $this->db->group_end(); // End grouping for search conditionsddddd

    } else if (!empty($search)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->like('title', $search)
        ->or_like('customer_email', $search)
        ->or_like('customer_contact', $search)
        ->or_like('customer_name', $search);
      $this->db->group_end(); // End grouping for search conditions
    } else if (!empty($lead_status) && empty($search)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->where('lead_status', $lead_status);
      $this->db->group_end(); // End grouping for search conditions


    } else if (!empty($search) && empty($lead_status)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->like('title', $search);
      $this->db->or_like('customer_name', $search);
      $this->db->group_end(); // End grouping for search conditions

    } else if (!empty($search) && !empty($lead_status)) {
      $this->db->group_start(); // Start grouping for search conditions
      $this->db->or_like('customer_email', $search);
      $this->db->or_like('customer_contact', $search);
      $this->db->or_like('customer_name', $search);
      $this->db->where('lead_status', $lead_status);
      $this->db->group_end(); // End grouping for search conditions
    }

    return $this->db->count_all_results();
  }

  public function count_all_leadgent_lead_status( $leadgentuser_id = 0)
  {
     $this->db->select('leads.*, leadgents.*');
    $this->db->from('tblleads as leads');
    $this->db->join('tblassign_leadgent as leadgents', 'leads.lead_id = leadgents.lead_id', 'inner');
    // $this->db->join('tbluser as users', 'leadgents.leadgent_user_id  = users.user_id', 'inner'); padayun
    $this->db->where('leadgents.leadgent_user_id =', $leadgentuser_id);
    // $this->db->where_not_in('leads.lead_status', ['inactive Leads']);
    $this->db->where('leads.lead_status IS NOT NULL');
    $this->db->where('leads.lead_status !=', '');
    $this->db->where('leads.lead_status_assign', 0);
    $this->db->where('leads.trash !=', 1);
    $this->db->where('leadgents.lead_status_leadgent !=', 2);

    return $this->db->count_all_results();
  }
}
?>