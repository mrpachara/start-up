<?php
	if(!defined("RESTCONFIGURATED")){
		header(((isset($_SERVER['SERVER_PROTOCOL']))? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0')." 404 Not Found");
		exit;
	}
?>
<article>
	<h1>This is List</h1>
	<md-button type="button" ng-click="$comp.view(7)">
		<span>View 7</span>
	</md-button>
	<pre>{{ $comp.self|json:true }}</pre>
</article>
