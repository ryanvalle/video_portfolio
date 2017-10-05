<?php
	# Set an error response code and respond with JSON
	function set_error_response($code, $message) {
		http_response_code($code);
		header("Content-Type: application/json");
		$resp = array(
			'status' => $code,
			'message' => $message,
			'server' => array(),
			'request' => array()
		);

		foreach ($_REQUEST as $key => $value) { $resp['request'][$key] = $value; }
		foreach ($_SERVER as $key => $value) { $resp['server'][$key] = $value; }
		return json_encode($resp);
	}
