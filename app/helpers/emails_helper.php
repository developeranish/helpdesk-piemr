<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function send_email($to='mark@belgiumgroup.net',$subject='test',$message='Testing the email class.',$from='webnetbelgium@gmail.com'){
	$CI = get_instance();
	$config = Array(
    'protocol' => 'smtp',
    'smtp_host' => 'ssl://smtp.googlemail.com',
    'smtp_port' => 465,
    'smtp_user' => $from,
    'smtp_pass' => 'Webnetgmail@2020',
    'mailtype'  => 'html',
    'charset'   => 'iso-8859-1'
	);
    $CI->load->library('email');
    $CI->email->initialize($config);
	$CI->email->set_newline("\r\n");
	$CI->email->from($from, 'Obalesh Solution');
    $CI->email->to($to); 

    $CI->email->subject($subject);
    $CI->email->message($message);  

	// Set to, from, message, etc.

	$result = $CI->email->send();
    
    return $result;
}

