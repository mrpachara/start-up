<?php
	if(!defined("RESTCONFIGURATED")){
		header(((isset($_SERVER['SERVER_PROTOCOL']))? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0')." 404 Not Found");
		exit;
	}
?>
<form ng-show="search.enabled()"
	ng-submit="search.submit()" layout="row" layout-align="end center" style="width: 100%;">
	<md-button type="button" class="md-icon-button" aria-label="show search" ng-click="search.active($event)">
		<md-icon md-svg-icon="action:ic-search" alt="search"></md-icon>
	</md-button>
	<div class="util-cp-search-box-search" layout="row" flex
		ng-show="search.isActive()">
		<input type="search" name="term" aria-label="search input"
			ng-model="search.term" ng-blur="search.restoreTerm()" flex />
		<md-button type="button" class="md-icon-button" ng-click="search.clear()" aria-label="clear search">
			<md-icon md-svg-icon="content:ic-clear" alt="clear"></md-icon>
		</md-button>
	</div>
</form>
