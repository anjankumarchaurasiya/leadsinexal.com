<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exal extends CI_Controller {
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
        $this->load->model('admin/Admin_Model','admin');
        $response = $this->admin->edit($this->session->userdata('admin_id'));
        $this->load->model('admin/Category_Model','category');
        $this->load->model('admin/Exal_Model','exal');
        $settings =$this->load->model('admin/Settings_Model','settings');
	    $settings = $this->load->model('admin/RolePermission_Model','rolepermission');
	    $this->data['settings'] = $this->settings->get();
        if($response['status']===true){
             $this->data['admin'] = $response['record'];
            $this->data['userrole']= $this->rolepermission->edit($this->data['admin']['role']);
            $this->page = 'exal';
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
         
        if($this->data['admin']['role']=='2' || $this->data['admin']['role']=='3')
        {

            $this->data['exal'] = $this->exal->get_user($this->data['admin']);  
         
        }else{
            $this->data['exal'] = $this->exal->get();
        }
        $this->data['category'] = $this->exal->get();
        
        $this->load->view('admin/exal/list',$this->data);
    }
    public function viewdata($id){

        $filter['state'] = ($this->input->get('state') !=="")?$this->input->get('state'):'';
        $filter['district'] = ($this->input->get('district') !=="")?$this->input->get('district'):'';
        $filter['location'] = ($this->input->get('location') !=="")?$this->input->get('location'):'';
        $interested_value =  $this->input->get('is_interested');
        $filter['is_interested'] = ($this->input->get('is_interested') !== "")? $interested_value:'';

        $where_filter['exal_id'] = base64_decode($id);
        ($filter['state'] !=="")?$where_filter['state'] = $filter['state']:'';
        ($filter['district'] !=="")?$where_filter['district'] = $filter['district']:'';
        ($filter['location'] !=="")?$where_filter['location'] = $filter['location']:'';

        ($filter['is_interested'] !=="")?$where_filter['is_interested'] = $filter['is_interested']:'';
        $where_filtered_array = array_filter($where_filter,'strlen');
        $filter_filter_array = array_filter($filter,'strlen');
        
        if($this->data['admin']['role']=='2' || $this->data['admin']['role']=='3')
        {
            $accessornot=$this->db->get_where('exal_assign_user',['user_id'=>$this->data['admin']['id'],'exal_id'=>base64_decode($id),'is_assigned'=>'yes'])->num_rows(); 
            if($accessornot==0)
            {
                redirect(base_url('admin/exal'));
            }
        }
        if($this->data['admin']['role']=='2' || $this->data['admin']['role']=='3')
        {
            $this->data['seller']=$this->db->select('ad.username,ad.id as adminuserid,ad.role,ad.status,ea.id as exal_assign_id,ea.user_id as assigned_user_id')
            ->from('admins as ad')
            ->join('exal_assign_user as ea','ea.user_id=ad.id AND ea.exal_id='.base64_decode($id),'left')
            ->where(['ad.role'=>3,'ad.status'=>'1','ad.seller_id'=>$this->data['admin']['id']])
            ->get()->result_array();
          
            $this->data['assignedseller']=$this->db->select('ea.exal_id,ad.username,ad.id as user_id,ad.role,ad.status,ea.id as exal_assign_id,ea.user_id as assigned_user_id,ea.mask_field_name,ea.is_assigned')
            ->from('admins as ad')
            ->join('exal_assign_user as ea','ea.user_id=ad.id AND ea.exal_id='.base64_decode($id))
            ->where(['ad.role'=>3,'ad.status'=>'1','ad.seller_id'=>$this->data['admin']['id']])
            ->get()->result_array();
            
            $assignmaskinfo=$this->db->get_where('exal_assign_user',['exal_id'=>base64_decode($id),'user_id'=>$this->data['admin']['id']])->row_array();
            // exal pagination
            $offset = ($this->input->get('page')) ? ( ( $this->input->get('page') - 1 ) * DATAPERPAGE ) : 0;
            $page=($this->input->get('page')) ? ($this->input->get('page') - 1 ): 0;

            $this->data['datatble']=$this->functions->pagination_config(base_url('admin/exal/viewdata/'.$id.'?'.http_build_query(array_filter($filter,'strlen'))),$this->exal->get_where_data_rows($where_filtered_array),DATAPERPAGE,$page);
            // -----------------
            $this->data['exal'] = $this->exal->get_where_data_withmask($where_filtered_array,$assignmaskinfo['mask_field_name'],DATAPERPAGE, $offset);
            $this->data['mask_field_name']=explode(',', $assignmaskinfo['mask_field_name']);
            
        }else{
            $this->data['seller']=$this->db->select('ad.username,ad.id as adminuserid,ad.role,ad.status,ea.id as exal_assign_id,ea.user_id as assigned_user_id,ea.is_assigned')
            ->from('admins as ad')
            ->join('exal_assign_user as ea','ea.user_id=ad.id AND ea.exal_id='.base64_decode($id),'left')
            ->where(['ad.role'=>2,'ad.status'=>'1'])
            ->get()->result_array();

            $this->data['assignedseller']=$this->db->select('ea.exal_id,ad.username,ad.id as user_id,ad.role,ad.status,ea.id as exal_assign_id,ea.user_id as assigned_user_id,ea.mask_field_name,ea.is_assigned')
            ->from('admins as ad')
            ->join('exal_assign_user as ea','ea.user_id=ad.id AND ea.exal_id='.base64_decode($id))
            ->where(['ad.role'=>2,'ad.status'=>'1'])
            ->get()->result_array();

            // exal pagination
            

            $offset = ($this->input->get('page')) ? ( ( $this->input->get('page') - 1 ) * DATAPERPAGE ) : 0;
            $page=($this->input->get('page')) ? ($this->input->get('page') - 1 ): 0;

            $this->data['datatble']=$this->functions->pagination_config(base_url('admin/exal/viewdata/'.$id.'?'.http_build_query(array_filter($filter,'strlen'))),$this->exal->get_where_data_rows($where_filtered_array),DATAPERPAGE,$page);
            $this->data['exal'] = $this->exal->get_where_data($where_filtered_array,DATAPERPAGE, $offset);

        }
        
        $this->data['filter'] = $filter_filter_array;
        $this->data['exal_data']=$this->exal->edit(base64_decode($id));
        $this->data['exal_id']=base64_decode($id);
        echo '<pre>';
        print_r($this->data['exal']);
        die();
        $this->load->view('admin/exal/exal_list',$this->data);
    }
    public function create(){
        chkaccess($this->data,$this->page,'create');
        $this->data['category'] = $this->category->get();
   
        $this->load->view('admin/exal/form',$this->data);
    }

    /**
    @param void
    @return void
    */
    public function store(){
        chkaccess($this->data,$this->page,'create');
         $validation = [
                ['field' => 'category_id','label' => 'Category','rules' => 'trim|required|xss_clean'],
                ['field' => 'title','label' => 'Title','rules' => 'trim|required|xss_clean']
            ];
        $this->form_validation->set_rules($validation);
        if($this->form_validation->run() == false){
            $this->load->view('admin/exal/form',$this->data);
        }else{
            if($_FILES["file_path"]['tmp_name'] == null){
                $this->session->set_flashdata('error', 'Please Enter File.');

                redirect(base_url('admin/exal/form'));
            }
            if(isset($_FILES['file_path'])&&$_FILES['file_path']['name']!=''){
                $config['upload_path'] = FCPATH . 'assets/excel/';
                $config['file_name'] = time();
                $config['overwrite'] = TRUE;
                $config["allowed_types"] = 'xlsx|xls';
                $this->load->library('upload', $config);
                if(!$this->upload->do_upload('file_path')){
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    $this->load->view('admin/exal/form',$this->data);
                }
                else{
                    $upload_data = $this->upload->data();
                    $_POST['file_size'] =$this->formatSizeUnits($_FILES["file_path"]["size"]);
                    $_POST['file_path'] = 'assets/excel/'.$upload_data['file_name'];
                }
            }
                      //read file from path
            $objPHPExcel = PHPExcel_IOFactory::load($_FILES["file_path"]["tmp_name"]);
             
            //get only the Cell Collection
            $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
             
            //extract to a PHP readable array format
            foreach ($cell_collection as $cell) {
                $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
                $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();

                if ($row == 1) {
                    $header[$row][$column] = $data_value;
                } else {
                    $arr_data[$row][$column] = $data_value;
                }
            }
            $_POST['no_row'] = count($arr_data);
            $this->exal->store($_POST);
            $lastexalid=$this->db->insert_id();
            //send the data in an array format
            $data['header'] = $header;
            $data['values'] = ($arr_data);
            $idatadata=array();
            foreach ($data['values'] as $key => $value) {
                $idata['exal_id']=$lastexalid;
                $idata['name']=$value['A'];
                $idata['mobile']=$value['B'];
                $idata['email']=$value['C'];
                $idata['district']=$value['D'];
                $idata['location']=$value['E'];
                $idata['state']=$value['F'];
                $idata['pincode']=$value['G'];
                $idata['father_name']=$value['H'];
                array_push($idatadata,$idata);
            }
            $this->db->insert_batch('exal_data',$idatadata);
            if($this->db->affected_rows() > 0){
                 $this->session->set_flashdata('success', 'Your file is successfully imported.');
            }
            else{
                 $this->session->set_flashdata('error', 'Somthing is wrong');
            
            } 
            redirect(base_url('admin/exal'));
        }
    }    
    public function destroy($id){
        
        chkaccess($this->data,$this->page,'delete');   

        $exalnorows=$this->db->get_where('exal_assign_user',['exal_id'=>$id])->num_rows();

        // if($exalnorows > 0){
        //     $this->session->set_flashdata('error', 'You can not delete this exal, its already assigned');
        //     redirect(base_url('admin/exal'));
        // }
        $this->db->where('id',$id);
        $this->db->delete('exal');

        $this->db->where('exal_id',$id);
        $this->db->delete('exal_assign_user');

        $this->session->set_flashdata($status, 'exal deleted successfully');
        redirect(base_url('admin/exal'));
    }

    function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }
    // assign to seller
    public function assigntoseller($id)
    {
       // chkaccess($this->data,$this->page,'create');
        $validation = [
                ['field' => 'exal_id','label' => 'Name','rules' => 'trim|required|xss_clean'],
                ['field' => 'user_id','label' => 'User','rules' => 'trim|required|xss_clean'],
            ];
 
        $this->form_validation->set_rules($validation);
        if($this->form_validation->run() == false){
             redirect(base_url('admin/exal/viewdata/'.$id));
        }
        else{
            $_POST;
            $_POST['mask_field_name']=implode(',', $_POST['mask_field_name']);
 
            $response=$this->exal->storeassigntouser($_POST);
            if($response['status']){
                $this->session->set_flashdata('success', 'Successfully assigned');
            }
            else{
                $this->session->set_flashdata('error', 'Somthing is wrong');
            } 
             redirect(base_url('admin/exal/viewdata/'.$id));
        } 
    }
    // destroy exallistassigndestroy
    public function exallistassigndestroy($exalid,$exal_assign_id)
    {
        $response = $this->exal->exallistassigndestroy(base64_decode($exal_assign_id));
 
        $status = $response['status']===true?'success':'error';
        $this->session->set_flashdata($status, $response['message']);
        redirect(base_url('admin/exal/viewdata/'.$exalid));
    }
    public function fetchmaskdata()
    {

        $validation = [
                ['field' => 'roleid','label' => 'Role id','rules' => 'trim|required|xss_clean'],
                ['field' => 'userid','label' => 'User id','rules' => 'trim|required|xss_clean'],
                ['field' => 'exal_id','label' => 'Exal id','rules' => 'trim|required|xss_clean'],
                ['field' => 'namefield','label' => 'Name','rules' => 'trim|required|xss_clean'],
                ['field' => 'exid','label' => 'Exal data id','rules' => 'trim|required|xss_clean'],
            
            ];
        $this->form_validation->set_rules($validation);
        if($this->form_validation->run() == false){
            $response['status'] = false;
            $response['message']= validation_errors();
            $response['data']='';
        }
        else{

            $roleid=$this->input->post('roleid');
            $userid=$this->input->post('userid');
            $exal_id=$this->input->post('exal_id');
            $namefield=$this->input->post('namefield');
            $exid=$this->input->post('exid');
            
            if($this->data['admin']['role']=='2' || $this->data['admin']['role']=='3')
            {
                $accessornot=$this->db->get_where('exal_assign_user',['user_id'=>$this->data['admin']['id'],'exal_id'=>$exal_id])->num_rows(); 
                if($accessornot==0)
                {
                    $response['status'] = false;
                    $response['message']= 'Not access';
                    $response['data']='';

                }else{

                    $exldata=$this->db->select($namefield)->from('exal_data')->where('id',$exid)->get()->row_array();
                    $response['status'] = true;
                    $response['message']= 'Successfully retrive';
                    $response['data']=$exldata;
                }
            }else{
                
                $response['status'] = false;
                $response['message']= 'Not access';
                $response['data']='';
            
            }
        }
        echo json_encode($response);
        exit();
   }
   // get city list based on the state & exal id
   public function citylist()
   {
      $validation = [
          ['field' => 'exal_id','label' => 'Exal id','rules' => 'trim|required|xss_clean'],
          ['field' => 'state','label' => 'state','rules' => 'trim|required|xss_clean'],
      ];
     $this->form_validation->set_rules($validation);
      if($this->form_validation->run() == false){
         $response['status'] = false;
         $response['message']= validation_errors();
         $response['data']='';
      }
      else{
         $exal_id=$this->input->post('exal_id');
         $state=$this->input->post('state');

         $citylist = $this->db->select('district')->from('exal_data')->where(['exal_id'=>$exal_id,'state'=>$state])->group_by('district')->get()->result_array();
         if(empty($citylist))
         {
            $response['status'] = false;
            $response['message']= 'Data not available';
            $response['data']='';
         }else{
            $response['status'] = true;
            $response['message']= 'Data available';
            $response['data']=$citylist;
         }
      }
      echo json_encode($response);
      exit();
   }
   // get lcoation list based on the state & exal id
   public function locationlist()
   {
      $validation = [
          ['field' => 'exal_id','label' => 'Exal id','rules' => 'trim|required|xss_clean'],
          ['field' => 'district','label' => 'district','rules' => 'trim|required|xss_clean'],
      ];
     $this->form_validation->set_rules($validation);
      if($this->form_validation->run() == false){
         $response['status'] = false;
         $response['message']= validation_errors();
         $response['data']='';
      }
      else{
         $exal_id=$this->input->post('exal_id');
         $district=$this->input->post('district');

         $locationlist = $this->db->select('location')->from('exal_data')->where(['exal_id'=>$exal_id,'district'=>$district])->group_by('location')->get()->result_array();
         if(empty($locationlist))
         {
            $response['status'] = false;
            $response['message']= 'Data not available';
            $response['data']='';
         }else{
            $response['status'] = true;
            $response['message']= 'Data available';
            $response['data']=$locationlist;
         }
      }
      echo json_encode($response);
      exit();
   }
   // assigned user chnage status
   public function changestatus()
   {
        $validation = [
          ['field' => 'assignid','label' => 'id','rules' => 'trim|required|xss_clean'],
        ];
        $this->form_validation->set_rules($validation);
        if($this->form_validation->run() == false){
            $response['status'] = false;
            $response['message']= validation_errors();
            $response['data']='';
        }
        else{
            $assignid=$this->input->post('assignid');
            $ass_data = $this->db->get_where('exal_assign_user',array('id'=>$assignid))->row_array();
            $ass_var = ($ass_data['is_assigned'] === "yes")?'no':'yes';
            $update = $this->db->where('id',$assignid)->update('exal_assign_user',['is_assigned'=>$ass_var]);
            if($update == true)
            {
                $response['status'] = true;
                $response['message']= ($ass_data['is_assigned'] === "yes")?'Unassigned successfully':'Assigned successfully';
                $response['data']= ($ass_data['is_assigned'] === "yes")?0:1;
            }else{
                $response['status'] = false;
                $response['message']= 'Data available';
                $response['data']='';
            }
        }
        echo json_encode($response);
        exit(); 
    }
   // assigned user chnage status
   public function isIntrestedStatusUpdate()
   {
        $validation = [
          ['field' => 'exid','label' => 'id','rules' => 'trim|required|xss_clean'],
        ];
        $this->form_validation->set_rules($validation);
        if($this->form_validation->run() == false){
            $response['status'] = false;
            $response['message']= validation_errors();
            $response['data']='';
        }
        else{
            $assignid=$this->input->post('exid');
            $ass_data = $this->db->get_where('exal_data',array('id'=>$assignid))->row_array();
            $ass_var = ($ass_data['is_interested'] === '1')?'0':'1';
            $update = $this->db->where('id',$assignid)->update('exal_data',['is_interested'=>$ass_var]);
            if($update == true)
            {
                $response['status'] = true;
                $response['message']= ($ass_data['is_interested'] === '1')?'"Not intrested" status update successfully':'"Intrested" status update successfully';
                $response['data']= ($ass_data['is_interested'] === '1')?'0':'1';
            }else{
                $response['status'] = false;
                $response['message']= 'Data available';
                $response['data']='';
            }
        }
        echo json_encode($response);
        exit(); 
    }
}
