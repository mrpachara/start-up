<?php
	if(!defined("RESTCONFIGURATED")){
		header(((isset($_SERVER['SERVER_PROTOCOL']))? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0')." 404 Not Found");
		exit;
	}
?>
(function(GLOBALOBJECT, angular){
	'use strict';

	angular.module(<?= json_encode($config->linkProp('angular-module', 'module-id')) ?>, [
		'ldrvn', 'ldrvn.service', 'ngComponentRouter',
		'util',
		'app.engine',
	])
		.config([
			function(){
			}
		])

		.run([
			'$rootRouter',
			function($rootRouter){
				$rootRouter.config([
					{'path': '/service01/...', 'name': 'Service01', 'component': 'service01'},
				]);
			}
		])

		.factory('service01Data01ListService', [
			'$q', '$ldrvn', 'service01ConfigLoader',
			function($q, $ldrvn, service01ConfigLoader){
				return $ldrvn.createService(service01ConfigLoader, {
					'load': function(params){
						return this.promise.then(function(service){
							return service.$$configService.$load('data01', params);
						});
					},
				});
			}
		])

		.factory('service01Data01ItemService', [
			'$q', '$ldrvn', 'service01ConfigLoader',
			function($q, $ldrvn, service01ConfigLoader){
				return $ldrvn.createService(service01ConfigLoader, {
					'load': function(params){
						return this.promise.then(function(service){
							if(angular.isUndefined(params.id)){
								return service.$$configService.$load('data01-new');
							} else{
								return service.$$configService.$load(['data01-item', params]);
							}
						});
					},
				});
			}
		])

		.component('service01', {
			'template': '<ng-outlet></ng-outlet>',
			'$routeConfig': [
				{'path': '/data01/...', 'name': 'Data01', 'component': 'service01Data01'},
			],
		})

		.component('service01Data01', {
			'template': '<ng-outlet></ng-outlet>',
			'$routeConfig': [
				{'path': '/', 'name': 'List', 'component': 'service01Data01List', 'useAsDefault': true},
				{'path': '/new', 'name': 'New', 'component': 'service01Data01New'},
				{'path': '/:id', 'name': 'View', 'component': 'service01Data01View'},
				{'path': '/:id/edit', 'name': 'Edit', 'component': 'service01Data01Edit'},
			],
		})

		.component('service01Data01List', {
			'controller': Service01Data01ListController,
			'controllerAs': '$comp',
			'templateUrl': [
				'service01Service',
				function(service01Service){
					return service01Service.promise.then(function(service){
						return service.template('list.html');
					});
				}
			],
			'bindings': {
				'$router': '<',
			},
		})

		.component('service01Data01View', {
			'controller': Service01Data01ItemController,
			'controllerAs': '$comp',
			'templateUrl': [
				'service01Service',
				function(service01Service){
					return service01Service.promise.then(function(service){
						return service.template('view.html');
					});
				}
			],
			'bindings': {
				'$router': '<',
			},
		})

		.component('service01Data01New', {
			'controller': Service01Data01ItemController,
			'controllerAs': '$comp',
			'templateUrl': [
				'service01Service',
				function(service01Service){
					return service01Service.promise.then(function(service){
						return service.template('edit.html');
					});
				}
			],
			'bindings': {
				'$router': '<',
			},
		})

		.component('service01Data01Edit', {
			'controller': Service01Data01ItemController,
			'controllerAs': '$comp',
			'templateUrl': [
				'service01Service',
				function(service01Service){
					return service01Service.promise.then(function(service){
						return service.template('edit.html');
					});
				}
			],
			'bindings': {
				'$router': '<',
			},
		})

		.factory('service01ConfigLoader', [
			'$ldrvn',
			function($ldrvn){
				return $ldrvn.loadConfig(<?= json_encode($GLOBALS['_rest']->getConfigUri()) ?>);
			}
		])

		.factory('service01Service', [
			'$ldrvn', 'service01ConfigLoader',
			function($ldrvn, service01ConfigLoader){
				return $ldrvn.createService(service01ConfigLoader, {});
			}
		])
	;

	Service01Data01ListController.$inject = [
		'$rootScope', '$timeout',
		'$mdMedia',
		'$ldrvn', 'appEngine',
		'service01Data01ListService',
		'appEngine',
	];
	function Service01Data01ListController(){
		var vm = this;
		var args = arguments;
		vm.$$di = {};
		angular.forEach(Service01Data01ListController.$inject, function(value, key){
			vm.$$di[value] = args[key];
		});

		vm.$$local = {
			'formCtrl': null,
		};

		vm.service = vm.$$di.service01Data01ListService;
		vm.$ae = vm.$$di.appEngine;
		vm.$mdMedia = vm.$$di.$mdMedia;
	}
	angular.extend(Service01Data01ListController.prototype, {
		'$routerOnActivate': function(next, previous){
			var vm = this;

			return vm.service.promise.then(function(service){
				return service.load(next.params).then(function(model){
					vm.$$di.$rootScope.$emit('setup-data', model);

					angular.extend(vm, model);
					vm.$$di.appEngine.service('router', 'appendActions', vm, next.params);

					return vm;
				});
			});
		},
	});

	Service01Data01ItemController.$inject = [
		'$window', '$timeout', '$rootScope',
		'$mdMedia',
		'$ldrvn', 'util', 'appEngine',
		'service01Data01ItemService',
		'appEngine',
	];
	function Service01Data01ItemController(){
		var vm = this;
		var args = arguments;
		vm.$$di = {};
		angular.forEach(Service01Data01ItemController.$inject, function(value, key){
			vm.$$di[value] = args[key];
		});

		vm.$$local = {
			'params': {},
		};

		vm.service = vm.$$di.service01Data01ItemService;
		vm.progress = vm.$$di.util.createProgress();
		vm.$ae = vm.$$di.appEngine;
		vm.$mdMedia = vm.$$di.$mdMedia;
	}
	angular.extend(Service01Data01ItemController.prototype, {
		'$routerOnActivate': function(next, previous){
			var vm = this;

			return vm.service.promise.then(function(service){
				return service.load(next.params).then(function(model){
					vm.$$di.$rootScope.$emit('setup-data', model);

					angular.extend(vm, model);
					vm.$$di.appEngine.service('router', 'appendActions', vm, next.params);

					vm.self.$data = angular.toJson(vm.self.data, true);
					return vm;
				});
			});
		},
		'$routerCanDeactivate': function(){
			if(this.progress.count()) return false;

			return this.$$di.appEngine.service('router', 'canDeactivate', this.$$local.formCtrl);
		},
		'setForm': function(formCtrl){
			this.$$local.formCtrl = formCtrl;
		},
		'submit': function(){
			var vm = this;

			vm.self.data = angular.fromJson(vm.self.$data);

			vm.progress.process(vm.$$di.$ldrvn.create(vm.links).$send('save', vm.self).then(
				function(){
					vm.$$local.formCtrl.$setPristine();
					vm.changeMode('View');
				}
			), 'Saving ...');
		},
	});
})(this, angular);
