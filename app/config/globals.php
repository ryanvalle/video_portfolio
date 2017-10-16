<?php
	$additional_scripts = [];
	# DB CONNECTION FOR CLEARDB DATABASE - DEVELOPMENT
	$config = array(
		'debug' => true,
		'contact_email' => 'rwptest@mailinator.com'
	);

	$navigation = array(
		'portfolio' => array('url' => '/portfolio', 'title' => 'Portfolio'),
		'about' => array('url' => '/about', 'title' => 'About'),
		'contact' => array('url' => '/contact-us', 'title' => 'Contact Us')
	);
	