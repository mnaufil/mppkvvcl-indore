<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

require APPPATH.'libraries/PhpXlsxGenerator.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

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

          $this->load->library('image_lib');
          $this->load->config('email');
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
          
          $result = $this->pp_model->getPhysicalProgressSheets($pp_list_status_ids, NULL, 0, 500);

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
               // $formatted_reported_date = (!empty($reported_date)) ? date('Y-m-d', strtotime($reported_date)) : '';
               $formatted_reported_date_arr = (!empty($reported_date)) ? explode(' - ', $reported_date) : '';
               $start_date = (!empty($formatted_reported_date_arr)) ? date('Y-m-d', strtotime($formatted_reported_date_arr[0])) : '';
               $end_date = (!empty($formatted_reported_date_arr)) ? date('Y-m-d', strtotime($formatted_reported_date_arr[1])) : '';
               $filter_arr['reportedDate']['label'] = 'Reported Date';
               $filter_arr['reportedDate']['value'] = $reported_date;

               $feeder_id = $this->input->post('feederID');
               $filter_arr['feederID']['label'] = 'Feeder ID';
               $filter_arr['feederID']['value'] = $feeder_id;

               $charging_status = $this->input->post('chargingStatus');
               $filter_arr['chargingStatus']['label'] = 'Charging Status';
               $filter_arr['chargingStatus']['value'] = (!empty($charging_status)) ? ucfirst($charging_status) : $charging_status;

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

               // $search_result = $this->pp_model->searchSheets($contractor, $tender_award_no, $type_of_work, $site_location, $region, $circle, $division, $reported_by_id, $formatted_reported_date, $feeder_id, $charging_status, $status, NULL, 0, 1000);
               $search_result = $this->pp_model->searchSheets($contractor, $tender_award_no, $type_of_work, $site_location, $region, $circle, $division, $reported_by_id, $start_date, $end_date, $feeder_id, $charging_status, $status, NULL, 0, 1000);

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

               if (!empty($sheet_result['activities_list'])) {
                    if ($mode == 'edit-prev') {
                         // Checking if count of activities from pp_activity table matches with count of activities from mst_typeofwork_activity table
                         $mst_activity_count = $this->pp_model->getTotalActivityCountFromMaster($sheet_result['typeofwork_id']);
                         $pp_activity_count = count($sheet_result['activities_list']);

                         if ($pp_activity_count != $mst_activity_count) {
                              $mst_activity_data = $this->pp_model->getActivitiesList($sheet_result['typeofwork_id'], $sheet_result['contract_location_id']);

                              $pp_activity_ids = array_column($sheet_result['activities_list'], 'activity_id');

                              foreach ($mst_activity_data as $key => $mst_activity) {
                                   if (!in_array($mst_activity['typeofwork_activity_id'], $pp_activity_ids)) {
                                        $mst_activity['status_id'] = 0;
                                        $mst_activity['applied_observations'] = [];

                                        array_push($sheet_result['activities_list'], $mst_activity);
                                   }
                              }
                         }
                    }

                    $sheet_result['task_ratio'] = $task_ratio = $this->calculateTaskRatio($sheet_result, $mode);

                    if ($task_ratio != '-') {
                         $task_ratio_arr = explode(' / ', $task_ratio);
                         $sheet_result['work_completion'] = round(((int)$task_ratio_arr[0] / (int)$task_ratio_arr[1]) * 100);     
                    } else {
                         $sheet_result['work_completion'] = '-';
                    }

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

                    if (!empty($sheet_result['ppsheet_completion_file'])) {
                         //Check for any feeder completion rejection messages
                         $sheet_result['completion_rejection_messages'] = $this->pp_model->getFeederCompletionRejectionMessages($sheet_result['feeder_id']);
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
               $charging_status = $this->input->post('charging_status');
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
               
               $civil_work_activities = $electrical_activities = $substation_activities = $feeder_33kv_activities = $feeder_11kv_activities = $feeder_separation_11kv_activities = $interconnection_line_33kv_activites = $additional_dtr_activities = $bare_to_cable_activities = $cable_augmentation_activities = $bifurcation_11_kv_activities = $interconnection_11_kv_activities = $augmentation_33_kv_activities = $augmentation_11_kv_activities = $dl_to_ag_coated_conductor_activities = $substation_rennovation_activities = $mixed_dtr_activities = $under_ground_cable_activities = array();

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
                              $boq_val = $value;

                              //Updating BOQ qty value in contract_location_boq
                              $this->updateBOQQty($key, $boq_val, $contract_location_id);

                              continue; 
                         }

                         $erected_val = $value;
                         
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
                              $boq_val = $value;

                              //Updating BOQ qty value in contract_location_boq
                              $this->updateBOQQty($key, $boq_val, $contract_location_id);

                              continue; 
                         }

                         $erected_val = $value;

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
                              $boq_val = $value;

                              //Updating BOQ qty value in contract_location_boq
                              $this->updateBOQQty($key, $boq_val, $contract_location_id);

                              continue; 
                         }

                         $erected_val = $value;

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
                              $boq_val = $value;

                              //Updating BOQ qty value in contract_location_boq
                              $this->updateBOQQty($key, $boq_val, $contract_location_id);

                              continue;
                         }

                         $erected_val = $value;

                         $input_name = explode('_', $key);
                         $interconnection_line_33kv_activites[$key]['physical_progress_id'] = $pp_id;
                         $interconnection_line_33kv_activites[$key]['activity_id'] = end($input_name);
                         $interconnection_line_33kv_activites[$key]['activity_status_id'] = $this->calculateStatusForWithBOQ($erected_val, $boq_val, $observation_flag);
                         $interconnection_line_33kv_activites[$key]['erected_qty'] = $value;
                    }

                    if (str_contains($key, 'additional_dtr')) { //withBOQ
                         if (str_contains($key,'observation')) {
                              $observation_flag = $value;
                              continue;
                         }

                         if (str_contains($key, 'boq')) {
                              $boq_val = $value;

                              //Updating BOQ qty value in contract_location_boq
                              $this->updateBOQQty($key, $boq_val, $contract_location_id);

                              continue;
                         }

                         $erected_val = $value;

                         $input_name = explode('_', $key);
                         $additional_dtr_activities[$key]['physical_progress_id'] = $pp_id;
                         $additional_dtr_activities[$key]['activity_id'] = end($input_name);
                         $additional_dtr_activities[$key]['activity_status_id'] = $this->calculateStatusForWithBOQ($erected_val, $boq_val, $observation_flag);
                         $additional_dtr_activities[$key]['erected_qty'] = $value;
                    }

                    if (str_contains($key, 'bare_to_cable')) { //withBOQ
                         if (str_contains($key,'observation')) {
                              $observation_flag = $value;
                              continue;
                         }

                         if (str_contains($key, 'boq')) {
                              $boq_val = $value;

                              //Updating BOQ qty value in contract_location_boq
                              $this->updateBOQQty($key, $boq_val, $contract_location_id);

                              continue;
                         }

                         $erected_val = $value;

                         $input_name = explode('_', $key);
                         $bare_to_cable_activities[$key]['physical_progress_id'] = $pp_id;
                         $bare_to_cable_activities[$key]['activity_id'] = end($input_name);
                         $bare_to_cable_activities[$key]['activity_status_id'] = $this->calculateStatusForWithBOQ($erected_val, $boq_val, $observation_flag);
                         $bare_to_cable_activities[$key]['erected_qty'] = $value;
                    }

                    if (str_contains($key, 'cable_augmentation')) { //withBOQ
                         if (str_contains($key,'observation')) {
                              $observation_flag = $value;
                              continue;
                         }

                         if (str_contains($key, 'boq')) {
                              $boq_val = $value;

                              //Updating BOQ qty value in contract_location_boq
                              $this->updateBOQQty($key, $boq_val, $contract_location_id);

                              continue; 
                         }

                         $erected_val = $value;

                         $input_name = explode('_', $key);
                         $cable_augmentation_activities[$key]['physical_progress_id'] = $pp_id;
                         $cable_augmentation_activities[$key]['activity_id'] = end($input_name);
                         $cable_augmentation_activities[$key]['activity_status_id'] = $this->calculateStatusForWithBOQ($erected_val, $boq_val, $observation_flag);
                         $cable_augmentation_activities[$key]['erected_qty'] = $value;
                    }

                    if (str_contains($key, '11_kv_bifurcation')) { //withBOQ
                         if (str_contains($key,'observation')) {
                              $observation_flag = $value;
                              continue;
                         }

                         if (str_contains($key, 'boq')) {
                              $boq_val = $value;

                              //Updating BOQ qty value in contract_location_boq
                              $this->updateBOQQty($key, $boq_val, $contract_location_id);

                              continue; 
                         }

                         $erected_val = $value;

                         $input_name = explode('_', $key);
                         $bifurcation_11_kv_activities[$key]['physical_progress_id'] = $pp_id;
                         $bifurcation_11_kv_activities[$key]['activity_id'] = end($input_name);
                         $bifurcation_11_kv_activities[$key]['activity_status_id'] = $this->calculateStatusForWithBOQ($erected_val, $boq_val, $observation_flag);
                         $bifurcation_11_kv_activities[$key]['erected_qty'] = $value;
                    }

                    if (str_contains($key, '11_kv_interconnection')) { //withBOQ
                         if (str_contains($key,'observation')) {
                              $observation_flag = $value;
                              continue;
                         }

                         if (str_contains($key, 'boq')) {
                              $boq_val = $value;

                              //Updating BOQ qty value in contract_location_boq
                              $this->updateBOQQty($key, $boq_val, $contract_location_id);

                              continue; 
                         }

                         $erected_val = $value;

                         $input_name = explode('_', $key);
                         $interconnection_11_kv_activities[$key]['physical_progress_id'] = $pp_id;
                         $interconnection_11_kv_activities[$key]['activity_id'] = end($input_name);
                         $interconnection_11_kv_activities[$key]['activity_status_id'] = $this->calculateStatusForWithBOQ($erected_val, $boq_val, $observation_flag);
                         $interconnection_11_kv_activities[$key]['erected_qty'] = $value;
                    }

                    if (str_contains($key, '33_kv_augmentation')) { //withBOQ
                         if (str_contains($key,'observation')) {
                              $observation_flag = $value;
                              continue;
                         }

                         if (str_contains($key, 'boq')) {
                              $boq_val = $value;

                              //Updating BOQ qty value in contract_location_boq
                              $this->updateBOQQty($key, $boq_val, $contract_location_id);

                              continue; 
                         }

                         $erected_val = $value;

                         $input_name = explode('_', $key);
                         $augmentation_33_kv_activities[$key]['physical_progress_id'] = $pp_id;
                         $augmentation_33_kv_activities[$key]['activity_id'] = end($input_name);
                         $augmentation_33_kv_activities[$key]['activity_status_id'] = $this->calculateStatusForWithBOQ($erected_val, $boq_val, $observation_flag);
                         $augmentation_33_kv_activities[$key]['erected_qty'] = $value;
                    }

                    if (str_contains($key, '11_kv_augmentation')) { //withBOQ
                         if (str_contains($key,'observation')) {
                              $observation_flag = $value;
                              continue;
                         }

                         if (str_contains($key, 'boq')) {
                              $boq_val = $value;

                              //Updating BOQ qty value in contract_location_boq
                              $this->updateBOQQty($key, $boq_val, $contract_location_id);

                              continue; 
                         }

                         $erected_val = $value;

                         $input_name = explode('_', $key);
                         $augmentation_11_kv_activities[$key]['physical_progress_id'] = $pp_id;
                         $augmentation_11_kv_activities[$key]['activity_id'] = end($input_name);
                         $augmentation_11_kv_activities[$key]['activity_status_id'] = $this->calculateStatusForWithBOQ($erected_val, $boq_val, $observation_flag);
                         $augmentation_11_kv_activities[$key]['erected_qty'] = $value;
                    }

                    if (str_contains($key, 'dl_to_ag_coated_conductor')) { //withBOQ
                         if (str_contains($key,'observation')) {
                              $observation_flag = $value;
                              continue;
                         }

                         if (str_contains($key, 'boq')) {
                              $boq_val = $value;

                              //Updating BOQ qty value in contract_location_boq
                              $this->updateBOQQty($key, $boq_val, $contract_location_id);

                              continue; 
                         }

                         $erected_val = $value;

                         $input_name = explode('_', $key);
                         $dl_to_ag_coated_conductor_activities[$key]['physical_progress_id'] = $pp_id;
                         $dl_to_ag_coated_conductor_activities[$key]['activity_id'] = end($input_name);
                         $dl_to_ag_coated_conductor_activities[$key]['activity_status_id'] = $this->calculateStatusForWithBOQ($erected_val, $boq_val, $observation_flag);
                         $dl_to_ag_coated_conductor_activities[$key]['erected_qty'] = $value;
                    }

                    if (str_contains($key, 'substation_rennovation')) { //withBOQ
                         if (str_contains($key,'observation')) {
                              $observation_flag = $value;
                              continue;
                         }

                         if (str_contains($key, 'boq')) {
                              $boq_val = $value;

                              //Updating BOQ qty value in contract_location_boq
                              $this->updateBOQQty($key, $boq_val, $contract_location_id);

                              continue; 
                         }

                         $erected_val = $value;

                         $input_name = explode('_', $key);
                         $substation_rennovation_activities[$key]['physical_progress_id'] = $pp_id;
                         $substation_rennovation_activities[$key]['activity_id'] = end($input_name);
                         $substation_rennovation_activities[$key]['activity_status_id'] = $this->calculateStatusForWithBOQ($erected_val, $boq_val, $observation_flag);
                         $substation_rennovation_activities[$key]['erected_qty'] = $value;
                    }

                    if (str_contains($key, 'mix_dtr')) { //withBOQ
                         if (str_contains($key,'observation')) {
                              $observation_flag = $value;
                              continue;
                         }

                         if (str_contains($key, 'boq')) {
                              $boq_val = $value;

                              //Updating BOQ qty value in contract_location_boq
                              $this->updateBOQQty($key, $boq_val, $contract_location_id);

                              continue; 
                         }

                         $erected_val = $value;

                         $input_name = explode('_', $key);
                         $mixed_dtr_activities[$key]['physical_progress_id'] = $pp_id;
                         $mixed_dtr_activities[$key]['activity_id'] = end($input_name);
                         $mixed_dtr_activities[$key]['activity_status_id'] = $this->calculateStatusForWithBOQ($erected_val, $boq_val, $observation_flag);
                         $mixed_dtr_activities[$key]['erected_qty'] = $value;
                    }

                    if (str_contains($key, 'under_ground_cable')) { //withBOQ
                         if (str_contains($key,'observation')) {
                              $observation_flag = $value;
                              continue;
                         }

                         if (str_contains($key, 'boq')) {
                              $boq_val = $value;

                              //Updating BOQ qty value in contract_location_boq
                              $this->updateBOQQty($key, $boq_val, $contract_location_id);

                              continue; 
                         }

                         $erected_val = $value;

                         $input_name = explode('_', $key);
                         $under_ground_cable_activities[$key]['physical_progress_id'] = $pp_id;
                         $under_ground_cable_activities[$key]['activity_id'] = end($input_name);
                         $under_ground_cable_activities[$key]['activity_status_id'] = $this->calculateStatusForWithBOQ($erected_val, $boq_val, $observation_flag);
                         $under_ground_cable_activities[$key]['erected_qty'] = $value;
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

               if (!empty($mixed_dtr_activities)) {
                    array_push($pp_sheet_activities, $mixed_dtr_activities);
               }

               if (!empty($under_ground_cable_activities)) {
                    array_push($pp_sheet_activities, $under_ground_cable_activities);
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

               // Updating charging status in contract_location table
               $this->pp_model->updateChargingStatus($contract_location_id, $charging_status);

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

     public function updateBOQQty($key, $boq_val, $contract_location_id)
     {
          $key_array = explode('_', $key);
          $activity_id = end($key_array);

          // Check if boq value already exists
          $result = $this->pp_model->getBOQ($activity_id, $contract_location_id);

          if (!$result) {
               $unit_id = $this->pp_model->getActivityData($activity_id, 'unit_id');

               // Inserting the BOQ Qty value
               $this->pp_model->insertBOQQty($contract_location_id, $activity_id, $unit_id, $boq_val);
          } else {
               // Updating the BOQ Qty value
               $this->pp_model->updateBOQQty($contract_location_id, $activity_id, $boq_val);
          }
     }

     public function getSheetDataByDate($reported_date, $ppsheet_id, $contract_id, $contract_location_id)
     {
          $mode = 'view-by-date';
          $sheet_result = $this->pp_model->getSheetDetail($mode, $ppsheet_id, $contract_id, $contract_location_id, $reported_date);

          /*Formatting Tender Award Date*/
          $award_date = date("d-m-Y", strtotime($sheet_result['tender_award_date']));
          $sheet_result['tender_award_date'] = $award_date;

          $sheet_result['task_ratio'] = $task_ratio = $this->calculateTaskRatio($sheet_result, $mode, $reported_date);
          $task_ratio_arr = explode(' / ', $task_ratio);
          $sheet_result['work_completion'] = round(((int)$task_ratio_arr[0] / (int)$task_ratio_arr[1]) * 100);

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
               $raised_by = $this->input->post('raisedBy');
               $designation = $this->input->post('designation');
               $distribution_centre = $this->input->post('distributionCentre');
               $observation_id = $this->input->post('observation');
               $observation_name = $this->input->post('observation_name');
               $other_observation_name = $this->input->post('other_observation');
               $observation_remark = $this->input->post('observation_remark');
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
                         // $status_id = (empty($completion_date)) ? 2 : 1;
                         $user_role = $this->pp_model->getUserRole($_SESSION['loggedData']->role_id);
                         $status_id = ($user_role == 'Client') ? 0 : ((empty($completion_date)) ? 2 : 1);

                         //Inserting data in physical_progress_activity table and getting last inserted id
                         $pp_activity_id = $this->pp_model->saveActivity($pp_id, $sr_no, $work_activity_id, $unit_id, $status_id, $erected_qty);
                    } else {
                         $pp_activity_id = $activity_check['physical_progress_activity_id'];
                    }

                    if ($pp_activity_id) {
                         $ncr_status_ids = $this->getNCRStatusIDs();
                         $obs_status_id = (empty($completion_date)) ? $ncr_status_ids['Pending'] : $ncr_status_ids['Reviewed'];
                         //Inserting data in physical_progress_activity_observation table and getting last inserted id
                         $inserted_observation_id = $this->pp_model->saveObservation($contract_location_id, $work_activity_id, $observation_id, $observation_name, $other_observation_name, $observation_remark, $ncr_id, $ncr_date, $remark, $completion_date, $obs_status_id, $raised_by, $designation, $distribution_centre);
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
                         // $obs_status_id = (empty($completion_date)) ? $ncr_status_ids['Pending'] : $ncr_status_ids['Reviewed'];

                         if (empty($completion_date)) {
                              $ncr_status = $this->pp_model->getNCRStatus($pp_activity_obs_id, $ncr_id);
                              if ($ncr_status == 'Forwarded') {
                                   $obs_status_id = $ncr_status_ids['Forwarded'];
                              } else {
                                   $obs_status_id = $ncr_status_ids['Pending'];
                              }
                         } else {
                              $obs_status_id = $ncr_status_ids['Reviewed'];
                         }

                         //Updating data in physical_progress_activity_observation table and returning updated id
                         $inserted_observation_id = $this->pp_model->updateObservation($observation_id, $observation_name, $other_observation_name, $ncr_id, $ncr_date, $remark, $observation_remark, $completion_date, $obs_status_id, $raised_by, $designation, $distribution_centre, $pp_activity_obs_id);     
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

     public function exportPhysicalVerificationList()
     {
          // Excel file name for download 
          $fileName = "Feeders_Data_".date('Y-m-d').".xlsx";

          // $excel_data = [];
          $excel_data[] = array('<center>CONTRACT NO</center>', '<center>CONTRACTOR</center>', '<center>TYPE OF WORK</center>', '<center>REGION</center>', '<center>CIRCLE</center>', '<center>DIVISION</center>', '<center>SITE LOCATION</center>', '<center>FEEDER ID</center>', '<center>TASK</center>', '<center>OBSERVATION</center>', '<center>WORK COMPLETION (IN %)</center>', '<center>CHARGING STATUS</center>', '<center>LAST REPORTED BY</center>', '<center>LAST REPORTED DATE</center>', '<center>STATUS</center>');

          // Fetch records from database and store in an array
          $session_query = $_SESSION['feeder_query'];
          $result = $this->pp_model->executeQuery($session_query);

          if (!empty($result)) {
               foreach ($result as $key => $value) {
                    $obs_ratio = ($value['cc_observation'] == 0 && $value['tt_observation'] == 0) ? '-' : $value['cc_observation'].' / '. $value['tt_observation'];

                    $work_completion = ($value['tt_task'] != 0) ? ((int)$value['cc_task'] / (int)$value['tt_task']) * 100 : '';
                    $work_completion_per = ($work_completion == 0 || $work_completion == 100 || $work_completion == '') ? $work_completion : round($work_completion);

                    $charging_status = (empty($value['charging_status'])) ? 'No' : ucfirst($value['charging_status']);

                    $reported_date = (!empty($value['reported_date'])) ? date('d-m-Y', strtotime($value['reported_date'])) : '';

                    $temp_data = array('<center>'.$value['tender_award_no'].'</center>', $value['contractor_name'], $value['typeofwork_name'], $value['region_name'], $value['circle_name'], $value['division_name'], $value['site_location'], '<center>'.$value['feeder_id'].'</center>', '<center>'.$value['cc_task'].' / '. $value['tt_task'].'</center>', '<center>'.$obs_ratio.'</center>', '<center>'.$work_completion_per.'</center>', '<center>'.$charging_status.'</center>', $value['pp_reported_by'], '<center>'.$reported_date.'</center>', '<center>'.$value['sheet_status'].'</center>');

                    array_push($excel_data, $temp_data);
               }
          }

          // Export data to excel and download as xlsx file
          $xlsx = CodexWorld\PhpXlsxGenerator::fromArray($excel_data);
          $xlsx->downloadAs($fileName);

          exit;
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
          if ($boq_val == 0) {
               return $status_id = 3;
          } else {
               if ($erected_val == 0 || $erected_val == '') {
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
          // $activities_result = $this->pp_model->getActivitiesList($site['typeofwork_id'], NULL);
          $activities_result = $site['activities_list'];

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

          $designation = $_SESSION['loggedData']->designation;
          
          $userdata['username'] = $username;
          $userdata['role'] = $userrole;
          $userdata['designation'] = $designation;
          $userdata['user_id'] = $_SESSION['loggedData']->user_id;

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

     public function sendFlagMailToTKC()
     {
          //Default Response
          http_response_code(200);
          $response['message'] = 'Successfully Raised Flag for TKC ';

          if (!empty($_POST)) {
               $pp_activity_obs_id = $this->input->post('pp_activity_obs_id');
               $ncr_id = $this->input->post('ncr_id');
               $flag_msg = $this->input->post('flag_msg');

               $result = $this->pp_model->saveNCRFlag($pp_activity_obs_id, $ncr_id, $flag_msg); //Uncomment Later

               if ($result) {
                    $ncr_data = $this->pp_model->getNCRDetails($pp_activity_obs_id);                    

                    $embedded_img_arr = [];
                    if (!empty($ncr_data['observation_files'])) {
                         $temp_observation_files = [];
                         foreach ($ncr_data['observation_files'] as $key => $value) {
                              $target_path = 'assets/uploads/observation_files/thumb/';
                              $resized_image = $this->resizeImage($value['file_path'], 1000, 1000, $target_path);

                              $embedded_img_arr['obs_file_'.$key] = $resized_image;
                              $temp_observation_files['obs_file_'.$key] = $resized_image;
                         }

                         $ncr_data['observation_files'] = $temp_observation_files;
                    }

                    if (!empty($ncr_data['observation_tkc_files'])) {
                         $temp_observation_by_tkc_files = [];
                         foreach ($ncr_data['observation_tkc_files'] as $key => $value) {
                              $target_path = 'assets/uploads/observation_files_by_tkc/thumb/';
                              $resized_image = $this->resizeImage($value['file_path'], 1000, 1000, $target_path);

                              $embedded_img_arr['obs_file_by_tkc_'.$key] = $resized_image;
                              $temp_observation_by_tkc_files['obs_file_by_tkc_'.$key] = $resized_image;
                         }

                         $ncr_data['observation_tkc_files'] = $temp_observation_by_tkc_files;
                    }

                    if (!empty($ncr_data['observation_completion_files'])) {
                         $temp_observation_completion_files = [];
                         foreach ($ncr_data['observation_completion_files'] as $key => $value) {
                              $target_path = 'assets/uploads/observation_completion_files/thumb/';
                              $resized_image = $this->resizeImage($value['file_path'], 1000, 1000, $target_path);

                              $embedded_img_arr['obs_completion_file'.$key] = $resized_image;
                              $temp_observation_completion_files['obs_completion_file'.$key] = $resized_image;
                         }

                         $ncr_data['observation_completion_files'] = $temp_observation_completion_files;
                    }

                    $ncr_data['ncr_flag_details'] = $flag_msg;

                    $data['ncr_data'] = $ncr_data;
                    
                    $tkc_user_id = $this->pp_model->getNCRRaisedByTKCUserID($pp_activity_obs_id);
                    $tkc_email = $this->pp_model->getUserEmail($tkc_user_id);

                    $users_result = $this->pp_model->getUsersByRegionCircleDivision($ncr_data['contract_location_id']);
                    $users = $this->filterUsers($users_result);

                    $other_email_ids_data = $this->pp_model->getCCBCCEmailIDs();
                    foreach ($other_email_ids_data as $key => $value) {
                         $other_email_ids[$value['display_name']] = $value['fieldvalue'];
                    }

                    $bcc_str = $other_email_ids['BCC EMAIL ID'];
                    $bcc_arr = explode(',', $bcc_str);

                    $cc_str = $other_email_ids['CC EMAIL ID'];
                    $cc_arr = explode(',', $cc_str);

                    $email_errors = [];

                    $message = $this->load->view('physical-progress/flag-email-body', $data, true);

                    $from = $this->config->item('smtp_user');
                    $to = $tkc_email; //Uncomment Later
                    // $to = 'parab.manasi14@gmail.com';

                    $subject = 'NCR ID:'.$ncr_data['ncr_id'].' Flag Raised for Observation By TKC';

                    // PHP Mailer Code Begins
                    $mail = new PHPMailer(true);

                    $mail->SMTPDebug = SMTP::DEBUG_OFF;
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'mppkvvcl.sgs@gmail.com';
                    $mail->Password = 'tarhuogjifshezmd';
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;
                    $mail->setFrom($from);

                    $mail->addAddress($to);

                    foreach ($bcc_arr as $bcc_value) { //Uncomment Later
                         $mail->AddBCC($bcc_value);
                    }

                    foreach ($cc_arr as $cc_value) { //Uncomment Later
                         $mail->AddCC($cc_value);
                    }

                    /*$mail->AddCC('mansi.p@benchmarksolution.com');
                    $mail->AddBCC('mansi.p@benchmarksolution.com');*/

                    foreach ($users as $user) { //Uncomment Later
                         $mail->AddCC($user);
                    }

                    $mail->isHTML(true);
                    $mail->Subject = $subject;

                    foreach ($embedded_img_arr as $emb_key => $emb_value) {
                         $mail->addEmbeddedImage("$emb_value","$emb_key");
                    }

                    $mail->Body = $message;

                    if (!$mail->send()) {
                         array_push($email_errors, $mail->ErrorInfo);
                         // $error = $mail->ErrorInfo;
                    }

                    if (!empty($email_errors)) {
                         http_response_code(400);
                         $response['message'] = 'Failed to send email to TKC';
                    } else {
                         // Fetching all raised flag messages
                         $ncr_flag_details = $this->pp_model->getNCRFlagDetails($ncr_data['ncr_id']);
                         $response['ncr_flag_details'] = $ncr_flag_details;

                         // Changing Status of NCR
                         $ncr_status_ids = $this->getNCRStatusIDs();
                         $this->pp_model->changeNCRStatus($pp_activity_obs_id, $ncr_id, $ncr_status_ids['Forwarded']);
                    }
               } else {
                    http_response_code(400);
                    $response['message'] = 'Failed to save NCR flag raised for TKC';     
               }
          } else {
               http_response_code(400);
               $response['message'] = 'No Inputs Found';
          }

          echo json_encode($response);
     }

     public function sendFeederCompletionRejectMail()
     {
          if (!empty($_POST)) {
               $physical_progress_id = $this->input->post('physical_progress_id');
               $feeder_id = $this->input->post('feeder_id');
               $contract_location_id = $this->input->post('contract_location_id');
               $reject_msg = $this->input->post('reject_msg');

               $user_id = $this->pp_model->getLoggedInUserID();

               $result = $this->pp_model->saveFeederCompletionRejectionFlag($physical_progress_id, $feeder_id, $reject_msg, $user_id); //Uncomment Later
               // $result = 1; //Delete Later

               if ($result) {
                    $feeder_data = $this->pp_model->getFeederDetails($feeder_id, $contract_location_id, $physical_progress_id);

                    $embedded_img_arr = [];

                    if (!empty($feeder_data)) {
                         $temp_files = [];

                         foreach ($feeder_data['feeder_completion_file'] as $key => $value) {
                              $target_path = 'assets/uploads/physical_progress_completion_files/thumb/';
                              $resized_image = $this->resizeImage($value['file_path'], 1000, 1000, $target_path);

                              $embedded_img_arr['file_'.$key] = $resized_image;
                              $temp_files['file_'.$key] = $resized_image;
                         }

                         $feeder_data['feeder_completion_file'] = $temp_files;

                         $feeder_data['reject_msg'] = $reject_msg;

                         $data['feeder_data'] = $feeder_data;

                         $fe_fs_data = $this->pp_model->getFEFSForFeeder($feeder_id, $contract_location_id);
                         $fe_fs_emails = array_column($fe_fs_data, 'email');

                         $other_email_ids_data = $this->pp_model->getCCBCCEmailIDs();
                         foreach ($other_email_ids_data as $key => $value) {
                              $other_email_ids[$value['display_name']] = $value['fieldvalue'];
                         }

                         $bcc_str = $other_email_ids['BCC EMAIL ID'];
                         $bcc_arr = explode(',', $bcc_str);

                         $message = $this->load->view('physical-progress/feeder-completion-reject-email-body', $data, true);

                         $subject = 'Feeder ID:'.$feeder_id.' Completion Photo Rejected By DTL';

                         $from = $this->config->item('smtp_user');

                         // PHP Mailer Code Begins
                         $mail = new PHPMailer(true);

                         try {
                              $mail->SMTPDebug = SMTP::DEBUG_OFF;
                              $mail->isSMTP();
                              $mail->Host = 'smtp.gmail.com';
                              $mail->SMTPAuth = true;
                              $mail->Username = 'mppkvvcl.sgs@gmail.com';
                              $mail->Password = 'tarhuogjifshezmd';
                              // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                              $mail->SMTPSecure = 'tls';
                              $mail->Port = 587;
                              $mail->setFrom($from);

                              foreach ($fe_fs_emails as $value) {
                                   $mail->addAddress($value);
                              }

                              foreach ($bcc_arr as $key => $value) {
                                   $mail->AddBCC($value);
                              }

                              $mail->isHTML(true);
                              $mail->Subject = $subject;

                              foreach ($embedded_img_arr as $emb_key => $emb_value) {
                                   $mail->addEmbeddedImage("$emb_value","$emb_key");
                              }

                              $mail->Body = $message;

                              if (!$mail->send()) {
                                   $error = $mail->ErrorInfo;

                                   $response['message'] = 'Failed to send email <br/>Error Message: '.$error;
                              } else {
                                   $pp_status_ids = $this->pp_model->getStatusList();
                                   $pp_status_ids = $this->modify_pp_status_ids($pp_status_ids);

                                   $changed_feeder_status_id = $pp_status_ids['In Process'];

                                   // Reverting Feeder status back to In Process
                                   $status_revert_result = $this->pp_model->updateFeederStatus($changed_feeder_status_id, $physical_progress_id, $contract_location_id);

                                   if ($status_revert_result) {
                                        $response['message'] = 'Email has been sent successfully for Feeder ID: '.$feeder_id; 
                                   } else {
                                        $response['message'] = 'Failed to revert Feeder status to In Process';
                                   }
                              }
                         } catch (Exception $e) {
                              $error = $mail->ErrorInfo;

                              // Setting Feeder Status to as it was i.e Reviewed
                              $pp_status_ids = $this->pp_model->getStatusList();
                              $pp_status_ids = $this->modify_pp_status_ids($pp_status_ids);

                              $changed_feeder_status_id = $pp_status_ids['Reviewed'];

                              $status_revert_result = $this->pp_model->updateFeederStatus($changed_feeder_status_id, $physical_progress_id, $contract_location_id);

                              $response['message'] = 'Failed to send email <br/>Error Message: '.$error;
                         }
                    } else {
                         $response['message'] = 'No Feeder Data found';     
                    }
               }
          } else {
               $response['message'] = 'Failed to send email';
          }

          echo json_encode($response);
     }

     public function filterUsers($users_result)
     {
          $fe_fs_dtl_arr = [];

          foreach ($users_result as $key => $value) {
               $user_role = $this->pp_model->getUserRoleName($value['user_id']);

               if ($user_role == 'Field Engineer' || $user_role == 'Field Supervisor' || $user_role == 'Deputy Team Lead') {
                    array_push($fe_fs_dtl_arr, $value['email']);
               }
          }

          return $fe_fs_dtl_arr;
     }

     public function resizeImage($image, $width, $height, $target_path)
     {
          $image_detail_arr = explode('/', $image);
          $image_name = end($image_detail_arr);

          $image_name_arr = explode('.', $image_name);
          $ext = end($image_name_arr);

          $image_name = $image_name_arr[0].'_thumb.'.$ext;

          $config['image_library'] = 'gd2';
          $config['source_image'] = $image;
          $config['new_image'] = $target_path;
          $config['create_thumb'] = TRUE;
          $config['maintain_ratio'] = TRUE;
          $config['quality'] = 90;
          $config['width'] = $width;
          $config['height'] = $height;

          $this->image_lib->clear();
         $this->image_lib->initialize($config);
         $this->image_lib->resize();

         return $target_path.$image_name;
     }
}

?>