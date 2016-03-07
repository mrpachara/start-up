<?php
	if(!defined("RESTCONFIGURATED")){
		header(((isset($_SERVER['SERVER_PROTOCOL']))? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0')." 404 Not Found");
		exit;
	}

	// Handle a request for an OAuth2.0 Access Token and send the response to the client
	$GLOBALS['_oauth2server']->handleTokenRequest(\OAuth2\Request::createFromGlobals())->send();
	exit();
?>
