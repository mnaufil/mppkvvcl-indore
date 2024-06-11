<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Report extends CI_Controller
{	
	function __construct()
	{
		parent::__construct();

		//$this->load->library('form_validation');
		$this->load->model('Report_Model');
		$this->load->model('Setup_Model');
		if(!$this->session->isUserLoggedIn)
    { 
      redirect('login'); 
    }
	}

	public function index()
	{
		$report_access_list = $this->Report_Model->getReportAccessList();
		$data['report_list'] = $report_access_list;
		$data['title'] = 'Reports';

		// echo 'data: <pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('report/reports', $data);
	}

	public function viewReport()
	{
		$data['packages'] = $this->Report_Model->loadPackages();
		$data['regions'] = $user_regions = $this->Report_Model->loadRegions();
		$user_circles = $this->Report_Model->loadCircles();
	  $user_divisions = $this->Report_Model->loadDivisions();

		$data['reportType'] = "";
	  $data['postpackage'] = array();
	  $data['postregion'] = "";
		$data['postcircle'] = "";
		$data['poststatus'] = "";
		$data['postfeederId'] = "";
		$data['reportData'] = array();
		$data['allRegion'] = array();
		$data['allCircle'] = array();
		$data['allDivision'] = array();
		
		$user_regions = $this->getRegionIDs($user_regions);
		$user_circles = $this->getCirlceIDs($user_circles);
		$user_divisions = $this->getDivisionIDs($user_divisions);

		/*$region_data = $this->Report_Model->getRegionData();
		$data['region_data'] = $region_data;*/

		$circle_data = $this->Report_Model->getCircleData($user_circles);
		$data['circles'] = $this->groupCircleData($circle_data);

		$division_data = $this->Report_Model->getDivisionData($user_divisions);
		$data['divisions'] = $this->groupDivisionData($division_data);

		$data['title'] = 'View Report';

		// echo 'data: <pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('report/view-report', $data);
	}

	public function generatePhysicalReport()
	{
		$data['postpackage'] = $package = $this->input->post('packageNo');
		$data['postfeederId'] = $feederId = $this->input->post('feederId');

		$data['packages'] = $this->Report_Model->loadPackages();

		$data['regions'] = $user_regions = $this->Report_Model->loadRegions();
		$user_regions = $this->getRegionIDs($user_regions);

		$user_circles = $this->Report_Model->loadCircles();
		$user_circles = $this->getCirlceIDs($user_circles);
		$circle_data = $this->Report_Model->getCircleData($user_circles);
		$data['circles'] = $this->groupCircleData($circle_data);

		$user_divisions = $this->Report_Model->loadDivisions();
		$user_divisions = $this->getDivisionIDs($user_divisions);
		$division_data = $this->Report_Model->getDivisionData($user_divisions);
		$data['divisions'] = $this->groupDivisionData($division_data);

		$data['reportType'] = $reportType = $this->input->post('reportType');

		if ($this->checkLocationAccess($this->input->post('feederId'), $this->input->post('packageNo'))) {
			$data['feeder_access'] = true;

			$data['sel_region'] = (!empty($this->input->post('region'))) ? $this->input->post('region') : [];
			$data['sel_circle'] = (!empty($this->input->post('circle'))) ? $this->input->post('circle') : [];
			$data['sel_division'] = (!empty($this->input->post('division'))) ? $this->input->post('division') : [];

			$user_role_id = $_SESSION['loggedData']->role_id;
			$report_name = 'Physical Progress';
			$report_access = $this->Report_Model->getReportAccessData($report_name, $user_role_id);

			$data['download_access'] = false;
			foreach ($report_access as $key => $value) {
				if (str_contains($value['access_key'], 'download')) {
					$data['download_access'] = true;
				}
			}

			if($reportType == 2)
			{
				$reportData = $this->Report_Model->generatePhysicalReport();

				if (empty($reportData['result'])) {
					$data['reportData'] = 'No Records Found';
				} else {
					$data['reportData'] = $reportData;
				}
			} elseif ($reportType == 1)
			{
				$reportData = $this->Report_Model->generatePhysicalReportFeederWise();

				if (empty($reportData)) {
					$data['reportData'] = 'No Records Found';
				} else {
					$myVar = $reportData[0];
					$onlyKeys = array();

					foreach($myVar as $key => $value) {
						array_push($onlyKeys, $key);
					}

					$data['onlyKeys'] = $onlyKeys;

					$mainHeadingArray = $subHeadingArray = $subSubHeadingArray = [];

					foreach($data['onlyKeys'] as $mainHeading)
					{
						if ($mainHeading == 'feeder_id' || $mainHeading == 'region_name' || $mainHeading == 'circle_name' || $mainHeading == 'division_name' || $mainHeading == 'pstatus' || $mainHeading == 'vidhansabha' || $mainHeading == 'district' || $mainHeading == 'loksabha') {
							continue;
						}

						$explode = explode("__", $mainHeading);
						array_push($mainHeadingArray, $explode[0]);
	 					array_push($subHeadingArray, $explode[1].' ('.$explode[2].')');
	 					array_push($subSubHeadingArray, $explode[3]);
					}

					$mainHeadingArray = array_unique($mainHeadingArray);

					$header_count = [];
					foreach ($mainHeadingArray as $group_name) {
						$header_count[$group_name] = 0;
						foreach ($data['onlyKeys'] as $value) {
							$match = '/^'.$group_name.'__/';
							if (preg_match($match, $value)) {
								$header_count[$group_name]++;
							}
						}
					}

					$data['mainHeadingArray'] = $header_count;
					$data['subHeadingArray'] = $subHeadingArray;
					$data['subSubHeadingArray'] = $subSubHeadingArray;

					// Modifying reportData
					$modified_report_data = [];
					
					foreach ($reportData as $key => $value) {
						$i = 1;
						foreach ($value as $k => $val) {
							if (str_contains($k, 'boq_qty')) {
								$boq_key = 'boq_qty_'.$i;
								$modified_report_data[$value['feeder_id']][$boq_key] = $val;

								$i++;
							} elseif (str_contains($k, 'erection_qty')) {
								$erection_key = 'erection_qty_'.$i;
								$modified_report_data[$value['feeder_id']][$erection_key] = $val;

								$i++;
							} elseif (str_contains($k, 'region_name')) {
								$modified_report_data[$value['feeder_id']]['region_name'] = $val;
							} elseif (str_contains($k, 'circle_name')) {
								$modified_report_data[$value['feeder_id']]['circle_name'] = $val;
							} elseif (str_contains($k, 'division_name')) {
								$modified_report_data[$value['feeder_id']]['division_name'] = $val;
							} elseif (str_contains($k, 'pstatus')) {
								$modified_report_data[$value['feeder_id']]['pstatus'] = $val;
							} elseif (str_contains($k, 'vidhansabha')) {
								$modified_report_data[$value['feeder_id']]['vidhansabha'] = $val;
							} elseif (str_contains($k, 'loksabha')) {
								$modified_report_data[$value['feeder_id']]['loksabha'] = $val;
							} elseif (str_contains($k, 'district')) {
								$modified_report_data[$value['feeder_id']]['district'] = $val;
							}
						}
					}

					$data['reportData'] = $modified_report_data;
				}
			}
		} else {
			$data['feeder_access'] = false;
		}

		$data['title'] = 'View Report';

		// echo 'data: <pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('report/view-report', $data);
	}

	public function getRegionIDs($user_regions)
	{
		$user_region_ids = [];

		foreach ($user_regions as $key => $value) {
			array_push($user_region_ids, $value->region_id);
		}

		return $user_region_ids;
	}

	public function getCirlceIDs($user_circles)
	{
		$user_circle_ids = [];

		foreach ($user_circles as $key => $value) {
			array_push($user_circle_ids, $value->circle_id);
		}

		return $user_circle_ids;
	}

	public function getDivisionIDs($user_divisions)
	{
		$user_divisions_ids = [];

		foreach ($user_divisions as $key => $value) {
			array_push($user_divisions_ids, $value->division_id);
		}

		return $user_divisions_ids;
	}

	public function checkLocationAccess($feeder_id, $package_no)
	{
		$user_regions = $this->Report_Model->loadRegions();
		$user_regions = $this->getRegionIDs($user_regions);

		$user_circles = $this->Report_Model->loadCircles();
		$user_circles = $this->getCirlceIDs($user_circles);

		$user_divisions = $this->Report_Model->loadDivisions();
		$user_divisions = $this->getDivisionIDs($user_divisions);

		if (!empty($feeder_id)) {
			$feeder_location_data = $this->Report_Model->getFeederLocationData($feeder_id);

			if (in_array($feeder_location_data['region_id'], $user_regions) && in_array($feeder_location_data['circle_id'], $user_circles) && in_array($feeder_location_data['division_id'], $user_divisions)) {
				return 1;
			} else {
				return 0;
			}
		} else {
			$feeders_data = $this->Report_Model->getFeedersLocationDataByPackageNo($package_no);

			$feeder_location_data['region_id'] = $feeder_location_data['circle_id'] = $feeder_location_data['division_id'] = [];
			foreach ($feeders_data as $key => $value) {
				array_push($feeder_location_data['region_id'], $value['region_id']);
				array_push($feeder_location_data['circle_id'], $value['circle_id']);
				array_push($feeder_location_data['division_id'], $value['division_id']);
			}

			$feeder_location_data['region_id'] = array_unique($feeder_location_data['region_id']);
			$feeder_location_data['circle_id'] = array_unique($feeder_location_data['circle_id']);
			$feeder_location_data['division_id'] = array_unique($feeder_location_data['division_id']);

			$region_result = array_intersect($user_regions, $feeder_location_data['region_id']);
			$circle_result = array_intersect($user_circles, $feeder_location_data['circle_id']);
			$division_result = array_intersect($user_divisions, $feeder_location_data['division_id']);

			if ((count($region_result) > 0) && (count($circle_result) > 0) && (count($division_result) > 0)) {
				return 1;
			} else {
				return 0;
			}
		}
	}
	
	public function visitReport()
	{
		$data['employees'] = $this->Report_Model->loadEmployees();
		$data['packages'] = $this->Report_Model->loadPackages();
		$data['regions'] = $this->Report_Model->loadRegions();
		$data['circles'] = $this->Report_Model->loadCircles();
		$data['statuss'] = $this->Report_Model->loadPhysicalStatus();
		$circle_data = $this->Report_Model->getRegionCircleData();
		$data['circle_data'] = $this->modifyCircleData($circle_data);
		
		$data['physicalProgressDate'] = $this->input->post('physicalProgressDate');
		$data['employee'] = "";			
		$data['package'] = "";
		$data['region'] = "";	
		$data['circle'] = "";
		//$data['status'] = 	"";
		$data['reportType'] = "";
		$data['allEmployee'] = array();	
	  $data['allPackage'] = array();
		$data['allRegion'] = array();
		$data['allCircle'] = array();
		$data['status'] = array();
		$data['reportType'] = "";

		$this->load->view('report/visit-report', $data);
	}

	public function modifyCircleData($circle_data)
	{
		$modified_circle_data = [];

		foreach ($circle_data as $key => $value) {
			$modified_circle_data[$value['region_id']][$value['circle_id']] = $value['circle_name'];
		}

		return $modified_circle_data;
	}
	
	public function generateVisitReport()
	{	
		$data['employees'] = $this->Report_Model->loadEmployees();
		$data['packages'] = $this->Report_Model->loadPackages();
		$data['regions'] = $this->Report_Model->loadRegions();
		$data['circles'] = $this->Report_Model->loadCircles();	
		$data['statuss'] = $this->Report_Model->loadPhysicalStatus();
		$data['reportType'] = 	$this->input->post('reportType');
		
		$data['allEmployee'] = array();	
	  $data['allPackage'] = array();
		$data['allRegion'] = array();
		$data['allCircle'] = array();
		$data['status'] = array();		
		
		$data['physicalProgressDate'] = $this->input->post('physicalProgressDate');
		
		$data['employee'] = $this->input->post('employee');	
		if(!empty($this->input->post('allemployee')))
		{
			$data['allEmployee'] = $this->input->post('allemployee');	
		}

		$data['package'] = $this->input->post('package');
		if(!empty($this->input->post('allpackage')))
		{
			$data['allPackage'] = $this->input->post('allpackage');
		}

		$data['region'] = $this->input->post('region');
		if(!empty($this->input->post('allregion')))
		{
		  $data['allRegion'] = $this->input->post('allregion');
		}

		$data['circle'] = $this->input->post('circle');
		if(!empty($this->input->post('allcircle')))
		{
		  $data['allCircle'] = $this->input->post('allcircle');
		}

		if(!empty($this->input->post('status')))
		{
			$data['status'] =	$this->input->post('status');
		}
		$data['reportType'] =	$this->input->post('reportType');

		// $data['reportData'] = $this->Report_Model->generateVisitReport();
		$reportData = $this->Report_Model->generateVisitReport();
		$data['reportData'] = !empty($reportData) ? $reportData : 'No Records Found';

		$user_role_id = $_SESSION['loggedData']->role_id;
		$report_name = 'Visit Report';
		$report_access = $this->Report_Model->getReportAccessData($report_name, $user_role_id);

		$data['download_access'] = false;
		foreach ($report_access as $key => $value) {
			if (str_contains($value['access_key'], 'download')) {
				$data['download_access'] = true;
			}
		}
				
		// echo 'data: <pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('report/visit-report', $data);
	}	
	
	public function ncrReport()
	{
		$data['employees'] = $this->Report_Model->loadEmployees();
		$data['packages'] = $this->Report_Model->loadPackages();
		$data['regions'] = $this->Report_Model->loadRegions();
		$data['circles'] = $this->Report_Model->loadCircles();
		$data['status'] = $this->Report_Model->loadPhysicalStatus();
		$circle_data = $this->Report_Model->getRegionCircleData();
		$data['circle_data'] = $this->modifyCircleData($circle_data);
		$data['reportType'] = "";
		
		$data['physicalProgressDate'] = $this->input->post('physicalProgressDate');
		$data['employee'] = "";			
		$data['package'] = "";
		$data['region'] = "";	
		$data['circle'] = 	"";
		$data['status'] = 	"";
		$data['reportType'] = 	"";
		$data['allEmployee'] = array();	
	  $data['allPackage'] = array();
		$data['allRegion'] = array();
		$data['allCircle'] = array();
		$data['ncr_status'] = array();

		$this->load->view('report/ncr-report', $data);
	}	
	
	public function generateNcrReport()
	{	
		$data['employees'] = $this->Report_Model->loadEmployees();
		$data['packages'] = $this->Report_Model->loadPackages();
		$data['regions'] = $this->Report_Model->loadRegions();
		$data['circles'] = $this->Report_Model->loadCircles();	
		$data['status'] = $this->Report_Model->loadPhysicalStatus();
		$circle_data = $this->Report_Model->getRegionCircleData();
		$data['circle_data'] = $this->modifyCircleData($circle_data);
		$data['reportType'] = 	$this->input->post('reportType');		
		
		$data['allEmployee'] = array();	
	  $data['allPackage'] = array();
		$data['allRegion'] = array();
		$data['allCircle'] = array();
		$data['ncr_status'] = array();		
		
		$data['physicalProgressDate'] = $this->input->post('physicalProgressDate');

		$data['employee'] = $this->input->post('employee');	
		if(!empty($this->input->post('allemployee')))
		{
			$data['allEmployee'] = $this->input->post('allemployee');	
		}

		$data['package'] = $this->input->post('package');
		if(!empty($this->input->post('allpackage')))
		{
			$data['allPackage'] = $this->input->post('allpackage');
		}

		$data['region'] = $this->input->post('region');
		if(!empty($this->input->post('allregion')))
		{
		  $data['allRegion'] = $this->input->post('allregion');
		  $selected_circles = [];
		  foreach ($data['allRegion'] as $region_id) {
		  	foreach ($circle_data as $circle) {
		  		if ($circle['region_id'] == $region_id) {
		  			array_push($selected_circles, (object) $circle);
		  		}
		  	}
		  }

		  $data['circles'] = $selected_circles;
		}

		$data['circle'] = $this->input->post('circle');
		if(!empty($this->input->post('allcircle')))
		{
		  $data['allCircle'] = $this->input->post('allcircle');
		}

		if(!empty($this->input->post('ncr_status')))
		{
			$data['ncr_status'] = $this->input->post('ncr_status');
		}

		$data['reportType'] = $this->input->post('reportType');

		// $data['reportData'] = $this->Report_Model->generateNcrReport();
		$reportData = $this->Report_Model->generateNcrReport();
		$data['reportData'] = !empty($reportData) ? $reportData : 'No Records Found';

		$user_role_id = $_SESSION['loggedData']->role_id;
		$report_name = 'NCR Data';
		$report_access = $this->Report_Model->getReportAccessData($report_name, $user_role_id);

		$data['download_access'] = false;
		foreach ($report_access as $key => $value) {
			if (str_contains($value['access_key'], 'download')) {
				$data['download_access'] = true;
			}
		}

		// echo 'data: <pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('report/ncr-report', $data);
	}	
	
	public function exportExcelSp()
	{
		$spQuery = $_SESSION['spQuery']; 
		$query = $this->db->query($spQuery);
		
		$tasks = array();
		
		foreach($query->result_array() as $rows)
		{
			$tasks[] = $rows;
		}
		
		$filename = "report-".date('Ymd') . ".xls";     
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$filename\"");
		$heading = false;

    if(!empty($tasks))
      foreach($tasks as $row) {
	      if(!$heading) {
	        // display field/column names as a first row
	        echo implode("\t", array_keys($row)) . "\n";
	        $heading = true;
	      }

      	echo implode("\t", array_values($row)) . "\n";
     	}
    	exit;
	}	
	
	public function contractSummaryReport()
	{
		//$data['packages'] = $this->Report_Model->loadPackages();
	  $data['postpackage'] = "";
		$data['postfeederId'] = "";
		$data['reportData'] = array();
		$this->load->view('report/contract-summary', $data);
	}
	
	public function generateContractSummaryReport()
	{
		$data['outputOption'] = $this->input->post('outputOption'); 

		$data['reportData'] = $this->Report_Model->generateContractSummaryReport();

		$user_role_id = $_SESSION['loggedData']->role_id;
		$report_name = 'Contract Summary';
		$report_access = $this->Report_Model->getReportAccessData($report_name, $user_role_id);

		$data['download_access'] = false;
		foreach ($report_access as $key => $value) {
			if (str_contains($value['access_key'], 'download')) {
				$data['download_access'] = true;
			}
		}
		
		// echo 'data: <pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('report/contract-summary', $data);
	}
	
	public function bgSummaryReport()
	{
		$data['packageNo'] = ""; 
		$data['contractor'] = "";
		$data['typeOfWork'] = "";
		
		$data['packages'] = $this->Report_Model->loadPackages();
		$data['worktypes'] = $this->Setup_Model->loadworktypes();
	  $data['postpackage'] = "";
		$data['postfeederId'] = "";
		$data['reportData'] = array();

		$this->load->view('report/bg-report', $data);
	}
	
	public function generateBgSummaryReport()
	{
		$data['packageNo'] = $this->input->post('packageNo'); 
		$data['contractor'] = $this->input->post('contractor');
		$data['typeOfWork'] = $this->input->post('typeOfWork');
		
		$data['packages'] = $this->Report_Model->loadPackages();
		$data['worktypes'] = $this->Setup_Model->loadworktypes();

		if ($this->checkLocationAccess(NULL, $this->input->post('packageNo'))) {
			$data['feeder_access'] = true;

			$reportData = $this->Report_Model->generateBgSummaryReport();
			$data['reportData'] = !empty($reportData) ? $reportData : 'No Records Found';

			$user_role_id = $_SESSION['loggedData']->role_id;
			$report_name = 'BG Summary';
			$report_access = $this->Report_Model->getReportAccessData($report_name, $user_role_id);

			$data['download_access'] = false;
			foreach ($report_access as $key => $value) {
				if (str_contains($value['access_key'], 'download')) {
					$data['download_access'] = true;
				}
			}	
		} else {
			$data['feeder_access'] = false;
		}		
		
		// echo 'data: <pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('report/bg-report', $data);
	}

	public function mobilisationSummaryReport()
	{
		$data['packageNo'] = ""; 
		$data['contractor'] = "";
		$data['typeOfWork'] = "";
		
		$data['packages'] = $this->Report_Model->loadPackages();
		$data['worktypes'] = $this->Setup_Model->loadworktypes();
	  $data['postpackage'] = "";
		$data['postfeederId'] = "";
		$data['reportData'] = array();

		// echo 'data: <pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('report/mobilisation-summary-report', $data);
	}	
	
	public function generateMobilisationSummaryReport()
	{	
		$data['packageNo'] = $this->input->post('packageNo'); 
		$data['contractor'] = $this->input->post('contractor');
		$data['typeOfWork'] = $this->input->post('typeOfWork');
		
		$data['packages'] = $this->Report_Model->loadPackages();
		$data['worktypes'] = $this->Setup_Model->loadworktypes();

		if ($this->checkLocationAccess(NULL, $this->input->post('packageNo'))) {
			$data['feeder_access'] = true;
			
			$reportData = $this->Report_Model->generateMobilisationSummaryReport();
			$data['reportData'] = (!empty($reportData)) ? $reportData : 'No Records Found';

			$user_role_id = $_SESSION['loggedData']->role_id;
			$report_name = 'Mobilisation Summary';
			$report_access = $this->Report_Model->getReportAccessData($report_name, $user_role_id);

			$data['download_access'] = false;
			foreach ($report_access as $key => $value) {
				if (str_contains($value['access_key'], 'download')) {
					$data['download_access'] = true;
				}
			}	
		} else {
			$data['feeder_access'] = false;
		}
		
		// echo 'data: <pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('report/mobilisation-summary-report', $data);
	}

	public function nonConformanceReport()
	{
		$data['packageNo'] = ""; 
		$data['contractor'] = "";
		$data['typeOfWork'] = "";
		
		$data['packages'] = $this->Report_Model->loadPackages();
		$data['worktypes'] = $this->Setup_Model->loadworktypes();
		$data['regions'] = $user_regions = $this->Report_Model->loadRegions();

		$user_circles = $this->Report_Model->loadCircles();
		$user_circles = $this->getCirlceIDs($user_circles);
		$circle_data = $this->Report_Model->getCircleData($user_circles);
		$data['circle_data'] = $this->groupCircleData($circle_data);

	  $data['postpackage'] = [];
		$data['postregion'] = "";
		$data['postcircle'] = "";
		$data['poststatus'] = "";

		$data['reportData'] = array();
		
		// echo '<pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('report/non-conformance-report', $data);
	}

	public function groupCircleData($circle_data)
	{
		$circles = [];
		foreach ($circle_data as $key => $value) {
			$circles[$value['region']][$value['circle_id']] = $value['circle'];
		}

		// Sorting the new array alphabetically
		foreach ($circles as $key => $value) {
			asort($value);
			$circles[$key] = $value;
		}

		return $circles;
	}

	public function groupDivisionData($division_data)
	{
		$divisions = [];
		foreach ($division_data as $key => $value) {
			$divisions[$value['circle_name']][$value['division_id']] = $value['division_name'];
		}

		// Sorting the new array alphabetically
		foreach ($divisions as $key => $value) {
			asort($value);
			$divisions[$key] = $value;
		}

		return $divisions;
	}

	public function generateNonConformaceReport()
	{
		$data['packages'] = $this->Report_Model->loadPackages();
		$data['regions'] = $user_regions = $this->Report_Model->loadRegions();

		$user_circles = $this->Report_Model->loadCircles();
		$user_circles = $this->getCirlceIDs($user_circles);
		$circle_data = $this->Report_Model->getCircleData($user_circles);
		$data['circle_data'] = $this->groupCircleData($circle_data);

		$data['selected_region_circle_data'] = $this->Report_Model->getSelectedRegionCircles($this->input->post('region'), $user_circles);

		$data['postpackage'] = $this->input->post('packageNo');
		$data['postregion'] = $this->input->post('region');
		$data['postcircle'] = $this->input->post('circle');

		$data['postncrDate'] = $this->input->post('ncrDate');
		$data['poststatus'] = $this->input->post('status');

		if ($this->checkLocationAccess(NULL, $this->input->post('packageNo'))) {
			$data['feeder_access'] = true;

			$reportData = $this->Report_Model->generateNonConformaceReport();
			if (empty($reportData)) {
				$data['reportData'] = 'No Records Found';
			} else {
				$grouped_ncr_data = $this->groupNCRs($reportData);

				$data['reportData'] = $grouped_ncr_data;
			}

			$user_role_id = $_SESSION['loggedData']->role_id;
			$report_name = 'Non Conformance Report';
			$report_access = $this->Report_Model->getReportAccessData($report_name, $user_role_id);

			$data['download_access'] = false;
			foreach ($report_access as $key => $value) {
				if (str_contains($value['access_key'], 'download')) {
					$data['download_access'] = true;
				}
			}
		} else {
			$data['feeder_access'] = false;
		}

		// echo '<pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('report/non-conformance-report', $data);
	}

	public function groupNCRs($reportData)
	{
		// echo 'reportData: <pre>'; print_r($reportData); echo '</pre>'; 
		$feeder_wise_data = [];

		foreach ($reportData as $key => $value) {
			$feeder_wise_data[$value->feeder_id][] = $value;
		}

		// echo 'feeder_wise_data: <pre>'; print_r($feeder_wise_data); echo '</pre>'; die();
		return $feeder_wise_data;
	}

	public function materialStatusReport()
	{
		// $data['packages'] = $this->Report_Model->loadPackages();
		$data['packages'] = $this->Report_Model->loadPackagesForMaterialReports();
		$data['circles'] = $this->Report_Model->loadCircles();

		$data['packageNo'] = []; 
		$data['contractor'] = "";
		$data['circle'] = [];

		// echo 'data: <pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('report/material-status-report', $data);
	}

	public function generateMaterialStatusReport()
	{
		// echo '<pre>'; print_r($_POST); echo '</pre>'; die();
		// $data['packages'] = $this->Report_Model->loadPackages();
		$data['packages'] = $this->Report_Model->loadPackagesForMaterialReports();
		$data['circles'] = $this->Report_Model->loadCircles();

		$data['packageNo'] = $this->input->post('packageNo'); 
		// $data['contractor'] = $this->input->post('contractor');
		$data['circle'] = $this->input->post('circle');

		if ($this->checkLocationAccess(NULL, $this->input->post('packageNo'))) {
			$data['feeder_access'] = true;

			$reportData = $this->Report_Model->generateMaterialStatusReport();
			$data['reportData'] = !empty($reportData) ? $reportData : 'No Records Found';

			$user_role_id = $_SESSION['loggedData']->role_id;
			$report_name = 'Material Status Report';
			$report_access = $this->Report_Model->getReportAccessData($report_name, $user_role_id);

			$data['download_access'] = false;
			foreach ($report_access as $key => $value) {
				if (str_contains($value['access_key'], 'download')) {
					$data['download_access'] = true;
				}
			}
		} else {
			$data['feeder_access'] = false;
		}

		// echo 'data: <pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('report/material-status-report', $data);
	}

	public function materialStatusSummary()
	{
		// $data['packages'] = $this->Report_Model->loadPackages();
		$data['packages'] = $this->Report_Model->loadPackagesForMaterialReports();
		//$data['circles'] = $this->Report_Model->loadCircles();	

		$data['packageNo'] = ""; 
		//$data['contractor'] = "";

		$this->load->view('report/material-status-summary', $data);
	}

	public function generateMaterialStatusSummary()
	{
		// $data['packages'] = $this->Report_Model->loadPackages();
		$data['packages'] = $this->Report_Model->loadPackagesForMaterialReports();
		//$data['circles'] = $this->Report_Model->loadCircles();

		$data['packageNo'] = $this->input->post('packageNo'); 
		//$data['contractor'] = $this->input->post('contractor');
		$data['date'] = $this->input->post('date'); 

		if ($this->checkLocationAccess(NULL, $this->input->post('packageNo'))) {
			$data['feeder_access'] = true;

			$reportData = $this->Report_Model->generateMaterialStatusSummary();
			$data['reportData'] = !empty($reportData) ? $reportData : 'No Records Found';

			$user_role_id = $_SESSION['loggedData']->role_id;
			$report_name = 'Material Status Summary';
			$report_access = $this->Report_Model->getReportAccessData($report_name, $user_role_id);

			$data['download_access'] = false;
			foreach ($report_access as $key => $value) {
				if (str_contains($value['access_key'], 'download')) {
					$data['download_access'] = true;
				}
			}
		} else {
			$data['feeder_access'] = false;
		}
		
		// echo 'data: <pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('report/material-status-summary', $data);
	}

	public function cashFlowReport()
	{
		$data['packages'] = $this->Report_Model->loadPackages();

		$data['packageNo'] = [];

		$this->load->view('report/cash-flow-report', $data);
	}

	public function generateCashFlowReport()
	{
		$data['packages'] = $this->Report_Model->loadPackages();
		$data['packageNo'] = $this->input->post('packageNo');

		if ($this->checkLocationAccess(NULL, $this->input->post('packageNo'))) {
			$data['feeder_access'] = true;

			$reportData = $this->Report_Model->generateCashFlowReport();
			$data['reportData'] = !empty($reportData) ? $reportData : 'No Records Found';

			$user_role_id = $_SESSION['loggedData']->role_id;
			$report_name = 'Cash Flow';
			$report_access = $this->Report_Model->getReportAccessData($report_name, $user_role_id);

			$data['download_access'] = false;
			foreach ($report_access as $key => $value) {
				if (str_contains($value['access_key'], 'download')) {
					$data['download_access'] = true;
				}
			}
		} else {
			$data['feeder_access'] = false;
		}

		// echo 'data: <pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('report/cash-flow-report', $data);
	}

	public function invoicingPaymentReport()
	{	
		$data['packageNo'] = ""; 
		//$data['contractor'] = "";

		$this->load->view('report/invoicing-payment-report', $data);
	}

	public function generateInvoicingPaymentReport()
	{
		$data['date'] = $this->input->post('date'); 
		//$data['contractor'] = $this->input->post('contractor');

		// $data['reportData'] = $this->Report_Model->generateInvoicingPaymentReport();
		$reportData = $this->Report_Model->generateInvoicingPaymentReport();
		$data['reportData'] = !empty($reportData) ? $reportData : 'No Records Found';

		$user_role_id = $_SESSION['loggedData']->role_id;
		$report_name = 'Updated Position of Invoicing and Payment';
		$report_access = $this->Report_Model->getReportAccessData($report_name, $user_role_id);

		$data['download_access'] = false;
		foreach ($report_access as $key => $value) {
			if (str_contains($value['access_key'], 'download')) {
				$data['download_access'] = true;
			}
		}

		// echo '<pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('report/invoicing-payment-report', $data);
	}

	public function materialInwardSamplingReport()
	{
		// $package_nos = $this->Report_Model->getPackageNos();
		$package_nos = $this->Report_Model->loadPackagesForMaterialReports();
		$circles = $this->Report_Model->getCircles();
		$status_list = $this->Report_Model->getMaterialStatusList();
		$status_list = $this->modifyMaterialStatusList($status_list);

		$data['package_nos'] = $package_nos;
		$data['package_no'] = [];
		$data['circles'] = $circles;
		$data['circle'] = [];
		$data['status_list'] = $status_list;
		$data['title'] = 'Material Inward Sampling Report';

		// echo 'data: <pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('report/material-inward-sampling-report', $data);
	}

	public function generateMaterialInwardSamplingReport()
	{
		$data['package_no'] = $package_no = $this->input->post('packageNo');
		$data['circle'] = $circle = $this->input->post('circle');
		$data['status'] = $status = $this->input->post('status');

		$data['material_received_date'] = $material_received_date = $this->input->post('matrerialReceivedDate');
		$dates_arr = explode(' - ', $material_received_date);
		$from_date = date('Y-m-d', strtotime($dates_arr[0]));
		$to_date = date('Y-m-d', strtotime($dates_arr[1]));

		// $package_nos = $this->Report_Model->getPackageNos();
		$package_nos = $this->Report_Model->loadPackagesForMaterialReports();
		$circles = $this->Report_Model->getCircles();
		$status_list = $this->Report_Model->getMaterialStatusList();
		$status_list = $this->modifyMaterialStatusList($status_list);

		if ($this->checkLocationAccess(NULL, $package_no)) {
			$report_data = $this->Report_Model->generateMaterialInwardSamplingReport($package_no, $circle, $status, $from_date, $to_date);

			$user_role_id = $_SESSION['loggedData']->role_id;
			$report_name = 'Material Inward Sampling';
			$report_access = $this->Report_Model->getReportAccessData($report_name, $user_role_id);

			$data['download_access'] = false;
			foreach ($report_access as $key => $value) {
				if (str_contains($value['access_key'], 'download')) {
					$data['download_access'] = true;
				}
			}

			$data['report_data'] = !empty($report_data) ? $report_data : 'No Records Found';
			$data['package_nos'] = $package_nos;
			$data['circles'] = $circles;
			$data['status_list'] = $status_list;
			
			$data['feeder_access'] = true;
		} else {
			$data['feeder_access'] = false;
		}

		$data['title'] = 'Material Inward Sampling Report';

		// echo 'data: <pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('report/material-inward-sampling-report', $data);
	}

	public function materialInwardMICCDetailsReport()
	{
		// $package_nos = $this->Report_Model->getPackageNos();
		$package_nos = $this->Report_Model->loadPackagesForMaterialReports();
		$circles = $this->Report_Model->getCircles();
		$status_list = $this->Report_Model->getMaterialStatusList();
		$status_list = $this->modifyMaterialStatusList($status_list);

		$data['package_nos'] = $package_nos;
		$data['package_no'] = [];
		$data['circles'] = $circles;
		$data['circle'] = [];
		$data['status_list'] = $status_list;
		$data['title'] = 'Material Inward MICC Details Report';

		// echo 'data: <pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('report/material-inward-micc-details-report', $data);
	}

	public function generateMaterialInwardMICCDetailsReport()
	{
		$data['package_no'] = $package_no = $this->input->post('packageNo');
		$data['circle'] = $circle = $this->input->post('circle');
		$data['status'] = $status = $this->input->post('status');
		$data['di_no'] = $di_no = $this->input->post('di_no');

		$data['material_received_date'] = $material_received_date = $this->input->post('matrerialReceivedDate');
		$dates_arr = explode(' - ', $material_received_date);
		$from_date = date('Y-m-d', strtotime($dates_arr[0]));
		$to_date = date('Y-m-d', strtotime($dates_arr[1]));

		// $package_nos = $this->Report_Model->getPackageNos();
		$package_nos = $this->Report_Model->loadPackagesForMaterialReports();
		$circles = $this->Report_Model->getCircles();
		$status_list = $this->Report_Model->getMaterialStatusList();
		$status_list = $this->modifyMaterialStatusList($status_list);

		if ($this->checkLocationAccess(NULL, $package_no)) {
			$report_data = $this->Report_Model->generateMaterialInwardMICCDetailsReport($package_no, $circle, $status, $di_no, $from_date, $to_date);	

			$user_role_id = $_SESSION['loggedData']->role_id;
			$report_name = 'Material Inward MICC Details';
			$report_access = $this->Report_Model->getReportAccessData($report_name, $user_role_id);

			$data['download_access'] = false;
			foreach ($report_access as $key => $value) {
				if (str_contains($value['access_key'], 'download')) {
					$data['download_access'] = true;
				}
			}

			$data['report_data'] = !empty($report_data) ? $report_data : 'No Records Found';
			$data['package_nos'] = $package_nos;
			$data['circles'] = $circles;
			$data['status_list'] = $status_list;
			
			$data['feeder_access'] = true;
		} else {
			$data['feeder_access'] = false;
		}

		$data['title'] = 'Material Inward MICC Details Report';

		// echo 'data: <pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('report/material-inward-micc-details-report', $data);
	}

	public function materialInwardReport()
	{
		// $package_nos = $this->Report_Model->getPackageNos();
		$package_nos = $this->Report_Model->loadPackagesForMaterialReports();
		$circles = $this->Report_Model->getCircles();		

		$data['package_nos'] = $package_nos;
		$data['package_no'] = [];
		$data['circles'] = $circles;
		$data['circle'] = [];
		$data['title'] = 'Material Inward Report';

		// echo 'data: <pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('report/material-inward-report', $data);
	}

	public function generateMaterialInwardReport()
	{
		$data['package_no'] = $package_no = $this->input->post('packageNo');
		$data['circle'] = $circle = $this->input->post('circle');

		$data['material_received_date'] = $material_received_date = $this->input->post('matrerialReceivedDate');
		$dates_arr = explode(' - ', $material_received_date);
		$from_date = date('Y-m-d', strtotime($dates_arr[0]));
		$to_date = date('Y-m-d', strtotime($dates_arr[1]));

		// $package_nos = $this->Report_Model->getPackageNos();
		$package_nos = $this->Report_Model->loadPackagesForMaterialReports();
		$circles = $this->Report_Model->getCircles();

		if ($this->checkLocationAccess(NULL, $package_no)) {
			$report_data = $this->Report_Model->generateMaterialInwardReport($package_no, $circle, $from_date, $to_date);

			$user_role_id = $_SESSION['loggedData']->role_id;
			$report_name = 'Material Inward';
			$report_access = $this->Report_Model->getReportAccessData($report_name, $user_role_id);

			$data['download_access'] = false;
			foreach ($report_access as $key => $value) {
				if (str_contains($value['access_key'], 'download')) {
					$data['download_access'] = true;
				}
			}

			$data['report_data'] = !empty($report_data) ? $report_data : 'No Records Found';
			$data['package_nos'] = $package_nos;
			$data['circles'] = $circles;
			
			$data['feeder_access'] = true;
		} else {
			$data['feeder_access'] = false;
		}

		$data['title'] = 'Material Inward Report';

		// echo 'data: <pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('report/material-inward-report', $data);
	}

	public function materialInwardReturnReport()
	{
		// $package_nos = $this->Report_Model->getPackageNos();
		$package_nos = $this->Report_Model->loadPackagesForMaterialReports();
		$circles = $this->Report_Model->getCircles();
		
		$data['package_nos'] = $package_nos;
		$data['package_no'] = [];
		$data['circles'] = $circles;
		$data['circle'] = [];
		$data['title'] = 'Material Inward Return Report';

		// echo 'data: <pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('report/material-inward-return-report', $data);
	}

	public function generateMaterialInwardReturnReport()
	{
		$data['package_no'] = $package_no = $this->input->post('packageNo');
		$data['circle'] = $circle = $this->input->post('circle');

		$data['material_return_date'] = $material_return_date = $this->input->post('matrerialReturnDate');
		$dates_arr = explode(' - ', $material_return_date);
		$from_date = date('Y-m-d', strtotime($dates_arr[0]));
		$to_date = date('Y-m-d', strtotime($dates_arr[1]));

		// $package_nos = $this->Report_Model->getPackageNos();
		$package_nos = $this->Report_Model->loadPackagesForMaterialReports();
		$circles = $this->Report_Model->getCircles();

		if ($this->checkLocationAccess(NULL, $package_no)) {
			$report_data = $this->Report_Model->generateMaterialInwardReturnReport($package_no, $circle, $from_date, $to_date);

			$user_role_id = $_SESSION['loggedData']->role_id;
			$report_name = 'Material Inward Return';
			$report_access = $this->Report_Model->getReportAccessData($report_name, $user_role_id);

			$data['download_access'] = false;
			foreach ($report_access as $key => $value) {
				if (str_contains($value['access_key'], 'download')) {
					$data['download_access'] = true;
				}
			}

			$data['report_data'] = !empty($report_data) ? $report_data : 'No Records Found';
			$data['package_nos'] = $package_nos;
			$data['circles'] = $circles;
			
			$data['feeder_access'] = true;
		} else {
			$data['feeder_access'] = false;
		}

		$data['title'] = 'Material Inward Return Report';

		// echo 'data: <pre>'; print_r($data); echo '</pre>'; die()
		$this->load->view('report/material-inward-return-report', $data);
	}

	public function materialOutwardReport()
	{
		// $package_nos = $this->Report_Model->getPackageNos();
		$package_nos = $this->Report_Model->loadPackagesForMaterialReports();
		$circles = $this->Report_Model->getCircles();

		$data['package_nos'] = $package_nos;
		$data['package_no'] = [];
		$data['circles'] = $circles;
		$data['circle'] = [];
		$data['title'] = 'Material Outward Report';

		// echo '<pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('report/material-outward-report', $data);
	}

	public function generateMaterialOutwardReport()
	{
		$data['package_no'] = $package_no = $this->input->post('packageNo');
		$data['circle'] = $circle = $this->input->post('circle');

		$data['material_received_date'] = $material_issue_date = $this->input->post('materialReceivedDate');
		$dates_arr = explode(' - ', $material_issue_date);
		$from_date = date('Y-m-d', strtotime($dates_arr[0]));
		$to_date = date('Y-m-d', strtotime($dates_arr[1]));

		$package_nos = $this->Report_Model->loadPackagesForMaterialReports();
		$circles = $this->Report_Model->getCircles();

		if ($this->checkLocationAccess(NULL, $package_no)) {
			$report_data = $this->Report_Model->generateMaterialOutwardReport($package_no, $circle, $from_date, $to_date);

			$user_role_id = $_SESSION['loggedData']->role_id;
			$report_name = 'Material Outward';
			$report_access = $this->Report_Model->getReportAccessData($report_name, $user_role_id);

			$data['download_access'] = false;
			foreach ($report_access as $key => $value) {
				if (str_contains($value['access_key'], 'download')) {
					$data['download_access'] = true;
				}
			}

			$data['report_data'] = !empty($report_data) ? $report_data : 'No Records Found';
			$data['package_nos'] = $package_nos;
			$data['circles'] = $circles;
			
			$data['feeder_access'] = true;
		} else {
			$data['feeder_access'] = false;
		}

		$data['title'] = 'Material Outward Report';

		// echo '<pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('report/material-outward-report', $data);
	}

	public function materialStockReport()
	{
		$package_nos = $this->Report_Model->loadPackagesForMaterialReports();
		$circles = $this->Report_Model->getCircles();

		$data['package_nos'] = $package_nos;
		$data['package_no'] = [];
		$data['circles'] = $circles;
		$data['circle'] = [];
		$data['title'] = 'Material Stock Report';

		// echo 'data: <pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('report/material-stock-report', $data);
	}

	public function generateMaterialStockReport()
	{
		$data['package_no'] = $package_no = $this->input->post('packageNo');
		$data['circle'] = $circle = $this->input->post('circle');

		$data['date_range'] = $date_range = $this->input->post('dateRange');
		$dates_arr = explode(' - ', $date_range);
		$from_date = date('Y-m-d', strtotime($dates_arr[0]));
		$to_date = date('Y-m-d', strtotime($dates_arr[1]));

		// $package_nos = $this->Report_Model->getPackageNos();
		$package_nos = $this->Report_Model->loadPackagesForMaterialReports();
		$circles = $this->Report_Model->getCircles();

		if ($this->checkLocationAccess(NULL, $package_no)) {
			$report_data = $this->Report_Model->generateMaterialStockReport($package_no, $circle, $from_date, $to_date);

			$user_role_id = $_SESSION['loggedData']->role_id;
			$report_name = 'Material Stock';
			$report_access = $this->Report_Model->getReportAccessData($report_name, $user_role_id);

			$data['download_access'] = false;
			foreach ($report_access as $key => $value) {
				if (str_contains($value['access_key'], 'download')) {
					$data['download_access'] = true;
				}
			}

			$data['report_data'] = !empty($report_data) ? $report_data : 'No Records Found';
			$data['package_nos'] = $package_nos;
			$data['circles'] = $circles;
			
			$data['feeder_access'] = true;
		}	else {
			$data['feeder_access'] = false;
		}

		$data['title'] = 'Material Stock Report';

		// echo 'data: <pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('report/material-stock-report', $data);
	}

	public function materialBalanceQuantityReport()
	{
		// $package_nos = $this->Report_Model->getPackageNos();
		$package_nos = $this->Report_Model->loadPackagesForMaterialReports();

		$data['package_nos'] = $package_nos;
		$data['package_no'] = [];
		$data['title'] = 'Material Balance Quantity Report';

		// echo 'data: <pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('report/material-balance-quantity-report', $data);
	}

	public function generateMaterialBalanceQuantityReport()
	{
		$data['package_no'] = $package_no = $this->input->post('packageNo');

		// $package_nos = $this->Report_Model->getPackageNos();
		$package_nos = $this->Report_Model->loadPackagesForMaterialReports();

		if ($this->checkLocationAccess(NULL, $package_no)) {
			$report_data = $this->Report_Model->generateMaterialBalanceQuantityReport($package_no);

			$user_role_id = $_SESSION['loggedData']->role_id;
			$report_name = 'Material Balance Quantity';
			$report_access = $this->Report_Model->getReportAccessData($report_name, $user_role_id);

			$data['download_access'] = false;
			foreach ($report_access as $key => $value) {
				if (str_contains($value['access_key'], 'download')) {
					$data['download_access'] = true;
				}
			}

			$data['report_data'] = !empty($report_data) ? $report_data : 'No Records Found';
			$data['package_nos'] = $package_nos;
			
			$data['feeder_access'] = true;
		} else {
			$data['feeder_access'] = false;
		}

		$data['title'] = 'Material Balance Quantity Report';

		// echo 'data: <pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('report/material-balance-quantity-report', $data);
	}

	public function tkcPhysicalProgressReport()
	{
		$data['packages'] = $this->Report_Model->loadPackages();
		$data['regions'] = $user_regions = $this->Report_Model->loadRegions();
		$user_circles = $this->Report_Model->loadCircles();
	  $user_divisions = $this->Report_Model->loadDivisions();

		$data['reportType'] = "";
	  $data['postpackage'] = [];
	  $data['postregion'] = "";
		$data['postcircle'] = "";
		$data['poststatus'] = "";
		$data['postfeederId'] = "";
		$data['reportData'] = array();
		$data['allRegion'] = array();
		$data['allCircle'] = array();
		$data['allDivision'] = array();
		
		$user_regions = $this->getRegionIDs($user_regions);
		$user_circles = $this->getCirlceIDs($user_circles);
		$user_divisions = $this->getDivisionIDs($user_divisions);

		/*$region_data = $this->Report_Model->getRegionData();
		$data['region_data'] = $region_data;*/

		$circle_data = $this->Report_Model->getCircleData($user_circles);
		$data['circles'] = $this->groupCircleData($circle_data);

		$division_data = $this->Report_Model->getDivisionData($user_divisions);
		$data['divisions'] = $this->groupDivisionData($division_data);
		$data['title'] = 'TKC Physical Progress Report';

		// echo '<pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('report/tkc-physical-progress-report', $data);
	}

	public function generateTKCPhysicalProgressReport()
	{
		$data['postpackage'] = $package = $this->input->post('packageNo');
		$data['postfeederId'] = $feederId = $this->input->post('feederId');

		$data['packages'] = $this->Report_Model->loadPackages();

		$data['regions'] = $user_regions = $this->Report_Model->loadRegions();
		$user_regions = $this->getRegionIDs($user_regions);

		$user_circles = $this->Report_Model->loadCircles();
		$user_circles = $this->getCirlceIDs($user_circles);
		$circle_data = $this->Report_Model->getCircleData($user_circles);
		$data['circles'] = $this->groupCircleData($circle_data);

		$user_divisions = $this->Report_Model->loadDivisions();
		$user_divisions = $this->getDivisionIDs($user_divisions);
		$division_data = $this->Report_Model->getDivisionData($user_divisions);
		$data['divisions'] = $this->groupDivisionData($division_data);

		$data['reportType'] = $reportType = $this->input->post('reportType');

		if ($this->checkLocationAccess($this->input->post('feederId'), $this->input->post('packageNo'))) {
			$data['feeder_access'] = true;

			$data['sel_region'] = (!empty($this->input->post('region'))) ? $this->input->post('region') : [];
			$data['sel_circle'] = (!empty($this->input->post('circle'))) ? $this->input->post('circle') : [];
			$data['sel_division'] = (!empty($this->input->post('division'))) ? $this->input->post('division') : [];

			$user_role_id = $_SESSION['loggedData']->role_id;
			$report_name = 'TKC Physical Progress';
			$report_access = $this->Report_Model->getReportAccessData($report_name, $user_role_id);

			$data['download_access'] = false;
			foreach ($report_access as $key => $value) {
				if (str_contains($value['access_key'], 'download')) {
					$data['download_access'] = true;
				}
			}

			if($reportType == 2)
			{
				$reportData = $this->Report_Model->generateTKCPhysicalReport();

				if (empty($reportData['result'])) {
					$data['reportData'] = 'No Records Found';
				} else {
					$data['reportData'] = $reportData;
				}
			} elseif ($reportType == 1)
			{
				$reportData = $this->Report_Model->generateTKCPhysicalReportFeederWise();

				if (empty($reportData)) {
					$data['reportData'] = 'No Records Found';
				} else {
					$myVar = $reportData[0];
					$onlyKeys = array();

					foreach($myVar as $key => $value) {
						array_push($onlyKeys, $key);
					}

					$data['onlyKeys'] = $onlyKeys;

					$mainHeadingArray = $subHeadingArray = $subSubHeadingArray = [];

					foreach($data['onlyKeys'] as $mainHeading)
					{
						if ($mainHeading == 'feeder_id' || $mainHeading == 'region_name' || $mainHeading == 'circle_name' || $mainHeading == 'division_name' || $mainHeading == 'vidhansabha' || $mainHeading == 'district' || $mainHeading == 'loksabha') {
							continue;
						}

						$explode = explode("__", $mainHeading);
						array_push($mainHeadingArray, $explode[0]);
	 					array_push($subHeadingArray, $explode[1].' ('.$explode[2].')');
	 					array_push($subSubHeadingArray, $explode[3]);
					}

					$mainHeadingArray = array_unique($mainHeadingArray);

					$header_count = [];
					foreach ($mainHeadingArray as $group_name) {
						$header_count[$group_name] = 0;
						foreach ($data['onlyKeys'] as $value) {
							$match = '/^'.$group_name.'__/';
							if (preg_match($match, $value)) {
								$header_count[$group_name]++;
							}
						}
					}

					$data['mainHeadingArray'] = $header_count;
					$data['subHeadingArray'] = $subHeadingArray;
					$data['subSubHeadingArray'] = $subSubHeadingArray;

					// Modifying reportData
					$modified_report_data = [];
					
					foreach ($reportData as $key => $value) {
						$i = 1;
						foreach ($value as $k => $val) {
							if (str_contains($k, 'boq_qty')) {
								$boq_key = 'boq_qty_'.$i;
								$modified_report_data[$value['feeder_id']][$boq_key] = $val;

								$i++;
							} elseif (str_contains($k, 'erection_qty')) {
								$erection_key = 'erection_qty_'.$i;
								$modified_report_data[$value['feeder_id']][$erection_key] = $val;

								$i++;
							} elseif (str_contains($k, 'region_name')) {
								$modified_report_data[$value['feeder_id']]['region_name'] = $val;
							} elseif (str_contains($k, 'circle_name')) {
								$modified_report_data[$value['feeder_id']]['circle_name'] = $val;
							} elseif (str_contains($k, 'division_name')) {
								$modified_report_data[$value['feeder_id']]['division_name'] = $val;
							} elseif (str_contains($k, 'vidhansabha')) {
								$modified_report_data[$value['feeder_id']]['vidhansabha'] = $val;
							} elseif (str_contains($k, 'loksabha')) {
								$modified_report_data[$value['feeder_id']]['loksabha'] = $val;
							} elseif (str_contains($k, 'district')) {
								$modified_report_data[$value['feeder_id']]['district'] = $val;
							}
						}
					}

					$data['reportData'] = $modified_report_data;
				}
			}
		} else {
			$data['feeder_access'] = false;
		}

		$data['title'] = 'TKC Physical Progress Report';

		// echo '<pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('report/tkc-physical-progress-report', $data);
	}

	public function materialDIIssuedButMaterialNotReceivedReport()
	{
		$package_nos = $this->Report_Model->getPackageNos();
		$circles = $this->Report_Model->getCircles();

		$data['package_nos'] = $package_nos;
		$data['circles'] = $circles;
		$data['title'] = 'Material DI Issued but Material not Received';

		// echo '<pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('report/material_di_issued_but_material_not_received_report', $data);
	}

	public function generateMaterialDIIssuedButMaterialNotReceivedReport()
	{
		$data['package_no'] = $package_no = $this->input->post('packageNo');
		$data['circle'] = $circle = (isset($_POST['circle'])) ? $this->input->post('circle') : 'NULL';

		$data['date_range'] = $date_range = $this->input->post('diReceivedDateRange');
		if (!empty($date_range)) {
			$dates_arr = explode(' - ', $date_range);
			$from_date = date('Y-m-d', strtotime($dates_arr[0]));
			$to_date = date('Y-m-d', strtotime($dates_arr[1]));	
		} else {
			$from_date = 'NULL';
			$to_date = 'NULL';
		}

		$package_nos = $this->Report_Model->getPackageNos();
		$circles = $this->Report_Model->getCircles();

		if ($this->checkLocationAccess(NULL, $package_no)) {
			$report_data = $this->Report_Model->generateMaterialDIIssuedButMaterialNotReceivedReport($package_no, $circle, $from_date, $to_date);

			$user_role_id = $_SESSION['loggedData']->role_id;
			$report_name = 'Material DI Issued but Material not Received';
			$report_access = $this->Report_Model->getReportAccessData($report_name, $user_role_id);

			$data['download_access'] = false;
			foreach ($report_access as $key => $value) {
				if (str_contains($value['access_key'], 'download')) {
					$data['download_access'] = true;
				}
			}

			$data['report_data'] = !empty($report_data) ? $report_data : 'No Records Found';
			$data['package_nos'] = $package_nos;
			$data['circles'] = $circles;
			
			$data['feeder_access'] = true;
		} else {
			$data['feeder_access'] = false;
		}

		$data['title'] = 'Material DI Issued but Material not Received';

		// echo '<pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('report/material_di_issued_but_material_not_received_report', $data);		
	}

	public function materialReceivedButMRADNotDoneReport()
	{
		$package_nos = $this->Report_Model->getPackageNos();
		$circles = $this->Report_Model->getCircles();

		$data['package_nos'] = $package_nos;
		$data['circles'] = $circles;
		$data['title'] = 'Material Received but MRAD not done';

		// echo '<pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('report/material_received_but_mrad_not_done_report', $data);
	}

	public function generateMaterialReceivedButMRADNotDoneReport()
	{
		// echo '<pre>'; print_r($_POST); echo '</pre>';
		$data['package_no'] = $package_no = $this->input->post('packageNo');
		$data['circle'] = $circle = (isset($_POST['circle'])) ? $this->input->post('circle') : 'NULL';

		$data['date_range'] = $date_range = $this->input->post('materialReceivedDateRange');
		if (!empty($date_range)) {
			$dates_arr = explode(' - ', $date_range);
			$from_date = date('Y-m-d', strtotime($dates_arr[0]));
			$to_date = date('Y-m-d', strtotime($dates_arr[1]));	
		} else {
			$from_date = 'NULL';
			$to_date = 'NULL';
		}

		$package_nos = $this->Report_Model->getPackageNos();
		$circles = $this->Report_Model->getCircles();

		if ($this->checkLocationAccess(NULL, $package_no)) {
			$report_data = $this->Report_Model->generateMaterialReceivedButMRADNotDoneReport($package_no, $circle, $from_date, $to_date);

			$user_role_id = $_SESSION['loggedData']->role_id;
			$report_name = 'Material DI Issued but Material not Received';
			$report_access = $this->Report_Model->getReportAccessData($report_name, $user_role_id);

			$data['download_access'] = false;
			foreach ($report_access as $key => $value) {
				if (str_contains($value['access_key'], 'download')) {
					$data['download_access'] = true;
				}
			}

			$data['report_data'] = !empty($report_data) ? $report_data : 'No Records Found';
			$data['package_nos'] = $package_nos;
			$data['circles'] = $circles;
			
			$data['feeder_access'] = true;
		} else {
			$data['feeder_access'] = false;
		}

		$data['title'] = 'Material Received but MRAD not done';

		// echo '<pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('report/material_received_but_mrad_not_done_report', $data);
	}

	public function modifyMaterialStatusList($status_list)
	{
		$modified_status_list = [];

		foreach ($status_list as $key => $value) {
			switch ($value['status_id']) {
				case '4':
					$modified_status_list[$key]['status_id'] = $value['status_id'];
					$modified_status_list[$key]['name'] = 'All';
					break;
				case '5':
					$modified_status_list[$key]['status_id'] = $value['status_id'];
					$modified_status_list[$key]['name'] = 'Pending';
					break;
				case '6':
					$modified_status_list[$key]['status_id'] = $value['status_id'];
					$modified_status_list[$key]['name'] = 'Completed';
					break;
				
				default:
					// code...
					break;
			}
		}

		return $modified_status_list;
	}
	
	public function convertPdf()
	{
		//$this->Report_Model->convertpdf();
		$this->Report_Model->generatePdf();
	}

	public function showfeeders($feederId)
	{
		$this->Report_Model->showfeeders($feederId);
	}
}

?>