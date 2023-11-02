<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Custom404 extends CI_Controller
{
	function __construct()
    {
      parent::__construct();
    }

    public function index()
    {
       $this->output->set_status_header('404');
       
          $data['heading']  = "Page Not Found";
          $data['message']  = "The Page you are requested is not found.";
   		    $this->load->view('errors/html/error_404', $data);

    }

}