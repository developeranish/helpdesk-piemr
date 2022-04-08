<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
$route['default_controller'] = 'front';
$route['404_override'] = 'custom_404/index';
$route['translate_uri_dashes'] = FALSE; 
//$route['login'] = 'Login'; 

/** Static pages routs**/
$route['about'] = 'front/about';
$route['stuller'] = 'front/stuller';
$route['rapnet'] = 'front/rapnet';
$route['contact'] = 'front/contact';
$route['newsletter_signup'] = 'front/newsletter_signup';
$route['cookie-policy'] = 'front/cookie_policy';
$route['privacy-policy'] = 'front/privacy_policy';
$route['terms-and-conditions'] = 'front/terms_and_conditions';
$route['contact_store'] = 'front/contact_store';

$route['engagement'] = 'front/engagement';
$route['diamonds'] = 'front/diamonds';


/** Jewelry Routes **/
$route['jewelry/(:any)'] = 'jewelry/index';
$route['ajax_search_new/(:any)'] = 'jewelry/ajax_search_new';
$route['ajax_search/(:any)'] = 'jewelry/ajax_search'; 
$route['quick_view'] = 'jewelry/quick_view'; 

// /** Ring Builder Routes **/
$route['build-your-own-ring'] = 'ring_builder/index';
$route['ring_builder/(:num)'] = 'ring_builder/index/$i';
$route['ring_builder/style/(:any)'] = 'ring_builder/filter_style';
$route['ring_search/(:any)'] = 'ring_builder/ajax_search'; 
$route['ring_view'] = 'ring_builder/quick_view';

//for settings in ring builder
$route['build-your-own-ring/choose_review/(.+)'] = 'ring_builder/setting/choose_review/$1';  
$route['build-your-own-ring/choose_setting/(:num)/(:any)'] = 'ring_builder/setting/choose_setting';  
$route['build-your-own-ring/change_after_review/(:num)/(:num)/(:any)'] = 'ring_builder/setting/change_after_review';  
$route['build-your-own-ring/choose_diamond/(:any)'] = 'ring_builder/setting/choose_diamond';  
$route['build-your-own-ring/choose_setting/remove'] = 'ring_builder/setting/choose_setting';  
$route['build-your-own-ring/choose_diamond/remove'] = 'ring_builder/setting/choose_diamond';  
$route['build-your-own-ring/review'] = 'ring_builder/setting/complete_setting'; 
$route['build-your-own-ring/(:any)'] = 'ring_builder/setting/index';



/*Watchew Routs*/
$route['watches/(:any)'] = 'watches/index';
$route['watching/(:any)'] = 'watching/index';

/** shopping routes **/
$route['shop/(:any)'] = 'shopping'; 
$route['cart'] = 'shopping/add_cart';
$route['cart_remove'] = 'shopping/remove'; 
$route['add_wish'] = 'shopping/add_wish'; 
$route['post_review'] = 'shopping/post_review'; 
$route['wishlist'] = 'shopping/wishlist'; 
$route['checkout'] = 'shopping/checkout'; 
$route['placeorder'] = 'shopping/buy';
$route['summary/(:num)'] = 'shopping/order_summary';
$route['write_review/(:any)'] = 'shopping/write_review'; 


#diamond routs
$route['diamond/(:any)'] = 'diamond/index';
$route['drop_hint_submit'] = 'diamond/drop_hint_submit';
$route['diamond-details/(:any)'] = 'diamond/details'; 
$route['diamond-education'] = 'diamond/education';
$route['education'] = 'front/diamond_landing';
$route['diamond_book_appointment'] = 'diamond/book_appointment';
$route['get_compare_list'] = 'diamond/get_compare_list';



/** Login & Auth **/
$route['google_login'] = 'auth/google_login';
$route['facebook_login'] = 'auth/facebook_login';
$route['login'] = 'auth';
$route['registration'] = 'auth/registration';
$route['logout'] = 'auth/logout';
$route['myaccount'] = 'front/my_account';
$route['forget_password'] = 'front/forget_password';
$route['reset_password'] = 'front/reset_password';
$route['unsubscribe/(:any)'] = 'front/unsubscribe';
$route['verify'] = 'auth/verify';
$route['edit-profile-submit'] = 'auth/edit_profile_submit';
$route['update-billing-address'] = 'auth/update_billing_address';
//http://172.16.1.134/mirror/unsubscribe/VxhnqbXEYx9YRCk4


#Blogs routs
#$route['blog/(:any)'] = 'blog/single_post';



/* FEED related routs defined below */

//1. Bassali jewelry prodcut feed
$route['bassali-feed'] = 'test/bassali_feed';

//2. Overnight Products feed feed
$route['overnight-feed'] = 'test/overnight_feed';

//3. Belgium diamonds feed
$route['test'] = 'test/belgium_feed';
//named 'test' because all existing cron running with 'test'
//we have to rename to with $route['belgium-feed'] = 'test/belgium_feed' in future

//4. Rapaport diamonds  feed
$route['rapaport-feed'] = 'test/rapaport_feed';

//4.1 Rapaport Dumper feed
$route['rapaport-dump'] = 'test/rapaport_dump';

//5. Swiss watches feed
$route['swiss-watches-feed'] = 'test/swiss_watches_feed';
