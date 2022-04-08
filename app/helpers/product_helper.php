<?php defined('BASEPATH') OR exit('No direct script access allowed');

/** Product Grid view **/
if ( ! function_exists('grid_pro_jwel')){

    function grid_pro_jwel($products='',$links=''){ 
      // pr($products);
      // exit();
      $html ='';
      if(!empty($products)){ 
        $html .= '<div id="grid_pro">';
             foreach($products as $product){ 
        $html .= '<div class="col-md-3 col-sm-4 col-xs-6 only-large">
		         
              <div class="item-product item-product4 text-center border">';
                $html.='
          <div class="product-thumb">
                    <a href="'.site_url('shop/'.strtolower($product->slug)).'" class="product-thumb-link zoom-thumb">';
          
         /*if(strposvis($product->group_id, 'MOUNT') !== false){          
          $html .= '<img data-src="'.thumb($product->image,200,200).'" data-src2="'.thumb(media('','','','',array('metal'=>$product->metal_type,'fake_sku'=>$product->fake_sku,'sort_order'=>1)),200,200).'" abc src="'.thumb(media('','','','',array('metal'=>$product->metal_type,'fake_sku'=>$product->fake_sku,'sort_order'=>0)),200,200).'" alt="">';
        }
        else*/{
          $html .= '<img data-src="'.thumb_aws($product->image,200,200).'" data-src2="'.thumb_aws(media($product->pro_id,'product',1,1),200,200).'" src="'.thumb_aws(media($product->pro_id,'product'),200,200).'" alt="">';
        }  

           $html .= '</a>
                    <a href="javascript:void(0);" data-pid="'.$product->pro_id.'" data-class="my-custom-class" data-id="'.strtolower($product->slug).'" class="quickview-link trigger title12 round white">Quick View</i></a>
                  </div>  ';
 // getting color and gem filter
                 
                     
              $html .= '<div class="product-info"> 
                  <h3 class="title14 product-title"><a href="'.site_url('shop/'.strtolower($product->slug)).'" class="black">'.ucwords($product->name).'</a></h3>
                  <div class="product-price title14 play-font">';
                      $html .=  '<ins class="black title18">$'.number_format(round($product->sale_price)).'</ins>';
                          if($product->discount!='' && number_format(round($product->price)) > number_format(round($product->sale_price)))  
                          $html .=  '<del class="silver">$'.number_format(round($product->price)).'</del>';   

                    $html.='</div></div>';
                    // $group_gem = get_group_gem($product->group_id);
                    // if($group_gem)
                    //    $html .= get_group_gem($product->group_id);
                    // else
                    //    $html .= get_group_metal($product->group_id);   

                  $html.='<ul class="wrap-rating list-inline-block">
                    <li>';
                        $reviews = reviews_count_avg($product->pro_id);
            
                      //       $html.='<div class="product-rate">
                      //   <div class="product-rating" style="width:'.(ratings($product->pro_id)*20).'%"></div>
                      // </div>';

            $html.='</li>';
              $html.='<li>';

            $html.='<span class="rate-number silver">('.$reviews->reviews_count.')</span>';
            
                $html.='</li>
                  </ul>';
                  $html.='<input type="hidden" class="form-control" value="'.$product->pro_id.'" name="pro_id" id="pro_id" required="">
                  <input type="hidden" name="metal_color" id="metal_color" value="'.$product->metal_color.'">
                  <input type="hidden" id="product_price" = value="'.$product->sale_price.'">
                  <input type="hidden" id="product_name" = value="'.ucwords($product->name).'">
                  <input type="hidden" class="form-control" value="'.strtolower($product->slug).'" name="product_slug" id="product_slug" required="">
                  <input type="hidden" name="ptype" id="ptype" value="Jewelry">';

                /*if(media($product->pro_id,'product',2)){
                  $html .='<div class="product-extra-link42 wishlist-top2 title18"> 
                    <a href="javascript:void(0);" class="black inline-block wishme hi-icon hi-icon-archive" ><i class="fa fa-play" aria-hidden="true" style="
                      padding-left: 4px;
                      color: #fff;
                  "></i>
                    <!--<span class="title10 white text-uppercase">Wishlist</span>--></a>
                  </div>';
                } */ 
                  $html.='<div class="product-extra-link42 wishlist-top1 title18">
          

                    <a href="javascript:void(0);" class=" black inline-block add_wish wishme hi-icon hi-icon-archive  wish_top '.cookie_wish('jewelry',$product->pro_id).' "  data-product="'.$product->pro_id.'" data-type="jewelry" ><i class="fa fa-heart-o"></i>
                    <!--<span class="title10 white text-uppercase">Wishlist</span>--></a>
                  </div>
               
              </div>
            </div> '; 
      //                    <!-- <a href="'.site_url('shop/'.strtolower($product->product_slug)).'" class="addcart-link black inline-block cart-top "><i class="icon ion-bag"></i><span class="title10 white text-uppercase">Add to cart</span></a>  -->
              } 
      $html .= '</div>'; 
      if(isset($links))
        $html .= $links;
       }  
        return $html;
  }
}
 

if ( ! function_exists('grid_pro_new')){

  function grid_pro_new($products='',$category_id=''){ 
    $html ='';
    if(!empty($products)){ 
      
      $html .= '<div id="grid_pro">';
           foreach($products as $product){ 
            $link = 'shop/';
            if(isset($product->category_id)){
              if($product->category_id==2){
                $link  = 'build-your-own-ring/';
              }
            }
            

      $html .= '<div class="col-md-3 col-sm-4 col-xs-6 only-large">
           
            <div class="item-product item-product4 text-center border">
            
            ';
              
              $html.='
        <div class="product-thumb">

                  <a href="'.site_url($link.strtolower($product->slug)).'" class="product-thumb-link zoom-thumb">';
        
      
        $html .= '<img src="'.thumb_aws($product->image,200,200).'" alt="">';
      

         $html .= '</a>
                  <a href="javascript:void(0);" data-pid="'.$product->pro_id.'" data-class="my-custom-class" data-id="'.strtolower($product->slug).'" class="quickview-link trigger title12 round white">Quick View</i></a>
                </div>  ';

               
                   
            $html .= '<div class="product-info"> 
                <h3 class="title14 product-title"><a href="'.site_url($link.strtolower($product->slug)).'" class="black">'.ucwords($product->name).'</a></h3>
                <div class="product-price title14 play-font">';
                    $html .=  '<ins class="black title18">$'.number_format(round($product->sale_price)).'</ins>';
                        if($product->discount!='' && number_format(round($product->price)) > number_format(round($product->sale_price)))  
                        $html .=  '<del class="silver">$'.number_format(round($product->price)).'</del>';   

                  $html.='</div></div>';
                
                
                $html.='<input type="hidden" class="form-control" value="'.$product->pro_id.'" name="pro_id" id="pro_id" required="">
                <input type="hidden" name="metal_color" id="metal_color" value="'.$product->metal_color.'">
                <input type="hidden" id="product_price" = value="'.$product->sale_price.'">
                <input type="hidden" id="product_name" = value="'.ucwords($product->name).'">
                <input type="hidden" class="form-control" value="'.strtolower($product->slug).'" name="product_slug" id="product_slug" required="">
                <input type="hidden" name="ptype" id="ptype" value="Jewelry">';

            
                $html.='<div class="product-extra-link42 wishlist-top1 title18">
        

                  <a href="javascript:void(0);" class=" black inline-block add_wish wishme hi-icon hi-icon-archive  wish_top '.cookie_wish('jewelry',$product->pro_id).' "  data-product="'.$product->pro_id.'" data-type="jewelry" ><i class="fa fa-heart-o"></i>
                  </a>
                </div>
             
            </div>
          </div> '; 
    
            } 
    $html .= '</div>'; 
    // if(isset($links))
    //   $html .= $links;
     }  
      return $html;
  }
}



/** Product vision_360 view **/
if ( ! function_exists('vision_360')){

    function vision_360($products='',$links=''){ 
      $html ='';
      if(!empty($products)){ 
        $html .= '<div id="grid_pro">';
             foreach($products as $product){ 
              //  pr(media($product->pro_id,'product',2));
              //  pr($product);
              //  exit();
        $html .= '<div class="col-md-3 col-sm-4 col-xs-6 only-large">
             
              <div class="item-product item-product4 text-center border">';
            $html.='<div class="product-thumb video-thumb" data-id="'.$product->pro_id.'">
                          <a href="'.site_url('shop/'.strtolower($product->product_slug)).'" class="product-thumb-link zoom-thumb">';
                      $html .= '<img id="img_'.$product->pro_id.'"  src="'.thumb($product->image,263,253).'" alt="">';
                      $html .= '<video style="display:none;" src="'.MEDIA.media($product->pro_id,'product',2).'" id="video_'.$product->pro_id.'" data-video="'.MEDIA.media($product->pro_id,'product',2).'" height="100%" loop="true" width="100%" muted  playsinline autoplay>Your browser does not support the video tag.</video>';
                 $html .= '</a>
                    <a href="javascript:void(0);" data-pid="'.$product->pro_id.'" data-class="my-custom-class" data-id="'.strtolower($product->product_slug).'" class="quickview-link trigger title12 round white">Quick View</i></a>
                  </div>  
           <div class="product-info"> 
                  <h3 class="title14 product-title"><a href="'.site_url('shop/'.strtolower($product->product_slug)).'" class="black">'.ucwords($product->product_name).'</a></h3>
                  <div class="product-price title14 play-font">';
                      $html .=  '<ins class="black title18">$'.number_format(round($product->product_sale_price)).'</ins>';
                          if($product->product_discount!='' && number_format(round($product->product_price)) > number_format(round($product->product_sale_price)))  
                          $html .=  '<del class="silver">$'.number_format(round($product->product_price)).'</del>';   

                    $html.='</div></div>';
                    // getting color and gem filter
                    $group_gem = get_group_gem($product->group_id);
                    if($group_gem)
                       $html .= get_group_gem($product->group_id);
                    else
                       $html .= get_group_metal($product->group_id);    

                  $html.='<ul class="wrap-rating list-inline-block">
                    <li>';
            $reviews = reviews_count_avg($product->pro_id);
            
                            $html.='<div class="product-rate">
                        <div class="product-rating" style="width:'.(ratings($product->pro_id)*20).'%"></div>
                      </div>';

            $html.='</li>
                    <li>';

            $html.='<span class="rate-number silver">('.$reviews->reviews_count.')</span>';
            
                $html.='</li>
                  </ul>';
                  $html.='<input type="hidden" class="form-control" value="'.$product->pro_id.'" name="pro_id" id="pro_id" required="">
                  <input type="hidden" name="metal_color" id="metal_color" value="'.$product->metal_color.'">
                  <input type="hidden" id="product_price" = value="'.$product->product_sale_price.'">
                  <input type="hidden" id="product_name" = value="'.ucwords($product->product_name).'">
                  <input type="hidden" class="form-control" value="'.strtolower($product->product_slug).'" name="product_slug" id="product_slug" required="">
                  <input type="hidden" name="ptype" id="ptype" value="Jewelry">';

                if(media($product->pro_id,'product',2)){
                  $html .='<div class="product-extra-link42 wishlist-top2 title18"> 
                    <a href="javascript:void(0);" class="black inline-block wishme hi-icon hi-icon-archive" ><i class="fa fa-play 360play" aria-hidden="true" style="
                      padding-left: 4px;
                      color: #fff;
                  "></i>
                    <!--<span class="title10 white text-uppercase">Wishlist</span>--></a>
                  </div>';
                }  
                  $html.='<div class="product-extra-link42 wishlist-top1 title18">
          

                    <a href="javascript:void(0);" class=" black inline-block add_wish wishme hi-icon hi-icon-archive  wish_top '.cookie_wish('jewelry',$product->pro_id).' "  data-product="'.$product->pro_id.'" data-type="jewelry" ><i class="fa fa-heart-o"></i>
                    <!--<span class="title10 white text-uppercase">Wishlist</span>--></a>
                  </div>
               
              </div>
            </div> '; 
      //                    <!-- <a href="'.site_url('shop/'.strtolower($product->product_slug)).'" class="addcart-link black inline-block cart-top "><i class="icon ion-bag"></i><span class="title10 white text-uppercase">Add to cart</span></a>  -->
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
                                  $handle = curl_init($md->url);
                                      curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

                                      /* Get the HTML or whatever is linked in $url. */
                                      $response = curl_exec($handle);

                                      /* Check for 404 (file not found). */
                                      $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
                                      if($httpCode == 200) {
                                  $quick .= '<div class="pro-large-img img-zoom ">';
                                    if($md->type==1){
                                       $quick .='<img id="theImagev3"  src="'.$md->url.'" alt="'.strtolower($product->slug).'"/>';
                                     }
                                     else{
                                      $mp4_url = str_replace("http://webnetny.s3-website-us-west-2.amazonaws.com/","https://webnetny.s3-us-west-2.amazonaws.com/",$md->url);
                                        $quick .='<video height="100%" loop="true" width="100%" muted playsinline autoplay="true">
                                    <source src="'.$mp4_url.'" type="video/mp4">
                                    <source src="'.$mp4_url.'" type="video/ogg">
                                    Your browser does not support the video tag.
                                  </video>';
                                     }
                                    $quick .='</div>'; 
                                  }
                                 }
               $quick .=      '</div>
                              </div>
                              <div class="col-md-12 col-lg-12 col-sm-12 hide-xs">
                                 <div class="pro-nav'.$product->product_id.' pro-nav'.$product->product_id.'_list slick-row-10 slick-arrow-style">';
                                  foreach($media as $md){     
                                  $handle = curl_init($md->url);
                                      curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

                                      /* Get the HTML or whatever is linked in $url. */
                                      $response = curl_exec($handle);

                                      /* Check for 404 (file not found). */
                                      $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
                                     
                                      if($httpCode == 200) {  
                      $quick .=         '<div class="pro-nav-thumb">';
                                        if($md->type==1){
                                          $quick.= '<img  src="'.$md->url.'" alt="'.$product->name.'" />';
                                        }else{
                                            $quick .='<img src="'.base_url('assets/images/video-thumb.png').'" alt="'.$product->name.'"  class="left_shifted_thumb" />';
                                          }
                                       $quick .='</div>'; 
                                    }    
                                  }               
                                     
                $quick .=      '</div>
                              </div>
                           </div>
                           <!-- rose gold end here -->
                        </div>
                     </div>
                     <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="detail-info">
                           <h2 class="product-title title24 dark font-bold">'.ucwords($product->name).'</h2>
                           <div class="inner-title">('.ucwords(str_replace('-',' ', $product->metal_color)).$weight.')</div>
                           <div class="item-product-meta-info product-code-info">
                              <label>Product Code:</label>
                              <span>#'.$product->sku.'</span>
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
                         
                     $quick .= '<ins class="title24 color font-bold">$'.number_format(round($product->sale_price)).'</ins>';
                       if($product->discount!='' || $product->product_discount!=0)
                     $quick .= '<del class="dark opaci title24">$'.number_format(round($product->price)).'</del>';
                      if($product->discount!='' && number_format(round((($product->price-$product->sale_price)/$product->price)*100))!=0)   
                     $quick .= '<span class="discount-rate">'.number_format(round((($product->price-$product->sale_price)/$product->price)*100)).' % Off</span>';
                     $quick .='</div>
                           <div class="clearfix"></div>
                           <!-- metal type filters -->
                           <div class="clearfix"></div>
                           <div class="detail-attr btn-cart">

                              
                              <a href="'.site_url('shop/'.strtolower($product->slug)).'" class="shop-button bg-dark1 addcart-link font-bold text-uppercase">Buy Now</a>
                           </div>';
                
               
               
                           $quick.='<div class="like-icon">
                               <div class="like-icon">
                              <a class="facebook" onClick="window.open(\'https://www.facebook.com/sharer/sharer.php?u='.site_url('shop/'.strtolower($product->slug)).'\');" target="_parent" href="javascript: void(0)"><i class="fa fa-facebook"></i></a><a class="twitter" onClick="window.open(\'https://twitter.com/intent/tweet?url='.site_url('shop/'.strtolower($product->slug)).'\');"target="_parent" href="javascript: void(0)"><i class="fa fa-twitter"></i></a>   
                                              
                             
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
 
 
 

?>