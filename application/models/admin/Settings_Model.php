<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings_Model extends CI_Model {
    // Set table name
	private $table = 'settings';

    /**
    @param void
    @return void
    */
    function __construct(){
        // Call the Model constructor
        parent::__construct();
    }

    public function get(){
        $this->db->select('*');
	$this->db->order_by("id", "desc");
        $query = $this->db->get($this->table);
        if($query->num_rows()>0){
            $records = $query->result_array();
            $response = ['status'=>true,'message'=>'Success','records'=>$records];
        }
        else{
            $response = ['status'=>false,'message'=>'No records found','records'=>[]];
        }
        return $response;
    }

    /**
    @param firstName string
    @param lastName string
    @param email string
    @param birthDate date
    @param password string
    @return status boolean
    @return message string
    @return id int
    */
    public function store($data){
        
        if($this->db->from($this->table)->count_all_results()>0){
            $request = $this->db->update($this->table, $data);
        }
        else{
    	   $request = $this->db->insert($this->table, $data);
        }
    	$this->db->trans_complete();
        // check if record inserted successfully.
    	if($request){
    		$response = ['status'=>true,'message'=>'Success','id'=>$this->db->insert_id()];
    	}
    	else{
    		$response = ['status'=>false,'message'=>'Something went wrong, Please try again.'];
    	}
    	return $response;
    }

    /**
    @param id int
    @return status boolean
    @return message string
    @return data array
    */
    public function edit($id){
        $this->db->select('*');
        $this->db->where('id', $id);
        $query = $this->db->get($this->table);
        if($query->num_rows()>0){
            $record = $query->row_array();
            $response = ['status'=>true,'message'=>'Success','record'=>$record];
        }
        else{
            $response = ['status'=>false,'message'=>'Please enter valid email and password'];
        }
        return $response;
    }
}
