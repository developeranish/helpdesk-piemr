<?php
defined('BASEPATH') OR exit('No direct script access allowed');


if (!function_exists('price_slider'))
{
    function price_slider($filter)
    { 
     
      return $html = '<li class="main-filter-start resp1">
          <div class="dropdown1">
            <button class="btn btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown">Price</button>
            <ul class="dropdown-menu">
             

             <div class="d_box2 irs_show col-sm-12 col-md-12 col-lg-12 col-xs-12 no-padding1 jwel_price pull-right text-right">
                  
                  <input type="text" data-min_price="0" data-max_price = "'.$filter->price_max_filter.'" class="js-range-slider_price pric_mins" name="my_range4" value="" />  
                  
                  <input type="hidden"  class="" id="price_filter" value="'.$filter->price_min_filter.','.$filter->price_max_filter.'" />
                     
                  <div class="col-sm-6 col-md-6 col-lg-6 col-xs-6 input-style">
                     <input type="text"  value="'.$filter->price_min_filter.'" class=" pull-left text-design min_price cr_pr pric_mins" id="min_price_pr_sldr">
                     <span class="pric_sett_jwel ">$ </span>
                  </div>
                  <div class="col-sm-6 col-md-6 col-lg-6 col-xs-6 input-style pric_rel">
                     <input type="text"  value="'.$filter->price_max_filter.'"  class="pull-right text-design max_price cr_pr pric_mins text-right" id="max_price_pr_sldr">
                      <span class="pric_sett1_jwel2 ">$ </span>
                  </div>
               </div>

            </ul>
          </div>
        </li>';
    }
}


if (!function_exists('style_filter'))
{
    function style_filter($filter, $category_id,$filter_data="")
    { 
      $html = '';
      $i=1;
      foreach($filter as $f){
        //print_r(strtolower(str_replace(' ','_',$f->value))); echo "--"; print_r(strtolower(str_replace(' ','_',$filter_data)));
        if(strtolower(str_replace(' ','_',$f->value))==strtolower(str_replace(' ','_',$filter_data))){
          $check="checked";
        }else{
          $check="";
        }
        $html .= '<li><input type="checkbox" data-cat="'.$category_id.'" data-identity="'.$f->value.'" data-finding_id="39" data-finding_col="ring_style"
          value="'.$f->value.'" data-check="value_'.$f->value.'" class="check ring_style common_selector '.str_replace(' ','_',$f->value).'" '.$check.'>'.$f->value.'</li>';
          $i=0;
      }
      return $html;
    }
}



// range slider filter
if (!function_exists('range_slider'))
{
    function range_slider($data, $filter_counter=0)
    { 
     
      return $html = '<li class="main-filter-start resp'.$filter_counter.'">
          <div class="dropdown1">
            <button class="btn btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown">'.ucwords($data["type"]).'
           </button>
            <ul class="dropdown-menu">
             

             <div class="d_box2 irs_show col-sm-12 col-md-12 col-lg-12 col-xs-12 no-padding1 jwel_price pull-right text-right">
                  
                  <input type="text" data-min_price="0" data-max_price = "'.$data["options"][1]["label"].'" class="js-range-slider_price pric_mins" name="my_range4" value="" />  
                  
                  <input type="hidden"  class="" id="price_filter" value="'.$data["options"][0]["label"].','.$data["options"][1]["label"].'" />
                     
                  <div class="col-sm-6 col-md-6 col-lg-6 col-xs-6 input-style">
                     <input type="text"  value="'.$data["options"][0]["label"].'" class=" pull-left text-design min_price cr_pr pric_mins" id="min_price_pr_sldr">
                     <span class="pric_sett_jwel ">$ </span>
                  </div>
                  <div class="col-sm-6 col-md-6 col-lg-6 col-xs-6 input-style pric_rel">
                     <input type="text"  value="'.$data["options"][1]["label"].'"  class="pull-right text-design max_price cr_pr pric_mins text-right" id="max_price_pr_sldr">
                      <span class="pric_sett1_jwel2 ">$ </span>
                  </div>
               </div>

            </ul>
          </div>
        </li>';

        /*return $html = '<li class="main-filter-start resp'.$filter_counter.'">
          <div class="dropdown1">
            <button class="btn btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown">'.ucwords($data["type"]).'
           </button>
            <ul class="dropdown-menu">
             <div class="range-filter" data-min="'.$data["options"][0]["label"].'" data-max="'.$data["options"][1]["label"].'">
              <div class="slider-range" >
                <span class="min-'.$data["type"].'"></span>
                <span class="max-'.$data["type"].'"></span>
              </div>
              <div class="ranges">
              <input type="text" class="min_'.$data["type"].' range_slides" value="'.$data["options"][0]["label"].'">
              <input type="text" class="max_'.$data["type"].' range_slides" value="'.$data["options"][1]["label"].'">  
              </div>  
            </div> 

            </ul>
          </div>
        </li>';*/
    }
}

// range slider filter mobile
if (!function_exists('range_slider_mobile'))
{
    function range_slider_mobile($filter)
    { 
      return $html ='<div class="panel panel-default">
                              <div class="panel-hd2" role="tab" id="filterOne">
                                 <h4 class="panel-title font-bold title18">
                                    <a role="button" data-toggle="collapse" data-parent="#filteraccordion" href="#fiteraOne" aria-expanded="false" aria-controls="fiteraOne" class="blck monu foottxt icon-change collapsed">
                                      '.ucwords('price filter').' </i>
                                    </a>
                                 </h4>
                              </div>
                              <div id="fiteraOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="filterOne" aria-expanded="false" style="height: 0px;">
                                 <div class="panel-body">
                                    <div class="card-body">
                                           <div class="d_box2 irs_show col-sm-12 col-md-12 col-lg-12 col-xs-12 no-padding1 jwel_price">
                                            
                                           <input type="text" data-min_price="0" data-max_price = "'.$filter->price_max_filter.'" class="js-range-slider_price pric_mins" name="my_range4" value="" />  
                  
                                           <input type="hidden"  class="" id="price_filter" value="'.$filter->price_min_filter.','.$filter->price_max_filter.'" />
                                              
                                           <div class="col-sm-6 col-md-6 col-lg-6 col-xs-6 input-style">
                                              <input type="text"  value="'.$filter->price_min_filter.'" class=" pull-left text-design min_price cr_pr pric_mins" id="min_price_pr_sldr">
                                              <span class="pric_sett_jwel ">$ </span>
                                           </div>
                                           <div class="col-sm-6 col-md-6 col-lg-6 col-xs-6 input-style pric_rel">
                                              <input type="text"  value="'.$filter->price_max_filter.'"  class="pull-right text-design max_price cr_pr pric_mins text-right" id="max_price_pr_sldr">
                                               <span class="pric_sett1_jwel2 ">$ </span>
                                           </div>
                                      </div>
                                    </div>
                                 </div>
                              </div>
                           </div>'; 
    }
}

// select box filter
if (!function_exists('select_box'))
{
    function select_box($data, $filter_counter=0)
    { 
    if(!empty($data['options'])){ 

        $html = '<li class="main-filter-start resp'.$filter_counter.'">
                <div class="dropdown1">
                  <button class="btn btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown">'.ucwords($data["type"]).'
                 </button>'; 

          
          $html .=  '<ul class="dropdown-menu multicheck_filter '.($data["type"]).'" data-finding="'.$data["finding"].'" data-finding_tbl_id="'.$data["finding_tbl_id"].'" data-finding_me ="'.$data["finding_me"].'"  data-filter = "'.strtolower($data["tag"]).'">';
          foreach($data['options'] as $opt){ 

           
              $html .=  '<li><input type="checkbox" data-identity="'.$opt["label"].'" data-finding_id="'.$opt["finding_id"].'" data-finding_col="'.$opt["finding_col"].'"    value="'.$opt["finding_val"].'" data-check="'.$opt["finding_col"].'_'.str_replace(' ', '_', $opt["label"]).'" class="check '.$data["tag"].' common_selector '.str_replace(' ', '_', $opt["label"]).'" />'.ucwords($opt["label"]);
            

              //with count code
              // $html .=  '<li><input type="checkbox" data-identity="'.$opt["label"].'" data-finding_id="'.$opt["finding_id"].'" data-finding_col="'.$opt["finding_col"].'"    value="'.$opt["finding_val"].'" data-check="'.$opt["finding_col"].'_'.str_replace(' ', '_', $opt["label"]).'" class="check '.$data["tag"].' common_selector '.str_replace(' ', '_', $opt["label"]).'" />'.ucwords($opt["label"]).' <span class="no1">('.$opt["finding_count"].')</span>';
           
            
            
            
            //check if image available 
            if($opt["image"]!='')
              $html .= '<img src="'.$opt["image"].'" alt="" class="img-right fit-size2" />';
            elseif($opt["icon"]!='')
              $html .= '<i class="'.$opt["icon"].' img-right style_icn"></i>';
            elseif($opt["color"]!='')
              $html .= '<div style="background-color:'.$opt["color"].'"></div>';
            else
                echo '';

            $html .= '</li>';   
          }  
      $html .= '</ul>';
      
      $html .= '</div></li>';
      return $html;
      }else{
        return [];
      } 
    }
}


// select box filter mobile
if (!function_exists('select_box_mobile'))
{
    function select_box_mobile($data,$i=0)
    {   
      if(!empty($data['options'])){ 
              $html = '<div class="panel panel-default">
                              <div class="panel-hd2" role="tab" id="filter_'.$i.'">
                                 <h4 class="panel-title panel-title font-bold title18">
                                    <a class="blck foottxt icon-change collapsed" role="button" data-toggle="collapse" data-parent="#filteraccordion" href="#filtera_'.$i.'" aria-expanded="false" aria-controls="filtera_'.$i.'">
                                   '.ucwords($data["type"]).'
                                    </a>
                                 </h4>
                              </div> 
                              
                              <div id="filtera_'.$i.'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="filter_'.$i.'" aria-expanded="false" style="height: 0px;">
                                 <div class="panel-body">
                                    <div class="card-body">
                                      <ul class="checkbox-container multicheck_filter" data-finding="'.$data["finding"].'" data-finding_tbl_id="'.$data["finding_tbl_id"].'" data-finding_me ="'.$data["finding_me"].'"  data-filter = "'.strtolower($data["tag"]).'">';
                                          foreach($data['options'] as $opt){ 
            $html .=   '<li>
                                  <div class="custom-control custom-checkbox">
                                     <input type="checkbox" data-identity="'.$opt["label"].'" data-finding_id="'.$opt["finding_id"].'" data-finding_col="'.$opt["finding_col"].'"  data-check="'.$opt["finding_col"].'_'.str_replace(' ', '_', $opt["label"]).'"  value="'.$opt["finding_val"].'"  class="custom-control-input check '.$data["tag"].' common_selector '.str_replace(' ', '_', $opt["label"]).'" >
                                     <label class="custom-control-label" for="customCheck21">'.ucwords($opt["label"]).'</label> <span class="no1">('.$opt["finding_count"].')</span>';
                                     //check if image available 
                                  if($opt["image"]!='')
                                    $html .= '<img src="'.$opt["image"].'" alt="" class="img-right fit-size2" />';
                                  elseif($opt["icon"]!='')
                                    $html .= '<i class="'.$opt["icon"].' img-right style_icn"></i>';
                                  elseif($opt["color"]!='')
                                    $html .= '<div style="background-color:'.$opt["color"].'"></div>';
                                  else
                                      echo '';
                                    $html .= '</div></li> '; 
                                                }  
                      $html .=        '</ul>
                                    </div>
                                 </div>
                              </div>
                           </div>';
            return $html;
        }else{
          return [];
        }
                           
    }
}

// gettting list of gems
if (!function_exists('get_group_gem'))
{
    function get_group_gem($group_id=NULL)
    { 
      if($group_id==NULL)
         return false;
      $CI =& get_instance();
        $gems = $CI->db->select('product_id,gem_id,gem_name,product_slug,product_sale_price,product_price,product_discount')->where("group_id",$group_id)->group_by('gem_id')->get('view_product')->result();
        $html = false;
        if(!empty($gems) && count($gems)>1){
          $html .= '<div class="gemstone-info">
                   <ul class="gemslider">';
          foreach ($gems as $key => $gem) { 
            $selected = $key==0 ? 'selected' : ''; 
            //'.(ratings($gem->product_id)*20).'
            $html .= '<li title="'.ucwords($gem->gem_name).'" class="gems change_gemstone '.$selected.' " data-src="'.thumb(media($gem->product_id,'product'),200,200).'" data-src2="'.thumb(media($gem->product_id,'product',1,1),200,200).'" data-href="'.site_url("build-your-own-ring/".$gem->product_slug).'" data-id="'.$gem->product_slug.'" data-pid="'.$gem->product_id.'" data-price="'.number_format(round($gem->product_price)).'" data-sale_price="'.number_format(round($gem->product_sale_price)).'" data-review='.(ratings($gem->product_id)*20).' data-discount="'.number_format(round($gem->product_discount)).'" ><a href="javascript:void(0);"<span><img src="'.MEDIA.(media($gem->gem_id,'gemstone')) .'" alt="" class="resize" /></span></a></li>'; 
          }
          $html .="</ul></div>";
      }
     return $html;
    }
}

// gettting list of metals
if (!function_exists('get_group_metal'))
{
    function get_group_metal($group_id=NULL)
    { 
      if($group_id==NULL)
         return false;
      $CI =& get_instance();
        // $metals = $CI->db->select('product_id,product_name,product_sku, metal_type,product_slug,product_sale_price,product_price,product_discount')->where("group_id",$group_id)->group_by('metal_type')->order_by('count(metal_type) desc , FIELD(metal_type, "14K-White-Gold", "14K-Yellow-Gold", "14K-Rose-Gold", "Platinum" )')->get('ring_builder')->result();
      $metals = $CI->db->query('SELECT `product_id`, `name` as `product_name`, `sku` as `product_sku`, `metal_color` as `metal_type`, `slug` as `product_slug`, `sale_price` as `product_sale_price`, `price` as `product_price`, `discount` as `product_discount` FROM `products` WHERE `group_id` = "'.$group_id.'" AND `metal_color` IN("14K-White-Gold", "14K-Yellow-Gold", "14K-Rose-Gold", "Platinum") GROUP BY metal_color order by FIELD(metal_color, "14K-White-Gold", "14K-Yellow-Gold", "14K-Rose-Gold", "Platinum" )')->result();
      echo vd();
        $html = false;
        //'.(ratings($metal->product_id)*20).'
        // echo vd();
        // pr($metals);
        if(!empty($metals)){
          $html .= '<div class="metal-info-box"><ul>';
          $count = 0;
          foreach ($metals as $metal) {
            // if (strpos($metal->metal_type, '14K') !== false) {
                
              //check if overnight product
              // if(strpos($group_id, 'MOUNT') === false){

                  $metal_css = 'a'.$metal->metal_type;

                  $html .= '<li title="'.ucwords(str_replace('-',' ', $metal->metal_type)).'" class="metal-color '.$metal_css.' '.$metal->metal_type.' '.strtolower($metal->metal_type).' change_metal" data-src="'.thumb_aws(media($metal->product_id,'product'),250,250).'" data-src2="'.thumb_aws(media($metal->product_id,'product',1,1),200,200).'" data-href="'.site_url().'/build-your-own-ring/'.$metal->product_slug.'" data-id="'.$metal->product_slug.'" data-pid="'.$metal->product_id.'" data-price="'.number_format(round($metal->product_price)).'" data-sale_price="'.number_format(round($metal->product_sale_price)).'" data-review='.(ratings($metal->product_id)*20).' data-discount="'.number_format(round($metal->product_discount)).'"><a href="javascript:void(0);"></a></li>'; 
              // }else{
              //   $html .= '<li title="'.ucwords(str_replace('-',' ', $metal->metal_type)).'" class="metal-color '.$metal_css.' '.$metal->metal_type.' change_metal" data-src="'.thumb_aws(media('','','','',array('metal'=>$metal->metal_type,'fake_sku'=>$metal->fake_sku,'sort_order'=>0)),250,250).'" data-src2="'.thumb_aws(media('','','','',array('metal'=>$metal->metal_type,'fake_sku'=>$metal->fake_sku,'sort_order'=>1)),250,250).'" data-href="'.site_url().'/shop/'.$metal->product_slug.'" data-id="'.$metal->product_slug.'" data-pid="'.$metal->product_id.'" data-price="'.number_format(round($metal->product_price)).'" data-sale_price="'.number_format(round($metal->product_sale_price)).'" data-review='.(ratings($metal->product_id)*20).' data-discount="'.number_format(round($metal->product_discount)).'"><a href="javascript:void(0);"></a></li>'; 
              // }  

            // }  

            if($count==3){
              break;
            }
            $count++;
          }
          $html .="</ul></div>";
      } 
     return $html;    
    }
}

?>