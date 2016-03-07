<?php
	if(!defined("RESTCONFIGURATED")){
		header(((isset($_SERVER['SERVER_PROTOCOL']))? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0')." 404 Not Found");
		exit;
	}

	/*
	ini_set("display_errors", 1);
	ini_set("track_errors", 1);
	ini_set("html_errors", 1);
	error_reporting(E_ALL);
	*/

	$GLOBALS['_grantservice']->authozExcp();

	$data = $GLOBALS['_oauth2server']->getAccessTokenData(\OAuth2\Request::createFromGlobals());
?>
