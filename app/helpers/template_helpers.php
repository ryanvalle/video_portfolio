<?php
	$defaults = array(
		'title' => 'Randy Witt Productions'
	);
	# Get the page tittle based on the page title
	function get_page_title($data) {
		global $defaults;
		$title = $defaults['title'];
		if ($data && array_key_exists('page_title', $data)) {
			$title = $data['page_title'] . ' | ' . $title;
		} elseif ($data && array_key_exists('title', $data)) {
			$title = $data['title'] . ' | ' . $title;
		}
		return $title;
	}
