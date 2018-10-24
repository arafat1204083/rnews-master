<?php

class Mdl_admin extends CI_Model {


	public function validate($username, $enc_password)
	{
		
		$query = $this->db->get_where('admin',array('admin_username'=>$username,'admin_password'=>$enc_password));
		if($query->num_rows()>0)
		{
		
           foreach ($query->result_array() as $a => $b) {
                $this->session->set_userdata(array(
                        'admin_id' => $b['admin_id'],
                        'admin_username' => $b['admin_username'],
                        'admin_name' => $b['admin_name'],
                        'admin_logged_in' => true
                    )
                   );
            }

            return $query;
		}
		
	}
	public function load_profile()
	{
		$id = $this->session->userdata('admin_id');
		$query = $this->db->get_where('admin',array('admin_id'=>$id,));
		if($query)
		{
			return $query->result();
		}

	}
	public function all_profile()
	{
		$query =$this->db->get('admin');
		if($query)
		{
			return $query->result();
		}

	}
	public function delete_admin($id)
	{
		$query=$this->db->get_where('admin',array('admin_id' =>$id,));
		if($query)
		{
			$result=$query->result();
			foreach ($result as $value) 
			{
				if(file_exists($value->admin_photo))
					{
						unlink($value->admin_photo);

					}
			}
			
		}
		$this->db->where('admin_id', $id);
		$delete = $this->db->delete('admin');
		if ($this->db->affected_rows() > 0)
	   	{
	   		 return 1;
	   	}
	}
	public function load_settings()
	{
		$query =$this->db->get('settings');
		if($query)
		{
			return $query->result();
		}

	}
	public function load_inbox($per_page,$offset)
	{
		$page = ($offset-1)*$per_page;
		$this->db->order_by('inbox_id','DESC');
		$this->db->limit($per_page,$page);
		$query =$this->db->get('inbox');
		if($query)
		{
			return $query->result();
		}

	}
	public function message_seen($id)
	{
		$attr = array('inbox_seen' => 1, );
		$this->db->where('inbox_id',$id);
		$this->db->update('inbox',$attr);
	}
	function delete_checked($message_ids) 
	{
		$message_ids = (array) $message_ids ;
		foreach ($message_ids as $key => $value) {
		 $this->db
	        ->where('inbox_id', $value)
	        ->delete('inbox');
		}
	   		
	  if ($this->db->affected_rows() > 0)
	   	{
	   		 return 1;
	   	}
		else
		{
			return 'x';
		}
	    
	}
	public function all_delete()
	{
		$query = $this->db->truncate('inbox');
		if($query)
		{
			return 1;
		}
		else
		{
			return false;
		}
	}
	public function inbox_count()
	{
		$this->db->where('inbox_seen', 1);
		$query = $this->db->get('inbox');
		if($query)
		{
			return $query->result();
		}

	}
	//## Category
	public function cat_insert()
	{
		$category_name = $this->input->post('category_name');
		$category_parent= $this->input->post('category_parent');

		$attr = array(
			'category_name' => $category_name,
			'category_parent' => $category_parent,

			);
		$query = $this->db->insert('category',$attr);
		if($query)
		{
			return 1;
		}
		else
		{
			return false;
		}

	}
	// ## Load Parent Category
	public function load_cat()
	{
		$query = $this->db->get_where('category',array('category_parent'=>'0'));
		return $query->result();
	}
	public function all_category()
	{
		$query = $this->db->get('category');
		return $query->result();
	}
	public function show_parent($parent_id)
	{
		$query = $this->db->get_where('category',array('category_id'=>$parent_id));
		return $query->result();
	}
	public function delete_cat($id) 
	{
	    $this->db->where('category_id', $id);
	   	$query = $this->db->delete('category');
	   	if ($this->db->affected_rows() > 0)
	   	{
	   		 return 1;
	   	}
    }
   // ## News
    
   	public function news_insert($target_file)
	{
		$time = date("Y-m-d");
		list($year, $month, $d) = explode('-', $time);
		$news_headline = $this->input->post('news_headline');
		$news_content= $this->input->post('news_content');
		$news_category_fkey = $this->input->post('news_category_fkey');

		$attr = array(
			'news_headline' => $news_headline,
			'news_content' => $news_content,
			'news_category_fkey' => $news_category_fkey,
			'news_photo' => $target_file,
			'news_month' => $month,
			'news_year' => $year,

			);
		$this->db->set('news_date', 'NOW()', FALSE);
		$query = $this->db->insert('news',$attr);
		if($query)
		{
			return 1;
		}
		else
		{
			return false;
		}

	}
	public function load_news()
	{
		$this->db->order_by('news_id','DESC');
		$query =$this->db->get('news');
		if($query)
		{
			return $query->result();
		}
	}
	public function load_news_page($per_page,$offset)
	{
		$page = ($offset-1)*$per_page;
		$this->db->order_by('news_id','DESC');
		$this->db->limit($per_page,$page);
		$query =$this->db->get('news');
		if($query)
		{
			return $query->result();
		}
	}
	public function delete_news($id)
	{
		$query=$this->db->get_where('news',array('news_id' =>$id,));
		if($query)
		{
			$result=$query->result();
			foreach ($result as $value) 
			{
				if(file_exists($value->news_photo))
					{
						unlink($value->news_photo);

					}
			}
			
		}
		$this->db->where('news_id', $id);
		$delete = $this->db->delete('news');
		if ($this->db->affected_rows() > 0)
	   	{
	   		 return 1;
	   	}
		else
		{
			return 'x';
		}
	}
	public function slide_insert($target_file)
	{
		$slideshow_name = $this->input->post('slideshow_name');
		

		$attr = array(
			'slideshow_name' => $slideshow_name,
			'slideshow_photo' => $target_file

			);

		$query = $this->db->insert('slideshow',$attr);
		if($query)
		{
			return 1;
		}
		else
		{
			return false;
		}
	}
	public function load_slide()
	{
		$query =$this->db->get('slideshow');
		if($query)
		{
			return $query->result();
		}
	}
	public function delete_slide($id)
		{
			$query=$this->db->get_where('slideshow',array('slideshow_id' => $id,));
			if($query)
			{
				$result=$query->result();
				foreach ($result as $value) 
				{
					if(file_exists($value->slideshow_photo))
						{
							unlink($value->slideshow_photo);

						}
				}
				
			}
			$this->db->where('slideshow_id', $id);
			$delete = $this->db->delete('slideshow');
			if ($this->db->affected_rows() > 0)
		   	{
		   		 return 1;
		   	}
		}
	public function load_link()
	{
		$query =$this->db->get('links');
		if($query)
		{
			return $query->result();
		}
	}
	public function profile_add($admin_name,$admin_username,$enc_password,$admin_email,$admin_designation,$target_file)
	{
		$attr  = array(	
			'admin_name' => $admin_name,
			'admin_password' => $enc_password,	
			'admin_username' => $admin_username,
			'admin_email' => $admin_email,
			'admin_designation' => $admin_designation,
			'admin_photo' => $target_file,
				
			);

		
		$query = $this->db->insert('admin',$attr);
		
		if($query)
		{
			$query2 = $this->db->get('admin');
			return $query2->result();
		}
		else
		{
			return 0;
		}	
	}
	public function total_visit($days)
	{
		
		$this->db->order_by('visitor_id DESC');
		$this->db->limit($days);	
		$this->db->from('visitor');
		$query = $this->db->get();
		
		if($query)
		{
			$result = $query->result();
		}
		$total = 0;
		foreach ($result as $key => $value) {
			$total = $total + $value->visitor_total;
		}
		return $total;

	}





	public function daily_visit()
	{
			
		
		
		$this->db->limit(1);
		$this->db->order_by('visitor_id','DESC');
		
		$query = $this->db->get('visitor');
		if($query)
		{
			return $query->result();
		}

	}
	public function monthly_visit()
	{
		$time = date("Y-m-d");
		list($year, $m, $d) = explode('-', $time);
		for ($month=1; $month <=12 ; $month++) { 
			$this->db->select('SUM(visitor_total) as total');
			$this->db->where('visitor_month',$month);
			$this->db->where('visitor_year',$year);
			$query=$this->db->get('visitor');
		
			$row=$query->row();
			$total=$row->total;
		
		
			$visitor_month = $month;
			if ($total!=null) {
				$visitor_month =  $month;
				$visitor_total =  $total;
			}
			else
			{	
				$visitor_month =  $month;
				$visitor_total = 0;
			}
			
			 $result[] = array('visitor_month'=>$visitor_month ,  'visitor_total'=>$visitor_total );
			 
		if($month==$m){
			break;
		}
		}
		
	return $result;
	}
	public function load_code()
		{
			$query = $this->db->get('adsense');
			return $query->result();
		}

}