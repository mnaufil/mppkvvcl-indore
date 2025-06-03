<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Region_Model extends CI_Model
{	
	function __construct()
	{
		parent::__construct();
	}

	public function getRegionList()
	{
		$this->db->select('region_id, region_name');
		$query = $this->db->get_where('mst_region', array('is_active' => 1, 'deletedby' => NULL));
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

	public function getRegionData($region_id)
	{
		$this->db->select('region_id, region_name');
		$query = $this->db->get_where('mst_region', array('region_id' => $region_id));
		// echo $this->db->last_query(); die();

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$query_result = [];

			if ($query->num_rows() > 0) {
				$query_result = $query->row_array();				

				// Check if the region has circles added
				$query_result['circle_data'] = $this->getCircleData($region_id);
			}

			return $query_result;
		}
	}

	public function getRegionName($region_id)
	{
		$this->db->select('region_name');
		$query = $this->db->get_where('mst_region', array('region_id' => $region_id));

		if (!$query) {
			$error = $this->db->error();
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$query_result = '';

			if ($query->num_rows() > 0) {
				$result = $query->row_array();

				$query_result = $result['region_name'];
			}

			return $query_result;
		}
	}

	public function saveRegion($region)
	{
		$data = array(
			'region_name' => $region,
			'is_active' => 1,
			'createdby' => $this->getLoggedInUserID(),
			'createddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->insert('mst_region', $data);

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			if ($this->db->affected_rows() > 0) {
				return $this->db->insert_id();	
			} else {
				return 0;
			}
		}
	}

	public function updateRegion($region_id, $region)
	{
		$data = array(
			'region_name' => $region,
			'modifiedby' => $this->getLoggedInUserID(),
			'modifieddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->update('mst_region', $data, array('region_id' => $region_id));

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			return $this->db->affected_rows();
		}
	}

	public function deleteRegion($region_id)
	{
		$data = array(
			'is_active' => 0,
			'deletedby' => $this->getLoggedInUserID(),
			'deleteddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->update('mst_region', $data, array('region_id' => $region_id));

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			return $this->db->affected_rows();
		}
	}

	public function getCircleData($region_id)
	{		
		$this->db->select('circle_id, circle_name');
		$query = $this->db->get_where('mst_circle', array('region_id' => $region_id, 'is_active' => 1, 'deletedby' => NULL));
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
					$query_result[$value['circle_id']] = $value['circle_name'];
				}
			}

			return $query_result;
		}
	}

	public function getLoggedInUserID()
	{
		$userdata = $_SESSION['loggedData'];
		return $userdata->user_id;
	}

	function __destruct()
    {
    	if (isset($this->db)) {
            $this->db->close(); // Explicitly close the DB connection
        }
    }
}



?>