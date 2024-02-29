<?php defined('BASEPATH') OR exit('No direct script access allowed');

class TKCWeeklyPlan_Model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	public function getPackages()
	{
		$contract_status_list = $this->getContractStatusList();

		$this->db->select('package_no');
		$query = $this->db->get_where('contract', array('status_id' =>$contract_status_list['Open']));
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

				mysqli_next_result($this->db->conn_id);
                $query->free_result();
			}

			return $query_result;
		}
	}

	public function getCirclesAssignedToTKC($packages)
	{
		$this->db->select('mst_circle.circle_name');
		$this->db->distinct();
		$this->db->from('contract');
		$this->db->join('contract_location', 'contract.contract_id = contract_location.contract_id', 'INNER');
		$this->db->join('mst_circle', 'contract_location.circle_id = mst_circle.circle_id', 'INNER');
		$this->db->where('contract.package_group_no', $packages);

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
					array_push($query_result, $value['circle_name']);
				}
			}

			return $query_result;
		}
	}

	public function getCircleWiseDivision($circles)
	{
		$this->db->select('mst_circle.circle_name, mst_division.division_name');
		$this->db->from('mst_circle');
		$this->db->join('mst_division', 'mst_circle.circle_id = mst_division.circle_id', 'INNER');
		$this->db->where_in('mst_circle.circle_name', $circles);

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

	public function getDivisionListAssignedToTKC($user_id)
	{
		$this->db->select('DISTINCT(contract_location.division_id), mst_division.circle_id, mst_division.division_name');
		$this->db->from('contract_location');
		$this->db->join('contract', 'contract.contract_id = contract_location.contract_id', 'INNER');
		$this->db->join('mst_user', 'mst_user.package_access = contract.package_no', 'INNER');
		$this->db->join('mst_division', 'contract_location.division_id = mst_division.division_id', 'INNER');
		$this->db->where(array('mst_user.user_id' => $user_id, 'mst_division.is_active' => 1, 'mst_division.deletedby' => NULL));

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

	public function getCircleDivisionWiseFeederList($circle_id, $division_id)
	{
		$this->db->select('feeder_id');
		$this->db->where(array('circle_id' => $circle_id, 'division_id' => $division_id));
		$this->db->order_by('feeder_id', 'ASC');

		$query = $this->db->get('contract_location');
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

	public function saveTKCWeeklyPlan($from_date, $to_date, $is_draft)
	{
		$data = array(
			'from_date' => date('Y-m-d', strtotime($from_date)),
			'to_date' => date('Y-m-d', strtotime($to_date)),
			'is_draft' => (int) $is_draft,
			'is_active' => 1,
			'createdby' => $this->getLoggedInUserID(),
			'createddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->insert('tkc_plan', $data);

		if (!$query) {
			$error = $this->db->error();	
			echo 'hereError Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$insert_id = $this->db->insert_id();
			return $insert_id;
		}
	}

	public function saveTKCWeeklyPlanDetails($tkc_plan_id, $contract_id, $date_of_work, $circle_id, $division_id, $work_description, $remark)
	{
		$data = array(
			'tkc_plan_id' => $tkc_plan_id,
			'contract_id' => $contract_id,
			'plan_date' => $date_of_work,
			'circle_id' => $circle_id,
			'division_id' => $division_id,
			'description' => $work_description,
			'remark' => $remark,
			'is_active' => 1,
			'createdby' => $this->getLoggedInUserID(),
			'createddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->insert('tkc_plan_detail', $data);

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$insert_id = $this->db->insert_id();
			return $insert_id;
		}
	}

	public function saveTKCWeeklyPlanFeederDetails($tkc_plan_detail_id, $contract_location_id)
	{
		$data = array(
			'tkc_plan_detail_id' => $tkc_plan_detail_id,
			'contract_location_id' => $contract_location_id,
			'is_active' => 1,
			'createdby' => $this->getLoggedInUserID(),
			'createddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->insert('tkc_plan_detail_feeder', $data);

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$insert_id = $this->db->insert_id();
			return $insert_id;
		}
	}

	public function updateTKCWeeklyPlan($tkc_plan_id, $from_date, $to_date, $is_draft)
	{
		$data = array(
			'from_date' => date('Y-m-d', strtotime($from_date)),
			'to_date' => date('Y-m-d', strtotime($to_date)),
			'is_draft' => (int) $is_draft,
			'is_active' => 1,
			'modifiedby' => $this->getLoggedInUserID(),
			'modifieddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->update('tkc_plan', $data, array('tkc_plan_id' => $tkc_plan_id));

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			return $this->db->affected_rows();
		}
	}

	public function updateTKCWeeklyPlanDetails($tkc_plan_detail_id, $tkc_plan_id, $contract_id, $date_of_work, $circle_id, $division_id, $work_description, $remark)
	{
		$data = array(
			'tkc_plan_id' => $tkc_plan_id,
			'contract_id' => $contract_id,
			'plan_date' => $date_of_work,
			'circle_id' => $circle_id,
			'division_id' => $division_id,
			'description' => $work_description,
			'remark' => $remark,
			'is_active' => 1,
			'modifiedby' => $this->getLoggedInUserID(),
			'modifieddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->update('tkc_plan_detail', $data, array('tkc_plan_detail_id' => $tkc_plan_detail_id));

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			if ($this->db->affected_rows() > 0) {
				return $tkc_plan_detail_id;	
			}
		}
	}

	public function checkFeederDetailsExists($tkc_plan_detail_id, $feeder_id)
	{
		$contract_location_id = $this->getContractLocationIDByFeederID($feeder_id);
		$query = $this->db->get_where('tkc_plan_detail_feeder', array('tkc_plan_detail_id' => $tkc_plan_detail_id, 'contract_location_id' => $contract_location_id));

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

	public function getTKCWeeklyPlans($user_id, $from_date = '', $to_date = '')
	{
		$user_role = $this->getUserRoleName($user_id);

		if ($user_role == 'TKC') {
			$this->db->select('tkc_plan.from_date, tkc_plan.to_date, tkc_plan_detail.tkc_plan_detail_id, tkc_plan_detail.contract_id, tkc_plan_detail.plan_date, tkc_plan_detail.circle_id, tkc_plan_detail.division_id, tkc_plan_detail.description, tkc_plan_detail.remark, contract.contractor_name, contract.package_no, mst_circle.circle_name, mst_division.division_name');
			$this->db->from('tkc_plan');
			$this->db->join('tkc_plan_detail', 'tkc_plan_detail.tkc_plan_id = tkc_plan.tkc_plan_id', 'INNER');
			$this->db->join('contract', 'contract.contract_id = tkc_plan_detail.contract_id', 'INNER');
			$this->db->join('mst_circle', 'mst_circle.circle_id = tkc_plan_detail.circle_id', 'INNER');
			$this->db->join('mst_division', 'mst_division.division_id = tkc_plan_detail.division_id', 'INNER');
			$this->db->where(array('tkc_plan.is_draft' => 0, 'tkc_plan.is_active' => 1, 'tkc_plan.deletedby' => NULL));	
		} else {
			$user_assigned_circles = $this->getUserAssignedCircles($user_id);
			$user_assigned_divisions = $this->getUserAssignedDivisions($user_id);

			$this->db->select('tkc_plan.from_date, tkc_plan.to_date, tkc_plan_detail.tkc_plan_detail_id, tkc_plan_detail.contract_id, tkc_plan_detail.plan_date, tkc_plan_detail.circle_id, tkc_plan_detail.division_id, tkc_plan_detail.description, tkc_plan_detail.remark, contract.contractor_name, contract.package_no, mst_circle.circle_name, mst_division.division_name');
			$this->db->from('tkc_plan');
			$this->db->join('tkc_plan_detail', 'tkc_plan_detail.tkc_plan_id = tkc_plan.tkc_plan_id', 'INNER');
			$this->db->join('contract', 'contract.contract_id = tkc_plan_detail.contract_id', 'INNER');
			$this->db->join('mst_circle', 'mst_circle.circle_id = tkc_plan_detail.circle_id', 'INNER');
			$this->db->join('mst_division', 'mst_division.division_id = tkc_plan_detail.division_id', 'INNER');
			$this->db->where_in('tkc_plan_detail.circle_id', $user_assigned_circles);
			$this->db->where_in('tkc_plan_detail.division_id', $user_assigned_divisions);
			$this->db->where(array('tkc_plan.is_draft' => 0, 'tkc_plan.is_active' => 1, 'tkc_plan.deletedby' => NULL));	
		}		

		if (!empty($from_date) && !empty($to_date)) {
			$this->db->where(array('tkc_plan.from_date' => $from_date, 'tkc_plan.to_date' => $to_date));
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

				foreach ($query_result as $key => $value) {
					$feeders_data = $this->getTKCWeeklyPlansFeederDetails($value['tkc_plan_detail_id']);
					$query_result[$key]['feeders'] = implode(',', $feeders_data);
				}
			}

			return $query_result;
		}
	}

	public function getDateRangeExists($user_id, $from_date, $to_date)
	{
		$query = $this->db->get_where('tkc_plan', array('from_date' => $from_date, 'to_date' => $to_date, 'createdby' => $user_id, 'is_active' => 1));
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

	public function getUserAssignedDivisions($user_id)
	{
		$this->db->select('division_id');
		$query = $this->db->get_where('mst_user_data_access', array('user_id' => $user_id));
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
					array_push($query_result, $value['division_id']);
				}

				return $query_result;
			}
		}
	}

	public function getUserAssignedCircles($user_id)
	{
		$this->db->select('circle_id');
		$query = $this->db->get_where('mst_user_data_access', array('user_id' => $user_id));
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
					array_push($query_result, $value['circle_id']);
				}

				return $query_result;
			}
		}
	}

	public function getTKCWeeklyPlanDetails($tkc_plan_id)
	{
		$this->db->select('tkc_plan.tkc_plan_id, tkc_plan.from_date, tkc_plan.to_date, tkc_plan_detail.tkc_plan_detail_id, tkc_plan_detail.contract_id, tkc_plan_detail.plan_date, tkc_plan_detail.circle_id, tkc_plan_detail.division_id, tkc_plan_detail.description, tkc_plan_detail.remark, contract.package_no, mst_circle.circle_name, mst_division.division_name');
		$this->db->from('tkc_plan');
		$this->db->join('tkc_plan_detail', 'tkc_plan.tkc_plan_id = tkc_plan_detail.tkc_plan_id', 'LEFT');
		$this->db->join('contract', 'tkc_plan_detail.contract_id = contract.contract_id', 'LEFT');
		$this->db->join('mst_circle', 'tkc_plan_detail.circle_id = mst_circle.circle_id', 'LEFT');
		$this->db->join('mst_division', 'tkc_plan_detail.division_id = mst_division.division_id', 'LEFT');
		$this->db->where(array('tkc_plan.tkc_plan_id' => $tkc_plan_id, 'tkc_plan.is_active' => 1, 'tkc_plan.deletedby' => NULL));

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

				$query_result = [];

				$query_result['date_range'] = date('d-m-Y', strtotime($result[0]['from_date'])).' - '.date('d-m-Y', strtotime($result[0]['to_date']));
				
				foreach ($result as $key => $value) {
					// echo 'value: <pre>'; print_r($value); echo '</pre>'; die();
					$result[$key]['from_date'] = date('d-m-Y', strtotime($value['from_date']));
					$result[$key]['to_date'] = date('d-m-Y', strtotime($value['to_date']));
					$result[$key]['plan_date'] = date('d-m-Y', strtotime($value['plan_date']));
					$result[$key]['plan_day'] = date('l', strtotime($value['plan_date']));
					// echo '<pre>'; print_r($result[$key]); echo '</pre>'; die();

					$feeders_data = $this->getTKCWeeklyPlansFeederDetails($value['tkc_plan_detail_id']);
					$result[$key]['feeders'] = implode(', ', $feeders_data);
				}

				$query_result['weekly_plan_details'] = $result;
			}

			return $query_result;
		}
	}

	public function getTKCWeeklyPlanDetailsForTKCWeeklyID($tkc_plan_id)
	{
		$query = $this->db->get_where('tkc_plan_detail', array('tkc_plan_id' => $tkc_plan_id, 'is_active' => 1, 'deletedby' => NULL));
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

	public function searchTKCWeeklyPlans($from_date, $to_date, $contractor, $circle, $division, $feeder_id)
	{
		if (!empty($feeder_id)) {
			$contract_location_id = $this->getContractLocationIDByFeederID($feeder_id);
		}

		$this->db->select('tkc_plan.tkc_plan_id, tkc_plan.from_date, tkc_plan.to_date, tkc_plan_detail.tkc_plan_detail_id, tkc_plan_detail.contract_id, tkc_plan_detail.plan_date, tkc_plan_detail.circle_id, tkc_plan_detail.division_id, tkc_plan_detail.description, tkc_plan_detail.remark, contract.contractor_name, contract.package_no, mst_circle.circle_name, mst_division.division_name');
		$this->db->from('tkc_plan');
		$this->db->join('tkc_plan_detail', 'tkc_plan_detail.tkc_plan_id = tkc_plan.tkc_plan_id', 'INNER');

		if (!empty($feeder_id)) {
			$this->db->join('tkc_plan_detail_feeder', 'tkc_plan_detail_feeder.tkc_plan_detail_id = tkc_plan_detail.tkc_plan_detail_id', 'INNER');
		}

		$this->db->join('contract', 'contract.contract_id = tkc_plan_detail.contract_id', 'INNER');
		$this->db->join('mst_circle', 'mst_circle.circle_id = tkc_plan_detail.circle_id', 'INNER');
		$this->db->join('mst_division', 'mst_division.division_id = tkc_plan_detail.division_id', 'INNER');
		$this->db->where(array('tkc_plan.is_draft' => 0, 'tkc_plan.is_active' => 1, 'tkc_plan.deletedby' => NULL));

		if (!empty($from_date)) {
			$this->db->where('tkc_plan.from_date', $from_date);
		}

		if (!empty($to_date)) {
			$this->db->where('tkc_plan.to_date', $to_date);
		}

		if (!empty($contractor)) {
			$this->db->where('tkc_plan.createdby', $contractor);
		}

		if (!empty($circle)) {
			$this->db->where('tkc_plan_detail.circle_id', $circle);
		}

		if (!empty($division)) {
			$this->db->where('tkc_plan_detail.division_id', $division);
		}

		if (!empty($feeder_id)) {
			$this->db->where('tkc_plan_detail_feeder.contract_location_id', $contract_location_id);
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

				foreach ($query_result as $key => $value) {
					$feeders_data = $this->getTKCWeeklyPlansFeederDetails($value['tkc_plan_detail_id']);

					if (!empty($feeder_id)) {
						foreach ($feeders_data as $f_value) {
							if ($feeder_id == $f_value) {
								$query_result[$key]['feeders'] = $f_value;			
							}
						}
					} else {
						$query_result[$key]['feeders'] = implode(',', $feeders_data);
					}					
				}
			}

			return $query_result;
		}
	}

	public function getTKCWeeklyPlanDateRanges($user_id)
	{
		$user_role = $this->getUserRoleName($user_id);

		if ($user_role == 'TKC') {
			$this->db->select('tkc_plan.tkc_plan_id, tkc_plan.from_date, tkc_plan.to_date, tkc_plan.is_draft, tkc_plan.createdby, mst_user.username');
			$this->db->from('tkc_plan');
			$this->db->join('mst_user', 'tkc_plan.createdby = mst_user.user_id', 'INNER');
			$this->db->where(array('tkc_plan.createdby' => $user_id, 'tkc_plan.is_active' => 1, 'tkc_plan.deletedby' => NULL, 'mst_user.is_active' => 1));
		} else {
			$user_assigned_circles = $_SESSION['myCircles'];
			$user_assigned_divisions = $_SESSION['myDivision'];

			$this->db->select('DISTINCT(tkc_plan.tkc_plan_id), tkc_plan.from_date, tkc_plan.to_date, tkc_plan.is_draft, tkc_plan.createdby, mst_user.username');
			$this->db->from('tkc_plan');
			$this->db->join('tkc_plan_detail', 'tkc_plan_detail.tkc_plan_id = tkc_plan.tkc_plan_id', 'LEFT');
			$this->db->join('mst_user', 'tkc_plan.createdby = mst_user.user_id', 'INNER');
			$this->db->where_in('tkc_plan_detail.circle_id', $user_assigned_circles);
			$this->db->where_in('tkc_plan_detail.division_id', $user_assigned_divisions);
			$this->db->where(array('tkc_plan.is_active' => 1, 'tkc_plan.deletedby' => NULL));
		}

		$this->db->order_by('tkc_plan.from_date', 'DESC');

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
					$lot_data = $this->getLotNoAndContractorForTKCWeeklyPlan($value['tkc_plan_id']);

					$lot_no = [];
					$contractor = [];
					foreach ($lot_data as $lot_key => $lot_value) {
						array_push($lot_no, $lot_value['package_group_no']);
						array_push($contractor, $lot_value['contractor_name']);
					}

					$result[$key]['lot_no'] = implode(', ', $lot_no);
					$result[$key]['contractor_name'] = implode(', ', $contractor);
				}

				$query_result = $result;
			}

			return $query_result;
		}
	}

	public function getLotNoAndContractorForTKCWeeklyPlan($tkc_plan_id)
	{
		$contract_status_list = $this->getContractStatusList();

		$this->db->select('DISTINCT (tkc_plan_detail.contract_id), contract.package_group_no, contract.contractor_name');
		$this->db->from('tkc_plan_detail');
		$this->db->join('contract', 'tkc_plan_detail.contract_id = contract.contract_id', 'INNER');
		$this->db->where(array('contract.status_id' => $contract_status_list['Open']));

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

	public function getTKCWeeklyPlansFeederDetails($tkc_plan_detail_id)
	{
		$this->db->select('contract_location.feeder_id');
		$this->db->from('tkc_plan_detail_feeder');
		$this->db->join('contract_location', 'tkc_plan_detail_feeder.contract_location_id = contract_location.contract_location_id', 'INNER');
		$this->db->where(array('tkc_plan_detail_feeder.tkc_plan_detail_id' => $tkc_plan_detail_id, 'tkc_plan_detail_feeder.is_active' => 1, 'tkc_plan_detail_feeder.deletedby' => NULL));		

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
					array_push($query_result, $value['feeder_id']);
				}
			}

			return $query_result;
		}
	}

	public function getTKCWeeklyPlansFeederDetailsForTKCWeeklyDetailID($tkc_plan_detail_id)
	{
		$query = $this->db->get_where('tkc_plan_detail_feeder', array('tkc_plan_detail_id' => $tkc_plan_detail_id, 'is_active', 'deletedby' => NULL));
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

	public function deleteFeedersDetailsByTKCPLanDetailID($tkc_plan_detail_id)
	{
		$data = array(
			'is_active' => 0,
			'deletedby' => $this->getLoggedInUserID(),
			'deleteddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->update('tkc_plan_detail_feeder', $data, array('tkc_plan_detail_id' => $tkc_plan_detail_id));

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			return $this->db->affected_rows();
		}
	}

	public function deleteWeekllPlanDetailsByTKCPlanID($tkc_plan_id)
	{
		$data = array(
			'is_active' => 0,
			'deletedby' => $this->getLoggedInUserID(),
			'deleteddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->update('tkc_plan_detail', $data, array('tkc_plan_id' => $tkc_plan_id));

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			return $this->db->affected_rows();
		}
	}

	public function deleteTKCWeeklyPlan($tkc_plan_id)
	{
		$data = array(
			'is_active' => 0,
			'deletedby' => $this->getLoggedInUserID(),
			'deleteddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->update('tkc_plan', $data, array('tkc_plan_id' => $tkc_plan_id));

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			return $this->db->affected_rows();
		}
	}

	public function getContractIDFromLotNo($lot_no)
	{
		$this->db->select('contract_id');
		$query = $this->db->get_where('contract', array('package_no' => $lot_no));
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

	public function getCircleID($circle)
	{
		$this->db->select('circle_id');
		$query = $this->db->get_where('mst_circle', array('circle_name' => $circle));
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();    
            echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
            die();
		} else {
			$query_result = [];
			
			if ($query->num_rows() > 0) {
				$result = $query->row_array();
				$query_result = $result['circle_id'];
			}

			return $query_result;
		}
	}

	public function getDivisionID($division)
	{
		$this->db->select('division_id');
		$query = $this->db->get_where('mst_division', array('division_name' => $division));
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();    
            echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
            die();
		} else {
			$query_result = [];
			
			if ($query->num_rows() > 0) {
				$result = $query->row_array();
				$query_result = $result['division_id'];
			}

			return $query_result;
		}
	}

	public function getContractLocationIDByFeederID($feeder)
	{
		$this->db->select('contract_location_id');
		$query = $this->db->get_where('contract_location', array('feeder_id' => $feeder));
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();    
            echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
            die();
		} else {
			$query_result = [];
			
			if ($query->num_rows() > 0) {
				$result = $query->row_array();
				$query_result = $result['contract_location_id'];
			}

			return $query_result;
		}
	}

	public function getContractorList()
	{
		$this->db->select('mst_user.username, mst_user.user_id');
		$this->db->from('mst_user');
		$this->db->join('mst_role', 'mst_user.role_id = mst_role.role_id', 'INNER');
		$this->db->where(array('mst_role.name' => 'TKC'));

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

	public function getCircleListAssignedToTKC($user_id)
	{
		$this->db->select('DISTINCT(contract_location.circle_id), mst_circle.circle_name');
		$this->db->from('contract_location');
		$this->db->join('contract', 'contract.contract_id = contract_location.contract_id', 'INNER');
		$this->db->join('mst_user', 'mst_user.package_access = contract.package_no', 'INNER');
		$this->db->join('mst_circle', 'contract_location.circle_id = mst_circle.circle_id', 'INNER');
		$this->db->where(array('mst_user.user_id' => $user_id, 'mst_circle.is_active' => 1, 'mst_circle.deletedby' => NULL))
		;

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

	public function getCircleListAssignedToUser($user_id)
	{
		$this->db->select('DISTINCT(mst_user_data_access.circle_id), mst_circle.circle_name');
		$this->db->from('mst_user_data_access');
		$this->db->join('mst_circle', 'mst_user_data_access.circle_id = mst_circle.circle_id', 'INNER');
		$this->db->where(array('mst_user_data_access.user_id' => $user_id));

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

	public function getDivisionListAssignedToUser($user_id)
	{
		$this->db->select('mst_user_data_access.division_id, mst_division.circle_id, mst_division.division_name');
		$this->db->from('mst_user_data_access');
		$this->db->join('mst_division', 'mst_user_data_access.division_id = mst_division.division_id', 'INNER');
		$this->db->where(array('mst_user_data_access.user_id' => $user_id));

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

	public function getUserModuleAccess()
	{
		$user_id = $this->getLoggedInUserID();

		$this->db->select('mst_user.role_id, mst_module.name, mst_role_module_access.module_access_id, mst_module_access.module_id, mst_module_access.access_key, mst_module_access.event');
		$this->db->from('mst_user');
		$this->db->join('mst_role_module_access', 'mst_user.role_id = mst_role_module_access.role_id', 'INNER');
		$this->db->join('mst_module_access', 'mst_role_module_access.module_access_id = mst_module_access.module_access_id', 'INNER');
		$this->db->join('mst_module', 'mst_module_access.module_id = mst_module.module_id', 'INNER');
		$this->db->where(array('mst_module.name' => 'TKC Weekly Plan', 'mst_module.icon !=' => '', 'mst_user.user_id' => $user_id));
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

	public function getUserRoleName($user_id)
	{
		$this->db->select('mst_role.name');
		$this->db->from('mst_role');
		$this->db->join('mst_user', 'mst_user.role_id = mst_role.role_id', 'INNER');
		$this->db->where(array('mst_user.user_id' => $user_id));

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

				$query_result = $result['name'];
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