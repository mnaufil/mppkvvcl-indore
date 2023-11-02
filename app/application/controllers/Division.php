<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Division extends CI_Controller
{	
	function __construct()
	{
		parent::__construct();

		$this->load->model('Division_Model', 'division_model');
		$this->load->model('Region_Model', 'region_model');
		$this->load->model('Circle_Model', 'circle_model');
	}

	public function index()
	{
		$data['divisions'] = $this->division_model->getDivisionList();
		$data['regions'] = $this->region_model->getRegionList();
		$data['circles'] = $this->circle_model->getCircleList();
		$data['title'] = 'Divisions';

		// echo 'data: <pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('setup/division/division', $data);
	}

	public function searchDivision()
	{
		if (!empty($_POST)) {
			$filter_arr = [];

			$region = (isset($_POST['region'])) ? $this->input->post('region') : '';
			$filter_arr['region']['label'] = 'Region';
			$filter_arr['region']['value'] = (isset($_POST['region'])) ? $this->region_model->getRegionName($region) : '';
			$filter_arr['region']['id'] = $region;

			$circle = (isset($_POST['circle'])) ? $this->input->post('circle') : '';
			$filter_arr['circle']['label'] = 'Circle';
			$filter_arr['circle']['value'] = (isset($_POST['circle'])) ? $this->circle_model->getCircleName($circle) : '';
			$filter_arr['circle']['id'] = $circle;

			$division = $this->input->post('division');
			$filter_arr['division']['label'] = 'Division';
           	$filter_arr['division']['value'] = $division;

           	$search_result = $this->division_model->searchDivisions($region, $circle, $division);

           	$data['divisions'] = $search_result;
           	$data['filter_data'] = $filter_arr;

           	$data['regions'] = $this->region_model->getRegionList();
			$data['circles'] = $this->circle_model->getCircleList();
			$data['title'] = 'Divisions';

			// echo 'data: <pre>'; print_r($data); echo '</pre>'; die();
			$this->load->view('setup/division/division', $data);
		}
	}

	public function addDivision()
	{
		$data['regions'] = $this->region_model->getRegionList();

		$circle_data = $this->circle_model->getCircleList();
		$data['circles'] = $this->modifyRegionCircleData($circle_data);


		$data['title'] = 'Divisions';

		// echo 'data: <pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('setup/division/add-division', $data);
	}

	public function saveDivision()
	{
		$region = $this->input->post('region');
		$circle = $this->input->post('circle');
		$division = $this->input->post('division');

		$result = $this->division_model->saveDivision($division, $circle);

		if ($result) {
			redirect('division');
		}
	}

	public function editDivision($division_id)
	{
		$data['division_data'] = $this->division_model->getDivisionByDivisionID($division_id);

		$data['regions'] = $this->region_model->getRegionList();

		$circle_data = $this->circle_model->getCircleList();
		$data['circles'] = $this->modifyRegionCircleData($circle_data);

		$data['title'] = 'Divisions';

		// echo 'data: <pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('setup/division/edit-division', $data);
	}

	public function updateDivision()
	{
		$division_id = $this->input->post('division_id');
		$region = $this->input->post('region');
		$circle = $this->input->post('circle');
		$division = $this->input->post('division');

		$result = $this->division_model->updateDivision($division_id, $division, $circle);

		if ($result) {
			redirect('division');
		}
	}

	public function deleteDivision()
	{
		//Default Response
        http_response_code(200);
        $response['message'] = 'Delete Division success';

        if (!empty($_POST)) {
        	$division_id = $this->input->post('division_id');
        	// echo 'division_id: <pre>'; print_r($division_id); echo '</pre>';

        	$division_delete_result = $this->division_model->deleteDivisionByID($division_id);

        	if (!$division_delete_result) {
        		http_response_code(400);
        		$response['message'] = 'Failed to Delete Division';
        	}
        } else {
        	http_response_code(400);
        	$response['message'] = 'No Input Provided';
        }

        echo json_encode($response);
	}

	public function modifyRegionCircleData($circle_data)
	{
		$circle_arr = [];

		foreach ($circle_data as $key => $value) {
			$circle_arr[$value['region_name']][$value['circle_id']] = $value['circle_name'];
		}

		return $circle_arr;
	}
}



?>