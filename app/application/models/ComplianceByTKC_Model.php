<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
/**
 * 
 */
class ComplianceByTKC_Model extends CI_Model
{	
	function __construct()
	{
		parent::__construct();
	}

	public function getNCRsSubmittedByTKC()
	{
		$user_id = $this->getLoggedInUserID();

		$ncr_status_ids_list = $this->getNCRStatusIDs();
		$ncr_status_ids = [];
        foreach ($ncr_status_ids_list as $key => $value) {
        	$ncr_status_ids[$value['status_name']] = $value['status_id'];
        }

		$this->db->distinct();
		$this->db->select('ppao.physical_progress_activity_observation_id, ppao.contract_location_id, ppao.observation_name, ppao.other_observation_name, ppao.ncr_id, ppao.ncr_date, ppao.remark, ppao.observation_remark, ppao.completion_date, ppao.raised_by, ppao.designation, ppao.distribution_centre, ppao.last_email_details, ppao.status_id, contract_location.contract_id, contract_location.region_id, contract_location.circle_id, contract_location.division_id, contract_location.location_name, contract_location.feeder_id, mst_region.region_name, mst_circle.circle_name, mst_division.division_name, contract.contractor_name,contract.contractor_email, contract.package_no, mst_status.name AS observation_status, mst_user.username, ppao_tkc_file.createddate');
		$this->db->from('physical_progress_activity_observation AS ppao');
		$this->db->join('physical_progress_activity_observation_tkc_file AS ppao_tkc_file', 'ppao_tkc_file.physical_progress_activity_observation_id = ppao.physical_progress_activity_observation_id', 'RIGHT');
		$this->db->join('contract_location', 'ppao.contract_location_id = contract_location.contract_location_id', 'INNER');
		$this->db->join('mst_user_data_access AS muda', 'muda.region_id = contract_location.region_id AND muda.circle_id = contract_location.circle_id AND muda.division_id = contract_location.division_id', 'LEFT');
		$this->db->join('mst_region', 'contract_location.region_id = mst_region.region_id', 'INNER');
		$this->db->join('mst_circle', 'contract_location.circle_id = mst_circle.circle_id', 'INNER');
		$this->db->join('mst_division', 'contract_location.division_id = mst_division.division_id', 'INNER');
		$this->db->join('contract', 'contract_location.contract_id = contract.contract_id', 'INNER');
		$this->db->join('mst_status', 'ppao.status_id = mst_status.status_id', 'INNER');
		$this->db->join('mst_user', 'ppao.createdby = mst_user.user_id', 'INNER');

		/*$where_clause = 'SELECT DISTINCT physical_progress_activity_observation_id FROM physical_progress_activity_observation_tkc_file WHERE is_active = 1 AND deletedby IS NULL';
		$this->db->where_in('ppao.physical_progress_activity_observation_id', $where_clause);*/

		$this->db->where(array('muda.user_id' => $user_id, 'ppao.status_id' => $ncr_status_ids['Submitted by TKC'], 'ppao.is_active' => 1, 'ppao.deletedby' => NULL, 'ppao_tkc_file.is_active' => 1, 'ppao_tkc_file.deletedby' => NULL));
		$this->db->order_by('ppao.ncr_date', 'DESC');

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

	public function searchComplianceByTKC($contractor, $compliance_date_range, $feeder_id, $ncr_id, $package_group_no, $circle)
	{
		$user_id = $this->getLoggedInUserID();

		$this->db->distinct();
		$this->db->select('ppao.physical_progress_activity_observation_id, ppao.contract_location_id, ppao.observation_name, ppao.other_observation_name, ppao.ncr_id, ppao.ncr_date, ppao.remark, ppao.observation_remark, ppao.completion_date, ppao.raised_by, ppao.designation, ppao.distribution_centre, ppao.last_email_details, ppao.status_id, contract_location.contract_id, contract_location.region_id, contract_location.circle_id, contract_location.division_id, contract_location.location_name, contract_location.feeder_id, mst_region.region_name, mst_circle.circle_name, mst_division.division_name, contract.contractor_name,contract.contractor_email, contract.package_no, mst_status.name AS observation_status, mst_user.username, ppao_tkc_file.createddate');

		$this->db->from('physical_progress_activity_observation AS ppao');
		$this->db->join('physical_progress_activity_observation_tkc_file AS ppao_tkc_file', 'ppao_tkc_file.physical_progress_activity_observation_id = ppao.physical_progress_activity_observation_id', 'RIGHT');
		$this->db->join('contract_location', 'ppao.contract_location_id = contract_location.contract_location_id', 'INNER');
		$this->db->join('mst_user_data_access AS muda', 'muda.region_id = contract_location.region_id AND muda.circle_id = contract_location.circle_id AND muda.division_id = contract_location.division_id', 'LEFT');
		$this->db->join('mst_region', 'contract_location.region_id = mst_region.region_id', 'INNER');
		$this->db->join('mst_circle', 'contract_location.circle_id = mst_circle.circle_id', 'INNER');
		$this->db->join('mst_division', 'contract_location.division_id = mst_division.division_id', 'INNER');
		$this->db->join('contract', 'contract_location.contract_id = contract.contract_id', 'INNER');
		$this->db->join('mst_status', 'ppao.status_id = mst_status.status_id', 'INNER');
		$this->db->join('mst_user', 'ppao.createdby = mst_user.user_id', 'INNER');

		$this->db->where(array('muda.user_id' => $user_id, 'ppao.is_active' => 1, 'ppao.deletedby' => NULL));

		if (!empty($contractor)) {
			$this->db->like('contract.contractor_name', $contractor);
		}

		if (!empty($compliance_date_range)) {
			$date_arr = explode(' - ', $compliance_date_range);
			$from_date = date('Y-m-d', strtotime($date_arr[0]));
			$to_date = date('Y-m-d', strtotime($date_arr[1]));

			$this->db->where('ppao_tkc_file.createddate BETWEEN "'.$from_date.'" AND "'.$to_date.'"');
		}

		if (!empty($feeder_id)) {
			$this->db->like('contract_location.feeder_id', $feeder_id);
		}

		if (!empty($ncr_id)) {
			$this->db->where('ppao.ncr_id', $ncr_id);
		}

		if (!empty($package_group_no)) {
			$this->db->where_in('contract.package_group_no', $package_group_no);
		}

		if (!empty($circle)) {
			$this->db->where('contract_location.circle_id', $circle);
		}

		$this->db->order_by('ppao.ncr_date', 'DESC');

		$query = $this->db->get();
		echo $this->db->last_query(); die();

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
		$this->db->select('ppao.physical_progress_activity_observation_id, ppao.contract_location_id, ppao.activity_id, ppao.observation_id, ppao.observation_name, ppao.other_observation_name, ppao.ncr_id, ppao.ncr_date, ppao.remark, ppao.observation_remark, ppao.completion_date, ppao.raised_by, ppao.designation, ppao.distribution_centre, ppao.status_id, contract_location.feeder_id, mst_status.name AS observation_status, ppao.is_active, ppao.deletedby');
		$this->db->from('physical_progress_activity_observation AS ppao');
		$this->db->join('contract_location', 'ppao.contract_location_id = contract_location.contract_location_id');
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
				$others_arr = array('typeofwork_activity_options_id' => 0, 'name' => 'Others');
				array_push($query_result, $others_arr);

				$result = $query->result_array();

				foreach ($result as $key => $value) {
					array_push($query_result, $value);
				}
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

	public function getContractDetailsByContractLocationID($contract_location_id)
	{
		$this->db->select('contract.*');
		$this->db->from('contract');
		$this->db->join('contract_location', 'contract.contract_id = contract_location.contract_id', 'INNER');
		$this->db->where(array('contract_location.contract_location_id' => $contract_location_id));

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

	public function getUserRegionList()
	{
		$user_regions = isset($_SESSION['myRegions']) ? $_SESSION['myRegions'] : '';

		$this->db->select('region_id, region_name');

		if (!empty($user_regions)) {
			$this->db->where_in('region_id', $user_regions);	
		}

		$query = $this->db->get_where('mst_region', array('is_active' => 1));
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

	public function getRegionCircleData()
	{
		$userdata = $_SESSION['loggedData'];
		$logged_user_role = $this->getUserRole($userdata->role_id);

		if ($logged_user_role == 'Admin') {
			$this->db->select('mst_region.region_id, mst_circle.circle_id, mst_circle.circle_name');
			$this->db->from('mst_region');
			$this->db->join('mst_circle', 'mst_region.region_id = mst_circle.region_id', 'INNER');
			$this->db->where(array('mst_region.is_active' => 1, 'mst_circle.is_active' => 1));

			$query = $this->db->get();
			// echo $this->db->last_query(); die();
		} else if ($logged_user_role == 'Deputy Team Lead') {
			$user_id = $userdata->user_id;

			$this->db->select('mst_user_data_access.region_id, mst_user_data_access.circle_id, mst_circle.circle_name');
			$this->db->from('mst_user_data_access');
			$this->db->join('mst_circle', 'mst_user_data_access.circle_id = mst_circle.circle_id', 'INNER');
			$this->db->where(array('mst_user_data_access.user_id' => $user_id));

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

	public function getCircle($circle_id)
	{
		$this->db->select('circle_name');
		$query = $this->db->get_where('mst_circle', array('circle_id' => $circle_id));
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$query_result = [];

			if ($query->num_rows()) {
				$result = $query->row_array();
				$query_result = $result['circle_name'];
			}

			return $query_result;
		}
	}

	public function getCircleDivisionData()
	{
		$userdata = $_SESSION['loggedData'];
		$logged_user_role = $this->getUserRole($userdata->role_id);

		if ($logged_user_role == 'Admin') {
			$this->db->select('mst_circle.circle_id, mst_division.division_id, mst_division.division_name');
			$this->db->from('mst_circle');
			$this->db->join('mst_division', 'mst_circle.circle_id = mst_division.circle_id', 'INNER');
			$this->db->where(array('mst_circle.is_active' => 1, 'mst_division.is_active' => 1));

			$query = $this->db->get();
			// echo $this->db->last_query(); die();
		} else if ($logged_user_role == 'Deputy Team Lead') {
			$user_id = $userdata->user_id;

			$this->db->select('mst_user_data_access.circle_id, mst_user_data_access.division_id, mst_division.division_name');
			$this->db->from('mst_user_data_access');
			$this->db->join('mst_division', 'mst_user_data_access.division_id = mst_division.division_id', 'INNER');
			$this->db->where(array('mst_user_data_access.user_id' => $user_id));

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

	public function getPackageGroupNos()
	{
		$contract_status_list = $this->getContractStatusList();

		$this->db->distinct()->select('package_group_no');
		$query = $this->db->get_where('contract', array('status_id' => $contract_status_list['Open']));
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

	public function getContractStatusList()
	{
		$this->db->select('mst_status.status_id, mst_status.name');
		$this->db->from('mst_status');
		$this->db->join('mst_module', 'mst_status.module_id = mst_module.module_id', 'INNER');
		$this->db->where(array('mst_module.name' => 'Contract Management'));
		$this->db->order_by('mst_status.seqno', 'ASC');

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
					$query_result[$value['name']] = $value['status_id'];
				}
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
		$this->db->where(array('mst_module.name' => 'Compliance By TKC', 'mst_module.icon !=' => '', 'mst_user.user_id' => $user_id));
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

	public function getLoggedInUserID()
	{
		$userdata = $_SESSION['loggedData'];
		return $userdata->user_id;
	}
}
?>