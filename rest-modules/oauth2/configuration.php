<?php
	if(!defined("RESTCONFIGURATED")){
		header(((isset($_SERVER['SERVER_PROTOCOL']))? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0')." 404 Not Found");
		exit;
	}

	$data = [
		'uri' => $GLOBALS['_rest']->getConfigUri(),
		'links' => [
			[
				'rel' => 'self/javascript', 'href' => $GLOBALS['_rest']->getModulePath("javascript/angular-app-engine.js"),
				'alias' => "angular-app-engine", 'module-id' => "app.engine",
			],
			[
				'rel' => 'self/javascript', 'href' => $GLOBALS['_rest']->getModulePath("javascript/angular-self.js"),
				'alias' => "angular-self", 'module-id' => "oauth2.app",
			],

			[
				'rel' => 'module/javascript', 'href' => $GLOBALS['_rest']->getModulePath("javascript/angular-module.js"),
				'alias' => "angular-module", 'module-id' => "oauth2",
			],

			['rel' => 'template', 'href' => $GLOBALS['_rest']->getModulePath('html/layout.html'), 'alias' => "layout.html"],
			['rel' => 'template', 'href' => $GLOBALS['_rest']->getModulePath('html/login-form.html'), 'alias' => "login-form.html"],

			['rel' => 'page', 'href' => $GLOBALS['_rest']->getRestPath('../oauth2/login'), 'alias' => "login-page"],

			['rel' => 'service', 'href' => $GLOBALS['_rest']->getModulePath('token'), 'alias' => "token"],
			['rel' => 'service', 'href' => $GLOBALS['_rest']->getModulePath('tokeninfo'), 'alias' => "tokeninfo"],
			['rel' => 'service', 'href' => $GLOBALS['_rest']->getModulePath('jwttoken'), 'alias' => "jwttoken"],

			['rel' => 'module', 'href' => $GLOBALS['_rest']->getConfigUri('util'), 'alias' => "util"],
		],
	];
?>
