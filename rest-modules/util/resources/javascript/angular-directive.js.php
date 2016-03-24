<?php
	if(!defined("RESTCONFIGURATED")){
		header(((isset($_SERVER['SERVER_PROTOCOL']))? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0')." 404 Not Found");
		exit;
	}
?>
(function(GLOBALOBJECT, angular){
	'use strict';

	angular.module(<?= json_encode($config->linkProp('angular-directive', 'module-id')) ?>, [
		'ldrvn', 'ldrvn.service',
		'ngMaterial',
		'util',
	])
		.directive('utilAutofocus', [
			'$timeout',
			function($timeout){
				var local = {
					'handler': null,
				};
				var drtv;
				return drtv = {
					'restrict': 'A',
					'link': function(scope, elem, attrs){
						if(attrs.utilAutofocus && !scope.$eval(attrs.utilAutofocus)) return;

						if(local.handler !== null) $timeout.cancel(local.handler);

						local.handler = $timeout(function(){
							local.handler = null;

							elem.focus();
						}, 300);
					}
				};
			}
		])
	;
})(this, angular);
