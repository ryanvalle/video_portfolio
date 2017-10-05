<?php
	switch ($URL['path']) {
    case '/_admin/video_import':
      include('lib/video_import.php');
      break;
  }

  if ( strpos($URL['path'], '_admin') !== false ) {
  	include('admin.php');
  	exit();
  }