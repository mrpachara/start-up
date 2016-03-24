<?php
	if(!defined("RESTCONFIGURATED")){
		header(((isset($_SERVER['SERVER_PROTOCOL']))? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0')." 404 Not Found");
		exit;
	}
?>
(function(GLOBALOBJECT, angular){
	'use strict';

	angular.module(<?= json_encode($config->linkProp('angular-controller', 'module-id')) ?>, [
		'ldrvn', 'ldrvn.service',
		'ngMaterial',
		'util',
	])
		.controller('UtilDialogController', UtilDialogController)

		.controller('UtilLogListController', UtilLogListController)
	;

	UtilDialogController.$inject = ['$mdDialog'];
	function UtilDialogController(){
		var vm = this;
		var args = arguments;
		vm.$$di = {};
		angular.forEach(UtilDialogController.$inject, function(value, key){
			vm.$$di[value] = args[key];
		});

		vm.$mdDialog = vm.$$di.$mdDialog;
	}

	UtilLogListController.$inject = ['utilLogService'];
	function UtilLogListController(){
		var vm = this;
		var args = arguments;
		vm.$$di = {};
		angular.forEach(UtilLogListController.$inject, function(value, key){
			vm.$$di[value] = args[key];
		});

		vm.items = vm.$$di.utilLogService.list();
	}
})(this, angular);
