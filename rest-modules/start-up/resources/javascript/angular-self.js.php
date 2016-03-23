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
			function($rootRouter){
				$rootRouter.config([
					/*
					{'path': '/login', 'name': 'OAuth2 Login', 'component': 'oauth2Login'},
					{'path': '/tokeninfo', 'name': 'OAuth2 Info', 'component': 'oauth2tokeninfo'},
					{'path': '/jwttoken', 'name': 'OAuth2 JWT Token', 'component': 'oauth2jwttoken'},
					*/
				]);
			}
		])

		.controller('AppController', AppController)
	;

	AppController.$inject= [
		'$log', '$window', '$injector',
		'$mdMedia', '$mdSidenav',
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
		'layout': function(){
			return (this.$$local.user)? this.$$di.startUpService.layout('layout') : null;
		},
		'name': function(){
			return this.$$local.config.appName;
		},
	});
})(this, this.angular);
