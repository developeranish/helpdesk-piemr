<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('chat')){
    function chat(){
        $CI = get_instance();  
        $CI->db->query("SELECT * FROM chat LIMIT 1");  
        return $CI->result();
    }
}