<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Region extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('Region_Model', 'region_model');
		$this->load->model('Circle_Model', 'circle_model');
		$this->load->model('Division_Model', 'division_model');
	}

	public function index()
	{
		$data['regions'] = $this->region_model->getRegionList();
		$data['title'] = 'Regions';

		$this->load->view('setup/region/regions', $data);
	}

	public function editRegion($region_id)
	{
		$region_data = $this->region_model->getRegionData($region_id);

		$data['region_data'] = $region_data;
		$data['title'] = 'Regions';

		// echo 'data: <pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('setup/region/edit-region', $data);
	}

	public function addRegion()
	{
		$data['title'] = 'Regions';
		$this->load->view('setup/region/add-region', $data);
	}

	public function saveRegion()
	{
		//Default Response
        http_response_code(200);
        $response['message'] = 'Save Region success';

		if (!empty($_POST)) {
			$region = $this->input->post('regionName');
			$circles = isset($_POST['circle']) ? $this->input->post('circle') : [];

			$result = $this->region_model->saveRegion($region);

			if ($result) {
				if (!empty($circles)) {
					$region_id = $result;

					foreach ($circles as $key => $value) {
						$this->circle_model->saveCircle($value, $region_id);
					}
				}
			} else {
				http_response_code(400);
        		$response['message'] = 'Failed to save Region';
			}
		} else {
			http_response_code(400);
        	$response['message'] = 'No Input Provided';
		}

		echo json_encode($response);
	}

	public function updateRegion()
	{
		//Default Response
        http_response_code(200);
        $response['message'] = 'Update Region success';

		if (!empty($_POST)) {
			$region_id = $this->input->post('regionID');
			$region = $this->input->post('regionName');

			$deleted_circle_ids = isset($_POST['deleted_circle']) ? $this->input->post('deleted_circle') : [];
			$new_circle = isset($_POST['circle']) ? $this->input->post('circle') : [];

			// Updating Region Data
			$region_update_result = $this->region_model->updateRegion($region_id, $region);

			if ($region_update_result) {
				if (!empty($new_circle)) {
					foreach ($new_circle as $key => $value) {
						$this->circle_model->saveCircle($value, $region_id);
					}
				}

				if (!empty($deleted_circle_ids)) {
					foreach ($deleted_circle_ids as $key => $value) {
						$this->circle_model->deleteCircle($value);
					}
				}
			} else {
				http_response_code(400);
        		$response['message'] = 'Failed to update Region';
			}
		} else {
			http_response_code(400);
        	$response['message'] = 'No Input Provided';
		}

		echo json_encode($response);
	}

	public function deleteRegion()
	{
		//Default Response
        http_response_code(200);
        $response['message'] = 'Delete Region success';

        if (!empty($_POST)) {
        	$region_id = $this->input->post('region_id');

        	// Getting Circle List for Region
        	$circle_data = $this->region_model->getCircleData($region_id);

        	if (!empty($circle_data)) {
        		// Checking for Division List for Circles
        		foreach ($circle_data as $key => $value) {
        			$division_data = $this->circle_model->getDivisionData($key);

        			if (!empty($division_data)) {
        				// Deleting Divisions
        				$division_delete_result = $this->division_model->deleteDivisionData($key);
        			}

        			$circle_delete_result = $this->circle_model->deleteCircle($key);
        		}
        	}

        	$region_delete_result = $this->region_model->deleteRegion($region_id);

        	if (!$region_delete_result) {
        		http_response_code(400);
        		$response['message'] = 'Failed to Delete Region';	
        	}
        } else {
        	http_response_code(400);
        	$response['message'] = 'No Input Provided';
        }

        echo json_encode($response);
	}
}




?>