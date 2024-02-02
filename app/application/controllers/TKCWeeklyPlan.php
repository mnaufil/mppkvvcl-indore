<?php defined('BASEPATH') OR exit('No direct script access allowed');

class TKCWeeklyPlan extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('TKCWeeklyPlan_Model', 'twp_model');
	}

	public function index()
	{
		$data['title'] = 'TKC Weekly Plan';
		// echo 'data: <pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('tkc-weekly-plan/tkc-weekly-plan', $data);
	}

	public function addTKCWeeklyPlan()
	{
		$data['packages'] = $this->twp_model->getPackages();

		$user_circles_ids = $_SESSION['myCircles'];
		$data['circles'] = $this->twp_model->getCirclesAssignedToUser($user_circles_ids);

		$user_divisions_ids = $_SESSION['myDivision'];
		$data['divisions'] = $this->twp_model->getDivisionsAssignedToUser($user_divisions_ids);

		$data['contractor_name'] = $_SESSION['loggedData']->username;
		// echo '<pre>'; print_r($_SESSION); echo '</pre>'; die();


		// echo '<pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('tkc-weekly-plan/add-tkc-weekly-plan', $data);
	}

	public function saveTKCWeeklyPlan()
	{
		// Default Response
		http_response_code(200);
      	$response['message'] = 'Save TKC Weekly Plan success';

      	if (!empty($_POST)) {
      		$week_date_range = $this->input->post('weeklyPlanDateRange');
      		$contractor = $this->input->post('contractorTKC');
      		$weekly_plan_array = json_decode($this->input->post('weekly_plan_array'));

      		$is_draft = 0;

      		$week_date_arr = explode(' - ', $week_date_range);
      		$from_date = $week_date_arr[0];
      		$to_date = $week_date_arr[1];

      		// Saving data in tkc_plan
      		$tkc_plan_id = $this->twp_model->saveTKCWeeklyPlan($from_date, $to_date, $is_draft);
      		if ($tkc_plan_id) {
      			foreach ($weekly_plan_array as $key => $value) {
      				$lot_no = $value->lot_no;
      				$contract_id = $this->twp_model->getContractIDFromLotNo($lot_no);
      				$date_of_work = date('Y-m-d', strtotime($value->date_of_work));

      				$circle_id = (!empty($value->circle)) ? $this->twp_model->getCircleID($value->circle) : $value->circle;
      				$division_id = (!empty($value->division)) ? $this->twp_model->getDivisionID($value->division) : $value->division;

      				$work_description = $value->description_of_work;
      				$remark = $value->remark;

      				// Saving data in tkc_plan_detail
      				$tkc_plan_detail_id = $this->twp_model->saveTKCWeeklyPlanDetails($tkc_plan_id, $contract_id, $date_of_work, $circle_id, $division_id, $work_description, $remark);

      				if ($tkc_plan_detail_id) {
      					$site_location = $value->site_location;
      					$contract_location_id = $this->twp_model->getContractLocationIDBySite($site_location);

      					// Saving data in tkc_plan_detail_feeder
      					$tkc_plan_detail_feeder_id = $this->twp_model->saveTKCWeeklyPlanFeederDetails($tkc_plan_detail_id, $contract_location_id);

      					if (!$tkc_plan_detail_feeder_id) {
      						http_response_code(400);
	      					$response['message'] = 'Error saving data in tkc_plan_detail_feeder';	
      					}
      				} else {
      					http_response_code(400);
      					$response['message'] = 'Error saving data in tkc_plan_detail';
      				}
      			}
      			
      		} else {
      			http_response_code(400);
      			$response['message'] = 'Error saving data in tkc_plan';
      		}
      	} else {
      		http_response_code(400);
      		$response['message'] = 'No Input';
      	}
	}
}























?>