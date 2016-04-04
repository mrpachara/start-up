<?php
	if(!defined("RESTCONFIGURATED")){
		header(((isset($_SERVER['SERVER_PROTOCOL']))? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0')." 404 Not Found");
		exit;
	}

	include __DIR__.'/../../vendor/mrpachara/php-lib/test/rest-modules/service01/configuration.php';

	$data['links'] = array_merge($data['links'], [
		[
			'rel' => 'module/javascript', 'href' => $GLOBALS['_rest']->getModulePath("javascript/angular-module.js"),
			'alias' => "angular-module", 'module-id' => "service01",
		],

		['rel' => 'template', 'href' => $GLOBALS['_rest']->getModulePath('html/list.html'), 'alias' => "list.html"],
		['rel' => 'template', 'href' => $GLOBALS['_rest']->getModulePath('html/view.html'), 'alias' => "view.html"],
		['rel' => 'template', 'href' => $GLOBALS['_rest']->getModulePath('html/edit.html'), 'alias' => "edit.html"],
	]);
?>
