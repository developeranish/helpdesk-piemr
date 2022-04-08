<?php defined('BASEPATH') OR exit('No direct script access allowed');

/** Product Grid view **/
if (!function_exists('grid_watches')){

		function grid_watches($products='',$links=''){
			$html ='';
		  if(!empty($products)){ 
				$html .= '<div id="grid_pro" class="watch-grid">';
						 foreach($products as $product){
  				$html .= '<div class="col-md-3 col-sm-4 col-xs-6">
  							<div class="item-product item-product4 text-center border">
                  <div class="image-jewel-slider">
  								  <div class="product-thumb">
    									<a href="'.site_url('watching/'.strtolower($product->product_slug)).'" class="product-thumb-link zoom-thumb"><img src="'.(count(json_decode($product->images))>0?thumb(watch_img(json_decode($product->images)[0][0],$product->product_id),180,180):base_url('../sync/category/no-200_200.png')).'" alt="'.$product->product_slug.'"></a>
  								  </div>
                  </div><!--./product-thumb-->
                  
  								<div class="product-info">
  									<h3 class="title14 product-title"><a href="javascript:void(0)" class="black">'.$product->product_name.'</a></h3>
  									<div class="product-price title14 play-font">';
        					$html .=	'<ins class="black title18">$'.number_format(round($product->product_price)).'</ins>';
                  if($product->product_retail_price!='0.0000')  
                  $html .=  '<del class="silver">$'.number_format(round($product->product_retail_price)).'</del>';   

  									$html.='</div><!--./product-price title14 play-font-->
  									</div><!--./product-info-->
  								</div><!-- ./image-jewel-slider -->
  							</div><!-- ./item-product-->'; 
						  } 
			$html .= '</div>'; 
			return $html;
	}
}
}

/** Product List view **/
if ( ! function_exists('quick_view')){
	function quick_view($product=''){
 
 $quick = '';
 if(!empty($product)){
 $quick .='
   <div id="popup1">
      <div class="row">
         <div class="container">
            <div id="close1"><i class="fa fa-close"></i></div>
            <div class="content-page-detail">
               <div class="product-detail quick-view1">
                  <div class="row">
                     <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="wishlist-top"><a href="javascript:void(0);" data-product="'.$product->product_id.'" data-type="jewelry" class="add_wish wishme '.cookie_wish('jewelry',$product->product_id).' " data-toggle="tooltip" title="Wishlist"><i
                           class="fa fa-heart-o"></i></a></div>
                        <div class="detail-gallery" >
                           <!-- rose gold start here -->
                           <div id="" class="">
                              <div class="col-md-12 col-lg-12 col-sm-12 pull-right">
                                 <div class="product-large-slider'.$product->product_id.' product-large-slider'.$product->product_id.'_list">';
                                 $CI =& get_instance();
                                 $media = $CI->db->select('url')->where(array('element_id'=>$product->product_id,'element_type'=>'product','type'=>1))->order_by('sort_order','ASC')->get('media')->result();  
                                foreach($media as $md){
                  $quick .=         '<div class="pro-large-img img-zoom ">
                                       <img id="theImagev3"  src="'.MEDIA.$md->url.'" alt="'.$product->product_slug.'"/>
                                    </div>'; 
                                 }
               $quick .=      '</div>
                              </div>
                              <div class="col-md-12 col-lg-12 col-sm-12 hide-xs">
                                 <div class="pro-nav'.$product->product_id.' pro-nav'.$product->product_id.'_list slick-row-10 slick-arrow-style">';
                                  foreach($media as $md){       
                  $quick .=         '<div class="pro-nav-thumb">
                                          <img  src="'.MEDIA.$md->url.'" alt="product-details" />
                                       </div>'; 
                                    }                   
                                     
                $quick .=      '</div>
                              </div>
                           </div>
                           <!-- rose gold end here -->
                        </div>
                     </div>
                     <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="detail-info">
                           <h2 class="product-title title24 text-uppercase dark font-bold">'.$product->product_slug.'</h2>
                           <div class="inner-title">('.ucwords(str_replace('-',' ', $product->metal_type)).', '.str_replace(array('carat','carats','ctw'),'',$product->product_weight).' ctw)</div>
                           <div class="item-product-meta-info product-code-info">
                              <label>Product Code:</label>
                              <span>#'.$product->product_sku.'</span>
                           </div>
                           <ul class="wrap-rating list-inline-block">
                      <li>
                        <div class="product-rate">';
                          $reviews = reviews_count_avg($product->product_id);
                          $quick.='<div class="product-rating" style="width:'.(ratings($product->product_id)*20).'%"></div>
                        </div>
                      </li>
                      <li>
                        <span class="rate-number silver">('.$reviews->reviews_count.')</span>
                      </li>
                    </ul>
                           <div class="product-price">';
                         
                     $quick .= '<ins class="title24 color font-bold">$'.number_format(round($product->product_sale_price)).'</ins>';
                       if($product->product_discount!='' || $product->product_discount!=0)
                     $quick .= '<del class="dark opaci title24">$'.number_format(round($product->product_price)).'</del>';
                      if($product->product_discount!='' || $product->product_discount!=0)   
                     $quick .= '<span class="discount-rate">'.number_format(round((($product->product_price-$product->product_sale_price)/$product->product_price)*100)).' % Off</span>';
                     $quick .='</div>
                           <div class="clearfix"></div>
                           <!-- metal type filters -->
                           <div class="clearfix"></div>
                           <div class="detail-attr btn-cart">
                              <a href="'.site_url('shop/'.$product->product_slug).'" class="shop-button bg-dark addcart-link font-bold text-uppercase">Add to Cart</a>
                              <a href="'.site_url('shop/'.$product->product_slug).'" class="shop-button bg-dark1 addcart-link font-bold text-uppercase">Buy Now</a>
                           </div>
                           <div class="detail-extra-link">
                              <li class="ship"><i class="fa fa-truck"></i>Free Shipping</li>
                              <li class="ship"><i class=" fa fa-retweet"></i>Free 30 Days Return</li>
                              <li class="ship"><i class=" fa fa-diamond"></i>Risk free Retail</li>
                           </div>
                           <div class="like-icon">
                               <div class="like-icon">
                              <a class="facebook" onClick="window.open(\'https://www.facebook.com/sharer/sharer.php?u='.site_url('shop/'.$product->product_slug).'\');" target="_parent" href="javascript: void(0)"><i class="fa fa-facebook"></i></a><a class="twitter" onClick="window.open(\'https://twitter.com/intent/tweet?url='.site_url('shop/'.$product->product_slug).'\');"target="_parent" href="javascript: void(0)"><i class="fa fa-twitter"></i></a>   
                                              
                             
                           </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
  </div>';
}
return $quick;
	}
}	


if (!function_exists('watch_img'))
{ 
    function watch_img($url='',$watch_id=''){ 
      if($url!='' && $watch_id!=''){
        if(valid_img_watch($url)){
          if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/'.WATCH_IMG_UPLOAD.$watch_id.'.'.pathinfo($url, PATHINFO_EXTENSION))) 
              if(copy($url, $_SERVER['DOCUMENT_ROOT'].'/'.WATCH_IMG_UPLOAD.$watch_id.'.'.pathinfo($url, PATHINFO_EXTENSION)))
                  return WATCH_IMG_UPLOAD.$watch_id.'.'.pathinfo($url, PATHINFO_EXTENSION);
              else
                  return $url;
          else
              return WATCH_IMG_UPLOAD.$watch_id.'.'.pathinfo($url, PATHINFO_EXTENSION);
        }
        else{
          return WATCH_IMG_UPLOAD."watch.jpg";
        }
      }else{
        return $url;
      }
    }
}

function valid_img_watch($url='',$shape=''){ 
  if (@getimagesize($url))
    return true;
  else
    return false;
 }


if (!function_exists('watch_img_url'))
{ 
    function watch_img_url($watch_id=''){ 
      $CI =& get_instance();
      $watch_media = $CI->db->select('images')->where(array('watch_id'=>$watch_id))->get('watch_data')->row_array();
      return json_decode($watch_media['images'])[0][0];
    }
}


?>