<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class TypeofWorkActivities extends CI_Controller
{	
	function __construct()
	{
		parent::__construct();

		$this->load->model('TypeofWorkActivities_Model', 'twa_model');

		if (!$this->session->isUserLoggedIn) {
			redirect('login'); 
		}
	}

	public function index()
	{
		$typeofwork_data = $this->twa_model->getTypeOfWorkList();

		$user_access_data = $this->twa_model->getUserModuleAccess();
        $user_access = $this->sortUserModuleAccess($user_access_data);

		$data['typeofwork_data'] = $typeofwork_data;
		$data['user_access'] = $user_access;
		$data['title'] = 'Type Of Work - Activities';
		$this->load->view('setup/activities/work-type-activities', $data);
	}

	public function addActivity($typeofwork_id)
	{
		$typeofwork_name = $this->twa_model->getTypeOfWorkName($typeofwork_id);
		$typeofwork_activities_groups = $this->twa_model->getAllTypeOfWorkActivityGroups();
		$typeofwork_activities_data = $this->twa_model->getTypeOfWorkActivities($typeofwork_id);

		$activity_data_withBOQ = [];
		$activity_data_withoutBOQ = [];
		$mode = 'add';

		if (!empty($typeofwork_activities_data)) {
			foreach ($typeofwork_activities_data as $key => $value) {
				$observations_arr = [];
				
				$obs_length = (count($value['observations']) > 2) ? 2 : count($value['observations']);
				for ($i = 0; $i < $obs_length; $i++) {
					array_push($observations_arr, $value['observations'][$i]['observation_name']);
				}

				$value['observations_str'] = implode(', ', $observations_arr);

				if ($value['is_boq'] == 0) {
					array_push($activity_data_withoutBOQ, $value);
				} else {
					array_push($activity_data_withBOQ, $value);
				}
			}

			$mode = 'update';
		}		

		$activity_group_withBOQ = [];
		$activity_group_withoutBOQ = [];
		foreach ($typeofwork_activities_groups as $key => $value) {
			if ($value['is_boq'] == 0) {
				array_push($activity_group_withoutBOQ, $value);
			} else {
				array_push($activity_group_withBOQ, $value);
			}
		}

		$data['typeofwork_name'] = $typeofwork_name;
		$data['activity_data_withBOQ'] = $activity_data_withBOQ;
		$data['activity_data_withoutBOQ'] = $activity_data_withoutBOQ;
		$data['activity_group_withBOQ'] = $activity_group_withBOQ;
		$data['activity_group_withoutBOQ'] = $activity_group_withoutBOQ;
		$data['mode'] = $mode;

		// echo '<pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('setup/activities/add-activity', $data);
	}

	public function saveActivityGroup()
	{
		//Default Response
        http_response_code(400);
        $response['message'] = 'Activity Group not saved';

		if (!empty($_POST)) {
			$new_activity_group = $this->input->post('new_activity_group');
			$activity_type = $this->input->post('activity_type');

			$activity_type = ($activity_type == 'withoutBOQ') ? 0 : 1;
			$result = $this->twa_model->saveActivityGroup($new_activity_group, $activity_type);

			if ($result) {
				http_response_code(200);
				$response['message'] = 'Activity Group saved';
			}
		}

		echo json_encode($response);
	}

	public function deleteTypeofWorkActivity()
	{
		//Default Response
        http_response_code(400);
        $response['message'] = 'Activity not deleted';

        if (!empty($_POST)) {
        	$typeofwork_activity_id = $this->input->post('typeofwork_activity_id');

        	$activity_del_result = $this->twa_model->deleteTypeofWorkActivity($typeofwork_activity_id);

        	if ($activity_del_result) {
        		$activity_obs_del_result = $this->twa_model->deleteTypeofWorkActivityOptions($typeofwork_activity_id);

        		if ($activity_obs_del_result) {
        			http_response_code(200);
					$response['message'] = 'Activity deleted';	
        		}
        	}
        }

        echo json_encode($response);
	}

	public function saveTypeofWorkActivities()
	{
		//Default Response
        http_response_code(200);
        $response['message'] = 'Save Activities success';

		if (!empty($_POST)) {
			$typeofwork_name = $this->input->post('typeofwork_name');
			$data_withoutBOQ = $this->input->post('data_withoutBOQ');
			$data_withBOQ = $this->input->post('data_withBOQ');

			//Getting typeofwork data
			$typeofwork_data = $this->twa_model->getTypeOfWorkData($typeofwork_name);
			$typeofwork_id = $typeofwork_data['typeofwork_id'];
			$typeofwork_unit_id = $typeofwork_data['unit_id'];

			if (isset($data_withoutBOQ) && !empty($data_withoutBOQ)) {
				foreach ($data_withoutBOQ as $key => $value) {
					foreach ($value as $k1 => $v1) {						
						$activity_group_id = $this->twa_model->getActivityGroupID($v1[0]['activity_group']);
						$typeofwork_activity_id = $this->twa_model->insertActivity($typeofwork_id, $activity_group_id, $typeofwork_unit_id, $v1[0]['seqno'], $v1[0]['activity_name'], $v1[0]['dashboard_head'], $v1[0]['weightage'], $v1[0]['report_head'], NULL, $v1[0]['item_code'], $v1[0]['erp_item_name']);

						if ($typeofwork_activity_id) {
							if (!empty($v1[0]['observations'])) {
								$observations_arr = $v1[0]['observations'];
								foreach ($observations_arr as $obs_key => $obs_val) {
									$result = $this->twa_model->insertActivityOptions($typeofwork_activity_id, $obs_val);	
								}
							}
						} else {
							http_response_code(400);
                         	$response['message'] = 'Activity Save Failed';
						}
					}
				}
			}

			if (isset($data_withBOQ) && !empty($data_withBOQ)) {
				foreach ($data_withBOQ as $key => $value) {
					foreach ($value as $k1 => $v1) {
						$activity_group_id = $this->twa_model->getActivityGroupID($v1[0]['activity_group']);
						$typeofwork_activity_id = $this->twa_model->insertActivity($typeofwork_id, $activity_group_id, $typeofwork_unit_id, $v1[0]['seqno'], $v1[0]['activity_name'], $v1[0]['dashboard_head'], NULL, $v1[0]['report_head'], $v1[0]['multiply_factor'], $v1[0]['item_code'], $v1[0]['erp_item_name']);

						if ($typeofwork_activity_id) {
							if (!empty($v1[0]['observations'])) {
								$observations_arr = $v1[0]['observations'];
								foreach ($observations_arr as $obs_key => $obs_val) {
									$result = $this->twa_model->insertActivityOptions($typeofwork_activity_id, $obs_val);	
								}
							}
						} else {
							http_response_code(400);
                         	$response['message'] = 'Activity Save Failed';
						}
					}
				}
			}
		} else {
			http_response_code(200);
        	$response['message'] = 'Save Activities failed';
		}

		echo json_encode($response);
	}

	public function updateTypeofWorkActivities()
	{
		//Default Response
        http_response_code(200);
        $response['message'] = 'Update Activities success';

        if (!empty($_POST)) {
        	$typeofwork_name = $this->input->post('typeofwork_name');
        	$data_withoutBOQ = $this->input->post('data_withoutBOQ');
			$data_withBOQ = $this->input->post('data_withBOQ');

			if (isset($data_withoutBOQ) && !empty($data_withoutBOQ)) {
				foreach ($data_withoutBOQ as $key => $value) {
					foreach ($value as $k1 => $v1) {
						//Check if activity already exists
						if (!empty($v1[0]['activity_id'])) {
							$activity_group_id = $this->twa_model->getActivityGroupID($v1[0]['activity_group']);

							/*Update existing activity*/
							$update_activity_result = $this->twa_model->updateActivity($v1[0]['activity_id'], $activity_group_id, $v1[0]['seqno'], $v1[0]['activity_name'], $v1[0]['dashboard_head'], $v1[0]['weightage'], $v1[0]['report_head'], NULL, $v1[0]['item_code'], $v1[0]['erp_item_name']);

							if ($update_activity_result) {
								if (!empty($v1[0]['observations'])) {
									//Check if observations exists
									$check_observations = $this->twa_model->checkTypeofWorkActivityOptionsExists($v1[0]['activity_id']);
									
									if ($check_observations) {
										//Delete existing observations
										$del_obs_result = $this->twa_model->deleteTypeofWorkActivityOptions($v1[0]['activity_id']);

										if ($del_obs_result) {
											//Inserting observations
											foreach ($v1[0]['observations'] as $obs_key => $obs_value) {
												$this->twa_model->insertActivityOptions($v1[0]['activity_id'], $obs_value);
											}
										}
									}
								}
							} else {
								http_response_code(200);
        						$response['message'] = 'Update Activities failed';
							}
						} else {
							/*Save new activity*/
							//Getting typeofwork data
							$typeofwork_data = $this->twa_model->getTypeOfWorkData($typeofwork_name);
							$typeofwork_id = $typeofwork_data['typeofwork_id'];
							$typeofwork_unit_id = $typeofwork_data['unit_id'];

							$activity_group_id = $this->twa_model->getActivityGroupID($v1[0]['activity_group']);
							$typeofwork_activity_id = $this->twa_model->insertActivity($typeofwork_id, $activity_group_id, $typeofwork_unit_id, $v1[0]['seqno'], $v1[0]['activity_name'], $v1[0]['dashboard_head'], $v1[0]['weightage'], $v1[0]['report_head'], NULL, $v1[0]['item_code'], $v1[0]['erp_item_name']);

							if ($typeofwork_activity_id) {
								if (!empty($v1[0]['observations'])) {
									foreach ($v1[0]['observations'] as $obs_key => $obs_val) {
										$result = $this->twa_model->insertActivityOptions($typeofwork_activity_id, $obs_val);	
									}
								}
							} else {
								http_response_code(200);
        						$response['message'] = 'Update Activities failed';
							}
						};
					}
				}
			}

			if (isset($data_withBOQ) && !empty($data_withBOQ)) {
				foreach ($data_withBOQ as $key => $value) {
					foreach ($value as $k1 => $v1) {
						//Check if activity already exists
						if (!empty($v1[0]['activity_id'])) {
							$activity_group_id = $this->twa_model->getActivityGroupID($v1[0]['activity_group']);

							/*Update existing activity*/
							$update_activity_result = $this->twa_model->updateActivity($v1[0]['activity_id'], $activity_group_id, $v1[0]['seqno'], $v1[0]['activity_name'], $v1[0]['dashboard_head'], NULL, $v1[0]['report_head'], $v1[0]['multiply_factor'], $v1[0]['item_code'], $v1[0]['erp_item_name']);

							if ($update_activity_result) {
								if (!empty($v1[0]['observations'])) {
									//Check if observations exists
									$check_observations = $this->twa_model->checkTypeofWorkActivityOptionsExists($v1[0]['activity_id']);
									
									if ($check_observations) {
										//Delete existing observations
										$del_obs_result = $this->twa_model->deleteTypeofWorkActivityOptions($v1[0]['activity_id']);

										if ($del_obs_result) {
											//Inserting observations
											foreach ($v1[0]['observations'] as $obs_key => $obs_value) {
												$this->twa_model->insertActivityOptions($v1[0]['activity_id'], $obs_value);
											}
										}
									}
								}
							}
						} else {
							/*Save new activity*/
							//Getting typeofwork data
							$typeofwork_data = $this->twa_model->getTypeOfWorkData($typeofwork_name);
							$typeofwork_id = $typeofwork_data['typeofwork_id'];
							$typeofwork_unit_id = $typeofwork_data['unit_id'];

							$activity_group_id = $this->twa_model->getActivityGroupID($v1[0]['activity_group']);
							$typeofwork_activity_id = $this->twa_model->insertActivity($typeofwork_id, $activity_group_id, $typeofwork_unit_id, $v1[0]['seqno'], $v1[0]['activity_name'], $v1[0]['dashboard_head'], $v1[0]['weightage'], $v1[0]['report_head'], NULL, $v1[0]['item_code'], $v1[0]['erp_item_name']);

							if ($typeofwork_activity_id) {
								if (!empty($v1[0]['observations'])) {
									foreach ($v1[0]['observations'] as $obs_key => $obs_val) {
										$result = $this->twa_model->insertActivityOptions($typeofwork_activity_id, $obs_val);	
									}
								}
							}
						}
					}
				}
			}
        } else {
        	http_response_code(200);
        	$response['message'] = 'Update Activities failed';
        }

        echo json_encode($response);
	}

	public function sortUserModuleAccess($user_access_data)
	{
		$user_access = [];
          	foreach ($user_access_data as $key => $value) {
               	switch ($value['event']) {
                    case 'view':
                        $user_access['view'] = 1;
                        break;
                    case 'update':
                        $user_access['update'] = 1;
                        break;
                    case 'download':
                        $user_access['download'] = 1;
                        break;
                    case 'add':
                        $user_access['add'] = 1;
                        break;
                    case 'delete':
                        $user_access['delete'] = 1;
                        break;                    
                    default:
                        break;
               	}
          	}

        return $user_access;
	}
}


?>