<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banip_Model extends CI_Model {

    // Set table name
	private $table = 'ban_ip';

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
        $this->db->order_by('id', 'desc');
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
        // $data['role'] = isset($data['role'])?$data['role']:'3';
      
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

    public function update($id,$data){
        $this->db->select('*');
        $this->db->where('id !=', $id);
        $this->db->where('IP', $data['IP']);
        $query = $this->db->get($this->table);
        if($query->num_rows()>0){
            $response = ['status'=>false,'message'=>'The IP already exitst'];
            return $response;
        }
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

    public function status($id,$status){
        $this->db->where('id', $id);
        $this->db->where('id!=','1');
        $this->db->update($this->table, ['status'=>$status]);
        $response = ['status'=>true,'message'=>'Success'];
        return $response;
    }

    public function count(){
        return $this->db->where('role!=','1')->from($this->table)->count_all_results();
    }

    public function lastlogin(){
         $this->db->select('*')->order_by('admins.last_login',"desc")->where('role!=','1')->limit(5);
         $query = $this->db->get($this->table);
         return $query->result_array();
    }

    public function lastregister(){
        $this->db->select('*')->order_by('admins.created_at',"desc")->where('role!=','1')->limit(5);
         $query = $this->db->get($this->table);
         return $query->result_array();
    }

    public function getheaders(){


        $this->db->select(['admins.firstname','admins.lastname','admins.username','admins.email','admins.birthdate']);
        $this->db->from('roles');
        $this->db->join('admins','admins.role=roles.id');
        $this->db->where('admins.id!=', '1');
        $this->db->order_by('admins.username',"asc");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function checkduplicate($data){
        $this->db->select('*');
        $this->db->where('email', $data['email']);
        $query = $this->db->get($this->table);
        if($query->num_rows()>0){
            $records = $query->row_array();
            $response = ['status'=>true,'records'=>$records];
        }
        else{
            $response = ['status'=>false,'records'=>[]];
        }
        return $response;
    }

    public function checkrole($name){
         $this->db->select('id');
        $this->db->where('name', $name);
        $query = $this->db->get('roles');
        return $query->row_array();
    }

    public function weeklyregistered($week_start,$week_end){
        $week_start = strtotime($week_start);
        $week_end = strtotime($week_end);
        $dates = array();
        for($i = $week_start; $i<=$week_end; $i+=86400){
        $query = $this->db->where('id!=','1')->where('DATE(created_at) =', date("Y-m-d", $i))->from($this->table)->count_all_results();
            array_push($dates,$query);  
        }
    
        return $dates;
    }

    public function checkip($ip){
        $this->db->select('*');
        $this->db->where('IP', $ip);
        $query = $this->db->get($this->table);
        if($query->num_rows()>0){
            $records = $query->row_array();
            $response = ['status'=>true,'message'=>'your ip has been banned','records'=>$records];
        }
        else{
            $response = ['status'=>false,'message'=>'Success','records'=>[]];
        }
        return $response;

    }
    
}
