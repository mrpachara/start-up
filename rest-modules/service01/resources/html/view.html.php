<?php
	if(!defined("RESTCONFIGURATED")){
		header(((isset($_SERVER['SERVER_PROTOCOL']))? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0')." 404 Not Found");
		exit;
	}
?>
<article>
	<h1>This is View</h1>
	<md-button type="button" ng-click="$comp.changeMode('Edit')">
		<span>Edit</span>
	</md-button>
</article>
