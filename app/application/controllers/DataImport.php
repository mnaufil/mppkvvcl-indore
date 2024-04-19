<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class DataImport extends CI_Controller
{	
	function __construct()
	{
		parent::__construct();

		$this->load->model('DataImport_Model', 'di_model');

		if(!$this->session->isUserLoggedIn)
        { 
            redirect('login'); 
        }
	}

	public function index()
	{
		$import_details = $this->di_model->getAllImportDetails();

		$data['import_details'] = $import_details;
		$data['title'] = 'Data Import';

		// echo 'data: <pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('data-import/data-import-list', $data);
	}

	public function addData()
	{
		$import_type_data = $this->di_model->getAllImportTypes();

		$import_sub_type_data = $this->di_model->getAllImportSubTypes();
		$import_sub_type_data = $this->modifyImportSubTypeData($import_sub_type_data);

		$data['import_types'] = $import_type_data;
		$data['import_sub_types'] = $import_sub_type_data;
		$data['title'] = 'Data Import';

		// echo 'data: <pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('data-import/add-data-import', $data);
	}

	public function editData($import_hdr_id)
	{
		$import_details = $this->di_model->getImportDetails($import_hdr_id);

		if ($import_details['import_type'] == 'Material') {
			$validation_result = $this->di_model->validateMaterialUploadedData($import_hdr_id);
		} else if ($import_details['import_type'] == 'Invoice') {
			$validation_result = $this->di_model->validateInvoiceUploadedData($import_hdr_id);
		}		

		$valid_records = $invalid_records = [];
		foreach ($validation_result as $key => $value) {
			if ($value['error_message'] == '' && $value['is_valid'] == 1) {
				array_push($valid_records, $value);
			} else {
				array_push($invalid_records, $value);
			}
		}

		$import_type = strtolower(str_replace(' ', '_', $import_details['import_type']));
		$import_sub_type = strtolower(str_replace(' ', '_', $import_details['sub_type']));
		if (!empty($import_sub_type)) {
			$import_type_str = $import_type.'_'.$import_sub_type;
		} else {
			$import_type_str = $import_type;	
		}		
		
		$format_file_path = 'assets/data-import-samples/'.$import_type.'/'.$import_type_str.'.xlsx';

		$format_headers = $this->getFormatFileHeaders($import_type, $import_type_str);

		$data['import_details'] = $import_details;
		$data['format_file_path'] = $format_file_path;
		$data['format_file_name'] = $import_type_str.'.xlsx';
		$data['table_headers'] = $format_headers;
		$data['valid_records'] = $valid_records;
		$data['invalid_records'] = $invalid_records;
		$data['import_hdr_id'] = $import_hdr_id;
		$data['title'] = 'Data Import';

		// echo 'data: <pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('data-import/edit-data-import', $data);
	}

	public function processDataFile()
	{
		//Default Response
      	http_response_code(200);
      	$response['message'] = 'Uploaded data file processed successfully';

		if (!empty($_POST)) {
			$import_hdr_id = isset($_POST['import_hdr_id']) ? $this->input->post('import_hdr_id') : '';
			$import_type = $type = $this->input->post('import_type');
			$import_sub_type = $sub_type = (isset($_POST['import_sub_type'])) ? $this->input->post('import_sub_type') : '';

			if (!empty($_FILES)) {
				$data_file = $_FILES['dataFile'];

				if ($data_file['error'] == 0) {
					$allowedTypes = array('text/xls', 'text/xlsx', 'application/excel', 'application/vnd.msexcel', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

					if (in_array($data_file['type'], $allowedTypes)) {
						if (is_uploaded_file($data_file['tmp_name'])) {
							$import_type = strtolower(str_replace(' ', '_', $import_type));

							if (!empty($import_sub_type)) {
								$import_sub_type = strtolower(str_replace(' ', '_', $import_sub_type));
								$import_type_str = $import_type.'_'.$import_sub_type;
							} else {
								$import_type_str = $import_type;
							}

							// Getting headers of sample format sheet
							$sample_headers = $this->getFormatFileHeaders($import_type, $import_type_str);

							// Getting data from uploaded sheet
							$reader = new Xlsx();
							$spreadsheet = $reader->load($data_file['tmp_name']);
							$worksheet = $spreadsheet->getActiveSheet();
							$worksheet_arr = $worksheet->toArray();

							$header_arr = $worksheet_arr[0];

							$header_not_found_count = 0;

							foreach ($sample_headers as $s_header) {
								if (!in_array($s_header, $header_arr)) {
									$header_not_found_count++;
								}
							}

							if ($header_not_found_count == 0) {
								// Removing header row
								unset($worksheet_arr[0]);
								unset($worksheet_arr[1]);

								if (empty($import_hdr_id)) {
									$response['test'] = 'save';
									$import_hdr_id = $this->di_model->saveImportTypes($type, $sub_type);
								} else {
									$response['test'] = 'update';
									$import_hdr_id = $this->di_model->updateImportTypes($import_hdr_id, $type, $sub_type);
								} //Uncomment Later
								
								// Uncomment Later
								switch ($import_type_str) {
									case 'material_inward':
										$this->di_model->saveMaterialInwardData($import_hdr_id, $worksheet_arr);
										break;
									case 'material_inward_micc':
										$this->di_model->saveMaterialInwardMICCData($import_hdr_id, $worksheet_arr);
										break;
									case 'material_inward_return':
										$this->di_model->saveMaterialInwardReturnData($import_hdr_id, $worksheet_arr);
										break;
									case 'material_inward_sampling':
										$this->di_model->saveMaterialInwardSamplingData($import_hdr_id, $worksheet_arr);
										break;
									case 'material_outward':
										$this->di_model->saveMaterialOutwardData($import_hdr_id, $worksheet_arr);
										break;
									case 'invoice':
										$this->di_model->saveInvoiceData($import_hdr_id, $worksheet_arr);
										break;
									default:
										// code...
										break;
								}								

								if ($import_type == 'material') {
									$validate_data = $this->di_model->validateMaterialUploadedData($import_hdr_id);	
								} elseif ($import_type == 'invoice') {
									$validate_data = $this->di_model->validateInvoiceUploadedData($import_hdr_id);
								}

								$valid_records = $invalid_records = [];

								foreach ($validate_data as $key => $value) {
									if ($value['is_valid'] == 0 && !empty($value['error_message'])) {
										array_push($invalid_records, $value);
									} elseif ($value['is_valid'] == 1 && empty($value['error_message'])) {
										array_push($valid_records, $value);
									}
								}

								$response['import_hdr_id'] = $import_hdr_id;
								$response['valid_records'] = $valid_records;
								$response['invalid_records'] = $invalid_records;
								$response['table_headers'] = $header_arr;
							} else {
								// Wrong Data File
		          				http_response_code(400);
		          				$response['message'] = 'Headers of uploaded file does not match with sample format file';
							}
						}
					} else {
						// Invalid Format
          				http_response_code(400);
          				$response['message'] = 'Invalid File Format';
					}
				} else {
					// Error with file
					http_response_code(400);
          			$response['message'] = 'Uploaded file contains error';
				}
			} else {
				// No files
				http_response_code(400);
          		$response['message'] = 'No file uploaded';
			}			
		} else {
			//No input
			http_response_code(400);
          	$response['message'] = 'No inputs selected';
		}

		echo json_encode($response);
	}

	public function importDataFile()
	{
		// Default Response
		http_response_code(200);
		$response['message'] = 'Data imported successfully';

		if (!empty($_POST)) {
			$import_hdr_id = $this->input->post('import_hdr_id');
			$import_type = $this->input->post('import_type');

			if ($import_type == 'Material') {
				$import_data_count = $this->di_model->importMaterialUploadedData($import_hdr_id); //Uncomment Later	
			} elseif ($import_type == 'Invoice') {
				$import_data_count = $this->di_model->importInvoiceUploadedData($import_hdr_id); //Uncomment Later	
			}

			if ($import_data_count == 0) {
				http_response_code(400);
				$response['message'] = 'Failed to import data';
			} else {
				$this->di_model->changeImportStatus($import_hdr_id, 2);
			}

			echo json_encode($response);
		}
	}

	public function cancelDataImport()
	{
		// Default Response
		http_response_code(200);
		$response['message'] = 'Data import cancelled';

		if (!empty($_POST)) {
			$import_hdr_id = $this->input->post('import_hdr_id');

			$cancel_result = $this->di_model->changeImportStatus($import_hdr_id, 3);

			if (!$cancel_result) {
				http_response_code(400);
				$response['message'] = 'Failed to cancel data import';
			}

			echo json_encode($response);
		}
	}

	public function getFormatFileHeaders($folder_name, $file_name)
	{
		$sample_file_path = 'assets/data-import-samples/'.$folder_name.'/'.$file_name.'.xlsx';

		$reader = new Xlsx();
		$spreadsheet = $reader->load($sample_file_path);
		$worksheet = $spreadsheet->getActiveSheet();
		$worksheet_arr = $worksheet->toArray();

		$sample_headers = $worksheet_arr[0];

		return $sample_headers;
	}

	public function modifyImportSubTypeData($import_sub_type_data)
	{
		$modified_data = [];

		foreach ($import_sub_type_data as $key => $value) {
			$modified_data[$value['type_name']][$key]['import_sub_type_id'] = $value['import_sub_type_id'];
			$modified_data[$value['type_name']][$key]['sub_type_name'] = $value['sub_type_name'];
		}

		return $modified_data;
	}
}



?>