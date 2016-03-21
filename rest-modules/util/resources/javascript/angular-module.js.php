<?php
	if(!defined("RESTCONFIGURATED")){
		header(((isset($_SERVER['SERVER_PROTOCOL']))? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0')." 404 Not Found");
		exit;
	}
?>
(function(GLOBALOBJECT, angular){
	'use strict';

	var $iconSetNames = [];

	angular.module(<?= json_encode($config->linkProp('angular-module', 'module-id')) ?>, [
		'ldrvn', 'ldrvn.service',
		'ngMaterial',
	])
		.constant('iconLinks', <?= json_encode($config->links('icon/svg')) ?>)

		.config([
			'$provide',
			'$mdIconProvider',
			'iconLinks',
			function($provide, $mdIconProvider, iconLinks){
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
	;
})(this, this.angular);
