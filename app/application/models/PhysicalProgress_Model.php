<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class PhysicalProgress_Model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	public function getPhysicalProgressSheets_old()
	{
		$where_in_array = array('1', '2', '3');

		$this->db->select('physical_progress.*, contract.contract_id, contract.contractor_name, contract.tender_award_no, contract.tender_award_date, contract.package_no, contract.typeofwork_id,  contract_location.contract_location_id, contract_location.contract_id, contract_location.region_id, contract_location.circle_id, contract_location.division_id, contract_location.location_name, contract_location.feeder_name, contract_location.feeder_id, contract_location.geo_code, contract_location.quantity, contract_location.revised_quantity');
		$this->db->from('physical_progress');
		$this->db->join('contract', 'physical_progress.contract_id = contract.contract_id', 'inner');
		$this->db->join('contract_location', 'physical_progress.contract_id = contract_location.contract_id AND physical_progress.contract_location_id = contract_location.contract_location_id', 'inner');
		/*$this->db->where('physical_pr-ogress.status_id', 1);
		$this->db->or_where('physical_progress.status_id', 2);*/
		$this->db->where_in('physical_progress.status_id', $where_in_array);
		$this->db->where('physical_progress.is_draft', 0);

		/*$this->db->where('physical_progress.reported_by is NULL');
		$this->db->where('physical_progress.reported_date is NULL');*/
		// $this->db->where('physical_progress.status_id !=', 3);

		$query = $this->db->get();
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$result = [];
			if ($query->num_rows() > 0) {
				$query_result = $query->result_array();

				foreach ($query_result as $key => $value) {
					$value['reported_by_name'] = $this->getReportedByName($value['reported_by']);

					$value['region_name'] = $this->getRegion($value['region_id']);

					$value['circle_name'] = $this->getCircle($value['circle_id']);

					$value['division_name'] = $this->getDivision($value['division_id']);

					$value['typeofwork'] = $this->getTypeOfWork($value['typeofwork_id']);

					$value['sheet_status'] = $this->getSheetStatus($value['status_id']);
					array_push($result, $value);
				}
			}

			return $result;
		}
	}

	public function getPhysicalProgressSheets($pp_list_status_ids, $user_id = NULL, $offset = NULL, $limit = NULL)
	{
		$user_id = ($user_id != NULL) ? $user_id : $this->getLoggedInUserID();
		$limit_query = '';

		if ($limit != NULL) {
			$limit_query = 'LIMIT '. $offset .','.$limit;
		}

		$contract_status_list = $this->getContractStatusList();
		$active_contract_status_id = $contract_status_list['Open'];

		$_SESSION['feeder_query'] = $sql_stmt = "SELECT physical_progress.physical_progress_id, physical_progress.contract_id, physical_progress.contract_location_id, physical_progress.site_location, physical_progress.reported_by, physical_progress.reported_date, physical_progress.status_id, contract.contract_id, contract.contractor_name, contract.tender_award_no, contract.typeofwork_id, contract_location.contract_location_id, contract_location.region_id, contract_location.circle_id, contract_location.division_id, contract_location.location_name, contract_location.feeder_id, contract_location.charging_status, mst_user.username AS pp_reported_by, mst_region.region_name, mst_circle.circle_name, mst_division.division_name, mst_status.name AS sheet_status, mst_typeofwork.name AS typeofwork_name, case when  physical_progress.status_id=1 then IFNULL(tt_act.tt_activity, 0) else IFNULL(cz_act.comp_act, 0) end AS tt_task, IFNULL(cc_act.comp_act, 0) AS cc_task, IFNULL(tt_obs.tt_observation, 0) AS tt_observation, IFNULL(cc_obs.cc_observation, 0) AS cc_observation FROM (SELECT MAX(physical_progress.physical_progress_id) AS physical_progress_id, physical_progress.contract_id, physical_progress.contract_location_id, MAX(reported_date) AS reported_date FROM physical_progress WHERE physical_progress.is_draft = 0 GROUP BY physical_progress.contract_id, physical_progress.contract_location_id) grp INNER JOIN physical_progress ON physical_progress.physical_progress_id = grp.physical_progress_id AND physical_progress.contract_id = grp.contract_id AND physical_progress.contract_location_id = grp.contract_location_id INNER JOIN contract ON physical_progress.contract_id = contract.contract_id INNER JOIN contract_location ON physical_progress.contract_id = contract_location.contract_id AND physical_progress.contract_location_id = contract_location.contract_location_id LEFT JOIN mst_user_data_access U ON U.region_id = contract_location.region_id AND U.circle_id = contract_location.circle_id AND U.division_id = contract_location.division_id LEFT JOIN mst_user ON mst_user.user_id = physical_progress.reported_by INNER JOIN mst_region ON mst_region.region_id = contract_location.region_id INNER JOIN mst_circle ON mst_circle.circle_id = contract_location.circle_id INNER JOIN mst_division ON mst_division.division_id = contract_location.division_id INNER JOIN mst_status ON mst_status.status_id = physical_progress.status_id INNER JOIN mst_typeofwork ON mst_typeofwork.typeofwork_id = contract.typeofwork_id LEFT JOIN(SELECT physical_progress_id, COUNT(mst_typeofwork_activity.typeofwork_activity_id) AS tt_activity FROM physical_progress a INNER JOIN contract ON contract.contract_id = a.contract_id INNER JOIN mst_typeofwork_activity ON mst_typeofwork_activity.typeofwork_id = contract.typeofwork_id GROUP BY physical_progress_id, mst_typeofwork_activity.typeofwork_id) tt_act ON tt_act.physical_progress_id = physical_progress.physical_progress_id LEFT JOIN(SELECT A.physical_progress_id AS physical_progress_id, IFNULL(COUNT(A.activity_id),0) AS comp_act FROM (SELECT P1.physical_progress_id, P1.contract_location_id, P2.activity_id, P2.status_id FROM contract C LEFT JOIN contract_location CL ON CL.contract_id = C.contract_id LEFT JOIN(SELECT MAX(physical_progress.physical_progress_id) AS physical_progress_id, physical_progress.contract_id, physical_progress.contract_location_id, MAX(reported_date) AS reported_date FROM physical_progress GROUP BY physical_progress.contract_id, physical_progress.contract_location_id) P ON P.contract_location_id = CL.contract_location_id AND P.contract_id = CL.contract_id LEFT JOIN physical_progress P1 ON P1.physical_progress_id = P.physical_progress_id LEFT JOIN physical_progress_activity P2 ON P2.physical_progress_id = P1.physical_progress_id WHERE CL.is_active = 1) A GROUP BY A.physical_progress_id) cz_act ON cz_act.physical_progress_id = physical_progress.physical_progress_id LEFT JOIN(SELECT A.physical_progress_id AS physical_progress_id, IFNULL(COUNT(A.activity_id),0) AS comp_act FROM (SELECT P1.physical_progress_id, P1.contract_location_id, P2.activity_id, P2.status_id FROM contract C LEFT JOIN contract_location CL ON CL.contract_id = C.contract_id LEFT JOIN(SELECT MAX(physical_progress.physical_progress_id) AS physical_progress_id, physical_progress.contract_id, physical_progress.contract_location_id, MAX(reported_date) AS reported_date FROM physical_progress GROUP BY physical_progress.contract_id, physical_progress.contract_location_id) P ON P.contract_location_id = CL.contract_location_id AND P.contract_id = CL.contract_id LEFT JOIN physical_progress P1 ON P1.physical_progress_id = P.physical_progress_id LEFT JOIN physical_progress_activity P2 ON P2.physical_progress_id = P1.physical_progress_id WHERE CL.is_active = 1 ) A LEFT JOIN(SELECT P1.physical_progress_id, P1.contract_location_id, 1 AS is_no_pending_observation, P.activity_id FROM mst_typeofwork_activity T INNER JOIN physical_progress_activity P ON P.activity_id = T.typeofwork_activity_id INNER JOIN physical_progress P1 ON P1.physical_progress_id = P.physical_progress_id INNER JOIN physical_progress_activity_observation P2 ON P2.contract_location_id = P1.contract_location_id AND P.activity_id = P2.activity_id AND P2.completion_date IS NULL INNER JOIN contract_location CL ON CL.contract_location_id = P1.contract_location_id AND P1.contract_id = CL.contract_id WHERE CL.is_active = 1 AND P2.deletedby IS NULL GROUP BY P1.contract_id, P1.contract_location_id, P.activity_id) P3 ON P3.contract_location_id = A.contract_location_id AND P3.activity_id = A.activity_id WHERE (A.status_id = 1 AND IFNULL(is_no_pending_observation, 0) = 0) OR(A.status_id = 3) GROUP BY A.physical_progress_id) cc_act ON cc_act.physical_progress_id = physical_progress.physical_progress_id LEFT JOIN(SELECT contract_location_id, COUNT(observation_id) AS tt_observation FROM physical_progress_activity_observation WHERE physical_progress_activity_observation.deletedby IS NULL GROUP BY contract_location_id) tt_obs ON tt_obs.contract_location_id = contract_location.contract_location_id LEFT JOIN(SELECT contract_location_id, COUNT(observation_id) AS cc_observation FROM physical_progress_activity_observation WHERE IFNULL(completion_date, '') <> '' GROUP BY contract_location_id) cc_obs ON cc_obs.contract_location_id = contract_location.contract_location_id WHERE physical_progress.is_draft = 0 AND physical_progress.status_id IN (".$pp_list_status_ids.") AND contract.status_id = ".$active_contract_status_id." AND contract_location.is_active = 1 AND U.user_id = ".$user_id." ORDER BY physical_progress.status_id DESC, physical_progress.reported_date DESC ".$limit_query.";";

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

	public function getSheetData($prev_pp_id)
	{
		$query = $this->db->get_where('physical_progress', array('physical_progress_id' => $prev_pp_id));

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			if ($query->num_rows() > 0) {
				$query_result = $query->row_array();

				return $query_result;
			}
		}
	}

	public function getPrevSheetDates($contract_id, $contract_location_id, $site_location)
	{
		$where_array = array('contract_id' => $contract_id, 'contract_location_id' => $contract_location_id, 'site_location' => $site_location, 'reported_date !=' => NULL);

		$this->db->select('physical_progress_id, reported_date');
		$this->db->from('physical_progress');
		$this->db->where($where_array);

		$query = $this->db->get();
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

	public function getSheetDetail($mode, $ppsheet_id, $contract_id, $contract_location_id, $reported_date = NULL, $type = NULL)
	{
		$this->db->select('physical_progress.*, contract.contractor_name, contract.tender_award_no, contract.tender_award_date, contract.package_no, contract.typeofwork_id,contract_location.region_id, contract_location.circle_id, contract_location.division_id,contract_location.location_name, contract_location.feeder_name, contract_location.feeder_id, contract_location.geo_code, contract_location.charging_status');
		$this->db->from('physical_progress');
		$this->db->join('contract', 'physical_progress.contract_id = contract.contract_id', 'inner');
		$this->db->join('contract_location', 'physical_progress.contract_id = contract_location.contract_id AND physical_progress.contract_location_id = contract_location.contract_location_id', 'inner');
		$this->db->where('physical_progress.physical_progress_id', $ppsheet_id);

		if ($type == NULL && $reported_date != NULL) {
			$this->db->where('physical_progress.reported_date', $reported_date);	
		}

		$query = $this->db->get();
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
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
						$group_name_arr = [];
						$group_model_arr = [];
						foreach ($activities_list as $key => $value) {
							array_push($group_name_arr, $value['activity_group_name']);
							array_push($group_model_arr, $value['activity_group_model']);
						}

						// $query_result['activities_group_name'] = array_unique($group_name_arr);
						$activity_groups = $this->getActivitiesGroupByWork($query_result['typeofwork_id'], $type);
						$query_result['activities_group_name'] = $activity_groups;

						// $query_result['activities_group_model'] = array_unique($group_model_arr);
					}
				} elseif ($mode == 'edit-prev' || $mode == 'view' || $mode == 'view-by-date' || $mode = 'edit-review') {
					if ($mode == 'view' || $mode = 'view-by-date') {
						//Fetching completion file details in case of viewing status complete sheet
						$completion_file_result = $this->getPhysicalProgressCompletionFile($ppsheet_id);

						if (!empty($completion_file_result)) {
							$query_result['ppsheet_completion_file'] = $completion_file_result;
						}
					}

					$activities_list = $this->getAppliedActivitiesList($ppsheet_id, $query_result['contract_location_id'], $reported_date);
					
					$activities_list_by_seqno = $this->sort_array_by_key($activities_list, 'seqno');

					$query_result['activities_list'] = $activities_list_by_seqno;

					$group_name_arr = [];
					$group_model_arr = [];
					foreach ($activities_list as $key => $value) {
						array_push($group_name_arr, $value['activity_group_name']);
						// array_push($group_model_arr, $value['activity_group_model']);
					}

					// $query_result['activities_group_name'] = array_unique($group_name_arr);
					// $group_name_arr = array_unique($group_name_arr);
					$activity_groups = $this->getActivitiesGroupByWork($query_result['typeofwork_id'], $type);
					$query_result['activities_group_name'] = $activity_groups;
				}
				
				return $query_result;
			}
		}
	}

	public function getPreviousSheetDataAPI($prev_pp_id)
	{
		$this->db->select('physical_progress.contract_id, physical_progress.contract_location_id, physical_progress.site_location, contract.typeofwork_id');
		$this->db->from('physical_progress');
		$this->db->join('contract', 'physical_progress.contract_id = contract.contract_id', 'INNER');
		$this->db->where(array('physical_progress.physical_progress_id' => $prev_pp_id));

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

	public function searchSheets_old($contractor, $tender_award_no, $type_of_work, $site_location, $region, $circle, $division, $reported_by, $reported_date, $feeder_id, $status)
	{
		$this->db->select('physical_progress.*, contract.contract_id, contract.contractor_name, contract.tender_award_no, contract.tender_award_date, contract.package_no, contract.typeofwork_id,  contract_location.contract_location_id, contract_location.contract_id, contract_location.region_id, contract_location.circle_id, contract_location.division_id, contract_location.location_name, contract_location.feeder_name, contract_location.feeder_id, contract_location.geo_code, contract_location.quantity, contract_location.revised_quantity');
		$this->db->from('physical_progress');
		$this->db->join('contract', 'physical_progress.contract_id = contract.contract_id', 'inner');
		$this->db->join('contract_location', 'physical_progress.contract_id = contract_location.contract_id AND physical_progress.contract_location_id = contract_location.contract_location_id', 'inner');

		//adding search filters to the query
		if (!empty($contractor)) {
			$this->db->where('contract.contractor_name', $contractor);
		}

		if (!empty($tender_award_no)) {
			$this->db->where('contract.tender_award_no', $tender_award_no);
		}

		if (!empty($type_of_work)) {
			$this->db->where('contract.typeofwork_id', $type_of_work);
		}

		if (!empty($site_location)) {
			$this->db->like('contract_location.location_name', $site_location);
		}

		if (!empty($region)) {
			$this->db->where('contract_location.region_id', $region);
		}

		if (!empty($circle)) {
			$this->db->where('contract_location.circle_id', $circle);
		}

		if (!empty($division)) {
			$this->db->where('contract_location.division_id', $division);
		}

		if (!empty($reported_by)) {
			$this->db->where('physical_progress.reported_by', $reported_by);
		}

		if (!empty($reported_date)) {
			$this->db->where('physical_progress.reported_date', $reported_date);
		}

		if (!empty($feeder_id)) {
			$this->db->where('contract_location.feeder_id', $feeder_id);
		}

		if (!empty($status)) {
			$this->db->where_in('physical_progress.status_id', $status);
		}

		$query = $this->db->get();
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$result = [];

			if ($query->num_rows() > 0) {
				$query_result = $query->result_array();

				$result = [];

				foreach ($query_result as $key => $value) {
					$value['reported_by_name'] = $this->getReportedByName($value['reported_by']);

					$value['region_name'] = $this->getRegion($value['region_id']);

					$value['circle_name'] = $this->getCircle($value['circle_id']);

					$value['division_name'] = $this->getDivision($value['division_id']);

					$value['typeofwork'] = $this->getTypeOfWork($value['typeofwork_id']);

					$value['sheet_status'] = $this->getSheetStatus($value['status_id']);
					array_push($result, $value);
				}
			}

			return $result;
		}
	}

	// public function searchSheets($contractor, $tender_award_no, $type_of_work, $site_location, $region, $circle, $division, $reported_by, $reported_date, $feeder_id, $charging_status, $status, $user_id = NULL, $offset = NULL, $limit = NULL)
	public function searchSheets($contractor, $tender_award_no, $type_of_work, $site_location, $region, $circle, $division, $reported_by, $start_date, $end_date, $feeder_id, $charging_status, $status, $user_id = NULL, $offset = NULL, $limit = NULL)
	{

		$user_id = ($user_id != NULL) ? $user_id : $this->getLoggedInUserID();
		$limit_query = '';

		if ($limit != NULL) {
			$limit_query = 'LIMIT '. $offset .','.$limit;
		}

		$contract_status_list = $this->getContractStatusList();
		$active_contract_status_id = $contract_status_list['Open'];

		//adding search filters to the query
		$contractor_query = (!empty($contractor)) ? "and (ifnull(`contract`.`contractor_name`,'')<>'' and `contract`.`contractor_name` like '%".$contractor."%')" : '';

		$tender_award_no_query = (!empty($tender_award_no)) ? "and (ifnull(`contract`.`tender_award_no`,'')<>'' and `contract`.`tender_award_no` like '%".$tender_award_no."%')": '';

		$type_of_work_query = (!empty($type_of_work)) ? "and (ifnull(`contract`.`typeofwork_id`,0)<>0 and `contract`.`typeofwork_id` = ".$type_of_work.")": '';

		$site_location_query = (!empty($site_location)) ? "and (ifnull(`contract_location`.`location_name`,'')<>'' and `contract_location`.`location_name` like '%".$site_location."%')" : '';

		$region_query = (!empty($region)) ? "and (ifnull(`contract_location`.`region_id`,0)<>0 and `contract_location`.`region_id` = ".$region.")" : '';

		$circle_query = (!empty($circle)) ? "and (ifnull(`contract_location`.`circle_id`,0)<>0 and `contract_location`.`circle_id` = ".$circle.")" : '';

		$division_query = (!empty($division)) ? "and (ifnull(`contract_location`.`division_id`,0)<>0 and `contract_location`.`division_id` = ".$division.")" : '';

		$reported_by_query = (!empty($reported_by)) ? "and (ifnull(`physical_progress`.`reported_by`,0)<>0 and `physical_progress`.`reported_by` like '%".$reported_by."%')" : '';
		
		if ($user_id == NULL) {
			$reported_date_query = (!empty($start_date) && !empty($end_date)) ? "and (ifnull(`physical_progress`.`reported_date`,'')<>'' and `physical_progress`.`reported_date` between '".$start_date."' and '".$end_date."')" : '';	
		} else {
			$reported_date_query = (!empty($start_date)) ? "and (ifnull(`physical_progress`.`reported_date`,'')<>'' and `physical_progress`.`reported_date` like '%".$start_date."%')" : '';	
		}

		$feeder_id_query = (!empty($feeder_id)) ? "and (ifnull(`contract_location`.`feeder_id`,0)<>0 and `contract_location`.`feeder_id` like '%".$feeder_id."%')" : '';

		$charging_status_query = (!empty($charging_status) && ($charging_status == 'yes')) ? "and `contract_location`.`charging_status` = 'yes'" : ((!empty($charging_status) && ($charging_status == 'no') ) ? "and (`contract_location`.`charging_status` = 'no' or `contract_location`.`charging_status` IS NULL)" : '');

		$status_query = (!empty($status)) ? "and (ifnull(`physical_progress`.`status_id`,0)<>0 and `physical_progress`.`status_id` IN (".$status."))" : '';

		$_SESSION['feeder_query'] = $sql_stmt = "SELECT physical_progress.physical_progress_id, physical_progress.contract_id, physical_progress.contract_location_id, physical_progress.site_location, physical_progress.reported_by, physical_progress.reported_date, physical_progress.status_id, contract.contract_id, contract.contractor_name, contract.tender_award_no, contract.typeofwork_id, contract_location.contract_location_id, contract_location.region_id, contract_location.circle_id, contract_location.division_id, contract_location.location_name, contract_location.feeder_id, contract_location.charging_status, mst_user.username AS pp_reported_by, mst_region.region_name, mst_circle.circle_name, mst_division.division_name, mst_status.name AS sheet_status, mst_typeofwork.name AS typeofwork_name, case when  physical_progress.status_id=1 then IFNULL(tt_act.tt_activity, 0) else IFNULL(cz_act.comp_act, 0) end AS tt_task, IFNULL(cc_act.comp_act, 0) AS cc_task, IFNULL(tt_obs.tt_observation, 0) AS tt_observation, IFNULL(cc_obs.cc_observation, 0) AS cc_observation FROM (SELECT MAX(physical_progress.physical_progress_id) AS physical_progress_id, physical_progress.contract_id, physical_progress.contract_location_id, MAX(reported_date) AS reported_date FROM physical_progress WHERE physical_progress.is_draft = 0 GROUP BY physical_progress.contract_id, physical_progress.contract_location_id) grp INNER JOIN physical_progress ON physical_progress.physical_progress_id = grp.physical_progress_id AND physical_progress.contract_id = grp.contract_id AND physical_progress.contract_location_id = grp.contract_location_id INNER JOIN contract ON physical_progress.contract_id = contract.contract_id INNER JOIN contract_location ON physical_progress.contract_id = contract_location.contract_id AND physical_progress.contract_location_id = contract_location.contract_location_id LEFT JOIN mst_user_data_access U ON U.region_id = contract_location.region_id AND U.circle_id = contract_location.circle_id AND U.division_id = contract_location.division_id LEFT JOIN mst_user ON mst_user.user_id = physical_progress.reported_by INNER JOIN mst_region ON mst_region.region_id = contract_location.region_id INNER JOIN mst_circle ON mst_circle.circle_id = contract_location.circle_id INNER JOIN mst_division ON mst_division.division_id = contract_location.division_id INNER JOIN mst_status ON mst_status.status_id = physical_progress.status_id INNER JOIN mst_typeofwork ON mst_typeofwork.typeofwork_id = contract.typeofwork_id LEFT JOIN(SELECT physical_progress_id, COUNT(mst_typeofwork_activity.typeofwork_activity_id) AS tt_activity FROM physical_progress a INNER JOIN contract ON contract.contract_id = a.contract_id INNER JOIN mst_typeofwork_activity ON mst_typeofwork_activity.typeofwork_id = contract.typeofwork_id GROUP BY physical_progress_id, mst_typeofwork_activity.typeofwork_id) tt_act ON tt_act.physical_progress_id = physical_progress.physical_progress_id LEFT JOIN(SELECT A.physical_progress_id AS physical_progress_id, IFNULL(COUNT(A.activity_id),0) AS comp_act FROM (SELECT P1.physical_progress_id, P1.contract_location_id, P2.activity_id, P2.status_id FROM contract C LEFT JOIN contract_location CL ON CL.contract_id = C.contract_id LEFT JOIN(SELECT MAX(physical_progress.physical_progress_id) AS physical_progress_id, physical_progress.contract_id, physical_progress.contract_location_id, MAX(reported_date) AS reported_date FROM physical_progress WHERE is_draft = 0 GROUP BY physical_progress.contract_id, physical_progress.contract_location_id) P ON P.contract_location_id = CL.contract_location_id AND P.contract_id = CL.contract_id LEFT JOIN physical_progress P1 ON P1.physical_progress_id = P.physical_progress_id LEFT JOIN physical_progress_activity P2 ON P2.physical_progress_id = P1.physical_progress_id WHERE CL.is_active = 1) A GROUP BY A.physical_progress_id) cz_act ON cz_act.physical_progress_id = physical_progress.physical_progress_id LEFT JOIN(SELECT A.physical_progress_id AS physical_progress_id, IFNULL(COUNT(A.activity_id),0) AS comp_act FROM (SELECT P1.physical_progress_id, P1.contract_location_id, P2.activity_id, P2.status_id FROM contract C LEFT JOIN contract_location CL ON CL.contract_id = C.contract_id LEFT JOIN(SELECT MAX(physical_progress.physical_progress_id) AS physical_progress_id, physical_progress.contract_id, physical_progress.contract_location_id, MAX(reported_date) AS reported_date FROM physical_progress WHERE is_draft = 0 GROUP BY physical_progress.contract_id, physical_progress.contract_location_id) P ON P.contract_location_id = CL.contract_location_id AND P.contract_id = CL.contract_id LEFT JOIN physical_progress P1 ON P1.physical_progress_id = P.physical_progress_id LEFT JOIN physical_progress_activity P2 ON P2.physical_progress_id = P1.physical_progress_id WHERE CL.is_active = 1 ) A LEFT JOIN(SELECT P1.physical_progress_id, P1.contract_location_id, 1 AS is_no_pending_observation, P.activity_id FROM mst_typeofwork_activity T INNER JOIN physical_progress_activity P ON P.activity_id = T.typeofwork_activity_id INNER JOIN physical_progress P1 ON P1.physical_progress_id = P.physical_progress_id INNER JOIN physical_progress_activity_observation P2 ON P2.contract_location_id = P1.contract_location_id AND P.activity_id = P2.activity_id AND P2.completion_date IS NULL INNER JOIN contract_location CL ON CL.contract_location_id = P1.contract_location_id AND P1.contract_id = CL.contract_id WHERE CL.is_active = 1 AND P2.deletedby IS NULL GROUP BY P1.contract_id, P1.contract_location_id, P.activity_id) P3 ON P3.contract_location_id = A.contract_location_id AND P3.activity_id = A.activity_id WHERE (A.status_id = 1 AND IFNULL(is_no_pending_observation, 0) = 0) OR(A.status_id = 3) GROUP BY A.physical_progress_id) cc_act ON cc_act.physical_progress_id = physical_progress.physical_progress_id LEFT JOIN(SELECT contract_location_id, COUNT(observation_id) AS tt_observation FROM physical_progress_activity_observation WHERE physical_progress_activity_observation.deletedby IS NULL GROUP BY contract_location_id) tt_obs ON tt_obs.contract_location_id = contract_location.contract_location_id LEFT JOIN(SELECT contract_location_id, COUNT(observation_id) AS cc_observation FROM physical_progress_activity_observation WHERE IFNULL(completion_date, '') <> '' GROUP BY contract_location_id) cc_obs ON cc_obs.contract_location_id = contract_location.contract_location_id WHERE physical_progress.is_draft = 0 AND contract.status_id = ".$active_contract_status_id." AND contract_location.is_active = 1 AND U.user_id = ".$user_id." ".$contractor_query." ".$tender_award_no_query." ".$type_of_work_query." ".$site_location_query." ".$region_query." ".$circle_query." ".$division_query." ".$reported_by_query." ".$reported_date_query." ".$feeder_id_query." ".$charging_status_query." ".$status_query." ORDER BY physical_progress.status_id DESC, physical_progress.reported_date DESC ".$limit_query.";";

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

	public function getLastFilledPhysicalProgressSheet($contract_id, $contract_location_id)
	{
		$where_array = array('contract_id' => $contract_id, 'contract_location_id' => $contract_location_id, 'is_draft' => 0);
		$this->db->select('physical_progress_id, contract_id, contract_location_id, site_location, reported_by, reported_date, remark, status_id');
		$this->db->where($where_array);
		$query = $this->db->order_by('reported_date', 'DESC')->limit(1)->get('physical_progress');
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			if ($query->num_rows() > 0) {
				$query_result = $query->row_array();

				return $query_result;
			}
		}
	}

	public function getActivitiesList($work_id, $contract_location_id, $activity_id = NULL)
	{
		$this->db->select('mst_typeofwork_activity.typeofwork_activity_id, mst_typeofwork_activity.typeofwork_id, mst_typeofwork_activity.activity_group_id, mst_activity_group.is_boq, mst_typeofwork_activity.unit_id, mst_typeofwork_activity.seqno, mst_typeofwork_activity.activity, mst_typeofwork_activity_options.typeofwork_activity_options_id, mst_typeofwork_activity_options.name');
		$this->db->from('mst_typeofwork_activity');
		$this->db->join('mst_typeofwork_activity_options', 'mst_typeofwork_activity.typeofwork_activity_id = mst_typeofwork_activity_options.typeofwork_activity_id', 'left');
		$this->db->join('mst_activity_group', 'mst_typeofwork_activity.activity_group_id = mst_activity_group.activity_group_id', 'INNER');
		$this->db->where('mst_typeofwork_activity.typeofwork_id', $work_id);

		if ($activity_id) {
			$this->db->where('mst_typeofwork_activity_options.typeofwork_activity_id', $activity_id);
		}

		$query = $this->db->get();
		// echo $this->db->last_query(); die();

		if (! $query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			if ($query->num_rows() > 0) {
				$query_result = $query->result_array();

				if (is_null($activity_id)) {
					//Grouping observations 
					$tmp_query_result = $query_result;

					$final_arr = [];
					$i = $k = 0;
					$query_result_count = count($query_result);
					
					do{
						$group_by_obs = [];
						
						$group_by_obs['typeofwork_activity_id'] = $query_result[$i]['typeofwork_activity_id'];
						$group_by_obs['typeofwork_id'] = $query_result[$i]['typeofwork_id'];
						$group_by_obs['activity_group_id'] = $query_result[$i]['activity_group_id'];
						$group_by_obs['is_boq'] = $query_result[$i]['is_boq'];

						if ($query_result[$i]['is_boq'] == 1) {
							$group_by_obs['boq'] = $this->getBOQ($query_result[$i]['typeofwork_activity_id'], $contract_location_id);
						}

						$activity_group_details = $this->getActivityName($query_result[$i]['activity_group_id']);
						$group_by_obs['activity_group_name'] = $activity_group_details['name'];
						$group_by_obs['activity_group_model'] = $activity_group_details['model'];

						$group_by_obs['unit_id'] = $query_result[$i]['unit_id'];
						$group_by_obs['unit_name'] = $this->getActivityUnitName($query_result[$i]['unit_id']);

						$group_by_obs['seqno'] = $query_result[$i]['seqno'];
						$group_by_obs['activity'] = $query_result[$i]['activity'];
						$group_by_obs['observations_list'] = array();

						for ($j = $i; $j < $query_result_count; $j++) {
							if ($query_result[$i]['typeofwork_activity_options_id'] != '') {
								if ($query_result[$i]['typeofwork_activity_id'] == $tmp_query_result[$j]['typeofwork_activity_id']) {
									$obs_arr = array('obs_id' => $tmp_query_result[$j]['typeofwork_activity_options_id'], 'name' => $tmp_query_result[$j]['name']);
									
									array_push($group_by_obs['observations_list'], $obs_arr);
									$k = $j;
								}
							} else if ($query_result[$i]['typeofwork_activity_options_id'] == '') {
								$k = $j;
								break;
							}
						}

						$i = $k;

						array_push($final_arr, $group_by_obs);
						$i++;

					} while($i < $query_result_count);
					
					$sorted_final_arr = [];
					
					//Sorting array on basis of observations key 
					foreach ($final_arr as $key => $value) {
						if (!empty($value['observations_list'])) {
							$value['observations_list'] = $this->sort_array_by_key($value['observations_list'], 'obs_id');
						}

						array_push($sorted_final_arr, $value);
					}

					return $sorted_final_arr;
				} else {
					return $query_result;
				}
			}
		}
	}

	public function getActivitiesListAPI($ppsheet_id, $work_id, $contract_location_id, $reported_date, $activity_id = NULL)
	{
		$status_field = ($reported_date != NULL) ? 'physical_progress_activity.status_id' : '';
		$this->db->select('mst_typeofwork_activity.typeofwork_activity_id, mst_typeofwork_activity.typeofwork_id, mst_typeofwork_activity.activity_group_id, mst_activity_group.is_boq, mst_typeofwork_activity.unit_id, mst_typeofwork_activity.seqno, mst_typeofwork_activity.activity, mst_typeofwork_activity_options.typeofwork_activity_options_id, mst_typeofwork_activity_options.name,'.$status_field);
		$this->db->from('mst_typeofwork_activity');
		$this->db->join('mst_typeofwork_activity_options', 'mst_typeofwork_activity.typeofwork_activity_id = mst_typeofwork_activity_options.typeofwork_activity_id', 'left');
		$this->db->join('mst_activity_group', 'mst_typeofwork_activity.activity_group_id = mst_activity_group.activity_group_id', 'INNER');

		if ($reported_date != NULL) {
			$this->db->join('physical_progress_activity', 'mst_typeofwork_activity.typeofwork_activity_id = physical_progress_activity.activity_id');
		}
		
		// $this->db->where('mst_typeofwork_activity.typeofwork_id', $work_id);
		$this->db->where('mst_typeofwork_activity.typeofwork_id', $work_id);

		if ($reported_date != NULL) {
			$this->db->where('physical_progress_activity.physical_progress_id', $ppsheet_id);
		}

		if ($activity_id) {
			$this->db->where('mst_typeofwork_activity_options.typeofwork_activity_id', $activity_id);
		}

		$query = $this->db->get();
		// echo $this->db->last_query(); die();

		if (! $query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			if ($query->num_rows() > 0) {
				$query_result = $query->result_array();

				if (is_null($activity_id)) {
					//Grouping observations 
					$tmp_query_result = $query_result;

					$final_arr = [];
					$i = $k = 0;
					$query_result_count = count($query_result);
					
					do{
						$group_by_obs = [];

						$group_by_obs['typeofwork_activity_id'] = $query_result[$i]['typeofwork_activity_id'];
						$group_by_obs['typeofwork_id'] = $query_result[$i]['typeofwork_id'];
						$group_by_obs['activity_group_id'] = $query_result[$i]['activity_group_id'];
						$group_by_obs['is_boq'] = $query_result[$i]['is_boq'];

						if ($query_result[$i]['is_boq'] == 1) {
							$group_by_obs['boq'] = $this->getBOQ($query_result[$i]['typeofwork_activity_id'], $contract_location_id);
							$group_by_obs['erected_qty'] = $this->getErectedQuantity($ppsheet_id, $query_result[$i]['typeofwork_activity_id']);
						}

						$activity_group_details = $this->getActivityName($query_result[$i]['activity_group_id']);
						$group_by_obs['activity_group_name'] = $activity_group_details['name'];
						$group_by_obs['activity_group_model'] = $activity_group_details['model'];

						$group_by_obs['unit_id'] = $query_result[$i]['unit_id'];
						$group_by_obs['unit_name'] = $this->getActivityUnitName($query_result[$i]['unit_id']);

						$group_by_obs['status_id'] = isset($query_result[$i]['status_id']) ? $query_result[$i]['status_id'] : '0';

						$group_by_obs['seqno'] = $query_result[$i]['seqno'];
						$group_by_obs['activity'] = $query_result[$i]['activity'];
						$group_by_obs['observations_list'] = array();

						for ($j = $i; $j < $query_result_count; $j++) {
							if ($query_result[$i]['typeofwork_activity_options_id'] != '') {
								if ($query_result[$i]['typeofwork_activity_id'] == $tmp_query_result[$j]['typeofwork_activity_id']) {
									$obs_arr = array('obs_id' => $tmp_query_result[$j]['typeofwork_activity_options_id'], 'name' => $tmp_query_result[$j]['name']);
									
									array_push($group_by_obs['observations_list'], $obs_arr);
									$k = $j;
								}
							} else if ($query_result[$i]['typeofwork_activity_options_id'] == '') {
								$k = $j;
								break;
							}
						}

						$i = $k;

						array_push($final_arr, $group_by_obs);
						$i++;

					} while($i < $query_result_count);
					
					$sorted_final_arr = [];
					
					//Sorting array on basis of observations key 
					foreach ($final_arr as $key => $value) {
						if (!empty($value['observations_list'])) {
							$value['observations_list'] = $this->sort_array_by_key($value['observations_list'], 'obs_id');
						}

						//Getting Applied Observation data to calculate obs_ratio, remark and fileupload field values
						$applied_obs_data = $this->getAllAppliedObservations($contract_location_id, $value['typeofwork_activity_id'], $reported_date);

						//If applied observation found, fetching observation and completion photos
						if (!empty($applied_obs_data)) {

							$completed_obs_count = 0;
							$applied_obs_remark = [];
							$applied_obs_files = [];
							$ncr_submitted_by_tkc_count = 0;

							//Temporary Code
							$arrContextOptions = array(
			                    "ssl" => array(
			                        'cafile' => '/path/to/bundle/cacert.pem',
			                        "verify_peer" => false,
			                        "verify_peer_name" => false
			                    ),
			                );

 							foreach ($applied_obs_data as $obs_key => $obs_value) {
								if ($obs_value['completion_date'] != '' && $obs_value['completion_date'] <= $reported_date) {
									$completed_obs_count++;
								} else {
									array_push($applied_obs_remark, $obs_value['remark']);
									$applied_obs_file_data = $this->getObservationFile($obs_value['physical_progress_activity_observation_id']);

									$pending_obs_files = [];
									
									foreach ($applied_obs_file_data as $fkey => $fvalue) {
										$ext = pathinfo($fvalue['file_path'], PATHINFO_EXTENSION);

										// Get the image and convert into string
				                        $file_path = base_url($fvalue['file_path']);
				                        // $image = file_get_contents($file_path);
				                        $image = file_get_contents($file_path, false, stream_context_create($arrContextOptions));

				                        // Encode the image string data into base64
                        				$image_base64 = 'data:image/'.$ext.';base64,'.base64_encode($image);

										array_push($pending_obs_files, $image_base64);
										array_push($applied_obs_files, $pending_obs_files);
									}
								}

								if ($obs_value['observation_status'] == 'Submitted by TKC') {
									$ncr_submitted_by_tkc_count++;
								}
							}

							$value['observation_ratio'] = $completed_obs_count.' / '.count($applied_obs_data);
							$value['remark'] = implode(',', $applied_obs_remark);
							$value['ncr_submitted_by_tkc_count'] = $ncr_submitted_by_tkc_count;
							$value['files'] = $applied_obs_files;
						} else {
							$value['observation_ratio'] = '';
							$value['remark'] = '';
							$value['files'] = [];
						}

						array_push($sorted_final_arr, $value);
					}

					return $sorted_final_arr;
				} else {
					return $query_result;
				}
			}
		}
	}	

	public function getAppliedActivitiesList($ppsheet_id, $contract_location_id, $reported_date = NULL)
	{
		$this->db->select('physical_progress_activity.physical_progress_activity_id, physical_progress_activity.physical_progress_id, physical_progress_activity.sr_no, physical_progress_activity.activity_id, physical_progress_activity.unit_id, physical_progress_activity.status_id, physical_progress_activity.erected_qty, physical_progress_activity.remarks, mst_typeofwork_activity.activity_group_id, mst_activity_group.is_boq');
		$this->db->from('physical_progress_activity');
		$this->db->join('mst_typeofwork_activity', 'physical_progress_activity.activity_id = mst_typeofwork_activity.typeofwork_activity_id', 'INNER');
		$this->db->join('mst_activity_group', 'mst_typeofwork_activity.activity_group_id = mst_activity_group.activity_group_id', 'LEFT');

		$this->db->where('physical_progress_activity.physical_progress_id', $ppsheet_id);

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
					$query_result[$key]['typeofwork_activity_id'] = $value['activity_id'];
					$typeofwork_id = $this->getActivityData($value['activity_id'], 'typeofwork_id');
					$query_result[$key]['typeofwork_id'] = $typeofwork_id;

					$activity_group_id = $this->getActivityData($value['activity_id'], 'activity_group_id');
					$query_result[$key]['activity_group_id'] = $activity_group_id;

					if ($value['is_boq'] == 1) {
						$query_result[$key]['boq'] = $this->getBOQ($value['activity_id'], $contract_location_id);
					}
					
					$activity_group_name = $this->getActivityName($activity_group_id);
					$query_result[$key]['activity_group_name'] = $activity_group_name['name'];
					$query_result[$key]['activity_group_model'] = $activity_group_name['model'];

					$query_result[$key]['seqno'] = $this->getActivityData($value['activity_id'], 'seqno');				
					$query_result[$key]['activity'] = $this->getActivityData($value['activity_id'], 'activity');

					$query_result[$key]['unit_name'] = $this->getActivityUnitName($value['unit_id']);

					$query_result[$key]['observations_list'] = $this->getObservationData($value['activity_id']);

					$activity_data = $this->getActivityDetail($value['physical_progress_id'], $value['activity_id'], $contract_location_id, $reported_date);

					$obs_data = [];
					if (!empty($activity_data)) {
						foreach ($activity_data as $akey => $avalue) {
							$obs_data[$akey]['physical_progress_activity_observation_id'] = $avalue['physical_progress_activity_observation_id'];
							$obs_data[$akey]['observation_id'] = $avalue['observation_id'];
							$obs_data[$akey]['observation_name'] = $avalue['observation_name'];
							$obs_data[$akey]['remark'] = $avalue['remark'];
							$obs_data[$akey]['observation_status'] = $avalue['observation_status'];
							$obs_data[$akey]['observation_photos'] = $avalue['observation_file_details'];
							$obs_data[$akey]['observation_photos_by_tkc'] = $avalue['observation_file_by_tkc_details'];
							$obs_data[$akey]['completion_photos'] = $avalue['observation_completion_file_details'];
						}
					}

					$query_result[$key]['applied_observations'] = $obs_data;					
				}

				return $query_result;
			}
		}
	}

	public function getAppliedActivitiesListForSheetStatusCalculation($pp_id)
	{
		$this->db->select('activity_id');
		$this->db->where('physical_progress_id', $pp_id);
		$this->db->where_in('status_id', array(0,2,4));

		$query = $this->db->get('physical_progress_activity');
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			return $query->num_rows();
		}
	}

	public function checkActivities($pp_id)
	{
		$query = $this->db->get_where('physical_progress_activity', array('physical_progress_id' => $pp_id));
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

	public function checkActivity($activity_id, $pp_id)
	{
		$query = $this->db->get_where('physical_progress_activity', array('activity_id' => $activity_id, 'physical_progress_id' => $pp_id));
		// echo $this->db->last_query().'<br/>'; 

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			if ($query->num_rows() > 0) {
				$query_result = $query->row_array();
				return $query_result;
			}
		}
	}

	public function saveActivity($pp_id, $sr_no, $activity_id, $unit_id, $status_id, $erected_qty)
	{
		$data = array(
			'physical_progress_id' => $pp_id,
			'sr_no' => $sr_no, 
			'activity_id' => $activity_id,
			'unit_id' => $unit_id,
			'status_id' => $status_id,
			'erected_qty' => $erected_qty,
			'is_active' => 1,
			'createdby' => $this->getLoggedInUserID(),
			'createddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->insert('physical_progress_activity', $data);

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			return $this->db->affected_rows();
		}
	}

	public function saveActivityAPI($pp_id, $sr_no, $activity_id, $unit_id, $status_id, $erected_qty, $user_id)
	{
		$data = array(
			'physical_progress_id' => $pp_id,
			'sr_no' => $sr_no, 
			'activity_id' => $activity_id,
			'unit_id' => $unit_id,
			'status_id' => $status_id,
			'erected_qty' => $erected_qty,
			'is_active' => 1,
			'createdby' => $user_id,
			'createddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->insert('physical_progress_activity', $data);

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$insert_id = $this->db->insert_id();
			return $insert_id;
		}
	}

	public function updateActivity($pp_id, $activity_id, $status_id, $erected_qty)
	{
		$data = array(
			'status_id' => $status_id,
			'erected_qty' => $erected_qty
		);

		$query = $this->db->update('physical_progress_activity', $data, array('physical_progress_id' => $pp_id, 'activity_id' => $activity_id));

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

	public function checkObservationExists($contract_location_id, $activity_id, $observation_id)
	{
		$query = $this->db->get_where('physical_progress_activity_observation', array('contract_location_id' => $contract_location_id, 'activity_id' => $activity_id, 'observation_id' => $observation_id, 'deletedby' => NULL));
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

	public function checkAppliedObservationsExists($contract_location_id, $activity_id)
	{
		$query = $this->db->get_where('physical_progress_activity_observation', array('contract_location_id' => $contract_location_id, 'activity_id' => $activity_id));
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

	public function saveObservation($contract_location_id, $work_activity_id, $observation_id, $observation_name, $ncr_id, $ncr_date, $remark, $completion_date, $obs_status_id)
	{
		$data = array(
			// 'physical_progress_activity_id' => $pp_activity_id,
			'contract_location_id' => $contract_location_id,
			'activity_id' => $work_activity_id,
			'observation_id' => $observation_id,
			'observation_name' => $observation_name,
			'ncr_id' => $ncr_id,
			'ncr_date' => $ncr_date,
			'remark' => $remark, 
			'completion_date' => $completion_date,
			'status_id' => $obs_status_id,
			'is_active' => 1,
			'createdby' => $this->getLoggedInUserID(),
			'createddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->insert('physical_progress_activity_observation', $data);

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$insert_id = $this->db->insert_id();
			return $insert_id;
		}
	}

	public function saveObservationAPI($contract_location_id, $work_activity_id, $observation_id, $observation_name, $ncr_id, $ncr_date, $remark, $completion_date, $obs_status_id, $user_id)
	{
		$data = array(
			// 'physical_progress_activity_id' => $pp_activity_id,
			'contract_location_id' => $contract_location_id,
			'activity_id' => $work_activity_id,
			'observation_id' => $observation_id,
			'observation_name' => $observation_name,
			'ncr_id' => $ncr_id,
			'ncr_date' => $ncr_date,
			'remark' => $remark, 
			'completion_date' => $completion_date,
			'status_id' => $obs_status_id,
			'is_active' => 1,
			'createdby' => $user_id,
			'createddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->insert('physical_progress_activity_observation', $data);

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$insert_id = $this->db->insert_id();
			return $insert_id;
		}
	}

	public function deleteObservation($observation_id, $user_id = NULL)
	{
		$data = array(
			'is_active' => 0,
			'deletedby' => ($user_id == NULL) ? $this->getLoggedInUserID() : $user_id,
			'deleteddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->update('physical_progress_activity_observation', $data, array('physical_progress_activity_observation_id' => $observation_id));

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			return $this->db->affected_rows();
		}
	}

	public function deleteAllAppliedObservations($contract_location_id, $activity_id)
	{
		$data = array(
			'is_active' => 0,
			'deletedby' => $this->getLoggedInUserID(),
			'deleteddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->update('physical_progress_activity_observation', $data, array('contract_location_id' => $contract_location_id, 'activity_id' => $activity_id));

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			return $this->db->affected_rows();
		}
	}

	public function updateObservation($observation_id, $observation_name, $ncr_id, $ncr_date, $remark, $completion_date, $obs_status_id, $pp_activity_obs_id, $user_id = NULL)
	{
		$data = array(
			'observation_id' => $observation_id,
			'observation_name' => $observation_name,
			'ncr_id' => $ncr_id,
			'ncr_date' => $ncr_date,
			'remark' => $remark,
			'completion_date' => $completion_date,
			'status_id' => $obs_status_id,
			'is_active' => 1,
			'modifiedby' => ($user_id != NULL) ? $user_id : $this->getLoggedInUserID(),
			'modifieddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->update('physical_progress_activity_observation', $data, array('physical_progress_activity_observation_id' => $pp_activity_obs_id));

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			if ($this->db->affected_rows() > 0) {
				return $pp_activity_obs_id;
			}
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
			/*$insert_id = $this->db->insert_id();
			return $insert_id;*/
			return $this->db->affected_rows();
		}
	}

	public function saveObservationFileAPI($pp_activity_obs_id, $file_path, $user_id)
	{
		$data = array(
			'physical_progress_activity_observation_id' => $pp_activity_obs_id,
			'file_path' => $file_path,
			'is_active' => 1,
			'createdby' => $user_id,
			'createddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->insert('physical_progress_activity_observation_file', $data);

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			/*$insert_id = $this->db->insert_id();
			return $insert_id;*/
			return $this->db->affected_rows();
		}
	}

	public function saveObservationCompletionFileAPI($pp_activity_obs_id, $file_path, $user_id)
	{
		$data = array(
			'physical_progress_activity_observation_id' => $pp_activity_obs_id,
			'file_path' => $file_path,
			'is_active' => 1,
			'createdby' => $user_id,
			'createddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->insert('physical_progress_activity_completion_file', $data);

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			/*$insert_id = $this->db->insert_id();
			return $insert_id;*/
			return $this->db->affected_rows();
		}
	}

	public function deleteObservationFile($pp_activity_obs_id, $user_id = NULL)
	{
		//Deleting (Updating delete flag) the previous saved file path
		$data = array(
			'is_active' => 0,
			'deletedby' => ($user_id == NULL) ? $this->getLoggedInUserID() : $user_id,
			'deleteddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->update('physical_progress_activity_observation_file', $data, array('physical_progress_activity_observation_id' => $pp_activity_obs_id,));

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			return $this->db->affected_rows();
		}
	}

	public function deleteObservationFile_new($ppao_file_id)
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
			/*$insert_id = $this->db->insert_id();
			return $insert_id;*/
			return $this->db->affected_rows();
		}
	}

	public function deleteObservationCompletionFile($pp_activity_obs_id, $user_id = NULL)
	{
		//Deleting (Updating delete flag) the previous saved file path
		$del_array = array(
			'is_active' => 0,
			'deletedby' => ($user_id == NULL) ? $this->getLoggedInUserID() : $user_id,
			'deleteddate' => date('Y-m-d H:i:s')
		);

		$where_array = array(
			'physical_progress_activity_completion_file_id' => $pp_activity_obs_id,
			'deletedby' => NULL
		);

		$this->db->set($del_array);
		$this->db->where($where_array);
		$query = $this->db->update('physical_progress_activity_completion_file');
		// echo $this->db->last_query();

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			return $this->db->affected_rows();
		}
	}

	public function deleteObservationCompletionFile_new($ppao_file_id)
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

	public function savePhysicalProgressSheet($contract_id, $contract_location_id, $site_location, $reported_by, $reported_date, $remark, $status_id, $is_draft)
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
			'createdby' => $this->getLoggedInUserID(),
			'createddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->insert('physical_progress', $data);

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$insert_id = $this->db->insert_id();
			return $insert_id;
		}
	}

	public function savePhysicalProgressSheetAPI($contract_id, $contract_location_id, $site_location, $reported_by, $reported_date, $geo_code, $is_inrange, $remark, $status_id, $is_draft, $user_id)
	{
		$data = array(
			'contract_id' => $contract_id,
			'contract_location_id' =>$contract_location_id,
			'site_location' => $site_location,
			'reported_by' => $reported_by,
			'reported_date' => $reported_date,
			'geo_code' => $geo_code,
			'is_inrange' => $is_inrange,
			'remark' => $remark,
			'is_draft' => $is_draft,
			'status_id' => $status_id,
			'createdby' => $user_id,
			'createddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->insert('physical_progress', $data);

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$insert_id = $this->db->insert_id();
			return $insert_id;
		}
	}

	public function updatePhysicalProgressSheet($pp_id, $contract_id, $contract_location_id, $site_location, $reported_by_id, $reported_date, $geo_code, $is_inrange, $remark, $status_id, $is_draft, $user_id = NULL)
	{
		$data = array(
			'contract_id' => $contract_id,
			'contract_location_id' => $contract_location_id,
			'site_location' => $site_location,
			'reported_by' => $reported_by_id,
			'reported_date' => $reported_date,
			'geo_code' => $geo_code,
			'is_inrange' => $is_inrange,
			'remark' => $remark,
			'is_draft' => $is_draft,
			'status_id' => $status_id,
			'modifiedby' => ($user_id != NULL) ? $user_id : $this->getLoggedInUserID(),
			'modifieddate' => date('Y-m-d H-i:s')
		);

		// $this->db->where('physical_progress_id', $pp_id);
		$query = $this->db->update('physical_progress', $data, array('physical_progress_id' => $pp_id));

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			if ($this->db->affected_rows() > 0) {
				return $pp_id;
			}
		}
	}

	public function savePhysicalProgressCompletionFile($pp_id, $file_path, $user_id = NULL)
	{
		$data = array(
			'physical_progress_id' => $pp_id,
			'file_path' => $file_path,
			'is_active' => 1,
			'createdby' => ($user_id != NULL) ? $user_id : $this->getLoggedInUserID(),
			'createddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->insert('physical_progress_file', $data);

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

	public function getPhysicalProgressCompletionFile($pp_id)
	{
		$this->db->select('physical_progress_file_id, physical_progress_id, file_path');
		$query = $this->db->get_where('physical_progress_file', array('physical_progress_id' => $pp_id, 'is_active' => 1, 'deletedby' => NULL));

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

	public function deletePhysicalProgressCompletionFile($pp_id)
	{
		$data = array(
			'is_active' => 0,
			'deletedby' => $this->getLoggedInUserID(),
			'deleteddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->update('physical_progress_file', $data, array('physical_progress_id' => $pp_id));

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			return $this->db->affected_rows();
		}
	}

	public function deletePhysicalProgressCompletionFile_new($pp_file_id)
	{
		$data = array(
			'is_active' => 0,
			'deletedby' => $this->getLoggedInUserID(),
			'deleteddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->update('physical_progress_file', $data, array('physical_progress_file_id' => $pp_file_id));

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			return $this->db->affected_rows();
		}
	}

	public function getLastPhysicalProgressFileData($pp_id)
	{
		$this->db->select('file_path');
		$this->db->where(array('physical_progress_id' => $pp_id));
		$this->db->order_by('physical_progress_file_id', 'DESC');
		$this->db->limit(1);

		$query = $this->db->get('physical_progress_file');
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

	public function updateSheetStatus($pp_id, $status_id, $sheet_remark = NULL)
	{
		$data = array(
			'status_id' => $status_id, 
			'modifiedby' => $this->getLoggedInUserID(), 
			'modifieddate' => date('Y-m-d H:i:s')
		);

		if ($sheet_remark != NULL) {
			$data['remark'] = $sheet_remark;
		}

		$query = $this->db->update('physical_progress', $data, array('physical_progress_id' => $pp_id));
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

	public function getActivityDetail($pp_id, $activity_id, $contract_location_id, $reported_date = NULL)
	{
		//Getting activity detail and observations
		/*$this->db->select('ppa.physical_progress_activity_id, ppa.physical_progress_id, ppa.sr_no, ppa.activity_id, ppa.unit_id, ppa.status_id, ppa.erected_qty, ppa.remarks, ppao.physical_progress_activity_observation_id, ppao.physical_progress_activity_id, ppao.observation_id, ppao.observation_name, ppao.ncr_id, ppao.ncr_date, ppao.remark, ppao.completion_date');*/
		$this->db->select('ppa.physical_progress_activity_id, ppa.physical_progress_id, ppa.sr_no, ppa.activity_id, ppa.unit_id, ppa.status_id, ppa.erected_qty, ppa.remarks, ppao.physical_progress_activity_observation_id, ppao.observation_id, ppao.observation_name, ppao.ncr_id, ppao.ncr_date, ppao.remark, ppao.completion_date, ppao.status_id AS observation_status_id, mst_status.name AS observation_status');
		$this->db->from('physical_progress_activity  as ppa');
		// $this->db->join('physical_progress_activity_observation as ppao', 'ppa.physical_progress_activity_id = ppao.physical_progress_activity_id', 'inner');
		$this->db->join('physical_progress_activity_observation as ppao', 'ppa.activity_id = ppao.activity_id', 'INNER');
		$this->db->join('mst_status', 'ppao.status_id = mst_status.status_id', 'INNER');
		$this->db->where('ppa.physical_progress_id', $pp_id);
		$this->db->where('ppa.activity_id', $activity_id);
		$this->db->where('ppao.contract_location_id', $contract_location_id);
		if ($reported_date != NULL) {
			$this->db->where('ppao.ncr_date <=', $reported_date);
		}
		$this->db->where('ppao.deletedby', NULL);

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
					//Getting observation file details
					$obs_file = $this->getObservationFile($value['physical_progress_activity_observation_id']);
					$query_result[$key]['observation_file_details'] = $obs_file;

					$query_result[$key]['observation_file_by_tkc_details'] = [];
					if ($value['observation_status'] == 'Submitted by TKC') {
						$obs_by_tkc_file = $this->getObservationFileByTKC($value['physical_progress_activity_observation_id']);
						$query_result[$key]['observation_file_by_tkc_details'] = $obs_by_tkc_file;
					}

					$query_result[$key]['observation_completion_file_details'] = [];
					if ($reported_date != NUll) {
						if ($reported_date >= $value['completion_date']) {
							$obs_completion_file = $this->getObservationCompletionFile($value['physical_progress_activity_observation_id']);
							$query_result[$key]['observation_completion_file_details'] = $obs_completion_file;
						}
					} else {
						$obs_completion_file = $this->getObservationCompletionFile($value['physical_progress_activity_observation_id']);
							$query_result[$key]['observation_completion_file_details'] = $obs_completion_file;
					}
					
				}
			}

			return $query_result;
		}
	}

	public function getObservationData($activity_id)
	{
		$this->db->select('typeofwork_activity_options_id as obs_id, name');
		$this->db->from('mst_typeofwork_activity_options');
		$this->db->where('typeofwork_activity_id', $activity_id);

		$query = $this->db->get();
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

	public function getAppliedObservationData($obs_id, $sheet_date)
	{
		// $query = $this->db->get_where('physical_progress_activity_observation', array('physical_progress_activity_observation_id' => $obs_id, 'deletedby' => NULL));

		$this->db->select('ppao.physical_progress_activity_observation_id, ppao.contract_location_id, ppao.activity_id, ppao.observation_id, ppao.observation_name, ppao.ncr_id, ppao.ncr_date, ppao.remark, ppao.completion_date, ppao.status_id AS observation_status_id, mst_status.name AS observation_status');
		$this->db->from('physical_progress_activity_observation AS ppao');
		$this->db->join('mst_status', 'ppao.status_id = mst_status.status_id', 'INNER');
		$this->db->where(array('ppao.physical_progress_activity_observation_id' => $obs_id, 'deletedby' => NULL));

		$query = $this->db->get();
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$obs_data = [];

			if ($query->num_rows() > 0) {
				$query_result = $query->row_array();
				
				$obs_data['physical_progress_activity_observation_id'] = $query_result['physical_progress_activity_observation_id'];
				$obs_data['contract_location_id'] = $query_result['contract_location_id'];
				$obs_data['activity_id'] = $query_result['activity_id'];
				$obs_data['observation_id'] = $query_result['observation_id'];
				$obs_data['observation_name'] = $query_result['observation_name'];
				$obs_data['ncr_id'] = $query_result['ncr_id'];
				$obs_data['ncr_date'] = date('d-m-Y', strtotime($query_result['ncr_date']));
				$obs_data['remark'] = $query_result['remark'];
				$obs_data['completion_date'] = '';
				$obs_data['observation_files'] = [];
				$obs_data['observation_files_by_tkc'] = [];
				$obs_data['completion_files'] = [];
				$obs_data['observation_status_id'] = $query_result['observation_status_id'];
				$obs_data['observation_status'] = $query_result['observation_status'];

				$obs_file_result = $this->getObservationFile($obs_id);				

				if (!empty($obs_file_result)) {
					foreach ($obs_file_result as $key => $value) {
						array_push($obs_data['observation_files'], $value);
					}

					// Fetching observations files by TKC 
					$obs_by_tkc_file_result = $this->getObservationFileByTKC($obs_id);

					if (!empty($obs_by_tkc_file_result)) {
						foreach ($obs_by_tkc_file_result as $key => $value) {
							array_push($obs_data['observation_files_by_tkc'], $value);
						}
					}
				}

				if ($sheet_date != '') {
					if ($sheet_date >= $query_result['completion_date']) {
						$obs_data['completion_date'] = ($query_result['completion_date'] == NULL) ? '' : date('d-m-Y', strtotime($query_result['completion_date']));

						$obs_completion_file_result = $this->getObservationCompletionFile($obs_id);

						if (!empty($obs_completion_file_result)) {
							foreach ($obs_completion_file_result as $key => $value) {
								array_push($obs_data['completion_files'], $value);
							}
						}
					}
				} else {
					$obs_data['completion_date'] = ($query_result['completion_date'] == NULL) ? '' : date('d-m-Y', strtotime($query_result['completion_date']));

					$obs_completion_file_result = $this->getObservationCompletionFile($obs_id);

					if (!empty($obs_completion_file_result)) {
						foreach ($obs_completion_file_result as $key => $value) {
							array_push($obs_data['completion_files'], $value);
						}
					}	
				}				
			}

			return $obs_data;
		}
	}

	public function getAllAppliedObservations($contract_location_id, $activity_id, $reported_date = NUll)
	{
		$where_array = array('contract_location_id' => $contract_location_id, 'activity_id' => $activity_id, 'deletedby' => NULL);

		$this->db->select('ppao.physical_progress_activity_observation_id, ppao.observation_name, ppao.ncr_id, ppao.ncr_date, ppao.remark, ppao.completion_date, ppao.status_id, mst_status.name AS observation_status');
		$this->db->from('physical_progress_activity_observation AS ppao');
		$this->db->join('mst_status', 'ppao.status_id = mst_status.status_id', 'INNER');
		$this->db->where($where_array);

		if ($reported_date != NULL) {
			$this->db->where(array('ncr_date <=' => $reported_date));
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

	public function getObservationFile($obs_id)
	{
		$where_array = array('physical_progress_activity_observation_id' => $obs_id, 'deletedby' => NULL);

		$this->db->select('physical_progress_activity_observation_file_id, physical_progress_activity_observation_id, file_path');
		$this->db->from('physical_progress_activity_observation_file');
		$this->db->where($where_array);

		$query = $this->db->get();
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else  {
			$query_result = [];
			if ($query->num_rows() > 0) {
				$query_result = $query->result_array();

				return $query_result;
			}
		}
	}

	public function getObservationCompletionFile($obs_id)
	{
		$this->db->select('physical_progress_activity_completion_file_id, physical_progress_activity_observation_id, file_path');
		$this->db->where(array('physical_progress_activity_observation_id' => $obs_id, 'is_active' => 1, 'deletedby' => NULL));

		$query = $this->db->get('physical_progress_activity_completion_file');
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else  {
			$query_result = [];
			if ($query->num_rows() > 0) {
				$query_result = $query->result_array();

				return $query_result;
			}
		}
	}

	public function getObservationFileByTKC($obs_id)
	{
		$this->db->select('physical_progress_activity_observation_tkc_file_id, physical_progress_activity_observation_id, file_path');
		$this->db->where(array('physical_progress_activity_observation_id' => $obs_id, 'is_active' => 1, 'deletedby' => NULL));

		$query = $this->db->get('physical_progress_activity_observation_tkc_file');
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else  {
			$query_result = [];
			if ($query->num_rows() > 0) {
				$query_result = $query->result_array();

				return $query_result;
			}
		}
	}

	public function fetchLastObservation()
	{
		$query = $this->db->order_by('physical_progress_activity_observation_id','desc')->limit(1)->get('physical_progress_activity_observation');
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			if ($query->num_rows() > 0) {
				$query_result = $query->row_array();

				return $query_result;
			}
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

	public function insertBOQQty($contract_location_id, $activity_id, $unit_id, $boq_val, $user_id = NULL)
	{
		$data = array(
			'contract_location_id' => $contract_location_id,
			'typeofwork_activity_id' => $activity_id,
			'unit_id' => $unit_id,
			'boq' => $boq_val,
			'is_active' => 1,
			'createdby' => ($user_id != NULL) ? $user_id : $this->getLoggedInUserID(),
			'createddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->insert('contract_location_boq', $data);

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

	public function updateBOQQty($contract_location_id, $activity_id, $boq_val, $user_id = NULL)
	{
		$data = array(
			'boq' => $boq_val,
			'modifiedby' => ($user_id != NULL) ? $user_id : $this->getLoggedInUserID(),
			'modifieddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->update('contract_location_boq', $data, array('contract_location_id' => $contract_location_id, 'typeofwork_activity_id' => $activity_id));
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

	public function getErectedQuantity($pp_id, $activity_id)
	{
		$this->db->select('erected_qty');
		$query = $this->db->get_where('physical_progress_activity', array('physical_progress_id' => $pp_id, 'activity_id' => $activity_id));
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$query_result = '';

			if ($query->num_rows() > 0) {
				$result = $query->row_array();
				$query_result = $result['erected_qty'];
			}

			return $query_result;
		}
	}

	public function updateChargingStatus($contract_location_id, $charging_status, $user_id = NULL)
	{
		$data = array(
			'charging_status' => $charging_status,
			'modifiedby' => ($user_id != NULL) ? $user_id : $this->getLoggedInUserID(),
			'modifieddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->update('contract_location', $data, array('contract_location_id' => $contract_location_id));

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

	public function updateFeederNameAndSiteLocation($contract_location_id, $feeder_name, $site_location, $user_id)
	{
		$data = array(
			'feeder_name' => $feeder_name,
			'location_name' => $site_location,
			'modifiedby' => ($user_id != NULL) ? $user_id : $this->getLoggedInUserID(),
			'modifieddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->update('contract_location', $data, array('contract_location_id' => $contract_location_id));

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

	public function getRegion($region_id)
	{
		$query = $this->db->get_where('mst_region', array('region_id' => $region_id));

		if ($query->num_rows() > 0) {
			$query_result = $query->row_array();
			return $query_result['region_name'];

		} else {
			return 'Not Found';
		}
	}

	public function getCircle($circle_id)
	{
		$query = $this->db->get_where('mst_circle', array('circle_id' => $circle_id));

		if ($query->num_rows() > 0) {
			$query_result = $query->row_array();
			return $query_result['circle_name'];
		} else {
			return 'Not Found';
		}
	}

	public function getDivision($division_id)
	{
		$query = $this->db->get_where('mst_division', array('division_id' => $division_id));

		if ($query->num_rows() > 0) {
			$query_result = $query->row_array();
			return $query_result['division_name'];
		} else {
			return 'Not Found';
		}
	}

	public function getTypeOfWork($work_id)
	{
		$query = $this->db->get_where('mst_typeofwork', array('typeofwork_id' => $work_id));

		if ($query->num_rows() > 0) {
			$query_result = $query->row_array();
			return $query_result['name'];
		} else {
			return 'Not Found';
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

	public function getTypeOfWorkList()
	{
		$query_result = [];

		$query =  $this->db->select('typeofwork_id, name')->get_where('mst_typeofwork', array('is_active' => 1));

		if ($query->num_rows() > 0) {
			$query_result = $query->result_array();
		}

		return $query_result;
	}

	public function getRegionList($user_id = NULL)
	{
		$userdata = $_SESSION['loggedData'];

		if ($user_id != NULL) {
			$userdata = $this->getUserData($user_id);
		}

		$logged_user_role = $this->getUserRole($userdata->role_id);
		
		if ($logged_user_role != 'Admin') {
			$user_id = $userdata->user_id;

			$this->db->select('DISTINCT(mst_user_data_access.region_id), mst_region.region_name');
			$this->db->from('mst_user_data_access');
			$this->db->join('mst_region', 'mst_user_data_access.region_id = mst_region.region_id', 'INNER');
			$this->db->where(array('mst_user_data_access.user_id' => $user_id));

			$query = $this->db->get();
			// echo $this->db->last_query(); die();
		} else {
			$this->db->select('region_id, region_name');
			$query = $this->db->get_where('mst_region', array('is_active' => 1));
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
		$this->db->where(array('mst_module.name' => 'Physical Verification', 'mst_module.icon !=' => ''));

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
			if ($query->num_rows() > 0) {
				$query_result = $query->result_array();

				return $query_result;
			}
		}
	}

	public function getTotalActivityCountFromMaster($typeofwork_id)
	{
		$this->db->where(array('typeofwork_id' => $typeofwork_id));
		$query = $this->db->count_all_results('mst_typeofwork_activity');

		return $query;
	}

	public function getActivityName($activity_id)
	{
		$query = $this->db->get_where('mst_activity_group', array('activity_group_id' => $activity_id));

		if ($query->num_rows() > 0) {
			$query_result = $query->row_array();
			return $query_result;
		} else {
			return 'Not Found';
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

	public function getUserData($user_id)
	{
		$query = $this->db->get_where('mst_user', array('user_id' => $user_id));

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$query_result = [];

			if ($query->num_rows() > 0) {
				$query_result = $query->row();
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
		$this->db->where(array('mst_module.name' => 'Physical Verification', 'mst_module.icon !=' => '', 'mst_user.user_id' => $user_id));
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
			if ($query->num_rows() > 0) {
				$query_result = $query->row_array();

				return $query_result['user_id'];
			} else {
				return 'Not Found';
			}
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
			if ($query->num_rows() > 0) {
				$query_result = $query->row_array();

				return $query_result['username'];
			}
		}
	}

	public function getActivityData($activity_id, $column)
	{
		$this->db->select($column);
		// $this->db->from('mst_typeofwork_activity');
		$query = $this->db->get_where('mst_typeofwork_activity', array('typeofwork_activity_id' => $activity_id));
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			if ($query->num_rows() > 0) {
				$query_result = $query->row_array();

				return $query_result[$column];
			}
		}
	}

	public function getActivityUnitName($unit_id)
	{
		$query = $this->db->get_where('mst_unit', array('unit_id' => $unit_id));
		// echo $this->db->last_query(); die();

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

	public function getContractorData($contractor)
	{
		$this->db->select('contract_id, contractor_name, tender_award_no, tender_award_date, typeofwork_id');

		if (!empty($contractor)) {
			$this->db->like('contractor_name', $contractor);
			$this->db->where(array('status_id !=' => 0));
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
					$query_result[$key]['typeofwork_name'] = $this->getTypeOfWork($value['typeofwork_id']);
				}
			}

			return $query_result;
		}
	}

	public function getContractLocationData($contract_location_id)
	{
		$query = $this->db->get_where('contract_location', array('contract_location_id' => $contract_location_id));
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

	public function getPhysicalProgressListLimit()
	{
		$display_name = 'PHYSICAL_PROGRESS_LIST_LIMIT';
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

	public function checkNCRIDExists($ncr_id)
	{
		$query = $this->db->get_where('physical_progress_activity_observation', array('ncr_id' => $ncr_id));
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

	public function getRegionCircleData($user_id = NULL)
	{
		$userdata = $_SESSION['loggedData'];

		if ($user_id != NULL) {
			$userdata = $this->getUserData($user_id);
		}

		$logged_user_role = $this->getUserRole($userdata->role_id);

		if ($logged_user_role != 'Admin') {
			$user_id = $userdata->user_id;

			$this->db->select('mst_user_data_access.region_id, mst_user_data_access.circle_id, mst_circle.circle_name');
			$this->db->from('mst_user_data_access');
			$this->db->join('mst_circle', 'mst_user_data_access.circle_id = mst_circle.circle_id', 'INNER');
			$this->db->where(array('mst_user_data_access.user_id' => $user_id));

			$query = $this->db->get();
			// echo $this->db->last_query(); die();
		} else {
			$this->db->select('mst_region.region_id, mst_circle.circle_id, mst_circle.circle_name');
			$this->db->from('mst_region');
			$this->db->join('mst_circle', 'mst_region.region_id = mst_circle.region_id', 'INNER');
			$this->db->where(array('mst_region.is_active' => 1, 'mst_circle.is_active' => 1));

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

	public function getCircleDivisionData($user_id = NULL)
	{
		$userdata = $_SESSION['loggedData'];

		if ($user_id != NULL) {
			$userdata = $this->getUserData($user_id);
		}

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

	public function getNCRSubmittedByTKCList($contract_location_id)
	{
		$this->db->select('physical_progress_activity_observation.*');
		$this->db->from('physical_progress_activity_observation');
		$this->db->join('mst_status', 'physical_progress_activity_observation.status_id = mst_status.status_id', 'INNER');
		$this->db->where(array('mst_status.name' => 'Submitted by TKC', 'physical_progress_activity_observation.contract_location_id' => $contract_location_id));

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

	//Function to sort array by key
	public function sort_array_by_key($array, $sort_key)
	{
		$key_array = array_column($array, $sort_key);
		array_multisort($key_array, SORT_ASC, $array); //or SORT_DESC
		return $array;
	}
}

?>