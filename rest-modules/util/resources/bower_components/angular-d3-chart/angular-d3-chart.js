(function(GLOBALOBJECT, angular){
	'use strict';

	function D3ChartController(){
		var vm = this;

		var args = arguments;
		vm.$$di = {};
		angular.forEach(D3ChartController.$inject, function(key, i){
			vm.$$di[key] = args[i];
		});
	}
	D3ChartController.$inject = [];

	angular.module('d3.chart', ['d3', 'd3.nv'])
		.factory('d3Chart', [
			'$parse',
			'd3', 'nv',
			function($parse, d3, nv){
				return {
					'util': {
						'compileOptions': function(options){
							options = options || {};
							angular.forEach(options, function(value, key){
								if(angular.isString(value)){
									var parser = $parse(value);

									options[key] = [function(d){
										return parser(d);
									}];
								}
							});

							return options;
						}
					},
				};
			}
		])

		.directive('d3Chart', [
			'd3', 'nv', '$q', '$log',
			function(d3, nv, $q, $log){
				return {
					'restrict': 'A',
					'scope': {
						'data': '=d3Chart',
						'type': '@d3ChartType',
						'options': '=d3ChartOptions',
					},
					'controllerAs': '$d3Chart',
					'bindToController': true,
					'controller': D3ChartController,
					'link': function(scope, elem, attrs, vm){
						var svg = d3.select(elem[0]).append('svg')
							.style('display', 'block')
							.style('width', '100%')
							.style('height', '100%')
							.style('flex', '1 1 auto')
							.attr('preserveAspectRatio', 'xMinYMin')
						;

						var $svg = angular.element(svg[0]);
						$q.when(vm.options)
							.then(function(options){
								nv.addGraph(function() {
									var chart = nv.models[vm.type + 'Chart']();

									angular.forEach(options, function(value, key){
										try{
											chart[key].apply(chart, value);
										} catch(excp){
											$log.error(vm.type, key, value, excp);
										}
									});

									svg.datum(vm.data)
										.call(chart)
									;

									nv.utils.windowResize(chart.update);
									scope.$watch('$d3Chart.data', function(){
										chart.update();
									}, true)

									return chart;
								});
							})
						;
					}
				};
			}
		])
	;
})(this, this.angular);
