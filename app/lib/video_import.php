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
	$data = json_decode(file_get_contents('php://input'), true);

	if ( !isset($data['token'])) {
		// todo validate token...
	 	echo set_error_response(403, 'Unauthorized');
	 	exit();
	}

	if ( isset($data['url']) ) {
		$url = $data['url'];
		$parsed_url = parse_url($url);

		if ( strpos($parsed_url['host'], 'vimeo') !== false ) {
			$oembed_endpoint = 'http://vimeo.com/api/oembed';
			$json_url = $oembed_endpoint . '.json?url=' . rawurlencode($url) . '&maxwidth=1920';

			$resp = http_get($json_url);
			$save_data = array(
				'url' => $url,
				'iframe' => $resp->html,
				'title' => $resp->title,
				'thumbnail' => $resp->thumbnail_url,
				'description' => $resp->description,
				'video_id' => $resp->video_id,
				'provider' => 'vimeo'
			);

			if ($data['save'] == true) {
				$save = save_to_db("videos", $save_data);
			} else {
				$save = array(
					'status' => 200,
					'data' => $save_data
				);
			}
			echo json_encode($save);
		}
	}

	exit();