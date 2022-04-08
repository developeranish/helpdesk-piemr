<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/*Navigation Categories */

if ( ! function_exists('nav_category')){

		function nav_category(){
	       $CI =& get_instance();
	       return $CI->db->select('slug, name')->where(array('status'=>1,'show_menu'=>1))->order_by('dd_sort_order','ASC' )->get('category')->result();
      } 
	} 



/*home slider */

if ( ! function_exists('home_slider')){

		function home_slider(){
	       $CI =& get_instance();
	       $CI->db->where('status',1);
	       $CI->db->order_by("display_order", "ASC");
	       return $CI->db->get('sliders')->result();
      } 
	}



	 /* Best selling products **/ 
if ( ! function_exists('best_selling_product')){

		function best_selling_product(){
	        $CI =& get_instance();
	  //       $CI->db->select('p.*, r.*');
			// $CI->db->from('products p');
			// $CI->db->join('media r','r.element_id = p.product_id');
			// $CI->db->join('category c','c.category_id = p.category_id');
			// $CI->db->order_by("r.sort_order",'DESC');
			// $CI->db->order_by("p.product_id",'DESC');
			// $CI->db->group_by("p.product_id");
			// $CI->db->where('p.status','active');
			// $CI->db->where('c.name "RLIKE "[[:<:]]rings[[:>:]]"" ');
			// $CI->db->where('r.element_type','product');
			// $CI->db->limit(8);
			// return $CI->db->get()->result();  
			return $CI->db->query("SELECT
			    `p`.*,
			    `r`.*,
			    `c`.`name` as cat_name
			FROM
			    `products` `p`
			JOIN
			    `media` `r`
			ON
			    `r`.`element_id` = `p`.`product_id`
			JOIN
			    `category` `c`
			ON
			    `c`.`category_id` = `p`.`category_id`
			WHERE
			    `p`.`status` = 'active' AND `c`.`name` RLIKE '[[:<:]]rings[[:>:]]'  AND `r`.`element_type` = 'product'
			GROUP BY
			    `p`.`product_id`
			ORDER BY
			    rand()
			DESC
			    ,
			    `p`.`product_id`
			DESC
			LIMIT 6")->result();
      }
	} 


/*home Blogs */

if ( ! function_exists('home_blogs')){

		function home_blogs(){
	       $CI =& get_instance();
	       return $CI->db->where('status',1)->get('blog')->result();
      } 
	}


/*home Testimonial */

if ( ! function_exists('home_testimonial')){

		function home_testimonial(){
	       $CI =& get_instance();
	       return $CI->db->where('status',1)->get('testimonial')->result();
      } 
	}
	
?>