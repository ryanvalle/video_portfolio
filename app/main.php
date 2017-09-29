<?php
	error_reporting(E_ALL);
	require_once('config/globals.php');
	require_once('config/mysql.php');
	require_once('helpers/mysql.php');
	require_once('helpers/template_helpers.php');

  $URL = parse_url($_SERVER['REQUEST_URI']);
  $data = get_page_by_slug($URL['path']);
  if ($data == NULL) {
    http_response_code(404);
  }

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
