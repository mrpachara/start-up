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
				'rel' => 'stylesheet/less', 'href' => $GLOBALS['_rest']->getModulePath("css/util.less"),
				'alias' => "util-less",
			],
/*
			[
				'rel' => 'module/javascript', 'href' => $GLOBALS['_rest']->getModulePath("bower_components/jquery/dist/jquery.js"),
				'alias' => "jquery", 'module-id' => "jquery",
			],
*/
			[
				'rel' => 'module/javascript', 'href' => $GLOBALS['_rest']->getModulePath("bower_components/angular/angular.js"),
				'alias' => "angular", 'module-id' => "ng",
			],
			[
				'rel' => 'module/javascript', 'href' => $GLOBALS['_rest']->getModulePath("bower_components/link-driven/angular-core.js"),
				'alias' => "ldrvn", 'module-id' => "ldrvn",
			],
			[
				'rel' => 'module/javascript', 'href' => $GLOBALS['_rest']->getModulePath("bower_components/link-driven/angular-service.js"),
				'alias' => "ldrvn-service", 'module-id' => "ldrvn.service",
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
			[
				'rel' => 'module/javascript', 'href' => $GLOBALS['_rest']->getModulePath("javascript/angular-directive.js"),
				'alias' => "angular-directive", 'module-id' => "util.directive",
			],
			[
				'rel' => 'module/javascript', 'href' => $GLOBALS['_rest']->getModulePath("javascript/angular-default.js"),
				'alias' => "angular-default", 'module-id' => "util.default",
			],

			['rel' => 'template', 'href' => $GLOBALS['_rest']->getModulePath('html/popup-dialog.html'), 'alias' => "popup-dialog.html"],
			['rel' => 'template', 'href' => $GLOBALS['_rest']->getModulePath('html/log-list.html'), 'alias' => "log-list.html"],
			['rel' => 'template', 'href' => $GLOBALS['_rest']->getModulePath('html/search-form.html'), 'alias' => "search-form"],
			['rel' => 'template', 'href' => $GLOBALS['_rest']->getModulePath('html/menu.html'), 'alias' => "menu"],
			['rel' => 'template', 'href' => $GLOBALS['_rest']->getModulePath('html/menu-item.html'), 'alias' => "menu-item"],

			['rel' => 'template', 'href' => $GLOBALS['_rest']->getModulePath('html/list-more-action.html'), 'alias' => "list-more-action.html"],
			['rel' => 'template', 'href' => $GLOBALS['_rest']->getModulePath('html/list-global-action.html'), 'alias' => "list-global-action.html"],
			['rel' => 'template', 'href' => $GLOBALS['_rest']->getModulePath('html/view-action.html'), 'alias' => "view-action.html"],
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
