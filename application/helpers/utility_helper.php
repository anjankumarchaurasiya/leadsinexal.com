<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

	if(!function_exists('asset_url()')){
		function asset_url(){
			return base_url().'assets/';
		}
	}
	
	function email_config(){
		$config = array(
				'protocol' => SMTP_PROTOCOL,
				'smtp_host' => SMTP_HOST,
				'smtp_port' => SMTP_PORT,
				'smtp_user' => SMTP_USER,
				'smtp_pass' => SMTP_PASSWORD,
				'mailtype' => SMTP_MAILTYPE,
				'charset' => SMTP_CHARSET,
				'wordwrap' => SMTP_WORDWRAP
			);
		return $config;
	}

	if(!function_exists('j')){
		function j($data){
			echo "<pre>";print_r($data);exit;
		}
	}

	function chkaccess($data,$page,$action){		
		// echo $action;exit;
		if(!isset($data['userrole']['record']['permissions'][$page][$action]) || $data['userrole']['record']['permissions'][$page][$action] !== true){  
            
                redirect(base_url('admin/dashboard'));
            }
	}

	function tracking(){
		$CI =& get_instance();
		$CI->load->library('session');
		if($CI->session->userdata('tracked')){
		}
		else{
			$CI->session->set_userdata('tracked',true);
			$CI->load->library('user_agent');
			$CI->load->database();
			$data = array();
			$data['ip'] = $CI->input->ip_address();
			$data['agent'] = $CI->agent->agent;
			$data['created_at'] = date('Y-m-d H:i:s');
			$CI->db->insert('tracking',$data);
		}
	}
		tracking();
	function getrole_id()
	{
		$CI =& get_instance();
		$CI->load->library('session');
		$adminid=$CI->session->userdata('admin_id');
		return $CI->db->get_where('admins',['id'=>$adminid])->row_array()['role'];
	}
	function howmuch_can_user_create()
	{
		$CI =& get_instance();
		$CI->load->library('session');
		$adminid=$CI->session->userdata('admin_id');
		$numof=$CI->db->get_where('admins',['id'=>$adminid])->row_array()['module'];
		$mod=json_decode($numof,true)['no_of_user_can_add'];

		$numofcreated=$CI->db->get_where('admins',['seller_id'=>$adminid])->num_rows();
		
		if($numofcreated < $mod)
		{
			return $mod - $numofcreated;
		}else{
			return 0;
		}
		// if($numofcreated > $mod)
		// return $mod;
	}
	function role_check()
	{
		$CI =& get_instance();
		$CI->load->library('session');
		$adminid=$CI->session->userdata('admin_id');
		$role= $CI->db->get_where('admins',['id'=>$adminid])->row_array()['role'];
		
		return ($role==2)?'seller':'user';
	}
	function getcategoryname($id)
	{
		$CI =& get_instance();
		return $CI->db->get_where('category',['id'=>$id])->row_array()['name'];
	}
	function checksellername($seller_id)
	{
		$CI =& get_instance();
		if($seller_id)
		{
			return $name= $CI->db->get_where('demodatabase_user',['id'=>$seller_id])->row_array()['name'];
		}else{
			return '';
		}
	}
   function exalname($exal_id)
   {
      $CI =& get_instance();
      if($exal_id)
      {
         return $name= $CI->db->get_where('exal',['id'=>$exal_id])->row_array()['title'];
      }else{
         return '';
      }
   }
   function get_exal_location_by_exal_id($exalid)
   {

     $CI =& get_instance();
      if($exalid)
      {
         $exaldata = $CI->db->select('state')->from('exal_data')->where(['exal_id'=>$exalid])->group_by('state')->get()->result_array();
           echo '<pre>';
           print_r($exaldata);
           die();
           // return $CI->db->select('*')->from('exal_data')->where(['exal_id'=>$exalid])->group_by('state')->get()->result_array();
            
      }else{
         return '';
      } 
   }
