<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends MY_Controller {

	public function __construct(){
	    parent::__construct();   
	    $this->load->model('search_model');
	    $this->load->model('jewelry/jewelry_model');
	  	$this->load->library('pagination'); 

	} 

	public function index(){ 
		front(); 
		$categories = $this->jewelry_model->categories();
		$categories = $this->obj2array($categories);
		$data['categories'] = $this->buildTree($categories);
		$data['price_range'] = min_max();
		$params = $this->pages();
		$data['products'] = $params['results'];
		$data['links'] = $params['links']; 
		 
		//render Home page
        $this->template->write('title', 'Jewelry | '.'Obalesh Solution', TRUE); 
        $this->template->add_meta('description', 'Jewelry | '.'Obalesh Solution',TRUE);
        $this->template->write_view('content', 'jewelry/jewels',$data,TRUE);
        $this->template->render(); 
	}

	private function buildTree(&$categories) { 
	      $map = array(
    	    0 => array('subcategories' => array())
	    );

	    foreach ($categories as &$category) {
	        $category['subcategories'] = array();
	        $map[$category['category_id']] = &$category;
	    }

	    foreach ($categories as &$category) {
	        $map[$category['parent']]['subcategories'][] = &$category;
	    }

	    return $map[0]['subcategories'];
	}

	private function obj2array($arr=''){
		$return = array();
		foreach($arr as $ar){
			$return[] = (array)$ar;
		}
		return $return;
	}


	private function pages(){
		$term = (get('query')) ? get('query') : '';
		$params = array();
        $start_index = (get('page')) ? get('page') : 0;
		$limit_per_page = 9;  
         
        $start_index = $start_index*$limit_per_page;
        $total_records = $this->search_model->get_total_products($term)->row()->count;
 		
        if ($total_records > 0) 
        {
            // get current page records
            $params["results"] = $this->search_model->get_current_page_records($term,$limit_per_page, $start_index); 
           
            $config['base_url'] = base_url() . 'search';
            $config['total_rows'] = $total_records;
            $config['per_page'] = $limit_per_page;
            $config["query_string_segment"] = 'page';
            
            // custom paging configuration
            $config['num_links'] = 2;
            $config['use_page_numbers'] = TRUE;
            $config['reuse_query_string'] = TRUE;
            $config['page_query_string'] = TRUE;
             
            $config['full_tag_open'] = '<div class="pagi-nav text-center">';
            $config['full_tag_close'] = '</div>';
             
            $config['first_link'] = 'First Page';
            $config['first_tag_open'] = '<span class="firstlink">';
            $config['first_tag_close'] = '</span>';
             
            $config['last_link'] = 'Last Page';
            $config['last_tag_open'] = '<span class="lastlink">';
            $config['last_tag_close'] = '</span>';
             
            $config['next_link'] = '<i class="fa fa-chevron-right" aria-hidden="true"></i>';
            $config['next_tag_open'] = '<span class="nextlink">';
            $config['next_tag_close'] = '</span>';
 
            $config['prev_link'] = '<i class="fa fa-chevron-left" aria-hidden="true"></i>';
            $config['prev_tag_open'] = '<span class="prevlink">';
            $config['prev_tag_close'] = '</span>';
 
            $config['cur_tag_open'] = '<span class="curlink">';
            $config['cur_tag_close'] = '</span>';
 
            $config['num_tag_open'] = '<span class="numlink">';
            $config['num_tag_close'] = '</span>';

            $this->pagination->initialize($config);
             
            // build paging links
           $params["links"]  = $this->pagination->create_links();
        } 
         
        return $params;
	} 
}
