<?php
	if(!defined("RESTCONFIGURATED")){
		header(((isset($_SERVER['SERVER_PROTOCOL']))? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0')." 404 Not Found");
		exit;
	}

	$data = [
		'uri' => $GLOBALS['_rest']->getConfigUri(),
		'links' => [
			[
				'rel' => 'self/javascript', 'href' => $GLOBALS['_rest']->getModulePath("javascript/angular-self.js"),
				'alias' => "angular-self", 'module-id' => "start-up.app",
			],

			[
				'rel' => 'module/javascript', 'href' => $GLOBALS['_rest']->getModulePath("javascript/angular-module.js"),
				'alias' => "angular-module", 'module-id' => "start-up",
			],

			['rel' => 'layout', 'href' => $GLOBALS['_rest']->getModulePath('html/layout.html'), 'alias' => "layout"],

			['rel' => 'module', 'href' => $GLOBALS['_rest']->getConfigUri('util'), 'alias' => "util"],
			['rel' => 'module', 'href' => $GLOBALS['_rest']->getConfigUri('oauth2'), 'alias' => "oauth2"],
			['rel' => 'module', 'href' => $GLOBALS['_rest']->getConfigUri('service01'), 'alias' => "service01"],
		],
	];
?>
