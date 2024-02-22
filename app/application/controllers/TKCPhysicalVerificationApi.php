<?php error_reporting(E_ERROR | E_PARSE);

if (isset($_SERVER['HTTP_ORIGIN'])) {
	header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
	header('Access-Control-Allow-Credentials: true');
	header('Access-Control-Max-Age: 86400');    // cache for 1 day	
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
		// may also be using PUT, PATCH, HEAD etc
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
	}

	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
		header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
	}

	exit(0);
}

require APPPATH.'libraries/REST_Controller.php';

class TKCPhysicalVerificationApi extends REST_Controller
{	
	function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->model('TKCPhysicalVerification_Model', 'tpv_model');
	}

	public function index_get()
	{
		if (!empty($this->get())) {
			$user_id = $this->get('user_id');
            $limit = $this->get('limit');
            $offset = 0;

            $result = $this->tpv_model->getPhysicalVerificationSheets($user_id);
            // echo 'result: <pre>'; print_r($result); echo '</pre>'; die();

            foreach ($result as $key => $value) {
            	$work_completion = ($value['tt_task'] != 0) ? ((int)$value['cc_task'] / (int)$value['tt_task']) * 100 : '';
            	$result[$key]['work_completion'] = ($work_completion == 0 || $work_completion == 100 || $work_completion == '') ? $work_completion : round($work_completion);
            }

            $data['result'] = $result;

            $errors = null;
            $message = (empty($result)) ? 'No access to feeders' : null;
            $status_code = 200;            
		} else {
			$errors = 'Empty GET Request';
            $message = 'GET Request has no arguments';
            $status_code = 400;
            $data = [];
		}

		$this->response(['errors' => $errors, 'message' => $message, 'status_code' => $status_code, 'data' => $data], REST_Controller::HTTP_OK);
	}
}



?>