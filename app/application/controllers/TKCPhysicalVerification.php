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
		echo '<pre>'; print_r($_POST); echo '</pre>';
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

	//Function to sort array by key
    public function sort_array_by_key($array, $sort_key)
    {
    	$key_array = array_column($array, $sort_key);
        array_multisort($key_array, SORT_ASC, $array); //or SORT_DESC
        return $array;
    }
}


?>