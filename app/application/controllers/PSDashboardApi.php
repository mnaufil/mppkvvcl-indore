<?php error_reporting(E_ERROR | E_PARSE);
ini_set('max_execution_time', '0'); 

if (isset($_SERVER['HTTP_ORIGIN'])) {
	header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
	header('Access-Control-Allow-Credentials: true');
	header('Access-Control-Max-Age: 86400');    // cache for 1 day	
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
		// may also be using PUT, PATCH, HEAD etc
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
	}

	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
		header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
	}

	exit(0);
}

require APPPATH.'libraries/REST_Controller.php';
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/**
 * 
 */
class PSDashboardApi extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('PSDashboardApi_Model', 'psdashboard_model');

		$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2). '/');
		$dotenv->load();

		date_default_timezone_set("Asia/Calcutta");
	}

	public function authenticateUser_post()
	{
		if (!empty($this->post())) {
			$username = $this->post('username');
			$password = $this->post('password');

			$user_details = $this->psdashboard_model->validateUser($username, $password);

			if ($user_details) {
				$jwt = $this->generate_jwt_token($user_details, $_ENV['API_KEY']);

				//Check if token already exists for user
				$token_result = $this->psdashboard_model->checkTokenExistsForUser($user_details['user_id']);

				if ($token_result) {
					// Updating jwt token
					$this->psdashboard_model->updateJWTTokenDetails($jwt, $user_details['user_id']);	
				} else {
					// Inserting jwt token
					$this->psdashboard_model->saveJWTTokenDetails($jwt, $user_details['user_id']);	
				}				

				$data['username'] = $username;
				$data['password'] = $password;
				$data['token'] = $jwt;
			} else {
				$errors = 'Invalid User';
	            $message = 'User does not exist';
	            $status_code = 400;
	            $data = [];	
			}
		} else {
			$errors = 'Empty POST Request';
            $message = 'POST Request has no arguments';
            $status_code = 400;
            $data = [];
		}

		$this->response(['errors' => $errors, 'message' => $message, 'status_code' => $status_code, 'data' => $data], REST_Controller::HTTP_OK);
	}

	public function getFeedersData_post()
	{
		if (!empty($this->post())) {
			if (!preg_match('/Bearer\s(\S+)/', $_SERVER['HTTP_AUTHORIZATION'], $matches)) {
				$errors = 'Token Error';
	            $message = 'Token not found in request';
	            $status_code = 400;
	            $data = [];
			} else {
				$jwt = $matches[1];

				if (!$jwt) {
					$errors = 'Token Error';
		            $message = 'Token not found in request';
		            $status_code = 400;
		            $data = [];
				} else {
					$validate_token = $this->validate_jwt_token($jwt, $_ENV['API_KEY']);

					if ($validate_token instanceof Exception) {
						$errors = 'Token Error';
			            $message = $validate_token->getMessage();
			            $status_code = 400;
			            $data = [];
					} else {
						// Check if token matches with user_id
						$token_result = $this->psdashboard_model->getUserTokenDetails($validate_token->user_id, $jwt);

						if (empty($token_result)) {
							$errors = 'Token Error';
				            $message = 'Token does not matches';
				            $status_code = 400;
				            $data = [];
						} else {
							$date = $this->post('date');
							// $lot_no = $this->post('lot_no');
							$lot_no = (!empty($this->post('lot_no'))) ? $this->post('lot_no') : 'NULL';

							/*if (empty($lot_no)) {
								$errors = 'Invalid Parameters';
					            $message = 'No Lot No. provided';
					            $status_code = 400;
					            $data = [];
							} else {*/
								$date_result = $this->isValidDate($date);

								if (!$date_result) {
									$errors = 'Invalid Parameters';
						            $message = 'Provide valid date in d-m-Y format';
						            $status_code = 400;
						            $data = [];
								} else {
									$formatted_date = date('Y-m-d', strtotime($date));

									$feeders_data = $this->psdashboard_model->getFeedersData($formatted_date, $lot_no);

									$feeder_details = $feeders_data[0];
									$feeder_progress = $feeders_data[1];

									if (empty($feeder_details) && empty($feeder_progress)) {
										$errors = NULL;
							            $message = 'No data found';
							            $status_code = 200;
							            $data = [];
									} else {
										foreach ($feeder_details as $fd_key => $fd_value) {
											$data[$fd_key]['lot_no'] = $fd_value['package_group_no'];
											$data[$fd_key]['contractor'] = $fd_value['contractor_name'];
											$data[$fd_key]['circle'] = $fd_value['circle_name'];
											$data[$fd_key]['vidhansabha'] = $fd_value['vidhansabha'];
											$data[$fd_key]['district'] = $fd_value['district'];
											$data[$fd_key]['division'] = $fd_value['division_name'];
											$data[$fd_key]['substation'] = $fd_value['location_name'];
											$data[$fd_key]['typeofwork'] = $fd_value['typeofwork'];
											$data[$fd_key]['feeder_id'] = $fd_value['feeder_id'];
											$data[$fd_key]['charging_status'] = $fd_value['charging_status'];
											$data[$fd_key]['estimate_created'] = $fd_value['estimate_created'];
											$data[$fd_key]['scope_as_per_award'] = [];
											$data[$fd_key]['work_completed'] = [];

											foreach ($feeder_progress as $fp_key => $fp_value) {
												if ($fd_value['feeder_id'] == $fp_value['feeder_id']) {
													$data[$fd_key]['scope_as_per_award'][$fp_value['report_head']] = $fp_value['totalAwardQty'];
													$data[$fd_key]['work_completed'][$fp_value['report_head']] = $fp_value['workProgressQty'];
												}
											}

											$data[$fd_key]['BOQ_cost'] = number_format($fd_value['BoQCost'], 2);
											$data[$fd_key]['estimated_executed_cost'] = $fd_value['EstimatedExecutedCost'];
											$data[$fd_key]['status_of_work'] = $fd_value['status'];
										}

										$errors = NULL;
							            $message = NULL;
							            $status_code = 200;	
									}
								}
							/*}*/
						}
					}
				}
			}
		} else {
			$errors = 'Invalid Parameters';
            $message = 'POST Request has no arguments';
            $status_code = 400;
            $data = [];
		}

		$this->response(['errors' => $errors, 'message' => $message, 'status_code' => $status_code, 'data' => $data], REST_Controller::HTTP_OK);
	}

	public function updateFeederData_post()
	{
		if (!empty($this->post())) {
			if (!preg_match('/Bearer\s(\S+)/', $_SERVER['HTTP_AUTHORIZATION'], $matches)) {
				$errors = 'Token Error';
	            $message = 'Token not found in request';
	            $status_code = 400;
	            $data = [];
			} else {
				$jwt = $matches[1];

				if (!$jwt) {
					$errors = 'Token Error';
		            $message = 'Token not found in request';
		            $status_code = 400;
		            $data = [];
				} else {
					$validate_token = $this->validate_jwt_token($jwt, $_ENV['API_KEY']);

					if ($validate_token instanceof Exception) {
						$errors = 'Token Error';
			            $message = $validate_token->getMessage();
			            $status_code = 400;
			            $data = [];
					} else {
						// Check if token matches with user_id
						$token_result = $this->psdashboard_model->getUserTokenDetails($validate_token->user_id, $jwt);

						if (empty($token_result)) {
							$errors = 'Token Error';
				            $message = 'Token does not matches';
				            $status_code = 400;
				            $data = [];
						} else {
							$feeder_data = $this->post('feeder_data');

							if (empty($feeder_data)) {
								$errors = 'Invalid Parameters';
					            $message = 'No feeder data provided to update';
					            $status_code = 400;
					            $data = [];
							} else {
								$feeder_result = [];
								$update_flag = 1;
								$not_updated_feeders = [];

								foreach ($feeder_data as $key => $value) {
									$result = $this->psdashboard_model->updateFeederDetails($value['feeder_id'], $value['charging_status'], $value['estimate_created'], $validate_token->user_id);

									$result_arr = [];
									if ($result) {
										$result_arr = array('feeder_id' => $value['feeder_id'], 'status' => 'updated');
									} else {
										$result_arr = array('feeder_id' => $value['feeder_id'], 'status' => 'not updated');
										$update_flag = 0;
										array_push($not_updated_feeders, $value['feeder_id']);
									}

									array_push($feeder_result, $result_arr);
								}

								if ($update_flag) {
									$message = 'Feeders updated successfully';		
								} else {
									$not_updated_feeders = implode(',', $not_updated_feeders);
									$message = $not_updated_feeders.' feeder(s) not updated';
								}

								$errors = NULL;					            
					            $status_code = 200;
					            $data = $feeder_result;

							}
						}

					}
				}
			}
		} else {
			$errors = 'Invalid Parameters';
            $message = 'POST Request has no arguments';
            $status_code = 400;
            $data = [];
		}

		$this->response(['errors' => $errors, 'message' => $message, 'status_code' => $status_code, 'data' => $data], REST_Controller::HTTP_OK);
	}

	public function isValidDate($date, $format = 'd-m-Y')
	{
		$dateTime = DateTime::createFromFormat($format, $date);
		return $dateTime && $dateTime->format($format) === $date;
	}	

	public function generate_jwt_token($user_details, $secret_key)
	{
		$issued_at = new DateTimeImmutable();
		$expiry = $issued_at->modify('+24 hours')->getTimestamp();// Add 24 hours     
		// $expiry = $issued_at->modify('+30 minute')->getTimestamp();// Add 30 minutes
		$serverName = $_SERVER['SERVER_NAME'];

		$payload = array(
	        'iat' => $issued_at->getTimestamp(),// Issued at: time when the token was generated
	        'iss' => $serverName,// Issuer
	        'nbf' => $issued_at->getTimestamp(),// Not before
	        'exp' => $expiry,//Token Expiry
	        'username' => $user_details['username'],
	        'useremail' => $user_details['email'],
	        'user_id' => $user_details['user_id']
	    );

	    return JWT::encode($payload, $secret_key, 'HS512');
	}

	public function validate_jwt_token($jwt, $secret_key)
	{
		try {
	        return JWT::decode($jwt, new Key($secret_key, 'HS512'));
	    } catch (ExpiredException $e) {
	        return new Exception('Token expired');
	    } catch (SignatureInvalidException $e) {
	        return new Exception('Invalid token signature');
	    } catch (BeforeValidException $e) {
	        return new Exception('Token not valid yet');
	    } catch (Exception $e) {
	        return new Exception('Invalid token');
	    }
	}
}

?>