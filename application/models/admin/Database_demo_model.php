<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Database_demo_model extends CI_Model {

    // Set table name
   private $table = 'demo_database';

    /**
    @param void
    @return void
    */
    function __construct(){
        // Call the Model constructor
        parent::__construct();
    }

    public function get(){
        $myid = $this->session->userdata('admin_id');
        if(getrole_id() == 1){
           $this->db->select('*');
       }else{
         $this->db->select('*')->where('created_by',$myid);
       }
       
        $query = $this->db->order_by("id", "desc")->get($this->table);
        if($query->num_rows()>0){
            $records = $query->result_array();
            $response = ['status'=>true,'message'=>'Success','records'=>$records];
        }
        else{
            $response = ['status'=>false,'message'=>'No records found','records'=>[]];
        }
        return $response;
    }
    public function store($data){
      $request = $this->db->insert($this->table, $data);
      $this->db->trans_complete();
      if($request){
         $response = ['status'=>true,'message'=>'Success','id'=>$this->db->insert_id()];
      }
      else{
         $response = ['status'=>false,'message'=>'Something went wrong, Please try again.'];
      }
      return $response;
    }
    public function destroy($id){
      
        $this->db->where('id', $id);
        $this->db->delete($this->table);
        $response = ['status'=>true,'message'=>'Success'];
        return $response;
    }
 }
