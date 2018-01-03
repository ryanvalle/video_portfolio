<?php
	header('Content-Type: application/json');
	if ($_SERVER['REQUEST_METHOD'] != "POST")  {
		echo set_error_response(400, 'Bad Request');
		exit();	
	}
	$data = $_POST;
	$username = $_POST["user"];
	$password = $_POST["password"];
	$hashed_pw = hash('sha256', $password);

	$stored_user = check_user_by_username($username);
	$result = array();
	if ($stored_user) {
		if ($hashed_pw == $stored_user['password']) {
			$result['status'] = 200;
			$result['token'] = generate_auth_cookie($stored_user) . "." . $stored_user['id'] . "." . uniqid();
		} else {
			$result['status'] = 401;
			$result['message'] = 'Incorrect password.';
		}
	} else {
		$result['status'] = 401;
		$result['message'] = 'User not found.';
	}

	http_response_code($result['status']);
	echo json_encode($result);

	exit();