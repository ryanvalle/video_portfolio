<?php
	$defaults = array(
		'title' => 'Randy Witt Productions'
	);
	# Get the page tittle based on the page title
	function get_page_title($data) {
		global $defaults;
		$title = $defaults['title'];
		if ($data && $data['page_title']) {
			$title = $data['page_title'] . ' | ' . $title;
		}
		return $title;
	}
