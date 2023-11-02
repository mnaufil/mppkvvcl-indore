<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Setsession extends CI_Controller
{
	function __construct()
    {
		parent::__construct();

        	$this->load->model('Session_Model');
        
        	if(!$this->session->isUserLoggedIn)
        	{ 
             	redirect('login'); 
        	}
	}


	public function generatesession()
	{
		$this->Session_Model->generatesession();
	}


	public function viewsession()
	{
		$this->Session_Model->viewsession();
	}

	public function destroysession()
	{
		$this->Session_Model->destroysession();
	}
}