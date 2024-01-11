<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Security extends CI_Controller
{

	function __construct()
    {
		parent::__construct();

        	$this->load->library('form_validation'); 
        	$this->load->model('Security_Model');
        
        	if(!$this->session->isUserLoggedIn)
        	{ 
             	redirect('login'); 
        	}
	}


	function users()
	{
		$data['access_key']  = $this->uri->segment(1);
		// $data['userslist'] = $this->Security_Model->userslist();	
		$result = $this->Security_Model->userslist();
		$data['userslist'] = $result['userslist'];
		if (isset($result['filters'])) {
			$data['filters'] = $result['filters'];
		}
		$data['roles'] = $this->Security_Model->loadRoles();
		$data['userRole'] = "";
		
		// echo 'data: <pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('security/user/user', $data); 
	}

	function adduserspage()
	{
		$data['roles'] = $this->Security_Model->loadRoles();
		$data['users'] = $this->Security_Model->loadUsers();
		//$data['grantaccess'] = $this->Security_Model->loadSiteGrantAccess();
		$data['regions'] = $this->Security_Model->loadRegions();
		$data['circles'] = $this->Security_Model->loadCircles();
		$data['divisions'] = $this->Security_Model->loadDivisions();
		$data['packages'] = $this->Security_Model->loadPackages();

		// echo 'data: <pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('security/user/add-user', $data);
	}


	public function addusers()
	{
		try
	 	{	
	 		$this->form_validation->set_rules('name', 'Name of User', 'required'); 
			$this->form_validation->set_rules('email', 'Email', 'required'); 
			$this->form_validation->set_rules('contact', 'Contact', 'required'); 
			$this->form_validation->set_rules('designation', 'Designation', 'required'); 
			$this->form_validation->set_rules('location', 'Location', 'required');

			$this->form_validation->set_rules('reportingManager', 'Reporting Manager', 'required');
			$this->form_validation->set_rules('role', 'Role', 'required');

			/*echo '<pre>';
			print_r($_POST); die;*/

			if($this->form_validation->run())
			{
				$return = $this->Security_Model->addusers();
				if($return)
				{
					$this->session->set_flashdata('success','User Added Successfully');
					redirect('users/add');
				}
			}
			else 
			{
					$this->session->set_flashdata('error',validation_errors());
					redirect('users/add');
			}
	 	}

	 	catch (Exception $e)
		{
        		log_message('error: ',$e->getMessage());
        		//return;
		}

	 }




	public function edituserspage($userID)	
	{
		

		/*echo '<pre>';
		print_r($data); die;*/
		$data['singleUser']= $this->Security_Model->loadSingleUsers($userID);
		$data['roles'] = $this->Security_Model->loadRoles();
		$data['users'] = $this->Security_Model->loadUsers();
		//$data['grantaccess'] = $this->Security_Model->loadSiteGrantAccess();
		//$data['regions'] = $this->Security_Model->loadRegions();

		$checkRegionsUsersInData = $this->Security_Model->checkRegionsUsersInData($userID);
		$selectedRegionsArray= array();
		$selectedCirclesArray= array();
		$selectedDivisionsArray= array();
		if($checkRegionsUsersInData) //check for regions in user data access table
		{
			$selectedregions = $this->Security_Model->loadSelectedRegions($userID);
			
			//print_r($selectedregions); die;
			foreach($selectedregions as $region)
			{
				array_push($selectedRegionsArray, $region->region_id);

			}	
			$selectedcircles = $this->Security_Model->loadSelectedRegions($userID);
			foreach($selectedcircles as $circle)
			{
				array_push($selectedCirclesArray, $circle->circle_id);
			}

			$selecteddivisions = $this->Security_Model->loadSelectedRegions($userID);
			foreach($selecteddivisions as $division)
			{
				array_push($selectedDivisionsArray, $division->division_id);
			}
				
		}
		
		
		

		/*echo '<pre>'; 
            print_r(); die;*/
		$data['regions'] = $this->Security_Model->loadRegions($userID);	
		$data['circles'] = $this->Security_Model->loadCircles();
		$data['divisions'] = $this->Security_Model->loadDivisions();
		$data['userdata'] = $this->Security_Model->loadUserData($userID);
		$data['selectedRegionsArray'] = array_unique($selectedRegionsArray);
		$data['selectedCirclesArray'] = array_unique($selectedCirclesArray);
		$data['selectedDivisionsArray'] = array_unique($selectedDivisionsArray);
		$this->load->view('security/user/edit-user', $data);
	}



	public function updateusers()
	{
		try
	 	{	
	 		$this->form_validation->set_rules('name', 'Name of User', 'required'); 
			$this->form_validation->set_rules('email', 'Email', 'required'); 
			$this->form_validation->set_rules('contact', 'Contact', 'required'); 
			$this->form_validation->set_rules('designation', 'Designation', 'required'); 
			$this->form_validation->set_rules('location', 'Location', 'required');

			$this->form_validation->set_rules('reportingManager', 'Reporting Manager', 'required');
			$this->form_validation->set_rules('role', 'Role', 'required');

			/*echo '<pre>';
			print_r($_POST); die;*/
			$user_id = $this->input->post('user_id');
			if($this->form_validation->run())
			{
				$return = $this->Security_Model->updateusers();
				if($return)
				{
					$this->session->set_flashdata('success','User Updated Successfully');
					redirect('users/'.$user_id);
				}
			}
			else 
			{
					$this->session->set_flashdata('error',validation_errors());
					redirect('users/'.$user_id);
			}
	 	}

	 	catch (Exception $e)
		{
        		log_message('error: ',$e->getMessage());
        		//return;
		}

	}


	 public function deleteuser($userID)
	{
		 echo $result = $this->Security_Model->deleteuser($userID);		 
	}

	public function roles()
	{
		$role_list = $this->Security_Model->getRolesData();

		$data['roles'] = $role_list;
		$data['title'] = 'Roles';

		// echo 'data: <pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('security/roles/roles', $data);
	}

	public function searchRoles()
	{
		if (!empty($_POST)) {
			$filter_arr = [];

			$role_name = $this->input->post('roleName');
           	$filter_arr['roleName']['label'] = 'Role';
            $filter_arr['roleName']['value'] = $role_name;

            $status = (isset($_POST['status'])) ? implode(',', $this->input->post('status')) : '';
            $filter_arr['status']['label'] = 'Status';
            $status_values = [];
            if (!empty($status)) {
            	foreach ($this->input->post('status') as $value) {
	            	$status_val = ($value == 1) ? 'Active' : 'Inactive';
	            	array_push($status_values, $status_val);
	            }	
            }
            
            $filter_arr['status']['value'] = (!empty($status_values)) ? implode(', ', $status_values) : '';
            $filter_arr['status']['id'] = $this->input->post('status');

            $search_result = $this->Security_Model->searchRoles($role_name, $status);

            $data['title'] = 'Roles';
            $data['roles'] = $search_result;
            $data['filters'] = $filter_arr;

            // echo '<pre>'; print_r($data); echo '</pre>'; die();
            $this->load->view('security/roles/roles', $data);
		}
	}

	public function addRole()
	{
		$module_list = $this->Security_Model->getModuleList();
		$sorted_module_list = $this->modifyModuleList($module_list);

		$module_access_list = $this->Security_Model->getModuleAccessList();

		$report_list = $this->Security_Model->getReportList();

		$data['module_list'] = $sorted_module_list;
		$data['module_access_list'] = $module_access_list;
		$data['report_list'] = $report_list;
		$data['title'] = 'Roles';

		// echo 'data: <pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('security/roles/add-role', $data);
	}

	public function saveRole()
	{
		$role_name = $this->input->post('roleName');
		$role_desc = $this->input->post('roleDesc');

		$role_result = $this->Security_Model->saveRole($role_name, $role_desc);

		if ($role_result) {
			unset($_POST['roleName']);
			unset($_POST['roleDesc']);

			foreach ($_POST as $key => $value) {
				if (str_contains($key, '_fullaccess')) {
					continue;
				}

				if (str_contains($key, '_view')) {
					if (str_contains($key, '_report')) {
						$report_access_id = $this->Security_Model->getReportAccessID($key);

						if ($report_access_id) {
							$view_report_result = $this->Security_Model->saveRoleReportAccess($role_result, $report_access_id);
						}
					} else {
						$module_access_id = $this->Security_Model->getModuleAccessID($key);

						if ($module_access_id) {
							$view_result = $this->Security_Model->saveRoleModuleAccess($role_result, $module_access_id);
						}
					}
				} elseif (str_contains($key, '_add')) {
					$module_access_id = $this->Security_Model->getModuleAccessID($key);
					if ($module_access_id) {
						$add_result = $this->Security_Model->saveRoleModuleAccess($role_result, $module_access_id);
					}
				} elseif (str_contains($key, '_update')) {
					$module_access_id = $this->Security_Model->getModuleAccessID($key);
					if ($module_access_id) {
						$update_result = $this->Security_Model->saveRoleModuleAccess($role_result, $module_access_id);
					}
				} elseif (str_contains($key, '_delete')) {
					$module_access_id = $this->Security_Model->getModuleAccessID($key);
					if ($module_access_id) {
						$delete_result = $this->Security_Model->saveRoleModuleAccess($role_result, $module_access_id);
					}
				} elseif (str_contains($key, '_download')) {
					if (str_contains($key, '_report')) {
						$report_access_id = $this->Security_Model->getReportAccessID($key);

						if ($report_access_id) {
							$view_report_result = $this->Security_Model->saveRoleReportAccess($role_result, $report_access_id);
						}
					} else {
						$module_access_id = $this->Security_Model->getModuleAccessID($key);
						if ($module_access_id) {
							$download_result = $this->Security_Model->saveRoleModuleAccess($role_result, $module_access_id);
						}	
					}
				}
			}

			// Adding Logout Access
			$key = 'logout_view';
			$module_access_id = $this->Security_Model->getModuleAccessID($key);
			if ($module_access_id) {
				$download_result = $this->Security_Model->saveRoleModuleAccess($role_result, $module_access_id);
			}

			redirect('roles');
		}
	}

	public function editRole($role_id)
	{
		$role_data = $this->Security_Model->getRoleData($role_id);

		$role_module_access_data = $this->Security_Model->getRoleModuleAccessData($role_id);

		$module_access_data = [];
		foreach ($role_module_access_data as $key => $value) {
			array_push($module_access_data, $value['access_key']);
		}

		$role_data['module_access_data'] = $module_access_data;

		$role_report_access_data = $this->Security_Model->getRoleReportAccessData($role_id);
		$report_access_data = [];
		foreach ($role_report_access_data as $key => $value) {
			array_push($report_access_data, $value['access_key']);
		}

		$role_data['report_access_data'] = $report_access_data;

		$module_list = $this->Security_Model->getModuleList();
		$sorted_module_list = $this->modifyModuleList($module_list);

		$module_access_list = $this->Security_Model->getModuleAccessList();

		$report_list = $this->Security_Model->getReportList();

		$data['role_data'] = $role_data;
		$data['module_list'] = $sorted_module_list;
		$data['module_access_list'] = $module_access_list;
		$data['report_list'] = $report_list;		
		$data['title'] = 'Roles';

		// echo 'data: <pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('security/roles/edit-role', $data);
	}

	public function updateRole()
	{
		$role_id = $this->input->post('roleID');
		$role_name = $this->input->post('roleName');
		$role_desc = $this->input->post('roleDesc');
		$access_revoked_modules = $this->input->post('access_revoked_modules');
		$access_revoked_reports = $this->input->post('access_revoked_reports');

		$role_result = $this->Security_Model->updateRole($role_id, $role_name, $role_desc);

		if ($role_result) {
			unset($_POST['roleID']);
			unset($_POST['roleName']);
			unset($_POST['roleDesc']);

			if (!empty($access_revoked_modules)) {
				$access_revoked_modules = explode(',', $access_revoked_modules);

				foreach ($access_revoked_modules as $key => $value) {
					$module_access_id = $this->Security_Model->getModuleAccessID($value);
					$remove_result = $this->Security_Model->removeRoleModuleAccess($role_id, $module_access_id);
				}

				unset($_POST['access_revoked_modules']);
			}

			if (!empty($access_revoked_reports)) {
				$access_revoked_reports = explode(',', $access_revoked_reports);

				foreach ($access_revoked_reports as $key => $value) {
					$report_access_id = $this->Security_Model->getReportAccessID($value);
					$remove_result = $this->Security_Model->removeRoleReportAccess($role_id, $report_access_id);
				}

				unset($_POST['access_revoked_reports']);
			}

			foreach ($_POST as $key => $value) {
				if (str_contains($key, '_fullaccess')) {
					continue;
				}

				if (str_contains($key, '_view')) {
					if (str_contains($key, '_report')) {
						$report_access_id = $this->Security_Model->getReportAccessID($key);

						if ($report_access_id) {
							$check_report_view_result = $this->Security_Model->checkReportAccess($role_id, $report_access_id);

							if (empty($check_report_view_result)) {
								$view_report_result = $this->Security_Model->saveRoleReportAccess($role_id, $report_access_id);
							}
						}
					} else {
						$module_access_id = $this->Security_Model->getModuleAccessID($key);

						if ($module_access_id) {
							$check_view_result = $this->Security_Model->checkModuleAccess($role_id, $module_access_id);

							if (empty($check_view_result)) {
								$view_result = $this->Security_Model->saveRoleModuleAccess($role_id, $module_access_id);
							}	
						}	
					}
				} elseif (str_contains($key, '_add')) {
					$module_access_id = $this->Security_Model->getModuleAccessID($key);

					if ($module_access_id) {
						$check_add_result = $this->Security_Model->checkModuleAccess($role_id, $module_access_id);

						if (empty($check_add_result)) {
							$add_result = $this->Security_Model->saveRoleModuleAccess($role_id, $module_access_id);
						}	
					}
				} elseif (str_contains($key, '_update')) {
					$module_access_id = $this->Security_Model->getModuleAccessID($key);

					if ($module_access_id) {
						$check_update_result = $this->Security_Model->checkModuleAccess($role_id, $module_access_id);

						if (empty($check_update_result)) {
							$update_result = $this->Security_Model->saveRoleModuleAccess($role_id, $module_access_id);
						}	
					}
				} elseif (str_contains($key, '_delete')) {
					$module_access_id = $this->Security_Model->getModuleAccessID($key);

					if ($module_access_id) {
						$check_delete_result = $this->Security_Model->checkModuleAccess($role_id, $module_access_id);

						if (empty($check_delete_result)) {
							$delete_result = $this->Security_Model->saveRoleModuleAccess($role_id, $module_access_id);
						}	
					}
				} elseif (str_contains($key, '_download')) {
					if (str_contains($key, '_report')) {
						$report_access_id = $this->Security_Model->getReportAccessID($key);

						if ($report_access_id) {
							$check_report_download_result = $this->Security_Model->checkReportAccess($role_id, $report_access_id);

							if (empty($check_report_download_result)) {
								$download_report_result = $this->Security_Model->saveRoleReportAccess($role_id, $report_access_id);
							}
						}
					} else {
						$module_access_id = $this->Security_Model->getModuleAccessID($key);

						if ($module_access_id) {
							$check_download_result = $this->Security_Model->checkModuleAccess($role_id, $module_access_id);

							if (empty($check_download_result)) {
								$download_result = $this->Security_Model->saveRoleModuleAccess($role_id, $module_access_id);
							}	
						}	
					}
				}
			}

			redirect('roles');
		}
	}

	public function deleteRole()
	{
		//Default Response
        http_response_code(200);
        $response['message'] = 'Delete Role success';

		if (!empty($_POST)) {
			$role_id = $this->input->post('role_id');

			// Checking if any report access granted
			$report_check = $this->Security_Model->checkReportAccessGranted($role_id);

			if (!empty($report_check)) {
				$report_delete = $this->Security_Model->deleteAllReportAccess($role_id);
			}

			// Deleting module access granted
			$module_check = $this->Security_Model->checkModuleAccessGranted($role_id);

			if (!empty($module_check)) {
				$module_delete = $this->Security_Model->deleteAllModuleAccess($role_id);
			}

			// Deleting Role
			$role_delete = $this->Security_Model->deleteRole($role_id);

			if (!$role_delete) {
				http_response_code(400);
        		$response['message'] = 'Failed to Delete Role';	
			}
		} else {
			http_response_code(400);
        	$response['message'] = 'No Input Provided';
		}

		echo json_encode($response);
	}

	public function modifyModuleList($module_list)
	{
		$modified_module_arr = [];

		for ($i = 0; $i < count($module_list); $i++) {
			for ($j = $i; $j <= count($module_list); $j++) {
				if (isset($module_list[$j]) && ($module_list[$i]['parent_module_id'] == $module_list[$j]['parent_module_id'])) {
					if ($module_list[$i]['name'] == $module_list[$j]['name']) {
						$modified_module_arr[$module_list[$i]['name']] = [];
					} else {
						array_push($modified_module_arr[$module_list[$i]['name']], $module_list[$j]['name']);
						unset($module_list[$j]);
					}
				}
			}

			$module_list = array_values($module_list);
		}

		return $modified_module_arr;
	}


	public function viewChangePassword()
	{
		$data['title'] = 'Change Password';
		$this->load->view('security/change-password/change-password', $data);
	}

	public function saveChangePassword()
	{
		if (!empty($_POST)) {
			$new_password = $this->input->post('newPassword');
			$retype_password = $this->input->post('reTypePassword');

			$user_data = $_SESSION['loggedData'];
			$user_id = $user_data->user_id;			

			//Updating new password
			$result = $this->Security_Model->updatePassword($user_id, $retype_password);
			
			if ($result) {
				$this->session->set_flashdata('success','Password updated successfully');
			} else {
				$this->session->set_flashdata('error','Password update fail');
			}

			redirect('statistics');
		}
	}
}