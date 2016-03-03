<?php
	require_once "infra.inc.php";
	require_once "app.inc.php";

	$urlpath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	if(!empty($_SERVER['PATH_INFO'])) $urlpath = substr($urlpath, 0, -strlen($_SERVER['PATH_INFO']));
	//var_dump($urlpath);

	define('APPPATH', $urlpath);
	require "template/app.php";
?>
