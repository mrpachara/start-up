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
		['rel' => 'template', 'href' => $GLOBALS['_rest']->getModulePath('html/edit.html'), 'alias' => "new.html"],

		[
			'rel' => 'component', 'href' => $GLOBALS['_rest']->getModulePath("javascript/angular-module.js"), 'alias' => "component",
		],
		[
			'rel' => 'component', 'href' => $GLOBALS['_rest']->getModulePath("javascript/angular-module.js"), 'alias' => "data01-component",
		],
		[
			'rel' => 'component', 'href' => $GLOBALS['_rest']->getModulePath("javascript/angular-module.js"), 'alias' => "data01-list-component",
			'service' => 'service01Data01ListService', 'controller' => 'DefaultComponentListController', 'template' => 'list.html',
		],
		[
			'rel' => 'component', 'href' => $GLOBALS['_rest']->getModulePath("javascript/angular-module.js"), 'alias' => "data01-view-component",
			'service' => 'service01Data01ItemService', 'controller' => 'DefaultComponentItemController', 'template' => 'view.html',
		],
		[
			'rel' => 'component', 'href' => $GLOBALS['_rest']->getModulePath("javascript/angular-module.js"), 'alias' => "data01-edit-component",
			'service' => 'service01Data01ItemService', 'controller' => 'DefaultComponentItemController', 'template' => 'edit.html',
		],
		[
			'rel' => 'component', 'href' => $GLOBALS['_rest']->getModulePath("javascript/angular-module.js"), 'alias' => "data01-new-component",
			'service' => 'service01Data01ItemService', 'controller' => 'DefaultComponentItemController', 'template' => 'new.html',
		],

		[
			'rel' => 'router', 'href' => $GLOBALS['_rest']->getModulePath("javascript/angular-module.js"), 'alias' => "main-router",
			'path' => 'service01/...', 'name' => 'Service01', 'component' => 'component',
		],
		[
			'rel' => 'router', 'href' => $GLOBALS['_rest']->getModulePath("javascript/angular-module.js"), 'alias' => "data01-router",
			'path' => '/data01/...', 'name' => 'Data01', 'component' => 'data01-component', 'for' => 'service01-component',
		],
		[
			'rel' => 'router', 'href' => $GLOBALS['_rest']->getModulePath("javascript/angular-module.js"), 'alias' => "data01-router",
			'path' => '/', 'name' => 'List', 'component' => 'data01-list-component', 'for' => 'data01-component',
		],
		[
			'rel' => 'router', 'href' => $GLOBALS['_rest']->getModulePath("javascript/angular-module.js"), 'alias' => "data01-router",
			'path' => '/:id', 'name' => 'View', 'component' => 'data01-view-component', 'for' => 'data01-component',
		],
		[
			'rel' => 'router', 'href' => $GLOBALS['_rest']->getModulePath("javascript/angular-module.js"), 'alias' => "data01-router",
			'path' => '/:id/edit', 'name' => 'Edit', 'component' => 'data01-edit-component', 'for' => 'data01-component',
		],
		[
			'rel' => 'router', 'href' => $GLOBALS['_rest']->getModulePath("javascript/angular-module.js"), 'alias' => "data01-router",
			'path' => '/new', 'name' => 'New', 'component' => 'data01-new-component', 'for' => 'data01-component',
		],
	]);
?>
