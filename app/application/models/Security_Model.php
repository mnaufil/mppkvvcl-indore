<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Security_Model extends CI_Model
{
	function __construct()
    {
        parent::__construct();
        
    }


    function loadRoles()
    {
        $this->db->where("is_active", "1");
        $query = $this->db->get("mst_role");
        $result = $query->result();
        return $result;
    }

      function loadUsers()
    {
        $this->db->where("is_active", "1");
        $query = $this->db->get("mst_user");
        $result = $query->result();
        return $result;
    }


    public function adduser($user_name, $user_email, $user_contact, $user_designation, $user_location, $user_role_id, $user_reporting_id, $package_access, $full_site_access)
    {
        $data = array(
            'username' => $user_name,
            'email' => $user_email,
            'password' => md5('Password'),
            'contact_no' => $user_contact,
            'designation' => $user_designation,
            'location' => $user_location,
            'reportingto_user_id' => $user_reporting_id,
            'role_id' => $user_role_id,
            'is_full_data_access' => $full_site_access,
            'package_access' => (!empty($package_access)) ? $package_access : NULL,
            'is_active' => 1,
            'createdby' => $_SESSION['loggedData']->user_id,
            'createddate' => date ('Y-m-d H:i:s')
        );

        $query = $this->db->insert('mst_user', $data);

        if (!$query) {
            $error = $this->db->error();    
            echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
            die();
        } else {
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
    }

    public function checkEmailExists($email)
    {
        $query = $this->db->get_where('mst_user', array('email' => $email, 'is_active' => 1, 'deletedby' => NULL));
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

    public function saveRegionCircleDivision($inserted_user_id, $region, $circle, $division)
    {
        $data = array(
            'user_id' => $inserted_user_id,
            'region_id' => $region,
            'circle_id' => $circle,
            'division_id' => $division
        );

        $query = $this->db->insert('mst_user_data_access', $data);

        if (!$query) {
            $error = $this->db->error();    
            echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
            die();
        } else {            
            return $this->db->affected_rows();
        }
    }


    function loadSiteGrantAccess()
    {

        $this->db->select('mst_region.region_id,mst_region.region_name, mst_circle.circle_id, mst_circle.circle_name, mst_division.division_id, mst_division.division_name');
        //$this->db->where("mst_region.contract_id", $contractID);         
        $this->db->from('mst_region');
        $this->db->join('mst_circle', 'mst_circle.region_id  = mst_region.region_id', 'inner');
        $this->db->join('mst_division', 'mst_division.circle_id  = mst_circle.circle_id', 'inner');

        $query = $this->db->get();
        //echo $this->db->last_query(); die;
        $result = $query->result();
        return $result;
    }


    function loadRegions()
    {
        $this->db->where("is_active", "1");
        $query = $this->db->get("mst_region");
        $result = $query->result();
        return $result;
    }

    function loadCircles()
    {
        $this->db->where("is_active", "1");
        $query = $this->db->get("mst_circle");
        $result = $query->result();
        return $result;
    }

    function loadDivisions()
    {
        $this->db->where("is_active", "1");
        $query = $this->db->get("mst_division");
        $result = $query->result();
        return $result;
    }

    public function loadPackages()
    {
        $this->db->select('package_no');
        $query = $this->db->get_where('contract', array('status_id' => 14));
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

    function userslist()
    {
        $result = [];

        $userName = @$_GET['userName'];
        $userEmail = @$_GET['userEmail'];
        $userRole = @$_GET['userRole'];
        $status = @$_GET['status'];        

        if(!empty($userName))
        {
            $this->db->like("mu1.username", $userName);

            $result['filters']['userName']['label'] = 'Name';
            $result['filters']['userName']['value'] = $userName;
        }

        if(!empty($userEmail))
        {
            $this->db->where("mu1.email", $userEmail);

            $result['filters']['userEmail']['label'] = 'Email';
            $result['filters']['userEmail']['value'] = $userEmail;
        }

        if(!empty($userRole))
        {
            $result['filters']['userRole']['label'] = 'Role';
            $result['filters']['userRole']['value'] = $this->getRole($userRole);
            $result['filters']['userRole']['id'] = $userRole;

            $this->db->where("mu1.role_id", $userRole);            
        }

        if(!empty($status))
        {
            $status_values = [];
            $result['filters']['status']['label'] = 'Status';
            foreach ($status as $key => $value) {
                array_push($status_values, $this->getUserStatus($value));
            }
            $result['filters']['status']['value'] = implode(', ', $status_values);
            $result['filters']['status']['id'] = $status;

            $this->db->where_in("mu1.is_active", $status);
        } else {
            $this->db->where("mu1.is_active", "1");    
        }
        
        // $this->db->where("mst_user.createdby", $_SESSION['loggedData']->user_id);
        //$this->db->where("mst_status.module_id", 18);
        $this->db->select('mu1.*, mu2.username AS reportingto_user_name, mst_role.name as rolename');
        //$this->db->where("mst_region.contract_id", $contractID);         
        $this->db->from('mst_user mu1');
        $this->db->join('mst_role', 'mst_role.role_id  = mu1.role_id', 'inner');
        $this->db->join('mst_user mu2', 'mu1.reportingto_user_id = mu2.user_id', 'LEFT');
       // $this->db->join('mst_status', 'mst_status.status_id  = mst_user.is_active AND mst_status.module_id = 18', 'inner');
        $query = $this->db->get();
        // echo $this->db->last_query(); die;
                
        $result['userslist'] = $query->result();

        return $result;
    }

    function loadSingleUsers($userId)
    {
        $this->db->where("user_id", $userId);
        $query = $this->db->get("mst_user");
        $result = $query->row();
       // print_r($result); die;
        return $result;
    }

    function loadUserData($userId)
    {
        $this->db->where("user_id", $userId);
        $query = $this->db->get("mst_user_data_access");
        $result = $query->result();
       // print_r($result); die;
        return $result;
    }


     function loadSelectedRegions($userId)
    {
        
      
        $this->db->where("user_id", $userId);
        $query = $this->db->get("mst_user_data_access");
        $result = $query->result();
       // print_r($result); die;
        return $result;
    }

    function checkRegionsUsersInData($userId)
    {
        $this->db->where("user_id", $userId);
        $query = $this->db->get("mst_user_data_access");
        $result = $query->result();

        if(!empty($result))
        {
            return true;
        }
        else
        {
            return false;
        }
       // print_r($result); die;
    }

     function checkCirclesUsersInData($userId, $region_id)
    {
        $this->db->where("user_id", $userId);
        $this->db->where("region_id", $region_id);
        $query = $this->db->get("mst_user_data_access");
        $result = $query->result();

        if(!empty($result))
        {
            return true;
        }
        else
        {
            return false;
        }
       // print_r($result); die;
    }


     function loadSelectedCircles($userId, $region_id)
    {
        
        $this->db->where("region_id", $region_id);
        $this->db->where("user_id", $userId);
        $query = $this->db->get("mst_user_data_access");
        $result = $query->result();
       // echo $this->db->last_query(); die;
        echo '<pre>'; 
        print_r($result); die;
        return $result;
    }



    function updateusers()
    {
        $returnArray = array();
        $user_id = $this->input->post('user_id');
        $insertArray = array(
            "username" => $this->input->post('name'),
            "email" => $this->input->post('email'),
            "contact_no" => $this->input->post('contact'),
            "designation" => $this->input->post('designation'),
            "location" => $this->input->post('location'),
            "reportingto_user_id" => $this->input->post('reportingManager'),
            "role_id" => $this->input->post('role'),
            "is_active" => 1,
            "createdby" => $_SESSION['loggedData']->user_id,
            "createddate" => date ('Y-m-d H:i:s')
        );

        $this->db->where("user_id", $user_id);
        $query = $this->db->update("mst_user", $insertArray);
        //echo $this->db->last_query(); die;
        //$last_id = $this->db->insert_id(); 

        if(!$query)
        {
            $this->session->set_flashdata('error','Error in Updating User');
            redirect('users/'.$user_id);
            return;
        }
        else
        {
           // print_r($_POST); die;
            if(isset($_POST['regions']))
            {
                $this->db->where("user_id", $user_id);
                $this->db->delete("mst_user_data_access");
                //die;
            $regionsArray = $_POST['regions'];
                for($i=0;$i<count($regionsArray);$i++)
                {
                    $region =  $regionsArray[$i];
                    $circleArray = $_POST['circles'.$region];
                    for($j=0;$j<count($_POST['circles'.$region]);$j++)
                    {
                        $circle =  $circleArray[$j];
                        $divisionArray =  $_POST['divisions'.$circle];
                        for($k=0;$k<count($_POST['divisions'.$circle]);$k++)
                        {
                            $division = $divisionArray[$k];
                            $insertGrantArray = array(
                                "user_id" => $user_id,
                                "region_id" => $region,
                                "circle_id" => $circle,
                                "division_id" => $division
                            );
                            //$this->db->where("user_id", $user_id);
                            $this->db->insert("mst_user_data_access", $insertGrantArray);
                        }
                    }
                }
               
            }
             return true;
        }


       // return $returnArray;

    }


    function deleteuser($userID)
    {
        $deleteArray = array(
            "is_active"=>0,
            "deletedby" => $_SESSION['loggedData']->user_id,
            "deleteddate" => date ('Y-m-d H:i:s')
        );
        $this->db->where("user_id", $userID);
        $query = $this->db->update("mst_user", $deleteArray);

        //echo $this->db->last_query(); die;
        if($query)
        {
            return true;
        }
        else 
        {
            return false;
        }
        //return $result;
    }

    public function updatePassword($user_id, $password)
    {
        $data = array(
            'password' => md5($password)
        );

        $query = $this->db->update('mst_user', $data, array('user_id' => $user_id));

        if (!$query) {
            $error = $this->db->error();    
            echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
            die();
        } else {
            return $this->db->affected_rows();
        }
    }

    public function getRolesData()
    {
        $this->db->select('role_id, name, is_active');
        $query = $this->db->get_where('mst_role', array('is_active' => 1, 'deletedby' => NULL));
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

    public function getRoleData($role_id)
    {
        $this->db->select('role_id, name, description');
        $query = $this->db->get_where('mst_role', array('role_id' => $role_id));
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

    public function getRoleModuleAccessData($role_id)
    {
        $this->db->select('mst_role_module_access.role_module_access_id, mst_role_module_access.role_id, mst_role_module_access.module_access_id, mst_module_access.access_key');
        $this->db->from('mst_role_module_access');
        $this->db->join('mst_module_access', 'mst_role_module_access.module_access_id = mst_module_access.module_access_id', 'INNER');
        $this->db->where(array('mst_role_module_access.role_id' => $role_id, 'mst_role_module_access.is_active' => 1));

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

    public function getRoleReportAccessData($role_id)
    {
        $this->db->select('mst_role_report_access.role_report_access_id, mst_role_report_access.role_id, mst_role_report_access.report_access_id, mst_report_access.access_key');
        $this->db->from('mst_role_report_access');
        $this->db->join('mst_report_access', 'mst_role_report_access.report_access_id = mst_report_access.report_access_id', 'INNER');
        $this->db->where(array('mst_role_report_access.role_id' => $role_id, 'mst_role_report_access.is_active' => 1));

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

    public function saveRole($role_name, $role_desc)
    {
        $data = array(
            'name' => $role_name,
            'description' => $role_desc,
            'is_active' => 1, 
            'createdby' => $this->getLoggedInUserID(),
            'createddate' => date('Y-m-d H:i:s')
        );

        $query = $this->db->insert('mst_role', $data);

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

    public function updateRole($role_id, $role_name, $role_desc)
    {
        $data = array(
            'name' => $role_name,
            'description' => $role_desc,
            'modifiedby' => $this->getLoggedInUserID(),
            'modifieddate' => date('Y-m-d H:i:s')
        );

        $query = $this->db->update('mst_role', $data, array('role_id' => $role_id));

        if (!$query) {
            $error = $this->db->error();    
            echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
            die();
        } else {
            return $this->db->affected_rows();
        }
    }

    public function saveRoleModuleAccess($role_id, $module_access_id)
    {
        $data = array(
            'role_id' => $role_id,
            'module_access_id' => $module_access_id,
            'is_active' => 1
        );

        $query = $this->db->insert('mst_role_module_access', $data);

        if (!$query) {
            $error = $this->db->error();    
            echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
            die();
        } else {
            return $this->db->affected_rows();
        }
    }

    public function saveRoleReportAccess($role_id, $report_access_id)
    {
        $data = array(
            'role_id' => $role_id,
            'report_access_id' => $report_access_id,
            'is_active' => 1
        );

        $query = $this->db->insert('mst_role_report_access', $data);

        if (!$query) {
            $error = $this->db->error();    
            echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
            die();
        } else {
            return $this->db->affected_rows();
        }
    }

    public function removeRoleModuleAccess($role_id, $module_access_id)
    {
        $data = array('is_active' => 0);

        $query = $this->db->update('mst_role_module_access', $data, array('role_id' => $role_id, 'module_access_id' => $module_access_id));

        if (!$query) {
            $error = $this->db->error();    
            echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
            die();
        } else {
            return $this->db->affected_rows();
        }
    }

    public function removeRoleReportAccess($role_id, $report_access_id)
    {
        $data = array('is_active' => 0);

        $query = $this->db->update('mst_role_report_access', $data, array('role_id' => $role_id, 'report_access_id' => $report_access_id));

        if (!$query) {
            $error = $this->db->error();    
            echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
            die();
        } else {
            return $this->db->affected_rows();
        }   
    }

    public function checkModuleAccess($role_id, $module_access_id)
    {
        $query = $this->db->get_where('mst_role_module_access', array('role_id' => $role_id, 'module_access_id' => $module_access_id, 'is_active' => 1));
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

    public function checkModuleAccessGranted($role_id)
    {
        $query = $this->db->get_where('mst_role_module_access', array('role_id' => $role_id));
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

    public function checkReportAccess($role_id, $report_access_id)
    {
        $query = $this->db->get_where('mst_role_report_access', array('role_id' => $role_id, 'report_access_id' => $report_access_id, 'is_active' => 1));
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

    public function checkReportAccessGranted($role_id)
    {
        $query = $this->db->get_where('mst_role_report_access', array('role_id' => $role_id));
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

    public function deleteAllReportAccess($role_id)
    {
        $query = $this->db->delete('mst_role_report_access', array('role_id' => $role_id));

        if (!$query) {
            $error = $this->db->error();    
            echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
            die();
        } else {
            return $this->db->affected_rows();
        }
    }

    public function deleteAllModuleAccess($role_id)
    {
        $query = $this->db->delete('mst_role_module_access', array('role_id' => $role_id));

        if (!$query) {
            $error = $this->db->error();    
            echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
            die();
        } else {
            return $this->db->affected_rows();
        }   
    }

    public function searchRoles($role_name, $status)
    {
        $this->db->select('role_id, name, is_active');

        if (!empty($role_name)) {
            $this->db->like(array('name' => $role_name));
        }

        if ($status != '') {
            $this->db->where_in('is_active', $status);
        }

        $query = $this->db->get('mst_role');
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

    public function getRole($roleID)
    {
        $this->db->select('name');
        $query = $this->db->get_where('mst_role', array('role_id' => $roleID));
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

                mysqli_next_result($this->db->conn_id);
                $query->free_result();
            }

            return $query_result;
        }
    }

    public function deleteRole($role_id)
    {
        $data = array(
            'is_active' => 0,
            'deletedby' => $this->getLoggedInUserID(),
            'deleteddate' => date('Y-m-d H:i:s')
        );

        $query = $this->db->update('mst_role', $data, array('role_id' => $role_id));

        if (!$query) {
            $error = $this->db->error();    
            echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
            die();
        } else {
            return $this->db->affected_rows();
        }
    }

    public function getModuleList()
    {
        $this->db->select('module_id, name, parent_module_id, seqno');
        $this->db->where(array('is_active' => 1));
        $this->db->order_by('seqno', 'ASC');

        $query = $this->db->get('mst_module');
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

    public function getReportList()
    {
        $this->db->select('name');
        $query = $this->db->get_where('mst_report', array('is_active' => 1));
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

    public function getModuleAccessList()
    {
        $query = $this->db->select('access_key')->get('mst_module_access');
        // echo $this->db->last_query(); die();

        if (!$query) {
            $error = $this->db->error();    
            echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
            die();
        } else {
            $query_result = [];

            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                // echo 'result: <pre>'; print_r($result); echo '</pre>'; die();

                foreach ($result as $key => $value) {
                    $query_result[$key] = $value['access_key'];
                }
            }

            return $query_result;
        }
    }

    public function getModuleAccessID($access_key)
    {
        $this->db->select('module_access_id');
        $query = $this->db->get_where('mst_module_access', array('access_key' => $access_key));
        // echo $this->db->last_query(); die();

        if (!$query) {
            $error = $this->db->error();    
            echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
            die();
        } else {
            $query_result = 0;

            if ($query->num_rows() > 0) {
                $result = $query->row_array();
                $query_result = $result['module_access_id'];
            }

            return $query_result;
        }
    }

    public function getReportAccessID($access_key)
    {
        $this->db->select('report_access_id');
        $query = $this->db->get_where('mst_report_access', array('access_key' => $access_key));
        // echo $this->db->last_query(); die();

        if (!$query) {
            $error = $this->db->error();    
            echo 'Error Code: '.$error['code'].'<br> Error Message: '.$error['message'];
            die();
        } else {
            $query_result = 0;

            if ($query->num_rows() > 0) {
                $result = $query->row_array();
                $query_result = $result['report_access_id'];
            }

            return $query_result;
        }
    }

    public function getUserStatus($status_id)
    {
        $status = '';

        if ($status_id == 1) {
            $status = 'Active';
        } elseif ($status_id == 0) {
            $status = 'In-active';
        }

        return $status;
    }

    public function getLoggedInUserID()
    {
        $userdata = $_SESSION['loggedData'];
        return $userdata->user_id;
    }
}