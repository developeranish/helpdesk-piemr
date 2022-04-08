<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//get all yelp reviews //
if ( ! function_exists('get_yelp_reviews')){

	function get_yelp_reviews(){
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://yelpapiserg-osipchukv1.p.rapidapi.com/getAutocomplete",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "",
			CURLOPT_HTTPHEADER => array(
				"content-type: application/x-www-form-urlencoded",
				"x-rapidapi-host: YelpAPIserg-osipchukV1.p.rapidapi.com",
				"x-rapidapi-key: ".YELP_KEY
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


//get all yelp reviews //
if ( ! function_exists('get_ivouch_reviews')){

	function get_ivouch_reviews(){
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "http://open.ivouch.com/api/topic/".IVOUCH_TOPIC.".json?key=".IVOUCH_KEY."&reviews=".IVOUCH_NUM_REVIEWS,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_POSTFIELDS => "",
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			return json_decode($response, true);
		}
		/*$reviews = array(
			"profile_url"=>"http://www.ivouch.com/sashka-jewelry-new-york-ny-us",
			"reviews"=>array(
					array("text"=>"Incredibly kind and professional, great quality in Jewelery! Will be buying from them for a lifetime", "rating"=>"50","user_name"=>"V.M."),
					array("text"=>"Isaac and his team were wonderful", "rating"=>"50","user_name"=>"R.B."),
					array("text"=>"I read about Isaac in a wedding planner article and decided to give him a call. He had gotten glowing reviews and quickly felt comfortable with him. Very knowledgeable and happy to spend time educating me on a variety of factors (waay beyond the '4 C's'). On a business trip to NYC we had a chance to meet and I could not have been more impressed. Clearly Isaac has worked with a variety of client's budgets and will create a ring based on what YOU want to spend.", "rating"=>"50","user_name"=>"Bill K."),
					array("text"=>"I have bought several pieces from Sashka and it is always a pleasure. I have been very happy with the quality, service and price. Isaac is very helpful in helping pick out the right piece, and if he doesn't have it will have it custom made. Will definitely be coming back.", "rating"=>"50","user_name"=>"Jonathan K."),
					array("text"=>"We could not be happier with Sashka and feel so lucky to have found Isaac. The diamond district can be an intimidating place. Fortunately we had a referral to these outstanding folks. They made the process transparent and easy and we ended up with a considerably nice and more valuable ring than we ever thought possible at the beginning of our search. Thank you so much!", "rating"=>"50","user_name"=>"John C.")
				)
		);
		return $reviews;*/

  	}	//end function
}//get_ivouch_reviews

