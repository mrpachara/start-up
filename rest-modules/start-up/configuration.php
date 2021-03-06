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
				'alias' => "angular-self", 'module-id' => "start-up.app",
			],
			/*
			[
				'rel' => 'self/javascript', 'href' => $GLOBALS['_rest']->getModulePath("javascript/angular-predefined.js"),
				'alias' => "angular-predefined", 'module-id' => "app.predefined",
			],
			*/

			[
				'rel' => 'module/javascript', 'href' => $GLOBALS['_rest']->getModulePath("javascript/angular-module.js"),
				'alias' => "angular-module", 'module-id' => "start-up",
			],

			['rel' => 'menu', 'href' => $GLOBALS['_rest']->getModulePath('menu.json'), 'alias' => "menu"],

			['rel' => 'template', 'href' => $GLOBALS['_rest']->getModulePath('html/layout.html'), 'alias' => "layout.html"],
			['rel' => 'template', 'href' => $GLOBALS['_rest']->getModulePath('html/home.html'), 'alias' => "home.html"],
/*
			['rel' => 'template', 'href' => $GLOBALS['_rest']->getModulePath('html/view-action.html'), 'alias' => "view-action.html"],
*/
			['rel' => 'template', 'href' => $GLOBALS['_rest']->getModulePath('html/list-more-action.html'), 'alias' => "list-more-action.html"],

			['rel' => 'module', 'href' => $GLOBALS['_rest']->getConfigUri('util'), 'alias' => "util"],
			['rel' => 'module', 'href' => $GLOBALS['_rest']->getConfigUri('oauth2'), 'alias' => "oauth2"],
			['rel' => 'module', 'href' => $GLOBALS['_rest']->getConfigUri('service01'), 'alias' => "service01"],
		],
	];
?>
