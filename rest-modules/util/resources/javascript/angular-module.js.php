<?php
	if(!defined("RESTCONFIGURATED")){
		header(((isset($_SERVER['SERVER_PROTOCOL']))? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0')." 404 Not Found");
		exit;
	}
?>
(function(GLOBALOBJECT, angular){
	'use strict';

	angular.module(<?= json_encode($config->linkProp('angular-module', 'module-id')) ?>, [
		'ldrvn', 'ldrvn.service',
		'ngMaterial',
	])
		.config([
			'$provide', '$httpProvider',
			function($provide, $httpProvider){
				$provide.decorator('$http', Util$httpDecorator);
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
			'utilConfigLoader',
			function($ldrvn, utilConfigLoader){
				return $ldrvn.createService(utilConfigLoader, {});
			}
		])

		.provider('utilLogService', [
			function(){
				var providerLocal = {
					'setting': {
						'maxLog': 50,
						'notification': null,
					},
				};

				return angular.extend(this, {
					'setting': function(_setting){
						if(arguments.length === 1){
							angular.extend(providerLocal.setting, _setting);
							return this;
						} else{
							return providerLocal.setting;
						}
					},
					'$get': [
						'$injector', '$log',
						'util',
						function($injector, $log, util){
							var notification;

							if(providerLocal.setting.notification){
								try{
									notification = $injector.invoke(providerLocal.setting.notification);
								} catch(excp){
									$log.error(excp);
								}
							}

							return util.createLog(providerLocal.setting.maxLog, notification);
						}
					]
				});
			}
		])

		.provider('utilSearchService', [
			function(){
				angular.extend(this, {
					'$get': [
						'$location',
						function($location){
							var local = {
								'activated': false,
								'enabled': false,
							};

							function updateActive(value){
								local.activated =	(!!value || !!service.search());
							}

							var service = {
								'activated': function(value){
									if(arguments.length === 0){
										return local.activated;
									} else{
										updateActive(value);
										return service;
									}
								},
								'search': function(value){
									if(arguments.length === 0){
										return $location.search().term || null;
									} else{
										if(value === '') value = null;
										$location.search('term', value).replace();
										updateActive(false);
										return service;
									}
								},
								'enabled': function(value){
									if(arguments.length === 0){
										return local.enabled;
									} else{
										local.enabled = value;
										return service;
									}
								},
							};

							return service.activated(false).enabled(false);
						}
					]
				});
			}
		])

		.factory('util', [
			'$q', '$timeout', '$log', '$mdToast',
			function($q, $timeout, $log, $mdToast){
				var service;

				return service = {
					'createProgress': function(_settings){
						var settings = {
							'delay': 300,
							'timeout': 30000,
							'notificationService': null,
						};
						angular.extend(settings, _settings);

						var localProvider = {
							'count': 0,
						};

						var service;
						return service = {
							'process': function(promise, message){
								var handler = $timeout(function(){
									var messageHandler;
									localProvider.count++;

									var timeoutHandler = $timeout(function(){
										timeoutHandler = null;
										$log.warn('timeout for:', promise);
										localProvider.count--;
										$mdToast.hide(messageHandler);
									}, settings.timeout);

									promise.finally(function(){
										if(timeoutHandler !== null){
											$timeout.cancel(timeoutHandler);
											localProvider.count--;
											$mdToast.hide(messageHandler);
										}
									});

									if(message){
										messageHandler = $mdToast.show($mdToast.simple()
											.textContent(message)
											.hideDelay(0)
										);
									}
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
					'createLog': function(limit, notification){
						limit = limit || 20;
						var local = {
							'logs': [],
							'notification': notification,
						};

						var slice = [].slice;
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

								if(angular.isFunction(local.notification)){
									local.notification.apply(void 0, slice.call(arguments, 0));
								}

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

	Util$httpDecorator.$inject = ['$delegate'];
	function Util$httpDecorator($delegate){
		function httpDeferUrl(requestConfig){
			var self = this;
			var args = [].slice.call(arguments, 0);
			if(angular.isObject(requestConfig.url) && angular.isFunction(requestConfig.url.then)){
				return requestConfig.url.then(function(url){
					args[0].url = url;
					return httpDeferUrl.apply(httpDeferUrl, args);
				});
			} else{
				return $delegate.apply($delegate, args);
			}
		}

		Object.keys($delegate).filter(function(key){
			return (typeof $delegate[key] === 'function');
		}).forEach(function(key){
			httpDeferUrl[key] = function (url){
				var self = this;
				var args = [].slice.call(arguments, 0);
				if(angular.isObject(url) && angular.isFunction(url.then)){
					return url.then(function(url){
						args[0] = url;
						return httpDeferUrl[key].apply(self, args)
					});
				} else{
					return $delegate[key].apply($delegate, args);
				}
			};
		});

		return httpDeferUrl;
	}
})(this, angular);
