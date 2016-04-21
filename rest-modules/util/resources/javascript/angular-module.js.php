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

		.provider('appEngine', [
			'$provide',
			function($provide){
				var providerLocal = {
					'cmds': {},
					'services': {},
				};

				angular.extend(this, {
					'cmds': function(_cmds){
						if(arguments.length === 1){
							angular.extend(providerLocal.cmds, _cmds);
							return this;
						} else{
							return providerLocal.cmds;
						}
					},
					'services': function(_services){
						if(arguments.length === 1){
							angular.extend(providerLocal.services, _services);
							return this;
						} else{
							return providerLocal.services;
						}
					},
					'$get': [
						'$injector', '$log', '$http', '$templateCache',
						function($injector, $log, $http, $templateCache){
							var local = {
								'props': {},
								'cmds': {},
								'services': {},
							};

							angular.forEach(providerLocal.services, function(name, key){
								try{
									local.services[key] = $injector.get(name);
								} catch(excp){
									$log.error(excp);
								}
							});

							angular.forEach(providerLocal.cmds, function(injectable, key){
								try{
									local.cmds[key] = $injector.invoke(injectable);
								} catch(excp){
									$log.error(excp);
								}
							})

							var slice = [].slice;
							var service;
							return service = {
								'prop': function(name, value){
									if(arguments.length === 2){
										local.props[name] = value;
										return service;
									} else{
										return local.props[name];
									}
								},
								'cmd': function(name){
									if(angular.isFunction(local.cmds[name])){
										var args = slice.call(arguments, 1);
										return local.cmds[name].apply(void 0, args);
									} else{
										return void 0;
									}
								},
								'service': function(name, method){
									if(local.services[name]){
										if(angular.isFunction(local.services[name])){
											var args = slice.call(arguments, 1);
											return local.services[name].apply(void 0, args);
										} else if(arguments.length === 1){
											return local.services[name];
										} else{
											var args = slice.call(arguments, 2);
											return local.services[name][method].apply(local.services[name], args);
										}
									} else{
										return void 0;
									}




									if(local.services[name] && local.services[name][method]){
										var args = slice.call(arguments, 2);
										return local.services[name][method].apply(local.services[name], args);
									} else{
										return void 0;
									}
								},
							};
						}
					]
				})
			}
		])

		.provider('util', [
			function(){
				var providerSettings = {
					'defaultProgressDelay': 300,
					'defaultProgressTimeout': 30000,
					'defaultNotificationService': null,
				};
				angular.extend(this, {
					'setting': function(){
						if(arguments.lenght === 2){
							providerSettings[arguments[0]] = arguments[1];
						} else if(arguments.length === 1){
							angular.extend(providerSettings, arguments[0]);
						} else{
							return angular.copy(providerSetting);
						}

						return this;
					},
					'$get': [
						'$injector', '$q', '$timeout', '$log',
						function($injector, $q, $timeout, $log){
							var service;

							var defaultSetting = angular.extend({}, providerSettings);
							if(defaultSetting.defaultNotificationService){
								try{
									if(providerSettings.defaultNotificationService) defaultSetting.defaultNotificationService = $injector.get(providerSettings.defaultNotificationService);
								} catch(excp){
									$log.error(excp);
								}
							}

							return service = {
								'createProgress': function(_settings){
									var settings = {
										'delay': providerSettings.defaultProgressDelay,
										'timeout': providerSettings.defaultProgressTimeout,
										'notificationService': defaultSetting.defaultNotificationService,
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
													if(message && settings.notificationService) settings.notificationService.hide(messageHandler);
													//$mdToast.hide(messageHandler);
												}, settings.timeout);

												promise.finally(function(){
													if(timeoutHandler !== null){
														$timeout.cancel(timeoutHandler);
														localProvider.count--;
														if(message && settings.notificationService) settings.notificationService.hide(messageHandler);
														//$mdToast.hide(messageHandler);
													}
												});

												if(message && settings.notificationService){
													messageHandler = settings.notificationService.show(message, 0);
													/*
													messageHandler = $mdToast.show($mdToast.simple()
														.textContent(message)
														.hideDelay(0)
													);
													*/
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
										'notificationService': defaultSetting.defaultNotificationService,
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

											if(local.notification){
												local.notification.show(message);
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
					],
				});
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
