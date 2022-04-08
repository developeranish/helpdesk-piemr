<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	// Helper For print_r
	function pr($var = '')
	{
		echo "<pre>";
		   print_r($var);	
		echo "</pre>";
	    // die();	
	}

	//Helper For base_url()
	function bs($value = '')
	{
		// public $url = ""
		echo base_url($value);
	}

	//Helper for $this->load->view()
	function view($value='', $data=array(), $output = false)
	{
		$CI =& get_instance();
		$CI->load->view($value,$data,$output);
	}

	//Helper For thsi->input->post()
	function post($value='')
	{
		$CI =& get_instance();
	    return $CI->input->post($value);
	}

	//Helper For thsi->input->get()
	function get($value='')
	{
		$CI =& get_instance();
	    return $CI->input->get($value);
	}

	//helper for var_dump
    function dd($value='')
	{
		echo "<pre>";
		   var_dump($value);	
		echo "</pre>";
		die();
	}

	//Helper for last_query()
	function vd()
	{
		$CI =& get_instance();
		return $CI->db->last_query();
	}
	function group_priviliges($value='')
	{
		$CI =& get_instance();

		$gp_id = $CI->session->userdata("group_id");

		$gp_result = $CI->ion_auth_model->user_gp_privilegs($gp_id);

		$gp_data = array();
		   
      	foreach($gp_result as $value)
        {
           //add all data to session
           $gp_data[] = $value->perm_name;

        }

	    return $gp_data;
	}
	function has($val)
	{
		if ($val) 
		{
			return true;
		}
		return false;
	}

	/**
	 * Slugify Helper
	 *
	 * Outputs the given string as a web safe filename
	 */
	if ( ! function_exists('slugify'))
	{
		function slugify($string, $replace = array(), $delimiter = '-', $locale = 'en_US.UTF-8', $encoding = 'UTF-8') {
			if (!extension_loaded('iconv')) {
				throw new Exception('iconv module not loaded');
			}
			// Save the old locale and set the new locale
			$oldLocale = setlocale(LC_ALL, '0');
			setlocale(LC_ALL, $locale);
			$clean = iconv($encoding, 'ASCII//TRANSLIT', $string);
			if (!empty($replace)) {
				$clean = str_replace((array) $replace, ' ', $clean);
			}
			$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
			$clean = strtolower($clean);
			$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
			$clean = trim($clean, $delimiter);
			// Revert back to the old locale
			// setlocale(LC_ALL, $oldLocale);
			return $clean;
		}
	} 

	  function do_upload($img=null,$path='./uploads/',$multi=false,$allowed='gif|jpg|png|jpeg|tif|mp4|wma|mov|avi|flv') { 

	    if($multi==false){
	         $config['upload_path']   = $path; 
	         $config['allowed_types'] =  $allowed; 
	         $config['max_size']      = 9000000000;  
	         $config['encrypt_name'] = TRUE;

	         
	         $CI = get_instance();
	         $redirect = $this->router->fetch_class().'/'.$CI->router->fetch_method();
			 $CI->load->library('upload', $config); 
				
	         if ( ! $CI->upload->do_upload($img)) {
	            return $CI->upload->display_errors();
	         }
				
	         else { 
	            return $CI->upload->data();
	         } 
     	}
         else{
         if(!empty($_FILES[$img]['name'])){
            $filesCount = count($_FILES[$img]['name']);
            $images = array();
            for($i = 0; $i < $filesCount; $i++){
                $_FILES['file']['name']     = $_FILES[$img]['name'][$i];
                $_FILES['file']['type']     = $_FILES[$img]['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES[$img]['tmp_name'][$i];
                $_FILES['file']['error']    = $_FILES[$img]['error'][$i];
                $_FILES['file']['size']     = $_FILES[$img]['size'][$i];
                
                // File upload configuration
                $uploadPath = $path;
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = 'gif|jpg|png|jpeg|tif|mp4|wma|mov|avi|flv'; 
                $config['encrypt_name'] = TRUE; 
                $config['max_size']      = 9000000000; 

                // Load and initialize upload library
                $CI = get_instance();
                $redirect = $CI->router->fetch_class().'/'.$CI->router->fetch_method();
                $CI->load->library('upload', $config);
                $CI->upload->initialize($config);

                if ( ! $CI->upload->do_upload('file')) {
                	set_flashdata('error',$CI->upload->display_errors()); 
           			redirect('product/create'); 
		         } 
		         else { 
		            $images[] = $CI->upload->data();
		            $images[$i]['clear_path'] = $path.'/'.$CI->upload->data('file_name');
		         } 
           	 }
           	 return $images;
          }  
      } 
   }   

    
function contains( $needle, $haystack ) {
    return preg_match( '#\b' . preg_quote( $needle, '#' ) . '\b#i', $haystack ) !== 0;
}

if ( ! function_exists('get_client_ip'))
	{
	function get_client_ip() {
	    $ipaddress = '';
	    if (isset($_SERVER['HTTP_CLIENT_IP']))
	        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
	        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	    else if(isset($_SERVER['HTTP_X_FORWARDED']))
	        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
	        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	    else if(isset($_SERVER['HTTP_FORWARDED']))
	        $ipaddress = $_SERVER['HTTP_FORWARDED'];
	    else if(isset($_SERVER['REMOTE_ADDR']))
	        $ipaddress = $_SERVER['REMOTE_ADDR'];
	    else
	        $ipaddress = 'UNKNOWN';
	    return $ipaddress;
	}
}


 function getTransactionId($n) { 
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
        $randomString = '';
        for ($i = 0; $i < $n; $i++) { 
            $index = rand(0, strlen($characters) - 1); 
            $randomString .= $characters[$index]; 
        }
        return $randomString; 
}

function array_flatten($array) { 
  if (!is_array($array)) { 
    return FALSE; 
  } 
  $result = array(); 
  foreach ($array as $key => $value) { 
    if (is_array($value)) { 
      $result = array_merge($result, array_flatten($value)); 
    } 
    else { 
      $result[$key] = $value; 
    } 
  } 
  return $result; 
} 

function custom_404(){
	redirect('custom_404/index');
}
	
function clean($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}	

function decToFraction($float,$array=false,$prefix='Carat',$separator=',') {
    // 1/2, 1/4, 1/8, 1/16, 1/3 ,2/3, 3/4, 3/8, 5/8, 7/8, 3/16, 5/16, 7/16,
    // 9/16, 11/16, 13/16, 15/16
	if($array){
		$return = [];
		foreach($float as $flt):
			$return[] = decToFraction($flt,false).' '.$prefix;	
		endforeach;	
		return implode($separator, $return);
	}else{	
	    $whole = floor ( $float );
	    $decimal = $float - $whole;
	    $leastCommonDenom = 48; // 16 * 3;
	    $denominators = array (2, 3, 4, 8, 16, 24, 48 );
	    $roundedDecimal = round ( $decimal * $leastCommonDenom ) / $leastCommonDenom;
	    if ($roundedDecimal == 0)
	        return $whole;
	    if ($roundedDecimal == 1)
	        return $whole + 1;
	    foreach ( $denominators as $d ) {
	        if ($roundedDecimal * $d == floor ( $roundedDecimal * $d )) {
	            $denom = $d;
	            break;
	        }
	    }
	    return ($whole == 0 ? '' : $whole) . " " . ($roundedDecimal * $denom) . "/" . $denom;
	}    
}
/* End of file custom_helpers.php */
/* Location: ./application/helpers/custom_helpers.php */