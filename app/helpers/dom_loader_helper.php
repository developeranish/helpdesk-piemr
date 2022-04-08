<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Dom Helper
 *
 * A simple helper to serve different html dom
 *
 * @package     Codeigniter Dom Helper
 * @author      Rudratosh shastri
 * @since       Version 1.0
 * @filesource
 */

/* load dahsboard dom plugins **/
if (!function_exists('common'))
{
    function common()
    {
    	$CI = get_instance();
        $CI->load->library('template');
		$CI->template->add_js('assets/pages/cart.js','import',false);
    }
}

/* load dahsboard dom plugins **/
if (!function_exists('front'))
{
    function front()
    {
    	common();
        $CI = get_instance();
        $CI->load->library('template');
        //load custom css	 

		// $CI->template->add_css('assets/css/libs/font-awesome.min.css','link'); 
		// $CI->template->add_css('assets/css/libs/ionicons.min.css','link'); 
		// $CI->template->add_css('assets/css/libs/bootstrap.min.css','link'); 
		// $CI->template->add_css('assets/css/libs/bootstrap-theme.min.css','link'); 
		// $CI->template->add_css('assets/css/libs/jquery.fancybox.css','link'); 
		// $CI->template->add_css('assets/css/libs/jquery-ui.min.css','link'); 
		// $CI->template->add_css('assets/css/libs/owl.carousel.min.css','link'); 
		// $CI->template->add_css('assets/css/libs/owl.transitions.min.css','link'); 
		// $CI->template->add_css('assets/css/libs/jquery.mCustomScrollbar.min.css','link'); 
		// $CI->template->add_css('assets/css/libs/owl.theme.min.css','link'); 
		// $CI->template->add_css('assets/css/libs/animate.min.css','link'); 
		// $CI->template->add_css('assets/css/libs/hover.min.css','link'); 
		// $CI->template->add_css('assets/css/jquery.fancybox.css','link'); 
		// $CI->template->add_css('assets/css/libs/slick.min.css','link'); 
		// $CI->template->add_css('assets/css/libs/semantic.css','link'); 
		// $CI->template->add_css('assets/pages/front/css/front.css','link'); 
		// $CI->template->add_css('assets/pages/front/css/masongram.min.css','link');
		
		
		// // load js files  
		
		// $CI->template->add_js('assets/js/libs/owl.carousel.min.js','import',false); 
		// $CI->template->add_js('assets/js/libs/jquery.fancybox1.min.js','import',false); 
		// $CI->template->add_js('assets/js/libs/jquery.mCustomScrollbar.min.js','import',false); 
		// $CI->template->add_js('assets/js/libs/popup.min.js','import',false); 
		// $CI->template->add_js('assets/js/libs/wow.min.js','import',false); 
		// $CI->template->add_js('assets/js/masonry.pkgd.min.js','import',false); 
		// $CI->template->add_js('assets/js/imagesloaded.pkgd.min.js','import',false); 
		// $CI->template->add_js('assets/js/masongram.min.js','import',false); 
		// //$CI->template->add_js('assets/js/masongram-facebook.min.js','import',false); 
		// $CI->template->add_js('assets/js/timecircles.min.js','import',false); 
		// $CI->template->add_js('assets/js/libs/semantic.js','import',false); 
		//  $CI->template->add_js('assets/js/jquery.pgallery.js','import',false);
		// $CI->template->add_js('assets/pages/front/js/insta.js','import',false); 
		// //$CI->template->add_js('assets/pages/front/js/facebook.js','import',false); 
		// $CI->template->add_js('assets/pages/front/js/home.js','import',false); 
		// $CI->template->add_js('assets/js/libs/slick.min.js','import',false); 
		// $CI->template->add_js('assets/js/theme.js','import',false); 
		// $CI->template->add_js('assets/pages/product_ajax.js','import',false);  
		// $CI->template->add_js('assets/js/cookiealert.js','import',false);  
		// $CI->template->add_js('assets/pages/front/js/front.js','import',false);  
		// $CI->template->add_js('assets/pages/single_product.js','import',false);  
		// $CI->template->add_js('assets/pages/wishlist.js','import',false);
	
		  

	

		
    }
}





