(function(GLOBALOBJECT, angular){
	'use strict';

	var appConfig = angular.module('app.config', []);
	appConfig.constant('configCache', angular.injector(['ng']).get('$cacheFactory')('config-cache'));

	angular.module('app.bootstrap', ['ng', 'ldrvn', 'ldrvn.service', 'app.config'])
		.config([
			'configServiceProvider',
			function(configServiceProvider){
				configServiceProvider.configURI(GLOBALOBJECT.APPCONFIGFILE);
			}
		])
	;

	angular.injector(['app.bootstrap'], true).invoke([
		'$log', '$document', 'moduleService',
		function($log, $document, moduleService){
			moduleService.appendScripts().then(
				function(moduleIds){
					moduleIds.unshift('app.config');
					$log.info('loaded modules:', moduleIds);
					var document = $document[0];
					angular.element(document).ready(function(){
						angular.bootstrap(document, moduleIds, {strictDi: true});
					});
				},
				function(error){
					throw error;
				}
			);
		}
	]);
})(this, this.angular);
