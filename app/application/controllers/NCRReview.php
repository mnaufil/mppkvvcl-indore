<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

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

        $this->load->library('image_lib');

        $this->load->library("Pdf");

        // Setting Timezone
        date_default_timezone_set("Asia/Calcutta");   //India time (GMT+5:30)

        ini_set('max_execution_time', 60);
	}

	public function index()
	{
		$ncr_status_ids = $this->getNCRStatusIDs();
		
		$user_id = $_SESSION['loggedData']->user_id;
		$user_role = $this->ncr_model->getUserRoleName($user_id);
		
		// $contract_location_ids = [];
		$contract_ids = [];

		if ($user_role == 'TKC') {
		 	$package_access_no = $_SESSION['loggedData']->package_access;

		 	// $contract_location_ids = $this->ncr_model->getContractLocationIDsByPackage($package_access_no);
		 	$contract_ids = $this->ncr_model->getContractIDsByPackage($package_access_no);
		}

		// $result = $this->ncr_model->getNCRs($ncr_status_ids['Pending'], $ncr_status_ids['Reviewed'], $contract_location_ids);
		$result = $this->ncr_model->getNCRs($ncr_status_ids['Pending'], $ncr_status_ids['Reviewed'], $contract_ids);

		// Formatting Dates
		foreach ($result as $key => $value) {
			$result[$key]['ncr_date'] = date('d-m-Y', strtotime($value['ncr_date']));
			$result[$key]['completion_date'] = (!empty($value['completion_date'])) ? date('d-m-Y', strtotime($value['completion_date'])) : '';
			$result[$key]['last_email_details'] = ($value['last_email_details'] != NULL) ? date('d-m-Y h:i a', strtotime($value['last_email_details'])): '';
		}

		$region_list = $this->ncr_model->getUserRegionList();

		$region_circle_data = $this->ncr_model->getRegionCircleData();
		$region_circle_data = $this->modifyRegionCircleData($region_circle_data);

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
		$data['region_list'] = $region_list;
		$data['region_circle_data'] = $region_circle_data;
		// $data['circle_list'] = $circle_list;
		// $data['division_list'] = $division_list;
		$data['circle_division_data'] = $circle_division_data;
		$data['status_list'] = $status_list;
		$data['user_access'] = $user_access;
		$data['user_role'] = $user_role;
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

           	$ncr_id = $this->input->post('ncrID');
           	$filter_arr['ncrID']['label'] = 'NCR ID';
           	$filter_arr['ncrID']['value'] = $ncr_id;

           	$region = (isset($_POST['region'])) ? $this->input->post('region') : '';
           	$filter_arr['region']['label'] = 'Region';
           	$filter_arr['region']['value'] = (isset($_POST['region'])) ? $this->ncr_model->getRegion($region) : '';
           	$filter_arr['region']['id'] = $region;

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

           	$last_email_sent = $this->input->post('last_email_sent');
           	$filter_arr['last_email_sent']['label'] = 'Last Email Sent';
           	$filter_arr['last_email_sent']['value'] = $last_email_sent;

           	$user_id = $_SESSION['loggedData']->user_id;
			$user_role = $this->ncr_model->getUserRoleName($user_id);

           	$contract_ids = [];

			if ($user_role == 'TKC') {
			 	$package_access_no = $_SESSION['loggedData']->package_access;

			 	// $contract_location_ids = $this->ncr_model->getContractLocationIDsByPackage($package_access_no);
			 	$contract_ids = $this->ncr_model->getContractIDsByPackage($package_access_no);
			}

           	// $search_result = $this->ncr_model->searchNCRs($contractor, $package_no, $feeder_id, $ncr_id, $region, $circle, $division, $status, $last_email_sent, $contract_location_ids);
           	$search_result = $this->ncr_model->searchNCRs($contractor, $package_no, $feeder_id, $ncr_id, $region, $circle, $division, $status, $last_email_sent, $contract_ids);

           	// Formatting Dates
           	foreach ($search_result as $key => $value) {
           		$search_result[$key]['ncr_date'] = date('d-m-Y', strtotime($value['ncr_date']));
				$search_result[$key]['completion_date'] = (!empty($value['completion_date'])) ? date('d-m-Y', strtotime($value['completion_date'])) : '';
           	}

           	$region_list = $this->ncr_model->getUserRegionList();

           	if (!empty($region)) {
           		$circle_list = $this->ncr_model->getCircleListOfRegion($region);
           		$data['circle_list'] = $circle_list;
           	}

           	$region_circle_data = $this->ncr_model->getRegionCircleData();
           	$region_circle_data = $this->modifyRegionCircleData($region_circle_data);

           	// $circle_list = $this->ncr_model->getCircleList();

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

           	// $data['circle_list'] = $circle_list;
           	$data['region_list'] = $region_list;
           	$data['region_circle_data'] = $region_circle_data;
			$data['circle_division_data'] = $circle_division_data;
			$data['status_list'] = $status_list;
			$data['user_access'] = $user_access;
			$data['user_role'] = $user_role;
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
		$data['logged_user_role'] = $this->ncr_model->getUserRole($_SESSION['loggedData']->role_id);
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
		$remark_by_tkc = $this->input->post('remark_by_tkc');
		$completion_date = (!empty($this->input->post('completionDate'))) ? date('Y-m-d', strtotime($this->input->post('completionDate'))) : NULL;
		$changed_obs_status = $this->input->post('changed_observation_status');
		$obs_deleted_file_id = (!empty($this->input->post('obs_deleted_file_id'))) ? explode(',', $this->input->post('obs_deleted_file_id')) : '';
		$obs_tkc_deleted_file_id = (!empty($this->input->post('obs_tkc_deleted_file_id'))) ? explode(',', $this->input->post('obs_tkc_deleted_file_id')) : '';
		$obs_completion_deleted_file_id = (!empty($this->input->post('obs_completion_deleted_file_id'))) ? explode(',', $this->input->post('obs_completion_deleted_file_id')) : '';

		$logged_user_role = $this->ncr_model->getUserRole($_SESSION['loggedData']->role_id);

		$ncr_status_ids = $this->getNCRStatusIDs();

		if ($logged_user_role == 'TKC') {
			$changed_obs_status_ID = $ncr_status_ids['Submitted by TKC'];
		} else {
			if ($changed_obs_status == 'Forwarded') {
				$changed_obs_status_ID = $ncr_status_ids['Forwarded'];	
			} elseif ($changed_obs_status == 'Closed') {
				$changed_obs_status_ID = $ncr_status_ids['Closed'];
			}
		}

		if ($logged_user_role != 'TKC') {
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
		} elseif ($logged_user_role == 'TKC') {
			if (!empty($obs_tkc_deleted_file_id)) {
				// Changing delete flag of deleted observation tkc files
				foreach ($obs_tkc_deleted_file_id as $key => $value) {
					$deleted_prev_files = $this->ncr_model->deleteObservationTKCFile($value);
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
							$obs_file_result = $this->ncr_model->saveObservationFileByTKC($pp_activity_obs_id, $targetFilePath); //Uncomment Later
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

			// Updating remark by tkc
			$this->ncr_model->updateNCRRemarkByTKC($pp_activity_obs_id, $remark_by_tkc);
		}

		if (!empty($errors)) {
			/*$this->session->set_flashdata('error',$errors);
			redirect('edit-ncr/'.$ncr_id);	*/
			http_response_code(400);
			$response['message'] = 'Failed to update NCR';

			echo json_encode($response);
		} else {
			if ($logged_user_role == 'TKC') {
				$email_result = $this->sendNCRSubmittedByTKCEmail($contract_location_id, $ncr_id, $pp_activity_obs_id);

				if (empty($email_result)) {
					$this->ncr_model->updateNCRStatus($pp_activity_obs_id, $changed_obs_status_ID);

					$this->session->set_flashdata('error', 'NCR updated successfully');
					
					redirect('ncr-review');	
				} else {
					$error_msg = 'Failed to send email to FE/FS/DTL';
					array_push($errors, $error_msg);
					
					$this->session->set_flashdata('error',$errors);
					redirect('edit-ncr/'.$ncr_id);
				}
			} else {
				http_response_code(200);
				$response['message'] = 'NCR updated successfully';

				echo json_encode($response);
			}
		}
	}

	public function deleteNCR()
	{
		//Default Response
      	http_response_code(200);
        $response['message'] = 'NCR deleted successfully';

		if (!empty($_POST)) {
			$ncr_id = $this->input->post('ncr_id');

			// Updating NCR status
			$delete_result = $this->ncr_model->deleteNCR($ncr_id);

			if (!$delete_result) {
				//Default Response
          		http_response_code(400);
          		$response['message'] = 'Failed to delete NCR';
			}
		}

		echo json_encode($response);
	}

	public function sendNCRSubmittedByTKCEmail($contract_location_id, $ncr_id, $pp_activity_obs_id)
	{
		$ncr_data = $this->ncr_model->getNCRDetails($pp_activity_obs_id);

		$embedded_img_arr = [];
		if (!empty($ncr_data['observation_files'])) {
			$temp_observation_files = [];
			foreach ($ncr_data['observation_files'] as $key => $value) {
				$target_path = 'assets/uploads/observation_files/thumb/';
				$resized_image = $this->resizeImage($value['file_path'], 1000, 1000, $target_path);

				/*$encoded_img = $this->encode_img_base64($resized_image);
				array_push($temp_observation_files, $encoded_img);*/
				$embedded_img_arr['obs_file_'.$key] = $resized_image;
				$temp_observation_files['obs_file_'.$key] = $resized_image;
			}

			// $ncr_data['observation_files'] = implode(', ', $temp_observation_files);
			$ncr_data['observation_files'] = $temp_observation_files;
		}

		if (!empty($ncr_data['observation_tkc_files'])) {
			$temp_observation_by_tkc_files = [];
			foreach ($ncr_data['observation_tkc_files'] as $key => $value) {
				$target_path = 'assets/uploads/observation_files_by_tkc/thumb/';
				$resized_image = $this->resizeImage($value['file_path'], 1000, 1000, $target_path);

				/*$encoded_img = $this->encode_img_base64($resized_image);
				array_push($temp_observation_by_tkc_files, $encoded_img);*/
				$embedded_img_arr['obs_file_by_tkc_'.$key] = $resized_image;
				$temp_observation_by_tkc_files['obs_file_by_tkc_'.$key] = $resized_image;
			}

			// $ncr_data['observation_tkc_files'] = implode(', ', $temp_observation_by_tkc_files);
			$ncr_data['observation_tkc_files'] = $temp_observation_by_tkc_files;
		}

		if (!empty($ncr_data['observation_completion_files'])) {
			$temp_observation_completion_files = [];
			foreach ($ncr_data['observation_completion_files'] as $key => $value) {
				$target_path = 'assets/uploads/observation_completion_files/thumb/';
				$resized_image = $this->resizeImage($value['file_path'], 1000, 1000, $target_path);

				/*$encoded_img = $this->encode_img_base64($resized_image);
				array_push($temp_observation_completion_files, $encoded_img);*/
				$embedded_img_arr['obs_completion_file'.$key] = $resized_image;
				$temp_observation_completion_files['obs_completion_file'.$key] = $resized_image;
			}

			// $ncr_data['observation_completion_files'] = implode(', ', $temp_observation_completion_files);
			$ncr_data['observation_completion_files'] = $temp_observation_completion_files;
		}

		$data['ncr_data'] = $ncr_data;		

		$contract_location_data = $this->ncr_model->getContractLocationData($contract_location_id);

		$users_result = $this->ncr_model->getUsersByRegionCircleDivision($contract_location_data);

		$users = $this->filterUsers($users_result);

		$email_errors = [];
		$data['title'] = 'NCR Review';

		$other_email_ids_data = $this->ncr_model->getCCBCCEmailIDs();
		foreach ($other_email_ids_data as $key => $value) {
			$other_email_ids[$value['display_name']] = $value['fieldvalue'];
		}

		$bcc_str = $other_email_ids['BCC EMAIL ID'];
		$bcc_arr = explode(',', $bcc_str);

		$cc_str = $other_email_ids['CC EMAIL ID'];
		$cc_arr = explode(',', $cc_str); 

		$message = $this->load->view('ncr-review/ncr-updated-by-tkc-email-body', $data, true);

		foreach ($users as $key => $value) {
			$from = $this->config->item('smtp_user');
			$to = $value;
			
			$subject = 'NCR ID:'.$ncr_data['ncr_id'].' Details Updated By TKC';

			// PHP Mailer Code Begins
			$mail = new PHPMailer(true);

			try {
				$mail->SMTPDebug = SMTP::DEBUG_OFF;
				$mail->isSMTP();
				$mail->Host = 'smtp.gmail.com';
				$mail->SMTPAuth = true;
				$mail->Username = 'mppkvvcl.sgs@gmail.com';
				$mail->Password = 'tarhuogjifshezmd';
				$mail->SMTPSecure = 'tls';
				$mail->Port = 587;
				$mail->setFrom($from);

				$mail->addAddress($to);

				foreach ($bcc_arr as $bcc_value) {
					$mail->AddBCC($bcc_value);
				}

				foreach ($cc_arr as $cc_value) { //Uncomment Later
					$mail->AddCC($cc_value);
				}

				$mail->isHTML(true);
				$mail->Subject = $subject;

				foreach ($embedded_img_arr as $emb_key => $emb_value) {
					$mail->addEmbeddedImage("$emb_value","$emb_key");
				}

				$mail->Body = $message;

				if (!$mail->send()) {
					array_push($email_errors, $mail->ErrorInfo);
					// $error = $mail->ErrorInfo;
				}
			} catch (Exception $e) {
				$error = $mail->ErrorInfo;
			}

			return $email_errors;
		}
	}

	public function filterUsers($users_result)
	{
		$fe_fs_dtl_arr = [];

		foreach ($users_result as $key => $value) {
			$user_role = $this->ncr_model->getUserRoleName($value['user_id']);

			if ($user_role == 'Field Engineer' || $user_role == 'Field Supervisor' || $user_role == 'Deputy Team Lead') {
				$user_data = $this->ncr_model->userDataByID($value['user_id']);

				array_push($fe_fs_dtl_arr, $user_data['email']);
			}
		}

		return $fe_fs_dtl_arr;
	}

	public function getNCREmailRecipientsNew()
	{
		if (!empty($_POST)) {
			$feeder_id = $this->input->post('feeder_id');
			$ncr_id = $this->input->post('ncr_id');

			$emails_result = $this->ncr_model->getNCREmailRecipientsNew($feeder_id[0]);

			$to_arr = $cc_arr = [];

			if (!empty($emails_result['tkc_emails'])) {
				$tkc_emails = explode(',', $emails_result['tkc_emails']);
				foreach ($tkc_emails as $key => $value) {
					array_push($to_arr, trim($value));
				}	
			}

			if (!empty($emails_result['fe_fs_emails'])) {
				$fe_fs_emails = explode(',', $emails_result['fe_fs_emails']);
				foreach ($fe_fs_emails as $key => $value) {
					array_push($cc_arr, trim($value));
				}
			}

			if (!empty($emails_result['dtl_emails'])) {
				$dtl_emails = explode(',', $emails_result['dtl_emails']);
				foreach ($dtl_emails as $key => $value) {
					array_push($cc_arr, trim($value));
				}	
			}			

			if (!empty($emails_result['client_emails'])) {
				$client_emails = explode(',', $emails_result['client_emails']);
				foreach ($client_emails as $key => $value) {
					array_push($cc_arr, trim($value));
				}	
			}

			if (!empty($emails_result['sgs_emails'])) {
				$sgs_emails = explode(',', $emails_result['sgs_emails']);
				foreach ($sgs_emails as $key => $value) {
					array_push($cc_arr, trim($value));
				}	
			}

			$other_emails_arr = $this->ncr_model->getCCBCCEmailIDs();

			foreach ($other_emails_arr as $key => $value) {
				if ($value['display_name'] == 'CC EMAIL ID') {
					$mandatory_emails = [];
					if (!empty($value['fieldvalue'])) {
						$mandatory_emails = explode(',', $value['fieldvalue']);	
					}
				}
			}

			if (!empty($mandatory_emails)) {
				foreach ($mandatory_emails as $key => $value) {
					array_push($cc_arr, trim($value));
				}
			}

			$email_recipients['to'] = $to_arr;
			$email_recipients['cc'] = $cc_arr;

			$response = $email_recipients;
			echo json_encode($response);
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

	public function sendNCREmailNew()
	{
		if (!empty($_POST)) {
			$checked_ncr_ids = $this->input->post('checked_ncr');
			$checked_feeder_ids = $this->input->post('feeder_id');

			$to_email_recipients = isset($_POST['to_email_recipients']) ? $this->input->post('to_email_recipients') : [];
			$cc_email_recipients = isset($_POST['cc_email_recipients']) ? $this->input->post('cc_email_recipients') : [];

			$add_to_recipient = $this->input->post('add_to_recipient');
			$add_cc_recipient = $this->input->post('add_cc_recipient');

			$user_id = $this->ncr_model->getLoggedInUserID();

			$other_email_ids_data = $this->ncr_model->getCCBCCEmailIDs();
			foreach ($other_email_ids_data as $key => $value) {
				$other_email_ids[$value['display_name']] = $value['fieldvalue'];
			}

			$email_errors = [];
			$failed_ncr_ids = [];
			$cc = [];
			$to = [];

			// Generating NCR Report data
			$report_data = $this->ncr_model->getNCRReportData($checked_ncr_ids[0], $user_id);

			foreach ($report_data as $r_key => $r_value) {
				if (!empty($r_value['observation_photos'])) {
					$observation_photos = explode(',', $r_value['observation_photos']);

					$r_value['observation_photos'] = [];
					$temp_observation_photos = [];
					foreach ($observation_photos as $obs_key => $obs_value) {
						$target_path = 'assets/uploads/observation_files/thumb/';
						$resized_image = $this->resizeImage($obs_value, 1000, 1000, $target_path);

						$encoded_img = $this->encode_img_base64($resized_image);
						array_push($temp_observation_photos, $encoded_img);
					}

					$report_data[$r_key]['observation_photos'] = implode(', ', $temp_observation_photos);
				}

				if (!empty($r_value['observation_tkc_photos'])) {
					$observation_tkc_photos = explode(',', $r_value['observation_tkc_photos']);

					$r_value['observation_tkc_photos'] = [];
					$temp_observation_tkc_photos = [];

					foreach ($observation_tkc_photos as $obs_key => $obs_value) {
						$encoded_img = $this->encode_img_base64($obs_value);
						array_push($temp_observation_tkc_photos, $encoded_img);
					}

					$report_data[$r_key]['observation_tkc_photos'] = implode(', ', $temp_observation_tkc_photos);
				}

				if (!empty($r_value['completion_photos'])) {
					$observation_completion_photos = explode(',', $r_value['completion_photos']);

					$r_value['completion_photos'] = [];
					$temp_observation_completion_photos = [];

					foreach ($observation_completion_photos as $obs_key => $obs_value) {
						$target_path = 'assets/uploads/observation_completion_files/thumb/';
						$resized_image = $this->resizeImage($obs_value, 1000, 1000, $target_path);

						$encoded_img = $this->encode_img_base64($resized_image);
						array_push($temp_observation_completion_photos, $encoded_img);
					}

					$report_data[$r_key]['completion_photos'] = implode(', ', $temp_observation_completion_photos);
				}
			}

			$pdf_name = $this->createPDF($report_data, $checked_ncr_ids[0]);
			sleep(5);

			$data['title'] = 'NCR Review';
			$data['date'] = date('d/m/Y');
			$data['feeder_id'] = $checked_feeder_ids[0];
			$data['ncr_id'] = $checked_ncr_ids[0];
			$data['ncr_status'] = $report_data[0]['ncr_status'];

			$from = $this->config->item('smtp_user');

			if (!empty($to_email_recipients)) {
				foreach ($to_email_recipients as $to_email_value) {
					array_push($to, trim($to_email_value));
				}
			}

			if (!empty($cc_email_recipients)) {
				foreach ($cc_email_recipients as $cc_email_value) {
					array_push($cc, trim($cc_email_value));
				}
			}

			if (!empty($add_to_recipient)) {
				$add_to_arr = explode(',', $add_to_recipient);

				foreach ($add_to_arr as $add_to_value) {
					array_push($to, trim($add_to_value));
				}
			}

			if (!empty($add_cc_recipient)) {
				$add_cc_arr = explode(',', $add_cc_recipient);

				foreach ($add_cc_arr as $add_cc_value) {
					array_push($cc, trim($add_cc_value));
				}
			}

			$bcc_str = $other_email_ids['BCC EMAIL ID'];
			$bcc_arr = explode(',', $bcc_str); 
			// $bcc_arr[0] = 'mansi.p@benchmarksolution.co.in'; /*Delete Later*/

			$subject = 'NCR Report - '.$checked_ncr_ids[0];
			$message = $this->load->view('ncr-review/ncr-email-body', $data, true);

			$attachment = $pdf_name;

			// PHP Mailer Code Begins
			$mail = new PHPMailer(true);

			try {
				$mail->SMTPDebug = SMTP::DEBUG_OFF;
				$mail->isSMTP();
				$mail->Host = 'smtp.gmail.com';
				$mail->SMTPAuth = true;
				$mail->Username = 'mppkvvcl.sgs@gmail.com';
				$mail->Password = 'tarhuogjifshezmd';
				// $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
				$mail->SMTPSecure = 'tls';
				$mail->Port = 587;
				$mail->setFrom($from);

				foreach ($to as $key => $value) {
					$mail->addAddress($value);
				}

				foreach ($cc as $key => $value) {
					$mail->AddCC($value);
				}

				foreach ($bcc_arr as $key => $value) {
					$mail->AddBCC($value);
				}

				$mail->isHTML(true);
				$mail->Subject = $subject;
				$mail->Body = $message;
				$mail->addAttachment($attachment);

				if (!$mail->send()) {
					$error = $mail->ErrorInfo;

					$response['message'] = 'Failed to send email for NCR ID: '.$checked_ncr_ids[0].'<br/>Error Message: '.$error;
				} else {
					if ($this->ncr_model->updateEmailDetails($checked_ncr_ids[0])) { //Uncomment Later
						$response['message'] = 'Email has been sent successfully for NCR ID: '.$checked_ncr_ids[0];	
					} 

					// $response['message'] = 'Email has been sent successfully for NCR ID: '.$checked_ncr_ids[0];	//Delete Later
				}
			} catch (Exception $e) {
				$error = $mail->ErrorInfo;

				$response['message'] = 'Failed to send email for NCR ID: '.$checked_ncr_ids[0].'<br/>Error Message: '.$error;
			}

			echo json_encode($response);
		}
	}

	public function resizeImage($image, $width, $height, $target_path)
	{
		$image_detail_arr = explode('/', $image);
		$image_name = end($image_detail_arr);

		$image_name_arr = explode('.', $image_name);
		$ext = end($image_name_arr);

		$image_name = $image_name_arr[0].'_thumb.'.$ext;

		$config['image_library'] = 'gd2';
		$config['source_image'] = $image;
		$config['new_image'] = $target_path;
		$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = TRUE;
		$config['quality'] = 90;
		$config['width'] = $width;
		$config['height'] = $height;

		$this->image_lib->clear();
	    $this->image_lib->initialize($config);
	    $this->image_lib->resize();

	    return $target_path.$image_name;
	}

	public function encode_img_base64($img_path)
	{
		$type = pathinfo($img_path, PATHINFO_EXTENSION);

		//Temporary Code
        $arrContextOptions = array(
            "ssl" => array(
                'cafile' => '/path/to/bundle/cacert.pem',
                "verify_peer" => false,
                "verify_peer_name" => false
            ),
        );

        $img_path = base_url($img_path);
        // $img_path = 'https://mpwzrdss.co.in/'.$img_path; //Delete Later

		$data = file_get_contents($img_path, false, stream_context_create($arrContextOptions));
		return 'data:image/'.$type.';base64,'.base64_encode($data);
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

	public function createPDF_old($report_data, $ncr_ids)
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

	public function createPDF($report_data, $ncr_ids, $download = false)
	{
		$data['report_data'] = $report_data;
		$html = $this->load->view('ncr-review/ncr-report', $data, true);

		$ncr_ids = str_replace(',', '_', $ncr_ids);

		$folder_path = 'assets/ncr-pdf/';
		$pdf_name = $folder_path.'NCR_Review_'.$ncr_ids.'.pdf';

		if ($download) {
			$this->pdf->createPDFForNCRDownload($html, $pdf_name);
		} else {
			$this->pdf->createPDF($html, $pdf_name);

			return $pdf_name;	
		}
	}

	public function downloadNCR($ncr_id)
	{
		$user_id = $this->ncr_model->getLoggedInUserID();

		// Generating NCR Report data
		$report_data = $this->ncr_model->getNCRReportData($ncr_id, $user_id);

		foreach ($report_data as $r_key => $r_value) {
			if (!empty($r_value['observation_photos'])) {
				$observation_photos = explode(',', $r_value['observation_photos']);

				$r_value['observation_photos'] = [];
				$temp_observation_photos = [];

				foreach ($observation_photos as $obs_key => $obs_value) {
					$encoded_img = $this->encode_img_base64($obs_value);
					array_push($temp_observation_photos, $encoded_img);
				}

				$report_data[$r_key]['observation_photos'] = implode(', ', $temp_observation_photos);
			}

			if (!empty($r_value['observation_tkc_photos'])) {
				$observation_tkc_photos = explode(',', $r_value['observation_tkc_photos']);

				$r_value['observation_tkc_photos'] = [];
				$temp_observation_tkc_photos = [];

				foreach ($observation_tkc_photos as $obs_key => $obs_value) {
					$encoded_img = $this->encode_img_base64($obs_value);
					array_push($temp_observation_tkc_photos, $encoded_img);
				}

				$report_data[$r_key]['observation_tkc_photos'] = implode(', ', $temp_observation_tkc_photos);
			}

			if (!empty($r_value['completion_photos'])) {
				$observation_completion_photos = explode(',', $r_value['completion_photos']);

				$r_value['completion_photos'] = [];
				$temp_observation_completion_photos = [];

				foreach ($observation_completion_photos as $obs_key => $obs_value) {
					$encoded_img = $this->encode_img_base64($obs_value);
					array_push($temp_observation_completion_photos, $encoded_img);
				}

				$report_data[$r_key]['completion_photos'] = implode(', ', $temp_observation_completion_photos);
			}
		}

		$this->createPDF($report_data, $ncr_id, true);
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

	public function modifyRegionCircleData($region_circle_data)
	{
		$modified_region_circle_arr = [];

        foreach ($region_circle_data as $key => $value) {
        	$modified_region_circle_arr[$value['region_id']][$value['circle_id']] = $value['circle_name'];
        }

        return $modified_region_circle_arr;
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