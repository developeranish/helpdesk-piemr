<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('create_slug')){

		function create_slug($name=null,$table="",$title=""){
	      	$config = array(
				'field' => 'slug',
				'table' => $table,
			);
			$CI = get_instance();
			$CI->load->library('slug', $config);

			$data = array(
				'slug' => $title 
			); 
			 return $data['uri'] = $CI->slug->create_uri($data); 
      } 
	} 

     
//crate thumbnail dynamically //
if ( ! function_exists('thumb')){ 

	 function thumb($fullname, $width, $height){	
    	$filename = pathinfo($fullname, PATHINFO_FILENAME);  
        
        // Get the CodeIgniter super object
        $CI = &get_instance();
        // get src file's extension and file name
        $extension = pathinfo($fullname, PATHINFO_EXTENSION); 
        // Path to image thumbnail in your root
        $dir = substr($fullname, 0, strpos($fullname, $filename . "." . $extension));
        $url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/' . $dir;

        $image_org = $dir . $filename . "." . $extension; 
        $image_thumb = $dir . $filename . "-" . $height . '_' . $width . "." . $extension;
        $image_returned = $url . $filename . "-" . $height . '_' . $width . "." . $extension;
        $exist_file = "file:///".$_SERVER['DOCUMENT_ROOT'].'/'.str_replace('.', '', $dir.$filename. "-" . $height . '_' . $width)."." . $extension;
        
      
 		clearstatcache(); 
        if (file_exists($exist_file)===FALSE) {  
        	
            // LOAD LIBRARY
            $CI->load->library('image_lib');
            // CONFIGURE IMAGE LIBRARY
            $config['image_library'] = 'gd2';
            $config['source_image'] = str_replace('..','',str_replace('//..','', $_SERVER['DOCUMENT_ROOT'] .'/'. $image_org));
            $config['new_image'] = str_replace('..','',str_replace('//..','',$_SERVER['DOCUMENT_ROOT'] .'/'.$image_thumb));
            $config['width'] = $width;
            $config['height'] = $height;
            $CI->image_lib->initialize($config);
            $CI->image_lib->resize();
      		// 		if (! $CI->image_lib->resize()) { 
		    //     echo $CI->image_lib->display_errors();
		    //     echo $fullname;
		    //     exit;
		    // }        
            $CI->image_lib->clear();
        } 
	        return $image_returned;
	    }
  }

if ( ! function_exists('thumb_aws')){ 

	function thumb_aws($fullname, $width, $height){	
		$pathinfo = pathinfo($fullname);
		$fullname = $pathinfo['dirname'].'/'.$width.'x'.$height.'/'.$pathinfo['basename'];
		return $fullname;
	}
 }
 
// if ( ! function_exists('thumb')){ 
// 	 function thumb($fullname, $width, $height){	
//     	$filename = pathinfo($fullname, PATHINFO_FILENAME); 
//         // Path to image thumbnail in your root
//         $dir = substr($fullname, 0, strpos($fullname, $filename));
//         $url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].'/' . $dir;
//         // Get the CodeIgniter super object
//         $CI = &get_instance();
//         // get src file's extension and file name
//         $extension = pathinfo($fullname, PATHINFO_EXTENSION); 
//         $image_org = $dir . $filename . "." . $extension;
//         $image_thumb = $dir . $filename . "-" . $height . '_' . $width . "." . $extension;
//         $image_returned = $url . $filename . "-" . $height . '_' . $width . "." . $extension;
//         $exist_file = "file:///".$_SERVER['DOCUMENT_ROOT'].'/'.str_replace('.', '', $dir.$filename. "-" . $height . '_' . $width)."." . $extension;

//  		clearstatcache(); 
//         if (file_exists($exist_file)===FALSE) { 
//             // LOAD LIBRARY
//             $CI->load->library('image_lib');
//             // CONFIGURE IMAGE LIBRARY
//             $config['source_image'] = $image_org;
//             $config['new_image'] = $image_thumb;
//             $config['width'] = $width;
//             $config['height'] = $height;
//             $CI->image_lib->initialize($config);
//             $CI->image_lib->resize();
//             $CI->image_lib->clear();
//         }
// 	        return $image_returned;
// 	    }
//   } 
  

  //get parent category name
  if ( ! function_exists('parent')){ 
		function parent($cat_id=0)
		{
			$CI =& get_instance();
			$parent = '';

			if( !is_numeric($cat_id)){
				$group = array();
				$cat_id= $CI->db->select('name')->where_in('category_id',$cat_id)->get('category')->result();
				foreach ($cat_id as $key ) { 
 					if(!empty($key))
 						$parent .= $key->name.',';
 				} 
			}else{

				$parent = $CI->db->select('name')->where('category_id',$cat_id)->get('category')->row();
			}

			
			if(!empty($parent) && isset($parent->name))
				return rtrim($parent->name,',');
			elseif(!empty($parent))
				return rtrim($parent,',');
			else
				return 'All';
		}
	}	   


  //get category image
  if ( ! function_exists('c_image')){ 
		function c_image($cat_id=0)
		{
			$CI =& get_instance();
			$media = $CI->db->select('url')->where(array('element_id'=>$cat_id,'element_type'=>'category'))->get('media')->row();
			if(!empty($media) && $media->url!='')
				return $media->url;
			else
				return 'sync/images/no.png';
		}
	}

//get product image
  if ( ! function_exists('pro_thumb')){ 
		function pro_thumb($pro_id=0)
		{
			$CI =& get_instance();
			$media = $CI->db->select('url')
			->where(array('element_id'=>$pro_id,'element_type'=>'product','type'=>1))
			->order_by('sort_order','ASC')
			->get('media')->row();
			if(!empty($media) && $media->url!='')
				return thumb($media->url,200,200);
			else
				return 'sync/images/no.png';
		}
	}


//get review count 
  if ( ! function_exists('review_count')){ 
		function review_count($pro_id=0)
		{
			$CI =& get_instance();
			$sum = $CI->db->select('AVG(rating) as count')->where(array('product_id'=>$pro_id))->get('reviews')->row();
			if(!empty($sum) && $sum->count!='')
				return round($sum->count);
			else
				return 0;
		}
	}	


//get product id
  if ( ! function_exists('pro_id')){ 
		function pro_id($slug=0)
		{
			$CI =& get_instance();
			$pro = $CI->db->select('product_id')->where(array('slug'=>$slug))->get('products')->row();
			if(!empty($pro) && $pro->product_id!='')
				return $pro->product_id;
			else
				return 0;
		}
	}		


//get media
  if ( ! function_exists('media')){ 
		function media($element_id='',$element_type='',$media_type=1,$sort_order=0,$extra=array())
		{

			if(!empty($extra))
				return media_ext($extra);

			if(!$element_id || !$element_type)
				return 'sync/images/no.png';

			$CI =& get_instance();
			$CI->db->select('url')
						->where(array('type'=>$media_type,'element_id'=>$element_id,'element_type'=>$element_type));
			if($sort_order==0)			
				$CI->db->where_in('sort_order',array(0,1));
			else
				$CI->db->where('sort_order',$sort_order);
			$media = $CI->db->get('media')->row();
			if(!empty($media) && $media->url!='')
				return $media->url;
			elseif($media_type==1)
				return 'sync/images/no.png';
			else
				return false;
		}
	}	

	function media_ext($extra=array()){
		if(empty($extra) || !isset($extra['metal']) || !isset($extra['fake_sku']))
			return 'sync/images/no.png';

		$metal = $extra['metal'];
		$fake_sku = $extra['fake_sku'];
		$bulk = (isset($extra['bulk']) && $extra['bulk']) === true ? true :false;
		$sort_me = isset($extra['sort_order'])  ? $extra['sort_order'] :0;
		//sort order according to image existance in folder   
		$sort_order = array(
		    'silver'=> [$fake_sku.'.jpg',$fake_sku.'.set.jpg',$fake_sku.'.side.jpg',$fake_sku.'.ver.jpg'],
		    'platinum'=> [$fake_sku.'.jpg',$fake_sku.'.set.jpg',$fake_sku.'.side.jpg',$fake_sku.'.ver.jpg'],
		   'white-gold'=> [$fake_sku.'.jpg',$fake_sku.'.set.jpg',$fake_sku.'.side.jpg',$fake_sku.'.ver.jpg'],
		   'rose-gold'=> [$fake_sku.'.alt1.jpg',$fake_sku.'.set.alt1.jpg',$fake_sku.'.side.alt1.jpg',$fake_sku.'.ver.alt1.jpg'],
		   'yellow-gold'=> [$fake_sku.'.alt.jpg',$fake_sku.'.set.alt.jpg',$fake_sku.'.side.alt.jpg',$fake_sku.'.ver.alt.jpg'] 
		);
		
		if($bulk===true):
			$bundle = array(); 

			$video_metal = in_array($metal, array('silver','platinum','white-gold')) ? 'white':substr($metal, 0, strpos($metal, '-'));
		    
		    if(file_exists($_SERVER['DOCUMENT_ROOT'].'/sync/overnight/'.$fake_sku.'/'.$fake_sku.'.video.'.$video_metal.'.mp4')){
			    $bundle[] = array('type'=>2,'../sync/overnight/'.$fake_sku.'/'.$fake_sku.'.video.'.$video_metal.'.mp4');
			}  

			for($i=0;$i<4;$i++):
			    	 
			    if(file_exists($_SERVER['DOCUMENT_ROOT'].'/sync/overnight/'.$fake_sku.'/'.$sort_order[$metal][$i])){
				    $bundle[] =  array('type'=>1,'../sync/overnight/'.$fake_sku.'/'.$sort_order[$metal][$i]) ;
				  }	
			endfor;  
			return $bundle;
		endif;    

		for($i=0;$i<4;$i++):  
		    if($i == $sort_me):	
		    	if(file_exists($_SERVER['DOCUMENT_ROOT'].'/sync/overnight/'.$fake_sku.'/'.$sort_order[$metal][$i])):
			    		return '../sync/overnight/'.$fake_sku.'/'.$sort_order[$metal][$i] ;
			  	endif;
			endif;  	
		endfor; 
		return 'sync/images/no.png';
	}

/// product_count by category

  if ( ! function_exists('pro_count')){ 
		function pro_count($cat_id='')
		{
			$CI =& get_instance();

			if($cat_id)
				$CI->db->where('category_id', $cat_id); 
			$category = $CI->db->select('sum(category_id) as sum')->get('category')->row();
		 
			if(!empty($category) && $category->sum!='')
				return $category->sum;
			else
				return 0;
		}
	}	

	/// product min and max price

  if ( ! function_exists('min_max')){ 
		function min_max()
		{
			$CI =& get_instance(); 

			$price = $CI->db->select('min(price) as min, max(price) as max')->get('products')->row();
		 	
		 	$return = array('min'=>0,'max'=>0);
			if(!empty($price) && $price->min!='')
				$return['min'] = $price->min-10;
			if(!empty($price) && $price->max!='')
				$return['max'] = $price->max+10;
			 
			return $return;
		}
	}

	  if ( ! function_exists('min_max_watches')){ 
		function min_max_watches()
		{
			$CI =& get_instance(); 

			$price = $CI->db->select('min(price) as min, max(price) as max')->get('watch_data')->row();
		 	
		 	$return = array('min'=>0,'max'=>0);
			if(!empty($price) && $price->min!='')
				$return['min'] = $price->min-10;
			if(!empty($price) && $price->max!='')
				$return['max'] = $price->max+10;
			 
			return $return;
		}
	}	

		/// product min and max price

  if ( ! function_exists('min_max_diamond')){ 
		function min_max_diamond() 
		{
			$CI =& get_instance(); 

			$price = $CI->db->select('min(actual_price) as min, max(actual_price) as max')->get('view_diamond')->row();
			// pr($CI->db->last_query());
		 	$return = array('min'=>0,'max'=>0);
			if(!empty($price) && $price->min!='')
				$return['min'] = round($price->min);
			if(!empty($price) && $price->max!='')
				$return['max'] = round($price->max);
			 
			return $return;
		}
	}

// price fraction

  if ( ! function_exists('price_fraction')){ 
		function price_fraction($data) 
		{
			$min_price = $data['min'];
			$max_price = $data['max'];
			$range = [$min_price];
			for($i=$min_price;$i<=$max_price;$i=$i+100):
				$range[] = $i; 
			endfor;	
			$range[] = $max_price;

			return implode(',', $range); 
		}
	}

	/// metal colors 

  if ( ! function_exists('metal_colors')){ 
		function metal_colors()
		{
			$CI =& get_instance();  
 
   return $CI->db->query('SELECT *, COUNT(product_id) count, metal_type FROM metal_colors, view_product WHERE STATUS = 1 AND view_product.metal_type = metal_colors.slug GROUP BY metal_type')->result(); 
		}
	}

	/// ratings

  if ( ! function_exists('ratings')){ 
		function ratings($product_id=0)
		{
			$CI =& get_instance(); 

			$ratings = $CI->db->select('avg(rating) avg')->where('product_id',$product_id)->where('status','active')->get('reviews')->row();   
			if(!empty($ratings) && $ratings->avg!='')
				return round($ratings->avg);
			else
				return 0;
		}
	}	


	/// reviews

  if ( ! function_exists('reviews')){ 
		function reviews($product_id=0)
		{
			if($product_id==""){
				$product_id = 0;
			}
			$CI =& get_instance(); 
			$query = 'SELECT reviews.*, CONCAT(users.first_name," ", users.last_name) as name FROM `reviews` , users WHERE reviews.product_id = '.$product_id.' and users.id = reviews.user_id';
			$reviews = $CI->db->query($query)->result();
			if(!empty($reviews))
				return $reviews;
			else
				return [];
		}
	}


//get all gemstone attribute for wishlist
if (!function_exists('get_gem_attr'))
{ 
    function get_gem_attr($gem_group_id){ 
    	$CI =& get_instance(); 
      $query = "SELECT ga.name, gav.value FROM gemstone_attribute_value gav JOIN gemstone_attribute ga ON ga.gemstone_attribute_id = gav.gem_attr_id WHERE gav.gem_group_id = '".$gem_group_id."' limit 5";
      return $CI->db->query($query)->result();
    }
}

//product attribute
if (!function_exists('pro_attribute'))
{ 
    function pro_attribute($group_id=0,$gem=false,$attr=''){ 
    	$CI =& get_instance(); 

    //getting product attribute	
      if($gem==false)	
      		$query = "select attribute.attribute_id as id ,attribute.name, attribute_value.value from attribute ,attribute_value where attribute.attribute_id = attribute_value.attribute_id and  attribute_value.`group_id` LIKE '".$group_id."'";
      if($attr!='' && $gem==false)
      		$query .= " and attribute.name LIKE '%".$attr."%' ";
      	
     //getting gemstone attribute	
      if($gem==true)	
      		$query = "select gemstone.name gem, gemstone_attribute.gemstone_attribute_id as id ,gemstone_attribute.name, gemstone_attribute_value.value from gemstone_attribute ,gemstone_attribute_value,gemstone where gemstone_attribute.gemstone_attribute_id = gemstone_attribute_value.gem_attr_id and gemstone_attribute.gemstone_id = gemstone.gemstone_id and  gemstone_attribute_value.`gem_group_id` LIKE '".$group_id."'";
      if($attr!='' && $gem==true)
      		$query .= " and gemstone_attribute.name LIKE '%".$attr."%' ";  	
      if($attr!='')	
      	return $CI->db->query($query)->row();
      else
      	return $CI->db->query($query)->result();
    }
}

//product attribute
if (!function_exists('pro_attribute_single'))
{ 
    function pro_attribute_single($pid=0){ 
    	$CI =& get_instance(); 

    	$query = "select attribute.attribute_id as id ,attribute.name, attribute_value.value from attribute ,attribute_value where attribute.attribute_id = attribute_value.attribute_id and  attribute_value.`product_id` = ".$pid;
     
		$r = $CI->db->query($query)->result();
		return $r;
    }
}

if (!function_exists('weight_options'))
{ 
    function weight_options($sku='', $metal_color=''){ 
    	$CI =& get_instance(); 

    	$query = "select product_id, slug, metal_carat_weight from products where sku = '".$sku."' AND metal_color='".$metal_color."'";
     
		$r = $CI->db->query($query)->result();
		// echo vd();
		return $r;
    }
}


/// reviews Count and Average

  if ( ! function_exists('reviews_count_avg')){ 
		function reviews_count_avg($product_id=0)
		{
			$CI =& get_instance(); 

			$reviews = $CI->db->query('SELECT avg(reviews.rating) avg, count(reviews.product_id) reviews_count FROM `reviews` , users WHERE reviews.product_id = '.$product_id.' and users.id = reviews.user_id')->row();
			if(!empty($reviews))
				return $reviews;
			else
				return 0;
		}
	}

  function initial_str($str=''){
         $parts = explode(' ',$str);
         $initials = '';
         foreach($parts as $part) {
            $initials .= $part[0];
         }
         return  $initials;
  }
/// insert overnight products

  if ( ! function_exists('overnight')){ 
		function overnight()
		{
			 
			$CI =& get_instance(); 
			$data = fopen($_SERVER['DOCUMENT_ROOT'].'/'.DIAMOND_DATA.'eng.json', "r") or die("Unable to open file!");
		    $data_json  =   fread($data,filesize($_SERVER['DOCUMENT_ROOT'].'/'.DIAMOND_DATA.'eng.json'));
		    fclose($data);
		    $data = json_decode($data_json);

		    //$eng_data = array();
		    $media = array();
		    foreach ($data as $key => $ring):
		    	
		    	$group_id = md5(uniqid(rand(), true));
		    	$group_id = substr($group_id, 0, 13).'MOUNT'.substr($group_id, 18);
		    	 
		    	$gem_group_id = md5(uniqid(rand(), true));
		    	$metals = array('silver','rose-gold','white-gold','yellow-gold','platinum');
		    	//pr($data);exit;
		    	foreach($metals as $metal): 

		    		$shape = $ring->shape!='N/A' ? $ring->shape.' shape diamond':'diamond';
		    		$style = $ring->Style!='Other' ? $ring->Style:'';
		    		$name = trim($ring->Style.' '.$shape.' '.'engagement ring');
		    		$slug = $name.' '.str_replace('-',' ',$metal);  
		    		$slug = create_slug('name','products',$slug);  
		    		$price = (str_replace(',','', $ring->$metal));
		    		$price = (int)$price;

				    $eng_data = array(
				    	'category_id' => $ring->Categories,
				    	'group_id' =>$group_id,
				    	'gem_group_id' =>$gem_group_id,
				    	'gem_id' => 5,
				    	'name' => strtolower($name),
				    	'metal_color'=>$metal,
				    	'sku'=>strtoupper($ring->Path.initial_str(str_replace('-',' ',$metal))),
				    	'fake_sku'=>$ring->Path,
				    	'price'=> round(($price/70)*100),
				    	'sale_price'=>round($price),
				    	'discount'=>round((($price/70)*100)-$price),
				    	'status'=>'active',
				    	'slug'=>$slug,
				    );

				    $CI =& get_instance();
				    $CI->db->insert('products',$eng_data);
				    $product_id = $CI->db->insert_id();
				   // $product_id = 0;
				   //pr($eng_data);
				//sort order according to image existance in folder   
				$sort_order = array(
				    'silver'=> [$ring->Path.'.jpg',$ring->Path.'.set.jpg',$ring->Path.'.side.jpg',$ring->Path.'.ver.jpg'],
				    'platinum'=> [$ring->Path.'.jpg',$ring->Path.'.set.jpg',$ring->Path.'.side.jpg',$ring->Path.'.ver.jpg'],
				   'white-gold'=> [$ring->Path.'.jpg',$ring->Path.'.set.jpg',$ring->Path.'.side.jpg',$ring->Path.'.ver.jpg'],
				   'rose-gold'=> [$ring->Path.'.alt1.jpg',$ring->Path.'.set.alt1.jpg',$ring->Path.'.side.alt1.jpg',$ring->Path.'.ver.alt1.jpg'],
				   'yellow-gold'=> [$ring->Path.'.alt.jpg',$ring->Path.'.set.alt.jpg',$ring->Path.'.side.alt.jpg',$ring->Path.'.ver.alt.jpg'] 
				);
				    //for images
				    for($i=0;$i<4;$i++):
				    	 
				    if(file_exists($_SERVER['DOCUMENT_ROOT'].'/sync/overnight/'.$ring->Path.'/'.$sort_order[$metal][$i])){
					    $media_img = array(
					    	'element_type' =>'product',
					    	'element_id' =>$product_id,
					    	'type' =>1,
					    	'url' =>'../sync/overnight/'.$ring->Path.'/'.$sort_order[$metal][$i],
					    	'metal_type' =>$metal,
					    	'gemstone' =>'diamond',
					    	'slug' =>$slug,
					    	'sort_order' =>$i
					  	);	
					  
					    $CI->db->insert('media',$media_img);
					    //pr($media_img);
					  }	
				    endfor; 
				    //for video
 					$video_metal = in_array($metal, array('silver','platinum','white-gold')) ? 'white':substr($metal, 0, strpos($metal, '-'));
				    if(file_exists($_SERVER['DOCUMENT_ROOT'].'/sync/overnight/'.$ring->Path.'/'.$ring->Path.'.video.'.$video_metal.'.mp4')){
					    $media_vid = array(
					    	'element_type' =>'product',
					    	'element_id' =>$product_id,
					    	'type' =>2,
					    	'url' =>'../sync/overnight/'.$ring->Path.'/'.$ring->Path.'.video.'.$video_metal.'.mp4',
					    	'metal_type' =>$metal,
					    	'gemstone' =>'diamond',
					    	'slug' =>$slug,
					    	'sort_order' =>4,
					    );	
					   $CI->db->insert('media',$media_vid);
					  //pr($media_vid); 
					}    
				endforeach;
				$attr = array('2'=>1,'8'=>39,'5'=>50,'3'=>48);

				$pro_attr = array(
					'value'=>$ring->Style,
					'group_id'=>$group_id,
					'attribute_id'=>$attr[$ring->Categories],
					'product_id'=>$product_id
				);	
				$CI->db->insert('attribute_value',$pro_attr);

				//gem attribute store breakdown
				$gems = array('stone_breakdown'=>143,'weight'=>95,'Cut'=>73,'Clarity'=>72,'Color'=>71,'shape'=>70);
				foreach ($gems as $gkey => $gvalue): 
					if($ring->$gkey!='N/A'){
						$gem_attr = array(
							'value'=>$ring->$gkey,
							'gem_group_id'=>$gem_group_id,
							'gem_attr_id'=>$gvalue
						);	
						$CI->db->insert('gemstone_attribute_value',$gem_attr);
					}
				endforeach;	
			endforeach;
		}
	}
//for diamond comparision count in cookies
if (!function_exists('compare_count'))
{ 
    function compare_count(){ 
      if(isset($_COOKIE['diamond-compare']))
        return count(json_decode($_COOKIE['diamond-compare']));
      else
        return null;
    }
}


if (!function_exists('wish_count'))
{ 
    function wish_count(){ 
	  $count = "0";
	  //check login
	  if(isset($_SESSION['logged_in']['email']) && isset($_SESSION['logged_in']['user_id'])){
		$user_id = $_SESSION['logged_in']['user_id'];
		$CI =& get_instance();
		$count = $CI->db->query('SELECT count(*) as count FROM wishlists WHERE user_id='.$user_id)->result();
		$count = $count[0]->count;
	  }else{
        if(isset($_COOKIE['jewelry']))
          $count = $count + count(json_decode($_COOKIE['jewelry']));

        if(isset($_COOKIE['diamond']))
          $count = $count + count(json_decode($_COOKIE['diamond']));

	  }
	  return $count;
    } 
}

if (!function_exists('cookie_wish'))
{ 
    function cookie_wish($cookie='cookie',$ele=0){ 
		
        if(isset($_COOKIE[$cookie]) && in_array($ele, json_decode($_COOKIE[$cookie])))
          return 'active';
        else
          return false;
    }
}  


if (!function_exists('get_product'))
{ 
    function get_product($group_id='',$metal='',$gem=''){  
       $slug = '';
       $CI =& get_instance();
       $CI->db->select('product_slug')
              ->where('group_id',$group_id)
              ->where('metal_type',$metal);
         if($gem!='' && $gem!=0)
              $CI->db->where('gem_id',$gem);

         $slug =  $CI->db->get('view_product')->row(); 

         if($slug!='')
             $slug = $slug->product_slug;
         else
             $slug = '';          
     return (site_url('shop/'.$slug));  
    }
}


if (!function_exists('get_product_ring'))
{ 
    function get_product_ring($group_id='',$metal='',$gem=''){  
       $slug = '';
       $CI =& get_instance();
       $CI->db->select('product_slug')
              ->where('group_id',$group_id)
              ->where('metal_type',$metal);
         if($gem!='' && $gem!=0)
              $CI->db->where('gem_id',$gem);

         $slug =  $CI->db->get('ring_builder')->row(); 

         if($slug!='')
             $slug = $slug->product_slug;
         else
             $slug = '';          
     return (site_url('setting/'.$slug));  
    }
}
?>