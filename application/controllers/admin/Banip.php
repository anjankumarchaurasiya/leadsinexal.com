<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banip extends CI_Controller {
    private $data;
  
    function __construct(){
        parent::__construct();
        if(!$this->session->userdata('admin_id')){
            redirect(base_url('admin/signin'));
        }
         
        $this->load->library('csvimport');
        
        $this->load->model('admin/Admin_Model','admin');
        $response = $this->admin->edit($this->session->userdata('admin_id'));

        $settings = $this->load->model('admin/Settings_Model','settings');
	      $role = $this->load->model('admin/RolePermission_Model','role');

	      $this->data['settings'] = $this->settings->get();

        if($response['status']===true){
            $users = $this->load->model('admin/User_Model','user');
            $banip = $this->load->model('admin/Banip_Model','banip');
            $this->data['admin'] = $response['record'];
            $role = $this->load->model('admin/RolePermission_Model','role');
            $this->data['userrole']= $this->role->edit($this->data['admin']['role']);
            $this->page = 'users';
             
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
        $this->data['users'] = $this->banip->get();
        $this->load->view('admin/banip/list',$this->data);
    }

    public function create(){
        chkaccess($this->data,$this->page,'view');
        $this->data['users'] = $this->user->get();
        $this->load->view('admin/banip/form',$this->data);
    }

    /**
    @param void
    @return void
    */
    public function store(){
        chkaccess($this->data,$this->page,'create');
        $validation = [
                ['field' => 'IP','label' => 'banIP','rules' => 'trim|required|valid_ip|is_unique[ban_ip.IP]','errors'=>['is_unique'=>'The %s is already taken']],
            ];

        $this->form_validation->set_rules($validation);
        if($this->form_validation->run() == false){
            $this->load->view('admin/banip/form',$this->data);
        }
        else{
            $response = $this->banip->store($_POST);
            if($response['status']===true){
                $this->session->set_flashdata('success', $response['message']);
                redirect(base_url('admin/banip'));
            }
            else{
                $this->session->set_flashdata('error', $response['message']);
                $this->load->view('admin/banip');
            }
        }
    }

    public function edit($id){
        chkaccess($this->data,$this->page,'edit');
        $this->data['id'] = $id;
        $this->data['user'] = $this->banip->edit($id);
        $this->data['role'] = $this->role->get();
        if($this->data['user']['status']===false){
            redirect(base_url('admin/banip'));
        }
        $this->load->view('admin/banip/form',$this->data);
    }

    public function update($id){
        
        $this->data['id'] = $id;
        $this->data['role'] = $this->role->get();
        $validation = [
                ['field' => 'value','label' => 'banIP','rules' => 'trim|required|valid_ip'],
            ];
        $this->form_validation->set_rules($validation);
        if($this->form_validation->run() == false){
            $this->load->view('admin/banip/form',$this->data);
        }
        else{
            $_POST = ["IP"=>$_POST['value']];
            $response = $this->banip->update($id,$_POST);
            if($response['status']===true){
                return $this->session->set_flashdata('success', $response['message']);
                redirect(base_url('admin/banip'));
            }
            else{
                return $this->session->set_flashdata('error', $response['message']);
                $this->load->view('admin/banip/form',$this->data);
            }
        }
    }

    public function destroy(){
        chkaccess($this->data,$this->page,'delete');
        $data = $this->input->post('data');
        foreach ($data as $key => $value) {
            $response = $this->banip->destroy($value);
        }
        $message = $this->session->set_flashdata('success', $response['message']);
        return $response;
    }

    public function status($id,$status){
        $response = $this->user->status($id,$status);
        $this->session->set_flashdata('success', $response['message']);
        redirect(base_url('admin/user'));
    }

     public function exportCSV(){ 
           // file name 
      
           $filename = 'users_'.date('Ymd').'.csv'; 
           header("Content-Description: File Transfer"); 
           header("Content-Disposition: attachment; filename=$filename"); 
           header("Content-Type: application/csv; ");
           
           // get data 

           $usersData = $this->user->getheaders();

           // file creation 
           $file = fopen('php://output', 'w');
         
           $header = array("Firstname","Lastname","Username","Email","Date of Birth(Y-mm-dd)"); 
           fputcsv($file, $header);
           foreach ($usersData as $key=>$line){ 
             fputcsv($file,$line); 
           }
           fclose($file); 
           exit; 
    }

    public function ShowimportCsv(){
         $this->load->view('admin/users/importfile',$this->data);
    }

    public function importCSV(){
          $file_data = $this->csvimport->get_array($_FILES["csv_file"]["tmp_name"]);
          foreach($file_data as $row)
          {

            if(!isset($row["Firstname"]) || !isset($row["Lastname"]) || !isset($row["Username"]) || !isset($row["Email"]) || !isset($row["Date of Birth(Y-mm-dd)"])  || !isset($row["Password"])){  
                 $this->session->set_flashdata('error', 'Invalid Format.');

                redirect(base_url('admin/user/ShowimportCsv'));
            }
            $password = md5($row["Password"]);
            
            $data = array(
                'firstname' => $row["Firstname"],
                'lastname'  => $row["Lastname"],
                'username'  => $row["Username"],
                'email'   => $row["Email"],
                'birthdate'   => $row["Date of Birth(Y-mm-dd)"],
                'password'   =>  $password,
                'role'   =>  '3',
            );

           $response = $this->user->checkduplicate($data);
            if($response['status']===true){
                $this->user->update($response['records']['id'],$data);
            }else{

             $this->user->store($data);
            }
          }
          $this->session->set_flashdata('success', 'Your file is successfully imported.');
         redirect(base_url('admin/user'));
     
    }

    public function exportCSVformat(){
          $filename = 'csv_formate_'.date('Ymd').'.csv'; 
           header("Content-Description: File Transfer"); 
           header("Content-Disposition: attachment; filename=$filename"); 
           header("Content-Type: application/csv; ");
               
           // file creation 
           $file = fopen('php://output', 'w');
         
           $header = array("Firstname","Lastname","Username","Password","Email","Date of Birth(Y-mm-dd)"); 
           fputcsv($file, $header);
          
           fclose($file); 
           exit; 
    }



    
}
