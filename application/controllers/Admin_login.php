<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_login extends CI_Controller {

	function __construct() {
        parent::__construct();
        /* chk user logged in or not*/
        if($this->session->userdata('admin_logged_in'))
        {
        	redirect('admin');
        }
    }

    public function index(){
    	$this->load->view('vw_login');
    }

    public function do_login(){
    	
    	$this->load->model('Mdl_admin');
    	$username = $this->input->post('username');
    	$password = $this->input->post('password');

    	$this->form_validation->set_rules('username','Username','required');
    	$this->form_validation->set_rules('password','Password','required');

    	if($this->form_validation->run()==FALSE)
           
    	{   
            
    		$this->load->view('vw_login');
    	}

    	else
    	{
            $this->load->library('encrypt');
            $enc_password = md5($password);
    		$is_valid = $this->Mdl_admin->validate($username,$enc_password);
            if($is_valid){
               
            redirect('admin');
            }
            else
            {
                $data['msg_type'] = 'class="alert alert-error" ';
                $data['msg'] = '*Invalid Username or Password';
                $this->load->view('vw_login',$data);
            }
    		
    	
    	}

    }

    }

