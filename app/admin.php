<?php
	# TODO: Implement authorization user session check...
	// echo set_error_response(403, 'Unauthorized');
	// exit();

	$admin_nav = array(
		'home' => array(
			'url' => '/_admin',
			'title' => 'Admin Home',
			'active_nav' => true,
			'auth' => true
		),
		'pages' => array(
			'url' => '/_admin/pages',
			'title' => 'Page Manager',
			'active_nav' => true,
			'auth' => true
		),
		'page_edit' => array(
			'url' => '/_admin/page_edit',
			'title' => 'Page Content Manager',
			'active_nav' => false,
			'auth' => true
		),
		'videos' => array(
			'url' => '/_admin/videos',
			'title' => 'Video Manager',
			'active_nav' => true,
			'auth' => true
		),
		'videos_edit' => array(
			'url' => '/admin/videos_edit',
			'title' => 'Edit Video',
			'active_nav' => false,
			'auth' => true
		),
		'logos' => array(
			'url' => '/_admin/logos',
			'title' => 'Logo Manager',
			'active_nav' => true,
			'auth' => true
		),
		'login' => array(
			'url' => '/_admin/login',
			'title' => 'Login Portal',
			'active_nav' => false,
			'auth' => false
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

	if ($admin_nav[$page_key]['auth'] && !is_logged_in()) {
		header("Location: " . $admin_nav['login']['url']);
		exit();
	}

	include('admin/partials/_header.php');
	include($file);
