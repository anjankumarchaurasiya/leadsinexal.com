<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	private $data;
	function __construct(){
        parent::__construct();
        if(!$this->session->userdata('admin_id')){
        	redirect(base_url('admin/signin'));
        }
        $this->load->model('admin/Admin_Model','admin');
        $response = $this->admin->edit($this->session->userdata('admin_id'));
        $settings = $this->load->model('admin/Cms_Model','cms');
	    $settings = $this->load->model('admin/Settings_Model','settings');
	    $this->data['settings'] = $this->settings->get();
    	if($response['status']===true){
			$this->data['admin'] = $response['record'];
            $role = $this->load->model('admin/RolePermission_Model','role');
            $this->data['userrole']= $this->role->edit($this->data['admin']['role']);
        }
		else{
			redirect(base_url('admin/signin'));
		}
    }

    /**
    @param void
    @return void
    */
	public function index(){
        $this->load->model('admin/User_Model','user');
    

        $day = date('w'); 
        $week_start = date('Y-m-d', strtotime('-'.$day.' days'));
        $week_end = date('Y-m-d', strtotime('+'.(6-$day).' days'));
        if($this->data['admin']['role']==2)
        {
         $this->data['users'] = $this->db->get_where('admins',['seller_id'=>$this->data['admin']['id']])->num_rows();   
         $sellerid=$this->data['admin']['id'];
         $this->data['registered'] = $this->user->weeklyregistered($week_start,$week_end,$sellerid);
         $this->data['exal'] = $this->db->get_where('exal_assign_user',['user_id'=>$this->data['admin']['id']])->num_rows();
         $this->data['last_login'] = $this->user->lastlogin_byseller($sellerid);
         $this->data['last_register'] = $this->user->lastregister_byseller($sellerid);
        }else{
            $this->data['users'] = $this->db->get_where('admins',['role'=>'3'])->num_rows();
            $this->data['seller']=$this->db->get_where('admins',['role'=>'2'])->num_rows();
            $this->data['registered']=$this->user->weeklyregistered($week_start,$week_end);
            $this->data['exal'] = $this->db->get('exal_assign_user')->num_rows();
            $this->data['category'] = $this->db->get('category')->num_rows();
            $this->data['last_login'] = $this->user->lastlogin();
            $this->data['last_register'] = $this->user->lastregister();
        }
 
        $this->data['registered'] =  implode(",",$this->data['registered']);
        // echo '<pre>';
        // print_r($this->data['userrole']);
        // die();
		$this->load->view('admin/dashboard',$this->data);
	}
}
