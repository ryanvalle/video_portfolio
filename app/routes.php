<?php
  switch ($URL['path']) {
    case '/_admin/video_import':
      include('helpers/admin_helpers.php');
      include('lib/video_import.php');
      break;
    case '/_admin/video_save':
      include('helpers/admin_helpers.php');
      include('lib/video_save.php');
      break;
    case '/_admin/video_update':
      include('helpers/admin_helpers.php');
      include('lib/video_update.php');
      break;    
    case '/_admin/logo_save':
      include('helpers/admin_helpers.php');
      include('lib/logo_save.php');
      break;
    case '/_admin/update':
      include('helpers/admin_helpers.php');
      include('lib/update_db.php');
      break;
    case '/_admin/save_string':
      include('helpers/admin_helpers.php');
      include('lib/save_string.php');
      break;
    case '/_admin/authenticate':
      include('helpers/admin_helpers.php');
      include('lib/authenticate.php');
      break;
    case '/_admin/revoke':
      include('lib/revoke.php');
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

