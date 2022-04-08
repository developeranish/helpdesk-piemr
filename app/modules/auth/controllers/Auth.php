<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {

	public function __construct(){
	    parent::__construct(); 
	    $this->load->model('Auth_model'); 
        $this->load->helper('emails'); 
        $this->load->helper('blog'); 
        $this->load->helper('reviews');
        $this->load->helper('yelp');
        $this->load->helper('chat');
        $this->load->helper('media');
	}
	    
	
	public function index(){
		$this->load->view('auth/login'); 
	}
    public function registration(){
		$this->load->view('auth/Registration'); 
	}
}