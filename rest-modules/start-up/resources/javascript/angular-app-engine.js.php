<?php
	if(!defined("RESTCONFIGURATED")){
		header(((isset($_SERVER['SERVER_PROTOCOL']))? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0')." 404 Not Found");
		exit;
	}
?>
(function(GLOBALOBJECT, angular){
	'use strict';

	angular.module(<?= json_encode($config->linkProp('angular-app-engine', 'module-id')) ?>, [
		'ngMaterial',
		'util', 'util.default',
	])
		.config([
			'$httpProvider', 'utilProvider',
			'appIconProvider', 'appEngineProvider',
			'utilDefault',
			function(
				$httpProvider, utilProvider,
				appIconProvider, appEngineProvider,
				utilDefault
			){
				utilProvider.setting({
					'defaultMessageService': 'utilNotificationService',
				});

				appIconProvider.initIcons(utilDefault.iconLinks);

				appEngineProvider.cmds(angular.extend({}, utilDefault.cmds));
				appEngineProvider.services(angular.extend({}, utilDefault.services, {
					//'template': 'startUpTemplate',
				}));
				appEngineProvider.registers(angular.extend({}, utilDefault.registers));

				$httpProvider.interceptors.push('utilDefaultHttpInterceptor');
			}
		])
		.run([
			'appIcon',
			function(appIcon){
				appIcon.preloadIcons();
			}
		])

		.factory('startUpTemplate', [
			'$q',
			'utilTemplate', 'startUpService',
			function($q, utilTemplate, startUpService){
				function template(alias){
					if(startUpService.template(alias)) return startUpService.template(alias);
					return utilTemplate(alias);
				}

				template.promise = $q.all(utilTemplate.promise, startUpService.promise).then(function(){
					return template;
				});

				return template;
			}
		])
	;
})(this, angular);
