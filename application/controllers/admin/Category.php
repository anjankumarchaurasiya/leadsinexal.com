<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {
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
        $this->load->model('admin/Category_Model','category');
        $settings =$this->load->model('admin/Settings_Model','settings');
	    $settings = $this->load->model('admin/RolePermission_Model','rolepermission');
	    $this->data['settings'] = $this->settings->get();
        if($response['status']===true){
             $this->data['admin'] = $response['record'];
            $this->data['userrole']= $this->rolepermission->edit($this->data['admin']['role']);
            $this->page = 'category';
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
        $this->data['category'] = $this->category->get();

        $this->load->view('admin/category/list',$this->data);
    }

    public function create(){
        chkaccess($this->data,$this->page,'create');
        $this->load->view('admin/category/form',$this->data);
    }

    /**
    @param void
    @return void
    */
    public function store(){
        chkaccess($this->data,$this->page,'create');

        $validation = [
                ['field' => 'name','label' => 'Name','rules' => 'trim|required|xss_clean|is_unique[category.name]','errors'=>['is_unique'=>'The %s is already taken']],
            ];
        $this->form_validation->set_rules($validation);
        if($this->form_validation->run() == false){
            $this->load->view('admin/category/form',$this->data);
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
            
           
            $response = $this->category->store($_POST);
             
            if($response['status']===true){
                $this->session->set_flashdata('success', $response['message']);
                redirect(base_url('admin/category'),'refresh');
            }
            else{
                $this->session->set_flashdata('error', $response['message']);
                $this->load->view('admin/category/form');
            }
        }
    }

    public function edit($id){
        chkaccess($this->data,$this->page,'edit');

        $this->data['id'] = $id;
        $this->data['category'] = $this->category->edit($id);
        // echo '<pre>';
        // print_r($this->data);
        // die();
        if($this->data['rolepermission']['status']===false){
            redirect(base_url('admin/category'));
        }
        $this->load->view('admin/category/form',$this->data);
    }

    public function update($id){

        $this->data['id'] = $id;
        $this->data['category'] = $this->category->edit($id);

        $validation = [
                ['field' => 'name','label' => 'Name','rules' => 'trim|required|xss_clean','errors'=>['is_unique'=>'The %s is already taken']],
            ];
        $this->form_validation->set_rules($validation);
        if($this->form_validation->run() == false){
            $this->load->view('admin/category/form',$this->data);
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
          

            $response = $this->category->update($id,$_POST);
    

            if($response['status']===true){
                $this->session->set_flashdata('success', $response['message']);
                redirect(base_url('admin/category'));
            }
            else{
                $this->session->set_flashdata('error', $response['message']);
                $this->load->view('admin/category/form',$this->data);
            }
        }
    }

    
    public function destroy($id){
        
        chkaccess($this->data,$this->page,'delete');   

        $exalnorows=$this->db->get_where('exal',['category_id'=>$id])->num_rows();

        if($exalnorows > 0){
            $this->session->set_flashdata('error', 'You can not delete this category, first delete exal.');
            redirect(base_url('admin/category'));
        }

        $response = $this->category->destroy($id);
        $status = $response['status']===true?'success':'error';
        $this->session->set_flashdata($status, $response['message']);
        redirect(base_url('admin/category'));
    }

}
