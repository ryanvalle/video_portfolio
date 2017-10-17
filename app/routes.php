<?php
	switch ($URL['path']) {
    case '/_admin/video_import':
      include('lib/video_import.php');
      break;
    case '/_admin/video_save':
      include('lib/video_save.php');
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

