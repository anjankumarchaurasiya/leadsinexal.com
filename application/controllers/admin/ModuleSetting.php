<?php
defined('BASEPATH') OR exit('No direct script access allowed');
define ("ATTRIBUTE", serialize (array("text(short field)","radio(select one)","email","select(dropdown)","checkbox(multiple select)","number","url","textarea(long field)")));
define ("VALIDATION", serialize (array("required","trim","xss_clean","min_length","max_length")));
class ModuleSetting extends CI_Controller {
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
        $cms = $this->load->model('admin/Cms_Model','cms');
	    $module_setting = $this->load->model('admin/ModuleSetting_Model','module_setting');
	    $this->data['settings'] = $this->settings->get();
        if($response['status']===true){
	
            $users = $this->load->model('admin/User_Model','user');
            $this->data['admin'] = $response['record'];
            $role = $this->load->model('admin/RolePermission_Model','role');
            $this->data['userrole']= $this->role->edit($this->data['admin']['role']); 
            $this->page = 'module';
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
            chkaccess($this->data,$this->page,'view');
       $this->data['module'] = $this->module_setting->get();
        $this->load->view('admin/module_setting/list',$this->data);
    }

    public function create(){
        chkaccess($this->data,$this->page,'create');
        $this->data['attribute'] = unserialize (ATTRIBUTE);
        $this->data['validate_attr'] = unserialize (VALIDATION);
        $this->data['roles']=$this->db->get('roles')->result_array();
        $this->load->view('admin/module_setting/form',$this->data);
    }

    /**
    @param void
    @return void
    */
    public function store(){
        chkaccess($this->data,$this->page,'create');
        $this->data['attribute'] = unserialize (ATTRIBUTE);
        $this->data['validate_attr'] = unserialize (VALIDATION);
        $validation = [
                ['field' => 'name','label' => 'name','rules' => 'trim|required|xss_clean|is_unique[module_settings.name]','errors'=>['is_unique'=>'The %s is already taken']],
                ['field' => 'type','label' => 'type','rules' => 'required'],
                ['field' => 'role_id','label' => 'type','rules' => 'required'],
                ['field' => 'validate[]','label' => 'validate','rules' => 'required'],
            ];
        if($this->input->post('type') == 'radio(select one)' || $this->input->post('type') == 'select(dropdown)' || $this->input->post('type') == 'checkbox(multiple select)'){
                array_push($validation,['field' => 'attributevalue','label' => 'attributevalue','rules' => 'required|callback_checkvalue']);

            }
        if(isset($_POST['validate']) ){
            if(in_array("max_length",$_POST['validate'])){
                array_push($validation,['field' => 'maximum','label' => 'maximum','rules' => 'required']);
            }
            if(in_array("min_length",$_POST['validate'])){
                array_push($validation,['field' => 'minimum','label' => 'minimum','rules' => 'required']);    
            }
        }
        $this->form_validation->set_rules($validation);
        if($this->form_validation->run() == false){
            $this->load->view('admin/module_setting/form',$this->data);
        }
        else{
            if((in_array("max_length",$_POST['validate']) && in_array("min_length",$_POST['validate'])) && $_POST['maximum'] < $_POST['minimum']) {
              
                    $this->session->set_flashdata('error', 'Maximum nuber should be greter than minimum number');

                    $this->load->view('admin/module_setting/form',$this->data);
                    unset($this->session->userdata['error']);

            }else{
                foreach ($_POST['validate'] as $key => $value) {
                
                    if($value == "max_length"){
                        $_POST['validate'][$key] =  'max_length['.$_POST['maximum'].']';
                    }elseif($value == "min_length"){
                    $_POST['validate'][$key] =  'min_length['.$_POST['minimum'].']';
                    }
                }
        
                $_POST['slug'] = url_title($_POST['name'], '_', true);
                // $_POST['page'] = 'user';
                if(empty($_POST['attributevalue'])){
                    $_POST['data'] = NULL;
                }else{
                    
                    $data = array('attributevalue'=>explode(",", $_POST['attributevalue']));
                    $_POST['data'] = json_encode($data);
                }
                unset($_POST['attributevalue']);
                unset($_POST['maximum']);
                unset($_POST['minimum']);
                $_POST['validate_attr'] = json_encode(array('rules'=> $_POST['validate']));
                unset($_POST['validate']);
                
                $response = $this->module_setting->store($_POST);
                // echo "<pre>";
                // print_r($_POST);
                // die();
                if($response['status']===true){
                    $this->session->set_flashdata('success', $response['message']);
                    redirect(base_url('admin/ModuleSetting'));
                    $this->dbforge->add_field($fields);
                }
                else{
                    $this->session->set_flashdata('error', $response['message']);
                    redirect(base_url('admin/ModuleSetting'));

                }
        }
        }
    }

    public function edit($id){
        chkaccess($this->data,$this->page,'edit');
          $this->data['roles']=$this->db->get('roles')->result_array();
        $this->data['attribute'] = unserialize (ATTRIBUTE);
         $this->data['validate_attr'] = unserialize (VALIDATION);
        $this->data['id'] = $id;
        $this->data['user'] = $this->module_setting->edit($id);
       
         $this->data['user']['record']['validate_attr'] = json_decode($this->data['user']['record']['validate_attr'],true);
        if($this->data['user']['record']['type'] == 'radio(select one)' || $this->data['user']['record']['type'] == 'checkbox(multiple select)' || $this->data['user']['record']['type'] == 'select(dropdown)'){
            if(!empty($this->data['user']['record']['data'])){
            $this->data['user']['record']['data'] = json_decode($this->data['user']['record']['data'],true);
            $this->data['user']['record']['data'] = implode(",", $this->data['user']['record']['data']['attributevalue']);
        }
        }
        $k = $this->data['user']['record']['validate_attr']['rules'];
        if(!empty($k) && isset($k)){
        foreach ($k as $key => $value) {
            $myArray[] = explode('[', $value);

            $a[] = $myArray[$key]['0'];
            if(in_array("max_length", $myArray[$key])){
                $number = explode(']', $myArray[$key]['1']);
                $this->data['user']['maximum'] = $number['0'];
            }
            if(in_array("min_length", $myArray[$key])){
                $number = explode(']', $myArray[$key]['1']);
                $this->data['user']['minimum'] = $number['0'];
            }
        }
        $this->data['user']['record']['validate_attr']['rules'] = $a;
    }
        if($this->data['user']['status']===false){
            redirect(base_url('admin/ModuleSetting'));
        }
        // echo '<pre>';
        // print_r($this->data);
        // die();
        $this->load->view('admin/module_setting/form',$this->data);
    }

    public function update($id){
        chkaccess($this->data,$this->page,'edit');
        $this->data['id'] = $id;
        $this->data['attribute'] = unserialize (ATTRIBUTE);
        $this->data['validate_attr'] = unserialize (VALIDATION);
        $validation = [
                ['field' => 'name','label' => 'name','rules' => 'required|trim|xss_clean'],
                ['field' => 'type','label' => 'type','rules' => 'required'],
                ['field' => 'role_id','label' => 'type','rules' => 'required'],

                ['field' => 'validate[]','label' => 'validate','rules' => 'required'],
            ];
        if($this->input->post('type') == 'radio(select one)' || $this->input->post('type') == 'select(dropdown)' || $this->input->post('type') == 'checkbox(multiple select)'){
            array_push($validation,['field' => 'attributevalue','label' => 'attributevalue','rules' => 'required|callback_checkvalue']);

        }
        if(isset($_POST['validate']) ){
            if(in_array("max_length",$_POST['validate'])){
                array_push($validation,['field' => 'maximum','label' => 'maximum','rules' => 'required']);
            }
            if(in_array("min_length",$_POST['validate'])){
                array_push($validation,['field' => 'minimum','label' => 'minimum','rules' => 'required']);    
            }
        }
        $this->form_validation->set_rules($validation);
        if($this->form_validation->run() == false){
            $this->load->view('admin/module_setting/form',$this->data);
        }
        else{
            if((in_array("max_length",$_POST['validate']) && in_array("min_length",$_POST['validate'])) && $_POST['maximum'] < $_POST['minimum']) {
              
                    $this->session->set_flashdata('error', 'Maximum nuber should be greter than minimum number');

                    $this->load->view('admin/module_setting/form',$this->data);
                    unset($this->session->userdata['error']);

            }else{
                foreach ($_POST['validate'] as $key => $value) {
                   
                    if($value == "max_length"){
                        $_POST['validate'][$key] =  'max_length['.$_POST['maximum'].']';
                    }elseif($value == "min_length"){
                       $_POST['validate'][$key] =  'min_length['.$_POST['minimum'].']';
                    }
                }
                $_POST['slug'] = url_title($_POST['name'], '_', true);
                $_POST['role_id'] = $this->input->post('role_id');
                if(!empty($_POST['attributevalue'])){
          
                    $data = array('attributevalue'=>explode(",",$_POST['attributevalue']));
                
                    $_POST['data'] = json_encode($data);
                }else{
                    unset($_POST['data']);
                }
                unset($_POST['attributevalue']);
                unset($_POST['maximum']);
                unset($_POST['minimum']);
                $_POST['validate_attr'] = json_encode(array('rules'=> $_POST['validate']));
                unset($_POST['validate']);
                $response = $this->module_setting->update($id,$_POST);
                if($response['status']===true){
                    $this->session->set_flashdata('success', $response['message']);
                    redirect(base_url('admin/ModuleSetting'));

                }
                else{
                    $this->session->set_flashdata('error', $response['message']);
                    $this->load->view('admin/module_setting/form',$this->data);
                }
            }
        }
    }

    public function destroy(){
        chkaccess($this->data,$this->page,'delete');
        $data = $this->input->post('data');
        foreach ($data as $key => $value) {

            $response = $this->module_setting->destroy($value);
        }
    
        $message = $this->session->set_flashdata($status, $response['message']);
        echo $response;
    }


    public function getattribute($user){
        $this->data['page']=$this->module_setting->getattribute($user);
        $this->data['seller']=$this->db->get_where('admins',['role'=>2,'status'=>'1'])->result_array();
        // echo "<pre>";
        // print_r($this->data['seller']);
        // die();
        $this->data['role_id']=$user;
        if($this->data['page']['status'] !== false){
            return $this->load->view('admin/users/formmodel',$this->data);
        }else{
            $this->data['page']['record']=[];
             return $this->load->view('admin/users/formmodel',$this->data);
        }
    }

    public function editattribute($id){
        $user=$this->user->edit($id)['record']['role'];
        
        $this->data['seller']=$this->db->get_where('admins',['role'=>2,'status'=>'1'])->result_array();
       
        $this->data['role_id']=$user;
        $this->data['page']=$this->module_setting->getattribute($user);
        if($id == "user"){
            $id = $this->session->userdata('admin_id');
        }
        $user=$this->user->edit($id)['record']['role'];
       
        if($this->data['page']['status'] !== false){
            $this->data['user'] = $this->user->edit($id);
            $this->data['role'] = $this->role->get();
            if($this->data['user']['status']===false){
                redirect(base_url('admin/user'));
            }
            $this->data['user']['record']['module'] = json_decode($this->data['user']['record']['module'],true);
            return $this->load->view('admin/users/formmodel',$this->data);
        }else{
            return "false";
        }
        
    }

    function checkvalue($str) {
        $a = explode(",", $str);
        foreach ($a as $key => $value) {
            if(!preg_match("/^[A-Za-z\\- \']+$/", $value)){
            $this->form_validation->set_message('checkvalue','The %s is must be a character.');
                return false;
            }
        }
        return true;
    }
}
