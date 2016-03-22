(function(GLOBALOBJECT, angular){
	'use strict';

	angular.module('d3', [])
		.factory('d3', [
			function(){
				return GLOBALOBJECT.d3;
			}
		])
	;
})(this, this.angular);
