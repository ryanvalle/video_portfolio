<?php

	function get_page_by_slug($slug) {
		global $conn;
		$sql = "SELECT * FROM pages WHERE slug='".$slug."'";
		if ($query = $conn->query($sql)) {
			$result = $query->fetch_assoc();
		}
		return $result;
	}

	function save_to_db($table, $data) {
		global $conn;
		$keys = array();
		$values = array();
		foreach ($data as $key => $value) {
			if ($key != 'token') {
				array_push($keys, $key);
				array_push($values, "\"" . $conn->real_escape_string($value) . "\"");
			}
		}
		$key_str = "(" . implode(', ',$keys) . ")";
		$value_str = "(" . implode(', ',$values) . ")";

		$sql = "INSERT INTO " . $table . " " . $key_str . " VALUES " . $value_str;

		if ($query = $conn->query($sql)) {
			return array(
				'status' => 201,
				'data' => $data
			);
		} else {
			return array(
				"status" => 400,
				"error" => $conn->error,
				"query" => $sql
			);
		}
	}
