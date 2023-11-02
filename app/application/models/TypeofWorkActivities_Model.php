<?php defined('BASEPATH') OR exit('No direct script access allowed');

class TypeofWorkActivities_Model extends CI_Model
{	
	function __construct()
	{
		parent::__construct();
	}

	public function getTypeOfWorkList()
	{
		$this->db->select('typeofwork_id, name');
		$query = $this->db->get_where('mst_typeofwork', array('is_active' => 1));
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

	public function getTypeOfWorkName($typeofwork_id)
	{
		$this->db->select('name');
		$query = $this->db->get_where('mst_typeofwork', array('typeofwork_id' => $typeofwork_id));
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$query_result = '';
			if ($query->num_rows() > 0) {
				$result = $query->row_array();
				$query_result = $result['name'];
			}

			return $query_result;
		}
	}

	public function getTypeOfWorkData($typeofwork_name)
	{
		$query = $this->db->get_where('mst_typeofwork', array('name' => $typeofwork_name));
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

	public function getAllTypeOfWorkActivityGroups()
	{
		$this->db->select('activity_group_id, name, is_boq');
		$query = $this->db->get_where('mst_activity_group', array('is_active' => 1));
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

	public function getTypeOfWorkActivities($typeofwork_id)
	{
		$this->db->select('mst_typeofwork_activity.typeofwork_activity_id, mst_typeofwork_activity.activity_group_id, mst_typeofwork_activity.unit_id, mst_typeofwork_activity.seqno, mst_typeofwork_activity.activity, mst_typeofwork_activity.dashboard_head, mst_typeofwork_activity.weightage, mst_typeofwork_activity.report_head, mst_typeofwork_activity.multiply_factor, mst_typeofwork_activity.item_code, mst_typeofwork_activity.erp_item_name, mst_activity_group.name as activity_group_name, mst_activity_group.is_boq');
		$this->db->from('mst_typeofwork_activity');
		$this->db->join('mst_activity_group', 'mst_typeofwork_activity.activity_group_id = mst_activity_group.activity_group_id', 'INNER');
		$this->db->where('mst_typeofwork_activity.typeofwork_id', $typeofwork_id);
		$this->db->where(array('mst_typeofwork_activity.typeofwork_id' => $typeofwork_id, 'mst_typeofwork_activity.is_active' => 1, 'mst_typeofwork_activity.deletedby' => NULL));

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

				//Getting observations configured against the activities
				foreach ($query_result as $key => $value) {
					$value['observations'] = [];
					$obs_data = $this->getConfiguredObservations($value['typeofwork_activity_id']);

					if (!empty($obs_data)) {
						foreach ($obs_data as $obs_key => $obs_value) {
							array_push($value['observations'], $obs_value); 
						}
					}

					$query_result[$key]['observations'] = $value['observations'];
				}
			}

			return $query_result;
		}
	}

	public function getConfiguredObservations($typeofwork_activity_id)
	{
		$this->db->select('typeofwork_activity_options_id,name as observation_name');
		$query = $this->db->get_where('mst_typeofwork_activity_options', array('typeofwork_activity_id' => $typeofwork_activity_id, 'is_active' => 1, 'deletedby' => NULL));
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

	public function getActivityGroupID($activity_group_name)
	{
		$this->db->select('activity_group_id');
		$query = $this->db->get_where('mst_activity_group', array('name' => $activity_group_name));
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$query_result = 0;

			if ($query->num_rows() > 0) {
				$result = $query->row_array();
				$query_result = $result['activity_group_id'];
			}

			return $query_result;
		}
	}

	public function saveActivityGroup($new_activity_group, $activity_type)
	{
		$data = array(
			'name' => $new_activity_group,
			'is_boq' => $activity_type,
			'model' => 0,
			'is_active' => 1
		);

		$query = $this->db->insert('mst_activity_group', $data);

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			return $this->db->affected_rows();
		}
	}

	public function deleteTypeofWorkActivity($typeofwork_activity_id)
	{
		$data = array(
			'is_active' => 0,
			'deletedby' => $this->getLoggedInUserID(),
			'deleteddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->update('mst_typeofwork_activity', $data, array('typeofwork_activity_id' => $typeofwork_activity_id));

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			return $this->db->affected_rows();
		}
	}

	public function checkTypeofWorkActivityOptionsExists($typeofwork_activity_id)
	{
		$query = $this->db->get_where('mst_typeofwork_activity_options', array('typeofwork_activity_id' => $typeofwork_activity_id));
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			return $query->num_rows();
		}

	}

	public function deleteTypeofWorkActivityOptions($typeofwork_activity_id)
	{
		$data = array(
			'is_active' => 0,
			'deletedby' => $this->getLoggedInUserID(),
			'deleteddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->update('mst_typeofwork_activity_options', $data, array('typeofwork_activity_id' => $typeofwork_activity_id));

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			return $this->db->affected_rows();
		}
	}

	public function insertActivity($typeofwork_id, $activity_group_id, $unit_id, $seqno, $activity, $dashboard_head, $weightage, $report_head, $multiply_factor, $item_code, $erp_item_name)
	{
		$data = array(
			'typeofwork_id' => $typeofwork_id,
			'activity_group_id' => $activity_group_id,
			'unit_id' => $unit_id,
			'seqno' => $seqno,
			'activity' => $activity,
			'dashboard_head' => $dashboard_head,
			'weightage' => $weightage,
			'report_head' => $report_head,
			'multiply_factor' => $multiply_factor,
			'item_code' => $item_code,
			'erp_item_name' => $erp_item_name,
			'is_active' => 1,
			'createdby' => $this->getLoggedInUserID(),
			'createddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->insert('mst_typeofwork_activity', $data);

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			if ($this->db->affected_rows() > 0) {
				return $this->db->insert_id();
			}
		}
	}

	public function updateActivity($activity_id, $activity_group_id, $seqno, $activity_name, $dashboard_head, $weightage, $report_head, $multiply_factor, $item_code, $erp_item_name)
	{
		$data = array(
			'activity_group_id' => $activity_group_id,
			'seqno' => $seqno,
			'activity' => $activity_name,
			'dashboard_head' => $dashboard_head,
			'weightage' => $weightage,
			'report_head' => $report_head,
			'multiply_factor' => $multiply_factor,
			'item_code' => $item_code,
			'erp_item_name' => $erp_item_name,
			'modifiedby' => $this->getLoggedInUserID(),
			'modifieddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->update('mst_typeofwork_activity', $data, array('typeofwork_activity_id' => $activity_id));
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			return $this->db->affected_rows();
		}
	}

	public function insertActivityOptions($typeofwork_activity_id, $name)
	{
		$data = array(
			'typeofwork_activity_id' => $typeofwork_activity_id,
			'name' => $name,
			'is_active' => 1,
			'createdby' => $this->getLoggedInUserID(),
			'createddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->insert('mst_typeofwork_activity_options', $data);

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$this->db->affected_rows();
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
		$this->db->where(array('mst_module.name' => 'Type of Work - Activities', 'mst_user.user_id' => $user_id));
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