<?php defined('BASEPATH') OR exit('No direct script access allowed');

class NCRReview_Model extends CI_Model
{	
	function __construct()
	{
		parent::__construct();
	}

	public function getNCRs($pending_id, $reviewed_id, $contract_location_ids)
	{
		$ncr_status = array($pending_id, $reviewed_id);
		$user_id = $this->getLoggedInUserID();

		$this->db->select('ppao.physical_progress_activity_observation_id, ppao.contract_location_id, ppao.observation_name, ppao.ncr_id, ppao.ncr_date, ppao.remark, ppao.completion_date, ppao.last_email_details, ppao.status_id, contract_location.contract_id, contract_location.region_id, contract_location.circle_id, contract_location.division_id, contract_location.location_name, contract_location.feeder_id, mst_region.region_name, mst_circle.circle_name, mst_division.division_name, contract.contractor_name, contract.contractor_email, contract.package_no, mst_status.name AS observation_status');
		$this->db->from('physical_progress_activity_observation AS ppao');
		$this->db->join('contract_location', 'ppao.contract_location_id = contract_location.contract_location_id', 'INNER');

		if (empty($contract_location_ids)) {
			$this->db->join('mst_user_data_access AS muda', 'muda.region_id = contract_location.region_id AND muda.circle_id = contract_location.circle_id AND muda.division_id = contract_location.division_id', 'LEFT');
		}

		$this->db->join('mst_region', 'contract_location.region_id = mst_region.region_id', 'INNER');
		$this->db->join('mst_circle', 'contract_location.circle_id = mst_circle.circle_id', 'INNER');
		$this->db->join('mst_division', 'contract_location.division_id = mst_division.division_id', 'INNER');
		
		$this->db->join('contract', 'contract_location.contract_id = contract.contract_id', 'INNER');
		$this->db->join('mst_status', 'ppao.status_id = mst_status.status_id', 'INNER');
		$this->db->where_in('ppao.status_id', $ncr_status);
		$this->db->where(array('ppao.is_active' => 1, 'ppao.deletedby' => NULL));

		if (!empty($contract_location_ids)) {
			$this->db->where_in('ppao.contract_location_id', $contract_location_ids);
		} else {
			$this->db->where(array('muda.user_id' => $user_id));
		}
		$this->db->order_by('ppao.ncr_date', 'ASC');

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

	public function searchNCRs($contractor, $package_no, $feeder_id, $circle, $division, $status, $contract_location_ids)
	{
		$user_id = $this->getLoggedInUserID();

		$this->db->select('ppao.physical_progress_activity_observation_id, ppao.contract_location_id, ppao.observation_name, ppao.ncr_id, ppao.ncr_date, ppao.remark, ppao.completion_date, ppao.status_id, contract_location.contract_id, contract_location.region_id, contract_location.circle_id, contract_location.division_id, contract_location.location_name, contract_location.feeder_id, mst_region.region_name, mst_circle.circle_name, mst_division.division_name, contract.contractor_name, contract.package_no, mst_status.name AS observation_status');
		$this->db->from('physical_progress_activity_observation AS ppao');
		$this->db->join('contract_location', 'ppao.contract_location_id = contract_location.contract_location_id', 'INNER');

		if (empty($contract_location_ids)) {
			$this->db->join('mst_user_data_access AS muda', 'muda.region_id = contract_location.region_id AND muda.circle_id = contract_location.circle_id AND muda.division_id = contract_location.division_id', 'LEFT');	
		}
		
		$this->db->join('mst_region', 'contract_location.region_id = mst_region.region_id', 'INNER');
		$this->db->join('mst_circle', 'contract_location.circle_id = mst_circle.circle_id', 'INNER');
		$this->db->join('mst_division', 'contract_location.division_id = mst_division.division_id', 'INNER');
		$this->db->join('contract', 'contract_location.contract_id = contract.contract_id', 'INNER');
		$this->db->join('mst_status', 'ppao.status_id = mst_status.status_id', 'INNER');
		$this->db->where(array('ppao.is_active' => 1, 'ppao.deletedby' => NULL));

		if (!empty($contract_location_ids)) {
			$this->db->where_in('ppao.contract_location_id', $contract_location_ids);
		} else {
			$this->db->where(array('muda.user_id' => $user_id));
		}

		if (!empty($contractor)) {
			$this->db->like('contract.contractor_name', $contractor);
		}

		if (!empty($package_no)) {
			$this->db->like('contract.package_no', $package_no);
		}

		if (!empty($feeder_id)) {
			$this->db->like('contract_location.feeder_id', $feeder_id);
		}

		if (!empty($circle)) {
			$this->db->where('contract_location.circle_id', $circle);
		}

		if (!empty($division)) {
			$this->db->where('contract_location.division_id', $division);
		}

		if (!empty($status)) {
			$this->db->where_in('ppao.status_id', $status);
		}

		$this->db->order_by('ppao.ncr_date', 'ASC');

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

	public function getNCRDetails($pp_activity_obs_id)
	{
		$this->db->select('ppao.physical_progress_activity_observation_id, ppao.contract_location_id, ppao.activity_id, ppao.observation_id, ppao.observation_name, ppao.ncr_id, ppao.ncr_date, ppao.remark, ppao.completion_date, ppao.status_id, mst_status.name AS observation_status');
		$this->db->from('physical_progress_activity_observation AS ppao');
		$this->db->join('mst_status', 'ppao.status_id = mst_status.status_id', 'INNER');
		$this->db->where(array('physical_progress_activity_observation_id' => $pp_activity_obs_id));

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
				$query_result['observation_files'] = [];
				$query_result['observation_completion_files'] = [];

				$observation_files = $this->getObservationFile($pp_activity_obs_id);
				if (!empty($observation_files)) {
					$query_result['observation_files'] = $observation_files;
				}

				$observation_tkc_files = $this->getObservationTKCFile($pp_activity_obs_id);
				if (!empty($observation_tkc_files)) {
					$query_result['observation_tkc_files'] = $observation_tkc_files;
				}

				if (!empty($query_result['completion_date'])) {
					$completion_files = $this->getObservationCompletionFile($pp_activity_obs_id);
					if (!empty($completion_files)) {
						$query_result['observation_completion_files'] = $completion_files;
					}
				}
			}

			return $query_result;
		}
	}

	public function getObservationFile($pp_activity_obs_id)
	{
		$this->db->select('physical_progress_activity_observation_file_id, file_path');
		$this->db->where(array('physical_progress_activity_observation_id' => $pp_activity_obs_id, 'is_active' => 1, 'deletedby' => NULL));
		$query = $this->db->get('physical_progress_activity_observation_file');
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

	public function saveObservationFile($pp_activity_obs_id, $file_path)
	{
		$data = array(
			'physical_progress_activity_observation_id' => $pp_activity_obs_id,
			'file_path' => $file_path,
			'is_active' => 1,
			'createdby' => $this->getLoggedInUserID(),
			'createddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->insert('physical_progress_activity_observation_file', $data);

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$insert_id = $this->db->insert_id();
			return $insert_id;
		}
	}

	public function deleteObservationFile($ppao_file_id)
	{
		$data = array(
			'is_active' => 0,
			'deletedby' => $this->getLoggedInUserID(),
			'deleteddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->update('physical_progress_activity_observation_file', $data, array('physical_progress_activity_observation_file_id' => $ppao_file_id));

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			return $this->db->affected_rows();
		}
	}

	public function getLastObservationFileData($pp_activity_obs_id)
	{
		$this->db->select('file_path');
		$this->db->where(array('physical_progress_activity_observation_id' => $pp_activity_obs_id));
		$this->db->order_by('physical_progress_activity_observation_file_id', 'DESC');
		$this->db->limit(1);

		$query = $this->db->get('physical_progress_activity_observation_file');
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$query_result = [];

			if ($query->num_rows() > 0) {
				$result = $query->row_array();
				$query_result = $result['file_path'];
			}

			return $query_result;
		}
	}

	public function getObservationTKCFile($pp_activity_obs_id)
	{
		$this->db->select('physical_progress_activity_observation_tkc_file_id, file_path');
		$this->db->where(array('physical_progress_activity_observation_id' => $pp_activity_obs_id, 'is_active' => 1, 'deletedby' => NULL));
		$query = $this->db->get('physical_progress_activity_observation_tkc_file');
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

	public function saveObservationFileByTKC($pp_activity_obs_id, $file_path)
	{
		$data = array(
			'physical_progress_activity_observation_id' => $pp_activity_obs_id,
			'file_path' => $file_path,
			'is_active' => 1,
			'createdby' => $this->getLoggedInUserID(),
			'createddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->insert('physical_progress_activity_observation_tkc_file', $data);

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$insert_id = $this->db->insert_id();
			return $insert_id;
		}
	}

	public function getLastObservationFileByTKCData($pp_activity_obs_id)
	{
		$this->db->select('file_path');
		$this->db->where(array('physical_progress_activity_observation_id' => $pp_activity_obs_id));
		$this->db->order_by('physical_progress_activity_observation_tkc_file_id', 'DESC');
		$this->db->limit(1);

		$query = $this->db->get('physical_progress_activity_observation_tkc_file');
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$query_result = [];

			if ($query->num_rows() > 0) {
				$result = $query->row_array();
				$query_result = $result['file_path'];
			}

			return $query_result;
		}
	}

	public function deleteObservationTKCFile($ppao_file_id)
	{
		$data = array(
			'is_active' => 0,
			'deletedby' => $this->getLoggedInUserID(),
			'deleteddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->update('physical_progress_activity_observation_tkc_file', $data, array('physical_progress_activity_observation_file_id' => $ppao_file_id));

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			return $this->db->affected_rows();
		}
	}

	public function getObservationCompletionFile($pp_activity_obs_id)
	{
		$this->db->select('physical_progress_activity_completion_file_id, file_path');
		$this->db->where(array('physical_progress_activity_observation_id' => $pp_activity_obs_id, 'is_active' => 1, 'deletedby' => NULL));
		$query = $this->db->get('physical_progress_activity_completion_file');
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

	public function saveObservationCompletionFile($pp_activity_obs_id, $file_path)
	{
		$data = array(
			'physical_progress_activity_observation_id' => $pp_activity_obs_id,
			'file_path' => $file_path,
			'is_active' => 1,
			'createdby' => $this->getLoggedInUserID(),
			'createddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->insert('physical_progress_activity_completion_file', $data);

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$insert_id = $this->db->insert_id();
			return $insert_id;
		}
	}

	public function deleteObservationCompletionFile($ppao_file_id)
	{
		$data = array(
			'is_active' => 0,
			'deletedby' => $this->getLoggedInUserID(),
			'deleteddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->update('physical_progress_activity_completion_file', $data, array('physical_progress_activity_completion_file_id' => $ppao_file_id));

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			return $this->db->affected_rows();
		}
	}

	public function getLastObservationCompletionFileData($pp_activity_obs_id)
	{
		$this->db->select('file_path');
		$this->db->where(array('physical_progress_activity_observation_id' => $pp_activity_obs_id));
		$this->db->order_by('physical_progress_activity_completion_file_id', 'DESC');
		$this->db->limit(1);

		$query = $this->db->get('physical_progress_activity_completion_file');
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$query_result = [];

			if ($query->num_rows() > 0) {
				$result = $query->row_array();
				$query_result = $result['file_path'];
			}

			return $query_result;
		}
	}

	public function getActivityObservations($typeofwork_activity_id)
	{
		$this->db->select('typeofwork_activity_options_id, name');
		$this->db->where(array('typeofwork_activity_id' => $typeofwork_activity_id, 'is_active' => 1, 'deletedby' => NULL));

		$query = $this->db->get('mst_typeofwork_activity_options');
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

	public function updateNCRDetails($pp_activity_obs_id, $observation_id, $observation_name, $observation_remark, $completion_date, $changed_obs_status_ID)
	{
		$data = array(
			'observation_id' => $observation_id,
			'observation_name' => $observation_name,
			'remark' => $observation_remark,
			'completion_date' => $completion_date,
			'status_id' => $changed_obs_status_ID,
			'modifiedby' => $this->getLoggedInUserID(),
			'modifieddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->update('physical_progress_activity_observation', $data, array('physical_progress_activity_observation_id' => $pp_activity_obs_id));

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			return $this->db->affected_rows();
		}
	}

	public function getNCRStatusIDs()
	{
		$this->db->select('mst_status.status_id, mst_status.name AS status_name');
		$this->db->from('mst_status');
		$this->db->join('mst_module', 'mst_status.module_id = mst_module.module_id', 'INNER');
		$this->db->where(array('mst_module.name' => 'NCR Review'));

		$query = $this->db->get();

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

	public function getNCRReportData($ncr_ids, $user_id)
	{
		$query = $this->db->query("CALL sp_ncr_review_pdf_email(".$user_id.", '".$ncr_ids."')");
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

	public function getPhysicalProgressSheetID($contract_location_id)
	{
		$this->db->select('physical_progress_id, site_location, reported_date');
		$this->db->where(array('contract_location_id' => 1, 'is_draft' => 0, 'deletedby' => NULL));
		$this->db->order_by('physical_progress_id', 'DESC');
		$this->db->limit(1);

		$query = $this->db->get('physical_progress');
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

	public function updateEmailDetails($ncr_ids)
	{
		$data = array(
			'last_email_details' => date('Y-m-d H:i:s')
		);

		$this->db->where_in('ncr_id', $ncr_ids);
		$query = $this->db->update('physical_progress_activity_observation', $data);
		// echo $this->db->last_query(); 

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			return $this->db->affected_rows();
		}
	}

	public function getContractorEmailIDs($ncr_ids)
	{
		$this->db->select('physical_progress_activity_observation.ncr_id, contract.contractor_email, contract.contractor_name');
		$this->db->from('physical_progress_activity_observation');
		$this->db->join('contract_location', 'physical_progress_activity_observation.contract_location_id = contract_location.contract_location_id', 'INNER');
		$this->db->join('contract', 'contract_location.contract_id = contract.contract_id', 'INNER');
		// $this->db->where(array('physical_progress_activity_observation.ncr_id' => $ncr_id));
		$this->db->where_in('physical_progress_activity_observation.ncr_id', $ncr_ids);

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

	public function getCCBCCEmailIDs()
	{
		$this->db->select('display_name, fieldvalue');
		$query = $this->db->get_where('sysconfig', array('module' => 'NCR Review'));
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
		$query_result = [];

		$this->db->select('circle_id, circle_name');
		$query = $this->db->get_where('mst_circle', array('is_active' => 1));

		if ($query->num_rows() > 0) {
			$query_result = $query->result_array();
		}

		return $query_result;
	}

	public function getCircleDivisionData()
	{
		$userdata = $_SESSION['loggedData'];
		$logged_user_role = $this->getUserRole($userdata->role_id);

		if ($logged_user_role != 'Admin') {
			$user_id = $userdata->user_id;

			$this->db->select('mst_user_data_access.circle_id, mst_user_data_access.division_id, mst_division.division_name');
			$this->db->from('mst_user_data_access');
			$this->db->join('mst_division', 'mst_user_data_access.division_id = mst_division.division_id', 'INNER');
			$this->db->where(array('mst_user_data_access.user_id' => $user_id));

			$query = $this->db->get();
			// echo $this->db->last_query(); die();
		} else {
			$this->db->select('mst_circle.circle_id, mst_division.division_id, mst_division.division_name');
			$this->db->from('mst_circle');
			$this->db->join('mst_division', 'mst_circle.circle_id = mst_division.circle_id', 'INNER');
			$this->db->where(array('mst_circle.is_active' => 1, 'mst_division.is_active' => 1));

			$query = $this->db->get();
			// echo $this->db->last_query(); die();
		}

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
		$query_result = [];

		$this->db->select('division_id, division_name');
		$query = $this->db->get_where('mst_division', array('is_active' => 1));

		if ($query->num_rows() > 0) {
			$query_result = $query->result_array();
		}

		return $query_result;	
	}

	public function getDivisionListOfCircle($circle_id)
	{
		$this->db->select('division_id, division_name');
		$query = $this->db->get_where('mst_division', array('is_active' => 1, 'circle_id' => $circle_id));

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

	public function getStatusList()
	{
		$this->db->select('mst_module.module_id, mst_module.name, mst_status.status_id, mst_status.name, mst_status.seqno');
		$this->db->from('mst_module');
		$this->db->join('mst_status', 'mst_module.module_id = mst_status.module_id', 'INNER');
		$this->db->where(array('mst_module.name' => 'NCR Review'));

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

	public function getCircle($circle_id)
	{
		$query = $this->db->get_where('mst_circle', array('circle_id' => $circle_id));

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			if ($query->num_rows() > 0) {
				$query_result = $query->row_array();
				return $query_result['circle_name'];
			} else {
				return 'Not Found';
			}	
		}			
	}

	public function getDivision($division_id)
	{
		$query = $this->db->get_where('mst_division', array('division_id' => $division_id));

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			if ($query->num_rows() > 0) {
				$query_result = $query->row_array();
				return $query_result['division_name'];
			} else {
				return 'Not Found';
			}
		}
	}

	public function getSheetStatus($status_id)
	{
		$query = $this->db->get_where('mst_status', array('status_id' => $status_id));

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			if ($query->num_rows() > 0) {
				$query_result = $query->row_array();
				return $query_result['name'];
			} else {
				return 'Not Found';
			}
		}
	}

	public function getContractLocationIDsByPackage($package_no)
	{
		$this->db->select('contract_location.contract_location_id');
		$this->db->from('contract_location');
		$this->db->join('contract', 'contract_location.contract_id = contract.contract_id', 'INNER');
		$this->db->where(array('contract.package_no' => $package_no));

		$query = $this->db->get();
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$query_result = [];

			if ($query->num_rows() > 0) {
				$result = $query->result_array();

				foreach ($result as $key => $value) {
					array_push($query_result, $value['contract_location_id']);	
				}
			}

			return $query_result;
		}
	}

	public function getLoggedInUserID()
	{
		$userdata = $_SESSION['loggedData'];
		return $userdata->user_id;
	}

	public function getUserRole($roleId)
	{
		$query = $this->db->get_where('mst_role', array('role_id' => $roleId));

		if ($query->num_rows() > 0) {
			$query_result = $query->row_array();
			return $query_result['name'];
		} else {
			return 'Not Found';
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
		$this->db->where(array('mst_module.name' => 'NCR Review', 'mst_module.icon !=' => '', 'mst_user.user_id' => $user_id));
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