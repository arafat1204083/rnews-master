<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rnews extends CI_Controller {


	public function index()
	{
		$this->home_index();
	}
	public function home_index()
	{
		$this->load->model('Mdl_rnews');
		$this->load->model('Mdl_admin');
		$data['vw_home'] = 'vw_index';
		$data['msg'] = '';
		$data['link'] = $this->Mdl_admin->load_link();
		$data['settings'] = $this->Mdl_admin->load_settings();
		$data['slideshow'] = $this->Mdl_admin->load_slide();
		$data['category'] = $this->Mdl_admin->load_cat();
		$data['news'] = $this->Mdl_rnews->load_news();
		$data['adsense'] = $this->Mdl_admin->load_code();
		$data['post'] = '0';
		$data['recent_news'] = $this->Mdl_rnews->recent_news();
		$data['recent_comment'] = $this->Mdl_rnews->recent_comment();
		

		if (!$this->session->userdata('timeout') || $this->session->userdata('timeout') < time()) {
        $this->session->set_userdata('timeout', time() + 10);       
        $total_visit = $this->Mdl_rnews->total_visitor();
        
	
    }
    else {
        $timeout_time = $this->session->userdata('timeout');
        if (time() > $timeout_time) {

            $this->session->set_userdata(array('timeout' => ''));
            $this->session->sess_destroy();
        }
    }
		$this->load->view('vw_front',$data);
        
	
    }
	/*public function home()
	{
		$this->load->model('Mdl_rnews');
		$this->load->model('Mdl_admin');
		$data['vw_home'] = 'vw_home';
		$data['msg'] = '';
		$data['link'] = $this->Mdl_admin->load_link();
		$data['settings'] = $this->Mdl_admin->load_settings();
		$data['slideshow'] = $this->Mdl_admin->load_slide();
		$data['category'] = $this->Mdl_admin->load_cat();
		$data['news'] = $this->Mdl_rnews->load_news();
		$data['adsense'] = $this->Mdl_admin->load_code();
		$data['post'] = '0';
		$data['recent_news'] = $this->Mdl_rnews->recent_news();
		$data['recent_comment'] = $this->Mdl_rnews->recent_comment();
		

		if (!$this->session->userdata('timeout') || $this->session->userdata('timeout') < time()) {
        $this->session->set_userdata('timeout', time() + 10);       
        $total_visit = $this->Mdl_rnews->total_visitor();
        
	
    }
    else {
        $timeout_time = $this->session->userdata('timeout');
        if (time() > $timeout_time) {

            $this->session->set_userdata(array('timeout' => ''));
            $this->session->sess_destroy();
        }
    }
		$this->load->view('vw_front',$data);
	}*/
	public function post($id=null)
	{
		$this->load->model('Mdl_rnews');
		$this->load->model('Mdl_admin');
		
		if (!$this->session->userdata('timeout') || $this->session->userdata('timeout') < time()) {
        $this->session->set_userdata('timeout', time() + 10);
        $update = $this->Mdl_rnews->increase_visitor($id);
        $total_visit = $this->Mdl_rnews->total_visitor();
        
	
    }
    else {
        $timeout_time = $this->session->userdata('timeout');
        if (time() > $timeout_time) {

            $this->session->set_userdata(array('timeout' => ''));
            $this->session->sess_destroy();
        }
    }
		
		$data['link'] = $this->Mdl_admin->load_link();
		
		$data['vw_post'] = 'vw_post';
		$data['msg'] = '';
		$data['recent_news'] = $this->Mdl_rnews->recent_news();
		$data['recent_comment'] = $this->Mdl_rnews->recent_comment();
		$data['settings'] = $this->Mdl_admin->load_settings();
		$data['category'] = $this->Mdl_admin->load_cat();
		$data['post'] = $this->Mdl_rnews->load_post($id);
		$data['comment'] = $this->Mdl_rnews->load_comment($id);
		$data['adsense'] = $this->Mdl_admin->load_code();
		$this->load->view('vw_front',$data);

	}
	public function categorized($id)
	{
		$this->load->model('Mdl_admin');
		$this->load->model('Mdl_rnews');
		
	
		$data['link'] = $this->Mdl_admin->load_link();
		$this->load->model('Mdl_admin');
		$data['vw_home'] = 'vw_home';
		$data['msg'] = '';
		$data['settings'] = $this->Mdl_admin->load_settings();
		$data['slideshow'] = $this->Mdl_admin->load_slide();
		$data['category'] = $this->Mdl_admin->load_cat();
		$data['news'] = $this->Mdl_rnews->categorized_news($id);
		$data['post'] = '0';

		$data['recent_news'] = $this->Mdl_rnews->recent_news();
		$data['recent_comment'] = $this->Mdl_rnews->recent_comment();
		$data['adsense'] = $this->Mdl_admin->load_code();
		$this->load->view('vw_front',$data);
	}	
	public function archieve($month,$year)
	{
		$this->load->model('Mdl_admin');
		$this->load->model('Mdl_rnews');
		
	
		$data['link'] = $this->Mdl_admin->load_link();
		$this->load->model('Mdl_admin');
		$data['vw_home'] = 'vw_home';
		$data['msg'] = '';
		$data['settings'] = $this->Mdl_admin->load_settings();
		$data['slideshow'] = $this->Mdl_admin->load_slide();
		$data['category'] = $this->Mdl_admin->load_cat();
		$data['news'] = $this->Mdl_rnews->archieve_news($month,$year);
		$data['post'] = '0';
		$data['recent_news'] = $this->Mdl_rnews->recent_news();
		$data['recent_comment'] = $this->Mdl_rnews->recent_comment();
		$data['adsense'] = $this->Mdl_admin->load_code();
		if(count($data['news'])==0)
		{
			$data['msg'] = 'Sorry!! no news found!!';
			$data['msg_type'] = 'danger';
		}
		$this->load->view('vw_front',$data);
	}
	public function comments()
	{
		$id =$this->input->post('comment_news_fkey');
		$this->load->model('Mdl_admin');
		$data['link'] = $this->Mdl_admin->load_link();
		$this->load->model('Mdl_rnews');
		$data['vw_post'] = 'vw_post';
		$data['comment'] = $this->Mdl_rnews->write_comment();
		$data['settings'] = $this->Mdl_admin->load_settings();
		$data['category'] = $this->Mdl_admin->load_cat();
		$data['post'] = $this->Mdl_rnews->load_post($id);
		$data['recent_news'] = $this->Mdl_rnews->recent_news();
		$data['recent_comment'] = $this->Mdl_rnews->recent_comment();
		$data['adsense'] = $this->Mdl_admin->load_code();

		if($data['comment']==1)
		{
		$data['comment'] = $this->Mdl_rnews->load_comment($id);	
		$data['news'] = $this->Mdl_rnews->load_post($id);
		$data['settings'] = $this->Mdl_admin->load_settings();
		$data['category'] = $this->Mdl_admin->load_cat();
		
		}
		
		$this->load->view('vw_front',$data);
	}
	public function send_message()
	{
		$this->load->model('Mdl_rnews');
		$this->load->model('Mdl_admin');
		$data['vw_index'] = 'vw_index';
		$data['link'] = $this->Mdl_admin->load_link();
		$data['settings'] = $this->Mdl_admin->load_settings();
		$data['slideshow'] = $this->Mdl_admin->load_slide();
		$data['category'] = $this->Mdl_admin->load_cat();
		$data['news'] = $this->Mdl_rnews->load_news();
		$data['post'] = '0';
		$data['recent_news'] = $this->Mdl_rnews->recent_news();
		$data['recent_comment'] = $this->Mdl_rnews->recent_comment();
		$data['adsense'] = $this->Mdl_admin->load_code();
	
		$result = $this->Mdl_rnews->message();
		if($result==1)
		{
			$data['msg'] = 'Thank you for your message!!';
			$data['msg_type'] = 'success';
		}
		else
		{
			$data['msg'] = 'Sorry!! There Was a problem while sending your message.Try Again!!';
			$data['msg_type'] = 'danger';
		}
		
		$this->load->view('vw_front',$data);
	}
	// ## search
	public function search()
	{
		$this->load->model('Mdl_admin');
		$this->load->model('Mdl_rnews');
		
	
		$data['link'] = $this->Mdl_admin->load_link();
		$this->load->model('Mdl_admin');
		$data['vw_home'] = 'vw_search';
		$data['msg'] = '';
		$data['settings'] = $this->Mdl_admin->load_settings();
		$data['slideshow'] = $this->Mdl_admin->load_slide();
		$data['category'] = $this->Mdl_admin->load_cat();
		
		$data['recent_news'] = $this->Mdl_rnews->recent_news();
		$data['recent_comment'] = $this->Mdl_rnews->recent_comment();
		$data['adsense'] = $this->Mdl_admin->load_code();
		$data['news'] = $this->Mdl_rnews->search_result();
		$data['post'] = '0';
		if(count($data['news'])==0)
		{
			$data['msg'] = 'Sorry!! no news found!!';
			$data['msg_type'] = 'danger';
		}
		$this->load->view('vw_front',$data);
	
	}
}


