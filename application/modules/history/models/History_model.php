<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class History_Model extends CI_Model
{

  function __construct()
  {

    parent::__construct();
  }


  public function tableactivities()
  {

    $this->db->select('act.*, lead.*')->from('tblactivity as act')->join('tblleads as lead', 'act.lead_id = lead.lead_id', 'inner');

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

    if ($this->db->insert("tbltransaction_history", $data)) {

      return true;
    }
  }
  public function insertPaymentTransactionHistory($data)
  {

    if ($this->db->insert("tblpayment_transaction_history ", $data)) {

      return true;
    }
  }
  public function select_lead_activity($lead_id)
  {

    $this->db->select('act.*, lead.*')->from('tblactivity as act')->join('tblleads as lead', 'act.lead_id = lead.lead_id', 'inner')
      ->where(array('act.lead_id ' => $lead_id));


    $query = $this->db->get();

    if ($query->num_rows() > 0) {

      return $query->result_array();
    } else {

      return false;
    }

    $this->db->close();
  }
  public function select_leadgent_lead($lead_id)
  {

    $this->db->select('*')->from('tblassign_leadgent')->where(array('lead_id ' => $lead_id));

    $query = $this->db->get();

    if ($query->num_rows() == 1) {
      return $query->row_array();
    } else {

      return false;
    }
    $this->db->close();
  }

  public function select_agent_lead($lead_id)
  {

    $this->db->select('*')->from('tblassign_agent')->where(array('lead_id ' => $lead_id));

    $query = $this->db->get();

    if ($query->num_rows() == 1) {
      return $query->row_array();
    } else {

      return false;
    }
    $this->db->close();
  }

  public function select_agent_history($lead_id)
  {

    $this->db->select('tblleads.*, tblpayment_transaction_history.*');
    $this->db->from(' tblpayment_transaction_history');
    $this->db->join('tblleads', 'tblpayment_transaction_history.lead_id = tblleads.lead_id', 'left');
    $this->db->where('tblpayment_transaction_history.lead_id', $lead_id);
    // $this->db->order_by('transcation_id', 'ASC');
    $query = $this->db->get();

    if ($query->num_rows() > 0) {

      return $query->result_array();
    } else {

      return false;
    }

    $this->$db->close();
  }

  public function select_transaction_history($lead_id)
  {

    $this->db->select('tblleads.*, tblpayment_transaction_history.*');
    $this->db->from(' tblpayment_transaction_history');
    $this->db->join('tblleads', 'tblpayment_transaction_history.lead_id = tblleads.lead_id', 'left');
    $this->db->where('tblpayment_transaction_history.lead_id', $lead_id);
    // $this->db->order_by('transcation_id', 'ASC');
    $query = $this->db->get();

    if ($query->num_rows() > 0) {

      return $query->result_array();
    } else {

      return false;
    }

    $this->$db->close();
  }

  
public function select_agents_transaction_history($lead_id)
  {
    $this->db->select('tblleads.*, tblpayment_transaction_history.*');
    $this->db->from(' tblpayment_transaction_history');
    $this->db->join('tblleads', 'tblpayment_transaction_history.lead_id = tblleads.lead_id', 'left');
    $this->db->where('tblpayment_transaction_history.lead_id', $lead_id);
    // $this->db->order_by('transcation_id', 'ASC');
    $query = $this->db->get();

    if ($query->num_rows() > 0) {

      return $query->result_array();
    } else {

      return false;
    }

    $this->$db->close();
  }
  public function updatePayment($transaction_id, $data)
  {
    $this->db->where('transaction_id', $transaction_id);
    return $this->db->update('tbltransaction_history', $data);
  }

  public function updateLatestsPayment($transaction_id, $data)
  {
    $this->db->where('transaction_id', $transaction_id);
    return $this->db->update('tbltransaction_history', $data);
  }

  
  // public function update_paymentTransaction($payment_id, $data)
  // {
  //   $this->db->where('payment_id', $payment_id);
  //   return $this->db->update('tblpayment_transaction_history', $data);
  // }

public function update_paymentTransaction($payment_id, $data, $date_paid)
{
    $this->db->where('payment_id', $payment_id);

    // Build update manually to use MySQL function
    $this->db->set($data);
    // $this->db->set('expiration_date', "DATE_ADD(DATE_FORMAT('".$date_paid."' + INTERVAL 1 MONTH, '%Y-%m-01'), INTERVAL 5 DAY)", FALSE);
$this->db->set('expiration_date',"IF(DAY('".$date_paid."') < 6,
        DATE_FORMAT('".$date_paid."', '%Y-%m-06'),
        DATE_FORMAT(DATE_ADD(DATE_FORMAT('".$date_paid."', '%Y-%m-01'), INTERVAL 1 MONTH), '%Y-%m-06')
    )",
    FALSE
);

    return $this->db->update('tblpayment_transaction_history');
}


  public function InsertPaymentTransaction($payment_id, $data_payment_trans_history)
  {
    $this->db->where('payment_id', $payment_id);
    return $this->db->insert('tblpayment_transaction_history', $data_payment_trans_history);
  }

  public function resetPayment($transaction_id)
  {

    $this->db->delete('tbltransaction_history', array('transaction_id' => $transaction_id));  // Produces: // DELETE FROM mytable  // WHERE id = $id
  }

  public function select_agent_payment_history($lead_id)
  {
    $this->db->select('tblleads.*, tbltransaction_history.*');
    $this->db->from('tbltransaction_history');
    $this->db->join('tblleads', 'tbltransaction_history.lead_id = tblleads.lead_id', 'left');
    $this->db->where('tbltransaction_history.lead_id', $lead_id);

    $query = $this->db->get();

    if ($query->num_rows() > 0) {

      return $query->result_array();
    } else {

      return false;
    }
    $this->$db->close();
  }
}

