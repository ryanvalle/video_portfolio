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

	if ( !isset($data['token'])) {
		// todo validate token...
	 	echo set_error_response(403, 'Unauthorized');
	 	exit();
	}

	// Save thumbnail locally 
	$thumb = parse_url($data['thumbnail']);
	$filename = basename($thumb['path']);

	$local_thumb = file_put_contents('public/assets/images/'.$filename, fopen($data['thumbnail'],'r'), FILE_APPEND);

	if ($local_thumb > 0) {
		$data['thumbnail'] = '/public/assets/images/'.$filename;
	}
	$save = save_to_db('videos', $data);
	http_response_code($save['status']);
	echo json_encode($save);

	exit();