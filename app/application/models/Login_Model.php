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
	/* 	$this->db->where('mrma.is_active', 1);
		$this->db->where('mrma.role_id', $roleId);
		$this->db->group_by('mma.module_id');
		$this->db->select('mm.module_id as menu_id, mm.name as menu_name, mm.parent_module_id, mma.access_key, mma.event, ');
		$this->db->from('mst_role_module_access mrma');
		$this->db->join('mst_module_access mma', 'mma.module_access_id = mrma.module_access_id');
		$this->db->join('mst_module mm', 'mm.module_id = mma.module_id');
		$query = $this->db->get(); */
		$query = $this->db->query("SELECT  mst_role_module_access.role_id, mst_role_module_access.module_access_id,
                mst_module_access.module_id, mst_module_access.access_key, mst_module_access.event,
                mst_module.name, mst_module.parent_module_id,mst_module.seqno,b.name as parent_menu_name
FROM    mst_role_module_access
INNER JOIN      mst_module_access
ON              mst_role_module_access.module_access_id = mst_module_access.module_access_id
INNER JOIN      mst_module
ON              mst_module_access.module_id = mst_module.module_id
INNER JOIN mst_module b
ON b.module_id=mst_module.parent_module_id
WHERE   mst_role_module_access.role_id = $roleId AND mst_role_module_access.is_active = 1 AND mst_module_access.is_active = 1 ORDER BY mst_module.seqno ASC");
		// echo $this->db->last_query(); die();
		//echo '<pre>';
		//print_r($query->result()); die("END");
		return $query->result();		


	}


	function allModule()
	{
			$query = $this->db->query("select name,  count(parent_module_id) as parent_module_id, seqno from mst_module where is_active =1 group by parent_module_id");
			return $query->result();	
	}
	function allIcon()
	{
			$query = $this->db->query("select name, icon,  count(parent_module_id) as parent_module_id from mst_module where is_active =1 group by parent_module_id");
			return $query->result();	
	}


	 function totalDisburse()
    {
        //$query = $this->db->query("CALL sp_get_dashboard_statistics($mileStoneId, 1)");
        $query = $this->db->query("CALL sp_dashboard_insights(1)");
        //print_r($query->result()); die;
        if($query)
        {
             return $query->result();
        }
       
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
}