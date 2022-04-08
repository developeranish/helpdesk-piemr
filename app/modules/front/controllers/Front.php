<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Front extends MY_Controller {

	public function __construct(){
	    parent::__construct(); 
	    $this->load->model('front_model'); 
        $this->load->helper('emails'); 
        $this->load->helper('blog'); 
        $this->load->helper('reviews');
        $this->load->helper('yelp');
        $this->load->helper('chat');
        $this->load->helper('media');
        // $this->output->cache(60);  
	}
	    
	/** load front page -- homepage-- **/
	public function index(){
		front(); 
		$this->template->write('title', 'Dashboard', TRUE); 
        $this->template->add_meta('description', 'Main Page',TRUE);
        $this->template->write_view('content', 'front/showcase');
        $this->template->render(); 
	}
}