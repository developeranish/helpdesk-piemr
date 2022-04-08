<?php defined('BASEPATH') OR exit('No direct script access allowed');

/** Product Grid view **/
if ( ! function_exists('grid_pro')){

    function grid_pro($products='',$links=''){ 
      
      $html ='';
      if(!empty($products)){ 
        
        $html .= '<div id="grid_pro">';
             foreach($products as $product){ 
              
        $html .= '<div class="col-md-3 col-sm-4 col-xs-6 only-large only-lg">
             
              <div class="item-product item-product4 text-center border">';
                $html.='
          <div class="product-thumb video-thumb" data-id ="'.$product->product_id.'" onclick="" onmouseover= "">'; 
       
         $html .= '<a href="'.site_url('build-your-own-ring/'.strtolower($product->product_slug)).'"><img data-sku="'.$product->product_sku.'" id="cls_'.$product->product_id.'" src="'.thumb_aws(single_img_ring($product->product_id)[0]->url,250,250).'" class="ring-image">'; 


           $html .= '</a>
                    
                  </div>  
           <div class="product-info"> 
                  <h3 class="title14 product-title"><a href="'.site_url('build-your-own-ring/'.strtolower($product->product_slug)).'" class="black">'.ucwords($product->product_name).'</a></h3>
                  <div class="product-price title14 play-font">';
                      $html .=  '<ins class="black title18">$'.number_format(round($product->product_sale_price)).'</ins>';
                          if($product->product_discount!='')  
                          $html .=  '<del class="silver">$'.number_format(round($product->product_price)).'</del>';   

                    $html.='</div></div>';
            
            
                  $html.='<input type="hidden" class="form-control" value="'.$product->product_id.'" name="pro_id" id="pro_id" required="">
                  <input type="hidden" name="metal_color" id="metal_color" value="'.$product->metal_type.'">
                  <input type="hidden" id="product_price" = value="'.$product->product_sale_price.'">
                  <input type="hidden" id="product_name" = value="'.ucwords($product->product_name).'">
                  <input type="hidden" class="form-control" value="'.strtolower($product->product_slug).'" name="slug" id="slug" required="">
                  <input type="hidden" name="ptype" id="ptype" value="Jewelry">';

                // if(media($product->product_id,'product',2)){
                //   $html .='<div class="product-extra-link42 wishlist-top2 title18"> 
                //     <a href="javascript:void(0);" class="black inline-block wishme hi-icon hi-icon-archive" ><i class="fa fa-play" aria-hidden="true" style="
                //       padding-left: 4px;
                //       color: #fff;
                //   "></i>
                //     <!--<span class="title10 white text-uppercase">Wishlist</span>--></a>
                //   </div>';
                // }  
                  $html.='<div class="product-extra-link42 wishlist-top1 title18">
          

                    <a href="javascript:void(0);" class=" black inline-block add_wish wishme hi-icon hi-icon-archive  wish_top '.cookie_wish('jewelry',$product->product_id).' "  data-product="'.$product->product_id.'" data-type="jewelry" ><i class="fa fa-heart-o"></i>
                    <!--<span class="title10 white text-uppercase">Wishlist</span>--></a>
                  </div>
               
              </div>
            </div> '; 
      
              } 
      $html .= '</div>'; 
      if(isset($links))
        $html .= $links;
       }  
        return $html;
  }
}
 

/** Product List view **/
if ( ! function_exists('quick_view')){
  function quick_view($product='',$weight=''){
 
 $quick = '';
 if(!empty($product)){
    if($weight!=''){
     $weight = ' , '.$weight; 
    }
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
                                 $media = $CI->db->select('url, type')->where(array('element_id'=>$product->product_id,'element_type'=>'product'))->order_by('sort_order','DESC')->get('media')->result();  
                                 
                                foreach($media as $md){
                                  $quick .= '<div class="pro-large-img img-zoom ">';
                                if($md->type==1){
                                       $quick .='<img id="theImagev3"  src="'.$md->url.'" alt="'.strtolower($product->product_slug).'"/>';
                                     }
                                     else{
                                        $quick .='<video height="100%" loop="true" width="100%" muted playsinline autoplay="true">
                                    <source src="'.$md->url.'" type="video/mp4">
                                    <source src="'.$md->url.'" type="video/ogg">
                                    Your browser does not support the video tag.
                                  </video>';
                                     }
                                    $quick .='</div>'; 
                                 }
               $quick .=      '</div>
                              </div>
                              <div class="col-md-12 col-lg-12 col-sm-12 hide-xs">
                                 <div class="pro-nav'.$product->product_id.' pro-nav'.$product->product_id.'_list slick-row-10 slick-arrow-style">';
                                  foreach($media as $md){       
                  $quick .=         '<div class="pro-nav-thumb">';
                                  if($md->type==1){
                                          $quick.= '<img  src="'.$md->url.'" alt="'.$product->product_name.'" />';
                                        }
                                          else{
                                            $quick .='<img src="'.base_url('assets/images/video-thumb.png').'" alt="'.$product->product_name.'"  class="left_shifted_thumb" />';
                                          }
                                       $quick .='</div>'; 
                                    }                   
                                     
                $quick .=      '</div>
                              </div>
                           </div>
                           <!-- rose gold end here -->
                        </div>
                     </div>
                     <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="detail-info">
                           <h2 class="product-title title24 dark font-bold">'.ucwords($product->product_name).'</h2>
                           <div class="inner-title">('.ucwords(str_replace('-',' ', $product->metal_type)).$weight.')</div>
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
                      if($product->product_discount!='' && number_format(round((($product->product_price-$product->product_sale_price)/$product->product_price)*100))!=0)   
                     $quick .= '<span class="discount-rate">'.number_format(round((($product->product_price-$product->product_sale_price)/$product->product_price)*100)).' % Off</span>';
                     $quick .='</div>
                           <div class="clearfix"></div>
                           <!-- metal type filters -->
                           <div class="clearfix"></div>
                           <div class="detail-attr btn-cart">

                              <a href="javascript:void(0)" class="shop-button bg-dark addcart-link font-bold text-uppercase add_cart active" data-product_id="'.$product->product_id.'" data-ptype="Jewelry" data-product_price="'.$product->product_sale_price.'" data-product_name="'.$product->product_name.'" data-buy-now="flase">Add to Cart</a>

                              <a href="'.site_url('shop/'.strtolower($product->product_slug)).'" class="shop-button bg-dark1 addcart-link font-bold text-uppercase">Buy Now</a>
                           </div>';
                
               
               
                           $quick.='<div class="like-icon">
                               <div class="like-icon">
                              <a class="facebook" onClick="window.open(\'https://www.facebook.com/sharer/sharer.php?u='.site_url('shop/'.strtolower($product->product_slug)).'\');" target="_parent" href="javascript: void(0)"><i class="fa fa-facebook"></i></a><a class="twitter" onClick="window.open(\'https://twitter.com/intent/tweet?url='.site_url('shop/'.strtolower($product->product_slug)).'\');"target="_parent" href="javascript: void(0)"><i class="fa fa-twitter"></i></a>   
                                              
                             
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
 


if ( ! function_exists('price_range')){ 
  function price_range()
  {
    $CI =& get_instance();  
    $price = $CI->db->select('min(price) as min, max(price) as max')->where('category_id',2)->get('products')->row();
    $return = array('min'=>0,'max'=>0);
    if(!empty($price) && $price->min!='' && $price->min!=0)
      $return['min'] = (int)$price->min-1;
    if(!empty($price) && $price->max!='' && $price->max!=0)
      $return['max'] = (int)$price->max+1; 
    return $return;
  }
} 


if ( ! function_exists('price_range_builder')){ 
  function price_range_builder()
  {
    $CI =& get_instance();  
    $price = $CI->db->select('min(sale_price) as min, max(sale_price) as max')->where('category_id',2)->where('vendor_id', 3)->get('products')->row();
    $return = array('min'=>0,'max'=>0);
    if(!empty($price) && $price->min!='' && $price->min!=0)
      $return['min'] = (int)$price->min-1;
    if(!empty($price) && $price->max!='' && $price->max!=0)
      $return['max'] = (int)$price->max+1; 
    return $return;
  }
} 

if ( ! function_exists('ring_styles')){ 
  function ring_styles()
  {
    $CI =& get_instance();  
      //return  $CI->db->query('SELECT DISTINCT(value), image icon  FROM `attribute_value` WHERE `attribute_id` = 1 and value !="Other" group by value order by count(group_id) desc limit 9')->result();
      
     
      return  $CI->db->query('SELECT DISTINCT (VALUE) value, image as icon FROM attribute_value WHERE product_id IN( SELECT product_id FROM `products` WHERE `vendor_id` = 3 GROUP BY group_id ) AND attribute_id = 1 LIMIT 9
')->result();
  }
}

if ( ! function_exists('ring_shapes')){ 
  function ring_shapes()
  {
    $CI =& get_instance();  
    $shapes = $CI->db->query("SELECT shapes FROM `products` order by (CHAR_LENGTH(shapes) - CHAR_LENGTH(REPLACE(shapes, ',', '')) + 1) desc limit 1")->row();
    // pr($CI->db->query("SELECT shapes FROM `products` order by (CHAR_LENGTH(shapes) - CHAR_LENGTH(REPLACE(shapes, ',', '')) + 1) desc limit 1")->row());
    return explode(',', $shapes->shapes);
  }
}

if(!function_exists('ring_metals')){ 
  function ring_metals()
  {
    $CI =& get_instance();  
      return $CI->db->query('select * from metal_colors where slug in (select products.metal_color from products where products.category_id = 2 and products.metal_color = metal_colors.slug) order by FIELD(slug, "18K-White-Gold","white-gold","18K-Yellow-Gold","yellow-gold","platinum","rose-gold","14K-Rose-Gold","silver")')->result(); 
  }
}


if(!function_exists('ring_image')){ 
  //pass -1 for all images of current shape
  function ring_image($sku='sample',$shape='Round',$order=100)
  {

    if($order > 0){
      if(file_exists(BUILDER_IMG_UPLOAD.$sku.'/'.$shape.'/'.$order.'.jpeg'))
          return BUILDER_IMG_UPLOAD.$sku.'/'.$shape.'/'.$order.'.jpeg';
      else
          return FALSE;
    }
    elseif($order == -2){
      if(file_exists(BUILDER_IMG_UPLOAD.$sku.'/side_img_lg.jpg'))
          return BUILDER_IMG_UPLOAD.$sku.'/side_img_lg.jpg';
      else  
          return FALSE;
    }
    elseif($order == -3){
      if(file_exists(BUILDER_IMG_UPLOAD.$sku.'/add_img1_lg.jpg'))
          return BUILDER_IMG_UPLOAD.$sku.'/add_img1_lg.jpg';
      else  
          return FALSE;
    }    
    else{
          return  FALSE;
    } 
  }
}
// setting_img_slider product slider single page
  if ( ! function_exists('setting_img_slider')){ 
    function setting_img_slider($media=[],$rotate='',$shapes=[],$carats=[],$_360s=[], $diamond='') 
    {  

      if(empty($media))
          return '';  
       $metal = key($media)!='' ? key($media) : NULL; 
       
        $slider = '';
        if($metal!=NULL):
          $metal_name = 'm'.str_replace('-','',$metal);
          
           $slider .= '  <div style="display:block" id="'.$metal_name.'"class="same_class '.$metal_name.'">
              <div class="col-md-12 col-lg-10 col-sm-12 pull-right">
              <div class="'.$metal_name.'_slider">'; 
            
           
            foreach($media[$metal] as $md):  
                $md = (object)$md;
                
                    $slider .= '<div class="pro-large-img img-zoom img-for-builder">';
  	                if($md->type==1){
  	                  $slider .= '<img src="'.$md->url.'" alt="'.$md->slug.'" />';
  	                }else{ 
  	                	$mp4_url = '';
  	                	if (strpos($md->url, '.mp4') !== false) {
						    $mp4_url = str_replace("http://webnetny.s3-website-us-west-2.amazonaws.com/","https://webnetny.s3-us-west-2.amazonaws.com/",$md->url);
						}
	  	                $slider .='<video height="100%" loop="true" width="100%" muted playsinline autoplay="true">
	  	                          <source src="'.$mp4_url.'" type="video/mp4">
	  	                          <source src="'.$mp4_url.'" type="video/ogg">
	  	                          Your browser does not support the video tag.
	  	                          </video>'; 
	  	                } 
	  	                $slider .='</div>';
                
                  
                
            endforeach;  
            
            if(!empty($_360s)):
              foreach ($_360s as $key => $_360):
                  
                   $_360 = (object)$_360;
                   $url = $_360->url;
                   if($key =='diamond'):
                     parse_str($_360->url, $get_array);
                     // $get_array['sv'] =0;
                     // $get_array['z'] =0;
                     // $get_array['btn'] =0;
                     // $url = str_replace('_','.',urldecode(http_build_query($get_array)));

                     $slider .='<div class="pro-large-img img-zoom">';
                     $handle = curl_init($url);
                                              curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
                                              $response = curl_exec($handle);
                                              $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
                                              if($httpCode==404){
                                                if($diamond->shape=="Round" || $diamond->shape=="European cut"){
                                                  $slider .='<img src="https://dl2vs6wk2ewna.cloudfront.net/shapes/round.jpg">';
                                                }
                                                if($diamond->shape=="Oval"){
                                                  $slider .='<img src="https://dl2vs6wk2ewna.cloudfront.net/shapes/oval.jpg"  class="ring_iframes">';
                                                }
                                                if($diamond->shape=="Emerald"){
                                                  $slider .='<img src="https://dl2vs6wk2ewna.cloudfront.net/shapes/emerald.jpg" class="ring_iframes">';
                                                }
                                                if($diamond->shape=="Asscher"){
                                                  $slider .='<img src="https://dl2vs6wk2ewna.cloudfront.net/shapes/asscher.jpg" class="ring_iframes">';
                                                }
                                                if($diamond->shape=="Cushion"){
                                                  $slider .='<img src="https://dl2vs6wk2ewna.cloudfront.net/shapes/cushion.jpg" class="ring_iframes">';
                                                }
                                                if($diamond->shape=="Radiant"){
                                                  $slider .='<img src="https://dl2vs6wk2ewna.cloudfront.net/shapes/radiant.jpg" class="ring_iframes">';
                                                }
                                                if($diamond->shape=="Pear"){
                                                  $slider .='<img src="https://dl2vs6wk2ewna.cloudfront.net/shapes/pear.jpg" class="ring_iframes">';
                                                }
                                                if($diamond->shape=="Heart"){
                                                  $slider .='<img src="https://dl2vs6wk2ewna.cloudfront.net/shapes/heart.jpg" class="ring_iframes">';
                                                }
                                                if($diamond->shape=="Baguette"){
                                                  $slider .='<img src="https://dl2vs6wk2ewna.cloudfront.net/shapes/baguette.jpg" class="ring_iframes">';
                                                }
                                                if($diamond->shape=="Princess"){
                                                  $slider .='<img src="https://dl2vs6wk2ewna.cloudfront.net/shapes/princess.jpg" class="ring_iframes">';
                                                }
                                                if($diamond->shape=="Marquise"){
                                                  $slider .='<img src="https://dl2vs6wk2ewna.cloudfront.net/shapes/marquise.jpg"  class="ring_iframes">';
                                                }
                                                
                                              }else{
                                                $slider .='<img src="'.$diamond->imagelink.'"  class="ring_iframes">';
                                              }
                     //$slider .='   <img src="'.$url.'" class="ring_iframes">';
                      $slider .='</div>';
                      //  $slider .='<div class="pro-large-img img-zoom">  
                      //   <iframe src="'.$url.'" class="ring_iframes"></iframe>
                      // </div>';
                   endif;

                   
                 
              endforeach;
            endif;
            $slider .='</div>';

           
            

            if(!empty($shapes)):
            $slider .='<div class="sel_shaps" style="display:none;">
                  <div class="col-md-6 no-pad"> 
            <form>
                <div class="form-group">
                  <div class="view-withs" style="visibility:hidden;">
                    <select id="ring_shape">';
                      foreach($shapes as $shape):
                        $slider .='<option value="'.$shape.'">'.$shape.'</option>';
                      endforeach;  
            $slider .='</select>
                  </div>
                </div>
              </form>
            </div>
            </div>';
            endif;

            // if(empty($_360s)):
              $slider .='<div class="sel_shaps2">
                 <!--<div class="d_box2 col-sm-12 col-md-12 col-lg-12 col-xs-12 no-padding1  col_clarity view-carat">-->
                  <!--<input type="text" class="js-range-slider_clarity" name="my_range5" value="" /> -->
                  <input type="hidden" id="carat_slides" value="'.decToFraction($carats,true).'" /> 
                  <input type="hidden" id="carat_values" value="'.implode(',',$carats).'" /> 
                         
                 <!--</div>--> 
                </div>';
              // endif;
            
            $slider .='<div class="like-icon"> 
                <a class="facebook" onClick="window.open(\'https://www.facebook.com/sharer/sharer.php?u='.current_url().'\');" target="_parent" href="javascript: void(0)"><i class="fa fa-facebook"></i></a>
                <a class="twitter" onClick="window.open(\'https://twitter.com/intent/tweet?url='.current_url().'\');"target="_parent" href="javascript: void(0)"><i class="fa fa-twitter"></i></a>   
                <a class="" href="#" data-toggle="modal" data-target="#shareModal" > <i class="fa fa-envelope"></i></a>
              </div>
            </div>
            <div class="col-md-12 col-lg-2 col-sm-12 hide-xs">
                <div class="pro-nav-'.$metal_name.'_slider slick-row-10 slick-arrow-style">';
                
                foreach($media[$metal] as $md):
                	
	                    $md = (object)$md;
		                  $slider .='<div class="pro-nav-'.$metal_name.'_slider-thumb slick-oultline">';
		                  if($md->type==1){
		                    $slider .='<img src="'.$md->url.'" alt="'.$md->slug.'"  />';
		                  }else{
		                  $slider .='<img src="'.base_url("assets/images/video-thumb.png").'" alt="'.$md->slug.'"  />';
		                  }  
		                  $slider .='</div>'; 
	                  
                  
                endforeach;
               

                if(!empty($_360s)):
                  foreach ($_360s as $key => $_360):
                    if($key=="diamond"){
                      $_360 = (object)$_360;
                      $slider .='<div class="pro-nav-Silver_slider-thumb slick-oultline">';
                      if($httpCode==404){
                                                if($diamond->shape=="Round" || $diamond->shape=="European cut"){
                                                  $slider .='<img class="ann" src="https://dl2vs6wk2ewna.cloudfront.net/shapes/72x72/round.jpg">';
                                                }
                                                if($diamond->shape=="Oval"){
                                                  $slider .='<img class="ann" src="https://dl2vs6wk2ewna.cloudfront.net/shapes/72x72/oval.jpg">';
                                                }
                                                if($diamond->shape=="Emerald"){
                                                  $slider .='<img class="ann" src="https://dl2vs6wk2ewna.cloudfront.net/shapes/72x72/emerald.jpg">';
                                                }
                                                if($diamond->shape=="Asscher"){
                                                  $slider .='<img class="ann" src="https://dl2vs6wk2ewna.cloudfront.net/shapes/72x72/asscher.jpg">';
                                                }
                                                if($diamond->shape=="Cushion"){
                                                  $slider .='<img class="ann" src="https://dl2vs6wk2ewna.cloudfront.net/shapes/72x72/cushion.jpg">';
                                                }
                                                if($diamond->shape=="Radiant"){
                                                  $slider .='<img class="ann" src="https://dl2vs6wk2ewna.cloudfront.net/shapes/72x72/radiant.jpg">';
                                                }
                                                if($diamond->shape=="Pear"){
                                                  $slider .='<img class="ann" src="https://dl2vs6wk2ewna.cloudfront.net/shapes/72x72/pear.jpg">';
                                                }
                                                if($diamond->shape=="Heart"){
                                                  $slider .='<img class="ann" src="https://dl2vs6wk2ewna.cloudfront.net/shapes/72x72/heart.jpg">';
                                                }
                                                if($diamond->shape=="Baguette"){
                                                  $slider .='<img class="ann" src="https://dl2vs6wk2ewna.cloudfront.net/shapes/72x72/baguette.jpg">';
                                                }
                                                if($diamond->shape=="Princess"){
                                                  $slider .='<img class="ann" src="https://dl2vs6wk2ewna.cloudfront.net/shapes/72x72/princess.jpg">';
                                                }
                                                if($diamond->shape=="Marquise"){
                                                  $slider .='<img class="ann" src="https://dl2vs6wk2ewna.cloudfront.net/shapes/72x72/marquise.jpg">';
                                                }
                                            }else{
                                                $slider .='<img class="ann" src="'.$diamond->imagelink.'">';
                                            }
                      // $slider .='<img class="ann" src="'.$_360->icon.'" alt=""  />';
                      $slider .='</div>';
                    }
                  endforeach;
                endif;
                

                $slider .='</div>
                  </div>
                </div>'; 
          endif;
        return $slider;        
    }
  }


// price fraction 
  if ( ! function_exists('price_ring_fraction')){ 
    function price_ring_fraction($data) 
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

// ring builder steps for desktop
  if ( ! function_exists('ring_builder_steps')){ 
  function ring_builder_steps($active='setting'){
    $CI =& get_instance();
    $setting_init  = $CI->session->userdata('setting_init');

    $step = 1;  
    if(!empty($setting_init) && $setting_init['step']!=0) 
        $step = $setting_init['step'];  
    elseif($active=='diamond')
        $step = 2;
    elseif($step=='setting')
        $step = 1;
    elseif($step=='review')
        $step = 3;  

    $setting_active = $diamond_active = $review_active = '';
    if($active =='diamond')
       $diamond_active = 'step-active';
    if($active =='setting')
       $setting_active = 'step-active';
    if($active =='review')
       $review_active = 'step-active';

    $default_shape = (!empty($setting_init)&& !empty($setting_init['setting'])) ? $setting_init['setting']['shape'] :''; 
    $diamond_number = $setting_number = 2; 
    $diamond_number = $step == 2 ? 1 : 2;
    $setting_number = $step == 1 ? 1 : 2;

    // pr(single_img_ring($setting_init['setting']['setting_id']));

    $setting_html = '<li class="sw-steps-step '.$setting_active.'"> <div class="sw-steps-step-container"> <span class="sw-steps-step-content"><span class="txt-shad">'.$setting_number.' </span> <span class="title_1"> <a id="Settingsw-steps" style="cursor:pointer" href="'.site_url('ring_builder').'"> <span style="padding-left:0px !important">CHOOSE A</span><br><span class="act_txt">SETTING </span></a></span> <span class="ring-steps1"> <img src="'.base_url("assets/images/ring-images/jwel.png").'"> </span></span> </div> </li>';

    $diamond_html= '<li class="sw-steps-step '.$diamond_active.'"> <div class="sw-steps-step-container"> <span class="sw-steps-step-content"><span class="txt-shad">'.$diamond_number.' </span><span class="title_2"> <a href="'.base_url('diamond/').'"><span style="1">CHOOSE A</span><br><span class="act_txt">DIAMOND </span></a></span> <span class="ring-steps2"><img src="'.base_url("assets/images/ring-builder/ring_part2.png").'"> </span></span> </div> </li>';

    $review_html = '<li class="sw-steps-step '.$review_active.'"> <div class="sw-steps-step-container"> <span class="sw-steps-step-content"><span class="txt-shad">3 </span></span><span class="complete-ring completesw-steps"><span class="ring-steps3"> <img src="'.base_url("assets/images/ring-builder/ring_part3.png").'"> </span></span> <span class="title_3"><a> <span style="padding-left:0px !important">REVIEW</span><br> <span class="act_txt">COMPLETE RING </span> </a></span> <span class="img_3"></span><span class="price_3"></span> </div> </li>';

     if(!empty($setting_init) && !empty($setting_init['setting']))
        $setting_html = '<li class="sw-steps-step '.$setting_active.'"> <div class="sw-steps-step-container"> <span class="sw-steps-step-content"><span class="txt-shad">'.$setting_number.' </span> <span class="title_1"> <a id="Settingsw-steps" style="cursor:pointer" href="'.site_url('ring_builder').'"> <span style="padding-left:0px !important">CHOOSE A</span><br><span class="act_txt">SETTING </span></a></span> <span class="prod_contents">'.((strlen($setting_init['setting']['name']) > 25) ? substr($setting_init['setting']['name'],0,25) : $setting_init['setting']['name']).' ... <span class="set_price">$'.number_format($setting_init['setting']['sale_price']).'</span> </span><span class="prd_specs"> <a href="'.site_url("build-your-own-ring/".$setting_init['setting']['slug']).'">View </a> </span> <span class="prd_specs2"> <a href="'.site_url("ring_builder?shapes=".$setting_init['setting']['shape']).'">Change</a> </span> <span class="prd_specs3"> <a href="'.base_url('build-your-own-ring/choose_setting/remove').'">Remove</a> </span> <span class="ring-steps1"> <a href="'.site_url("build-your-own-ring/".$setting_init['setting']['slug']).'"><img src="'.thumb_aws(single_img_ring($setting_init['setting']['setting_id'])[0]->url,250,250).'"></a> </span></span> </div> </li>';
      

     if(!empty($setting_init)&& !empty($setting_init['diamond']))
        $diamond_html = '<li class="sw-steps-step '.$diamond_active.'">
                     <div class="sw-steps-step-container">
                        <span class="sw-steps-step-content"><span class="txt-shad">'.$diamond_number.' </span><span class="title_2">
                        <a href="'.base_url('diamond/'.$default_shape).'"><span style="1">CHOOSE A</span><br><span class="act_txt">DIAMOND </span></a></span>
                         <span class="prod_contents">Diamond '.round($setting_init['diamond']['weight'], 2).' Carat <br/><span class="set_price">$'.number_format($setting_init['diamond']['sale_price']).'</span>
                        </span><span class="prd_specs">
                        <a href="'.site_url("diamond-details/".$setting_init['diamond']['stock_no']).'">View </a> 
                        </span>
                        <span class="prd_specs2">
                        <a href="'.site_url('diamond/'.$setting_init['diamond']['shape']).'">Change</a> 
                        </span>
                        <span class="prd_specs3">
                        <a href="'.base_url('build-your-own-ring/choose_diamond/remove').'">Remove</a> 
                        </span>
                        <span class="ring-steps2"><img  src="'.$setting_init['diamond']['image'].'"> </span></span>
                     </div>
                  </li>';
      if(!empty($setting_init) && !empty($setting_init['diamond']) && !empty($setting_init['setting']))            
      $review_html = ' <li class="sw-steps-step '.$review_active.' ">
                     <div class="sw-steps-step-container">
                        <span class="sw-steps-step-content"><span class="txt-shad">3 </span></span><span class="complete-ring completesw-steps"><span class="ring-steps3">
                        <img  src="'.base_url("assets/images/ring-builder/ring_part3.png").'"/> </span></span>
                        <span class="title_3"><a href="'.site_url("build-your-own-ring/review").'">
                        <span style="padding-left:0px !important">REVIEW</span><br>
                        <span class="act_txt">COMPLETE
                        RING </span>
                    </a></span>

                   <span class="prod_contents_complete">
                   <span class="ring_cur_price">$'.number_format($setting_init['setting']['price']+$setting_init['diamond']['price']).'</span> <span class="set_price2">$'.number_format($setting_init['setting']['sale_price']+$setting_init['diamond']['sale_price']).' </span>
                        </span> 
                       <!--  <span class="img_3"></span><span class="price_3"></span> -->
                     </div>
                  </li>';  

       $html = '<div id="sw-steps" class="only-desktop2">
               <ul class="sw-steps-container">';
              if(!empty($setting_init) && $setting_init['step'] ==1) 
                  $html .= $setting_html.' '.$diamond_html.' '.$review_html;
              elseif(!empty($setting_init) && $setting_init['step'] ==2)  
                  $html .= $diamond_html.' '.$setting_html.' '.$review_html; 
              elseif($active=='diamond')
                  $html .= $diamond_html.' '.$setting_html.' '.$review_html;
              elseif($active=='setting')
                  $html .= $setting_html.' '.$diamond_html.' '.$review_html;
              else
                  $html .= $setting_html.' '.$diamond_html.' '.$review_html;  

        return $html .='</ul><br></div>';          
    
  }
}
  // ring builder steps for desktop
  if ( ! function_exists('ring_builder_steps_mobile')){ 
  function ring_builder_steps_mobile($active='setting'){
    $CI =& get_instance();
    $setting_init  = $CI->session->userdata('setting_init');
    $step = 1;  
    if(!empty($setting_init) && $setting_init['step']!=0) 
        $step = $setting_init['step'];  
    elseif($active=='diamond')
        $step = 2;
    elseif($step=='setting')
        $step = 1;
    elseif($step=='review')
        $step = 3;  

    $setting_active = $diamond_active = $review_active = '';
    if($active =='diamond')
       $diamond_active = 'active';
    if($active =='setting')
       $setting_active = 'active';
    if($active =='review')
       $review_active = 'active';

    $default_shape = (!empty($setting_init)&& !empty($setting_init['setting'])) ? $setting_init['setting']['shape'] :''; 
    $diamond_number = $setting_number = 2; 
    $diamond_number = $step == 2 ? 1 : 2;
    $setting_number = $step == 1 ? 1 : 2;


    $setting_html = '<li class="Ring"><a href="'.base_url("ring_builder").'">Setting </a></li>';
    $diamond_html = '<li class="Diamond"><a href="'.base_url("diamond").'">Diamond </a></li>';
    $review_html = '<li class="Complete complete"> Complete </li>';


    
     if(!empty($setting_init)&& !empty($setting_init['setting']))
        $setting_html = '<li class="Ring '.$setting_active.'" style="width: 30%;">
                  Setting <span class="done_icons"><i class="fa fa-check"></i> </span>
                  <!--  view change or remove for mobile or tablet view only visible when adding setting -->
                  <div class="dropdown drp-styles">
                     <button class="btn btn-primary dropdown-toggle drp_btns" type="button" data-toggle="dropdown" aria-expanded="true"><i class="fa fa-check" aria-hidden="true"></i></button>
                 
                     <ul class="dropdown-menu mob-drop-filter">
                        <li>
                           <a href="'.site_url("build-your-own-ring/".$setting_init['setting']['slug']).'">
                              <img class="mob-filt-imgs" src="'.thumb_aws(single_img_ring($setting_init['setting']['setting_id'])[0]->url,68,68).'">
                              <p>'.$setting_init['setting']['name'].' - $'.number_format($setting_init['setting']['sale_price']).' </p>
                           </a>
                        </li>
                        <li><a href="'.site_url("build-your-own-ring/".$setting_init['setting']['slug']).'">View</a></li>
                        <li><a href="'.site_url("ring_builder?shapes=".$setting_init['setting']['shape']).'">Change</a></li>
                        <li><a href="'.base_url('build-your-own-ring/choose_setting/remove').'">Remove</a></li>
                     </ul>
                  </div>
               </li>';

     if(!empty($setting_init)&& !empty($setting_init['diamond'])) 
      $diamond_html = '<li class="Diamond '.$diamond_active.'" style="width: 30%;">
                  Diamond <span class="done_icons"><i class="fa fa-check"></i> </span>
                  <!--  view change or remove for mobile or tablet view only visible when adding setting -->
                  <div class="dropdown drp-styles">
                     <button class="btn btn-primary dropdown-toggle drp_btns" type="button" data-toggle="dropdown" aria-expanded="true"><i class="fa fa-check" aria-hidden="true"></i></button>
                 
                     <ul class="dropdown-menu mob-drop-filter">
                        <li>
                           <a href="'.site_url("diamond-details/".$setting_init['diamond']['stock_no']).'">
                              <img class="mob-filt-imgs" src="'.$setting_init['diamond']['image'].'">
                              <p>Diamond '.$setting_init['diamond']['weight'].' Carat - $'.number_format($setting_init['diamond']['sale_price']).' </p>
                           </a>
                        </li>
                        <li><a href="'.site_url("diamond-details/".$setting_init['diamond']['stock_no']).'">View</a></li>
                        <li><a href="'.site_url('diamond/'.$setting_init['diamond']['shape']).'">Change</a></li>
                        <li><a href="'.base_url('build-your-own-ring/choose_diamond/remove').'">Remove</a></li>
                     </ul>
                  </div>
               </li>';            
                  
      if(!empty($setting_init) && !empty($setting_init['diamond']) && !empty($setting_init['setting']))           
          $review_html = '<li class="Complete complete '.$review_active.'" style="width: 30%;"><a href="'.site_url('/build-your-own-ring/review').'">  </a> </li>';

       $html = '<div class="mobiles-container only-mobiles">
               <ul class="mobile-box show" style="display:none;margin-top: 10px;">';
              if(!empty($setting_init) && $setting_init['step'] ==1) 
                  $html .= $setting_html.' '.$diamond_html.' '.$review_html;
              elseif(!empty($setting_init) && $setting_init['step'] ==2)  
                  $html .= $diamond_html.' '.$setting_html.' '.$review_html; 
              elseif($active=='diamond')
                  $html .= $diamond_html.' '.$setting_html.' '.$review_html;
              elseif($active=='setting')
                  $html .= $setting_html.' '.$diamond_html.' '.$review_html;
              else
                  $html .= $setting_html.' '.$diamond_html.' '.$review_html;  

        return $html .='</ul></div>';          
    
  }
}
?>





