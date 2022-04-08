<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Custom_404 extends MY_Controller {

	public function __construct(){
	    parent::__construct();    
        $this->load->model('front/front_model'); 
	} 

    public function index() {   
        $CI =& get_instance(); 

        front(); 
        $data=array();
        // data 
        // $data['categories'] = $CI->front_model->categories();
        
        // if(isset($CI->session->userdata['logged_in'])){
        //     $data['user'] = $CI->session->userdata['logged_in'];            
        // }
        //render Home page
        $CI->template->write('title', FRONT_TITLE, TRUE); 
        $CI->template->add_meta('description', '404 Not Found',TRUE);
        $CI->template->write_view('content', '404',$data,TRUE);
        $CI->template->render();  
        echo $CI->output->get_output();
        exit;
    }
    

    //Loading assets
        

       
}
