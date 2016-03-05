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
	])
		.run([
			'$rootRouter',
			function($rootRouter){
				console.debug('router config');
				console.debug($rootRouter);
				$rootRouter.config([
					{'path': '/data01', 'name': 'Data01 List', 'component': 'data01List'},
					{'path': '/data01/:id', 'name': 'Data01 Item', 'component': 'data01Item'},
				]);
			}
		])

		.component('data01List', {
			'controller': Data01ListController,
			'controllerAs': 'vm',
			'template': 'Test List',
		})

		.component('data01Item', {
			'controller': Data01ItemController,
			'controllerAs': 'vm',
			'template': 'Test Item {{ vm.getId() }}',
		})
	;

	Data01ListController.$inject = [];
	function Data01ListController(){
		var vm = this;
		var args = arguments;
		vm.$$di = {};
		angular.forEach(Data01ListController.$inject, function(value, key){
			vm.$$di[value] = args[key];
		});
	}

	Data01ItemController.$inject = [];
	function Data01ItemController(){
		var vm = this;
		var args = arguments;
		vm.$$di = {};
		angular.forEach(Data01ItemController.$inject, function(value, key){
			vm.$$di[value] = args[key];
		});

		vm.$$local = {
			'params': {},
		};
	}
	angular.extend(Data01ItemController.prototype, {
		'$routerOnActivate': function(next, previous){
			var vm = this;

			vm.$$local.params = next.params;
		},
		'getId': function(){
			var vm = this;

			return vm.$$local.params.id;
		},
	});
})(this, this.angular);
