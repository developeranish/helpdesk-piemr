<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search_model extends CI_Model {

	public function __construct(){
	    parent::__construct(); 
	}

	public function get_total_products($term=''){
		$this->db->select('count(product_id) count');
		$this->db->where('status','active');
		$this->db->where("name LIKE '%$term%'");
		$this->db->or_where("short LIKE '%$term%'");
		$this->db->or_where("desp LIKE '%$term%'");
	    return $this->db->get("products"); 
	} 

    public function get_current_page_records($term='',$limit, $start) 
    {	
		$this->db->where('status','active');
		if($term!=''){
			$this->db->where("name LIKE '%$term%'");
			$this->db->or_where("short LIKE '%$term%'");
			$this->db->or_where("desp LIKE '%$term%'");
        }
        $this->db->limit($limit, $start);
        $query = $this->db->get("products");
        if ($query->num_rows() > 0) 
        {
            foreach ($query->result() as $row) 
            {
                $data[] = $row;
            }
             
            return $data;
        }
 
        return false;
    }

}
