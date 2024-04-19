<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

require APPPATH.'libraries/PhpXlsxGenerator.php';
class Dashboard extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        //$this->load->library('form_validation'); 
        $this->load->model('Dashboard_Model');
        $this->load->model('Setup_Model');
        if(!$this->session->isUserLoggedIn)
        { 
            redirect('login'); 
        }
    }

    public function index($mileStoneId =null)
    {
		if($mileStoneId==null)
        {
           $mileStoneId = 1;
        } 
		$data['statistics'] = $this->Dashboard_Model->statistics($mileStoneId);
        
		$rolesData = $this->session->rolesData;
		$menusData = $this->session->menusData;
        $totalData = $this->session->totalData;
	   
		// $data['menus'] = $rolesData;

        // echo '<pre>'; print_r($data); echo '</pre>'; die();
        $this->load->view('dashboard/dashboard', $data); 
    }

    // public function showgraph($packageNo) /*Original Code*/
    public function showgraph($packageNo, $stage_id)
    {
        // echo $this->Dashboard_Model->showgraph($packageNo); /*Original Code*/
        echo $this->Dashboard_Model->showgraph($packageNo, $stage_id);
    }
    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login'); 
    }

    public function pertchart()
    {
        $this->load->view('dashboard/pert-chart'); 
    }


    public function statstable($mileStoneId =null)
    {
        $rolesData = $this->session->rolesData;
        $menusData = $this->session->menusData;
        //echo '<pre>';
        //print_r($rolesData); die;
        // $data['menus'] = $rolesData;
         if($mileStoneId==null)
        {
           $mileStoneId = 1;
        } 

         $data['statistics'] = $this->Dashboard_Model->statistics($mileStoneId);

        $this->load->view('dashboard/dashboard-table', $data); 
    }

   
    public function physicalachievement($mileStoneId =null)
    {
        $data['regions'] = $this->Dashboard_Model->loadRegions();
        if($mileStoneId == null)
        {
           $mileStoneId = date('Y-m-d');
        }
        else
        {
            $mileStoneId = $mileStoneId;
        }

        $previousMonth = date('M y', strtotime($mileStoneId. '-1 month'));
        $actualMonth = date('M y', strtotime($mileStoneId));

        $data['stages'] = $this->Dashboard_Model->loadStagesDash();
        $data['physicals'] = $this->Dashboard_Model->physicalprogress($mileStoneId);
        $data['previousMonth'] = $previousMonth;
        $data['actualMonth'] = $actualMonth;
        $data['milestoneid'] = $mileStoneId;

        $this->load->view('dashboard/physical-achievement', $data); 
    }

    public function financialachievement($date = NULL)
    {
        if ($date == NULL) {
            $data['date'] = $date = date('Y-m-d');
            
            $data['current_date'] = date('d.m.y');
            $data['current_month'] = date("M'y");
        } else {
            $data['date'] = $date;

            $data['current_date'] = date('d.m.y', strtotime($date));
            $data['current_month'] = date("M'y", strtotime($date));
        }

        $result = $this->Dashboard_Model->getFinancialDashboardData($date);

        foreach ($result as $key => $value) {
            $result[$key]['contract_price'] = $this->convertToCrore($value['contract_price']);
            $result[$key]['target'] = $this->convertToCrore($value['target']);
            $result[$key]['supply_invoice_raised'] = $this->convertToCrore($value['supply_invoice_raised']);
            $result[$key]['supply_amount_disbursed'] = $this->convertToCrore($value['supply_amount_disbursed']);
            $result[$key]['supply_cum_invoice_raised'] = $this->convertToCrore($value['supply_cum_invoice_raised']);
            $result[$key]['supply_cum_amount_disbursed'] = $this->convertToCrore($value['supply_cum_amount_disbursed']);
            $result[$key]['erection_cum_invoice_raised'] = $this->convertToCrore($value['erection_cum_invoice_raised']);
            $result[$key]['erection_cum_amount_disbursed'] = $this->convertToCrore($value['erection_cum_amount_disbursed']);
            $result[$key]['mobilisation_advance'] = $this->convertToCrore($value['mobilisation_advance']);
            $result[$key]['payment_of_taxes'] = $this->convertToCrore($value['payment_of_taxes']);
            $result[$key]['total_disbursement_amount'] = $this->convertToCrore($value['total_disbursement_amount']);
        }

        $data['contract_data'] = $result;
        
        // echo 'data: <pre>'; print_r($data); echo '</pre>'; die();
        $this->load->view('dashboard/financial-achievement', $data);
    }

    public function convertToCrore($amount)
    {
        if ($amount == '-' || $amount == '') {
            return '-';
        }

        $ext = ""; //thousand, lac, crore
        $number_of_digits = $this->countDigit($amount); //this is call :)

        if ($number_of_digits > 3) {
            /*if ($number_of_digits % 2 != 0) {
                $divider = $this->divider($number_of_digits - 1);
            } else {
                $divider = $this->divider($number_of_digits);
            }*/

            $divider = 10000000;
        } else {
            $divider = 1;
        }

        $fraction = $amount / $divider;
        $fraction = number_format($fraction, 2);

        /*if ($number_of_digits == 4 || $number_of_digits == 5) {
            $ext="k";
        }

        if ($number_of_digits == 6 || $number_of_digits == 7) {
            $ext="Lac";
        }

        if ($number_of_digits == 8 || $number_of_digits == 9) {
            $ext="Cr";
        }*/

        return $fraction." ".$ext;;
    }

    public function countDigit($amount)
    {
        // echo 'amount: <pre>'; print_r($amount); echo '</pre>';
        $amt_arr = explode('.', $amount);
        $amt_without_decimal = $amt_arr[0];

        return strlen($amt_without_decimal);
    }

    public function divider($number_of_digits)
    {
        /*$tens = "1";

        if ($number_of_digits > 8) {
            return 10000000;
        }

        while (($number_of_digits - 1) > 0) {
            $tens .= "0";
            $number_of_digits--;
        }

        return $tens;*/

        return 10000000;
    }

    public function physicalVerification($date = NULL)
    {
        if ($date == NULL) {
            $data['date'] = $date = date('Y-m-d');
        } else {
            $data['date'] = $date;
        }

        $data['verification_data'] = $this->Dashboard_Model->getPhysicalVerificationData($date);

        // echo 'data: <pre>'; print_r($data); echo '</pre>'; die();
        $this->load->view('dashboard/physical-verification', $data);
    }

    public function getFeedersList()
    {
        if (!empty($_POST)) {
            $slab = $this->input->post('slab');
            $contract_id = $this->input->post('contract_id');
            $package_no = $this->input->post('package_no');
            $date = $this->input->post('date');

            $response['sel_region'] = $region = (!empty($this->input->post('region_id'))) ? $this->input->post('region_id') : 'NULL';
            $response['sel_circle'] = $circle = (!empty($this->input->post('circle_id'))) ? $this->input->post('circle_id') : 'NULL';
            $response['sel_division'] = $division = (!empty($this->input->post('division_id'))) ? $this->input->post('division_id') : 'NULL';

            $response['regions'] = $this->Dashboard_Model->getRegionList();

            $circles_data = $this->Dashboard_Model->getCircleList();
            $response['circles'] = $this->modifyRegionCircleData($circles_data);

            $division_data = $this->Dashboard_Model->getDivisionList();
            $response['divisions'] = $this->modifyCircleDivisionData($division_data);

            $feeders_data = $this->Dashboard_Model->getFeedersList($slab, $contract_id, $package_no, $date, $region, $circle, $division);
            $response['feeders_data'] = $feeders_data;
            http_response_code(200);
        } else {
            http_response_code(400);
            $response['message'] = 'No Input Provided';
        }

        echo json_encode($response);
    }

    public function modifyRegionCircleData($circles_data)
    {
        $modified_circle_data = [];

        foreach ($circles_data as $key => $value) {
            $modified_circle_data[$value['region_name']][$value['circle_id']] = $value['circle_name'];
        }

        return $modified_circle_data;
    }

    public function modifyCircleDivisionData($division_data)
    {
        $modified_division_data = [];

        foreach ($division_data as $key => $value) {
            $modified_division_data[$value['circle_name']][$value['division_id']] = $value['division_name'];
        }

        return $modified_division_data;
    }
	
	public function getlocations($packageNo)
	{
		$this->Dashboard_Model->getlocations($packageNo);
	}

    public function getcircles($regionId)
    {
        $this->Dashboard_Model->getcircles($regionId);
    }

    public function getdivisions($circleId)
    {
        $this->Dashboard_Model->getdivisions($circleId);
    }

    public function getlocationsfilter($packageNo, $regionId, $circleId, $divisionId)
    {
        $this->Dashboard_Model->getlocationsfilter($packageNo, $regionId, $circleId, $divisionId);
    }

	
	// public function statisticspopup($packageNo, $contractId) //Original
    public function statisticspopup($packageNo, $stage)
    {
		// $this->Dashboard_Model->statisticspopup($packageNo, $contractId); //Original
        $this->Dashboard_Model->statisticspopup($packageNo, $stage);
    }


    // public function changeweekmonthval($datevalue, $packageNo, $contract_id, $stage) /*Original Code*/
    public function changeweekmonthval($datevalue, $packageNo, $stage)
    {
        // $this->Dashboard_Model->changeweekmonthval($datevalue, $packageNo, $contract_id, $stage); /*Original Code*/
        $this->Dashboard_Model->changeweekmonthval($datevalue, $packageNo, $stage);
    }


      public function getweekdate($packageNo, $stage)
    {
        $this->Dashboard_Model->getweekdate($packageNo, $stage);
    }

    public function formhtmltable()
    {
        $this->Dashboard_Model->formhtmltable();
    }

    // public function weekdatedropdownload($contractId, $stage) /*Original Code*/
    public function weekdatedropdownload($packageNo, $stage)
    {
        // $this->Dashboard_Model->weekdatedropdownload($contractId, $stage); /*Original Code*/
        $this->Dashboard_Model->weekdatedropdownload($packageNo, $stage);
    }

    public function exportPhysicalVerificationData()
    {
        // Excel file name for download 
        $fileName = "Physical_verification_Dashboard_Feeders_Data_".date('Y-m-d').".xlsx";

        // $excel_data = [];
        $excel_data[] = array('REGION', 'CIRCLE', 'DIVISION', 'SITE LOCATION', 'FEEDER ID', 'TASK', 'OBSERVATION', 'LAST REPORTED BY', 'LAST REPORTED DATE', 'STATUS');

        // Fetch records from database and store in an array
        $session_query = $_SESSION['pvdashboard_query'];
        $result = $this->Dashboard_Model->executeQuery($session_query);

        if (!empty($result)) {
            foreach ($result as $key => $value) {
                $location_data = $this->splitLocation($value['region_circle_division']);

                $temp_data = array($location_data['region'], $location_data['circle'], $location_data['division'], $value['site_location'], $value['feeder_id'], $value['task'], $value['observation'], $value['username'], $value['reported_date'], $value['name']);

                array_push($excel_data, $temp_data);
            }
        }

        // Export data to excel and download as xlsx file
        $xlsx = CodexWorld\PhpXlsxGenerator::fromArray($excel_data);
        $xlsx->downloadAs($fileName);

        exit;
    }

    public function splitLocation($location)
    {
        $location_arr = explode('/', $location);

        $location_data['region'] = $location_arr[0];
        $location_data['circle'] = $location_arr[1];
        $location_data['division'] = $location_arr[2];

        return $location_data;
    }
}