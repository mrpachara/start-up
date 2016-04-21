
<?php
	if(!defined("RESTCONFIGURATED")){
		header(((isset($_SERVER['SERVER_PROTOCOL']))? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0')." 404 Not Found");
		exit;
	}
?>
(function(GLOBALOBJECT, angular){
	'use strict';

	var $iconSetNames = [];

	angular.module(<?= json_encode($config->linkProp('angular-default', 'module-id')) ?>, [
		'ldrvn', 'ldrvn.service',
		'util',
		'ngMaterial',
	])
		.constant('utilDefault', {
			'iconLinks': <?= json_encode($config->links('icon/svg')) ?>,
			'services': {
				'log': 'utilLogService',
				'search': 'utilSearchService',
				'notification': 'utilNotificationService',
				'template': 'utilTemplate',
			},
			'cmds': {
				'showLog': [
					'$mdDialog', 'utilTemplate',
					function($mdDialog, utilTemplate){
						return function(ev){
							return utilTemplate.promise.then(function(template){
								return $mdDialog.show({
									'autoWrap': false,
									'templateUrl': template('popup-dialog.html'),
									'targetEvent': ev,
									'controller': 'UtilDialogController',
									'bindToController': true,
									'controllerAs': '$dialog',
									'locals': {
										'name': 'Log History',
										'contentUrl': template('log-list.html'),
									},
								});
							});
						}
					}
				],
				'showNotification': [
					'$mdToast',
					function($mdToast){
						return function(type, message, data){
							$mdToast.showSimple(message);
						};
					}
				],
			},
		})

		.run([
			'utilService',
			function(utilService){
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

		.factory('utilTemplate', [
			'utilService',
			function(utilService){
				function template(alias){
					return utilService.template(alias);
				}

				template.promise = utilService.promise.then(function(){
					return template;
				});

				return template;
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

		.factory('utilNotificationService', [
			'$mdToast',
			function($mdToast){
				var service;

				return service = {
					'show': function(message, hideDelay){
						if(arguments.length == 2){
							return $mdToast.show($mdToast.simple()
								.textContent(message)
								.hideDelay(hideDelay)
							);
						} else{
							return $mdToast.simple(message);
						}
					},
					'hide': function(handler){
						return $mdToast.hide(handler);
					},
				};
			}
		])

		.provider('appIcon', [
			'$provide',
			'$mdIconProvider',
			function($provide, $mdIconProvider){
				var providerLocal = {
					'iconsLinks': [],
				};

				angular.extend(this, {
					'initIcons': function(iconsLinks){
						providerLocal.iconsLinks = iconsLinks;
						angular.forEach(providerLocal.iconsLinks, function(link){
							$iconSetNames.push(link['set-name']);
							$mdIconProvider.iconSet(link['set-name'], link.href);
						});

						$provide.decorator('$mdIcon', Util$mdIconDecorator);

						return this;
					},
					'$get': [
						'$http', '$templateCache',
						function($http, $templateCache){
							var slice = [].slice;
							var service;
							return service = {
								'preloadIcons': function(){
									angular.forEach(providerLocal.iconsLinks, function(link) {
										$http.get(link.href, {cache: $templateCache});
									});

									return service;
								},
							};
						}
					]
				})
			}
		])

		.factory('utilDefaultHttpInterceptor', [
			'$injector', '$q',
			function($injector, $q){
				var service;

				return service = {
					'response': function(response){
						try{
							var appEngine = $injector.get('appEngine');

							if(response.data && response.data.info){
								var message = response.data.info;

								appEngine.services('log', 'push', 'info', message, response.data)
							}
						} catch(excp){}

						return response;
					},
					'responseError': function(reject){
						try{
							var appEngine = $injector.get('appEngine');

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

							appEngine.services('log', 'push', 'error', message, (reject.data)? reject.data : reject)
						} catch($excp){}

						return $q.reject(reject);
					},
				};
			}
		])
	;

	Util$mdIconDecorator.$inject = ['$delegate'];
	function Util$mdIconDecorator($delegate){
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
