<?php
	header('Content-Type: application/json');
	if ($_SERVER['REQUEST_METHOD'] != "POST")  {
		echo set_error_response(400, 'Bad Request');
		exit();	
	}

	/*
	 *	Get json response from service and save
	 *	@params
 	 *		- token
 	 *		- url: String
 	 * 	@returns
 	 *		- Success: saved object
 	 * 		- Error: error object
 	*/
	$data = $_POST;

	if ( !is_logged_in() ) {
		// todo validate token...
	 	echo set_error_response(403, 'Unauthorized');
	 	exit();
	}

	if ( isset($data['url']) ) {
		$url = $data['url'];
		$parsed_url = parse_url($url);

		if ( array_key_exists('host',$parsed_url) && strpos($parsed_url['host'], 'vimeo') !== false ) {
			$oembed_endpoint = 'http://vimeo.com/api/oembed';
			$json_url = $oembed_endpoint . '.json?url=' . rawurlencode($url) . '&maxwidth=1920';
			$resp = http_get($json_url);
			error_log(gettype($resp))	;
			if (gettype($resp) == "object") {
				$save_data = array(
					'url' => $url,
					'iframe' => $resp->html,
					'title' => $resp->title,
					'thumbnail' => $resp->thumbnail_url,
					'description' => $resp->description,
					'video_id' => $resp->video_id,
					'provider' => 'vimeo'
				);

				$save = array(
					'status' => 200,
					'data' => $save_data
				);
			} else {
				http_response_code(403);
				$save = array(
					'status' => 403,
					'message' => 'Unable to get video. Please check video permissions for ' . $url . '.'
				);
			}
		} else {
			http_response_code(400);
			$save = array(
				'status' => 400,
				'message' => 'Bad URL submitted.'
			);
		}
		echo json_encode($save);
	}

	exit();