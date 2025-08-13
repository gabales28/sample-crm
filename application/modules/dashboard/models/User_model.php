  <?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');



   class User_Model extends CI_Model {

      

      function __construct() {

         parent::__construct();


      }
      public function all_users(){

        $this->db->select('*')->from('tbluser');

        $query=$this->db->get();


        if ($query->num_rows() > 0){

          return $query->result_array();

        }

        else{

            return false;

        }

        $this->db->close();

      }
      public function insert(){
      
      }
      public function update(){
      
      }
      public function delete(){
      
      }


   }

?>

