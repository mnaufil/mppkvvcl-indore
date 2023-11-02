<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class InvoiceStatus extends CI_Controller
{
     function __construct()
     {
          parent::__construct();

          //$this->load->library('form_validation'); 
          $this->load->model('InvoiceStatus_Model', 'is_model');
        
          if(!$this->session->isUserLoggedIn)
          { 
               redirect('login'); 
          }
     }

     public function index()
     {
          $result = $this->is_model->getInvoiceList();

          // Formatting dates
          foreach ($result as $key => $value) {
               $result[$key]['invoice_date'] = (!empty($value['invoice_date'])) ? date('d-m-Y', strtotime($value['invoice_date'])) : '';
               $result[$key]['tender_award_date'] = (!empty($value['tender_award_date'])) ? date('d-m-Y', strtotime($value['tender_award_date'])) : '';               
               $result[$key]['period'] = (!empty($value['invoice_date'])) ? date('F', strtotime($value['invoice_date'])) : '';
          }

          $status_data = $this->is_model->getStatusData();

          $user_access_data = $this->is_model->getUserModuleAccess();
          $user_access = $this->sortUserModuleAccess($user_access_data);

          $data['invoices'] = $result;
          $data['invoice_status'] = $status_data;
          $data['user_access'] = $user_access;
          $data['title'] = 'Invoice Status';

          // echo '<pre>'; print_r($data); echo '</pre>'; die();
          $this->load->view('invoice-status/invoice-status', $data); 
     }

     public function viewAddInvoice()
     {
          $data['title'] = 'Invoice Status';
          $this->load->view('invoice-status/add-invoice', $data);
     }

     public function addInvoiceStatus()
     {
          echo '<pre>'; print_r($_POST); echo '</pre>';
     }

     public function searchInvoice()
     {
          if (!empty($_POST)) {
               $contractor = $this->input->post('contractor');
               $filter_arr['contractor']['label'] = 'Contractor (TKC)';
               $filter_arr['contractor']['value'] = $contractor;

               $tender_award_no = $this->input->post('tenderAwardNo');
               $filter_arr['tender_award_no']['label'] = 'Contract No.';
               $filter_arr['tender_award_no']['value'] = $tender_award_no;

               $invoice_no = $this->input->post('invoiceNo');
               $filter_arr['invoice_no']['label'] = 'Invoice No.';
               $filter_arr['invoice_no']['value'] = $invoice_no;

               $status = (isset($_POST['status'])) ? implode(',', $this->input->post('status')) : '';
               $filter_arr['status']['label'] = 'Status';
               $status_values = [];
               if ($status != '') {
                    foreach ($this->input->post('status') as $key => $value) {
                         array_push($status_values, $this->is_model->getSheetStatus($value));
                    }
               }
               $filter_arr['status']['value'] = (!empty($status_values)) ? implode(', ', $status_values) : '';
               $filter_arr['status']['id'] = $this->input->post('status');

               $invoice_status_search_result = $this->is_model->searchInvoiceStatus($contractor, $tender_award_no, $invoice_no, $status);

               // Formatting dates
               foreach ($invoice_status_search_result as $key => $value) {
                    $invoice_status_search_result[$key]['invoice_date'] = (!empty($value['invoice_date'])) ? date('d-m-Y', strtotime($value['invoice_date'])) : '';
                    $invoice_status_search_result[$key]['tender_award_date'] = (!empty($value['tender_award_date'])) ? date('d-m-Y', strtotime($value['tender_award_date'])) : '';               
                    $invoice_status_search_result[$key]['period'] = (!empty($value['invoice_date'])) ? date('F', strtotime($value['invoice_date'])) : '';
               }

               $status_data = $this->is_model->getStatusData();

               $user_access_data = $this->is_model->getUserModuleAccess();
               $user_access = $this->sortUserModuleAccess($user_access_data);

               $data['invoices'] = $invoice_status_search_result;
               $data['filter_data'] = $filter_arr;
               $data['invoice_status'] = $status_data;
               $data['user_access'] = $user_access;
               $data['title'] = 'Invoice Status';

               // echo '<pre>'; print_r($data); echo '</pre>'; die();
               $this->load->view('invoice-status/invoice-status', $data); 
          }
     }

     public function viewEditInvoice($invoice_id)
     {
          $result = $this->is_model->getInvoiceData($invoice_id);

          // Formatting dates
          $result['invoice_date'] = (!empty($result['invoice_date'])) ? date('d-m-Y', strtotime($result['invoice_date'])) : '';
          $result['cis_booking_portal_date'] = (!empty($result['cis_booking_portal_date'])) ? date('d-m-Y', strtotime($result['cis_booking_portal_date'])) : '';
          $result['tender_award_date'] = (!empty($result['tender_award_date'])) ? date('d-m-Y', strtotime($result['tender_award_date'])) : '';

          $typeofinvoice_data = $this->is_model->getTypeOfInvoices();
          $typeofclaim_data = $this->is_model->getTypeOfClaims();

          $mode = 'edit';

          $data['invoice_details'] = $result;
          $data['type_of_invoices'] = $typeofinvoice_data;
          $data['type_of_claims'] = $typeofclaim_data;
          $data['mode'] = $mode;
          $data['title'] = 'Invoice Status';

          // echo '<pre>'; print_r($data); echo '</pre>'; die();
          $this->load->view('invoice-status/edit-invoice', $data);
     }

     public function editInvoiceStatus()
     {
          echo '<pre>'; print_r($_POST); echo '</pre>';
     }

     public function saveInvoice()
     {
          echo "Save Invoice Status";
     }

     public function getInvoice($contract_id, $invoice_id)
     {
          $invoice_data = [];

          $contract_data = $this->is_model->getContractorData($contract_id);
          $contract_data['tender_award_date'] = date('d-m-Y', strtotime($contract_data['tender_award_date']));

          $result = $this->is_model->getInvoicesByContract($contract_id);

          $progressive_amt = 0;
          foreach ($result as $key => $value) {
               //Formatting dates
               $result[$key]['invoice_date'] = date('d-m-Y', strtotime($value['invoice_date']));
               $result[$key]['invoice_month'] = date('F', strtotime($value['invoice_date']));
               $result[$key]['payable_amount'] = $value['invoice_amount_with_gst'];
               $progressive_amt += $value['invoice_amount_with_gst'];
               $result[$key]['progressive_amount'] = $progressive_amt;
          }

          $discom = $this->is_model->getDiscom();

          $invoice_data = $contract_data;
          $invoice_data['invoice_id'] = $invoice_id;
          $invoice_data['invoice_data'] = $result;
          $invoice_data['discom'] = $discom;

          $data['invoice_details'] = $invoice_data;
          $data['title'] = 'Invoice Status';

          // echo '<pre>'; print_r($data); echo '</pre>'; die();
          $this->load->view('invoice-status/get-invoices', $data);
     }

     public function viewInvoice($invoice_id)
     {
          $result = $this->is_model->getInvoiceData($invoice_id);

          // Formatting dates
          $result['invoice_date'] = (!empty($result['invoice_date'])) ? date('d-m-Y', strtotime($result['invoice_date'])) : '';
          $result['cis_booking_portal_date'] = (!empty($result['cis_booking_portal_date'])) ? date('d-m-Y', strtotime($result['cis_booking_portal_date'])) : '';
          $result['tender_award_date'] = (!empty($result['tender_award_date'])) ? date('d-m-Y', strtotime($result['tender_award_date'])) : '';

          $mode = 'view';

          $data['invoice_details'] = $result;
          $data['mode'] = $mode;
          $data['title'] = 'Invoice Status';

          // echo '<pre>'; print_r($data); echo '</pre>'; die();
          $this->load->view('invoice-status/edit-invoice', $data);
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