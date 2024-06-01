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
class PhysicalProgressApi extends REST_Controller
{	
	function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->model('PhysicalProgress_Model', 'pp_model');
        $this->load->model('Security_Model', 'security_model');
	}

	public function index_get()
	{
        if (!empty($this->get())) {
            $user_id = $this->get('user_id');
            $limit = $this->get('limit');
            $offset = 0;

            //Getting List LIMIT value from sysconfig table
            // $limit = $this->pp_model->getPhysicalProgressListLimit();

            $pp_list_status_ids = $this->pp_model->getStatusIDsForList();
            $pp_list_status_ids = implode(',', $pp_list_status_ids);

            $result = $this->pp_model->getPhysicalProgressSheets($pp_list_status_ids, $user_id, $offset, $limit);

            foreach ($result as $key => $value) {
                $work_completion = ($value['tt_task'] != 0) ? ((int)$value['cc_task'] / (int)$value['tt_task']) * 100 : '';
                $result[$key]['work_completion'] = ($work_completion == 0 || $work_completion == 100 || $work_completion == '') ? $work_completion : round($work_completion);

                $submitted_by_tkc_ncr = $this->pp_model->getNCRSubmittedByTKCList($value['contract_location_id']);
                $result[$key]['ncr_submitted_by_tkc_count'] = count($submitted_by_tkc_ncr);
            }

            $data['title'] = 'Physical Progress';
            $data['result'] = $result;

            $errors = null;
            $message = (empty($result)) ? 'No access to feeder locations' : null;
            $status_code = 200;
        } else {
            $errors = 'Empty GET Request';
            $message = 'GET Request has no arguments';
            $status_code = 400;
            $data = [];
        }		

        $this->response(['errors' => $errors, 'message' => $message, 'status_code' => $status_code, 'data' => $data], REST_Controller::HTTP_OK);
	}

    public function get_ppsheet_details_post()
    {
        if (!empty($this->post())) {
            $logged_user_role_id = $this->post()['logged_user_role_id'];
            $ppsheet_id = $this->post()['physical_progress_id'];
            $prev_ppsheet_id = $this->post('prev_physical_progress_id');
            $contract_id = $this->post()['contract_id'];
            $contract_location_id = $this->post()['contract_location_id'];
            $reported_date = (!empty($this->post('reported_date'))) ? date('Y-m-d', strtotime($this->post('reported_date'))) : '';
            $sheet_status_id = $this->post('sheet_status_id');
            $day = $this->post('day');

            $reported_date = ($sheet_status_id == 1) ? '' : $reported_date;

            $mode = 'edit-new';
            $type = 'API';

            $pp_id = (empty($ppsheet_id)) ? $prev_ppsheet_id : $ppsheet_id;
            
            $sheet_result = $this->pp_model->getSheetDetail($mode, $pp_id, $contract_id, $contract_location_id, $reported_date, $type);
            $sheet_result['reported_date'] = (!empty($sheet_result['reported_date'])) ? date('d-m-Y', strtotime($sheet_result['reported_date'])) : "";
            
            $sheet_result['reported_by'] = (!empty($ppsheet_id)) ? $sheet_result['reported_by'] : '';
            $sheet_result['reported_by_name'] = $this->pp_model->getReportedByName($sheet_result['reported_by']);

            $sheet_result['geo_location_radius'] = $this->pp_model->getGeoLocationRadius();

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
                if ($mode == 'edit-new') {
                    // Checking if count of activities from pp_activity table matches with count of activities from mst_typeofwork_activity table
                    $mst_activity_count = $this->pp_model->getTotalActivityCountFromMaster($sheet_result['typeofwork_id']);

                    $pp_activity_count = count($sheet_result['activities_list']);

                    if ($pp_activity_count != $mst_activity_count) {
                        $mst_activity_data = $this->pp_model->getActivitiesList($sheet_result['typeofwork_id'], $sheet_result['contract_location_id']);

                        $pp_activity_ids = array_column($sheet_result['activities_list'], 'activity_id');

                        foreach ($mst_activity_data as $key => $mst_activity) {
                            if (!in_array($mst_activity['typeofwork_activity_id'], $pp_activity_ids)) {
                                array_push($sheet_result['activities_list'], $mst_activity);
                            }
                        }
                    }
                }

                $activities_list = $this->sortByActivities($sheet_result['activities_list'], $sheet_result['activities_group_name']);
                $sheet_result['activities_list'] = $activities_list;
            }

            $pp_status_list = $this->pp_model->getStatusList();
            $pp_status_list = $this->modify_pp_status_ids($pp_status_list);

            if ($sheet_result['status_id'] == $pp_status_list['Reviewed'] || $sheet_result['status_id'] == $pp_status_list['Completed']) {
                // Fetching sheet complete photo
                $sheet_completion_photo = $this->pp_model->getPhysicalProgressCompletionFile($pp_id);

                //Temporary Code
                $arrContextOptions = array(
                    "ssl" => array(
                        'cafile' => '/path/to/bundle/cacert.pem',
                        "verify_peer" => false,
                        "verify_peer_name" => false
                    ),
                );

                $sheet_completion_files = [];
                foreach ($sheet_completion_photo as $key => $value) {
                    $temp_files = [];
                    $ext = pathinfo($value['file_path'], PATHINFO_EXTENSION); 

                    // Get the image and convert into string
                    $file_path = base_url($value['file_path']);
                    $image = file_get_contents($file_path, false, stream_context_create($arrContextOptions));
                    // $image = file_get_contents($file_path);

                    // Encode the image string data into base64
                    $image_base64 = 'data:image/'.$ext.';base64,'.base64_encode($image);

                    array_push($temp_files, $image_base64);
                    array_push($sheet_completion_files, $temp_files);
                }

                $sheet_result['sheet_completion_photo'] = $sheet_completion_files;
            } else {
                $sheet_result['sheet_completion_photo'] = '';
            }

            $sheet_result['mode'] = (($reported_date == date('Y-m-d')) || ($reported_date == '') || $day == 'today') ? 'new' : 'previous';

            $userdata = $this->getUserData($logged_user_role_id);
            $sheet_result['user_role'] = $userdata['role'];

            $data['sheet_data'] = $sheet_result;

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

    public function save_ppsheet_details_post()
    {
        if (!empty($this->post())) {
            $user_id = $this->post('user_id');

            $pp_id = $this->post('physical_progress_id');
            $prev_pp_id = $this->post('prev_physical_progress_id');
            $reported_by = $this->post('reported_by');
            $reported_date = date('Y-m-d', strtotime($this->post('reported_date')));
            $geo_code = $this->post('geo_code');
            $is_inrange = ($this->post('is_inrange') == 'yes') ? 1 : 0;
            $sheet_remark = $this->post('sheet_remark');
            $charging_status = $this->post('charging_status');
            $activities = $this->post('activities');
            $sheet_completion_file = $this->post('sheet_completion_file');
            // $status_id = $this->post('status_id');

            //Fetching sheet details using prev_pp_id
            $prev_sheet_data = $this->pp_model->getPreviousSheetDataAPI($prev_pp_id);

            $status_id = 2;
            $is_draft = 0;
            
            //In case sheet is being saved, without saving any observations
            if ((empty($pp_id)) || $pp_id == NULL) {
                //Saving the sheet and fetching the new physical_progres_id
                $pp_id = $this->pp_model->savePhysicalProgressSheetAPI($prev_sheet_data['contract_id'], $prev_sheet_data['contract_location_id'], $prev_sheet_data['site_location'], $reported_by, $reported_date, $geo_code, $is_inrange, $sheet_remark, $status_id, $is_draft, $user_id);
            } else {
                $pp_id = $this->pp_model->updatePhysicalProgressSheet($pp_id, $prev_sheet_data['contract_id'], $prev_sheet_data['contract_location_id'], $prev_sheet_data['site_location'], $reported_by, $reported_date, $geo_code, $is_inrange, $sheet_remark, $status_id, $is_draft, $user_id);
            }

            if ($pp_id) {
                $remaining_activity_count = 0;
                foreach ($activities as $value) {
                    foreach ($value['tab_body'] as $act_key => $act_value) {
                        $activity_id = $act_value['activity_id'];

                        if (isset($act_value['boq']) && is_numeric($act_value['boq'])) {
                            $boq_val = $act_value['boq'];
                            $unit_id = $act_value['unit_id'];

                            $contract_location_id = $prev_sheet_data['contract_location_id'];

                            //Updating BOQ qty value in contract_location_boq
                            $this->updateBOQQty($activity_id, $boq_val, $contract_location_id, $unit_id, $user_id);    
                        }

                        $erected_qty = (isset($act_value['erected_qty']) && is_numeric($act_value['erected_qty'])) ? $act_value['erected_qty'] : NULL;

                        //Calculating the pending activities
                        if ($act_value['status_id'] == 0 || $act_value['status_id'] == 2 || $act_value['status_id'] == 4) {
                            $remaining_activity_count++;
                        }

                        //Checking if activity already exists
                        $activity_check_result = $this->pp_model->checkActivity($activity_id, $pp_id);

                        if (empty($activity_check_result)) {
                            //Inserting sheet activity details
                            $affected_row = $this->pp_model->saveActivityAPI($pp_id, $act_value['seqno'], $activity_id, $act_value['unit_id'], $act_value['status_id'], $erected_qty, $user_id);
                        } else {
                            //Updating sheet activity details
                            $affected_row = $this->pp_model->updateActivity($pp_id, $activity_id, $act_value['status_id'], $erected_qty);
                        }
                    }
                }

                // Updating charging status in contract_location table
                $this->pp_model->updateChargingStatus($prev_sheet_data['contract_location_id'], $charging_status, $user_id);

                $alert_message = '';
                //If all the activities are marked as complete, uploading the sheet completion photo
                if ($remaining_activity_count == 0) {
                    if (!empty($sheet_completion_file)) {
                        $allowTypes = array('jpg', 'png', 'jpeg');
                        $uploadDir = 'assets/uploads/physical_progress_completion_files/';

                        //Processing Base64 image
                        foreach ($sheet_completion_file as $key => $value) {
                            //Stripping off data:image/jpeg;base64
                            $img = preg_replace('#^data:image/[^;]+;base64,#', '', ltrim($value));
                            $bin = base64_decode($img); //Obtaining the original content

                            $size = getImageSizeFromString($bin); //Gathering information about the image using the GD library

                            // Check the MIME type to be sure that the binary data is an image
                            if (empty($size['mime']) || strpos($size['mime'], 'image/') !== 0) {
                                $errors = 'Sheet Completion File Error';
                                $message = 'Base64 value is not a valid image';
                                $status_code = 400;
                                $data = [];
                            }

                            $ext = substr($size['mime'], 6); //Extracting the image extension

                            //Checking if file type is valid
                            if (!in_array($ext, $allowTypes)) {
                                $errors = 'Sheet Completion File Error';
                                $message = 'Unsupported Image Type. Only '.implode(',', $allowTypes).' files are allowed to upload.';
                                $status_code = 400;
                                $data = [];
                            }

                            $file_name = $pp_id.'_completion_file_'.$key.'.'.$ext;
                            $file_path = $uploadDir.$file_name;

                            //Uploading the file to directory
                            if (file_put_contents($file_path, $bin)) {
                                //Saving Sheet Completion File details
                                $file_result = $this->pp_model->savePhysicalProgressCompletionFile($pp_id, $file_path, $user_id);
                            } else {
                                $errors = 'Sheet Completion File Error';
                                $message = 'Could not upload Sheet Completion File';
                                $status_code = 400;
                                $data = array('physical_progress_id' => $pp_id);
                            }
                        }

                        //Updating the status of physical progress sheet to Completed
                        // $status_id = 3;
                        $pp_status_ids = $this->pp_model->getStatusList();
                        $pp_status_ids = $this->modify_pp_status_ids($pp_status_ids);

                        $status_id = $pp_status_ids['Reviewed'];
                        $this->pp_model->updateSheetStatus($pp_id, $status_id);

                        $alert_message = 'Physical Progress Sheet saved and marked as completed successfully';
                    }
                }

                $errors = null;
                $message = (empty($alert_message)) ? 'Physical Progress Sheet saved successfully' : $alert_message;
                $status_code = 200;
                $data = array('physical_progress_id' => $pp_id);
            }
        } else {
            $errors = 'Empty POST Request';
            $message = 'POST Request has no arguments';
            $status_code = 400;
            $data = [];
        }

        $this->response(['errors' => $errors, 'message' => $message, 'status_code' => $status_code, 'data' => $data], REST_Controller::HTTP_OK);
    }

    public function updateBOQQty($activity_id, $boq_val, $contract_location_id, $unit_id, $user_id)
    {
        // Check if boq value already exists
        $result = $this->pp_model->getBOQ($activity_id, $contract_location_id);

        if (!$result) {
            // Inserting the BOQ Qty value
            $this->pp_model->insertBOQQty($contract_location_id, $activity_id, $unit_id, $boq_val, $user_id);
        } else {
            // Updating the BOQ Qty value
            $this->pp_model->updateBOQQty($contract_location_id, $activity_id, $boq_val, $user_id);
        }
    }

    public function get_observations_post()
    {
        if (!empty($this->post())) {
            $typeofwork_activity_id = $this->post('typeofwork_activity_id');

            $obs_data = $this->pp_model->getObservationData($typeofwork_activity_id);
            $data['observations'] = $obs_data;

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

    public function save_observations_post()
    {
        if (!empty($this->post())) {
            $user_id = $this->post('user_id');

            $pp_id = $this->post('physical_progress_id');
            $prev_pp_id = $this->post('prev_physical_progress_id');
            $contract_location_id = $this->post('contract_location_id');

            $activity_seq_no = $this->post('activity_seq_no');
            $activity_id = $this->post('activity_id');
            $unit_id = $this->post('unit_id');
            $status_id = $this->post('status_id');
            $erected_qty = NULL;

            $observation_id = $this->post('observation_id');
            $observation_name = $this->post('observation_name');
            $ncr_id = $this->post('ncr_id');

            //Check if NCR ID already exists
            $ncr_id_check_result = $this->pp_model->checkNCRIDExists($ncr_id);

            if (!empty($ncr_id_check_result)) {
                $last_obs_data = $this->pp_model->fetchLastObservation();
                $last_ncr_id = $last_obs_data['ncr_id'];

                $ncr_id = ++$last_ncr_id;
            }

            $ncr_date = date('Y-m-d', strtotime($this->post('ncr_date')));
            $observation_remark = $this->post('observation_remark');
            $completion_date = empty($this->post('completion_date')) ? NULL : date('Y-m-d', strtotime($this->post('completion_date')));
            $observation_files = $this->post('observation_files');
            $completion_files = $this->post('completion_files');

            if (!empty($observation_files)) {
                if (empty($pp_id)) {
                    //Getting data of previous physical progress sheet
                    $prev_pp_sheet_data = $this->pp_model->getSheetData($prev_pp_id);

                    $is_draft = 1;
                    $status_id = 2;

                    //Saving the physical progress sheet and obtaining its ID
                    $pp_id = $this->pp_model->savePhysicalProgressSheetAPI($prev_pp_sheet_data['contract_id'], $prev_pp_sheet_data['contract_location_id'], $prev_pp_sheet_data['site_location'], NULL, NULL, NULL, NULL, NULL, $status_id, $is_draft, $user_id);
                }

                //Checking if the activity already exists
                $check_activity_exists = $this->pp_model->checkActivity($activity_id, $pp_id);

                if ($check_activity_exists) {
                    if ($check_activity_exists['status_id'] == $status_id && $check_activity_exists['erected_qty'] == $erected_qty) {
                        $pp_act_id = $activity_id;
                    } elseif ($check_activity_exists['status_id'] != $status_id || $check_activity_exists['erected_qty'] != $erected_qty) {
                        //Updating the existing activity
                        $pp_act_id = $this->pp_model->updateActivity($pp_id, $activity_id, $status_id, $erected_qty);    
                    }
                } else {
                    //Saving the activity against the pp_id
                    $pp_act_id = $this->pp_model->saveActivityAPI($pp_id, $activity_seq_no, $activity_id, $unit_id, $status_id, $erected_qty, $user_id);    
                }

                if ($pp_act_id) {
                    $ncr_status_ids = $this->getNCRStatusIDs();
                    $obs_status_id = ($completion_date == NULL) ? $ncr_status_ids['Pending'] : $ncr_status_ids['Reviewed'];

                    //Saving Observation and obtaining its ID
                    $pp_activity_obs_id = $this->pp_model->saveObservationAPI($contract_location_id, $activity_id, $observation_id, $observation_name, $ncr_id, $ncr_date, $observation_remark, $completion_date, $obs_status_id, $user_id);

                    if ($pp_activity_obs_id) {
                        if (!empty($observation_files)) {
                            $allowTypes = array('jpg', 'png', 'jpeg');
                            $uploadDir = 'assets/uploads/observation_files/';

                            //Processing Base64 image
                            foreach ($observation_files as $key => $value) {
                                //Stripping off data:image/jpeg;base64
                                $img = preg_replace('#^data:image/[^;]+;base64,#', '', ltrim($value));
                                $bin = base64_decode($img); //Obtaining the original content

                                $size = getImageSizeFromString($bin); //Gathering information about the image using the GD library

                                // Check the MIME type to be sure that the binary data is an image
                                if (empty($size['mime']) || strpos($size['mime'], 'image/') !== 0) {
                                    $errors = 'Observation File Error';
                                    $message = 'Base64 value is not a valid image';
                                    $status_code = 400;
                                    $data = [];
                                }

                                $ext = substr($size['mime'], 6); //Extracting the image extension

                                //Checking if file type is valid                            
                                if (!in_array($ext, $allowTypes)) {
                                    $errors = 'Observation File Error';
                                    $message = 'Unsupported Image Type. Only '.implode(',', $allowTypes).' files are allowed to upload.';
                                    $status_code = 400;
                                    $data = [];
                                }

                                $file_name = $key.'_'.$pp_id.'_observation_'.$observation_id.'_'.$ncr_id.'.'.$ext;
                                $file_path = $uploadDir.$file_name;

                                //Uploading the file to directory
                                if (file_put_contents($file_path, $bin)) {
                                    //Saving Observation File details
                                    $file_result = $this->pp_model->saveObservationFileAPI($pp_activity_obs_id, $file_path, $user_id);

                                    $errors = null;
                                    $message = 'Observation Saved successfully';
                                    $status_code = 200;
                                    $data = array('physical_progress_id' => $pp_id, 'pp_activity_id' => $pp_act_id, 'pp_activity_obs_id' => $pp_activity_obs_id);
                                } else {
                                    $errors = 'Observation File Error';
                                    $message = 'Could not upload Observation File';
                                    $status_code = 400;
                                    $data = array('physical_progress_id' => $pp_id, 'pp_activity_id' => $pp_act_id, 'pp_activity_obs_id' => $pp_activity_obs_id);
                                }
                            }    
                        }

                        if (!empty($completion_files)) {
                            //Inserting observation completion files details
                            $allowTypes = array('jpg', 'png', 'jpeg');
                            $uploadDir = 'assets/uploads/observation_completion_files/';

                            //Processing Base64 image
                            foreach ($completion_files as $key => $value) {
                                //Stripping off data:image/jpeg;base64
                                $img = preg_replace('#^data:image/[^;]+;base64,#', '', ltrim($value));
                                $bin = base64_decode($img); //Obtaining the original content

                                $size = getImageSizeFromString($bin); //Gathering information about the image using the GD library

                                // Check the MIME type to be sure that the binary data is an image
                                if (empty($size['mime']) || strpos($size['mime'], 'image/') !== 0) {
                                    $errors = 'Observation Completion File Error';
                                    $message = 'Base64 value is not a valid image';
                                    $status_code = 400;
                                    $data = [];
                                }

                                $ext = substr($size['mime'], 6); //Extracting the image extension

                                //Checking if file type is valid
                                if (!in_array($ext, $allowTypes)) {
                                    $errors = 'Observation Completion File Error';
                                    $message = 'Unsupported Image Type. Only '.implode(',', $allowTypes).' files are allowed to upload.';
                                    $status_code = 400;
                                    $data = [];
                                }

                                $file_name = $key.'_'.$pp_id.'_completion_'.$observation_id.'_'.$ncr_id.'.'.$ext;
                                $file_path = $uploadDir.$file_name;

                                //Uploading the file to directory
                                if (file_put_contents($file_path, $bin)) {
                                    //Saving Observation Completion File details
                                    $completion_file_result = $this->pp_model->saveObservationCompletionFileAPI($pp_activity_obs_id, $file_path, $user_id);
                                } else {
                                    $errors = 'Observation Completion File Error';
                                    $message = 'Could not upload Observation Completion File';
                                    $status_code = 400;
                                    $data = array('physical_progress_id' => $pp_id, 'pp_activity_id' => $pp_act_id, 'pp_activity_obs_id' => $pp_activity_obs_id);
                                }
                            }
                        }
                    }
                    else {
                        $errors = 'Error Saving Observation';
                        $message = 'Failed to save observation details';
                        $status_code = 400;
                        $data = array('physical_progress_id' => $pp_id, 'pp_activity_id' => $pp_act_id);
                    }
                }
            } else {
                $errors = 'Error Saving Observation';
                $message = 'No Observation Photos found';
                $status_code = 400;
                $data = [];
            }
        } else {
            $errors = 'Empty POST Request';
            $message = 'POST Request has no arguments';
            $status_code = 400;
            $data = [];
        }

        $this->response(['errors' => $errors, 'message' => $message, 'status_code' => $status_code, 'data' => $data], REST_Controller::HTTP_OK);
    }

    public function update_observations_post()
    {
        if (!empty($this->post())) {

            $user_id = $this->post('user_id');

            $pp_activity_obs_id = $this->post('physical_progress_activity_observation_id');
            $observation_id = $this->post('observation_id');
            $observation_name = $this->post('observation_name');
            $ncr_id = $this->post('ncr_id');
            $ncr_date = date('Y-m-d', strtotime($this->post('ncr_date')));
            $observation_remark = $this->post('observation_remark');
            $completion_date = (empty($this->post('completion_date')) ? NULL : date('Y-m-d', strtotime($this->post('completion_date'))));
            $observation_files = $this->post('observation_files');
            $completion_files = $this->post('completion_files');

            if (!empty($observation_files)) {
                //Deleting previously saved observation files
                $obs_files_del_result = $this->pp_model->deleteObservationFile($pp_activity_obs_id, $user_id);

                if ($obs_files_del_result) {
                    //Inserting new observation files details
                    if (!empty($observation_files)) {
                        $allowTypes = array('jpg', 'png', 'jpeg');
                        $uploadDir = 'assets/uploads/observation_files/';

                        //Processing Base64 image
                        foreach ($observation_files as $key => $value) {
                            //Stripping off data:image/jpeg;base64
                            $img = preg_replace('#^data:image/[^;]+;base64,#', '', ltrim($value));
                            $bin = base64_decode($img); //Obtaining the original content

                            $size = getImageSizeFromString($bin); //Gathering information about the image using the GD library

                            // Check the MIME type to be sure that the binary data is an image
                            if (empty($size['mime']) || strpos($size['mime'], 'image/') !== 0) {
                                $errors = 'Observation File Error';
                                $message = 'Base64 value is not a valid image';
                                $status_code = 400;
                                $data = [];
                            }

                            $ext = substr($size['mime'], 6); //Extracting the image extension

                            //Checking if file type is valid                            
                            if (!in_array($ext, $allowTypes)) {
                                $errors = 'Observation File Error';
                                $message = 'Unsupported Image Type. Only '.implode(',', $allowTypes).' files are allowed to upload.';
                                $status_code = 400;
                                $data = [];
                            }

                            $file_name = $key.'_observation_'.$observation_id.'_'.$ncr_id.'.'.$ext;
                            $file_path = $uploadDir.$file_name;

                            //Uploading the file to directory
                            if (file_put_contents($file_path, $bin)) {
                                //Saving Observation File details
                                $file_result = $this->pp_model->saveObservationFileAPI($pp_activity_obs_id, $file_path, $user_id);
                            } else {
                                $errors = 'Observation File Error';
                                $message = 'Could not upload Observation File';
                                $status_code = 400;
                                $data = array('pp_activity_obs_id' => $pp_activity_obs_id);
                            }
                        }
                    } else {
                        $errors = 'Error Saving Observation';
                        $message = 'No Observation Photos found';
                        $status_code = 400;
                        $data = [];
                    }
                }
            }            

            if (!empty($completion_files)) {
                //Check if completion files exists
                $obs_completion_check = $this->pp_model->getObservationCompletionFile($pp_activity_obs_id);                

                if (!empty($obs_completion_check)) {
                    // Deleting previously saved completion files
                    $obs_completion_files_del_result = $this->pp_model->deleteObservationCompletionFile($pp_activity_obs_id, $user_id);
                }

                //Inserting observation completion files details
                $allowTypes = array('jpg', 'png', 'jpeg');
                $uploadDir = 'assets/uploads/observation_completion_files/';

                //Processing Base64 image
                foreach ($completion_files as $key => $value) {
                    //Stripping off data:image/jpeg;base64
                    $img = preg_replace('#^data:image/[^;]+;base64,#', '', ltrim($value));
                    $bin = base64_decode($img); //Obtaining the original content

                    $size = getImageSizeFromString($bin); //Gathering information about the image using the GD library

                    // Check the MIME type to be sure that the binary data is an image
                    if (empty($size['mime']) || strpos($size['mime'], 'image/') !== 0) {
                        $errors = 'Observation Completion File Error';
                        $message = 'Base64 value is not a valid image';
                        $status_code = 400;
                        $data = [];
                    }

                    $ext = substr($size['mime'], 6); //Extracting the image extension

                    //Checking if file type is valid
                    if (!in_array($ext, $allowTypes)) {
                        $errors = 'Observation Completion File Error';
                        $message = 'Unsupported Image Type. Only '.implode(',', $allowTypes).' files are allowed to upload.';
                        $status_code = 400;
                        $data = [];
                    }

                    $file_name = $key.'_observation_completion_'.$observation_id.'_'.$ncr_id.'.'.$ext;
                    $file_path = $uploadDir.$file_name;

                    //Uploading the file to directory
                    if (file_put_contents($file_path, $bin)) {
                        //Saving Observation Completion File details
                        $completion_file_result = $this->pp_model->saveObservationCompletionFileAPI($pp_activity_obs_id, $file_path, $user_id);
                    } else {
                        $errors = 'Observation Completion File Error';
                        $message = 'Could not upload Observation Completion File';
                        $status_code = 400;
                        $data = array('pp_activity_obs_id' => $pp_activity_obs_id);
                    }
                }
            }

            $ncr_status_ids = $this->getNCRStatusIDs();
            $obs_status_id = ($completion_date == NULL) ? $ncr_status_ids['Pending'] : $ncr_status_ids['Reviewed'];

            $obs_update_result = $this->pp_model->updateObservation($observation_id, $observation_name, $ncr_id, $ncr_date, $observation_remark, $completion_date, $obs_status_id, $pp_activity_obs_id, $user_id);

            if ($obs_update_result) {
                $errors = null;
                $message = 'Observation Updated successfully';
                $status_code = 200;
                $data = array('pp_activity_obs_id' => $pp_activity_obs_id);
            } else {
                $errors = 'Error Updating Observation';
                $message = 'Could not update observation';
                $status_code = 400;
                $data = array('pp_activity_obs_id' => $pp_activity_obs_id);   
            }
        } else {
            $errors = 'Empty POST Request';
            $message = 'POST Request has no arguments';
            $status_code = 400;
            $data = [];
        }

        $this->response(['errors' => $errors, 'message' => $message, 'status_code' => $status_code, 'data' => $data], REST_Controller::HTTP_OK);        
    }

    public function edit_applied_observation_post()
    {
       if (!empty($this->post())) {
            $pp_activity_obs_id = $this->post('physical_progress_activity_observation_id');

            $sheet_date = ''; //will be used later to fetch submitted sheet applied observations

            //Fetching observation details
            $applied_obs_data = $this->pp_model->getAppliedObservationData($pp_activity_obs_id, $sheet_date);

            if ($applied_obs_data) {
                //Getting Activity Name
                $applied_obs_data['activity'] = $this->pp_model->getActivityData($applied_obs_data['activity_id'], 'activity');

                $observation_files = [];

                //Temporary Code
                $arrContextOptions = array(
                    "ssl" => array(
                        'cafile' => '/path/to/bundle/cacert.pem',
                        "verify_peer" => false,
                        "verify_peer_name" => false
                    ),
                );

                foreach ($applied_obs_data['observation_files'] as $key => $value) {
                    $obs_files = [];
                    $ext = pathinfo($value['file_path'], PATHINFO_EXTENSION);

                    // Get the image and convert into string
                    $file_path = base_url($value['file_path']);
                    $image = file_get_contents($file_path, false, stream_context_create($arrContextOptions));
                    // $image = file_get_contents($file_path);

                    // Encode the image string data into base64
                    $image_base64 = 'data:image/'.$ext.';base64,'.base64_encode($image);

                    array_push($obs_files, $image_base64);
                    array_push($observation_files, $obs_files);
                }

                $applied_obs_data['observation_files'] = [];
                $applied_obs_data['observation_files'] = $observation_files;

                if (!empty($applied_obs_data['observation_files_by_tkc'])) {
                    $observation_files_by_tkc = [];

                    foreach ($applied_obs_data['observation_files_by_tkc'] as $key => $value) {
                        $obs_files_by_tkc = [];
                        $ext = pathinfo($value['file_path'], PATHINFO_EXTENSION);

                        // Get the image and convert into string
                        $file_path = base_url($value['file_path']);
                        $image = file_get_contents($file_path, false, stream_context_create($arrContextOptions));

                        // Encode the image string data into base64
                        $image_base64 = 'data:image/'.$ext.';base64,'.base64_encode($image);

                        array_push($obs_files_by_tkc, $image_base64);
                        array_push($observation_files_by_tkc, $obs_files_by_tkc);
                    }

                    $applied_obs_data['observation_files_by_tkc'] = [];
                    $applied_obs_data['observation_files_by_tkc'] = $observation_files_by_tkc;
                }

                if (!empty($applied_obs_data['completion_files'])) {
                    $completion_files = [];

                    foreach ($applied_obs_data['completion_files'] as $key => $value) {
                        $obs_completion_files =  [];
                        $ext = pathinfo($value['file_path'], PATHINFO_EXTENSION);

                        // Get the image and convert into string
                        $file_path = base_url($value['file_path']);
                        // $image = file_get_contents($file_path);
                        $image = file_get_contents($file_path, false, stream_context_create($arrContextOptions));

                        // Encode the image string data into base64
                        $image_base64 = 'data:image/'.$ext.';base64,'.base64_encode($image);

                        array_push($obs_completion_files, $image_base64);
                        array_push($completion_files, $obs_completion_files);
                    }

                    $applied_obs_data['completion_files'] = [];
                    $applied_obs_data['completion_files'] = $completion_files;
                }

                unset($applied_obs_data['contract_location_id']);

                $errors = null;
                $message = 'Applied Observation Data';
                $status_code = 200;
                $data = $applied_obs_data;
            } else {
                $errors = null;
                $message = 'No Applied Observation found';
                $status_code = 200;
                $data = [];
            }
        } else {
            $errors = 'Empty POST Request';
            $message = 'POST Request has no arguments';
            $status_code = 400;
            $data = [];
        }

        $this->response(['errors' => $errors, 'message' => $message, 'status_code' => $status_code, 'data' => $data], REST_Controller::HTTP_OK);        
    }

    public function delete_applied_observation_post()
    {
        if (!empty($this->post())) {
            $pp_activity_obs_id = $this->post('physical_progress_activity_observation_id');
            $user_id = $this->post('user_id');

            //Deleting the applied observation
            $delete_obs_result = $this->pp_model->deleteObservation($pp_activity_obs_id, $user_id);

            if ($delete_obs_result) {
                //Deleting the applied observation photos
                $delete_obs_file_result = $this->pp_model->deleteObservationFile($pp_activity_obs_id, $user_id);

                //Deleting the applied observation completion photos
                $delete_obs_completion_file_result = $this->pp_model->deleteObservationCompletionFile($pp_activity_obs_id, $user_id);

                $errors = null;
                $message = 'Observation deleted successfully';
                $status_code = 200;
                $data = [];
            } else {
                $errors = 'Observation Delete Error';
                $message = 'Observation deletion failed';
                $status_code = 400;
                $data = [];    
            }
        } else {
            $errors = 'Empty POST Request';
            $message = 'POST Request has no arguments';
            $status_code = 400;
            $data = [];
        }

        $this->response(['errors' => $errors, 'message' => $message, 'status_code' => $status_code, 'data' => $data], REST_Controller::HTTP_OK);
    }

    public function get_applied_observations_list_post()
    {
        if (!empty($this->post())) {
            $contract_location_id = $this->post('contract_location_id');
            $activity_id = $this->post('activity_id');
            $reported_date = date('Y-m-d', strtotime($this->post('reported_date')));

            //Check for observations
            $observations_data = $this->pp_model->getAllAppliedObservations($contract_location_id, $activity_id, $reported_date);

            if (!empty($observations_data)) {                
                foreach ($observations_data as $key => $value) {
                    //Getting Activity Name
                    $observations_data[$key]['activity'] = $this->pp_model->getActivityData($activity_id, 'activity');

                    //Fetching observation files    
                    $observations_files_data = $this->pp_model->getObservationFile($value['physical_progress_activity_observation_id']);
                    $observations_files_count = count($observations_files_data);

                    //Fetching observation completion files
                    $completion_files_data = $this->pp_model->getObservationCompletionFile($value['physical_progress_activity_observation_id']);
                    $completion_files_count = (!empty($completion_files_data)) ? count($completion_files_data) : 0;

                    $observations_data[$key]['ncr_date'] = date('d-m-Y', strtotime($value['ncr_date']));
                    $observations_data[$key]['observation_photo'] = $observations_files_count.' files uploaded';
                    $observations_data[$key]['completed_photo'] = ($completion_files_count == 0) ? '' : $completion_files_count.' files uploaded';

                    $obs_message = 'Applied Observations Data';
                }                
            } else {
                $observations_data = [];

                $obs_message = 'No observations found';
            }

            $errors = null;
            $message = $obs_message;
            $status_code = 200;
            $data = $observations_data;
        } else {
            $errors = 'Empty POST Request';
            $message = 'POST Request has no arguments';
            $status_code = 400;
            $data = [];
        }

        $this->response(['errors' => $errors, 'message' => $message, 'status_code' => $status_code, 'data' => $data], REST_Controller::HTTP_OK);
    }

    public function get_applied_observations_details_post()
    {
        if (!empty($this->post())) {
            $contract_location_id = $this->post('contract_location_id');
            $activity_id = $this->post('activity_id');
            $reported_date = date('Y-m-d', strtotime($this->post('reported_date')));

            $applied_obs_result = $this->pp_model->getAllAppliedObservations($contract_location_id, $activity_id, $reported_date);

            $complete_obs_count = 0;
            $pending_obs_remarks = [];            
            $observation_files = [];

            foreach ($applied_obs_result as $key => $value) {
                if ($value['completion_date'] != '') {
                    $complete_obs_count++;                    
                } else {
                    array_push($pending_obs_remarks, $value['remark']);

                    $pending_obs_files = [];

                    //Fetching observation photos
                    $obs_file_result = $this->pp_model->getObservationFile($value['physical_progress_activity_observation_id']);

                    //Temporary Code
                    $arrContextOptions = array(
                        "ssl" => array(
                            'cafile' => '/path/to/bundle/cacert.pem',
                            "verify_peer" => false,
                            "verify_peer_name" => false
                        ),
                    );

                    //Converting image to base64 encoded
                    foreach ($obs_file_result as $f_key => $f_value) {
                        $ext = pathinfo($f_value['file_path'], PATHINFO_EXTENSION);

                        // Get the image and convert into string
                        $file_path = base_url($f_value['file_path']);
                        // $image = file_get_contents($file_path);
                        $image = file_get_contents($file_path, false, stream_context_create($arrContextOptions));

                        // Encode the image string data into base64
                        $image_base64 = 'data:image/'.$ext.';base64,'.base64_encode($image);
                        array_push($pending_obs_files, $image_base64);
                        array_push($observation_files, $pending_obs_files);
                    }
                }
            }

            $errors = null;
            $message = 'Applied Observation Details';
            $status_code = 200;

            $data['observation_ratio'] = $complete_obs_count .' / '. count($applied_obs_result);
            $data['remark'] = implode(';', $pending_obs_remarks);
            $data['files'] = $observation_files;
        } else {
            $errors = 'Empty POST Request';
            $message = 'POST Request has no arguments';
            $status_code = 400;
            $data = [];
        }

        $this->response(['errors' => $errors, 'message' => $message, 'status_code' => $status_code, 'data' => $data], REST_Controller::HTTP_OK);
    }

    public function get_previous_sheet_dates_post()
    {
        if (!empty($this->post())) {
            $contract_id = $this->post('contract_id');
            $contract_location_id = $this->post('contract_location_id');
            $site_location = $this->post('site_location');

            $previous_sheet_data = $this->pp_model->getPrevSheetDates($contract_id, $contract_location_id, $site_location);

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

    public function search_sheets_post()
    {
        if (!empty($this->post())) {
            $user_id = $this->post('user_id');

            $contractor = $this->post('contractor');
            $tender_award_no = $this->post('tender_award_no');
            $type_of_work = $this->post('type_of_work');
            $site_location = $this->post('site_location');
            $region = $this->post('region');
            $circle = $this->post('circle');
            $division = $this->post('division');
            $reported_by = $this->post('reported_by');
            $reported_date = (!empty($this->post('reported_date'))) ? date('Y-m-d', strtotime($this->post('reported_date'))) : '';
            $feeder_id = $this->post('feeder_id');
            $status = $this->post('status');
            $limit = $this->post('limit');
            $offset = 0;

            $search_result = $this->pp_model->searchSheets($contractor, $tender_award_no, $type_of_work, $site_location, $region, $circle, $division, $reported_by, $reported_date, NULL, $feeder_id, NULL, $status, $user_id, $offset, $limit);
            
            $errors = null;
            $message = (empty($search_result)) ? 'No results found for the specified filters' : 'Search Sheet Result';
            $status_code = 200;

            $data['search_result'] = $search_result; 
        } else {
            $errors = 'Empty POST Request';
            $message = 'POST Request has no arguments';
            $status_code = 400;
            $data = [];
        }

        $this->response(['errors' => $errors, 'message' => $message, 'status_code' => $status_code, 'data' => $data], REST_Controller::HTTP_OK);
    }

    public function change_password_post()
    {
        if (!empty($this->post())) {
            $new_password = $this->post('new_password');
            $retype_password = $this->post('retype_password');

            $user_id = $this->post('user_id');

            $result = $this->security_model->updatePassword($user_id, $retype_password);

            if ($result) {
                $errors = null;
                $message = 'Password updated successfully';
                $status_code = 200;
                $data = []; 
            } else {
                $errors = 'Error Password Updation';
                $message = 'Password update fail';
                $status_code = 400;
                $data = [];
            }
        } else {
            $errors = 'Empty POST Request';
            $message = 'POST Request has no arguments';
            $status_code = 400;
            $data = [];
        }

        $this->response(['errors' => $errors, 'message' => $message, 'status_code' => $status_code, 'data' => $data], REST_Controller::HTTP_OK);
    }

    public function filter_data_post()
    {
        if (!empty($this->post())) {
            $user_id = $this->post('user_id');

            $type_of_work = $this->pp_model->getTypeOfWorkList();
            $region_list = $this->pp_model->getRegionList($user_id);
            // $circle_list = $this->pp_model->getCircleList();
            // $division_list = $this->pp_model->getDivisionList();
            $region_circle_data = $this->pp_model->getRegionCircleData($user_id);
            $circle_list = $this->modifyRegionCircleData($region_circle_data);

            $circle_division_data = $this->pp_model->getCircleDivisionData($user_id);
            $division_list = $this->modifyCircleDivisionData($circle_division_data);

            $status_list = $this->pp_model->getStatusList();

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

    public function get_last_ncr_id_get()
    {
        $last_obs_record = $this->pp_model->fetchLastObservation();

        $last_ncr_id = 0;

        if (!empty($last_obs_record)) {
            $last_ncr_id = $last_obs_record['ncr_id'];
        }

        $data['last_ncr_id'] = $last_ncr_id;

        $errors = null;
        $message = null;
        $status_code = 200;

        $this->response(['errors' => $errors, 'message' => $message, 'status_code' => $status_code, 'data' => $data], REST_Controller::HTTP_OK);
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

    public function calculateTaskRatio($site, $mode, $reported_date = NULL)
    {
        $activities_result = $this->pp_model->getActivitiesList($site['typeofwork_id'], NULL);

        $task_ratio = '-';

        if (!empty($activities_result)) {
            $activities_count = count($activities_result);
            $pp_id = ($mode == 'edit-prev' && empty($reported_date)) ? $site['prev_physical_progress_id'] : $site['physical_progress_id'] ;

            $applied_activities_result = $this->pp_model->getAppliedActivitiesList($pp_id, $site['contract_location_id']);
            $applied_activities_count = 0;

            if (!empty($applied_activities_result)) {
                foreach ($applied_activities_result as $key => $value) {
                    if ($value['status_id'] == 3) {
                        $applied_activities_count++;
                    } elseif ($value['status_id'] == 1) {
                        if (!empty($value['observations_list'])) {
                            if (!empty($value['applied_observations'])) {
                                $obs_completion_count = count($value['applied_observations']);
                                foreach ($value['applied_observations'] as $k1 => $v1) {
                                    if (!empty($v1['completion_photos'])) {
                                        $obs_completion_count--;
                                    }
                                }

                                if ($obs_completion_count == 0) {
                                    $applied_activities_count++;
                                }
                            } else {
                                $applied_activities_count++;
                            }
                        } else {
                            $applied_activities_count++;
                        }
                    }
                }     
            }

            $task_ratio = $applied_activities_count .' / '.$activities_count;     
        }          

        return $task_ratio;
    }

    public function calculateObservationRatio($site)
    {
    	$obs_result = $this->pp_model->getAppliedActivitiesList($site['physical_progress_id'], $site['contract_location_id']);

        if (!empty($obs_result)) {
        	$applied_obs_count = 0;
            $applied_obs_completion_count = 0;

            foreach ($obs_result as $key => $value) {
            	if (!empty($value['applied_observations'])) {
                	$applied_obs_count += count($value['applied_observations']);

                    foreach ($value['applied_observations'] as $k1 => $v1) {
                    	if (!empty($v1['completion_photos'])) {
                        	$applied_obs_completion_count++;
                        }
                    }
                }
            }

            $obs_ratio = $applied_obs_completion_count.' / '.$applied_obs_count;     
        } else {
        	$obs_ratio = '-';
    	}          

    	return $obs_ratio;
    }

    public function getNCRStatusIDs()
    {
        $result = $this->pp_model->getNCRStatusIDs();

        $ncr_status_ids = [];
        foreach ($result as $key => $value) {
            $ncr_status_ids[$value['status_name']] = $value['status_id'];
        }

        return $ncr_status_ids;
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

    public function getUserData($role_id)
    {
        $userrole = $this->pp_model->getUserRole($role_id);
          
        // $userdata['username'] = $username;
        $userdata['role'] = $userrole;

        return $userdata;
    }
}

?>