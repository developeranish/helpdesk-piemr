<?php

function get_media($sku, $code){
		/*pr($sku);
		pr($code);*/
		
		$mediaArr = array("single_image"=>"", "single_video"=>"", "all_images"=>array(), "all_videos"=>array(), "order_images"=>array(), "order_videos"=>array(), "all_media"=>array());

		$image_video=$code['image_video'];

		//check if shape folder exists?
		$shape="";
		if($code['shape']!=""){
			if(is_dir("https://dl2vs6wk2ewna.cloudfront.net/scrap/overnight/".$sku."/".$shape."/")){
				$shape = $code['shape'];	
			}
			else{
				$shape="";
			}
		}
		
		$order = $code['order'];
		if($code['carat']==""){
			$carat = "100";
		}else{
			$carat = preg_replace("/[^0-9,.]/", "", $code['carat']) * 100;	//carat (1.25ctw = 125)
		}

		$na = 'https://dl2vs6wk2ewna.cloudfront.net/images/no-200_200.png';


		//1 = single image
		if($image_video=="1"){
			if($shape!="")
			{
				if($order!="")
				{
					$single_image = "https://dl2vs6wk2ewna.cloudfront.net/scrap/overnight/".$sku."/".$shape."/".$order.".jpg";
				}
				else{
					if($carat!=""){
						$single_image = "https://dl2vs6wk2ewna.cloudfront.net/scrap/overnight/".$sku."/".$shape."/".$carat.".jpg";
					}
					else
						$single_image = "https://dl2vs6wk2ewna.cloudfront.net/scrap/overnight/".$sku."/".$shape."/0.jpg";
				}
			}
			else{	//get default media
				if($order!="")
				{
					$single_image = "https://dl2vs6wk2ewna.cloudfront.net/scrap/overnight/".$sku."/".$order.".jpg";
				}
				else{
					$single_image = "https://dl2vs6wk2ewna.cloudfront.net/scrap/overnight/".$sku."/0.jpg";	
				}
			}


			$file_headers = @get_headers($single_image);
			if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
			    $mediaArr['single_image'] = $na;
			}
			else {
			    $mediaArr['single_image'] = $single_image;
			}

			// if (file_exists($single_image)) {
			// 	$mediaArr['single_image'] = $single_image;
			// }
			// //check jpg ext
			// elseif(file_exists(preg_replace('/\\.[^.\\s]{3,4}$/', '', $single_image).'.jpg')){
			// 	$mediaArr['single_image'] = preg_replace('/\\.[^.\\s]{3,4}$/', '', $single_image).'.jpg';
			// }
			// else{
			// 	$mediaArr['single_image'] = $na;
			// }

			

		}

		//2 = single video
		if($code['image_video']=="2"){
			if($shape!="")
			{
				if($order!="")
				{
					$single_image = "https://dl2vs6wk2ewna.cloudfront.net/scrap/overnight/".$sku."/".$shape."/".$order.".mp4";
				}
				else{
					$single_image = "https://dl2vs6wk2ewna.cloudfront.net/scrap/overnight/".$sku."/".$shape."/0.mp4";	
				}
			}
			else{	//get default media
				if($order!="")
				{
					$single_image = "https://dl2vs6wk2ewna.cloudfront.net/scrap/overnight/".$sku."/".$order.".mp4";
				}
				else{
					$single_image = "https://dl2vs6wk2ewna.cloudfront.net/scrap/overnight/".$sku."/0.m4v";	
				}
			}
			if (file_exists($single_image)) {
				$mediaArr['single_video'] = $single_image;
			}
			else{
				$mediaArr['single_video'] = $na;
			}
		}

		//3 = multiple image
		if($code['image_video']=="3"){

			//for image
			if($shape!="")
			{
				//$all_images = getDirFiles("https://dl2vs6wk2ewna.cloudfront.net/scrap/overnight/".$sku."/".$shape."/", "jpg");
				$all_images = array("https://dl2vs6wk2ewna.cloudfront.net/scrap/overnight/".$sku."/".$shape."/0.jpg","https://dl2vs6wk2ewna.cloudfront.net/scrap/overnight/".$sku."/".$shape."/1.jpg","https://dl2vs6wk2ewna.cloudfront.net/scrap/overnight/".$sku."/".$shape."/2.jpg");
				$mediaArr['all_images'] = $all_images;
			}
			else{	//get default media
				  // $CI =& get_instance();
     	// 			$CI->load->library('S3');
				   
				// $all_images = getDirFiles("https://dl2vs6wk2ewna.cloudfront.net/scrap/overnight/".$sku."/", "image");
				
				$all_images = array("https://dl2vs6wk2ewna.cloudfront.net/scrap/overnight/".$sku."/0.jpg","https://dl2vs6wk2ewna.cloudfront.net/scrap/overnight/".$sku."/1.jpg","https://dl2vs6wk2ewna.cloudfront.net/scrap/overnight/".$sku."/2.jpg");
				// pr($sku);
				$mediaArr['all_images'] = $all_images;
			}

		}


		//4 = multiple videos
		if($code['image_video']=="4"){
			//for video
			if($shape!="")
			{
				$all_videos = getDirFiles("https://dl2vs6wk2ewna.cloudfront.net/scrap/overnight/".$sku."/".$shape."/", "video");
				$mediaArr['all_videos'] = $all_videos;
			}
			else{	//get default media
				$all_videos = getDirFiles("https://dl2vs6wk2ewna.cloudfront.net/scrap/overnight/".$sku."/", "video");
				$mediaArr['all_videos'] = $all_videos;
			}
		}


		//5 = multiple images (with order)
		if($code['image_video']=="5"){
			//for image
			if($shape!="")
			{
				if($order!=""){
					$order = explode(",", $order);
					foreach ($order as $ord) {
						array_push($mediaArr['order_images'], "https://dl2vs6wk2ewna.cloudfront.net/scrap/overnight/".$sku."/".$shape."/".$ord.".jpg");
					}
				}
				else{
					$mediaArr['order_images'] = getDirFiles("https://dl2vs6wk2ewna.cloudfront.net/scrap/overnight/".$sku."/".$shape."/", "image");
				}
			}
			else{	//get default media
				if($order!=""){
					$order = explode(",", $order);
					foreach ($order as $ord) {
						array_push($mediaArr['order_images'], "https://dl2vs6wk2ewna.cloudfront.net/scrap/overnight/".$sku."/".$ord.".jpg");
					}
				}
				else{
					$mediaArr['order_images'] = getDirFiles("https://dl2vs6wk2ewna.cloudfront.net/scrap/overnight/".$sku."/", "image");
				}
			}
		}

		//6 = multiple video (with order)
		if($code['image_video']=="6"){
			//for image
			if($shape!="")
			{
				if($order!=""){
					$order = explode(",", $order);
					foreach ($order as $ord) {
						array_push($mediaArr['order_videos'], "https://dl2vs6wk2ewna.cloudfront.net/scrap/overnight/".$sku."/".$shape."/".$ord.".mp4");
					}
				}
				else{
					$mediaArr['order_videos'] = getDirFiles("https://dl2vs6wk2ewna.cloudfront.net/scrap/overnight/".$sku."/".$shape."/", "video");
				}
			}
			else{	//get default media
				if($order!=""){
					$order = explode(",", $order);
					foreach ($order as $ord) {
						array_push($mediaArr['order_videos'], "https://dl2vs6wk2ewna.cloudfront.net/scrap/overnight/".$sku."/".$ord.".mp4");
					}
				}
				else{
					$mediaArr['order_videos'] = getDirFiles("https://dl2vs6wk2ewna.cloudfront.net/scrap/overnight/".$sku."/", "video");
				}
			}
		}
		//7 = all media
		if($code['image_video']=="7"){
			//for image
			if($shape!="")
			{
				$order_images = getDirFiles("https://dl2vs6wk2ewna.cloudfront.net/scrap/overnight/".$sku."/".$shape."/".$ord, "image");
				$mediaArr['all_media']["images"] = $order_images;
			}
			else{	//get default media
				$order_images = getDirFiles("https://dl2vs6wk2ewna.cloudfront.net/scrap/overnight/".$sku."/".$ord, "image");
				$mediaArr['all_media']["images"] = $order_images;
			}

			//for video
			if($shape!="")
			{
				$order_videos = getDirFiles("https://dl2vs6wk2ewna.cloudfront.net/scrap/overnight/".$sku."/".$shape."/".$ord, "video");
				$mediaArr['all_media']["videos"] = $order_images;
			}
			else{	//get default media
				$order_images = getDirFiles(MEDIA.	"https://dl2vs6wk2ewna.cloudfront.net/scrap/overnight/".$sku."/".$ord, "video");
				$mediaArr['all_media']["videos"] = $order_images;
			}
		}

		//1 = shape
		if($code['shape']!=""){
			$shape = $code['shape'];
			//get default shape folder media (for now lets say it is round)

		} 
		
		return $mediaArr;

	}
function getDirFiles($dir, $mt="jpg"){
	$results=[];
	if($mt=='image')
		$mt="jpg";
	else if($mt=='video')
		$mt="mp4";

	$dir = str_replace('..','',$dir);
    $fileList  = glob($_SERVER['DOCUMENT_ROOT'].$dir."*.".$mt);
    foreach($fileList as $filename){
	   	if(file_exists($filename)){
	   		$results[] = $filename;
	   	}
	}
    return $results;
}

function single_img($sku,$shape='',$carat=''){ 
	$codeArr = array('image_video'=>"1", 'shape'=>$shape, 'order'=>"", 'carat'=>$carat);
	$single = get_media($sku, $codeArr);
	// pr($single);
	return $single['single_image'];
}

function single_img_ring($pid){ 

	$CI =& get_instance();
	$CI->load->model('common');
	$gp_result = $CI->common->get_media_ringbuilder($pid);
	return $gp_result;
}


function single_vid($sku){
	
	$codeArr = array('image_video'=>"2", 'shape'=>"", 'order'=>"", 'carat'=>'');
	$single = get_media($sku, $codeArr);
	return $single['single_video'];
} 

function multiple_images($sku){
	$codeArr = array('image_video'=>"3", 'shape'=>"", 'order'=>"", 'carat'=>'');
	$multiple = get_media($sku, $codeArr); 
	return $multiple['all_images'];
}

function multiple_metal_images($sku,$shape='',$carat=''){
	$codeArr = array('image_video'=>"3", 'shape'=>$shape, 'order'=>"", 'carat'=>$carat);
	$multiple = get_media($sku, $codeArr); 
	return $multiple['all_images'];
}
 