<?php error_reporting(E_ERROR | E_PARSE);

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

		$path = base_url();

		// $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/');
		$dotenv = Dotenv\Dotenv::createImmutable($path);
		// echo 'dotenv<pre>'; print_r(__DIR__ . '/'); echo '</pre>'; die();
		$dotenv->load();
		// echo 'dotenv<pre>'; print_r($dotenv->load()); echo '</pre>'; die();

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
						// echo 'validate_token: <pre>'; print_r($validate_token); echo '</pre>';

						$date = (!empty($this->post('date'))) ? date('Y-m-d', strtotime($this->post('date'))) : date('Y-m-d');
						$lot_no = (isset($_POST['lot_no']) && !empty($this->post('lot_no'))) ? $this->post('lot_no') : 'NULL';

						/*if (empty($date)) {
							$errors = 'Empty POST Request';
				            $message = 'No date provided';
				            $status_code = 400;
				            $data = [];
						}*/

						$feeders_data = $this->psdashboard_model->getFeedersData($date, $lot_no);
						echo 'feeders_data: <pre>'; print_r($feeders_data); echo '</pre>'; die();

					}
				}
			}

			die();



			


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
	        // return JWT::decode($jwt, $secret_key, array('HS512'));
	        return JWT::decode($jwt, new Key($secret_key, 'HS512'));
	    } catch (ExpiredException $e) {
	        return new Exception('Token expired');
	        // return get_class($e);
	    } catch (SignatureInvalidException $e) {
	        // throw new Exception('Invalid token signature');
	        return new Exception('Invalid token signature');
	        // return get_class($e);
	    } catch (BeforeValidException $e) {
	        // throw new Exception('Token not valid yet');
	        return new Exception('Token not valid yet');
	        // return get_class($e);
	    } catch (Exception $e) {
	        // throw new Exception('Invalid token');
	        return new Exception('Invalid token');
	        // return get_class($e);
	    }
	}


}



?>