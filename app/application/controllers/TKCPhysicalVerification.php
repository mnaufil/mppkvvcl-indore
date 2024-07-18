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

		$type_of_work = $this->tpv_model->getTypeOfWorkList($user_id);

		$region_list = $this->tpv_model->getRegionList($user_id);
      	$region_list = $this->sort_array_by_key($region_list, 'region_name');

      	$status_list = $this->tpv_model->getStatusList();
      	$status_list = $this->sort_array_by_key($status_list, 'seqno');

      	$region_circle_data = $this->tpv_model->getRegionCircleData($user_id);
      	$region_circle_data = $this->modifyRegionCircleData($region_circle_data);      	

      	$circle_division_data = $this->tpv_model->getCircleDivisionData($user_id);
      	$circle_division_data = $this->modifyCircleDivisionData($circle_division_data);

      	$user_access_data = $this->tpv_model->getUserModuleAccess();
      	$user_access = $this->sortUserModuleAccess($user_access_data);

      	$data['title'] = 'TKC Physical Entry';
      	$data['result'] = $result;

      	$data['work_list'] = $type_of_work;
        $data['region_list'] = $region_list;
        $data['region_circle_data'] = $region_circle_data;
        $data['circle_division_data'] = $circle_division_data;
        $data['status_list'] = $status_list;        

      	$data['user_access'] = $user_access;
      	$data['userdata'] = $this->getUserData();

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

       	if ($mode == 'edit-prev' || $mode == 'view') {
       		/*Formatting Reported Date*/
       		$reported_date = (!empty($sheet_result['reported_date'])) ? date("d-m-Y", strtotime($sheet_result['reported_date'])) : '';
            $sheet_result['reported_date'] = $reported_date;

            //Getting previously edited sheet dates
            $prev_sheet_dates = $this->tpv_model->getPrevSheetDates($sheet_result['contract_id'], $sheet_result['contract_location_id'], $sheet_result['site_location']);

            if ($sheet_result['reported_date'] == date('d-m-Y')) {
            	$sheet_result['sheet_mode'] = 'update';

            	if ($mode == 'edit-prev') {
                	array_pop($prev_sheet_dates);     
                }

                $data['prev_sheet_dates'] = $prev_sheet_dates;

                //Setting physical_progress_id to latest ID
                $sheet_result['tkc_physical_progress_id'] = $sheet_result['prev_tkc_physical_progress_id'];
            } else {
            	$data['prev_sheet_dates'] = $prev_sheet_dates;
            }
       	}

       	$data['sheet_data'] = $sheet_result;
       	$data['title'] = 'TKC Physical Entry';
       	$data['page_title'] = 'TKC Physical Entry - Feeder ID['.$sheet_result['feeder_id'].']';

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

			// $status_id = 2;
			$pp_status_ids = $this->tpv_model->getStatusList();
			$pp_status_ids = $this->modify_pp_status_ids($pp_status_ids);
			$status_id = $pp_status_ids['In Process'];

           	$is_draft = 0;

           	$uriSegments = explode("/", parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH));
           	$mode = array_slice($uriSegments, -4);

           	if (empty($tkc_pp_id)) {
           		$tkc_pp_id = $this->tpv_model->saveTKCPhysicalVerificationSheet($contract_id, $contract_location_id, $site_location, $reported_by_id, $reported_date, $remark, $status_id, $is_draft);

           		if ($mode[0] == 'edit-prev') {
           			
           		}
           	} else {
           		$tkc_pp_id = $this->tpv_model->updateTKCPhysicalVerificationSheet($tkc_pp_id, $contract_id, $contract_location_id, $site_location, $reported_by_id, $reported_date, NULL, NULL, $remark, $status_id, $is_draft);
           	}

           	$pp_sheet_activities = array();

           	$civil_work_activities = array();
           	$electrical_activities = array();
           	$substation_activities = array();
           	$feeder_33kv_activities = array();
           	$feeder_11kv_activities = array();
           	$feeder_separation_11kv_activities = array();
           	$interconnection_line_33kv_activites = array();
           	$additional_dtr_activities = array();
           	$bare_to_cable_activities = array();
           	$cable_augmentation_activities = array();
           	$bifurcation_11_kv_activities = array();
           	$interconnection_11_kv_activities = array();
           	$augmentation_33_kv_activities = array();
           	$augmentation_11_kv_activities = array();
           	$dl_to_ag_coated_conductor_activities = array();
           	$substation_rennovation_activities = array();

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

           		if (str_contains($key, 'additional_dtr')) { //withBOQ
                 	if (str_contains($key, 'boq')) {
                    	$boq_val = $value;
                        continue;
                    }

                        $erected_val = $value;

                    $input_name = explode('_', $key);
                    $additional_dtr_activities[$key]['tkc_physical_progress_id'] = $tkc_pp_id;
                    $additional_dtr_activities[$key]['activity_id'] = end($input_name);
                    $additional_dtr_activities[$key]['activity_status_id'] = $this->calculateStatusForWithBOQ($erected_val, $boq_val);
                    $additional_dtr_activities[$key]['erected_qty'] = $value;
                }

                if (str_contains($key, 'bare_to_cable')) { //withBOQ
                 	if (str_contains($key, 'boq')) {
                    	$boq_val = $value;
                        continue;
                    }

                    $erected_val = $value;

                    $input_name = explode('_', $key);
                    $bare_to_cable_activities[$key]['tkc_physical_progress_id'] = $tkc_pp_id;
                    $bare_to_cable_activities[$key]['activity_id'] = end($input_name);
                    $bare_to_cable_activities[$key]['activity_status_id'] = $this->calculateStatusForWithBOQ($erected_val, $boq_val);
                    $bare_to_cable_activities[$key]['erected_qty'] = $value;
                }

                if (str_contains($key, 'cable_augmentation')) { //withBOQ
                	if (str_contains($key, 'boq')) {
                        $boq_val = $value;
                        continue;
                    }

                    $erected_val = $value;

                    $input_name = explode('_', $key);
                    $cable_augmentation_activities[$key]['tkc_physical_progress_id'] = $tkc_pp_id;
                    $cable_augmentation_activities[$key]['activity_id'] = end($input_name);
                    $cable_augmentation_activities[$key]['activity_status_id'] = $this->calculateStatusForWithBOQ($erected_val, $boq_val);
                    $cable_augmentation_activities[$key]['erected_qty'] = $value;
                }

                if (str_contains($key, '11_kv_bifurcation')) { //withBOQ
                	if (str_contains($key, 'boq')) {
                        $boq_val = $value;
                      	continue;
                    }

                    $erected_val = $value;

                    $input_name = explode('_', $key);
                    $bifurcation_11_kv_activities[$key]['tkc_physical_progress_id'] = $tkc_pp_id;
                    $bifurcation_11_kv_activities[$key]['activity_id'] = end($input_name);
                    $bifurcation_11_kv_activities[$key]['activity_status_id'] = $this->calculateStatusForWithBOQ($erected_val, $boq_val);
                    $bifurcation_11_kv_activities[$key]['erected_qty'] = $value;
                }

                if (str_contains($key, '11_kv_interconnection')) { //withBOQ
                	if (str_contains($key, 'boq')) {
                    	$boq_val = $value;
                      	continue;
                    }

                    $erected_val = $value;

                    $input_name = explode('_', $key);
                    $interconnection_11_kv_activities[$key]['tkc_physical_progress_id'] = $tkc_pp_id;
                    $interconnection_11_kv_activities[$key]['activity_id'] = end($input_name);
                    $interconnection_11_kv_activities[$key]['activity_status_id'] = $this->calculateStatusForWithBOQ($erected_val, $boq_val);
                    $interconnection_11_kv_activities[$key]['erected_qty'] = $value;
                }

                if (str_contains($key, '33_kv_augmentation')) { //withBOQ
                	if (str_contains($key, 'boq')) {
                    	$boq_val = $value;
                      	continue;
                    }

                    $erected_val = $value;

                    $input_name = explode('_', $key);
                    $augmentation_33_kv_activities[$key]['tkc_physical_progress_id'] = $tkc_pp_id;
                    $augmentation_33_kv_activities[$key]['activity_id'] = end($input_name);
                    $augmentation_33_kv_activities[$key]['activity_status_id'] = $this->calculateStatusForWithBOQ($erected_val, $boq_val);
                    $augmentation_33_kv_activities[$key]['erected_qty'] = $value;
                }

                if (str_contains($key, '11_kv_augmentation')) { //withBOQ
                	if (str_contains($key, 'boq')) {
                    	$boq_val = $value;
                      	continue;
                    }

                    $erected_val = $value;

                    $input_name = explode('_', $key);
                    $augmentation_11_kv_activities[$key]['tkc_physical_progress_id'] = $tkc_pp_id;
                    $augmentation_11_kv_activities[$key]['activity_id'] = end($input_name);
                    $augmentation_11_kv_activities[$key]['activity_status_id'] = $this->calculateStatusForWithBOQ($erected_val, $boq_val);
                    $augmentation_11_kv_activities[$key]['erected_qty'] = $value;
                }

                if (str_contains($key, 'dl_to_ag_coated_conductor')) { //withBOQ
                	if (str_contains($key, 'boq')) {
                    	$boq_val = $value;
                        continue;
                    }

                    $erected_val = $value;

                    $input_name = explode('_', $key);
                    $dl_to_ag_coated_conductor_activities[$key]['tkc_physical_progress_id'] = $tkc_pp_id;
                    $dl_to_ag_coated_conductor_activities[$key]['activity_id'] = end($input_name);
                    $dl_to_ag_coated_conductor_activities[$key]['activity_status_id'] = $this->calculateStatusForWithBOQ($erected_val, $boq_val);
                    $dl_to_ag_coated_conductor_activities[$key]['erected_qty'] = $value;
                }

                if (str_contains($key, 'substation_rennovation')) { //withBOQ
                	if (str_contains($key, 'boq')) {
                    	$boq_val = $value;
                        continue;
                    }

                    $erected_val = $value;

                    $input_name = explode('_', $key);
                    $substation_rennovation_activities[$key]['tkc_physical_progress_id'] = $tkc_pp_id;
                    $substation_rennovation_activities[$key]['activity_id'] = end($input_name);
                    $substation_rennovation_activities[$key]['activity_status_id'] = $this->calculateStatusForWithBOQ($erected_val, $boq_val);
                    $substation_rennovation_activities[$key]['erected_qty'] = $value;
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

            if (!empty($additional_dtr_activities)) {
            	array_push($pp_sheet_activities, $additional_dtr_activities);     
           	}

           	if (!empty($bare_to_cable_activities)) {
                array_push($pp_sheet_activities, $bare_to_cable_activities);     
           	}

           	if (!empty($cable_augmentation_activities)) {
                array_push($pp_sheet_activities, $cable_augmentation_activities);     
           	}

           	if (!empty($bifurcation_11_kv_activities)) {
                array_push($pp_sheet_activities, $bifurcation_11_kv_activities);     
           	}

           	if (!empty($interconnection_11_kv_activities)) {
                array_push($pp_sheet_activities, $interconnection_11_kv_activities);     
           	}

           	if (!empty($augmentation_33_kv_activities)) {
                array_push($pp_sheet_activities, $augmentation_33_kv_activities);     
           	}

           	if (!empty($augmentation_11_kv_activities)) {
                array_push($pp_sheet_activities, $augmentation_11_kv_activities);     
           	}

           	if (!empty($dl_to_ag_coated_conductor_activities)) {
                array_push($pp_sheet_activities, $dl_to_ag_coated_conductor_activities);     
           	}

           	if (!empty($substation_rennovation_activities)) {
                array_push($pp_sheet_activities, $substation_rennovation_activities);     
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

            redirect('tkc-physical-entry');
		}
	}

	public function searchSheet()
	{
		if (!empty($_POST)) {
			$user_id = $_SESSION['loggedData']->user_id;

			$filter_arr = [];

			$contractor = $this->input->post('contractor');
			$filter_arr['contractor']['label'] = 'Contractor (TKC)';
            $filter_arr['contractor']['value'] = $contractor;

            $tender_award_no = $this->input->post('tenderAwardNo');
            $filter_arr['tenderAwardNo']['label'] = 'Contract No.';
           	$filter_arr['tenderAwardNo']['value'] = $tender_award_no;

           	$type_of_work = (isset($_POST['typeOfWork'])) ? $this->input->post('typeOfWork') : '';
           	$filter_arr['typeOfWork']['label'] = 'Type Of Work';
           	$filter_arr['typeOfWork']['value'] = (isset($_POST['typeOfWork'])) ? $this->tpv_model->getTypeOfWork($type_of_work) : '';
            $filter_arr['typeOfWork']['id'] = $type_of_work;

            $site_location = $this->input->post('siteLocation');
           	$filter_arr['siteLocation']['label'] = 'Site Location';
            $filter_arr['siteLocation']['value'] = $site_location;

            $region = (isset($_POST['region'])) ? $this->input->post('region') : '';
            $filter_arr['region']['label'] = 'Region';
            $filter_arr['region']['value'] = (isset($_POST['region'])) ? $this->tpv_model->getRegion($region) : '';
            $filter_arr['region']['id'] = $region;

            $circle = (isset($_POST['circle'])) ? $this->input->post('circle') : '';
            $filter_arr['circle']['label'] = 'Circle';
            $filter_arr['circle']['value'] = (isset($_POST['circle'])) ? $this->tpv_model->getCircle($circle) : '';
            $filter_arr['circle']['id'] = $circle;

            $division = (isset($_POST['division'])) ? $this->input->post('division') : '';
            $filter_arr['division']['label'] = 'Division';
            $filter_arr['division']['value'] = (isset($_POST['division'])) ? $this->tpv_model->getDivision($division) : '';
            $filter_arr['division']['id'] = $division;

            $reported_by = $this->input->post('reportedBy');
            $reported_by_id = (!empty($reported_by)) ? $this->tpv_model->getReportedByID($reported_by, 'LIKE') : '';
            $filter_arr['reportedBy']['label'] = 'Reported By';
            $filter_arr['reportedBy']['value'] = $reported_by;

            $reported_date = $this->input->post('reportedDate');
           	$formatted_reported_date = (!empty($reported_date)) ? date('Y-m-d', strtotime($reported_date)) : '';
            $filter_arr['reportedDate']['label'] = 'Reported Date';
            $filter_arr['reportedDate']['value'] = $reported_date;

            $feeder_id = $this->input->post('feederID');
            $filter_arr['feederID']['label'] = 'Feeder ID';
            $filter_arr['feederID']['value'] = $feeder_id;

            $status = (isset($_POST['status'])) ? implode(',', $this->input->post('status')) : '';
            $filter_arr['status']['label'] = 'Status';
            $status_values = [];
            if ($status != '') {
            	foreach ($this->input->post('status') as $key => $value) {
                	array_push($status_values, $this->tpv_model->getSheetStatus($value));
                }
           	}
            $filter_arr['status']['value'] = (!empty($status_values)) ? implode(', ', $status_values) : '';
            $filter_arr['status']['id'] = $this->input->post('status');

            $search_result = $this->tpv_model->searchSheets($contractor, $tender_award_no, $type_of_work, $site_location, $region, $circle, $division, $reported_by_id, $formatted_reported_date, $feeder_id, $status, $user_id, 0, 1000);

            $user_access_data = $this->tpv_model->getUserModuleAccess();
      		$user_access = $this->sortUserModuleAccess($user_access_data);

      		$type_of_work = $this->tpv_model->getTypeOfWorkList($user_id);

      		$region_list = $this->tpv_model->getRegionList($user_id);
      		$region_list = $this->sort_array_by_key($region_list, 'region_name');

      		if (!empty($region)) {
      			$circle_list = $this->tpv_model->getCircleListOfRegion($region);
      			$data['circle_list'] = $this->sort_array_by_key($circle_list, 'circle_name');
      		}

      		if (!empty($circle)) {
                $division_list = $this->tpv_model->getDivisionListOfCircle($circle);
                $data['division_list'] = $this->sort_array_by_key($division_list, 'division_name');
            }

            $region_circle_data = $this->tpv_model->getRegionCircleData($user_id);
	      	$region_circle_data = $this->modifyRegionCircleData($region_circle_data);

	      	$circle_division_data = $this->tpv_model->getCircleDivisionData($user_id);
	      	$circle_division_data = $this->modifyCircleDivisionData($circle_division_data);

	      	$status_list = $this->tpv_model->getStatusList();
      		$status_list = $this->sort_array_by_key($status_list, 'seqno');

      		$data['title'] = 'TKC Physical Verification';
      		$data['result'] = $search_result;

      		$data['filters'] = $filter_arr;
      		$data['work_list'] = $type_of_work;
      		$data['region_list'] = $region_list;
      		$data['region_circle_data'] = $region_circle_data;
        	$data['circle_division_data'] = $circle_division_data;
        	$data['status_list'] = $status_list;

        	$data['user_access'] = $user_access;
      		$data['userdata'] = $this->getUserData();

      		// echo 'data: <pre>'; print_r($data); echo '</pre>'; die();
        	$this->load->view('tkc-physical-verification/physical-verification', $data);
		}
	}

	public function getSheetDataByDate($reported_date, $ppsheet_id, $contract_id, $contract_location_id)
	{
		$mode = 'view-by-date';
		$sheet_result = $this->tpv_model->getSheetDetail($mode, $ppsheet_id, $contract_id, $contract_location_id, $reported_date);		

		/*Formatting Tender Award Date*/
        $award_date = date("d-m-Y", strtotime($sheet_result['tender_award_date']));
        $sheet_result['tender_award_date'] = $award_date;

        $sheet_result['task_ratio'] = $task_ratio = $this->calculateTaskRatio($sheet_result, $mode, $reported_date);
        $task_ratio_arr = explode(' / ', $task_ratio);
       	$sheet_result['work_completion'] = round(((int)$task_ratio_arr[0] / (int)$task_ratio_arr[1]) * 100);
        // echo 'sheet_result: <pre>'; print_r($sheet_result); echo '</pre>'; die();

        if (!empty($sheet_result['activities_list'])) {
            $activities_list = $this->sortByActivities($sheet_result['activities_list'], $sheet_result['activities_group_name']);
            $sheet_result['activities_list'] = $activities_list;
        }

        /*Formatting Reported Date*/
        $reported_date = date("d-m-Y", strtotime($sheet_result['reported_date']));
        $sheet_result['reported_date'] = $reported_date;

        $data['sheet_type'] = 'old';
        $data['sheet_date'] = $reported_date;

        //Checking future date's sheet for the same contract & location (to check if the sheet is completed in future dates)
        $last_filled_sheet = $this->tpv_model->getLastFilledPhysicalProgressSheet($contract_id, $contract_location_id);
        if ($last_filled_sheet['status_id'] == '3') {
        	$data['future_sheet_status'] = 'Completed';
        }

        //Getting previously edited sheet dates
        $prev_sheet_dates = $this->tpv_model->getPrevSheetDates($sheet_result['contract_id'], $sheet_result['contract_location_id'], $sheet_result['site_location']);
        $data['prev_sheet_dates'] = $prev_sheet_dates;

        $data['sheet_data'] = $sheet_result;
        $data['title'] = 'TKC Physical Entry';
        $data['page_title'] = 'Physical Entry - Feeder ID['.$sheet_result['feeder_id'].']';

        $data['userdata'] = $this->getUserData();

        // echo 'data: <pre>'; print_r($data); echo '</pre>'; die();
        $this->load->view('tkc-physical-verification/add-tkc-physical-verification', $data);
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
    	if ($boq_val == 0) {
    		return $status_id = 3;
    	} else {
    		if ($erected_val == 0) {
	        	return $status_id = 0;
	        } elseif ($erected_val > 0 && $erected_val < $boq_val) {
	        	return $status_id = 2;
	        } elseif ($erected_val == $boq_val) {
	        	return $status_id = 1;
	      	}	
    	}
    }

	public function calculateTaskRatio($site, $mode, $reported_date = NULL)
	{
		$activities_result = $this->tpv_model->getActivitiesList($site['typeofwork_id'], NULL);

		$task_ratio = '-';

		if (!empty($activities_result)) {
			$activities_count = count($activities_result);

			$pp_id = (($mode == 'edit-prev' || $mode == 'view') && empty($reported_date)) ? $site['prev_tkc_physical_progress_id'] : $site['tkc_physical_progress_id'];

			$applied_activities_result = $this->tpv_model->getAppliedActivitiesList($pp_id, $site['contract_location_id']);

			$applied_activities_count = 0;

			if (!empty($applied_activities_result)) {
				foreach ($applied_activities_result as $key => $value) {

					if ($value['status_id'] == 3 || $value['status_id'] == 1) {
						$applied_activities_count++;
					}
				}
			}

			$task_ratio = $applied_activities_count .' / '.$activities_count;
		}

		return $task_ratio;
	}

	public function modifyRegionCircleData($region_circle_data)
	{
		$modified_region_circle_arr = [];

      	foreach ($region_circle_data as $key => $value) {
        	$modified_region_circle_arr[$value['region_id']][$value['circle_id']] = $value['circle_name'];
        }

        return $modified_region_circle_arr;
	}

	public function modifyCircleDivisionData($circle_division_data)
	{
		$modified_circle_division_arr = [];

        foreach ($circle_division_data as $key => $value) {
        	$modified_circle_division_arr[$value['circle_id']][$value['division_id']] = $value['division_name'];
        }

        return $modified_circle_division_arr;
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

    public function searchContractor()
    {
    	if (!empty($_POST)) {
    		$contractor = $this->input->post('contractor');
    		$response['contractor_data'] = $this->tpv_model->getContractorData($contractor);
    	}

    	echo json_encode($response);
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