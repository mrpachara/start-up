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
						return service.template('list');
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
						return service.template('view');
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
						return service.template('edit');
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
					'load': function(){
						var service = this;
						if(angular.isUndefined(service.$$configService)) return $q.reject(new Error('Service not ready'));

						return service.$$configService.$load('data01');
					},
				});
			}
		])
	;

	Service01Data01ListController.$inject = ['service01Data01ListService'];
	function Service01Data01ListController(){
		var vm = this;
		var args = arguments;
		vm.$$di = {};
		angular.forEach(Service01Data01ListController.$inject, function(value, key){
			vm.$$di[value] = args[key];
		});
	}
	angular.extend(Service01Data01ListController.prototype, {
		'$routerOnActivate': function(){
			var vm = this;

			return vm.$$di.service01Data01ListService.promise.then(function(service){
				return service.load().then(function(model){
					return angular.extend(vm, model);
				});
			});
		},
		'view': function(id){
			this.$router.parent.navigate(['View', {'id': id}]);
		},
	});

	Service01Data01ItemController.$inject = ['$location', '$mdDialog'];
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
	}
	angular.extend(Service01Data01ItemController.prototype, {
		'$routerOnActivate': function(next, previous){
			var vm = this;

			vm.$$local.params = next.params;
		},
		'$routerCanDeactivate': function(){
			return (this.$router.hostComponent === 'service01Data01Edit')? this.$$di.$mdDialog.show(
				this.$$di.$mdDialog.confirm()
					.title('Do you want to discard change?')
					.textContent('All your changed data will be lost')
					.ok('Yes')
					.cancel('Discard')
			).then(
				function(){
					return true;
				},
				function(){
					return false;
				}
			) : true;
		},
		'getId': function(){
			var vm = this;

			return vm.$$local.params.id;
		},
		'changeMode': function(name){
			var vm = this;

			vm.$router.parent.navigate([name, {'id': vm.$$local.params.id}]).then(function(){
				vm.$$di.$location.replace();
			});
		},
	});
})(this, angular);
