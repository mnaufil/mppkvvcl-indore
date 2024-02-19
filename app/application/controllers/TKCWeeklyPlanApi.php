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

/**
 * 
 */
class TKCWeeklyPlanApi extends REST_Controller
{
	
	function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->model('TKCWeeklyPlan_Model', 'twp_model');
	}

	public function index_get()
	{
		$from_date = (date('D') != 'Mon') ? date('Y-m-d', strtotime('last Monday')) : date('Y-m-d');
		$to_date = (date('D') != 'Sun') ? date('Y-m-d', strtotime('next Sunday')) : date('Y-m-d');

		$tkc_plan_result = $this->twp_model->getTKCWeeklyPlans($from_date, $to_date);

		$data = [];
		foreach ($tkc_plan_result as $key => $value) {

			if ($key == 0) {
				$data['from_date'] = date('d-m-Y', strtotime($value['from_date']));
				$data['to_date'] = date('d-m-Y', strtotime($value['to_date']));
			}

			$data['daily_plan'][$key]['formatted_date'] = date('d M Y', strtotime($value['plan_date']));
			$data['daily_plan'][$key]['day'] = date('D', strtotime($value['plan_date']));
			$data['daily_plan'][$key]['lot_no'] = $value['package_no'];
			$data['daily_plan'][$key]['tkc'] = $value['contractor_name'];
			$data['daily_plan'][$key]['circle'] = $value['circle_name'];
			$data['daily_plan'][$key]['division'] = $value['division_name'];
			$data['daily_plan'][$key]['feeder'] = $value['feeders'];
			$data['daily_plan'][$key]['description'] = $value['description'];
			$data['daily_plan'][$key]['remark'] = $value['remark'];
		}

		$errors = null;
        $message = (empty($result)) ? 'No TKC Weekly Plans' : null;
        $status_code = 200;

        $this->response(['errors' => $errors, 'message' => $message, 'status_code' => $status_code, 'result' => $data], REST_Controller::HTTP_OK);
	}
}





?>