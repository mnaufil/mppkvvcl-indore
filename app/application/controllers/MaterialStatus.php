<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class MaterialStatus extends CI_Controller
{
     function __construct()
     {
          parent::__construct();

          //$this->load->library('form_validation'); 
          $this->load->model('MaterialStatus_Model', 'ms_model');
        
          if(!$this->session->isUserLoggedIn)
          { 
               redirect('login'); 
          }
     }

     public function index()
     {
          $material_result = $this->ms_model->getMaterialsStatusList();
          $status_data = $this->ms_model->getStatusData();
          array_shift($status_data);

          $user_access_data = $this->ms_model->getUserModuleAccess();
          $user_access = $this->sortUserModuleAccess($user_access_data);

          $data['title'] = 'Material Status';
          $data['material_status_data'] = $material_result;
          $data['status_data'] = $status_data;
          $data['user_access'] = $user_access;          

          // echo '<pre>'; print_r($data); echo '</pre>'; die();
          $this->load->view('material-status/material-status', $data); 
     }

     public function addMaterialStatus()
     {
          $data['work_list'] = $this->ms_model->getTypeOfWorkList();
          $data['sampling_lab_data'] = $this->ms_model->getSamplingLabData();
          $data['title'] = 'Material Status';

          // echo '<pre>'; print_r($data); echo '</pre>'; die();
          $this->load->view('material-status/add-materialstatus', $data);
     }

     public function searchMaterialStatus()
     {
          if (!empty($_POST)) {
               $contractor = $this->input->post('contractor');
               $filter_arr['contractor']['label'] = 'Contractor (TKC)';
               $filter_arr['contractor']['value'] = $contractor;
               
               $tender_award_no = $this->input->post('tenderAwardNo');
               $filter_arr['tender_award_no']['label'] = 'Contract No.';
               $filter_arr['tender_award_no']['value'] = $tender_award_no;

               $tkc_offer_letter_no = $this->input->post('tkcOfferLetterNo');
               $filter_arr['tkc_offer_letter_no']['label'] = 'TKC Offer Letter No.';
               $filter_arr['tkc_offer_letter_no']['value'] = $tkc_offer_letter_no;

               /*$di_letter_no = $this->input->post('diLetterNo');
               $filter_arr['di_letter_no'] = $di_letter_no;*/
               $di_letter_no = '';

               /*$status = $this->input->post('status');
               $filter_arr['status'] = $status;

               if (!empty($status)) {
                    $status = implode(',', $status);
               }*/

               $status = (isset($_POST['status'])) ? implode(',', $this->input->post('status')) : '';
               $filter_arr['status']['label'] = 'Status';
               $status_values = [];
               if ($status != '') {
                    foreach ($this->input->post('status') as $key => $value) {
                         array_push($status_values, $this->ms_model->getSheetStatus($value));
                    }
               }
               $filter_arr['status']['value'] = (!empty($status_values)) ? implode(', ', $status_values) : '';
               $filter_arr['status']['id'] = $this->input->post('status');


               $material_status_search_result = $this->ms_model->searchMaterialStatus($contractor, $tender_award_no, $tkc_offer_letter_no, $di_letter_no, $status);

               $status_data = $this->ms_model->getStatusData();
               array_shift($status_data);

               $user_access_data = $this->ms_model->getUserModuleAccess();
               $user_access = $this->sortUserModuleAccess($user_access_data);

               $data['material_status_data'] = $material_status_search_result;
               $data['title'] = 'Material Status';
               $data['status_data'] = $status_data;
               $data['filter_data'] = $filter_arr;
               $data['user_access'] = $user_access;

               // echo '<pre>'; print_r($data); echo '</pre>'; die();
               $this->load->view('material-status/material-status', $data); 
          }
     }

     public function editMaterialStatus($material_status_id)
     {
          $material_data = $this->ms_model->getMaterialData($material_status_id);
          $material_data['offer_letter_date'] = date('d-m-Y', strtotime($material_data['offer_letter_date']));
          $material_data['tender_award_date'] = date('d-m-Y', strtotime($material_data['tender_award_date']));

          foreach ($material_data['material_details'] as $key => $value) {
               $approve_quantity = 0;

               // Getting Earlier Approved Quantity if any
               $contract_data = $this->ms_model->checkContractExists($material_data['contract_id']);
               foreach ($contract_data as $cd_key => $cd_value) {
                    $material_details_data = $this->ms_model->getMaterialStatusDetailData($cd_value['material_status_id'], $value['contract_material_id']);

                    foreach ($material_details_data as $mdd_key => $mdd_value) {
                         $accepted_quantities_data = $this->ms_model->getMaterialAcceptedQuantityData($mdd_value['material_status_detail_id']);

                         foreach ($accepted_quantities_data as $aq_key => $aq_value) {
                              if (strtotime($aq_value['accepted_report_date']) < strtotime($material_data['offer_letter_date'])) {
                                   $approve_quantity += $aq_value['accepted_quantity'];
                              }
                         }
                    }
               }

               $material_data['material_details'][$key]['earlier_approved_quantity'] = number_format((float)$approve_quantity, 2, '.', '');
          }

          $data['material_data'] = $material_data;
          $data['circle_data'] = $this->ms_model->getCircleList($material_data['contract_id']);
          $data['work_list'] = $this->ms_model->getTypeOfWorkList();
          $data['sampling_lab_data'] = $this->ms_model->getSamplingLabData();
          $data['title'] = 'Edit Material Status';

          // echo '<pre>'; print_r($data); echo '</pre>'; die();
          $this->load->view('material-status/edit-materialstatus', $data);
     }

     public function viewMaterialStatus()
     {
          echo "View Material Status";
     }

     public function saveMaterialStatus()
     {
          if (!empty($_POST)) {
               $material_status_id = $this->input->post('material_status_id');

               //Check later for material_details form completely filled and update is_draft to 1

               $is_draft = 0;
               //Updating (saving by changing is_draft to 1) Material Status record
               $update_result = $this->ms_model->updateMaterialStatus($is_draft, $material_status_id);
               
               /*if ($update_result) {
                    redirect('material-status');
               }*/

               redirect('material-status');
          }
     }

     public function deleteMaterialStatus()
     {
          //Default Response
          http_response_code(200);
          $response['message'] = 'Delete Material Details success';

          if (!empty($_POST)) {
               $material_status_id = $this->input->post('material_status_id');

               //Deleting record from Material Status table
               $delete_material_status_result = $this->ms_model->deleteMaterialStatus($material_status_id);

               if ($delete_material_status_result) {
                    //Getting material_status_detail_ids
                    $material_status_detail_ids = $this->ms_model->getMaterialStatusDetailIDs($material_status_id);

                    foreach ($material_status_detail_ids as $key => $value) {
                         //Deleting record from Material Status Detail table
                         $delete_material_status_detail_result = $this->ms_model->deleteMaterialStatusDetail($value['material_status_detail_id']); 

                         if ($delete_material_status_detail_result) {
                              //Deleting record from Material Status Detail File table
                              $delete_material_status_detail_file_result = $this->ms_model->deleteMaterialStatusDetailFiles($value['material_status_detail_id']);

                              //Deleting record from Material Status Material Received Detail table
                              $delete_material_received_result = $this->ms_model->deleteMaterialReceivedData($value['material_status_detail_id']);

                              //Deleting record from Material Status Random Sampling Detail
                              $delete_random_sampling_result = $this->ms_model->deleteRandomSamplingData($value['material_status_detail_id']);     
                         }
                    }
               } else {
                    http_response_code(400);
                    $response['message'] = 'Delete Material Details Failed';
               }
          }

          echo json_encode($response);
     }

     public function searchContractor()
     {
          if (!empty($_POST)) {
               $contractor = $this->input->post('contractor');

               $response['contractor_data'] = $this->ms_model->getContractorData($contractor);
          }

          echo json_encode($response);
     }

     public function getMaterials()
     {
          if (!empty($_POST)) {
               $contract_id = $this->input->post('contract_id');

               $response['inspecting_agency_data'] = $this->ms_model->getInspectingAgencies();
               $response['material_data'] = $this->ms_model->getMaterials($contract_id);
          }

          echo json_encode($response);
     }

     public function getCircles()
     {
          // echo '<pre>'; print_r($_POST); echo '</pre>'; die();
          if (!empty($_POST)) {
               $contract_id = $this->input->post('contract_id');

               $response['circle_data'] = $this->ms_model->getCircleList($contract_id);
          }

          echo json_encode($response);
     }

     public function getMaterialDetails()
     {
          if (!empty($_POST)) {
               $material_details_id = $this->input->post('material_status_detail_id');
               $contract_id = $this->input->post('contract_id');

               //Getting details for the mentioned material
               $material_details_data = $this->ms_model->getMaterialDetails($material_details_id);
               /*echo 'material_details_data: <pre>'; print_r($material_details_data); echo '</pre>'; die();

               if (!empty($contract_id)) {
                    // Getting Earlier Approved Quantity if any
                    $contract_data = $this->ms_model->checkContractExists($material_data['contract_id']);

                    foreach ($contract_data as $cd_key => $cd_value) {
                         $material_details_data = $this->ms_model->getMaterialStatusDetailData($cd_value['material_status_id'], $value['contract_material_id']);

                    }

               }*/

               $response['material_details_data'] = $material_details_data;
               // echo '<pre>'; print_r($response['material_details_data']); echo '</pre>'; die();
               $response['inspecting_agency_data'] = $this->ms_model->getInspectingAgencies();
          }

          echo json_encode($response);
     }

     public function getInspectingAgencies()
     {
          $response['inspecting_agency_data'] = $this->ms_model->getInspectingAgencies();

          echo json_encode($response);
     }

     public function getMaterialQuantity()
     {
          if (!empty($_POST)) {
               $material_id = $this->input->post('material_id');
               $contract_id = $this->input->post('contract_id');
               $tkc_offer_letter_date = $this->input->post('tkc_offer_letter_date');

               $material_qty_data = $this->ms_model->getMaterialQuantities($material_id);

               // Check for previous approved quantity if any
               $contract_data = $this->ms_model->checkContractExists($contract_id);

               $approve_quantity = 0;
               if (!empty($contract_data)) {
                    foreach ($contract_data as $key => $value) {
                         $material_details_data = $this->ms_model->getMaterialStatusDetailData($value['material_status_id'], $material_id);
                         
                         foreach ($material_details_data as $mdd_key => $mdd_value) {
                              $accepted_quantities_data = $this->ms_model->getMaterialAcceptedQuantityData($mdd_value['material_status_detail_id']);

                              foreach ($accepted_quantities_data as $aq_key => $aq_value) {
                                   if ($aq_value['accepted_quantity'] != NULL && strtotime($aq_value['accepted_report_date']) < strtotime($tkc_offer_letter_date)) {
                                        $approve_quantity += $aq_value['accepted_quantity'];
                                   }
                              }
                         }
                    }
               }
               
               if ($material_qty_data['revised_quantity'] != 0) {
                    if ($approve_quantity != 0) {
                         $material_qty = $material_qty_data['revised_quantity'] - $approve_quantity;
                    } else {
                         $material_qty = $material_qty_data['revised_quantity'];
                    }
               }

               $response['material_qty'] = number_format((float)$material_qty, 2, '.', '');
               $response['contract_material_id'] = $material_qty_data['contract_material_id'];
               $response['approve_quantity'] = $approve_quantity;
          }

          echo json_encode($response);
     }

     public function saveMaterialDetails()
     {
          //Default Response
          http_response_code(200);
          $response['message'] = 'Save Material Details success';

          if (!empty($_POST)) {
               $contract_id = $this->input->post('contract_id');
               $material_status_id = $this->input->post('material_status_id');
               $material_status_detail_id = $this->input->post('material_status_detail_id');
               $discom = $this->input->post('discom'); //derive from table
               $tkc_offer_letter_no = $this->input->post('tkc_offer_letter_no');
               $tkc_offer_letter_date = date('Y-m-d', strtotime($this->input->post('tkc_offer_letter_date')));
               $status_id = 5;
               
               if (!empty($_POST['material_details'])) {
                    $material_details = (array)json_decode($this->input->post('material_details'));
                    if (empty($material_status_id)) {
                         $is_draft = 1;

                         //make an entry in material_status
                         $material_status_id = $this->ms_model->saveMaterialStatus($contract_id, $discom, $tkc_offer_letter_no, $tkc_offer_letter_date, $status_id, $is_draft);     
                    }

                    if ($material_status_id) {
                         $contract_material_id = $material_details['contract_material_id'];
                         $material_name = $material_details['material_name'];

                         $offer_letter_qty = $material_details['offerLetterQuantity'];
                         $date_of_readiness = empty($material_details['dateOfReadiness']) ? NULL : date('Y-m-d', strtotime($material_details['dateOfReadiness']));
                         $inspection_letter_no = empty($material_details['inspectionLetterNo']) ? NULL : $material_details['inspectionLetterNo'];
                         $inspection_letter_date = empty($material_details['inspectionLetterDate']) ? NULL : date('Y-m-d', strtotime($material_details['inspectionLetterDate']));
                         $date_of_inspection = empty($material_details['dateofInspection']) ? NULL : date('Y-m-d', strtotime($material_details['dateofInspection']));
                         $material_serial_nos = empty($material_details['materialSerialNos']) ? NULL : $material_details['materialSerialNos'];
                         $di_material_no = empty($material_details['diMaterialNo']) ? NULL : $material_details['diMaterialNo'];
                         $di_material_date = empty($material_details['diMaterialDate']) ? NULL : date('Y-m-d', strtotime($material_details['diMaterialDate']));
                         $di_qty = empty($material_details['diQuantity']) ? NULL : $material_details['diQuantity'];
                         $di_remark = empty($material_details['diRemark']) ? NULL : $material_details['diRemark'];
                         $mrc_generated_no = empty($material_details['mrcGeneratedNo']) ? NULL : $material_details['mrcGeneratedNo'];
                         $mrc_generated_date = empty($material_details['mrcGeneratedDate']) ? NULL : date('Y-m-d', strtotime($material_details['mrcGeneratedDate']));

                         if (empty($material_status_detail_id)) {
                              // $contract_material_id = $material_details['contract_material_id'];  

                              //make an entry in material_status_details 
                              // $material_status_detail_id = $this->ms_model->saveMaterialDetails($material_status_id, $contract_material_id, $material_details['material_name'], $material_details['offerLetterQuantity'], $material_details['dateOfReadiness'], $material_details['pdiLetterNo'], $material_details['pdiLetterDate'], $material_details['inspectionLetterNo'], $material_details['inspectionLetterDate'], $material_details['inspectionAgency'], $material_details['dateofInspection'], $material_details['materialSerialNos'], $material_details['diMaterialNo'], $material_details['diMaterialDate'], $material_details['diQuantity'], $material_details['mrcGeneratedNo'], $material_details['mrcGeneratedDate']);

                              $material_status_detail_id = $this->ms_model->saveMaterialDetails($material_status_id, $contract_material_id, $material_name, $offer_letter_qty, $date_of_readiness, $date_of_inspection, $inspection_letter_date, $date_of_inspection, $material_serial_nos, $di_material_no, $di_material_date, $di_qty, $di_remark, $mrc_generated_no, $mrc_generated_date);
                         } else {
                              //updating record in material_status_details
                              $this->ms_model->updateMaterialDetails($material_status_detail_id, $offer_letter_qty, $date_of_readiness, $inspection_letter_no, $inspection_letter_date, $date_of_inspection, $material_serial_nos, $di_material_no, $di_material_date, $di_qty, $di_remark, $mrc_generated_no, $mrc_generated_date);                              
                         }                                                  

                         if ($material_status_detail_id) {
                              //Material Files
                              if (!empty($_FILES)) {
                                   $material_files = $_FILES['material_files'];

                                   if ($material_files['error'][0] != 4) {
                                        $allowTypes = array('jpg', 'png', 'jpeg');

                                        $uploadDir = 'assets/uploads/material_status_files/';

                                        $uploaded_files = [];

                                        foreach ($material_files['name'] as $key => $value) {
                                             $ext = pathinfo($value, PATHINFO_EXTENSION);

                                             // File upload path 
                                             // $fileName = basename($value);
                                             $fileName = $material_status_detail_id.'_material_file_'.$key.'.'.$ext;
                                             $targetFilePath = $uploadDir . $fileName;

                                             if (in_array($ext, $allowTypes)) {
                                                  // Upload file to server
                                                  if (move_uploaded_file($material_files['tmp_name'][$key], $targetFilePath)) {
                                                       //Save the file details
                                                       $file_result = $this->ms_model->saveMaterialStatusDetailsFile($material_status_detail_id, $targetFilePath);

                                                       if (!$file_result) {
                                                            http_response_code(400);
                                                            $response['message'] = 'Material Details File upload failed';
                                                       } else {
                                                            array_push($uploaded_files, $targetFilePath);
                                                       }
                                                  }
                                             }
                                        }

                                        $response['material_files'] = $uploaded_files;
                                   }
                              }

                              // Material Received Details
                              if (!empty($material_details['materialReceivedData'])) {
                                   $material_received_data = (array)$material_details['materialReceivedData'];

                                   //make an entry in material_status_material_received_detail
                                   foreach ($material_received_data as $key => $value) {
                                        if (!empty($value->circle)) {
                                             $circle_data = $this->ms_model->getCircleID($value->circle);
                                             $received_date = date('Y-m-d', strtotime($value->received_date));

                                             $this->ms_model->saveMaterialReceivedDetails($material_status_detail_id, $circle_data['circle_id'], $value->received_qty, $value->received_serial_nos, $received_date);
                                        }
                                   }
                              }

                              //Random Sampling Details
                              if (!empty($material_details['randomSamplingData'])) {
                                   $random_sampling_data = (array)$material_details['randomSamplingData'];

                                   //make an entry in material_status_random_sampling_detail
                                   foreach ($random_sampling_data as $key => $value) {
                                        if (!empty($value->circle)) {
                                             $circle_data = $this->ms_model->getCircleID($value->circle);
                                             $sampling_date = date('Y-m-d', strtotime($value->sampling_date));
                                             $accepted_report_date = (!empty($value->accepted_report_date)) ? date('Y-m-d', strtotime($value->accepted_report_date)) : NULL;
                                             $sampling_lab_id = $this->ms_model->getSamplingLabID($value->sampling_lab);

                                             $this->ms_model->saveRandomSamplingDetails($material_status_detail_id, $circle_data['circle_id'], $value->sampling_qty, $value->sampling_serial_nos, $sampling_date, $value->sampling_letter_no, $sampling_lab_id, $value->accepted_report_no, $accepted_report_date, $value->accepted_qty);
                                        }
                                   }
                              }

                              $response['material_status_id'] = $material_status_id;
                              $response['material_status_detail_id'] = $material_status_detail_id;

                              //Fetching BOQ and Revised Quantity for the material
                              $response['quantities'] = $this->ms_model->getMaterialQuantities($contract_material_id);
                         } else {
                              http_response_code(400);
                              $response['message'] = 'Save Material Details failed';
                         }
                    } else {
                         http_response_code(400);
                         $response['message'] = 'Save Material Status failed';
                    }
               }
          }

          echo json_encode($response);
     }

     public function updateMaterialDetails()
     {
          //Default Response
          http_response_code(200);
          $response['message'] = 'Update Material Details success';

          if (!empty($_POST)) {
               // $ms_data = $this->input->post('material_details');

               $material_status_detail_id = $this->input->post('material_status_detail_id');
               $offer_letter_qty = $this->input->post('offerLetterQuantity');
               $date_of_readiness = (empty($this->input->post('dateOfReadiness'))) ? NULL : date('Y-m-d', strtotime($this->input->post('dateOfReadiness')));
               // $pdi_letter_no = (empty($this->input->post('pdiLetterNo'))) ? NULL : $this->input->post('pdiLetterNo');
               // $pdi_letter_date = (empty($this->input->post('pdiLetterDate'))) ? NULL : date('Y-m-d', strtotime($this->input->post('pdiLetterDate')));
               $inspection_letter_no = (empty($this->input->post('inspectionLetterNo'))) ? NULL : $this->input->post('inspectionLetterNo');
               $inspection_letter_date = (empty($this->input->post('inspectionLetterDate'))) ? NULl : date('Y-m-d', strtotime($this->input->post('inspectionLetterDate')));
               // $inspection_agency_id = (empty($this->input->post('inspectionAgency'))) ? NULL : $this->input->post('inspectionAgency');
               $date_of_inspection = (empty($this->input->post('dateofInspection'))) ? NULL : date('Y-m-d', strtotime($this->input->post('dateofInspection')));
               $material_serial_nos = (empty($this->input->post('materialSerialNos'))) ? NULL : $this->input->post('materialSerialNos');
               $di_material_no = (empty($this->input->post('diMaterialNo'))) ? NULL : $this->input->post('diMaterialNo');
               $di_material_date = (empty($this->input->post('diMaterialDate'))) ? NULL : date('Y-m-d', strtotime($this->input->post('diMaterialDate')));
               $di_qty = (empty($this->input->post('diQuantity'))) ? NULL : $this->input->post('diQuantity');
               $di_remark = (empty($this->input->post('diRemark'))) ? NULL : $this->input->post('diRemark');
               $mrc_generated_no = (empty($this->input->post('mrcGeneratedNo'))) ? NULL : $this->input->post('mrcGeneratedNo');
               $mrc_generated_date = (empty($this->input->post('mrcGeneratedDate'))) ? NULL : date('Y-m-d', strtotime($this->input->post('mrcGeneratedDate')));

               //Uncomment Later
               // $update_result = $this->ms_model->updateMaterialDetails($material_status_detail_id, $offer_letter_qty, $date_of_readiness, $pdi_letter_no, $pdi_letter_date, $inspection_letter_no, $inspection_letter_date, $inspection_agency_id, $date_of_inspection, $material_serial_nos, $di_material_no, $di_material_date, $di_qty, $mrc_generated_no, $mrc_generated_date);
               $update_result = $this->ms_model->updateMaterialDetails($material_status_detail_id, $offer_letter_qty, $date_of_readiness, $inspection_letter_no, $inspection_letter_date, $date_of_inspection, $material_serial_nos, $di_material_no, $di_material_date, $di_qty, $di_remark, $mrc_generated_no, $mrc_generated_date);

               //Saving Material Received Details
               if ($update_result) {
                    $material_received_data = (array) json_decode($this->input->post('materialReceivedData'));

                    if (!empty($material_received_data)) {
                         foreach ($material_received_data as $key => $value) {
                              if (!empty($value->circle)) {
                                   $circle_id = $this->ms_model->getCircleID($value->circle);
                                   $received_qty = $value->received_qty;
                                   $serial_no = $value->serial_no;
                                   $received_date = date('Y-m-d', strtotime($value->received_date));

                                   // Check if circle already exists
                                   $circle_data = $this->ms_model->checkMaterialReceivedCircleExists($material_status_detail_id, $circle_id['circle_id']);

                                   if ($circle_data) {
                                        //Update
                                        $received_result = $this->ms_model->updateMaterialReceivedDetails($material_status_detail_id, $circle_id['circle_id'], $received_qty, $serial_no, $received_date);
                                   } else {
                                        // Save
                                        $received_result = $this->ms_model->saveMaterialReceivedDetails($material_status_detail_id, $circle_id['circle_id'], $received_qty, $serial_no, $received_date);
                                   }
                              }
                         }
                    }

                    $random_sampling_data = (array) json_decode($this->input->post('randomSamplingData'));

                    if (!empty($random_sampling_data)) {
                         foreach ($random_sampling_data as $key => $value) {
                              if (!empty($value->circle)) {
                                   $circle_id = $this->ms_model->getCircleID($value->circle);
                                   $sampling_qty = $value->sampling_qty;
                                   $sampling_serial_no = $value->sampling_serial_no;
                                   $sampling_date = date('Y-m-d', strtotime($value->sampling_date));
                                   $sampling_letter_no = $value->sampling_letter_no;
                                   $sampling_lab_id = $this->ms_model->getSamplingLabID($value->sampling_lab);
                                   $accepted_report_no = $value->accepted_report_no;
                                   $accepted_report_date = date('Y-m-d', strtotime($value->accepted_report_date));
                                   $accepted_qty = $value->accepted_qty;

                                   // Check if circle already exists
                                   $circle_data = $this->ms_model->checkRandomSamplingCircleExists($material_status_detail_id, $circle_id['circle_id']);

                                   if ($circle_data) {
                                        //Update
                                        $sampling_result = $this->ms_model->updateRandomSamplingDetails($material_status_detail_id, $circle_id['circle_id'], $sampling_qty, $sampling_serial_no, $sampling_date, $sampling_letter_no, $sampling_lab_id, $accepted_report_no, $accepted_report_date, $accepted_qty);
                                   } else {
                                        //Save
                                        $sampling_result = $this->ms_model->saveRandomSamplingDetails($material_status_detail_id, $circle_id['circle_id'], $sampling_qty, $sampling_serial_no, $sampling_date, $sampling_letter_no, $sampling_lab_id, $accepted_report_no, $accepted_report_date, $accepted_qty);
                                   }
                              }
                         }    
                    }
               }

               //Saving file details
               if ($update_result) {
                    if (!empty($_FILES)) {
                         $material_files = $_FILES['material_file'];

                         $allowTypes = array('jpg', 'png', 'jpeg');
                         $material_files_data = [];

                         if ($material_files['error'][0] != 4) {
                              $uploadDir = 'assets/uploads/material_status_files/';

                              //check if any file exists before
                              $check_file_exists = $this->ms_model->checkMaterialFileExists($material_status_detail_id);

                              if ($check_file_exists) {
                                   //Delete previously saved files
                                   $deleted_files = $this->ms_model->deleteMaterialStatusDetailFiles($material_status_detail_id);
                              }

                              foreach ($material_files['name'] as $key => $value) {
                                   $ext = pathinfo($value, PATHINFO_EXTENSION);

                                   // File upload path 
                                   // $fileName = basename($value);
                                   $fileName = $material_status_detail_id.'_material_file_'.$key.'.'.$ext;
                                   $targetFilePath = $uploadDir . $fileName;

                                   // Check whether file type is valid
                                   $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

                                   if (in_array($fileType, $allowTypes)) {
                                        // Upload file to server
                                        if (move_uploaded_file($material_files['tmp_name'][$key], $targetFilePath)) {
                                             //Save the file details
                                             $file_result = $this->ms_model->saveMaterialStatusDetailsFile($material_status_detail_id, $targetFilePath);

                                             if (!$file_result) {
                                                  http_response_code(400);
                                                  $response['message'] = 'Material Details File upload failed';
                                             } else {
                                                  array_push($material_files_data, $targetFilePath);
                                             }
                                        }
                                   }
                              }

                              $response['file_data'] = $material_files_data;
                         } else {
                              //Getting previously saved files
                              $files_data = $this->ms_model->getMaterialStatusDetailsFile($material_status_detail_id);
                              foreach ($files_data as $key => $value) {
                                   array_push($material_files_data, $value['file_path']);
                              }

                              $response['file_data'] = $material_files_data;    
                         }
                    }

                    $response['material_details_id'] = $material_status_detail_id;
               } else {
                    http_response_code(400);
                    $response['message'] = 'Update Material Details failed';
               }
          }

          echo json_encode($response);
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