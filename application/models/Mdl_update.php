<?php

class Mdl_update extends CI_Model {
	// ## Admin Update
	public function profile_edited($id,$admin_name,$admin_username,$enc_password,$admin_email,$enc_old_password,$target_file,$name)
	{
		
        $query = $this->db->get_where('admin',array('admin_id'=>$id,'admin_password'=>$enc_old_password));
		if($query->num_rows()>0)
		{
				$attr  = array(	
			'admin_name' => $admin_name,
			'admin_password' => $enc_password,	
			'admin_username' => $admin_username,
			'admin_email' => $admin_email,
				
			);

		$this->db->where('admin_id',$id);
		$query = $this->db->update('admin',$attr);
		$admin_photo = $target_file;
        if($name!='')
        {
			$query = $this->db->get_where('admin',array('admin_id'=>$id));
			$photo_url = $query->result();
			foreach ($photo_url as $value) 
			{
				if(file_exists($value->admin_photo))
				{
					unlink($value->admin_photo);
				}
			}
			$attr2  = array(	
			
			'admin_photo' => $admin_photo,
				
			);
			$this->db->where('admin_id',$id);
			$query = $this->db->update('admin',$attr2);
		}
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
		else
		{
			return 1;
		}
		
	
	}
	// ## Settings Update
	public function settings_edited($target_file1,$name1,$target_file2,$name2)
	{
		$id = $this->input->post('settings_id');
		$settings_color = $this->input->post('settings_color');
        $settings_title = $this->input->post('settings_title');
    	$settings_address = $this->input->post('settings_address');
        $settings_phone = $this->input->post('settings_phone');
        $settings_email = $this->input->post('settings_email');
        $settings_advert = $this->input->post('settings_advert');


			$attr  = array(	
			'settings_title' => $settings_title,
			'settings_address' => $settings_address,	
			'settings_phone' => $settings_phone,
			'settings_email' => $settings_email,
			'settings_color' => $settings_color,
			
				
			);

		$this->db->where('settings_id',$id);
		$query = $this->db->update('settings',$attr);

		$settings_logo = $target_file1;
	    if($name1!='')
        {
			$query = $this->db->get_where('settings',array('settings_id'=>$id));
			$photo_url = $query->result();
			foreach ($photo_url as $value) 
			{
				if(file_exists($value->settings_logo))
				{
					unlink($value->settings_logo);
				}
			}
			$attr2  = array(	
			
			'settings_logo' => $settings_logo,
				
			);
			$this->db->where('settings_id',$id);
			$query = $this->db->update('settings',$attr2);
		}

		$settings_icon = $target_file2;
	    if($name2!='')
        {
			$query = $this->db->get_where('settings',array('settings_id'=>$id));
			$photo_url = $query->result();
			foreach ($photo_url as $value) 
			{
				if(file_exists($value->settings_icon))
				{
					unlink($value->settings_icon);
				}
			}
			$attr3  = array(	
			
			'settings_icon' => $settings_icon,
				
			);
			$this->db->where('settings_id',$id);
			$query = $this->db->update('settings',$attr3);
		}

		if($query)
		{
			$query2 = $this->db->get('settings');
			return $query2->result();
		}
		else
		{
			return 0;
		}

		}
		// ## Category Update
		public function cat_update()
		{
			$id = $this->input->post('category_id');
			$category_name = $this->input->post('category_name');
			$category_parent= $this->input->post('category_parent');

			$attr = array(
				'category_name' => $category_name,
				'category_parent' => $category_parent,

				);
			$this->db->where('category_id',$id);
			$query = $this->db->update('category',$attr);
			if($query)
			{
				return 1;
			}
			else
			{
				return false;
			}
		}
		// ## News update
		public function news_updated($target_file,$name)
		{
		$id = $this->input->post('news_id');
		$news_headline = $this->input->post('news_headline');
        $news_content = $this->input->post('news_content');
        $news_category_fkey = $this->input->post('news_category_fkey');
    	

			$attr  = array(	
			'news_content' => $news_content,
			'news_headline' => $news_headline,
			'news_category_fkey' => $news_category_fkey,	
		
				
			);

		$this->db->where('news_id',$id);
		$query = $this->db->update('news',$attr);

		$news_photo = $target_file;
	    if($name!='')
        {
			$query = $this->db->get_where('news',array('news_id'=>$id));
			$photo_url = $query->result();
			foreach ($photo_url as $value) 
			{
				if(file_exists($value->news_photo))
				{
					unlink($value->news_photo);
				}
			}
			$attr2  = array(	
			
			'news_photo' => $news_photo,
				
			);
			$this->db->where('news_id',$id);
			$query = $this->db->update('news',$attr2);
		}
		if($query)
		{
			$query2 = $this->db->get('news');
			return $query2->result();
		}
		else
		{
			return 0;
		}

		}

	// ## Link update
	public function link_updated()
	{
		$id = $this->input->post('link_id');
		$link_fb = $this->input->post('link_fb');
		$link_twt = $this->input->post('link_twt');
		$link_google = $this->input->post('link_google');
		$link_utube = $this->input->post('link_utube');
		$link_linkedin = $this->input->post('link_linkedin');

		$attr  = array(	
			'link_fb' => $link_fb,
			'link_twt' => $link_twt,	
			'link_google' => $link_google,
			'link_utube' => $link_utube,
			'link_linkedin' => $link_linkedin,

				
			);

		$this->db->where('link_id',$id);
		$query = $this->db->update('links',$attr);

		if($query)
		{
			$query2 = $this->db->get('links');
			return $query2->result();
		}
		else
		{
			return 0;
		}

		

	}
	public function update_code()
		{
			$id = $this->input->post('adsense_id');
			$adsense_code = $this->input->post('adsense_code');
			$adsense_status= $this->input->post('adsense_status');

			$attr = array(
				'adsense_code' => $adsense_code,
				'adsense_status' => $adsense_status,

				);
			$this->db->where('adsense_id',$id);
			$query = $this->db->update('adsense',$attr);
			if($query)
			{
				return 1;
			}
			else
			{
				return false;
			}
		}
	
}