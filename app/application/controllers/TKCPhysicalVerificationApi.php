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

	public function get_tkc_ppsheet_details_post()
	{
		if (!empty($this->post())) {
			$logged_user_role_id = $this->post('logged_user_role_id');
			$tkc_ppsheet_id = $this->post('physical_progress_id');
			$prev_tkc_ppsheet_id = $this->post('prev_tkc_physical_progress_id');
			$contract_id = $this->post('contract_id');
			$contract_location_id = $this->post('contract_location_id');
			$reported_date = (!empty($this->post('reported_date'))) ? date('Y-m-d', strtotime($this->post('reported_date'))) : '';
			$sheet_status_id = $this->post('sheet_status_id');
            $day = $this->post('day');

            $reported_date = ($sheet_status_id == 1) ? '' : $reported_date;

            $mode = 'edit-new';
            $type = 'API';

            $tkc_pp_id = (empty($tkc_ppsheet_id)) ? $prev_tkc_ppsheet_id : $tkc_ppsheet_id;

            $sheet_result = $this->tpv_model->getSheetDetail($mode, $tkc_pp_id, $contract_id, $contract_location_id, $reported_date, $type);
            $sheet_result['reported_date'] = (!empty($sheet_result['reported_date'])) ? date('d-m-Y', strtotime($sheet_result['reported_date'])) : "";

            $sheet_result['reported_by'] = (!empty($tkc_ppsheet_id)) ? $sheet_result['reported_by'] : '';
            $sheet_result['reported_by_name'] = $this->tpv_model->getReportedByName($sheet_result['reported_by']);

            $sheet_result['geo_location_radius'] = $this->tpv_model->getGeoLocationRadius();

            /*Formatting Tender Award Date*/
            $award_date = date("d-m-Y", strtotime($sheet_result['tender_award_date']));
            $sheet_result['tender_award_date'] = $award_date;

            $sheet_result['task_ratio'] = $task_ratio = $this->calculateTaskRatio($sheet_result, $mode);
            $task_arr = explode('/', $task_ratio);
            $task['cc_task'] = $task_arr[0];
            $task['tt_task'] = $task_arr[1];

            $work_completion = ($task['tt_task'] != 0) ? ((int)$task['cc_task'] / (int)$task['tt_task']) * 100 : '';
            $sheet_result['work_completion'] = ($work_completion == 0 || $work_completion == 100 || $work_completion == '') ? $work_completion : round($work_completion);

            if (!empty($sheet_result['activities_list'])) {
                $activities_list = $this->sortByActivities($sheet_result['activities_list'], $sheet_result['activities_group_name']);
                $sheet_result['activities_list'] = $activities_list;
            }

            $sheet_result['mode'] = (($reported_date == date('Y-m-d')) || ($reported_date == '') || $day == 'today') ? 'new' : 'previous';

            $data['sheet_data'] = $sheet_result;
            $data['userdata'] = $this->getUserData($logged_user_role_id);

            $errors = null;
            $message = null;
            $status_code = 200;
		} else {
			$errors = 'Empty POST Request';
            $message = 'POST Request has no arguments';
            $status_code = 400;
            $data = [];
		}

		$this->response(['errors' => $errors, 'message' => $message, 'status_code' => $status_code, 'data' => $data], REST_Controller::HTTP_OK);
	}

	public function get_tkc_previous_sheet_dates_post()
	{
		if (!empty($this->post())) {
			$contract_id = $this->post('contract_id');
			$contract_location_id = $this->post('contract_location_id');
			$site_location = $this->post('site_location');

			$previous_sheet_data = $this->tpv_model->getPrevSheetDates($contract_id, $contract_location_id, $site_location);

			$errors = null;
            $message = 'Applied Observation Details';
            $status_code = 200;

            $data['previous_dates'] = $previous_sheet_data; 
		} else {
			$errors = 'Empty POST Request';
            $message = 'POST Request has no arguments';
            $status_code = 400;
            $data = [];
		}

		$this->response(['errors' => $errors, 'message' => $message, 'status_code' => $status_code, 'data' => $data], REST_Controller::HTTP_OK);
	}

	public function save_tkc_ppsheet_details_post()
	{
		if (!empty($this->post())) {
			$user_id = $this->post('user_id');

			$tkc_pp_id = $this->post('tkc_physical_progress_id');
			$prev_tkc_pp_id = $this->post('prev_tkc_physical_progress_id');
			$reported_by = $this->post('reported_by');
			$reported_date = date('Y-m-d', strtotime($this->post('reported_date')));
			$geo_code = $this->post('geo_code');
			$sheet_remark = $this->post('sheet_remark');
			$activities = $this->post('activities');

			//Fetching sheet details using prev_tkc_pp_id
			$prev_sheet_data = $this->tpv_model->getPreviousSheetDataAPI($prev_tkc_pp_id);

			$status_id = 2;
            $is_draft = 0;

            //In case sheet is being saved, without saving any observations
            if ((empty($tkc_pp_id)) || $tkc_pp_id == NULL) {
            	//Saving the sheet and fetching the new physical_progres_id
            	$tkc_pp_id = $this->tpv_model->saveTKCPhysicalVerificationSheet($prev_sheet_data['contract_id'], $prev_sheet_data['contract_location_id'], $prev_sheet_data['site_location'], $reported_by, $reported_date, $sheet_remark, $status_id, $is_draft, $geo_code, $user_id);
            } else {
            	$tkc_pp_id = $this->tpv_model->updateTKCPhysicalVerificationSheet($tkc_pp_id, $prev_sheet_data['contract_id'], $prev_sheet_data['contract_location_id'], $prev_sheet_data['site_location'], $reported_by, $reported_date, $geo_code, $sheet_remark, $status_id, $is_draft, $user_id);
            }

            if ($tkc_pp_id) {
            	$remaining_activity_count = 0;
            	foreach ($activities as $value) {
            		foreach ($value['tab_body'] as $act_key => $act_value) {
            			$activity_id = $act_value['activity_id'];
            			$erected_qty = (isset($act_value['erected_qty']) && is_numeric($act_value['erected_qty'])) ? $act_value['erected_qty'] : NULL;

            			//Calculating the pending activities
            			if ($act_value['status_id'] == 0 || $act_value['status_id'] == 4) {
            				$remaining_activity_count++;
            			}

            			//Checking if activity already exists
                        $activity_check_result = $this->tpv_model->checkActivity($activity_id, $tkc_pp_id);

                        if (empty($activity_check_result)) {
                        	//Inserting sheet activity details
                            $affected_row = $this->tpv_model->saveActivityAPI($tkc_pp_id, $act_value['seqno'], $activity_id, $act_value['unit_id'], $act_value['status_id'], $erected_qty, $user_id);
                        } else {
                        	//Updating sheet activity details
                            $affected_row = $this->tpv_model->updateActivity($tkc_pp_id, $activity_id, $act_value['status_id'], $erected_qty);
                        }
            		}
            	}

            	$alert_message = '';
            	if ($remaining_activity_count == 0) {
                	//Updating the status of physical progress sheet to Completed
                	$pp_status_ids = $this->tpv_model->getStatusList();
                	$pp_status_ids = $this->modify_pp_status_ids($pp_status_ids);

                	$alert_message = 'Physical Progress Sheet saved and marked as completed successfully';
                }

                $errors = null;
                $message = (empty($alert_message)) ? 'Physical Verification Sheet saved successfully' : $alert_message;
                $status_code = 200;
                $data = array('tkc_physical_progress_id' => $tkc_pp_id);
            }
		} else {
			$errors = 'Empty POST Request';
            $message = 'POST Request has no arguments';
            $status_code = 400;
            $data = [];
		}

		$this->response(['errors' => $errors, 'message' => $message, 'status_code' => $status_code, 'data' => $data], REST_Controller::HTTP_OK);
	}

	public function tkc_filter_data_post()
	{
		if (!empty($this->post())) {
			$user_id = $this->post('user_id');

			$type_of_work = $this->tpv_model->getTypeOfWorkList($user_id);
			$region_list = $this->tpv_model->getRegionList($user_id);
			$region_circle_data = $this->tpv_model->getRegionCircleData($user_id);
			$circle_list = $this->modifyRegionCircleData($region_circle_data);

			$circle_division_data = $this->tpv_model->getCircleDivisionData($user_id);
			$division_list = $this->modifyCircleDivisionData($circle_division_data);

			$status_list = $this->tpv_model->getStatusList();

			$data['work_list'] = (!empty($type_of_work)) ? $type_of_work : [];
            $data['region_list'] = (!empty($region_list)) ? $region_list : [];
            $data['circle_list'] = (!empty($circle_list)) ? $circle_list : [];
            $data['division_list'] = (!empty($division_list)) ? $division_list : [];
            $data['status_list'] = (!empty($status_list)) ? $status_list : [];

			$errors = null;
            $message = null;
            $status_code = 200;
			
		} else {
			$errors = 'Empty POST Request';
            $message = 'POST Request has no arguments';
            $status_code = 400;
            $data = [];
		}

		$this->response(['errors' => $errors, 'message' => $message, 'status_code' => $status_code, 'data' => $data], REST_Controller::HTTP_OK);
	}

	public function calculateTaskRatio($site, $mode, $reported_date = NULL)
	{
		$activities_result = $this->tpv_model->getActivitiesList($site['typeofwork_id'], NULL);

		$task_ratio = '-';

		if (!empty($activities_result)) {
			$activities_count = count($activities_result);
			$tkc_pp_id = ($mode == 'edit-prev' && empty($reported_date)) ? $site['prev_tkc_physical_progress_id'] : $site['tkc_physical_progress_id'] ;

			$applied_activities_result = $this->tpv_model->getAppliedActivitiesList($tkc_pp_id, $site['contract_location_id']);

			$applied_activities_count = 0;

			if (!empty($applied_activities_result)) {
				foreach ($applied_activities_result as $key => $value) {
					if ($value['status_id'] == 3) {
						$applied_activities_count++;
					} elseif ($value['status_id'] == 1) {
						$applied_activities_count++;
					}
				}
			}

			$task_ratio = $applied_activities_count .' / '.$activities_count;
		}

		return $task_ratio;
	}

	public function sortByActivities($list, $group_name)
    {
        $activities_arr = [];
        $sorted_activities_arr = [];

        foreach ($group_name as $g_key => $g_value) {
            $activities_arr[$g_key]['is_boq'] = [];
            $activities_arr[$g_key][$g_value['name']] = [];
            foreach ($list as $l_key => $l_value) {
                if ($g_value['is_boq'] == $l_value['is_boq']) {
                    $activities_arr[$g_key]['is_boq'] = $l_value['is_boq'];
                }
                if ($g_value['name'] == $l_value['activity_group_name']) {
                    array_push($activities_arr[$g_key][$g_value['name']], $l_value);
                }
            }
        }

        foreach ($activities_arr as $key => $value) {
            $sorted_arr = [];

                $tab_name = '';
                foreach (array_slice($value, 1) as $k1 =>  $v1) {
                    $tab_name = $k1;
                    $sort_arr = $this->sort_array_by_key($v1, 'seqno');
                    array_push($sorted_arr, $sort_arr);
                }

                $sorted_activities_arr[$key]['is_boq'] = $value['is_boq'];
                $sorted_activities_arr[$key]['tab_name'] = $tab_name;
                $sorted_activities_arr[$key]['tab_body'] = $sorted_arr[0];
                // $sorted_activities_arr[$key] = $sorted_arr;
        }
        
        return $sorted_activities_arr;
    }

    public function getUserData($role_id)
    {
        $userrole = $this->tpv_model->getUserRole($role_id);
          
        // $userdata['username'] = $username;
        $userdata['role'] = $userrole;

        return $userdata;
    }

    public function modifyRegionCircleData($region_circle_data)
    {
    	$modified_region_circle_arr = [];
        $final_modified_region_circle_arr = [];
        $temp_arr = [];

        foreach ($region_circle_data as $key => $value) {
            $modified_region_circle_arr[$value['region_id']][$value['circle_id']] = $value['circle_name'];
        }

        foreach ($modified_region_circle_arr as $key => $value) {
            $temp_arr['region_id'] = $key;
            $temp_arr['data'] = [];
            foreach ($value as $k => $v) {
                array_push($temp_arr['data'], array('circle_id' => $k, 'circle_name' => $v));
            }

            array_push($final_modified_region_circle_arr, $temp_arr);
        }

        return $final_modified_region_circle_arr;
    }

    public function modifyCircleDivisionData($circle_division_data)
    {
    	$modified_circle_division_arr = [];
        $final_modified_circle_division_arr = [];
        $temp_arr = [];

        foreach ($circle_division_data as $key => $value) {
            $modified_circle_division_arr[$value['circle_id']][$value['division_id']] = $value['division_name'];
        }

        foreach ($modified_circle_division_arr as $key => $value) {
            $temp_arr['circle_id'] = $key;
            $temp_arr['data'] = [];
            foreach ($value as $k => $v) {
                array_push($temp_arr['data'], array('division_id' => $k, 'division_name' => $v));
            }

            array_push($final_modified_circle_division_arr, $temp_arr);
        }

        return $final_modified_circle_division_arr;
    }

    public function modify_pp_status_ids($pp_status_ids)
    {
        $modified_status_arr = [];

        foreach ($pp_status_ids as $value) {
            $modified_status_arr[$value['name']] = $value['status_id']; 
        }

        return $modified_status_arr;
    }

    //Function to sort array by key
    public function sort_array_by_key($array, $sort_key)
    {
        $key_array = array_column($array, $sort_key);
        array_multisort($key_array, SORT_ASC, $array); //or SORT_DESC
        return $array;
    }
}



?>