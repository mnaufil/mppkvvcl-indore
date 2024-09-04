<?php  defined('BASEPATH') OR exit('No direct script access allowed'); 
/**
 * 
 */
class ComplianceByTKC extends CI_Controller
{	
	function __construct()
	{
		parent::__construct();

		$this->load->model('ComplianceByTKC_Model', 'cbt_model');

		if(!$this->session->isUserLoggedIn)
        { 
            redirect('login'); 
        }

        $this->load->library("Pdf");

        // Setting Timezone
        date_default_timezone_set("Asia/Calcutta");   //India time (GMT+5:30)
	}

	public function index()
	{
		$result = $this->cbt_model->getNCRsSubmittedByTKC();

		// Formatting Dates
		foreach ($result as $key => $value) {
			$result[$key]['ncr_date'] = date('d-m-Y', strtotime($value['ncr_date']));
			$result[$key]['completion_date'] = (!empty($value['completion_date'])) ? date('d-m-Y', strtotime($value['completion_date'])) : '';
			$result[$key]['last_email_details'] = ($value['last_email_details'] != NULL) ? date('d-m-Y h:i a', strtotime($value['last_email_details'])): '';
			$result[$key]['date_of_submitted_by_tkc'] = date('d-m-Y', strtotime($value['createddate']));
		}

		$package_group_nos = $this->cbt_model->getPackageGroupNos();

		$circle_list = $this->cbt_model->getCircleList();
		$circle_list = $this->sort_array_by_key($circle_list, 'circle_name');

        $user_access_data = $this->cbt_model->getUserModuleAccess();
		$user_access = $this->sortUserModuleAccess($user_access_data);

		$data['ncr_data'] = $result;
		$data['package_group_nos'] = $package_group_nos;
		$data['circles'] = $circle_list;
		$data['user_access'] = $user_access;
		$data['title'] = 'Compliance By TKC';

		// echo '<pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('compliance-by-tkc/compliance-by-tkc', $data);
	}

	public function searchComplianceByTKC()
	{
		if (!empty($_POST)) {
			$filter_arr = [];

			$contractor = $this->input->post('contractor');
			$filter_arr['contractor']['label'] = 'Contractor (TKC)';
           	$filter_arr['contractor']['value'] = $contractor;

           	$compliance_date_range = $this->input->post('complianceByTKCDate');
           	$filter_arr['complianceByTKCDate']['label'] = 'Compliance By TKC Date';
           	$filter_arr['complianceByTKCDate']['value'] = $compliance_date_range;

           	$feeder_id = $this->input->post('feederID');
			$filter_arr['feederID']['label'] = 'Feeder ID';
           	$filter_arr['feederID']['value'] = $feeder_id;

           	$ncr_id = $this->input->post('ncrID');
           	$filter_arr['ncrID']['label'] = 'NCR ID';
           	$filter_arr['ncrID']['value'] = $ncr_id;

           	$package_group_no = isset($_POST['package_group_no']) ? $this->input->post('package_group_no') : '';
           	$filter_arr['package_group_no']['label'] = 'Lot No.';
           	$filter_arr['package_group_no']['value'] = (!empty($package_group_no)) ? implode(', ', $package_group_no) : '';
           	$filter_arr['package_group_no']['id'] = $package_group_no;

           	$circle = (isset($_POST['circle'])) ? $this->input->post('circle') : '';
           	$filter_arr['circle']['label'] = 'Circle';
            $filter_arr['circle']['value'] = (isset($_POST['circle'])) ? $this->cbt_model->getCircle($circle) : '';
            $filter_arr['circle']['id'] = $circle;

            $result = $this->cbt_model->searchComplianceByTKC($contractor, $compliance_date_range, $feeder_id, $ncr_id, $package_group_no, $circle);

            // Formatting Dates
			foreach ($result as $key => $value) {
				$result[$key]['ncr_date'] = date('d-m-Y', strtotime($value['ncr_date']));
				$result[$key]['completion_date'] = (!empty($value['completion_date'])) ? date('d-m-Y', strtotime($value['completion_date'])) : '';
				$result[$key]['last_email_details'] = ($value['last_email_details'] != NULL) ? date('d-m-Y h:i a', strtotime($value['last_email_details'])): '';
				$result[$key]['date_of_submitted_by_tkc'] = date('d-m-Y', strtotime($value['createddate']));
			}

			$package_group_nos = $this->cbt_model->getPackageGroupNos();

			$circle_list = $this->cbt_model->getCircleList();
			$circle_list = $this->sort_array_by_key($circle_list, 'circle_name');

	        $user_access_data = $this->cbt_model->getUserModuleAccess();
			$user_access = $this->sortUserModuleAccess($user_access_data);

			$data['ncr_data'] = $result;
			$data['filter_data'] = $filter_arr;
			$data['package_group_nos'] = $package_group_nos;
			$data['circles'] = $circle_list;
			$data['user_access'] = $user_access;
			$data['title'] = 'Compliance By TKC';

			// echo '<pre>'; print_r($data); echo '</pre>'; die();
			$this->load->view('compliance-by-tkc/compliance-by-tkc', $data);
		}
	}

	public function viewComplianceByTKC($pp_activity_obs_id)
	{
		$obs_result = $this->cbt_model->getNCRDetails($pp_activity_obs_id);

		// Formatting Dates
		$obs_result['ncr_date'] = date('d-m-Y', strtotime($obs_result['ncr_date']));
		$obs_result['completion_date'] = (!empty($obs_result['completion_date'])) ? date('d-m-Y', strtotime($obs_result['completion_date'])) : '';

		//Getting Observations for an activity
		$activity_observations = $this->cbt_model->getActivityObservations($obs_result['activity_id']);

		$data['ncr_data'] = $obs_result;
		$data['activity_observations'] = $activity_observations;
		$data['logged_user_role_id'] = $_SESSION['loggedData']->role_id;
		$data['logged_user_role'] = $this->cbt_model->getUserRole($_SESSION['loggedData']->role_id);
		$data['title'] = 'Compliance By TKC';

		// echo '<pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('compliance-by-tkc/view-compliance-by-tkc', $data);
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

 	public function downloadComplianceByTKC($pp_activity_obs_id)
 	{
 		$user_id = $this->cbt_model->getLoggedInUserID();

 		// Generating NCR Report data
		$ncr_details = $this->cbt_model->getNCRDetails($pp_activity_obs_id);

		$result = $this->cbt_model->getNCRReportData($ncr_details['ncr_id'], $user_id);

		$report_data = [];
		$report_data = $result[0];

		if (!empty($report_data['observation_photos'])) {
			$observation_photos = explode(',', $report_data['observation_photos']);

			$report_data['observation_photos'] = [];
			$temp_observation_photos = [];

			foreach ($observation_photos as $obs_key => $obs_value) {
				$encoded_img = $this->encode_img_base64($obs_value);
				array_push($temp_observation_photos, $encoded_img);
			}

			$report_data['observation_photos'] = implode(', ', $temp_observation_photos);
		}

		if (!empty($report_data['completion_photos'])) {
			$observation_completion_photos = explode(',', $report_data['completion_photos']);

			$report_data['completion_photos'] = [];
			$temp_observation_completion_photos = [];

			foreach ($observation_completion_photos as $obs_key => $obs_value) {
				$encoded_img = $this->encode_img_base64($obs_value);
				array_push($temp_observation_completion_photos, $encoded_img);
			}

			$report_data['completion_photos'] = implode(', ', $temp_observation_completion_photos);
		}

		if (!empty($ncr_details['observation_tkc_files'])) {
			$observation_tkc_photos = $ncr_details['observation_tkc_files'];

			$report_data['observation_by_tkc_photos'] = [];
			$temp_observation_tkc_photos = [];

			foreach ($observation_tkc_photos as $obs_tkc_key => $obs_tkc_value) {
				$encoded_img = $this->encode_img_base64($obs_tkc_value['file_path']);
				array_push($temp_observation_tkc_photos, $encoded_img);
			}

			$report_data['observation_by_tkc_photos'] = implode(', ', $temp_observation_tkc_photos);
		}		

		$this->createPDF($report_data, $ncr_details['ncr_id']);
 	}

 	public function createPDF($report_data, $ncr_id)
 	{
 		$data['report_data'] = $report_data;
 		$html = $this->load->view('compliance-by-tkc/compliance-by-tkc-pdf', $data, true);

 		$folder_path = 'assets/compliance-by-tkc-pdf/';
 		$pdf_name = $folder_path.'Compliance_By_TKC_'.$ncr_id.'.pdf';

 		$this->pdf->createPDFForComplianceByTKC($html, $pdf_name);
 	}

 	public function encode_img_base64($img_path)
	{
		$type = pathinfo($img_path, PATHINFO_EXTENSION);

		//Temporary Code
        $arrContextOptions = array(
            "ssl" => array(
                'cafile' => '/path/to/bundle/cacert.pem',
                "verify_peer" => false,
                "verify_peer_name" => false
            ),
        );

        $img_path = base_url($img_path);
        // $img_path = 'https://mpwzrdss.co.in/'.$img_path; //Delete Later

		$data = file_get_contents($img_path, false, stream_context_create($arrContextOptions));
		return 'data:image/'.$type.';base64,'.base64_encode($data);
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