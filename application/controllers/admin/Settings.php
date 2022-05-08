<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {
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
        if($response['status']===true){
            $users = $this->load->model('admin/User_Model','user');
            $settings = $this->load->model('admin/Settings_Model','settings');
	        $response['settings'] = $this->settings->get();
            $this->data['admin'] = $response['record'];
            $role = $this->load->model('admin/RolePermission_Model','role');
            $this->data['userrole']= $this->role->edit($this->data['admin']['role']);
            $action = $this->uri->segment(3);
            $this->page = 'setting';
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
        $this->data['settings'] = $this->settings->get();
        $this->load->view('admin/Settings/form',$this->data);
    }


    /**
    @param void
    @return void
    */

     public function create(){
        chkaccess($this->data,$this->page,'view');
	$this->data['settings'] = $this->settings->get();
        $this->load->view('admin/Settings/form',$this->data);
    }
    

        /**
    @param void
    @return void
    */
    public function store(){
        chkaccess($this->data,$this->page,'edit');
        if($this->data['userrole']['record']['permissions']['setting']['edit'] !== true){
            redirect(base_url('admin/settings/create'));
        }
       
  
        $validation = [
                ['field' => 'footer_text','label' => 'Footer text','rules' => 'trim|required|xss_clean'],
            ];
        $this->form_validation->set_rules($validation);

        if($this->form_validation->run() == false){
            $this->load->view('admin/Settings/form',$this->data);
        }
        else{


            if(isset($_FILES['logo'])&&$_FILES['logo']['name']!=''){
                $config['upload_path'] = FCPATH . 'uploads/images/';
                $config['file_name'] = time().'_'.$_FILES['logo']['name'];
                $config['overwrite'] = TRUE;
                $config["allowed_types"] = 'jpg|jpeg|png|gif';
                $this->load->library('upload', $config);
                if(!$this->upload->do_upload('logo')){
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    $this->load->view('admin/Settings/form',$this->data);
                }
                else{
                    $upload_data = $this->upload->data();
                    $_POST['logo'] = $upload_data['file_name'];
                }
            }

            if(isset($_FILES['favicon'])&&$_FILES['favicon']['name']!=''){
                $config2['upload_path'] = FCPATH . 'uploads/images/';
                $config2['file_name'] = time().'_'.$_FILES['favicon']['name'];
                $config2['overwrite'] = TRUE;
                $config2["allowed_types"] = 'jpg|jpeg|png|gif|ico';
                $this->load->library('upload', $config2);
                $this->upload->initialize($config2);
                if(!$this->upload->do_upload('favicon')){
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    $this->load->view('admin/Settings/form',$this->data);
                }
                else{
                    $upload_data = $this->upload->data();
                    $_POST['favicon'] = $upload_data['file_name'];
                }
            }
            $response = $this->settings->store($_POST);
            
            if($response['status']===true){
                $this->session->set_flashdata('success', $response['message']);
                redirect(base_url('admin/Settings'));
            }
            else{
                $this->session->set_flashdata('error', $response['message']);
                $this->load->view('admin/Settings/form',$this->data);
            }
        }
    }

    public function edit($id){
        chkaccess($this->data,$this->page,'edit');
        $this->data['id'] = $id;
        $this->data['user'] = $this->user->edit($id);
        $this->load->view('admin/Settings/form',$this->data);
    }

    public function update($id){
        echo $id; 
        exit();
        $this->data['id'] = $id;
        $validation = [
                ['field' => 'footer_text','label' => 'Footer text','rules' => 'trim|required|xss_clean'],
            ];
        $this->form_validation->set_rules($validation);
        if($this->form_validation->run() == false){
            $this->load->view('admin/Settings/form',$this->data);
        }
        else{
         if(isset($_FILES['logo'])&&$_FILES['logo']['name']!=''){
                $config['upload_path'] = FCPATH . 'uploads/images/';
                $config['file_name'] = time().'_'.$_FILES['logo']['name'];
                $config['overwrite'] = TRUE;
                $config["allowed_types"] = 'jpg|jpeg|png|gif';
                $this->load->library('upload', $config);
                if(!$this->upload->do_upload('logo')){
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    $this->load->view('admin/Settings',$this->data);
                }
                else{
                    $_POST['logo'] = $config['file_name'];
                }  
            }

            if(isset($_FILES['favicon'])&&$_FILES['favicon']['name']!=''){
                $config['upload_path'] = FCPATH . 'uploads/images/';
                $config['file_name'] = time().'_'.$_FILES['favicon']['name'];
                $config['overwrite'] = TRUE;
                $config["allowed_types"] = 'jpg|jpeg|png|gif';
                $this->load->library('upload', $config);
                if(!$this->upload->do_upload('favicon')){
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    $this->load->view('admin/Settings',$this->data);
                }
                else{
                    $_POST['favicon'] = $config['file_name'];
                }  
            }
            $response = $this->settings->update($id,$_POST);
            if($response['status']===true){
                $this->session->set_flashdata('success', $response['message']);
                redirect(base_url('admin/Settings'));
            }
            else{
                $this->session->set_flashdata('error', $response['message']);
                $this->load->view('admin/Settings/form',$this->data);
            }
        }
    }

    public function destroy($id){
        chkaccess($this->data,$this->page,'delete');
        $this->settings->destroy($id);
        $this->session->set_flashdata('success', $response['message']);
        redirect(base_url('admin/Settings'));
    }

    public function status($id,$status){
        $this->settings->status($id,$status);
        $this->session->set_flashdata('success', $response['message']);
        redirect(base_url('admin/Settings'));
    }
}
