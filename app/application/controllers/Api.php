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

class Api extends REST_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('Login_Model');
        // $this->load->library('Authentication');
    }

    public function checklogin_post()
    {  
        $email = trim($this->post()['email']);
        $password = trim($this->post()['password']);

        // $this->authentication->authenticateUser($email, $password);
        $data = $this->Login_Model->index($email,$password);            

        if ($data['status'] == 200) {
            $user_rolename = $this->Login_Model->getRoleNameByRoleID($data['userdetails']->role_id);
            $data['userdetails']->user_rolename = $user_rolename;    

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

    public function getMobileAPKDetails_get()
    {
        $result = $this->Login_Model->getMobileAPKDetails();

        $data = [];
        foreach ($result as $key => $value) {
            if ($value['display_name'] == 'apk_url_link') {
                $data[$value['display_name']] = base_url($value['fieldvalue']);
            } else {
                $data[$value['display_name']] = $value['fieldvalue'];
            }
        }

        $errors = null;
        $message = null;
        $status_code = 200;

        $this->response(['errors' => $errors, 'message' => $message, 'status_code' => $status_code, 'data' => $data], REST_Controller::HTTP_OK);
    }


}