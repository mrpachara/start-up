<?php
	if(!defined("RESTCONFIGURATED")){
		header(((isset($_SERVER['SERVER_PROTOCOL']))? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0')." 404 Not Found");
		exit;
	}
?>
(function(GLOBALOBJECT, angular){
	'use strict';

	angular.module(<?= json_encode($config->linkProp('angular-default', 'module-id')) ?>, [
		'ngMaterial',
		'util', 'util.default',
	])
		.config([
			'$httpProvider',
			'utilLogServiceProvider',
			'appEngineProvider',
			'utilDefault',
			function(
				$httpProvider, utilLogServiceProvider, appEngineProvider,
				utilDefault
			){
				appEngineProvider.initIcons(utilDefault.iconLinks);
				appEngineProvider.cmds(utilDefault.cmds);
				appEngineProvider.services(utilDefault.services);

				utilLogServiceProvider.setting({
					'notification': utilDefault.utilLogServiceNotification,
				});

				$httpProvider.interceptors.push('utilDefaultHttpInterceptor');
			}
		])
		.run([
			'appEngine',
			function(appEngine){
				appEngine.preloadIcons();
			}
		])

		.factory('utilTemplate', [
			'$q',
			'utilService', 'startUpService',
			function($q, utilService, startUpService){
				function template(alias){
					if(startUpService.template(alias)) return startUpService.template(alias);
					return utilService.template(alias);
				}

				template.promise = $q.all(utilService.promise, startUpService.promise).then(function(){
					return template;
				});

				return template;
			}
		])
	;
})(this, angular);
