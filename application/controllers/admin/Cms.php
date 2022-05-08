<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cms extends CI_Controller {
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
	     $settings = $this->load->model('admin/Cms_Model','cms');
	     $this->data['settings'] = $this->settings->get();
        if($response['status']===true){
	
            $users = $this->load->model('admin/User_Model','user');
            $this->data['admin'] = $response['record'];
            $role = $this->load->model('admin/RolePermission_Model','role');
            $this->data['userrole']= $this->role->edit($this->data['admin']['role']); 
            $this->page = 'cms';
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

        $this->data['users'] = $this->cms->get();
        $this->load->view('admin/cms/list',$this->data);
    }

    public function create(){
        chkaccess($this->data,$this->page,'create');
        $this->load->view('admin/cms/form',$this->data);
    }

    /**
    @param void
    @return void
    */
    public function store(){
        chkaccess($this->data,$this->page,'create');
        $validation = [
                ['field' => 'title','label' => 'Title','rules' => 'trim|required|xss_clean'],
                ['field' => 'content','label' => 'Content','rules' => 'required'],
            ];
        $this->form_validation->set_rules($validation);
        if($this->form_validation->run() == false){
            $this->load->view('admin/cms/form',$this->data);
        }
        else{
            unset($_POST['files']);
            $_POST['slug'] = url_title($_POST['title'], 'dash', true);
            $response = $this->cms->store($_POST);
            if($response['status']===true){
                $this->session->set_flashdata('success', $response['message']);
                redirect(base_url('admin/cms'));
            }
            else{
                $this->session->set_flashdata('error', $response['message']);
                $this->load->view('admin/cms');
            }
        }
    }

    public function edit($id){
        chkaccess($this->data,$this->page,'edit');
        $this->data['id'] = $id;
        $this->data['user'] = $this->cms->edit($id);
        if($this->data['user']['status']===false){
            redirect(base_url('admin/cms'));
        }
        $this->load->view('admin/cms/form',$this->data);
    }

    public function update($id){
        $this->data['id'] = $id;
        $validation = [
                ['field' => 'title','label' => 'Title','rules' => 'trim|required|xss_clean'],
                ['field' => 'content','label' => 'Content','rules' => 'trim|required'],
            ];
        $this->form_validation->set_rules($validation);
        if($this->form_validation->run() == false){
            $this->load->view('admin/cms/form',$this->data);
        }
        else{
            unset($_POST['files']);
            $_POST['slug'] = url_title($_POST['title'], 'dash', true);
            $response = $this->cms->update($id,$_POST);
            if($response['status']===true){
                $this->session->set_flashdata('success', $response['message']);
                redirect(base_url('admin/cms'));
            }
            else{
                $this->session->set_flashdata('error', $response['message']);
                $this->load->view('admin/cms/form',$this->data);
            }
        }
    }

    public function destroy(){
        chkaccess($this->data,$this->page,'delete');
         
         $data = $this->input->post('data');
        foreach ($data as $key => $value) {

            $response = $this->cms->destroy($value);
        }
    
        $message = $this->session->set_flashdata($status, $response['message']);
        echo $response;
    }

    public function preview($slug){
        $this->data['cms'] = $this->cms->preview($slug);
        $this->load->view('admin/cms/preview',$this->data);
    }
}
