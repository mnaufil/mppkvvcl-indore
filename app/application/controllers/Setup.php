<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Setup extends CI_Controller
{	
	function __construct()
    {
		parent::__construct();

    	$this->load->library('form_validation'); 
    	$this->load->model('Setup_Model');
    
    	if(!$this->session->isUserLoggedIn)
    	{ 
         	redirect('login'); 
    	}
	}
	
	public function loadMilestones($rowIndex)
	{
		$result = $this->Setup_Model->loadMilestones($rowIndex);
	}
	
	public function loadRegions($rowIndex)
	{
		 $result = $this->Setup_Model->loadRegions($rowIndex);		 
	}
	
	public function loadCircle($regionId, $rowIndex)
	{
		 $result = $this->Setup_Model->loadCircle($regionId, $rowIndex);		 
	}
	
	public function loadDivision($circleId, $rowIndex)
	{
		$result = $this->Setup_Model->loadDivision($circleId, $rowIndex);		 
	}

	public function loadSessionCircle($regionId)
	{
		 $result = $this->Setup_Model->loadSessionCircle($regionId);		 
	}

	public function loadSessionDivision($regionId)
	{
		 $result = $this->Setup_Model->loadSessionDivision($regionId);		 
	}
		
		

	public function contractmanagement()
	{
		$data['access_key']  = $this->uri->segment(1);
		$data['status_list'] = $this->Setup_Model->getContractStatusList();
		$result = $this->Setup_Model->contractlist();
		$data['contractlist'] = $result['contractlist'];

		if (isset($result['filters'])) {
			$data['filters'] = $result['filters'];			
		}

		if(isset($_GET['tenderAwardDate']))
		{
			$data['posttenderAwardDate'] = $_GET['tenderAwardDate'];	
		}
		
		// echo '<pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('setup/contract/contract-management', $data);
	}

	public function addcontractpage()
	{
		$data['worktypes'] = $this->Setup_Model->loadworktypes();	
		$_SESSION['sessionName'] = array();
		$_SESSION['acceptstage'] = array();
		$_SESSION['acceptregion'] = array();
		$_SESSION['acceptmaterial'] = array();
		$_SESSION['acceptmobilisation'] = array();
		$_SESSION['acceptbank'] = array();
		$_SESSION['boq_worktype'] = false;
		$_SESSION['contract_location_boq'] = array();
		$this->load->view('setup/contract/add-contract', $data); 
	}

	public function addcontract()
	{
		try
	 	{	
			$this->form_validation->set_rules('nameOfContractor', 'Name of Contractor', 'required'); 
			$this->form_validation->set_rules('tenderAwardNo', 'Tender Award No', 'required'); 
			$this->form_validation->set_rules('tenderAwardDate', 'Tender Award Date', 'required'); 
			$this->form_validation->set_rules('packageNo', 'Package No', 'required'); 
			$this->form_validation->set_rules('typeOfWork', 'Type of Work', 'required'); 
			$this->form_validation->set_rules('effectiveDate', 'Effective Date', 'required'); 
			$this->form_validation->set_rules('completionDate', 'Completion Date', 'required');
			$this->form_validation->set_rules('eTenderNo', 'E-Tender No', 'required');
			$this->form_validation->set_rules('bidOpeningDate', 'Bid Opening Date', 'required');
			$this->form_validation->set_rules('priceBidOpeningDate', 'Price Bid Opening Date', 'required');
			$this->form_validation->set_rules('systemRefNo', 'System Reference No', 'required');

			$this->form_validation->set_rules('estimatedCostWithoutGST', 'Estimated Cost (Without GST)', 'required');
			$this->form_validation->set_rules('estimatedCostWithGST', 'Estimated Cost (With GST)', 'required');
			$this->form_validation->set_rules('quotedPriceWithoutGST', 'Quoted Price(Without GST)', 'required');
			$this->form_validation->set_rules('quotedPriceWithGST', 'Quoted Price (With GST)', 'required');
			$this->form_validation->set_rules('supplyOfGoods', 'Supply of Goods', 'required');
			$this->form_validation->set_rules('installationServices', 'Installation and Other Services ', 'required');
			$this->form_validation->set_rules('quantity', 'Quantity', 'required');
			$this->form_validation->set_rules('gst', 'GST', 'required');

			//print_r($_POST); die;

			if($this->form_validation->run())
			{
				$return = $this->Setup_Model->addcontract();
				if($return)
				{
					$this->session->set_flashdata('success','Contract Added Successfully');
					//redirect('contract-management/add');
					redirect('contract-management');
				}
			}
			else 
			{
				//print_r(validation_errors());
				//die("fdhfjdfh");
					$this->session->set_flashdata('error',validation_errors());
					redirect('contract-management/add');
					//redirect('contract-management');
			}
		}
		catch (Exception $e)
		{
        		log_message('error: ',$e->getMessage());
        		//return;
		}
	}


	public function editcontractpage($contractID)	
	{
		$data['contractdetails'] =  $this->Setup_Model->loadSingleContract($contractID);
		$data['contractmilestonesdetails'] = $this->Setup_Model->loadSingleContractMilestones($contractID);		
		
		$data['contractregionsdetails'] = $this->Setup_Model->loadSingleContractRegions($contractID);
		$data['contractinstallationsdetails'] = $this->Setup_Model->loadSingleContractInstallations($contractID);	
		$data['contractbanksdetails'] = $this->Setup_Model->loadSingleContractBanks($contractID);	 	   
		$data['worktypes'] = $this->Setup_Model->loadworktypes();	
		$data['materialdetails'] = $this->Setup_Model->loadMaterials($contractID);

		// echo '<pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('setup/contract/edit-contract', $data); 
	}

	
	public function viewcontractpage($contractID)	
	{
		$data['contractdetails'] =  $this->Setup_Model->loadSingleContract($contractID);	
		$data['contractmilestonesdetails'] = $this->Setup_Model->loadSingleContractMilestones($contractID);
		
		$data['contractregionsdetails'] = $this->Setup_Model->loadSingleContractRegions($contractID);	
		$data['contractinstallationsdetails'] = $this->Setup_Model->loadSingleContractInstallations($contractID);	
		$data['contractbanksdetails'] = $this->Setup_Model->loadSingleContractBanks($contractID);	 	   
		$data['worktypes'] = $this->Setup_Model->loadworktypes();	
		$data['materialdetails'] = $this->Setup_Model->loadMaterials($contractID);

		/*echo '<pre>';
		print_r($data); die;*/
		$this->load->view('setup/contract/view-contract', $data); 
	}



	public function updatecontract()
	{
		try
	 	{	
			$this->form_validation->set_rules('nameOfContractor', 'Name of Contractor', 'required'); 
			$this->form_validation->set_rules('tenderAwardNo', 'Tender Award No', 'required'); 
			$this->form_validation->set_rules('tenderAwardDate', 'Tender Award Date', 'required'); 
			$this->form_validation->set_rules('packageNo', 'Package No', 'required'); 
			$this->form_validation->set_rules('typeOfWork', 'Type of Work', 'required'); 
			$this->form_validation->set_rules('effectiveDate', 'Effective Date', 'required'); 
			$this->form_validation->set_rules('completionDate', 'Completion Date', 'required');
			$this->form_validation->set_rules('eTenderNo', 'E-Tender No', 'required');
			$this->form_validation->set_rules('bidOpeningDate', 'Bid Opening Date', 'required');
			$this->form_validation->set_rules('priceBidOpeningDate', 'Price Bid Opening Date', 'required');
			$this->form_validation->set_rules('systemRefNo', 'System Reference No', 'required');
			$this->form_validation->set_rules('estimatedCostWithoutGST', 'Estimated Cost (Without GST)', 'required');
			$this->form_validation->set_rules('estimatedCostWithGST', 'Estimated Cost (With GST)', 'required');
			$this->form_validation->set_rules('quotedPriceWithoutGST', 'Quoted Price(Without GST)', 'required');
			$this->form_validation->set_rules('quotedPriceWithGST', 'Quoted Price (With GST)', 'required');
			$this->form_validation->set_rules('supplyOfGoods', 'Supply of Goods', 'required');
			$this->form_validation->set_rules('installationServices', 'Installation and Other Services ', 'required');
			$this->form_validation->set_rules('quantity', 'Quantity', 'required');
			$this->form_validation->set_rules('gst', 'GST', 'required');

			$contractId = $this->input->post('contractID');
			if($this->form_validation->run())
			{
				$return = $this->Setup_Model->updatecontract();
				foreach($return as $key=>$val)
				{
					if($val!==false)
					{
						$this->session->set_flashdata('success','Contract Updated Successfully');
					}
					else
					{
						$this->session->set_flashdata('error','Problem in updating Contract data.');
					}
				}
			}
			else 
			{
				$this->session->set_flashdata('error',validation_errors());

			}
			
			redirect('contract-management');
		}
		catch (Exception $e)
		{
        	log_message('error: ',$e->getMessage());
		}
	}


	public function deletecontract($contractID)
	{
		 echo $result = $this->Setup_Model->deletecontract($contractID);		 
	}


	public function worktype()
	{
		$this->load->view('setup/work-type/work-type');
	}

	public function addtypeofwork()
	{
		$this->load->view('setup/work-type/add-typeofwork');
	}

	public function edittypeofwork()
	{
		$this->load->view('setup/work-type/edit-typeofwork');
	}

	public function savetypeofwork()
	{
		echo "Save typeOfWork";
	}

	public function worktypeactivities()
	{
		$this->load->view('setup/activities/work-type-activities');
	}

	public function addactivity()
	{
		$this->load->view('setup/activities/add-activity');
	}

	public function checkquotedpricewithgst()
	{
		$this->Setup_Model->checkquotedpricewithgst();	
	}
	
	public function checkquantity()
	{
		$this->Setup_Model->checkquantity();	
	}

	public function loadUnits($rowIndex)
	{
		$result = $this->Setup_Model->loadUnits($rowIndex);
	}

	public function loadMobilisationType($rowIndex)
	{
		$result = $this->Setup_Model->loadMobilisationType($rowIndex);
	}
	
	public function checkquotedpricewithoutgst()
	{
		$this->Setup_Model->checkquotedpricewithoutgst();	
	}

	public function loadbanktypes($rowIndex)
	{
		$result = $this->Setup_Model->loadbanktypes($rowIndex);
	}

	public function typeofworkboq($workId)
	{
		$result = $this->Setup_Model->typeofworkboq($workId);	
	}

	public function checktypeofworkboq()
	{
		$result = $this->Setup_Model->checktypeofworkboq();	
	}

	public function saveboq()
	{
		$result = $this->Setup_Model->saveboq();	
	}

	public function saveboqedit()
	{
		$result = $this->Setup_Model->saveboqedit();	
	}


	public function typeofworkboqedit($workId)
	{
		$result = $this->Setup_Model->typeofworkboqedit($workId);	
	}


	public function checkcontractstagecount()
	{
		$this->Setup_Model->checkcontractstagecount();	
	}

	public function checkrowboq($rowIndex, $workId)
	{
		$this->Setup_Model->checkrowboq($rowIndex, $workId);	
	}


	public function checkdatelessthan($inputField, $rowIndex, $dateField)
	{
		$this->Setup_Model->checkdatelessthan($inputField, $rowIndex, $dateField);	
	}
	
}