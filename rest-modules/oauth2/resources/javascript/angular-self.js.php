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
		'util', 'util.directive',
		'oauth2',
		'app.default',
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
			function($rootRouter){
				$rootRouter.config([
					{'path': '/login', 'name': 'OAuth2 Login', 'component': 'oauth2Login'},
					/*
					{'path': '/tokeninfo', 'name': 'OAuth2 Info', 'component': 'oauth2tokeninfo'},
					{'path': '/jwttoken', 'name': 'OAuth2 JWT Token', 'component': 'oauth2jwttoken'},
					*/
				]);
			}
		])

		.component('body', {
			'controller': AppController,
			'controllerAS': 'app',
			'templateUrl': [
				'oauth2Service',
				function(oauth2Service){
					return oauth2Service.promise.then(function(service){
						return service.template('layout.html');
					});
				}
			],
		})

		.component('oauth2Login', {
			'controller': Oauth2LoginController,
			'controllerAs': 'vm',
			'templateUrl': [
				'oauth2Service',
				function(oauth2Service){
					return oauth2Service.promise.then(function(service){
						return service.template('login-form.html');
					});
				}
			],
		})

		.controller('AppController', AppController)
	;

	AppController.$inject= ['oauth2Service'];
	function AppController(){
		var vm = this;
		var args = arguments;
		vm.$$di = {};
		angular.forEach(AppController.$inject, function(value, key){
			vm.$$di[value] = args[key];
		});
	}
	angular.extend(AppController.prototype, {
	});

	Oauth2LoginController.$inject = [
		'$window', '$location', '$q',
		'util',
		'oauth2Service',
	];
	function Oauth2LoginController(){
		var vm = this;
		var args = arguments;
		vm.$$di = {};
		angular.forEach(Oauth2LoginController.$inject, function(value, key){
			vm.$$di[value] = args[key];
		});

		vm.$$local = {
			'progress': vm.$$di.util.createProgress(),
		};

		vm.model = {
			'grant_type': 'password',
		};
	}
	angular.extend(Oauth2LoginController.prototype, {
		'progress': function(){
			return this.$$local.progress.count();
		},
		'submit': function(){
			var vm = this;

			var defer = vm.$$di.$q.defer();
			vm.$$local.progress.process(defer.promise);

			vm.$$di.oauth2Service.promise.then(function(service){
				service.token(vm.model)
					.then(
						function(data){
							vm.$$di.$window.location.href = vm.$$di.$location.search().redirect_uri;
						},
						function(data){
							vm.model.password = null;
						}
					)
					.finally(function(){
						defer.resolve();
					})
				;
			});
		},
	});
})(this, angular);
