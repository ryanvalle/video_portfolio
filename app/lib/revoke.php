<?php
	header('Content-Type: application/json');
	if ($_SERVER['REQUEST_METHOD'] != "POST")  {
		echo set_error_response(400, 'Bad Request');
		exit();	
	}

	if (array_key_exists('rwp_admin_session', $_COOKIE)) {
		$cookie = $_COOKIE['rwp_admin_session'];
	}
	if (isset($cookie)) {
		$cookie_split = explode(".", $cookie);
		$token = $cookie_split[0];
		$user_id = $cookie_split[1];
		$session = delete_session($user_id, $token);
	}
	$result = array(
		'message' => 'Logged Out'
	);
	http_response_code(200);
	echo json_encode($result);

	exit();