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

	public function getSheetDetail($mode, $ppsheet_id, $contract_id, $contract_location_id, $reported_date = NULL, $type = NULL)
	{
		$this->db->select('tkc_physical_progress.*, contract.contractor_name, contract.tender_award_no, contract.tender_award_date, contract.package_no, contract.typeofwork_id, contract_location.region_id, contract_location.circle_id, contract_location.division_id, contract_location.location_name, contract_location.feeder_name, contract_location.feeder_id, contract_location.geo_code');
		$this->db->from('tkc_physical_progress');
		$this->db->join('contract', 'tkc_physical_progress.contract_id = contract.contract_id', 'INNER');
		$this->db->join('contract_location', 'tkc_physical_progress.contract_id = contract_location.contract_id AND tkc_physical_progress.contract_location_id = contract_location.contract_location_id', 'INNER');
		$this->db->where(array('tkc_physical_progress.tkc_physical_progress_id' => $ppsheet_id));

		if ($type == NULL && $reported_date != NULL) {
			$this->db->where('tkc_physical_progress.reported_date', $reported_date);	
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
				$query_result = $query->row_array();

				$query_result['region_name'] = $this->getRegion($query_result['region_id']);
				$query_result['circle_name'] = $this->getCircle($query_result['circle_id']);
				$query_result['division_name'] = $this->getDivision($query_result['division_id']);
				$query_result['typeofwork'] = $this->getTypeOfWork($query_result['typeofwork_id']);
				$query_result['sheet_status'] = $this->getSheetStatus($query_result['status_id']);

				if ($mode == 'edit-new') {
					if ($type == 'API') {
						$activities_list = $this->getActivitiesListAPI($ppsheet_id, $query_result['typeofwork_id'], $contract_location_id, $reported_date);	
					} else {
						$activities_list = $this->getActivitiesList($query_result['typeofwork_id'], $contract_location_id);	
					}

					$query_result['activities_list'] = $activities_list;

					if (!empty($activities_list)) {
						$activity_groups = $this->getActivitiesGroupByWork($query_result['typeofwork_id'], $type);
						$query_result['activities_group_name'] = $activity_groups;
					}
				} elseif ($mode == 'edit-prev' || $mode == 'view' || $mode == 'view-by-date') {
					if ($mode == 'view' || $mode = 'view-by-date') {
						
					}

					$activities_list = $this->getAppliedActivitiesList($ppsheet_id, $query_result['contract_location_id'], $reported_date);

					$activities_list_by_seqno = $this->sort_array_by_key($activities_list, 'seqno');

					$query_result['activities_list'] = $activities_list_by_seqno;

					$group_name_arr = [];
					foreach ($activities_list as $key => $value) {
						array_push($group_name_arr, $value['activity_group_name']);
					}

					$activity_groups = $this->getActivitiesGroupByWork($query_result['typeofwork_id'], $type);
					$query_result['activities_group_name'] = $activity_groups;
				}

				return $query_result;
			}
		}
	}

	public function searchSheets($contractor, $tender_award_no, $type_of_work, $site_location, $region, $circle, $division, $reported_by, $reported_date, $feeder_id, $status, $user_id = NULL, $offset = NULL, $limit = NULL)
	{
		$package_access = $this->getTKCPackageAccess($user_id);
		$contract_id = $this->getContractIDFromPackageAccess($package_access);

		$contract_status_list = $this->getContractStatusList();
		$active_contract_status_id = $contract_status_list['Open'];

		$pp_status_ids = $this->getStatusIDsForList();

		//adding search filters to the query
		$contractor_query = (!empty($contractor)) ? "and (ifnull(`contract`.`contractor_name`,'')<>'' and `contract`.`contractor_name` like '%".$contractor."%')" : '';

		$tender_award_no_query = (!empty($tender_award_no)) ? "and (ifnull(`contract`.`tender_award_no`,'')<>'' and `contract`.`tender_award_no` like '%".$tender_award_no."%')": '';

		$type_of_work_query = (!empty($type_of_work)) ? "and (ifnull(`contract`.`typeofwork_id`,0)<>0 and `contract`.`typeofwork_id` = ".$type_of_work.")": '';

		$site_location_query = (!empty($site_location)) ? "and (ifnull(`contract_location`.`location_name`,'')<>'' and `contract_location`.`location_name` like '%".$site_location."%')" : '';

		$region_query = (!empty($region)) ? "and (ifnull(`contract_location`.`region_id`,0)<>0 and `contract_location`.`region_id` = ".$region.")" : '';

		$circle_query = (!empty($circle)) ? "and (ifnull(`contract_location`.`circle_id`,0)<>0 and `contract_location`.`circle_id` = ".$circle.")" : '';

		$division_query = (!empty($division)) ? "and (ifnull(`contract_location`.`division_id`,0)<>0 and `contract_location`.`division_id` = ".$division.")" : '';

		$reported_by_query = (!empty($reported_by)) ? "and (ifnull(`tkc_physical_progress`.`reported_by`,0)<>0 and `tkc_physical_progress`.`reported_by` like '%".$reported_by."%')" : '';

		$reported_date_query = (!empty($reported_date)) ? "and (ifnull(`tkc_physical_progress`.`reported_date`,'')<>'' and `tkc_physical_progress`.`reported_date` like '%".$reported_date."%')" : '';

		$feeder_id_query = (!empty($feeder_id)) ? "and (ifnull(`contract_location`.`feeder_id`,0)<>0 and `contract_location`.`feeder_id` like '%".$feeder_id."%')" : '';

		$status_query = (!empty($status)) ? "and (ifnull(`tkc_physical_progress`.`status_id`,0)<>0 and `tkc_physical_progress`.`status_id` IN (".$status."))" : '';

		$query = $this->db->query("SELECT `tkc_physical_progress`.`tkc_physical_progress_id`, `tkc_physical_progress`.`contract_id`, `tkc_physical_progress`.`contract_location_id`, `tkc_physical_progress`.`site_location`, `tkc_physical_progress`.`reported_by`, `tkc_physical_progress`.`reported_date`, `tkc_physical_progress`.`status_id`, `contract`.`contract_id`, `contract`.`package_no`, `contract`.`contractor_name`, `contract`.`tender_award_no`, `contract`.`typeofwork_id`, `contract_location`.`contract_location_id`, `contract_location`.`region_id`, `contract_location`.`circle_id`, `contract_location`.`division_id`, `contract_location`.`location_name`, `contract_location`.`feeder_id`, `mst_user`.`username` AS `pp_reported_by`, `mst_user`.`package_access`, `mst_region`.`region_name`, `mst_circle`.`circle_name`, `mst_division`.`division_name`, `mst_status`.`name` AS `sheet_status`, `mst_typeofwork`.`name` AS `typeofwork_name`, IFNULL(`tt_act`.`tt_activity`, 0) AS `tt_task`, IFNULL(`cc_act`.`comp_act`, 0) AS `cc_task` FROM (SELECT MAX(`tkc_physical_progress`.`tkc_physical_progress_id`) AS `tkc_physical_progress_id`, `tkc_physical_progress`.`contract_id`, `tkc_physical_progress`.`contract_location_id`, MAX(`reported_date`) AS `reported_date` FROM		`tkc_physical_progress` WHERE `tkc_physical_progress`.`is_draft` = 0 GROUP BY `tkc_physical_progress`.`contract_id`, `tkc_physical_progress`.`contract_location_id`) `grp` INNER JOIN `tkc_physical_progress` ON `tkc_physical_progress`.`tkc_physical_progress_id` = `grp`.`tkc_physical_progress_id` AND `tkc_physical_progress`.`contract_id` = `grp`.`contract_id` AND `tkc_physical_progress`.`contract_location_id` = `grp`.`contract_location_id` INNER JOIN `contract` ON `tkc_physical_progress`.`contract_id` = `contract`.`contract_id` INNER JOIN `contract_location` ON `tkc_physical_progress`.`contract_id` = `contract_location`.`contract_id` AND `tkc_physical_progress`.`contract_location_id` = `contract_location`.`contract_location_id` LEFT JOIN `mst_user` ON `mst_user`.`user_id` = `tkc_physical_progress`.`reported_by` INNER JOIN `mst_region` ON `mst_region`.`region_id` = `contract_location`.`region_id` INNER JOIN `mst_circle` ON `mst_circle`.`circle_id` = `contract_location`.`circle_id` INNER JOIN `mst_division` ON `mst_division`.`division_id` = `contract_location`.`division_id` INNER JOIN `mst_status` ON `mst_status`.`status_id` = `tkc_physical_progress`.`status_id` INNER JOIN `mst_typeofwork` ON `mst_typeofwork`.`typeofwork_id` = `contract`.`typeofwork_id` LEFT JOIN (SELECT `tkc_physical_progress_id`, COUNT(`mst_typeofwork_activity`.`typeofwork_activity_id`) AS `tt_activity` FROM `tkc_physical_progress` `a` INNER JOIN 	`contract` ON `contract`.`contract_id` = `a`.`contract_id` INNER JOIN `mst_typeofwork_activity` ON `mst_typeofwork_activity`.`typeofwork_id` = `contract`.`typeofwork_id` GROUP BY `tkc_physical_progress_id`, `mst_typeofwork_activity`.`typeofwork_id`) `tt_act` ON `tt_act`.`tkc_physical_progress_id` = `tkc_physical_progress`.`tkc_physical_progress_id` LEFT JOIN (SELECT `A`.`tkc_physical_progress_id` AS `tkc_physical_progress_id`, IFNULL(COUNT(`A`.`activity_id`), 0) AS `comp_act` FROM (SELECT `P1`.`tkc_physical_progress_id`, `P1`.`contract_location_id`, `P2`.`activity_id`, `P2`.`status_id` FROM `contract` `C` LEFT JOIN `contract_location` `CL` ON `CL`.`contract_id` = `C`.`contract_id` LEFT JOIN (SELECT MAX(`tkc_physical_progress`.`tkc_physical_progress_id`) AS `tkc_physical_progress_id`, `tkc_physical_progress`.`contract_id`, `tkc_physical_progress`.`contract_location_id`, MAX(`reported_date`) AS `reported_date` FROM `tkc_physical_progress` GROUP BY `tkc_physical_progress`.`contract_id`, `tkc_physical_progress`.`contract_location_id`) `P` ON `P`.`contract_location_id` = `CL`.`contract_location_id` AND `P`.`contract_id` = `CL`.`contract_id` LEFT JOIN `tkc_physical_progress` `P1` ON `P1`.`tkc_physical_progress_id` = `P`.`tkc_physical_progress_id` LEFT JOIN `tkc_physical_progress_activity` `P2` ON `P2`.`tkc_physical_progress_id` = `P1`.`tkc_physical_progress_id` WHERE `CL`.`is_active` = 1) `A` LEFT JOIN	(SELECT `P1`.`tkc_physical_progress_id`, `P1`.`contract_location_id`, 1 AS `is_no_pending_observation`, `P`.`activity_id` FROM `mst_typeofwork_activity` `T` INNER JOIN `tkc_physical_progress_activity` `P` ON `P`.`activity_id` = `T`.`typeofwork_activity_id` INNER JOIN `tkc_physical_progress` `P1` ON `P1`.`tkc_physical_progress_id` = `P`.`tkc_physical_progress_id` INNER JOIN `contract_location` `CL` ON `CL`.`contract_location_id` = `P1`.`contract_location_id` AND `P1`.`contract_id` = `CL`.`contract_id` WHERE `CL`.`is_active` = 1 GROUP BY `P1`.`contract_id`, `P1`.`contract_location_id`, `P`.`activity_id`) `P3` ON `P3`.`contract_location_id` = `A`.`contract_location_id` AND `P3`.`activity_id` = `A`.`activity_id` WHERE (`A`.`status_id` = 1 AND IFNULL(`is_no_pending_observation`, 0) = 0) OR (`A`.`status_id` = 3) GROUP BY `A`.`tkc_physical_progress_id`) `cc_act` ON `cc_act`.`tkc_physical_progress_id` = `tkc_physical_progress`.`tkc_physical_progress_id` WHERE `tkc_physical_progress`.`is_draft` = 0 AND `tkc_physical_progress`.`status_id` IN(".$pp_status_ids.") AND `contract`.`status_id` = ".$active_contract_status_id." AND `contract_location`.`is_active` = 1 AND `contract`.`contract_id` = ".$contract_id." ".$contractor_query." ".$tender_award_no_query." ".$type_of_work_query." ".$site_location_query." ".$region_query." ".$circle_query." ".$division_query." ".$reported_by_query." ".$reported_date_query." ".$feeder_id_query." ".$status_query." ORDER BY `tkc_physical_progress`.`status_id` DESC, `tkc_physical_progress`.`reported_date` DESC;");
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

	public function getPreviousSheetDataAPI($prev_tkc_pp_id)
	{
		$this->db->select('tkc_physical_progress.contract_id, tkc_physical_progress.contract_location_id, tkc_physical_progress.site_location, contract.typeofwork_id');
		$this->db->from('tkc_physical_progress');
		$this->db->join('contract', 'tkc_physical_progress.contract_id = contract.contract_id', 'INNER');
		$this->db->where(array('tkc_physical_progress.tkc_physical_progress_id' => $prev_tkc_pp_id));

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

	public function saveTKCPhysicalVerificationSheet($contract_id, $contract_location_id, $site_location, $reported_by, $reported_date, $remark, $status_id, $is_draft, $geo_code = NULL, $user_id = NULL)
	{
		$data = array(
			'contract_id' => $contract_id,
			'contract_location_id' =>$contract_location_id,
			'site_location' => $site_location,
			'reported_by' => $reported_by,
			'reported_date' => $reported_date,
			'remark' => $remark,
			'is_draft' => $is_draft,
			'status_id' => $status_id,
			'createdby' => ($user_id != NULL) ? $user_id : $this->getLoggedInUserID(),
			'createddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->insert('tkc_physical_progress', $data);

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$insert_id = $this->db->insert_id();
			return $insert_id;
		}
	}

	public function updateTKCPhysicalVerificationSheet($tkc_pp_id, $contract_id, $contract_location_id, $site_location, $reported_by_id, $reported_date, $geo_code, $remark, $status_id, $is_draft, $user_id = NULL)
	{
		$data = array(
			'contract_id' => $contract_id,
			'contract_location_id' => $contract_location_id,
			'site_location' => $site_location,
			'reported_by' => $reported_by_id,
			'reported_date' => $reported_date,
			'geo_code' => $geo_code,
			'remark' => $remark,
			'is_draft' => $is_draft,
			'status_id' => $status_id,
			'modifiedby' => ($user_id != NULL) ? $user_id : $this->getLoggedInUserID(),
			'modifieddate' => date('Y-m-d H-i:s')
		);

		$query = $this->db->update('tkc_physical_progress', $data, array('tkc_physical_progress_id' => $pp_id));

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			if ($this->db->affected_rows() > 0) {
				return $tkc_pp_id;
			}
		}
	}

	public function saveActivity($tkc_pp_id, $sr_no, $activity_id, $unit_id, $status_id, $erected_qty)
	{
		$data = array(
			'tkc_physical_progress_id' => $tkc_pp_id,
			'sr_no' => $sr_no, 
			'activity_id' => $activity_id,
			'unit_id' => $unit_id,
			'status_id' => $status_id,
			'erected_qty' => $erected_qty,
			'is_active' => 1,
			'createdby' => $this->getLoggedInUserID(),
			'createddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->insert('tkc_physical_progress_activity', $data);

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			return $this->db->affected_rows();
		}
	}

	public function updateActivity($tkc_pp_id, $activity_id, $status_id, $erected_qty)
	{
		$data = array(
			'status_id' => $status_id,
			'erected_qty' => $erected_qty
		);

		$query = $this->db->update('tkc_physical_progress_activity', $data, array('tkc_physical_progress_id' => $tkc_pp_id, 'activity_id' => $activity_id));

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			if ($this->db->affected_rows() > 0) {
				return $activity_id;	
			}
		}
	}

	public function saveTKCPhysicalProgressCompletionFile($tkc_pp_id, $file_path, $user_id = NULL)
	{
		$data = array(
			'tkc_physical_progress_id' => $pp_id,
			'file_path' => $file_path,
			'is_active' => 1,
			'createdby' => ($user_id != NULL) ? $user_id : $this->getLoggedInUserID(),
			'createddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->insert('tkc_physical_progress_file', $data);

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			if ($this->db->affected_rows() > 0) {
				return $this->db->affected_rows();
			}
		}
	}

	public function updateSheetStatus($tkc_pp_id, $status_id, $sheet_remark = NULL)
	{
		$data = array(
			'status_id' => $status_id, 
			'modifiedby' => $this->getLoggedInUserID(), 
			'modifieddate' => date('Y-m-d H:i:s')
		);

		if ($sheet_remark != NULL) {
			$data['remark'] = $sheet_remark;
		}

		$query = $this->db->update('tkc_physical_progress', $data, array('tkc_physical_progress_id' => $tkc_pp_id));
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			if ($this->db->affected_rows() > 0) {
				return $this->db->affected_rows();
			}	
		}
	}

	public function getActivitiesListAPI($ppsheet_id, $work_id, $contract_location_id, $reported_date, $activity_id = NULL)
	{
		$status_field = ($reported_date != NULL) ? 'tkc_physical_progress_activity.status_id' : '';
		$this->db->select('mst_typeofwork_activity.typeofwork_activity_id, mst_typeofwork_activity.typeofwork_id, mst_typeofwork_activity.activity_group_id, mst_activity_group.is_boq, mst_activity_group.name as activity_group_name, mst_typeofwork_activity.unit_id, mst_unit.name as unit_name, mst_typeofwork_activity.seqno, mst_typeofwork_activity.activity,'.$status_field);
		$this->db->from('mst_typeofwork_activity');
		$this->db->join('mst_activity_group', 'mst_typeofwork_activity.activity_group_id = mst_activity_group.activity_group_id', 'INNER');
		$this->db->join('mst_unit', 'mst_typeofwork_activity.unit_id = mst_unit.unit_id', 'INNER');

		if ($reported_date != NULL) {
			$this->db->join('tkc_physical_progress_activity', 'mst_typeofwork_activity.typeofwork_activity_id = tkc_physical_progress_activity.activity_id');
		}
		
		$this->db->where(array('mst_typeofwork_activity.typeofwork_id' => $work_id));

		if ($reported_date != NULL) {
			$this->db->where('tkc_physical_progress_activity.tkc_physical_progress_id', $ppsheet_id);
		}

		if ($activity_id) {
			$this->db->where('mst_typeofwork_activity_options.typeofwork_activity_id', $activity_id);
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

				if (is_null($activity_id)) {
					foreach ($query_result as $key => $value) {
						if ($value['is_boq'] == 1) {
							$query_result[$key]['boq'] = $this->getBOQ($value['typeofwork_activity_id'], $contract_location_id);
							$query_result[$key]['erected_qty'] = $this->getErectedQuantity($ppsheet_id, $value['typeofwork_activity_id']);
						}

						$query_result[$key]['status_id'] = isset($value['status_id']) ? $value['status_id'] : '0';
					}

					return $query_result;
				} else {
					return $query_result;
				}
			}
		}
	}

	public function getActivitiesList($work_id, $contract_location_id, $activity_id = NULL)
	{
		$this->db->select('mst_typeofwork_activity.typeofwork_activity_id, mst_typeofwork_activity.typeofwork_id, mst_typeofwork_activity.activity_group_id, mst_activity_group.is_boq, mst_activity_group.name as activity_group_name, mst_typeofwork_activity.unit_id, mst_unit.name, mst_typeofwork_activity.seqno, mst_typeofwork_activity.activity');
		$this->db->from('mst_typeofwork_activity');
		$this->db->join('mst_activity_group', 'mst_typeofwork_activity.activity_group_id = mst_activity_group.activity_group_id', 'INNER');
		$this->db->join('mst_unit', 'mst_typeofwork_activity.unit_id = mst_unit.unit_id', 'INNER');
		$this->db->where(array('mst_typeofwork_activity.typeofwork_id' => $work_id));

		if ($activity_id) {
			$this->db->where('mst_typeofwork_activity_options.typeofwork_activity_id', $activity_id);
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

				if (is_null($activity_id)) {
					foreach ($query_result as $key => $value) {
						if ($value['is_boq'] == 1) {
							$query_result[$key]['boq'] = $this->getBOQ($value['typeofwork_activity_id'], $contract_location_id);
						}
					}

					return $query_result;
				} else {
					return $query_result;
				}
			}
		}
	}

	public function getActivitiesGroupByWork($work_id, $type)
	{
		$this->db->distinct();

		if ($type === 'API') {
			$this->db->select('mst_typeofwork_activity.typeofwork_id, mst_typeofwork_activity.activity_group_id, mst_activity_group.name, mst_activity_group.is_boq');	
		} else {
			$this->db->select('mst_typeofwork_activity.typeofwork_id, mst_typeofwork_activity.activity_group_id, mst_activity_group.name');	
		}

		$this->db->from('mst_typeofwork_activity');
		$this->db->join('mst_activity_group','mst_typeofwork_activity.activity_group_id = mst_activity_group.activity_group_id','inner');
		$this->db->where('mst_typeofwork_activity.typeofwork_id', $work_id);

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

	public function getAppliedActivitiesList($ppsheet_id, $contract_location_id, $reported_date = NULL)
	{
		$this->db->select('tkc_physical_progress_activity.tkc_physical_progress_activity_id, tkc_physical_progress_activity.tkc_physical_progress_id, tkc_physical_progress_activity.sr_no, tkc_physical_progress_activity.activity_id, tkc_physical_progress_activity.unit_id, mst_unit.name as unit_name, tkc_physical_progress_activity.status_id, tkc_physical_progress_activity.erected_qty, tkc_physical_progress_activity.remarks, mst_typeofwork_activity.activity_group_id, mst_activity_group.is_boq, mst_activity_group.name as activity_group_name');
		$this->db->from('tkc_physical_progress_activity');
		$this->db->join('mst_typeofwork_activity', 'tkc_physical_progress_activity.activity_id = mst_typeofwork_activity.typeofwork_activity_id', 'INNER');
		$this->db->join('mst_activity_group', 'mst_typeofwork_activity.activity_group_id = mst_activity_group.activity_group_id', 'LEFT');
		$this->db->join('mst_unit', 'tkc_physical_progress_activity.unit_id = mst_unit.unit_id', 'INNER');
		$this->db->where(array('tkc_physical_progress_activity.tkc_physical_progress_id' => $ppsheet_id));

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

				foreach ($query_result as $key => $value) {
					$query_result[$key]['typeofwork_activity_id'] = $value['activity_id'];
					$typeofwork_id = $this->getActivityData($value['activity_id'], 'typeofwork_id');
					$query_result[$key]['typeofwork_id'] = $typeofwork_id;

					$activity_group_id = $this->getActivityData($value['activity_id'], 'activity_group_id');
					$query_result[$key]['activity_group_id'] = $activity_group_id;

					if ($value['is_boq'] == 1) {
						$query_result[$key]['boq'] = $this->getBOQ($value['activity_id'], $contract_location_id);
					}

					$query_result[$key]['seqno'] = $this->getActivityData($value['activity_id'], 'seqno');
					$query_result[$key]['activity'] = $this->getActivityData($value['activity_id'], 'activity');
				}
			}

			return $query_result;
		}
	}

	public function checkActivity($activity_id, $tkc_pp_id)
	{
		$query = $this->db->get_where('tkc_physical_progress_activity', array('activity_id' => $activity_id, 'tkc_physical_progress_id' => $tkc_pp_id));
		// echo $this->db->last_query().'<br/>'; 

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

	public function saveActivityAPI($tkc_pp_id, $sr_no, $activity_id, $unit_id, $status_id, $erected_qty, $user_id)
	{
		$data = array(
			'tkc_physical_progress_id' => $tkc_pp_id,
			'sr_no' => $sr_no, 
			'activity_id' => $activity_id,
			'unit_id' => $unit_id,
			'status_id' => $status_id,
			'erected_qty' => $erected_qty,
			'is_active' => 1,
			'createdby' => $user_id,
			'createddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->insert('tkc_physical_progress_activity', $data);

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$insert_id = $this->db->insert_id();
			return $insert_id;
		}
	}

	public function getActivityData($activity_id, $column)
	{
		$this->db->select($column);
		$query = $this->db->get_where('mst_typeofwork_activity', array('typeofwork_activity_id' => $activity_id));
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$query_result = [];
			if ($query->num_rows() > 0) {
				$result = $query->row_array();

				$query_result = $result[$column];
			}

			return $query_result;
		}
	}

	public function getAppliedActivitiesListForSheetStatusCalculation($tkc_pp_id)
	{
		$this->db->select('activity_id');
		$this->db->where('tkc_physical_progress_id', $tkc_pp_id);
		$this->db->where_in('status_id', array(0,4));

		$query = $this->db->get('tkc_physical_progress_activity');
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			return $query->num_rows();
		}
	}

	public function getBOQ($typeofwork_activity_id, $contract_location_id)
	{
		$this->db->select('boq');
		$query = $this->db->get_where('contract_location_boq', array('typeofwork_activity_id' => $typeofwork_activity_id, 'contract_location_id' => $contract_location_id, 'is_active' => 1));
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$query_result = 0;
			if ($query->num_rows() > 0) {
				$boq_result = $query->row_array();
				$query_result = $boq_result['boq'];
			}

			return $query_result;
		}
	}

	public function getErectedQuantity($pp_id, $activity_id)
	{
		$this->db->select('erected_qty');
		$query = $this->db->get_where('tkc_physical_progress_activity', array('tkc_physical_progress_id' => $pp_id, 'activity_id' => $activity_id));
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$query_result = [];

			if ($query->num_rows() > 0) {
				$result = $query->row_array();
				$query_result = $result['erected_qty'];
			}

			return $query_result;
		}
	}

	public function getPrevSheetDates($contract_id, $contract_location_id, $site_location)
	{
		$where_array = array('contract_id' => $contract_id, 'contract_location_id' => $contract_location_id, 'site_location' => $site_location, 'reported_date !=' => NULL);

		$this->db->select('tkc_physical_progress_id, reported_date');
		$this->db->from('tkc_physical_progress');
		$this->db->where($where_array);

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

	public function getTypeOfWorkList($user_id)
	{
		$package_access = $this->getTKCPackageAccess($user_id);
		$contract_id = $this->getContractIDFromPackageAccess($package_access);

		// $query =  $this->db->select('typeofwork_id, name')->get('mst_typeofwork');

		$this->db->select('contract.typeofwork_id, mst_typeofwork.name');
		$this->db->from('contract');
		$this->db->join('mst_typeofwork', 'contract.typeofwork_id = mst_typeofwork.typeofwork_id', 'INNER');
		$this->db->where(array('contract.contract_id' => $contract_id));

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

	public function getRegion($region_id)
	{
		$query = $this->db->get_where('mst_region', array('region_id' => $region_id));

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$query_result = [];

			if ($query->num_rows() > 0) {
				$result = $query->row_array();

				$query_result = $result['region_name'];
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
			$query_result = [];

			if ($query->num_rows() > 0) {
				$result = $query->row_array();

				$query_result = $result['circle_name'];
			}

			return $query_result;
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
			$query_result = [];

			if ($query->num_rows() > 0) {
				$result = $query->row_array();

				$query_result = $result['division_name'];
			}

			return $query_result;
		}
	}

	public function getTypeOfWork($work_id)
	{
		$query = $this->db->get_where('mst_typeofwork', array('typeofwork_id' => $work_id));

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$query_result = [];

			if ($query->num_rows() > 0) {
				$result = $query->row_array();

				$query_result = $result['name'];
			}

			return $query_result;
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
			$query_result = [];

			if ($query->num_rows() > 0) {
				$result = $query->row_array();

				$query_result = $result['name'];
			}

			return $query_result;
		}
	}

	public function getRegionList($user_id = NULL)
	{
		$package_access = $this->getTKCPackageAccess($user_id);
		$contract_id = $this->getContractIDFromPackageAccess($package_access);

		$this->db->distinct();
		$this->db->select('contract_location.region_id, mst_region.region_name');
		$this->db->from('contract_location');
		$this->db->join('mst_region', 'contract_location.region_id = mst_region.region_id', 'INNER');
		$this->db->where(array('contract_location.contract_id' => $contract_id));

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

	public function getRegionCircleData($user_id)
	{
		$package_access = $this->getTKCPackageAccess($user_id);
		$contract_id = $this->getContractIDFromPackageAccess($package_access);

		$this->db->distinct();
		$this->db->select('contract_location.circle_id, mst_circle.circle_name, mst_circle.region_id');
		$this->db->from('contract_location');
		$this->db->join('mst_circle', 'contract_location.circle_id = mst_circle.circle_id', 'INNER');
		$this->db->where(array('contract_location.contract_id' => $contract_id));

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

	public function getCircleDivisionData($user_id)
	{
		$package_access = $this->getTKCPackageAccess($user_id);
		$contract_id = $this->getContractIDFromPackageAccess($package_access);

		$this->db->distinct();
		$this->db->select('contract_location.division_id, mst_division.division_name, mst_division.circle_id');
		$this->db->from('contract_location');
		$this->db->join('mst_division', 'contract_location.division_id = mst_division.division_id', 'INNER');
		$this->db->where(array('contract_location.contract_id' => $contract_id));

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

	public function getCircleListOfRegion($region_id)
	{
		$this->db->select('circle_id, circle_name');
		$query = $this->db->get_where('mst_circle', array('is_active' => 1, 'region_id' => $region_id));

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

	public function getReportedByID($reportedByName, $clause = NULL)
	{
		if ($clause != NULL && $clause == 'LIKE') {
			$this->db->like('username', $reportedByName);
			$query = $this->db->get('mst_user');
		} elseif ($clause == NULL) {
			$query = $this->db->get_where('mst_user', array('username' => $reportedByName));	
		}

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$query_result = [];

			if ($query->num_rows() > 0) {
				$result = $query->row_array();

				$query_result = $result['user_id'];
			}

			return $query_result;
		}
	}

	public function getReportedByName($reportedByID)
	{
		$query = $this->db->get_where('mst_user', array('user_id' => $reportedByID));

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$query_result = [];

			if ($query->num_rows() > 0) {
				$result = $query->row_array();
				$query_result = $result['username'];
			}

			return $query_result;
		}
	}

	public function getGeoLocationRadius()
	{
		$display_name = 'GEO_LOCATION_RADIUS';
		$query = $this->db->get_where('sysconfig', array('display_name' => $display_name));
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$query_result = 0;

			if ($query->num_rows() > 0) {
				$result = $query->row_array();
				$query_result = $result['fieldvalue'];
			}

			return $query_result;
		}
	}

	public function getStatusList()
	{
		$this->db->select('mst_module.module_id, mst_module.name, mst_status.status_id, mst_status.name, mst_status.seqno');
		$this->db->from('mst_module');
		$this->db->join('mst_status', 'mst_module.module_id = mst_status.module_id', 'INNER');
		$this->db->where(array('mst_module.name' => 'TKC Physical Verification', 'mst_module.icon !=' => ''));

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

	public function getUserRole($roleId)
	{
		$query = $this->db->get_where('mst_role', array('role_id' => $roleId));

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$query_result = [];

			if ($query->num_rows() > 0) {
				$result = $query->row_array();

				$query_result = $result['name'];
			}

			return $query_result;	
		}
	}

	//Function to sort array by key
	public function sort_array_by_key($array, $sort_key)
	{
		$key_array = array_column($array, $sort_key);
		array_multisort($key_array, SORT_ASC, $array); //or SORT_DESC
		return $array;
	}
}


?>