<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    private $data;
    /**
    @param void
    @return void
    */
    function __construct(){
        parent::__construct();
        if(!$this->session->userdata('admin_id')){
            redirect(base_url('admin/signin'));
        }
        $this->load->library('csvimport');
        $this->load->model('admin/Admin_Model','admin');
        $response = $this->admin->edit($this->session->userdata('admin_id'));
        $settings = $this->load->model('admin/Settings_Model','settings');
        $module_setting = $this->load->model('admin/ModuleSetting_Model','module_setting');
	    $role = $this->load->model('admin/RolePermission_Model','role');
	    $this->data['settings'] = $this->settings->get();
        if($response['status']===true){
            $users = $this->load->model('admin/User_Model','user');
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
        chkaccess($this->data,$this->page,'view');
        $this->data['users'] = $this->user->get();
        $this->load->view('admin/users/list',$this->data);
    }

    public function create(){
        chkaccess($this->data,$this->page,'create');
        $this->data['module'] = $this->module_setting->get();
        $this->data['role'] = $this->role->get();
        $this->load->view('admin/users/userform',$this->data);
    }
   
    /**
    @param void
    @return void
    */
    public function store(){
        chkaccess($this->data,$this->page,'create');
        $this->data['role'] = $this->role->get();
        $user =$this->input->post('role');
        $module=$this->module_setting->getattribute($user);
        $validation = [
                ['field' => 'firstname','label' => 'First Name','rules' => 'trim|required|xss_clean'],
                ['field' => 'lastname','label' => 'Last Name','rules' => 'trim|required|xss_clean'],
                ['field' => 'username','label' => 'Username','rules' => 'trim|required|xss_clean|is_unique[admins.username]','errors'=>['is_unique'=>'The %s is already taken']],
                ['field' => 'email','label' => 'Email','rules' => 'trim|required|xss_clean|valid_email|is_unique[admins.email]','errors'=>['is_unique'=>'The %s is already taken']],
                ['field' => 'mobile','label' => 'Mobile','rules' => 'trim|required|xss_clean|is_unique[admins.mobile]','errors'=>['is_unique'=>'The %s is already taken']],
                ['field' => 'password','label' => 'Password','rules' => 'required|min_length[4]|xss_clean'],
                ['field' => 'role','label' => 'Role','rules' => 'trim|required|xss_clean|callback_check_sellerid_avl'],
            ];
            if(!empty($module['record'])){
                foreach ($module['record'] as $key => $value) {
                    # code...
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
            $originalpassword=$_POST['password'];
            unset($_POST['confirm_password']);
            $_POST['password'] = md5($_POST['password']);
            $_POST['created_at'] = date('Y-m-d H:i:s');
            if(!empty($module['record'])){
            foreach ($module['record'] as $key => $value) {
                $d[$value['slug']] = $_POST[$value['slug']];
                unset($_POST[$value['slug']]);
             }
            $_POST['module'] = json_encode($d);
            }
            $response = $this->user->store($_POST);
            if($response['status']===true){
                // send email and password to user email
                $this->sendemailtouserinfo($_POST['email'],$originalpassword);
                // -------------------------
                $this->session->set_flashdata('success', $response['message']);
                $response['status'] = true;
                echo json_encode($response);
            }
            else{
                $this->session->set_flashdata('error', $response['message']);
                $response['status'] = false;
                 echo json_encode($response);
            }
        }
    }
    public function sendemailtouserinfo($email,$password)
    {
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

        $htmlContent = '<h4>Welcome</h4></br></br>';
        $htmlContent .= '<b>Dear user,</b></br>';
        $htmlContent .= '<p>Congratulations, Your account has been created and activate now. you can login to your account with the following below credentials.</p></br></br></br>';
        $htmlContent .= '<p><a href="'.$_SERVER['SERVER_NAME'].'">'.$_SERVER['SERVER_NAME'].'</a></p>';
        $htmlContent .= '<p><b>Email</b> : '.$email.'</p>';
        $htmlContent .= '<p><b>Password</b> : '.$password.'</p>';

        $this->email->to($email);
        $this->email->from(SMTP_SEND_FROM,SMTP_SEND_FROM_NAME);
        $this->email->subject('Registration confirmation emails');
        $this->email->message($htmlContent);

        //Send email
        if($this->email->send())
        {
            return true;
        }else{
            return false;
        }
    }
    public function check_sellerid_avl($role) {   

         if($role == 3)
         {
            if($this->input->post('seller_id') == 0 || $this->input->post('seller_id') == "")
            {
                $this->form_validation->set_message('check_sellerid_avl', 'Please select seller');
                $response = false;
            }else{
                $response = true;
            }
         }else{
            $response = true;
         }
         return $response;
    }

    public function edit($id){
        chkaccess($this->data,$this->page,'edit');
        $this->data['id'] = $id;
        $this->data['user'] = $this->user->edit($id);
        $this->data['role'] = $this->role->get();
        if($this->data['user']['status']===false){
            redirect(base_url('admin/user'));
        }
        if(!empty($this->data['user'])){
            $this->data['user']['record']['module'] = json_decode($this->data['user']['record']['module'],true);
        }

        // echo '<pre>';
        // print_r($this->data);
        // die();
        $this->load->view('admin/users/userform',$this->data);
    }

   

    public function update($id){
        $this->data['id'] = $id;
        $this->data['role'] = $this->role->get();
        $user = $this->user->edit($id)['record']['role'];
        $module=$this->module_setting->getattribute($user);
        // echo '<pre>';
        // print_r($module);
        // die();
        $validation = [
                ['field' => 'firstname','label' => 'First Name','rules' => 'trim|required|xss_clean'],
                ['field' => 'lastname','label' => 'Last Name','rules' => 'trim|required|xss_clean'],
                ['field' => 'username','label' => 'Username','rules' => 'trim|required|xss_clean','errors'=>['is_unique'=>'The %s is already taken']],
                ['field' => 'email','label' => 'Email','rules' => 'trim|required|xss_clean|valid_email','errors'=>['is_unique'=>'The %s is already taken']],
                ['field' => 'role','label' => 'role','rules' => 'trim|required|xss_clean'],
                // ['field' => 'role','label' => 'role','rules' => 'required'],
            ];
            if(!empty($module['record'])){
        foreach ($module['record'] as $key => $value) {
            # code...
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
            unset($_POST['confirm_password']);
            if($_POST['password']!=''){
                $_POST['password'] = md5($_POST['password']);
            }
            else{
                unset($_POST['password']);
            }
             if(!empty($module['record'])){
            foreach ($module['record'] as $key => $value) {
                $d[$value['slug']] = $_POST[$value['slug']];
                unset($_POST[$value['slug']]);
             }
            $_POST['module'] = json_encode($d);
         }
            if($id==$this->session->userdata('admin_id')){
                unset($_POST['role']);
            }
            $response = $this->user->update($id,$_POST);
            if($response['status']===true){
                $this->session->set_flashdata('success', $response['message']);
                $response['status'] = true;
                echo json_encode($response);
            }
            else{
                $this->session->set_flashdata('error', $response['message']);
                $response['status'] = false;
                 echo json_encode($response);
            }
        }
    }

    public function destroy(){
        chkaccess($this->data,$this->page,'delete');
        
        $data = $this->input->post('data');
        foreach ($data as $key => $value) {
            $response = $this->user->destroy($value);
        }
        $message = $this->session->set_flashdata('success', $response['message']);
        echo $response;
    }

    public function status($id,$status){
        $response = $this->user->status($id,$status);
        $this->session->set_flashdata('success', $response['message']);
        redirect(base_url('admin/user'));
    }

    public function exportCSV(){ 
    
        set_time_limit(0);
        $filename = 'users_'.date('Y:m:d h:i:s');
        $title = array("Firstname","Lastname","Username","Email","Date of Birth(Y-mm-dd)","Role",'Reseller');
        $fieldlist = $this->user->getfieldlist();
        if(isset($fieldlist)){
        foreach ($fieldlist as $key => $value) {
        $title[] = ucfirst($value['name']);
        }
        }
        $data=$this->user->getheaders();
        // echo '<pre>';
        // print_r($data);
        // die();
        foreach($data as $k=>$v){
            $m = json_decode($v['module'],true);
            if(is_array($m)){
                foreach($m as $k1=>$v1){
                    $data[$k][$k1] = $v1; 
                }
            }
            if(isset($fieldlist)){
                foreach ($fieldlist as $key1 => $value1) {
                   if(!isset($data[$k][$value1['name']])){
                    $data[$k][$value1['name']] = '';
                   }
                }
            }
            unset($data[$k]['module']);
        }
       

        $filename=iconv("UTF-8", "GB2312",$filename);
        header("Content-type:application/octet-stream"); 
        header("Accept-Ranges:bytes"); 
        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:attachment;filename=".$filename.".xls");
        header("Pragma: no-cache"); 
        header("Expires: 0");
         
               //Start exporting xls
         if (!empty($title)){
             foreach ($title as $k => $v) {
                 $title[$k]=iconv("UTF-8", "GB2312",$v);
             }
             $title= implode("\t", $title); 
             echo "$title\n";
         }
        if (!empty($data)){
            foreach($data as $key=>$val){
                foreach ($val as $ck => $cv) {
                 $data[$key][$ck]=mb_convert_encoding($cv, "gb2312","UTF-8");
                } 
               $data[$key]=implode("\t", $data[$key]); 
            }
             echo implode("\n",$data);
        }      
    }
    public function ShowimportCsv(){
         $this->load->view('admin/users/importfile',$this->data);
    }

    public function importCSV(){
          $file_data = $this->csvimport->get_array($_FILES["csv_file"]["tmp_name"]);
          if($_FILES["csv_file"]['tmp_name'] == null){
            $this->session->set_flashdata('error', 'Please Enter File.');

            redirect(base_url('admin/user/ShowimportCsv'));
          }
          foreach($file_data as $k=>$row)
          {

            if(!isset($row["Firstname"]) || !isset($row["Lastname"]) || !isset($row["Username"]) || !isset($row["Email"]) || !isset($row["Date of Birth(Y-mm-dd)"])  || !isset($row["Password"])){  
              
                 $this->session->set_flashdata('error', 'Invalid Format.');

                redirect(base_url('admin/user/ShowimportCsv'));
            }
            $password = md5($row["Password"]);
            
            $usersData = $this->user->getfieldlist();
            foreach ($usersData as $key => $value) {
                if(isset($row[ucfirst($value['name'])])){
                    $a[str_replace(' ', '_', strtolower($value['name']))] = $row[ucfirst($value['name'])];
                }else{
                    $a[str_replace(' ', '_', strtolower($value['name']))] = '';
                }
            }
            $data = array(
                'firstname' => $row["Firstname"],
                'lastname'  => $row["Lastname"],
                'username'  => $row["Username"],
                'email'   => $row["Email"],
                'birthdate'   => $row["Date of Birth(Y-mm-dd)"],
                'password'   =>  $password,
                'role'   =>  '3',
                'module' => json_encode($a),
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
            $usersData = $this->user->getfieldlist();
            foreach ($usersData as $key => $value) {
                $header[] = ucfirst($value['name']);
            }
           fputcsv($file, $header);
          
           fclose($file); 
           exit; 
    }

    
}
