<?php defined('BASEPATH') OR exit('No direct script access allowed');
 

Class Blog_model extends CI_Model{
    
    private $return = array(),  // default empty result
        $db_name = 'wordpress',         // default db connection group, see /config/database.php
        $t_posts = 'liora_posts',    // table posts name
        $t_postmeta = 'liora_postmeta',    // table postmeta name
        $postmeta_serialize = array('_liora_attachment_metadata', 'image_meta'),   // meta_key that need to unserialize
        $attachment_type = 'attachment',    // post_type for attachment
        $attachment_status = 'inherit';     // post_status for attachment

    public function __construct(){
        parent::__construct();
        $this->db_wp = $this->load->database($this->db_name, TRUE);
    }
 
    /*
     * get wp_posts based on post description
     * $post_desc = array of ID, post_parent, post_type, post_status
     * $postmeta_depth = how deep it trace posts related from postmeta
     */
    public function get_posts ($post_desc = array(), $postmeta_depth = 0, $limit = null, $offset = null){
        // assign return variable into default empty result
        $return  = $this->return;

        // check $post_desc, proceeds if not empty
        if (!empty($post_desc)){
            
            // identify if $post_desc array single or not
            $is_single = empty($post_desc[0]) ? TRUE : FALSE;

            // process single array search
            if ($is_single){
                
                // assuming it has proper array key names
                $where = $post_desc;

            }else{
                // initialize empty array, constructing where string
                $where = array();
                foreach ($post_desc as $desc){
                    $where[] = '('.$this->key_value_builder($desc, ' = ', ' AND ', "", "'").')';
                }

                // concat And state, 
                $where = implode(' OR ', $where);
            }
        }

        // start CI db cache
        $this->db_wp->start_cache();

        if (!empty($where)) $this->db_wp->where($where);

        $this->db_wp->order_by('ID', 'desc');



        // limitting result
        if (isset($limit) && isset($offset)){
            $total_data = $this->db_wp->count_all_results($this->t_posts);
            $total_page = ceil($total_data/$limit);
            $this->db_wp->limit($limit, $offset);
        }

        // stop CI db cache
        $this->db_wp->stop_cache();

        // get query result
        if (isset($limit) && isset($offset)){
            $return = $this->db_wp->get()->result();
        }else{
            $return = $this->db_wp->get($this->t_posts)->result();
        }

        // flush CI db cache
        $this->db_wp->flush_cache();

        if ($return){
            $postmeta_search = array();
            foreach ($return as $ret){
                $postmeta_search[] = array('post_id'=>$ret->ID);
            }

            $postmetas = $this->get_postmeta($postmeta_search, $postmeta_depth);

            // some complicated thing happens, the point is set its meta_key and meta_value as postmeta
            if ($postmetas){
                $i = 0;
                foreach ($return as &$ret){
                    $ret->postmeta = new stdClass();
                    for ($i; $i<count($postmetas); $i++){
                        if ($postmetas[$i]->post_id == $ret->ID){
                            $meta_key = $postmetas[$i]->meta_key;
                            $ret->postmeta->$meta_key = $postmetas[$i]->meta_value;
                        }else{
                            continue 2;
                        }
                    }
                }
            }
        }
        
        if (isset($limit) && isset($offset)){
            $data = $return;
            $return = array();
            $return['data'] = $data;
            $return['total_data'] = $total_data;
            $return['total_page'] = $total_page;
        }
        return $return;
    }


    /*
     * get wp_postmeta based on postmeta description
     * $postmeta_desc = array of meta_id, post_id, meta_key, meta_value
     * $postmeta_depth = how deep it trace posts related from postmeta
     */
    public function get_postmeta ($postmeta_desc = array(), $postmeta_depth = 0){
        // assign return variable into default empty result
        $return  = $this->return;

        // check $postmeta_desc, proceeds if not empty
        if (!empty($postmeta_desc)){
            // identify if $postmeta_desc array single or not
            $is_single = empty($postmeta_desc[0]) ? TRUE : FALSE;

            // start CI db cache
            $this->db_wp->start_cache();

            // process single array search
            if ($is_single){

                // assuming it has proper array key names
                $this->db_wp->where($postmeta_desc);
            }else{
                // initialize empty array, constructing where string
                $where = array();
                foreach ($postmeta_desc as $desc){
                    $where[] = '('.$this->key_value_builder($desc, ' = ', ' AND ', "", "'").')';
                }

                // concat And state
                $this->db_wp->where(implode('OR', $where));
            }

            $this->db_wp->order_by('post_id', 'desc');

            // stop CI db cache
            $this->db_wp->stop_cache();

            // get query result
            $return = $this->db_wp->get($this->t_postmeta)->result();
            
            // flush CI db cache
            $this->db_wp->flush_cache();

            // get post related 
            if ($return){
                
                $post_definition = array();
                foreach ($return as &$ret){
                    if (is_numeric($ret->meta_value)){
                        $post_definition[] = array(
                            'ID' => $ret->meta_value,
                            'post_parent' => $ret->post_id,
                            'post_type' => $this->attachment_type,
                            'post_status' => $this->attachment_status);
                    }
                    //}else
                    if(in_array($ret->meta_key, $this->postmeta_serialize)){
                        $ret->meta_value = unserialize($ret->meta_value);
                    }
                }
                if ($postmeta_depth > 0){
                    $postmeta_depth--;
                    $attachment = $this->get_posts($post_definition, $postmeta_depth);

                    if ($attachment){
                        $num_attachment = count($attachment);
                        $i = 0;
                        foreach ($return as &$ret){
                            if (is_numeric($ret->meta_value)){
                                for ($i=0; $i<$num_attachment; $i++){
                                    if ($ret->post_id == $attachment[$i]->post_parent && $ret->meta_value == $attachment[$i]->ID)
                                        $ret->meta_value = $attachment[$i];
                                }
                            }
                        }
                    }
                }
            }
        }

        return $return;
    }

    /*
     * convert array key-value into string
     */
    private function key_value_builder ($where, $key_value_delimiter = " = ", $item_delimiter = ",", $key_cover = "", $value_cover = ""){
        // assign return variable into default empty result
        $return = '';

        // check $where, proceeds if not empty
        if (!empty($where)){
            // temporary array, collecting key-value string
            $temp = array();
            foreach($where as $key=>$value){
                $temp[] = $key_cover.$key.$key_cover.$key_value_delimiter.$value_cover.$value.$value_cover;
            }

            $return = implode($item_delimiter, $temp);
        }

        return $return;
    }
}