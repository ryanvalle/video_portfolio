<?php 
echo 'Welcome <br />';
echo 'current path: '.parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);