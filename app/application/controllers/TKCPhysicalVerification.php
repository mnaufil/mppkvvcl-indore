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