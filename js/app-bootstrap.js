(function(GLOBALOBJECT, angular){
	'use strict';

	angular.module('app.bootstrap', ['ng', 'ldrvn', 'ldrvn.service'])
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
	], GLOBALOBJECT);
})(this, this.angular);
