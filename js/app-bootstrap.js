(function(GLOBALOBJECT, angular){
	'use strict';

	var appConfig;
	try{
		appConfig = angular.module('app.config');
	} catch(excp){
		appConfig = angular.module('app.config', []).constant('config', {
			'appName': 'Unkonwn',
			'configURI': null,
		});
	}

	angular.injector(['ng'], true).invoke([
		'$cacheFactory',
		function($cacheFactory){
			appConfig.constant('configCache', $cacheFactory('config-cache'));
		}
	]);

	/**********************************************************************************************************
		IMPORTANT: DO NOT cache configuration loader from app.config, because it has difference config engine.
		The code below doesn't work anymore.
	***********************************************************************************************************/
	//appConfig.constant('configLoaderCache', angular.injector(['ng']).get('$cacheFactory')('config-loader-cache'));

	angular.module('app.bootstrap', ['ng', 'ldrvn', 'ldrvn.service', appConfig.name])
		.config([
			'config', 'configServiceProvider',
			function(config, configServiceProvider){
				if(config.configURI) configServiceProvider.configURI(config.configURI);
			}
		])
	;

	angular.injector(['app.bootstrap'], true).invoke([
		'$log', '$document', 'moduleService',
		function($log, $document, moduleService){
			moduleService.appendScripts().then(
				function(moduleIds){
					moduleIds.unshift(appConfig.name);
					$log.info('loaded modules:', moduleIds);
					var document = $document[0];
					angular.element(document).ready(function(){
						angular.bootstrap(document, moduleIds, {'strictDi': true});
					});
				},
				function(error){
					throw error;
				}
			);
		}
	]);
})(this, angular);
