<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class PhysicalProgressReview extends CI_Controller
{	
	function __construct()
	{
		parent::__construct();

		$this->load->model('PhysicalProgressReview_Model', 'ppreview_model');

		if(!$this->session->isUserLoggedIn)
        { 
            redirect('login'); 
        }
	}

	public function index()
	{
		$pp_status_id = $this->ppreview_model->getStatusIDForList();

		$result = $this->ppreview_model->getPhysicalProgressReviewedSheets($pp_status_id);

		$type_of_work = $this->ppreview_model->getTypeOfWorkList();

        $region_list = $this->ppreview_model->getRegionList();
        $region_list = $this->sort_array_by_key($region_list, 'region_name');

        $region_circle_data = $this->ppreview_model->getRegionCircleData();
      	$region_circle_data = $this->modifyRegionCircleData($region_circle_data);

        $circle_division_data = $this->ppreview_model->getCircleDivisionData();
        $circle_division_data = $this->modifyCircleDivisionData($circle_division_data);

        $status_list = $this->ppreview_model->getStatusList();
        $status_list = $this->modifyStatusList($status_list);

        $user_access_data = $this->ppreview_model->getUserModuleAccess();
        $user_access = $this->sortUserModuleAccess($user_access_data);

		$data['title'] = 'Physical Verification Review';
		$data['result'] = $result;
        $data['work_list'] = $type_of_work;
        $data['region_list'] = $region_list;
        $data['region_circle_data'] = $region_circle_data;
        $data['circle_division_data'] = $circle_division_data;
        $data['status_list'] = $status_list;
        $data['user_access'] = $user_access;

        // echo '<pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('physical-progress-review/physical-progress-review', $data);
	}

	public function searchReviewSheet()
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
            $filter_arr['typeOfWork']['value'] = (isset($_POST['typeOfWork'])) ? $this->ppreview_model->getTypeOfWork($type_of_work) : '';
            $filter_arr['typeOfWork']['id'] = $type_of_work;

            $site_location = $this->input->post('siteLocation');
            $filter_arr['siteLocation']['label'] = 'Site Location';
            $filter_arr['siteLocation']['value'] = $site_location;

            $region = (isset($_POST['region'])) ? $this->input->post('region') : '';
            $filter_arr['region']['label'] = 'Region';
            $filter_arr['region']['value'] = (isset($_POST['region'])) ? $this->ppreview_model->getRegion($region) : '';
            $filter_arr['region']['id'] = $region;

            $circle = (isset($_POST['circle'])) ? $this->input->post('circle') : '';
           	$filter_arr['circle']['label'] = 'Circle';
            $filter_arr['circle']['value'] = (isset($_POST['circle'])) ? $this->ppreview_model->getCircle($circle) : '';
            $filter_arr['circle']['id'] = $circle;

            $division = (isset($_POST['division'])) ? $this->input->post('division') : '';
           	$filter_arr['division']['label'] = 'Division';
            $filter_arr['division']['value'] = (isset($_POST['division'])) ? $this->ppreview_model->getDivision($division) : '';
            $filter_arr['division']['id'] = $division;

            $reported_by = $this->input->post('reportedBy');
            $reported_by_id = (!empty($reported_by)) ? $this->ppreview_model->getReportedByID($reported_by, 'LIKE') : '';
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
	            	array_push($status_values, $this->ppreview_model->getSheetStatus($value));
	            }
	        }
            $filter_arr['status']['value'] = (!empty($status_values)) ? implode(', ', $status_values) : '';
            $filter_arr['status']['id'] = $this->input->post('status');

            $search_result = $this->ppreview_model->searchPhysicalProgressReviewedSheets($contractor, $tender_award_no, $type_of_work, $site_location, $region, $circle, $division, $reported_by_id, $formatted_reported_date, $feeder_id, $status);

            $type_of_work = $this->ppreview_model->getTypeOfWorkList();

        	$region_list = $this->ppreview_model->getRegionList();
	        $region_list = $this->sort_array_by_key($region_list, 'region_name');

	        if (!empty($region)) {
            	$circle_list = $this->ppreview_model->getCircleListOfRegion($region);
                $data['circle_list'] = $this->sort_array_by_key($circle_list, 'circle_name');
            }

	        // $division_list = $this->ppreview_model->getDivisionList();
	        if (!empty($circle)) {
                $division_list = $this->ppreview_model->getDivisionListOfCircle($circle);
                $data['division_list'] = $this->sort_array_by_key($division_list, 'division_name');
           	}

           	$region_circle_data = $this->ppreview_model->getRegionCircleData();
           	$region_circle_data = $this->modifyRegionCircleData($region_circle_data);

           	$circle_division_data = $this->ppreview_model->getCircleDivisionData();
           	$circle_division_data = $this->modifyCircleDivisionData($circle_division_data);           	

	        $status_list = $this->ppreview_model->getStatusList();
	        $status_list = $this->modifyStatusList($status_list);

	        $data['title'] = 'Physical Progress Review';
            $data['result'] = $search_result;

            $data['filters'] = $filter_arr;
	        $data['work_list'] = $type_of_work;
	        $data['region_list'] = $region_list;
	        $data['region_circle_data'] = $region_circle_data;
           	$data['circle_division_data'] = $circle_division_data;	        
	        $data['status_list'] = $status_list;

	        // echo '<pre>'; print_r($data); echo '</pre>'; die();
			$this->load->view('physical-progress-review/physical-progress-review', $data);
		}
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

    public function modifyStatusList($status_list)
    {
        $modified_status_arr = [];

        foreach ($status_list as $value) {
            if ($value['name'] == 'Reviewed' || $value['name'] == 'Completed') {
                array_push($modified_status_arr, $value);
            }
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