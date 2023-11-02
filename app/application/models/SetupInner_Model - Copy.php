<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class SetupInner_Model extends CI_Model
{
	function __construct()
    {
        parent::__construct();

    }


     function insertMilestones($mileStones, $last_id, $actionItem)
    {
        try
        {
            $dom = new DOMDocument();
            $dom->loadHtml($mileStones);
            $x = new DOMXpath($dom);
            $i=0;
            $mainArray = array();
          // echo $last_id; die;
            
            foreach($x->query('//tr') as $td){
				
				if($actionItem == "insert")	
				{
					$insertContractMilestone = array("contract_id"=>$last_id);
					$this->db->insert("contract_milestone", $insertContractMilestone);
					$lastInsertIdOfContractMilestone = $this->db->insert_id();
				}
                

				//echo $columnValue = $td->C14N()." ";
                //if just need the text use:

              $columnValue = trim($td->textContent);
          
                $explodeString = explode(" ", $columnValue);
				//print_r($explodeString); die;
                $insertArray = array();
                $j=0;
                foreach($explodeString as $str)
                {
                    if($i>0)
                    {
                        //echo $str;
                    
                        //$insertArray['contract_id'] = $last_id;
                        if($j==0)
                        {
                           $insertArray['milestone_id'] = $str;                      
                        }
                        else if($j==48)
                        {
                           $insertArray['date'] = date ('Y-m-d H:i:s', strtotime($str));
                        }
                        else if($j==72)
                        {
                           $insertArray['quantity'] = $str;
                        }
                       else  if($j==96)
                        {
                           $insertArray['amount'] = $str;
                        }
                        
                    }
                   
                     $j++;
                }
              
               
                $i++;
                //print_r($insertArray); die;
                $this->db->where("contract_milestone_id", $lastInsertIdOfContractMilestone);
                $query = $this->db->update("contract_milestone", $insertArray);
                if($query)
                {
                    return true;
                }


        }
       
        }
         catch (Exception $e)
        {
            
            log_message('error: ',$e->getMessage());
            
            return;
        }

       
        
        
    }
	
	
	
	
	function insertRegions($regions, $last_id, $actionItem)
    {
		//echo $regions;
        try
        {
            $dom = new DOMDocument();
            $dom->loadHtml($regions);
            $x = new DOMXpath($dom);
            $i=0;
            $mainArray = array();
           
            
            foreach($x->query('//tr') as $td){
				if($actionItem == "insert")	
				{
				   $insertContractRegion = array("contract_id"=>$last_id);
				   $this->db->insert("contract_location", $insertContractRegion);
				   $lastInsertIdOfContractRegion = $this->db->insert_id();
				}

            // echo $columnValue = $td->C14N()." ";
                //if just need the text use:

              $columnValue = trim($td->textContent);
          
                $explodeString = explode(" ", $columnValue);
								//print_r($explodeString); die;

                $insertArray = array();
                $j=0;
                foreach($explodeString as $str)
                {
                    if($i>0)
                    {
                        //echo $str;
                    
                        $insertArray['contract_id'] = $last_id;
                        if($j==24)
                        {
                           $insertArray['region_id'] = $str;                      
                        }
                        else if($j==48)
                        {
                           $insertArray['circle_id'] = $str;
                        }
                        else if($j==72)
                        {
                           $insertArray['division_id'] = $str;
                        }
                       else  if($j==96)
                        {
                           $insertArray['location_name'] = $str;
                        }
					   else  if($j==121)
                        {
                           $insertArray['geo_code'] = $str;
                        }
						else  if($j==145)
                        {
                           $insertArray['quantity'] = $str;
                        }
                        
                    }
                   
                     $j++;
                }
               
                $i++;
				              

				
                $this->db->where("contract_id", $lastInsertIdOfContractRegion);
                $query = $this->db->update("contract_location", $insertArray);
                if($query)
                {
                    return true;
                }
				

        }
		// print_r($insertArray);
		//die;
        }
         catch (Exception $e)
        {
            
            log_message('error: ',$e->getMessage());
            
            return;
        } 
        
    }


	 function insertInstallations($insertInstallations, $last_id, $actionItem)
    {
        try
        {
            $dom = new DOMDocument();
            $dom->loadHtml($insertInstallations);
            $x = new DOMXpath($dom);
            $i=0;
            $mainArray = array();
           
            
            foreach($x->query('//tr') as $td){
				
				if($actionItem == "insert")	
				{
				   $insertContractInstallation = array("contract_id"=>$last_id);
				   $this->db->insert("contract_boq", $insertContractInstallation);
				   $lastInsertIdOfContractInstallation = $this->db->insert_id();
				}  

            //  echo $columnValue = $td->C14N()." ";
                //if just need the text use:

              $columnValue = trim($td->textContent);
          
                $explodeString = explode(" ", $columnValue);
              // print_r($explodeString); die;
                $insertArray = array();
                $j=0;
                foreach($explodeString as $str)
                {
                    if($i>0)
                    {
                       // echo $str;
                    
                        $insertArray['contract_id'] = $last_id;
                        if($j==0)
                        {
                           $insertArray['sr_no'] = $str;                      
                        }
                        else if($j==24)
                        {
                           $insertArray['equipment_material_name'] = $str;
                        }
                        else if($j==48)
                        {
                           $insertArray['unit_id'] = $str;
                        }
                       else  if($j==72)
                        {
                           $insertArray['quantity'] = $str;
                        }
                        
                    }
                   
                     $j++;
                }
               // print_r($insertArray);
               
                $i++;
              
                $this->db->where("contract_id", $lastInsertIdOfContractInstallation);
                $query = $this->db->update("contract_boq", $insertArray);
                if($query)
                {
                    return true;
                }


        }
       
        }
         catch (Exception $e)
        {
            
            log_message('error: ',$e->getMessage());
            
            return;
        }
    
    }
	
	
	function insertBanks($banks, $last_id, $actionItem)
    {
		
        try
        {
            $dom = new DOMDocument();
            $dom->loadHtml($banks);
            $x = new DOMXpath($dom);
            $i=0;
            $mainArray = array();
           
            
            foreach($x->query('//tr') as $td){
				
				if($actionItem == "insert")	
				{
				   $insertContractBank = array("contract_id"=>$last_id);
				   $this->db->insert("contract_bg", $insertContractBank);
				   $lastInsertIdOfContractBank = $this->db->insert_id();
				}

            // echo $columnValue = $td->C14N()." ";
                //if just need the text use:

              $columnValue = trim($td->textContent);
          
                $explodeString = explode(" ", $columnValue);
				
				//print_r($explodeString);die;
                $insertArray = array();
                $j=0;
                foreach($explodeString as $str)
                {
                    if($i>0)
                    {
                        //echo $str;
                    
                        $insertArray['contract_id'] = $last_id;
                        if($j==0)
                        {
                           $insertArray['sr_no'] = $str;                      
                        }
                        else if($j==24)
                        {
                           $insertArray['bg_type_id'] = $str;
                        }
                        else if($j==48)
                        {
                           $insertArray['bg_number'] = $str;
                        }
                       else  if($j==72)
                        {
                           $insertArray['bg_date'] = date ('Y-m-d H:i:s', strtotime($str));
                        }
					   else  if($j==96)
                        {
                           $insertArray['bg_amount'] = $str;
                        }
						else  if($j==121)
                        {
                           $insertArray['bg_valid_till'] = date ('Y-m-d H:i:s', strtotime($str));
                        }
                        
                    }
                   
                     $j++;
                }
               
                $i++;
				              

				
                $this->db->where("contract_id", $lastInsertIdOfContractBank);
                $query = $this->db->update("contract_bg", $insertArray);
                if($query)
                {
                    return true;
                }
				

        }
		// print_r($insertArray);
		//die;
        }
         catch (Exception $e)
        {
            
            log_message('error: ',$e->getMessage());
            
            return;
        } 
        
    }

}