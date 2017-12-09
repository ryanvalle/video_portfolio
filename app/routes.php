<?php
	switch ($URL['path']) {
    case '/_admin/video_import':
      include('lib/video_import.php');
      break;
    case '/_admin/video_save':
      include('lib/video_save.php');
      break;
    case '/_admin/video_update':
      include('lib/video_update.php');
      break;    
    case '/_admin/logo_save':
      include('lib/logo_save.php');
      break;
    case '/_admin/update':
      include('lib/update_db.php');
      break;
    case '/_contact':
      include('lib/contact.php');
      break;
    case '/_info':
      phpinfo();
      break;
    case '/':
      $header_type = 'large-header';
      break;
  }

  if ( strpos($URL['path'], '/_admin') !== false ) {
  	include('admin.php');
  	exit();
  }

