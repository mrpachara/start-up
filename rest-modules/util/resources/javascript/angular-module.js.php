<?php
	if(!defined("RESTCONFIGURATED")){
		header(((isset($_SERVER['SERVER_PROTOCOL']))? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0')." 404 Not Found");
		exit;
	}
?>
(function(GLOBALOBJECT, angular){
	'use strict';

	angular.element('head').append('<link rel="stylesheet" type="text/css" href="<?= htmlspecialchars($config->linkProp('angular-material-css', 'href')) ?>" />')

	var $iconSetNames = [];

	angular.module(<?= json_encode($config->linkProp('angular-module', 'module-id')) ?>, [
		'ldrvn', 'ldrvn.service',
		'ngMaterial',
	])
		.constant('iconLinks', <?= json_encode($config->links('icon/svg')) ?>)

		.config([
			'$provide', '$httpProvider',
			'$mdIconProvider',
			'iconLinks',
			function($provide, $httpProvider, $mdIconProvider, iconLinks){
				angular.forEach(iconLinks, function(link){
					$iconSetNames.push(link['set-name']);
					$mdIconProvider.iconSet(link['set-name'], link.href);
				});

				$provide.decorator('$mdIcon', [
					'$delegate',
					function($delegate){
						return function(){
							var args = [].slice.call(arguments);
							var id = args[0];
							var ids = id.split(':', 2);

							if((ids.length === 2) && ($iconSetNames.indexOf(ids[0]) >= 0)){
								args[0] = args[0].replace(/-/g, '_') + '_24px';
							}

							return $delegate.apply(undefined, args);
						}
					}
				]);

				$httpProvider.interceptors.push('utilHttpInterceptor');
			}
		])

		.run([
			'$http', '$templateCache', 'iconLinks',
			function($http, $templateCache, iconLinks){
				angular.forEach(iconLinks, function(link) {
					$http.get(link.href, {cache: $templateCache});
				});
			}
		])

		.factory('utilHttpInterceptor', [
			'$injector',
			function($injector){
				var service;
				return service = {
					'response': function(response){
						try{
							var $mdToast = $injector.get('$mdToast');
							if(angular.isDefined(response.data) && (response.data !== null) && angular.isDefined(response.data.info)){
								$mdToast.showSimple(message);
							}
						} catch(excp){}

						return response;
					},
					'responseError': function(reject){
						try{
							var
								$q = $injector.get('$q'),
								$mdToast = $injector.get('$mdToast')
							;

							var message;
							if(reject instanceof Error){
								message = reject.message;
							} else if(angular.isDefined(reject.data) && (reject.data !== null) && angular.isDefined(reject.data.error_description)){
								message = reject.data.error_description;
							} else if(angular.isDefined(reject.statusText)){
								message = reject.statusText;
							} else{
								message = reject;
							}

							$mdToast.showSimple(message);
						} catch($excp){}

						return $q.reject(reject);
					},
				};
			}
		])
	;
})(this, this.angular);
