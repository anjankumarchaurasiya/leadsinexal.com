<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    private $data;
	/**
    @param void
    @return void
    */
	function __construct(){
        
        parent::__construct();
              
        $this->load->library('googleplus');
        $this->load->library('facebook');

        if(!$this->session->userdata('admin_id')){
        	redirect(base_url('admin/signin'));
        }
        $this->load->model('admin/Admin_Model','admin');
        $response = $this->admin->edit($this->session->userdata('admin_id'));
        if($response['status']===true){
            $this->data['admin'] = $response['record'];
            $role = $this->load->model('admin/RolePermission_Model','role');
            $module_setting = $this->load->model('admin/ModuleSetting_Model','module_setting');
            $this->data['userrole']= $this->role->edit($this->data['admin']['role']);
	    $settings = $this->load->model('admin/Settings_Model','settings');
       $settings = $this->load->model('admin/Cms_Model','cms');
	    $this->data['settings'] = $this->settings->get();
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

    }

    public function profile(){
        $this->load->view('admin/profile',$this->data);
    }

    public function update(){
        $validation = [
                ['field' => 'firstname','label' => 'First Name','rules' => 'trim|required|xss_clean'],
                ['field' => 'lastname','label' => 'Last Name','rules' => 'trim|required|xss_clean'],
                ['field' => 'email','label' => 'Email','rules' => 'trim|required|xss_clean|valid_email','errors'=>['is_unique'=>'The %s is already taken']],
            ];
           
            $userrole=$this->db->get_where('admins',['id'=>$this->session->userdata('admin_id')])->row_array();

        
        $module=$this->module_setting->getattribute($userrole['role']);
        if(!empty($module)){
                foreach ($module['record'] as $key => $value) {
                    
                    $validate_value = json_decode($value['validate_attr'],true);
                    $r = $validate_value['rules'];
                    $value['validate_attr'] = implode("|",(array) $r);
                    if($value['type'] == "checkbox(multiple select)"){
                        $validation[] =  ['field' => $value['slug'].'[]','label' =>ucfirst($value['name']),'rules' => $value['validate_attr']];
                    }else{
                    $validation[] = 
                        ['field' => $value['slug'],'label' =>ucfirst($value['name']),'rules' => $value['validate_attr']];
                    }

                }
        }
        $this->form_validation->set_rules($validation);
        if($this->form_validation->run() == false){
            $response['status'] = false;
            $response['validation']= validation_errors();
            echo json_encode($response);
        }
        else{
            if(isset($_FILES['image'])&&$_FILES['image']['name']!=''){
                $config['upload_path'] = FCPATH . 'uploads/admins/';
                $config['file_name'] = time().'_'.$_FILES['image']['name'];
                $config['overwrite'] = TRUE;
                $config["allowed_types"] = 'jpg|jpeg|png|gif';
                $this->load->library('upload', $config);
                if(!$this->upload->do_upload('image')){
                            $this->session->set_flashdata('error', $this->upload->display_errors());
                    $this->load->view('admin/profile',$this->data);
                }
                else{
                    $upload_data = $this->upload->data();
                    $_POST['image'] = $upload_data['file_name'];
                    $_POST['image_flag'] = '0';
                }  
            }
            unset($_POST['email']);
            $_POST['birthdate'] = $_POST['birthdate']==''?null:$_POST['birthdate'];
              foreach ($module['record'] as $key => $value) {
                $d[$value['slug']] = $_POST[$value['slug']];
                unset($_POST[$value['slug']]);
             }
            $_POST['module'] = json_encode($d);
            $response = $this->admin->update($this->session->userdata('admin_id'),$_POST);
            if($response['status']===true){
                $this->session->set_flashdata('success', $response['message']);
                $response['status'] = true;

                echo json_encode($response);
            }
            else{
                $this->session->set_flashdata('error', $response['message']);
                $response['status'] = false;
                unset($response['validation']);
                $response['validation'] = $response['message'];
                unset($response['message']);
                echo json_encode($response);
            }
        }
    }

    public function change_password(){
  
        $this->load->view('admin/change_password',$this->data);
    }

    public function update_password(){
        $id =  $this->session->userdata('admin_id');
       
        $validation = [
                ['field' => 'current_password','label' => 'Current Password','rules' => 'required|xss_clean'],
                ['field' => 'password','label' => 'New Password','rules' => 'required|min_length[4]|xss_clean'],
                ['field' => 'confirm_password','label' => 'Confirm Password','rules' => 'required|matches[password]'],
            ];
        $this->form_validation->set_rules($validation);
        if($this->form_validation->run() == false){
            $this->load->view('admin/change_password',$this->data);
        }
        else{
            unset($_POST['confirm_password']);
            $_POST['current_password'] = md5($_POST['current_password']);
            $_POST['password'] = md5($_POST['password']);
            $response = $this->admin->update_password($this->session->userdata('admin_id'),$_POST);
            if($response['status']===true){
                $this->session->set_flashdata('success', $response['message']);
                redirect(base_url('admin/admin/change_password'));
            }
            else{
                $this->session->set_flashdata('error', $response['message']);
                $this->load->view('admin/change_password',$this->data);
            }
        }
    }
    /**
    Bulk sms balance check
    */
    public function balance_check()
    {
        // code...
    }
    /**
    @param void
    @return void
    */
	public function signout(){

		$this->session->unset_userdata('admin_id');
		redirect(base_url('admin/signin'));
	}

   public function logout(){
        // Reset OAuth access token
        $this->googleplus->revokeToken($this->session->userdata('access_token'));
        // Remove local Facebook session
        $this->facebook->destroy_session();
        // Remove token and user data from the session
        $this->session->unset_userdata('admin_id');
        // Destroy entire session data
        $this->session->sess_destroy();
        
        // Redirect to login page
        redirect(base_url('admin/signin'));
   }
}
