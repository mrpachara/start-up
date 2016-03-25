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

				$provide.decorator('$mdIcon', $mdIconDecorator);

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

		.provider('utilLogService', [
			function(){
				var providerLocal = {
					'maxLog': 50,
				};
				var provider = this;
				return angular.extend(provider, {
					'maxLog': function(value){
						if(arguments.length === 2){
							providerLocal.maxLog = value;
							return provider;
						} else{
							return providerLocal.maxLog;
						}
					},
					'$get': [
						'util',
						function(util){
							return util.createLog(providerLocal.maxLog);
						}
					]
				});
			}
		])

		.factory('utilConfigLoader', [
			'$ldrvn',
			function($ldrvn){
				return $ldrvn.loadConfig(<?= json_encode($GLOBALS['_rest']->getConfigUri()) ?>);
			}
		])

		.factory('utilService', [
			'$ldrvn',
			'$mdDialog',
			'utilConfigLoader',
			function($ldrvn, $mdDialog, utilConfigLoader){
				return $ldrvn.createService(utilConfigLoader, {
					'showLog': function(ev){
						var service = this;

						return service.promise.then(function(service){
							return $mdDialog.show({
								'autoWrap': false,
								'templateUrl': service.template('popup-dialog'),
								'targetEvent': ev,
								'controller': 'UtilDialogController',
								'bindToController': true,
								'controllerAs': 'dialog',
								'locals': {
									'name': 'Log',
									'template': service.template('log-list'),
								},
							});
						});
					},
				});
			}
		])

		.factory('utilHttpInterceptor', [
			'$injector', '$q',
			'utilLogService',
			function($injector, $q, utilLogService){
				var service;
				return service = {
					'response': function(response){
						try{
							var $mdToast = $injector.get('$mdToast');

							if(response.data && response.data.info){
								var message = response.data.info;

								utilLogService.push('info', message, response.data);
								$mdToast.showSimple(message);
							}
						} catch(excp){}

						return response;
					},
					'responseError': function(reject){
						try{
							var $mdToast = $injector.get('$mdToast');

							var message;
							if(reject instanceof Error){
								message = reject.message;
							} else if(reject.data && reject.data.error_description){
								message = reject.data.error_description;
							} else if(reject.statusText){
								message = reject.statusText;
							} else{
								message = reject;
							}

							utilLogService.push('error', message, (reject.data)? reject.data : reject);
							$mdToast.showSimple(message);
						} catch($excp){}

						return $q.reject(reject);
					},
				};
			}
		])

		.factory('util', [
			'$q', '$timeout', '$log',
			function($q, $timeout, $log){
				var service;

				return service = {
					'createProgress': function(_settings){
						var settings = {
							'delay': 300,
							'timeout': 30000,
						};
						angular.extend(settings, _settings);

						var localProvider = {
							'count': 0,
						};

						var service;
						return service = {
							'process': function(promise){
								var handler = $timeout(function(){
									localProvider.count++;

									var timeoutHandler = $timeout(function(){
										timeoutHandler = null;
										$log.warn('timeout for:', promise);
										localProvider.count--;
									}, settings.timeout);

									promise.finally(function(){
										if(timeoutHandler !== null){
											$timeout.cancel(timeoutHandler);
											localProvider.count--;
										}
									});
								}, settings.delay);

								promise.finally(function(){
									$timeout.cancel(handler);
								});

								return service;
							},
							'count': function(){
								return localProvider.count;
							},
						};
					},
					'createLog': function(limit){
						limit = limit || 20;
						var local = {
							'logs': [],
						};

						var service;
						return service = {
							'push': function(type, message, data){
								local.logs.unshift({
									'type': type,
									'message': message,
									'timestamp': new Date(),
									'data': data,
								});

								local.logs.splice(limit, local.logs.length);

								return service;
							},
							'list': function(){
								return angular.copy(local.logs);
							},
						};
					},
				};
			}
		])
	;

	$mdIconDecorator.$inject = ['$delegate'];
	function $mdIconDecorator($delegate){
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
})(this, angular);
