<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class DataImport_Model extends CI_Model
{	
	function __construct()
	{
		parent::__construct();
	}

	public function getAllImportDetails()
	{
		$this->db->select('import_hdr.import_hdr_id, import_hdr.import_type, import_hdr.sub_type, import_hdr.status, import_hdr.createdby, import_hdr.createddate, mst_user.username AS imported_by');
		$this->db->from('import_hdr');
		$this->db->join('mst_user', 'import_hdr.createdby = mst_user.user_id', 'INNER');

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
					$import_records = $this->getImportRecordsCount($value['import_hdr_id'], $value['import_type'], $value['sub_type']);
					$query_result[$key]['import_records'] = $import_records;
				}
			}

			return $query_result;
		}
	}

	public function getImportRecordsCount($import_hdr_id, $import_type, $sub_type)
	{
		$import_type = strtolower(str_replace(' ', '_', $import_type));
		$sub_type = strtolower(str_replace(' ', '_', $sub_type));

		$table = 'import_dtl_'.$import_type.'_'.$sub_type;

		$this->db->where(array('import_hdr_id' => $import_hdr_id, 'is_active' => 1, 'deletedby' => NULL));
		$query = $this->db->count_all_results($table);
		// echo $this->db->last_query(); die();

		return $query;
	}

	public function getImportDetails($import_hdr_id)
	{
		$this->db->select('import_type, sub_type');
		$query = $this->db->get_where('import_hdr', array('import_hdr_id' => $import_hdr_id));
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

	public function getAllImportTypes()
	{
		$this->db->select('import_type_id, type_name');
		$query = $this->db->get_where('mst_import_type', array('is_active' => 1));
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

	public function getAllImportSubTypes()
	{
		$this->db->select('mst_import_sub_type.import_sub_type_id, mst_import_sub_type.sub_type_name, mst_import_type.type_name');
		$this->db->from('mst_import_sub_type');
		$this->db->join('mst_import_type', 'mst_import_sub_type.import_type_id = mst_import_type.import_type_id', 'INNER');
		$this->db->where(array('mst_import_sub_type.is_active' => 1, 'mst_import_type.is_active' => 1));

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

	public function saveImportTypes($import_type, $import_sub_type)
	{
		$data = array(
			'import_type' => $import_type,
			'sub_type' => $import_sub_type,
			'status' => 1,
			'createdby' => $this->getLoggedInUserID(),
			'createddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->insert('import_hdr', $data);

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$insert_id = $this->db->insert_id();
			return $insert_id;
		}
	}

	public function updateImportTypes($import_hdr_id, $import_type, $import_sub_type)
	{
		$data = array(
			'import_type' => $import_type,
			'sub_type' => $import_sub_type,
			'status' => 1,
			'modifiedby' => $this->getLoggedInUserID(),
			'modifieddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->update('import_hdr', $data, array('import_hdr_id' => $import_hdr_id));

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			return $import_hdr_id;
		}
	}

	public function saveMaterialInwardData($import_hdr_id, $worksheet_arr)
	{
		$record_exists = $this->checkRecordExists($import_hdr_id, 'import_dtl_material_inward');

		if ($record_exists > 0) {
			$this->deleteExistingRecords($import_hdr_id, 'import_dtl_material_inward');
		}

		foreach ($worksheet_arr as $key => $value) {
			$data = array(
				'import_hdr_id' => $import_hdr_id,
				'lot_no' => $value[0],
				'circle' => $value[1],
				'item_code' => $value[2],
				'material_description' => $value[3],
				'unit' => $value[4],
				'name_of_vendor' => $value[5],
				'di_no' => $value[6],
				'di_date' => $value[7],
				'di_quantity' => $value[8],
				'received_quantity' => $value[9],
				'received_date' => $value[10],
				'is_active' => 1,
				'createdby' => $this->getLoggedInUserID(),
				'createddate' => date('Y-m-d H:i:s')
			);

			$query = $this->db->insert('import_dtl_material_inward', $data);

			if (!$query) {
				$error = $this->db->error();	
				echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
				die();
			}
		}
	}

	public function saveMaterialInwardMICCData($import_hdr_id, $worksheet_arr)
	{
		$record_exists = $this->checkRecordExists($import_hdr_id, 'import_dtl_material_inward_micc');

		if ($record_exists > 0) {
			$this->deleteExistingRecords($import_hdr_id, 'import_dtl_material_inward_micc');
		}

		foreach ($worksheet_arr as $key => $value) {
			$data = array(
				'import_hdr_id' => $import_hdr_id,
				'lot_no' => $value[0],
				'circle' => $value[1],
				'item_code' => $value[2],
				'material_description' => $value[3],
				'unit' => $value[4],
				'name_of_vendor' => $value[5],
				'di_no' => $value[6],
				'di_date' => $value[7],
				'di_quantity' => $value[8],
				'received_quantity' => $value[9],
				'received_date' => $value[10],
				'sampling_quantity' => $value[11],
				'sampling_seal_date' => $value[12],
				'micc_no' => $value[13],
				'micc_date' => $value[14],
				'billing_status' => $value[15],
				'amount_in_cr_60' => $value[16],
				'amount_in_cr_100' => $value[17],
				'remark' => $value[18],
				'is_active' => 1,
				'createdby' => $this->getLoggedInUserID(),
				'createddate' => date('Y-m-d H:i:s')
			);

			$query = $this->db->insert('import_dtl_material_inward_micc', $data);

			if (!$query) {
				$error = $this->db->error();	
				echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
				die();
			}
		}
	}

	public function saveMaterialInwardReturnData($import_hdr_id, $worksheet_arr)
	{
		$record_exists = $this->checkRecordExists($import_hdr_id, 'import_dtl_material_inward_return');

		if ($record_exists > 0) {
			$this->deleteExistingRecords($import_hdr_id, 'import_dtl_material_inward_return');
		}

		foreach ($worksheet_arr as $key => $value) {
			$data = array(
				'import_hdr_id' => $import_hdr_id,
				'lot_no' => $value[0],
				'circle' => $value[1],
				'item_code' => $value[2],
				'material_description' => $value[3],
				'unit' => $value[4],
				'name_of_vendor' => $value[5],
				'di_no' => $value[6],
				'di_date' => $value[7],
				'di_quantity' => $value[8],
				'received_quantity' => $value[9],
				'received_date' => $value[10],
				'returned_quantity' => $value[11],
				'returned_date' => $value[12],
				'is_active' => 1,
				'createdby' => $this->getLoggedInUserID(),
				'createddate' => date('Y-m-d H:i:s')
			);

			$query = $this->db->insert('import_dtl_material_inward_return', $data);

			if (!$query) {
				$error = $this->db->error();	
				echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
				die();
			}
		}
	}

	public function saveMaterialInwardSamplingData($import_hdr_id, $worksheet_arr)
	{
		$record_exists = $this->checkRecordExists($import_hdr_id, 'import_dtl_material_inward_sampling');

		if ($record_exists > 0) {
			$this->deleteExistingRecords($import_hdr_id, 'import_dtl_material_inward_sampling');
		}

		foreach ($worksheet_arr as $key => $value) {
			$data = array(
				'import_hdr_id' => $import_hdr_id,
				'lot_no' => $value[0],
				'circle' => $value[1],
				'item_code' => $value[2],
				'material_description' => $value[3],
				'unit' => $value[4],
				'name_of_vendor' => $value[5],
				'di_no' => $value[6],
				'di_date' => $value[7],
				'di_quantity' => $value[8],
				'received_quantity' => $value[9], 
				'received_date' => $value[10],
				'sampling_quantity' => $value[11],
				'sampling_seal_date' => $value[12],
				'is_active' => 1,
				'createdby' => $this->getLoggedInUserID(),
				'createddate' => date('Y-m-d H:i:s')
			);

			$query = $this->db->insert('import_dtl_material_inward_sampling', $data);

			if (!$query) {
				$error = $this->db->error();	
				echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
				die();
			}
		}
	}

	public function saveMaterialOutwardData($import_hdr_id, $worksheet_arr)
	{
		$record_exists = $this->checkRecordExists($import_hdr_id, 'import_dtl_material_outward');

		if ($record_exists > 0) {
			$this->deleteExistingRecords($import_hdr_id, 'import_dtl_material_outward');
		}

		foreach ($worksheet_arr as $key => $value) {
			$data = array(
				'import_hdr_id' => $import_hdr_id,
				'lot_no' => $value[0],
				'circle' => $value[1],
				'item_code' => $value[2],
				'material_description' => $value[3],
				'unit' => $value[4],
				'issue_quantity' => $value[5],
				'issue_date' => $value[6],
				'is_active' => 1,
				'createdby' => $this->getLoggedInUserID(),
				'createddate' => date('Y-m-d H:i:s')
			);

			$query = $this->db->insert('import_dtl_material_outward', $data);

			if (!$query) {
				$error = $this->db->error();	
				echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
				die();
			}
		}
	}

	public function checkRecordExists($import_hdr_id, $table)
	{
		$this->db->where(array('import_hdr_id' => $import_hdr_id, 'is_active' => 1, 'deletedby' => NULL));
		$query = $this->db->count_all_results($table);
		// echo $this->db->last_query(); die();

		return $query;
	}

	public function deleteExistingRecords($import_hdr_id, $table)
	{
		$data = array(
			'is_active' => 0,
			'deletedby' => $this->getLoggedInUserID(),
			'deleteddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->update($table, $data, array('import_hdr_id' => $import_hdr_id));

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			return $this->db->affected_rows();
		}
	}

	public function changeImportStatus($import_hdr_id, $status_id)
	{
		/*1-Open, 2-Completed, 3-Cancelled*/
		$data = array(
			'status ' => $status_id,
			'modifiedby' => $this->getLoggedInUserID(),
			'modifieddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->update('import_hdr', $data, array('import_hdr_id' => $import_hdr_id));

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			return $this->db->affected_rows();
		}
	}

	public function validateUploadedData($import_hdr_id)
	{
		$user_id = $this->getLoggedInUserID();

		$query = $this->db->query('CALL sp_validate_import_data('.$user_id.', '.$import_hdr_id.')');
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

	public function importUploadedData($import_hdr_id)
	{
		$user_id = $this->getLoggedInUserID();

		$query = $this->db->query('CALL sp_import_data('.$user_id.', '.$import_hdr_id.')');
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			return $this->db->affected_rows();
		}
	}

	public function getLoggedInUserID()
	{
		$userdata = $_SESSION['loggedData'];
		return $userdata->user_id;
	}
}

?>