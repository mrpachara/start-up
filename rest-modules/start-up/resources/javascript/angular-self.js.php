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
		.config([
			'$locationProvider', 'oauth2ServiceProvider',
			function($locationProvider, oauth2ServiceProvider){
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
					/*
					{'path': '/tokeninfo', 'name': 'OAuth2 Info', 'component': 'oauth2tokeninfo'},
					{'path': '/jwttoken', 'name': 'OAuth2 JWT Token', 'component': 'oauth2jwttoken'},
					*/
				]);

				startUpService.promise.then(function(service){
					return service.$$configService.$load('menu').then(function(data){
						utilModuleService.menu(data);
						return data;
					});
				});
			}
		])

		.controller('AppController', AppController)

		.component('startUpHome', {
			'controller': StartUpHomeController,
			'controllerAs': 'vm',
			'template': '<h1>Test List</h1><pre>{{ vm.parmas|json:true }}</pre>',
			'bindings': { '$router': '<' },
		})
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
		'layout': function(){
			return (this.$$local.user)? this.$$di.startUpService.layout('layout') : null;
		},
		'name': function(){
			return this.$$local.config.appName;
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
	}
	angular.extend(StartUpHomeController.prototype, {
		'$routerOnActivate': function(next, previous){
			var vm = this;

			vm.parmas = next.params;
			vm.$$di.utilSearchService.enabled(true);
			vm.$$di.utilModuleService.name('Home');
		},
	});
})(this, this.angular);
