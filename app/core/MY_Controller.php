<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* load the MX_Router class */
require APPPATH . "third_party/MX/Controller.php";

class MY_Controller extends MX_Controller
{	

	function __construct() 
	{
		parent::__construct();
		$this->_hmvc_fixes(); 		
		$data = array();
		$data['logo'] = "sadsad";
        $this->template->write('title', 'Faculty Helpdesk');
        if($this->router->fetch_class()=='front')
        	$this->social_meta();
        $this->template->add_social_meta('twitter:card', 'summary_large_image');
	    $this->template->add_social_meta('twitter:site', "@Faculty Helpdesk");
	    $this->template->add_social_meta('twitter:creator', "@Faculty Helpdesk");
	    $this->template->add_social_meta('twitter:domain', "'".base_url()."'"); 
	    

        //it is better to include header and footer here because these will be used by every page

        $this->template->write_view('topnav', 'templates/snippets/topnav',TRUE);
        $this->template->write_view('navbar', 'templates/snippets/navbar', $data, TRUE);
        $this->template->write_view('footer', 'templates/snippets/footer', $data, TRUE);
        $this->template->write_view('misc', 'templates/snippets/misc',TRUE);
    
	}
	
	function _hmvc_fixes()
	{		
		//fix callback form_validation		
		//https://bitbucket.org/wiredesignz/codeigniter-modular-extensions-hmvc
		$this->load->library('form_validation');
		$this->form_validation->CI =& $this;
	}

	function social_meta(){  
	    $this->template->add_social_meta('og:site_name', 'Faculty Helpdesk');
	    $this->template->add_social_meta('og:title', 'Faculty Helpdesk');
	    $this->template->add_social_meta('og:description', 'Faculty Helpdesk');
	    $this->template->add_social_meta('og:image', base_url("sync/images/products/rose-gold-floating-diamond-cluster-halo-stud-earrings-in-two-tone/rose-gold/509b79122f6a5867a136b9b61e5ab857.jpg"));
	    $this->template->add_social_meta('og:url', base_url());  

	    //twitter
	    $this->template->add_social_meta('twitter:card', 'summary_large_image');
	    $this->template->add_social_meta('twitter:site', "@Faculty Helpdesk");
	    $this->template->add_social_meta('twitter:title', 'Faculty Helpdesk');
	    $this->template->add_social_meta('twitter:description', 'Faculty Helpdesk');
	    $this->template->add_social_meta('twitter:creator', "@Faculty Helpdesk");
	    $this->template->add_social_meta('twitter:image', base_url("sync/images/products/rose-gold-floating-diamond-cluster-halo-stud-earrings-in-two-tone/rose-gold/509b79122f6a5867a136b9b61e5ab857.jpg"));
	    $this->template->add_social_meta('twitter:domain', base_url());

	}
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */