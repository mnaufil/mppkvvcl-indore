<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class InvoiceStatus_Model extends CI_Model
{	
	function __construct()
	{
		parent::__construct();
	}

	public function getInvoiceList()
	{
		$this->db->select('invoice.invoice_id, invoice.invoice_no, invoice.invoice_date, invoice.invoice_amount_with_gst, invoice.contract_id, invoice.type_of_invoice_id, invoice.balance_to_claim, invoice.balance_to_pay, invoice.status_id, contract.contract_id, contract.contractor_name, contract.tender_award_no, contract.tender_award_date, contract.typeofwork_id, mst_typeofwork.name AS typeofwork_name, mst_type_of_invoice.name AS invoice_type, mst_status.name AS status');
		$this->db->from('invoice');
		$this->db->join('contract', 'invoice.contract_id = contract.contract_id', 'INNER');
		$this->db->join('mst_typeofwork', 'contract.typeofwork_id = mst_typeofwork.typeofwork_id', 'INNER');
		$this->db->join('mst_type_of_invoice', 'invoice.type_of_invoice_id = mst_type_of_invoice.type_of_invoice_id', 'INNER');
		$this->db->join('mst_status', 'invoice.status_id = mst_status.status_id', 'INNER');
		$this->db->where(array('invoice.is_active' => 1, 'invoice.deletedby' => NULL));

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

	public function searchInvoiceStatus($contractor, $tender_award_no, $invoice_no, $status)
	{
		$this->db->select('invoice.invoice_id, invoice.invoice_no, invoice.invoice_date, invoice.invoice_amount_with_gst, invoice.contract_id, invoice.type_of_invoice_id, invoice.balance_to_claim, invoice.balance_to_pay, invoice.status_id, contract.contract_id, contract.contractor_name, contract.tender_award_no, contract.tender_award_date, contract.typeofwork_id, mst_typeofwork.name AS typeofwork_name, mst_type_of_invoice.name AS invoice_type, mst_status.name AS status');
		$this->db->from('invoice');
		$this->db->join('contract', 'invoice.contract_id = contract.contract_id', 'INNER');
		$this->db->join('mst_typeofwork', 'contract.typeofwork_id = mst_typeofwork.typeofwork_id', 'INNER');
		$this->db->join('mst_type_of_invoice', 'invoice.type_of_invoice_id = mst_type_of_invoice.type_of_invoice_id', 'INNER');
		$this->db->join('mst_status', 'invoice.status_id = mst_status.status_id', 'INNER');
		$this->db->where(array('invoice.is_active' => 1, 'invoice.deletedby' => NULL));

		if (!empty($contractor)) {
			$this->db->like('contract.contractor_name', $contractor);
		}

		if (!empty($tender_award_no)) {
			$this->db->like('contract.tender_award_no', $tender_award_no);
		}

		if (!empty($invoice_no)) {
			$this->db->like('invoice.invoice_no', $invoice_no);
		}

		if (!empty($status)) {
			$this->db->where_in('invoice.status_id', $status);
		}

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

	public function getInvoiceData($invoice_id)
	{
		$this->db->select('invoice.invoice_id, invoice.invoice_no, invoice.invoice_date, invoice.contract_id, invoice.type_of_invoice_id, invoice.cis_booking_portal_date, invoice.invoice_amount_without_gst, invoice.gst_amount, invoice.invoice_amount_with_gst, invoice.di_emb_no, invoice.balance_to_claim, invoice.balance_to_pay, contract.contractor_name, contract.package_no, contract.tender_award_no, contract.tender_award_date, contract.typeofwork_id, mst_typeofwork.name AS typeofwork_name, mst_type_of_invoice.name AS invoice_type');
		$this->db->from('invoice');
		$this->db->join('contract', 'invoice.contract_id = contract.contract_id', 'INNER');
		$this->db->join('mst_typeofwork', 'contract.typeofwork_id = mst_typeofwork.typeofwork_id', 'INNER');
		$this->db->join('mst_type_of_invoice', 'invoice.type_of_invoice_id = mst_type_of_invoice.type_of_invoice_id', 'INNER');
		$this->db->where(array('invoice.invoice_id' => $invoice_id));

		$query = $this->db->get();
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$query_result = [];

			if ($query->num_rows() > 0) {
				$query_result = $query->row_array();

				$claim_result = $this->getInvoiceClaimDetails($invoice_id);
				$query_result['claim_payment_data'] = $claim_result;
			}

			return $query_result;
		}
	}

	public function getInvoicesByContract($contract_id)
	{
		$this->db->select('invoice.type_of_invoice_id, invoice.invoice_no, invoice.invoice_date, invoice.invoice_amount_with_gst, invoice.di_emb_no, mst_type_of_invoice.name AS invoice_type');
		$this->db->from('invoice');
		$this->db->join('mst_type_of_invoice', 'invoice.type_of_invoice_id = mst_type_of_invoice.type_of_invoice_id', 'INNER');
		$this->db->where(array('invoice.contract_id' => $contract_id));
		$this->db->order_by('invoice.invoice_date', 'ASC');

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

	public function getInvoiceClaimDetails($invoice_id)
	{
		$this->db->select('invoice_claim.invoice_claim_id, invoice_claim.claim_type_id, invoice_claim.claim_amount_with_gst, invoice_claim.moblisation_adv_adjusted_amount, invoice_claim.ld_amount, invoice_claim.interest_on_moblisation_adv_amount, invoice_claim.other_deductions_amount, invoice_claim.tds_gsttds_amount, invoice_claim.payable_amount, invoice_claim.balance_to_pay_amount, mst_type_of_claim.name AS claim_type');
		$this->db->from('invoice_claim');
		$this->db->join('mst_type_of_claim', 'invoice_claim.claim_type_id = mst_type_of_claim.type_of_claim_id', 'INNER');
		$this->db->where(array('invoice_claim.invoice_id' => $invoice_id));

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
				// echo 'query_result: <pre>'; print_r($query_result); echo '</pre>'; die();

				// Check if required later
				foreach ($query_result as $key => $value) {
					$query_result[$key]['balance_to_pay_amount'] = ($value['balance_to_pay_amount'] != NULL) ? $value['balance_to_pay_amount'] : 0.00;

					$payment_details_data = $this->getInvoicePaymentDetails($value['invoice_claim_id']);
					$query_result[$key]['payment_details_data'] = $payment_details_data;
				}

			}

			return $query_result;
		}
	}

	public function getInvoicePaymentDetails($invoice_claim_id)
	{
		$this->db->select('invoice_payment_details_id, paid_amount, paid_date');
		$query = $this->db->get_where('invoice_payment_details', array('invoice_claim_id' => $invoice_claim_id));
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$query_result = [];

			if ($query->num_rows() > 0) {
				$query_result = $query->result_array();
				
				foreach ($query_result as $key => $value) {
					$query_result[$key]['paid_date'] = date('d-m-Y', strtotime($value['paid_date']));
					$query_result[$key]['paid_amount'] = number_format($value['paid_amount'], 2);
				}
			}

			return $query_result;
		}
	}

	public function getTypeOfInvoices()
	{
		$query = $this->db->get_where('mst_type_of_invoice', array('is_active' => 1));
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

	public function getTypeOfClaims()
	{
		$this->db->select('type_of_claim_id, name');
		$query = $this->db->get_where('mst_type_of_claim', array('is_active' => 1));
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

	public function getContractorData($contract_id)
	{
		$this->db->select('contract.contract_id, contract.contractor_name, contract.tender_award_no, contract.tender_award_date, contract.typeofwork_id, contract.quoted_price_with_gst AS contract_amount, mst_typeofwork.name AS typeofwork_name');
		$this->db->from('contract');
		$this->db->join('mst_typeofwork', 'contract.typeofwork_id = mst_typeofwork.typeofwork_id', 'INNER');
		$this->db->where(array('contract.contract_id' => $contract_id));

		$query = $this->db->get();
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

	public function getStatusData()
	{
		$this->db->select('mst_module.module_id, mst_module.name, mst_status.status_id, mst_status.name');
		$this->db->from('mst_module');
		$this->db->join('mst_status', 'mst_module.module_id = mst_status.module_id', 'INNER');
		$this->db->where(array('mst_module.name' => 'Invoice Status'));

		$query = $this->db->get();
		// echo $this->db->last_query();	 die();

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

	public function getSheetStatus($status_id)
	{
		$query = $this->db->get_where('mst_status', array('status_id' => $status_id));

		if ($query->num_rows() > 0) {
			$query_result = $query->row_array();
			return $query_result['name'];
		} else {
			return 'Not Found';
		}
	}

	public function getDiscom()
	{
		$this->db->select('fieldvalue');
		$query = $this->db->get_where('sysconfig', array('display_name' => 'DISCOM'));
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$query_result = '';

			if ($query->num_rows() > 0) {
				$result = $query->row_array();
				$query_result = $result['fieldvalue'];
			}

			return $query_result;
		}
	}

	public function getUserModuleAccess()
	{
		$user_id = $this->getLoggedInUserID();

		$this->db->select('mst_user.role_id, mst_module.name, mst_role_module_access.module_access_id, mst_module_access.module_id, mst_module_access.access_key, mst_module_access.event');
		$this->db->from('mst_user');
		$this->db->join('mst_role_module_access', 'mst_user.role_id = mst_role_module_access.role_id', 'INNER');
		$this->db->join('mst_module_access', 'mst_role_module_access.module_access_id = mst_module_access.module_access_id', 'INNER');
		$this->db->join('mst_module', 'mst_module_access.module_id = mst_module.module_id', 'INNER');
		$this->db->where(array('mst_module.name' => 'Invoice Status', 'mst_user.user_id' => $user_id));
		$this->db->where(array('mst_role_module_access.is_active' => 1, 'mst_module_access.is_active' => 1, 'mst_module.is_active' => 1));

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

	public function getLoggedInUserID()
	{
		$userdata = $_SESSION['loggedData'];
		return $userdata->user_id;
	}
}

?>