<?php

class Mdl_rnews extends CI_Model {

public function load_subcategory($id)
	{
		$query = $this->db->get_where('category',array('category_parent'=>$id));
		return $query->result();
	}
public function home_news($id)
	{
		$this->db->order_by('news_id','DESC');
		$this->db->limit(3);
		$query = $this->db->get_where('news',array('news_category_fkey'=>$id));
		return $query->result();
	}
public function load_news()
	{
		$this->db->order_by('news_id','DESC');
		$this->db->limit(10);
		$query =$this->db->get('news');
		if($query)
		{
			return $query->result();
		}
	}
public function recent_news()
	{
		$this->db->order_by('news_id','DESC');
		$this->db->limit(6);
		$query =$this->db->get('news');
		if($query)
		{
			return $query->result();
		}
	}
public function load_post($id)
	{
		$query = $this->db->get_where('news',array('news_id'=>$id));
		return $query->result();
	}
public function categorized_news($id)
	{
		$this->db->order_by('news_id','DESC');
		$this->db->limit(10);
		$query = $this->db->get_where('news',array('news_category_fkey'=>$id));
		return $query->result();
	}
public function load_comment($id)
	{
		$query = $this->db->get_where('comment',array('comment_news_fkey'=>$id));
		return $query->result();
	}

public function write_comment()
	{
		$comment_news_fkey = $this->input->post('comment_news_fkey');
		$comment_name = $this->input->post('comment_name');
		$comment_email = $this->input->post('comment_email');
		$comment_content = $this->input->post('comment_content');

		$attr = array(
			'comment_news_fkey' => $comment_news_fkey,
			'comment_name' => $comment_name,
			'comment_email' => $comment_email,
			'comment_content' => $comment_content, );

		$this->db->set('comment_time', 'NOW()', FALSE);
		$query = $this->db->insert('comment',$attr);
		if($query)
		{
			return 1;
		}
		else
		{
			return false;
		}
	}
public function recent_comment()
{
	
	$this->db->distinct();
	$this->db->select('comment_news_fkey');
	$this->db->order_by('comment_id','DESC');
	$query = $this->db->get('comment');
	 $data['comment'] = $query->result();
	
	foreach ($data['comment'] as $key => $value) {
		 $where = $value->comment_news_fkey;
		$this->db->where('news_id',$where);
		$query = $this->db->get('news');
		$result[] = $query->result();
	}
	
	return $result;
}
public function increase_visitor($id=null)
{
	$this->db->select('news_visitor');
	$this->db->where('news_id',$id);
	$get_news = $this->db->get('news');
	foreach ($get_news->result_array() as $row)
		{
		    $news_visitor = $row['news_visitor'] + 1;	       
		}
	$attr = array('news_visitor' => $news_visitor,);
	$this->db->where('news_id',$id);
	$query = $this->db->update('news',$attr);
	if($query)
	{
		return true;
	}
}
public function total_visitor()
{
	
	$get_visitor = $this->db->get('visitor');
	$count = $this->db->count_all('visitor');
	if($count==0)
	{
		$time = date("Y-m-d");
		list($year, $month, $date) = explode('-', $time);

		$visitor_total = 1;
		$attr = array(
			'visitor_total' => $visitor_total,
		   	'visitor_month' =>$month,
		 	'visitor_year' => $year,);
		$this->db->set('visitor_date', 'NOW()', FALSE);
		$query = $this->db->insert('visitor',$attr);
		if($query)
		{
		   	return true;
		}
		else
		{
			return false;
		}
	}
	else{
	foreach ($get_visitor->result_array() as $row) {
		$time = date("Y-m-d");
		
		$match_time = $row['visitor_date'];
		  
		if($match_time == $time)
		{
			$matched = 1;
			$where = $row['visitor_date'];
		}
		else
		{
			$matched = 0;
			$where = null;
		}
	}
	
	if($matched==1)
		{
			$visitor_total = $row['visitor_total'] + 1;
		   	$attr = array('visitor_total' => $visitor_total,);	       
		   	$this->db->where('visitor_date',$where);
		   	$query = $this->db->update('visitor',$attr);
		   	if($query)
		   	{
		   		return true;
		   	}
		   	else
		   	{
		   		return false;
		   	}
		}
	else if($matched==0)
		{
			$time = date("Y-m-d");
			list($year, $month, $date) = explode('-', $time);

			
			$attr = array(
				'visitor_total' => 1,
			   	'visitor_month' =>$month,
			 	'visitor_year' => $year,);
		   	$this->db->set('visitor_date', 'NOW()', FALSE);
		   	$query = $this->db->insert('visitor',$attr);
		   	if($query)
		   	{
		   		return true;
		   	}
		   	else
		   	{
		   		return false;
		   	}
		}
	}

		
	}

	public function message()
	{
		$inbox_name = $this->input->post('inbox_name');
		$inbox_email = $this->input->post('inbox_email');
		$inbox_message = $this->input->post('inbox_message');
		$this->db->set('inbox_date','NOW()',FALSE);

		$attr = array(
			'inbox_name' => $inbox_name,
			'inbox_email' => $inbox_email,
			'inbox_message' => $inbox_message,
			);
		$query = $this->db->insert('inbox',$attr);
		if($query)
		{
			return 1;
		}
		else
		{
			return false;
		}
	}
	// ## search
	public function search_result()
	{
		$search_value = $this->input->post('search_value');

		$this->db->select('*');
        $this->db->from('news');
        $this->db->like('news_headline',$search_value);

        // Execute the query.
        $query = $this->db->get();

        // Return the results.
        if($query)
        {
        return $query->result_array();
    	}
    	else
    	{
    		return 0;
    	}
	}
	// ## Archieve
	public function archieve_news($month,$year)
	{
		$this->db->order_by('news_id','DESC');
		$query = $this->db->get_where('news',array('news_month'=>$month,'news_year'=>$year));
		return $query->result();
	}
		
	
}