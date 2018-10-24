<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_logout extends CI_Controller {

	function __construct() {
        parent::__construct();
      //  $this->load->model('home_model');
		/* chk user logged in or not*/
		if(!$this->session->userdata('admin_logged_in'))
		{
			redirect('Admin_login');
		}
		
    }
	
    public function index()
    {
    	$this->session->sess_destroy();
    	redirect('Admin_login');
    }
}