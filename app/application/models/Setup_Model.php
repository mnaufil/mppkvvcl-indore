<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Setup_Model extends CI_Model
{
	function __construct()
    {
        parent::__construct();
        $this->load->model('SetupInner_Model');

    }
	
	function loadworktypes()
	{
		//$this->db->where("is_active", "1");
		$query = $this->db->get("mst_typeofwork");
		$result = $query->result();
		return $result;
	}
	
	
	function loadMilestones($rowIndex)
	{
		$stages = "";
		if(isset($_SESSION['acceptstage']))
           {
           		foreach($_SESSION['acceptstage'] as $stage)
                {
                    if($rowIndex == $stage['rowId'])
                    {
                          $stages = $stage['stage'];
                    }
                }
           }
		$this->db->where("is_active", "1");
		$query = $this->db->get("mst_stage");
		$result = $query->result();
		//return $result;
		$select = '<select id="dynamicstages'.$rowIndex.'" class="form-control stages" onchange="stagechange(this.value)"><option value="">Select Stages</option>';
		foreach($result as $res)
		{
			 if($res->stage_id == $stages && !empty( $stages))
			 {
			 	 $select .= '<option value='.$res->stage_id.' selected>'.$res->name.'</option>';
			 }
			 else
			 {
			 	 $select .= '<option value='.$res->stage_id.'>'.$res->name.'</option>';
			 }
			// $select .= '<option value='.$res->stage_id.'>'.$res->name.'</option>';
		}
		echo $select .= '</select>';
	}
	
	function loadRegions($rowIndex)
	{
		
		$this->db->where("is_active", "1");
		$query = $this->db->get("mst_region");
		$result = $query->result();
		//return $result;
		$select = '<select class="form-control" onchange="selectcircle(this.value, '.$rowIndex.')"  id="dynamicregion'.$rowIndex.'"><option value="Select">Select Region</option>';
		$selected = "";
		foreach($result as $res)
		{
			if(isset($_SESSION['acceptregion']) && count($_SESSION['acceptregion']) > 0 && isset($_SESSION['acceptregion'][$rowIndex]))
			{
				if($_SESSION['acceptregion'][$rowIndex]['region']==$res->region_id)
				{
					$selected="selected";
				}
				else
				{
					$selected="";
				}

				 
			}
			$select .= '<option value='.$res->region_id.' '.$selected.'>'.$res->region_name.'</option>';
			
		}
		echo $select .= '</select>';
	}
	
	function loadCircle($regionId, $rowIndex)
	{
		$this->db->where("region_id", $regionId);	
		$this->db->where("is_active", "1");
		$query = $this->db->get("mst_circle");
		$result = $query->result();
		//return $result;
		$select = '<select class="form-control" onchange="selectdivision(this.value, '.$rowIndex.')" id="dynamiccircleregion'.$rowIndex.'"><option value="Select">Select Circle</option>';
		foreach($result as $res)
		{
			 $select .= '<option value='.$res->circle_id.'>'.$res->circle_name.'</option>';
		}
		echo $select .= '</select>';
	}
	
	
	
	function loadDivision($circleId, $rowIndex)
	{
		$this->db->where("circle_id", $circleId);	
		$this->db->where("is_active", "1");
		$query = $this->db->get("mst_division");
		$result = $query->result();
		//return $result;
		$select = '<select class="form-control"><option value="Select" id="dynamicdivisionregion'.$rowIndex.'">Select Division</option>';
		foreach($result as $res)
		{
			 $select .= '<option value='.$res->division_id.'>'.$res->division_name.'</option>';
		}
		echo $select .= '</select>';
	}


	function loadSessionCircle($circleId)
	{
		$select = '<div id="loadcircles"><select class="form-control" ><option value="Select">Select Circle</option>';

		if(isset($_SESSION['acceptregion']) && count($_SESSION['acceptregion']) > 0 && isset($_SESSION['acceptregion'][$circleId]))
			{
				$selected = "selected";

				 $select .= '<option value='.$_SESSION['acceptregion'][$circleId]['circle'].' '.$selected.'>'.$_SESSION['acceptregion'][$circleId]['circle_text'].'</option>';
			}

			echo $select .= '</select></div>';
			
	}

	function loadSessionDivision($circleId)
	{
		$select = '<div id="loaddivisions"><select class="form-control" ><option value="Select">Select Divisions</option>';

		if(isset($_SESSION['acceptregion']) && count($_SESSION['acceptregion']) > 0 && isset($_SESSION['acceptregion'][$circleId]))
			{
				$selected = "selected";

				 $select .= '<option value='.$_SESSION['acceptregion'][$circleId]['division'].' '.$selected.'>'.$_SESSION['acceptregion'][$circleId]['division_text'].'</option>';
			}

			echo $select .= '</select></div>';
			
	}

    function addcontract()
    {
    	$contract_status_list = $this->getContractStatusList();

		$contract_status = [];
		foreach ($contract_status_list as $key => $value) {
			$contract_status[$value['name']] = $value['status_id'];
		}

		$returnArray = array();
    	$insertArray = array(

    		"contractor_name" => $this->input->post('nameOfContractor'),
    		"contractor_email" => $this->input->post('contractEmail'),
    		"tender_award_no" => $this->input->post('tenderAwardNo'),
    		"tender_award_date" => date ('Y-m-d', strtotime($this->input->post('tenderAwardDate'))),
    		"package_no" => $this->input->post('packageNo'),
    		"typeofwork_id" => $this->input->post('typeOfWork'),
    		"effective_date" => date ('Y-m-d',strtotime($this->input->post('effectiveDate'))),
    		"completion_date" => date ('Y-m-d',strtotime($this->input->post('completionDate'))),
    		"etender_no" => $this->input->post('eTenderNo'),
    		"bid_opening_date" => date ('Y-m-d',strtotime($this->input->post('bidOpeningDate'))),
    		"price_bid_opening_date" => date ('Y-m-d',strtotime($this->input->post('priceBidOpeningDate'))),
    		"system_ref_no" => $this->input->post('systemRefNo'),
    		"estimated_cost_without_gst" => $this->input->post('estimatedCostWithoutGST'),
    		"estimated_cost_with_gst" => $this->input->post('estimatedCostWithGST'),
    		"quoted_price_without_gst" => $this->input->post('quotedPriceWithoutGST'),
    		"quoted_price_with_gst" => $this->input->post('quotedPriceWithGST'),
    		"supply_of_goods" => $this->input->post('supplyOfGoods'),
    		"installation_other_services" => $this->input->post('installationServices'),
    		"quantity" => $this->input->post('quantity'),
    		"GST" => $this->input->post('gst'),
    		"createdby" => $_SESSION['loggedData']->user_id,
    		"createddate" => date ('Y-m-d H:i:s'),
    		"status_id" => $contract_status['Open']
    	);

        $this->db->insert("contract", $insertArray);
		
        $last_id = $this->db->insert_id(); 
        //$last_id = 3;
        //code to insert milestones

        if($last_id == 0 )
        {
			$error = $this->db->error();
        	$this->session->set_flashdata('error',$error['message']);
			redirect('contract-management/add');
			return;
        }
       
        if(isset($_SESSION['acceptstage']))
        {
            $mileStonesReturn = $this->SetupInner_Model->insertMilestones($last_id, "insert");
                    
            if($mileStonesReturn)
            {
                $returnArray['returnMilestones'] = true;
            }
			else
			{
				$returnArray['returnMilestones'] = false;
			}
        }
	
         if(isset($_SESSION['acceptregion']))
        {
            $regionsReturn = $this->SetupInner_Model->insertRegions($last_id, "insert");
            
            if($regionsReturn)
            {
                $returnArray['returnregions'] = true;
            }
			else
			{
				$returnArray['returnregions'] = false;
			}
        }

        if(isset($_SESSION['acceptmaterial']))
        {
            $installationsReturn = $this->SetupInner_Model->insertMaterial($last_id, "insert");
            
            if($installationsReturn)
            {
                $returnArray['returninstallations'] = true;
            }
			else
			{
				$returnArray['returninstallations'] = false;
			}
        }

         if(isset($_SESSION['acceptmobilisation']))
        {
            $mobilisationReturn = $this->SetupInner_Model->insertMobilisation($last_id, "insert");
            
            if($mobilisationReturn)
            {
                $returnArray['returnmobilisation'] = true;
            }
			else
			{
				$returnArray['returnmobilisation'] = false;
			}
        }

       if(isset($_SESSION['acceptbank']))
        {
            $banksRetrun = $this->SetupInner_Model->insertBanks($last_id, "insert");
            
            if($banksRetrun)
            {
                $returnArray['returnbank'] = true;
            }
			else
			{
				$returnArray['returnbank'] = false;
			}
        }

        
        	return $returnArray;
    }


	function contractlist()
	{
		$result = [];

		$contractor = isset($_GET['contractor']) ? $_GET['contractor'] : '';
		$tenderAwardNo = isset($_GET['tenderAwardNo']) ? $_GET['tenderAwardNo'] : '';
		$tenderAwardDate = isset($_GET['tenderAwardDate']) ? $_GET['tenderAwardDate'] : '';
		$status = isset($_GET['status']) ? $_GET['status'] : '';

		if (!empty($status)) {
			$status_values = [];
			$result['filters']['status']['label'] = 'Status';
			foreach ($status as $key => $value) {
				array_push($status_values, $this->getUserStatus($value));
			}
			$result['filters']['status']['value'] = implode(', ', $status_values);
            $result['filters']['status']['id'] = $status;

			$this->db->where_in("contract.status_id", $status);
		} else {
			$status_list = $this->getContractStatusList();
			$status_list_arr = [];
			foreach ($status_list as $key => $value) {
				$status_list_arr[$value['name']] = $value['status_id'];
			}			

			$this->db->order_by("contract.createddate", 'DESC');
			$this->db->where("contract.status_id", $status_list_arr['Open']);	
		}

		if (!empty($contractor)) {
			$result['filters']['contractor']['label'] = 'Contractor (TKC)';
            $result['filters']['contractor']['value'] = $contractor;

			$this->db->like("contract.contractor_name", $contractor);
		}

		if (!empty($tenderAwardNo)) {
			$result['filters']['tenderAwardNo']['label'] = 'Contract No.';
            $result['filters']['tenderAwardNo']['value'] = $tenderAwardNo;

			$this->db->where("contract.tender_award_no", $tenderAwardNo);
		}

		if (!empty($tenderAwardDate)) {
			$result['filters']['tenderAwardDate']['label'] = 'Tender Award Date';
            $result['filters']['tenderAwardDate']['value'] = $tenderAwardDate;

			$tenderAwardDate = date('Y-m-d', strtotime($tenderAwardDate));
			$this->db->where("contract.tender_award_date", $tenderAwardDate);
		}
		
		$this->db->select('contract.*,mst_typeofwork.name, mst_status.name as status_name');
		//$this->db->where("contract.contract_id", $contractID);			
		$this->db->from('contract');
		$this->db->join('mst_typeofwork', 'mst_typeofwork.typeofwork_id  = contract.typeofwork_id', 'inner');
		$this->db->join('mst_status', 'mst_status.status_id  = contract.status_id', 'inner');
		$query = $this->db->get();
	    // echo $this->db->last_query(); die;
		$result['contractlist'] = $query->result();
		//print_r($result); die;
		return $result;
	}

	public function getUserStatus($status_id)
	{
		$this->db->select('name');
		$query = $this->db->get_where('mst_status', array('status_id' => $status_id));
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();    
            echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
            die();
		} else {
			$query_result = '';

			if ($query->num_rows() > 0) {
				$result = $query->row_array();
				$query_result = $result['name'];

				mysqli_next_result($this->db->conn_id);
                $query->free_result();
			}

			return $query_result;
		}
	}

	public function getContractStatusList()
	{
		$this->db->select('mst_status.status_id, mst_status.name');
		$this->db->from('mst_status');
		$this->db->join('mst_module', 'mst_status.module_id = mst_module.module_id', 'INNER');
		$this->db->where(array('mst_module.name' => 'Contract Management'));
		$this->db->order_by('mst_status.seqno', 'ASC');

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

				mysqli_next_result($this->db->conn_id);
                $query->free_result();
			}

			return $query_result;
		}
	}
	
	
	function loadSingleContract($contractID)
	{
		$this->db->where("contract_id", $contractID);
		$query = $this->db->get("contract");
		$result = $query->row();
		return $result;
	}
	
	function loadSingleContractMilestones($contractID)
	{
		$this->db->where("contract_stage.is_active", 1);			
		$this->db->select('contract_stage.*,mst_stage.name');
		$this->db->where("contract_stage.contract_id", $contractID);			
		$this->db->from('contract_stage');
		$this->db->join('mst_stage', 'mst_stage.stage_id  = contract_stage.stage_id', 'inner');
		$query = $this->db->get();
		//echo $this->db->last_query(); die;
		$result = $query->result();
     	//creating session

		$_SESSION['acceptstage'] = array();
		$i=0;
		foreach($result as $postData)
		{
			$stageData = array(
					  'databaseId' => 	$postData->contract_stage_id,
                      'rowId'  => $i,
                      'stage'     => $postData->stage_id,
                      'stage_text'     => $postData->name,
                      'date' => date('d-m-Y', strtotime($postData->date)),
                      'quantity' => $postData->quantity,
                      'amount' => $postData->amount
                );
			 $_SESSION['acceptstage'][$i] = $stageData;
			 $i++;
		}

		//return $result;
		return $_SESSION['acceptstage'];
	}
	
	function loadSingleContractRegions($contractID)
	{
		/*$this->db->where("contract_id", $contractID);
		$query = $this->db->get("contract_location");
		$result = $query->result();
		return $result;*/

		$this->db->select('contract_location.*,mst_region.region_name, mst_circle.circle_name, mst_division.division_name');
		$this->db->where("contract_location.contract_id", $contractID);			
		$this->db->from('contract_location');
		$this->db->join('mst_region', 'mst_region.region_id  = contract_location.region_id', 'inner');
		$this->db->join('mst_circle', 'mst_circle.circle_id  = contract_location.circle_id', 'inner');
		$this->db->join('mst_division', 'mst_division.division_id  = contract_location.division_id', 'inner');
		$query = $this->db->get();
		//echo $this->db->last_query(); die;
		$result = $query->result();

		$_SESSION['acceptregion'] = array();
		$i=0;
		foreach($result as $postData)
		{
			$regionData = array(
					  'databaseId' => 	$postData->contract_location_id,
                      'rowId'  => $i,
                      'region'     => $postData->region_id,
                      'region_text'     => $postData->region_name,
                      'circle' => $postData->circle_id,
                      'circle_text' => $postData->circle_name,
                      'division' => $postData->division_id,
                      'division_text' => $postData->division_name,
                      'district' => $postData->district,
                      'vidhansabha' => $postData->vidhansabha,
                      'loksabha' => $postData->loksabha,
                      'location' => $postData->location_name,
                      'feedername' => $postData->feeder_name,
                      'feederid' => $postData->feeder_id,
                      'projectid' => $postData->project_id,
                      'geocode' => $postData->geo_code,
                      'quantity' => $postData->quantity,
                      'boq' => ""
                );
			 $_SESSION['acceptregion'][$i] = $regionData;
			 
			 $i++;
			  
		}

		$this->loadSetSessionBoqDetails($contractID, $i);

		//return $result;
		return $_SESSION['acceptregion'];

	}
	
	function loadSingleContractInstallations($contractID)
	{
		/*$this->db->where("contract_id", $contractID);
		$query = $this->db->get("contract_material");
		$result = $query->result();
		return $result;*/

		$package_group_no = $this->getPackageGroupNo($contractID);

		$this->db->select('contract_material.*,mst_unit.name');
		// $this->db->where("contract_material.contract_id", $contractID);			
		$this->db->where("contract_material.package_group_no", $package_group_no['package_group_no']);			
		$this->db->from('contract_material');
		$this->db->join('mst_unit', 'mst_unit.unit_id  = contract_material.unit_id', 'inner');
		$query = $this->db->get();
		// echo $this->db->last_query(); die();

		$result = $query->result();
     	//creating session

		$_SESSION['acceptmaterial'] = array();

		$i=0;
		foreach($result as $postData)
		{
			$materialData = array(
					  'databaseId' => 	$postData->contract_material_id,	 
                      'rowId'  => $i,
                      'sr_no'     => $postData->item_code,
                      'equipment_material_name'     => $postData->equipment_material_name,
                      'unit_id' => $postData->unit_id,
                      'unit_text' => $postData->name,
                      'total_quantity' => $postData->quantity
                );
			 $_SESSION['acceptmaterial'][$i] = $materialData;
			 $i++;
		}

		//return $result;
		return $_SESSION['acceptmaterial'];
	}
	
	function loadSingleContractBanks($contractID)
	{
		/*$this->db->where("contract_id", $contractID);
		$query = $this->db->get("contract_bg");
		$result = $query->result();
		return $result;*/


		$this->db->select('contract_bg.*,mst_bg_type.name');
		$this->db->where("contract_bg.is_active", 1);
		$this->db->where("contract_bg.contract_id", $contractID);			
		$this->db->from('contract_bg');
		$this->db->join('mst_bg_type', 'mst_bg_type.bg_type_id  = contract_bg.bg_type_id', 'inner');
		$query = $this->db->get();
		$result = $query->result();
     	//creating session

		$_SESSION['acceptbank'] = array();
		$i=0;
		foreach($result as $postData)
		{
			$bankData = array(
				      'databaseId' => 	$postData->contract_bg_id,	
                      'rowId'  => $i,
                      //'sr_no'     => $postData->sr_no,
                      'bank_id'     => $postData->bg_type_id,
                      'bank_text' => $postData->name,
                      'bg_no' => $postData->bg_number,
                      'bg_date' => date('d-m-Y', strtotime($postData->bg_date)), 
                      'bg_amount' => $postData->bg_amount,
                      'bank' => $postData->bg_bank,
                      'bg_till_date' => date('d-m-Y', strtotime($postData->bg_valid_till))
                );
			 $_SESSION['acceptbank'][$i] = $bankData;
			 $i++;
		}

		//return $result;
		return $_SESSION['acceptbank'];

	}


	function loadMaterials($contractID)
	{
		/*$this->db->where("contract_id", $contractID);
		$query = $this->db->get("contract_mobilisation");
		$result = $query->result();
		return $result;*/

		$this->db->where("contract_mobilisation.is_active", 1);			
		$this->db->select('contract_mobilisation.*,mst_mobilisation_type.name');
		$this->db->where("contract_mobilisation.contract_id", $contractID);			
		$this->db->from('contract_mobilisation');
		$this->db->join('mst_mobilisation_type', 'mst_mobilisation_type.mobilisation_type_id  = contract_mobilisation.mobilisation_type_id', 'inner');
		$query = $this->db->get();
		$result = $query->result();
     	//creating session

		$_SESSION['acceptmobilisation'] = array();
		$i=0;
		foreach($result as $postData)
		{
			$mobilisationData = array(
					  'databaseId' => 	$postData->contract_mobilisation_id,		
                      'rowId'  => $i,
                      //'sr_no'     => $postData->sr_no,
                      'mobilisation_type'     => $postData->mobilisation_type_id,
                      'mobilisation_text' => $postData->name,
                      'invoice_no' => $postData->invoice_no,
                      'invoice_date' => date('d-m-Y', strtotime($postData->invoice_date)), 
                      'advance_amount' => $postData->advance_amount,
                      'date_of_payment' => date('d-m-Y', strtotime($postData->date_of_payment)), 
                      'advance_adjusted' => $postData->advance_adjusted
                );
			 $_SESSION['acceptmobilisation'][$i] = $mobilisationData;
			 $i++;
		}

		//return $result;
		return $_SESSION['acceptmobilisation'];


	}
	
	
	
	
	function updatecontract()
    {
		$returnArray = array();
		$contractId = $this->input->post('contractID');

		$contract_status_list = $this->getContractStatusList();

		$contract_status = [];
		foreach ($contract_status_list as $key => $value) {
			$contract_status[$value['name']] = $value['status_id'];
		}

    	$insertArray = array(
    		"contractor_name" => $this->input->post('nameOfContractor'),
    		"contractor_email" => $this->input->post('contractEmail'),
    		"tender_award_no" => $this->input->post('tenderAwardNo'),
    		"tender_award_date" => date ('Y-m-d', strtotime($this->input->post('tenderAwardDate'))),
    		"package_no" => $this->input->post('packageNo'),
    		"typeofwork_id" => $this->input->post('typeOfWork'),
    		"effective_date" => date ('Y-m-d',strtotime($this->input->post('effectiveDate'))),
    		"completion_date" => date ('Y-m-d',strtotime($this->input->post('completionDate'))),
    		"etender_no" => $this->input->post('eTenderNo'),
    		"bid_opening_date" => date ('Y-m-d',strtotime($this->input->post('bidOpeningDate'))),
    		"price_bid_opening_date" => date ('Y-m-d',strtotime($this->input->post('priceBidOpeningDate'))),
    		"system_ref_no" => $this->input->post('systemRefNo'),
    		"estimated_cost_without_gst" => $this->input->post('estimatedCostWithoutGST'),
    		"estimated_cost_with_gst" => $this->input->post('estimatedCostWithGST'),
    		"quoted_price_without_gst" => $this->input->post('quotedPriceWithoutGST'),
    		"quoted_price_with_gst" => $this->input->post('quotedPriceWithGST'),
    		"supply_of_goods" => $this->input->post('supplyOfGoods'),
    		"installation_other_services" => $this->input->post('installationServices'),
    		"quantity" => $this->input->post('quantity'),
    		"GST" => $this->input->post('gst'),
    		"modifiedby" => $_SESSION['loggedData']->user_id,
    		"modifieddate" => date ('Y-m-d H:i:s'),
    		"status_id" => $contract_status['Open']
    	);

		$this->db->where("contract_id", $contractId);
        $query = $this->db->update("contract", $insertArray);

        if(!$query)
        {
        	$this->session->set_flashdata('error','Error in Updating Contract');
			redirect('contract-management');
			return;
        }

        $last_id = $contractId; 
        //$last_id = 3;
        //code to insert milestones
       	//$mileStones = $this->input->post('milestonehiddentable');

        if(isset($_SESSION['acceptstage']))
        {
            $mileStonesReturn = $this->SetupInner_Model->updateMilestones($last_id, "update");
                    
            if($mileStonesReturn)
            {
                $returnArray['returnMilestones'] = true;
            }
			else
			{
				$returnArray['returnMilestones'] = false;
			}
        }
	
        //$regions = $this->input->post('regionhiddentable');
        if(isset($_SESSION['acceptregion']))
        {
            $regionsReturn = $this->SetupInner_Model->updateRegions($last_id, "update");
            
            if($regionsReturn)
            {
                $returnArray['returnregions'] = true;
            }
			else
			{
				$returnArray['returnregions'] = false;
			}
        }

       	// $installations = $this->input->post('installationhiddentable');
        if(isset($_SESSION['acceptmaterial']))
        {
            $installationsReturn = $this->SetupInner_Model->updateMaterial($last_id, "update");
            
            if($installationsReturn)
            {
                $returnArray['returninstallations'] = true;
            }
			else
			{
				$returnArray['returninstallations'] = false;
			}
        }

        if(isset($_SESSION['acceptmobilisation']))
        {
            $mobilisationReturn = $this->SetupInner_Model->updateMobilisation($last_id, "update");
            
            if($mobilisationReturn)
            {
                $returnArray['returnmobilisation'] = true;
            }
			else
			{
				$returnArray['returnmobilisation'] = false;
			}
        }

        //$banks = $this->input->post('bankhiddentable');
       	if(isset($_SESSION['acceptbank']))
        {
            $banksRetrun = $this->SetupInner_Model->updateBanks($last_id, "update");
            
            if($banksRetrun)
            {
                $returnArray['returnbank'] = true;
            }
			else
			{
				$returnArray['returnbank'] = false;
			}
        }

        if (isset($_SESSION['contract_location_boq'])) {
        	$contractLocationBOQReturn = $this->SetupInner_Model->updateContractLocationBOQ($last_id, 'update');
        }
        
        return $returnArray;
    }
	
	
	function deletecontract($contractID)
	{
		$deleteArray = array(
			"status_id"=>2,
			"deletedby" => $_SESSION['loggedData']->user_id,
    		"deleteddate" => date ('Y-m-d H:i:s')
		);
		$this->db->where("contract_id", $contractID);
		$query = $this->db->update("contract", $deleteArray);
		if($query)
		{
			return true;
		}
		else 
		{
			return false;
		}
		//return $result;
	}


	function checkquotedpricewithgst()
	{
		$amount = array();
		foreach($_SESSION['acceptstage'] as $stage)
                {
                    
                    array_push($amount, $stage['amount']);

                }
                 echo array_sum($amount);
	}

	function checkquotedpricewithoutgst()
	{
		$amount = array();
		foreach($_SESSION['acceptmobilisation'] as $mobilisation)
                {
                    
                    array_push($amount, $mobilisation['amount']);

                }
                 echo array_sum($amount);
	}


	function checkquantity()
	{
		$quantity = array();
		foreach($_SESSION['acceptstage'] as $stage)
                {
                    
                    array_push($quantity, $stage['quantity']);

                }
                 echo array_sum($quantity);
	}


	function loadUnits($rowIndex)
	{
		$units = "";
		if(isset($_SESSION['acceptmaterial']))
           {
           		foreach($_SESSION['acceptmaterial'] as $unit)
                {
                    if($rowIndex == $unit['rowId'])
                    {
                         $units = $unit['unit_id'];
                    }
                }
           }
		$this->db->where("is_active", "1");
		$query = $this->db->get("mst_unit");
		$result = $query->result();
		//return $result;
		$select = '<select class="form-control stages"><option value="">Select Units</option>';
		foreach($result as $res)
		{
			 if($res->unit_id == $units && !empty( $units))
			 {
			 	 $select .= '<option value='.$res->unit_id.' selected>'.$res->name.'</option>';
			 }
			 else
			 {
			 	 $select .= '<option value='.$res->unit_id.'>'.$res->name.'</option>';
			 }
			// $select .= '<option value='.$res->stage_id.'>'.$res->name.'</option>';
		}
		echo $select .= '</select>';
	}

	function loadMobilisationType($rowIndex)
	{
		$mobilisation = "";
		if(isset($_SESSION['acceptmobilisation']))
           {
           		foreach($_SESSION['acceptmobilisation'] as $mobilisation)
                {
                    if($rowIndex == $mobilisation['rowId'])
                    {
                         $mobilisation = $mobilisation['mobilisation_type'];
                    }
                }
           }
		$this->db->where("is_active", "1");
		$query = $this->db->get("mst_mobilisation_type");
		$result = $query->result();
		//return $result;
		$select = '<select class="form-control stages" ><option value="">Select Mobilisation Type</option>';
		foreach($result as $res)
		{
			 if($res->mobilisation_type_id == $mobilisation && !empty( $mobilisation))
			 {
			 	 $select .= '<option value='.$res->mobilisation_type_id.' selected>'.$res->name.'</option>';
			 }
			 else
			 {
			 	 $select .= '<option value='.$res->mobilisation_type_id.'>'.$res->name.'</option>';
			 }
			// $select .= '<option value='.$res->stage_id.'>'.$res->name.'</option>';
		}
		echo $select .= '</select>';
	}

	function loadbanktypes($rowIndex)
	{
		$banks = "";
		if(isset($_SESSION['acceptbank']))
       	{
       		foreach($_SESSION['acceptbank'] as $bank)
            {
                if($rowIndex == $bank['rowId'])
                {
                    $banks = $bank['bank_id'];
                }
            }
       	}

		$this->db->where("is_active", "1");
		$query = $this->db->get("mst_bg_type");
		$result = $query->result();

		$select = '<select class="form-control stages" ><option value="">Select Bank Type</option>';
		foreach($result as $res)
		{
			if($res->bg_type_id == $banks && !empty( $banks))
			{
				$select .= '<option value='.$res->bg_type_id.' selected>'.$res->name.'</option>';
			}
			else
			{
			 	$select .= '<option value='.$res->bg_type_id.'>'.$res->name.'</option>';
			}
			
			// $select .= '<option value='.$res->stage_id.'>'.$res->name.'</option>';
		}
		echo $select .= '</select>';
	}
	
   	function typeofworkboq($workId)
   	{
   		$this->db->where("mst_activity_group.is_boq", 1);
   		$this->db->where("mst_typeofwork_activity.typeofwork_id", $workId);	
   		$this->db->select('mst_typeofwork_activity.*,mst_activity_group.name,mst_activity_group.is_boq, mst_unit.name as unitName, mst_unit.unit_id');   		
		$this->db->from('mst_typeofwork_activity');
		$this->db->join('mst_activity_group', 'mst_activity_group.activity_group_id  = mst_typeofwork_activity.activity_group_id', 'inner');
		$this->db->join('mst_unit', 'mst_unit.unit_id  = mst_typeofwork_activity.unit_id', 'inner');
		$query = $this->db->get();
		$result = $query->result();
		//echo $this->db->last_query();

		$html = '';				
		if(empty($result))
		{
			$_SESSION['boq_worktype'] = false;
		}
		else
		{
			$_SESSION['boq_worktype'] = true;
		}

		$typeOdActivityGroups = $this->typeofworkboqgroup($workId);		

		$html = '<div class="tab-menu-heading tab-menu-heading-boxed">
            		<div class="tabs-menu-boxed">
            			<ul class="nav panel-tabs" role="tablist">';
            				$j=1;
            				foreach($typeOdActivityGroups as $activityGroup)
            				{
            					if($j==1)
            					{
            						$classname = "active";
        						}
            					else
            					{
            						$classname = "";
        						}
            					$html .='<li>
            								<a href="#tab'.$activityGroup->activity_group_id.'" class="'.$classname.'" data-bs-toggle="tab" aria-selected="true" role="tab" >'.$activityGroup->name.'</a>
            							 </li>';
            					$j++;
        					}

            				$html .='</ul>
            		</div>
            	 </div>
            	 <div class="panel-body tabs-menu-body">
            		<div class="tab-content" style="height: 300px;overflow-y: scroll;">';
            			$i=1;
            			foreach($typeOdActivityGroups as $activityGroup1)
            			{
            				if($i==1)
            				{
            					$classname = "active show";
        					}
            				else
        					{
            					$classname = "";
        					}

            				$html .= '<div class="tab-pane '.$classname.' " id="tab'.$activityGroup1->activity_group_id.'" role="tabpanel">
            							<div class="table-responsive">
											<table class="table border table-bordered text-nowrap text-md-nowrap table-sm mb-0">
												<thead>
													<tr>
														<th>Sr No.</th>
														<th>Name of Activity</th>
														<th style="width: 10px;">Unit</th>
														<th>BOQ</th>
													</tr>
												</thead>
												<tbody>';
													$k=1;
													foreach($result as $res)
            										{
            											if($activityGroup1->activity_group_id == $res->activity_group_id) { 
															$html .= '<tr>
																		<td>'.$k.'</td>
																		<td>'.$res->activity.'</td>
																		<td>'.$res->unitName.'</td>
																		<td>
																			<input class="form-control" type="hidden" name="unitid'.$res->typeofwork_activity_id.'" value="'.$res->unit_id.'">
																			<input class="form-control" type="hidden" name="typeofwork_activity_id[]" value="'.$res->typeofwork_activity_id.'">
																			<input class="form-control addinputsboq" type="text" name="boq'.$res->typeofwork_activity_id.'" placeholder="Enter Value" >
																		</td>
																	 </tr>';
														}
														$k++;
													}
															
													$html .= '</tbody>
											</table>
										</div>
        							 </div>';            								
						}

            			$html .= '</div>
            	 </div>';

        echo $html;
   	}

   	function checktypeofworkboq()
   	{
   		if($_SESSION['boq_worktype']==1)
   		{
   			echo true;
   		}
   		else
   		{
   			echo false;
   		}
   	}

   	function typeofworkboqgroup($workId)
   	{
   		$this->db->group_by("mst_activity_group.name");
   		$this->db->where("mst_activity_group.is_boq", 1);
   		$this->db->where("mst_typeofwork_activity.typeofwork_id", $workId);	
   		$this->db->select('mst_typeofwork_activity.*,mst_activity_group.name,mst_activity_group.is_boq');   		
		$this->db->from('mst_typeofwork_activity');
		$this->db->join('mst_activity_group', 'mst_activity_group.activity_group_id  = mst_typeofwork_activity.activity_group_id', 'inner');
		$query = $this->db->get();
		$result = $query->result();
		return $result;
   	}

   	function saveboq()
	{
		$rowIndex = $this->input->post('rowid');
		$activityids = $this->input->post('typeofwork_activity_id');
		$contract_location_boq  = array();
		$boq = array();

		foreach($activityids as $id)
		{
			$typeofwork_activity_id = $id;
			$unit_id = $this->input->post('unitid'.$id);
			$boq_value = $this->input->post('boq'.$id);
			$boq['typeofwork_activity_id'] = $typeofwork_activity_id;
			$boq['unit_id'] = $unit_id;
			$boq['boq_value'] = $boq_value;
			$boq['rowid'] = $rowIndex;
			$contract_location_boq[$typeofwork_activity_id] = $boq;
		}

		$_SESSION['contract_location_boq'][$rowIndex] = $contract_location_boq;
		return true;
	}

	function saveboqedit()
	{
		$rowIndex = $this->input->post('rowid');
		$row_feeder_id = $this->input->post('feeder_id');
		$activityids = $this->input->post('typeofwork_activity_id');
		$contract_location_boq  = array();
		$boq = array();

		foreach($activityids as $id)
		{
			$typeofwork_activity_id = $id;
			$unit_id = $this->input->post('unitid'.$id);
			$boq_value = $this->input->post('boq'.$id);
			$boq['typeofwork_activity_id'] = $typeofwork_activity_id;
			$boq['unit_id'] = $unit_id;
			$boq['boq_value'] = $boq_value;
			$boq['rowid'] = $rowIndex;
			if(!empty($_SESSION['contract_location_boq'][$row_feeder_id][$typeofwork_activity_id]['contract_location_boq_id']))
			{
				$boq['contract_location_boq_id'] = $_SESSION['contract_location_boq'][$row_feeder_id][$typeofwork_activity_id]['contract_location_boq_id'];
			}

			$contract_location_boq[$typeofwork_activity_id] = $boq;
		}

		$_SESSION['contract_location_boq'][$row_feeder_id] = $contract_location_boq;
		return true;
	}

	function typeofworkboqedit($workId)
   	{
   		$this->db->where("mst_activity_group.is_boq", 1);
   		$this->db->where("mst_typeofwork_activity.typeofwork_id", $workId);	
   		$this->db->select('mst_typeofwork_activity.*,mst_activity_group.name,mst_activity_group.is_boq, mst_unit.name as unitName, mst_unit.unit_id');   		
		$this->db->from('mst_typeofwork_activity');
		$this->db->join('mst_activity_group', 'mst_activity_group.activity_group_id  = mst_typeofwork_activity.activity_group_id', 'inner');
		$this->db->join('mst_unit', 'mst_unit.unit_id  = mst_typeofwork_activity.unit_id', 'inner');
		$query = $this->db->get();
		$result = $query->result();
		//echo $this->db->last_query();
		$html = '';				
		if(empty($result))
		{
			$_SESSION['boq_worktype'] = false;
		}
		else
		{
			$_SESSION['boq_worktype'] = true;
		}

		$typeOdActivityGroups = $this->typeofworkboqgroup($workId);
		

		$html = '<div class="tab-menu-heading tab-menu-heading-boxed">
            		<div class="tabs-menu-boxed">
            			<ul class="nav panel-tabs" role="tablist">';
            			$j=1;
            			foreach($typeOdActivityGroups as $activityGroup)
            			{
            				if($j==1)
            				{
            					$classname = "active";
            				}
            				else
            				{
            					$classname = "";
        					}
            				$html .='<li>
            							<a href="#tab'.$activityGroup->activity_group_id.'" class="'.$classname.'" data-bs-toggle="tab" aria-selected="true" role="tab" >'.$activityGroup->name.'</a>
									 </li>';
            				$j++;
        				}

        $html .='       </ul>
        			</div>
        		 </div>
            	 <div class="panel-body tabs-menu-body">
            		<div class="tab-content" style="height: 300px;overflow-y: scroll;">';
						$i=1;
            			foreach($typeOdActivityGroups as $activityGroup1)
            			{
            				if($i==1)
            				{
            					$classname = "active show";
        					}
        					else
            				{
            					$classname = "";
        					}

       	$html .= '		<div class="tab-pane '.$classname.' " id="tab'.$activityGroup1->activity_group_id.'" role="tabpanel">
            				<div class="table-responsive">
								<table class="table border table-bordered text-nowrap text-md-nowrap table-sm mb-0">
									<thead>
										<tr>
											<th>Sr No.</th>
											<th>Name of Activity</th>
											<th style="width: 10px;">Unit</th>
											<th>BOQ</th>
										</tr>
									</thead>
									<tbody>';
									$k=1;
									foreach($result as $res)
            						{
            							if($activityGroup1->activity_group_id == $res->activity_group_id)
            							{ 
		$html .=	'						<tr>
												<td>'.$k.'</td>
												<td>'.$res->activity.'</td>
												<td>'.$res->unitName.'</td>
												<td>
													<input class="form-control" type="hidden" name="unitid'.$res->typeofwork_activity_id.'" value="'.$res->unit_id.'">
													<input class="form-control" type="hidden" name="typeofwork_activity_id[]" value="'.$res->typeofwork_activity_id.'">
													<input class="form-control" type="text" name="boq'.$res->typeofwork_activity_id.'" placeholder="Enter Value">
												</td>
											</tr>';
										}
									
										$k++;
									}
															
		$html .= '              	</tbody>
								</table>
							</div>
    					</div>';
            								
        				}

        $html .= '</div>
            		</div>';

        echo $html;
   	}

   	function checkcontractstagecount()
   	{
   		if(isset($_SESSION['acceptstage']))
   		{
   			echo count($_SESSION['acceptstage']);
   		}
   	}

   	function checkrowboq($rowIndex, $workId, $feeder_id)
   	{
   		if(count($_SESSION['contract_location_boq'])==0)
   		{
   			echo '';
   			return;
   		}
   		foreach($_SESSION['contract_location_boq'] as $row=>$value)
   		{
   			if($feeder_id==$row)
   			{
   				$this->db->where("mst_activity_group.is_boq", 1);
   				$this->db->where("mst_typeofwork_activity.typeofwork_id", $workId);	
   				$this->db->select('mst_typeofwork_activity.*,mst_activity_group.name,mst_activity_group.is_boq, mst_unit.name as unitName, mst_unit.unit_id');   		
				$this->db->from('mst_typeofwork_activity');
				$this->db->join('mst_activity_group', 'mst_activity_group.activity_group_id  = mst_typeofwork_activity.activity_group_id', 'inner');
				$this->db->join('mst_unit', 'mst_unit.unit_id  = mst_typeofwork_activity.unit_id', 'inner');
				$query = $this->db->get();
				$result = $query->result();
				//echo $this->db->last_query(); die();

				$html = '';

				$typeOdActivityGroups = $this->typeofworkboqgroup($workId);
		
				$html = '<div class="tab-menu-heading tab-menu-heading-boxed">
            				<div class="tabs-menu-boxed">
            								
            					<ul class="nav panel-tabs" role="tablist">';
            					$j=1;
            					foreach($typeOdActivityGroups as $activityGroup)
            					{
            						if($j==1)
            						{
            							$classname = "active";
        							}
            						else
            						{
            							$classname = "";
        							}

            						$html .='<li>
            									<a href="#tab'.$activityGroup->activity_group_id.'" class="'.$classname.'" data-bs-toggle="tab" aria-selected="true" role="tab" >'.$activityGroup->name.'</a>
            								 </li>';
    								$j++;
            					}

            					$html .='</ul>
            				</div>
            			 </div>
            			 <div class="panel-body tabs-menu-body">
            				<div class="tab-content" style="height: 300px;overflow-y: scroll;">';
        						$i=1;
            					foreach($typeOdActivityGroups as $activityGroup1)
            					{
            						if($i==1)
            						{
            							$classname = "active show";
    								}
            						else
            						{
            							$classname = "";
            						}

            						$html .= '<div class="tab-pane '.$classname.' " id="tab'.$activityGroup1->activity_group_id.'" role="tabpanel">
            									<div class="table-responsive">
													<table class="table border table-bordered text-nowrap text-md-nowrap table-sm mb-0">
														<thead>
															<tr>
																<th>Sr No.</th>
																<th>Name of Activity</th>
																<th style="width: 10px;">Unit</th>
																<th>BOQ</th>
															</tr>
														</thead>
														<tbody>';
														 	$k=1;
															foreach($result as $res)
            												{
            													if($activityGroup1->activity_group_id == $res->activity_group_id ) { 
																$html .='<tr>
																			<td>'.$k.'</td>
																			<td>'.$res->activity.'</td>
																			<td>'.$res->unitName.'</td>
																			<td>
																				<input class="form-control" type="hidden" name="unitid'.$res->typeofwork_activity_id.'" value="'.$res->unit_id.'">
																				<input class="form-control" type="hidden" name="typeofwork_activity_id[]" value="'.$res->typeofwork_activity_id.'">
																				<input class="form-control addinputsboq" type="text" name="boq'.$res->typeofwork_activity_id.'" value="'.$_SESSION['contract_location_boq'][$feeder_id][$res->typeofwork_activity_id]['boq_value'].'">
																			</td>
																		 </tr>';
																}
																$k++;
															}
															
														$html .= '</tbody>
													</table>
												</div>
            								</div>
            								';
            					}

            					$html .= '</div>
            			 </div>';
            	echo $html;
   			}
   			else
   			{
   				echo "";
   			}
   		}   	
   	}

   	function loadSetSessionBoqDetails($contractID, $rowID)
   	{
   		$this->db->where("contract_location.contract_id", $contractID);
   		$this->db->where("contract_location.is_active", 1);	
   		$this->db->select('contract_location.feeder_id,contract_location.contract_location_id,contract_location_boq.boq,contract_location_boq.typeofwork_activity_id,contract_location_boq.unit_id,contract_location_boq.contract_location_boq_id');   		
		$this->db->from('contract_location');
		$this->db->join('contract_location_boq', 'contract_location_boq.contract_location_id  = contract_location.contract_location_id', 'inner');
		$query = $this->db->get();
		$result = $query->result();
		// echo $this->db->last_query(); die();

		if(!empty($result))
		{
			foreach($result as $val)
			{
				$typeofwork_activity_id = $val->typeofwork_activity_id;
				
				$boq['typeofwork_activity_id'] = $val->typeofwork_activity_id;
				$boq['unit_id'] = $val->unit_id;
				$boq['boq_value'] = $val->boq;
				$boq['contract_location_boq_id'] = $val->contract_location_boq_id;
				$boq['rowid'] = $rowID;
				$boq['feeder_id'] = $val->feeder_id;
				$contract_location_boq[$val->feeder_id][$typeofwork_activity_id] = $boq;
			}
		
			// $_SESSION['contract_location_boq'][$rowID] = $contract_location_boq;
			$_SESSION['contract_location_boq'] = $contract_location_boq;
		}
   	}

   	function checkdatelessthan($inputField, $rowIndex, $dateField)
   	{
   		$rowIndexArray = array();

   		foreach($_SESSION['acceptstage'] as $stage)
   		{
   			if($stage['rowId'] < $rowIndex && $rowIndex !=0)
   			{
				$earlierDate = date("d-m-Y", strtotime($stage['date']));
				$thisDate = date("d-m-Y", strtotime($dateField));
				
   				//if($dateField <= $stage['date'])
					if($thisDate <= $earlierDate)
   				{
   					array_push($rowIndexArray, $stage['rowId']);
   				}
   			}
   		}

   		if(count($rowIndexArray) > 0)
   		{
   			echo "Entered Date is less than rest of Stage dates.";
   		}
   	}

   	public function getPackageGroupNo($contractID)
   	{
   		$this->db->select('package_group_no');
   		$query = $this->db->get_where('contract', array('contract_id' => $contractID));
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
	
}