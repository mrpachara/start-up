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
			},
			'utilLogServiceNotification': [
				'$mdToast',
				function($mdToast){
					return function(type, message, data){
						$mdToast.showSimple(message);
					};
				}
			]
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

		.provider('appEngine', [
			'$provide',
			'$mdIconProvider',
			function($provide, $mdIconProvider){
				var providerLocal = {
					'cmds': {},
					'services': {},
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
									if(local.services[name] && local.services[name][method]){
										var args = slice.call(arguments, 2);
										return local.services[name][method].apply(local.services[name], args);
									} else{
										return void 0;
									}
								},
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
							var utilLogService = $injector.get('utilLogService');

							if(response.data && response.data.info){
								var message = response.data.info;

								utilLogService.push('info', message, response.data);
							}
						} catch(excp){}

						return response;
					},
					'responseError': function(reject){
						try{
							var utilLogService = $injector.get('utilLogService');

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
