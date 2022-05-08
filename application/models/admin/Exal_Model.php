<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exal_Model extends CI_Model {
    
    function __construct() {
        $this->table = 'exal';
        $this->primaryKey = 'id';
    }
    
    public function get(){
        $this->db->select('*');
        $this->db->order_by("id", "desc");
        $query = $this->db->get($this->table);
        if($query->num_rows()>0){
            $records = $query->result_array();
            $response = ['status'=>true,'message'=>'Success','records'=>$records];
        }
        else{
            $response = ['status'=>false,'message'=>'No records found','records'=>[]];
        }
        return $response;
    }
    public function get_user($data){

        $this->db->select('es.mask_field_name,ex.*');
        $this->db->from('exal_assign_user as es');
        $this->db->join('exal as ex','ex.id=es.exal_id');
        $this->db->where('es.user_id',$data['id']);
        $this->db->where('es.is_assigned','yes');
        $this->db->order_by("es.id", "desc");
        $query = $this->db->get();
        if($query->num_rows()>0){
            $records = $query->result_array();
            $response = ['status'=>true,'message'=>'Success','records'=>$records];
        }
        else{
            $response = ['status'=>false,'message'=>'No records found','records'=>[]];
        }
        return $response;
    }
    /**
    @param firstName string
    @param lastName string
    @param email string
    @param birthDate date
    @param password string
    @return status boolean
    @return message string
    @return id int
    */
    public function store($data){
          
        $request = $this->db->insert($this->table, $data);
        
        $this->db->trans_complete();
        // check if record inserted successfully.
        if($request){
            $response = ['status'=>true,'message'=>'Success','id'=>$this->db->insert_id()];
        }
        else{
            $response = ['status'=>false,'message'=>'Something went wrong, Please try again.'];
        }
        return $response;
    }

    /**
    @param id int
    @return status boolean
    @return message string
    @return data array
    */
    public function edit($id){
        $this->db->select('*');
        $this->db->where('id', $id);
        $query = $this->db->get($this->table);
        if($query->num_rows()>0){
            $record = $query->row_array();
            $response = ['status'=>true,'message'=>'Success','record'=>$record];
        }
        else{
            $response = ['status'=>false,'message'=>'Please enter valid email and password'];
        }
        return $response;
    }

    public function update($id,$data){
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
        $response = ['status'=>true,'message'=>'Success'];
        return $response;
    }
    
    public function get_where_data($where,$limit ='',$offset='')
    {
        $record=$this->db->select('*')->from('exal_data')->where($where)->limit($limit,$offset)->get()->result_array();
        return $record; 
    }
    public function get_where_data_rows($where)
    {
        $record=$this->db->select('*')->from('exal_data')->where($where)->get()->num_rows();
        // $response = ['status'=>true,'message'=>'Success','record'=>$record];
        return $record; 
    } 
    public function get_where_data_withmask($where_filter,$mask_field_name,$limit ='',$offset='')
    {

        $msfield=explode(',', $mask_field_name);
        $wherecondition = $this->arrayTowhereContidion($where_filter);
   
        $mainmaskfield=['name','email','mobile','district','location','state','pincode','father_name'];
        $m_select='';
        if($msfield){
            foreach ($msfield as $key => $value) {
             
                $pos = array_search($value, $mainmaskfield);
                if(count($msfield) == $key+1)
                {
                  $m_select .="CONCAT(SUBSTR(".$value.", 1, 2), REPEAT('*', CHAR_LENGTH(".$value.") - 2)) AS ".$value;
                }else{
                  $m_select .="CONCAT(SUBSTR(".$value.", 1, 2), REPEAT('*', CHAR_LENGTH(".$value.") - 2)) AS ".$value." , ";
                }
                unset($mainmaskfield[$pos]);           
            }
        }
        
        $record=$this->db->query("SELECT ".$m_select.implode(',',$mainmaskfield).",id,exal_id,is_interested,remark"."
        FROM exal_data WHERE ".$wherecondition." LIMIT ".$limit." OFFSET ".$offset."")->result_array();
        $response = ['status'=>true,'message'=>'Success','record'=>$record];
        return $record; 
    }
    public function destroy($id){
        $this->db->where('id', $id);
        $this->db->delete($this->table);
        $response = ['status'=>true,'message'=>'Success'];
        return $response;
    }
     public function exallistassigndestroy($id){
        $this->db->where('id', $id);
        $this->db->delete('exal_assign_user');
        $response = ['status'=>true,'message'=>'Success'];
        return $response;
    }
    public function exaldatadestroy($id){
        $this->db->where('id', $id);
        $this->db->delete('exal_data');
        $response = ['status'=>true,'message'=>'Success'];
        return $response;
    }
    public function storeassigntouser($data){
          
        $request = $this->db->insert('exal_assign_user', $data);
        
        $this->db->trans_complete();
        // check if record inserted successfully.
        if($request){
            $response = ['status'=>true,'message'=>'Success','id'=>$this->db->insert_id()];
        }
        else{
            $response = ['status'=>false,'message'=>'Something went wrong, Please try again.'];
        }
        return $response;
    }
    public function arrayTowhereContidion($where_filter)
    {
        $terms = count($where_filter);
        foreach ($where_filter as $field => $value)
        {
            $terms--;
            $vars = (is_int($value))?$value: "\"$value\"";
             
            $queryStr .= $field . ' = ' . $vars;
            if ($terms)
            {
                $queryStr .= ' AND ';
            }
        }
        return $queryStr;
    }
    public function get_for_demodb()
    {
        // getrole_id()
        $data = $this->db->select('t1.id,t1.title')
        ->from('exal as t1')
        ->join('exal_assign_user as t2','t2.exal_id=t1.id')
        ->where('t2.user_id',$this->session->userdata('admin_id'))
        ->get()->result_array();
         if($data){
            $response = ['status'=>true,'message'=>'Success','records'=>$data];
        }
        else{
            $response = ['status'=>false,'message'=>'No records found','records'=>[]];
        }
        return $response;
    }
}