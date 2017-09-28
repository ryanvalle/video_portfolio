<?php
	error_reporting(E_ALL);
	require_once('config/mysql.php');
	require_once('helpers/mysql.php');
	require_once('helpers/template_helpers.php');

  $URL = parse_url($_SERVER['REQUEST_URI']);
  $data = get_page_by_slug($URL['path']);

  include('templates/partials/_header.php');

  var_dump($data);
  include('templates/partials/_footer.php');
