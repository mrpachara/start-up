<!DOCTYPE html>
<html lang="en" xml:lang="en" xmlns="http://www.w3.org/1999/xhtml" ng-app="app" strict-di>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
		<meta charset="UTF-8" />
		<meta http-equiv="Content-Language" content="en_US, th_TH" />
		<title>Show Material Design Icon</title>

		<link rel="stylesheet/less" type="text/css" href="show-icon.less" />

		<script type="application/javascript" src="rest/util/bower_components/less/dist/less.js" data-env="development" data-async="true"></script>
		<script type="application/javascript" src="rest/util/bower_components/jquery/dist/jquery.js"></script>

		<script type="application/javascript" src="rest/util/bower_components/angular/angular.js" data-module-id="ng"></script>

		<script type="application/javascript">
(function(GLOBALOBJECT, angular){
	angular.module('app', ['ng'])
		.config([
			'loadIconServiceProvider',
			function(loadIconServiceProvider){
				loadIconServiceProvider.setConfigUrl('rest/util/configuration');
			}
		])

		.run([
			'$rootScope',
			'loadIconService',
			function($rootScope, loadIconService){
				$rootScope.loadIconService = loadIconService;
			}
		])

		.provider('loadIconService', [
			function(){
				var providerLocal = {
					'configUrl': null,
				};
				return angular.extend(this, {
					'setConfigUrl': function(url){
						providerLocal.configUrl = url;
					},
					'$get': [
						'$http',
						function($http){
							var local = {
								'iconSet': [],
							};

							var svgParser = new DOMParser();

							$http.get(providerLocal.configUrl).then(function(response){
								angular.forEach(response.data.links, function(link){
									if(link.rel === 'icon/svg'){
										var name = link.href.match(/([^-]*)\.svg$/)[1];

										local.iconSet.push({
											'name': name,
											'promise': $http.get(link.href).then(function(response){
												return svgParser.parseFromString(response.data, 'image/svg+xml');
											}),
										});
									}
								});
							});

							var service;
							return service = {
								'list': function(){
									return local.iconSet;
								}
							};
						}
					]
				});
			}
		])

		.component('iconSet', {
			'controller': iconSetController,
			'controllerAs': '$iconSet',
			'template':
				'<section>' +
					'<h1 ng-bind="$iconSet.item.name"></h1>' +
					'<article>' +
						'<icon-svg ng-repeat="iconId in $iconSet.listIconIds()" icon-id="iconId" index="$index"></icon-svg>' +
					'</article>' +
				'</section>',
			'bindings': {
				'item': '<',
			},
		})

		.component('iconSvg', {
			'require': {
				'iconSetCtrl': '^^iconSet',
			},
			'controller': IconSvgController,
			'controllerAs': '$iconSvg',
			'template':
				'<div>' +
					'<svg icon-target version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24" width="48" height="48"></svg>' +
					'<div ng-bind="$iconSvg.iconId"></div>' +
				'</div>',
			'bindings': {
				'iconId': '<',
				'index': '<',
			},
		})

		.directive('iconTarget', [
			function(){
				return {
					'require': ['^iconSvg'],
					'link': function(scope, elem, attrs, ctrls){
						var iconSvgCtrl = ctrls[0];

						elem.html(iconSvgCtrl.getSvg().innerHTML);
					},
				}
			}
		])
	;

	iconSetController.$inject = [];
	function iconSetController(){
		var vm = this;

		vm.$$local = {
			'iconNames': [],
			'items': null,
		};
	}
	angular.extend(iconSetController.prototype, {
		'$onInit': function(){
			var vm = this;
			vm.item.promise.then(function(doc){
				vm.$$local.items = angular.element('*:root>svg', doc);

				vm.$$local.items.each(function(index, elem){
					vm.$$local.iconNames.push(vm.item.name + ':' + elem.id.replace(/_/g, '-').slice(0, -5));
				});
			});
		},
		'listIconIds': function(){
			return this.$$local.iconNames;
		},
		'get': function(index){
			return this.$$local.items[index];
		},
	});

	IconSvgController.$inject = [];
	function IconSvgController(){

	}
	angular.extend(IconSvgController.prototype, {
		'getSvg': function(){
			var vm = this;

			return vm.iconSetCtrl.get(vm.index);
		}
	});
})(this, angular);
		</script>
	</head>
	<body>
		<icon-set ng-repeat="item in loadIconService.list()" item="item"></icon-set>
	</body>
</html>
