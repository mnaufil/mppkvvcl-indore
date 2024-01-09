<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Login extends CI_Controller
{
	function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation'); 
        $this->load->model('Login_Model'); 

        if($this->session->isUserLoggedIn)
        { 
            redirect('dashboard');
        }
    }

    public function index()
    { 
        
	}

	public function login()
	{
		$this->load->view('login/login'); 
	}

	public function checklogin()
	{
		try 
		{
			$this->form_validation->set_rules('email', 'Email', 'required'); 
			$this->form_validation->set_rules('password', 'password', 'required'); 

			if($this->form_validation->run())
			{
				$email = $this->input->post('email');
				$password = $this->input->post('password');

				$validate = $this->Login_Model->index($email,$password);
				$access = $this->Login_Model->getRegionCircleDivisionWiseAccess($validate['userdetails']->user_id);
				/*echo '<pre>';
				print_r($access); die;*/
				

				$allModule = $this->Login_Model->allModule();
				$allIcon = $this->Login_Model->allIcon();
				$allIconArray = array();
				foreach($allIcon as $icon)
				{
					//array_push($allIconArray, $icon->icon);
					
					$allIconArray[$icon->name] = $icon->icon;
				}
				$allModuleArray = array();
				foreach($allModule as $all)
				{
					if($all->parent_module_id==1)
					{
						array_push($allModuleArray, $all->name);
					}
				}

				/*if(!empty($validate))*/
				if($validate['status']==200)
				{
					$this->session->set_userdata('userId',$validate['userdetails']->user_id);	
					$this->session->set_userdata('username',$validate['userdetails']->username);	
					$this->session->set_userdata('isUserLoggedIn',TRUE);
					$this->session->set_userdata('loggedData',$validate['userdetails']);
					$rolesData = $validate['roles'];
					$menuArray = array();
					$moduleAccess = array();
					for($i=0;$i<count($rolesData)-1;$i++)
					{
						$role = $rolesData[$i]->access_key;
						/******code for user module********/

						//$moduleAccess[$strReplaceWithUnderscores] = $rolesData[$i]->event;
						array_push($moduleAccess, $rolesData[$i]->access_key);

						/******code for user module********/

						if(!empty($role))
						{
							$explode = explode("_", $role);
							//$strReplace = str_replace("_", "-", $explode[0]);
							$strReplaceWithUnderscores = strrev(explode('_', strrev($role), 2)[1]);
							$strReplace = str_replace("_", "-", $strReplaceWithUnderscores);
							$rolesData[$i]->menu_url = $strReplace;
						}
						
						array_push($menuArray, $rolesData[$i]->parent_menu_name);						
					}

					$this->session->set_userdata('menusData', array_unique($menuArray));
					$this->session->set_userdata('iconData', $allIconArray);		
					$this->session->set_userdata('rolesData',$rolesData);
					$this->session->set_userdata('moduleAccess',$moduleAccess);		
					$this->session->set_userdata('allModuleArray',$allModuleArray);	
					$data['totalDisburse'] = $this->Login_Model->totalDisburse();

					$this->session->set_userdata('totalData', $data['totalDisburse']);
        			//$totalData = $this->session->totalData;
					// echo '<pre>'; print_r($_SESSION); echo '</pre>'; die();
					redirect('statistics');
				}
				else
				{
					$this->session->set_flashdata('error','Invalid login. Please try again.');
					redirect('login');
				}
			}
		}
		catch (Exception $e)
		{
			//log_message('debug: ',$e->getMessage());
			$this->session->set_flashdata('error',$e->getMessage());
		}
    }
}