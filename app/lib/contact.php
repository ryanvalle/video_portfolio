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
	$body = '';
	foreach($data as $key => $value) {
		$body .= $key . ": " . $value . "\n\n";
	}

	if ( mail('rwptest@mailinator.com', 'Randy Witt Productions Website Message', $body) ) {
		$data['status'] = 200;
	} else {
		$data['status'] = 400;
	}


	http_response_code($data['status']);
	echo json_encode($data);

	exit();