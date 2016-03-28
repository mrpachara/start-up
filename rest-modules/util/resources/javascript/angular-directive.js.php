<?php
	if(!defined("RESTCONFIGURATED")){
		header(((isset($_SERVER['SERVER_PROTOCOL']))? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0')." 404 Not Found");
		exit;
	}
?>
(function(GLOBALOBJECT, angular){
	'use strict';

	var ngModule = angular.module(<?= json_encode($config->linkProp('angular-directive', 'module-id')) ?>, [
		'ldrvn', 'ldrvn.service',
		'ngMaterial',
		'util',
	])
		.directive('utilAutofocus', [
			'$timeout',
			function($timeout){
				var local = {
					'handler': null,
				};
				var drtv;
				return drtv = {
					'restrict': 'A',
					'link': function(scope, elem, attrs){
						if(attrs.utilAutofocus && !scope.$eval(attrs.utilAutofocus)) return;

						if(local.handler !== null) $timeout.cancel(local.handler);

						local.handler = $timeout(function(){
							local.handler = null;

							elem.focus();
						}, 300);
					}
				};
			}
		])

		.component('utilSearch', {
			'templateUrl': ['utilService', function(utilService){
				return utilService.promise.then(function(service){
					return service.template('search-form');
				});
			}],
			'controller': UtilSearchController,
			'controllerAs': 'search',
			'bindings': {
				'service': '=',
			},
		})

		.component('utilMenu', {
			'templateUrl': ['utilService', function(utilService){
				return utilService.promise.then(function(service){
					return service.template('menu');
				});
			}],
			'controller': UtilMenuController,
			'controllerAs': 'menu',
			'bindings': {
				'service': '=',
			},
		})

		.component('utilMenuItem', {
			'templateUrl': ['utilService', function(utilService){
				return utilService.promise.then(function(service){
					return service.template('menu');
				});
			}],
			'controller': UtilMenuController,
			'controllerAs': 'menu',
			'bindings': {
				'service': '=',
			},
		})
	;

	UtilSearchController.$inject = ['$timeout'];
	function UtilSearchController(){
		var vm = this;
		var args = arguments;
		vm.$$di = {};
		angular.forEach(UtilSearchController.$inject, function(value, key){
			vm.$$di[value] = args[key];
		});
		vm.term = null;
	}
	angular.extend(UtilSearchController.prototype, {
		'$onInit': function(){
			this.restoreTerm();
		},
		'submit': function(){
			this.service.search(this.term);
		},
		'clear': function(){
			var vm = this;
			vm.term = null;
			vm.submit();
		},
		'restoreTerm': function(){
			var vm = this;
			vm.term = vm.service.search();
			vm.service.activated(false);
		},
		'isActive': function(){
			return this.service.activated();
		},
		'active': function(ev){
			var vm = this;
			vm.service.activated(true);

			vm.$$di.$timeout(function(){
				var textElem = angular.element(ev.target).closest('.util-cp-search-box').find('input[name="term"]');
				textElem.focus();
			});
		},
		'enabled': function(){
			return this.service.enabled();
		}
	});

	UtilMenuController.$inject = [];
	function UtilMenuController(){
		var vm = this;
		var args = arguments;
		vm.$$di = {};
		angular.forEach(UtilSearchController.$inject, function(value, key){
			vm.$$di[value] = args[key];
		});
	}
	angular.extend(UtilMenuController.prototype, {

	});
})(this, angular);
