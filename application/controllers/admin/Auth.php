<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
   private $data;
   /**
    @param void
    @return void
    */
   function __construct(){
      parent::__construct();
      $this->load->library('googleplus');
      $this->load->library('facebook');
      if($this->session->userdata('admin_id')){
         redirect(base_url('admin/dashboard'));
      }
      $this->load->model('admin/Admin_Model','admin');
      $this->load->model('admin/Banip_Model','banip');
      $this->load->model('admin/ModuleSetting_Model','module_setting');
      $settings = $this->load->model('admin/Settings_Model','settings');
      $this->load->library('email');
      $this->data['settings'] = $this->settings->get();
      $this->data['loginURL'] = $this->googleplus->loginURL();
      $this->data['facebookLoginURL'] = $this->facebook->login_url();

    }

    /**
    @param void
    @return void
    */
    
   public function index(){
         $this->load->view('admin/auth/signin',$this->data);
   }

   /**
    @param void
    @return void
    */
   public function signin(){     
      $this->load->view('admin/auth/signin',$this->data);
   }

    public function googleauth(){   
        if(isset($_GET['code'])){
            
            // Authenticate user with google
            if($this->googleplus->getAuthenticate()){
                // Get user info from google
                $gpInfo = $this->googleplus->getUserInfo();
                // Preparing data for database insertion
                $userData['oauth_provider'] = 'google';
                $userData['oauth_uid']      = $gpInfo['id'];
                $userData['firstname']     = $gpInfo['given_name'];
                $userData['lastname']      = $gpInfo['family_name'];
                $userData['email']          = $gpInfo['email'];
                $userData['gender']         = !empty($gpInfo['gender'])?$gpInfo['gender']:'';
                $userData['locale']         = !empty($gpInfo['locale'])?$gpInfo['locale']:'';
                $userData['link']           = !empty($gpInfo['link'])?$gpInfo['link']:'';
                $userData['image']        = !empty($gpInfo['picture'])?$gpInfo['picture']:'';
                $userData['login_type'] = '2';
                $userData['role'] = '3';
                $userData['image_flag'] = '1';
                

                $response = $this->admin->checkactivation($userData);
                if($response['status'] === true){
                     $this->session->set_flashdata('error', $response['message']);
                     redirect(base_url('admin/signin'));
               // $this->load->view('admin/auth/signin',$this->data);
                  }
                $response = $this->admin->validemail($userData);

                if($response['status'] === false){
                     $this->session->set_flashdata('error', $response['message']);
                     redirect(base_url('admin/signin'));
               // $this->load->view('admin/auth/signin',$this->data);
                  }else{
                   // Insert or update user data to the database
                  $response = $this->admin->checkUser($userData);
                   // Store the status and user profile info into session
               $access_token = json_decode($this->googleplus->getAccessToken(),true)['access_token'];
                     if($response['status'] === true){
                        $this->session->set_userdata('admin_id', $response['id']);
                        $this->session->set_userdata('access_token', $access_token);
                   // Redirect to profile page
                  redirect(base_url('admin/dashboard'));
                     }else{
                        $this->session->set_flashdata('error', $response['message']);
               $this->load->view('admin/auth/signin',$this->data);
                     }
                  }
                
            }
      }
   }

   public function facebookauth(){  
        if(isset($_GET['code'])){
            
            // Authenticate user with google
            if($this->facebook->is_authenticated()){
                // Get user facebook profile details
               $fbUser = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,link,gender,picture');
               
               // Preparing data for database insertion
               $userData['oauth_provider'] = 'facebook';
               $userData['oauth_uid']    = !empty($fbUser['id'])?$fbUser['id']:'';;
               $userData['firstname']    = !empty($fbUser['first_name'])?$fbUser['first_name']:'';
               $userData['lastname']    = !empty($fbUser['last_name'])?$fbUser['last_name']:'';
               $userData['email']        = !empty($fbUser['email'])?$fbUser['email']:'';
               $userData['gender']        = !empty($fbUser['gender'])?$fbUser['gender']:'';
               $userData['image']    = !empty($fbUser['picture']['data']['url'])?$fbUser['picture']['data']['url']:'';
               $userData['link']        = !empty($fbUser['link'])?$fbUser['link']:'';

         
               
               // Get logout URL
               $data['logoutURL'] = $this->facebook->logout_url();

                $userData['login_type'] = '2';
                $userData['role'] = '3';
                $userData['image_flag'] = '1';
                

                $response = $this->admin->checkactivation($userData);
                if($response['status'] === true){
                     $this->session->set_flashdata('error', $response['message']);
                     redirect(base_url('admin/signin'));
                  }
                $response = $this->admin->validemail($userData);

                if($response['status'] === false){
                     $this->session->set_flashdata('error', $response['message']);
                     redirect(base_url('admin/signin'));
                  }else{
                   // Insert or update user data to the database
                  $response = $this->admin->checkUser($userData);
                   // Store the status and user profile info into session
               $access_token = json_decode($this->googleplus->getAccessToken(),true)['access_token'];
                     if($response['status'] === true){
                        $this->session->set_userdata('admin_id', $response['id']);
                        $this->session->set_userdata('access_token', $access_token);
                   // Redirect to profile page
                  redirect(base_url('admin/dashboard'));
                     }else{
                        $this->session->set_flashdata('error', $response['message']);
               $this->load->view('admin/auth/signin',$this->data);
                     }
                  }
                
            }
      }
   }

   /**
    @param void
    @return void
    */
   public function dosignin(){
      $validation = [
            ['field' => 'username','label' => 'Username','rules' => 'trim|required|xss_clean'],
            ['field' => 'password','label' => 'Password','rules' => 'required|min_length[4]|xss_clean'],
         ];
       $this->form_validation->set_rules($validation);
       if($this->form_validation->run() == false){
         $this->load->view('admin/auth/signin',$this->data);
       }
       else{
         $_POST['password'] = md5($_POST['password']);
         $response = $this->admin->dosignin($_POST);
         if($response['status']===true){
            $ip = $this->input->ip_address();
            if($response['record']['id'] == "1"){
               $this->session->set_userdata('admin_id', $response['record']['id']);
               redirect(base_url('admin/dashboard'));
            }
            $res = $this->banip->checkip($ip);

            if($res['status']===true){
               $this->session->set_flashdata('error', $res['message']);
               $this->load->view('admin/auth/signin',$this->data);
            }else{
            $this->session->set_userdata('admin_id', $response['record']['id']);
            redirect(base_url('admin/dashboard'));
            }
         }
         else{
            $this->session->set_flashdata('error', $response['message']);
            $this->load->view('admin/auth/signin',$this->data);
         }
       }
   }

   /**
    @param void
    @return void
    */
   public function signup(){
      $this->load->view('admin/auth/signup',$this->data);
   }

   public function getattribute(){
      $user = "user";
        $this->data['page']=$this->module_setting->getattribute($user);
        if($this->data['page']['status'] !== false){
            return $this->load->view('admin/users/formmodel',$this->data);
        }else{
            return "false";
        }
    }
   /**
    @param void
    @return void
    */
   public function store(){
      $user ='user';
        $module=$this->module_setting->getattribute($user);
      $validation = [
            ['field' => 'firstname','label' => 'First Name','rules' => 'trim|required|xss_clean'],
            ['field' => 'lastname','label' => 'Last Name','rules' => 'trim|required|xss_clean'],
            ['field' => 'email','label' => 'Email','rules' => 'trim|required|xss_clean|valid_email|is_unique[admins.email]','errors'=>['is_unique'=>'The %s is already taken']],
            ['field' => 'password','label' => 'Password','rules' => 'required|min_length[4]|xss_clean'],
            ['field' => 'confirm_password','label' => 'Confirm Password','rules' => 'required|matches[password]'],
         ];
         if(!empty($module)){
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
         $_POST['password'] = md5($_POST['password']);
         $_POST['role'] = '3';
         $_POST['created_at'] = date('Y-m-d H:i:s');

            foreach ($module['record'] as $key => $value) {
                $d[$value['slug']] = $_POST[$value['slug']];
                unset($_POST[$value['slug']]);
             }
            $_POST['module'] = json_encode($d);
         $response = $this->admin->store($_POST);
         if($response['status']===true){
            $this->session->set_userdata('admin_id', $response['id']);
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

   public function email(){
      $this->load->view('admin/auth/email',$this->data);
   }

   public function forgot(){
      $validation = [
            ['field' => 'email','label' => 'Email','rules' => 'trim|required|xss_clean'],
         ];
       $this->form_validation->set_rules($validation);
       if($this->form_validation->run() == false){
         $this->load->view('admin/auth/email',$this->data);
       }
       else{
         $response = $this->admin->forgot($_POST);
         if($response['status']===true){
            // $config = email_config();
            $message = '<!DOCTYPE html>
                        <html lang="en-US">
                           <head>
                              <meta charset="utf-8">
                           </head>
                           <body>
                              <h2>Password Reset</h2>
                              <div>
                                 To reset your password, complete this form: <a href="'.base_url().'admin/auth/reset/'.$response['token'].'" target="_blank">Reset Password</a>
                              </div>
                           </body>
                        </html>';
             
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
            $this->email->from(SMTP_SEND_FROM,SMTP_SEND_FROM_NAME);
            $this->email->to($_POST['email']);
            $this->email->subject('Forgot Password');
            $this->email->message($message);
            if($this->email->send()){
               $res = 'true';
            }
            else{
               $res = 'false';
            }
            $this->session->set_flashdata('success', $response['message']);
            redirect(base_url('admin/signin'));
         }
         else{
            $this->session->set_flashdata('error', $response['message']);
            $this->load->view('admin/auth/email',$this->data);
         }
       }
   }

   public function reset($token){
      $this->data['token'] = $token;
      $this->load->view('admin/auth/reset',$this->data);
   }

   public function doreset(){
      $this->data['token'] = $_POST['remember_token'];
      $validation = [
            ['field' => 'password','label' => 'Password','rules' => 'required|min_length[4]|xss_clean'],
            ['field' => 'confirm_password','label' => 'Confirm Password','rules' => 'required|matches[password]'],
         ];
       $this->form_validation->set_rules($validation);
       if($this->form_validation->run() == false){
         $this->load->view('admin/auth/reset',$this->data);
       }
       else{
         $_POST['password'] = md5($_POST['password']);
         unset($_POST['confirm_password']);
         $response = $this->admin->doreset($_POST);
         if($response['status']===true){
            $this->session->set_flashdata('success', $response['message']);
            redirect(base_url('admin/signin'));
         }
         else{
            $this->session->set_flashdata('error', $response['message']);
            $this->load->view('admin/auth/reset',$this->data);
         }
       }
   }
   public function sendemailotp($email)
   {
        // for linuk server use smtp and for window use ssmtp
      $otp = random_int(100000, 999999);
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
      //  for localhost only
      // $this->email->initialize($config);
      $this->email->set_mailtype("html");
      $this->email->set_newline("\r\n");
      $htmlContent = '<p>Your Login OTP is '.$otp.'. OTP is confidential For Security Reasons, Do Not Share This OTP With Anyone</p>';
      $this->email->to($email);
      $this->email->from(SMTP_SEND_FROM,SMTP_SEND_FROM_NAME);
      $this->email->subject('Login with otp');
      $this->email->message($htmlContent);
      $this->email->send();
      //Send email
      if(true)
      {
         $this->db->where('email',$email)->update('admins',['last_otp'=>$otp]);
         return true;
      }else{
         $this->db->where('email',$email)->update('admins',['last_otp'=>'']);
         return false;   
      }
   }
   public function loginwithotp()
   {
      $this->form_validation->set_rules('username', 'Username', 'required|trim');
      $this->form_validation->set_rules('password', 'Password', 'required|trim');
       
       if($this->form_validation->run() == false){

         $output['status']=false;
         $output['message']=strip_tags(validation_errors());
         $output['data']=null;
         
       }
       else{

         $username=$this->input->post('username');
         $password=$this->input->post('password');
 
         $response = $this->admin->dosignin(['username'=>$username,'password'=>md5($password)]);
   
         // echo json_encode($response);
          // die();
   
         if($response['status']===true){
            
            $sendmemail=$this->sendemailotp($username);
            if ($sendmemail) {
               $output['status']=true;
               $output['message']="Please enter 6 digit otp";
            }else{
               $output['status']=false;
               $output['message']="Email error";
            }
               //  remove after deploy on live server
               $output['status']=true;
               $output['message']="Please enter 6 digit otp";
             
         }else{
            $output['status']=false;
            $output['message']="Wrong credentials";
         }
       }
       echo json_encode($output);
       die();
   }
   public function dosigninwithotp()
   {
      $this->form_validation->set_rules('username', 'Username', 'required|trim');
      $this->form_validation->set_rules('password', 'Password', 'required|trim');
      $this->form_validation->set_rules('otp', 'Otp', 'required|trim');
       
       if($this->form_validation->run() == false){

         $output['status']=false;
         $output['message']=strip_tags(validation_errors());
         $output['data']=null;
         
       }
       else{

         $username=$this->input->post('username');
         $password=$this->input->post('password');
         $otp=$this->input->post('otp');

         $response = $this->admin->dosignin(['username'=>$username,'password'=>md5($password)]);
         if($response['status']===true){

            if($response['record']['last_otp']==$otp)
            {
               $ip = $this->input->ip_address();
               if($response['record']['id'] == "1"){
                  $this->session->set_userdata('admin_id', $response['record']['id']);
                  $output['status']=true;
                  $output['message']="Login successfully";
                  echo json_encode($output);
                  die();
               }
               $res = $this->banip->checkip($ip);

               if($res['status']===true){
                  $this->session->set_flashdata('error', $res['message']);
                  $output['status']=false;
                  $output['message']=$res['message'];
                  echo json_encode($output);
                  die();
               }else{
                  $this->session->set_userdata('admin_id', $response['record']['id']);
                  $output['status']=true;
                  $output['message']='Login successfully';
                  echo json_encode($output);
                  die();
               }  
            }else{
               $output['status']=false;
               $output['message']="Invalid otp";
               echo json_encode($output);
               die();
            }
            
         }
         else{
            $this->session->set_flashdata('error', $response['message']);
            $output['status']=false;
            $output['message']=$response['message'];
            echo json_encode($output);
            die();
         }
      }
   }  
   
}
   