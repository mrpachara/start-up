<?php
	if(!defined("RESTCONFIGURATED")){
		header(((isset($_SERVER['SERVER_PROTOCOL']))? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0')." 404 Not Found");
		exit;
	}

	$GLOBALS['_rest']->setResponseContentType("image/svg+xml; charset=utf-8");
	$filename = __DIR__.'/../material-design-icons/sprites/svg-sprite/'.$GLOBALS['_rest']->getArgument(0);
	$data = fopen($filename, 'rb');
?>
