<?php

	function is_logged_in() {
		if (array_key_exists('rwp_admin_session', $_COOKIE)) {
			$cookie = $_COOKIE['rwp_admin_session'];
		}
		if (isset($cookie)) {
			$cookie_split = explode(".", $cookie);
			$token = $cookie_split[0];
			$user_id = $cookie_split[1];
			error_log($token);
			error_log($user_id);
			$session = get_session_from_user_and_key($user_id, $token);
			return !!$session;
		} else {
			return false;
		}
	}

	function page_key_to_title($key) {
		global $admin_nav;
		return $admin_nav[$key]['title'];
	}

	function generate_auth_cookie($user) {
		$token = uniqid();
		$entry = array(
			'user_id' => $user['id'],
			'user_token' => hash('sha256', $token)
		);
		save_to_db('user_sessions', $entry);
		return $token;
	}