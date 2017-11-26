<?php
	# TODO: Implement authorization user session check...
	// echo set_error_response(403, 'Unauthorized');
	// exit();

	$admin_nav = array(
		'home' => array(
			'url' => '/_admin',
			'title' => 'Admin Home'
		),
		'videos' => array(
			'url' => '/_admin/videos',
			'title' => 'Video Manager'
		),
		'logos' => array(
			'url' => '/_admin/logos',
			'title' => 'Logo Manager'
		),
	);

	include('helpers/admin_helpers.php');
	$path = explode('/', $URL['path']);
	$path = array_filter($path, function($v) { return $v !== ''; });
	if (count($path) > 1) {
		$page_key = end($path);
		if ($page_key == '') { $page_key = false; }
	}  else {
		$page_key = 'home';
	}
	$data = array(
		'page_key' => $page_key
	);

	$file = 'admin/templates/' . $page_key . '.php';
	if (!file_exists($file)) {
		echo set_error_response(404, $path);
		exit();
	}

	include('admin/partials/_header.php');
	include($file);
	include('templates/partials/_debug.php');
	include('admin/partials/_footer.php');