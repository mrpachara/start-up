<?php
	if(!defined("RESTCONFIGURATED")){
		header(((isset($_SERVER['SERVER_PROTOCOL']))? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0')." 404 Not Found");
		exit;
	}
?>
(function(GLOBALOBJECT, angular){
	'use strict';

	//angular.element('head').append('<link rel="stylesheet" type="text/css" href="<?= htmlspecialchars($config->linkProp('angular-material-css', 'href')) ?>" />')

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
				$provide.decorator('$http', $httpDecorator);

				$httpProvider.interceptors.push('utilHttpInterceptor');
			}
		])

		.run([
			'$http', '$templateCache', '$rootScope', 'iconLinks', 'utilSearchService', 'utilService',
			function($http, $templateCache, $rootScope, iconLinks, utilSearchService, utilService){
				angular.forEach(iconLinks, function(link) {
					$http.get(link.href, {cache: $templateCache});
				});

				$rootScope.$on('$locationChangeSuccess', function(){
					utilSearchService.enabled(false);
				});

				utilService.promise.then(function(service){
					var $head = angular.element('head');
					service.$$configService.$forLinks('stylesheet', function(link){
						$head.append(angular.element('<link />', {
							'rel': 'stylesheet',
							'type': 'text/css',
							'href': link.href,
						}));
					});
					service.$$configService.$forLinks('stylesheet/less', function(link){
						var $link = angular.element('<link />', {
							'rel': 'stylesheet/less',
							'type': 'text/css',
							'href': link.href,
						});
						$head.append($link);
						less.sheets.push($link[0]);
					});
					less.refresh();
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

		.provider('utilSearchService', [
			function(){
				var provider = this;

				angular.extend(provider, {
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
										$location.search('term', value);
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
			function($injector, $q){
				var service;
				return service = {
					'response': function(response){
						try{
							var utilLogService = $injector.get('utilLogService');
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
							var utilLogService = $injector.get('utilLogService');
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

		.factory('utilModuleService', [
			function(){
				var local = {
					'name': null,
					'menu': null,
				};

				var service;
				return service = {
					'name': function(value){
						if(arguments.length === 0){
							return local.name;
						} else{
							local.name = value;
							return service;
						}
					},
					'menu': function(value){
						if(arguments.length === 0){
							return local.menu;
						} else{
							local.menu = value;
							return service;
						}
					},
				};
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
						};
						angular.extend(settings, _settings);

						var localProvider = {
							'count': 0,
						};

						var service;
						return service = {
							'process': function(promise, message){
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

									if(message){
										var $mdToast = $injector.get('$mdToast');

										$mdToast.show($mdToast.simple()
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

	$httpDecorator.$inject = ['$delegate'];
	function $httpDecorator($delegate){
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
