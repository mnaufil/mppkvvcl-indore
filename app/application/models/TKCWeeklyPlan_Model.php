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

	public function getCirclesAssignedToUser($circle_ids)
	{
		$this->db->select('circle_id, circle_name');
		$this->db->where_in('circle_id', $circle_ids);
		$query = $this->db->get_where('mst_circle');
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

	/*public function getDivisionsAssignedToUser($division_ids)
	{
		$this->db->select('division_id, division_name');
		$this->db->where_in('division_id', $division_ids);
		$query = $this->db->get('mst_division');
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
	}*/

	public function getCircleWiseDivision($division_ids)
	{
		$this->db->select('mst_division.division_name, mst_circle.circle_name');
		$this->db->from('mst_division');
		$this->db->join('mst_circle', 'mst_division.circle_id = mst_circle.circle_id', 'INNER');
		$this->db->where_in('mst_division.division_id', $division_ids);

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

	public function getTKCWeeklyPlans()
	{
		$this->db->select('tkc_plan.from_date, tkc_plan.to_date, tkc_plan_detail.tkc_plan_detail_id, tkc_plan_detail.contract_id, tkc_plan_detail.plan_date, tkc_plan_detail.circle_id, tkc_plan_detail.division_id, tkc_plan_detail.description, tkc_plan_detail.remark, contract.contractor_name, contract.package_no, mst_circle.circle_name, mst_division.division_name');
		$this->db->from('tkc_plan');
		$this->db->join('tkc_plan_detail', 'tkc_plan_detail.tkc_plan_id = tkc_plan.tkc_plan_id', 'INNER');
		$this->db->join('contract', 'contract.contract_id = tkc_plan_detail.contract_id', 'INNER');
		$this->db->join('mst_circle', 'mst_circle.circle_id = tkc_plan_detail.circle_id', 'INNER');
		$this->db->join('mst_division', 'mst_division.division_id = tkc_plan_detail.division_id', 'INNER')
		$this->db->where(array('tkc_plan.is_draft' => 0, 'tkc_plan.is_active' => 1));

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

	public function getTKCWeeklyPlansFeederDetails($tkc_plan_detail_id)
	{
		$this->db->select('contract_location.feeder_id');
		$this->db->from('tkc_plan_detail_feeder');
		$this->db->join('contract_location', 'tkc_plan_detail_feeder.contract_location_id = contract_location.contract_location_id', 'INNER');
		$this->db->where(array('tkc_plan_detail_feeder.tkc_plan_detail_id' => $tkc_plan_detail_id));

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

	public function getLoggedInUserID()
	{
		$userdata = $_SESSION['loggedData'];
		return $userdata->user_id;
	}
}

?>