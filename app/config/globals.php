<?php
	$additional_scripts = [];
	# DB CONNECTION FOR CLEARDB DATABASE - DEVELOPMENT
	$config = array(
		'debug' => true,
		'contact_email' => 'rwptest@mailinator.com',
		'show_contact_form_header' => true
	);

	$navigation = array(
		'about' => array('url' => '/about', 'title' => 'About'),
		'portfolio' => array('url' => '/portfolio', 'title' => 'Portfolio'),
		'contact' => array('url' => '/contact-us', 'title' => 'Contact Us')
	);
	