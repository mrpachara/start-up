<?php
	if(!defined("RESTCONFIGURATED")){
		header(((isset($_SERVER['SERVER_PROTOCOL']))? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0')." 404 Not Found");
		exit;
	}
?>
<md-button type="button" ng-repeat="link in $action.ctrl.links.$links('action')"
	class="{{ (link.class)? 'md-' + link.class : '' }}"
	ng-click="$action.execute(link)">
	<md-icon md-svg-icon="{{ link.icon }}"></md-icon>
	<span>{{ link.title }}</span>
</md-button>
