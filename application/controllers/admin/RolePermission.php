<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RolePermission extends CI_Controller {
    private $data;
    private $page;
    /**
    @param void
    @return void
    */
    function __construct(){
        parent::__construct();
        if(!$this->session->userdata('admin_id')){
            redirect(base_url('admin/signin'));
        }
        $this->load->model('admin/Admin_Model','admin');
        $response = $this->admin->edit($this->session->userdata('admin_id'));
        $settings = $this->load->model('admin/Settings_Model','settings');
	    $settings = $this->load->model('admin/RolePermission_Model','rolepermission');
	    $this->data['settings'] = $this->settings->get();
        if($response['status']===true){
             $this->data['admin'] = $response['record'];
            $this->data['userrole']= $this->rolepermission->edit($this->data['admin']['role']);
            $this->page = 'role';
            chkaccess($this->data,$this->page,'view');
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
        $this->data['rolepermission'] = $this->rolepermission->get();

        $this->load->view('admin/rolepermission/list',$this->data);
    }

    public function create(){
        chkaccess($this->data,$this->page,'create');
        
        $this->load->view('admin/rolepermission/form',$this->data);
    }

    /**
    @param void
    @return void
    */
    public function store(){
        chkaccess($this->data,$this->page,'create');

        $validation = [
                ['field' => 'name','label' => 'Name','rules' => 'trim|required|xss_clean|is_unique[roles.name]','errors'=>['is_unique'=>'The %s is already taken']],
            ];
        $this->form_validation->set_rules($validation);
        if($this->form_validation->run() == false){
            $this->load->view('admin/rolepermission/form',$this->data);
        }
        else{
            $permissions = [];
            if(isset($_POST['permissions'])){
                foreach($_POST['permissions'] as $key=>$val){
                    $permissions['permissions'][$key]['view'] = isset($val['view'])?true:false;
                    $permissions['permissions'][$key]['create'] = isset($val['create'])?true:false;
                    $permissions['permissions'][$key]['edit'] = isset($val['edit'])?true:false;
                    $permissions['permissions'][$key]['delete'] = isset($val['delete'])?true:false;
                }
            }
            $_POST['permissions'] = json_encode($permissions['permissions']);
            $response = $this->rolepermission->store($_POST);
            if($response['status']===true){
                $this->session->set_flashdata('success', $response['message']);
                redirect(base_url('admin/RolePermission'));
            }
            else{
                $this->session->set_flashdata('error', $response['message']);
                $this->load->view('admin/rolepermission');
            }
        }
    }

    public function edit($id){
        chkaccess($this->data,$this->page,'edit');

        $this->data['id'] = $id;
        $this->data['rolepermission'] = $this->rolepermission->edit($id);
        if($this->data['rolepermission']['status']===false){
            redirect(base_url('admin/RolePermission'));
        }
        $this->load->view('admin/rolepermission/form',$this->data);
    }

    public function update($id){

        $this->data['id'] = $id;
        $this->data['rolepermission'] = $this->rolepermission->edit($id);
        $validation = [
                ['field' => 'name','label' => 'Name','rules' => 'trim|required|xss_clean|callback_check_role_name','errors'=>['is_unique'=>'The %s is already taken']],
            ];
        $this->form_validation->set_rules($validation);
        if($this->form_validation->run() == false){
            $this->load->view('admin/rolepermission/form',$this->data);
        }
        else{
            $permissions = [];
            if(isset($_POST['permissions'])){
                foreach($_POST['permissions'] as $key=>$val){
                    $permissions['permissions'][$key]['view'] = isset($val['view'])?true:false;
                    $permissions['permissions'][$key]['create'] = isset($val['create'])?true:false;
                    $permissions['permissions'][$key]['edit'] = isset($val['edit'])?true:false;
                    $permissions['permissions'][$key]['delete'] = isset($val['delete'])?true:false;
                }
            }
            $_POST['permissions'] = json_encode($permissions['permissions']);

            $response = $this->rolepermission->update($id,$_POST);
            if($response['status']===true){
                $this->session->set_flashdata('success', $response['message']);
                redirect(base_url('admin/RolePermission'));
            }
            else{
                $this->session->set_flashdata('error', $response['message']);
                $this->load->view('admin/rolepermission/form',$this->data);
            }
        }
    }

    public function check_role_name($name) {    
         if($this->data['id'])
            $id = $this->data['id'];
        else
            $id = ' ';
        $result = $this->rolepermission->check_unique_user_name($id, $name);
        if($result == 0)
            $response = true;
        else {
            $this->form_validation->set_message('check_role_name', 'Name must be unique');
            $response = false;
        }
        return $response;

    }
    public function destroy($id){
        if($id <= 3){
        $this->session->set_flashdata('error', 'You can not delete this role.');
        redirect(base_url('admin/RolePermission/create'));
        }
        chkaccess($this->data,$this->page,'delete');        

        $response = $this->rolepermission->destroy($id);
        $status = $response['status']===true?'success':'error';
        $this->session->set_flashdata($status, $response['message']);
        redirect(base_url('admin/RolePermission'));
    }

}
