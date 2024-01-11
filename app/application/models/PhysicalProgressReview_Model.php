<?php defined('BASEPATH') OR exit('No direct script access allowed');

class PhysicalProgressReview_Model extends CI_Model
{	
	function __construct()
	{
		parent::__construct();
	}

	public function getPhysicalProgressReviewedSheets($pp_status_id)
	{
		$user_id = $this->getLoggedInUserID();

		$contract_status_list = $this->getContractStatusList();
		$active_contract_status_id = $contract_status_list['Open'];

		$query = $this->db->query("SELECT `physical_progress`.`physical_progress_id`, `physical_progress`.`contract_id`, `physical_progress`.`contract_location_id`, `physical_progress`.`site_location`, `physical_progress`.`reported_by`, `physical_progress`.`reported_date`, `physical_progress`.`status_id`, `contract`.`contract_id`, `contract`.`contractor_name`, `contract`.`tender_award_no`, `contract`.`typeofwork_id`, `contract_location`.`contract_location_id`, `contract_location`.`region_id`, `contract_location`.`circle_id`, `contract_location`.`division_id`, `contract_location`.`location_name`, `contract_location`.`feeder_id`,`mst_user`.`username` AS `pp_reported_by`, `mst_region`.`region_name`,`mst_circle`.`circle_name`, `mst_division`.`division_name`, `mst_status`.`name` as `sheet_status`,`mst_typeofwork`.`name` as `typeofwork_name`, ifnull(`tt_act`.`tt_activity`,0) as `tt_task`, ifnull(`cc_act`.`comp_act`,0) as `cc_task`, ifnull(`tt_obs`.`tt_observation`,0) as `tt_observation`, ifnull(`cc_obs`.`cc_observation`,0) as `cc_observation` FROM (select max(`physical_progress`.`physical_progress_id`) AS `physical_progress_id`, `physical_progress`.`contract_id`, `physical_progress`.`contract_location_id`, max(`reported_date`) AS `reported_date` from `physical_progress` where `physical_progress`.`is_draft` = 0 group by `physical_progress`.`contract_id`,`physical_progress`.`contract_location_id`) `grp` INNER JOIN `physical_progress` ON `physical_progress`.`physical_progress_id`=`grp`.`physical_progress_id` AND `physical_progress`.`contract_id` = `grp`.`contract_id` AND `physical_progress`.`contract_location_id`=`grp`.`contract_location_id` INNER JOIN `contract` ON `physical_progress`.`contract_id` = `contract`.`contract_id` INNER JOIN `contract_location` ON `physical_progress`.`contract_id` = `contract_location`.`contract_id` AND `physical_progress`.`contract_location_id` = `contract_location`.`contract_location_id` LEFT JOIN mst_user_data_access U ON U.region_id=`contract_location`.region_id AND U.circle_id=`contract_location`.circle_id AND U.division_id=`contract_location`.division_id LEFT JOIN `mst_user` ON `mst_user`.`user_id` = `physical_progress`.`reported_by` INNER JOIN `mst_region` ON `mst_region`.`region_id` = `contract_location`.`region_id` INNER JOIN `mst_circle` ON `mst_circle`.`circle_id` = `contract_location`.`circle_id` INNER JOIN `mst_division` ON `mst_division`.`division_id` = `contract_location`.`division_id` INNER JOIN `mst_status` ON `mst_status`.`status_id` = `physical_progress`.`status_id` INNER JOIN `mst_typeofwork` ON `mst_typeofwork`.`typeofwork_id` = `contract`.`typeofwork_id` LEFT JOIN ( select `physical_progress_id`, count(`mst_typeofwork_activity`.`typeofwork_activity_id`) as `tt_activity` from `physical_progress` `a` inner join `contract` on `contract`.`contract_id` = `a`.`contract_id` inner join `mst_typeofwork_activity` on `mst_typeofwork_activity`.`typeofwork_id` = `contract`.`typeofwork_id` group by `physical_progress_id`,`mst_typeofwork_activity`.`typeofwork_id`)`tt_act` on `tt_act`.`physical_progress_id` = `physical_progress`.`physical_progress_id` LEFT JOIN (Select A.`physical_progress_id` as `physical_progress_id`, ifnull(count(A.activity_id),0) as `comp_act` From (Select P1.physical_progress_id, P1.contract_location_id, P2.activity_id, P2.status_id From contract C LEFT JOIN contract_location CL ON CL.contract_id = C.contract_id LEFT JOIN (select max(physical_progress.physical_progress_id) AS physical_progress_id, physical_progress.contract_id, physical_progress.contract_location_id, max(reported_date) AS reported_date from physical_progress group by physical_progress.contract_id, physical_progress.contract_location_id) P ON P.contract_location_id = CL.contract_location_id AND P.contract_id = CL.contract_id LEFT JOIN physical_progress P1 ON P1.physical_progress_id = P.physical_progress_id LEFT JOIN physical_progress_activity P2 ON P2.physical_progress_id = P1.physical_progress_id where CL.is_active = 1)A LEFT JOIN (Select P1.physical_progress_id, P1.contract_location_id, 1 as is_no_pending_observation, P.activity_id From mst_typeofwork_activity T INNER JOIN physical_progress_activity P ON P.activity_id = T.typeofwork_activity_id INNER JOIN physical_progress P1 ON P1.physical_progress_id = P.physical_progress_id INNER JOIN physical_progress_activity_observation P2 ON P2.contract_location_id = P1.contract_location_id AND P.activity_id = P2.activity_id AND P2.completion_date IS NULL INNER JOIN contract_location CL ON CL.contract_location_id = P1.contract_location_id AND P1.contract_id = CL.contract_id where CL.is_active = 1 and P2.deletedby is NULL Group By P1.contract_id, P1.contract_location_id, P.activity_id) P3 ON P3.contract_location_id = A.contract_location_id AND P3.activity_id = A.activity_id where (A.status_id = 1 AND IFNULL(is_no_pending_observation,0)=0) OR (A.status_id = 3) Group By A.physical_progress_id)`cc_act` on `cc_act`.`physical_progress_id` = `physical_progress`.`physical_progress_id` LEFT JOIN (select `contract_location_id`, count(`observation_id`) as `tt_observation` from `physical_progress_activity_observation` 
			where `physical_progress_activity_observation`.`deletedby` IS NULL group by `contract_location_id`)`tt_obs` on 
			`tt_obs`.`contract_location_id` = `contract_location`.`contract_location_id` LEFT JOIN (select 
			`contract_location_id`, count(`observation_id`) as `cc_observation` from `physical_progress_activity_observation`
			where ifnull(`completion_date`,'')<>'' group by `contract_location_id`)`cc_obs` on 
			`cc_obs`.`contract_location_id` = `contract_location`.`contract_location_id` WHERE `physical_progress`.`is_draft` = 0 and `physical_progress`.`status_id` = ".$pp_status_id." and `contract`.`status_id` = ".$active_contract_status_id." and `contract_location`.`is_active` = 1 and U.user_id=".$user_id." ORDER BY `physical_progress`.`status_id`desc, `physical_progress`.`reported_date` desc ;");

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

	public function searchPhysicalProgressReviewedSheets($contractor, $tender_award_no, $type_of_work, $site_location, $region, $circle, $division, $reported_by_id, $formatted_reported_date, $feeder_id, $status)
	{
		$user_id = $this->getLoggedInUserID();
		
		$ppreview_status_list_arr = $this->getStatusList();
		$ppreview_status_ids = [];
		foreach ($ppreview_status_list_arr as $value) {
			if ($value['name'] == 'Reviewed' || $value['name'] == 'Completed') {
				array_push($ppreview_status_ids, $value['status_id']);
			}
		}

		//adding search filters to the query
		$contractor_query = (!empty($contractor)) ? "and (ifnull(`contract`.`contractor_name`,'')<>'' and `contract`.`contractor_name` like '%".$contractor."%')" : '';

		$tender_award_no_query = (!empty($tender_award_no)) ? "and (ifnull(`contract`.`tender_award_no`,'')<>'' and `contract`.`tender_award_no` like '%".$tender_award_no."%')": '';

		$type_of_work_query = (!empty($type_of_work)) ? "and (ifnull(`contract`.`typeofwork_id`,0)<>0 and `contract`.`typeofwork_id` = ".$type_of_work.")": '';

		$site_location_query = (!empty($site_location)) ? "and (ifnull(`contract_location`.`location_name`,'')<>'' and `contract_location`.`location_name` like '%".$site_location."%')" : '';

		$region_query = (!empty($region)) ? "and (ifnull(`contract_location`.`region_id`,0)<>0 and `contract_location`.`region_id` = ".$region.")" : '';

		$circle_query = (!empty($circle)) ? "and (ifnull(`contract_location`.`circle_id`,0)<>0 and `contract_location`.`circle_id` = ".$circle.")" : '';

		$division_query = (!empty($division)) ? "and (ifnull(`contract_location`.`division_id`,0)<>0 and `contract_location`.`division_id` = ".$division.")" : '';

		$reported_by_query = (!empty($reported_by)) ? "and (ifnull(`physical_progress`.`reported_by`,0)<>0 and `physical_progress`.`reported_by` like '%".$reported_by."%')" : '';

		$reported_date_query = (!empty($reported_date)) ? "and (ifnull(`physical_progress`.`reported_date`,'')<>'' and `physical_progress`.`reported_date` like '%".$reported_date."%')" : '';

		$feeder_id_query = (!empty($feeder_id)) ? "and (ifnull(`contract_location`.`feeder_id`,0)<>0 and `contract_location`.`feeder_id` like '%".$feeder_id."%')" : '';

		$status_query = (!empty($status)) ? "and (ifnull(`physical_progress`.`status_id`,0)<>0 and `physical_progress`.`status_id` IN (".$status."))" : "and `physical_progress`.`status_id` IN (".implode(',',$ppreview_status_ids).")";

		$query = $this->db->query("SELECT `physical_progress`.`physical_progress_id`, `physical_progress`.`contract_id`, `physical_progress`.`contract_location_id`, `physical_progress`.`site_location`, `physical_progress`.`reported_by`, `physical_progress`.`reported_date`, `physical_progress`.`status_id`, `contract`.`contract_id`, `contract`.`contractor_name`, `contract`.`tender_award_no`, `contract`.`typeofwork_id`, `contract_location`.`contract_location_id`, `contract_location`.`region_id`, `contract_location`.`circle_id`, `contract_location`.`division_id`,`contract_location`.`location_name`, `contract_location`.`feeder_id`,`mst_user`.`username` AS `pp_reported_by`, `mst_region`.`region_name`,`mst_circle`.`circle_name`, `mst_division`.`division_name`,`mst_status`.`name` as `sheet_status`,`mst_typeofwork`.`name` as `typeofwork_name`, ifnull(`tt_act`.`tt_activity`,0) as `tt_task`, ifnull(`cc_act`.`comp_act`,0) as `cc_task`, ifnull(`tt_obs`.`tt_observation`,0) as `tt_observation`, ifnull(`cc_obs`.`cc_observation`,0) as `cc_observation` FROM (select max(`physical_progress`.`physical_progress_id`) AS `physical_progress_id`, `physical_progress`.`contract_id`, `physical_progress`.`contract_location_id`, max(`reported_date`) AS `reported_date` from `physical_progress` group by `physical_progress`.`contract_id`,`physical_progress`.`contract_location_id`) `grp` INNER JOIN `physical_progress` ON `physical_progress`.`physical_progress_id`=`grp`.`physical_progress_id` AND `physical_progress`.`contract_id` = `grp`.`contract_id` AND `physical_progress`.`contract_location_id`=`grp`.`contract_location_id` INNER JOIN `contract` ON `physical_progress`.`contract_id` = `contract`.`contract_id` INNER JOIN `contract_location` ON `physical_progress`.`contract_id` = `contract_location`.`contract_id` AND `physical_progress`.`contract_location_id` = `contract_location`.`contract_location_id` LEFT JOIN mst_user_data_access U ON U.region_id=`contract_location`.region_id AND U.circle_id=`contract_location`.circle_id AND U.division_id=`contract_location`.division_id LEFT JOIN `mst_user` ON `mst_user`.`user_id` = `physical_progress`.`reported_by` INNER JOIN `mst_region` ON `mst_region`.`region_id` = `contract_location`.`region_id` INNER JOIN `mst_circle` ON `mst_circle`.`circle_id` = `contract_location`.`circle_id` INNER JOIN `mst_division` ON `mst_division`.`division_id` = `contract_location`.`division_id` INNER JOIN `mst_status` ON `mst_status`.`status_id` = `physical_progress`.`status_id` INNER JOIN `mst_typeofwork` ON `mst_typeofwork`.`typeofwork_id` = `contract`.`typeofwork_id` LEFT JOIN ( select `physical_progress_id`, count(`mst_typeofwork_activity`.`typeofwork_activity_id`) as `tt_activity` from `physical_progress` `a` inner join `contract` on `contract`.`contract_id` = `a`.`contract_id` inner join `mst_typeofwork_activity` on `mst_typeofwork_activity`.`typeofwork_id` = `contract`.`typeofwork_id` group by `physical_progress_id`,`mst_typeofwork_activity`.`typeofwork_id`)`tt_act` on `tt_act`.`physical_progress_id` = `physical_progress`.`physical_progress_id` LEFT JOIN (Select A.`physical_progress_id` as `physical_progress_id`, ifnull(count(A.activity_id),0) as `comp_act` From (Select P1.physical_progress_id, P1.contract_location_id, P2.activity_id, P2.status_id From contract C  LEFT JOIN contract_location CL ON CL.contract_id = C.contract_id LEFT JOIN (select max(physical_progress.physical_progress_id) AS physical_progress_id, physical_progress.contract_id, physical_progress.contract_location_id, max(reported_date) AS reported_date from physical_progress group by physical_progress.contract_id, physical_progress.contract_location_id) P ON P.contract_location_id = CL.contract_location_id AND P.contract_id = CL.contract_id LEFT JOIN physical_progress P1 ON P1.physical_progress_id = P.physical_progress_id LEFT JOIN physical_progress_activity P2 ON P2.physical_progress_id = P1.physical_progress_id where CL.is_active = 1)A LEFT JOIN ( Select P1.physical_progress_id, P1.contract_location_id, 1 as is_no_pending_observation, P.activity_id From mst_typeofwork_activity T INNER JOIN physical_progress_activity P ON P.activity_id = T.typeofwork_activity_id INNER JOIN physical_progress P1 ON P1.physical_progress_id = P.physical_progress_id INNER JOIN physical_progress_activity_observation P2 ON P2.contract_location_id = P1.contract_location_id AND P.activity_id = P2.activity_id AND P2.completion_date IS NULL INNER JOIN contract_location CL ON CL.contract_location_id = P1.contract_location_id AND P1.contract_id = CL.contract_id where CL.is_active = 1 and P2.deletedby is NULL Group By P1.contract_id, P1.contract_location_id, P.activity_id) P3 ON P3.contract_location_id = A.contract_location_id AND P3.activity_id = A.activity_id where (A.status_id = 1 AND IFNULL(is_no_pending_observation,0)=0) OR (A.status_id = 3) Group By A.physical_progress_id)`cc_act` on `cc_act`.`physical_progress_id` = `physical_progress`.`physical_progress_id` LEFT JOIN (select `contract_location_id`, count(`observation_id`) as `tt_observation` from `physical_progress_activity_observation` where `physical_progress_activity_observation`.`deletedby` IS NULL group by `contract_location_id`)`tt_obs` on `tt_obs`.`contract_location_id` = `contract_location`.`contract_location_id` LEFT JOIN (select `contract_location_id`, count(`observation_id`) as `cc_observation` from `physical_progress_activity_observation` where ifnull(`completion_date`,'')<>'' group by `contract_location_id`)`cc_obs` on `cc_obs`.`contract_location_id` = `contract_location`.`contract_location_id` WHERE `physical_progress`.`is_draft` = 0 and `contract_location`.`is_active` = 1 and U.user_id=".$user_id." ".$contractor_query." ".$tender_award_no_query." ".$type_of_work_query." ".$site_location_query." ".$region_query." ".$circle_query." ".$division_query." ".$reported_by_query." ".$reported_date_query." ".$feeder_id_query." ".$status_query." ORDER BY `physical_progress`.`status_id` desc ;");

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

	public function getTypeOfWorkList()
	{
		$query_result = [];

		$query =  $this->db->select('typeofwork_id, name')->get('mst_typeofwork');

		if ($query->num_rows() > 0) {
			$query_result = $query->result_array();
		}

		return $query_result;
	}

	public function getRegionList()
	{
		$query_result = [];

		$this->db->select('region_id, region_name');
		$query = $this->db->get_where('mst_region', array('is_active' => 1));

		if ($query->num_rows() > 0) {
			$query_result = $query->result_array();
		}

		return $query_result;
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

	public function getRegionCircleData()
	{
		$userdata = $_SESSION['loggedData'];
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

	public function getStatusList()
	{
		$this->db->select('mst_module.module_id, mst_module.name, mst_status.status_id, mst_status.name, mst_status.seqno');
		$this->db->from('mst_module');
		$this->db->join('mst_status', 'mst_module.module_id = mst_status.module_id', 'INNER');
		$this->db->where(array('mst_module.name' => 'Physical Verification', 'mst_module.icon !=' => ''));
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
				$query_result = $query->result_array();				
			}

			return $query_result;
		}
	}

	public function getStatusIDForList()
	{
		$this->db->select('mst_status.status_id');
		$this->db->from('mst_status');
		$this->db->join('mst_module', 'mst_status.module_id = mst_module.module_id', 'INNER');
		$this->db->where(array('mst_module.name' => 'Physical Verification', 'mst_module.icon !=' => '', 'mst_status.name' => 'Reviewed'));

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
				$query_result = $result['status_id'];
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
		$this->db->where(array('mst_module.name' => 'Physical Progress Review', 'mst_module.icon !=' => '', 'mst_user.user_id' => $user_id));
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