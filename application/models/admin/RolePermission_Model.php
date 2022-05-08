<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RolePermission_Model extends CI_Model {

    // Set table name
	private $table = 'roles';

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

    public function check_unique_user_name($id = '',$name) {
        $this->db->where('name', $name);
        if($id) {
            $this->db->where_not_in('id', $id);
        }
        return $this->db->get($this->table)->num_rows();
    }
    /**
    @param name string
    @param rolespermission array
    @return id int
    */
    public function store($data){
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
        //     echo '<pre>';
        // print_r($record);
        // die();
            $record['permissions'] = json_decode($record['permissions'],true);
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

}
