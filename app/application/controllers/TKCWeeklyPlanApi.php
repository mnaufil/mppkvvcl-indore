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

	public function filter_data_get()
	{
		$tkc_list = $this->twp_model->getContractorList();

		$circle_list = $this->twp_model->getCircleList();

		$circle_arr = [];
		foreach ($circle_list as $key => $value) {
			$circle_arr[$key]['name'] = $value['circle_name'];
			$circle_arr[$key]['value'] = $value['circle_id'];
		}

		$division_list = $this->twp_model->getDivisionList();

		$divisions_arr_temp = [];
		foreach ($division_list as $key => $value) {
			$divisions_arr_temp[$value['circle_id']][$key]['value'] = $value['division_id'];
			$divisions_arr_temp[$value['circle_id']][$key]['name'] = $value['division_name'];
		}

		$divisions_arr = [];
		foreach ($divisions_arr_temp as $key => $value) {
			$div_arr['circle_id'] = $key;
			$div_arr['divisions_list'] = array_values($value);

			array_push($divisions_arr, $div_arr);
		}

		$data['tkc'] = $tkc_list;
		$data['circles'] = $circle_arr;
		$data['divisions'] = $divisions_arr;

		$errors = null;
		$message = null;
		$status_code = 200;

		$this->response(['errors' => $errors, 'message' => $message, 'status_code' => $status_code, 'data' => $data], REST_Controller::HTTP_OK);
	}

	public function filter_weekly_plan_post()
	{
		if (!empty($this->post())) {
			$from_date = (!empty($this->post('from_date'))) ? date('Y-m-d', strtotime($this->post('from_date'))) : '';
			$to_date = (!empty($this->post('to_date'))) ? date('Y-m-d', strtotime($this->post('to_date'))) : '';
			$contractor = $this->post('contractor');
			$circle = $this->post('circle');
			$division = $this->post('division');
			$feeder_id = $this->post('feeder_id');

			$search_result = $this->twp_model->searchTKCWeeklyPlans($from_date, $to_date, $contractor, $circle, $division, $feeder_id);

			$result = [];
			foreach ($search_result as $key => $value) {
				$result[$value['tkc_plan_id']][] = $value;
			}

			$data = [];
			foreach ($result as $key => $value) {
				$temp_data = [];
				foreach ($value as $k => $v) {
					if ($k == 0) {
						$temp_data['from_date'] = date('d-m-Y', strtotime($v['from_date']));
						$temp_data['to_date'] = date('d-m-Y', strtotime($v['to_date']));
					}

					$temp_data['daily_plan'][$k]['formatted_date'] = date('d M Y', strtotime($v['plan_date']));
					$temp_data['daily_plan'][$k]['day'] = date('D', strtotime($v['plan_date']));
					$temp_data['daily_plan'][$k]['lot_no'] = $v['package_no'];
					$temp_data['daily_plan'][$k]['tkc'] = $v['contractor_name'];
					$temp_data['daily_plan'][$k]['circle'] = $v['circle_name'];
					$temp_data['daily_plan'][$k]['division'] = $v['division_name'];
					$temp_data['daily_plan'][$k]['feeder'] = $v['feeders'];
					$temp_data['daily_plan'][$k]['description'] = $v['description'];
					$temp_data['daily_plan'][$k]['remark'] = $v['remark'];
				}

				array_push($data, $temp_data);
			}

			$errors = null;
			$message = null;
			$status_code = 200;			
		} else {
			$errors = 'Invalid Parameters';
            $message = 'POST Request has no arguments';
            $status_code = 400;
            $data = [];
		}

		$this->response(['errors' => $errors, 'message' => $message, 'status_code' => $status_code, 'data' => $data], REST_Controller::HTTP_OK);
	}
}





?>