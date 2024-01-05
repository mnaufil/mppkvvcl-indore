<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

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

    public function showgraph($packageNo)
    {
        echo $this->Dashboard_Model->showgraph($packageNo);
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
        if($mileStoneId==null)
        {
           $mileStoneId = date('Y-m-d');
        }
        else
        {
            $mileStoneId = $mileStoneId;
        }

         $previousMonth = date('M y', strtotime($mileStoneId. '-1 month'));
         $actualMonth = date('M y', strtotime($mileStoneId));
        //echo $mileStoneId; die;

        $data['stages'] = $this->Dashboard_Model->loadStagesDash();
        $data['physicals'] = $this->Dashboard_Model->physicalprogress($mileStoneId);
        $data['previousMonth'] = $previousMonth;
        $data['actualMonth'] = $actualMonth;
       /* echo '<pre>';
        print_r($data); die;*/
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

	
	 public function statisticspopup($packageNo, $contractId)
    {
		$this->Dashboard_Model->statisticspopup($packageNo, $contractId);
    }


    public function changeweekmonthval($datevalue, $packageNo, $contract_id, $stage)
    {
        $this->Dashboard_Model->changeweekmonthval($datevalue, $packageNo, $contract_id, $stage);
    }


      public function getweekdate($packageNo, $stage)
    {
        $this->Dashboard_Model->getweekdate($packageNo, $stage);
    }

    public function formhtmltable()
    {
        $this->Dashboard_Model->formhtmltable();
    }

    public function weekdatedropdownload($contractId, $stage)
    {
        $this->Dashboard_Model->weekdatedropdownload($contractId, $stage);
    }
}