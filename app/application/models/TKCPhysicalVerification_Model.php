<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class TKCPhysicalVerification_Model extends CI_Model
{	
	function __construct()
	{
		parent::__construct();
	}

	public function getPhysicalVerificationSheets($user_id)
	{
		$package_access = $this->getTKCPackageAccess($user_id);
		$contract_id = $this->getContractIDFromPackageAccess($package_access);

		$contract_status_list = $this->getContractStatusList();
		$active_contract_status_id = $contract_status_list['Open'];

		$pp_status_ids = $this->getStatusIDsForList();

		$query = $this->db->query("SELECT `tkc_physical_progress`.`tkc_physical_progress_id`, `tkc_physical_progress`.`contract_id`, `tkc_physical_progress`.`contract_location_id`, `tkc_physical_progress`.`site_location`, `tkc_physical_progress`.`reported_by`, `tkc_physical_progress`.`reported_date`, `tkc_physical_progress`.`status_id`, `contract`.`contract_id`, `contract`.`package_no`, `contract`.`contractor_name`, `contract`.`tender_award_no`, `contract`.`typeofwork_id`, `contract_location`.`contract_location_id`, `contract_location`.`region_id`, `contract_location`.`circle_id`, `contract_location`.`division_id`, `contract_location`.`location_name`, `contract_location`.`feeder_id`, `mst_user`.`username` AS `pp_reported_by`, `mst_user`.`package_access`, `mst_region`.`region_name`, `mst_circle`.`circle_name`, `mst_division`.`division_name`, `mst_status`.`name` AS `sheet_status`, `mst_typeofwork`.`name` AS `typeofwork_name`, IFNULL(`tt_act`.`tt_activity`, 0) AS `tt_task`, IFNULL(`cc_act`.`comp_act`, 0) AS `cc_task` FROM (SELECT MAX(`tkc_physical_progress`.`tkc_physical_progress_id`) AS `tkc_physical_progress_id`, `tkc_physical_progress`.`contract_id`, `tkc_physical_progress`.`contract_location_id`, MAX(`reported_date`) AS `reported_date` FROM		`tkc_physical_progress` WHERE `tkc_physical_progress`.`is_draft` = 0 GROUP BY `tkc_physical_progress`.`contract_id`, `tkc_physical_progress`.`contract_location_id`) `grp` INNER JOIN `tkc_physical_progress` ON `tkc_physical_progress`.`tkc_physical_progress_id` = `grp`.`tkc_physical_progress_id` AND `tkc_physical_progress`.`contract_id` = `grp`.`contract_id` AND `tkc_physical_progress`.`contract_location_id` = `grp`.`contract_location_id` INNER JOIN `contract` ON `tkc_physical_progress`.`contract_id` = `contract`.`contract_id` INNER JOIN `contract_location` ON `tkc_physical_progress`.`contract_id` = `contract_location`.`contract_id` AND `tkc_physical_progress`.`contract_location_id` = `contract_location`.`contract_location_id` LEFT JOIN `mst_user` ON `mst_user`.`user_id` = `tkc_physical_progress`.`reported_by` INNER JOIN `mst_region` ON `mst_region`.`region_id` = `contract_location`.`region_id` INNER JOIN `mst_circle` ON `mst_circle`.`circle_id` = `contract_location`.`circle_id` INNER JOIN `mst_division` ON `mst_division`.`division_id` = `contract_location`.`division_id` INNER JOIN `mst_status` ON `mst_status`.`status_id` = `tkc_physical_progress`.`status_id` INNER JOIN `mst_typeofwork` ON `mst_typeofwork`.`typeofwork_id` = `contract`.`typeofwork_id` LEFT JOIN (SELECT `tkc_physical_progress_id`, COUNT(`mst_typeofwork_activity`.`typeofwork_activity_id`) AS `tt_activity` FROM `tkc_physical_progress` `a` INNER JOIN 	`contract` ON `contract`.`contract_id` = `a`.`contract_id` INNER JOIN `mst_typeofwork_activity` ON `mst_typeofwork_activity`.`typeofwork_id` = `contract`.`typeofwork_id` GROUP BY `tkc_physical_progress_id`, `mst_typeofwork_activity`.`typeofwork_id`) `tt_act` ON `tt_act`.`tkc_physical_progress_id` = `tkc_physical_progress`.`tkc_physical_progress_id` LEFT JOIN (SELECT `A`.`tkc_physical_progress_id` AS `tkc_physical_progress_id`, IFNULL(COUNT(`A`.`activity_id`), 0) AS `comp_act` FROM (SELECT `P1`.`tkc_physical_progress_id`, `P1`.`contract_location_id`, `P2`.`activity_id`, `P2`.`status_id` FROM `contract` `C` LEFT JOIN `contract_location` `CL` ON `CL`.`contract_id` = `C`.`contract_id` LEFT JOIN (SELECT MAX(`tkc_physical_progress`.`tkc_physical_progress_id`) AS `tkc_physical_progress_id`, `tkc_physical_progress`.`contract_id`, `tkc_physical_progress`.`contract_location_id`, MAX(`reported_date`) AS `reported_date` FROM `tkc_physical_progress` GROUP BY `tkc_physical_progress`.`contract_id`, `tkc_physical_progress`.`contract_location_id`) `P` ON `P`.`contract_location_id` = `CL`.`contract_location_id` AND `P`.`contract_id` = `CL`.`contract_id` LEFT JOIN `tkc_physical_progress` `P1` ON `P1`.`tkc_physical_progress_id` = `P`.`tkc_physical_progress_id` LEFT JOIN `tkc_physical_progress_activity` `P2` ON `P2`.`tkc_physical_progress_id` = `P1`.`tkc_physical_progress_id` WHERE `CL`.`is_active` = 1) `A` LEFT JOIN	(SELECT `P1`.`tkc_physical_progress_id`, `P1`.`contract_location_id`, 1 AS `is_no_pending_observation`, `P`.`activity_id` FROM `mst_typeofwork_activity` `T` INNER JOIN `tkc_physical_progress_activity` `P` ON `P`.`activity_id` = `T`.`typeofwork_activity_id` INNER JOIN `tkc_physical_progress` `P1` ON `P1`.`tkc_physical_progress_id` = `P`.`tkc_physical_progress_id` INNER JOIN `contract_location` `CL` ON `CL`.`contract_location_id` = `P1`.`contract_location_id` AND `P1`.`contract_id` = `CL`.`contract_id` WHERE `CL`.`is_active` = 1 GROUP BY `P1`.`contract_id`, `P1`.`contract_location_id`, `P`.`activity_id`) `P3` ON `P3`.`contract_location_id` = `A`.`contract_location_id` AND `P3`.`activity_id` = `A`.`activity_id` WHERE (`A`.`status_id` = 1 AND IFNULL(`is_no_pending_observation`, 0) = 0) OR (`A`.`status_id` = 3) GROUP BY `A`.`tkc_physical_progress_id`) `cc_act` ON `cc_act`.`tkc_physical_progress_id` = `tkc_physical_progress`.`tkc_physical_progress_id` WHERE `tkc_physical_progress`.`is_draft` = 0 AND `tkc_physical_progress`.`status_id` IN(".$pp_status_ids.") AND `contract`.`status_id` = ".$active_contract_status_id." AND `contract_location`.`is_active` = 1 AND `contract`.`contract_id` = ".$contract_id." ORDER BY `tkc_physical_progress`.`status_id` DESC, `tkc_physical_progress`.`reported_date` DESC;");
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

	public function getTKCPackageAccess($tkc_user_id)
	{
		$this->db->select('mst_user.package_access');
		$this->db->from('mst_user');
		$this->db->join('mst_role', 'mst_user.role_id = mst_role.role_id', 'INNER');
		$this->db->where(array('mst_user.user_id' => $tkc_user_id, 'mst_role.name' => 'TKC'));

		$query = $this->db->get();
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$query_result = [];

			if ($query->num_rows() > 0) {
				$result = $query->row_array();

				$query_result = $result['package_access'];
			}

			return $query_result;
		}
	}

	public function getContractIDFromPackageAccess($package_access)
	{
		$this->db->select('contract_id');
		$query = $this->db->get_where('contract', array('package_no' => $package_access));
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$query_result = [];

			if ($query->num_rows() > 0) {
				$result = $query->row_array();

				$query_result = $result['contract_id'];
			}

			return $query_result;
		}
	}

	public function getContractStatusList()
	{
		$this->db->select('mst_status.name, mst_status.status_id');
		$this->db->from('mst_status');
		$this->db->join('mst_module', 'mst_status.module_id = mst_module.module_id', 'INNER');
		$this->db->where(array('mst_module.name' => 'Contract Management'));

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

	public function getTypeOfWorkList()
	{
		$query =  $this->db->select('typeofwork_id, name')->get('mst_typeofwork');

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$query_result = [];

			if ($query->num_rows() > 0) {
				$query_result = $query->result_array();
			}
		}

		return $query_result;
	}

	public function getStatusIDsForList()
	{
		$where_in_array = array('Open', 'In Process');

		$this->db->select('mst_status.status_id');
		$this->db->from('mst_status');
		$this->db->join('mst_module', 'mst_status.module_id = mst_module.module_id', 'INNER');
		// $this->db->where(array('mst_module.name' => 'Physical Verification', 'mst_module.icon !=' => '')); //Uncomment Later
		$this->db->where(array('mst_module.name' => 'Physical Verification', 'mst_module.icon !=' => '')); //Delete Later
		$this->db->where_in('mst_status.name',$where_in_array);

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
					array_push($query_result, $value['status_id']);					
				}

				$query_result = implode(',', $query_result);
			}

			return $query_result;
		}
	}

	public function getRegionList($user_id = NULL)
	{
		
	}

	public function getUserModuleAccess()
	{
		$user_id = $this->getLoggedInUserID();

		$this->db->select('mst_user.role_id, mst_module.name, mst_role_module_access.module_access_id, mst_module_access.module_id, mst_module_access.access_key, mst_module_access.event');
		$this->db->from('mst_user');
		$this->db->join('mst_role_module_access', 'mst_user.role_id = mst_role_module_access.role_id', 'INNER');
		$this->db->join('mst_module_access', 'mst_role_module_access.module_access_id = mst_module_access.module_access_id', 'INNER');
		$this->db->join('mst_module', 'mst_module_access.module_id = mst_module.module_id', 'INNER');
		$this->db->where(array('mst_module.name' => 'TKC Physical Verification', 'mst_module.icon !=' => '', 'mst_user.user_id' => $user_id));
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