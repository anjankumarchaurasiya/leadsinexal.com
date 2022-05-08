<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_Model extends CI_Model {

    // Set table name
    private $table = 'admins';

    /**
    @param void
    @return void
    */
    function __construct(){
        // Call the Model constructor
        parent::__construct();
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
    @param email string
    @param password string
    @return status boolean
    @return message string
    @return data array
    */
    public function dosignin($data){
        $this->db->select('*');
        $this->db->group_start();
        $this->db->where('username', $data['username'])->or_where('email',$data['username']);
        $this->db->group_end();
        $this->db->where('password', $data['password']);
        $query = $this->db->get($this->table);
        // check if valid email and password.
        if($query->num_rows()>0){
            $record = $query->row_array();
            if($record['status']=='0'){
                
                $response = ['status'=>false,'message'=>'Your account is disabled'];
            }
            else{
                $data = ["last_login"=>date('Y-m-d H:i:s'),"created_at"=>" ","updated_at"=>" "];
                // print_r($data);exit;
                $this->db->where('id', $record['id']);
                $this->db->update($this->table, $data);
                $response = ['status'=>true,'message'=>'Success','record'=>$record];
            }
        }
        else{
            $response = ['status'=>false,'message'=>'Please enter valid email and password'];
        }
        return $response;
    }

        public function checkUser($userData){
        $this->db->select('*');
        $this->db->where('email', $userData['email']);
        $query = $this->db->get($this->table);
        if($query->num_rows()>0){
            $record = $query->row_array();
            unset($userData['image']);
            unset($userData['login_type']);
            unset($userData['image_flag']);
            $this->db->where('id', $record['id']);
            $this->db->update($this->table, $userData);
            $response = ['status'=>true,'id'=>$record['id']];
        }
        else{
            $request = $this->db->insert($this->table, $userData);
            $response = ['status'=>true,'id'=>$this->db->insert_id()];
        }
        return $response;
    }

    public function checkactivation($userData){

        $this->db->select('*');
        $this->db->where('email', $userData['email']);
        $this->db->where('status', '0');
        $query = $this->db->get($this->table);
        if($query->num_rows()>0){
            $record = $query->row_array();
            $response = ['status'=>true,'message'=>'Your account is disabled.','id'=>$record['id']];
        }
        else{
            $response = ['status'=>false,'message'=>'Success'];
        }
        return $response;
    }

    public function validemail($userData){

        $this->db->select('*');
        $this->db->where('email', $userData['email']);
        $this->db->where('login_type', '1');
        $query = $this->db->get($this->table);
        if($query->num_rows()>0){
            $record = $query->row_array();
            $response = ['status'=>false,'message'=>'This email is already registered.','id'=>$record['id']];
        }
        else{
            $response = ['status'=>true,'message'=>'Success'];
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

    public function forgot($data){
        $this->db->select('*');
        $this->db->where('email', $data['email']);
        $this->db->where('id !=', 1);
        $query = $this->db->get($this->table);
        if($query->num_rows()>0){
            $record = $query->row_array();
            $this->load->helper('string');
            $token = random_string('alnum',80);
            $this->db->where('id', $record['id']);
            $this->db->update($this->table, ['remember_token'=>$token]);
            $response = ['status'=>true,'message'=>'Reset password link sent to your email','record'=>$record,'token'=>$token];
        }
        else{
            $response = ['status'=>false,'message'=>'This email is not available in our record'];
        }
        return $response;
    }

    public function doreset($data){
        $this->db->select('*');
        $this->db->where('remember_token', $data['remember_token']);
        $query = $this->db->get($this->table);
        if($query->num_rows()>0){
            $record = $query->row_array();
            $this->db->where('id', $record['id']);
            $this->db->update($this->table, ['password'=>$data['password'],'remember_token'=>null]);
            $response = ['status'=>true,'message'=>'Password updated successfully'];
        }
        else{
            $response = ['status'=>false,'message'=>'Something went wrong, Please try again'];
        }
        return $response;
    }

    public function update($id,$data){
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
        $response = ['status'=>true,'message'=>'Success'];
        return $response;
    }


    public function update_password($id,$data){
        $this->db->select('*');
        $this->db->where('id', $id);
        $this->db->where('password', $data['current_password']);
        $query = $this->db->get($this->table);
        if($query->num_rows()>0){
            $record = $query->row_array();
            $this->db->where('id', $record['id']);
            $this->db->update($this->table, ['password'=>$data['password']]);
            $response = ['status'=>true,'message'=>'Password updated successfully'];
        }
        else{
            $response = ['status'=>false,'message'=>'Current password is wrong'];
        }
        return $response;
    }
}
