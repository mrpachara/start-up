<!DOCTYPE html>
<html lang="en" xml:lang="en" xmlns="http://www.w3.org/1999/xhtml" ng-app="app" strict-di>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
		<meta charset="UTF-8" />
		<meta http-equiv="Content-Language" content="en_US, th_TH" />
		<title>Show Material Design Icon</title>

		<script type="application/javascript" src="rest/util/bower_components/less/dist/less.js" data-env="development" data-async="true"></script>
		<script type="application/javascript" src="rest/util/bower_components/jquery/dist/jquery.js"></script>

		<script type="application/javascript" src="rest/util/bower_components/angular/angular.js" data-module-id="ng"></script>

		<script type="application/javascript">
(function(GLOBALOBJECT, angular){
	//var nameRe = /^.*-(.+)\.svg$/g;
	angular.module('app', ['ng'])
		.run([
			'$http', '$q'
			function($http, $q){
				$http.get('rest/util/configuration').then(function(response){
					var data = response.data;
					var promise = {};
					if(angular.isArray(data.links)){
						angular.forEach(data.links, function(link){
							if(link.rel === 'icon/svg'){
								var setName = link['set-name'];
								promise[setName] = $http.get(link.href);
							}
						});
					}
				});
			}
		])
	;
})(this, angular);
		</script>
	</head>
	<body>
	</body>
</html>
