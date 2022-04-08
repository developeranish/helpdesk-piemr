<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('rapaport_inventory')){
	function rapaport_dumper() {
		$pages = get_page_count('69975','wissam130');
		for($i=1;$i<=$pages;$i++){
			rapaport_data_dumper($i);
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
				return 0;
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


if ( ! function_exists('rapaport_data_dumper')){
	function rapaport_data_dumper($page_number)
	{
		/*$data = fopen($_SERVER['DOCUMENT_ROOT'].'/'.DIAMOND_DATA.'/rapa/rapaport_diamond'.$page_number.'.json', "r") or die("Unable to open file!");
		$data_json  =   fread($data,filesize($_SERVER['DOCUMENT_ROOT'].'/'.DIAMOND_DATA.'/rapa/rapaport_diamond'.$page_number.'.json'));
		fclose($data);*/

		$data = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/'.DIAMOND_DATA.'/rapa/rapaport_diamond'.$page_number.'.json');
		$data_json = json_decode($data, TRUE);

		foreach ($data_json as $single_stock) {
		  	if(!empty($single_stock)){
			  	//$imagelink = "https://dnalink.in/Imaged/".$single_stock['stock_num']."/still.jpg";
	  			if(valid_img1($single_stock['image_file_url'])){
	  				if(rapa_create_query($single_stock)){
	  					copy_diamond_img1($single_stock['image_file_url'], $single_stock['stock_num']);
	  				}
	  			}
				else{
					if(rapa_create_query($single_stock, true)){
	  					copy_diamond_img1($single_stock['image_file_url'], $single_stock['stock_num']);
	  				}
	  			}
	  			/*if($single_stock['image_file_url']!=""){
	  				var_dump($single_stock);
	  				echo "<hr/>";
	  			}*/
			}
		}	//end for
	}
}


 function valid_img1($url='',$shape=''){ 
	if (@getimagesize($url))
		return true;
	else
		return false;
 }

 function copy_diamond_img1($url='',$stock=''){ 
 	if($url!='' && $stock!=''){
 		if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/'.DIAMOND_IMG_UPLOAD.$stock.'.'.pathinfo($url, PATHINFO_EXTENSION))){ 
 			if(copy($url, $_SERVER['DOCUMENT_ROOT'].'/'.DIAMOND_IMG_UPLOAD.$stock.'.'.pathinfo($url, PATHINFO_EXTENSION))){
 			 		if(thumb(DIAMOND_IMG_UPLOAD.$stock.'.'.pathinfo($url, PATHINFO_EXTENSION),270,270)){
 			 			if(thumb(DIAMOND_IMG_UPLOAD.$stock.'.'.pathinfo($url, PATHINFO_EXTENSION),110,110)){ 
 			 			}
 			 	}
 			}		
 		}
 	}	
 }


if ( ! function_exists('rapa_create_query')){
	function rapa_create_query($json='', $image_not_found=false){
		$CI = get_instance();
		/*$per_carat_price = ($json['total_sales_price_in_currency']*100)/($json['size']*100);
	  	$json['actual_price'] = $per_carat_price;*/
	  	//$actual_price = $json['total_sales_price_in_currency'];
		//$diamond_query = "INSERT INTO `diamond_data` (`stock_no`, `availability`, `shape`, `weight`, `color`, `clarity`, `cut_grade`, `polish`, `symmetry`, `fluorescence_intensity`, `fluorescence_color`, `measurements`, `lab`, `certificate`, `treatment`, `memo_price`, `memo_discount_per`, `buy_price`, `buy_price_discount_per`, `cod_buy_price`, `cod_buy_price_discount_per`, `fancycolor`, `fancy_color_intensity`, `fancycolorovertone`, `depth_per`, `table_per`, `girdle_min`, `girdle_max`, `girdle_per`, `girdle_condition`, `culet_size`, `culet_condition`, `crown_height`, `crown_angle`, `pavilion_depth`, `pavilion_angle`, `laserinscription`, `cert_comments`, `country`, `state`, `city`, `time_to_location`, `lsmatchedpairseparable`, `country_of_origin`, `pair_stock`, `allow_raplink_feed`, `parcel_stones`, `certificatelink`, `imagelink`, `videolink`, `key_to_symbols`, `shade`, `star_length`, `center_inclusion`, `black_inclusion`, `member_comments`, `report_issue_date`, `report_type`, `lab_location`, `brand`, `milky`, `eye_clean`, `sarine_name`, `internal_clarity_desc_code`, `clarity_description`, `gemprint_id`, `bgm`, `modified_rate`, `wire_discount_price`, `actual_price`) VALUES  ('".$json['stock_num']."', '', '".$json['shape']."', '".$json['size']."', '". $json['color']."', '". $json['clarity']."', '".diamond_cutgrade_mapper($json['cut'])."', '".diamond_polish_mapper($json['polish'])."', '".diamond_symmetry_mapper($json['symmetry'])."', '".diamond_fluorescenceintensity_mapper($json['fluor_intensity'])."', '".diamond_fluorescencecolor_mapper($json['fluor_color'])."', '".$json['meas_width']." X ".$json['meas_depth']." X ".$json['meas_length']."', '".$json['lab']."', '".$json['cert_num']."', '', 0.00, 0.00, '".$json['actual_price']."', '".$json['actual_price']."', 0.00, '', '".diamond_fancycolor_mapper($json['fancy_color_dominant_color'])."', '".diamond_fancycolorintensity_mapper($json['fancy_color_intensity'])."', '".$json['fancy_color_overtone']."', '".$json['depth_percent']."', '".$json['table_percent']."', '".$json['girdle_min']."', '".$json['girdle_max']."', '', '".$json['girdle_condition']."', '".diamond_culetsize_mapper($json['culet_size'])."', '".diamond_culet_cond_mapper($json['culet_condition'])."', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '".($json['lab']=="GIA"?"https://dnalink.in/Imaged/certificate_Images/".$json['cert_num'].".pdf":"NULL")."', '".($json['lab']=="GIA"?"https://dnalink.in/Imaged/".$json['stock_num']."/still.jpg":"NULL")."', '".($json['lab']=="GIA"?"https://dnalink.in/Vision360.html?d=".$json['stock_num']."&v=2&sv=0,1,2,3,4&z=1&btn=1,2,3,5?s=100&sr=0":"NULL")."', '', 'None', '', '', '', '', '', '', '', '', '', '".($json['eye_clean']!=""?"Yes":"No")."', '', '', '', '', 'NO', '', '', '".$json['actual_price']."');";*/


$diamond_query = "INSERT INTO `diamond_data` (`stock_no`, `availability`, `shape`, `weight`, `color`, `clarity`, `cut_grade`, `polish`, `symmetry`, `fluorescence_intensity`, `fluorescence_color`, `measurements`, `lab`, `certificate`, `treatment`, `memo_price`, `memo_discount_per`, `buy_price`, `buy_price_discount_per`, `cod_buy_price`, `cod_buy_price_discount_per`, `fancycolor`, `fancy_color_intensity`, `fancycolorovertone`, `depth_per`, `table_per`, `girdle_min`, `girdle_max`, `girdle_per`, `girdle_condition`, `culet_size`, `culet_condition`, `crown_height`, `crown_angle`, `pavilion_depth`, `pavilion_angle`, `laserinscription`, `cert_comments`, `country`, `state`, `city`, `time_to_location`, `lsmatchedpairseparable`, `country_of_origin`, `pair_stock`, `allow_raplink_feed`, `parcel_stones`, `certificatelink`, `imagelink`, `videolink`, `key_to_symbols`, `shade`, `star_length`, `center_inclusion`, `black_inclusion`, `member_comments`, `report_issue_date`, `report_type`, `lab_location`, `brand`, `milky`, `eye_clean`, `sarine_name`, `internal_clarity_desc_code`, `clarity_description`, `gemprint_id`, `bgm`, `modified_rate`, `wire_discount_price`, `actual_price`) VALUES  ('".$json['stock_num']."', '', '".$json['shape']."', '".$json['size']."', '". $json['color']."', '". $json['clarity']."', '".diamond_cutgrade_mapper($json['cut'])."', '".diamond_polish_mapper($json['polish'])."', '".diamond_symmetry_mapper($json['symmetry'])."', '".diamond_fluorescenceintensity_mapper($json['fluor_intensity'])."', '".diamond_fluorescencecolor_mapper($json['fluor_color'])."', '".$json['meas_width']." X ".$json['meas_depth']." X ".$json['meas_length']."', '".$json['lab']."', '".$json['cert_num']."', '', 0.00, 0.00, '".$json['total_sales_price_in_currency']."', '".$json['total_sales_price_in_currency']."', 0.00, '', '".diamond_fancycolor_mapper($json['fancy_color_dominant_color'])."', '".diamond_fancycolorintensity_mapper($json['fancy_color_intensity'])."', '".$json['fancy_color_overtone']."', '".$json['depth_percent']."', '".$json['table_percent']."', '".$json['girdle_min']."', '".$json['girdle_max']."', '', '".$json['girdle_condition']."', '".diamond_culetsize_mapper($json['culet_size'])."', '".diamond_culet_cond_mapper($json['culet_condition'])."', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '',";
	
	//check if has certificate
	if($json['has_cert_file']==true)
		$diamond_query .= "'https://www.diamondselections.com/GetCertificate.aspx?diamondid=".$json['stock_num']."',";
	else
		$diamond_query .= "'' ,";

	//check if has image
	if($json['has_image_file']==true)
		$diamond_query .= "'".$json['image_file_url']."',";
	else
		$diamond_query .= "'".base_url("../sync/diamond/sample_images/sample_".strtolower($json['shape']).".jpg")."',";		


	$diamond_query .= "'' , '', 'None', '', '', '', '', '', '', '', '', '', '".($json['eye_clean']!=""?"Yes":"No")."', '', '', '', '', 'NO', '', '', '".$json['total_sales_price_in_currency']."');";

		$diamond_exists = $CI->db->select('stock_no')->where('stock_no', $json['stock_num'])->get('diamond_data')->num_rows();
		if($diamond_exists==0){
			if($CI->db->query($diamond_query))
			{
				//echo $json['stock_num'] ." Saved.<br/>";
				return true;
			}
			else{
				echo $diamond_query;
				echo "<hr/>";

				return false;
			}
		}
		else{
			echo "diamond exists in db = ".$json['stock_num'];
			echo "<hr/>";
			return false;
		}
	}
}



function diamond_allowraplinkfeed_mapper($val, $rev=1){
	if($rev==0)
		$arr = array (""=>"", 'Y'=>'Yes', 'N'=>'No');
	else
		$arr = array (""=>"", 'Yes'=>'Y', 'No'=>'N');
	return (array_key_exists($val, $arr)?$arr[$val]:"");
}



function diamond_availability_mapper($val, $rev=1){
	if($rev==0)
		$arr = array (""=>"", 'G'=>'Guaranteed Availability', 'M'=>'Out on Memo','STPS'=>'Subject to Prior Sale', 'NA'=>'Not Available');
	else
		$arr = array (""=>"", 'Guaranteed Availability'=>'G', 'GA,'=>'G','Out on Memo,'=>'M', 'Memo'=>'M','OnMemo'=>'M', 'On Memo'=>'M', 'Subject to Prior Sale'=>'STPS', 'Not Available'=>'NA', 'N'=>'NA', 'Unavailable'=>"NA");
	return (array_key_exists($val, $arr)?$arr[$val]:"");
}


function diamond_culet_cond_mapper($val, $rev=1){
	if($rev==0)
		$arr = array (""=>"", 'P'=>'Pointed', 'A'=>'Abraded','C'=>'Chipped');
	else
		$arr = array (""=>"",  'Pointed' => 'P', 'Abraded' => 'A', 'Chipped' => 'C');
	return (array_key_exists($val, $arr)?$arr[$val]:"");
}

function diamond_culetsize_mapper($val, $rev=1){
	if($rev==0)
		$arr = array (""=>"", 'EL' => 'Extremely Large','VL' => 'Very Large','L' => 'Large','SL' => 'Slightly Large','M' => 'Medium','S' => 'Small','VS' => 'Very Small','N' => 'None');
	else
		$arr = array (""=>"",  'Extremely Large' => 'EL', 'Very Large' => 'VL', 'Large' => 'L', 'Slightly Large' => 'SL', 'Medium' => 'M', 'Small' => 'S', 'Very Small' => 'VS', 'None' => 'NON');
	return (array_key_exists($val, $arr)?$arr[$val]:"");
}

function diamond_cutgrade_mapper($val, $rev=1){
	if($rev==0)
		$arr = array (""=>"", 'I'=> 'Ideal', 'I'=>'ID','EX' => 'Excellent', 'EX'=> 'EXC','VG' => 'Very Good','G' => 'Good','F' => 'Fair','P' => 'Poor');
	else
		$arr = array (""=>"",  'Ideal'=> 'I', 'ID' => 'I', 'EXC' => 'EX',  'Excellent' => 'EX', 'Very Good' => 'VG', 'Good' => 'G', 'Fair' => 'F', 'Poor' => 'P');

	return (array_key_exists($val, $arr)?$arr[$val]:"");
}

function diamond_displaycert_mapper($val, $rev=1){
	if($rev==0)
		$arr = array (""=>"", 'Y'=>'Yes', 'N'=>'No');
	else
		$arr = array (""=>"", 'Yes'=>'Y', 'No'=>'N');
	return (array_key_exists($val, $arr)?$arr[$val]:"");
}

function diamond_fancycolor_mapper($val, $rev=1){
	if($rev==0)
		$arr = array (""=>"", 'BK' => 'Black','B' => 'Blue','BN' => 'Brown','CH' => 'Chameleon','CM' => 'Champagne','CG' => 'Cognac','GY' => 'Gray','G' => 'Green','O' => 'Orange','P' => 'Pink','PL' => 'Purple','R' => 'Red','V' => 'Violet', 'GY' => 'Grey', 'Y' => 'Yellow', 'W' => 'WH', 'X' => 'OT');
	else
		$arr = array (""=>"",  'Black' => 'BK', 'Blue' => 'B', 'Brown' => 'BN', 'Chameleon' => 'CH', 'Champagne' => 'CM', 'Cognac' => 'CG', 'Gray' => 'GY', 'Green' => 'G', 'Orange' => 'O', 'Pink' => 'P', 'Purple' => 'PL', 'Red' => 'R', 'Violet' => 'V', 'Grey' => 'GY',  'Yellow' => 'Y', 'White' => 'W', 'Other' => 'X', 'WH' => 'W', 'OT' => 'X');

	

	return (array_key_exists($val, $arr)?$arr[$val]:"");
}

function diamond_fancycolorintensity_mapper($val, $rev=1){
	if($rev==0)
		$arr = array (""=>"", 'F' => 'Faint','VL' => 'Very Light','L' => 'Light','FCL'=> 'Fancy Light','FL' => 'Fancy Light','FC' => 'Fancy','FCD' => 'Fancy Dark','I' => 'Fancy Intense','FV' => 'Fancy Vivid','D' => 'Fancy Deep');
	else
		$arr = array (""=>"",  'Faint' => 'F', 'Very Light' => 'VL', 'Light' => 'L', 'Fancy Light' => 'FL', 'Fancy' => 'FC', 'FC'=>'FC', 'Fancy Dark' => 'FCD', 'Fancy Intense' => 'I', 'Fancy Vivid' => 'FV', 'Fancy Deep' => 'D', );
	return (array_key_exists($val, $arr)?$arr[$val]:"");
}

function diamond_fluorescencecolor_mapper($val, $rev=1){
	if($rev==0)
		$arr = array (""=>"", 'B' => 'Blue','W' => 'White','Y' => 'Yellow','O' => 'Orange','R' => 'Red','G' => 'Green','N' => 'None');
	else
		$arr = array (""=>"",  'Blue' => 'B', 'White' => 'W', 'WH'=>'W', 'Yellow' => 'Y', 'Orange' => 'O', 'Red' => 'R', 'Green' => 'G', 'None' => 'N', 'YL'=>'Y', 'OR'=>'O', 'BG'=>'G', 'NIL'=>'N', 'NON'=>'N');
	return (array_key_exists($val, $arr)?$arr[$val]:"");
}

function diamond_fluorescenceintensity_mapper($val, $rev=1){
	if($rev==0)
		$arr = array (""=>"", 'VS' => 'Very Strong', 'S' => 'Strong','M' => 'Medium','F' => 'Faint','SL' => 'SL','VSL' => 'Very Slight','N' => 'None');
	else
		$arr =array ( 'Very Strong' => 'VS','VST,' => 'VS','FL4' => 'VS', 'Strong' => 'S','STG' => 'S','ST' => 'S','FL3' => 'S', 'Medium' => 'M', 'MED' => 'M', 'FL2' => 'M', 'Faint' => 'F','FNT' => 'F','Negligible' => 'F','FA' => 'F','FL1' => 'F', 'SL' => 'SL', 'Slight' => 'SL', 'SLI' => 'SL', 'Very Slight' => 'VSL','VSLG' => 'VSL','VSLT' => 'VSL', 'None' => 'N');
	return (array_key_exists($val, $arr)?$arr[$val]:"");
}

function diamond_girdlecondition_mapper($val, $rev=1){
	if($rev==0)
		$arr = array (""=>"", 'P' => 'Polished', 'F' => 'Faceted', 'B' => 'Bruted');
	else
		$arr = array (""=>"",  'Polished' => 'P', 'Faceted' => 'F', 'Bruted' => 'B');
	return (array_key_exists($val, $arr)?$arr[$val]:"");
}
function diamond_girdlemax_mapper($val, $rev=1){
	if($rev==0)
		$arr = array (""=>"",  'XTK' => 'Extremely Thick', 'VTK' => 'Very Thick', 'TK' => 'Thick', 'STK' => 'Slightly Thick', 'M' => 'Medium', 'TN' => 'Thin', 'STN' => 'Slightly Thin', 'VTN' => 'Very Thin', 'XTN' => 'Extremely Thin');
	else
		$arr = array (""=>"", 'Extremely Thick' => 'XTK','Very Thick'=> 'VTK','Thick' => 'TK','Slightly Thick' => 'STK','Medium' => 'M', 'Thin' => 'TN','Slightly Thin' => 'STN','Very Thin'=> 'VTN','Extremely Thin' => 'XTN');
	return (array_key_exists($val, $arr)?$arr[$val]:"");
}


function diamond_girdlemin_mapper($val, $rev=1){
	if($rev==0)
		$arr = array (""=>"",  'XTK' => 'Extremely Thick', 'VTK' => 'Very Thick', 'TK' => 'Thick', 'STK' => 'Slightly Thick', 'M' => 'Medium', 'TN' => 'Thin', 'STN' => 'Slightly Thin', 'VTN' => 'Very Thin', 'XTN' => 'Extremely Thin');
	else
		$arr = array (""=>"", 'Extremely Thick' => 'XTK', 'Very Thick'=> 'VTK','Thick' => 'TK','Slightly Thick' => 'STK','Medium' => 'M', 'Thin' => 'TN','Slightly Thin' => 'STN','Very Thin'=>'VTN');
	return (array_key_exists($val, $arr)?$arr[$val]:"");
}

function diamond_ismatchedpairseparable_mapper($val, $rev=1){
	if($rev==0)
		$arr = array (""=>"", 'Y'=>'Yes', 'N'=>'No');
	else
		$arr = array (""=>"", 'Yes'=>'Y', 'No'=>'N');
	return (array_key_exists($val, $arr)?$arr[$val]:"");
}


function diamond_polish_mapper($val, $rev=1){
	if($rev==0)
		$arr = array (""=>"",  'P' => 'Poor', 'F' => 'Fair', 'F-G' => 'Fair to Good', 'G' => 'Good', 'G-VG' => 'Good to Very Good', 'VG' => 'Very Good', 'VG-EX' => 'Very Good to Excellent', 'EX' => 'Excellent', 'I' => 'I');

	else
		$arr = array (""=>"",  'Poor' => 'P', 'Fair' => 'F', 'Fair to Good' => 'F-G', 'Good' => 'G', 'Good to Very Good' => 'G-VG', 'Very Good' => 'VG', 'Very Good to Excellent' => 'VG-EX', 'Excellent' => 'EX', 'I' => 'I', "Ideal"=>"I");


	return (array_key_exists($val, $arr)?$arr[$val]:"");
}


function diamond_symmetry_mapper($val, $rev=1){
	if($rev==0)
		$arr = array (""=>"",  'P' => 'Poor', 'F' => 'Fair', 'F-G' => 'Fair to Good', 'G' => 'Good', 'G-VG' => 'Good to Very Good', 'VG' => 'Very Good', 'VG-EX' => 'Very Good to Excellent', 'EX' => 'Excellent', 'I' => 'I');

	else
		
		$arr = array (""=>"",  'Poor' => 'P', 'Fair' => 'F', 'Fair to Good' => 'F-G', 'Good' => 'G', 'Good to Very Good' => 'G-VG', 'Very Good' => 'VG', 'Very Good to Excellent' => 'VG-EX', 'Excellent' => 'EX', 'I' => 'I');

	return (array_key_exists($val, $arr)?$arr[$val]:"");
}

?>