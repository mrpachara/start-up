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
		'oauth2',
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

		.component('oauth2Login', {
			'controller': Oauth2LoginController,
			'controllerAs': 'vm',
			'templateUrl': <?= json_encode($config->linkProp('login-form', 'href')) ?>,
		})

		.factory('oauth2LayoutService', [
			function(){

			}
		])

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
		'layout': function(){
			return this.$$di.oauth2Service.layout('layout');
		}
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
})(this, this.angular);
