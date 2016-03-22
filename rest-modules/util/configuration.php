<?php
	if(!defined("RESTCONFIGURATED")){
		header(((isset($_SERVER['SERVER_PROTOCOL']))? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0')." 404 Not Found");
		exit;
	}

	$data = [
		'uri' => $GLOBALS['_rest']->getConfigUri(),
		'links' => [
			[
				'rel' => 'stylesheet', 'href' => $GLOBALS['_rest']->getModulePath("bower_components/angular-material/angular-material.css"),
				'alias' => "angular-material-css",
			],

			[
				'rel' => 'self/javascript', 'href' => $GLOBALS['_rest']->getModulePath("javascript/angular-self.js"),
				'alias' => "angular-self", 'module-id' => "util.app",
			],

			[
				'rel' => 'module/javascript', 'href' => $GLOBALS['_rest']->getModulePath("bower_components/angular-aria/angular-aria.js"),
				'alias' => "angular-aria", 'module-id' => "ngAria",
			],
			[
				'rel' => 'module/javascript', 'href' => $GLOBALS['_rest']->getModulePath("bower_components/angular-animate/angular-animate.js"),
				'alias' => "angular-animate", 'module-id' => "ngAnimate",
			],
			[
				'rel' => 'module/javascript', 'href' => $GLOBALS['_rest']->getModulePath("bower_components/angular-messages/angular-messages.js"),
				'alias' => "angular-messages", 'module-id' => "ngMessages",
			],
			[
				'rel' => 'module/javascript', 'href' => $GLOBALS['_rest']->getModulePath("bower_components/angular-sanitize/angular-sanitize.js"),
				'alias' => "angular-sanitize", 'module-id' => "ngSanitize",
			],
			[
				'rel' => 'module/javascript', 'href' => $GLOBALS['_rest']->getModulePath("bower_components/angular-material/angular-material.js"),
				'alias' => "angular-material", 'module-id' => "ngMaterial",
			],
			[
				'rel' => 'module/javascript', 'href' => $GLOBALS['_rest']->getModulePath("node_modules/@angular/router/angular1/angular_1_router.js"),
				'alias' => "angular-component-router", 'module-id' => "ngComponentRouter",
			],
			[
				'rel' => 'module/javascript', 'href' => $GLOBALS['_rest']->getModulePath("javascript/angular-module.js"),
				'alias' => "angular-module", 'module-id' => "util",
			],

			['rel' => 'template', 'href' => $GLOBALS['_rest']->getModulePath('html/login.html'), 'alias' => "loading"],
		],
	];

	foreach(glob(__DIR__."/resources/material-design-icons/sprites/svg-sprite/*.svg") as $filename){
		$filenames = explode('/', $filename);
		$real_filename = $filenames[count($filenames) - 1];
		$set_names = explode('-', explode('.', $real_filename, 2)[0]);
		$set_name = $set_names[count($set_names) - 1];
		if($set_name == 'symbol') continue;
		$data['links'][] = [
			'rel' => 'icon/svg',
			'set-name' => $set_name,
			'href' => $GLOBALS['_rest']->getModulePath("svg/{$real_filename}"),
		];
	}
?>
