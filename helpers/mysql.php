<?php

	function get_page_by_slug($slug) {
		global $conn;
		$sql = "SELECT * FROM pages WHERE slug='".$slug."'";
		if ($query = $conn->query($sql)) {
			$result = $query->fetch_assoc();
		}
		return $result;
	}
