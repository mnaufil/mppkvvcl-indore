<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Circle extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('Circle_Model', 'circle_model');
		$this->load->model('Region_Model', 'region_model');
		$this->load->model('Division_Model', 'division_model');
	}

	public function index()
	{
		$data['regions'] = $this->region_model->getRegionList();
		$data['circles'] = $this->circle_model->getCircleList();
		$data['title'] = 'Circles';

		// echo 'data:<pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('setup/circle/circle', $data);
	}

	public function searchCircle()
	{
		if (!empty($_POST)) {
			$filter_arr = [];

			$region = (isset($_POST['region'])) ? $this->input->post('region') : '';
			$filter_arr['region']['label'] = 'Region';
			$filter_arr['region']['value'] = (isset($_POST['region'])) ? $this->region_model->getRegionName($region) : '';
			$filter_arr['region']['id'] = $region;

			$circle = $this->input->post('circle');
			$filter_arr['circle']['label'] = 'Circle';
           	$filter_arr['circle']['value'] = $circle;

			$search_result = $this->circle_model->searchCircles($region, $circle);

			$data['circles'] = $search_result;
			$data['filter_data'] = $filter_arr;

			$data['regions'] = $this->region_model->getRegionList();
			$data['title'] = 'Circles';

			// echo 'data:<pre>'; print_r($data); echo '</pre>'; die();
			$this->load->view('setup/circle/circle', $data);
		}
	}

	public function addCircle()
	{
		$data['regions'] = $this->region_model->getRegionList();
		$data['title'] = 'Circles';

		// echo 'data: <pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('setup/circle/add-circle', $data);
	}

	public function saveCircle()
	{
		//Default Response
        http_response_code(200);
        $response['message'] = 'Save Circle success';

        if (!empty($_POST)) {
        	$region_id = $this->input->post('region');
        	$circle = $this->input->post('circle');

        	$result = $this->circle_model->saveCircle($circle, $region_id);

        	if (!$result) {
        		http_response_code(400);
        		$response['message'] = 'Failed to save Circle';	
        	}
        } else {
        	http_response_code(400);
        	$response['message'] = 'No Input Provided';
        }

        echo json_encode($response);
	}

	public function editCircle($circle_id)
	{
		$data['circle_data'] = $this->circle_model->getCircleData($circle_id);
		$data['regions'] = $this->region_model->getRegionList();
		$data['title'] = 'Circles';

		// echo 'data: <pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('setup/circle/edit-circle', $data);
	}

	public function updateCircle()
	{
		$circle_id = $this->input->post('circle_id');
		$circle = $this->input->post('circle');
		$region_id = $this->input->post('region');

		$result = $this->circle_model->updateCircle($circle_id, $circle, $region_id);

		if ($result) {
			redirect('circle');
		}
	}

	public function deleteCircle()
	{
		//Default Response
        http_response_code(200);
        $response['message'] = 'Delete Circle success';

        if (!empty($_POST)) {
        	$circle_id = $this->input->post('circle_id');

        	// Getting Division List for Circle
        	$division_data = $this->division_model->getDivisionData($circle_id);

        	if (!empty($division_data)) {
        		$division_delete_result = $this->division_model->deleteDivisionData($circle_id);
        	}

        	$circle_delete_result = $this->circle_model->deleteCircle($circle_id);

        	if (!$circle_delete_result) {
        		http_response_code(400);
        		$response['message'] = 'Failed to Delete Circle';
        	}
        } else {
        	http_response_code(400);
        	$response['message'] = 'No Input Provided';
        }

        echo json_encode($response);
	}
}

?>