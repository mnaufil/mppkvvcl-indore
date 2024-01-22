<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class NCRReview extends CI_Controller
{	
	function __construct()
	{
		parent::__construct();

		$this->load->model('NCRReview_Model', 'ncr_model');

		if(!$this->session->isUserLoggedIn)
        { 
            redirect('login'); 
        }

        $this->load->config('email');
        $this->load->library('email');

        // $this->load->library("Mypdf");

        // Setting Timezone
        date_default_timezone_set("Asia/Calcutta");   //India time (GMT+5:30)

        ini_set('max_execution_time', 60);
	}

	public function index()
	{
		$ncr_status_ids = $this->getNCRStatusIDs();
		$logged_user_role_id = $_SESSION['loggedData']->role_id;
		$contract_location_ids = [];

		if ($logged_user_role_id == 8) {
		 	$package_access_no = $_SESSION['loggedData']->package_access;

		 	$contract_location_ids = $this->ncr_model->getContractLocationIDsByPackage($package_access_no);
		}

		$result = $this->ncr_model->getNCRs($ncr_status_ids['Pending'], $ncr_status_ids['Reviewed'], $contract_location_ids);

		// Formatting Dates
		foreach ($result as $key => $value) {
			$result[$key]['ncr_date'] = date('d-m-Y', strtotime($value['ncr_date']));
			$result[$key]['completion_date'] = (!empty($value['completion_date'])) ? date('d-m-Y', strtotime($value['completion_date'])) : '';
			$result[$key]['last_email_details'] = ($value['last_email_details'] != NULL) ? date('d-m-Y h:i a', strtotime($value['last_email_details'])): '';
		}

		$circle_list = $this->ncr_model->getCircleList();
		$circle_list = $this->sort_array_by_key($circle_list, 'circle_name');

		/*$division_list = $this->ncr_model->getDivisionList();
		$division_list = $this->sort_array_by_key($division_list, 'division_name');*/

		$circle_division_data = $this->ncr_model->getCircleDivisionData();
        $circle_division_data = $this->modifyCircleDivisionData($circle_division_data);

		$status_list = $this->ncr_model->getStatusList();
		$status_list = $this->sort_array_by_key($status_list, 'seqno');

		$user_access_data = $this->ncr_model->getUserModuleAccess();
		$user_access = $this->sortUserModuleAccess($user_access_data);

		$data['ncr_data'] = $result;
		$data['circle_list'] = $circle_list;
		// $data['division_list'] = $division_list;
		$data['circle_division_data'] = $circle_division_data;
		$data['status_list'] = $status_list;
		$data['user_access'] = $user_access;
		$data['title'] = 'NCR Review';

		// echo '<pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('ncr-review/ncr-review', $data);
	}

	public function searchNCRReview()
	{
		if (!empty($_POST)) {
			$filter_arr = [];

			$contractor = $this->input->post('contractor');
			$filter_arr['contractor']['label'] = 'Contractor (TKC)';
           	$filter_arr['contractor']['value'] = $contractor;

           	$package_no = $this->input->post('packageNo');
			$filter_arr['package_no']['label'] = 'Package No.';
           	$filter_arr['package_no']['value'] = $package_no;

           	$feeder_id = $this->input->post('feederID');
			$filter_arr['feederID']['label'] = 'Feeder ID';
           	$filter_arr['feederID']['value'] = $feeder_id;

           	$circle = (isset($_POST['circle'])) ? $this->input->post('circle') : '';
           	$filter_arr['circle']['label'] = 'Circle';
            $filter_arr['circle']['value'] = (isset($_POST['circle'])) ? $this->ncr_model->getCircle($circle) : '';
            $filter_arr['circle']['id'] = $circle;

            $division = (isset($_POST['division'])) ? $this->input->post('division') : '';
            $filter_arr['division']['label'] = 'Division';
            $filter_arr['division']['value'] = (isset($_POST['division'])) ? $this->ncr_model->getDivision($division) : '';
            $filter_arr['division']['id'] = $division;

			$status = (isset($_POST['status'])) ? $this->input->post('status') : '';
            $filter_arr['status']['label'] = 'Status';
            $status_values = [];
            if ($status != '') {
                foreach ($this->input->post('status') as $key => $value) {
                	array_push($status_values, $this->ncr_model->getSheetStatus($value));
                }
            }
            $filter_arr['status']['value'] = (!empty($status_values)) ? implode(', ', $status_values) : '';
           	$filter_arr['status']['id'] = $this->input->post('status');

           	$logged_user_role_id = $_SESSION['loggedData']->role_id;
           	$contract_location_ids = [];

			if ($logged_user_role_id == 8) {
			 	$package_access_no = $_SESSION['loggedData']->package_access;

			 	$contract_location_ids = $this->ncr_model->getContractLocationIDsByPackage($package_access_no);
			}

           	$search_result = $this->ncr_model->searchNCRs($contractor, $package_no, $feeder_id, $circle, $division, $status, $contract_location_ids);

           	// Formatting Dates
           	foreach ($search_result as $key => $value) {
           		$search_result[$key]['ncr_date'] = date('d-m-Y', strtotime($value['ncr_date']));
				$search_result[$key]['completion_date'] = (!empty($value['completion_date'])) ? date('d-m-Y', strtotime($value['completion_date'])) : '';
           	}

           	$circle_list = $this->ncr_model->getCircleList();

           	if (!empty($circle)) {
           		$division_list = $this->ncr_model->getDivisionListOfCircle($circle);
           		$data['division_list'] = $division_list;
           	}

			$circle_division_data = $this->ncr_model->getCircleDivisionData();
        	$circle_division_data = $this->modifyCircleDivisionData($circle_division_data);

			$status_list = $this->ncr_model->getStatusList();

			$user_access_data = $this->ncr_model->getUserModuleAccess();
			$user_access = $this->sortUserModuleAccess($user_access_data);

           	$data['ncr_data'] = $search_result;
           	$data['filter_data'] = $filter_arr;

           	$data['circle_list'] = $circle_list;			
			$data['circle_division_data'] = $circle_division_data;
			$data['status_list'] = $status_list;
			$data['user_access'] = $user_access;
			$data['title'] = 'NCR Review';

			// echo '<pre>'; print_r($data); echo '</pre>'; die();
			$this->load->view('ncr-review/ncr-review', $data);
		}
	}

	public function editNCR($pp_activity_obs_id)
	{
		$obs_result = $this->ncr_model->getNCRDetails($pp_activity_obs_id);

		// Formatting Dates
		$obs_result['ncr_date'] = date('d-m-Y', strtotime($obs_result['ncr_date']));
		$obs_result['completion_date'] = (!empty($obs_result['completion_date'])) ? date('d-m-Y', strtotime($obs_result['completion_date'])) : '';

		//Getting Observations for an activity
		$activity_observations = $this->ncr_model->getActivityObservations($obs_result['activity_id']);

		$data['ncr_data'] = $obs_result;
		$data['activity_observations'] = $activity_observations;
		$data['logged_user_role_id'] = $_SESSION['loggedData']->role_id;
		$data['title'] = 'NCR Review';

		// echo '<pre>'; print_r($data); echo '</pre>'; die();
		$this->load->view('ncr-review/edit-ncr', $data);
	}

	public function updateNCR()
	{
		$errors = [];

		$pp_activity_obs_id = $this->input->post('pp_activity_observation_id');
		$contract_location_id = $this->input->post('contractLocationID');
		// $typeofwork_activity_id = $this->input->post('typeOfWorkActivityID');
		$observation_id = $this->input->post('observationType');
		$observation_name = $this->input->post('observationName');
		$ncr_id = $this->input->post('ncrID');
		$ncr_date = $this->input->post('ncrDate');
		$observation_remark = $this->input->post('remark');
		$completion_date = (!empty($this->input->post('completionDate'))) ? date('Y-m-d', strtotime($this->input->post('completionDate'))) : NULL;
		$changed_obs_status = $this->input->post('changed_observation_status');
		$obs_deleted_file_id = (!empty($this->input->post('obs_deleted_file_id'))) ? explode(',', $this->input->post('obs_deleted_file_id')) : '';
		$obs_tkc_deleted_file_id = (!empty($this->input->post('obs_tkc_deleted_file_id'))) ? explode(',', $this->input->post('obs_tkc_deleted_file_id')) : '';
		$obs_completion_deleted_file_id = (!empty($this->input->post('obs_completion_deleted_file_id'))) ? explode(',', $this->input->post('obs_completion_deleted_file_id')) : '';

		$logged_user_role_id = $_SESSION['loggedData']->role_id;

		$ncr_status_ids = $this->getNCRStatusIDs();

		if ($logged_user_role_id == 8) {
			$changed_obs_status_ID = $ncr_status_ids['Submitted by TKC'];
		} else {
			
			if ($changed_obs_status == 'Forwarded') {
				$changed_obs_status_ID = $ncr_status_ids['Forwarded'];	
			} elseif ($changed_obs_status == 'Closed') {
				$changed_obs_status_ID = $ncr_status_ids['Closed'];
			}	
		}				

		//Updating record in physical_progress_activity_observation table
		$result = $this->ncr_model->updateNCRDetails($pp_activity_obs_id, $observation_id, $observation_name, $observation_remark, $completion_date, $changed_obs_status_ID);
		if (!empty($obs_deleted_file_id)) {
			// Changing delete flag of deleted observation files
			foreach ($obs_deleted_file_id as $key => $value) {
              	$deleted_prev_files = $this->ncr_model->deleteObservationFile($value);
         	}
		}

		if (!empty($obs_completion_deleted_file_id)) {
			// Changing delete flag of deleted observation completion files
			foreach ($obs_completion_deleted_file_id as $key => $value) {
              	$deleted_prev_files = $this->ncr_model->deleteObservationCompletionFile($value);
         	}
		}

		if (!empty($obs_tkc_deleted_file_id)) {
			// Changing delete flag of deleted observation tkc files
			foreach ($obs_tkc_deleted_file_id as $key => $value) {
				$deleted_prev_files = $this->ncr_model->deleteObservationTKCFile($value);
			}
		}

		if ($result && !empty($_FILES)) {
			// Getting last physical_progress_sheet_id
			if ((isset($_FILES['obs_photo']) && $_FILES['obs_photo']['error'][0] != 4) || (isset($_FILES['completion_photo']) && $_FILES['completion_photo']['error'][0] != 4) || (isset($_FILES['obs_photo_tkc']) && $_FILES['obs_photo_tkc']['error'][0] != 4)) {
				$pp_data = $this->ncr_model->getPhysicalProgressSheetID($contract_location_id);
				$pp_id = $pp_data['physical_progress_id'];
			}

			// Updating observation files
			if (isset($_FILES['obs_photo']) && $_FILES['obs_photo']['error'][0] != 4) {
				$observation_files = $_FILES['obs_photo'];

				$allowTypes = array('jpg', 'png', 'jpeg');
				$uploadDir = 'assets/uploads/observation_files/';

				$last_file_data = $this->ncr_model->getLastObservationFileData($pp_activity_obs_id);

              	$last_file_data = explode('/', $last_file_data);
              	$last_file_data = end($last_file_data);
              	$last_file_no = explode('_', $last_file_data);
              	$last_file_no = current($last_file_no);

				foreach ($observation_files['name'] as $key => $value) {
					$ext = pathinfo($value, PATHINFO_EXTENSION);
					$last_file_no++;

					// File upload path
                  	// $fileName = $key.'_'.$pp_id.'_observation_'.$observation_id.'.'.$ext;
                  	$fileName = $last_file_no.'_observation_'.$observation_id.'_'.$ncr_id.'.'.$ext;
                    $targetFilePath = $uploadDir . $fileName;

                    if (in_array($ext, $allowTypes)) {
                    	// Upload file to server
                    	if (move_uploaded_file($observation_files['tmp_name'][$key], $targetFilePath)) {
                    		$obs_file_result = $this->ncr_model->saveObservationFile($pp_activity_obs_id, $targetFilePath);
                    	} else {
                    		$error_msg = 'Failed to upload observation photo';
                    		array_push($errors, $error_msg);
                    	}
                    } else {
                    	$error_msg = 'Only '.implode(',', $allowTypes).' files are allowed to upload';
                    	array_push($errors, $error_msg);
                    }
				}
			}

			// Updating observation tkc files
			if (isset($_FILES['obs_photo_tkc']) && $_FILES['obs_photo_tkc']['error'][0] != 4) {
				$observation_tkc_files = $_FILES['obs_photo_tkc'];

				$allowTypes = array('jpg', 'png', 'jpeg');
				$uploadDir = 'assets/uploads/observation_files_by_tkc/';

				$last_file_data = $this->ncr_model->getLastObservationFileByTKCData($pp_activity_obs_id);

				if ($last_file_data) {
					$last_file_data = explode('/', $last_file_data);
	              	$last_file_data = end($last_file_data);
	              	$last_file_no = explode('_', $last_file_data);
	              	$last_file_no = current($last_file_no);
				} else {
					$last_file_no = 0;
				}

				foreach ($observation_tkc_files['name'] as $key => $value) {
					$ext = pathinfo($value, PATHINFO_EXTENSION);
					$last_file_no++;

					// File upload path
					$fileName = $last_file_no.'_observation_tkc_'.$observation_id.'_'.$ncr_id.'.'.$ext;
					$targetFilePath = $uploadDir . $fileName;

					if (in_array($ext, $allowTypes)) {
						// Upload file to server
						if (move_uploaded_file($observation_tkc_files['tmp_name'][$key], $targetFilePath)) {
							$obs_file_result = $this->ncr_model->saveObservationFileByTKC($pp_activity_obs_id, $targetFilePath);
						} else {
							$error_msg = 'Failed to upload observation photo';
                    		array_push($errors, $error_msg);
						}
					} else {
						$error_msg = 'Only '.implode(',', $allowTypes).' files are allowed to upload';
                    	array_push($errors, $error_msg);
					}
				}
			}

			// Updating observation completion files
			if (isset($_FILES['completion_photo']) && $_FILES['completion_photo']['error'][0] != 4) {
				$completion_files = $_FILES['completion_photo'];

				$allowTypes = array('jpg', 'png', 'jpeg');
				$uploadDir = 'assets/uploads/observation_completion_files/';

				$last_file_data = $this->ncr_model->getLastObservationCompletionFileData($pp_activity_obs_id);

				if (!empty($last_file_data)) {
					$last_file_data = explode('/', $last_file_data);
	              	$last_file_data = end($last_file_data);
	              	$last_file_no = explode('_', $last_file_data);
	              	$last_file_no = current($last_file_no);
				} else {
					$last_file_no = 0;
				}				

				foreach ($completion_files['name'] as $key => $value) {
					$ext = pathinfo($value, PATHINFO_EXTENSION);
					$last_file_no++;

					// File upload path
					// $fileName = $key.'_'.$pp_id.'_completion_'.$observation_id.'.'.$ext;
					$fileName = $last_file_no.'_completion_'.$observation_id.'_'.$ncr_id.'.'.$ext;
                    $targetFilePath = $uploadDir . $fileName;

                    if (in_array($ext, $allowTypes)) {
                    	// Upload file to server
                    	if (move_uploaded_file($completion_files['tmp_name'][$key], $targetFilePath)) {
                    		$obs_completion_file_result = $this->ncr_model->saveObservationCompletionFile($pp_activity_obs_id, $targetFilePath);
                    	} else {
                    		$error_msg = 'Failed to upload completion photo';
                    		array_push($errors, $error_msg);
                    	}
                    } else {
                    	$error_msg = 'Only '.implode(',', $allowTypes).' files are allowed to upload';
                    	array_push($errors, $error_msg);
                    }
				}
			}
		}

		if (!empty($errors)) {
			$this->session->set_flashdata('error',$errors);
			redirect('edit-ncr/'.$ncr_id);	
		} else {
			redirect('ncr-review');	
		}
	}

	public function sendNCREmail()
	{
		if (!empty($_POST)) {
			$checked_ncr_ids = $this->input->post('checked_ncr');
			$user_id = $this->ncr_model->getLoggedInUserID();

			$contractor_data = $this->ncr_model->getContractorEmailIDs($checked_ncr_ids);

			// $sorted_contractor_data = $this->groupContractorDataByEmail($contractor_data);
			$sorted_contractor_data = $this->groupContractorDataByName($contractor_data);

			$other_email_ids_data = $this->ncr_model->getCCBCCEmailIDs();
			foreach ($other_email_ids_data as $key => $value) {
				$other_email_ids[$value['display_name']] = $value['fieldvalue'];
			}

			$email_errors = [];
			$failed_ncr_ids = [];

			foreach ($sorted_contractor_data as $key => $value) {
				$ncr_ids = implode(',', $value['ncr_id']);

				// Generating NCR Report data
				$report_data = $this->ncr_model->getNCRReportData($ncr_ids, $user_id);

				// $pdf_name = $this->createPDF($report_data, $ncr_ids);
				$pdf_name = $this->createPDF2($report_data, $ncr_ids);

				$data['title'] = 'NCR Review';
				$data['date'] = date('d/m/Y');

				$from = $this->config->item('smtp_user');
				$to = $value['contractor_email'];
				$cc = $other_email_ids['CC EMAIL ID'];
				$bcc_str = $other_email_ids['BCC EMAIL ID'];
				$bcc_arr = explode(', ', $bcc_str);

				$subject = 'NCR Report';
				$message = $this->load->view('ncr-review/ncr-email-body', $data, true);

				// $attachment = base_url($pdf_name);
				$attachment = $pdf_name;

				$this->email->clear(TRUE);
				$this->email->set_newline("\r\n");
				$this->email->set_header('Content-Type', 'text/html');
				// $this->email->set_header('MIME-Version', '1.0; charset=utf-8');
				$this->email->from($from);
				$this->email->to($to);
				$this->email->cc($cc);
				$this->email->bcc($bcc_arr);
				
				$this->email->subject($subject);
				$this->email->message($message);
				$this->email->attach($attachment);

				if (!$this->email->send()) {
					$error = $this->email->print_debugger();
					array_push($email_errors, $error);
					foreach ($value['ncr_id'] as $val) {
						array_push($failed_ncr_ids, $val);	
					}
				} else {
					$this->ncr_model->updateEmailDetails($value['ncr_id']);
				}
			}
			
			if (empty($email_errors)) {
				$response['message'] = 'Email has been sent successfully';
			} else {
				$response['message'] = 'Failed to send email for NCR IDs: '.implode(',', $failed_ncr_ids);
			}

			echo json_encode($response);
		}
	}

	public function createPDF2($report_data, $ncr_ids)
	{
		$mpdf = new \Mpdf\Mpdf();

		$data['report_data'] = $report_data;
		$html = $this->load->view('ncr-review/ncr-report', $data, true);

		$mpdf->WriteHTML($html);

		// Saving the pdf file
		$folder_path = 'assets/ncr-pdf/';
		$pdf_name = $folder_path.'test_pdf.pdf';
		$mpdf->Output($pdf_name, 'F');

		$ncr_ids = str_replace(',', '_', $ncr_ids);

		$folder_path = 'assets/ncr-pdf/';
		$pdf_name = $folder_path.'NCR_Review_'.$ncr_ids.'.pdf';

		$mpdf->Output($pdf_name, 'F');

		return $pdf_name;
	}	

	public function createPDF($report_data, $ncr_ids)
	{
		$pdf = new Mypdf();

		$pdf->AddPage();
		$pdf->SetFont('Arial', '', 20);
		$pdf->Write(5, "Non Conformance Report");
		$pdf->SetFont('', 'U');
		$pdf->SetFont('');
		$pdf->SetFont('Arial', '', 20);
		$pdf->SetLeftMargin(10);
		$pdf->SetFontSize(9);
		$pdf->WriteHTML("<br>");
		$pdf->WriteHTML("<br>");
		$header = array('Sl No');

		$i = 0;

		foreach ($report_data as $value) {
			if ($i == 0) {
				$pdf->Cell(95,7,'DISCOM',1);
				$pdf->Cell(95,7,'MPPKVVCL',1);

				$pdf->Ln();

				$pdf->Cell(95,7,'TKC',1);
				$pdf->Cell(95,7,$value['contractor_name'], 1);

				$pdf->Ln();

				$pdf->Cell(95,7,'Package No',1);
				$pdf->Cell(95,7,$value['package_no'],1);

				$pdf->Ln();

				$pdf->Cell(95,7,'Region Name',1);
				$pdf->Cell(95,7,$value['region_name'],1);

				$pdf->Ln();

				$pdf->Cell(95,7,'Circle Name',1);
				$pdf->Cell(95,7,$value['circle_name'],1);

				$pdf->Ln();

				$pdf->Cell(95,7,'Division Name',1);
				$pdf->Cell(95,7,$value['division_name'],1);

				$pdf->Ln();

				$pdf->Cell(95,7,'Feeder ID',1);
				$pdf->Cell(95,7,$value['feeder_id'],1);

				$pdf->Ln();

				$pdf->Cell(95,7,'Feeder Name',1);
				$pdf->Cell(95,7,$value['feeder_name'],1);

				$pdf->Ln();

				$pdf->Cell(95,7,'Substation',1);
				$pdf->Cell(95,7,$value['substation'],1);

				$pdf->Ln();

				$pdf->Cell(95,7,'Standards',1);
				$pdf->Cell(95,7,$value['standards'],1);
			}

			$pdf->Ln();
			$pdf->Ln();

			$pdf->Cell(95,7,'NCR ID',1);
			$pdf->Cell(95,7,$value['ncr_id'],1);

			$pdf->Ln();

			$pdf->Cell(95,7,'NCR Date',1);
			$pdf->Cell(95,7,$value['ncr_date'],1);

			$pdf->Ln();

			$pdf->Cell(95,7,'Inspected By',1);
			$pdf->Cell(95,7,$value['Inspected_by'],1);

			$pdf->Ln();

			$pdf->Cell(95,7,'Activity',1);
			$pdf->Cell(95,7,$value['activity'],1);

			$pdf->Ln();

			$pdf->Cell(95,7,'Observation Type',1);
			$pdf->Cell(95,7,$value['observation_type'],1);

			$pdf->Ln();

			$pdf->Cell(95,7,'Observation',1);
			$pdf->Cell(95,7,$value['observation'],1);

			$pdf->Ln();

			$obs_photos = explode(",",$value['observation_photos'] ?? '');
			$obs_photo_count = count($obs_photos);

			$pdf->Cell(190,7,'Observation Photo(s)',1);

			$pdf->Ln();
			$pdf->Ln();

			for ($i = 0; $i < $obs_photo_count; $i++) { 
				if (!empty($obs_photos[$i])) {
					// $size = getimagesize(base_url().$obs_photos[$i]);
					$size = getimagesize($obs_photos[$i]);
					$wImg = $size[0];
					$hImg = $size[1];

					//  Get PDF dimensions
					$wPdf = $pdf->A4_WIDTH;
					$hPdf = $pdf->A4_HEIGHT;

					//  Calculate width necessary for the cell
					$width = $wPdf - $wImg;

					if ($width < 0) {
						error_log('Image is larger than page we\'re trying to print on.');
						$width = 0;
					}

					//  Convert pixel units to user units
					/*$width  /= $pdf->MM_IN_INCH;
					$height /= $pdf->MM_IN_INCH;*/

					//  Print a boundary cell
					$pdf->Cell($wImg/2,$hImg/2);

					//  Print image
					// $pdf->Image(base_url().$obs_photos[$i]);
					$pdf->Image($obs_photos[$i]);

					//  Force a new line
					$pdf->Ln();
				}

				$pdf->Ln();
			}

			$pdf->Ln();
			$pdf->Ln();

			$pdf->Cell(190,7,'Completion Photo(s)',1);

			$pdf->Ln();
			$pdf->Ln();

			$obs_completion_photos = explode(",",$value['completion_photos'] ?? '');
			$obs_completion_photos_count = count($obs_completion_photos);

			for ($j = 0; $j < $obs_completion_photos_count; $j++) { 
				if (!empty($obs_completion_photos[$j])) {
					// $size = getimagesize(base_url().$obs_completion_photos[$j]);
					$size = getimagesize($obs_completion_photos[$j]);
					$wImg = $size[0];
					$hImg = $size[1];

					//  Get PDF dimensions
					$wPdf = $pdf->A4_WIDTH;
					$hPdf = $pdf->A4_HEIGHT;

					//  Calculate width necessary for the cell
					$width = $wPdf - $wImg;

					if ($width < 0) {
						error_log('Image is larger than page we\'re trying to print on.');
    					$width = 0;
					}

					//  Convert pixel units to user units
					/*$width  /= $pdf->MM_IN_INCH;
					$height /= $pdf->MM_IN_INCH;*/

					//  Print a boundary cell
					$pdf->Cell($wImg/2,$hImg/2);

					//  Print image
					// $pdf->Image(base_url().$obs_completion_photos[$j]);
					$pdf->Image($obs_completion_photos[$j]);

					//  Force a new line
					$pdf->Ln();
				}

				$pdf->Ln();
			}

			$pdf->Ln();
			$pdf->Ln();

			$pdf->Cell(95,7,'Completion Date',1);
			$pdf->Cell(95,7,$value['completion_date'],1);

			$i++;
		}

		$ncr_ids = str_replace(',', '_', $ncr_ids);

		$folder_path = 'assets/ncr-pdf/';
		$pdf_name = $folder_path.'NCR_Review_'.$ncr_ids.'.pdf';

		$pdf->Output($pdf_name, 'F');

		return $pdf_name;
	}

	public function getNCRStatusIDs()
    {
        $result = $this->ncr_model->getNCRStatusIDs();

        $ncr_status_ids = [];
        foreach ($result as $key => $value) {
        	$ncr_status_ids[$value['status_name']] = $value['status_id'];
        }

        return $ncr_status_ids;
    }

    public function groupContractorDataByEmail($contractor_data)
	{
		$arr = array();

		foreach ($contractor_data as $key => $value) {
		   $arr[$value['contractor_email']][$key] = $value['ncr_id'];
		}

		return $arr;
	}

	public function groupContractorDataByName($contractor_data)
	{
		$arr = array();

		foreach ($contractor_data as $key => $value) {
		   $arr[$value['contractor_name']]['contractor_email'] = $value['contractor_email'];
		   $arr[$value['contractor_name']]['ncr_id'][$key] = $value['ncr_id'];
		}

		return $arr;
	}

	public function modifyCircleDivisionData($circle_division_data)
    {
    	$modified_circle_division_arr = [];

        foreach ($circle_division_data as $key => $value) {
        	$modified_circle_division_arr[$value['circle_id']][$value['division_id']] = $value['division_name'];
        }

        return $modified_circle_division_arr;
    }

    //Function to sort array by key
    public function sort_array_by_key($array, $sort_key)
    {
        $key_array = array_column($array, $sort_key);
        array_multisort($key_array, SORT_ASC, $array); //or SORT_DESC
        return $array;
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