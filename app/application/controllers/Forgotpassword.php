<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Forgotpassword extends CI_Controller
{
	
	function __construct()
    {
        parent::__construct();
        //$this->load->database('mpp');
    }

	public function forgotpassword()
	{
		$this->load->view('forgot-password/forgot-password'); 
	}

}