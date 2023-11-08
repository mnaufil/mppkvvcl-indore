<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Report_Model extends CI_Model
{	
	function __construct()
	{
		parent::__construct();
		$this->load->library("Mypdf");
	}

	public function getReportAccessList()
	{
		$role_id = $_SESSION['loggedData']->role_id;
		
		$this->db->distinct();
		$this->db->select('mst_report.name');
		$this->db->from('mst_role_report_access');
		$this->db->join('mst_report_access', 'mst_role_report_access.report_access_id = mst_report_access.report_access_id', 'INNER');
		$this->db->join('mst_report', 'mst_report_access.report_id = mst_report.report_id', 'INNER');
		$this->db->where(array('mst_role_report_access.role_id' => $role_id, 'mst_role_report_access.is_active' => 1));

		$query = $this->db->get();
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();    
            echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
            die();
		} else {
			$query_result = [];

			if ($query->num_rows() > 0) {
				$result = $query->result_array();

				foreach ($result as $key => $value) {
					$query_result[$key] = $value['name'];
				}
			}

			return $query_result;
		}
	}
	
	function loadEmployees()
	{
		$this->db->where("is_active", 1);
		$query = $this->db->get("mst_user");
		$result = $query->result();
		return $result;
	}
	
	function loadPackages()
	{
		$contract_status_list = $this->getContractStatusList();
		$query = $this->db->query("SELECT DISTINCT package_no FROM contract where status_id = ".$contract_status_list['Open']);
		if($query)
		{
			$result = $query->result();
			return $result;
		}
	}

	public function getContractStatusList()
	{
		$this->db->select('mst_status.name, mst_status.status_id');
		$this->db->from('mst_status');
		$this->db->join('mst_module', 'mst_status.module_id = mst_module.module_id', 'INNER');
		$this->db->where(array('mst_module.name' => 'Contract Management'));

		$query = $this->db->get();
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$query_result = [];

			if ($query->num_rows() > 0) {
				$result = $query->result_array();

				foreach ($result as $key => $value) {
					$query_result[$value['name']] = $value['status_id'];
				}
			}

			return $query_result;
		}
	}
	
	function loadRegions()
	{
	    // $regions = implode(",",$_SESSION['myRegions']);
	    $regions = $_SESSION['myRegions'];

		$this->db->where_in("region_id", $regions);
		$this->db->where("is_active", 1);
		$query = $this->db->get("mst_region");
		// echo $this->db->last_query(); die;

		$result = $query->result();
		return $result;
	}	
	
	function loadCircles()
	{
		// $circles = implode(",",$_SESSION['myCircles']);
		$circles = $_SESSION['myCircles'];

		$this->db->where_in("circle_id", $circles);
		$this->db->where("is_active", 1);
		$query = $this->db->get("mst_circle");
		// echo $this->db->last_query(); die();

		$result = $query->result();
		return $result;
	}

	function loadDivisions()
	{
		// $divisions = implode(",",$_SESSION['myDivision']);
		$divisions = $_SESSION['myDivision'];

		$this->db->where_in("division_id", $divisions);
		$this->db->where("is_active", 1);
		$query = $this->db->get("mst_division");
		// echo $this->db->last_query(); die();

		$result = $query->result();
		return $result;
	}

	public function getRegionData()
	{
		$this->db->select('region_id, region_name');
		$query = $this->db->get_where('mst_region', array('is_active' => 1, 'deletedby' => NULL));
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$query_result = [];

			if ($query->num_rows() > 0) {
				$query_result = $query->result_array();
			}

			return $query_result;
		}
	}

	public function getCircleData($user_region_ids= NULL)
	{
		$this->db->select('mst_circle.circle_id, mst_circle.circle_name AS circle, mst_region.region_name AS region');
		$this->db->from('mst_circle');
		$this->db->join('mst_region', 'mst_circle.region_id = mst_region.region_id', 'INNER');

		if (!empty($user_region_ids)) {
			$this->db->where_in('mst_region.region_id', $user_region_ids);
		}

		$query = $this->db->get();
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$query_result = [];

			if ($query->num_rows() > 0) {
				$query_result = $query->result_array();
			}

			return $query_result;
		}
	}

	public function getDivisionData($user_circles_ids = NULL)
	{
		$this->db->select('mst_division.division_id, mst_division.division_name, mst_circle.circle_name');
		$this->db->from('mst_division');
		$this->db->join('mst_circle', 'mst_division.circle_id = mst_circle.circle_id', 'INNER');

		if (!empty($user_circles_ids)) {
			$this->db->where_in('mst_circle.circle_id', $user_circles_ids);
		}

		$query = $this->db->get();
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$query_result = [];

			if ($query->num_rows() > 0) {
				$query_result = $query->result_array();
			}

			return $query_result;
		}
	}

	public function getRegionCircleData()
	{
		$this->db->select('mst_circle.circle_id, mst_circle.circle_name, mst_region.region_id');
		$this->db->from('mst_circle');
		$this->db->join('mst_region', 'mst_circle.region_id = mst_region.region_id', 'INNER');

		$query = $this->db->get();
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$query_result = [];

			if ($query->num_rows() > 0) {
				$query_result = $query->result_array();
			}

			return $query_result;
		}
	}

	public function getSelectedRegionCircles($region)
	{
		$this->db->select('mst_circle.circle_name');
		$this->db->from('mst_circle');
		$this->db->join('mst_region', 'mst_circle.region_id = mst_region.region_id', 'INNER');
		$this->db->where(array('mst_region.region_name' => $region));

		$query = $this->db->get();
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$query_result = [];

			if ($query->num_rows() > 0) {
				$result = $query->result_array();

				foreach ($result as $key => $value) {
					$query_result[$key] = $value['circle_name'];
				}
			}

			return $query_result;
		}
	}
	
	function loadPhysicalStatus()
	{
		$this->db->order_by("seqno", "ASC");
		$this->db->where("module_id", 5);
		$query = $this->db->get("mst_status");
		$result = $query->result();
		return $result;
	}
	
	function generateVisitReport()
	{
		$physicalProgressDate = explode(" - ", $this->input->post('physicalProgressDate'));
		$physicalProgressFromDate = date('Y-m-d', strtotime($physicalProgressDate[0]));
		$physicalProgressToDate = date('Y-m-d', strtotime($physicalProgressDate[1]));
		$employee = $this->input->post('employee');		
		$sessionId = $_SESSION['userId'];	
		$package = $this->input->post('package');
		$region = $this->input->post('region');	
		$circle = 	$this->input->post('circle');
		//$status = 	$this->input->post('status');
		if(!empty($this->input->post('status')))
		{
			$status = implode(",",  $this->input->post('status'));
		}
		else 
		{
			$status = "All";
		}		
		
		$reportType = 	$this->input->post('reportType');
		
		$spEmployee = "";
		$spPackage = "";
		$spRegion = "";
		$spCircle = "";
		$spStatus = $status;
		$spReportType = $reportType;
		
		if($employee == "all")
		{
			$spEmployee = "NULL";
		}
		else if($employee == "specific")
		{
			$allEmployee = implode(",",  $this->input->post('allemployee'));
			$spEmployee ="'".$allEmployee."'";
		}
		
		if($package == "all")
		{
			$spPackage = 'NULL';
		}
		else if($package == "specific")
		{
			$allPackage = implode(",",  $this->input->post('allpackage'));
			$spPackage = "'".$allPackage."'";
		}

		if($region == "all")
		{
			$spRegion = 'NULL';
		}
		else if($region == "specific")
		{
			$allRegion = implode(",",  $this->input->post('allregion'));
			$spRegion = "'".$allRegion."'";
		}

		if($circle == "all")
		{
			$spCircle = 'NULL';
		}
		else if($circle == "specific")
		{
			$allCircle = implode(",",  $this->input->post('allcircle'));
			$spCircle = "'".$allCircle."'";
		}

		if($status == "All" || $status == "")
		{
			$spStatus = 'NULL';
		}
		else
		{
			$spStatus = implode(",",  $this->input->post('status'));
			if(count($this->input->post('status')) > 1)
			{
				$spStatus = "'".$spStatus."'";
			}
			else 
			{
				$spStatus = $spStatus;
			}
		}
		
		//echo "CALL sp_rpt_visit_report($sessionId, '$physicalProgressFromDate', '$physicalProgressToDate', $spEmployee, $spPackage, $spRegion, $spCircle,$spStatus, $spReportType)"; die;
		
		
	    $query = $this->db->query("CALL sp_rpt_visit_report($sessionId, '$physicalProgressFromDate', '$physicalProgressToDate', $spEmployee, $spPackage, $spRegion, $spCircle,$spStatus, $spReportType)");
		
		$_SESSION['spQuery'] = "CALL sp_rpt_visit_report($sessionId, '$physicalProgressFromDate', '$physicalProgressToDate', $spEmployee, $spPackage, $spRegion, $spCircle,$spStatus, $spReportType)";
		
		$result =  $query->result();

		mysqli_next_result( $this->db->conn_id);
		$query->free_result();

		return $result;
	}	
	
	function generateNcrReport()
	{
		$physicalProgressDate = explode(" - ", $this->input->post('physicalProgressDate'));
		$physicalProgressFromDate = date('Y-m-d', strtotime($physicalProgressDate[0]));
		$physicalProgressToDate = date('Y-m-d', strtotime($physicalProgressDate[1]));
		$employee = $this->input->post('employee');	

		$sessionId = $_SESSION['userId'];		
		
		$package = $this->input->post('package');
		$region = $this->input->post('region');	
		$circle = 	$this->input->post('circle');
		if(!empty($this->input->post('ncr_status')))
		{
			$status = implode(",",  $this->input->post('ncr_status'));
		}
		else 
		{
			$status = "All";
		}
		
		$reportType = $this->input->post('reportType');
		
		$spEmployee = "";
		$spPackage = "";
		$spRegion = "";
		$spCircle = "";
		$spStatus = $status;
		$spReportType = $reportType;
		
		if($employee == "all")
		{
			$spEmployee = "NULL";
		}
		else if($employee == "specific" && !empty($this->input->post('allemployee')))
		{
			$allEmployee = implode(",",  $this->input->post('allemployee'));
			$spEmployee = $allEmployee;
		}
		
		if($package == "all")
		{
			$spPackage = "NULL";
		}
		else if($package == "specific" && !empty($this->input->post('allpackage')))
		{
			$allPackage = implode(",",  $this->input->post('allpackage'));
			$spPackage = $allPackage;
		}

		if($region == "all")
		{
			$spRegion = "NULL";
		}
		else if($region == "specific" && !empty($this->input->post('allregion')))
		{
			$allRegion = implode(",",  $this->input->post('allregion'));
			$spRegion = $allRegion;
		}

		if($circle == "all")
		{
			$spCircle = "NULL";
		}
		else if($circle == "specific" && !empty($this->input->post('allcircle')))
		{
			$allCircle = implode(",",  $this->input->post('allcircle'));
			$spCircle = $allCircle;
		}

		if($status == "All" || $status == "")
		{
			$spStatus = "NULL";
		}
		else
		{
			$spStatus = implode(",", $this->input->post('ncr_status'));
			if(count($this->input->post('ncr_status')) > 1)
			{
				$spStatus = "'".$spStatus."'";
			}
			else 
			{
				$spStatus = $spStatus;
			}
		}
		
		//echo "CALL sp_rpt_ncr_data($sessionId, '$physicalProgressFromDate', '$physicalProgressToDate', $spEmployee, $spPackage, $spRegion, $spCircle, $spStatus, $spReportType)"; die;		
		
	    $query = $this->db->query("CALL sp_rpt_ncr_data($sessionId,'$physicalProgressFromDate', '$physicalProgressToDate', $spEmployee, $spPackage, $spRegion, $spCircle, $spStatus, $spReportType)");
		
		$_SESSION['spQuery'] = "CALL sp_rpt_ncr_data($sessionId,'$physicalProgressFromDate', '$physicalProgressToDate', $spEmployee, $spPackage, $spRegion, $spCircle, $spStatus, $spReportType)";
		
		if($query)
		{
			$result =  $query->result();

			mysqli_next_result( $this->db->conn_id );
			$query->free_result();

			return $result;
		}
	}
	
	function generatePhysicalReport()
	{
		$package = $this->input->post('packageNo');
		$sessionId = $_SESSION['userId'];
		$feederId = $this->input->post('feederId');
		if($feederId=="")
		{
			$feederId = 'NULL';
		}

		$spRegion = 'NULL';
		$spCircle = 'NULL';
		$spDivision = 'NULL';
		if(!empty($this->input->post('region')))
		{
			$allRegion = implode(",",  $this->input->post('region'));
			$spRegion = $allRegion;
		}
		
		if(!empty($this->input->post('circle')))
		{
			$allCircle = implode(",",  $this->input->post('circle'));
			$spCircle = $allCircle;
		}

		if(!empty($this->input->post('division')))
		{
			$allDivision = implode(",",  $this->input->post('division'));
			$spDivision = $allDivision;
		}
		
		//echo "CALL sp_rpt_physical_progress($sessionId,$package,$feederId)"; die;
		
		 //$query = $this->db->query("CALL sp_rpt_physical_progress($sessionId,$package,$feederId)");		
		 //$_SESSION['spQuery'] = "CALL sp_rpt_physical_progress($sessionId,$package,$feederId)";

		//echo "CALL sp_rpt_physical_progress_consolidatedActivityWise($sessionId,$package,'$spRegion','$spCircle','$spDivision',$feederId)"; die;
		$query = $this->db->query("CALL sp_rpt_physical_progress_consolidatedActivityWise($sessionId,$package,$spRegion,$spCircle,$spDivision,$feederId)");
		$_SESSION['spQuery'] = "CALL sp_rpt_physical_progress_consolidatedActivityWise($sessionId,$package,$spRegion,$spCircle,$spDivision,$feederId)";

		// echo $this->db->last_query(); die();
		
		if($query)
		{
			$result =  $query->result();

			mysqli_next_result( $this->db->conn_id );
			$query->free_result();

			$mainArray = array();
			$feederIdArray = array();
			$feederNameArray = array();
			$regionArray = array();
			$circleArray = array();
			$divisionArray = array();
			$awardNoArray = array();
			$contractNameArray = array();
			$dateTimeArray = array();
		
			foreach($result as $res)
			{
				$mainArray['scheme_name'] = $res->scheme_name;
				$mainArray['discom'] = $res->discom;
				if($feederId == "NULL")
				{
					/* array_Push($feederIdArray, $res->feeder_id);
					array_Push($feederNameArray, $res->feeder_name);
					array_Push($regionArray, $res->region_name);
					array_Push($circleArray, $res->circle_name);
					array_Push($divisionArray, $res->division_name);
					array_Push($awardNoArray, $res->award_no);
					array_Push($contractNameArray, $res->contractor_name);
					array_Push($dateTimeArray, $res->datetime); */
				
					array_Push($feederIdArray,"-");
					array_Push($feederNameArray, "-");
					array_Push($regionArray, "-");
					array_Push($circleArray, "-");
					array_Push($divisionArray, "-");
					array_Push($awardNoArray, "-");
					array_Push($contractNameArray, "-");
					array_Push($dateTimeArray, "-");
				}
				else
				{
					//$mainArray['feeder_id'] = $res->feeder_id;
					array_Push($feederIdArray, $res->feeder_id);
					array_Push($feederNameArray, $res->feeder_name);
					array_Push($regionArray, $res->region_name);
					array_Push($circleArray, $res->circle_name);
					array_Push($divisionArray, $res->division_name);
					array_Push($awardNoArray, $res->award_no);
					array_Push($contractNameArray, $res->contractor_name);
					array_Push($dateTimeArray, $res->datetime);
				}
			}

			$mainArray['feeder_id'] = implode(",", array_unique($feederIdArray));
			$mainArray['feeder_name'] = implode(",", array_unique($feederNameArray));
			$mainArray['region_name'] = implode(",", array_unique($regionArray));
			$mainArray['circle_name'] = implode(",", array_unique($circleArray));
			$mainArray['division_name'] = implode(",", array_unique($divisionArray));
			$mainArray['award_no'] = implode(",", array_unique($awardNoArray));
			$mainArray['contractor_name'] = implode(",", array_unique($contractNameArray));
			$mainArray['datetime'] = implode(",", array_unique($dateTimeArray));		
		
			$mainArray['result'] = $result;
			return $mainArray;
		}
	}

	function generatePhysicalReportFeederWise()
	{
		$package = $this->input->post('packageNo');
		$sessionId = $_SESSION['userId'];
		$feederId = $this->input->post('feederId');

		if($feederId == "")
		{
			$feederId = 'NULL';
		}

		$spRegion = "NULL";
		$spCircle = 'NULL';
		$spDivision = 'NULL';
		
		if(!empty($this->input->post('region')))
		{
			$allRegion = implode(",",  $this->input->post('region'));
			$spRegion = "'".$allRegion."'";
		}
		
		if(!empty($this->input->post('circle')))
		{
			$allCircle = implode(",",  $this->input->post('circle'));
			$spCircle = "'".$allCircle."'";
		}

		if(!empty($this->input->post('division')))
		{
			$allDivision = implode(",",  $this->input->post('division'));
			$spDivision = "'".$allDivision."'";
		}
		
		//echo "CALL sp_rpt_physical_progress($sessionId,$package,$feederId)"; die;
		
		 //$query = $this->db->query("CALL sp_rpt_physical_progress($sessionId,$package,$feederId)");		
		 //$_SESSION['spQuery'] = "CALL sp_rpt_physical_progress($sessionId,$package,$feederId)";

		//echo "CALL sp_rpt_physical_progress_feederWise($sessionId,$package,'$spRegion','$spCircle','$spDivision',null)"; die;

		//echo "CALL sp_rpt_physical_progress_feederWise($sessionId,$package,$spRegion,$spCircle,$spDivision,$feederId)"; die;
		$query = $this->db->query("CALL sp_rpt_physical_progress_feederWise($sessionId,$package,$spRegion,$spCircle,$spDivision,$feederId)");
		// echo $this->db->last_query(); die();
		$_SESSION['spQuery'] = "CALL sp_rpt_physical_progress_feederWise($sessionId,$package,$spRegion,$spCircle,$spDivision,$feederId)";
		
		if($query)
		{
			$result =  $query->result();
			return $result;
		}
	}	
	
	function generatePhysicalReport1()
	{
		$package = $this->input->post('packageNo');
		$sessionId = $_SESSION['userId'];
		$feederId = $this->input->post('feederId');

		if($feederId == "")
		{
			$feederId = "NULL";
		}
		
		//echo "CALL sp_rpt_physical_progres($sessionId,$package,$feederId)"; die;
	 	$_SESSION['spQuery'] = "CALL sp_rpt_physical_progres($sessionId,$package,$feederId)";

		$query1 = $this->db->query("CALL sp_rpt_physical_progres($sessionId,$package,$feederId)");		
		
		if($query1)
		{
			$result =  $query1->result();
			return $result;
		}
	}	
	
	function generateContractSummaryReport()
	{
		$outputOption = $this->input->post('outputOption');
		$sessionId = $_SESSION['userId'];
		
		//echo "CALL sp_rpt_physical_progres($sessionId,$package,$feederId)"; die;
		$_SESSION['spQuery'] = "CALL sp_rpt_contract_summary($sessionId,$outputOption)";
		$query1 = $this->db->query("CALL sp_rpt_contract_summary($sessionId,$outputOption)");		
		
		if($query1)
		{
			$result =  $query1->result();

			mysqli_next_result( $this->db->conn_id);
			$query1->free_result();

			return $result;
		}
	}	
	
	function generateBgSummaryReport()
	{
		$packageNo = $this->input->post('packageNo');
		$contractor = $this->input->post('contractor');
		$typeOfWork = $this->input->post('typeOfWork');
		
		if($packageNo == "")
		{
			$packageNo = "NULL";
		}

		if($contractor == "")
		{
			$contractor = "NULL";
		}

		if($typeOfWork == "")
		{
			$typeOfWork = "NULL";
		}
			
		$sessionId = $_SESSION['userId'];
		
		//echo "CALL sp_rpt_bg_summary($sessionId,$packageNo, $contractor, $typeOfWork)"; die;
		$_SESSION['spQuery'] = "CALL sp_rpt_bg_summary($sessionId,'$packageNo', '$contractor', $typeOfWork)";
		$query1 = $this->db->query("CALL sp_rpt_bg_summary($sessionId, '$packageNo', '$contractor', $typeOfWork)");
		// echo $this->db->last_query(); die();
		
		if($query1)
		{
			$result = $query1->result();

			mysqli_next_result( $this->db->conn_id);
			$query1->free_result();

			return $result;
		}
	}	
	
	function generateMobilisationSummaryReport()
	{
		$packageNo = $this->input->post('packageNo');
		$contractor = $this->input->post('contractor');
		$typeOfWork = $this->input->post('typeOfWork');
		
		if($packageNo == "")
		{
			$packageNo = "NULL";
		}

		if($contractor == "")
		{
			$contractor = "NULL";
		}

		if($typeOfWork == "")
		{
			$typeOfWork = "NULL";
		}
			
		$sessionId = $_SESSION['userId'];
		
		//echo "CALL sp_rpt_mobilisation_summary($sessionId,$packageNo, $contractor, $typeOfWork)"; die;
		// $_SESSION['spQuery'] = "CALL sp_rpt_mobilisation_summary($sessionId, $packageNo, $contractor, $typeOfWork)";
		$_SESSION['spQuery'] = "CALL sp_rpt_mobilisation_summary($sessionId, '$packageNo')";
		// $query1 = $this->db->query("CALL sp_rpt_mobilisation_summary($sessionId, $packageNo, '$contractor', $typeOfWork)");
		$query1 = $this->db->query("CALL sp_rpt_mobilisation_summary($sessionId, '$packageNo')");
		// echo $this->db->last_query(); die();
		
		if($query1)
		{
			$result = $query1->result();

			mysqli_next_result( $this->db->conn_id);
			$query1->free_result();

			return $result;
		}
	}

	function generateNonConformaceReport()
	{
		$package = $this->input->post('packageNo');
		$region = $this->input->post('region');
		$circle = $this->input->post('circle');
		$ncrDate = $this->input->post('ncrDate');
		$status = $this->input->post('status');

		if($status=="" || $status =="all")
		{
			$status = 'NULL';
		}

		if(!empty($ncrDate))
		{
			$explode = explode(" - ", $ncrDate);
			$startDate = date('Y-m-d', strtotime($explode[0]));
			$endDate = date('Y-m-d', strtotime($explode[1]));
		}
		else
		{
			$startDate = 'NULL';	
			$endDate = 'NULL';
		}

		$sessionId = $_SESSION['userId'];
		
		//echo "CALL sp_rpt_non_conformance_report($sessionId,'$package','$region', '$circle', NULL, '$startDate', '$endDate', $status)"; die;
		$_SESSION['spQuery'] = "CALL sp_rpt_non_conformance_report($sessionId,'$package','$region', '$circle', NULL, '$startDate', '$endDate', $status)";

		$query1 = $this->db->query("CALL sp_rpt_non_conformance_report($sessionId,'$package','$region', '$circle', NULL, '$startDate', '$endDate', $status)");		
		// echo $this->db->last_query(); die();
		
		if($query1)
		{
			$result =  $query1->result();

			mysqli_next_result( $this->db->conn_id);
			$query1->free_result();

			return $result;
		}
	}

	function generateMaterialStatusReport()
	{
		$packageNo = $this->input->post('packageNo');
		// $contractor = $this->input->post('contractor');
		$circle = $this->input->post('circle');
		
		if($packageNo == "")
		{
			$packageNo = "NULL";
		}

		/*if($contractor == "")
		{
			$contractor = "NULL";
		}*/
			
		$sessionId = $_SESSION['userId'];
		
		//echo "CALL sp_rpt_material_status_report($sessionId,$packageNo, $contractor)"; die;
		// $_SESSION['spQuery'] = "CALL sp_rpt_material_status_report($sessionId, '$packageNo', $contractor)";
		$_SESSION['spQuery'] = "CALL sp_rpt_material_status_report($sessionId, '$packageNo', $circle)";

		// $query1 = $this->db->query("CALL sp_rpt_material_status_report($sessionId, '$packageNo', $contractor)");
		$query1 = $this->db->query("CALL sp_rpt_material_status_report($sessionId, '$packageNo', $circle)");
		// echo $this->db->last_query(); die();

		if($query1)
		{
			$result =  $query1->result();

			mysqli_next_result( $this->db->conn_id);
			$query1->free_result();

			return $result;
		}
	}

	function generateMaterialStatusSummary()
	{
		$packageNo = $this->input->post('packageNo');
		$date = $this->input->post('date');		
		
		if($packageNo == "")
		{
			$packageNo = "NULL";
		}

		if($date == "")
		{
			$date = "NULL";
		}		
			
		$sessionId = $_SESSION['userId'];
		
		//echo "CALL sp_rpt_material_status_summary($sessionId,$packageNo, $date)"; die;
		$_SESSION['spQuery'] = "CALL sp_rpt_material_status_summary($sessionId,'$packageNo', $date)";
		$query1 = $this->db->query("CALL sp_rpt_material_status_summary($sessionId,'$packageNo', $date)");
		// echo $this->db->last_query(); die();
		
		if($query1)
		{
			$result =  $query1->result();

			mysqli_next_result( $this->db->conn_id);
			$query1->free_result();

			return $result;
		}
	}

	function generateCashFlowReport()
	{
		$packageNo = $this->input->post('packageNo');			
		
		if($packageNo == "")
		{
			$packageNo = "NULL";
		}
			
		$sessionId = $_SESSION['userId'];
		
		//echo "CALL sp_rpt_material_status_report($sessionId,$packageNo, $contractor)"; die;
		$_SESSION['spQuery'] = "CALL sp_rpt_cash_flow($sessionId, $packageNo)";
		$query1 = $this->db->query("CALL sp_rpt_cash_flow($sessionId, $packageNo)");		
		
		if($query1)
		{
			$result =  $query1->result();

			mysqli_next_result( $this->db->conn_id);
			$query1->free_result();

			return $result;
		}
	}

	function generateInvoicingPaymentReport()
	{
		$date = date('Y-m-d', strtotime($this->input->post('date')));			
		
		if($date == "")
		{
			$date = "NULL";
		}		
			
		$sessionId = $_SESSION['userId'];
		
		//echo "CALL sp_rpt_material_status_report($sessionId,$packageNo, $contractor)"; die;
		$_SESSION['spQuery'] = "CALL sp_rpt_updated_position_of_invoicing_and_payment($sessionId,'$date')";
		$query1 = $this->db->query("CALL sp_rpt_updated_position_of_invoicing_and_payment($sessionId,'$date')");		
		
		if($query1)
		{
			$result =  $query1->result();

			mysqli_next_result( $this->db->conn_id);
			$query1->free_result();

			return $result;
		}
	}
	

	public function convertpdf() 
	{
		$downloadfile="test.pdf"; 
 
		$html = 'You can now easily print text mixing different styles: <b>bold</b>, <i>italic</i>, <u>underlined</u>, or <b><i><u>all at once</u></i></b>!<br><br>You can also insert links on text, such as <a href="http://www.fpdf.org">www.fpdf.org</a>, or on an image: click on the logo. ';

		$pdf = new Mypdf();
		// First page
		$pdf->AddPage();
		$pdf->SetFont('Arial','',20);
		$pdf->Write(5,"To find out what's new in this tutorial, click ");
		$pdf->SetFont('','U');
		$link = $pdf->AddLink();
		$pdf->Write(5,'here',$link);
		$pdf->SetFont('');
		// Second page
		$pdf->AddPage();
		$pdf->SetLink($link);
		$pdf->Image('http://localhost/mppkvvcl/app/assets/images/brand/logo-dark.png',10,12,30,0,'','http://www.fpdf.org');
		$pdf->SetLeftMargin(45);
		$pdf->SetFontSize(14);
		$pdf->WriteHTML($html);
		$pdf->Output();
		//$pdf->Output('D', $downloadfile);
	}

	function generatePdf()
	{
		//$query1 = $this->db->query("CALL sp_rpt_non_conformance_report(60,'101','Jabalpur', 'Narsinghpur', NULL, '2023-03-01', '2023-08-31', NULL)");		
		$spQuery = $_SESSION['spQuery']; 
		$query1 = $this->db->query($spQuery);
		
		if($query1)
		{
			$reportData =  $query1->result();
			//return $result;
		}

		$pdf = new Mypdf();
		// First page
		$pdf->AddPage();
		$pdf->SetFont('Arial','',20);
		$pdf->Write(5," Non Conformance Report");
		$pdf->SetFont('','U');
		/*$link = $pdf->AddLink();
		$pdf->Write(5,'here',$link);*/
		$pdf->SetFont('');
		// Second page
		//$pdf->AddPage();
		//$pdf->SetLink($link);
		//$pdf->Image('http://localhost/mppkvvcl/app/assets/images/brand/logo-dark.png',10,12,30,0,'','http://www.fpdf.org');
		$pdf->SetFont('Arial','',20);
		$pdf->SetLeftMargin(10);
		$pdf->SetFontSize(9);
		$pdf->WriteHTML("<br>");
		$pdf->WriteHTML("<br>");
		//$pdf->WriteHTML($html);
		$header = array('Sl No');

		$i=0; 
		foreach($reportData as $report) {
		 	if($i==0) 
		 	{ 
				$pdf->Cell(95,7,'DISCOM',1);
				$pdf->Cell(95,7,'MPPKVVCL',1);
				$pdf->Ln();
				$pdf->Cell(95,7,'TKC',1);
				$pdf->Cell(95,7,$report->contractor_name,1);
				$pdf->Ln();
				$pdf->Cell(95,7,'Package No',1);
				$pdf->Cell(95,7,$report->package_no,1);
				$pdf->Ln();
				$pdf->Cell(95,7,'Region Name',1);
				$pdf->Cell(95,7,$report->region_name,1);
				$pdf->Ln();
				$pdf->Cell(95,7,'Circle Name',1);
				$pdf->Cell(95,7,$report->circle_name,1);
				$pdf->Ln();
				$pdf->Cell(95,7,'Division Name',1);
				$pdf->Cell(95,7,$report->division_name,1);
				$pdf->Ln();
				$pdf->Cell(95,7,'Feeder ID',1);
				$pdf->Cell(95,7,$report->feeder_id,1);
				$pdf->Ln();
				$pdf->Cell(95,7,'Feeder Name',1);
				$pdf->Cell(95,7,$report->feeder_name,1);
				$pdf->Ln();
				$pdf->Cell(95,7,'Substation',1);
				$pdf->Cell(95,7,$report->substation,1);
				$pdf->Ln();
				$pdf->Cell(95,7,'Standards',1);
				$pdf->Cell(95,7,$report->standards,1);
			}
			$pdf->Ln();
			$pdf->Ln();
			$pdf->Cell(95,7,'NCR ID',1);
			$pdf->Cell(95,7,$report->ncr_id,1);

			$pdf->Ln();
			$pdf->Cell(95,7,'NCR Date',1);
			$pdf->Cell(95,7,$report->ncr_date,1);

			$pdf->Ln();
			$pdf->Cell(95,7,'Inspected By',1);
			$pdf->Cell(95,7,$report->Inspected_by,1);

			$pdf->Ln();
			$pdf->Cell(95,7,'Activity',1);
			$pdf->Cell(95,7,$report->activity,1);

			$pdf->Ln();
			$pdf->Cell(95,7,'Observation Type',1);
			$pdf->Cell(95,7,$report->observation_type,1);

			$pdf->Ln();
			$pdf->Cell(95,7,'Observation',1);
			$pdf->Cell(95,7,$report->observation,1);

			$pdf->Ln();
			$explode = explode(",",$report->observation_photos ?? '');
			$count = count($explode);
				
			$pdf->Cell(190,7,'Observation Photo(s)',1);
			$pdf->Ln();
			$pdf->Ln();

			for($i=0;$i<$count;$i++) { 
				if(!empty($explode[$i])) {
					$size = getimagesize(base_url().$explode[$i]);
					$wImg = $size[0];
					$hImg = $size[1];

					//  Get PDF dimensions
					$wPdf = $pdf->A4_WIDTH;
					$hPdf = $pdf->A4_HEIGHT;

					//  Calculate width necessary for the cell
					$width  = $wPdf - $wImg;

					if( $width<0 )
					{
					    error_log('Image is larger than page we\'re trying to print on.');
					    $width = 0;
					}

					//  Convert pixel units to user units
					/*$width  /= $pdf->MM_IN_INCH;
					$height /= $pdf->MM_IN_INCH;*/

					//  Print a boundary cell
					$pdf->Cell($wImg/2,$hImg/2);

					//  Print image
					$pdf->Image(base_url().$explode[$i]);

					//  Force a new line
					$pdf->Ln();
				}

				$pdf->Ln();
			}					

			$pdf->Ln();
			$pdf->Ln();
			$pdf->Cell(190,7,'Completion Photos(s)',1);
			$pdf->Ln();
			$pdf->Ln();
			$explode1 = explode(",",$report->completion_photos ?? '');
			$count1 = count($explode1);

			for($j=0;$j<$count1;$j++) { 
				if(!empty($explode1[$j])) { 
					//$pdf->Cell(95,7,$report->completion_photos,1);
					$size = getimagesize(base_url().$explode1[$j]);
					$wImg = $size[0];
					$hImg = $size[1];

					//  Get PDF dimensions
					$wPdf = $pdf->A4_WIDTH;
					$hPdf = $pdf->A4_HEIGHT;

					//  Calculate width necessary for the cell
					$width  = $wPdf - $wImg;

					if( $width < 0)
					{
					    error_log('Image is larger than page we\'re trying to print on.');
					    $width = 0;
					}

					//  Convert pixel units to user units
					/*$width  /= $pdf->MM_IN_INCH;
					$height /= $pdf->MM_IN_INCH;*/

					//  Print a boundary cell
					$pdf->Cell($wImg/2,$hImg/2);

					//  Print image
					$pdf->Image(base_url().$explode1[$j]);

					//  Force a new line
					$pdf->Ln();
					//$pdf->Cell( $wImg, $hImg, $pdf->Image('http://localhost/mppkvvcl/app/assets/images/brand/logo-dark.png', $pdf->GetX(), $pdf->GetY(), 20), 0, 0, 'L', false );
				}

				$pdf->Ln();
			}
			
			$pdf->Ln();
			$pdf->Ln();
			$pdf->Cell(95,7,'Completion Date',1);
			$pdf->Cell(95,7,$report->completion_date,1);

			$i++;
		}

		$pdf->Output();
	}

	function showfeeders($feederId)
	{
		$this->db->select('contract_location.*,mst_region.region_name, mst_circle.circle_name, mst_division.division_name');
		$this->db->where("contract_location.is_active", 1);
			$this->db->where("contract_location.feeder_id", $feederId);
		// $this->db->or_where("mst_status.status_id", 5);		
		$this->db->from('contract_location');
		
		$this->db->join('mst_region', 'mst_region.region_id  = contract_location.region_id', 'inner');
		$this->db->join('mst_circle', 'mst_circle.circle_id  = contract_location.circle_id', 'inner');
		$this->db->join('mst_division', 'mst_division.division_id  = contract_location.division_id', 'inner');
		//$this->db->join('mst_status', 'mst_status.status_id  = physical_progress.status_id', 'inner');
		$query = $this->db->get();
		//echo $this->db->last_query(); die;
		$result = $query->result();
		$html = "";
		foreach($result as $res)
		{
			$html .= 	'<div class="feeder-class" onclick="feeder('.$res->feeder_id.')">
							<a href="javascript:void(0)" class="list-group-item list-group-item-action flex-column align-items-start ">
                        		<div class="d-flex w-100 justify-content-between"><h6 class="mb-1">Feeder ID : <strong>'.$res->feeder_id.'</strong></h6>
                                   <small class="text-muted">Region : <span class="text-primary"> '.$res->region_name.'</span></small></div>
                                    <small class="mb-1">Circle: <span class="text-primary"> '.$res->circle_name.'</span></small> 

                                    <small class="text-muted" style="float:right;">Division: <span class="text-primary">'.$res->division_name.'</span></small>
                                    <br>
                                    <small class="text-muted">Substation: <span class="text-primary">'.$res->location_name.'</span></small>
                            </a>
                        </div>';
		}

		echo $html;
	}

	public function getFeederLocationData($feeder_id)
	{
		$this->db->select('region_id, circle_id, division_id');
		$query = $this->db->get_where('contract_location', array('feeder_id' => $feeder_id, 'is_active' => 1, 'deletedby' => NULL));
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$query_result = [];

			if ($query->num_rows() > 0) {
				$query_result = $query->row_array();
			}

			return $query_result;
		}
	}

	public function getFeedersLocationDataByPackageNo($package_no)
	{
		$this->db->select('contract_location.region_id, contract_location.circle_id, contract_location.division_id');
		$this->db->from('contract_location');
		$this->db->join('contract', 'contract_location.contract_id = contract.contract_id', 'INNER');
		$this->db->where(array('contract.package_no' => $package_no));

		$query = $this->db->get();
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$query_result = [];

			if ($query->num_rows() > 0) {
				$query_result = $query->result_array();
			}

			return $query_result;
		}
	}

	public function getReportAccessData($report_name, $role_id)
	{
		$this->db->select('mst_role_report_access.*, mst_report_access.report_id, mst_report_access.access_key');
		$this->db->from('mst_role_report_access');
		$this->db->join('mst_report_access', 'mst_role_report_access.report_access_id = mst_report_access.report_access_id', 'INNER');
		$this->db->join('mst_report', 'mst_report_access.report_id = mst_report.report_id', 'INNER');
		$this->db->where(array('mst_report.name' => $report_name, 'mst_role_report_access.role_id' =>$role_id, 'mst_report_access.is_active' => 1, 'mst_report.is_active' => 1, 'mst_role_report_access.is_active' => 1));

		$query = $this->db->get();
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$query_result = [];

			if ($query->num_rows() > 0) {
				$query_result = $query->result_array();
			}

			return $query_result;
		}
	}
}

?>