<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('get_watches_data')){
	function get_watches_data(){
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://swissmadecorp.com/api/products",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
		));

		$response = curl_exec($curl);
		//var_dump($response);exit;
		//$res  = count(json_decode($response)->data);
		//$data_json = json_decode($response)->data;
		$err = curl_error($curl);
		curl_close($curl);

		$f = fopen($_SERVER['DOCUMENT_ROOT'].'/'.WATCHES_DATA.'watches_data.json', "wb");
		fwrite($f, $response);
		fclose($f);
		dump_watches_data();
	}
}


if(!function_exists('dump_watches_datas')){
	function dump_watches_data(){
		$counter=0;
		$data_json = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/'.WATCHES_DATA.'watches_data.json');
		$data_json = json_decode($data_json)->data;
		$CI = get_instance();
		$CI->db->query("TRUNCATE TABLE watch_data");

		if($data_json!=""){
			foreach ($data_json as $rec) {
				$watches_query = "INSERT INTO `watch_data` (`watch_id`, `title`, `model`, `reference`, `box`, `papers`, `material`, `condition`, `retail`, `price`, `status`, `gender`, `strap`, `slug`, `images`, `meta_title`, `meta_keywords`, `meta_desp`) VALUES (".$rec->id.", '".addslashes($rec->title)."', '".addslashes($rec->model)."', '".addslashes($rec->reference)."', '".addslashes($rec->box)."', '".addslashes($rec->papers)."', '".addslashes($rec->material)."', '".addslashes($rec->condition)."', '".addslashes($rec->retail)."', '".addslashes($rec->price)."', '".($rec->status=="Available"?"active":"")."', '".addslashes($rec->gender)."', '".$rec->strap."', '".addslashes($rec->slug)."', '".addslashes(json_encode($rec->images))."', '".addslashes($rec->title)."', '".addslashes($rec->title)."', '".addslashes($rec->title)."');";
				
				$CI->db->query($watches_query);
				$counter++;
			}
		}
		echo $counter." watches updated";
	}
}