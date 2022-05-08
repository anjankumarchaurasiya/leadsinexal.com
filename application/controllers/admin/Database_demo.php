<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Database_demo extends CI_Controller {
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
       
        $this->load->library('excel');
        $this->load->library('email');
        $this->load->model('admin/Admin_Model','admin');
        $this->load->model('admin/User_Model','usermodel');
        $response = $this->admin->edit($this->session->userdata('admin_id'));
        $this->load->model('admin/Category_Model','category');
        $this->load->model('admin/Exal_Model','exal');
        $this->load->model('admin/Database_demo_model','dbdemomodel');
        $settings =$this->load->model('admin/Settings_Model','settings');
       $settings = $this->load->model('admin/RolePermission_Model','rolepermission');
       $this->data['settings'] = $this->settings->get();
        if($response['status']===true){
             $this->data['admin'] = $response['record'];
            $this->data['userrole']= $this->rolepermission->edit($this->data['admin']['role']);
            $this->page = 'database_demo';
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
              
        chkaccess($this->data,$this->page,'view');
        $this->data['demodb'] = $this->dbdemomodel->get();
        $this->load->view('admin/databaseDemo/list',$this->data);
    }
    
    public function create(){
        chkaccess($this->data,$this->page,'create');
        // $this->data['user'] = $this->usermodel->getUserRoleWise(3);
         if(getrole_id() == 1){
            $this->data['exal'] = $this->exal->get();  
        }else{
            $this->data['exal'] = $this->exal->get_for_demodb();
        }
        $this->load->view('admin/databaseDemo/form',$this->data);
    }

    /**
    @param void
    @return void
    */
    public function store(){
        chkaccess($this->data,$this->page,'create');
        $validation = [
            ['field' => 'name','label' => 'Name','rules' => 'trim|required|xss_clean|is_unique[demodatabase_user.name]'],
            ['field' => 'email','label' => 'Email','rules' => 'trim|required|valid_email|xss_clean|is_unique[demodatabase_user.email]'],
            ['field' => 'mobile','label' => 'Mobile','rules' => 'trim|required|xss_clean|is_unique[demodatabase_user.mobile]'],
            ['field' => 'remark','label' => 'Remark','rules' => 'trim|required|xss_clean'],
            ['field' => 'exal_id','label' => 'Exal','rules' => 'trim|required|xss_clean|is_natural_no_zero'],
            ['field' => 'check_no_of_data','label' => 'Check no of data','rules' => 'trim|required|xss_clean|is_natural_no_zero'],
            ['field' => 'link_expire_duration','label' => 'Expiry duration','rules' => 'trim|required|xss_clean'],
            ['field' => 'otp_type','label' => 'Otp type','rules' => 'trim|required|xss_clean'],
            ];
        $this->form_validation->set_rules($validation);
        if($this->form_validation->run() == false){
            $this->data['exal'] = $this->exal->get();
            $this->load->view('admin/databaseDemo/form',$this->data);
        }else{
 
            $temp_user_data['name'] = $_POST['name'];
            $temp_user_data['email'] = $_POST['email'];
            $temp_user_data['mobile'] = $_POST['mobile'];
            $temp_user_data['remark'] = $_POST['remark'];
            $this->db->insert('demodatabase_user',$temp_user_data);

            $storedata['user_id'] = $this->db->insert_id();
            $storedata['exal_id'] = $_POST['exal_id'];
            $storedata['check_no_of_data'] = $_POST['check_no_of_data'];
            $storedata['link_expire_duration'] = strtotime($_POST['link_expire_duration']);
            $storedata['demourl'] = $this->keygen();
            $storedata['otp_type'] = $_POST['otp_type'];
            $storedata['created_by'] = $this->session->userdata('admin_id');

            $this->dbdemomodel->store($storedata);
            $lastdbdemoid=$this->db->insert_id();
            $this->demodatabase_sendemail($storedata['user_id'],$storedata['demourl'],$storedata['link_expire_duration']);
            if($this->db->affected_rows() > 0){

               
                 $this->session->set_flashdata('success', 'Demo database created successfully');
            }
            else{
                 $this->session->set_flashdata('error', 'Somthing is wrong');
            
            } 
            redirect(base_url('admin/database_demo'));
        }
    }    
    public function destroy($id){
        chkaccess($this->data,$this->page,'delete');   
        $response = $this->dbdemomodel->destroy(base64_decode($id));
        $status = $response['status']===true?'success':'error';
        $this->session->set_flashdata($status, $response['message']);
        redirect(base_url('admin/database_demo'));
    }

    /**
     * 
     * Generate a unique url
    */
    public function keygen()
    {
        $chars = "abcdefghijklmnopqrstuvwxyz";
        $chars .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $chars .= "0123456789";
        while (1) {
            $key = '';
            srand((double) microtime() * 1000000);
            for ($i = 0; $i < 8; $i++) {
                $key .= substr($chars, (rand() % (strlen($chars))), 1);
            }
            break;
        }
        $checkip = array(
            '127.0.0.1',
            '::1'
        );

        if(in_array($_SERVER['REMOTE_ADDR'], $checkip)){
           return 'http://localhost/leadinexaldemo/demodb/'.$key.strtotime("now"); 
        }else{
            $livedemodburl = 'https://leadsinexcel.com/demodatabase';
            return $livedemodburl.'/demodb/'.$key.strtotime("now"); 
        }
        
    }
    public function demodatabase_sendemail($userid,$demourl,$duration)
    {
        $userinfo = $this->db->select('*')->from('demodatabase_user')->where('id',$userid)->get()->row_array();
        if($userinfo)
        {
           
            $expireduration = date('d-m-Y H:i A',$duration);

            $config = array(

              'protocol'  => SMTP_PROTOCOL,
              'smtp_host' => SMTP_HOST,
              'smtp_port' => SMTP_PORT,
              'smtp_user' => SMTP_USER,
              'smtp_pass' => SMTP_PASSWORD,
              'mailtype'  => SMTP_MAILTYPE,
              'charset'   => SMTP_CHARSET
            );
            $this->load->library('email', $config);
            $this->email->set_mailtype("html");
            $this->email->set_newline("\r\n");

            $expireduration = date('d.m.Y H:i A',$duration);
            $message = '<!DOCTYPE html>
            <html lang="en-US">
                <head>
                    <title>Demo database account</title>
                    <meta charset="utf-8">
                </head>
                <body>
                    <div>
                        <p><b>Hello '.$userinfo['firstname'].'</b>,</p>
                        <p>Hope you are doing well</p>

                        Created a demo database account for you <a href="'.$demourl.'"><b>URL</b></a><br/>
                        This link will expire at '.$expireduration.'
                    </div>
                    <footer>
                    <p>Thank you,</p>
                    <a href="https://leadsinexcel.com/">leadsinexcel.com</a>
                    </footer>
                </body>
            </html>';
          $this->email->to($userinfo['email']);
          $this->email->from(SMTP_SEND_FROM,SMTP_SEND_FROM_NAME);
          $this->email->subject('Demo database account');
          $this->email->message($message);
          $this->email->send();
          
        }
        
    }
     
}
