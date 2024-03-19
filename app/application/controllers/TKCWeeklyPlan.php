<?php defined('BASEPATH') OR exit('No direct script access allowed');

class TKCWeeklyPlan extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('TKCWeeklyPlan_Model', 'twp_model');

		if(!$this->session->isUserLoggedIn)
        { 
        	redirect('login'); 
        }
	}

	public function index()
	{
		$data['title'] = 'TKC Weekly Plan';

		$user_id = $_SESSION['loggedData']->user_id;
		$user_role = $this->twp_model->getUserRoleName($user_id);

		$result = $this->twp_model->getTKCWeeklyPlanDateRanges($user_id);

		foreach ($result as $key => $value) {
			$result[$key]['date_range'] = date('d-m-Y', strtotime($value['from_date'])).' - '.date('d-m-Y', strtotime($value['to_date']));
			$result[$key]['draft_status'] = ($value['is_draft'] == 0) ? 'Full Week Plan' : 'Draft';
		}

		$user_access_data = $this->twp_model->getUserModuleAccess();
      	$user_access = $this->sortUserModuleAccess($user_access_data);

		$data['result'] = $result;
		$data['user_access'] = $user_access;
		$data['user_role'] = $user_role;

		// echo 'data: <pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('tkc-weekly-plan/tkc-weekly-plan', $data);
	}

	public function addTKCWeeklyPlan()
	{
		$package_group_no = $_SESSION['loggedData']->package_access;
		$lot_nos = $this->twp_model->getLotNoFromPackageGroupNo($package_group_no);
		$data['packages'] = $lot_no_arr = implode(',', $lot_nos);

		$data['circles'] = $circles = $this->twp_model->getCirclesAssignedToTKC($lot_no_arr);
		$divisions = $this->twp_model->getCircleWiseDivision($circles);

		$divisions_arr = [];
		foreach ($divisions as $key => $value) {
			$divisions_arr[$value['circle_name']][] = $value['division_name'];
		}

		$data['divisions'] = $divisions_arr;

		$data['title'] = 'TKC Weekly Plan';

		// echo '<pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('tkc-weekly-plan/add-tkc-weekly-plan-new', $data);
	}

	public function saveTKCWeeklyPlan()
	{
		// Default Response
		http_response_code(200);
      	$response['message'] = 'Saved TKC Weekly Plan successfully';

      	if (!empty($_POST)) {
      		$week_date_range = $this->input->post('weeklyPlanDateRange');
      		$contractor = $this->input->post('contractorTKC');
      		$weekly_plan_array = json_decode($this->input->post('weekly_plan_array'));

      		$is_draft = $this->input->post('is_draft');

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
      					$feeder = $value->feeder;

      					if ($feeder) {
      						$feeders_list = explode(', ', $feeder);

      						foreach ($feeders_list as $key => $value) {
      							$contract_location_id = $this->twp_model->getContractLocationIDByFeederID($value);

      							// Saving data in tkc_plan_detail_feeder
		      					$tkc_plan_detail_feeder_id = $this->twp_model->saveTKCWeeklyPlanFeederDetails($tkc_plan_detail_id, $contract_location_id);

		      					if (!$tkc_plan_detail_feeder_id) {
		      						http_response_code(400);
			      					$response['message'] = 'Error saving data in tkc_plan_detail_feeder';	
		      					}
      						}
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

      	echo json_encode($response);
	}

	public function editTKCWeeklyPlan($mode, $tkc_plan_id)
	{
		$user_id = $_SESSION['loggedData']->user_id;
		$user_role = $this->twp_model->getUserRoleName($user_id);		

		$result = $this->twp_model->getTKCWeeklyPlanDetails($tkc_plan_id);

		$result['tkc_plan_id'] = $tkc_plan_id;

		if ($user_role == 'TKC') {
			$package_group_no = $_SESSION['loggedData']->package_access;
			$lot_nos = $this->twp_model->getLotNoFromPackageGroupNo($package_group_no);
			$data['packages'] = $lot_no_arr = implode(',', $lot_nos);

			$data['circles'] = $circles = $this->twp_model->getCirclesAssignedToTKC($lot_no_arr);

			$divisions = $this->twp_model->getCircleWiseDivision($circles);

			$divisions_arr = [];
			foreach ($divisions as $key => $value) {
				$divisions_arr[$value['circle_name']][] = $value['division_name'];
			}

			$data['divisions'] = $divisions_arr;
		}		

		$data['result'] = $result;
		$data['mode'] = $mode;
		$data['title'] = ucfirst($mode).' TKC Weekly Plan';

		// echo '<pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('tkc-weekly-plan/edit-tkc-weekly-plan', $data);
	}

	public function updateTKCWeeklyPlan()
	{
		// Default Response
		http_response_code(200);
      	$response['message'] = 'Updated TKC Weekly Plan successfully';

      	if (!empty($_POST)) {
      		$tkc_plan_id = $this->input->post('tkc_plan_id');
      		$week_date_range = $this->input->post('weeklyPlanDateRange');
      		$weekly_plan_array = json_decode($this->input->post('weekly_plan_array'));
      		$deleted_plan_detail_ids = isset($_POST['deleted_plan_detail_ids']) ? explode(',', $this->input->post('deleted_plan_detail_ids')) : '';

      		$is_draft = $this->input->post('is_draft');

      		$week_date_arr = explode(' - ', $week_date_range);
      		$from_date = $week_date_arr[0];
      		$to_date = $week_date_arr[1];

      		// Updating data in tkc_plan
      		$tkc_plan_result = $this->twp_model->updateTKCWeeklyPlan($tkc_plan_id, $from_date, $to_date, $is_draft);

      		if ($tkc_plan_result) {
      			if (!empty($deleted_plan_detail_ids)) {
      				foreach ($deleted_plan_detail_ids as $value) {
      					// Check if feeders details exists against tkc_plan_detail_id
						$feeders_result = $this->twp_model->getTKCWeeklyPlansFeederDetailsForTKCWeeklyDetailID($value);

						if (!empty($feeders_result)) {
							// Updating delete status of the feeders
							$feeders_deleted =  $this->twp_model->deleteFeedersDetailsByTKCPLanDetailID($value);
						}

      					// Updating delete status of the weekly plan details
      					$details_deleted = $this->twp_model->deleteWeeklyPlanDetailsByTKCPlanDetailsID($value);
      				}
      			}

      			foreach ($weekly_plan_array as $key => $value) {
      				$lot_no = trim($value->lot_no);
      				$contract_id = $this->twp_model->getContractIDFromLotNo($lot_no);
      				$date_of_work = date('Y-m-d', strtotime($value->date_of_work));

      				$circle_id = (!empty($value->circle)) ? $this->twp_model->getCircleID(trim($value->circle)) : $value->circle;
      				$division_id = (!empty($value->division)) ? $this->twp_model->getDivisionID(trim($value->division)) : $value->division;

      				$work_description = trim($value->description_of_work);
      				$remark = trim($value->remark);

      				if (isset($value->tkc_plan_detail_id)) {
      					// Updating data in tkc_plan_detail
      					$tkc_plan_detail_id = $this->twp_model->updateTKCWeeklyPlanDetails($value->tkc_plan_detail_id, $tkc_plan_id, $contract_id, $date_of_work, $circle_id, $division_id, $work_description, $remark);	
      				} else {
      					// Saving data in tkc_plan_detail
      					$tkc_plan_detail_id = $this->twp_model->saveTKCWeeklyPlanDetails($tkc_plan_id, $contract_id, $date_of_work, $circle_id, $division_id, $work_description, $remark);	
      				}

      				if ($tkc_plan_detail_id) {
      					$feeder = $value->feeder;

      					if ($feeder) {
      						$feeders_list = explode(', ', $feeder);

      						foreach ($feeders_list as $f_value) {
      							// Check if feeder details exist in tkc_plan_detail_feeder
      							$check_feeder_exists = $this->twp_model->checkFeederDetailsExists($tkc_plan_detail_id, $f_value);

      							if (empty($check_feeder_exists)) {
      								$contract_location_id = $this->twp_model->getContractLocationIDByFeederID($f_value);

      								// Saving data in tkc_plan_detail_feeder
									$tkc_plan_detail_feeder_id = $this->twp_model->saveTKCWeeklyPlanFeederDetails($tkc_plan_detail_id, $contract_location_id);
      							}
      						}
      					}      					
      				}
      			}
      		}
      	} else {
      		http_response_code(400);
      		$response['message'] = 'No Input';
      	}

      	echo json_encode($response);
	}

	public function deleteTKCWeeklyPlan($tkc_plan_id)
	{
		// Fetching records from tkc_plan_detail against the $tkc_plan_id
		$details_result = $this->twp_model->getTKCWeeklyPlanDetailsForTKCWeeklyID($tkc_plan_id);

		foreach ($details_result as $key => $value) {
			// Check if feeders details exists against tkc_plan_detail_id
			$feeders_result = $this->twp_model->getTKCWeeklyPlansFeederDetailsForTKCWeeklyDetailID($value['tkc_plan_detail_id']);

			if (!empty($feeders_result)) {
				// Updating delete status of the feeders
				$feeders_deleted =  $this->twp_model->deleteFeedersDetailsByTKCPLanDetailID($value['tkc_plan_detail_id']);
			}
		}

		// Updating delete status of the weekly plan details
		$details_deleted = $this->twp_model->deleteWeeklyPlanDetailsByTKCPlanID($tkc_plan_id);

		if ($details_deleted) {
			// Updating delete status of the weekly plan
			$plan_deleted = $this->twp_model->deleteTKCWeeklyPlan($tkc_plan_id);
		}

		redirect('tkc-weekly-plan');
	}

	public function checkDateRangeExists()
	{
		$response['date_range_result'] = [];
		if (!empty($_POST)) {
			$from_date = date('Y-m-d', strtotime($this->input->post('from_date')));
			$to_date = date('Y-m-d', strtotime($this->input->post('to_date')));

			$user_id = $_SESSION['loggedData']->user_id;

			$result = $this->twp_model->getDateRangeExists($user_id, $from_date, $to_date);

			if (!empty($result)) {
				$response['date_range_result'] = $result;
			}
		}

		echo json_encode($response);
	}

	public function sortCircleWiseDivisionData($circle_wise_division_data)
	{
		$sorted_circle_wise_division_data = [];
		foreach ($circle_wise_division_data as $key => $value) {
			$sorted_circle_wise_division_data[$value['circle_name']][] = $value['division_name'];
		}

		return $sorted_circle_wise_division_data;
	}

	public function getFeedersList()
	{
		$response['feeder_list'] = [];

		if (!empty($_POST)) {
			$circle_name = $this->input->post('circle_name');
			$division_name = $this->input->post('division_name');

			$circle_id = $this->twp_model->getCircleID($circle_name);
			$division_id = $this->twp_model->getDivisionID($division_name);

			$response['feeder_list'] = $this->twp_model->getCircleDivisionWiseFeederList($circle_id, $division_id);
		}

		echo json_encode($response);
	}

	public function sortUserModuleAccess($user_access_data)
	{
	    $user_access = [];
	    foreach ($user_access_data as $key => $value) {
	    	switch ($value['event']) {
	        	case 'view':
	            	$user_access['view'] = 1;
	                break;
                case 'update':
	            	$user_access['update'] = 1;
	                break;
                case 'download':
	            	$user_access['download'] = 1;
	                break;
                case 'add':
	            	$user_access['add'] = 1;
	                break;
                case 'delete':
	            	$user_access['delete'] = 1;
	                break;                    
                default:
	            	break;
           	}
	    }

	    return $user_access;
	}
}























?>