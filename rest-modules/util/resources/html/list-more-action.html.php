<?php
	if(!defined("RESTCONFIGURATED")){
		header(((isset($_SERVER['SERVER_PROTOCOL']))? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0')." 404 Not Found");
		exit;
	}
?>
<md-menu>
	<md-icon md-menu-origin md-svg-icon="navigation:ic-more-vert" ng-click="$mdOpenMenu($event)" alt="more action"></md-icon>
	<md-menu-content width="4">
		<md-menu-item>
			<h4 layout="row" layout-align="start center" style="padding-right: 0px;">
				<span flex>More Action</span>
				<md-icon md-menu-align-target md-svg-icon="navigation:ic-more-vert" alt="more action"
					style="margin-right: 0px;"></md-icon>
			</h4>
		</md-menu-item>
		<md-menu-divider></md-menu-divider>
		<md-menu-item ng-repeat="action in $action.items">
			<md-button type="button" ng-click="action.execute($event, $action.data)">
				<span>{{ action.title }}</span>
			</md-button>
		</md-menu-item>
	</md-menu-content>
</md-menu>
