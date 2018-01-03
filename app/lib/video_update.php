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

	$save = update_db('videos', $data, $data['id']);
	http_response_code($save['status']);
	echo json_encode($save);

	exit();