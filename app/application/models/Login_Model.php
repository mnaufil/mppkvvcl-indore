<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Login_Model extends CI_Model
{
	function __construct()
    {
        parent::__construct();
    }

	public function index($email,$password)
	{
	 	try
	 	{
			$returnArray = array();
		    /*$data = array(
				'username'=> $email,
				'password' => md5($password)
			);*/
			
			$this->db->group_start()->where('username', $email)->or_where('email', $email)->group_end();
			$this->db->where('password', md5($password));

			$query = $this->db->get('mst_user');
			
			$db_error = $this->db->error();			
			
			//if (!empty($db_error)) {
			if (!empty($db_error['message'])) {
            	throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
            	return false; // unreachable retrun statement !!!
        	}

			/*if($login != NULL)
			{
				return $login->row();
		 	}*/

		 	//Instead of checking for NULL, we can check returned num_rows
		 	if ($query->num_rows() > 0) {
				//check for roles
				$loggedUser = $query->row();
				$roles = $this->checkRoles($loggedUser->role_id);
				$returnArray['roles'] = $roles;
				$returnArray['userdetails'] = $query->row();
				$returnArray['message'] = "Login Successfull";
				$returnArray['status'] = 200;
		 	 	//return $query->row();
				return $returnArray;
		 	}
		 	else
		 	{
		 		$returnArray['message'] = "Invalid Login Credentials";
				$returnArray['status'] = 500;
				return $returnArray;
		 	}
		}
		catch (Exception $e)
		{
			// this will not catch DB related errors. But it will include them, because this is more general. 
        	log_message('error: ',$e->getMessage());
        	return;
		}
	}
	
	public function checkRoles($roleId)
	{
	 	/*$this->db->where('mrma.is_active', 1);
		$this->db->where('mrma.role_id', $roleId);
		$this->db->group_by('mma.module_id');
		$this->db->select('mm.module_id as menu_id, mm.name as menu_name, mm.parent_module_id, mma.access_key, mma.event, ');
		$this->db->from('mst_role_module_access mrma');
		$this->db->join('mst_module_access mma', 'mma.module_access_id = mrma.module_access_id');
		$this->db->join('mst_module mm', 'mm.module_id = mma.module_id');
		$query = $this->db->get(); */
		$query = $this->db->query("SELECT mst_role_module_access.role_id, mst_role_module_access.module_access_id, mst_module_access.module_id, mst_module_access.access_key, mst_module_access.event, mst_module.name, mst_module.parent_module_id, mst_module.seqno, b.name as parent_menu_name FROM mst_role_module_access INNER JOIN mst_module_access ON mst_role_module_access.module_access_id = mst_module_access.module_access_id INNER JOIN mst_module ON mst_module_access.module_id = mst_module.module_id INNER JOIN mst_module b ON b.module_id = mst_module.parent_module_id WHERE mst_role_module_access.role_id = $roleId AND mst_role_module_access.is_active = 1 AND mst_module_access.is_active = 1 ORDER BY mst_module.seqno ASC");
		return $query->result();
	}

	function allModule()
	{
		// $query = $this->db->query("select name,  count(parent_module_id) as parent_module_id, seqno from mst_module where is_active =1 group by parent_module_id");
		// $query = $this->db->query("select name,  count(parent_module_id) as parent_module_id, seqno from mst_module where is_active =1 group by name, seqno");

		$this->db->select('A.name, A.parent_module_id, A.seqno, B.name as parent_name');
		$this->db->from('mst_module A');
		$this->db->join('mst_module B', 'A.parent_module_id = B.module_id', 'INNER');
		$this->db->where(array('A.is_active' => 1));

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

				$new_result = [];
				foreach ($result as $key => $value) {
					$new_result[$value['parent_name']][] = $value;
				}

				foreach ($new_result as $key => $value) {
					$query_result_temp['name'] = $key;
					$query_result_temp['parent_module_id'] = count($value);
					$query_result_temp['seqno'] = $value[0]['seqno'];

					array_push($query_result, $query_result_temp);
				}
			}
		}
		
		// return $query->result();
		return $query_result;	
	}

	function allIcon()
	{
		// $query = $this->db->query("select name, icon,  count(parent_module_id) as parent_module_id from mst_module where is_active =1 group by parent_module_id");
		// $query = $this->db->query("select name, icon,  count(parent_module_id) as parent_module_id from mst_module where is_active =1 group by name, icon");

		$this->db->select('A.name, A.parent_module_id, A.icon, B.name as parent_name');
		$this->db->from('mst_module A');
		$this->db->join('mst_module B', 'A.parent_module_id = B.module_id', 'INNER');
		$this->db->where(array('A.is_active' => 1));

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

				$new_result = [];
				foreach ($result as $key => $value) {
					$new_result[$value['parent_name']][] = $value;
				}

				foreach ($new_result as $key => $value) {
					$query_result_temp['name'] = $key;
					$query_result_temp['icon'] = $value[0]['icon'];
					$query_result_temp['parent_module_id'] = count($value);

					array_push($query_result, $query_result_temp);
				}
			}
		}

		// return $query->result();	
		return $query_result;	
	}

	function totalDisburse()
    {
        //$query = $this->db->query("CALL sp_get_dashboard_statistics($mileStoneId, 1)");
        // $query = $this->db->query("CALL sp_dashboard_insights(1)"); //Original SP
        // $query = $this->db->query("CALL bkp_020824_sp_dashboard_insights(1)");
        // $query = $this->getMultipleQueryResult("CALL sp_dashboard_insights(1)"); //Original SP Call
        $query = $this->getMultipleQueryResult("CALL bkp_activity_price_sp_dashboard_insights(1)"); //Currently used SP
        // echo 'query: <pre>'; print_r($query); echo '</pre>'; die();

        /*if($query)
        {
            return $query->result();
        }*/
        return $query;
    }

    function getRegionCircleDivisionWiseAccess($userId)
    {
    	$this->db->where("user_id", $userId);
    	$query = $this->db->get("mst_user_data_access");
    	$result = $query->result();
    	$region = array();
    	$circle = array();
    	$division = array();
    	foreach ($result as $key) {

    		array_push($region, $key->region_id);
    		array_push($circle, $key->circle_id);
    		array_push($division, $key->division_id);
    	}
    	$this->session->set_userdata('myRegions',array_unique($region));
		$this->session->set_userdata('myCircles',array_unique($circle));
		$this->session->set_userdata('myDivision',array_unique($division));    	
    }

    public function getRoleNameByRoleID($role_id)
    {
    	$this->db->select('name');
    	$query = $this->db->get_where('mst_role', array('role_id' => $role_id));
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

    public function getMobileAPKDetails()
    {
    	$this->db->select('display_name, fieldvalue');
    	$query = $this->db->get_where('sysconfig', array('module' => 'Mobile APK'));
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

					// $rowID = 0;
					while ($row = $result->fetch_assoc()) {
						// $query_result1[$rowID] = $row;
						$query_result1 = $row;
						// $rowID++;
					}

					$query_result[$index] = $query_result1;
				}

				$index++;
			} while (mysqli_next_result($this->db->conn_id));
		}

		return $query_result;
	}

	function __destruct()
    {
    	if (isset($this->db)) {
            $this->db->close(); // Explicitly close the DB connection
        }
    }
}