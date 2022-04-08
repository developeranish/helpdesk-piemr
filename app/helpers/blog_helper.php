<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//get all posts //
if ( ! function_exists('blog_posts')){

	function blog_posts(){
        $CI = get_instance();
		$CI->load->model('blog_model');
		$data_export =array();
		for($i=0;$i<=10;$i++):
			$data =array();
			$posts = $CI->blog_model->get_posts(array('post_type'=>'post','post_status'=>'publish'),1,1,$i); 
			if(!empty($posts) && !empty($posts['data'])){
				foreach($posts['data'] as $key => $post): 
					$data[$key]['title'] = $post->post_title; 
					$data[$key]['post_content'] = trim(substr($post->post_content, 0, 120)); 
					if(isset($post->postmeta) && isset($post->postmeta->_thumbnail_id) && $post->postmeta->_thumbnail_id->guid)
						$data[$key]['thumb'] = parse_url($post->postmeta->_thumbnail_id->guid)['path'];
					else
						$data[$key]['thumb'] = '';
					$data[$key]['post_modified'] = $post->post_modified;
					$data[$key]['comment_count'] = $post->comment_count;
				endforeach;	
			}
			if(!empty($data[0]))
				$data_export[] = $data[0];	
		endfor;	
		return  $data_export;
  	} 

      
} 