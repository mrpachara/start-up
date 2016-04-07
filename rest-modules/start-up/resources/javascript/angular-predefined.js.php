<?php
	if(!defined("RESTCONFIGURATED")){
		header(((isset($_SERVER['SERVER_PROTOCOL']))? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0')." 404 Not Found");
		exit;
	}
?>
(function(GLOBALOBJECT, angular){
	'use strict';

	angular.module(<?= json_encode($config->linkProp('angular-predefined', 'module-id')) ?>, [
		'start-up',
	])
		.run([
			'$http', '$templateCache',
			'startUpService',
			function($http, $templateCache, startUpService){
				angular.forEach(['view-action.html', 'list-more-action.html'], function(alias){
					startUpService.promise.then(function(service){
						$http.get(service.template(alias), {'cache': $templateCache});
					});
				});
			}
		])

		.factory('appPredefined', [
			'startUpService',
			function(startUpService){
				return {
					'templateUrl': function(alias){
						return startUpService.template(alias);
					},
				};
			}
		])
	;
})(this, angular);
