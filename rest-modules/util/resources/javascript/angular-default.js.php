
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
			'aliasMap': {
				'*': {
					'icon': 'action:ic-print',
				},
				'view': {
					'title': 'View',
					'icon': 'action:ic-pageview',
					'classes': ['md-primary'],
				},
				'new': {
					'title': 'New',
					'icon': 'content:ic-add',
					'classes': ['md-primary'],
				},
				'save': {
					'title': 'Edit',
					'icon': 'editor:ic-mode-edit',
					'classes': ['md-primary'],
				},
				'delete': {
					'title': 'Delete',
					'icon': 'action:ic-delete-forever',
					'classes': ['md-warn'],
				},
				'print': {
					'title': 'Print',
					'icon': 'action:ic-print',
					'classes': ['md-primary'],
				},
			},
			'services': {
				'log': 'utilLogService',
				'search': 'utilSearchService',
				'notification': 'utilNotificationService',
				'message': 'utilNotificationService',
				'router': 'utilComponentRouterService',
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
				'confirm': [
					'$mdDialog', function($mdDialog){
						return function(ev, title, message){
							var elem = angular.element(ev.currentTarget);
							var name = elem.attr('aria-label') || 'perform this action';
							title = title || 'Do you want to ' + name + '?';
							message = message || elem.data('message') || 'Your action cannot be cancel later';
							return $mdDialog.show($mdDialog.confirm()
								.title(title)
								.textContent(message)
								.ok('Yes')
								.cancel('Cancel')
							);
						};
					}
				],
				'navBack': [
					'$window',
					function($window){
						return function(ev){
							return $window.history.back();
						};
					}
				],
			},
			'registers': {
				'notification-show': [
					['appEngine', function(appEngine){
						return function(ev, message){
							appEngine.service('notification', 'show', message);
						};
					}]
				],
				'setup-data': [
					['appEngine', function(appEngine){
						return function(ev, data){
							if(data.name) appEngine.prop('name', data.name.join('/'));
							appEngine.service('search', 'name', data.search);
						};
					}]
				],
				/*
				'navigation-sub' [
					[function(){
						return function(router, sub, data){

						};
					}],
				],
				*/
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
						'util',
						function(util){
							return util.createLog(providerLocal.setting.maxLog);
						}
					]
				});
			}
		])

		.provider('utilSearchService', [
			function(){
				angular.extend(this, {
					'$get': [
						'$location', '$rootScope',
						function($location, $rootScope){
							var local = {
								'name': null,
							};

							var service

							$rootScope.$on('$locationChangeSuccess', function(ev){
								$rootScope.$emit('search-changed', service.search());
							});

							return service = {
								'search': function(value){
									if(arguments.length === 0){
										return $location.search()[local.name] || null;
									} else{
										if(value === '') value = null;
										$location.search(local.name, value).replace();
										return service;
									}
								},
								'enabled': function(){
									return !!local.name;
								},
								'name': function(value){
									if(arguments.length === 0){
										return local.name;
									} else{
										local.name = value;
										$rootScope.$emit('search-changed', service.search());
										return service;
									}
								},
							};
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
						var simple = $mdToast.simple().textContent(message);
						if(arguments.length == 2){
							simple.hideDelay(hideDelay)
						}

						return $mdToast.show(simple);
					},
					'hide': function(handler){
						return $mdToast.hide(handler);
					},
				};
			}
		])

		.factory('utilComponentRouterService', [
			'$q', '$injector',
			'$mdDialog',
			'$ldrvn',
			'utilDefault',
			function($q, $injector, $mdDialog, $ldrvn, utilDefault){
				var service;

				return service = {
					'canDeactivate': function(formCtrl){
						return (formCtrl && formCtrl.$dirty)? $mdDialog.show(
							$mdDialog.confirm()
								.title('Do you want to discard change?')
								.textContent('All your changed data will be lost')
								.ok('Discard')
								.cancel('Cancel')
						).then(
							function(){
								return true;
							},
							function(){
								return false;
							}
						) : true;
					},
					'appendActions': function(ctrl, params, options){
						options = angular.extend({}, options);
						options.aliasMap = angular.extend({}, utilDefault.aliasMap, options.aliasMap);

						ctrl.$actions = {
							'default': function(){},
							'more': [],
							'global': [],
						};

						ctrl.$ld = $ldrvn.create(ctrl.links);
						angular.forEach(ctrl.$ld.$links(), function(link){
							var type = 'global';
							if(link.rel === 'resource/item') type = 'more';
							var name = link.alias.replace(/^./, function(c){ return c.toUpperCase();});
							var actionProp = angular.extend({}, utilDefault.aliasMap['*'], utilDefault.aliasMap[link.alias], options[link.alias]);
							actionProp.title = actionProp.title || name;
							actionProp.execute = function(ev, data){
								var elem = angular.element(ev.currentTarget);
								var appEngine = $injector.get('appEngine');
								((elem.hasClass('md-warn'))? appEngine.cmd('confirm', ev) : $q.when({}))
									.then(function(){
										if(angular.isDefined(ctrl.$router.registry._rules.get(ctrl.$router.parent.hostComponent).rulesByName.get(actionProp.title))){
											if(angular.isDefined(params.url)) params = {};
											var instruction = ctrl.$router.generate([actionProp.title, angular.extend({}, params, data)]);
		/*
		console.debug(ctrl.$router, instruction);
		console.debug('toLinkUrl', instruction.toLinkUrl());
		console.debug('toRootUrl', instruction.toRootUrl());
		console.debug('toUrlPath', instruction.toUrlPath());
		console.debug('toUrlQuery', instruction.toUrlQuery());
		*/
											ctrl.$router.navigateByUrl(instruction.toLinkUrl());
										} else{
											return ctrl.$ld.$send([link.alias, data], ctrl.self);
										}
									})
								;
							};
							ctrl.$actions[type].push(actionProp);
						});

						if(ctrl.$actions.more.length > 0){
							ctrl.$actions.default = ctrl.$actions.more.shift();
						}
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

								appEngine.service('log', 'push', 'info', message, response.data)
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

							appEngine.service('log', 'push', 'error', message, (reject.data)? reject.data : reject)
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
