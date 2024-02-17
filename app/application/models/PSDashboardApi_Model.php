<?php defined('BASEPATH') OR exit('No direct script access allowed');

class PSDashboardApi_Model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	public function validateUser($username, $password)
	{
		$this->db->group_start()->where('username', $username)->or_where('email', $username)->group_end();
		$this->db->where('password', md5($password));

		$query = $this->db->get('mst_user');
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

	public function saveJWTTokenDetails($jwt, $user_id)
	{
		$data = array(
			'createddate' => date('Y-m-d H:i:s'),
			'token' => $jwt,
			'user_id' => $user_id
		);

		$query = $this->db->insert('auth_token', $data);

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			$insert_id = $this->db->insert_id();
			return $insert_id;
		}
	}

	public function updateJWTTokenDetails($jwt, $user_id)
	{
		$data = array(
			'createddate' => date('Y-m-d H:i:s'),
			'token' => $jwt,
			'user_id' => $user_id
		);

		$query = $this->db->update('auth_token', $data, array('user_id' => $user_id));

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			return $this->db->affected_rows();
		}
	}

	public function getUserTokenDetails($user_id, $jwt)
	{
		$query = $this->db->get_where('auth_token', array('user_id' => $user_id, 'token' => $jwt));

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

	public function checkTokenExistsForUser($user_id)
	{
		$query = $this->db->get_where('auth_token', array('user_id' => $user_id));

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

	public function getFeedersData($date, $lot_no)
	{
		$query_result = $this->getMultipleQueryResult("CALL sp_api_physical_verification_data(1, '".$date."', ".$lot_no.")");

		return $query_result;
	}

	public function updateFeederDetails($feeder_id, $charging_status, $estimate_value, $user_id)
	{
		$data = array(
			'charging_status' => $charging_status,
			'estimate_created' => $estimate_value,
			'modifiedby' => $user_id,
			'modifieddate' => date('Y-m-d H:i:s')
		);

		$query = $this->db->update('contract_location', $data, array('feeder_id' => $feeder_id));

		if (!$query) {
			$error = $this->db->error();	
			echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
			die();
		} else {
			return $this->db->affected_rows();
		}
	}

	public function getMultipleQueryResult($query)
	{
		if (empty($query)) {
			return false;
		}

		$index = 0;
		$query_result = [];
		$query_result1 = [];

		// execute multi result query
		if (mysqli_multi_query($this->db->conn_id, $query)) {
			do {				
				if (false != $result = mysqli_store_result($this->db->conn_id)) {

					$rowID = 0;
					while ($row = $result->fetch_assoc()) {
						$query_result1[$rowID] = $row;
						$rowID++;
					}

					$query_result[$index] = $query_result1;
				}

				$index++;
			} while (mysqli_next_result($this->db->conn_id));
		}

		return $query_result;
	}
}

?>