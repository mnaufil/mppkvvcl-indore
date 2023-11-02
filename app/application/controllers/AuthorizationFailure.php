<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class AuthorizationFailure extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->output->set_status_header('403');

		$data['heading']  = "Authorization Failure";
		$data['message']  = "You don't have access to this record. Ask your administrator for help or request for access";

		$this->load->view('errors/html/error_authorization_failure', $data);
	}
}

?>