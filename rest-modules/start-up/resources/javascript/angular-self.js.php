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
			'$locationProvider', 'oauth2ServiceProvider',
			function($locationProvider, oauth2ServiceProvider){
				$locationProvider.html5Mode(true);

				oauth2ServiceProvider.setClient({'client_id': 'web_client'});

				oauth2ServiceProvider.setStorage([
					'$window',
					function($window){
						var storage = $window.sessionStorage;
						var prefix = 'oauth2-';
						return {
							'prop': function(name, value){
								if(arguments.length === 2){
									storage.setItem(prefix + name, value);
								} else{
									return storage.getItem(prefix + name);
								}
							},
							'remove': function(name){
								if(storage.getItem(prefix + name)){
									storage.removeItem(prefix + name);

									return true;
								} else{
									return false;
								}
							},
							'clear': function(){
								//$window.sessionStorage.clear();
								var matchedKeys = [];
								for(var i, len = storage.length; i < len; i++){
									var key = storage.key(i);
									if(key.indexOf(prefix) === 0) matchKeys.push(key);
								}

								angular.forEach(matchedKeys, function(key){
									storage.removeItem(key);
								});
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
						return service.template('layout');
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
		'utilService', 'utilSearchService', 'utilModuleService',
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

	StartUpHomeController.$inject = ['$timeout', 'utilSearchService', 'utilModuleService'];
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

			/* change some property may be defer executed */
			vm.$$di.$timeout(function(){
				vm.$$di.utilSearchService.enabled(true);
				vm.$$di.utilModuleService.name('Home');
			}, 10);
		},
		'incBoxSize': function(){
			this.$$local.boxSize+=10;
		},
		'boxSize': function(){
			return this.$$local.boxSize;
		},
	});
})(this, this.angular);
