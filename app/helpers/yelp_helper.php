<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//get all yelp reviews //
if ( ! function_exists('get_yelp_reviews_front')){

	function get_yelp_reviews_front(){
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://api.yelp.com/v3/businesses/5H7vfy1kCUKTJnasy71DLg/reviews",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_POSTFIELDS => "",
			CURLOPT_HTTPHEADER => array(
				"Authorization: Bearer o5tZRf_MIio0NJGBE4OFvWX5d70RmkF6e-KLVsiBLu9IJHnHVU5kTFHoS83bqd13w4TKgFqW_uto0R1W8dQ8wfj1g2_lO21eJBvtCnwdjaogU_vXHQ5HngrJZ4QUXnYx"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			return json_decode($response);
		}
  	}	//end function
}//get_yelp_reviews



