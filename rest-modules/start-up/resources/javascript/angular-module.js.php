<?php
	if(!defined("RESTCONFIGURATED")){
		header(((isset($_SERVER['SERVER_PROTOCOL']))? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0')." 404 Not Found");
		exit;
	}
?>
(function(GLOBALOBJECT, angular){
	'use strict';

	angular.module(<?= json_encode($config->linkProp('angular-module', 'module-id')) ?>, [
		'ldrvn', 'ldrvn.service', 'ngComponentRouter',
		'util',
	])
		.factory('startUpConfigLoader', [
			'$ldrvn',
			function($ldrvn){
				return $ldrvn.loadConfig(<?= json_encode($GLOBALS['_rest']->getConfigUri()) ?>);
			}
		])

		.factory('startUpService', [
			'$ldrvn',
			'startUpConfigLoader',
			function($ldrvn, startUpConfigLoader){
				return $ldrvn.createService(startUpConfigLoader, {
					'menu': function(){
						var service = this;
						return (service.$$configService)? service.$$configService.load('menu').then(function(data){
							return data;
						}) : null;
					},
				});
			}
		])
	;
})(this, angular);
