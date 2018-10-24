<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	
		function __construct() {
        parent::__construct();
      	$this->load->helper(array('form', 'url'));
      	$this->load->model('Mdl_admin');
		/* chk user logged in or not*/
		if(!$this->session->userdata('admin_logged_in'))
		{
			redirect('admin_login');
		}		
    }
    //  ##Load pages
	public function index()
	{
		$this->dashboard();
	}

	public function dashboard()
	{
		
		$data['vw_dashboard'] = 'vw_dashboard';
		$data['msg'] = '';
		$data['settings'] = $this->Mdl_admin->load_settings();
		$data['profile'] = $this->Mdl_admin->load_profile();
		$data['admin_name'] = $this->session->userdata('admin_name');
		$num_rows = $this->db->count_all("inbox");
		$data['inbox_total'] = $num_rows;
		$data['inbox_count'] = $this->Mdl_admin->inbox_count();

		$this->load->library('pagination');
 		$this->load->database(); //load library database

// Config setup
		$num_rows=$this->db->count_all("news");
 		$config['base_url'] = base_url().'admin/dashboard';
 		$config['total_rows'] = $num_rows;	
		$config['per_page'] = 16;
 		$config['num_links'] = 4;
 		$config['use_page_numbers'] = TRUE;
 		$config['full_tag_open'] = '<ul class="pagination">';
 		$config['full_tag_close'] = '</ul>';
 		$config['prev_link'] = '&laquo;';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
 		$config['cur_tag_open'] = '<li class="active"><a href="#">';
	 	$config['cur_tag_close'] = '</a></li>';
 		$config['num_tag_open'] = '<li>';
 		$config['num_tag_close'] = '</li>';
		$config['next_link'] = '&raquo;';
		$config['uri_segment'] = 3;
		if($this->uri->segment(3)){
		 $offset = $this->uri->segment(3);
		}
		else
		{
			$offset =1;
		}
 		$this->pagination->initialize($config);

 		$data['total_post'] = $num_rows;
 		$data['daily_visit'] = $this->Mdl_admin->daily_visit();
 		$data['weekly_visit'] = $this->Mdl_admin->total_visit(7);
 		$data['monthly_visit'] = $this->Mdl_admin->total_visit(30);
 		$data['monthly_progress'] = $this->Mdl_admin->monthly_visit();
 		$data['news'] = $this->Mdl_admin->load_news_page($config['per_page'],$offset);
 		
		$this->load->view('vw_admin',$data);
	}
	//## Settings update

	public function settings_update()
	{
		$this->load->model('Mdl_update');
		$num_rows = $this->db->count_all("inbox");
		$data['inbox_total'] = $num_rows;
		$data['inbox_count'] = $this->Mdl_admin->inbox_count();
        $target_file1 =$this->logo_upload();
        $name1 = $_FILES['settings_logo']['name'];
        $target_file2 =$this->icon_upload();
        $name2 = $_FILES['settings_icon']['name'];

        
        $data['settings'] = $this->Mdl_update->settings_edited($target_file1,$name1,$target_file2,$name2);
    	$data['profile'] = $this->Mdl_admin->load_profile();

    	if($data['settings'] ==0)
		{
			
			$data['settings'] = $this->Mdl_admin->load_settings();
			$data['profile'] = $this->Mdl_admin->load_profile();
			$data['msg'] = 'Sorry!! There is a problem in Update!!';
			$data['msg_type'] = 'danger';
		}
		
		else
		{
			
			$data['settings'] = $this->Mdl_admin->load_settings();
			$data['profile'] = $this->Mdl_admin->load_profile();
			$data['msg'] = 'Successfully updated Settings!!';
			$data['msg_type'] = 'success';
		}
		$data['vw_dashboard'] = 'vw_dashboard';
		$data['settings'] = $this->Mdl_admin->load_settings();
		$data['profile'] = $this->Mdl_admin->load_profile();
		$data['admin_name'] = $this->session->userdata('admin_name');
		
		$this->load->library('pagination');
 		$this->load->database(); //load library database

// Config setup
		$num_rows=$this->db->count_all("news");
 		$config['base_url'] = base_url().'admin/settings_update';
 		$config['total_rows'] = $num_rows;	
		$config['per_page'] = 16;
 		$config['num_links'] = 4;
 		$config['use_page_numbers'] = TRUE;
 		$config['full_tag_open'] = '<ul class="pagination">';
 		$config['full_tag_close'] = '</ul>';
 		$config['prev_link'] = '&laquo;';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
 		$config['cur_tag_open'] = '<li class="active"><a href="#">';
	 	$config['cur_tag_close'] = '</a></li>';
 		$config['num_tag_open'] = '<li>';
 		$config['num_tag_close'] = '</li>';
		$config['next_link'] = '&raquo;';
		$config['uri_segment'] = 3;
		if($this->uri->segment(3)){
		 $offset = $this->uri->segment(3);
		}
		else
		{
			$offset =1;
		}
 		$this->pagination->initialize($config);

 		$data['total_post'] = $num_rows;
 		$data['daily_visit'] = $this->Mdl_admin->daily_visit();
 		$data['weekly_visit'] = $this->Mdl_admin->total_visit(7);
 		$data['monthly_visit'] = $this->Mdl_admin->total_visit(30);
 		$data['monthly_progress'] = $this->Mdl_admin->monthly_visit();
 		$data['news'] = $this->Mdl_admin->load_news_page($config['per_page'],$offset);
		$this->load->view('vw_admin',$data);
    	
	}
		private function logo_upload()
		{
			if($_FILES['settings_logo']['name']!='')
			{
				$name = $_FILES['settings_logo']['name'];
				$name_ext = explode('.',$name );
				$ext = end($name_ext);
				$target_name = uniqid(rand()).".".$ext;
				$target_file1 = "assets/upload/photo/".$target_name;
				$allowed_types = array("jpeg","JPEG","jpg","JPG","gif","GIF","png","PNG");
				$file_type = $_FILES['settings_logo']['type'];

				if(in_array($ext, $allowed_types))
				{
					if(is_uploaded_file($_FILES['settings_logo']['tmp_name']))
						
						{
							if(move_uploaded_file($_FILES['settings_logo']['tmp_name'], $target_file1))
							{
								
								return $target_file1;
							}
							
								return false;					
						}
				}
				else
				{
					return false;
				}
			}
		}
		private function icon_upload()
		{
			if($_FILES['settings_icon']['name']!='')
			{
				$name = $_FILES['settings_icon']['name'];
				$name_ext = explode('.',$name );
				$ext = end($name_ext);
				$target_name = uniqid(rand()).".".$ext;
				$target_file2 = "assets/upload/photo/".$target_name;
				$allowed_types = array("jpeg","JPEG","jpg","JPG","gif","GIF","png","PNG");
				$file_type = $_FILES['settings_icon']['type'];

				if(in_array($ext, $allowed_types))
				{
					if(is_uploaded_file($_FILES['settings_icon']['tmp_name']))
						
						{
							if(move_uploaded_file($_FILES['settings_icon']['tmp_name'], $target_file2))
							{
								
								return $target_file2;
							}
							
								return false;					
						}
				}
				else
				{
					return false;
				}
			}
		}
		// ## Category
	public function category()
	{
		
		$data['vw_category'] = 'vw_category';
		$data['msg'] = '';
		$num_rows = $this->db->count_all("inbox");
		$data['inbox_total'] = $num_rows;
		$data['inbox_count'] = $this->Mdl_admin->inbox_count();
		$data['category'] = $this->Mdl_admin->all_category();
		$data['parent'] = $this->Mdl_admin->load_cat();
		$data['settings'] = $this->Mdl_admin->load_settings();
		$data['profile'] = $this->Mdl_admin->load_profile();
		$this->load->view('vw_admin',$data);
	}
	// ## Category Insert
    public function insert_cat()
    {
    	$data['vw_category'] = 'vw_category';
    	$num_rows = $this->db->count_all("inbox");
		$data['inbox_total'] = $num_rows;
		$data['inbox_count'] = $this->Mdl_admin->inbox_count();
		$data['settings'] = $this->Mdl_admin->load_settings();
		$data['profile'] = $this->Mdl_admin->load_profile();
		$data['category'] = $this->Mdl_admin->all_category();
		$result = $this->Mdl_admin->cat_insert();
		if($result==1)
		{
			$data['msg'] = 'Successfully Added Category!!';
			$data['msg_type'] = 'success';
		}
		else
		{
			$data['msg'] = 'Sorry!! Category wast not added!!Try Again';
			$data['msg_type'] = 'danger';
		}
		$data['parent'] = $this->Mdl_admin->load_cat();
		$data['category'] = $this->Mdl_admin->all_category();
		$this->load->view('vw_admin',$data);
    }	

	
    public function update_cat()
    {
    	$this->load->model('Mdl_update');
    	$data['vw_category'] = 'vw_category';
    	$num_rows = $this->db->count_all("inbox");
		$data['inbox_total'] = $num_rows;
		$data['inbox_count'] = $this->Mdl_admin->inbox_count();
		$data['settings'] = $this->Mdl_admin->load_settings();
		$data['profile'] = $this->Mdl_admin->load_profile();
		$data['category'] = $this->Mdl_admin->all_category();
		$result = $this->Mdl_update->cat_update();
		if($result==1)
		{
			$data['msg'] = 'Successfully Updated Category!!';
			$data['msg_type'] = 'success';
		}
		else
		{
			$data['msg'] = 'Sorry!! Category wast not updated!!Try Again';
			$data['msg_type'] = 'danger';
		}
		$data['parent'] = $this->Mdl_admin->load_cat();
		$data['category'] = $this->Mdl_admin->all_category();
		$this->load->view('vw_admin',$data);
    }
    // ## Category Delete
   public function category_delete($id=null)
   {			
		
		$data['vw_category'] = 'vw_category';
		$data['msg'] = '';	
		$num_rows = $this->db->count_all("inbox");
		$data['inbox_total'] = $num_rows;
		$data['inbox_count'] = $this->Mdl_admin->inbox_count();	
		$data['settings'] = $this->Mdl_admin->load_settings();
		$data['profile'] = $this->Mdl_admin->load_profile();
		$query = $this->Mdl_admin->delete_cat($id);
		if($query==1)
		{
			$data['msg'] = 'Successfully Deleted Category!!';
			$data['msg_type'] = 'success';
		}
		else{
			$data['msg'] = 'Sorry!! Category wast not deleted!!Try Again';
			$data['msg_type'] = 'danger';
		}
		$data['category'] = $this->Mdl_admin->all_category();
		$data['parent'] = $this->Mdl_admin->load_cat();
		$this->load->view('vw_admin',$data);

	}
  // ## News
	public function news($msg=null)
	{
		
		$data['vw_news'] = 'vw_news';
		$data['msg'] = '';
		$num_rows = $this->db->count_all("inbox");
		$data['inbox_total'] = $num_rows;
		$data['inbox_count'] = $this->Mdl_admin->inbox_count();
		$data['category'] = $this->Mdl_admin->all_category();
		$data['settings'] = $this->Mdl_admin->load_settings();
		$data['profile'] = $this->Mdl_admin->load_profile();
		if($msg==1)
		{
			$data['msg'] = 'Successfully Deleted News!!';
			$data['msg_type'] = 'success';
		}
		else if($msg=='x'){
			$data['msg'] = 'Sorry!! News wast not deleted!!Try Again';
			$data['msg_type'] = 'danger';
		}
		else
		{
			$data['msg'] = '';
		}
		$this->load->library('pagination');

 		$this->load->database(); //load library database

// Config setup
		$num_rows=$this->db->count_all("news");
 		$config['base_url'] = base_url().'admin/news';
 		$config['total_rows'] = $num_rows;	
		$config['per_page'] = 6;
 		$config['num_links'] = 4;
 		$config['use_page_numbers'] = TRUE;
 		$config['full_tag_open'] = '<ul class="pagination">';
 		$config['full_tag_close'] = '</ul>';
 		$config['prev_link'] = '&laquo;';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
 		$config['cur_tag_open'] = '<li class="active"><a href="#">';
	 	$config['cur_tag_close'] = '</a></li>';
 		$config['num_tag_open'] = '<li>';
 		$config['num_tag_close'] = '</li>';
		$config['next_link'] = '&raquo;';

 		$config['uri_segment'] = 3;
		if($this->uri->segment(3)){
		 $offset = $this->uri->segment(3);
		}
		else
		{
			$offset =1;
		}
 		$this->pagination->initialize($config);

 
 		$data['news'] = $this->Mdl_admin->load_news_page($config['per_page'],$offset);
		
		$this->load->view('vw_admin',$data);
	}
	// ## Publish a news

	public function news_publish()
	{
		$data['vw_news'] = 'vw_news';
		$data['msg'] = '';
		$num_rows = $this->db->count_all("inbox");
		$data['inbox_total'] = $num_rows;
		$data['inbox_count'] = $this->Mdl_admin->inbox_count();
		$data['category'] = $this->Mdl_admin->all_category();
		$data['settings'] = $this->Mdl_admin->load_settings();
		$data['profile'] = $this->Mdl_admin->load_profile();
		$target_file =$this->news_photo();
		$result = $this->Mdl_admin->news_insert($target_file);
		if($result==1)
		{
			$data['msg'] = 'Successfully Published the News!!';
			$data['msg_type'] = 'success';
		}
		else
		{
			$data['msg'] = 'Sorry!! News Couldnt published!!Try Again';
			$data['msg_type'] = 'danger';
		}
		$this->load->library('pagination');

 		$this->load->database(); //load library database

// Config setup
		$num_rows=$this->db->count_all("news");
 		$config['base_url'] = base_url().'admin/news';
 		$config['total_rows'] = $num_rows;	
		$config['per_page'] = 6;
 		$config['num_links'] = 4;
 		$config['use_page_numbers'] = TRUE;
 		$config['full_tag_open'] = '<ul class="pagination">';
 		$config['full_tag_close'] = '</ul>';
 		$config['prev_link'] = '&laquo;';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
 		$config['cur_tag_open'] = '<li class="active"><a href="#">';
	 	$config['cur_tag_close'] = '</a></li>';
 		$config['num_tag_open'] = '<li>';
 		$config['num_tag_close'] = '</li>';
		$config['next_link'] = '&raquo;';

 		$config['uri_segment'] = 3;
		if($this->uri->segment(3)){
		 $offset = $this->uri->segment(3);
		}
		else
		{
			$offset =1;
		}
 		$this->pagination->initialize($config);

 
 		$data['news'] = $this->Mdl_admin->load_news_page($config['per_page'],$offset);
		
		$this->load->view('vw_admin',$data);
			}

private function news_photo()
		{
			
				$name = $_FILES['news_photo']['name'];
				$name_ext = explode('.',$name );
				$ext = end($name_ext);
				$target_name = uniqid(rand()).".".$ext;
				$target_file = "assets/upload/news/".$target_name;
				$allowed_types = array("jpeg","JPEG","jpg","JPG","gif","GIF","png","PNG");
				$file_type = $_FILES['news_photo']['type'];

				if(in_array($ext, $allowed_types))
				{
					if(is_uploaded_file($_FILES['news_photo']['tmp_name']))
						
						{
							if(move_uploaded_file($_FILES['news_photo']['tmp_name'], $target_file))
							{
								
								return $target_file;
							}
							
								return false;					
						}
				}
				else
				{
					return false;
				}
			}
		
//## News update

	public function update_news()
	{
		$this->load->model('Mdl_update');
        $target_file = $this->news_photo_update();
        $name = $_FILES['news_photo']['name'];

        $data['vw_news'] = 'vw_news';
        $num_rows = $this->db->count_all("inbox");
		$data['inbox_total'] = $num_rows;
		$data['inbox_count'] = $this->Mdl_admin->inbox_count();
        $data['news'] = $this->Mdl_update->news_updated($target_file,$name);
    	$data['profile'] = $this->Mdl_admin->load_profile();
    	$data['settings'] = $this->Mdl_admin->load_settings();

    	if($data['news'] ==0)
		{
			$data['category'] = $this->Mdl_admin->all_category();
			$data['news'] = $this->Mdl_admin->load_news();
			$data['settings'] = $this->Mdl_admin->load_settings();
			$data['profile'] = $this->Mdl_admin->load_profile();
			$data['msg'] = 'Sorry!! There is a problem in Update!!';
			$data['msg_type'] = 'danger';
		}
		
		else
		{
			$data['category'] = $this->Mdl_admin->all_category();
			
			$data['settings'] = $this->Mdl_admin->load_settings();
			$data['profile'] = $this->Mdl_admin->load_profile();
			$data['msg'] = 'Successfully updated News!!';
			$data['msg_type'] = 'success';
		}
		$this->load->library('pagination');

 		$this->load->database(); //load library database

// Config setup
		$num_rows=$this->db->count_all("news");
 		$config['base_url'] = base_url().'admin/news';
 		$config['total_rows'] = $num_rows;	
		$config['per_page'] = 6;
 		$config['num_links'] = 4;
 		$config['use_page_numbers'] = TRUE;
 		$config['full_tag_open'] = '<ul class="pagination">';
 		$config['full_tag_close'] = '</ul>';
 		$config['prev_link'] = '&laquo;';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
 		$config['cur_tag_open'] = '<li class="active"><a href="#">';
	 	$config['cur_tag_close'] = '</a></li>';
 		$config['num_tag_open'] = '<li>';
 		$config['num_tag_close'] = '</li>';
		$config['next_link'] = '&raquo;';

 		$config['uri_segment'] = 3;
		if($this->uri->segment(3)){
		 $offset = $this->uri->segment(3);
		}
		else
		{
			$offset =1;
		}
 		$this->pagination->initialize($config);

 
 		$data['news'] = $this->Mdl_admin->load_news_page($config['per_page'],$offset);
		
		$this->load->view('vw_admin',$data);   	
	}
		private function news_photo_update()
		{
			if($_FILES['news_photo']['name']!='')
			{
				$name = $_FILES['news_photo']['name'];
				$name_ext = explode('.',$name );
				$ext = end($name_ext);
				$target_name = uniqid(rand()).".".$ext;
				$target_file = "assets/upload/news/".$target_name;
				$allowed_types = array("jpeg","JPEG","jpg","JPG","gif","GIF","png","PNG");
				$file_type = $_FILES['news_photo']['type'];

				if(in_array($ext, $allowed_types))
				{
					if(is_uploaded_file($_FILES['news_photo']['tmp_name']))
						
						{
							if(move_uploaded_file($_FILES['news_photo']['tmp_name'], $target_file))
							{
								
								return $target_file;
							}
							
								return false;					
						}
				}
				else
				{
					return false;
				}
			}
		}
	public function news_delete($id)
	{
		$data['vw_category'] = 'vw_news';
		$data['msg'] = '';		
		$num_rows = $this->db->count_all("inbox");
		$data['inbox_total'] = $num_rows;
		$data['inbox_count'] = $this->Mdl_admin->inbox_count();
		$data['settings'] = $this->Mdl_admin->load_settings();
		$data['profile'] = $this->Mdl_admin->load_profile();
		$query = $this->Mdl_admin->delete_news($id);
		
		$data['category'] = $this->Mdl_admin->all_category();
		$data['parent'] = $this->Mdl_admin->load_cat();
		$data['news'] = $this->Mdl_admin->load_news();
		redirect('admin/news/'.$query);
	} 
	// ## Slideshow
	public function slideshow()
	{
		$data['vw_slideshow'] = 'vw_slideshow';
		$data['msg'] = '';
		$num_rows = $this->db->count_all("inbox");
		$data['inbox_total'] = $num_rows;
		$data['inbox_count'] = $this->Mdl_admin->inbox_count();
		$data['slideshow'] = $this->Mdl_admin->load_slide();
		$data['settings'] = $this->Mdl_admin->load_settings();
		$data['profile'] = $this->Mdl_admin->load_profile();
		$this->load->view('vw_admin',$data);
	}
	  public function add_slideshow()
    {
    	$target_file = $this->slide_photo();
    	$data['vw_slideshow'] = 'vw_slideshow';
    	$num_rows = $this->db->count_all("inbox");
		$data['inbox_total'] = $num_rows;
		$data['inbox_count'] = $this->Mdl_admin->inbox_count();
		$data['settings'] = $this->Mdl_admin->load_settings();
		$data['profile'] = $this->Mdl_admin->load_profile();
		
		$result = $this->Mdl_admin->slide_insert($target_file);
		if($result==1)
		{
			$data['msg'] = 'Successfully added the Slide!!';
			$data['msg_type'] = 'success';
		}
		else
		{
			$data['msg'] = 'Sorry!! Slide was not added!!Try Again';
			$data['msg_type'] = 'danger';
		}
		$data['slideshow'] = $this->Mdl_admin->load_slide();
		

		$this->load->view('vw_admin',$data);
    }
    public function slide_delete($id)
	{
		
		$data['msg'] = '';		
		$data['vw_slideshow'] = 'vw_slideshow';
		$num_rows = $this->db->count_all("inbox");
		$data['inbox_total'] = $num_rows;
		$data['inbox_count'] = $this->Mdl_admin->inbox_count();
		
		$data['settings'] = $this->Mdl_admin->load_settings();
		$data['profile'] = $this->Mdl_admin->load_profile();
		$query = $this->Mdl_admin->delete_slide($id);
		if($query==1)
		{
			$data['msg'] = 'Successfully Deleted the Slide!!';
			$data['msg_type'] = 'success';
		}
		else{
			$data['msg'] = 'Sorry!! Slide wast not deleted!!Try Again';
			$data['msg_type'] = 'danger';
		}
		$data['slideshow'] = $this->Mdl_admin->load_slide();
		$this->load->view('vw_admin',$data);
	} 
    private function slide_photo()
    {
    $name = $_FILES['slideshow_photo']['name'];
				$name_ext = explode('.',$name );
				$ext = end($name_ext);
				$target_name = uniqid(rand()).".".$ext;
				$target_file = "assets/upload/slide/".$target_name;
				$allowed_types = array("jpeg","JPEG","jpg","JPG","gif","GIF","png","PNG");
				$file_type = $_FILES['slideshow_photo']['type'];

				if(in_array($ext, $allowed_types))
				{
					if(is_uploaded_file($_FILES['slideshow_photo']['tmp_name']))
						
						{
							if(move_uploaded_file($_FILES['slideshow_photo']['tmp_name'], $target_file))
							{
								
								return $target_file;
							}
							
								return false;					
						}
				}
				else
				{
					return false;
				}	
    }
    // ## Inbox
	public function inbox($msg=null)
	{
		$data['vw_inbox'] = 'vw_inbox';
		$data['msg'] = '';
		$data['settings'] = $this->Mdl_admin->load_settings();
		$data['profile'] = $this->Mdl_admin->load_profile();
		
		$this->load->library('pagination');

 		$this->load->database(); //load library database

// Config setup
		$num_rows = $this->db->count_all("inbox");
 		$config['base_url'] = base_url().'admin/inbox';
 		$config['total_rows'] = $num_rows;	
		$config['per_page'] = 16;
 		$config['num_links'] = 4;
 		$config['use_page_numbers'] = TRUE;
 		$config['full_tag_open'] = '<ul class="pagination">';
 		$config['full_tag_close'] = '</ul>';
 		$config['prev_link'] = '&laquo;';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
 		$config['cur_tag_open'] = '<li class="active"><a href="#">';
	 	$config['cur_tag_close'] = '</a></li>';
 		$config['num_tag_open'] = '<li>';
 		$config['num_tag_close'] = '</li>';
		$config['next_link'] = '&raquo;';
		$config['uri_segment'] = 3;
		if($this->uri->segment(3)){
		 $offset = $this->uri->segment(3);
		}
		else
		{
			$offset =1;
		}
 		
 		$this->pagination->initialize($config);

 
 		$data['inbox'] = $this->Mdl_admin->load_inbox($config['per_page'],$offset);
 		$data['inbox_total'] = $num_rows;
		$data['inbox_count'] = $this->Mdl_admin->inbox_count();
		if($msg==1)
		{
			$data['msg'] = 'Successfully Deleted Messages!!';
			$data['msg_type'] = 'success';
		}
		else if($msg=='x'){
			$data['msg'] = 'Sorry!! Message wast not deleted!!Try Again';
			$data['msg_type'] = 'danger';
		}
		else
		{
			$data['msg'] = '';
		}
		$this->load->view('vw_admin',$data);
	}
	public function seen($id)
	{
		$this->Mdl_admin->message_seen($id);
		$data['msg'] = '';
		$data['vw_inbox'] = 'vw_inbox';
		$data['settings'] = $this->Mdl_admin->load_settings();
		$data['profile'] = $this->Mdl_admin->load_profile();
 
 		redirect('admin/inbox');
		}
	function remove_checked()
	{
	    $data['msg'] = ''; 
	    $data['vw_inbox'] = 'vw_inbox';   
	    $checked_messages = $this->input->post('msg'); //selected messages
	    $query = $this->Mdl_admin->delete_checked($checked_messages); 
	    
		$data['settings'] = $this->Mdl_admin->load_settings();
		$data['profile'] = $this->Mdl_admin->load_profile();
		
		redirect('admin/inbox/'.$query);	}
	public function delete_all()
	{
		$data['msg'] = ''; 
		$query = $this->Mdl_admin->all_delete();
		 if($query==1)
		{
			$data['msg'] = 'Successfully Deleted all messages!!';
			$data['msg_type'] = 'success';
		}
		else{
			$data['msg'] = 'Sorry!! Message wast not deleted!!Try Again';
			$data['msg_type'] = 'danger';
		} 
		$data['vw_inbox'] = 'vw_inbox';
		$data['settings'] = $this->Mdl_admin->load_settings();
		$data['profile'] = $this->Mdl_admin->load_profile();
		
		$this->load->library('pagination');

 		$this->load->database(); //load library database

// Config setup
		$num_rows = $this->db->count_all("inbox");
 		$config['base_url'] = base_url().'admin/inbox';
 		$config['total_rows'] = $num_rows;	
		$config['per_page'] = 16;
 		$config['num_links'] = 4;
 		$config['use_page_numbers'] = TRUE;
 		$config['full_tag_open'] = '<ul class="pagination">';
 		$config['full_tag_close'] = '</ul>';
 		$config['prev_link'] = '&laquo;';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
 		$config['cur_tag_open'] = '<li class="active"><a href="#">';
	 	$config['cur_tag_close'] = '</a></li>';
 		$config['num_tag_open'] = '<li>';
 		$config['num_tag_close'] = '</li>';
		$config['next_link'] = '&raquo;';

 		$config['uri_segment'] = 3;
		if($this->uri->segment(3)){
		 $offset = $this->uri->segment(3);
		}
		else
		{
			$offset =1;
		}
 		$this->pagination->initialize($config);

 
 		$data['inbox'] = $this->Mdl_admin->load_inbox($config['per_page'],$offset);
 		$data['inbox_total'] = $num_rows;
		$data['inbox_count'] = $this->Mdl_admin->inbox_count();		
		$this->load->view('vw_admin',$data);
	}
	
	public function add_admin()
	{
		$data['vw_add_admin'] = 'vw_add_admin';
		$data['msg'] = '';
		$num_rows = $this->db->count_all("inbox");
		$data['inbox_total'] = $num_rows;
		$data['inbox_count'] = $this->Mdl_admin->inbox_count();
		$data['settings'] = $this->Mdl_admin->load_settings();
		$data['profile'] = $this->Mdl_admin->load_profile();
		$data['all_profile'] = $this->Mdl_admin->all_profile();
		$this->load->view('vw_admin',$data);
	}
	public function edit_profile()
	{
		$data['vw_edit_profile'] = 'vw_edit_profile';
		$data['msg'] = '';
		$num_rows = $this->db->count_all("inbox");
		$data['inbox_total'] = $num_rows;
		$data['inbox_count'] = $this->Mdl_admin->inbox_count();
		$data['settings'] = $this->Mdl_admin->load_settings();
		$data['profile'] = $this->Mdl_admin->load_profile();
		$this->load->view('vw_admin',$data);
	}
	//  ## aDD LINK
	public function add_links()
	{
		$data['vw_add_links'] = 'vw_add_links';
		$data['msg'] = '';
		$num_rows = $this->db->count_all("inbox");
		$data['inbox_total'] = $num_rows;
		$data['inbox_count'] = $this->Mdl_admin->inbox_count();
		$data['settings'] = $this->Mdl_admin->load_settings();
		$data['profile'] = $this->Mdl_admin->load_profile();
		$data['link'] = $this->Mdl_admin->load_link();
		$this->load->view('vw_admin',$data);
	}
	public function update_link()
	{
		$this->load->model('Mdl_update');
      
		$num_rows = $this->db->count_all("inbox");
		$data['inbox_total'] = $num_rows;
		$data['inbox_count'] = $this->Mdl_admin->inbox_count();
        $data['vw_news'] = 'vw_add_links';
        $data['link'] = $this->Mdl_update->link_updated();
    	$data['profile'] = $this->Mdl_admin->load_profile();
    	$data['settings'] = $this->Mdl_admin->load_settings();

    	if($data['link'] ==0)
		{
			
			$data['link'] = $this->Mdl_admin->load_link();
			$data['settings'] = $this->Mdl_admin->load_settings();
			$data['profile'] = $this->Mdl_admin->load_profile();
			$data['msg'] = 'Sorry!! There is a problem in Update!!';
			$data['msg_type'] = 'danger';
		}
		
		else
		{
			
			$data['link'] = $this->Mdl_update->link_updated();
			$data['settings'] = $this->Mdl_admin->load_settings();
			$data['profile'] = $this->Mdl_admin->load_profile();
			$data['msg'] = 'Successfully updated Links!!';
			$data['msg_type'] = 'success';
		}
		$this->load->view('vw_admin',$data);
	} 

	//  ##Profile update
	public function profile_update()
    {
        $id = $this->input->post('admin_id');
        $admin_name = $this->input->post('admin_name');
    	$email = $this->input->post('admin_email');
        $username = $this->input->post('admin_username');
        $admin_old_password = $this->input->post('admin_old_password');
    	$password = $this->input->post('admin_password');
    	$passconf = $this->input->post('admin_passconf');

        $this->form_validation->set_rules('admin_username', 'Username', 'trim|required|min_length[5]|max_length[12]');
		$this->form_validation->set_rules('admin_password', 'Password', 'trim|required|min_length[8]');
		$this->form_validation->set_rules('admin_passconf', 'Password Confirmation', 'trim|required|matches[admin_password]');
		$this->form_validation->set_rules('admin_email', 'Email', 'trim|required|valid_email');
		if($this->form_validation->run()==FALSE)
           
    	{   
            $data['vw_edit_profile'] = 'vw_edit_profile';
            $data['msg'] = '';
			$data['settings'] = $this->Mdl_admin->load_settings();
			$data['profile'] = $this->Mdl_admin->load_profile();
    		$this->load->view('vw_admin',$data);
    	}

    	else
    	{
            $this->load->library('encrypt');
            $enc_password = md5($password);
            $enc_old_password = md5($admin_old_password);
            $this->load->model('Mdl_update');
            $target_file =$this->do_upload();
            $name = $_FILES['admin_photo']['name'];
			$data['vw_edit_profile'] = 'vw_edit_profile';
            $data['settings'] = $this->Mdl_admin->load_settings();
    		$data['profile'] = $this->Mdl_update->profile_edited($id,$admin_name,$username,$enc_password,$email,$enc_old_password,$target_file,$name);
            
    	if($data['profile'] ==0)
		{
			$data['vw_edit_profile'] = 'vw_edit_profile';
			$data['settings'] = $this->Mdl_admin->load_settings();
			$data['profile'] = $this->Mdl_admin->load_profile();
			$data['msg'] = 'Sorry!! There is a problem in Update!!';
			$data['msg_type'] = 'danger';
		}
		else if($data['profile'] ==1)
		{
			$data['vw_edit_profile'] = 'vw_edit_profile';
			$data['settings'] = $this->Mdl_admin->load_settings();
			$data['profile'] = $this->Mdl_admin->load_profile();
			$data['msg'] = 'Sorry!! Wrong old pssword!!';
			$data['msg_type'] = 'danger';
		}
		else
		{
			$data['vw_edit_profile'] = 'vw_edit_profile';
			$data['settings'] = $this->Mdl_admin->load_settings();
			$data['profile'] = $this->Mdl_admin->load_profile();
			$data['msg'] = 'Successfully updated Profile!!';
			$data['msg_type'] = 'success';
		}
		
		$num_rows = $this->db->count_all("inbox");
		$data['inbox_total'] = $num_rows;
		$data['inbox_count'] = $this->Mdl_admin->inbox_count();
		$this->load->view('vw_admin',$data);
        
    	}
    }
        
    	private function do_upload()
		{
			if($_FILES['admin_photo']['name']!='')
			{
				$name = $_FILES['admin_photo']['name'];
				$name_ext = explode('.',$name );
				$ext = end($name_ext);
				$target_name = uniqid(rand()).".".$ext;
				$target_file = "assets/upload/photo/".$target_name;
				$allowed_types = array("jpeg","JPEG","jpg","JPG","gif","GIF","png","PNG");
				$file_type = $_FILES['admin_photo']['type'];

				if(in_array($ext, $allowed_types))
				{
					if(is_uploaded_file($_FILES['admin_photo']['tmp_name']))
						
						{
							if(move_uploaded_file($_FILES['admin_photo']['tmp_name'], $target_file))
							{
								
								return $target_file;
							}
							
								return false;					
						}
				}
				else
				{
					return false;
				}
			}
		}

	public function add_profile()
	{

		$num_rows = $this->db->count_all("inbox");
		$data['inbox_total'] = $num_rows;
		$data['inbox_count'] = $this->Mdl_admin->inbox_count();
        $admin_name = $this->input->post('admin_name');
    	$email = $this->input->post('admin_email');
        $username = $this->input->post('admin_username');
    	$password = $this->input->post('admin_password');
    	$passconf = $this->input->post('admin_passconf');
    	$designation = $this->input->post('admin_designation');

        $this->form_validation->set_rules('admin_username', 'Username', 'trim|required|min_length[5]|max_length[12]|is_unique[admin.admin_username]');
		$this->form_validation->set_rules('admin_password', 'Password', 'trim|required|min_length[8]');
		$this->form_validation->set_rules('admin_passconf', 'Password Confirmation', 'trim|required|matches[admin_password]');
		$this->form_validation->set_rules('admin_email', 'Email', 'trim|required|valid_email|is_unique[admin.admin_email]');

		if($this->form_validation->run()==FALSE)
           
    	{   
            $data['vw_add_admin'] = 'vw_add_admin';
            $data['msg'] = '';
			$data['settings'] = $this->Mdl_admin->load_settings();
			$data['profile'] = $this->Mdl_admin->load_profile();
			$data['all_profile'] = $this->Mdl_admin->all_profile();
    		$this->load->view('vw_admin',$data);
    	}

    	else
    	{
            $this->load->library('encrypt');
            $enc_password = md5($password);
    	  	$data['msg'] = '';
            $this->load->model('Mdl_admin');
            $target_file =$this->do_upload_2();
            $name = $_FILES['admin_photo']['name'];
			$data['vw_add_admin'] = 'vw_add_admin';
            $data['settings'] = $this->Mdl_admin->load_settings();
    		$data['profile'] = $this->Mdl_admin->profile_add($admin_name,$username,$enc_password,$email,$designation,$target_file,$name);
            $data['all_profile'] = $this->Mdl_admin->all_profile();

    	if($data['profile'] ==0)
		{
			$data['vw_add_admin'] = 'vw_add_admin';
			$data['settings'] = $this->Mdl_admin->load_settings();
			$data['profile'] = $this->Mdl_admin->load_profile();
			$data['all_profile'] = $this->Mdl_admin->all_profile();
			$data['msg'] = 'Sorry!! Failed to add admin.Try Again!!!!';
			$data['msg_type'] = 'danger';
		}
		
		else
		{
			$data['vw_add_admin'] = 'vw_add_admin';
			$data['settings'] = $this->Mdl_admin->load_settings();
			$data['profile'] = $this->Mdl_admin->load_profile();
			$data['all_profile'] = $this->Mdl_admin->all_profile();
			$data['msg'] = 'Successfully Added Profile!!';
			$data['msg_type'] = 'success';
		}
		
		
		$this->load->view('vw_admin',$data);
        
    	}
	}	
private function do_upload_2()
		{
			if($_FILES['admin_photo']['name']!='')
			{
				$name = $_FILES['admin_photo']['name'];
				$name_ext = explode('.',$name );
				$ext = end($name_ext);
				$target_name = uniqid(rand()).".".$ext;
				$target_file = "assets/upload/photo/".$target_name;
				$allowed_types = array("jpeg","JPEG","jpg","JPG","gif","GIF","png","PNG");
				$file_type = $_FILES['admin_photo']['type'];

				if(in_array($ext, $allowed_types))
				{
					if(is_uploaded_file($_FILES['admin_photo']['tmp_name']))
						
						{
							if(move_uploaded_file($_FILES['admin_photo']['tmp_name'], $target_file))
							{
								
								return $target_file;
							}
							
								return false;					
						}
				}
				else
				{
					return false;
				}
			}
		}
		public function admin_delete($id)
	{
		$data['vw_add_admin'] = 'vw_add_admin';
		$data['msg'] = '';		-
		
		$query = $this->Mdl_admin->delete_admin($id);
		if($query==1)
		{
			$data['msg'] = 'Successfully Deleted Admin!!';
			$data['msg_type'] = 'success';
		}
		else{
			$data['msg'] = 'Sorry!! Admin was not deleted!!Try Again';
			$data['msg_type'] = 'danger';
		}
		$data['all_profile'] = $this->Mdl_admin->all_profile();
		$num_rows = $this->db->count_all("inbox");
		$data['inbox_total'] = $num_rows;
		$data['inbox_count'] = $this->Mdl_admin->inbox_count();
		$data['settings'] = $this->Mdl_admin->load_settings();
		$data['profile'] = $this->Mdl_admin->load_profile();
		$this->load->view('vw_admin',$data);
	} 
	
	public function adsense()
	{
		$this->load->model('Mdl_update');
		$data['vw_adsense'] = 'vw_adsense';
		$data['msg'] = '';
		$num_rows = $this->db->count_all("inbox");
		$data['inbox_total'] = $num_rows;
		$data['inbox_count'] = $this->Mdl_admin->inbox_count();
		$data['settings'] = $this->Mdl_admin->load_settings();
		$data['profile'] = $this->Mdl_admin->load_profile();
		$data['adsense'] = $this->Mdl_admin->load_code();
		$this->load->view('vw_admin',$data);
	}
	public function adsense_code()
    {
    	$this->load->model('Mdl_update');
    	$data['vw_adsense'] = 'vw_adsense';
    	$num_rows = $this->db->count_all("inbox");
		$data['inbox_total'] = $num_rows;
		$data['inbox_count'] = $this->Mdl_admin->inbox_count();
		$data['settings'] = $this->Mdl_admin->load_settings();
		$data['profile'] = $this->Mdl_admin->load_profile();
		
		$result = $this->Mdl_update->update_code();
		if($result==1)
		{
			$data['msg'] = 'Successfully Updated  your AdSense Code!!';
			$data['msg_type'] = 'success';
		}
		else
		{
			$data['msg'] = 'Sorry!!Code wast not added!!Try Again';
			$data['msg_type'] = 'danger';
		}
		$data['adsense'] = $this->Mdl_admin->load_code();
		$this->load->view('vw_admin',$data);
    }	
    

}

