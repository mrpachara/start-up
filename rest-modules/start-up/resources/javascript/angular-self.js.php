<?php
	if(!defined("RESTCONFIGURATED")){
		header(((isset($_SERVER['SERVER_PROTOCOL']))? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0')." 404 Not Found");
		exit;
	}
?>
(function(GLOBALOBJECT, angular){
	'use strict';

	angular.module(<?= json_encode($config->linkProp('angular-self', 'module-id')) ?>, [
		'ldrvn', 'ldrvn.service', 'ngComponentRouter',
		'ngMessages', 'ngSanitize', 'ngMaterial',
		'util', 'oauth2', 'start-up',
	])
		.value('$routerRootComponent', 'body')

		.config([
			'$provide', '$locationProvider', 'oauth2ServiceProvider',
			function($provide, $locationProvider, oauth2ServiceProvider){
				//$provide.value('$routerRootComponent', 'main');

				$locationProvider.html5Mode(true);

				oauth2ServiceProvider.setClient({'client_id': 'web_client'});

				oauth2ServiceProvider.setStorage([
					'$window',
					function($window){
						return {
							'prop': function(name, value){
								if(arguments.length === 2){
									$window.sessionStorage.setItem(name, value);
								} else{
									return $window.sessionStorage.getItem(name);
								}
							},
							'remove': function(name){
								if($window.sessionStorage.getItem(name)){
									$window.sessionStorage.removeItem(name);

									return true;
								} else{
									return false;
								}
							},
							'clear': function(){
								$window.sessionStorage.clear();
							},
						};
					}
				]);
			}
		])

		.run([
			'$rootRouter',
			'utilModuleService',
			'startUpService',
			function($rootRouter, utilModuleService, startUpService){
				$rootRouter.config([
					{'path': '/home', 'name': 'Home', 'component': 'startUpHome', 'useAsDefault': true},
				]);

				startUpService.promise.then(function(service){
					return service.$$configService.$load('menu').then(function(data){
						utilModuleService.menu(data);
						return data;
					});
				});
			}
		])

		.component('body', {
			'controller': AppController,
			'controllerAs': 'app',
			'templateUrl': [
				'startUpService',
				function(startUpService){
					return startUpService.promise.then(function(service){
						return service.layout('layout');
					});
				}
			],
		})

		.component('startUpHome', {
			'controller': StartUpHomeController,
			'controllerAs': '$comp',
			'templateUrl': [
				'startUpService',
				function(startUpService){
					return startUpService.promise.then(function(service){
						return service.template('home');
					});
				}
			],
			'bindings': { '$router': '<' },
		})

		.controller('AppController', AppController)
	;

	AppController.$inject= [
		'$log', '$window', '$injector', '$q', '$interval',
		'$mdMedia', '$mdSidenav', '$mdDialog',
		'utilService', 'utilLogService', 'utilSearchService', 'utilModuleService',
		'startUpService', 'oauth2Service',
	];
	function AppController(){
		var vm = this;
		var args = arguments;
		vm.$$di = {};
		angular.forEach(AppController.$inject, function(value, key){
			vm.$$di[value] = args[key];
		});

		vm.$$local = {
			'user': null,
			'config': {},
		};

		try{
			vm.$$local.config = vm.$$di.$injector.get('config');
		} catch(excp){}

		vm.$mdMedia = vm.$$di.$mdMedia;
		vm.$mdSidenav = vm.$$di.$mdSidenav;
		vm.utilService = vm.$$di.utilService;
		vm.utilSearchService = vm.$$di.utilSearchService;
		vm.utilModuleService = vm.$$di.utilModuleService;

		vm.$$di.oauth2Service.info().then(
			function(data){
				vm.$$local.user = data;
			},
			function(data){
				vm.$$di.$window.location.href = vm.$$di.oauth2Service.loginPageUrl() + '?redirect_uri=' + encodeURIComponent(vm.$$di.$window.location.href);
			}
		);

		var types = ['info', 'error'];
		var count = 0;
		var datas = [
			undefined,
			{
				'error_exception': 'error_exception\nline1',
			},
			undefined,
			{
				'error_trace': 'error_trace\nline1\nline2\nline3',
			},
		];
		var count_data = 0;
		//vm.$$di.$interval(function(){
			vm.$$di.utilLogService.push(types[count++], 'abcd', datas[count_data++]);
			count %= 2;
			count_data %= 4;
		//}, 3000);
	}
	angular.extend(AppController.prototype, {
		'isAuthenticated': function(){
			return !!(this.$$local.user);
		},
		'name': function(){
			return this.$$local.config.appName;
		},
		'debug': function(data){
			this.$$di.$log.debug('app debug:', data);
		},
	});

	StartUpHomeController.$inject = ['utilSearchService', 'utilModuleService'];
	function StartUpHomeController(){
		var vm = this;
		var args = arguments;
		vm.$$di = {};
		angular.forEach(StartUpHomeController.$inject, function(value, key){
			vm.$$di[value] = args[key];
		});

		vm.$$local = {
			'boxSize': 40,
		};
	}
	angular.extend(StartUpHomeController.prototype, {
		'$routerOnActivate': function(next, previous){
			var vm = this;

			vm.parmas = next.params;
			vm.$$di.utilSearchService.enabled(true);
			vm.$$di.utilModuleService.name('Home');
		},
		'incBoxSize': function(){
			this.$$local.boxSize+=10;
		},
		'boxSize': function(){
			return this.$$local.boxSize;
		},
	});
})(this, this.angular);
