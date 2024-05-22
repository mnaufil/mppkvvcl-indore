<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Dashboard_Model extends CI_Model
{
    function __construct()
    {
        parent::__construct();       
    }

    function physicalprogress($date, $contractor, $type_of_work)
    {
        $userId = $_SESSION['userId'];

        $query = $this->db->query("CALL sp_get_dashboard_physical_progress($userId, '$date', $contractor, $type_of_work)");
        // echo $this->db->last_query(); die();
        
        if($query)
        {
            return $query->result();    
        }
    }

    function statistics($mileStoneId)
    {
        //$query = $this->db->query("CALL sp_get_dashboard_statistics($mileStoneId, 1)");
        // $query = $this->db->query("CALL sp_get_dashboard_statistics(1, null)"); //Original Code
        $query = $this->db->query("CALL sp_get_dashboard_statisticsCombineLot(1, null)");
        if($query)
        {
            return $query->result();
        }
    }
   
    // function showgraph($packageNo)
    function showgraph($packageNo, $stage_id)
    {
        $userId = $_SESSION['userId'];
        // $query = $this->db->query("CALL sp_get_dashboard_statistics_popup_graph($userId, '$packageNo')"); /*Original Code*/
        $query = $this->db->query("CALL sp_get_dashboard_statistics_popup_graphCombineLot(".$userId.", ".$packageNo.", ".$stage_id.")");
        // $query = $this->db->query("CALL bkp_sk_sp_get_dashboard_statistics_popup_graphCombineLot(".$userId.", ".$packageNo.", ".$stage_id.")");
        // echo $this->db->last_query(); die();
        if($query)
        {
            $result  = $query->result();
        }
        $mainArray = array();
        $packageActualArray = array();
        $packageTargetArray = array();
        $financeActualArray = array();
        $financeTargetArray = array();
        $labelArray = array();
        foreach($result as $res)
        {
            if(!empty($res->month))
            {
                $date = date('M-y', strtotime($res->month));
                array_push($labelArray, $date);
            }
            array_push($packageActualArray, ($res->quantity_cummulative_actual != '') ? $res->quantity_cummulative_actual : 0);
            array_push($packageTargetArray, ($res->quantity_cummulative_target != '') ? $res->quantity_cummulative_target : 0);
            array_push($financeActualArray, ($res->financial_cummulative_actual != '') ? $res->financial_cummulative_actual : 0);
            array_push($financeTargetArray, ($res->financial_cummulative_target != '') ? $res->financial_cummulative_target : 0);
        }

        $mainArray['labelArray'] = $labelArray;
        $mainArray['packageActualArray'] = $packageActualArray;
        $mainArray['packageTargetArray'] = $packageTargetArray;
        $mainArray['financeActualArray'] = $financeActualArray;
        $mainArray['financeTargetArray'] = $financeTargetArray;
        echo json_encode($mainArray);
    }    

    function loadStagesDash()
    {
        //$this->db->where("is_active", 1);
        $query = $this->db->get("mst_stage");

        if($query->num_rows() > 0) {
            $result = $query->result();
        }

        return $result;
    }
    
    function getContractId($packageNo)
    {
        $this->db->where("package_no", $packageNo);
        $query = $this->db->get("contract");
        $result = $query->row();
        return  $result->contract_id;
    }    
    
    public function getlocations($packageNo)
    {
        $contract_id = $this->getContractId($packageNo);
        $regions = implode(",",$_SESSION['myRegions']); 
        $this->db->select('mst_typeofwork.name as t_name, contract.tender_award_no, `contract`.`typeofwork_id`, `contract`.`contractor_name`,contract_location.*,mst_region.region_name, mst_circle.circle_name, mst_division.division_name, `mst_status`.`name`, `physical_progress`.`physical_progress_id`');
        //$this->db->where_in("contract_location.region_id", $regions);
        $this->db->where("physical_progress.contract_id", $contract_id);
        // $this->db->or_where("mst_status.status_id", 5);      
        $this->db->from('physical_progress');
        $this->db->join('contract_location', 'contract_location.contract_location_id  = physical_progress.contract_location_id', 'inner');
        $this->db->join('mst_region', 'mst_region.region_id  = contract_location.region_id', 'inner');
        $this->db->join('mst_circle', 'mst_circle.circle_id  = contract_location.circle_id', 'inner');
        $this->db->join('mst_division', 'mst_division.division_id  = contract_location.division_id', 'inner');
        $this->db->join('mst_status', 'mst_status.status_id  = physical_progress.status_id', 'inner');
        $this->db->join('contract', 'contract.contract_id  = physical_progress.contract_id', 'inner');
         $this->db->join('mst_typeofwork', 'mst_typeofwork.typeofwork_id  = contract.typeofwork_id', 'inner');
        $query = $this->db->get();
        //echo $this->db->last_query(); die;
        $result = $query->result();
        
        $html = "";
        
        foreach($result as $res)
        {
            $mode = "";
            $action_btn = '';
            $status_color = '';
            if($res->name=="Open")
            {
                $mode = "edit-new";
                $action_btn = 'fe fe-edit';
                $status_color = 'text-gray';
            }
            else if($res->name=="In Process")
            {
                $mode = "edit-prev";
                $action_btn = 'fe fe-edit';
                $status_color = 'text-yellow';
            }
            else if ($res->name=="Reviewed")
            {
                $mode = "view";
                $action_btn = 'fa fa-eye';
                $status_color = 'text-blue';   
            }
            else if($res->name=="Completed")
            {
                $mode = "view";
                $action_btn = 'fa fa-eye';
                $status_color = 'text-green';
            }
            
            $myUrl = base_url('add-physical-progress')."/".$mode."/".$res->physical_progress_id."/".$res->contract_id."/".$res->contract_location_id;
            
            /*$html .=    '<tr>
                            <td>'.$res->tender_award_no.'</td>
                            <td>'.$res->contractor_name.'</td>
                            <td>'.$res->t_name.'</td>
                            <td>'.$res->region_name.'</td>
                            <td>'.$res->circle_name.'</td>
                            <td>'.$res->division_name.'</td>
                            <td>'.$res->location_name.'</td>
                            <td>'.$res->feeder_id.'</td>
                            <td class="'.$status_color.'">'.$res->name.'</td>
                            <td>
                                <a target="_blank" href="'.$myUrl.'" id="bEdit" type="button" class="btn btn-sm " style="">
                                    <span class="'.$action_btn.' fa-lg action-btn-table"></span>
                                </a>
                            </td>
                        </tr>';*/
            $html .=    '<tr>
                            <td>'.$res->region_name.'</td>
                            <td>'.$res->circle_name.'</td>
                            <td>'.$res->division_name.'</td>
                            <td>'.$res->location_name.'</td>
                            <td>'.$res->feeder_id.'</td>
                            <td class="'.$status_color.'">'.$res->name.'</td>
                            <td>
                                <a target="_blank" href="'.$myUrl.'" id="bEdit" type="button" class="btn btn-sm " style="">
                                    <span class="'.$action_btn.' fa-lg action-btn-table"></span>
                                </a>
                            </td>
                        </tr>';
        }

        echo  $html;
    }

    public function getlocationsfilter($packageNo, $regionId, $circleId, $divisionId)
    {
        $contract_id = $this->getContractId($packageNo);
            
        $this->db->select('contract_location.*,mst_region.region_name, mst_circle.circle_name, mst_division.division_name, `mst_status`.`name`, `physical_progress`.`physical_progress_id`');

        if ($regionId != 'null') {
            $this->db->where("mst_region.region_id", $regionId);    
        }

        if ($circleId != 'null') {
            $this->db->where("mst_circle.circle_id", $circleId);    
        }

        if ($divisionId != 'null') {
            $this->db->where("mst_division.division_id", $divisionId);    
        }

        $this->db->where("physical_progress.contract_id", $contract_id);
        // $this->db->or_where("mst_status.status_id", 5);     
        $this->db->from('physical_progress');
        $this->db->join('contract_location', 'contract_location.contract_location_id  = physical_progress.contract_location_id', 'inner');
        $this->db->join('mst_region', 'mst_region.region_id  = contract_location.region_id', 'inner');
        $this->db->join('mst_circle', 'mst_circle.circle_id  = contract_location.circle_id', 'inner');
        $this->db->join('mst_division', 'mst_division.division_id  = contract_location.division_id', 'inner');
        $this->db->join('mst_status', 'mst_status.status_id  = physical_progress.status_id', 'inner');
        $query = $this->db->get();
        // echo $this->db->last_query(); die;
        $result = $query->result();
        
        $html = "";

        if (!empty($result)) {
            foreach($result as $res)
            {
                $mode = "";
                $action_btn = '';
                $status_color = '';
                if($res->name=="Open")
                {
                    $mode = "edit-new";
                    $action_btn = 'fe fe-edit';
                    $status_color = 'text-gray';
                }
                else if($res->name=="In Process")
                {
                    $mode = "edit-prev";
                    $action_btn = 'fe fe-edit';
                    $status_color = 'text-yellow';
                }
                else if ($res->name=="Reviewed")
                {
                    $mode = "view";
                    $action_btn = 'fa fa-eye';
                    $status_color = 'text-blue';   
                }
                else if($res->name=="Completed")
                {
                    $mode = "view";
                    $action_btn = 'fa fa-eye';
                    $status_color = 'text-green';
                }
                
                $myUrl = base_url('add-physical-progress')."/".$mode."/".$res->physical_progress_id."/".$res->contract_id."/".$res->contract_location_id;
                
                $html .=    '<tr>
                                <td>'.$res->region_name.'</td>
                                <td>'.$res->circle_name.'</td>
                                <td>'.$res->division_name.'</td>
                                <td>'.$res->location_name.'</td>
                                <td>'.$res->feeder_id.'</td>
                                <td class="'.$status_color.'">'.$res->name.'</td>
                                <td>
                                    <a target="_blank" href="'.$myUrl.'" id="bEdit" type="button" class="btn btn-sm " style="">
                                        <span class="'.$action_btn.' fa-lg action-btn-table"></span>
                                    </a>
                                </td>
                            </tr>';
            }    
        } else {
            $html .= '<tr style="text-align:center"> <td colspan=7> No Records Found </td> </tr>';
        }

        echo  $html;
    }

    public function GetMultipleQueryResultNew($queryString)
    {
        if (empty($queryString)) {
            return false;
        }

        $index     = 0;
        $ResultSet = array();

        /* execute multi query */
        if (mysqli_multi_query($this->db->conn_id, $queryString)) 
        {
            /* do {
                if ($result = mysqli_store_result($this->db->conn_id)) {
                    $rowID = 0;
              
                    while ($row = $result->fetch_assoc()) {
                        $ResultSet[$index][$rowID] = $row;
                        //$ResultSet[$index] = $row;
                        $rowID++;
                    }
                }
                $index++;
            } while (mysqli_next_result($this->db->conn_id));*/

            while ($result = mysqli_next_result($this->db->conn_id))
            {
                $rowID = 0;
              
                while ($row = $result->fetch_assoc()) {
                    $ResultSet[$index][$rowID] = $row;
                    //$ResultSet[$index] = $row;
                    $rowID++;
                }

                $index++;
            }
        }
        return $ResultSet;
    }

    public function GetMultipleQueryResult($queryString)
    {
        // echo 'queryString: <pre>'; print_r($queryString); echo '</pre>';
        if (empty($queryString)) {
            return false;
        }

        $index = 0;
        $ResultSet = array();

        /* execute multi query */
        if (mysqli_multi_query($this->db->conn_id, $queryString)) {
            do {
                if (false != $result = mysqli_store_result($this->db->conn_id)) {
                    $rowID = 0;
                    while ($row = $result->fetch_assoc()) {
                        $ResultSet[$index][$rowID] = $row;
                        // $ResultSet[$index] = $row; /*Original Code*/
                        // $ResultSet[$rowID] = $row;
                        // echo 'ResultSet: <pre>'; print_r($ResultSet); echo '</pre>';
                        $rowID++;
                    }
                }

                $index++;
            } while (mysqli_next_result($this->db->conn_id));
        }

        return $ResultSet;
    }    
    
    // public function statisticspopup($packageNo, $contractId)
    public function statisticspopup($packageNo, $stage)
    {
        $user_id = $_SESSION['loggedData']->user_id;
        // $result = $this->GetMultipleQueryResult("call sp_get_dashboard_statistics_popup(1,'$contractId','week',NULL, NULL,1)"); //Original
        // $result = $this->GetMultipleQueryResult("call sp_get_dashboard_statistics_popup(1,'$packageNo','week',NULL, NULL,1)");
        $result = $this->GetMultipleQueryResult("CALL sp_get_combineLot_dashboard_statistics_popup(".$user_id.", ".$packageNo.", 'week', NULL, NULL, ".$stage.")");

        // $result_multiple = $this->GetMultipleQueryResult("call sp_get_dashboard_statistics_popup_weekdate_stage($contractId)");       
        
        //$result = $this->GetMultipleQueryResult("call sp_get_dashboard_statistics_popup(1,'102','month',NULL, NULL,NULL)");
        $allValues = $result[1];
        $allKeys = array_keys($result[1][0]);
        $mainHeaders = array();
        $mainHeadersWithUnderscores = array();
        $mainHeadersWithoutPercent = array();
        //$weekOrMonth = "month_";
        $weekOrMonth = "week_";
        $stage = explode("_", $allKeys[1]);
        // $stageDropdown = $this->stagePopup($contractId, $stage[1]); /*Original Code*/
        $stageDropdown = $this->stagePopup($packageNo, $stage[1]);

        foreach($allKeys as $keys)
        {
            if(str_contains($keys, $weekOrMonth))
            {
                $explode = explode($weekOrMonth, $keys);  
                array_push($mainHeaders, $explode[1]);
            }
        }

        foreach($mainHeaders as $main)
        {
            if(str_contains($main, "_"))
            {
                $explode1 = explode("_", $main);  
                array_push($mainHeadersWithUnderscores, $explode1[0]);
            }
        }

        $mainHeadersWithUnderscores = $mainHeaders;

        $headers = $week_headers = $cummulative_headers = [];
        foreach($allKeys as $per)
        {
            if(!str_contains($per, "Percent"))
            {
                if (!str_contains($per, 'week_') && !str_contains($per, 'Cummulative_')) {
                    array_push($headers, $per);
                }

                if (str_contains($per, 'week_')) {
                    array_push($week_headers, $per);
                }

                if (str_contains($per, 'Cummulative_')) {
                    array_push($cummulative_headers, $per);
                }
                // array_push($mainHeadersWithoutPercent, $per);
            }           
        }

        $mainHeadersWithoutPercent = array_merge($headers, $week_headers, $cummulative_headers);
        
        $mainTd = "";
        
        $colsPan = count($mainHeadersWithUnderscores)*2;
        for($i=0; $i< count($mainHeadersWithUnderscores);$i++)
        {
            $mainTd .=  '<td align="center">'.$mainHeadersWithUnderscores[$i].'</td>';
            //$mainTd .=  '<td>'.$mainHeadersWithUnderscores[$i].' % </td>'; -- removed
        }

        for($j=0; $j< count($mainHeadersWithUnderscores);$j++)
        {
            $mainTd .=  '<td align="center">'.$mainHeadersWithUnderscores[$j].'</td>';
            $mainTd .=  '<td align="center">'.$mainHeadersWithUnderscores[$j].' % </td>';
        }
        
        $valueTd = "";
        $col = 1;
        foreach ($allValues as $all_key => $all_value) {
            $valueTd .= '<tr>';

            foreach ($mainHeadersWithoutPercent as $val) {
                if(!str_contains($val, "package_no") && !str_contains($val, "Stage") && !str_contains($val, "week") && !str_contains($val, "month"))
                {
                    $valueTd .= '<td align="center">'.$all_value[$val].'</td>';
                
                    // $valueTd .= '<td align="center">'.$allValues[$val.'_Percent'].'</td>'; //Original Code

                    if (isset($allValues[0][$val.'_Percent'])) {
                        $valueTd .= '<td align="center">'.$all_value[$val.'_Percent'].'</td>';
                    } else {
                        $valueTd .= '<td align="center">0.00%</td>';
                    }
                    /* if(!str_contains($val, "week") || !str_contains($val, "month"))
                    {
                        $valueTd .= '<td>'.$allValues[$val.'_Percent'].'</td>';
                    }*/            
                }
                else
                {
                    $valueTd .= '<td align="center">'.$all_value[$val].'</td>';
                }
            }

            $valueTd .= '<td>'.$all_value['Slippage_In_Percent'].'</td>';
            $valueTd .= '</tr>';
        }        
        
        //$weekDropdownWithDates = $this->getWeekDropdownDate($contractId);  
        // $weekDropdownWithDates = $this->getWeekDropdownDateLoad($contractId, $result[0]['week_or_month'], $stage[1]);  /*Original Code*/
        $weekDropdownWithDates = $this->getWeekDropdownDateLoad($packageNo, $result[0][0]['week_or_month'], $stage[1]);
        
        $weeklyMonthlyDropdown = "<select id='weekmonthselect' onchange='changeweekMonthVal(this.value)'>
         <option value='week'>Weekly</option>
        <option value='month'>Monthly</option>       
        </select>";
      
        $html = '<div class="modal-body">
                        <!-- Show a second modal and hide this one with the button below. -->
                        <div class="table-responsive">
                            <input type="hidden" id="packageNo" value="'.$packageNo.'">
                            <table class="table table-bordered border text-nowrap mb-0 table-striped change-font" id="new-edit-observations-details">
                                <thead>
                                    <tr style="background: #eee;">
                                        <th style="text-align: left !important;">Scheme Name</th>
                                        <th style="text-align: left !important;">'.$result[0][0]['scheme_name'].'</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>DISCOM</td>
                                        <td>'.$result[0][0]['discom'].'</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>TKC</td>
                                        <td>'.$result[0][0]['contractor_name'].'</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Award No</td>
                                        <td>'.$result[0][0]['award_no'].'</td>
                                        <td>Contract Value</td>
                                        <td>'.number_format($result[0][0]['contract_value']).'</td>
                                    </tr>
                                    <tr>
                                        <td>Stage</td>
                                        <td>'.$stageDropdown.'</td>
                                        <td># Feeders/SS</td>
                                        <td>'.$result[0][0]['no_of_feeders'].'</td>
                                    </tr>
                                    <tr>
                                        <td>Period</td>
                                        <td>'.$weeklyMonthlyDropdown.'<span id="weekMonthChange">'.$weekDropdownWithDates.'</span></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="table-responsive mt-4" >
                            <table class="table table-bordered border text-nowrap mb-0 change-font" id="showvalues">
                                <thead>
                                    <tr style="background: #eee;">
                                    <th style="border-right: 1px solid #c5c5c5;" align="center">Lot</th>
                                        <th style="border-right: 1px solid #c5c5c5;" align="center">Stage</th>
                                        <th colspan="'.($i).'" style="border-right: 1px solid #c5c5c5;">Weekly</th>
                                        <th colspan="'.($i * 2).'" style="border-right: 1px solid #c5c5c5;">Cummulative</th>
                                        <th>Slippage (%)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td align="center">Lot No</td>
                                        <td align="center">'.$stage[1].'</td>
                                        '.$mainTd.'
                                        <td></td>
                                    </tr>
                                    '.$valueTd.'
                                </tbody>
                            </table>
                        </div>
                    </div>';
        echo $html;
    }

    function getWeekDropdownDate($contractId)
    {        
        $weekOrMonthQuery2 = $this->db->query("CALL sp_get_dashboard_statistics_popup_weekdate($contractId)"); 
        $select = "";
        //$weekOrMonthQuery = $this->db->query("CALL sp_get_dashboard_statistics_popup_weekdate('102')"); 
        $select .= "<select id='weekdatedropdown' onchange='weekdatedropdown()'>";
        // $select  .='<option value="">Select week Range</option>';
        if($weekOrMonthQuery2)
        {                 
            $weekOrMonthResult =  $weekOrMonthQuery2->result();
            foreach($weekOrMonthResult as $res)
            {
                $select .= '<option value="'.$res->weekdate.'">'.$res->weekdate.'</option>';
            }                  
        }  
        
        return $select .= "</select>";
    }

    // function getWeekDropdownDateLoad($contractId, $weekRange, $stage) /*Original Code*/
    function getWeekDropdownDateLoad($packageNo, $weekRange, $stage)
    {
        $weekRangeNew = str_replace(".", "-", $weekRange);
        //$weekOrMonthQuery2 = $this->db->query("CALL sp_get_dashboard_statistics_popup_weekdate($contractId)"); 
        $stage = explode(" ", $stage);
        //$weekOrMonthQuery = $this->db->query("CALL sp_get_dashboard_statistics_popup_weekdate('102')"); 
        // $select = "<select id='weekdatedropdown' onclick='weekdatedropdownload(".$contractId.", ".$stage[1].")'>";
        $select = "<select id='weekdatedropdown' onclick='weekdatedropdownload(".$packageNo.", ".$stage[1].")'>";
        //print_r($weekOrMonthQuery); die;
        $select  .='<option value="'.$weekRangeNew.'">'.$weekRangeNew.'</option>';
        /*if($weekOrMonthQuery2)
        {
            $weekOrMonthResult =  $weekOrMonthQuery2->result();
            foreach($weekOrMonthResult as $res)
            {
                $select .= '<option value="'.$res->weekdate.'">'.$res->weekdate.'</option>';
            }                  
        }  */
        
        return $select .= "</select>";
    }

    // function weekdatedropdownload($contractId, $stage) /*Original Code*/
    function weekdatedropdownload($packageNo, $stage)
    {        
        // $weekOrMonthQuery2 = $this->db->query("CALL sp_get_dashboard_statistics_popup_weekdate($contractId, $stage)"); /*Original Code*/
        $weekOrMonthQuery2 = $this->db->query("CALL sp_get_dashboard_statistics_popup_weekdate($packageNo, $stage)"); 
       
        //$weekOrMonthQuery = $this->db->query("CALL sp_get_dashboard_statistics_popup_weekdate('102')"); 
        $select = "<select id='weekdatedropdown' onchange='weekdatedropdown()'>";
        // $select .='<option>Select week Range</option>';
        if($weekOrMonthQuery2)
        {
            $weekOrMonthResult =  $weekOrMonthQuery2->result();
            foreach($weekOrMonthResult as $res)
            {
                $select .= '<option value="'.$res->weekdate.'">'.$res->weekdate.'</option>';
            }     
        }  
        
        echo $select .= "</select>";
    }

    public function stagePopup($packageNo, $stage)
    {
        $stageDropdown = "";
        $userId = $_SESSION['userId'];
        // $stageQuery = $this->db->query("CALL sp_get_dashboard_statistics_popup_stage($userId, '$contractId')"); /*Original Code*/
        $stageQuery = $this->db->query("CALL bkp_sksp_get_dashboard_statistics_popup_stage(".$userId.", ".$packageNo.")");
        
        //$stageQuery = $this->db->query("CALL sp_get_dashboard_statistics_popup_stage('102')");
        if($stageQuery)
        {   
            $stageResult =  $stageQuery->result();
            /* $stageDropdown .= '<select id="stageChange" onchange="changeStage(this.value)"><option value="All">All</option>';*/
            $stageDropdown .= '<select id="stageChange" onchange="changeStage(this.value, '.$packageNo.')">';
            $selected = "";
            foreach($stageResult as $res)
            {
                // $string = str_replace(' ', '', strtolower($res->name));
                $string = $res->name;
              
                if($stage==$string)
                {
                    $stageDropdown .= '<option value="'.$res->name.'" selected>'.$res->name.'</option>';
                }
                else
                {
                    $stageDropdown .= '<option value="'.$res->name.'">'.$res->name.'</option>';
                }
            }

            return $stageDropdown .= '</select>';
        }
    }

    // public function changeweekmonthval($datevalue, $packageNo, $contract_id, $stage) /*Original Code*/
    public function changeweekmonthval($datevalue, $packageNo, $stage)
    {
        $stage1 = explode("%20", $stage);
        $stageId = $stage1[1];

        if($datevalue=="week")
        {
            // $weekOrMonthQuery = $this->db->query("CALL sp_get_dashboard_statistics_popup_weekdate('$contract_id', '$stageId')");  
            $weekOrMonthQuery = $this->db->query("CALL sp_get_dashboard_statistics_popup_weekdateCombineLot(".$packageNo.", ".$stageId.")"); 
            // echo $this->db->last_query() ; die();

            //$weekOrMonthQuery = $this->db->query("CALL sp_get_dashboard_statistics_popup_weekdate('102')"); 
            $select = "<select id='weekdatedropdown' onchange='weekdatedropdown()'>";

            if($weekOrMonthQuery)
            {
                $weekOrMonthResult =  $weekOrMonthQuery->result();
                foreach($weekOrMonthResult as $res)
                {
                    $select .= '<option value="'.$res->weekdate.'">'.$res->weekdate.'</option>';
                }

                echo $select .= "</select>";
            }
        }
    }

    // public function getweekdate($contract_id, $stage)
    public function getweekdate($packageNo, $stage)
    {
        $stage1 = explode("%20", $stage);
        $stageId = $stage1[1];
        
        // $weekOrMonthQuery = $this->db->query("CALL sp_get_dashboard_statistics_popup_monthdate('$contract_id', '$stageId')");  /*Original Code*/
        $weekOrMonthQuery = $this->db->query("CALL sp_get_dashboard_statistics_popup_monthdateCombineLot(".$packageNo.", ".$stageId.")");
        // echo $this->db->last_query(); die();

        //$weekOrMonthQuery = $this->db->query("CALL sp_get_dashboard_statistics_popup_weekdate('102')"); 
        $select = "<select id='weekdatedropdown' onchange='weekdatedropdown()'>";      

        if($weekOrMonthQuery)
        {                 
            $weekOrMonthResult =  $weekOrMonthQuery->result();
            echo json_encode($weekOrMonthResult); 
        }
    }

    public function formhtmltable()
    {
        $stageValue = @$_POST['stageValue'];        

        $weekmonthselect = @$_POST['weekmonthselect'];
        $userId = $_SESSION['userId'];
        $monthdate = @$_POST['monthdate'];

        if($monthdate=="")
        {
            $monthdate = 'NULL';
        }

        //$weekdatedropdown = @$_POST['weekdatedropdown'];
        $packageno = @$_POST['packageno'];

        if($weekmonthselect=="month")
        {
            if($stageValue=="All")
            {
                $stageValue = 'NULL';
                // $result = $this->GetMultipleQueryResult("call sp_get_dashboard_statistics_popup($sessionId,'$packageno','month','$monthdate', NULL,NULL)"); /*Original Code*/
                $result = $this->GetMultipleQueryResult("CALL sp_get_combineLot_dashboard_statistics_popup(".$userId.", ".$packageno.", 'month', ".$monthdate.", NULL, NULL)");
            }
            else
            {   
                $explode = explode(" ", $stageValue);
                $stageId = $explode[1];

                // $result = $this->GetMultipleQueryResult("call sp_get_dashboard_statistics_popup($sessionId,'$packageno','month','$monthdate', NULL, '$explode[1]')"); /*Original Code*/
                $result = $this->GetMultipleQueryResult("CALL sp_get_combineLot_dashboard_statistics_popup(".$userId.", ".$packageno.", 'month', ".$monthdate.", NULL, ".$stageId.")");
            }
        }

        $weekDateFirst = "";
        $weekDateSecond = "";

        if(!empty($_POST['weekdatedropdown']))
        {
            $weekdatedropdown = explode(" - ", @$_POST['weekdatedropdown']) ;
            $weekDateFirst = $weekdatedropdown[0];
            $weekDateSecond = $weekdatedropdown[1];
        }
       
        if($weekmonthselect=="week")
        {
            if($stageValue=="All")
            {
                // $result = $this->GetMultipleQueryResult("call sp_get_dashboard_statistics_popup($sessionId,'$packageno','week','$weekDateFirst', '$weekDateSecond', NULL)"); /*Original Code*/
                $result = $this->GetMultipleQueryResult("CALL sp_get_combineLot_dashboard_statistics_popup(".$userId.", ".$packageno.", 'week', '".$weekDateFirst."', '".$weekDateSecond."', NULL)");
            }
            else
            {
                $explode = explode(" ", $stageValue);
                $stageId = $explode[1];
           
                // $result = $this->GetMultipleQueryResult("call sp_get_dashboard_statistics_popup($sessionId,'$packageno','week','$weekDateFirst', '$weekDateSecond','$stageId')"); /*Original Code*/
                $result = $this->GetMultipleQueryResult("CALL sp_get_combineLot_dashboard_statistics_popup(".$userId.", ".$packageno.", 'week', '".$weekDateFirst."', '".$weekDateSecond."', ".$stageId.")");
            }
        }
        //$result = $this->GetMultipleQueryResult("call sp_get_dashboard_statistics_popup(1,'102','$weekmonthselect',NULL, NULL,NULL)");
       
        //$allValues = $result[1];

        $allValues = $result[1];
        $allKeys = array_keys($result[1][0]);
        $mainHeaders = array();
        $mainHeadersWithUnderscores = array();
        $mainHeadersWithoutPercent = array();
        $weekOrMonth = $weekmonthselect."_";
        $stage = explode("_", $allKeys[1]);
        
        foreach($allKeys as $keys)
        {
            if(str_contains($keys, $weekOrMonth))
            {
                $explode = explode($weekOrMonth, $keys);  
                array_push($mainHeaders, $explode[1]);
            }
        }

        foreach($mainHeaders as $main)
        {
            if(str_contains($main, "_"))
            {
                $explode1 = explode("_", $main);  
                array_push($mainHeadersWithUnderscores, $explode1[0]);
            }           
        }

        $mainHeadersWithUnderscores = $mainHeaders;

        $headers = $week_headers = $cummulative_headers = [];
        foreach($allKeys as $per)
        {
            if(!str_contains($per, "Percent"))
            {
                if (!str_contains($per, 'week_') && !str_contains($per, 'Cummulative_')) {
                    array_push($headers, $per);
                }

                if (str_contains($per, 'week_')) {
                    array_push($week_headers, $per);
                }

                if (str_contains($per, 'Cummulative_')) {
                    array_push($cummulative_headers, $per);
                }
                // array_push($mainHeadersWithoutPercent, $per);
            }
        }

        $mainHeadersWithoutPercent = array_merge($headers, $week_headers, $cummulative_headers);

        $mainTd = "";

        $colsPan = count($mainHeadersWithUnderscores)*2;
        //$colsPan = 6;

        for($i=0; $i< count($mainHeadersWithUnderscores);$i++)
        {
            $mainTd .=  '<td align="center">'.$mainHeadersWithUnderscores[$i].'</td>';

        }

        for($j=0; $j< count($mainHeadersWithUnderscores);$j++)
        {
            $mainTd .=  '<td align="center">'.$mainHeadersWithUnderscores[$j].'</td>';
            $mainTd .=  '<td align="center">'.$mainHeadersWithUnderscores[$j].' % </td>';            
        }

        $valueTd = "";
        foreach ($allValues as $all_key => $all_value) {
            $valueTd .= '<tr>';

            foreach ($mainHeadersWithoutPercent as $val) {
                if(!str_contains($val, "package_no") && !str_contains($val, "Stage") && !str_contains($val, "week") && !str_contains($val, "month"))
                {
                    $valueTd .= '<td align="center">'.$all_value[$val].'</td>';
                
                    // $valueTd .= '<td align="center">'.$allValues[$val.'_Percent'].'</td>'; //Original Code

                    if (isset($allValues[$val.'_Percent'])) {
                        $valueTd .= '<td align="center">'.$all_value[$val.'_Percent'].'</td>';
                    } else {
                        $valueTd .= '<td align="center">0.00%</td>';
                    }
                    /* if(!str_contains($val, "week") || !str_contains($val, "month"))
                    {
                        $valueTd .= '<td>'.$allValues[$val.'_Percent'].'</td>';
                    }*/            
                }
                else
                {
                    $valueTd .= '<td align="center">'.$all_value[$val].'</td>';
                }
            }

            $valueTd .= '<td>'.$all_value['Slippage_In_Percent'].'</td>';
            $valueTd .= '</tr>';
        }

        $return  = '<thead>
                        <tr style="background: #eee;">
                        <th style="border-right: 1px solid #c5c5c5;" align="center">Lot</th>
                            <th style="border-right: 1px solid #c5c5c5;" align="center">Stage</th>
                            <th colspan="'.($i).'" style="border-right: 1px solid #c5c5c5;">Weekly</th>
                            <th colspan="'.($i * 2).'" style="border-right: 1px solid #c5c5c5;">Cummulative</th>
                            <th>Slippage (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td align="center">Lot No</td>
                            <td align="center">'.$stage[1].'</td>
                            '.$mainTd.'
                            <td></td>
                        </tr>
                        '.$valueTd.'
                    </tbody>';
        
        echo $return;                        
    }

    public function loadRegions()
    {  
        $query = $this->db->get("mst_region");
        //   echo $this->db->last_query();
        if($query)
        {
            $result = $query->result();
            return $result;
        }
    }

    public function getcircles($regionId)
    {
        $this->db->where("region_id", $regionId);
        $query = $this->db->get("mst_circle");
        //echo $this->db->last_query();
        if($query) {
            $result = $query->result();
            //return $result;
        }
        
        $html = '<option value="" selected disabled>Select Circle</option>'; 

        foreach($result as $res)
        {
            $html .= "<option value='".$res->circle_id."'>".$res->circle_name."</option>";
        }
        echo $html;        
    }

    public function getdivisions($regionId)
    {
        $this->db->where("circle_id", $regionId);
        $query = $this->db->get("mst_division");
        //echo $this->db->last_query();
        if($query) {
            $result = $query->result();
            //return $result;
        }
        
        $html = '<option value="" selected disabled>Select Division</option>'; 

        foreach($result as $res)
        {
            $html .= "<option value='".$res->division_id."'>".$res->division_name."</option>";
        }

        echo $html;
    }

    public function getFinancialDashboardData($date)
    {
        $user_id = $_SESSION['loggedData']->user_id;
        $sql_stmt = $_SESSION['pvdashboard_query'] = "CALL sp_get_dashboard_financial_progress(".$user_id.", '".$date."')";
        $query = $this->db->query($sql_stmt);
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

    public function getPhysicalVerificationData($date, $contractor, $type_of_work)
    {
        $user_id = $_SESSION['loggedData']->user_id;

        $sql_stmt = $_SESSION['pvdashboard_query'] = "CALL sp_get_dashboard_physical_verification(".$user_id.", '".$date."', ".$contractor.", ".$type_of_work.")";
        $query = $this->db->query($sql_stmt);
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

    public function getFeedersList($slab, $contract_id, $package_no, $date, $region = NULL, $circle = NULL, $division = NULL)
    {
        $user_id = $_SESSION['loggedData']->user_id;

        $sql_stmt = $_SESSION['pvdashboard_query'] = "CALL sp_get_dashboard_physical_verification_feeder_popup(".$user_id.", '".$date."', '".$package_no."', '".$slab."', ".$region.", ".$circle.", ".$division.")";
        $query = $this->db->query($sql_stmt);
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

    public function getRegionList()
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

    public function getCircleList()
    {
        $this->db->select('mst_circle.circle_id, mst_circle.circle_name, mst_region.region_name');
        $this->db->from('mst_circle');
        $this->db->join('mst_region', 'mst_circle.region_id = mst_region.region_id', 'INNER');
        $this->db->where(array('mst_circle.is_active' => 1, 'mst_circle.deletedby' => NULL));

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

    public function getDivisionList()
    {
        $this->db->select('mst_division.division_id, mst_division.division_name, mst_circle.circle_name');
        $this->db->from('mst_division');
        $this->db->join('mst_circle', 'mst_division.circle_id = mst_circle.circle_id', 'INNER');
        $this->db->where(array('mst_division.is_active' => 1, 'mst_division.deletedby' => NULL));

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

    public function getTypeOfWorkList()
    {
        $this->db->select('typeofwork_id, name');
        $query = $this->db->get_where('mst_typeofwork', array('is_active' => 1, 'deletedby' => NULL));
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
    
    public function executeQuery($session_query)
    {
        $query = $this->db->query($session_query);

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

