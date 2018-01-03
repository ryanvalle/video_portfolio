<?php
	header('Content-Type: application/json');
	if ($_SERVER['REQUEST_METHOD'] != "POST")  {
		echo set_error_response(400, 'Bad Request');
		exit();	
	}

	/*
	 *	Save Video To DB
 	*/
	$data = $_POST;

	if ( !is_logged_in() ) {
		// todo validate token...
	 	echo set_error_response(403, 'Unauthorized');
	 	exit();
	}
	switch($data['table']) {
		case 'partners':
			$fields = array('logo','url','title','active');
			break;
		case 'contents':
			$fields = array('id', 'mapping_key','mapping_string');
			break;
	}
	$filtered_data = array();

	foreach ($data as $key => $value) {
		if (in_array($key, $fields)) {
			$filtered_data[$key] = $value;
		}
	}
	$save = update_db($data['table'], $filtered_data, $data['id']);
	http_response_code($save['status']);
	echo json_encode($save);

	exit();