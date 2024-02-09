<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Session_Model extends CI_Model
{
	function __construct()
    {
        parent::__construct();
        
    }

    function generatesession()
    {
        $postData = $this->input->post();
        $sessionName = $postData['sessionName'];
        $stageData = array();
        $sessionArray = array();
        
        //print_r($postData);
        if(isset($_SESSION['sessionName']))
        {
           // echo "if";
            
             if($postData['action']=='acceptstage')
             {
               if(isset($_SESSION['acceptstage']))
               {
                $stageData = array(
                      'rowId'  => $postData['rowId'],
                      'stage'     => $postData['stage'],
                      'stage_text'     => $postData['stage_text'],
                      'date' => $postData['date'],
                      'quantity' => $postData['quantity'],
                      'amount' => $postData['amount']
                );
                foreach($_SESSION['acceptstage'] as $stage => $rowId)
                {
                   //echo "asas".$rowId['databaseId'];
                    if(isset($rowId['databaseId']) && !empty($rowId['databaseId']) && $rowId['rowId']==$postData['rowId'])
                    {
                        //echo "dsdsd";
                       $stageData['databaseId'] = $rowId['databaseId'];
                    }
                   // if($stage[$rowId]==$postData['rowId'])
                     if($rowId['rowId']==$postData['rowId'])
                    {
                         unset($_SESSION['acceptstage'][$postData['rowId']]);
                    }
                }
               
                $_SESSION['acceptstage'][$postData['rowId']] = $stageData;
               //array_push($_SESSION['acceptstage'], $stageData); 

               }
               else
               {
                    $_SESSION['acceptstage'] = array();
               }
                
               //$_SESSION['sessionName']['acceptstage'] = $stageData;
               //array_push($_SESSION['sessionName'], $_SESSION['acceptstage']); 
             }
             if($postData['action']=='deletestage')
             {
                    //unset($_SESSION['acceptstage'][$postData['rowId']]);  -- earlier code

                 foreach($_SESSION['acceptstage'] as $stage => $rowId)
                {
                   
                  
            if(isset($rowId['databaseId']) && !empty($rowId['databaseId']))                   
             {
               
                //$_SESSION['acceptstage'][$postData['rowId']]['deleteId'] = $postData['rowId'];
               
                 $stageData = array(
                      'rowId'  => $rowId['rowId'],
                      'stage'     => $rowId['stage'],
                      'stage_text'     => $rowId['stage_text'],
                      'date' => $rowId['date'],
                      'quantity' => $rowId['quantity'],
                      'amount' => $rowId['amount'],
                      'deleteId' => $rowId['databaseId']
                );
                
                if($rowId['rowId']==$postData['rowId'])
                {
                     unset($_SESSION['acceptstage'][$postData['rowId']]);
                }
             //   $_SESSION['acceptstage'][$postData['rowId']] = $stageData;
            }
            else
            {
               
                unset($_SESSION['acceptstage'][$postData['rowId']]);

            }
                }
               
             
             }
             if($postData['action']=='acceptregion')
             {

              if(isset($_SESSION['acceptregion']))
               {
                $stageData = array(
                      'rowId'  => $postData['rowId'],
                      'region'     => $postData['region'],
                      'region_text'     => $postData['region_text'],
                      'circle' => $postData['circle'],
                      'circle_text' => $postData['circle_text'],
                      'division' => $postData['division'],
                      'division_text' => $postData['division_text'],
                      'location' => $postData['location'],
                      'feedername' => $postData['feedername'],
                      'feederid' => $postData['feederid'],
                      'projectid' => $postData['projectid'],
                      'geocode' => $postData['geocode'],
                      'quantity' => $postData['quantity'],
                      // 'boq' => $postData['boq']
                );
                foreach($_SESSION['acceptregion'] as $stage => $rowId)
                {

                     if(isset($rowId['databaseId']) && !empty($rowId['databaseId']) && $rowId['rowId']==$postData['rowId'])
                    { 
                        //echo "dsdsd";
                       $stageData['databaseId'] = $rowId['databaseId'];
                    }
                    //if($stage[$rowId]==$postData['rowId'])
                    if($rowId['rowId']==$postData['rowId'])
                    {
                         unset($_SESSION['acceptregion'][$postData['rowId']]);
                    }
                }
                
                $_SESSION['acceptregion'][$postData['rowId']] = $stageData;
               //array_push($_SESSION['acceptstage'], $stageData); 

               }
               else
               {
                    $_SESSION['acceptregion'] = array();
               }

             }
             if($postData['action']=='deleteregion')
             {
                    //unset($_SESSION['acceptregion'][$postData['rowId']]);

                foreach($_SESSION['acceptregion'] as $stage => $rowId)
                {
                   
                  
            if(isset($rowId['databaseId']) && !empty($rowId['databaseId']))                   
             {
               
                //$_SESSION['acceptstage'][$postData['rowId']]['deleteId'] = $postData['rowId'];
               
                 $stageData = array(
                      'rowId'  => $rowId['rowId'],
                      'region'     => $rowId['region'],
                      'region_text'     => $rowId['region_text'],
                      'circle' => $rowId['circle'],
                      'circle_text' => $rowId['circle_text'],
                      'division' => $rowId['division'],
                      'division_text' => $rowId['division_text'],
                      'location' => $rowId['location'],
                      'feedername' => $rowId['feedername'],
                      'feederid' => $rowId['feederid'],
                      'projectid' => $postData['projectid'],
                      'geocode' => $rowId['geocode'],
                      'quantity' => $rowId['quantity'],
                      'boq' => $rowId['boq'],
                      'deleteId' => $rowId['databaseId']
                );
                
                if($rowId['rowId']==$postData['rowId'])
                {
                     unset($_SESSION['acceptregion'][$postData['rowId']]);
                }
               // $_SESSION['acceptregion'][$postData['rowId']] = $stageData;
            }
            else
            {
               
                unset($_SESSION['acceptregion'][$postData['rowId']]);

            }
                }
             }

             if($postData['action']=='acceptmaterial')
             {
                 if(isset($_SESSION['acceptmaterial']))
               {
                $stageData = array(
                      'rowId'  => $postData['rowId'],
                      'sr_no'     => $postData['sr_no'],
                      'equipment_material_name'     => $postData['equipment_material_name'],
                      'unit_id' => $postData['unit_id'],
                      'unit_text' => $postData['unit_text'],
                      'total_quantity' => $postData['total_quantity']
                );
                foreach($_SESSION['acceptmaterial'] as $material => $rowId)
                {

                    if(isset($rowId['databaseId']) && !empty($rowId['databaseId']) && $rowId['rowId']==$postData['rowId'])
                    { 
                        //echo "dsdsd";
                       $stageData['databaseId'] = $rowId['databaseId'];
                    }

                    //if($material[$rowId]==$postData['rowId'])
                    if($rowId['rowId']==$postData['rowId'])
                    {
                         unset($_SESSION['acceptmaterial'][$postData['rowId']]);
                    }
                }
                
                $_SESSION['acceptmaterial'][$postData['rowId']] = $stageData;
               //array_push($_SESSION['acceptstage'], $stageData); 

               }
               else
               {
                    $_SESSION['acceptmaterial'] = array();
               }
             }
             if($postData['action']=='deletematerial')
             {
                    //unset($_SESSION['acceptmaterial'][$postData['rowId']]);


                    foreach($_SESSION['acceptmaterial'] as $stage => $rowId)
                {
                   
                  
            if(isset($rowId['databaseId']) && !empty($rowId['databaseId']))                   
             {
               
                //$_SESSION['acceptstage'][$postData['rowId']]['deleteId'] = $postData['rowId'];
               
                 $stageData = array(
                      'rowId'  => $rowId['rowId'],
                      'sr_no'     => $rowId['sr_no'],
                      'equipment_material_name'     => $rowId['equipment_material_name'],
                      'unit_id' => $rowId['unit_id'],
                      'unit_text' => $rowId['unit_text'],
                      'total_quantity' => $rowId['total_quantity'],
                      'deleteId' => $rowId['databaseId']
                );
                
                if($rowId['rowId']==$postData['rowId'])
                {
                     unset($_SESSION['acceptmaterial'][$postData['rowId']]);
                }
              //  $_SESSION['acceptmaterial'][$postData['rowId']] = $stageData;
            }
            else
            {
               
                unset($_SESSION['acceptmaterial'][$postData['rowId']]);

            }
                }

             }

              if($postData['action']=='acceptmobilisation')
             {
                 if(isset($_SESSION['acceptmobilisation']))
               {
                $mobilisationData = array(
                      'rowId'  => $postData['rowId'],
                      //'sr_no'     => $postData['sr_no'],
                      'mobilisation_type'     => $postData['mobilisation_type'],
                      'mobilisation_text' => $postData['mobilisation_text'],
                      'invoice_no' => $postData['invoice_no'],
                      'invoice_date' => $postData['invoice_date'],
                      'advance_amount' => $postData['advance_amount'],
                      'date_of_payment' => $postData['date_of_payment'],
                      'advance_adjusted' => $postData['advance_adjusted']

                );
                foreach($_SESSION['acceptmobilisation'] as $mobilisation => $rowId)
                {

                     if(isset($rowId['databaseId']) && !empty($rowId['databaseId']) && $rowId['rowId']==$postData['rowId'])
                    { 
                        //echo "dsdsd";
                       $mobilisationData['databaseId'] = $rowId['databaseId'];
                    }

                    //if($mobilisation[$rowId]==$postData['rowId'])
                    if($rowId['rowId']==$postData['rowId'])
                    {
                         unset($_SESSION['acceptmobilisation'][$postData['rowId']]);
                    }
                }
                
                $_SESSION['acceptmobilisation'][$postData['rowId']] = $mobilisationData;
               //array_push($_SESSION['acceptstage'], $stageData); 

               }
               else
               {
                    $_SESSION['acceptmobilisation'] = array();
               }
             }
             if($postData['action']=='deletemobilisation')
             {
                    //unset($_SESSION['acceptmobilisation'][$postData['rowId']]);


                    foreach($_SESSION['acceptmobilisation'] as $stage => $rowId)
                {
                   
                  
            if(isset($rowId['databaseId']) && !empty($rowId['databaseId']))                   
             {
               
                //$_SESSION['acceptstage'][$postData['rowId']]['deleteId'] = $postData['rowId'];
               
                 $mobilisationData = array(
                      'rowId'  => $rowId['rowId'],
                      //'sr_no'     => $rowId['sr_no'],
                      'mobilisation_type'     => $rowId['mobilisation_type'],
                      'mobilisation_text' => $rowId['mobilisation_text'],
                      'invoice_no' => $rowId['invoice_no'],
                      'invoice_date' => $rowId['invoice_date'],
                      'advance_amount' => $rowId['advance_amount'],
                      'date_of_payment' => $rowId['date_of_payment'],
                      'advance_adjusted' => $rowId['advance_adjusted'],
                      'deleteId' => $rowId['databaseId']

                );
                
                if($rowId['rowId']==$postData['rowId'])
                {
                     unset($_SESSION['acceptmobilisation'][$postData['rowId']]);
                }
                //$_SESSION['acceptmobilisation'][$postData['rowId']] = $mobilisationData;
            }
            else
            {
               
                unset($_SESSION['acceptmobilisation'][$postData['rowId']]);

            }
                }

             }

             if($postData['action']=='acceptbank')
             {
                 if(isset($_SESSION['acceptbank']))
               {
                $bankData = array(
                      'rowId'  => $postData['rowId'],
                      //'sr_no'     => $postData['sr_no'],
                      'bank_id'     => $postData['bank_id'],
                      'bank_text' => $postData['bank_text'],
                      'bg_no' => $postData['bg_no'],
                      'bg_date' => $postData['bg_date'],
                      'bg_amount' => $postData['bg_amount'],
                      'bank' => $postData['bank'],
                      'bg_till_date' => $postData['bg_till_date']

                );
                foreach($_SESSION['acceptbank'] as $bank => $rowId)
                {


                     if(isset($rowId['databaseId']) && !empty($rowId['databaseId']) && $rowId['rowId']==$postData['rowId'])
                    { 
                        //echo "dsdsd";
                       $bankData['databaseId'] = $rowId['databaseId'];
                    }
                    
                    //if($bank[$rowId]==$postData['rowId'])
                    if($rowId['rowId']==$postData['rowId'])
                    {
                         unset($_SESSION['acceptbank'][$postData['rowId']]);
                    }
                }
                
                $_SESSION['acceptbank'][$postData['rowId']] = $bankData;
               //array_push($_SESSION['acceptstage'], $stageData); 

               }
               else
               {
                    $_SESSION['acceptbank'] = array();
               }
             }

              if($postData['action']=='deletebank')
             {
                    //unset($_SESSION['acceptbank'][$postData['rowId']]);

                foreach($_SESSION['acceptbank'] as $stage => $rowId)
                {
                   
                  
            if(isset($rowId['databaseId']) && !empty($rowId['databaseId']))                   
             {
               
                //$_SESSION['acceptstage'][$postData['rowId']]['deleteId'] = $postData['rowId'];
               
                 $bankData = array(
                      'rowId'  => $rowId['rowId'],
                      //'sr_no'     => $rowId['sr_no'],
                      'bank_id'     => $rowId['bank_id'],
                      'bank_text' => $rowId['bank_text'],
                      'bg_no' => $rowId['bg_no'],
                      'bg_date' => $rowId['bg_date'],
                      'bg_amount' => $rowId['bg_amount'],
                      'bank' => $rowId['bank'],
                      'bg_till_date' => $rowId['bg_till_date'],
                      'deleteId' => $rowId['databaseId']

                );
                
                if($rowId['rowId']==$postData['rowId'])
                {
                     unset($_SESSION['acceptbank'][$postData['rowId']]);
                }
               // $_SESSION['acceptbank'][$postData['rowId']] = $bankData;
            }
            else
            {
               
                unset($_SESSION['acceptbank'][$postData['rowId']]);

            }
                }


             }

        }
        else
        {
            $_SESSION['sessionName'] = array();
            echo "else";
            $_SESSION['sessionName'] = $sessionName;
        }
       


       
    }

    public function viewsession()
    {
       //echo "hii";
        echo '<pre>';
        // print_r($this->session->userdata('sessionName')); die;
        print_r($_SESSION); die;
    }

    public function destroysession()
    {
       unset($_SESSION['acceptstage']); 
    }
}