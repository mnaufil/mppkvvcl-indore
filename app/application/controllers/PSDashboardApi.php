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

		$path = base_url().'app/';

		// $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/');
		$dotenv = Dotenv\Dotenv::createImmutable($path);
		$dotenv->load();

		date_default_timezone_set("Asia/Calcutta");
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
						$date = (!empty($this->post('date'))) ? date('Y-m-d', strtotime($this->post('date'))) : date('Y-m-d');
						$lot_no = (!empty($this->post('lot_no'))) ? $this->post('lot_no') : 'NULL';

						/*if (empty($date)) {
							$errors = 'Empty POST Request';
				            $message = 'No date provided';
				            $status_code = 400;
				            $data = [];
						}*/

						$feeders_data = $this->psdashboard_model->getFeedersData($date, $lot_no);

						$feeder_details = $feeders_data[0];
						$feeder_progress = $feeders_data[1];

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
							$data[$fd_key]['scope_as_per_award'] = [];
							$data[$fd_key]['work_completed'] = [];

							foreach ($feeder_progress as $fp_key => $fp_value) {
								if ($fd_value['feeder_id'] == $fp_value['feeder_id']) {
									$data[$fd_key]['scope_as_per_award'][$fp_value['report_head']] = $fp_value['totalAwardQty'];
									$data[$fd_key]['work_completed'][$fp_value['report_head']] = $fp_value['workProgressQty'];
								}
							}
						}

						$errors = NULL;
			            $message = NULL;
			            $status_code = 200;
					}
				}
			}
		} else {
			$errors = 'Empty POST Request';
            $message = 'POST Request has no arguments';
            $status_code = 400;
            $data = [];
		}

		$this->response(['errors' => $errors, 'message' => $message, 'status_code' => $status_code, 'data' => $data], REST_Controller::HTTP_OK);
	}

	public function authenticateUser_post()
	{
		if (!empty($this->post())) {
			$username = $this->post('username');
			$password = $this->post('password');

			$user_details = $this->psdashboard_model->validateUser($username, $password);

			if ($user_details) {
				$jwt = $this->generate_jwt_token($user_details, $_ENV['API_KEY']);

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

	public function generate_jwt_token($user_details, $secret_key)
	{
		$issued_at = new DateTimeImmutable();
		// $expiry = $issued_at->modify('+1 minute')->getTimestamp();// Add 60 seconds
		$expiry = $issued_at->modify('+30 minute')->getTimestamp();// Add 60 seconds     //---Delete Later
		$serverName = $_SERVER['SERVER_NAME'];

		$payload = array(
	        'iat' => $issued_at->getTimestamp(),// Issued at: time when the token was generated
	        'iss' => $serverName,// Issuer
	        'nbf' => $issued_at->getTimestamp(),// Not before
	        'exp' => $expiry,//Token Expiry
	        'username' => $user_details['username'],
	        'useremail' => $user_details['email']
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