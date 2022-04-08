<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Common extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function logo_data(){
		$q = $this->db->query('SELECT * FROM logo LIMIT 1');
        if($q->num_rows() > 0)
        {
            return $q->result();
        }
        return array();
	}


    public function get_chat_data(){
        $q = $this->db->query('SELECT * FROM chat LIMIT 1');
        if($q->num_rows() > 0)
        {
            return $q->result();
        }
        return array();
    }

    public function get_media_ringbuilder($pid){
       return $this->db->query('select url from media where element_id = '.$pid.' and sort_order=0')->result(); 
    }
    
 
    // Return all records in the table
    public function get_all($table)
    {
        $q = $this->db->get($table);
        if($q->num_rows() > 0)
        {
            return $q->result();
        }
        return array();
    }

  

    // Return all records in the table
    public function get_where($table,$where=1)
    {   
        if($where!=1)
             $this->db->where($where);
        $q = $this->db->get($table);
        if($q->num_rows() > 0)
        {
            return $q->result();
        }
        return array();
    }
 
    // Return only one row
    public function get_row($table,$where=1)
    {
        $this->db->where($where);
        $q = $this->db->get($table);
        if($q->num_rows() > 0)
        {
            return $q->row();
        }
        return false;
    }
  
    // Return only one row
    public function get_count($table,$where=1)
    {
        $this->db->where($where);
        $q = $this->db->get($table); 
        return $q->num_rows();
    }

    // Return one only field value
    public function get_data($table,$where=1,$fieldname='*')
    {
        $this->db->select($fieldname);
        $this->db->where($where);
        $q = $this->db->get($table);
        if($q->num_rows() > 0)
        {
            return $q->result();
        }
        return array();
    }

    // Return one only field value
    public function get_data_row($table,$where=1,$fieldname='*')
    {
        $this->db->select($fieldname);
        $this->db->where($where);
        $q = $this->db->get($table);
        if($q->num_rows() > 0)
        {
            return $q->row();
        }
        return array();
    }
 
    // Insert into table
    public function add($table,$data)
    {
         $this->db->insert($table, $data);
         return $this->db->insert_id();
    }


    // Insert into table
    public function add_batch($table, $data)
    {
         $this->db->insert_batch($table, $data);
         return $this->db->insert_id();
    }
 
    // Update data to table
    public function update($table,$data,$primaryfield,$id)
    {
        $this->db->where($primaryfield, $id);
        $q = $this->db->update($table, $data);
        return $q;
    }
 
    // Delete record from table
    public function delete($table,$where=1)
    {
    	$this->db->where($where);
    	return $this->db->delete($table);
    }
 
    // Check whether a value has duplicates in the database
    public function has_duplicate($value, $tabletocheck, $fieldtocheck)
    {
        $this->db->select($fieldtocheck);
        $this->db->where($fieldtocheck,$value);
        $result = $this->db->get($tabletocheck);
 
        if($result->num_rows() > 0) {
            return true;
        }
        else {
            return false;
        }
    }
 
    // Check whether the field has any reference from other table
    // Normally to check before delete a value that is a foreign key in another table
    public function has_child($value, $tabletocheck, $fieldtocheck)
    {
        $this->db->select($fieldtocheck);
        $this->db->where($fieldtocheck,$value);
        $result = $this->db->get($tabletocheck);
 
        if($result->num_rows() > 0) {
            return true;
        }
        else {
            return false;
        }
    }

    public function global_search($term='',$category=''){
        //  $query =  $this->db->select('product_name,product_slug,product_id,product_price,product_sale_price')
                    // ->where("product_name like '%".$term."%'");

        //Search filter text for like %
        $search_arr = array();
        $search_arr = explode(' ', $term);
        $search_txt = '';
        foreach($search_arr as $s){
                $search_txt = $search_txt.'%'.$s.'%';
        }

        $res =  $this->db->query('SELECT *, 
                                    products.product_id AS pro_id, 
                                    Count(products.metal_color), 
                                    MD.url                  AS image 
                            FROM   products 
                                    JOIN media MD 
                                    ON products.product_id = MD.element_id 
                            WHERE  products.status = "active"
                                    AND ( products.name LIKE "'.$search_txt.'"
                                        OR products.metal_color LIKE "'.$search_txt.'"
                                        OR products.sku LIKE "'.$search_txt.'" ) 
                                    AND MD.element_type = "product" 
                                    AND MD.type = 1 
                                    AND MD.sort_order IN ( 0, 1 ) 
                            GROUP  BY products.group_id 
                            ORDER  BY Field(products.metal_color, "14K-Rose-Gold", "14K-White-Gold", 
                                    "14K-Yellow-Gold", "platinum"), 
                                    products.product_id DESC, 
                                    Count(products.metal_color) DESC LIMIT 11');
           
        // echo vd();
        // if($category!='' && $category!=1)
        //     $this->db->where('category_slug',$category)->group_by('group_id');
        // $this->db->limit(10);
        // $res = $this->db->get('view_product')->result();
        return $res->result();
    }

    public function save_form_to_table($post_data, $table)
    {
        $data = [];
        foreach ($post_data as $key=>$value){
            $data[$key] = $value;
        }
        $CI =& get_instance(); 
        $res = $CI->db->insert($table, $data);
        if($res)
            return true;
        else
            return false;
    }
}
