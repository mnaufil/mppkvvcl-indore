<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Circle_Model extends CI_Model
{	
	function __construct()
	{
		parent::__construct();
	}

	public function getCircleList()
	{
		$this->db->select('mst_circle.circle_id, mst_circle.circle_name, mst_region.region_name');
		$this->db->from('mst_circle');
		$this->db->join('mst_region', 'mst_circle.region_id = mst_region.region_id', 'INNER');
		$this->db->where(array('mst_circle.is_active' => 1, 'mst_circle.deletedby' => NULL));

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

	public function getCircleData($circle_id)
	{
		$this->db->select('mst_circle.circle_id, mst_circle.circle_name, mst_circle.region_id, mst_region.region_name');
		$this->db->from('mst_circle');
		$this->db->join('mst_region', 'mst_circle.region_id = mst_region.region_id', 'INNER');
		$this->db->where(array('mst_circle.circle_id' => $circle_id));

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

	public function searchCircles($region_id, $circle)
	{
		if (!empty($region_id)) {
			$this->db->where('mst_circle.region_id', $region_id);
		}

		if (!empty($circle)) {
			$this->db->like('mst_circle.circle_name', $circle);
		}

		$this->db->select('mst_circle.circle_id, mst_circle.circle_name, mst_region.region_name');
		$this->db->from('mst_circle');
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

	public function saveCircle($circle, $region_id)
	{
		$data = array(
			'circle_name' => $circle,
			'region_id' => $region_id,
			'is_active' => 1, 
			'createdby' => $this->getLoggedInUserID(),
			'createddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->insert('mst_circle', $data);

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			return $this->db->affected_rows();
		}
	}

	public function updateCircle($circle_id, $circle, $region_id)
	{
		$data = array(
			'circle_name' => $circle,
			'region_id' => $region_id,
			'modifiedby' => $this->getLoggedInUserID(),
			'modifieddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->update('mst_circle', $data, array('circle_id' => $circle_id));

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			return $this->db->affected_rows();
		}
	}

	public function deleteCircle($circle_id)
	{
		$data = array(
			'is_active' => 0,
			'deletedby' => $this->getLoggedInUserID(),
			'deleteddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->update('mst_circle', $data, array('circle_id' => $circle_id));

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			return $this->db->affected_rows();
		}
	}

	public function getCircleName($circle_id)
	{
		$this->db->select('circle_name');
		$query = $this->db->get_where('mst_circle', array('circle_id' => $circle_id));

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$query_result = '';

			if ($query->num_rows() > 0) {
				$result = $query->row_array();

				$query_result = $result['circle_name'];
			}

			return $query_result;
		}
	}

	public function getDivisionData($circle_id)
	{
		$query = $this->db->get_where('mst_division', array('circle_id' => $circle_id));

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