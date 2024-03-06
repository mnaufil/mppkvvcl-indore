<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class PhysicalProgress extends CI_Controller
{
     function __construct()
     {
          parent::__construct();
 
          $this->load->model('PhysicalProgress_Model', 'pp_model');
        
          if(!$this->session->isUserLoggedIn)
          { 
               redirect('login'); 
          }
     }

     public function index_old()
     {
          $result = $this->pp_model->getPhysicalProgressSheets();
          // $sorted_result_by_location = $this->sortByLocation($result);
          $sorted_result_by_feederID = $this->sortByFeederID($result);
          $sorted_result = $this->sortByStatus($sorted_result_by_feederID);

          foreach ($sorted_result as $key => $value) {
               $task_ratio = $this->calculateTaskRatio($value, 'edit-new');
               $sorted_result[$key]['task_ratio'] = $task_ratio;
          }

          foreach ($sorted_result as $key => $value) {
               $obs_ratio = $this->calculateObservationRatio($value);
               $sorted_result[$key]['obs_ratio'] = $obs_ratio;
          }

          $type_of_work = $this->pp_model->getTypeOfWorkList();
          $region_list = $this->pp_model->getRegionList();
          $circle_list = $this->pp_model->getCircleList();
          $division_list = $this->pp_model->getDivisionList();
          $status_list = $this->pp_model->getStatusList();

          $data['title'] = 'Physical Progress';
          $data['result'] = $sorted_result;
          $data['work_list'] = $type_of_work;
          $data['region_list'] = $region_list;
          $data['circle_list'] = $circle_list;
          $data['division_list'] = $division_list;
          $data['status_list'] = $status_list;
          // echo '<pre>'; print_r($data); echo '</pre>'; die();

          $this->load->view('physical-progress/physical-progress', $data); 
     }

     public function index()
     {
          $pp_list_status_ids = $this->pp_model->getStatusIDsForList();
          $pp_list_status_ids = implode(',', $pp_list_status_ids);
          
          $result = $this->pp_model->getPhysicalProgressSheets($pp_list_status_ids, NULL, 0, 1000);

          foreach ($result as $key => $value) {
               $submitted_by_tkc_ncr = $this->pp_model->getNCRSubmittedByTKCList($value['contract_location_id']);
               $result[$key]['ncr_submitted_by_tkc_count'] = count($submitted_by_tkc_ncr);
          }

          $type_of_work = $this->pp_model->getTypeOfWorkList();

          $region_list = $this->pp_model->getRegionList();
          $region_list = $this->sort_array_by_key($region_list, 'region_name');
          
          /*$circle_list = $this->pp_model->getCircleList();
          $circle_list = $this->sort_array_by_key($circle_list, 'circle_name'); 

          $division_list = $this->pp_model->getDivisionList();
          $division_list = $this->sort_array_by_key($division_list, 'division_name');*/

          $status_list = $this->pp_model->getStatusList();
          $status_list = $this->sort_array_by_key($status_list, 'seqno');

          $region_circle_data = $this->pp_model->getRegionCircleData();
          $region_circle_data = $this->modifyRegionCircleData($region_circle_data);

          $circle_division_data = $this->pp_model->getCircleDivisionData();
          $circle_division_data = $this->modifyCircleDivisionData($circle_division_data);

          $user_access_data = $this->pp_model->getUserModuleAccess();
          $user_access = $this->sortUserModuleAccess($user_access_data);

          $data['title'] = 'Physical Verification';
          $data['result'] = $result;
          $data['work_list'] = $type_of_work;
          $data['region_list'] = $region_list;
          /*$data['circle_list'] = $circle_list;
          $data['division_list'] = $division_list;*/
          $data['region_circle_data'] = $region_circle_data;
          $data['circle_division_data'] = $circle_division_data;
          $data['status_list'] = $status_list;
          $data['user_access'] = $user_access;

          // echo '<pre>'; print_r($data); echo '</pre>'; die();
          $this->load->view('physical-progress/physical-progress', $data); 
     }     

     public function searchSheet()
     {
          if (!empty($_POST)) {
               $filter_arr = [];

               $contractor = $this->input->post('contractor');
               $filter_arr['contractor']['label'] = 'Contractor (TKC)';
               $filter_arr['contractor']['value'] = $contractor;

               $tender_award_no = $this->input->post('tenderAwardNo');
               $filter_arr['tenderAwardNo']['label'] = 'Contract No.';
               $filter_arr['tenderAwardNo']['value'] = $tender_award_no;

               $type_of_work = (isset($_POST['typeOfWork'])) ? $this->input->post('typeOfWork') : '';
               $filter_arr['typeOfWork']['label'] = 'Type Of Work';
               $filter_arr['typeOfWork']['value'] = (isset($_POST['typeOfWork'])) ? $this->pp_model->getTypeOfWork($type_of_work) : '';
               $filter_arr['typeOfWork']['id'] = $type_of_work;

               $site_location = $this->input->post('siteLocation');
               $filter_arr['siteLocation']['label'] = 'Site Location';
               $filter_arr['siteLocation']['value'] = $site_location;

               $region = (isset($_POST['region'])) ? $this->input->post('region') : '';
               $filter_arr['region']['label'] = 'Region';
               $filter_arr['region']['value'] = (isset($_POST['region'])) ? $this->pp_model->getRegion($region) : '';
               $filter_arr['region']['id'] = $region;

               $circle = (isset($_POST['circle'])) ? $this->input->post('circle') : '';
               $filter_arr['circle']['label'] = 'Circle';
               $filter_arr['circle']['value'] = (isset($_POST['circle'])) ? $this->pp_model->getCircle($circle) : '';
               $filter_arr['circle']['id'] = $circle;

               $division = (isset($_POST['division'])) ? $this->input->post('division') : '';
               $filter_arr['division']['label'] = 'Division';
               $filter_arr['division']['value'] = (isset($_POST['division'])) ? $this->pp_model->getDivision($division) : '';
               $filter_arr['division']['id'] = $division;

               $reported_by = $this->input->post('reportedBy');
               $reported_by_id = (!empty($reported_by)) ? $this->pp_model->getReportedByID($reported_by, 'LIKE') : '';
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
                         array_push($status_values, $this->pp_model->getSheetStatus($value));
                    }
               }
               $filter_arr['status']['value'] = (!empty($status_values)) ? implode(', ', $status_values) : '';
               $filter_arr['status']['id'] = $this->input->post('status');

               $search_result = $this->pp_model->searchSheets($contractor, $tender_award_no, $type_of_work, $site_location, $region, $circle, $division, $reported_by_id, $formatted_reported_date, $feeder_id, $status, NULL, 0, 1000);

               foreach ($search_result as $key => $value) {
                    $submitted_by_tkc_ncr = $this->pp_model->getNCRSubmittedByTKCList($value['contract_location_id']);
                    $search_result[$key]['ncr_submitted_by_tkc_count'] = count($submitted_by_tkc_ncr);
               }

               $user_access_data = $this->pp_model->getUserModuleAccess();
               $user_access = $this->sortUserModuleAccess($user_access_data);

               // $sorted_result = $this->sortByStatus($search_result, 'search');

               /*foreach ($sorted_result as $key => $value) {
                    $task_ratio = $this->calculateTaskRatio($value, 'edit-new');
                    $sorted_result[$key]['task_ratio'] = $task_ratio;
               }

               foreach ($sorted_result as $key => $value) {
                    $obs_ratio = $this->calculateObservationRatio($value);
                    $sorted_result[$key]['obs_ratio'] = $obs_ratio;
               }*/

               $data['title'] = 'Physical Progress';
               // $data['result'] = $sorted_result;
               $data['result'] = $search_result;

               $data['filters'] = $filter_arr;
               
               $data['work_list'] = $this->pp_model->getTypeOfWorkList();

               $region_list = $this->pp_model->getRegionList();
               $data['region_list'] = $this->sort_array_by_key($region_list, 'region_name');

               // $circle_list = $this->pp_model->getCircleList();
               if (!empty($region)) {
                    $circle_list = $this->pp_model->getCircleListOfRegion($region);
                    $data['circle_list'] = $this->sort_array_by_key($circle_list, 'circle_name');
               }

               // $division_list = $this->pp_model->getDivisionList();
               if (!empty($circle)) {
                    $division_list = $this->pp_model->getDivisionListOfCircle($circle);
                    $data['division_list'] = $this->sort_array_by_key($division_list, 'division_name');
               }

               $region_circle_data = $this->pp_model->getRegionCircleData();
               $region_circle_data = $this->modifyRegionCircleData($region_circle_data);

               $circle_division_data = $this->pp_model->getCircleDivisionData();
               $circle_division_data = $this->modifyCircleDivisionData($circle_division_data);

               $data['region_circle_data'] = $region_circle_data;
               $data['circle_division_data'] = $circle_division_data;

               $status_list = $this->pp_model->getStatusList();
               $data['status_list'] = $this->sort_array_by_key($status_list, 'seqno');
               $data['user_access'] = $user_access;

               $this->load->view('physical-progress/physical-progress', $data); 
          }
     }

     public function editSheet($mode, $ppsheet_id, $contract_id, $contract_location_id)
     {
          if ($this->checkLocationAccess($contract_location_id)) {
               $sheet_result = $this->pp_model->getSheetDetail($mode, $ppsheet_id, $contract_id, $contract_location_id);
               
               //Setting physical_progress_id of editing sheet as prev_physical_progress_id
               $sheet_result['prev_physical_progress_id'] = $sheet_result['physical_progress_id'];

               //Setting physical_progress_id to blank
               $sheet_result['physical_progress_id'] = '';

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

               if ($mode == 'edit-prev' || $mode == 'view' || $mode == 'edit-review') {
                    /*Formatting Reported Date*/
                    $reported_date = date("d-m-Y", strtotime($sheet_result['reported_date']));
                    $sheet_result['reported_date'] = $reported_date;

                    //Getting previously edited sheet dates
                    $prev_sheet_dates = $this->pp_model->getPrevSheetDates($sheet_result['contract_id'], $sheet_result['contract_location_id'], $sheet_result['site_location']);               

                    if ($sheet_result['reported_date'] == date('d-m-Y')) {
                         $sheet_result['sheet_mode'] = 'update';

                         if ($mode == 'edit-prev') {
                              array_pop($prev_sheet_dates);     
                         }
                         
                         $data['prev_sheet_dates'] = $prev_sheet_dates;

                         //Setting physical_progress_id to latest ID
                         $sheet_result['physical_progress_id'] = $sheet_result['prev_physical_progress_id'];
                    } else {
                         $data['prev_sheet_dates'] = $prev_sheet_dates;
                    }

                    if ($mode == 'edit-review') {
                         //Setting physical_progress_id to latest ID
                         $sheet_result['physical_progress_id'] = $sheet_result['prev_physical_progress_id'];
                    }
               }

               $data['sheet_data'] = $sheet_result;
               $data['title'] = 'Physical Verification';
               $data['page_title'] = 'Physical Verification - Feeder ID['.$sheet_result['feeder_id'].']';

               $data['userdata'] = $this->getUserData();
               // echo 'data: <pre>'; print_r($data); echo '</pre>'; die();
               $this->load->view('physical-progress/add-physical-progress', $data);    
          } else {
               redirect('authorization_failed');
          }
     }

     public function checkLocationAccess($contract_location_id)
     {
          $contract_location_data = $this->pp_model->getContractLocationData($contract_location_id);
          $region_id = $contract_location_data['region_id'];
          
          $user_access_regions = $_SESSION['myRegions'];

          if (in_array($region_id, $user_access_regions)) {
               return true;
          }

          return false;
     }

     public function saveSheet()
     {
          if (!empty($_POST)) {
               $post_data = $this->input->post();
               
               $pp_id = $this->input->post('physical_progress_id');
               $prev_pp_id = $this->input->post('prev_physical_progress_id');
               $contract_id = $this->input->post('contract_id');
               $contract_location_id = $this->input->post('contract_location_id');
               $site_location = $this->input->post('siteLocation');
               $reported_by_name = $this->input->post('reportedBy');
               $reported_by_id = $this->pp_model->getReportedByID($reported_by_name);
               $reported_date = date('Y-m-d', strtotime($this->input->post('reportedDate')));
               $remark = $this->input->post('sheetRemark');
               $status_id = 2;
               $is_draft = 0;

               $uriSegments = explode("/", parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH));
               $mode = array_slice($uriSegments, -4);

               if (empty($pp_id)) {
                    $pp_id = $this->pp_model->savePhysicalProgressSheet($contract_id, $contract_location_id, $site_location, $reported_by_id, $reported_date, $remark, $status_id, $is_draft);
                    if ($mode[0] == 'edit-prev') {
                         //For replicating data from previously saved sheet
                         $activities_check = $this->pp_model->checkActivities($prev_pp_id);

                         foreach ($activities_check as $key => $value) {
                              $this->pp_model->saveActivity($pp_id, $value['sr_no'], $value['activity_id'], $value['unit_id'], $value['status_id'], $value['erected_qty']);
                         }
                    }
               } else {
                    $pp_id = $this->pp_model->updatePhysicalProgressSheet($pp_id, $contract_id, $contract_location_id, $site_location, $reported_by_id, $reported_date, NULL, NULL,$remark, $status_id, $is_draft);
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

                         $civil_work_activities[$key]['physical_progress_id'] = $pp_id;
                         $civil_work_activities[$key]['activity_id'] = end($input_name);
                         $civil_work_activities[$key]['activity_status_id'] = $this->calculateStatusForWithoutBOQ($value);
                         $civil_work_activities[$key]['erected_qty'] = NULL;
                    }

                    if (str_contains($key, 'electrical')) { //withoutBOQ
                         $input_name = explode('_', $key);

                         $electrical_activities[$key]['physical_progress_id'] = $pp_id;
                         $electrical_activities[$key]['activity_id'] = end($input_name);
                         $electrical_activities[$key]['activity_status_id'] = $this->calculateStatusForWithoutBOQ($value);
                         $electrical_activities[$key]['erected_qty'] = NULL;
                    }

                    if (str_contains($key, 'sub-station_items')) { //withoutBOQ
                         $input_name = explode('_', $key);

                         $substation_activities[$key]['physical_progress_id'] = $pp_id;
                         $substation_activities[$key]['activity_id'] = end($input_name);
                         $substation_activities[$key]['activity_status_id'] = $this->calculateStatusForWithoutBOQ($value);
                         $substation_activities[$key]['erected_qty'] = NULL;
                    }

                    if (str_contains($key, '33kv_feeder')) { //withBOQ
                         if (str_contains($key,'observation')) {
                              $observation_flag = $value;
                              continue;
                         }

                         if (str_contains($key, 'boq')) {
                              $boq_val = (int)$value;
                              continue;
                         }

                         $erected_val = (int)$value;
                         
                         $input_name = explode('_', $key);
                         $feeder_33kv_activities[$key]['physical_progress_id'] = $pp_id;
                         $feeder_33kv_activities[$key]['activity_id'] = end($input_name);
                         $activity_status_id =  $feeder_33kv_activities[$key]['activity_status_id'] = $this->calculateStatusForWithBOQ($erected_val, $boq_val, $observation_flag);
                         $feeder_33kv_activities[$key]['erected_qty'] = $value;
                    }

                    if (preg_match('/\b11kv_feeder_\d/', $key) || preg_match('/\b11kv_feeder_boq_\d/', $key) || preg_match('/\b11kv_feeder_observation_\d/', $key)) { //withBOQ
                         if (str_contains($key,'observation')) {
                              $observation_flag = $value;
                              continue;
                         }

                         if (str_contains($key, 'boq')) {
                              $boq_val = (int)$value;
                              continue;
                         }

                         $erected_val = (int)$value;

                         $input_name = explode('_', $key);
                         $feeder_11kv_activities[$key]['physical_progress_id'] = $pp_id;
                         $feeder_11kv_activities[$key]['activity_id'] = end($input_name);
                         $feeder_11kv_activities[$key]['activity_status_id'] = $this->calculateStatusForWithBOQ($erected_val, $boq_val, $observation_flag);
                         $feeder_11kv_activities[$key]['erected_qty'] = $value;
                    }

                    if (str_contains($key, '11kv_feeder_separation')) { //withBOQ
                         if (str_contains($key,'observation')) {
                              $observation_flag = $value;
                              continue;
                         }

                         if (str_contains($key, 'boq')) {
                             $boq_val = (int)$value;
                              continue; 
                         }

                         $erected_val = (int)$value;

                         $input_name = explode('_', $key);
                         $feeder_separation_11kv_activities[$key]['physical_progress_id'] = $pp_id;
                         $feeder_separation_11kv_activities[$key]['activity_id'] = end($input_name);
                         $feeder_separation_11kv_activities[$key]['activity_status_id'] = $this->calculateStatusForWithBOQ($erected_val, $boq_val, $observation_flag);
                         $feeder_separation_11kv_activities[$key]['erected_qty'] = $value;
                    }

                    if (str_contains($key, '33kv_interconnection_line')) { //withBOQ
                         if (str_contains($key,'observation')) {
                              $observation_flag = $value;
                              continue;
                         }

                         if (str_contains($key, 'boq')) {
                             $boq_val = (int)$value;
                              continue; 
                         }

                         $erected_val = (int)$value;

                         $input_name = explode('_', $key);
                         $interconnection_line_33kv_activites[$key]['physical_progress_id'] = $pp_id;
                         $interconnection_line_33kv_activites[$key]['activity_id'] = end($input_name);
                         $interconnection_line_33kv_activites[$key]['activity_status_id'] = $this->calculateStatusForWithBOQ($erected_val, $boq_val, $observation_flag);
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
                         $check_result = $this->pp_model->checkActivity($v1['activity_id'], $v1['physical_progress_id']);

                         if (empty($check_result)) {
                              $seqno = $this->pp_model->getActivityData($v1['activity_id'], 'seqno');
                              $unit_id = $this->pp_model->getActivityData($v1['activity_id'], 'unit_id');

                              if (!empty($v1['physical_progress_id'])) {
                                   $activity_insert_id = $this->pp_model->saveActivity($v1['physical_progress_id'], $seqno, $v1['activity_id'], $unit_id, $v1['activity_status_id'], $v1['erected_qty']);     
                              }
                         } else {
                              $row_affected = $this->pp_model->updateActivity($v1['physical_progress_id'], $v1['activity_id'], $v1['activity_status_id'], $v1['erected_qty']);
                         }
                    }
               }

               $remaining_activity_count = $this->pp_model->getAppliedActivitiesListForSheetStatusCalculation($pp_id);
               if ($remaining_activity_count == 0) {                    

                    if (isset($_FILES['completionFile']) && $_FILES['completionFile']['error'][0] != 4) {
                         $ppsheet_completion_photo = $_FILES['completionFile'];
                         $allowTypes = array('jpg', 'png', 'jpeg');
                         $last_file_no = 0;

                         $uploadDir = 'assets/uploads/physical_progress_completion_files/';

                         foreach ($ppsheet_completion_photo['name'] as $key => $value) {
                              $ext = pathinfo($value, PATHINFO_EXTENSION);
                              $last_file_no++;

                              // File upload path 
                              // $fileName = $pp_id.'_completion_file_'.$key.'.'.$ext;
                              $fileName = $pp_id.'_completion_file_'.$last_file_no.'.'.$ext;
                              $targetFilePath = $uploadDir . $fileName;

                              // Check whether file type is valid
                              if (in_array($ext, $allowTypes)) {
                                   // Upload file to server
                                   if (move_uploaded_file($ppsheet_completion_photo['tmp_name'][$key], $targetFilePath))
                                   {
                                        //Saving physical progress completion file details
                                        $file_result = $this->pp_model->savePhysicalProgressCompletionFile($pp_id, $targetFilePath);
                                        if ($file_result) {
                                             // $status_id = 3;
                                             $pp_status_ids = $this->pp_model->getStatusList();
                                             $pp_status_ids = $this->modify_pp_status_ids($pp_status_ids);

                                             $status_id = $pp_status_ids['Reviewed'];
                                             $this->pp_model->updateSheetStatus($pp_id, $status_id);
                                        }
                                   }
                              }
                         }
                    }                    
               }

               redirect('physical-verification');
          }
     }

     public function getSheetDataByDate($reported_date, $ppsheet_id, $contract_id, $contract_location_id)
     {
          $mode = 'view-by-date';
          $sheet_result = $this->pp_model->getSheetDetail($mode, $ppsheet_id, $contract_id, $contract_location_id, $reported_date);

          /*Formatting Tender Award Date*/
          $award_date = date("d-m-Y", strtotime($sheet_result['tender_award_date']));
          $sheet_result['tender_award_date'] = $award_date;

          $sheet_result['task_ratio'] = $this->calculateTaskRatio($sheet_result, $mode, $reported_date);

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
          $last_filled_sheet = $this->pp_model->getLastFilledPhysicalProgressSheet($contract_id, $contract_location_id);
          if ($last_filled_sheet['status_id'] == '3') {
               $data['future_sheet_status'] = 'Completed';
          }

          //Getting previously edited sheet dates
          $prev_sheet_dates = $this->pp_model->getPrevSheetDates($sheet_result['contract_id'], $sheet_result['contract_location_id'], $sheet_result['site_location']);
          $data['prev_sheet_dates'] = $prev_sheet_dates;

          $data['sheet_data'] = $sheet_result;
          $data['title'] = 'Physical Progress';
          $data['page_title'] = 'Physical Progress - Feeder ID['.$sheet_result['feeder_id'].']';

          $data['userdata'] = $this->getUserData();

          $this->load->view('physical-progress/add-physical-progress', $data);          
     }

     public function getObservation()
     {
          $obs_data = array();          

          if (!empty($_POST)) {
               $pp_activity_obs_id = $this->input->post('pp_activity_obs_id');
               $sheet_date = $this->input->post('sheet_date');

               $obs_data = $this->pp_model->getAppliedObservationData($pp_activity_obs_id, $sheet_date);
          }

          $response['obs_data'] = $obs_data;

          echo json_encode($response);
     }

     public function saveObservation()
     {
          //Default Response
          http_response_code(200);
          $response['message'] = 'Save Observation success';

          if (!empty($_POST)) {
               $contract_location_id = $this->input->post('contract_location_id');
               $pp_id = $this->input->post('physical_progress_id');
               $prev_pp_id = $this->input->post('prev_physical_progress_id');
               $sr_no = $this->input->post('seq_no');
               $work_activity_id = $this->input->post('activity_id');
               $unit_id = $this->input->post('unit_id');
               // $activity_status_id = $this->input->post('activity_status_id');
               $erected_qty = (!empty($this->input->post('erected_qty')) ? $this->input->post('erected_qty') : NULL);

               //Observation Details from the modal
               $observation_id = $this->input->post('observation');
               $observation_name = $this->input->post('observation_name');
               $ncr_id = $this->input->post('ncrID');
               $ncr_date = date('Y-m-d', strtotime($this->input->post('ncrDate')));
               $remark = $this->input->post('remark');
               $completion_date = (empty($this->input->post('completionDate'))) ? NULL : date('Y-m-d', strtotime($this->input->post('completionDate')));
               $action = $this->input->post('action');

               if ($action == 'add') {
                    if (empty($pp_id)) {
                         //Getting data of previous physical progress sheet
                         $prev_pp_sheet_data = $this->pp_model->getSheetData($prev_pp_id);

                         $is_draft = 1;

                         //Saving current sheet and getting its physical_progress_id
                         $pp_id = $this->pp_model->savePhysicalProgressSheet($prev_pp_sheet_data['contract_id'], $prev_pp_sheet_data['contract_location_id'], $prev_pp_sheet_data['site_location'], NULL, NULL, NULL, $prev_pp_sheet_data['status_id'], $is_draft);
                    }

                    //Check if entry has been made for activity
                    $activity_check = $this->pp_model->checkActivity($work_activity_id, $pp_id);

                    if (empty($activity_check)) {
                         $status_id = (empty($completion_date)) ? 2 : 1;

                         //Inserting data in physical_progress_activity table and getting last inserted id
                         $pp_activity_id = $this->pp_model->saveActivity($pp_id, $sr_no, $work_activity_id, $unit_id, $status_id, $erected_qty);
                    } else {
                         $pp_activity_id = $activity_check['physical_progress_activity_id'];
                    }

                    if ($pp_activity_id) {
                         $ncr_status_ids = $this->getNCRStatusIDs();
                         $obs_status_id = (empty($completion_date)) ? $ncr_status_ids['Pending'] : $ncr_status_ids['Reviewed'];
                         //Inserting data in physical_progress_activity_observation table and getting last inserted id
                         $inserted_observation_id = $this->pp_model->saveObservation($contract_location_id, $work_activity_id, $observation_id, $observation_name, $ncr_id, $ncr_date, $remark, $completion_date, $obs_status_id);
                    } else {
                         http_response_code(400);
                         $response['message'] = 'Insert Activity failed';
                    }
               } elseif ($action == 'edit') {
                    $response['message'] = 'Update Observation success';
                    if (empty($pp_id)) {
                         //Getting data of previous physical progress sheet
                         $prev_pp_sheet_data = $this->pp_model->getSheetData($prev_pp_id);

                         $is_draft = 1;

                         //Saving current sheet and getting its physical_progress_id
                         $pp_id = $this->pp_model->savePhysicalProgressSheet($prev_pp_sheet_data['contract_id'], $prev_pp_sheet_data['contract_location_id'], $prev_pp_sheet_data['site_location'], NULL, NULL, NULL, $prev_pp_sheet_data['status_id'], $is_draft);
                    }

                    //Check if entry has been made for activity
                    $activity_check = $this->pp_model->checkActivity($work_activity_id, $pp_id);

                    if (empty($activity_check)) {
                         $status_id = (empty($completion_date)) ? 2 : 1;

                         //Inserting data in physical_progress_activity table and getting last inserted id
                         $pp_activity_id = $this->pp_model->saveActivity($pp_id, $sr_no, $work_activity_id, $unit_id, $status_id, $erected_qty);
                    } else {
                         $pp_activity_id = $activity_check['physical_progress_activity_id'];    
                    }

                    if ($pp_activity_id) {
                         $pp_activity_obs_id = $this->input->post('pp_activity_obs_id');

                         $ncr_status_ids = $this->getNCRStatusIDs();
                         $obs_status_id = (empty($completion_date)) ? $ncr_status_ids['Pending'] : $ncr_status_ids['Reviewed'];

                         //Updating data in physical_progress_activity_observation table and returning updated id
                         $inserted_observation_id = $this->pp_model->updateObservation($observation_id, $observation_name, $ncr_id, $ncr_date, $remark, $completion_date, $obs_status_id, $pp_activity_obs_id);     
                    }
               }

               $response['action'] = $action;
               $response['inserted_observation_id'] = $inserted_observation_id;

               if ($inserted_observation_id) {
                    $obs_file = $_FILES['obs_photo'];
                    $obs_completion_file = $_FILES['completion_photo'];

                    $allowTypes = array('jpg', 'png', 'jpeg');

                    //Observation Photos
                    if ($action == 'edit' && isset($_POST['obs_deleted_file_id'])) {
                         // $deleted_prev_files = $this->pp_model->deleteObservationFile($inserted_observation_id);
                         $obs_deleted_file_id = explode(',', $this->input->post('obs_deleted_file_id'));

                         foreach ($obs_deleted_file_id as $key => $value) {
                              $deleted_prev_files = $this->pp_model->deleteObservationFile_new($value);
                         }
                    }

                    if ($obs_file['error'][0] != 4) {
                         $response['file_data'] = [];
                         $uploadDir = 'assets/uploads/observation_files/';

                         if ($action == 'add') {
                              $last_file_no = 0;
                         } elseif ($action == 'edit') {
                              $last_file_data = $this->pp_model->getLastObservationFileData($inserted_observation_id);

                              $last_file_data = explode('/', $last_file_data);
                              $last_file_data = end($last_file_data);
                              $last_file_no = explode('_', $last_file_data);
                              $last_file_no = current($last_file_no);
                         }

                         foreach ($obs_file['name'] as $key => $value) {
                              $ext = pathinfo($value, PATHINFO_EXTENSION);
                              $last_file_no++;

                              // File upload path
                              // $fileName = $key.'_'.$pp_id.'_observation_'.$observation_id.'_'.$ncr_id.'.'.$ext;
                              $fileName = $last_file_no.'_observation_'.$observation_id.'_'.$ncr_id.'.'.$ext;
                              $targetFilePath = $uploadDir . $fileName;

                              // Check whether file type is valid
                              if (in_array($ext, $allowTypes)) {
                                   // Upload file to server
                                   if (move_uploaded_file($obs_file['tmp_name'][$key], $targetFilePath)) {
                                        
                                        $pp_activity_obs_id = $inserted_observation_id;
                                        $file_path = $targetFilePath;
                                        
                                        $result = $this->pp_model->saveObservationFile($pp_activity_obs_id, $file_path);

                                        if (!$result) {
                                             http_response_code(400);
                                             $response['message'] = 'Insert Observation File failed';  
                                        } else {
                                             array_push($response['file_data'], $file_path);
                                        }

                                   } else {
                                        http_response_code(400);
                                        $response['message'] = 'Error uploading file';
                                   }
                              } else {
                                   http_response_code(400);
                                   $response['message'] = 'Only '.implode(',', $allowTypes).' files are allowed to upload.';
                              }
                         }
                    }

                    //Observation Completion Photos
                    if ($action == 'edit' && isset($_POST['obs_completion_deleted_file_id'])) {
                         $obs_completion_deleted_file_id = explode(',', $this->input->post('obs_completion_deleted_file_id'));

                         foreach ($obs_completion_deleted_file_id as $key => $value) {
                              $deleted_prev_files = $this->pp_model->deleteObservationCompletionFile_new($value);
                         }
                    }
                    if ($obs_completion_file['error'][0] != 4) {
                         $uploadDir = 'assets/uploads/observation_completion_files/';

                         if ($action == 'add') {
                              $last_file_no = 0;
                         } elseif ($action == 'edit') {
                              $last_file_data = $this->pp_model->getLastObservationCompletionFileData($inserted_observation_id);

                              if (!empty($last_file_data)) {
                                   $last_file_data = explode('/', $last_file_data);
                                   $last_file_data = end($last_file_data);
                                   $last_file_no = explode('_', $last_file_data);
                                   $last_file_no = current($last_file_no);     
                              } else {
                                   $last_file_no = 0;  
                              }                             
                         }

                         foreach ($obs_completion_file['name'] as $key => $value) {                              
                              $ext = pathinfo($value, PATHINFO_EXTENSION);
                              $last_file_no++;

                              // File upload path
                              // $fileName = $key.'_'.$pp_id.'_completion_'.$observation_id.'_'.$ncr_id.'.'.$ext;
                              $fileName = $last_file_no.'_completion_'.$observation_id.'_'.$ncr_id.'.'.$ext;
                              $targetFilePath = $uploadDir . $fileName;

                              // Check whether file type is valid
                              if (in_array($ext, $allowTypes)) {
                                   // Upload file to server
                                   if (move_uploaded_file($obs_completion_file['tmp_name'][$key], $targetFilePath))
                                   {
                                        $pp_activity_obs_id = $inserted_observation_id;
                                        $file_path = $targetFilePath;

                                        $result = $this->pp_model->saveObservationCompletionFile($pp_activity_obs_id, $file_path);

                                        if (!$result) {
                                             http_response_code(400);
                                             $response['message'] = 'Insert Observation File failed';  
                                        }
                                   } else {
                                        http_response_code(400);
                                        $response['message'] = 'Error uploading file';
                                   }
                              } else {
                                   http_response_code(400);
                                   $response['message'] = 'Only '.implode(',', $allowTypes).' files are allowed to upload.';
                              }  
                         }
                    }

                    $response['observation_id'] = $inserted_observation_id;
               } else {
                    http_response_code(400);
                    $response['message'] = 'Insert Observation failed';
               }

               $response['physical_progress_id'] = $pp_id;
               
               echo json_encode($response);
          }
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

     public function deleteObservation()
     {
          //Default Response
          http_response_code(400);
          $response['message'] = 'Delete Observation failed';

          if (!empty($_POST)) {
               $observation_id = $this->input->post('observation_id');

               //Deleting the applied observation
               $result = $this->pp_model->deleteObservation($observation_id);

               if ($result) {
                    //Deleting the applied observation photos
                    $obs_file_result = $this->pp_model->deleteObservationFile($observation_id);

                    //Deleting the applied observation completion photos
                    $obs_completion_file_result = $this->pp_model->deleteObservationCompletionFile($observation_id);

                    http_response_code(200);
                    $response['message'] = 'Delete Observation success';
               }
          }

          echo json_encode($response);
     }

     public function markReviewedSheetComplete()
     {
          //Default Response
          http_response_code(200);
          $response['message'] = 'Marked Physical Progress Sheet as Completed';

          if (!empty($_POST)) {
               $pp_id = $this->input->post('pp_id');
               $sheet_remark = (isset($_POST['sheet_remark'])) ? $this->input->post('sheet_remark') : NULL;
               $sheet_completion_deleted_file_id = $this->input->post('sheet_completion_deleted_file_id');

               if (!empty($sheet_completion_deleted_file_id)) {
                    $deleted_file_id = explode(',', $sheet_completion_deleted_file_id);

                    foreach ($deleted_file_id as $key => $value) {
                         // Deleting previously uploaded sheet completion file details from table
                         $file_result = $this->pp_model->deletePhysicalProgressCompletionFile_new($value);     
                    }                    
               }               

               if (!empty($_FILES)) {
                    $sheet_completion_files = $_FILES['sheet_completion_files'];

                    if ($sheet_completion_files['error'][0] != 4) {
                         $allowTypes = array('jpg', 'png', 'jpeg');
                         $uploadDir = 'assets/uploads/physical_progress_completion_files/';

                         $last_file_data = $this->pp_model->getLastPhysicalProgressFileData($pp_id);

                         if (!empty($last_file_data)) {
                              $last_file_data = explode('/', $last_file_data);
                              $last_file_data = end($last_file_data);
                              $last_file_no = explode('_', $last_file_data);
                              $last_file_no = end($last_file_no);
                              $last_file_no = explode('.', $last_file_no);
                              $last_file_no = current($last_file_no);
                         }

                         foreach ($sheet_completion_files['name'] as $key => $value) {
                              $ext = pathinfo($value, PATHINFO_EXTENSION);
                              $last_file_no++;

                              // File upload path 
                              // $fileName = $pp_id.'_completion_file_'.$key.'.'.$ext;
                              $fileName = $pp_id.'_completion_file_'.$last_file_no.'.'.$ext;
                              $targetFilePath = $uploadDir . $fileName;

                              // Check whether file type is valid
                              if (in_array($ext, $allowTypes)) {
                                   // Upload file to server
                                   if (move_uploaded_file($sheet_completion_files['tmp_name'][$key], $targetFilePath)) {
                                        //Saving physical progress completion file details
                                        $file_result = $this->pp_model->savePhysicalProgressCompletionFile($pp_id, $targetFilePath);
                                   }
                              }
                         }
                    }
               }

               $pp_status_ids = $this->pp_model->getStatusList();
               $pp_status_ids = $this->modify_pp_status_ids($pp_status_ids);

               $status_id = $pp_status_ids['Completed'];

               $result = $this->pp_model->updateSheetStatus($pp_id, $status_id, $sheet_remark);

               if (!$result) {
                    http_response_code(400);
                    $response['message'] = 'Failed to mark Physical Progress Sheet as Completed';
               }
          }

          echo json_encode($response);
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

     public function calculateStatusForWithBOQ($erected_val, $boq_val, $observation_flag)
     {
          if ($erected_val == 0) {
               return $status_id = 0;
          } elseif ($erected_val > 0 && $erected_val < $boq_val) {
               return $status_id = 2;
          } elseif ($erected_val == $boq_val) {
               if ($observation_flag == 'no observation' || $observation_flag == 'observation complete') {
                    return $status_id = 1;
               } elseif ($observation_flag == 'observation pending') {
                    return $status_id = 2;
               }
          }
     }

     public function checkAppliedObservationsExists()
     {
          if (!empty($_POST)) {
               $activity_id = $this->input->post('activity_id');
               $contract_location_id = $this->input->post('contract_location_id');

               $applied_obs_data = $this->pp_model->checkAppliedObservationsExists($contract_location_id, $activity_id);
               $response['applied_obs_count'] = count($applied_obs_data);

               echo json_encode($response);
          }
     }

     public function deleteAllAppliedObservations()
     {
          if (!empty($_POST)) {
               $activity_id = $this->input->post('activity_id');
               $contract_location_id = $this->input->post('contract_location_id');

               //Fetching all observation IDs applied against the activity
               $obs_result = $this->pp_model->getAllAppliedObservations($contract_location_id, $activity_id);
               
               $delete_result = $this->pp_model->deleteAllAppliedObservations($contract_location_id, $activity_id);

               if ($delete_result) {
                    foreach ($obs_result as $key => $value) {
                         //Deleting the applied observation photos
                         $obs_file_result = $this->pp_model->deleteObservationFile($value['physical_progress_activity_observation_id']); 

                         if ($value['completion_date'] != '') {
                              //Deleting the applied observation completion photos
                              $obs_completion_file_result = $this->pp_model->deleteObservationCompletionFile($value['physical_progress_activity_observation_id']);     
                         }
                    }

                    //Getting activity name to show on toaster alert
                    $activity_name = $this->pp_model->getActivityData($activity_id, 'activity');
                    $response['activity_name'] = $activity_name;
               }

               $response['deleted_obs_count'] = $delete_result;

               echo json_encode($response);
          }
     }

     public function getActivityDetail()
     {
          //Default Response
          http_response_code(400);
          $response['message'] = 'Get Activity failed';

          if (!empty($_POST['activity_id'])) {
               $pp_id = $this->input->post('pp_id');
               $activity_id = $this->input->post('activity_id');
               $contract_location_id = $this->input->post('contract_location_id');
               $prev_pp_id = $this->input->post('prev_pp_id');
               
               $response['message'] = 'No Activity Found';
               $response['activity_details'] = [];
               if (!empty($pp_id)) {
                    $activity_details = $this->pp_model->getActivityDetail($pp_id, $activity_id, $contract_location_id);

                    if (empty($activity_details)) {
                         //Check activities with previous physical progress id
                         $activity_details = $this->pp_model->getActivityDetail($prev_pp_id, $activity_id, $contract_location_id);
                    }

                    $response['message'] = 'Get Activity Success';
                    $response['activity_details'] = $activity_details;
               }

               http_response_code(200);
          }
          
          echo json_encode($response);
     }

     public function getLastNCRID()
     {
          $last_obs_record = $this->pp_model->fetchLastObservation();

          $last_ncr_id = 0;

          if (!empty($last_obs_record)) {
               $last_ncr_id = $last_obs_record['ncr_id'];
          }

          $response['last_ncr_id'] = $last_ncr_id;

          echo json_encode($response);
     }

     public function modify_pp_status_ids($pp_status_ids)
     {
          $modified_status_arr = [];

          foreach ($pp_status_ids as $value) {
              $modified_status_arr[$value['name']] = $value['status_id']; 
          }

          return $modified_status_arr;
     }

     /*public function sortByLocation($data)
     {
          $sorted_data = [];
          $final_sorted_data = [];

          foreach ($data as $key => $value) {
               $sorted_data[$value['site_location']][] = $value;              
          }

          $sort_arr = [];
          foreach ($sorted_data as $key => $value) {
               if (count($value) > 1) {
                    foreach ($value as $k1 => $v1) {
                         $sort_arr[$k1] = strtotime($v1['reported_date']);
                    }

                    array_multisort($sort_arr, SORT_DESC, $value);
                    // echo '<pre>'; print_r($value); echo '</pre>';
                    $final_sorted_data[$key] = $value[0];
               }

               $final_sorted_data[$key] = $value[0];
          }

          return $final_sorted_data;
     }*/

     //Not Required Anymore
     public function sortByFeederID($data)
     {
          $sorted_data = [];
          $final_sorted_data = [];

          foreach ($data as $key => $value) {
               $sorted_data[$value['feeder_id']][] = $value;
          }

          foreach ($sorted_data as $key => $value) {
               $sort_arr = [];
               if (count($value) > 1) {
                    foreach ($value as $k1 => $v1) {
                         // $sort_arr[$k1] = strtotime($v1['reported_date']);
                         $sort_arr[$k1] = (!empty($v1['reported_date'])) ? strtotime($v1['reported_date']) : '';
                    }
                    array_multisort($sort_arr, SORT_DESC, $value);
                    $final_sorted_data[$key] = $value[0];
               } else {
                    $final_sorted_data[$key] = $value[0];     
               }
          }

          return $final_sorted_data;
     }

     //Not Required Anymore
     public function sortByStatus($data, $action = NULL)
     {
          $sorted_result = [];

          foreach ($data as $value) {
               if ($value['sheet_status'] == 'Completed') {
                   array_push($sorted_result, $value);
               }
          }
          
          foreach ($data as $value) {
               if ($value['sheet_status'] == 'In Process') {
                   array_push($sorted_result, $value);
               }
          }

          foreach ($data as $value) {
               if ($value['sheet_status'] == 'Open') {
                   array_push($sorted_result, $value);
               }
          }

          if ($action == NULL) {
               foreach ($sorted_result as $key => $value) {
                    if ($value['sheet_status'] == 'Completed') {
                         unset($sorted_result[$key]);                    
                    }
               }     
          }          

          $final_sorted_result = array_values($sorted_result);

          return $final_sorted_result;
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

     //Not Required Anymore
     public function calculateTaskRatio($site, $mode, $reported_date = NULL)
     {
          $activities_result = $this->pp_model->getActivitiesList($site['typeofwork_id'], NULL);

          $task_ratio = '-';

          if (!empty($activities_result)) {
               $activities_count = count($activities_result);
               $pp_id = (($mode == 'edit-prev' || $mode == 'view' || $mode == 'edit-review') && empty($reported_date)) ? $site['prev_physical_progress_id'] : $site['physical_progress_id'];

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

     //Not Required Anymore
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

     //Function to sort array by key
     public function sort_array_by_key($array, $sort_key)
     {
          $key_array = array_column($array, $sort_key);
          array_multisort($key_array, SORT_ASC, $array); //or SORT_DESC
          return $array;
     }

     public function getUserData()
     {
          $username = $_SESSION['username'];
          $role_id = $_SESSION['loggedData']->role_id;
          
          $userrole = $this->pp_model->getUserRole($role_id);
          
          $userdata['username'] = $username;
          $userdata['role'] = $userrole;

          return $userdata;
     }

     public function searchContractor()
     {
          if (!empty($_POST)) {
               $contractor = $this->input->post('contractor');

               $response['contractor_data'] = $this->pp_model->getContractorData($contractor);
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