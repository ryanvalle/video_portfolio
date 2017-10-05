<?php
	function page_key_to_title($key) {
		global $admin_nav;
		return $admin_nav[$key]['title'];
	}