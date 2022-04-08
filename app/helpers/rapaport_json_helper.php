<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('rapaport_inventory')){
	function rapaport_inventory($create_json="") {
		$pages = get_page_count('69975','wissam130');
		for($i=1;$i<=$pages;$i++){
			rapaport_curl_call('69975','wissam130',$i, 50, 'price', 'Asc', $create_json);
		}
	}
}

if ( ! function_exists('get_page_count();')){
	function get_page_count($username, $password){
		$curl = curl_init();

		curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://technet.rapaport.com/HTTP/JSON/RetailFeed/GetDiamonds.aspx",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 300,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS =>json_encode(array ( 'request' => 
			                              array 
			                                ( 'header' => 
			                                array ('username' => '69975', 'password' => 'wissam130', ), 
			                                'body' =>
			                                 array ('page_number' => 1, 'page_size' => 1)
			                                )
			                            )),
			  CURLOPT_HTTPHEADER => array(
			    "cache-control: no-cache",
			    "content-type: application/x-www-form-urlencoded",
			    "postman-token: 85fd30dc-0f21-93fc-fc76-c5c6e59f1e41"
			  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		if ($err) {
				echo "cURL Error #:" . $err;
			} 
		else {
			$tmp = json_decode($response, true);
			$res_summery = $tmp['response']['body']['search_results'];
			$total_diamonds_found = $res_summery['total_diamonds_found'];
			$loopCounter = intdiv($total_diamonds_found, 50) + ($total_diamonds_found%50!=0?1:0);
			return $loopCounter;
		}
	}
}


if ( ! function_exists('rapaport_curl_call')){
	function rapaport_curl_call($username, $password, $page_number, $page_size,$sort_by,$sort_direction,$create_json="") {
		if($create_json=="") {
		 
		$curl = curl_init();

		curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://technet.rapaport.com/HTTP/JSON/RetailFeed/GetDiamonds.aspx",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 300,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS =>json_encode(array ( 'request' => 
			                              array 
			                                ( 'header' => 
			                                array ('username' => $username, 'password' => $password), 
			                                'body' =>
			                                 array ('page_number' => $page_number, 'page_size' => $page_size)
			                                )
			                            )),
			  CURLOPT_HTTPHEADER => array(
			    "cache-control: no-cache",
			    "content-type: application/x-www-form-urlencoded",
			    "postman-token: 85fd30dc-0f21-93fc-fc76-c5c6e59f1e41"
			  ),
		));

		$response = curl_exec($curl);

		$err = curl_error($curl);

		curl_close($curl);
		if ($err) {
				echo "cURL Error #:" . $err;
			} 
		else {
			$tmp = json_decode($response, true);
			$res_diamonds = $tmp['response']['body']['diamonds'];
		   if($res_diamonds!=''){
		   		rapa_res_data($res_diamonds, $page_number);
		   }
		}
	}
	}
}




if (!function_exists('rapa_res_data')){
	function rapa_res_data($data='', $page_number) { 
		 $fp = fopen($_SERVER['DOCUMENT_ROOT'].'/'.DIAMOND_DATA.'/rapa/rapaport_diamond'.$page_number.'.json', 'wb');
		 if(fwrite($fp, json_encode($data, TRUE)))
		 	fclose($fp);
	}
}
?>