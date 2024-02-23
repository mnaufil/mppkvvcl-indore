<?php defined('BASEPATH') OR exit('No direct script access allowed'); 


class TKCPhysicalVerification extends CI_Controller
{	
	function __construct()
	{
		parent::__construct();

		$this->load->model('TKCPhysicalVerification_Model', 'tpv_model');

		if(!$this->session->isUserLoggedIn)
        { 
            redirect('login'); 
        }
	}

	public function index()
	{
		$user_id = $_SESSION['loggedData']->user_id;

		$result = $this->tpv_model->getPhysicalVerificationSheets($user_id);
		// echo 'result: <pre>'; print_r($result); echo '</pre>'; die();

		/*$type_of_work = $this->tpv_model->getTypeOfWorkList();

		$region_list = $this->tpv_model->getRegionList();
      	$region_list = $this->sort_array_by_key($region_list, 'region_name');

      	$status_list = $this->pp_model->getStatusList();
      	$status_list = $this->sort_array_by_key($status_list, 'seqno');

      	$region_circle_data = $this->pp_model->getRegionCircleData();
      	$region_circle_data = $this->modifyRegionCircleData($region_circle_data);

      	$circle_division_data = $this->pp_model->getCircleDivisionData();
      	$circle_division_data = $this->modifyCircleDivisionData($circle_division_data);*/

      	$user_access_data = $this->tpv_model->getUserModuleAccess();
      	$user_access = $this->sortUserModuleAccess($user_access_data);

      	$data['title'] = 'TKC Physical Verification';
      	$data['result'] = $result;

      	$data['user_access'] = $user_access;

      	// echo '<pre>'; print_r($data); echo '</pre>'; die();
        $this->load->view('tkc-physical-verification/physical-verification', $data); 
	}

	public function editSheet($mode, $ppsheet_id, $contract_id, $contract_location_id)
	{
		$sheet_result = $this->tpv_model->getSheetDetail($mode, $ppsheet_id, $contract_id, $contract_location_id);

		//Setting tkc_physical_progress_id of editing sheet as prev_tkc_physical_progress_id
       	$sheet_result['prev_tkc_physical_progress_id'] = $sheet_result['tkc_physical_progress_id'];

       	//Setting tkc_physical_progress_id to blank
        $sheet_result['tkc_physical_progress_id'] = '';

        /*Formatting Tender Award Date*/
       	$award_date = date("d-m-Y", strtotime($sheet_result['tender_award_date']));
       	$sheet_result['tender_award_date'] = $award_date;

       	$sheet_result['task_ratio'] = $task_ratio = $this->calculateTaskRatio($sheet_result, $mode);
       	$task_ratio_arr = explode(' / ', $task_ratio);
       	$sheet_result['work_completion'] = round(((int)$task_ratio_arr[0] / (int)$task_ratio_arr[1]) * 100);       	

       	if (!empty($sheet_result['activities_list'])) {
       		$activities_list = $this->sortByActivities($sheet_result['activities_list'], $sheet_result['activities_group_name']);
            $sheet_result['activities_list'] = $activities_list;
       	}

       	$data['sheet_data'] = $sheet_result;
       	$data['title'] = 'TKC Physical Verification';
       	$data['page_title'] = 'TKC Physical Verification - Feeder ID['.$sheet_result['feeder_id'].']';

        $data['userdata'] = $this->getUserData();

       	// echo 'data: <pre>'; print_r($data); echo '</pre>'; die();
       	$this->load->view('tkc-physical-verification/add-tkc-physical-verification', $data);
	}

	public function saveSheet()
	{
		if (!empty($_POST)) {
			$post_data = $this->input->post();

			$tkc_pp_id = $this->input->post('tkc_physical_progress_id');
			$prev_tkc_pp_id = $this->input->post('prev_tkc_physical_progress_id');
			$contract_id = $this->input->post('contract_id');
			$contract_location_id = $this->input->post('contract_location_id');
			$site_location = $this->input->post('siteLocation');
			$reported_by_name = $this->input->post('reportedBy');
			$reported_by_id = $this->tpv_model->getReportedByID($reported_by_name);
			$reported_date = date('Y-m-d', strtotime($this->input->post('reportedDate')));
			$remark = $this->input->post('sheetRemark');

			$status_id = 2;
           	$is_draft = 0;

           	$uriSegments = explode("/", parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH));
           	$mode = array_slice($uriSegments, -4);

           	if (empty($tkc_pp_id)) {
           		$tkc_pp_id = $this->tpv_model->saveTKCPhysicalVerificationSheet($contract_id, $contract_location_id, $site_location, $reported_by_id, $reported_date, NULL, $remark, $status_id, $is_draft);

           		if ($mode[0] == 'edit-prev') {
           			
           		}
           	} else {
           		$tkc_pp_id = $this->tpv_model->updateTKCPhysicalVerificationSheet($pp_id, $contract_id, $contract_location_id, $site_location, $reported_by_id, $reported_date, NULL, $remark, $status_id, $is_draft);
           	}

           	$pp_sheet_activities = array();

           	$civil_work_activities = array();
           	$electrical_activities = array();
           	$substation_activities = array();
           	$feeder_33kv_activities = array();
           	$feeder_11kv_activities = array();
           	$feeder_separation_11kv_activities = array();
           	$interconnection_line_33kv_activites = array();

           	foreach ($post_data as $key => $value) {
           		if (str_contains($key, 'civil_work')) { //withoutBOQ
           			$input_name = explode('_', $key);

           			$civil_work_activities[$key]['tkc_physical_progress_id'] = $tkc_pp_id;
           			$civil_work_activities[$key]['activity_id'] = end($input_name);
           			$civil_work_activities[$key]['activity_status_id'] = $this->calculateStatusForWithoutBOQ($value);
           			$civil_work_activities[$key]['erected_qty'] = NULL;
           		}

           		if (str_contains($key, 'electrical')) { //withoutBOQ
           			$input_name = explode('_', $key);

           			$electrical_activities[$key]['tkc_physical_progress_id'] = $tkc_pp_id;
                    $electrical_activities[$key]['activity_id'] = end($input_name);
                    $electrical_activities[$key]['activity_status_id'] = $this->calculateStatusForWithoutBOQ($value);
                    $electrical_activities[$key]['erected_qty'] = NULL;
           		}

           		if (str_contains($key, 'sub-station_items')) { //withoutBOQ
           			$input_name = explode('_', $key);

           			$substation_activities[$key]['tkc_physical_progress_id'] = $tkc_pp_id;
                    $substation_activities[$key]['activity_id'] = end($input_name);
                    $substation_activities[$key]['activity_status_id'] = $this->calculateStatusForWithoutBOQ($value);
                    $substation_activities[$key]['erected_qty'] = NULL;
           		}

           		if (str_contains($key, '33kv_feeder')) { //withBOQ
           			if (str_contains($key, 'boq')) {
                        $boq_val = (int)$value;
                        continue;
                    }

                    $erected_val = (int)$value;

                    $input_name = explode('_', $key);
                    $feeder_33kv_activities[$key]['tkc_physical_progress_id'] = $tkc_pp_id;
                    $feeder_33kv_activities[$key]['activity_id'] = end($input_name);
                    $activity_status_id = $feeder_33kv_activities[$key]['activity_status_id'] = $this->calculateStatusForWithBOQ($erected_val, $boq_val);
                    $feeder_33kv_activities[$key]['erected_qty'] = $value;
           		}

           		if (preg_match('/\b11kv_feeder_\d/', $key) || preg_match('/\b11kv_feeder_boq_\d/', $key)) { //withBOQ
           			if (str_contains($key, 'boq')) {
                    	$boq_val = (int)$value;
                        continue;
                    }

                    $erected_val = (int)$value;

                    $input_name = explode('_', $key);
                    $feeder_11kv_activities[$key]['tkc_physical_progress_id'] = $tkc_pp_id;
                    $feeder_11kv_activities[$key]['activity_id'] = end($input_name);
                    $feeder_11kv_activities[$key]['activity_status_id'] = $this->calculateStatusForWithBOQ($erected_val, $boq_val);
                    $feeder_11kv_activities[$key]['erected_qty'] = $value;
           		}

           		if (str_contains($key, '11kv_feeder_separation')) { //withBOQ
           			if (str_contains($key, 'boq')) {
                    	$boq_val = (int)$value;
                        continue; 
                    }

                    $erected_val = (int)$value;

                    $input_name = explode('_', $key);
                    $feeder_separation_11kv_activities[$key]['tkc_physical_progress_id'] = $tkc_pp_id;
                    $feeder_separation_11kv_activities[$key]['activity_id'] = end($input_name);
                    $feeder_separation_11kv_activities[$key]['activity_status_id'] = $this->calculateStatusForWithBOQ($erected_val, $boq_val);
                    $feeder_separation_11kv_activities[$key]['erected_qty'] = $value;
           		}

           		if (str_contains($key, '33kv_interconnection_line')) { //withBOQ
           			if (str_contains($key, 'boq')) {
                    	$boq_val = (int)$value;
                        continue; 
                    }

                    $erected_val = (int)$value;

                    $input_name = explode('_', $key);
                    $interconnection_line_33kv_activites[$key]['tkc_physical_progress_id'] = $tkc_pp_id;
                    $interconnection_line_33kv_activites[$key]['activity_id'] = end($input_name);
                    $interconnection_line_33kv_activites[$key]['activity_status_id'] = $this->calculateStatusForWithBOQ($erected_val, $boq_val);
                    $interconnection_line_33kv_activites[$key]['erected_qty'] = $value;
           		}
           	}

           	if (!empty($civil_work_activities)) {
                array_push($pp_sheet_activities, $civil_work_activities);
            }

            if (!empty($electrical_activities)) {
            	array_push($pp_sheet_activities, $electrical_activities);
            }

            if (!empty($substation_activities)) {
            	array_push($pp_sheet_activities, $substation_activities);
            }

            if (!empty($feeder_33kv_activities)) {
            	array_push($pp_sheet_activities, $feeder_33kv_activities);
            }

            if (!empty($feeder_11kv_activities)) {
            	array_push($pp_sheet_activities, $feeder_11kv_activities);
            }

            if (!empty($feeder_separation_11kv_activities)) {
            	array_push($pp_sheet_activities, $feeder_separation_11kv_activities);
            }

            if (!empty($interconnection_line_33kv_activites)) {
            	array_push($pp_sheet_activities, $interconnection_line_33kv_activites);
            }

            //Inserting sheet activities in the table
            foreach ($pp_sheet_activities as $key => $value) {
            	foreach ($value as $k1 => $v1) {
            		$check_result = $this->tpv_model->checkActivity($v1['activity_id'], $v1['tkc_physical_progress_id']);

            		if (empty($check_result)) {
            			$seqno = $this->tpv_model->getActivityData($v1['activity_id'], 'seqno');
                      	$unit_id = $this->tpv_model->getActivityData($v1['activity_id'], 'unit_id');

                      	if (!empty($v1['tkc_physical_progress_id'])) {
                      		$activity_insert_id = $this->tpv_model->saveActivity($v1['tkc_physical_progress_id'], $seqno, $v1['activity_id'], $unit_id, $v1['activity_status_id'], $v1['erected_qty']);
                      	}
            		} else {
            			$row_affected = $this->tpv_model->updateActivity($v1['tkc_physical_progress_id'], $v1['activity_id'], $v1['activity_status_id'], $v1['erected_qty']);
            		}
            	}
            }

            $remaining_activity_count = $this->tpv_model->getAppliedActivitiesListForSheetStatusCalculation($tkc_pp_id);

            if ($remaining_activity_count == 0) {
            	$pp_status_ids = $this->tpv_model->getStatusList();
				$pp_status_ids = $this->modify_pp_status_ids($pp_status_ids);

				$status_id = $pp_status_ids['Completed'];
                $this->tpv_model->updateSheetStatus($tkc_pp_id, $status_id);
            	/*if (isset($_FILES['completionFile']) && $_FILES['completionFile']['error'][0] != 4) {
            		$ppsheet_completion_photo = $_FILES['completionFile'];
            		$allowTypes = array('jpg', 'png', 'jpeg');
                    $last_file_no = 0;

                    $uploadDir = 'assets/uploads/tkc_physical_progress_completion_files/';

                    foreach ($ppsheet_completion_photo['name'] as $key => $value) {
                    	$ext = pathinfo($value, PATHINFO_EXTENSION);
                    	$last_file_no++;

                    	// File upload path 
                    	$fileName = $pp_id.'_tkc_completion_file_'.$last_file_no.'.'.$ext;
                    	$targetFilePath = $uploadDir . $fileName;

                    	// Check whether file type is valid
                    	if (in_array($ext, $allowTypes)) {
                    		// Upload file to server
                    		if (move_uploaded_file($ppsheet_completion_photo['tmp_name'][$key], $targetFilePath)) {
                    			//Saving physical progress completion file details
                    			$file_result = $this->tpv_model->saveTKCPhysicalProgressCompletionFile($tkc_pp_id, $targetFilePath);

                    			if ($file_result) {
                    				$pp_status_ids = $this->tpv_model->getStatusList();
                    				$pp_status_ids = $this->modify_pp_status_ids($pp_status_ids);

                    				$status_id = $pp_status_ids['Completed'];
                                    $this->tpv_model->updateSheetStatus($tkc_pp_id, $status_id);
                    			}
                    		}
                    	}
                    }
            	}*/
            }

            redirect('tkc-physical-verification');
		}
	}

	public function calculateStatusForWithoutBOQ($value)
	{
		switch ($value) {
            case 'yes':
            	$status_id = 1;
                break;
            case 'yes-partial':
            	$status_id = 2;
                break;
           	case 'na':
            	$status_id = 3;
            	break;
           	case 'wip':
                $status_id = 4;
                break;
           	default:
                $status_id = 0;
                break;
        }

        return $status_id;
	}

	public function calculateStatusForWithBOQ($erected_val, $boq_val)
    {
    	if ($erected_val == 0) {
        	return $status_id = 0;
        } elseif ($erected_val > 0 && $erected_val < $boq_val) {
        	return $status_id = 2;
        } elseif ($erected_val == $boq_val) {
        	return $status_id = 1;
      	}
    }

	public function calculateTaskRatio($site, $mode, $reported_date = NULL)
	{
		$activities_result = $this->tpv_model->getActivitiesList($site['typeofwork_id'], NULL);

		$task_ratio = '-';

		if (!empty($activities_result)) {
			$activities_count = count($activities_result);

			$pp_id = (($mode == 'edit-prev' || $mode == 'view' || $mode == 'edit-review') && empty($reported_date)) ? $site['prev_tkc_physical_progress_id'] : $site['tkc_physical_progress_id'];

			$applied_activities_result = $this->tpv_model->getAppliedActivitiesList($pp_id, $site['contract_location_id']);

			$applied_activities_count = 0;

			if (!empty($applied_activities_result)) {
				// code...
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
        	$activities_arr[$g_key][$g_value['name']] = [];

            foreach ($list as $l_key => $l_value) {
            	if ($g_value['name'] == $l_value['activity_group_name']) {
                	array_push($activities_arr[$g_key][$g_value['name']], $l_value);
                }
           	}
        }

        foreach ($activities_arr as $key => $value) {
        	$sorted_arr = [];

            foreach ($value as $k1 =>  $v1) {
            	$sort_arr = $this->sort_array_by_key($v1, 'seqno');
                $sorted_arr[$k1] = $sort_arr;     
           	}

            $sorted_activities_arr[$key] = $sorted_arr;
        }

        return $sorted_activities_arr;
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

	public function getUserData()
    {
        $username = $_SESSION['username'];
        $role_id = $_SESSION['loggedData']->role_id;
          
        $userrole = $this->tpv_model->getUserRole($role_id);
          
        $userdata['username'] = $username;
        $userdata['role'] = $userrole;

        return $userdata;
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