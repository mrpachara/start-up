<?php
	if(!defined("RESTCONFIGURATED")){
		header(((isset($_SERVER['SERVER_PROTOCOL']))? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0')." 404 Not Found");
		exit;
	}

	$GLOBALS['_rest']->setResponseContentType("application/javascript; charset=utf-8");
	ob_start();
	include $service.'-resource/'.$GLOBALS['_rest']->getArgument(0).'.php';
	$data = ob_get_clean();
?>
