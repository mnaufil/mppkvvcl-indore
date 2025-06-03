<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class SetupInner_Model extends CI_Model
{
	function __construct()
    {
        parent::__construct();

    }


    function insertMilestones($last_id, $actionItem)
    {
        try
        {
            foreach($_SESSION['acceptstage'] as $stage)
            {
                if(!isset($stage['databaseId']))
                {
                $stageArray = array(

                    "contract_id" => $last_id,
                    "stage_id" => $stage['stage'],
                    "date" => date ('Y-m-d', strtotime($stage['date'])),
                    "quantity" => $stage['quantity'],
                    "amount" => $stage['amount'],
                    "is_active" => 1,
                    "createdby" => $_SESSION['loggedData']->user_id,
                    "createddate" => date ('Y-m-d H:i:s')
                );

                $this->db->insert("contract_stage", $stageArray);
                $last_id_for_log = $this->db->insert_id(); 

                $stageArrayLog = array(
                    "contract_stage_id" => $last_id_for_log,
                    "contract_id" => $last_id,
                    "stage_id" => $stage['stage'],
                    "date" => date ('Y-m-d', strtotime($stage['date'])),
                    "quantity" => $stage['quantity'],
                    "amount" => $stage['amount'],
                    "is_active" => 1,
                   "createdby" => $_SESSION['loggedData']->user_id,
                    "createddate" => date ('Y-m-d H:i:s')
                );
                $this->db->insert("contract_stage_log", $stageArrayLog);
                unset($_SESSION['acceptstage'][$stage['rowId']]);
            }
        }
            return true;
       
        }
         catch (Exception $e)
        {
            
            log_message('error: ',$e->getMessage());
            
            return;
        }
        
    }
	
	
	function insertRegions($last_id, $actionItem)
    {
        try
        {
            foreach($_SESSION['acceptregion'] as $region)
            {
                if(!isset($region['databaseId']))
                {
                $regionArray = array(

                    "contract_id" => $last_id,
                    "region_id" => $region['region'],
                    "circle_id" => $region['circle'],
                    "division_id" => $region['division'],
                    "district" => $region['district'],
                    "vidhansabha" => $region['vidhansabha'],
                    "loksabha" => $region['loksabha'],
                    "location_name" => $region['location'],
                    "feeder_name" => $region['feedername'],
                    "feeder_id" => $region['feederid'],
                    "project_id" => $region['projectid'],
                    "geo_code" => $region['geocode'],
                    "quantity" => $region['quantity'],
                    "is_active" => 1,
                    "createdby" => $_SESSION['loggedData']->user_id,
                    "createddate" => date ('Y-m-d H:i:s')
                );

                $this->db->insert("contract_location", $regionArray);
                $last_id_for_log = $this->db->insert_id(); 


                //for inserting in physical progress 
                $physicalProgressArray = array(
                    "contract_id" => $last_id,
                    "contract_location_id" => $last_id_for_log,
                    "site_location" => $region['location'],
                    "status_id" => 1,
                     "createdby" => $_SESSION['loggedData']->user_id,
                    "createddate" => date ('Y-m-d H:i:s')
                );
                $this->db->insert("physical_progress", $physicalProgressArray);


                $regionArrayLog = array(
                    "contract_location_id" => $last_id_for_log,
                    "contract_id" => $last_id,
                    "region_id" => $region['region'],
                    "circle_id" => $region['circle'],
                    "division_id" => $region['division'],
                    "location_name" => $region['location'],
                    "feeder_name" => $region['feedername'],
                    "feeder_id" => $region['feederid'],
                    "project_id" => $region['projectid'],
                    "geo_code" => $region['geocode'],
                    "quantity" => $region['quantity'],
                    "is_active" => 1,
                    "createdby" => $_SESSION['loggedData']->user_id,
                    "createddate" => date ('Y-m-d H:i:s')
                );
                $this->db->insert("contract_location_log", $regionArrayLog);


                //insert for contract location boq
                if(isset($_SESSION['boq_worktype']) && $_SESSION['boq_worktype']==1)
                {
                    $rowId = $region['rowId'];

                    if(isset($_SESSION['contract_location_boq'][$rowId]))
                        {

                     foreach($_SESSION['contract_location_boq'][$rowId] as $location_boq)
                     {   
                        
                        $typeofwork_activity_id = $location_boq['typeofwork_activity_id'];
                    $boqArray = array(
                        "contract_location_id" => $last_id_for_log,
                        "typeofwork_activity_id" => $typeofwork_activity_id,
                        "unit_id" => $location_boq['unit_id'],
                        "boq" => $location_boq['boq_value'],
                        "is_active" => 1,
                        "createdby" => $_SESSION['loggedData']->user_id,
                        "createddate" => date ('Y-m-d H:i:s')

                    );

                    $this->db->insert("contract_location_boq", $boqArray);
                    $last_id_for_boq = $this->db->insert_id(); 

                    $boqArrayLog = array(
                        "contract_location_boq_id" => $last_id_for_boq,
                        "contract_location_id" => $last_id_for_log,
                        "typeofwork_activity_id" => $typeofwork_activity_id,
                         "unit_id" => $location_boq['unit_id'],
                        "boq" => $location_boq['boq_value'],
                        "is_active" => 1,
                        "createdby" => $_SESSION['loggedData']->user_id,
                        "createddate" => date ('Y-m-d H:i:s')

                    );

                    $this->db->insert("contract_location_boq_log", $boqArrayLog);
                }
                }
            }
        }
        unset($_SESSION['acceptregion'][$region['rowId']]);

            }
            return true;
       
        }
         catch (Exception $e)
        {
            
            log_message('error: ',$e->getMessage());
            
            return;
        }
        
    }



    function insertMaterial($last_id, $actionItem)
    {
        try
        {
            foreach($_SESSION['acceptmaterial'] as $material)
            {
                if(!isset($material['databaseId'])) {
                $materialArray = array(

                    "contract_id" => $last_id,
                    "item_code" => $material['sr_no'],
                    "equipment_material_name" => $material['equipment_material_name'],
                    "unit_id" => $material['unit_id'],
                    "quantity" => $material['total_quantity'],
                    "is_active" => 1,
                    "createdby" => $_SESSION['loggedData']->user_id,
                    "createddate" => date ('Y-m-d H:i:s')
                );

                $this->db->insert("contract_material", $materialArray);
                $last_id_for_log = $this->db->insert_id(); 

                $materialArrayLog = array(
                    "contract_material_id" => $last_id_for_log,
                    "contract_id" => $last_id,
                    "item_code" => $material['sr_no'],
                    "equipment_material_name" => $material['equipment_material_name'],
                    "unit_id" => $material['unit_id'],
                    "quantity" => $material['total_quantity'],
                    "is_active" => 1,
                    "createdby" => $_SESSION['loggedData']->user_id,
                    "createddate" => date ('Y-m-d H:i:s')
                );
                $this->db->insert("contract_material_log", $materialArrayLog);
                unset($_SESSION['acceptmaterial'][$material['rowId']]);
            }
            }
            return true;
       
        }
         catch (Exception $e)
        {
            
            log_message('error: ',$e->getMessage());
            
            return;
        }
        
    }



    function insertMobilisation($last_id, $actionItem)
    {
        try
        {
            foreach($_SESSION['acceptmobilisation'] as $mobilisation)
            {
                if(!isset($mobilisation['databaseId']))
                {
                $mobilisationArray = array(

                    "contract_id" => $last_id,
                   // "sr_no" => $mobilisation['sr_no'],
                    "mobilisation_type_id" => $mobilisation['mobilisation_type'],
                    "invoice_no" => $mobilisation['invoice_no'],
                    "invoice_date" => date ('Y-m-d', strtotime($mobilisation['invoice_date'])),
                    "advance_amount" => $mobilisation['advance_amount'],
                    "date_of_payment" => date ('Y-m-d', strtotime($mobilisation['date_of_payment'])),
                    "advance_adjusted" => $mobilisation['advance_adjusted'],
                    "is_active" => 1,
                    "createdby" => $_SESSION['loggedData']->user_id,
                    "createddate" => date ('Y-m-d H:i:s')
                );

                $this->db->insert("contract_mobilisation", $mobilisationArray);
                $last_id_for_log = $this->db->insert_id(); 

                $mobilisationArrayLog = array(
                    "contract_mobilisation_id" => $last_id_for_log,
                     "contract_id" => $last_id,
                  //  "sr_no" => $mobilisation['sr_no'],
                    "mobilisation_type_id" => $mobilisation['mobilisation_type'],
                    "invoice_no" => $mobilisation['invoice_no'],
                    "invoice_date" => date ('Y-m-d', strtotime($mobilisation['invoice_date'])),
                    "advance_amount" => $mobilisation['advance_amount'],
                    "date_of_payment" => date ('Y-m-d', strtotime($mobilisation['date_of_payment'])),
                    "advance_adjusted" => $mobilisation['advance_adjusted'],
                    "is_active" => 1,
                    "createdby" => $_SESSION['loggedData']->user_id,
                    "createddate" => date ('Y-m-d H:i:s')
                );
                $this->db->insert("contract_mobilisation_log", $mobilisationArrayLog);
                 unset($_SESSION['acceptmobilisation'][$mobilisation['rowId']]);
            }
        }
            return true;
       
        }
         catch (Exception $e)
        {
            
            log_message('error: ',$e->getMessage());
            
            return;
        }
        
    }


     function insertBanks($last_id, $actionItem)
    {
        try
        {
            foreach($_SESSION['acceptbank'] as $bank)
            {
                if(!isset($bank['databaseId']))
                {
                $bankArray = array(

                    "contract_id" => $last_id,
                   // "sr_no" => $bank['sr_no'],
                    "bg_type_id" => $bank['bank_id'],
                    "bg_number" => $bank['bg_no'],
                    "bg_date" => date ('Y-m-d', strtotime($bank['bg_date'])),
                    "bg_amount" => $bank['bg_amount'],
                    "bg_bank" => $bank['bank'],
                    "bg_valid_till" => date ('Y-m-d', strtotime($bank['bg_till_date'])),
                    "is_active" => 1,
                    "createdby" => $_SESSION['loggedData']->user_id,
                    "createddate" => date ('Y-m-d H:i:s')
                );

                $this->db->insert("contract_bg", $bankArray);
                $last_id_for_log = $this->db->insert_id(); 

                /*$mobilisationArrayLog = array(
                    "contract_mobilisation_id" => $last_id_for_log,
                     "contract_id" => $last_id,
                    "sr_no" => $mobilisation['region'],
                    "mobilisation_type_id" => $mobilisation['mobilisation_type'],
                    "invoice_no" => $mobilisation['invoice_no'],
                    "invoice_date" => $mobilisation['invoice_date'],
                    "advance_amount" => $mobilisation['advance_amount'],
                    "date_of_payment" => $mobilisation['date_of_payment'],
                    "advance_adjusted" => $mobilisation['advance_adjusted'],
                    "is_active" => 1,
                    "createdby" => $_SESSION['loggedData']->user_id,
                    "createddate" => date ('Y-m-d H:i:s')
                );
                $this->db->insert("contract_mobilisation_log", $mobilisationArrayLog);*/
                unset($_SESSION['acceptbank'][$bank['rowId']]);
            }
        }
            return true;
       
        }
         catch (Exception $e)
        {
            
            log_message('error: ',$e->getMessage());
            
            return;
        }
        
    }




     function updateMilestones($last_id, $actionItem)
    {
        try
        {
           $idArrayToDelete = array();
            foreach($_SESSION['acceptstage'] as $stage)
            {
                if(!isset($stage['databaseId']) && empty($stage['databaseId']) && !isset($stage['deleteId']))
                {
                    //echo "if/".$stage['databaseId']; die;
                    $this->insertMilestones($last_id, $actionItem);
                }
                else if(isset($stage['deleteId']))
                {
                    //echo "kvblvbkclvb/".$stage['deleteId']; die;
                    $stageArray = array(
                    "contract_id" => $last_id,
                    "stage_id" => $stage['stage'],
                    "date" => date ('Y-m-d', strtotime($stage['date'])),
                    "quantity" => $stage['quantity'],
                    "amount" => $stage['amount'],
                    "is_active" => 0,
                    "deletedby" => $_SESSION['loggedData']->user_id,
                    "deleteddate" => date ('Y-m-d H:i:s')
                );

                    $this->db->where("contract_stage_id", $stage['deleteId']);
                    $this->db->update("contract_stage", $stageArray);
                    $last_id_for_log = $stage['deleteId'];

                    $stageArrayLog = array(
                    "contract_stage_id" => $last_id_for_log,
                    "contract_id" => $last_id,
                    "stage_id" => $stage['stage'],
                    "date" => date ('Y-m-d', strtotime($stage['date'])),
                    "quantity" => $stage['quantity'],
                    "amount" => $stage['amount'],
                    "is_active" => 0,
                    "deletedby" => $_SESSION['loggedData']->user_id,
                    "deleteddate" => date ('Y-m-d H:i:s')
                );
                $this->db->insert("contract_stage_log", $stageArrayLog); 

                }
                else
                {
                    //echo "else/".$stage['databaseId']; die;
                   $stageArray = array(
                    "contract_id" => $last_id,
                    "stage_id" => $stage['stage'],
                    "date" => date ('Y-m-d', strtotime($stage['date'])),
                    "quantity" => $stage['quantity'],
                    "amount" => $stage['amount'],
                    "is_active" => 1,
                    "modifiedby" => $_SESSION['loggedData']->user_id,
                    "modifieddate" => date ('Y-m-d H:i:s')
                );

                $this->db->where("contract_stage_id", $stage['databaseId']);
                $this->db->update("contract_stage", $stageArray);
                $last_id_for_log = $stage['databaseId']; 

               // array_push($idArrayToDelete, $stage['databaseId']);                

                $stageArrayLog = array(
                    "contract_stage_id" => $last_id_for_log,
                    "contract_id" => $last_id,
                    "stage_id" => $stage['stage'],
                    "date" => date ('Y-m-d', strtotime($stage['date'])),
                    "quantity" => $stage['quantity'],
                    "amount" => $stage['amount'],
                    "is_active" => 1,
                    "modifiedby" => $_SESSION['loggedData']->user_id,
                    "modifieddate" => date ('Y-m-d H:i:s')
                );
                $this->db->insert("contract_stage_log", $stageArrayLog); 
                }
                unset($_SESSION['acceptstage'][$stage['rowId']]);
                
            }
          
            //$this->deleteAction("contract_stage", $idArrayToDelete, $last_id);
            return true;
       
        }
         catch (Exception $e)
        {
            
            log_message('error: ',$e->getMessage());
            
            return;
        }
        
    }



    function updateRegions($last_id, $actionItem)
    {
        try
        {
            foreach($_SESSION['acceptregion'] as $region)
            {
                if(!isset($region['databaseId']) && empty($region['databaseId']) && !isset($region['deleteId']))
                {
                    $this->insertRegions($last_id, $actionItem);
                }
                else if(isset($region['deleteId']))
                {
                    $regionArray = array(
                        "contract_id" => $last_id,
                        "region_id" => $region['region'],
                        "circle_id" => $region['circle'],
                        "division_id" => $region['division'],
                        "location_name" => $region['location'],
                        "feeder_name" => $region['feedername'],
                        "feeder_id" => $region['feederid'],
                        "project_id" => $region['projectid'],
                        "geo_code" => $region['geocode'],
                        "quantity" => $region['quantity'],
                        "is_active" => 0,
                        "deletedby" => $_SESSION['loggedData']->user_id,
                        "deleteddate" => date ('Y-m-d H:i:s')
                    );
                    $this->db->where("contract_location_id", $region['deleteId']);
                    $this->db->update("contract_location", $regionArray);
                    $last_id_for_log = $region['deleteId'];

                    //for inserting in physical progress 
                    $physicalProgressArray = array(
                        "contract_id" => $last_id,
                        //"contract_location_id" => $last_id_for_log,
                        "site_location" => $region['location'],
                        "status_id" => 0,
                        "deletedby" => $_SESSION['loggedData']->user_id,
                        "deleteddate" => date ('Y-m-d H:i:s')
                    );
                    
                    $this->db->where("contract_location_id", $region['deleteId']);
                    $this->db->update("physical_progress", $physicalProgressArray);

                    $regionArrayLog = array(
                        "contract_location_id" => $last_id_for_log,
                        "contract_id" => $last_id,
                        "region_id" => $region['region'],
                        "circle_id" => $region['circle'],
                        "division_id" => $region['division'],
                        "location_name" => $region['location'],
                        "feeder_name" => $region['feedername'],
                        "feeder_id" => $region['feederid'],
                        "project_id" => $region['projectid'],
                        "geo_code" => $region['geocode'],
                        "quantity" => $region['quantity'],
                        "is_active" => 0,
                        "deletedby" => $_SESSION['loggedData']->user_id,
                        "deleteddate" => date ('Y-m-d H:i:s')
                    );
                    $this->db->insert("contract_location_log", $regionArrayLog);

                    //insert for contract location boq
                    if(isset($_SESSION['boq_worktype']) && $_SESSION['boq_worktype']==1)
                    {
                        $rowId = $region['rowId'];
                        if(isset($_SESSION['contract_location_boq'][$rowId])) {
                            foreach($_SESSION['contract_location_boq'][$rowId] as $location_boq)
                            {   
                                $typeofwork_activity_id = $location_boq['typeofwork_activity_id'];
                                $boqArray = array(
                                    "contract_location_id" => $last_id_for_log,
                                    "typeofwork_activity_id" => $typeofwork_activity_id,
                                    "unit_id" => $location_boq['unit_id'],
                                    "boq" => $location_boq['boq_value'],
                                    "is_active" => 0,
                                    "deletedby" => $_SESSION['loggedData']->user_id,
                                    "deleteddate" => date ('Y-m-d H:i:s')
                                );

                                $this->db->where("contract_location_boq_id", $location_boq['contract_location_boq_id']);
                                $this->db->update("contract_location_boq", $boqArray);
                                // echo $this->db->last_query(); die;
                                // $last_id_for_boq = $this->db->insert_id(); 

                                $boqArrayLog = array(
                                    "contract_location_boq_id" => $location_boq['contract_location_boq_id'],
                                    "contract_location_id" => $last_id_for_log,
                                    "typeofwork_activity_id" => $typeofwork_activity_id,
                                    "unit_id" => $location_boq['unit_id'],
                                    "boq" => $location_boq['boq_value'],
                                    "is_active" => 0,
                                    "deletedby" => $_SESSION['loggedData']->user_id,
                                    "deleteddate" => date ('Y-m-d H:i:s')
                                );

                                $this->db->insert("contract_location_boq_log", $boqArrayLog);
                            }
                        }
                    }
                }
                else
                {
                    $regionArray = array(
                        "contract_id" => $last_id,
                        "region_id" => $region['region'],
                        "circle_id" => $region['circle'],
                        "division_id" => $region['division'],
                        "location_name" => $region['location'],
                        "feeder_name" => $region['feedername'],
                        "feeder_id" => $region['feederid'],
                        "project_id" => $region['projectid'],
                        "geo_code" => $region['geocode'],
                        "quantity" => $region['quantity'],
                        "is_active" => 1,
                        "modifiedby" => $_SESSION['loggedData']->user_id,
                        "modifieddate" => date ('Y-m-d H:i:s')
                    );
                    $this->db->where("contract_location_id", $region['databaseId']);
                    $this->db->update("contract_location", $regionArray);
                    $last_id_for_log = $region['databaseId']; 


                    //for inserting in physical progress 
                    $physicalProgressArray = array(
                        "contract_id" => $last_id,
                        //"contract_location_id" => $last_id_for_log,
                        "site_location" => $region['location'],
                        // "status_id" => 1
                    );
                    $this->db->where("contract_location_id", $region['databaseId']);
                    $this->db->update("physical_progress", $physicalProgressArray);


                    $regionArrayLog = array(
                        "contract_location_id" => $last_id_for_log,
                        "contract_id" => $last_id,
                        "region_id" => $region['region'],
                        "circle_id" => $region['circle'],
                        "division_id" => $region['division'],
                        "location_name" => $region['location'],
                        "feeder_name" => $region['feedername'],
                        "feeder_id" => $region['feederid'],
                        "project_id" => $region['projectid'],
                        "geo_code" => $region['geocode'],
                        "quantity" => $region['quantity'],
                        "is_active" => 1,
                        "modifiedby" => $_SESSION['loggedData']->user_id,
                        "modifieddate" => date ('Y-m-d H:i:s')
                    );
                    $this->db->insert("contract_location_log", $regionArrayLog);

                    //insert for contract location boq
                    if(isset($_SESSION['boq_worktype']) && $_SESSION['boq_worktype']==1)
                    {
                        $rowId = $region['rowId'];
                        if(isset($_SESSION['contract_location_boq'][$rowId])) {
                            foreach($_SESSION['contract_location_boq'][$rowId] as $location_boq)
                            {   
                                $typeofwork_activity_id = $location_boq['typeofwork_activity_id'];
                                $boqArray = array(
                                    "contract_location_id" => $last_id_for_log,
                                    "typeofwork_activity_id" => $typeofwork_activity_id,
                                    "unit_id" => $location_boq['unit_id'],
                                    "boq" => $location_boq['boq_value'],
                                    "is_active" => 1,
                                    "modifiedby" => $_SESSION['loggedData']->user_id,
                                    "modifieddate" => date ('Y-m-d H:i:s')
                                );

                                $this->db->where("contract_location_boq_id", $location_boq['contract_location_boq_id']);
                                $this->db->update("contract_location_boq", $boqArray);
                                // echo $this->db->last_query(); die;
                                // $last_id_for_boq = $this->db->insert_id(); 

                                $boqArrayLog = array(
                                    "contract_location_boq_id" => $location_boq['contract_location_boq_id'],
                                    "contract_location_id" => $last_id_for_log,
                                    "typeofwork_activity_id" => $typeofwork_activity_id,
                                    "unit_id" => $location_boq['unit_id'],
                                    "boq" => $location_boq['boq_value'],
                                    "is_active" => 1,
                                    "modifiedby" => $_SESSION['loggedData']->user_id,
                                    "modifieddate" => date ('Y-m-d H:i:s')
                                );

                                $this->db->insert("contract_location_boq_log", $boqArrayLog);
                            }
                        }
                    }
                }
                unset($_SESSION['acceptregion'][$region['rowId']]);
                //end here
            }

            return true;
        }
        catch (Exception $e)
        {            
            log_message('error: ',$e->getMessage());
            
            return;
        }
    }

    public function updateContractLocationBOQ($last_id, $actionItem)
    {
        try {
            foreach ($_SESSION['contract_location_boq'] as $key => $value) {
                foreach ($value as $k => $v) {
                    $data = array(
                        'boq' => $v['boq_value']
                    );

                    $this->db->update('contract_location_boq', $data, array('contract_location_boq_id' => $v['contract_location_boq_id'], 'typeofwork_activity_id' => $v['typeofwork_activity_id']));
                    // echo $this->db->last_query(); die();
                }

                unset($_SESSION['contract_location_boq'][$key]);
            }

            return true;
        } catch (Exception $e) {
            log_message('error: ',$e->getMessage());
            return;
        }
    }

    function updateMaterial($last_id, $actionItem)
    {
        try
        {
            foreach($_SESSION['acceptmaterial'] as $material)
            {
                if(!isset($material['databaseId']) && empty($material['databaseId']) && !isset($material['deleteId']))
                { 
                    $this->insertMaterial($last_id, $actionItem);
                }
                else if(isset($material['deleteId']))
                {
                    $materialArray = array(

                    "contract_id" => $last_id,
                    "sr_no" => $material['sr_no'],
                    "equipment_material_name" => $material['equipment_material_name'],
                    "unit_id" => $material['unit_id'],
                    "quantity" => $material['total_quantity'],
                    "is_active" => 0,
                    "deletedby" => $_SESSION['loggedData']->user_id,
                    "deleteddate" => date ('Y-m-d H:i:s')
                );
                $this->db->where("contract_material_id", $material['deleteId']);
                $this->db->update("contract_material", $materialArray);
                $last_id_for_log = $material['deleteId']; 

                $materialArrayLog = array(
                    "contract_material_id" => $last_id_for_log,
                    "contract_id" => $last_id,
                    "sr_no" => $material['sr_no'],
                    "equipment_material_name" => $material['equipment_material_name'],
                    "unit_id" => $material['unit_id'],
                    "quantity" => $material['total_quantity'],
                    "is_active" => 0,
                    "deletedby" => $_SESSION['loggedData']->user_id,
                    "deleteddate" => date ('Y-m-d H:i:s')
                );
                $this->db->insert("contract_material_log", $materialArrayLog);
                }
                else
                {

                $materialArray = array(

                    "contract_id" => $last_id,
                    "sr_no" => $material['sr_no'],
                    "equipment_material_name" => $material['equipment_material_name'],
                    "unit_id" => $material['unit_id'],
                    "quantity" => $material['total_quantity'],
                    "is_active" => 1,
                    "modifiedby" => $_SESSION['loggedData']->user_id,
                    "modifieddate" => date ('Y-m-d H:i:s')
                );
                $this->db->where("contract_material_id", $material['databaseId']);
                $this->db->update("contract_material", $materialArray);
                $last_id_for_log = $material['databaseId']; 

                $materialArrayLog = array(
                    "contract_material_id" => $last_id_for_log,
                    "contract_id" => $last_id,
                    "sr_no" => $material['sr_no'],
                    "equipment_material_name" => $material['equipment_material_name'],
                    "unit_id" => $material['unit_id'],
                    "quantity" => $material['total_quantity'],
                    "is_active" => 1,
                    "modifiedby" => $_SESSION['loggedData']->user_id,
                    "modifieddate" => date ('Y-m-d H:i:s')
                );
                $this->db->insert("contract_material_log", $materialArrayLog);
            }
            unset($_SESSION['acceptmaterial'][$material['rowId']]);

        }
            return true;
       
        }
         catch (Exception $e)
        {
            
            log_message('error: ',$e->getMessage());
            
            return;
        }
        
    }



     function updateMobilisation($last_id, $actionItem)
    {
        try
        {
            foreach($_SESSION['acceptmobilisation'] as $mobilisation)
            {

                if(!isset($mobilisation['databaseId']) && empty($mobilisation['databaseId']) && !isset($mobilisation['deleteId']))
                {
                    $this->insertMobilisation($last_id, $actionItem);
                }
                else if(isset($mobilisation['deleteId']))
                {


                    $mobilisationArray = array(

                    "contract_id" => $last_id,
                    //"sr_no" => $mobilisation['sr_no'],
                    "mobilisation_type_id" => $mobilisation['mobilisation_type'],
                    "invoice_no" => $mobilisation['invoice_no'],
                    "invoice_date" => date ('Y-m-d', strtotime($mobilisation['invoice_date'])),
                    "advance_amount" => $mobilisation['advance_amount'],
                    "date_of_payment" => date ('Y-m-d', strtotime($mobilisation['date_of_payment'])),
                    "advance_adjusted" => $mobilisation['advance_adjusted'],
                    "is_active" => 0,
                    "deletedby" => $_SESSION['loggedData']->user_id,
                    "deleteddate" => date ('Y-m-d H:i:s')
                );
                $this->db->where("contract_mobilisation_id", $mobilisation['deleteId']);
                $this->db->update("contract_mobilisation", $mobilisationArray);
                $last_id_for_log = $mobilisation['deleteId']; 

                $mobilisationArrayLog = array(
                    "contract_mobilisation_id" => $last_id_for_log,
                    "contract_id" => $last_id,
                    //"sr_no" => $mobilisation['sr_no'],
                    "mobilisation_type_id" => $mobilisation['mobilisation_type'],
                    "invoice_no" => $mobilisation['invoice_no'],
                    "invoice_date" => date ('Y-m-d', strtotime($mobilisation['invoice_date'])),
                    "advance_amount" => $mobilisation['advance_amount'],
                    "date_of_payment" => date ('Y-m-d', strtotime($mobilisation['date_of_payment'])),
                    "advance_adjusted" => $mobilisation['advance_adjusted'],
                    "is_active" => 0,
                    "deletedby" => $_SESSION['loggedData']->user_id,
                    "deleteddate" => date ('Y-m-d H:i:s')
                );
                $this->db->insert("contract_mobilisation_log", $mobilisationArrayLog);

                }
                else
                {

                $mobilisationArray = array(

                    "contract_id" => $last_id,
                    //"sr_no" => $mobilisation['sr_no'],
                    "mobilisation_type_id" => $mobilisation['mobilisation_type'],
                    "invoice_no" => $mobilisation['invoice_no'],
                    "invoice_date" => date ('Y-m-d', strtotime($mobilisation['invoice_date'])),
                    "advance_amount" => $mobilisation['advance_amount'],
                    "date_of_payment" => date ('Y-m-d', strtotime($mobilisation['date_of_payment'])),
                    "advance_adjusted" => $mobilisation['advance_adjusted'],
                    "is_active" => 1,
                    "modifiedby" => $_SESSION['loggedData']->user_id,
                    "modifieddate" => date ('Y-m-d H:i:s')
                );
                $this->db->where("contract_mobilisation_id", $mobilisation['databaseId']);
                $this->db->update("contract_mobilisation", $mobilisationArray);
                $last_id_for_log = $mobilisation['databaseId']; 

                $mobilisationArrayLog = array(
                    "contract_mobilisation_id" => $last_id_for_log,
                     "contract_id" => $last_id,
                   //"sr_no" => $mobilisation['sr_no'],
                    "mobilisation_type_id" => $mobilisation['mobilisation_type'],
                    "invoice_no" => $mobilisation['invoice_no'],
                    "invoice_date" => date ('Y-m-d', strtotime($mobilisation['invoice_date'])),
                    "advance_amount" => $mobilisation['advance_amount'],
                    "date_of_payment" => date ('Y-m-d', strtotime($mobilisation['date_of_payment'])),
                    "advance_adjusted" => $mobilisation['advance_adjusted'],
                    "is_active" => 1,
                    "modifiedby" => $_SESSION['loggedData']->user_id,
                    "modifieddate" => date ('Y-m-d H:i:s')
                );
                $this->db->insert("contract_mobilisation_log", $mobilisationArrayLog);
            }
             unset($_SESSION['acceptmobilisation'][$mobilisation['rowId']]);
        }
            return true;
       
        }
         catch (Exception $e)
        {
            
            log_message('error: ',$e->getMessage());
            
            return;
        }
        
    }



     function updateBanks($last_id, $actionItem)
    {
        try
        {
            foreach($_SESSION['acceptbank'] as $bank)
            {
                if(!isset($bank['databaseId']) && empty($bank['databaseId']) && !isset($bank['deleteId']))
                {
                    $this->insertBanks($last_id, $actionItem);
                }
                else if(isset($bank['deleteId']))
                {
                     $bankArray = array(

                    "contract_id" => $last_id,
                   // "sr_no" => $bank['sr_no'],
                    "bg_type_id" => $bank['bank_id'],
                    "bg_number" => $bank['bg_no'],
                    "bg_date" => date ('Y-m-d', strtotime($bank['bg_date'])),
                    "bg_amount" => $bank['bg_amount'],
                    "bg_bank" => $bank['bank'],
                    "bg_valid_till" => date ('Y-m-d', strtotime($bank['bg_till_date'])),
                    "is_active" => 0,
                    "deletedby" => $_SESSION['loggedData']->user_id,
                    "deleteddate" => date ('Y-m-d H:i:s')
                );
                 $this->db->where("contract_bg_id", $bank['deleteId']);
                $this->db->update("contract_bg", $bankArray);
                $last_id_for_log = $bank['deleteId']; 


                }
                else
                {
                $bankArray = array(

                    "contract_id" => $last_id,
                   // "sr_no" => $bank['sr_no'],
                    "bg_type_id" => $bank['bank_id'],
                    "bg_number" => $bank['bg_no'],
                    "bg_date" => date ('Y-m-d', strtotime($bank['bg_date'])),
                    "bg_amount" => $bank['bg_amount'],
                    "bg_bank" => $bank['bank'],
                    "bg_valid_till" => date ('Y-m-d', strtotime($bank['bg_till_date'])),
                    "is_active" => 1,
                    "modifiedby" => $_SESSION['loggedData']->user_id,
                    "modifieddate" => date ('Y-m-d H:i:s')
                );
                 $this->db->where("contract_bg_id", $bank['databaseId']);
                $this->db->update("contract_bg", $bankArray);
                $last_id_for_log = $bank['databaseId']; 

                /*$mobilisationArrayLog = array(
                    "contract_mobilisation_id" => $last_id_for_log,
                     "contract_id" => $last_id,
                    "sr_no" => $mobilisation['region'],
                    "mobilisation_type_id" => $mobilisation['mobilisation_type'],
                    "invoice_no" => $mobilisation['invoice_no'],
                    "invoice_date" => $mobilisation['invoice_date'],
                    "advance_amount" => $mobilisation['advance_amount'],
                    "date_of_payment" => $mobilisation['date_of_payment'],
                    "advance_adjusted" => $mobilisation['advance_adjusted'],
                    "is_active" => 1,
                    "createdby" => $_SESSION['loggedData']->user_id,
                    "createddate" => date ('Y-m-d H:i:s')
                );
                $this->db->insert("contract_mobilisation_log", $mobilisationArrayLog);*/
            }
            unset($_SESSION['acceptbank'][$bank['rowId']]);
        }
            return true;
       
        }
         catch (Exception $e)
        {
            
            log_message('error: ',$e->getMessage());
            
            return;
        }
        
    }



    function deleteAction($tableName, $idArrayToDelete, $last_id)
    {
        switch($tableName)
        {
            case "contract_stage":

             $this->db->where("is_active", 1);
             $this->db->where("contract_id", $last_id);
             /*$this->db->select("contract_stage_id");*/
             $query = $this->db->get($tableName);
             $result = $query->result();
             
             $existsArray = array();

             foreach($result as $res)
             {
                    array_push($existsArray, $res->contract_stage_id);
             }
            
             $array_diff = array_diff($existsArray, $idArrayToDelete);
            /* print_r($idArrayToDelete); die;*/
             $this->db->where_in("contract_stage_id", $array_diff);

             $deleteArray = array(
                "is_active"  => 0,
                "deletedby" => $_SESSION['loggedData']->user_id,
                "deleteddate" => date ('Y-m-d H:i:s')
             );

             $this->db->update("contract_stage", $deleteArray);


             foreach($result as $res)
             {
                if(in_array($res->contract_stage_id, $array_diff))
                {
                $stageArrayLog = array(
                    "contract_stage_id" => $res->contract_stage_id,
                    "contract_id" => $last_id,
                    "stage_id" => $res->stage_id,
                    "date" => date ('Y-m-d', strtotime($res->date)),
                    "quantity" => $res->quantity,
                    "amount" => $res->amount,
                    "is_active" => 0,
                   "deletedby" => $_SESSION['loggedData']->user_id,
                    "deleteddate" => date ('Y-m-d H:i:s')
                );
                $this->db->insert("contract_stage_log", $stageArrayLog);
                }

             }

            
             break;

             case "contract_stage_log":
             $this->db->where("is_active", 1);
             $this->db->where("contract_stage_id", $last_id);
             $this->db->select("contract_stage_id");
             $query = $this->db->get($tableName);
             $result = $query->result();

        }
       
    }

    function __destruct()
    {
        if (isset($this->db)) {
            $this->db->close(); // Explicitly close the DB connection
        }
    }
}