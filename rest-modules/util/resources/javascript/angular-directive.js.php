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
		'ngComponentRouter', 'ngMaterial',
		'util', 'util.default',
	])
		.directive('utilId', [
			function(){
				var drtv;
				return drtv = {
					'restrict': 'A',
					'priority': 400,
					'link': function(scope, elem, attrs){
						attrs.$set('id', attrs.utilId);
					},
				};
			}
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

		.directive('utilLinksAction', [
			'$timeout',
			function($timeout){
				var local = {
					'handler': null,
				};
				var drtv;
				return drtv = {
					'restrict': 'E',
					'socpe': {},
					'controller': UtilLinksActionController,
					'controllerAs': '$action',
					'bindToController': {
						'ctrl': '<',
					},
				};
			}
		])

		.component('utilSearch', {
			'templateUrl': ['utilTemplate', function(utilTemplate){
				return utilTemplate.promise.then(function(template){
					return template('search-form');
				});
			}],
			'controller': UtilSearchController,
			'controllerAs': 'search',
			'bindings': {
				'service': '=',
			},
		})

		.component('utilMenu', {
			'require': {
				'menuCtrl': '?^^utilMenu',
			},
			'templateUrl': ['utilTemplate', function(utilTemplate){
				return utilTemplate.promise.then(function(template){
					return template('menu');
				});
			}],
			'controller': UtilMenuController,
			'controllerAs': 'menu',
			'bindings': {
				'id': '@',
				'service': '=',
				'data': '=',
			},
		})

		.component('utilMenuItem', {
			'require': {
				'menuCtrl': '^^utilMenu',
			},
			'templateUrl': ['utilTemplate', function(utilTemplate){
				return utilTemplate.promise.then(function(template){
					return template('menu-item');
				});
			}],
			'controller': UtilMenuController,
			'controllerAs': 'menuItem',
			'bindings': {
				'data': '=',
				'index': '=',
			},
		})

		.controller('UtilDialogController', UtilDialogController)

		.controller('UtilLogListController', UtilLogListController)
	;

	UtilLinksActionController.$inject = [];
	function UtilLinksActionController(){
		var vm = this;
		var args = arguments;
		vm.$$di = {};
		angular.forEach(UtilLinksActionController.$inject, function(value, key){
			vm.$$di[value] = args[key];
		});
	}
	angular.extend(UtilLinksActionController.prototype, {
		'execute': function(link){
			var ctrl = this.ctrl;
			if(angular.isArray(link.action)){
				return ctrl.$router.navigate(link.action);
			} else if(angular.isString(link.action)){
				return ctrl.changeMode(link.action);
			} else{
				return (((link.confirm) || (link.class && (link.class.split(/\s+/g).indexOf('warn') >= 0)))?
					ctrl.$$di.$mdDialog.show(ctrl.$$di.$mdDialog.confirm()
						.title((link.confirm)? link.confirm : 'Do you want to ' + link.title + '?')
						.textContent((link.message)? link.message : 'Your action cannot be cancel later')
						.ok('Yes')
						.cancel('Cancel')
					) : ctrl.$$di.$q.when()
				).then(function(){
					var currentPath = ctrl.$$di.$location.path();
					return ctrl.links.$load(link.alias).then(function(data){
						if((ctrl.$$di.$location.path() === currentPath) && data.status && (data.status == 'deleted') && (data.uri === ctrl.uri)) ctrl.back();
					});
				});
			}
		},
	});

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
				var textElem = angular.element(ev.target).closest('util-search').find('input[name="term"]');
				textElem.focus();
			});
		},
		'enabled': function(){
			return this.service.enabled();
		}
	});

	UtilMenuController.$inject = ['$rootRouter'];
	function UtilMenuController(){
		var vm = this;
		var args = arguments;
		vm.$$di = {};
		angular.forEach(UtilMenuController.$inject, function(value, key){
			vm.$$di[value] = args[key];
		});
		vm.$$local = {
			'depth': 0,
			'selected': null,
			'menuHeight': null,
			'element': null,
		};
	}
	angular.extend(UtilMenuController.prototype, {
		'$onInit': function(){
			var vm = this;
			if(vm.menuCtrl) vm.$$local.depth = vm.menuCtrl.depth() + 1;
		},
		'$postLink': function(){
			var vm = this;

			if(vm.id) vm.$$local.element = angular.element('#' + vm.id);
		},
		'item': function(){
			return (this.service)? this.service.prop('menu') : this.data;
		},
		'depth': function(){
			return this.$$local.depth;
		},
		'isExpand': function(){
			var vm = this;
			var data = vm.item();
			return !!((vm.item() && vm.item().items) && (!vm.menuCtrl || (data.action !== 'toggle') || (vm.menuCtrl.selected() === vm.index)));
		},
		'hasSubmenu': function(){
			var item = this.item();
			return !!(item && item.items);
		},
		'selected': function(value){
			var vm = this;
			if(arguments.length === 0){
				return vm.$$local.selected;
			} else{
				vm.$$local.selected = value;
			}
		},
		'action': function(ev){
			var vm = this;

			var data = vm.item();
			if(data.action === 'toggle'){
				if(!vm.menuCtrl) return;
				if(vm.menuCtrl.selected() === vm.index){
					vm.menuCtrl.selected(null);
				} else{
					vm.menuCtrl.selected(vm.index);
				}
			} else if(angular.isArray(data.action)){
				vm.$$di.$rootRouter.navigate(data.action);
				ev.originalEvent.commandComplete = true;
			} else if(angular.isFunction(data.action)){
				data.action(ev);
			}
		},
		'menuHeight': function(){
			var vm = this;

			//var $elem = angular.element('#' + vm.id);
			var $elem = vm.$$local.element;
			if(($elem) && ($elem.length > 0) && ($elem.css('display') !== 'none')){
				vm.$$local.menuHeight = $elem.outerHeight();
			}

			if((vm.$$local.menuHeight === null) && (vm.item()) && angular.isArray(vm.item().items)){
				vm.$$local.menuHeight = vm.item().items.length * 36;
			}

			return vm.$$local.menuHeight;
		},
	});

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
