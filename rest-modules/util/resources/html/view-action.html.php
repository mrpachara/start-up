<?php
	if(!defined("RESTCONFIGURATED")){
		header(((isset($_SERVER['SERVER_PROTOCOL']))? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0')." 404 Not Found");
		exit;
	}
?>
<md-button type="button" ng-repeat="action in $action.items"
	ng-class="action.classes"
	ng-click="action.execute($event)">
	<md-icon md-svg-icon="{{ action.icon }}"></md-icon>
	<span>{{ action.title }}</span>
</md-button>
