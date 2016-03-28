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
					{'path': '/service01/data01', 'name': 'Service01 Data01 List', 'component': 'service01Data01List'},
					{'path': '/service01/data01/:id', 'name': 'Service01 Data01 Item', 'component': 'service01Data01Item'},
				]);
			}
		])

		.component('service01Data01List', {
			'controller': Service01Data01ListController,
			'controllerAs': 'vm',
			'template': 'Test List<pre>{{ vm|json:true }}</pre>',
		})

		.component('service01Data01Item', {
			'controller': Service01Data01ItemController,
			'controllerAs': 'vm',
			'template': 'Test Item {{ vm.getId() }}',
		})

		.factory('service01ConfigLoader', [
			'$ldrvn',
			function($ldrvn){
				return $ldrvn.loadConfig(<?= json_encode($GLOBALS['_rest']->getConfigUri()) ?>);
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
	});

	Service01Data01ItemController.$inject = [];
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
		'getId': function(){
			var vm = this;

			return vm.$$local.params.id;
		},
	});
})(this, angular);
