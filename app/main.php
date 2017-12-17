<?php
	error_reporting(E_ALL);
	require_once('config/globals.php');
	require_once('config/mysql.php');
	require_once('helpers/mysql.php');
  require_once('helpers/template_helpers.php');
  require_once('helpers/response_helpers.php');
  require_once('helpers/request_helpers.php');

  $URL = parse_url($_SERVER['REQUEST_URI']);
  $header_type = 'small-header';
  require_once('routes.php');

  $data = get_page_by_slug($URL['path']);
  // Check if a video
  if ($data == NULL) {
    $data = get_video_by_slug($URL['path']);
    if ($data) {
      $data['page_type'] = 4;
    }
  }
  if ($data == NULL) {
    http_response_code(404);
  }

  $translations = get_page_translations($data['page_type']);
  include('templates/partials/_header.php');

  if ($data == NULL) {
    echo '404...';
  } else {
    include('templates/main/' . $data['template'] . '.php');
  }

  include('templates/partials/_footer.php');

  # Only show debug stuff locally
  if ($_SERVER['HTTP_HOST'] && $config['debug']) {
    include('templates/partials/_debug.php');
  }
