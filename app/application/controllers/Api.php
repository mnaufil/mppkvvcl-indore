<?php
if (isset($_SERVER['HTTP_ORIGIN'])) {

    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        // may also be using PUT, PATCH, HEAD etc
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}

require APPPATH . 'libraries/REST_Controller.php';

class Api extends REST_Controller {

     public function __construct() {
       parent::__construct();
       $this->load->database();
       $this->load->model('Login_Model');
      
    }

    public function checklogin_post()
    {  
        $email = trim($this->post()['email']);
        $password = trim($this->post()['password']);  
        $data = $this->Login_Model->index($email,$password);

        if ($data['status'] == 200) {
            $errors = null;
        } else {
            $errors = 'Login Failed';
        }

        $this->response([
            'errors'       => $errors,
            'message'      => $data['message'],
            'status_code'  => $data['status'],
            'data'         => $data
        ], REST_Controller::HTTP_OK);
    }
}