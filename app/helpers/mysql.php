<?php

	function get_table_list($table, $query) {
		global $conn;
		$sql = "SELECT * from " . $table;
		if ($query) { $sql = $sql . " " . $query; }
		$result = [];
		if ($query = $conn->query($sql)) {
			$result = $query;
		}
		return $result;
	}

	function get_categories() {
		global $conn;
		$sql = "SELECT * from categories ORDER BY display_order ASC";
		$result = [];
		if ($query = $conn->query($sql)) {
			$result = $query;
		}
		return $result;
	}

	function get_page_by_slug($slug) {
		global $conn;
		$sql = "SELECT * FROM pages WHERE slug='".$slug."'";
		if ($query = $conn->query($sql)) {
			$result = $query->fetch_assoc();
		}
		return $result;
	}

	function get_video_by_id($id) {
		global $conn;
		$sql = "SELECT * FROM videos WHERE id='".$id."'";
		if ($query = $conn->query($sql)) {
			$result = $query->fetch_assoc();
		}
		return $result;
	}

	function get_video_by_slug($slug) {
		global $conn;
		$parsed_slug = array_values(array_filter(explode('/', $slug)));
		if ($parsed_slug[0] == 'video') {
			$sql = "SELECT * FROM videos WHERE slug='".$parsed_slug[1]."'";
			if ($query = $conn->query($sql)) {
				$result = $query->fetch_assoc();
			}
			if ($result) { $result['template'] = 'video_show'; }
			return $result;
		}
	}

	function get_videos($type) {
		global $conn;
		$selector = '';
		switch ($type) {
			case 'portfolio':
				$selector = ' WHERE (feature_tag!="feat_ex" OR feature_tag!="testim") AND feature_tag!="hide" ORDER BY priority ASC';
				break;
			case 'featured':
				$selector = ' WHERE feature_tag="feat" OR feature_tag="feat_ex" ORDER BY feat_priority ASC';
				break;
			case 'testimonials':
				$selector = ' WHERE feature_tag="testim" ORDER BY priority ASC LIMIT 3';
				break;
			default:
				$selector = ' WHERE feature_tag!="hide" ORDER BY priority ASC';
				break;
		}
		$sql = "SELECT * FROM videos" . $selector;
		$result = [];
		if ($query = $conn->query($sql)) { $result = $query; }
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

	function update_db($table, $data, $id) {
		global $conn;
		$sets = array();
		foreach ($data as $key => $value) {
			if ($key != 'token') {
				array_push($sets, $key . "='" . addslashes($value) . "'");
			}
		}
		$set = implode(', ', $sets);
		$sql = "UPDATE " . $table  . " SET " . $set . " WHERE id=" . $id;

		if ($query = $conn->query($sql)) {
			return array(
				'status' => 200,
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
