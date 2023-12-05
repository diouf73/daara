<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class User extends CI_Controller {
 
	public function __construct()
    {
        parent::__construct();
        //initialisation de la session
		$this->load->helper('url');
		$this->load->model('users_model');
      
    }

 
	public function index(){
		//load session library
		$this->load->library('session');
 
		//restrict users to go back to login if session has been set
		if($this->session->userdata('user')){
			redirect('home');
		}
		else{
			$this->load->view('dash/login');
			
		}
	}
 
	public function login(){
		//$suite_req = site_url();
		//load session library
		$this->load->library('session');
 
		$email = $_POST['email'];
		$password = $_POST['password'];
		$data = $this->users_model->login($email,$password);
		
		if($data){
			$this->session->set_userdata('user', $data);
			$this->load->view('template/layout');
		}
		else{
			//header("Location:".$suite_req."home");
			header('location:'.base_url().$this->index());
			$this->session->set_flashdata('error','revoyez votre email ou paasword');
		}
		 
	}
 
	public function home(){
		//load session library
		$this->load->library('session');
 
		//restrict users to go to home if not logged in
		if($this->session->userdata('user')){
			$this->load->view('template/layout');
		}
		else{
			redirect('/');
		}
 
	}
 
	// public function logout(){
	// 	//load session library
	// 	$this->load->library('session');
	// 	$this->session->unset_userdata('user');
	// 	redirect('/');
	// }


	public function se_deconnecter()
    {
        $suite_req = site_url();

        $this->session->sess_destroy();	// destruction des donnees de la session
        header("Location:".$suite_req."user");
    }
 
}