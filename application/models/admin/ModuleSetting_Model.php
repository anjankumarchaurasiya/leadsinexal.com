<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModuleSetting_Model extends CI_Model {

    // Set table name
	private $table = 'module_settings';

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
    @param birthDate    date
    @param password string
    @return status boolean
    @return message string
    @return id int
    */
    public function store($data){
        $data['created_at'] = date ("Y-m-d H:i:s");
        $data['updated_at'] = date ("Y-m-d H:i:s");
    	$request = $this->db->insert($this->table, $data);
        
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

    public function preview($slug){
        $this->db->select('*');
        $this->db->where('slug', $slug);
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

    public function update($id,$data){
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
        $response = ['status'=>true,'message'=>'Success'];
        return $response;
    }

    public function destroy($id){
       
        $this->db->where('id', $id);
        $this->db->delete($this->table);
        $response = ['status'=>true,'message'=>'Success'];
        return $response;
    }

    public function count(){
        return $this->db->from($this->table)->count_all_results();
    }

    public function getattribute($page){
        $this->db->select('*');
        $this->db->where('role_id', $page);
        $query = $this->db->get($this->table);
        if($query->num_rows()>0){
            $record = $query->result_array();
            $response = ['status'=>true,'message'=>'Success','record'=>$record];
        }
        else{
            $response = ['status'=>false];
        }
        return $response;
    }
}
