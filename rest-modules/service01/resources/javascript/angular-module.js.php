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
							return service.$$configService.$load(['data01-item', params]);
						});
					},
				});
			}
		])
	;

	Service01Data01ListController.$inject = [
		'$timeout',
		'$ldrvn',
		'service01Data01ListService',
		'utilModuleService',
	];
	function Service01Data01ListController(){
		var vm = this;
		var args = arguments;
		vm.$$di = {};
		angular.forEach(Service01Data01ListController.$inject, function(value, key){
			vm.$$di[value] = args[key];
		});

		vm.$$local = {
			'linkService': null,
		};

		vm.service = vm.$$di.service01Data01ListService;
	}
	angular.extend(Service01Data01ListController.prototype, {
		'$routerOnActivate': function(next, previous){
			var vm = this;

			return vm.service.promise.then(function(service){
				return service.load(next.params).then(function(model){
					vm.$$di.$timeout(function(){
						vm.$$di.utilModuleService.name('Data01');
					}, 10);

					angular.extend(vm, model);
					if(vm.links) vm.links = vm.$$di.$ldrvn.create(vm.links);
					return vm;
				});
			});
		},
		'view': function(id){
			this.$router.parent.navigate(['View', {'id': id}]);
		},
	});

	Service01Data01ItemController.$inject = [
		'$window', '$timeout', '$location',
		'$mdDialog', '$mdMedia',
		'$ldrvn',
		'service01Data01ItemService',
		'utilModuleService',
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
		vm.$mdMedia = vm.$$di.$mdMedia;
	}
	angular.extend(Service01Data01ItemController.prototype, {
		'$routerOnActivate': function(next, previous){
			var vm = this;

			vm.$$local.params = next.params;
			return vm.service.promise.then(function(service){
				return service.load(vm.$$local.params).then(function(model){
					vm.$$di.$timeout(function(){
						vm.$$di.utilModuleService.name('Data01/' + model.self.id);
					}, 10);

					angular.extend(vm, model);
					if(vm.links) vm.links = vm.$$di.$ldrvn.create(vm.links);
					vm.self.$data = angular.toJson(vm.self.data, true);
					return vm;
				});
			});
		},
		'$routerCanDeactivate': function(){
			return (this.$router.hostComponent === 'service01Data01Edit')? this.$$di.$mdDialog.show(
				this.$$di.$mdDialog.confirm()
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
		'action': function(link){
			var vm = this;
			if(angular.isArray(link.action)){
				return vm.$router.navigate(link.action);
			} else if(angular.isString(link.action)){
				return vm.changeMode(link.action);
			} else{
				return vm.links.$load(link.alias);
			}
		},
		'back': function(ev){
			return this.$$di.$window.history.back();
		},
		'changeMode': function(name){
			var vm = this;

			return vm.$router.navigateByInstruction(vm.$router.generate([name, {'id': vm.self.id}]), true);
		},
		'submit': function(){
			var vm = this;

			vm.self.data = angular.fromJson(vm.self.$data);
			vm.links.$send('save', vm.self);
		},
	});
})(this, angular);
