<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Front_model extends CI_Model {

	public function __construct(){
	    parent::__construct(); 
	}
	     
	 /* list of categories **/
	 public function categories(){
	 	return $this->db->where(array('status'=>1,'show_menu'=>1))->get('category')->result();
	 }

	 public function get_user_data($id){
	 	$res = $this->db->where(array("id"=>$id,'active'=>1))->get('users')->row_array();
	 	return $res;
	 }

	 public function newsletter_signup($newsletter_email){
	 	$cond = array('email'=>$newsletter_email);
	 	$count = $this->db->where($cond)->from("subscribe")->count_all_results();
	 	
	 	if($count==0){
	 		$unsubscribe_token = getTransactionId(16);
	 		$data = array(
		        'email'=>$newsletter_email,
		        'unsubscribe_token'=>$unsubscribe_token,
		        'date_added'=>date('Y-m-d H:i:s')
			);
    		if($this->db->insert('subscribe',$data))
    			return $unsubscribe_token;
    		else
    			return FALSE;
	 	}
	 	else{
	 		//if($count==1){
	 			$row = $this->db->get_where('subscribe', array("email"=>$newsletter_email))->row();
	 			if($row->status==0){
			 		$data = array(
				        'status'=>1,
				        'date_updated'=>date('Y-m-d H:i:s')
					);
					$this->db->where(array("email"=>$newsletter_email));
		    		if($this->db->update('subscribe',$data))
		    		{
		    			return $row->unsubscribe_token;
		    		}
		    		else
		    			return FALSE;
		    	}
		 		else
	 				return FALSE;
	 	}
	 }

	public function orders($user_id){
		$sql = "SELECT * FROM `orders` WHERE user_id=".$user_id;
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function delete_user_address($address_id, $user_id){
		$sql = "DELETE FROM `address` WHERE address_id=".$address_id.' AND user_id='.$user_id;
		$this->db->query($sql);
		
		return "sucessfully deleted";
	}

	public function user_address($user_id){
		$sql = "select billing_address, shipping_address from users where id =".$user_id;
		$res = $this->db->query($sql)->row();

		$sql = "select * from address where (address_id in (0".($res->billing_address!=0?",".$res->billing_address:"").($res->shipping_address!=0?$res->shipping_address:"").") OR user_id=".$user_id.") and active=1";
		return $this->db->query($sql)->result();

		/*$res = $this->db->where(array('user_id'=>$user_id, 'active'=>1))->get('address')->result();
		return $res;*/
	}

	public function check_old_pass($user_id, $old_pass){
		$rows = $this->db->where(array('id'=>$user_id, 'password'=>md5($old_pass)))->get('users')->num_rows();
		if($rows>0)
			return true;
		else
			return false;
	}
	public function forget_password_link($email, $code)
	{
		$rows = $this->db->where(array('email'=>$email, "active"=>1))->get('users')->num_rows();
		if($rows>0){
			//$email = encrypt($email);
			$data=array(
				'forgotten_password_code'=>$code
			);

			if($this->common->update('users', $data, 'email', $email)){
				return true;
			}
			else{
				return false;
			}
		}
		else
			return false;
	}
	public function forget_password_link_check($email='', $code=''){
		$rows = $this->db->where(array('email'=>$email, 'forgotten_password_code'=>$code))->get('users')->num_rows();
		if($rows>0)
			return true;
		else
			return false;
	}

	public function forget_password_update($email, $password){
		$data = array('password'=>md5($password));
		if($this->common->update('users', $data, 'email', $email)){
			$this->common->update('users', array('forgotten_password_code'=>'',  "forgotten_password_time"=>strtotime("now")), 'email',$email);
			return true;
		}
		else{
			return false;
		}
	}
	public function store_chatbot_msg($name, $email, $comment){
		$data = array(
				'name'=>$name,
				'email'=>$email,
				'comment'=>$comment,
				'date_added'=>date('Y-m-d H:i:s')
		);
		if($this->db->insert('contact_us', $data)){
			return true;
		}
		else{
			return false;
		}
	}

	public function unsubscribe($token){
		$count = $this->db->where('unsubscribe_token',$token)->from("subscribe")->count_all_results();
	 	if($count==1){
	 		$data = array(
		        'status'=>0,
		        'date_unsubscribed'=>date('Y-m-d H:i:s')
			);
    		return $this->common->update('subscribe',$data, 'unsubscribe_token', $token);
	 	}
	 	else{
	 		return 0;
	 	}
	}

	public function get_slide_pro($category='',$page=0,$limit=0){
		
		

		return $this->db->query("SELECT
			    `p`.product_id,
			    `p`.slug,
				`p`.name,
				`p`.price,
				`p`.sale_price,
				`p`.category_id,
			    `r`.media_id,
			    `r`.url,
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
			    `p`.`status` = 'active' AND `c`.`slug` = '".$category."'  AND `r`.`element_type` = 'product'
			GROUP BY
			    `p`.`group_id`
			ORDER BY 
			    
			    `p`.`product_id`
			DESC
			LIMIT  $page , $limit ")->result();
		
	}


	public function social_feeds(){
		$q = $this->db->query('SELECT * FROM social_feeds LIMIT 1');
        if($q->num_rows() > 0)
        {
            return $q->result();
        }
        return array();
	}

	public function fetch_faq(){
		$q = $this->db->query('SELECT * FROM constants WHERE type="faq"');
        if($q->num_rows() > 0)
        {
            return $q->result();
        }
        return array();
	}

	
}