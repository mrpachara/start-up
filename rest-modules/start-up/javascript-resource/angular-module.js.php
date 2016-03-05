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
		.config([
			'$locationProvider',
			function($locationProvider){
				$locationProvider.html5Mode(true);
			}
		])

		.run([
			'$rootRouter',
			function($rootRouter){
			}
		])

		.controller('AppController', AppController)
	;

	AppController.$inject= [];
	function AppController(){
		var vm = this;
		var args = arguments;
		vm.$$di = {};
		angular.forEach(AppController.$inject, function(value, key){
			vm.$$di[value] = args[key];
		});
	}
})(this, this.angular);
