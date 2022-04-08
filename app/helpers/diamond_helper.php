<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/** Diamond Grid view **/
if (!function_exists('grid_dmd')) {
    
    function grid_dmd($diamonds = '', $links = '')
    {
        $html = '';
        if (!empty($diamonds)) {
            $html .= '<div id="diamond_grid">';
            foreach ($diamonds as $diamond) {
                $html .= '<div class="col-md-3 col-sm-4 col-xs-6 only-large ">

                                 <div class="item-product item-product4 text-center border">
                                    <div class="product-thumb ">
                                       <a href="'.base_url('diamond-details/'.$diamond->stock_no).'" class="zoom-thumb">
                                       <div id="event_'.$diamond->stock_no.'" class="img-event image-container">
 
                                        <img src="'.thumb(diamond_img($diamond->imagelink,$diamond->stock_no),270,270).'" class="replace-img frame_image lazyload" alt="">
                                        <div class="curtain"><div class="shine"></div></div>
                                        <!--<video id="98" width="100%" height="250" autoplay src="https://padesignsusa.com/pa_jewelers/public/uploads/products/5cee87a40eccb_3765.m4v"></video>-->
                                         </div>
                                        </a>
                                      <!-- <a href="'.site_url('diamond-details/'.$diamond->stock_no).'" class="quickview-link1 title12 round white"><i class="fa fa-search"></i></a>-->
                                    </div>
                                    <div class="product-info">
                                       <h3 class="title14 product-title"><a href="'.base_url('diamond-details/'.$diamond->stock_no).'" class="black">'.round($diamond->weight,2).' Carat '.$diamond->color.' '.$diamond->clarity.' 
 '.$diamond->cut_grade.' Cut '.$diamond->shape.' Diamond
                                       </a></h3>';

                                       //$html .= unserialize(DIAMOND_CUT)[$diamond->cut_grade].'Cut | '.ucwords(strtolower($diamond->color)).' Color '.(($diamond->clarity!="" && $diamond->clarity!="NA")?" | ".$diamond->clarity." Clarity":"");

                                       $html.='<div class="show-properties-container">
                                          <div class="show-properties-inner1">
                                             <div class="dots-1">...</div>
                                          </div>
                                          <span class="display-onhover">
                                             <div class="bg-slide">
                                                <li class="item-lists">
                                                   <div class="left-align">Item:</div>
                                                   <div class="right-align">#'.$diamond->stock_no.'</div>
                                                </li>
                                                <li class="item-lists">
                                                   <div class="left-align">Carat:</div>
                                                   <div class="right-align">'.round($diamond->weight,2).'</div>
                                                </li>
                                                <li class="item-lists">
                                                   <div class="left-align">Color:</div>
                                                   <div class="right-align">'.$diamond->color.'</div>
                                                </li>
                                                <li class="item-lists">
                                                   <div class="left-align">Clarity:</div>
                                                   <div class="right-align">'.$diamond->clarity.'</div>
                                                </li>
                                                <li class="item-lists">
                                                   <div class="left-align">Cut:</div>
                                                   <div class="right-align">'.$diamond->cut_grade.'</div>
                                                </li>
                                                <li class="item-lists">
                                                   <div class="left-align">Pol/sym</div>
                                                   <div class="right-align">'.$diamond->polish.'/'.$diamond->symmetry.'</div>
                                                </li>
                                                <li class="item-lists">
                                                   <div class="left-align">Fluorescence</div>
                                                   <div class="right-align">'.$diamond->fluorescence_intensity.'</div>
                                                </li>
                                                <li class="item-lists">
                                                   <div class="left-align">Measure</div>
                                                   <div class="right-align">'.$diamond->measurements.'</div>
                                                </li>
                                                <li class="item-lists">
                                                   <div class="left-align">lab</div>
                                                   <div class="right-align certificatelink"  data-toggle="modald" data-target="#certififyModald" data-cert="'.$diamond->certificatelink.'">'.$diamond->lab.'</div>
                                                </li>
                                             </div>
                                          </span>
                                       </div>
                                       <div class="product-price title14 play-font">
                                         
                                          <ins class="black title18">$'.number_format(round($diamond->actual_price)).'</ins>';
                                          if(round($diamond->mrp)!=round($diamond->actual_price))
                    $html .=            '<del class="silver">$'.number_format(round($diamond->mrp)).'</del>';
                    $html .=            '</div>
                                       
                                       <div class="product-extra-link4 title18">
                                          <a href="javascript:void(0);"   data-diamond="'.$diamond->stock_no.'" data-type="diamond-compare"   class="compare-link inline-block add_compare '.diamond_cookie('diamond-compare',$diamond->stock_no).'"><i class="icon ion-ios-loop-strong"></i><span class="title10 white text-uppercase">Compare</span></a>
                                          
                                          <a href="javascript:void(0);" data-product="'.$diamond->stock_no.'" data-type="diamond"  class="wishlist-link black inline-block add_wish   '.diamond_cookie('diamond',$diamond->stock_no).'"><i class="icon ion-android-favorite-outline"></i><span class="title10 white text-uppercase">Wishlist</span></a>
                                       </div>
                                    </div>
                                 </div>
 							  </div> ';
            } 
 
            $html .= '</div>';
            if (isset($links))
                $html .= $links;
        }
        return $html; 
    }
}



/** Diamond Grid view **/
if (!function_exists('list_dmd')) {
    
    function list_dmd($diamonds = '', $links = '')
    {
        $html = '';
        if (!empty($diamonds)) {
            $html .= '<div class="row"><div class="flex-container displayonlist">
                        
                        <div class="flex-item">Shape</div>
                        <div class="flex-item">Carat</div>
                        <div class="flex-item hidden-xs">Color</div>
                         <div class="flex-item hidden-xs">Clarity</div>
                        <div class="flex-item hidden-xs">Cut</div>
                        <div class="flex-item hidden-xs">Lab</div>
                        <div class="flex-item">Price</div>
                        <div class="flex-item hidden-xs">Compare</div>
                        <div class="flex-item hidden-xs">Wishlist</div>
                        <div class="flex-item"></div>
                    </div>
                    </div>
                     <div class="row" id="diamond_list">
                        <div class="col-md-12 no-pad">';
            foreach ($diamonds as $diamond) {
                $html .= '<div class="item-product item-product1 item-product-list">
                           <div class="row">
                              <div class="list-display-block list_block">
                                 <div class="flex-container-section " style="color: black;">
                                    
                                    <!-- Oval 0.33 Carat D VS1 -->
                                    <div class="flex-item-new">'.$diamond->shape.'</div>
                                    <div class="flex-item-new">'.round($diamond->weight,2).'</div>
                                    <div class="flex-item-new hidden-xs">'.$diamond->color.'</div>
                                    <div class="flex-item-new hidden-xs">'.$diamond->clarity.'</div>
                                    <div class="flex-item-new hidden-xs">'.$diamond->cut_grade.'</div>
                                    <div class="flex-item-new certificatelink hidden-xs" data-toggle="modald" data-target="#certififyModald" data-cert="'.$diamond->certificatelink.'"> <span>'.$diamond->lab.'</span>
                                    </div>
                                    <div class="flex-item-new" style="font-size:18px">$'.number_format(round($diamond->actual_price)).'</div>
                                    <div class="flex-item-new  bt-icon hidden-xs">
                                       <a href="javascript:void(0);"   data-diamond="'.$diamond->stock_no.'" data-type="diamond-compare"  class="compare-link add_compare '.diamond_cookie('diamond-compare',$diamond->stock_no).'"> <span class="icon-compare">
                                                       <i class="icon ion-ios-loop-strong"></i>
                                                     </span>
                                       </a>
                                    </div>
                                    <div class="flex-item-new  bt-icon hidden-xs">
                                       <a href="javascript:void(0);" data-product="'.$diamond->stock_no.'" data-type="diamond"    class="wishlist-link add_wish  '.diamond_cookie('diamond',$diamond->stock_no).' "> <span class="icon-wishlist2 ">
                                                    <i class="icon ion-android-favorite-outline"></i>
                                                  </span>
                                       </a>
                                    </div>
                                    <div class="flex-item-new"> <a href="'.site_url('diamond-details/'.$diamond->stock_no).'" class="btn btn-round btn-border">Details</a>
 
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div> ';
            }

            $html .= '</div> </div>';
            if (isset($links))
                $html .= $links;
        }
        return $html; 
    }
}

if (!function_exists('diamond_cookie'))
{ 
    function diamond_cookie($cookie='cookie',$ele=0){ 
        if(isset($_COOKIE[$cookie]) && in_array($ele, json_decode($_COOKIE[$cookie])))
          return 'active';
        else
          return false;
    }
}
  

if (!function_exists('diamond_img'))
{ 
    function diamond_img($url='',$stock=''){ 
      if($url!='' && $stock!=''){
          if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/'.DIAMOND_IMG_UPLOAD.$stock.'.'.pathinfo($url, PATHINFO_EXTENSION))) 
              if(copy($url, $_SERVER['DOCUMENT_ROOT'].'/'.DIAMOND_IMG_UPLOAD.$stock.'.'.pathinfo($url, PATHINFO_EXTENSION)))
                  return DIAMOND_IMG_UPLOAD.$stock.'.'.pathinfo($url, PATHINFO_EXTENSION);
              else
                  return $url;
          else
              return DIAMOND_IMG_UPLOAD.$stock.'.'.pathinfo($url, PATHINFO_EXTENSION);          
      }else{
        return $url;
      }      
    }
}



if (!function_exists('get_full_form'))
{
    function get_full_form($field='', $key=''){

      /*for allow_raplink_feed*/
      if($field=="allow_raplink_feed"){
        $dataArr = array("Y"=>"Yes","N"=>"No");
        if(array_key_exists($key,$dataArr))
            return $dataArr[$key];
        else
          return false;
      }


      /*for availability*/
      if($field=="availability"){
      $dataArr = array(
                            "G"=>"Guaranteed Availability",
                            "M"=>"Out on Memo",
                            "STPS"=>"Subject to Prior Sale",
                            "NA"=>"Not Available"
                        );
      if(array_key_exists($key,$dataArr))
            return $dataArr[$key];
        else
          return false;
      }


      /*for clarity*/
      if($field=="clarity"){
      $dataArr = array(
                      "FL"=>"Flawless",
                      "IF"=>"Internally Flawless",
                      "Loupe Clean"=>"Loupe Clean",
                      "LC"=>"",
                      "VVS1"=>"Very Very Slightly Included",
                      "VVS2"=>"Very Very Slightly Included",
                      "VS1"=>"Very Slightly Included",
                      "VS2"=>"Very Slightly Included",
                      "SI1"=>"Slightly Included",
                      "SI2"=>"Slightly Included",
                      "I1"=>"Included",
                      "P1"=>"Guaranteed",
                      "I2"=>"Included",
                      "P2"=>"",
                      "I3"=>"Included 3",
                      "P3"=>"",
                      "N"=>"None",
                      ""=>"None"
                  );
        if(array_key_exists($key,$dataArr))
            return $dataArr[$key];
        else
          return false;
      }


      /*for color*/
      if($field=="color"){
      $dataArr = array(
                 "D"=>"","E"=>"","F"=>"","G"=>"","H"=>"","I"=>"","J"=>"","K"=>"","L"=>"","M"=>"","N"=>"","O"=>"","P"=>"","Q"=>"","R"=>"","S"=>"","T"=>"","U"=>"","V"=>"","W"=>"","X"=>"","Y"=>"","Z"=>""
              );
        if(array_key_exists($key,$dataArr))
            return $dataArr[$key];
        else
          return false;
      }


      /*for culet_condition*/
      if($field=="culet_condition"){
        $dataArr = array("P"=>"Pointed","C"=>"Abraded","C"=>"Chipped");
        if(array_key_exists($key,$dataArr))
            return $dataArr[$key];
        else
          return false;
      }


      /*for culet_size*/
      if($field=="culet_size"){
      $dataArr = array(
                        "EL" => "Extremely Large",
                        "VL" => "Very Large",
                        "L" => "Large",
                        "SL" => "Slightly Large",
                        "M" => "Medium",
                        "S" =>"Small",
                        "VS" => "Very Small",
                        "N" => "None",
                        "NON" => "None"
                      );
       if(array_key_exists($key,$dataArr))
            return $dataArr[$key];
        else
          return false;
      }


      /*for cut_grade*/
      if($field=="cut_grade"){
      $dataArr = array(
                        "I" => "Ideal",
                        "EX" => "Excellent",
                        "VG" => "Very Good",
                        "G" => "Good",
                        "F" => "Fair",
                        "P" =>"Poor"
                      );
       if(array_key_exists($key,$dataArr))
            return $dataArr[$key];
        else
          return false;
      }


      /*for display_cert number*/
      if($field=="availability"){
        $dataArr = array("Y"=>"Yes","N"=>"No");
        if(array_key_exists($key,$dataArr))
            return $dataArr[$key];
        else
          return false;
      }


      /*for availability*/
      if($field=="fancycolor"){

      $dataArr = array(
                            "BK"=>"Black",
                            "B"=>"Blue",
                            "BN"=>"Brown",
                            "CH"=>"Chameleon",
                            "CM"=>"Champagne",
                            "CG"=>"Cognac",
                            "GY"=>"Gray",
                            "G"=>"Green",
                            "O"=>"Orange",
                            "P"=>"Pink",
                            "PL"=>"Purple",
                            "R"=>"Red",
                            "V"=>"Violet",
                            "Y"=>"Yellow",
                            "W"=>"White",
                            "X"=>"Other"
                      );
       if(array_key_exists($key,$dataArr))
            return $dataArr[$key];
        else
          return false;
      }


      /*for fancy_color_intensity*/
      if($field=="fancy_color_intensity"){
      $dataArr = array(
                            "F"=>"Faint",
                            "VL"=>"Very Light",
                            "L"=>"Light",
                            "FCL, FL"=>"Fancy Light",
                            "FC"=>"Fancy",
                            "FCD"=>"Fancy Dark",
                            "I"=>"Fancy Intense",
                            "FV"=>"Fancy Vivid",
                            "D"=>"Fancy Deep",
                      );
        if(array_key_exists($key,$dataArr))
            return $dataArr[$key];
        else
          return false;
      }


      /*for fluorescence_color*/
      if($field=="fluorescence_color"){
       $dataArr = array(
                          "B" => "Blue",
                          "W" => "White",
                          "Y" => "Yellow",
                          "O" => "Orange",
                          "R" => "Red",
                          "G" => "Green",
                          "N" => "None"
                      );
        if(array_key_exists($key,$dataArr))
            return $dataArr[$key];
        else
          return false;
      }


      /*for fluorescence_intensity*/
      if($field=="fluorescence_intensity"){
        $dataArr = array(
                        "VS" => "Very Strong",
                        "S" => "Strong",
                        "M" => "Medium",
                        "F" => "Faint",
                        "SL" >= "Slight",
                        "VSL" => "Very Slight",
                        "N" => "None"
                      );
      if(array_key_exists($key,$dataArr))
            return $dataArr[$key];
        else
          return false;
      }


      /*for girdle_condition*/
      if($field=="girdle_condition"){
        $dataArr = array(
                        "P" => "Polished",
                        "F" => "Faceted",
                        "B" => "Bruted"
                      );
      if(array_key_exists($key,$dataArr))
            return $dataArr[$key];
        else
          return false;
      }

     /*for lab*/
     if($field=="lab"){
        $dataArr = array(
                  "GIA"=>"assets/images/labs/lab-gia.png",
                  "AGS"=>"assets/images/labs/lab-ags.png",
                  "CGL"=>"assets/images/labs/lab-cgl.png",
                  "DCLA"=>"assets/images/labs/lab-dcla.png",
                  "GCAL"=>"assets/images/labs/lab-gcal.png",
                  "GSI"=>"assets/images/labs/lab-gsi.png",
                  "HRD"=>"assets/images/labs/lab-hrd.png",
                  "IGI"=>"assets/images/labs/lab-igi.png",
                  "NGTC"=>"assets/images/labs/lab-ngtc.png",
                  "PGS"=>"assets/images/labs/lab-pgs.png",
                  "VGR"=>"assets/images/labs/lab-vgr.png",
                  "IDR"=>"assets/images/labs/lab-idr.png",
                  "GHI"=>"assets/images/labs/lab-ghi.png",
                  "SGL"=>"assets/images/labs/lab-sgl.png",
                  "IIDGR"=>"assets/images/labs/lab-iidgr.png",
                  "None"=>"assets/images/labs/lab_logo.png",
                  "OTHER_LABS"=>"assets/images/labs/lab-other.png"
              );
      if(array_key_exists($key,$dataArr))
            return $dataArr[$key];
        else
          return false;
      }


      /*for polish*/
      if($field=="polish"){
    $dataArr = array(
                  "I"=>"I",
                  "EX"=>"Excellent",
                  "VG-EX"=>"Very Good to Excellent",
                  "VG"=>"Very Good",
                  "G-VG"=>"Good to Very Good",
                  "G"=>"Good",
                  "F-G"=>"Fair to Good",
                  "F"=>"Fair",
                  "P"=>"Poor"
              );
      if(array_key_exists($key,$dataArr))
            return $dataArr[$key];
        else
          return false;
      }


      /*for symmetry*/
      if($field=="symmetry"){
    $dataArr = array(
                  "I"=>"I",
                  "EX"=>"Excellent",
                  "VG-EX"=>"Very Good to Excellent",
                  "VG"=>"Very Good",
                  "G-VG"=>"Good to Very Good",
                  "G"=>"Good",
                  "F-G"=>"Fair to Good",
                  "F"=>"Fair",
                  "P"=>"Poor"
              );
      if(array_key_exists($key,$dataArr))
            return $dataArr[$key];
        else
          return false;
      }


      /*for treatment*/
      if($field=="treatment"){
        $dataArr = array(
                  "LD"=>"Laser Drilled",
                  "IRR"=>"Irradiated",
                  "CE"=> "Clarity Enhanced",
                  "COL"=>"Color Enhanced",
                  "HPHT"=>"High pressure high temperature",
                  "OT"=>"Other",
                  "N"=>"None"
              );
      if(array_key_exists($key,$dataArr))
            return $dataArr[$key];
        else
          return false;
      }

    }
}


if (!function_exists('hide_dna_controls'))
{ 
    function hide_dna_controls($link=""){
      if($link!=""){
        if(is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'mobile'))){
            $link = str_replace("sv=0,1,2,3,4", "sv=0", $link);
            $link = str_replace("z=1", "z=0", $link);
            $link = str_replace("btn=1,2,3,5", "btn=0", $link);
        }
        
        return $link;
      }
      else{
        return $link;
      }
    }
}