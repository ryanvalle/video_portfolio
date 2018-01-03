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
		if ($table == 'contents') {
			$sql = "UPDATE " . $table  . " SET " . $set . " WHERE mapping_key=\"" . $data['mapping_key'] . "\"";
		} else {
			$sql = "UPDATE " . $table  . " SET " . $set . " WHERE id=" . $id;
		}

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
	
	function get_page_type_ids($id) {
		global $conn;
		$sql = "SELECT * FROM page_type_ids";
		if ($id >= 0) {
			$sql = $sql . " WHERE id=" . $id;
		}
		$result = [];
		if ($query = $conn->query($sql)) {
			$result = $query;
			if ($id >= 0) { $result = $result->fetch_assoc(); }
		}

		return $result;
	}

	function get_page_content($id) {
		global $conn;
		$sql = "SELECT * FROM page_type_ids WHERE id=" . $id;
		$result = [];
		if ($query = $conn->query($sql)) { $result = $query; }
		return $result;
	}

	function get_content_id_by_key($key) {
		global $conn;
		$sql = "SELECT * FROM contents WHERE mapping_key=" . $key;
		$result = [];
		if ($query = $conn->query($sql)) {
			$result = $query;
			$result = $result->fetch_assoc();
		}
		return $result['id'];	
	}

	function get_page_translations($id) {
		global $conn;
		$sql = "SELECT mapping_key, mapping_string FROM contents WHERE page_id=" . $id . " OR page_id=0"; 
		$result = array();
		$translations = array();
		if ($query = $conn->query($sql)) {
			$result = $query;
		}
		foreach($result as $key => $str) {
			$translations[$str['mapping_key']] = $str['mapping_string'];
		}
		return $translations;
	}

	function check_user_by_username($user) {
		global $conn;
		$sql = "SELECT * FROM users WHERE user='".$user."'";
		if ($query = $conn->query($sql)) {
			$result = $query->fetch_assoc();
		}
		return $result;
	}

	function get_session_from_user_and_key($user_id, $token) {
		global $conn;
		$encrypted_token = hash('sha256', $token);
		$sql = "SELECT * FROM user_sessions WHERE user_id=" . $user_id . " AND user_token='" . $encrypted_token . "'";
		if ($query = $conn->query($sql)) {
			$result = $query->fetch_assoc();
		}
		return $result;
	}

	function delete_session($user_id, $token) {
		global $conn;
		$encrypted_token = hash('sha256', $token);
		$sql = "DELETE FROM user_sessions WHERE user_id=" . $user_id . " AND user_token='" . $encrypted_token . "'";
		return $conn->query($sql);
	}
