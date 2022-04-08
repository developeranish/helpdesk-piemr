<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('curl_call')){
	function curl_call($url='') {
		 $curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://www.belgiumny.com/api/DeveloperAPI?stock=&APIKEY=B6F7AD04-70D4-28EF-B548-64A2DC8D4FFD",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 5000,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_POSTREDIR => 3, 
		  CURLOPT_FOLLOWLOCATION => TRUE,


		//  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_HTTPHEADER => array(
		    "cache-control: no-cache",
		    "postman-token: 35a44445-246d-7c16-ab03-06ece4e4c991"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		   if($response!='')
		   		res_data($response);
		}
		 
	}
}




if ( ! function_exists('call_inventory')){
	function call_inventory() {
		curl_call('https://www.belgiumny.com/api/DeveloperAPI?stock=&APIKEY=B6F7AD04-70D4-28EF-B548-64A2DC8D4FFD'); 
		exit;
	}
}


if ( ! function_exists('res_data')){
	function res_data($data='') { 
		
		 $fp = fopen($_SERVER['DOCUMENT_ROOT'].'/'.DIAMOND_DATA.'diamond.json', 'w');
		 if(fwrite($fp, $data)){
		 		fclose($fp);
		 }
		 
		 dump_data(); 

	}
}


if ( ! function_exists('dump_data')){
	function dump_data($data='') { 
		  $data = fopen($_SERVER['DOCUMENT_ROOT'].'/'.DIAMOND_DATA.'diamond.json', "r") or die("Unable to open file!");
		  $data_json  =   fread($data,filesize($_SERVER['DOCUMENT_ROOT'].'/'.DIAMOND_DATA.'diamond.json'));
		  fclose($data);


		  $single_stock = json_decode($data_json)->Stock;
		  if(!empty($single_stock)){
		  	$CI = get_instance();  
		  	$CI->db->query("TRUNCATE TABLE `diamond_data` ");  
		  	foreach ($single_stock as $key => $val) {  
	  			$actual_price = ($val->Memo_Price*$val->Weight);
	  			$val->actual_price = ($actual_price*0.30)+$actual_price;
	  			if($val->ImageLink	!='' && valid_img($val->ImageLink)){
	  				if($CI->db->insert('diamond_data',$val))
	  					copy_diamond_img($val->ImageLink,$val->Stock_No); 
	  			}
	  			else{
	  				echo "Stock No : ".$val->Stock_No." Path: ".$val->ImageLink;
	  			}
	  		}

		  }

		}  
	}

	

 function valid_img($url='',$shape=''){ 
	if (@getimagesize($url))
		return true;
	else
		return false;
 } 
 function copy_diamond_img($url='',$stock=''){ 
 	if($url!='' && $stock!=''){
 		if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/'.DIAMOND_IMG_UPLOAD.$stock.'.'.pathinfo($url, PATHINFO_EXTENSION))){ 
 			if(copy($url, $_SERVER['DOCUMENT_ROOT'].'/'.DIAMOND_IMG_UPLOAD.$stock.'.'.pathinfo($url, PATHINFO_EXTENSION))){
 			 		if(thumb(DIAMOND_IMG_UPLOAD.$stock.'.'.pathinfo($url, PATHINFO_EXTENSION),270,270)){
 			 			if(thumb(DIAMOND_IMG_UPLOAD.$stock.'.'.pathinfo($url, PATHINFO_EXTENSION),110,110)){ 
 			 			}
 			 	}
 			} 	// copy end main flie			
 		}
 	}	
 }
 
 function shape_img($shape){ 
      if($shape=='ASSCHER')
         return 'assets/images/shape/ASSCHER.jpg'; 
      else if($shape=='CUSHION') 
      	return 'assets/images/shape/CUSHION.jpg';
      else if($shape=='EMERALD')
       return 'assets/images/shape/EMERALD.jpg';
      else if($shape=='HEART')
         return 'assets/images/shape/HEART.jpg';
      else if($shape=='MARQUISE')
         return 'assets/images/shape/MARQUISE.jpg';
      else if($shape=='OVAL')
         return 'assets/images/shape/OVAL.jpg';
      else if($shape=='PEAR')
         return 'assets/images/shape/PEAR.jpg';
      else if($shape=='PRINCESS')
         return 'assets/images/shape/PRINCESS.jpg';
      else if($shape=='RADIANT')
         return 'assets/images/shape/RADIANT.jpg';
      else if($shape=='Round' || $shape=='RBC' || $shape=='ROUND')
         return 'assets/images/shape/ROUND.jpg';
    }