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

		// echo 'data: <pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('report/reports', $data);
	}

	public function viewReport()
	{
		$data['packages'] = $this->Report_Model->loadPackages();
		$data['regions'] = $this->Report_Model->loadRegions(); 
		$data['circles'] = $this->Report_Model->loadCircles();
	  $data['divisions'] = $this->Report_Model->loadDivisions();
		$circle_data = $this->Report_Model->getCircleData();
		$data['reportType'] = "";
	  $data['postpackage'] = "";
	  $data['postregion'] = "";
		$data['postcircle'] = "";
		$data['poststatus'] = "";
		$data['postfeederId'] = "";
		$data['reportData'] = array();
		$data['allRegion'] = array();
		$data['allCircle'] = array();
		$data['allDivision'] = array();
			$circle_data = $this->Report_Model->getCircleData();
		$data['circle_data'] = $this->groupCircleData($circle_data);
		$this->load->view('report/view-report', $data);
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
		$data['circle'] = 	"";
		//$data['status'] = 	"";
		$data['reportType'] = 	"";
		$data['allEmployee'] = array();	
	    $data['allPackage'] = array();
		$data['allRegion'] = array();
		$data['allCircle'] = array();
		$data['status'] = array();
		$data['reportType'] = 	"";

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

	public function generatePhysicalReport()
	{
		$package = $this->input->post('packageNo');
		$feederId = $this->input->post('feederId');
		
		$data['postpackage'] = $package;
		$data['postfeederId'] = $feederId;
		$data['packages'] = $this->Report_Model->loadPackages();
		$data['regions'] = $this->Report_Model->loadRegions();
		$data['circles'] = $this->Report_Model->loadCircles();
	  $data['divisions'] = $this->Report_Model->loadDivisions();

	  $data['allRegion'] = array();
		$data['allCircle'] = array();
		$data['allDivision'] = array();

		$data['region'] = $this->input->post('region');
		if(!empty($this->input->post('region')))
		{
		   $data['allRegion']	 = $this->input->post('region');
		}

		$data['circle'] = 	$this->input->post('circle');
		if(!empty($this->input->post('circle')))
		{
		   $data['allCircle'] = $this->input->post('circle');
		}

		$data['division'] = 	$this->input->post('division');
		if(!empty($this->input->post('division')))
		{
		   $data['allDivision'] = $this->input->post('division');
		}
		//print_r($data['allDivision']);die;
		/*if(!empty($this->input->post('ncr_status')))
		{
			$data['ncr_status'] = 	$this->input->post('ncr_status');
		}*/
		$data['reportType'] = 	$this->input->post('reportType');
		
		$reportType = $this->input->post('reportType');
		if($reportType ==2 )
		{
			$data['reportData'] = $this->Report_Model->generatePhysicalReport();	
		}
		if($reportType ==1 )
		{
			$data['reportData'] = $this->Report_Model->generatePhysicalReportFeederWise();

		/*	echo '<pre>';
		print_r($data);  

		die;*/
		$myVar = json_encode($data['reportData'][0]);
		//print_r($myVar);
		$onlyKeys = array();
		$jsonArray = json_decode($myVar,true);
		foreach($jsonArray as $key=>$value){
    //echo $key . " => " . $value . "<br>";
			array_push($onlyKeys, $key);
			}
			$data['onlyKeys'] = $onlyKeys;

	
		
		//echo '<pre>';
		//print_r($data['reportData'][0]);
		//print_r($data['onlyKeys']);
		$mainHeadingArray = array();
		$subHeadingArray = array();
		$subSubHeadingArray = array();
		foreach($data['onlyKeys'] as $mainHeading)
		{
			  if(str_contains($mainHeading, "__"))
			  {
			  	$explode = explode("__", $mainHeading);	
 					array_push($mainHeadingArray, $explode[0]);
 					array_push($subHeadingArray, $explode[1].' ('.$explode[2].')');
 					array_push($subSubHeadingArray, $explode[3]);

			  }
			  
		}
		
	/*	print_r(array_unique($mainHeadingArray));
		print_r($subHeadingArray);
		print_r($subSubHeadingArray);
		 die;*/

		 $data['mainHeadingArray'] = array_unique($mainHeadingArray);
		 $data['subHeadingArray'] = $subHeadingArray;
		 $data['subSubHeadingArray'] = $subSubHeadingArray;

		 	}

		$this->load->view('report/view-report', $data);
	}
	
	public function generateVisitReport()
	{	
		
		$data['employees'] = $this->Report_Model->loadEmployees();
		$data['packages'] = $this->Report_Model->loadPackages();
		$data['regions'] = $this->Report_Model->loadRegions();
		$data['circles'] = $this->Report_Model->loadCircles();	
		$data['statuss'] = $this->Report_Model->loadPhysicalStatus();
		$data['reportType'] = 	$this->input->post('reportType');
		$data['reportData'] = $this->Report_Model->generateVisitReport();
		
		$data['allEmployee'] = array();	
	    $data['allPackage'] = array();
		$data['allRegion'] = array();
		$data['allCircle'] = array();
		$data['status'] = array();
		
		
		$data['physicalProgressDate'] = $this->input->post('physicalProgressDate');
		
		/*$data['employee'] = $this->input->post('employee');		
		$data['package'] = $this->input->post('package');
		$data['region'] = $this->input->post('region');	
		$data['circle'] = 	$this->input->post('circle');
		$data['status'] = 	$this->input->post('status');
		$data['reportType'] = 	$this->input->post('reportType');
		*/
		
		$data['employee'] = $this->input->post('employee');	
		if(!empty($this->input->post('allemployee')))
		{
			$data['allEmployee'] = $this->input->post('allemployee');	
		}
		$data['package'] = $this->input->post('package');
		if(!empty($this->input->post('allPackage')))
		{
			$data['allPackage'] = $this->input->post('allpackage');
		}
		$data['region'] = $this->input->post('region');
		if(!empty($this->input->post('allRegion')))
		{
		   $data['allRegion']	 = $this->input->post('allregion');
		}
		$data['circle'] = 	$this->input->post('circle');
		if(!empty($this->input->post('allCircle')))
		{
		   $data['allCircle'] = $this->input->post('allcircle');
		}
		if(!empty($this->input->post('status')))
		{
			$data['status'] = 	$this->input->post('status');
		}
		$data['reportType'] = 	$this->input->post('reportType');

		
	//	print_r($data); die;
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
		$data['reportType'] = 	$this->input->post('reportType'); ;
		$data['reportData'] = $this->Report_Model->generateNcrReport();
		
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
		if(!empty($this->input->post('allPackage')))
		{
			$data['allPackage'] = $this->input->post('allpackage');
		}
		$data['region'] = $this->input->post('region');
		if(!empty($this->input->post('allRegion')))
		{
		   $data['allRegion']	 = $this->input->post('allregion');
		}
		$data['circle'] = 	$this->input->post('circle');
		if(!empty($this->input->post('allCircle')))
		{
		   $data['allCircle'] = $this->input->post('allcircle');
		}
		if(!empty($this->input->post('ncr_status')))
		{
			$data['ncr_status'] = 	$this->input->post('ncr_status');
		}
		$data['reportType'] = 	$this->input->post('reportType');
		
		//$data['ncr_status'] = $this->input->post('ncr_status');

		//echo '<pre>';
		//print_r($data['allEmployee']); die;
		$this->load->view('report/ncr-report', $data);
	}
	
	
	public function exportExcelSp()
	{
		 $spQuery = $_SESSION['spQuery']; 
		$query = $this->db->query($spQuery);
		
			//$result =  $query->result();
		
		
		$tasks = array();
		//while( $rows =mysqli_fetch_assoc($query) ) {
		//	while( $rows =$query->result() ) {
		  //$tasks[] = $rows;
		//}
		
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
		
		$this->load->view('report/contract-summary', $data);
	}
	
	public function bgSummaryReport()
	{
		$data['packageNo'] = ""; 
		$data['contractor'] ="";
		$data['typeOfWork'] ="";
		
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
		$data['reportData'] = $this->Report_Model->generateBgSummaryReport();		
		
		$this->load->view('report/bg-report', $data);
	}
	
	public function showtkcs($tkcs)
	{
		
	}
	public function mobilisationSummaryReport()
	{
		$data['packageNo'] = ""; 
		$data['contractor'] ="";
		$data['typeOfWork'] ="";
		
		$data['packages'] = $this->Report_Model->loadPackages();
		$data['worktypes'] = $this->Setup_Model->loadworktypes();
	    $data['postpackage'] = "";
		$data['postfeederId'] = "";
		$data['reportData'] = array();
		/* echo '<pre>';
		print_r($data); die; */
		$this->load->view('report/mobilisation-summary-report', $data);
	}
	
	
	public function generateMobilisationSummaryReport()
	{
		
		$data['packageNo'] = $this->input->post('packageNo'); 
		$data['contractor'] = $this->input->post('contractor');
		$data['typeOfWork'] = $this->input->post('typeOfWork');
		
		$data['packages'] = $this->Report_Model->loadPackages();
		$data['worktypes'] = $this->Setup_Model->loadworktypes();
		$data['reportData'] = $this->Report_Model->generateMobilisationSummaryReport();		
		
		$this->load->view('report/mobilisation-summary-report', $data);
	}



	public function nonConformanceReport()
	{
		$data['packageNo'] = ""; 
		$data['contractor'] ="";
		$data['typeOfWork'] ="";
		
		$data['packages'] = $this->Report_Model->loadPackages();
		$data['worktypes'] = $this->Setup_Model->loadworktypes();
		$data['regions'] = $this->Report_Model->loadRegions();
		$data['circles'] = $this->Report_Model->loadCircles();

		$circle_data = $this->Report_Model->getCircleData();
		$data['circle_data'] = $this->groupCircleData($circle_data);

	  $data['postpackage'] = "";
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
			$circles[$value['region']][] = $value['circle'];
		}

		return $circles;
	}



	public function generateNonConformaceReport()
	{		
		$data['packages'] = $this->Report_Model->loadPackages();
		$data['regions'] = $this->Report_Model->loadRegions();
		$data['circles'] = $this->Report_Model->loadCircles();

		$data['selected_region_circle_data'] = $this->Report_Model->getSelectedRegionCircles($this->input->post('region'));
		$circle_data = $this->Report_Model->getCircleData();
		$data['circle_data'] = $this->groupCircleData($circle_data);
		
		$data['reportData'] = $this->Report_Model->generateNonConformaceReport();
		
		
	   $data['postpackage'] = $this->input->post('packageNo');
		$data['postregion'] = $this->input->post('region');
		$data['postcircle'] = $this->input->post('circle');

		$data['postncrDate'] = $this->input->post('ncrDate');
		$data['poststatus'] = $this->input->post('status');

		// echo '<pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('report/non-conformance-report', $data);
	}



	public function materialStatusReport()
	{
		$data['packages'] = $this->Report_Model->loadPackages();
		$data['circles'] = $this->Report_Model->loadCircles();	

		$data['packageNo'] = ""; 
		$data['contractor'] = "";

		$this->load->view('report/material-status-report', $data);
	}


	public function generateMaterialStatusReport()
	{
			$data['packages'] = $this->Report_Model->loadPackages();
			//$data['circles'] = $this->Report_Model->loadCircles();	

			$data['reportData'] = $this->Report_Model->generateMaterialStatusReport();

			$data['packageNo'] = $this->input->post('packageNo'); 
			$data['contractor'] = $this->input->post('contractor');

			
			$this->load->view('report/material-status-report', $data);


	}






	public function materialStatusSummary()
	{
		$data['packages'] = $this->Report_Model->loadPackages();
		//$data['circles'] = $this->Report_Model->loadCircles();	

		$data['packageNo'] = ""; 
		//$data['contractor'] = "";

		$this->load->view('report/material-status-summary', $data);
	}


	public function generateMaterialStatusSummary()
	{
			$data['packages'] = $this->Report_Model->loadPackages();
			//$data['circles'] = $this->Report_Model->loadCircles();	

			$data['reportData'] = $this->Report_Model->generateMaterialStatusSummary();

			$data['packageNo'] = $this->input->post('packageNo'); 
			//$data['contractor'] = $this->input->post('contractor');

			
			$this->load->view('report/material-status-summary', $data);


	}




	public function cashFlowReport()
	{
		$data['packages'] = $this->Report_Model->loadPackages();
		//$data['circles'] = $this->Report_Model->loadCircles();	

		$data['packageNo'] = ""; 
		//$data['contractor'] = "";


		$this->load->view('report/cash-flow-report', $data);
	}



	public function generateCashFlowReport()
	{
			$data['packages'] = $this->Report_Model->loadPackages();
			//$data['circles'] = $this->Report_Model->loadCircles();	

			$data['reportData'] = $this->Report_Model->generateCashFlowReport();

			$data['packageNo'] = $this->input->post('packageNo'); 
			//$data['contractor'] = $this->input->post('contractor');
				// echo '<pre>';
				// print_r($data['reportData']); DIE;
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
			
			$data['reportData'] = $this->Report_Model->generateInvoicingPaymentReport();

			$data['date'] = $this->input->post('date'); 
			//$data['contractor'] = $this->input->post('contractor');
				/* echo '<pre>';
				 print_r($data['reportData']); DIE;*/
		$this->load->view('report/invoicing-payment-report', $data);
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