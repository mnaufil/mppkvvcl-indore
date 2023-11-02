<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Division_Model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	public function getDivisionList()
	{
		$this->db->select('mst_division.division_id, mst_division.division_name, mst_circle.circle_name, mst_region.region_name');
		$this->db->from('mst_division');
		$this->db->join('mst_circle', 'mst_division.circle_id = mst_circle.circle_id', 'INNER');
		$this->db->join('mst_region', 'mst_circle.region_id = mst_region.region_id', 'INNER');
		$this->db->where(array('mst_division.is_active' => 1, 'mst_division.deletedby' => NULL));

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

	public function getDivisionData($circle_id)
	{
		$query = $this->db->get_where('mst_division', array('circle_id' => $circle_id));
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

	public function getDivisionByDivisionID($division_id)
	{
		$this->db->select('mst_division.division_id, mst_division.division_name, mst_circle.circle_name, mst_region.region_name');
		$this->db->from('mst_division');
		$this->db->join('mst_circle', 'mst_division.circle_id = mst_circle.circle_id', 'INNER');
		$this->db->join('mst_region', 'mst_circle.region_id = mst_region.region_id', 'INNER');
		$this->db->where(array('mst_division.division_id' => $division_id));

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

	public function searchDivisions($region, $circle, $division)
	{
		if (!empty($region)) {
			$this->db->where('mst_circle.region_id', $region);
		}

		if (!empty($circle)) {
			$this->db->where('mst_division.circle_id', $circle);
		}

		if (!empty($division)) {
			$this->db->like('mst_division.division_name', $division);
		}

		$this->db->select('mst_division.division_id, mst_division.division_name, mst_circle.circle_name, mst_region.region_name');
		$this->db->from('mst_division');
		$this->db->join('mst_circle', 'mst_division.circle_id = mst_circle.circle_id', 'INNER');
		$this->db->join('mst_region', 'mst_circle.region_id = mst_region.region_id', 'INNER');

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

	public function saveDivision($division, $circle_id)
	{
		$data = array(
			'division_name' => $division,
			'circle_id' => $circle_id,
			'is_active' => 1, 
			'createdby' => $this->getLoggedInUserID(),
			'createddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->insert('mst_division', $data);

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			return $this->db->affected_rows();
		}
	}

	public function updateDivision($division_id, $division, $circle_id)
	{
		$data = array(
			'division_name' => $division,
			'circle_id' => $circle_id,
			'modifiedby' => $this->getLoggedInUserID(),
			'modifieddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->update('mst_division', $data, array('division_id' => $division_id));

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			return $this->db->affected_rows();
		}
	}

	public function deleteDivisionData($circle_id)
	{
		$data = array(
			'is_active' => 0,
			'deletedby' => $this->getLoggedInUserID(),
			'deleteddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->update('mst_division', $data, array('circle_id' => $circle_id));

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			return $this->db->affected_rows();
		}
	}

	public function deleteDivisionByID($division_id)
	{
		$data = array(
			'is_active' => 0,
			'deletedby' => $this->getLoggedInUserID(),
			'deleteddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->update('mst_division', $data, array('division_id' => $division_id));

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