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
				'alias' => "angular-self", 'module-id' => "oauth2.app",
			],

			[
				'rel' => 'module/javascript', 'href' => $GLOBALS['_rest']->getModulePath("javascript/angular-module.js"),
				'alias' => "angular-module", 'module-id' => "oauth2",
			],

			['rel' => 'service', 'href' => $GLOBALS['_rest']->getModulePath('token'), 'alias' => "token"],
			['rel' => 'service', 'href' => $GLOBALS['_rest']->getModulePath('tokeninfo'), 'alias' => "tokeninfo"],
			['rel' => 'service', 'href' => $GLOBALS['_rest']->getModulePath('jwttoken'), 'alias' => "jwttoken"],
		],
	];
?>
