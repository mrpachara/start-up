(function(GLOBALOBJECT, angular){
	'use strict';

	angular.module('d3.nv', ['d3'])
		.factory('nv', [
			'd3',
			function(d3){
				return GLOBALOBJECT.nv;
			}
		])
	;
})(this, this.angular);
