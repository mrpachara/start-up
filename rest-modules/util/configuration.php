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
				'alias' => "angular-self", 'module-id' => "util.app",
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
