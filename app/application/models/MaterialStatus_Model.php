<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class MaterialStatus_Model extends CI_Model
{	
	function __construct()
	{
		parent::__construct();
	}

	public function getMaterialsStatusList()
	{
		$this->db->select('material_status.material_status_id, material_status.contract_id, material_status.offer_letter_no, material_status.offer_letter_date, material_status.status_id, mst_status.name as status, contract.contractor_name, contract.tender_award_no, contract.tender_award_date, contract.typeofwork_id');
		$this->db->from('material_status');
		$this->db->join('contract', 'material_status.contract_id = contract.contract_id', 'INNER');
		$this->db->join('mst_status', 'material_status.status_id = mst_status.status_id', 'INNER');
		$this->db->where(array('material_status.is_draft' => 0, 'material_status.is_active' => 1, 'material_status.deletedby' => NULL));

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

				// echo '<pre>'; print_r($query_result); echo '</pre>'; die();
				foreach ($query_result as $key => $value) {
					$query_result[$key]['tender_award_date'] = date('d-m-Y', strtotime($value['tender_award_date']));
					$query_result[$key]['offer_letter_date'] = date('d-m-Y', strtotime($value['offer_letter_date']));
					$query_result[$key]['typeofwork_name'] = $this->getTypeOfWorkName($value['typeofwork_id']);
				}
			}

			return $query_result;
		}
	}

	public function getMaterialData($material_status_id)
	{
		$this->db->select('material_status.material_status_id, material_status.contract_id, material_status.discom, material_status.offer_letter_no, material_status.offer_letter_date, material_status.offer_letter_date, contract.contractor_name, contract.tender_award_no, contract.tender_award_date, contract.typeofwork_id, mst_status.name as status');
		$this->db->from('material_status');
		$this->db->join('contract', 'material_status.contract_id = contract.contract_id' , 'INNER');
		$this->db->join('mst_status', 'material_status.status_id = mst_status.status_id', 'INNER');
		$this->db->where('material_status.material_status_id', $material_status_id);
		$this->db->where('material_status.is_draft', 0);

		$query = $this->db->get();
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			if ($query->num_rows() > 0) {
				$query_result = $query->row_array();
				// echo '<pre>'; print_r($query_result); echo '</pre>'; die();

				$query_result['typeofwork_name'] = $this->getTypeOfWorkName($query_result['typeofwork_id']);

				//Getting material details
				$material_details = $this->getAllMaterialDetails($query_result['material_status_id']);
				$query_result['material_details'] = $material_details;

				return $query_result;
			}
		}
	}

	public function searchMaterialStatus($contractor, $tender_award_no, $tkc_offer_letter_no, $di_letter_no, $status)
	{
		// $this->db->select('material_status.material_status_id, material_status.contract_id, material_status.offer_letter_no, material_status.offer_letter_date, material_status.status_id, mst_status.name as status, contract.contractor_name, contract.tender_award_no, contract.tender_award_date, contract.typeofwork_id, material_status_detail.pdi_letter_no');
		$this->db->select('material_status.material_status_id, material_status.contract_id, material_status.offer_letter_no, material_status.offer_letter_date, material_status.status_id, mst_status.name as status, contract.contractor_name, contract.tender_award_no, contract.tender_award_date, contract.typeofwork_id');
		$this->db->from('material_status');
		$this->db->join('contract', 'material_status.contract_id = contract.contract_id', 'INNER');
		$this->db->join('mst_status', 'material_status.status_id = mst_status.status_id', 'INNER');
		// $this->db->join('material_status_detail', 'material_status.material_status_id = material_status_detail.material_status_id', 'INNER');
		$this->db->where(array('material_status.is_draft' => 0, 'material_status.is_active' => 1, 'material_status.deletedby' => NULL));

		if (!empty($contractor)) {
			$this->db->like('contract.contractor_name', $contractor);
		}

		if (!empty($tender_award_no)) {
			$this->db->like('contract.tender_award_no', $tender_award_no);
		}

		if (!empty($tkc_offer_letter_no)) {
			$this->db->like('material_status.offer_letter_no', $tkc_offer_letter_no);
		}

		/*if (!empty($di_letter_no)) {
			$this->db->like('material_status_detail.pdi_letter_no', $di_letter_no);	
		}*/

		if (!empty($status)) {
			$this->db->where_in('material_status.status_id', $status);
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

				// echo '<pre>'; print_r($query_result); echo '</pre>'; die();
				foreach ($query_result as $key => $value) {
					$query_result[$key]['tender_award_date'] = date('d-m-Y', strtotime($value['tender_award_date']));
					$query_result[$key]['offer_letter_date'] = date('d-m-Y', strtotime($value['offer_letter_date']));
					$query_result[$key]['typeofwork_name'] = $this->getTypeOfWorkName($value['typeofwork_id']);
				}
			}

			return $query_result;
		}
	}

	public function saveMaterialStatus($contract_id, $discom, $tkc_offer_letter_no, $tkc_offer_letter_date, $status_id, $is_draft)
	{
		$data = array(
			'contract_id' => $contract_id,
			'discom' => $discom,
			'offer_letter_no' => $tkc_offer_letter_no,
			'offer_letter_date' => $tkc_offer_letter_date,
			'status_id' => $status_id,
			'is_draft' => $is_draft,
			'is_active' => 1,
			'createdby' => $this->getLoggedInUserID(),
			'createddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->insert('material_status', $data);

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			return $this->db->insert_id();
		}
	}

	public function updateMaterialStatus($is_draft, $material_status_id)
	{
		$data = array('is_draft' => $is_draft);
		$query = $this->db->update('material_status', $data, array('material_status_id' => $material_status_id));

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			return $this->db->affected_rows();
		}
	}

	public function deleteMaterialStatus($material_status_id)
	{
		$data = array(
			'is_active' => 0,
			'deletedby' => $this->getLoggedInUserID(),
			'deleteddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->update('material_status', $data, array('material_status_id' => $material_status_id));

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			return $this->db->affected_rows();
		}
	}

	public function getAllMaterialDetails($material_status_id)
	{
		$this->db->select('material_status_detail.material_status_detail_id, material_status_detail.material_status_id, material_status_detail.contract_material_id, material_status_detail.material_name, material_status_detail.offer_letter_quantity, material_status_detail.date_of_readiness, material_status_detail.pdi_letter_no, material_status_detail.pdi_letter_date, material_status_detail.inspection_letter_no, material_status_detail.inspection_letter_date, material_status_detail.inspecting_agency_id, material_status_detail.date_of_inspection, material_status_detail.material_serial_nos, material_status_detail.di_material_no, material_status_detail.di_material_date, material_status_detail.di_quantity, material_status_detail.mrc_generated_no, material_status_detail.mrc_generated_date, mst_inspecting_agency.name as agency_name, contract_material.quantity, contract_material.revised_quantity');
		$this->db->from('material_status_detail');
		$this->db->join('mst_inspecting_agency', 'material_status_detail.inspecting_agency_id = mst_inspecting_agency.inspecting_agency_id', 'LEFT');
		$this->db->join('contract_material', 'material_status_detail.contract_material_id = contract_material.contract_material_id', 'INNER');
		$this->db->where('material_status_detail.material_status_id', $material_status_id);

		$query = $this->db->get();
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			if ($query->num_rows() > 0) {
				$query_result = $query->result_array();

				foreach ($query_result as $key => $value) {
					//Chaning formats of all the dates
					$query_result[$key]['date_of_readiness'] = (!empty($value['date_of_readiness'])) ? date('d-m-Y', strtotime($value['date_of_readiness'])) : '';
					$query_result[$key]['pdi_letter_date'] = (!empty($value['pdi_letter_date'])) ? date('d-m-Y', strtotime($value['pdi_letter_date'])) : '';
					$query_result[$key]['inspection_letter_date'] = (!empty($value['inspection_letter_date'])) ? date('d-m-Y', strtotime($value['inspection_letter_date'])) : '';
					$query_result[$key]['date_of_inspection'] = (!empty($value['date_of_inspection'])) ? date('d-m-Y', strtotime($value['date_of_inspection'])) : '';
					$query_result[$key]['di_material_date'] = (!empty($value['di_material_date'])) ? date('d-m-Y', strtotime($value['di_material_date'])) : '';
					$query_result[$key]['mrc_generated_date'] = (!empty($value['mrc_generated_date'])) ? date('d-m-Y', strtotime($value['mrc_generated_date'])) : '';

					//Getting material details files
					$query_result[$key]['material_files'] = $this->getMaterialDetailsFiles($value['material_status_detail_id']);

					//Getting Material Received Detail
					$query_result[$key]['received_materials_details'] = $this->getReceivedMaterialDetails($value['material_status_detail_id']);

					//Getting Random Sampling Data
					$query_result[$key]['random_sampling_details'] = $this->getRandomSamplingDetails($value['material_status_detail_id']);
				}

				return $query_result;
			}
		}
	}

	// public function saveMaterialDetails($material_status_id, $contract_material_id, $material_name, $offerLetterQuantity, $dateOfReadiness, $pdiLetterNo, $pdiLetterDate, $inspectionLetterNo, $inspectionLetterDate, $inspectionAgency, $dateofInspection, $materialSerialNos, $diMaterialNo, $diMaterialDate, $diQuantity, $mrcGeneratedNo, $mrcGeneratedDate)
	public function saveMaterialDetails($material_status_id, $contract_material_id, $material_name, $offerLetterQuantity, $dateOfReadiness, $inspectionLetterNo, $inspectionLetterDate, $dateofInspection, $materialSerialNos, $diMaterialNo, $diMaterialDate, $diQuantity, $diRemark, $mrcGeneratedNo, $mrcGeneratedDate)
	{
		$data = array(
			'material_status_id' => $material_status_id,
			'contract_material_id' => $contract_material_id,
			'material_name' => $material_name,
			'offer_letter_quantity' => $offerLetterQuantity,
			'date_of_readiness' => $dateOfReadiness,
			// 'pdi_letter_no' => empty($pdiLetterNo) ? NULL : $pdiLetterNo,
			// 'pdi_letter_date' => empty($pdiLetterDate) ? NULL : date('Y-m-d', strtotime($pdiLetterDate)),
			'inspection_letter_no' => $inspectionLetterNo,
			'inspection_letter_date' => $inspectionLetterDate, 
			// 'inspecting_agency_id' => empty($inspectionAgency) ? NULL : $inspectionAgency, 
			'date_of_inspection' => $dateofInspection,
			'material_serial_nos' => $materialSerialNos,
			'di_material_no' => $diMaterialNo,
			'di_material_date' => $diMaterialDate, 
			'di_quantity' => $diQuantity,
			'di_remarks' => $diRemark,
			'mrc_generated_no' => $mrcGeneratedNo, 
			'mrc_generated_date' => $mrcGeneratedDate,
			'is_active' => 1,
			'createdby' => $this->getLoggedInUserID(),
			'createddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->insert('material_status_detail', $data);

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$insert_id = $this->db->insert_id();
			return $insert_id;
		}
	}

	// public function updateMaterialDetails($material_status_detail_id, $offer_letter_qty, $date_of_readiness, $pdi_letter_no, $pdi_letter_date, $inspection_letter_no, $inspection_letter_date, $inspection_agency_id, $date_of_inspection, $material_serial_nos, $di_material_no, $di_material_date, $di_qty, $mrc_generated_no, $mrc_generated_date)
	public function updateMaterialDetails($material_status_detail_id, $offer_letter_qty, $date_of_readiness, $inspection_letter_no, $inspection_letter_date, $date_of_inspection, $material_serial_nos, $di_material_no, $di_material_date, $di_qty, $di_remark, $mrc_generated_no, $mrc_generated_date)
	{
		$data = array(
			'offer_letter_quantity' => $offer_letter_qty,
			'date_of_readiness' => $date_of_readiness,
			// 'pdi_letter_no' => $pdi_letter_no,
			// 'pdi_letter_date' => $pdi_letter_date,
			'inspection_letter_no' => $inspection_letter_no,
			'inspection_letter_date' => $inspection_letter_date,
			// 'inspecting_agency_id' => $inspection_agency_id,
			'date_of_inspection' => $date_of_inspection,
			'material_serial_nos' => $material_serial_nos,
			'di_material_no' => $di_material_no,
			'di_material_date' => $di_material_date,
			'di_quantity' => $di_qty,
			'di_remarks' => $di_remark,
			'mrc_generated_no' => $mrc_generated_no,
			'mrc_generated_date' => $mrc_generated_date,
			'modifiedby' => $this->getLoggedInUserID(),
			'modifieddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->update('material_status_detail', $data, array('material_status_detail_id' => $material_status_detail_id));
		// echo $this->db->last_query(); die();
		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			return $this->db->affected_rows();
		}
	}

	public function deleteMaterialStatusDetail($material_status_detail_id)
	{
		$data = array(
			'is_active' => 0,
			'deletedby' => $this->getLoggedInUserID(),
			'deleteddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->update('material_status_detail', $data, array('material_status_detail_id' => $material_status_detail_id));

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			return $this->db->affected_rows();
		}
	}

	public function getMaterialDetails($material_status_detail_id)
	{
		$this->db->select('material_status_detail.material_status_detail_id, material_status_detail.material_status_id, material_status_detail.contract_material_id, material_status_detail.material_name, material_status_detail.offer_letter_quantity, material_status_detail.date_of_readiness, material_status_detail.pdi_letter_no, material_status_detail.pdi_letter_date, material_status_detail.inspection_letter_no, material_status_detail.inspection_letter_date, material_status_detail.inspecting_agency_id, material_status_detail.date_of_inspection, material_status_detail.material_serial_nos, material_status_detail.di_material_no, material_status_detail.di_material_date, material_status_detail.di_quantity, material_status_detail.di_remarks, material_status_detail.mrc_generated_no, material_status_detail.mrc_generated_date, mst_inspecting_agency.name as agency_name, contract_material.quantity, contract_material.revised_quantity');
		$this->db->from('material_status_detail');
		$this->db->join('mst_inspecting_agency','material_status_detail.inspecting_agency_id = mst_inspecting_agency.inspecting_agency_id', 'LEFT');
		$this->db->join('contract_material', 'material_status_detail.contract_material_id = contract_material.contract_material_id');
		$this->db->where('material_status_detail_id', $material_status_detail_id);

		$query = $this->db->get();
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			if ($query->num_rows() > 0) {
				$query_result = $query->row_array();

				// echo '<pre>'; print_r($query_result); echo '</pre>'; die();

				//Chaning formats of all the dates
				$query_result['date_of_readiness'] = (!empty($query_result['date_of_readiness'])) ? date('d-m-Y', strtotime($query_result['date_of_readiness'])) : NULL;
				$query_result['pdi_letter_date'] = (!empty($query_result['pdi_letter_date'])) ? date('d-m-Y', strtotime($query_result['pdi_letter_date'])) : NULL;
				$query_result['inspection_letter_date'] = (!empty($query_result['inspection_letter_date'])) ? date('d-m-Y', strtotime($query_result['inspection_letter_date'])) : NULL;
				$query_result['date_of_inspection'] = (!empty($query_result['date_of_inspection'])) ? date('d-m-Y', strtotime($query_result['date_of_inspection'])) : NULL;
				$query_result['di_material_date'] = (!empty($query_result['di_material_date'])) ? date('d-m-Y', strtotime($query_result['di_material_date'])) : NULL;
				$query_result['mrc_generated_date'] = (!empty($query_result['mrc_generated_date'])) ? date('d-m-Y', strtotime($query_result['mrc_generated_date'])) : NULL;

				//Getting material files
				$query_result['material_files'] = $this->getMaterialDetailsFiles($material_status_detail_id);

				//Getting Material Received Detail
				$query_result['received_materials_details'] = $this->getReceivedMaterialDetails($material_status_detail_id);

				//Getting Random Sampling Data
				$query_result['random_sampling_details'] = $this->getRandomSamplingDetails($material_status_detail_id);

				return $query_result;
			}
		}
	}

	public function getMaterialStatusDetailData($material_status_id, $contract_material_id)
	{
		$query = $this->db->get_where('material_status_detail', array('material_status_id' => $material_status_id, 'contract_material_id' => $contract_material_id));
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

	public function getMaterialStatusDetailIDs($material_status_id)
	{
		$this->db->select('material_status_detail_id');
		$query = $this->db->get_where('material_status_detail', array('material_status_id' => $material_status_id));
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

	public function saveMaterialReceivedDetails($material_status_detail_id, $circle_id, $received_qty, $serial_no, $received_date)
	{
		$data = array(
			'material_status_detail_id' => $material_status_detail_id,
			'circle_id' => $circle_id,
			'quantity' => $received_qty,
			'serial_nos' => $serial_no,
			'received_date' => $received_date,
			'is_active' => 1,
			'createdby' => $this->getLoggedInUserID(),
			'createddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->insert('material_status_material_received_detail', $data);

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$insert_id = $this->db->insert_id();
			return $insert_id;
		}
	}

	public function updateMaterialReceivedDetails($material_status_detail_id, $circle_id, $received_qty, $serial_no, $received_date)
	{
		$data = array(
			'quantity' => $received_qty,
			'serial_nos' => $serial_no,
			'received_date' => $received_date,
			'modifiedby' => $this->getLoggedInUserID(),
			'modifieddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->update('material_status_material_received_detail', $data, array('material_status_detail_id' => $material_status_detail_id, 'circle_id' => $circle_id));
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			return $this->db->affected_rows();
		}
	}

	public function saveRandomSamplingDetails($material_status_detail_id, $circle_id, $sampling_qty, $sampling_serial_no, $sampling_date, $sampling_letter_no, $sampling_lab, $accepted_report_no, $accepted_report_date, $accepted_qty)
	{
		$data = array(
			'material_status_detail_id' => $material_status_detail_id,
			'circle_id' => $circle_id,
			'sampling_quantity' => $sampling_qty, 
			'sampling_serial_nos' => $sampling_serial_no,
			'sampling_date' => $sampling_date, 
			'sampling_letter_no' => $sampling_letter_no,
			'sampling_lab_id' => $sampling_lab,
			'accepted_report_no' => $accepted_report_no,
			'accepted_report_date' => $accepted_report_date,
			'accepted_quantity' => $accepted_qty,
			'is_active' => 1,
			'createdby' => $this->getLoggedInUserID(),
			'createddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->insert('material_status_random_sampling_detail', $data);

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$insert_id = $this->db->insert_id();
			return $insert_id;
		}
	}

	public function updateRandomSamplingDetails($material_status_detail_id, $circle_id, $sampling_qty, $sampling_serial_no, $sampling_date, $sampling_letter_no, $sampling_lab_id, $accepted_report_no, $accepted_report_date, $accepted_qty)
	{
		$data = array(
			'sampling_quantity' => $sampling_qty,
			'sampling_serial_nos' => $sampling_serial_no, 
			'sampling_date' => $sampling_date,
			'sampling_letter_no' => $sampling_letter_no, 
			'sampling_lab_id' => $sampling_lab_id, 
			'accepted_report_no' => $accepted_report_no, 
			'accepted_report_date' => $accepted_report_date, 
			'accepted_quantity' => $accepted_qty,
			'modifiedby' => $this->getLoggedInUserID(),
			'modifieddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->update('material_status_random_sampling_detail', $data, array('material_status_detail_id' => $material_status_detail_id, 'circle_id' => $circle_id));
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			return $this->db->affected_rows();
		}
	}

	public function getMaterialDetailsFiles($material_status_detail_id)
	{
		$this->db->select('material_status_detail_file_id, file_path');
		$query = $this->db->get_where('material_status_detail_file', array('material_status_detail_id' => $material_status_detail_id, 'deletedby' => NULL));
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

	public function checkMaterialFileExists($material_status_detail_id)
	{
		$query = $this->db->get_where('material_status_detail_file', array('material_status_detail_id' => $material_status_detail_id));
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$query_result = 0;			
			if ($query->num_rows() > 0) {
				$query_result = $query->num_rows();
			}

			return $query_result;
		}
	}

	public function deleteMaterialStatusDetailFiles($material_status_detail_id)
	{
		$data = array(
			'is_active' => 0,
			'deletedby' => $this->getLoggedInUserID(),
			'deleteddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->update('material_status_detail_file', $data, array('material_status_detail_id' => $material_status_detail_id));
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			return $this->db->affected_rows();
		}
	}

	public function getReceivedMaterialDetails($material_status_detail_id)
	{
		$this->db->select('material_status_material_received_detail.material_received_detail_id, material_status_material_received_detail.material_status_detail_id, material_status_material_received_detail.circle_id, material_status_material_received_detail.quantity, material_status_material_received_detail.serial_nos, material_status_material_received_detail.received_date, mst_circle.circle_name');
		$this->db->from('material_status_material_received_detail');
		$this->db->join('mst_circle', 'material_status_material_received_detail.circle_id = mst_circle.circle_id', 'INNER');
		$this->db->where(array('material_status_detail_id' => $material_status_detail_id));
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

				foreach ($query_result as $key => $value) {
					$query_result[$key]['received_date'] = (!empty($value['received_date'])) ? date('d-m-Y', strtotime($value['received_date'])) : '';
				}
			}

			return $query_result;
		}
	}

	public function deleteMaterialReceivedData($material_status_detail_id)
	{
		$data = array(
			'is_active' => 0,
			'deletedby' => $this->getLoggedInUserID(),
			'deleteddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->update('material_status_material_received_detail', $data, array('material_status_detail_id' => $material_status_detail_id));
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			return $this->db->affected_rows();
		}
	}

	public function checkMaterialReceivedCircleExists($material_status_detail_id, $circle_id)
	{
		$query = $this->db->get_where('material_status_material_received_detail', array('material_status_detail_id' => $material_status_detail_id, 'circle_id' => $circle_id));
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

	public function getRandomSamplingDetails($material_status_detail_id)
	{
		/*$this->db->select('material_status_random_sampling_detail.random_sampling_detail_id, material_status_random_sampling_detail.material_status_detail_id, material_status_random_sampling_detail.circle_id, material_status_random_sampling_detail.sampling_quantity, material_status_random_sampling_detail.sampling_serial_nos, material_status_random_sampling_detail.sampling_date, material_status_random_sampling_detail.sampling_letter_no, material_status_random_sampling_detail.sampling_lab_id, material_status_random_sampling_detail.accepted_report_no, material_status_random_sampling_detail.accepted_report_date, material_status_random_sampling_detail.accepted_quantity, mst_sampling_lab.lab_name, mst_circle.circle_name');
		$this->db->from('material_status_random_sampling_detail');
		$this->db->join('mst_sampling_lab', 'material_status_random_sampling_detail.sampling_lab_id = mst_sampling_lab.sampling_lab_id', 'INNER');
		$this->db->join('mst_circle', 'material_status_random_sampling_detail.circle_id = mst_circle.circle_id', 'INNER');
		$this->db->where('material_status_detail_id', $material_status_detail_id);*/

		$this->db->select('material_status_random_sampling_detail.random_sampling_detail_id, material_status_random_sampling_detail.material_status_detail_id, material_status_random_sampling_detail.circle_id, material_status_random_sampling_detail.sampling_quantity, material_status_random_sampling_detail.sampling_serial_nos, material_status_random_sampling_detail.sampling_date, material_status_random_sampling_detail.sampling_letter_no, material_status_random_sampling_detail.sampling_lab_id, material_status_random_sampling_detail.accepted_report_no, material_status_random_sampling_detail.accepted_report_date, material_status_random_sampling_detail.accepted_quantity,  mst_circle.circle_name');
		$this->db->from('material_status_random_sampling_detail');
		$this->db->join('mst_circle', 'material_status_random_sampling_detail.circle_id = mst_circle.circle_id', 'INNER');
		$this->db->where('material_status_detail_id', $material_status_detail_id);

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

				foreach ($query_result as $key => $value) {
					// $query_result[$key]['sampling_date'] = (!empty($value['sampling_date'])) ? date('d-m-Y', strtotime($value['sampling_date'])) : '';
					
					//Check with Sir
					$query_result[$key]['sampling_date'] = ($value['sampling_date'] == '0000-00-00') ? '' : (!empty($value['sampling_date']) ? date('d-m-Y', strtotime($value['sampling_date'])) : '');
					$query_result[$key]['sampling_quantity'] = ($value['sampling_quantity'] == 0.00) ? '' : $value['sampling_quantity'];
					$query_result[$key]['sampling_lab_id'] = ($value['sampling_lab_id'] == '0') ? '' : $value['sampling_lab_id'];
					$query_result[$key]['accepted_report_no'] = ($value['accepted_report_no'] == null) ? '' : $value['accepted_report_no'] ;

					$query_result[$key]['accepted_report_date'] = (!empty($value['accepted_report_date'])) ? date('d-m-Y', strtotime($value['accepted_report_date'])) : '';
				}
			}

			return $query_result;
		}
	}

	public function deleteRandomSamplingData($material_status_detail_id)
	{
		$data = array(
			'is_active' => 0,
			'deletedby' => $this->getLoggedInUserID(),
			'deleteddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->update('material_status_random_sampling_detail', $data, array('material_status_detail_id' => $material_status_detail_id));
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			return $this->db->affected_rows();
		}
	}

	public function checkRandomSamplingCircleExists($material_status_detail_id, $circle_id)
	{
		$query = $this->db->get_where('material_status_random_sampling_detail', array('material_status_detail_id' => $material_status_detail_id, 'circle_id' => $circle_id));
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

	public function saveMaterialStatusDetailsFile($material_status_detail_id, $targetFilePath)
	{
		$data = array(
			'material_status_detail_id' => $material_status_detail_id,
			'file_path' => $targetFilePath,
			'is_active' => 1,
			'createdby' => $this->getLoggedInUserID(),
			'createddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->insert('material_status_detail_file', $data);

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$insert_id = $this->db->insert_id();
			return $insert_id;
		}
	}

	public function getMaterialStatusDetailsFile($material_status_detail_id)
	{
		$this->db->select('file_path');
		$query = $this->db->get_where('material_status_detail_file', array('material_status_detail_id' => $material_status_detail_id));
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

	public function getContractorData($contractor)
	{
		$this->db->select('contract_id, contractor_name, tender_award_no, tender_award_date, typeofwork_id');

		if (!empty($contractor)) {
			$this->db->like('contractor_name', $contractor);	
		}
		
		$query = $this->db->get('contract');
		// echo $this->db->last_query();

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$query_result = [];

			if ($query->num_rows() > 0) {
				$query_result = $query->result_array();

				foreach ($query_result as $key => $value) {
					$query_result[$key]['tender_award_date'] = date('d-m-Y', strtotime($value['tender_award_date']));
					$query_result[$key]['typeofwork_name'] = $this->getTypeOfWorkName($value['typeofwork_id']);
				}
			}

			return $query_result;
		}
	}

	public function checkContractExists($contract_id)
	{
		$query = $this->db->get_where('material_status', array('contract_id' => $contract_id, 'is_draft' => 0, 'is_active' => 1, 'deletedby' => NULL));

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

	public function getMaterials($contract_id)
	{
		$this->db->select('contract_material_id, contract_id, item_code, equipment_material_name, unit_id, quantity');
		$this->db->where('contract_id', $contract_id);
		$query = $this->db->get('contract_material');
		// echo $this->db->last_query();

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

	public function getMaterialQuantities($material_id)
	{
		$this->db->select('contract_material_id, quantity, revised_quantity');
		$query = $this->db->get_where('contract_material', array('contract_material_id' => $material_id));
		// echo $this->db->last_query();

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

	public function getMaterialAcceptedQuantityData($material_status_detail_id)
	{
		$this->db->select('accepted_quantity, accepted_report_date');
		$query = $this->db->get_where('material_status_random_sampling_detail', array('material_status_detail_id' => $material_status_detail_id));
		//echo $this->db->last_query(); die();

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

	public function getInspectingAgencies()
	{
		$this->db->select('inspecting_agency_id, name');
		$query = $this->db->get('mst_inspecting_agency');
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {			
			if ($query->num_rows() > 0) {
				$query_result = $query->result_array();

				return $query_result;
			}
		}
	}

	public function getSamplingLabData()
	{
		$this->db->select('sampling_lab_id, lab_name');
		$query = $this->db->get('mst_sampling_lab');
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			if ($query->num_rows() > 0) {
				$query_result = $query->result_array();

				return $query_result;
			}
		}
	}

	public function getSamplingLabID($sampling_lab_name)
	{
		$this->db->select('sampling_lab_id');
		$query = $this->db->get_where('mst_sampling_lab', array('lab_name' => $sampling_lab_name));
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$query_result = 0;
			if ($query->num_rows() > 0) {
				$result = $query->row_array();
				$query_result = $result['sampling_lab_id'];
			}

			return $query_result;
		}
	}

	public function getTypeOfWorkList()
	{
		$query = $this->db->select('typeofwork_id, name')->get('mst_typeofwork');
		
		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			if ($query->num_rows() > 0) {
				$query_result = $query->result_array();

				return $query_result;
			}
		}
	}

	public function getTypeOfWorkName($work_id)
	{
		$query = $this->db->get_where('mst_typeofwork', array('typeofwork_id' => $work_id));

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			if ($query->num_rows() > 0) {
				$query_result = $query->row_array();

				return $query_result['name'];
			}
		}
	}

	public function getCircleList($contract_id)
	{
		$this->db->distinct();
		$this->db->select('contract_location.circle_id, mst_circle.circle_name');
		$this->db->from('contract_location');
		$this->db->join('mst_circle', 'contract_location.circle_id = mst_circle.circle_id', 'INNER');
		$this->db->where('contract_location.contract_id', $contract_id);
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

	public function getCircleID($circle_name)
	{
		$this->db->select('circle_id');
		$query = $this->db->get_where('mst_circle', array('circle_name' => $circle_name));
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$query_result = 0;			
			if ($query->num_rows() > 0) {
				$query_result = $query->row_array();
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

	public function getStatusData()
	{
		$this->db->select('mst_module.module_id, mst_module.name, mst_status.status_id, mst_status.name');
		$this->db->from('mst_module');
		$this->db->join('mst_status', 'mst_module.module_id = mst_status.module_id', 'INNER');
		$this->db->where(array('mst_module.name' => 'Material Status'));

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

	public function getUserModuleAccess()
	{
		$user_id = $this->getLoggedInUserID();

		$this->db->select('mst_user.role_id, mst_module.name, mst_role_module_access.module_access_id, mst_module_access.module_id, mst_module_access.access_key, mst_module_access.event');
		$this->db->from('mst_user');
		$this->db->join('mst_role_module_access', 'mst_user.role_id = mst_role_module_access.role_id', 'INNER');
		$this->db->join('mst_module_access', 'mst_role_module_access.module_access_id = mst_module_access.module_access_id', 'INNER');
		$this->db->join('mst_module', 'mst_module_access.module_id = mst_module.module_id', 'INNER');
		$this->db->where(array('mst_module.name' => 'Material Status', 'mst_module.icon !=' => '', 'mst_user.user_id' => $user_id));
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

}

?>