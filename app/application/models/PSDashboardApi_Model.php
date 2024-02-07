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

	public function getFeedersData($date, $lot_no)
	{
		$query = $this->db->query("CALL sp_api_physical_verification_data(1, '".$date."', ".$lot_no.")");
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