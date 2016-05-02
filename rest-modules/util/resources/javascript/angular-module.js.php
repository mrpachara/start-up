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
					'registers': {},
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
					'registers': function(_registers){
						angular.forEach(_registers, function(value, key){
							if(!angular.isArray(providerLocal.registers[key])) providerLocal.registers[key] = [];
							providerLocal.registers[key] = providerLocal.registers[key].concat(value);
						});
					},
					'$get': [
						'$injector', '$log', '$http', '$templateCache', '$rootScope',
						function($injector, $log, $http, $templateCache, $rootScope){
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

							var slice = [].slice;
							var service = {
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

							angular.forEach(providerLocal.cmds, function(injectable, key){
								try{
									local.cmds[key] = $injector.invoke(injectable, void 0, {'appEngine': service});
								} catch(excp){
									$log.error(excp);
								}
							});

							angular.forEach(providerLocal.registers, function(injectables, key){
								angular.forEach(injectables, function(injectable){
									try{
										$rootScope.$on(key, $injector.invoke(injectable, void 0, {'appEngine': service}));
									} catch(excp){
										$log.error(excp);
									}
								});
							});

							return service;
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
					'defaultMessageService': null,
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
						'$injector', '$q', '$timeout', '$log', '$rootScope',
						function($injector, $q, $timeout, $log ,$rootScope){
							var service;

							var defaultSetting = angular.extend({}, providerSettings);
							if(defaultSetting.defaultMessageService){
								try{
									if(providerSettings.defaultMessageService) defaultSetting.defaultMessageService = $injector.get(providerSettings.defaultMessageService);
								} catch(excp){
									$log.error(excp);
								}
							}

							return service = {
								'createProgress': function(_settings){
									var settings = {
										'delay': providerSettings.defaultProgressDelay,
										'timeout': providerSettings.defaultProgressTimeout,
										'messageService': defaultSetting.defaultMessageService,
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
													if(message && settings.messageService) settings.messageService.hide(messageHandler);
												}, settings.timeout);

												promise.finally(function(){
													if(timeoutHandler !== null){
														$timeout.cancel(timeoutHandler);
														localProvider.count--;
														if(message && settings.messageService) settings.messageService.hide(messageHandler);
													}
												});

												if(message && settings.messageService){
													messageHandler = settings.messageService.show(message, 0);
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

											$rootScope.$emit('notification-show', message);

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
